<?php
/**
 * oauth专用 client
 * @author    michael
 * @datetime  2013-11-05
 * @modify    2014-07-08  
 * @copyright Copyright (c) 2012 Wuhan Bo Sheng Education Information Co., Ltd.
 * @version 0.2
 */
class Models_DDClient
{

    private $appId = '';

    private $appKey = '';

    private $appSecret = '';

    private $callBackUrl = '';

    private $accessToken = '';

    private $refreshToken = '';

    public $http_code;
    
    /**
     * @var string tokens 的变量名，有多个子应用时，这里要改
     */
    const TOKEN_NAME = 'resource_tokens'; 

    /**
     * Contains the last API call.
     *
     * @ignore
     *
     *
     */
    public $url;

    /**
     * Set up the API root URL.
     *
     * @ignore
     *
     *
     */
    public $host = DD_API_URL;

    /**
     * Set timeout default.
     *
     * @ignore
     *
     *
     */
    public $timeout = 30;

    /**
     * Set connect timeout.
     *
     * @ignore
     *
     *
     */
    public $connecttimeout = 30;

    /**
     * Verify SSL Cert.
     *
     * @ignore
     *
     *
     */
    public $ssl_verifypeer = false;

    /**
     * Respons format.
     *
     * @ignore
     *
     *
     */
    public $format = 'json';

    /**
     * Decode returned json data.
     *
     * @ignore
     *
     *
     */
    public $decode_json = true;

    /**
     * Contains the last HTTP headers returned.
     *
     * @ignore
     *
     *
     */
    public $http_info;

    /**
     * Set the useragnet.
     *
     * @ignore
     *
     *
     */
    public $useragent = 'DDApi';

    /**
     * print the debug info
     *
     * @ignore
     *
     *
     */
    public $debug = false;

    /**
     * boundary of multipart
     *
     * @ignore
     *
     *
     */
    public static $boundary = '';

 
    /**
     * 构造函数
     */
    function __construct($access_token = null, $refresh_token = null)
    {
        $this->appId = DD_APPID;
        $this->appKey = DD_AKEY;
        $this->appSecret = DD_SKEY;
        $this->callBackUrl = DD_CALLBACK_URL;
        $this->accessToken = $access_token;
        $this->refreshToken = $refresh_token;
    }

    /**
     * 获取认证连接
     * @ignore
     *
     */
    private function _grantAuthorizeURL()
    {
        return DD_API_URL . 'auth/authorize/';
    }
    /**
     * 请求accessToken的地址
     * @ignore
     *
     */
    private function _grantAccessTokenURL()
    {
        return DD_API_URL . 'auth/accesstoken/';
    }
    /**
     * 处理服务器传过来的POST
     * @param $signedRequest
     * @return -1,签名算法不对应. -2,客户端签名与从服务器传过来的不一致.没有错误的话返回数组
     */
    public function parseSignedRequest($signedRequest)
    {
        list($sig, $requestUrl) = explode('.', $signedRequest, 2);
        $infoArr = base64_decode($requestUrl);
        $infoArr = json_decode($infoArr);
        $clientSig = base64_encode(hash_hmac('sha256', $infoArr->user_id, DD_SKEY, true));
        if ($infoArr->algorithm != 'HMAC-SHA256') {
            return '-1';
        } else
            if ($clientSig != $sig) {
                return '-2';
            } else {
                return $this->json_to_array($infoArr);
            }
    }
    /**
     * 
     * @return Models_DDClient
     */
    public static function getInstance(){
    	return new static();
    }
 
    /**
     * 使用refresh_token换取新的access_token
     *
     * @param
     *            $accessToken
     * @param
     *            $refreshToken
     * @return bool
     */
    public function _grantNewAccessToken($accessToken, $refreshToken)
    {
        if (!$accessToken and !$refreshToken) {
            return false;
        }
        $url = HTTP_DODOEDU . '/DDApi/auth/newaccesstoken';

        $params = array();
        $params['access_token'] = $accessToken;
        $params['refresh_token'] = $refreshToken;

        $response = json_decode(Cola_Com_Http::post($url, $params), 1);
        //var_dump($url);
        //var_dump($response); 

        if (isset($response['errcode']) and $response['errcode']) {
            throw new Exception('error:/auth/newaccesstoken/' . var_export($params, 1) .
                var_export((array )$response, 1));
            return false;
        } else {
            if (empty($response)) {
                throw new Exception('error:_grantNewAccessToken 为空');
                return false;
            }
            if ($response['access_token']) {
                $_SESSION[self::TOKEN_NAME]['access_token'] = $response['access_token'];
                $_SESSION[self::TOKEN_NAME]['refresh_token'] = $response['refresh_token'];
            } elseif ($response['accessToken']) {
                $_SESSION[self::TOKEN_NAME]['access_token'] = $response['accessToken'];
                $_SESSION[self::TOKEN_NAME]['refresh_token'] = $response['refreshToken'];
            }
        }
        return true;
    }

    /**
     * authorize接口
     */
    public function getAuthorizeURL($inUrl, $inResponseType = 'code', $inState = null,
        $inDisplay = null)
    {
        $params = array();
        $params['client_key'] = $this->appKey;
        $params['redirect_uri'] = $inUrl;
        $params['response_type'] = $inResponseType;
        $params['state'] = $inState;
        $params['display'] = $inDisplay;
        return $this->_grantAuthorizeURL() . "?" . http_build_query($params);
    }

    /**
     * access_token接口
     *
     * 对应API：{@link /DDApi/accessToken}
     *
     * @param string $type
     *            请求的类型,可以为:code, password, token
     * @param array $keys
     *            其他参数：(目前都固定为CODE)
     *            - 当$type为code时： array('code'=>..., 'redirect_uri'=>...)
     *            - 当$type为password时： array('username'=>..., 'password'=>...)
     *            - 当$type为token时： array('refresh_token'=>...)
     * @return array
     */
    public function getAccessToken($type = 'code', $keys)
    {
        $params = array();
        $params['client_key'] = $this->appKey;
        $params['client_secret'] = $this->appSecret;
        if ($type === 'code') {
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $keys['code'];
            $params['redirect_uri'] = $keys['redirectUri'];
        } else {
            throw new Exception("wrong auth type");
        }
        $response = $this->oAuthRequest($this->_grantAccessTokenURL(), 'POST', 
                $params);
        $token = json_decode($response, true);
        if (isset($token['errcode']) and $token['errcode']===0) {
        	$this->accessToken = $token['access_token'];
            $this->refreshToken = $token['refresh_token'];
        } else {
            throw new Exception("get access token failed." . $token['msg']);
        }
        $ss['access_token'] = $token['access_token'];
        $ss['refresh_token'] = $token['refresh_token'];
        return $ss;
    }

    /**
     * Format and sign an OAuth / API request
     * @return string
     * @ignore
     */
    public function oAuthRequest($url, $method, $parameters, $multi = false)
    {
        switch ($method) {

            case 'POST':
                $headers = array();
                // $parameters['access_token'] = $this->accessToken;
                if (!$multi && (is_array($parameters) || is_object($parameters))) {
                    $body = http_build_query($parameters);
                } else {
                    $body = self::build_http_query_multi($parameters);
                    $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
                }
                return $this->http($url, $method, $body, $headers);
                break;
            default:
                echo "目前只支持post方法";
        }
    }
    /**
     * @ignore
     */
    public static function build_http_query_multi($params)
    {
        if (!$params)
            return '';

        uksort($params, 'strcmp');

        $pairs = array();

        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--' . $boundary;
        $endMPboundary = $MPboundary . '--';
        $multipartbody = '';

        foreach ($params as $parameter => $value) {
            if (in_array($parameter, self::$params_file) && $value{0} == '@') {
                $url = ltrim($value, '@');
                if (!empty($url)) {
                    $content = file_get_contents($url);
                    $array = explode('?', basename($url));
                    $filename = $array[0];

                    $filename = $_FILES[$parameter]['name'];
                    $multipartbody .= $MPboundary . "\r\n";
                    $mime = self::get_image_mime($url);
                    $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter .
                        '"; filename="' . $filename . '"' . "\r\n";
                    $multipartbody .= "Content-Type: " . $mime . "\r\n\r\n";
                    $multipartbody .= $content . "\r\n";
                }
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                $multipartbody .= $value . "\r\n";
            }
        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
   /**
    * Make an HTTP request
    * @param string $url
    * @param string $method POST
    * @param string $postfields
    * @param unknown $headers
    * @return mixed
    */
    public function http($url, $method='POST', $postfields = null, $headers = array())
    {
        $this->http_info = array();
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_ENCODING, "");
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ci, CURLOPT_HEADER, false);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
        }

        if (isset($this->accessToken) && $this->accessToken) {
            $headers[] = "Authorization: OAuth2 " . $this->accessToken;
        }

        $headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($ci);
        $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
        $this->url = $url;

        if ($this->debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);

            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));

            echo '=====$response=====' . "\r\n";
            print_r($response);
        }

        curl_close($ci);
        return $response;
    }
    /**
     * Get the header info to store.
     * @return int
     * @ignore
     */
    public function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }

    /**
     * 将JSON对象转化成ARRAY
     *
     * @param
     *            $obj
     * @return array
     */
    public function json_to_array($obj)
    {
        $arr = array();
        foreach ((array )$obj as $k => $w) {
            if (is_object($w))
                $arr[$k] = $this->json_to_array($w); // 判断类型是不是object
            else
                $arr[$k] = $w;
        }
        return $arr;
    }

    /**
     * 刷新token
     */
    public function updateToken()
    {
        if(isset($_SESSION[self::TOKEN_NAME]['access_token'])){
            $this->_grantNewAccessToken($_SESSION[self::TOKEN_NAME]['access_token'],
                    $_SESSION[self::TOKEN_NAME]['refresh_token']);
             
        }else{
            $user_id = $_SESSION['user']['user_id'];
            $url = HTTP_DODOEDU.'/DDApi/auth/siteLoginedAuthorize';
            $data = array('user_id'=>$user_id,'client_key'=>DD_AKEY,'sid'=>session_id());
            //var_dump($data);
            $res = json_decode(Cola_Com_Http::post($url,$data),1);
            $keys = array();
            $keys['code'] = $res['data']['code'];
            $keys['redirectUri'] = DD_CALLBACK_URL;
            $tokens = $this->getAccessToken('code', $keys);
            $_SESSION[self::TOKEN_NAME] = $tokens;
        }
    }
  
    /**
     * 网站从主站登录后如果access_token 这个方法可以取到access_token
     * @return mixed
     */
    public function getSiteLogined()
    {

        $url = HTTP_DODOEDU . '/DDApi/auth/siteloginedauthorize';
        $data['client_key'] = $this->appKey;
        $data['user_id'] = $_SESSION['user']['user_id'];
        $data['sid'] = session_id();
        //var_dump($data);
        //$res = Cola_Com_Http::post($url, $data);

        $query = json_decode(Cola_Com_Http::post($url, $data), 1);

        $code = $query['data']['code'];

        $keys = array('code' => $code, 'redirectUri' => DD_CALLBACK_URL);
        $_SESSION[self::TOKEN_NAME] = $this->getAccessToken('code', $keys);
        return $query['code'];
    }
    /**
     * 主要是未登录可以取数据
     * 基于client 模式取accestoken
     */
    public function getToken()
    {
          
          $get_public_url =  DD_API_URL . 'auth/grantaccesstokenbyclientkey';
          if(!isset($_SESSION[self::TOKEN_NAME]['access_token'])){
        	$tokenInfo = Cola_Com_Http::post($get_public_url, array('app_key' => DD_AKEY));
            $token = (array )json_decode($tokenInfo, 1);
        	if(!is_array($token)  or $token['errcode']>0){
        	  throw new Exception($token['msg'].var_export($tokenInfo,1));	
        	}
            $_SESSION[self::TOKEN_NAME]['access_token'] = $token['access_token'];
            $_SESSION[self::TOKEN_NAME]['refresh_token'] = $token['refresh_token'];
            
         }else{
         	$token = $_SESSION[self::TOKEN_NAME];
         }
        return $token;
        
    }
    /**
     * 获取有用户信息的token
     */
    public  function setUserIdToAccessToken($user_id){
        //http://dev.dodoedu.com/DDApi/auth/setuseridtoaccesstoken?access_token=fb7b8e0111ed94d760f889bce69785cf&user_id=s35951247001862320095
        $url  = DD_API_URL . 'auth/setuseridtoaccesstoken';
         
        if($user_id and $_SESSION['user']['with_token']===0){
            $data = array('user_id'=>$user_id,'access_token'=>$_SESSION[self::TOKEN_NAME]['access_token']);
            $info = Cola_Com_Http::post($url, $data);
        	$_SESSION['user']['with_token'] = 1;
        }
    }
    
    /**
     * 
     * @param string $api_name 'disk/getfilelist'
     * @param array $data  参数
     * @throws Exception
     * @return mixed
     */
    public function getDataByApi($api_name, array $data,$is_debug=false)
    {
        if (!$api_name) {
            throw new Exception("error:$api_name.不能为空");
        }
        if(isset($_SESSION[self::TOKEN_NAME]['access_token'])){
        	$token = $_SESSION[self::TOKEN_NAME];
        }else{
            $token = $this->getToken();
        }
          
        if(isset($_SESSION['user']) and  $_SESSION['user']['user_id']  and isset($_SESSION['user']['with_token']) ){
            $this->setUserIdToAccessToken($_SESSION['user']['user_id']);
        }
        
        $url = HTTP_DODOEDU . '/DDApi/' . $api_name;
        $param = $data + array('access_token' => $token['access_token'], 'refresh_token' => $token['refresh_token']);
       
        $res = Cola_Com_Http::post($url, $param);
        //$res = $this->http($url, 'POST',$param);
        if($is_debug){
            echo '<pre>';
            var_dump(func_get_args());
            var_dump($url,$param);
            var_dump($res);
        }
        $query = (array )json_decode($res, 1);
        if(isset($query['errcode']) and $query['errcode']==7){
        	$this->_grantNewAccessToken($token['access_token'], $token['refresh_token']);
        	return $this->getDataByApi($api_name, $data,$is_debug);
        }
        if ($is_debug and isset($query['errcode']) and $query['errcode']) {
                throw new Exception("error:$api_name." . var_export($data, 1) . var_export($query,
                1) . $res);
            
        }elseif( isset($query['errcode']) and $query['errcode']   ){
            return $query;
        }
        return $query;

    }
}
