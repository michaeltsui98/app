<?php

/**
 * 产品管理
 * 
 * @author michaeltsui98@qq.com 2014-05-14
 *
 */
class Modules_Admin_Controllers_AppProduct extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源管理-列表';
	    
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    $this->view->get_official_url  = url($this->c, 'getOfficialAction');
	    $this->view->get_balance_url  = url($this->c, 'getBalanceAction');
	    $this->view->get_platform_url  = url($this->c, 'getPlatformAction');
	    $this->view->get_cooperation_url  = url($this->c, 'getCooperationAction');
	    $this->view->get_cate_url  = url($this->c, 'getAppTypeAction');

	    $this->tpl();
	}

    /**
     * 产品来源 用户 官方
     */
	public function getOfficialAction(){
	    $data = Cola::getConfig('_official');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--产品来源--','selected'=>true);
		foreach($data as $k=>$v){
				  $tmp[] = array('id'=>$k,'text'=>$v);
		}
		$this->abort($tmp);
	}

    /**
     * 结算方式
     */
	public function getBalanceAction(){
		$data = Cola::getConfig('_balance');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--结算方式--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$v,'text'=>$v);
		}
		$this->abort($tmp);
	}
    /**
     * 平台系统
     */
	public function getPlatformAction(){
		$data = Cola::getConfig('_platform');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--平台系统--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$v,'text'=>$v);
		}
		$this->abort($tmp);
	}
    /**
     * 合作方式
     */
	public function getCooperationAction(){
		$data = Cola::getConfig('_cooperation');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--合作方式--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$k,'text'=>$v);
		}
		$this->abort($tmp);
	}
    /**
     * 产品类型
     */
	public function getAppTypeAction(){
		$data = Cola::getConfig('_appType');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--产品类型--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$k,'text'=>$v);
		}
		$this->abort($tmp);
	}
    /**
     * 查看方式
     */
	public function getDataViewAction(){
		$data = Cola::getConfig('_dataview');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--查看方式--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$v,'text'=>$v);
		}
		$this->abort($tmp);
	}

	/**
	 * 添加
	 */
	public  function addAction(){

        $this->view->get_cate_url  = url($this->c, 'getAppTypeAction');
        $this->view->get_official_url  = url($this->c, 'getOfficialAction');
        $this->view->get_balance_url  = url($this->c, 'getBalanceAction');
        $this->view->get_platform_url  = url($this->c, 'getPlatformAction');
        $this->view->get_cooperation_url  = url($this->c, 'getCooperationAction');
        $this->view->get_dataview_url  = url($this->c, 'getDataViewAction');


        



	    $this->tpl();
	}
	/**
	 * 添加
	 */
	public  function addDoAction(){
	    
	    
	    $post = $this->post();
	    $post = $post['data'];
	    


	    if(isset($res['status']) and $res['status']==0){
	        $this->alert_page($res['msg']);
	    }else{
	        $this->flash_page('app_product',1);
	    }
 
	      
 
		
	}
 
	/**
	 * 编辑
	 */
	public  function editAction(){
		$id = $this->getVar('id');
//         $info = Models_Resource::init()->load($id);
        $info =  Models_Video::init()->getVideoResouceInfo($id,5);
        $node_id  = 0 ;
        if($info['node_id']){
            $node_id = $info['node_id'];        	
        }else{
            $node_id = Models_Node::init()->getIdByNode($info['xd'], $info['xk'], $info['bb'], $info['nj']);
        }
        
        $node_arr = Modules_Admin_Models_NodeKind::init()->getAllListTree(1,1000,$node_id);
        
        $this->view->node_arr = $node_arr['rows'];
        

        
        $unit_arr =  Models_Unit::init()->getUnit($info['xd'], $info['xk'], $info['bb'], $info['nj'],'option',$info['nid']);
         
        $this->view->unit_arr = $unit_arr['rows'];
        //取单元节点的url
        $this->view->get_unit_url = url('Modules_Admin_Controllers_Unit', 'getTreeUnit');
		$this->view->info = $info;
		$this->view->id = $id;
		$this->tpl();
	}
 
	/**
	 * 保存编辑
	 */
	public  function editDoAction(){
		$id = $this->post('id');
		$data = $this->post('data');
		$node_id = $this->post('node_id');
		$node_arr = Models_Node::init()->getParentCodeById($node_id);
		$xd = $node_arr['xd'];
		$xk = $node_arr['xk'];
		$bb = $node_arr['bb'];
		$nj = $node_arr['nj'];
		$zs = $data['nid'];
		$data += $node_arr;
		$data['node_id'] = $node_id;
		//更新数据库
		Models_Resource::init()->update($id, $data);
		
		$vid = $this->getVar('vid');
		$file_id = $this->getVar('file_id');
		
		//将视频写到视频云中
		if($vid){
		    $video_info = Models_Sdk_Polyv::init()->getById($vid);
		    $video_info['obj_type'] = 'app_product';
		    $video_info['obj_id'] = $file_id;
		    if(Models_Video::init()->checkExists($vid, $file_id, 'app_product')){
		        $video_row =Models_Video::init()->getInfo($vid, $file_id, 'app_product');
		        Models_Video::init()->update($video_row['id'], $video_info);
		    }else{
		       Models_Video::init()->insert($video_info);
		    }
		}
		$zs_name = '';
		if($data['nid']){
		    $zs_name = Models_Unit::init()->getUnitNameById($data['nid']);
		}
		
		$index_arr = array();
		$index_arr['id'] = $id;
		$index_arr['title'] = $data['doc_title'];
		$index_arr['summery'] = $data['doc_summery'];
		// 节点名称集,"小学+数数+三年级+人教版"
		$index_arr['node_name'] = Cola::$_config['_xd'][$xd].'+'.Cola::$_config['_xk'][$xk].'+'.Cola::$_config['_bb'][$bb].'+'.Cola::$_config['_nj'][$nj].'+'.$zs_name;
		// 节点ID的串,xd,xk,bb,nj,nid
		$index_arr['node_id'] = "$xd,$xk,$bb,$nj,$zs,$node_id";
		$res =  Models_Search::inits()->update_index($id, $index_arr);
		$doc_title = Models_Resource::init()->db->col("select doc_title from resource where doc_id = '$id'");
		Models_Log::init()->add('edit',$id,$this->user_info['user_id'],$this->user_info['user_realname'],'编辑资源:'.$doc_title);
		$this->flash_page('app_product',$res);
	}
	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');
		if(is_array($id)){
			foreach($id as $v){
               $res = Models_AppProduct::init()->delete($v);
			}
		}elseif(is_string($id)){
			$res =Models_AppProduct::init()->delete($id);
		}

		$this->flash_page('app_product',$res,null);

	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);


	    $cate_id = $this->getVar('app_cate',0);
    	$official = (int)$this->getVar('official');
    	$balance = $this->getVar('balance');
    	$platform = $this->getVar('platform');
    	$cooperation = (int)$this->getVar('cooperation');

        $title = (string)$this->getVar('app_title');
    	$where = "1";
    	if($cate_id){
    		$where .= " and cate_id = '$cate_id' ";
    	}
    	if($official){
    		$where .= " and official = '$official' ";
    	}
    	if($balance){
    		$where .= " and balance = '$balance' ";
    	}
    	if($platform){
    		$where .= " and  platform = '$platform' ";
    	}
    	if($cooperation){
    		$where .= " and cooperation = '$cooperation' ";
    	}
    	if($title){
            $where .= " and title like '$title%' ";
    	}
    	$sql = "SELECT  * from app_product
                where $where
                order by  updated_at desc ";
		//var_dump($sql);die;
    	$data =  (array)Models_Resource::init()->getListBySql($sql, $page, $rows);
	    $this->view->data =$data;

	   $this->view->app_type =  Cola::getConfig('_appType');
	    $this->view->official =  Cola::getConfig('_official');
	    $this->view->platform =  Cola::getConfig('_platform');
	    $this->view->balance =  Cola::getConfig('_balance');
	    $this->view->dataview =  Cola::getConfig('_dataview');
	    $this->view->cooperation =  Cola::getConfig('_cooperation');

	    $this->view->auditUrl = url($this->c,'auditAction');

		if(!empty($data)){
			$this->tpl();
		} else{
			$this->abort(array());
		}

	}

	public  function  auditAction(){
		$doc_id = $this->getVar('doc_id');
		$is_ok = $this->getVar('is_ok');
		$user_id = $this->user_info['user_id'];
		$user_name = $this->user_info['user_realname'];
		$msg = $this->getVar('msg');
		$time = $_SERVER['REQUEST_TIME'];
		$doc_title = Models_Resource::init()->db->col("select doc_title from resource where doc_id = '$doc_id'");
		$res = Models_Resource::init()->update_doc($doc_id,array('is_ok'=>$is_ok));
		Models_Search::inits()->update_index($doc_id,array('is_ok'=>$is_ok));
		Models_Audit::init()->insert(array('doc_id'=>$doc_id,'user_id'=>$user_id,'user_name'=>$user_name,'created_at'=>$time,
		'status'=>$is_ok,'msg'=>$msg));

		if($is_ok==1){
			$info = "通过审核:{$doc_title}";
		}elseif($is_ok==2){
			$info = "审核未通过:{$doc_title},原因：{$msg}";
		}

		//生成操作日志
		Models_Log::init()->add('audit',$doc_id,$user_id,$user_name,$info);

		$this->flash_page('app_product', $res);

	}
	 
	
	 
 
	
}