<?php
/**
 * 文档对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Doc extends Controllers_Interfaces_Base 
{
    
    /**
     * 获取学校的文档信息
     */
    public function getDocListBySchoolAction(){
    	$school_id = $this->getVar('school_id');
        $status = 'error';
        if(!$school_id){
            $this->abort(array('status'=>$status,'msg'=>'school_id is empty'));
        }
        $this->getDocData();
    }
    /**
     * 第三方用用的文档接口
     * 业务参数
     * @param $obj_type site_wenku 
     * @param $obj_id   1222
     */
    public function getDocListByAppAction(){
    	$obj_type = $this->getVar('obj_type');
    	$obj_id = $this->getVar('obj_id');
    	$status = 'error';
    	if(!$obj_type or !$obj_id){
    		$this->abort(array('status'=>$status,'msg'=>'obj_type or obj_id is empty'));
    	}
    	$this->getDocData("doc_id,uid,doc_title,doc_page_key,on_time");
    }
    /**
     * 根据条件获取文档的数据列表
     * 基本参数
     * @param $order
     * @param $start
     * @param $limit
     * @param $ct0 xd (可选)
     * @param $ct1 xk (可选)
     * @param $ct2 nj (可选)
     * @param $ct3 bb (可选)
     * @param $type 文档类型(1教案2课件3习题) (可选)
     */
    public function getDocData($fileds='*'){
    	$school_id = $this->getVar('school_id');
    	$role_id = $this->getVar('role_id');
    	$user_id = $this->getVar('user_id');
    	$order = $this->getVar('order',null);
    	$start = $this->getVar('start',0);
    	$limit = $this->getVar('limit',10);
    	$cate_id = $this->getVar('type');
    	$obj_type = $this->getVar('obj_type');
    	$obj_id = $this->getVar('obj_id');
    	
    	$status = 'error';
    	
    	$ct0 = $this->getVar('ct0');
    	$ct1 = $this->getVar('ct1');
    	$ct2 = $this->getVar('ct2');
    	$ct3 = $this->getVar('ct3');
    	$where  = " 1 ";
    	if($school_id){
    		$where  .= " and school_id = '$school_id'";
    	}
    	if($user_id){
    		$where  .= " and uid = '$user_id'";
    	}
    	if($role_id){
    		$where  .= " and role_id = '$role_id'";
    	}
    	if($ct0){
    		$where  .= " and xd = '$ct0'";
    	}
    	if($ct1){
    		$where  .= " and xk = '$ct1'";
    	}
    	if($ct2){
    		$where  .= " and nj = '$ct2'";
    	}
    	if($ct3){
    		$where  .= " and bb = '$ct3'";
    	}
    	if($cate_id){
    		$where  .= " and cate_id = '$cate_id'";
    	}
    	if($obj_type and $obj_id){
    		$where  .= " and obj_type = '$obj_type' and obj_id = '$obj_id'";
    	}
    	 
    	$doc_model = new Models_Doc();
    	 
    	$cnd = array('fileds' => $fileds, 'where' => $where,  'order' => $order,  'start' => $start, 'limit' => $limit);
    	
    	$doc_arr = $doc_model->find($cnd);
    	
    	
    	/* $sql  = $doc_model->db()->lastSql();
    	$this->abort($sql); */
    	$count = $doc_model->count($where);
    	$data = array('status'=>'ok','data'=>$doc_arr,'count'=>$count);
    	$this->abort($data);
    }
    
    
    /**
     * 获取文档信息
     */
    public function getDocInfoAction(){
        $id = $this->getVar('doc_id');
        
        $status = 'error';
        if(!$id){
            $this->abort(array('status'=>$status,'msg'=>'doc id is empty'));
        }
         
        $doc_model = new Models_Doc();
        
        $doc_info = $doc_model->load($id);
        $data = array('status'=>'ok','data'=>$doc_info );
        $this->abort($data);
    } 
}

?>