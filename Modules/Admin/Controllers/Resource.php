<?php

/**
 * 后台资源管理
 * 
 * @author michaeltsui98@qq.com 2014-05-14
 *
 */
class Modules_Admin_Controllers_Resource extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源管理-列表';
	    
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    $this->view->get_node_url = url('Modules_Admin_Controllers_Resource', 'getNodelJsonAction');
	    //取单元节点的url
	    $this->view->get_unit_url = url('Modules_Admin_Controllers_Unit', 'jsonAction');

	    $this->view->get_attr_url  = url('Modules_Admin_Controllers_Resource', 'getAttrAction');
	    $this->view->get_cate_url  = url('Modules_Admin_Controllers_Resource', 'getCateAction');
	    $this->view->get_audit_url  = url('Modules_Admin_Controllers_Resource', 'getAuditAction');

	    $this->view->upload_url = HTTP_DODOWENKU.url($this->c, 'addAction');
	    
	    $this->tpl();
	}


	/**
	 * 取点json
	 */
	public function getNodelJsonAction(){
	    $id = $this->getVar('id',0);
		$data = Modules_Admin_Models_NodeKind::init()->getList(1, 200,$id);
		if($id==0){
			$f = array('id'=>0,'text'=>'--基础节点--');
			array_unshift($data['rows'],$f);
		}
		$this->abort($data['rows']);
	}
	public function getAttrAction(){
	    //1=>用户资源 2=>官方资源 3=>机构资源
		$data = array(1=>'用户资源', 2=>'官方资源', 3=>'机构资源');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--资源属性--','selected'=>true);
		foreach($data as $k=>$v){
				  $tmp[] = array('id'=>$k,'text'=>$v);

		}
		$this->abort($tmp);
	}
	public function getCateAction(){
		$data = Cola::getConfig('_resourceType');
		$tmp = array();
		$tmp[] = array('id'=>0,'text'=>'--资源类型--','selected'=>true);
		foreach($data as $k=>$v){
				$tmp[] = array('id'=>$k,'text'=>$v);

		}
		$this->abort($tmp);
	}
	public function getAuditAction(){
	    //Models_Audit::$status;

		$data = array(0=>'待审核',1=>'通过审核', 2=>'审核未通过');
		$tmp = array();
		$tmp[] = array('id'=>-1,'text'=>'--审核状态--','selected'=>true);
		foreach($data as $k=>$v){
			$tmp[] = array('id'=>$k,'text'=>$v);
		}
		$this->abort($tmp);
	}

	
	/**
	 * 添加
	 */
	public  function addAction(){
		 
	    //$node_id = $this->getVar('node_id');


       // $unit_id = $this->getVar('unit_id');
       // $this->view->unit_id = $unit_id;
        //节点信息
		$node_arr = array();
		//if($node_id){
			//$node_arr = Models_Node::init()->getParentCodeById($node_id);
		//}

        //资源类型
        $cate_arr = Models_Base::init()->get_type_node();
        
        $sid = session_id();
        $resource_file_type = Cola::getConfig('_resourceFileType');
        $this->view->file_type = json_encode($resource_file_type);
        $this->view->sid = $sid;
        
        //取单元节点的url
        $this->view->get_unit_url = url('Modules_Admin_Controllers_Unit', 'jsonAction');
		$this->view->get_node_url = url('Modules_Admin_Controllers_Resource', 'getNodelJsonAction');

        
        
         
	   // $this->view->node_id = $node_id;
	    //$this->view->node_arr = $node_arr;
	    $this->view->cate_arr = $cate_arr;
	    $this->tpl();
	}
	/**
	 * 添加
	 */
	public  function addDoAction(){
	    
	    
	    $post = $this->post();
	    $post = $post['data'];
	    
	    $up = new Models_Upload();
	    //var_dump($post);die;
	    $tips = array('status'=>1,'msg'=>'上传成功');
		$node_id = $post['node_id'];
		if(!$node_id ){
			$this->alert_page('基础节点不能空');
			exit;
		}
	    //判断是否有文件
	    if(!$post['file'] ){
	        $tips = array('status'=>0,'msg'=>'没有找到上传的文件');
	        $this->alert_page($tips['msg']);
	        exit;
	    }elseif($post['file']){
    	    //取文件信息
    	    $files = array();
    	    
    	    $temp = explode(';', $post['file']);
    	    foreach ($temp as $key => $tmp){
    	        list($file_path,$file_name) = explode(',', $tmp,2);
    	        $file_ext = pathinfo($file_name,PATHINFO_EXTENSION);
    	        //判断文件类型是否正确
    	        if(!$up->checkFileType($post['cate_id'], $file_ext)){
    	            continue;
    	        }
    	        //die;
    	        $files[$key]['file_name'] = $file_name;
    	        $files[$key]['file_path'] = $file_path;
    	        $files[$key]['file_ext'] = $file_ext;
    	    }
    	    
    	    if(empty($files)){
    	        $tips = array('status'=>0,'msg'=>'资源文件的类型不符合要求');
    	        if(Cola_Request::isAjax()){
    	            $this->alert_page($tips['msg']);
    	        } 
    	    
    	    }
	    }


		$node_arr = Models_Node::init()->getParentCodeById($node_id);

		$post += $node_arr;

	    $post['doc_source'] = isset($post['doc_source'])?1:2;
	    //$post['node_id'] = $this->post('node_id');


		if($post['node_id']){

			if($post['node_id']>80000){
				//专业资源tree node
				$post['pid_path'] = Modules_Admin_Models_NodeCate::init()->getPidPath($post['node_id']);
			}else{
				//标准资源，但是没有知识节点的 tree node
				$post['pid_path'] = Modules_Admin_Models_NodeKind::init()->getPidPath($post['node_id']);
			}
		}

		if(isset($post['zs']) and $post['zs']){
			//知识节点的父ID
			$post['unit_pid_path'] = Modules_Admin_Models_UnitNode::init()->getPidPath($post['zs']);
		}

		$post['attr'] = 2;
		$post['is_ok'] = 1;

	   //var_dump($post);die;
	    $res  = $up->uploadData($files, $post);

		if(isset($res['doc_id']) and $res['doc_id']){
			$doc_title = $res['doc_title'];
			Models_Log::init()->add('add',$res['doc_id'],$this->user_info['user_id'],$this->user_info['user_realname'],'添加资源:'.$doc_title);
		}

	    if(isset($res['status']) and $res['status']==0){
	        $this->alert_page($res['msg']);
	    }else{
	        $this->flash_page('resource',1);
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
		    $video_info['obj_type'] = 'resource';
		    $video_info['obj_id'] = $file_id;
		    if(Models_Video::init()->checkExists($vid, $file_id, 'resource')){
		        $video_row =Models_Video::init()->getInfo($vid, $file_id, 'resource');
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
		$this->flash_page('resource',$res);
	}


	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');

		if(is_array($id)){
			foreach($id as $v){
				$doc_title = Models_Resource::init()->db->col("select doc_title from resource where doc_id = '$v'");
				//删除索引
				Models_Resource::init()->del_index($v);
				//删除数据库
				$res = Models_Resource::init()->del_doc($v);

				Models_Log::init()->add('delete',$v,$this->user_info['user_id'],$this->user_info['user_realname'],'删除资源:'.$doc_title);
			}
		}elseif(is_string($id)){
			$doc_title = Models_Resource::init()->db->col("select doc_title from resource where doc_id = '$id'");
			//删除索引
			Models_Resource::init()->del_index($id);
			//删除数据库
			$res = Models_Resource::init()->del_doc($id);
			Models_Log::init()->add('delete',$id,$this->user_info['user_id'],$this->user_info['user_realname'],'删除资源:'.$doc_title);
		}

		Models_Search::init()->flushIndex();
		Models_Search::init()->close();
		$this->flash_page('resource', $res);
		//$this->alert_page('删除成功');
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);
	    $node_id = $this->getVar('node_id',0);
    	$unit_id = (int)$this->getVar('unit_id');
    	$cate_id = (int)$this->getVar('cate_id');
    	$type = (int)$this->getVar('type');
    	$attr = (int)$this->getVar('attr');
		if(isset($_GET['is_ok'])){
			$is_ok = (int)$this->getVar('is_ok');
		}
    	$doc_title = (string)$this->getVar('doc_title');
	    
    	$node_arr = Models_Node::init()->getParentCodeById($node_id);
	    
    	$xd = $node_arr['xd'];
    	$xk = $node_arr['xk'];
    	$bb = $node_arr['bb'];
    	$nj = $node_arr['nj'];

    	$where = "1";
    	if($cate_id){
    		$where .= " and a.cate_id = '$cate_id' ";
    	}
    	
    	if($xd){
    		$where .= " and a.xd = '$xd' ";
    	}
    	if($xk){
    		$where .= " and a.xk = '$xk' ";
    	}
    	if($bb){
    		$where .= " and a.bb = '$bb' ";
    	}
    	if($nj){
    		$where .= " and a.nj = '$nj' ";
    	}
    	if($unit_id){
    		$where .= " and FIND_IN_SET('$unit_id',c.fid_path) ";

    	}
    	if($node_id){
    		//$where .= " or  a.node_id = '$node_id' ";
    	}
    	if($attr){
    		$where .= " and  a.attr = '$attr' ";
    	}
    	if($is_ok > -1){
    		$where .= " and  a.is_ok = '$is_ok' ";
    	}

    	switch ($type){
    		case 1:
    		    $where .= " and a.doc_title like '$doc_title%' ";
    		break;
    		case 2:
    		    $where .= " and a.user_name = '$doc_title' ";
    		break;
    		case 3:
    		    $where .= " and a.doc_id = '$doc_title' ";
    		break;
    	}
    	$where .= " and a.node_id < 80000 and a.node_id>0 ";
    	 
    	//$sql = "select * from resource where  $where order by doc_id desc";
    	$sql = "SELECT a.*,b.file_size,b.doc_ext_name ,d.user_name audit_user,d.msg
                FROM `resource` a  left join resource_file b
                on a.file_id = b.file_id
                LEFT JOIN unit_node c
				on a.nid = c.id
				left join resource_audit d
				on a.doc_id = d.doc_id
                where $where
                order by a.doc_id desc
                ";
		//var_dump($sql);die;
    	$data =  (array)Models_Resource::init()->getListBySql($sql, $page, $rows);

		//var_dump($sql);die;
    	$status = array(0=>"转换中",1=>"转换完成",2=>"转换失败",3=>'重复资源');
    	
	    $this->view->data =$data;
	    $this->view->status =$status;
	    $this->view->cate_name = Cola::$_config['_resourceType'];

		$is_ok_arr = array(0=>'待审核',1=>'通过审核', 2=>'审核未通过');

		$attr_arr = array(1=>'用户资源',2=>'官方资源', 3=>'机构资源') ;

		$colors = Models_Resource::$status_color;


	    $this->view->is_ok_arr = $is_ok_arr;
	    $this->view->attr_arr = $attr_arr;
	    $this->view->colors = $colors;


	    //$this->view->isOkUrl = url($this->c,'isOkAction');
	    $this->view->orderUrl = url($this->c,'orderAction');
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
		Models_Search::inits()->flushIndex();
		Models_Search::inits()->close();
		$this->flash_page('resource', $res);

	}
	 
	
	 
 
	
}