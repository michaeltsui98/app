<?php


class Modules_Admin_Models_UnitNode extends Cola_Model {
    
	protected $_table = 'unit_node';
	
	protected $_pk = 'id';
	
	 
	/**
	 * 根据年级节点id获取单元表列
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUnitListByNodeId($id ,$pid=0){
		 
	    $node_arr = Models_Node::init()->getParentCodeById($id);
	    
	    $arr =  Models_Unit::init()->getUnit($node_arr['xd'], $node_arr['xk'], $node_arr['bb'], $node_arr['nj'],'cat');
	    $data = array();
	    if(!$arr){
	    	return  array('rows'=>array());
	    }
	    foreach ($arr['rows'] as $k=>$v){
	        $data[$v['id']] = $v;
	    }
	    
	     $arr1 =  $this->sql("SELECT * FROM `{$this->_table}` WHERE `node_fid` = '$pid' 
                    	     and xd = '{$node_arr['xd']}'
                    	     and xk = '{$node_arr['xk']}'
                    	     and bb = '{$node_arr['bb']}'
                    	     and nj = '{$node_arr['nj']}'
                    	     and node_show='1'  order by node_order ");
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
	/**
	 * 取知识节点BY Node_id
	 * @param int $id node_id
	 * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
	 */
	public function getTreeUnitByNodeId($id){
	    $node_arr = Models_Node::init()->getParentCodeById($id);
	    $arr =  Models_Unit::init()->getUnit($node_arr['xd'], $node_arr['xk'], $node_arr['bb'], $node_arr['nj'],'cat');
	    return $arr;
	}
	
	public function getAllUnitListByNodeId($id ,$pid=0){
		 
	    $node_arr = Models_Node::init()->getParentCodeById($id);
	    
	    $arr =  Models_Unit::init()->getUnit($node_arr['xd'], $node_arr['xk'], $node_arr['bb'], $node_arr['nj'],'cat');
	    $data = array();
	    if(!$arr){
	    	return  array('rows'=>array());
	    }
	    foreach ($arr['rows'] as $k=>$v){
	        $data[$v['id']] = $v;
	    }
	    
	     $arr1 =  $this->sql("SELECT * FROM `{$this->_table}` WHERE `node_fid` = '$pid' 
                    	     and xd = '{$node_arr['xd']}'
                    	     and xk = '{$node_arr['xk']}'
                    	     and bb = '{$node_arr['bb']}'
                    	     and nj = '{$node_arr['nj']}'
                    	        order by node_order ");
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
	
	
	/**
	 * get dataGrid data
	 * @param string $xk
	 * @param int $page
	 * @param int $limit
	 * @return Ambigous <boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
	 */
	public function getGroupList($page,$limit){
		$sql = "select * from {$this->_table}      order by group_order asc";
		return $this->getListBySql($sql, $page, $limit);
	}
	/**
	 * 检查组名
	 * @param string $name
	 * @param string $xk
	 * @return number | boolean
	 */
	public function checkGroupName($name){
		$res = false;
		$res = $this->count("group_title = '$name' ");
		return $res;
	}
	/**
	 * 更新pidPath
	 * @param int $id
	 * @return Ambigous <multitype:, boolean>
	 */
	public function updatePidPath($id){
	    return $this->sql("update {$this->_table} set fid_path = genUnitPidPath($id) where id = '$id' ");
	}
	
	/**
	 * 取父ID路径
	 * @param int $id
	 * @return string $pid_path
	 */
	public function getPidPath($id){
	    return $this->db->col("select fid_path from {$this->_table} where id = '$id'");
	} 
	
}

?>