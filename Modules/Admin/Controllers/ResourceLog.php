<?php

/**
 * 后台资源管理日志
 * 
 * @author michaeltsui98@qq.com 2014-05-14
 *
 */
class Modules_Admin_Controllers_ResourceLog extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源日志-列表';
	    
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }


	    
	    $this->tpl();
	}



	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');

		if(is_array($id)){
			foreach($id as $v){
				//删除数据库
				$res = Models_Log::init()->delete($v);
			}
		}elseif(is_string($id)){
			//删除数据库
			$res =  Models_Log::init()->delete($id);
		}

		$this->flash_page('resourcelog', $res);
		//$this->alert_page('删除成功');
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);
	    $title = $this->getVar('title');
    	$where = " 1 ";
    	if($title){
    		$where .= " and a.info like '%$title%' ";
    	}
    	$sql = "
				SELECT a.*    FROM `resource_log` a
				LEFT JOIN resource b
				on a.doc_id   = b.doc_id
				where $where  order by a.id desc
                ";
		//var_dump($sql);die;
    	$data =  (array)Models_Resource::init()->getListBySql($sql, $page, $rows);
	    $this->view->data =$data;
		if(!empty($data)){
			$this->tpl();
		} else{
			$this->abort(array());
		}

	}


	 
	
	 
 
	
}