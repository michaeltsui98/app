<?php

/**
 * cms栏目管理
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_CmsColumn extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = 'Cms栏目管理-列表';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }

	    $this->tpl();
	}
	/**
	 * 添加
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
        $res = Orm_CmsColumn::create($data);
        Modules_Admin_Models_CmsColumn::init()->updatePidPath($res->id);
		$this->flash_page('cms_column', $res,'添加成功',1);
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
	 * 编辑
	 */
	public  function editAction(){
		$id = $this->getVar('id');
		$info = Orm_CmsColumn::find($id)->toArray();
		$this->view->info = $info;
		$this->view->id = $id;
		$this->tpl();
	}
	/**
	 * 保存编辑
	 */
	public  function editDoAction(){
		$id = $this->getVar('id');
		$data = array();
		$data = $this->getVar('data');
		 
		$res = Orm_CmsColumn::find($id)->update($data);

		$this->flash_page('cms_column', $res,null,1);
	}
	/**
	 * 设置用户组状态
	 */
	public function isOkAction(){
		$id = $this->get('id');
		$ok = $this->get('ok');

        $res = Orm_CmsColumn::where("id",'=',$id)->update(array('is_ok'=>$ok));
		$this->flash_page('cms_column', $res,null,1);
	}

	/**
	 * 删除 
	 */
	public function delAction(){
        $id = $this->get('id');
        $columns = Modules_Admin_Models_CmsColumn::init();
        $sql = "DELETE a.*,b.*,c.*  FROM `cms_column` a left join cms_relate b
                on a.id = b.column_id
                left join cms_content c
                on c.relate_id = b.id
                where a.id = %d";
        if(is_array($id)){
            foreach($id as $v){
                //删除数据库
                $res = $columns->sql(sprintf($sql,$v));
            }
        }elseif(is_string($id)){
            //删除数据库
            $res = $columns->sql(sprintf($sql,$id));
        }
        $this->flash_page('cms_column', $res,null,1);
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    //$rows =  $this->getVar('rows',20);
	    $pid = $this->getVar('id',0);
	    //$is_ok = $this->getVar('is_ok',true);

        $data =  Modules_Admin_Models_CmsColumn::init()->getList($page, 500 ,$pid);
	    
	   // var_dump($data['rows']);
	    $this->view->data =$data;

	    
	    $this->view->isOkUrl = url($this->c,'isOkAction');
	    //$this->view->orderUrl = url($this->c,'orderAction');
	    $this->tpl();
	    
	}
 
 
	
}