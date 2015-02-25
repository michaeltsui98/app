<?php
class Models_Sdk_Polyv extends Cola_Model {
    private $_readtoken;
    private $_writetoken;
    private $_privateKey;
    private $_sign;
    public static $error = array(
                1=>'找不到writetoken关联的user',
                2=>'文件为空或者writetoken为空',
                3=>'提交的json名字JSONRPC为null',
                4=>'提交文件格式不正确',
                5=>'readtoken为空',
                6=>'分页输入出错',
                7=>'vid不能为空',
                8=>'找不到方法名',
                10=>'userid不能为空',
                11=>'上传目录为空',
                12=>'远程URL文件不能访问',
                13=>'远程视频文件自定义名称不能为空',
                15=>'其他异常',
                16=>'空间已满',
                17=>'用户无是用接口权限',
                18=>'标题重复',
                19=>'标题为空',
                20=>'播放列表不存在',
                21=>'参数错误',
                22=>'参数签名错误'
        );
    public static  $status = array(
            10=>'等待编码',
            20=>'正在编码',
            50=>'等待审核',
            51=>'审核不通过',
            60=>'已经发布',
            61=>'已经发布',
    );
    function __construct() {
    
        $this->_readtoken 	= POLY_READTOKEN;
        $this->_writetoken 	= POLY_WRITETOKEN;
        $this->_privatekey = POLY_PRIVATEKEY;
        $this->_sign = true;//提交参数是否需要签名
    }
     
    
    private function _processXmlResponse($url, $xml = ''){
    
        if (extension_loaded('curl')) {
            $ch = curl_init() or die ( curl_error() );
            $timeout = 10;
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            if(!empty($xml)){
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/xml',
                'Content-length: ' . strlen($xml)
                ));
            }
            $data = curl_exec( $ch );
            curl_close( $ch );
            if($data)
                return (new SimpleXMLElement($data));
            else
                return false;
        }
        if(!empty($xml))
            throw new Exception('Set xml, but curl does not installed.');
    
        return (simplexml_load_file($url));
    }
    private function makeVideo($video){
        //var_dump($video->images->image); 
        return array(
                'vid' => (string)$video->vid,
                'cataid' => (string)$video->cataid,
                'hlsindex' => (string)$video->hlsIndex,
                'swf_link' => (string)$video->swf_link,
                'ptime' => (string)$video->ptime,
                'times' => (string)$video->times,
                'status' => (string)$video->status,
                'df' => (string)$video->df,
                'first_image' => (string)$video->first_image,
                'default_video' => (string)$video->default_video,
                'title' => (string)$video->title,
                'context' => (string)$video->context,
                'duration' => (string)$video->duration,
                'flv1' => (string)$video->flv1,
                'flv2' => (string)$video->flv2,
                'flv3' => (string)$video->flv3,
                'sourcefile' => (string)$video->sourcefile,
                'mp4' => (string)$video->mp4,
                'mp4_1' => (string)$video->mp4_1,
                'mp4_2' => (string)$video->mp4_2,
                'mp4_3' => (string)$video->mp4_3,
                //'hls_1' => (string)$video->hls_1,
               // 'hls_2' => (string)$video->hls_2,
                //'hls_3' => (string)$video->hls_3,
                'seed' => (string)$video->seed,
                'images' => (string) implode(';',(array)$video->images->image),
                'images_b' => (string)implode(';',(array)$video->images_b->image),
                'tag' => (string)$video->tag,
                'playerwidth' => (int)$video->playerwidth,
                'playerheight' => (int)$video->playerheight,
                'original_definition' => (string)$video->original_definition,
                'hls1' => (string)$video->hls1
        );
    }
    	
    public function getById($vid) {
        if($this->_sign){
            $hash = sha1('readtoken='.$this->_readtoken.'&vid='.$vid.$this->_privatekey);
        }
        $xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getById&vid='.$vid.'&format=xml&sign='.$hash, $xml);
        if($xml) {
            //var_dump($xml);
            if($xml->error=='0'){
               // var_dump($xml->data->video);die;
                return $this->makeVideo($xml->data->video);
            }else{
                return array(
                        'returncode' => $xml->error
                );
            }
        }
        else {
            return null;
        }
    
    }
    public function getById2($vid){
        
        $url = "http://v.polyv.net/uc/services/rest?method=getById&readtoken={$this->_readtoken}&vid={$vid}";
        $json =  Cola_Com_Http::get($url);
        $data = json_decode($json,1);
        if($data['error']==0){
            return $data['data'];
        }else{
            return $data['error'];
        }
    }
    
    
    public function uploadfile($title,$desc,$tag,$cataid,$filename) {
        $JSONRPC = '{"title":"'.$title.'","tag":"'.$tag.'","desc":"'.$desc.'"}';
    
        if($this->_sign){
            $hash = sha1('cataid='.$cataid.'&JSONRPC='.$JSONRPC.'&writetoken='.$this->_writetoken.$this->_privatekey);
        }
        //echo 'cataid='.$cataid.'&JSONRPC='.$JSONRPC.'&writetoken='.$this->_writetoken.$this->_privatekey.' hash:'.$hash;
         
            $ch = curl_init() or die ( curl_error() );
            $timeout = 3600;
            	
            $post = array(
                    'JSONRPC' => $JSONRPC,
                    'cataid'=>$cataid,
                    'writetoken'=>$this->_writetoken,
                    'sign'=>$hash,
                    'format'=>'xml',
                    'Filedata'=>'@'.$filename
            );

            //var_dump($post);
            curl_setopt( $ch, CURLOPT_URL, "http://v.polyv.net/uc/services/rest?method=uploadfile" );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            	
            	
            $data = curl_exec( $ch );
            if($data === false)
            {
                echo 'Curl error: ' . curl_error($ch);
                
                die;
            }
           
            curl_close( $ch );
           
            if($data){
                $xml = (new SimpleXMLElement($data));
                      //  var_dump($xml->data->video);die;
                if($xml) {
                    if($xml->error=='0')
                        return $this->makeVideo($xml->data->video);
                    else
                        return array(
                                'returncode' => $xml->error
                        );
                }
                else {
                    return null;
                }
    
            }
            else{
                return false;
            }
       
    
    }
    
    public function getNewList($pageNum,$numPerPage,$catatree) {
        if($this->_sign){
            $hash = sha1('catatree='.$catatree.'&numPerPage='.$numPerPage.'&pageNum='.$pageNum.'&readtoken='.$this->_readtoken.$this->_privatekey);
        }
        //echo 'http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getNewList&pageNum='.$pageNum.'&format=xml&numPerPage='.$numPerPage.'&catatree='.$catatree.'&sign='.$hash;
        $xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getNewList&pageNum='.$pageNum.'&format=xml&numPerPage='.$numPerPage.'&catatree='.$catatree.'&sign='.$hash, $xml);
        if($xml) {
            if($xml->error=='0') {
                foreach ($xml->data->video as $video){
                    	
                    $videodata = $this->makeVideo($video);
                    $result[] =$videodata;
                    
                }
                return $result;
            }else{
                return array(
                        'returncode' => $xml->error
                );
            }
        }
        else {
            return null;
        }
    
    }
    
}