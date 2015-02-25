<?php

/**
 * 文库单元节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Unit extends Cola_Model
{

    protected  $_table = 'unit_node';
    protected  $_pk = 'id';
    
    /**
     * 取单元节点
     * @param string $xd
     * @param string $xk
     * @param string $bb
     * @param string $nj
     */
    public function getUnit($xd,$xk,$bb,$nj,$type='cat',$select=null){
//     	$sql = "select * from {$this->_table} where xd='$xd' and xk='$xk' and bb='$bb' and nj = '$nj'";
    	$sql = "select * from {$this->_table} where xd='$xd' and xk='$xk' and bb='$bb' and nj = '$nj' order by node_order ";
    	return $this->getListBySql($sql, 1, 500,$type,'id','node_fid','node_title','node_show',$select);
    }
    /**
     * 取单元子节点
     * @param unknown $id
     * @return Ambigous <boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
     */
    public function getSubUint($id){
    	$sql = "select * from {$this->_table} where node_fid = '$id' and node_show = 1";
    	return $this->getListBySql($sql, 1, 500);
    }
    /**
     * 取单元节点
     * @param int $id
     */
    public function getUnitNameById($id){
        $sql = "select node_title from {$this->_table} where id = '$id'";
    	return $this->db->col($sql);
    }
    
     
     
}
 