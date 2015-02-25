<?php

/**
 * 文库基础节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Cate extends Cola_Model
{

    protected  $_table = 'node_cate';
    protected  $_pk = 'id';

     /**
      * 取父级与子级的节点信息
      * @param int $id
      */
     public function getParentById($id){
     	$sql = "SELECT a.id pid, a.name pname, b.id sid, b.name sname
                FROM `{$this->_table}` a
                left join {$this->_table} b on
                a.id = b.pid
                where b.id = '$id'";
     	return $this->db->row($sql);
     	        
     }


     
}
 