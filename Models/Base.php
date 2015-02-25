<?php

/**
 * 文库基础节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Base extends Cola_Model
{
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
     * 返回信息输出数组
     * @param string $type error,success
     * @param string $message  提示信息
     * @param array $data  数据
     * @return multitype:unknown string number
     */
    public function msgArr($type,$message,array $data = array(),$error_code=null){
        $array = array('type' => $type, 'message' => $message ,'data' => $data,'errcode'=>$error_code,'time'=>time());
        return $array;
    }
    
    /**
     * 文档类型
     */
    function get_type_node($id=null){
        $ls = Cola::getConfig('_resourceType');;
        if($id){
            return $ls[$id];
        }else{
            return $ls;
        }
    }
     
     
}
 