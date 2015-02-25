<?php

/**
 * 后台节点树管理
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_Node extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源基本节点树管理-列表';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    $this->tpl();
	}
	/**
	 * 添加用户组
	 */
	public  function addAction(){
		 
	    $pid = $this->getVar('pid');
	    $level = $this->getVar('l');
	    $data = array();
	    if($level==0){
	    	//学科
	    	$data = Cola::$_config['_xk'];
	    	$text = '学科';
	    }elseif($level == 1){
	    	$text = '版本';
	        $data = Cola::$_config['_bb'];
	    }elseif($level == 2){
	    	$text = '年级';
	        $data = Cola::$_config['_nj'];
	    }
	  
	    $this->view->data = $data;
	    $this->view->pid = $pid;
	    $this->view->text = $text;
	    $this->view->check_code_url = url($this->c, 'checkNameAction');
		$this->tpl();
	}
	
	public  function addDoAction(){
	    $data = array();
		$data = $this->getVar('data');
		$node_arr = Models_Public_Node::getAllNode();
		$data['name']  =  $node_arr[$data['code']];
		$res = Modules_Admin_Models_NodeKind::init()->insert($data);
		Modules_Admin_Models_NodeKind::init()->updatePidPath($res);
		$this->alert_page('添加成功');
		
	}
	public  function checkNameAction(){
		$name = $this->getVar('param');
		$pid = (int)$this->getVar('pid');
        $arr = array('info'=>'已存在相同的','status'=>'n');		
		$status = Modules_Admin_Models_NodeKind::init()->checkCodeName($name,$pid);
        if(!$status){
	        $arr = array('info'=>'可以使用','status'=>'y');		
        }
		$this->abort($arr);
	}
	/**
	 * 编辑用户组信息
	 */
	public  function editAction(){
		$id = $this->getVar('id');
		$level = $this->getVar('l');
		$data = array();
		if($level==1){
		    //学科
		    $data = Cola::$_config['_xk'];
		    $text = '学科';
		}elseif($level == 2){
		    $text = '版本';
		    $data = Cola::$_config['_bb'];
		}elseif($level == 3){
		    $text = '年级';
		    $data = Cola::$_config['_nj'];
		}
		$this->view->text = $text;
		$this->view->data = $data;
		$this->view->check_code_url = url($this->c, 'checkNameAction');
		$info = Modules_Admin_Models_NodeKind::init()->load($id);
		$this->view->info = $info;
		$this->view->id = $id;
		$this->tpl();
	}
	/**
	 * 保存编辑用户组信息
	 */
	public  function editDoAction(){
		$id = $this->getVar('id');
		$data = array();
		$data = $this->getVar('data');
		$node_arr = Models_Public_Node::getAllNode();
		$data['name']  = $node_arr[$data['code']];
		$res = Modules_Admin_Models_NodeKind::init()->update($id, $data);
		 
		//$this->flash_page($table_id, $status);
		//ui_tip('', json.message, json.status, success_callback)
		$this->flash_page('node', $res,null,'treegrid');
	}
	/**
	 * 设置用户组状态
	 */
	public function isOkAction(){
		$id = $this->get('id');
		$ok = $this->get('ok');
		$res  =  Modules_Admin_Models_NodeKind::init()->update($id, array('is_ok'=>$ok));
		$this->flash_page('node', $res,null,'treegrid');
	}
	/**
	 * 排序
	 */
	public function orderAction(){
		$id = $this->get('id');
		$type = $this->get('type');
		$obj_id = $this->get('obj_id');
		$res  =  Modules_Admin_Models_NodeKind::init()->update($id, array('node_order'=>$obj_id));
		$this->flash_page('node', $res,null,'treegrid');
	}
	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');
		$res  =  Modules_Admin_Models_NodeKind::init()->delNodeById($id);
		$this->flash_page('node', $res,null,'treegrid');
		//$this->alert_page('删除成功');
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);
	    $pid = $this->getVar('id',0);
	    $is_ok = $this->getVar('is_ok',true);
	    $data =  Modules_Admin_Models_NodeKind::init()->getList($page, 500 ,$pid,$is_ok);
	    
	   // var_dump($data['rows']);
	    $this->view->data =$data;
	    $this->view->node_name = Modules_Admin_Models_NodeKind::init()->getAllNodeName();
	    
	    $this->view->isOkUrl = url($this->c,'isOkAction');
	    $this->view->orderUrl = url($this->c,'orderAction');
	    $this->tpl();
	    
	}
 
 
	
}