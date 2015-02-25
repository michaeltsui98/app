<?php

	/**
	 * 基础资源分类
	 * Class Modules_Admin_Models_NodeKind
	 */

class Modules_Admin_Models_NodeKind extends Cola_Model {
    
	protected $_table = 'node_kind';
	
	protected $_pk = 'id';
	
 

	/**
	 * get dataGrid data
	 * @param string $xk
	 * @param int $page
	 * @param int $limit
	 * @return Ambigous <boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
	 */
	public function getList($page,$limit,$pid=0,$is_all = true){
	    $sql = "select * from {$this->_table} where 1 ";
	    $where = "";
	    if($is_all){
	    	$where .= " and is_ok = 1 ";
	    }
		$arr =  $this->getListBySql($sql, $page, $limit,'cat','id','pid','code');
		$data = array();
		foreach ($arr['rows'] as $k=>$v){
			$data[$v['id']] = $v;
		}
		//var_dump($data);
	    $arr1 =  $this->sql("SELECT *,name as text FROM `{$this->_table}` WHERE `pid` = '$pid'  $where order by node_order ");
	     
	    foreach ($arr1 as $key =>$value) {
	        if($data[$value['id']]['have_child']){
    	    	$arr1[$key]['state'] = 'closed';
	        }else{
    	    	$arr1[$key]['state'] = 'open';
	        }
	    	$arr1[$key]['level'] = $data[$value['id']]['level'];
	        
	    }
	    return array('rows'=>$arr1);
	}
	
	public function getAllList($page,$limit,$pid=0){
	    $sql = "select * ,a.name as text from (
                select * from node_kind 
                UNION
                select * from node_cate
                ) a
                where  a.is_ok =1 ";
	    $where = "";
	    
		$arr =  $this->getListBySql($sql, $page, $limit,'cat','id','pid','code');
		$data = array();
		foreach ($arr['rows'] as $k=>$v){
			$data[$v['id']] = $v;
		}
		
	    $arr1 =  $this->sql("select * ,a.name as text from (
                select * from node_kind 
                UNION
                select * from node_cate
                ) a WHERE a.pid = '$pid' and a.is_ok =1 $where order by a.node_order,a.id ");
	     
	    foreach ($arr1 as $key =>$value) {
	        if($data[$value['id']]['have_child']){
    	    	$arr1[$key]['state'] = 'closed';
	        }else{
    	    	$arr1[$key]['state'] = 'open';
	        }
	    	$arr1[$key]['level'] = $data[$value['id']]['level'];
	        
	    }
	    return array('rows'=>$arr1);
	}
	
	public function getAllListTree($page,$limit,$id=0){
	    $sql = "select * ,a.name as text from (
                select * from node_kind
                UNION
                select * from node_cate
                ) a
                where  a.is_ok =1 ";
 
	     
	    return  $this->getListBySql($sql, $page, $limit,'option','id','pid','name',null,$id);
	}
	
	public function buildTree(array &$elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['pid'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['child'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }
    /**
     * 取基础节点名称
     * @return multitype:
     */
    public function getAllNodeName(){
    	return array_merge(Cola::$_config['_xd'],Cola::$_config['_xk'],Cola::$_config['_bb'],Cola::$_config['_nj']);
    }
    
    /**
     * 删除节点及子节点
     * @param int $id
     */
    public function delNodeById($id){
    	$sql = "DELETE a.*,b.* FROM `{$this->_table}` a
                left join {$this->_table} b on a.id = b.pid 
                where a.id = '$id'";
    	return $this->sql($sql);
    }
	 
	/**
	 * 检查重名
	 * @param string $name
	 * @param string $pid
	 * @return number | boolean
	 */
	public function checkCodeName($name,$pid){
		$res = false;
		$res = $this->count("code = '$name' and pid = '$pid'");
		return $res;
	}
	/**
	 * 更新pidPath
	 * @param int $id
	 * @return Ambigous <multitype:, boolean>
	 */
	public function updatePidPath($id){
	    return $this->sql("update {$this->_table} set pid_path = genKindPidPath($id) where id = '$id' ");
	}
	
	/**
	 * 取父ID路径
	 * @param int $id
	 * @return string $pid_path
	 */
	public function getPidPath($id){
	    return $this->db->col("select pid_path from {$this->_table} where id = '$id'");
	}
}

?>