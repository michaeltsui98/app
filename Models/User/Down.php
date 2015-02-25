<?php

class Models_User_Down extends Cola_Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'doc_down_log';
    
    /**
     * Primary key
     *
     * @var string
     */
    protected $_pk = 'id';
    


    /**
     * 获取某用户下载的文档
     * @param array $Uid
     * @return MyDocData
     */
    public function getMyDown($Uid, $limit, $url, $ajax = 0){
        $page = v('page');
        $order = v('order');
        $type = v('type');
        if($type==""){
            $type = "desc";
        }
        switch ($order) {
            case 'p':
                $order_type = "Doc.doc_remark_val";
                break;
            case 'u':
                $order_type = "Down.uid";
                break;
            case 't':
                $order_type = "on_time";
                break;
            case 'j':
                $order_type = "cost";
                break;
            default:
                $order_type = "on_time";
                break;
        }
        $sql = "SELECT Down.*, 
                Doc.doc_remark_val/Doc.doc_remarks as remark, Doc.doc_title, Doc.doc_status
                , Doc.doc_ext_name , Doc.user_name, Doc.uid AS user_id     
                FROM ".$this->_table." AS Down 
                LEFT JOIN doc AS Doc  
                ON Down.doc_id =Doc.doc_id 
                WHERE Down.uid = '$Uid'  
                ORDER BY $order_type $type";
        $MyDocData = $this->sql_pager($sql, $page, $limit, $url, $ajax);
        return $MyDocData;
    }

    /**
     * 删除我下载的
     * @param $user_id
     * @param $doc_id
     * @return array
     */
    public function del($user_id,$doc_id){
        $sql = "delete from {$this->_table} where uid= '$user_id' and doc_id = '$doc_id'";
        return $this->sql($sql);
    }
    
    
}
