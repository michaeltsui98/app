<?php

	/**
	 * 专业资源分类
	 */

class Modules_Admin_Models_CmsColumn extends Cola_Model {
    
	protected $_table = 'cms_column';
	
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
	    	//$where .= " and is_ok = 1 ";
	    }
		$arr =  $this->getListBySql($sql, $page, $limit,'cat','id','pid','name');
		$data = array();
		foreach ($arr['rows'] as $k=>$v){
			$data[$v['id']] = $v;
		}
		//var_dump($data);
	    $arr1 =  $this->sql("SELECT * ,name as text FROM `{$this->_table}` WHERE `pid` = '$pid'  $where order by corder ");
	     
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
	 * 取所有的分类
	 */
	public  function getAllList($selected_id=null){
	    $sql = "select * from {$this->_table} where 1 and is_ok = 1 ";
	    return  $this->getListBySql($sql, 1, 500,'cat','id','pid','code',null,$selected_id);
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
	 * 取父ID路径
	 * @param int $id
	 * @return string $pid_path
	 */
	public function getPidPath($id){
	     return $this->db->col("select pid_path from {$this->_table} where id = '$id'");
	}
	
	
	/**
	 * 更新pidPath
	 * @param int $id
	 * @return Ambigous <multitype:, boolean>
	 */
	public function updatePidPath($id){
	    return $this->sql("update {$this->_table} set pid_path = genCmsColumnPidPath($id) where id = '$id' ");
	}
}

?>