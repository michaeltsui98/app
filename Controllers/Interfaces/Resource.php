<?php
/**
 * 文档对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Resource extends Controllers_Interfaces_Base 
{
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
    	 
    	$doc_model =  Models_Resource::init();
    	 
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
    public function getResourceInfoAction(){
        $id = $this->getVar('id');
        
        $status = 'error';
        if(!$id){
            $this->abort(array('status'=>$status,'msg'=>'doc id is empty'));
        }
        $doc_model = Models_Resource::init();
        $doc_info = $doc_model->get_doc_info($id);
        $doc_model->view_add($id,$doc_info['doc_views']);
        $data = array('status'=>'ok','data'=>$doc_info );
        $this->abort($data);
    } 
    /**
     * 获取资源评论信息
     * 资源的评分数，评分人数
     */
    public function  getResourceRemarkInfoAction(){
        $id = $this->getVar('id');
        $data = Models_Resource::init()->get_count_mark($id,'doc');
    	$this->abort(array('status'=>'ok','data'=>$data ));
    }
    
    /**
     * 我下载的资源 
     */
    public function getMyDownAction(){
    	$xk = $this->getVar('xk');
    	$user_id = $this->getVar('user_id');
    	$cate_id = (int)$this->getVar('cate_id');
    	if(!$xk or !$user_id){
    	    $this->abort(array('status'=>'error','data'=>'参数不正确' ));
    	}
    	
    	$page = $this->getVar('page',1);
    	$limit = $this->getVar('limit',20);
    	$where = "";
    	if($cate_id){
    		$where = " and b.cate_id = '$cate_id' ";
    	}
    	
    	$sql = "select 
                 b.doc_id as id ,b.doc_title as title , 
                b.doc_summery summery , 
                b.user_name , b.doc_views views,
                b.doc_credit credit, 
                round(b.doc_remark_val/b.doc_remarks,1) remark, 
                c.doc_ext_name file_type, c.file_key,c.doc_pages pages ,
                c.doc_page_key page_key, b.on_time,c.file_size,a.on_time down_time,
                b.doc_downs downs, a.uid 
                from doc_down_log a inner join resource b
                on a.doc_id = b.doc_id
                left join resource_file c 
                on b.file_id = c.file_id 
                where   b.xk = '$xk' and a.uid = '$user_id' $where  order by a.id desc";
    	 
    	$data = Models_Resource::init()->getListBySql($sql, $page, $limit);
    	$this->abort(array('status'=>'ok','data'=>$data ));
    }
    /**
     * 我收藏的的资源
     */
    public function getMyFavAction(){
        $xk = $this->getVar('xk');
        $user_id = $this->getVar('user_id');
        $cate_id = (int)$this->getVar('cate_id');
        if(!$user_id){
            $this->abort(array('status'=>'error','data'=>'参数不正确' ));
        }
        $page = $this->getVar('page',1);
        $limit = $this->getVar('limit',20);
        
        $where = "";
    	if($cate_id){
    		$where = " and b.cate_id = '$cate_id' ";
    	}
        if($xk){

            $where .= " and b.xk = '$xk' ";
        }
        
        $sql = "select 
                b.doc_id as id ,b.doc_title as title ,
                b.doc_summery summery ,
                b.user_name , b.doc_views views,b.doc_credit credit,
                round(b.doc_remark_val/b.doc_remarks,1) remark,
                c.doc_ext_name file_type,
                c.file_key,c.doc_pages pages ,c.doc_page_key page_key,
                b.on_time,c.file_size,a.on_time fav_time, b.doc_favs favs,
                a.uid,b.uid user_id
                from resource_fav a inner join resource b
                on a.obj_id = b.doc_id
                left join resource_file c 
                on b.file_id = c.file_id 
                where a.obj_type='doc'  and b.xk = '$xk' and a.uid = '$user_id' $where order by a.id desc";
        $data = Models_Resource::init()->getListBySql($sql, $page, $limit);
        $this->abort(array('status'=>'ok','data'=>$data ));
    }
    
    /**
     * 删除我收藏
     */
    public function delMyFavAction(){
        $user_id = $this->getVar('user_id');
        $id = $this->getVar('id');
    	$res = Models_Resource::init()->delMyFavResource($user_id, $id);
    	$this->abort(array('status'=>'ok','data'=>$res ));
    }
    /**
     * 删除我上传的
     */
    public function delMyUploadAction(){
    	$user_id = $this->getVar('user_id');
        $id = $this->getVar('id');
    	$res = Models_Resource::init()->delMyUploadResource($user_id, $id);
    	$this->abort(array('status'=>'ok','data'=>$res ));
    }
    public function getCountUploadResourceAction(){
    	$user_id = $this->getVar('user_id');
    	$xk = $this->getVar('xk');
        $res = Models_Resource::init()->getCountUploadResource($user_id,$xk);
    	$this->abort(array('status'=>'ok','data'=>$res ));
    }
    /**
     * 更新资源信息
     */
    public function editResourceAction(){
        $id = (int)$this->getVar('id');
        if(!$id){
            $this->abort(array('status'=>'error','data'=>'参数错误' ));
        }
        $title = (string)$this->getVar('title');
        $summery = (string)$this->getVar('summery');
        $xd = (string)$this->getVar('xd');
        $xk = (string)$this->getVar('xk');
        $bb = (string)$this->getVar('bb');
        $nj = (string)$this->getVar('nj');
        $zs = (int)$this->getVar('zs');
        $data = array('doc_title'=>$title,'doc_summery'=>$summery,'xd'=>$xd,'xk'=>$xk,'bb'=>$bb,'nj'=>$nj,'nid'=>$zs);
        //更新数据库
        $res = Models_Resource::init()->update($id, array_filter($data));
        //$this->abort(array('status'=>'ok','data'=>$data));
        $zs_name = '';
        if($zs){
        	$zs_name = Models_Unit::init()->getUnitNameById($zs);
        }
        
        $index_arr = array();
        $index_arr['id'] = $id;
        $index_arr['title'] = $data['doc_title'];
        $index_arr['summery'] = $data['doc_summery'];
        // 节点名称集,"小学+数数+三年级+人教版"
        $index_arr['node_name'] = Cola::$_config['_xd'][$xd].'+'.Cola::$_config['_xk'][$xk].'+'.Cola::$_config['_bb'][$bb].'+'.Cola::$_config['_nj'][$nj].'+'.$zs_name;
        // 节点ID的串,xd,xk,bb,nj,nid
        $index_arr['node_id'] = "$xd,$xk,$bb,$nj,$zs";
        $res =  Models_Search::inits()->update_index($id, array_filter($index_arr));
        Models_Search::init()->flushIndex();
        $this->abort(array('status'=>'ok','data'=>'删除成功' ));
    }
    /**
     * 收藏资源
     */
    public  function favAction(){
        $id = $this->getVar('id');
        $user_id = $this->getVar('user_id');
        if(!$id){
            $this->abort(array('status'=>'error','data'=>'收藏的对象不成在' ));
        }
        $doc = new Models_Resource();
        $uid = $user_id;
        if(!$uid){
            $this->abort(array('status'=>'error','data'=>'user_id 不存在!' ));
        }
        $doc_info = $doc->get_doc_info($id);
        if($uid ==$doc_info['uid']){
            $this->abort(array('status'=>'error','data'=>'不能收藏自己的资源' ));
        }
        $is_fav = $doc->is_fav($uid, $id,'doc');
        if($is_fav){
            $this->abort(array('status'=>'error','data'=>'已经收藏过了' ));
        }
        $data['uid'] = $uid;
        $data['obj_type'] = 'doc';
        $data['obj_id'] = $id;
        $data['on_time'] = $_SERVER['REQUEST_TIME'];
        //防止重复收藏
        $count = Cola_Model::init()->table('resource_fav')->count("obj_id = '$id' and obj_type='doc' and uid = '$uid'");
        
        if(!$count){
            $res =  Cola_Model::init()->table('resource_fav')->insert($data);
            $doc->fav_add($id);
        }
        $doc->clear_doc_info_cache($id);
         
        //$this->renderJsonpData(array('msg'=>'收藏成功！','status'=>1));
        $this->abort(array('status'=>'ok','data'=>'收藏成功！' ));
    }
    /**
     * 资源评价
     */
    public function remarkResourceAction(){
        $ff = (int) $this->getVar('zs',0);
        $ty = (int) $this->getVar('ty',0);
        $id = $this->getVar('id');
        $uid = $this->getVar('user_id');
        if(!$uid){
            $this->abort(array('status'=>'error','data'=>'请登录!' ));
        }
        $data['uid'] = $uid;
        $data['obj_id'] = $id;
        $data['obj_type'] = 'doc';
        $data['ff'] = $ff;
        $data['ty'] = $ty;
        $doc = new Models_Resource();
        $is_mark = $doc->is_mark($uid, $id,'doc');
        
        if($is_mark){
            $this->abort(array('status'=>'error','data'=>'已经评价过了' ));
        }
       
        $res = Cola_Model::init()->insert($data,'doc_remark');
        $val =$ff+$ty;
        $doc->mark_add($id,$val);
        //取当前分数
        //$cond = array('fileds' => 'doc_remark_val/doc_remarks', 'where' => "doc_id = '$id'");
        $remark_info = $doc->get_count_mark($id, 'doc');
        $remarks = number_format($remark_info['mark'],2);
        //更新评分数索引
        $doc->update_index($id, array('remark'=>$remarks));
        $res = $doc->clear_doc_info_cache($id);
         
        $this->abort(array('status'=>'ok','data'=>'评价成功！' ));
    }
     
    
    
  
    
}

?>