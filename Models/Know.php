<?php

/**
 * 文库知识节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Know extends Cola_Model
{
    protected  $_table = 'knowledge_node';
    
     /**
      * 获取节点列表
      * @return multitype:
      */
     function get_all(){
         $sql = "select * from knowledge_node order  by   node_order asc";
         $data = $this->sql($sql);
         $tree = new Cola_Com_Tree();
         $temp = array();
         $tree->get_tree($data, $temp,'cat',null,'id','node_fid','node_title');
         return $temp;
     }
     /**
      * 检查下级节点
      * @param int $id
      * @return Ambigous <string, NULL, mixed>
      */
     function check_sub($id){
         $sql = "SELECT count(*) FROM knowledge_node WHERE `node_fid` = " . $id;
         return (int)$this->db()->col($sql);
     }
   /**
    * 根据条件获取知识节点
    * @return array
    */  
     function get_know_by_where(){
         
         $w['node_xueduan']  = v('x');
         $w['node_subject']  = v('l');
         $w['node_grade']  = v('g');
         $w['node_edition']  = v('b');
         $w['node_special']  = v('s');
         
         $where = $this->getWhere($w);
         
         if(!$where){
             return array();
         }
         return (array)$this->table('knowledge_node')->find(array('fileds' => '*', 'where' => $where));
     }
     /**
      * 前端列表页面
      * @return multitype:|array
      */
     function get_know($ct0,$ct1,$ct2,$ct3,$zt){
         
         $w['node_xueduan']  = $ct0;
         $w['node_subject']  = $ct1;
         $w['node_grade']  = $ct2;
         $w['node_edition']  = $ct3;
         if($zt){
             $w['node_special']  = $zt;
         }
         $where = $this->getWhere($w);
          
         if(!$where){
             return array();
         }
         $key = $this->cache_key('get_know',$w);
         $data = $this->cache()->get($key);
         if(!$data){
             $data =  (array)$this->find(array('fileds' => '*', 'where' => $where,'order' => 'id'));
             $this->cache()->set($key,$data);
         }
         return $data;
     }
     /**
      * 知识节点树
      * @param array $data
      */
     function get_tree($data){
         $temp_arr = array();
         Cola_Com_Tree::get_trees($data, $temp_arr,'cat','null','id','node_fid','node_title');
         return $temp_arr;
     }
     /**
      * 取知识节点名称
      * @param id $knode
      * @return Ambigous <string, NULL, mixed>
      */
     function get_know_title($knode){
         $sql = "select node_title from knowledge_node       where id = '$knode'";
         return $this->db()->col($sql);
     }
          
     
}
 