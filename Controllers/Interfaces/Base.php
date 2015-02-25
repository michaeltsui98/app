<?php

class Controllers_Interfaces_Base extends Cola_Controller 
{
     public function __construct(){
         $this->init();
     }
     /**
      * 初始化接口参数，判断数据是不是有效的请求
      * 通过Access_token 到oauth 平台来判断
      * 0代表令牌无效，1代表有效，2代表过期
      */
     public function init(){
         
         $status= false;
         $app_key = $this->getVar('app_key');
         if(!$app_key){
             $this->abort(array('status'=>$status,'msg'=>'access_token 为空'));
         }
         $dd = new Models_DDClient();
         
         $url = DD_API_URL."auth/checkappkey";
         
         $res = (int)Cola_Com_Http::post($url, array('app_key'=>$app_key));
         
         if($res==0){
             $this->abort(array('status'=>$status,'msg'=>'验证 app_key 无效'));
         }
         if($res==2){
             $this->abort(array('status'=>$status,'msg'=>'验证 app_key 过期'));
         }
         if($res==1){
             return true;
         }
     } 
     
     /**
      * ajax json 统一输出
      * @param string $type error,success
      * @param string $message  提示信息
      * @param array $data  数据
      * @param $error_code 错误代码
      */
     public function echoJson($type,$message,array $data = array(),$error_code=null){
         $array = array('type' => $type, 'message' => $message ,'data' => $data,'error_code'=>$error_code,'time'=>time());
         $this->abort($array);
     }
     
}

?>