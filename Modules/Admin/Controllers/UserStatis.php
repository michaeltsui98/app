<?php

/**
 * 用户资源上传信息统计
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_UserStatis extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '教师用户资源统计';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    
 	    //$this->view->getChart1  = url($this->c, 'chart1Action');
	    //$this->view->getChart2  = url($this->c, 'chart2Action');
	    $this->tpl();
	}
	
	/**
	 * 统计数据输出
	 */
	public function jsonAction(){
	    
	    
	    $start_date = $this->getVar('start_date');
	    $end_date = $this->getVar('end_date');
	    if($start_date and $end_date){
	        $where = " and  (FROM_UNIXTIME(a.on_time,'%Y-%m-%d') BETWEEN '$start_date' and '$end_date') ";
	    }
	    
	    $sql = "SELECT a.user_name ,count(a.doc_id) resources ,count(b.file_id) files
        FROM `resource` a left join resource_file b
        on a.file_id = b.file_id
        where a.role_id = 2 $where 
        group by a.user_name
        ;";
	    
	    $data = Cola_Model::init()->sql($sql);
	    $this->view->user = $data;
	    $this->tpl();
	       
	}
	
}