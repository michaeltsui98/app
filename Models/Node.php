<?php

/**
 * 文库基础节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Node extends Cola_Model
{

    protected  $_table = 'node_kind';
    protected  $_pk = 'id';
     /**
      * 获取资源基础子节点
      * @param int $id
      * @return number
      */
     function getSubNode($id){
         $sql = "SELECT * FROM `{$this->_table}` WHERE `pid` = '$id' and is_ok='1'  order by node_order ";
         $key = $this->cache_key(__FUNCTION__,$id);
         $data = $this->cache->get($key);
         //var_dump($data);die;
         if(!$data){
             $data = $this->sql($sql);
             $this->cache->set($key,$data);
         }
         return $data;
     }
     
     /**
      * 取父级节点code
      * @param id $id
      */
     public function getParentCodeById($id){
     	$sql = "select * from {$this->_table} where is_ok = 1 ";
     	$arr = $this->sql($sql);
     	$tmp = array();
     	foreach ($arr as $value) {
     		$tmp[$value['id']] = $value;
     	}
     	$nj_arr = $tmp[$id];
     	$nj_code = $nj_arr['code'];
     	$bb_arr = $tmp[$nj_arr['pid']];
     	$bb_code = $bb_arr['code'];
     	$xk_arr = $tmp[$bb_arr['pid']];
     	$xk_code= $xk_arr['code'];
     	$xd = $tmp[$xk_arr['pid']];
     	$xd_code = $xd['code'];
     	
     	$data = array_values(array_filter(array($xd_code,$xk_code,$bb_code,$nj_code)));

     	$xd_code = isset($data[0])?$data[0]:null;
    	$xk_code = isset($data[1])?$data[1]:null;
    	$bb_code = isset($data[2])?$data[2]:null;
    	$nj_code = isset($data[3])?$data[3]:null;
      
     	
     	return array('xd'=>$xd_code,'xk'=>$xk_code,'bb'=>$bb_code,'nj'=>$nj_code);
     }
     /**
      * 取父级与子级的节点信息
      * @param int $id
      */
     public function getParentCateById($id){
     	$sql = "SELECT a.id pid, a.name pname, b.id sid, b.name sname
                FROM `node_cate` a 
                left join node_cate b on 
                a.id = b.pid
                where b.id = '$id'";
     	return $this->db->row($sql);
     	        
     }
     /**
      * 统计资源子节点的数量
      * @param int $id
      * @return multitype:Ambigous <>
      */
     function count_sub_resnode($id){
         $sql = "SELECT a.id, count(b.id) c
                 FROM node_kind a
                 left join node_kind b
                 on a.id = b.pid
                 WHERE a.`pid` = '$id'
                 and a.is_ok='1'
                 GROUP BY a.id";
         $data = $this->sql($sql);
         $res = array();
         foreach ($data as $v){
         $res[$v['id']] = $v['c'];
         }
         return $res;
     }
     /**
      * 节点为编码获取节点名称
      * @param array $nodes
      */
     public function getNodeName($nodes=array()){
        $all = Models_Public_Node::getAllNode();
        //var_dump($nodes,$all);die;
        $text = array();
     	foreach ($nodes as $node){
            if(isset($all[$node])){
                $text[] = $all[$node] ;
            }
     	}
     	return $text;
     }
     /**
      * 根据学段编号取学段id
      * @param string $xd
      */
     public function getXdIdByCode($xdcode){
     	return $this->db->col("select id from {$this->_table} where code='$xdcode'");
     }
     /**
      * 取基础节点树
      * @param string $select
      * @param string $type
      * @return Ambigous <boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
      */
     public function getNodeList($select='',$type='option'){
        $sql = "select * from {$this->_table}";
         
     	return $this->getListBySql($sql, 1, 1000,$type,'id','pid','name',null,$select);
     }
     /**
      * 取基础节点ID
      * @param string $xd
      * @param string $xk
      * @param string $bb
      * @param string $nj
      * @return number
      */
     public function getIdByNode($xd,$xk,$bb,$nj){
     	$sql = "select id from node_kind d where d.pid = (
                select id from node_kind c where c.pid = (
                SELECT id from node_kind b where b.pid = (
                SELECT id FROM `node_kind` a where code='$xd'
                ) and  b.`code` = '$xk'
                ) and c.`code` = '$bb'
                ) and d.`code` = '$nj'";
     	return (int)$this->db->col($sql);
     	        
     }
     /**
      * 所有的节点信息
      * @return array
      */
     public static function getAllNode(){
         return array_merge(Cola::$_config['_xd'],Cola::$_config['_xk'],Cola::$_config['_bb'],Cola::$_config['_nj']);
     }
     
}
 