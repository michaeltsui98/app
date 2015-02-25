<?php
/**
 * 教育节点关系
 * @author michael
 *
 */

class Modules_Admin_Models_NodeEdu extends Cola_Model {
    
	protected $_table = 'edu_relation';
	
	protected $_pk = 'id';
	
 
	/**
	 * get dataGrid data
	 * @param string $xk
	 * @param int $page
	 * @param int $limit
	 * @return Ambigous <boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
	 */
	public function getList($page,$limit,$pid=0){
	    $sql = "select * from {$this->_table} where 1 ";
	   
	     
		$arr =  $this->getListBySql($sql, $page, $limit,'cat','id','pid','code');
		$data = array();
		if(!$arr){
		    return $data;
		}
		foreach ($arr['rows'] as $k=>$v){
			$data[$v['id']] = $v;
		}
		//var_dump($data);
	    $arr1 =  $this->sql("SELECT * FROM `{$this->_table}` WHERE `pid` = '$pid' ");
	     
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
	 * 取教育关系ID
	 */ 
    public function getId($xd,$xk,$bb,$nj,$pid=0){
    	$sql = "select id from {$this->_table} where xd = '$xd' and xk = '$xk' and bb = '$bb' and nj = '$nj' and pid = '$pid'";
    	return $this->db->col($sql);
    }
    /**
     * 取教育的资源关系数据
     * @param int $pid
     * @return Ambigous <multitype:, boolean>
     */
    public function getSubByPid($pid){
        if(!$pid){
        	return array();
        }
            
    	$sql = "select * from {$this->_table} where pid = '$pid'";
    	return $this->sql($sql);
    }
	
}

?>