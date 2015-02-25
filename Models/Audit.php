<?php

/**
 * 资源审核
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Audit extends Cola_Model
{

    protected  $_table = 'resource_audit';
    protected  $_pk = 'id';

    /**
     * 审核状态 0=>待审核1=>通过审核 2=>审核未通过
     * @var array
     */
    public  static $status = array(0,1,2);

    public  function add($doc_id,$user_id,$user_name,$status,$msg){
        $data = array();
        $data['doc_id']  = $doc_id;
        $data['user_id'] = $user_id;
        $data['user_name'] = $user_name;
        $data['status'] = $status;
        $data['msg'] = $msg;
        $data['created_at'] = $_SERVER['REQUEST_TIME'];
        $this->insert($data);
    }
     
     
}
 