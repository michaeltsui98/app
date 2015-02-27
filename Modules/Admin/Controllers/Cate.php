<?php

/**
 * 基础分类管理
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_Cate extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '基础分类管理-列表';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
        $this->view->get_obj_type_url = url($this->c,'getObjTypeAction');
	    $this->tpl();
	}

    public function getObjTypeAction(){
        $sql = "SELECT obj_id,obj_type FROM `cus_cate` GROUP BY obj_type";
        $data =  Modules_Admin_Models_CusCate::init()->sql($sql);
        $this->abort($data);
    }
	/**
	 * 添加用户组
	 */
	public  function addAction(){
		 
	    $pid = $this->getVar('pid');

	   
	   
	    $this->view->pid = $pid;
	   
	    $this->view->check_code_url = url($this->c, 'checkNameAction');
		$this->tpl();
	}
	
	public  function addDoAction(){
	    $data = array();
		$data = $this->getVar('data');
		$res = Orm_CusCate::create($data);
		Modules_Admin_Models_CusCate::init()->updatePidPath($res->id);
        
		$this->flash_page('cus_cate', 1,'添加成功',1);
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

		$info = Orm_CusCate::find($id)->toArray();
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
		$res = Orm_CusCate::find($id)->update(array_filter($data,function($v){
            return $v != '';
        }));
		$this->flash_page('cus_cate', 1,$res,1);
	}


	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');

        $res = Orm_CusCate::destroy($id);

		$this->flash_page('cus_cate', $res,null,1);
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);

	    $pid = $this->getVar('id',0);

        $obj_type = $this->getVar('obj_type');
        $name = $this->getVar('name');
        $where = '';
        if($obj_type){
            $where  .= " and obj_type = '$obj_type'";
        }
        if($name){
            $where  .= " and name like '%$name%'";
        }

	    $data =   Modules_Admin_Models_CusCate::init()->getList($page, 500 ,$pid,$where);
	    

	    $this->view->data =$data;


	    $this->tpl();
	    
	}
 
 
	
}