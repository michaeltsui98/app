<?php

/**
 * 非标准分类管理
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_Cate extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '非标准分类管理-列表';
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
	   
	   
	    $this->view->pid = $pid;
	   
	    $this->view->check_code_url = url($this->c, 'checkNameAction');
		$this->tpl();
	}
	
	public  function addDoAction(){
	    $data = array();
		$data = $this->getVar('data');
		//$node_arr = Models_Public_Node::getAllNode();
		//$data['name']  =  $node_arr[$data['code']];
		$res = Modules_Admin_Models_NodeCate::init()->insert($data);
		//$this->alert_page('添加成功');
		Modules_Admin_Models_NodeCate::init()->updatePidPath($res);
		$this->flash_page('cate', 1,'添加成功',1);
	}
	
	public  function checkNameAction(){
		$name = $this->getVar('param');
		$pid = (int)$this->getVar('pid');
        $arr = array('info'=>'已存在相同的','status'=>'n');		
		$status = Modules_Admin_Models_NodeCate::init()->checkCodeName($name,$pid);
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
		 
 
		$info = Modules_Admin_Models_NodeCate::init()->load($id);
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
		 
		$res = Modules_Admin_Models_NodeCate::init()->update($id, $data);
		 
		//$this->flash_page($table_id, $status);
		//ui_tip('', json.message, json.status, success_callback)
		$this->flash_page('cate', 1,null,1);
	}
	/**
	 * 设置用户组状态
	 */
	public function isOkAction(){
		$id = $this->get('id');
		$ok = $this->get('ok');
		$res  =  Modules_Admin_Models_NodeCate::init()->update($id, array('is_ok'=>$ok));
		$this->flash_page('cate', 1,null,1);
	}
	/**
	 * 排序
	 */
	public function orderAction(){
		$id = $this->get('id');
		$type = $this->get('type');
		$obj_id = $this->get('obj_id');
		$res  =  Modules_Admin_Models_NodeCate::init()->update($id, array('node_order'=>$obj_id));
		 
		$this->flash_page('cate', 1,null,1);
	}
	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');
		$res  =  Modules_Admin_Models_NodeCate::init()->delNodeById($id);
		//$this->flash_page('node', $res,null,'treegrid');
		//$this->alert_page('删除成功');
		$this->flash_page('cate', 1,null,1);
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);
	    $pid = $this->getVar('id',0);
	    $is_ok = $this->getVar('is_ok',true);
	    $data =  Modules_Admin_Models_NodeCate::init()->getList($page, 500 ,$pid,$is_ok);
	    
	   // var_dump($data['rows']);
	    $this->view->data =$data;
	    $this->view->node_name = Modules_Admin_Models_NodeCate::init()->getAllNodeName();
	    
	    $this->view->isOkUrl = url($this->c,'isOkAction');
	    $this->view->orderUrl = url($this->c,'orderAction');
	    $this->tpl();
	    
	}
 
 
	
}