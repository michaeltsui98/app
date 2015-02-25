<?php
/**
 * 手机接口基类
 * @author michaeltsui98@qq.com
 */
class Models_Interface_Base extends Cola_Model {
     
    
   
     /**
      * 过滤数组中的Null为''空值
      * @return array
      */
     public function filterNull(array $data){
         if(!empty($data)){
            return  array_map(array($this,'opNull'), $data);
         }else{
         	return $data;
         }
     }
     public function opNull($val){
             if(is_null($val) or $val==''){
                 return '';
             }elseif(is_array($val)){
                 return $this->filterNull($val);
             }else{
                 return $val;
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
         $array = array('type' => $type, 'message' => $message ,'data' => $data,'errcode'=>$error_code,'time'=>time());
         $this->abort($array);
     }
     /**
      * 返回数组
      * @param string $type error,success
      * @param string $message  提示信息
      * @param array $data  数据
      * @return multitype:unknown string number
      */
     public function rtnArr($type,$message,array $data = array(),$error_code=null){
         $array = array('type' => $type, 'message' => $message ,'data' => $data,'errcode'=>$error_code,'time'=>time());
         return $array;
     }
 
}