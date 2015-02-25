<?php

/**
 * 资源操作日志
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Log extends Cola_Model
{

    protected  $_table = 'resource_log';
    protected  $_pk = 'id';

    public  static  $op = array('add','update','delete','audit');


    /**
     * 添加日志
     * @param $op
     * @param $doc_id
     * @param $user_id
     * @param $user_name
     */
    public  function  add($op,$doc_id,$user_id,$user_name,$info){
        $data = array();
        $data['doc_id'] = $doc_id;
        $data['user_id'] = $user_id;
        $data['user_name'] = $user_name;
        $data['op'] = $op;
        $data['info'] = $info;
        $data['created_at'] = $_SERVER['REQUEST_TIME'];
        $this->insert($data);
    }
    
     
     
}
 