<?php

/**
 * 后台知识节点树管理
 * 
 * @author michaeltsui98@qq.com 2014-05-12
 *
 */
class Modules_Admin_Controllers_Unit extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源知识节点树管理-列表';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    
	    $this->view->get_node_url = url('Modules_Admin_Controllers_Node', 'jsonAction');
	    $this->view->import_url = HTTP_DODOWENKU.url($this->c, 'importAction');
	    $this->tpl();
	}
	/**
	 * 添加
	 */
	public  function addAction(){
		 
	    $node_id = $this->getVar('node_id');
        if(!$node_id){
        	echo '请选择年级';
        	return false;
        }
        $fid = (int)$this->getVar('fid');
        $this->view->fid = $fid;
        $node_arr = Models_Node::init()->getParentCodeById($node_id);
        if(!isset($node_arr['nj'])){
            echo '请选择年级';
            return false;
        }
        $arr =  Models_Unit::init()->getUnit($node_arr['xd'], $node_arr['xk'], $node_arr['bb'], $node_arr['nj'],'option',$fid);
        $this->view->node_arr = $arr['rows'];
        /* $fcode = $this->view->code = (int)Models_Unit::init()->count("xd= '{$node_arr['xd']}' and xk='{$node_arr['xk']}' and bb='{$node_arr['bb']}' and nj='{$node_arr['nj']}' and node_fid = {$fid} ");
        if($fid){
            $code = $fcode +1;
            $this->view->code = $fcode.'.'.$code ;
        }else{
        	$this->view->code = $fcode+1;
        } */
        $this->view->get_node_url = url('Modules_Admin_Controllers_Node', 'jsonAction');
	    $this->view->node_id = $node_id;
	    $this->tpl();
	}
	
	public  function addDoAction(){
	    
	    $node_id = $this->getVar('node_id');
	    $node_arr = Models_Node::init()->getParentCodeById($node_id);
	    if(!isset($node_arr['nj'])){
	        $this->alert_page('选择的年级没有找到');
	        return false;
	    }
	    //$arr =  Models_Unit::init()->getUnit($node_arr['xd'], $node_arr['xk'], $node_arr['bb'], $node_arr['nj']);
	    
		$data = $this->getVar('data');
		$data = array_merge($data,$node_arr);
		
		$res = Modules_Admin_Models_UnitNode::init()->insert($data);
		Modules_Admin_Models_UnitNode::init()->updatePidPath($res);
		$this->flash_page('unit', $res,null,'treegrid');
		
	}
	public  function checkNameAction(){
		$name = $this->getVar('param');
		$pid = (int)$this->getVar('pid');
        $arr = array('info'=>'已存在相同的','status'=>'n');		
		$status = Modules_Admin_Models_UnitNode::init()->checkCodeName($name,$pid);
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
        $info = Modules_Admin_Models_UnitNode::init()->load($id);
        $this->view->fid = $info['node_fid'];
        $arr =  Models_Unit::init()->getUnit($info['xd'], $info['xk'], $info['bb'], $info['nj'],'option',$info['node_fid']);
        $this->view->node_arr = $arr['rows'];
		$this->view->info = $info;
		$this->view->id = $id;
		$this->tpl();
	}
	/**
	 * 保存编辑
	 */
	public  function editDoAction(){
		$id = $this->getVar('id');
		$data = $this->getVar('data');
		$res = Modules_Admin_Models_UnitNode::init()->update($id, $data);
		 
		$this->flash_page('unit', $res,null,'treegrid');
	}
	
	public  function getTreeUnitAction(){
		$id = $this->getVar('node_id');
		$res = Modules_Admin_Models_UnitNode::init()->getTreeUnitByNodeId($id);
		$this->abort($res);
	}
	
	
	
	/**
	 * 设置用户组状态
	 */
	public function isOkAction(){
		$id = $this->get('id');
		$ok = $this->get('ok');
		$res  =  Modules_Admin_Models_UnitNode::init()->update($id, array('is_ok'=>$ok));
		$this->flash_page('unit', $res,null,'treegrid');
	}
	/**
	 * 排序
	 */
	public function orderAction(){
		$id = $this->get('id');
		$type = $this->get('type');
		$obj_id = $this->get('obj_id');
		$res  =  Modules_Admin_Models_UnitNode::init()->update($id, array('node_order'=>$obj_id));
		$this->flash_page('unit', $res,null,'treegrid');
	}
	/**
	 * 删除 
	 */
	public function delAction(){
		$id = $this->get('id');
		$ids = $this->get('node_id');
		if($ids){
			foreach ($ids as $id)
			{
			  $res  =   Modules_Admin_Models_UnitNode::init()->delete($id);
			}
		}
		if($id){
		  $res  =  Modules_Admin_Models_UnitNode::init()->delete($id);
		}
		 
		
		$arr = array('status'=>1,'message'=>'删除成功','success_callback'=>"treeload('unit');");
		$this->abort($arr);
		//$this->alert_page('删除成功');
	}
	/**
	 * json数据输出
	 */
	public function jsonAction() {
	     
	    $page =  $this->getVar('page',1);
	    $rows =  $this->getVar('rows',20);
	    $id = $this->getVar('node_id',0);
    	$pid = (int)$this->getVar('id');
	    
	    $data =  Modules_Admin_Models_UnitNode::init()->getAllUnitListByNodeId($id,$pid);
	    
	    
	    $this->view->data =$data;
	    
	    
	    $this->view->isOkUrl = url($this->c,'isOkAction');
	    $this->view->orderUrl = url($this->c,'orderAction');
	    $this->tpl();
	    
	}
	
 
	
	/**
	 * 导入excel
	 */
	public function importAction(){
		
	    $node_id = $this->getVar('node_id');
	    $node_arr = Models_Node::init()->getParentCodeById($node_id);
	    if(!$node_arr['nj'] or !$node_id){
	    	exit('请选择年级');
	    }
	    
        $this->view->node_id = $node_id;
        $this->view->xd = $node_arr['xd'];
        $this->view->xk = $node_arr['xk'];
        $this->view->bb = $node_arr['bb'];
        $this->view->nj = $node_arr['nj'];
        
	    $this->view->import_do_url = url($this->c,'importDoAction');
	    $this->view->import_file_url = HTTP_DODOWENKU.url($this->c,'importFileAction');
	    $this->tpl();
	}
	
	/**
	 * 上传文件
	 */
	public function importFileAction(){
	    
	    $file = $_FILES['Filedata']['tmp_name'];
	    $size = $_FILES['Filedata']['size'];
	    $file_name=$_FILES['Filedata']['name'];
	    if(is_uploaded_file($file)){
	        move_uploaded_file($file, $file);
	    }
	    //$data = array();
	    //$data['size'] = $size ;
	    //$data['file_path'] = $file;
	    //$data['file_name'] = $file_name;
// 	    $this->abort($data);
	    echo $file;die;
	    
	}
	
	/**
	 * 导入保存
	 */
	public function importDoAction(){
	    $row = array();
	    
	    $post = $this->getVar('data');
	    
	    require_once S_ROOT . '/Models/PHPExcel/PHPExcel.php';
	    $PHPExcel = new PHPExcel();
	    //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
	    $PHPReader = new PHPExcel_Reader_Excel2007();
	    $file = $post['file_path'];
	    if (!$PHPReader->canRead($file)) {
	        $PHPReader = new PHPExcel_Reader_Excel5();
	        if (!$PHPReader->canRead($file)) {
	            $this->abort(array('type' => 'error', 'message' => '请使用正确的模板文件'));
	        }
	    }
	    unset($post['file_path']);
	    $PHPExcel = $PHPReader->load($file);
	    // 读取excel文件中的第一个工作表
	    $currentSheet = $PHPExcel->getSheet(0);
	    // 取得最大的列号
	    $allColumn = $currentSheet->getHighestColumn();
	    //取得一共有多少行
	    $allRow = $currentSheet->getHighestRow();
	    
	    //从第二行开始输出，因为excel表中第一行为列名
	    $PHPExcel = $PHPReader->load($file);
	    // 读取excel文件中的第一个工作表
	    $currentSheet = $PHPExcel->getSheet(0);
	    // 取得最大的列号
	    $allColumn = $currentSheet->getHighestColumn();
	    // 取得一共有多少行
	    $allRow = $currentSheet->getHighestRow();
	    
	    // 列对应的字段名称
	    $col_arr = array(
	            'A' => 'node_title',
	            'B' => 'code',
	    );
	    
	    $row_arr = array();
	    for ($r = 2; $r <=$allRow ; $r ++) {
	        $res = array();
	        for ($c = 'A'; $c <= $allColumn; $c ++) {
	            $val = $currentSheet->getCellByColumnAndRow(ord($c) - 65, $r)->getValue();
	            $res[$col_arr[$c]] = $this->_blankTrim($val);
	        }
	        $row_arr[] = $res;
	    }
	    $currentSheet->garbageCollect();
	    $data = array();
	    $res = array();
	    
	    
	    //var_dump($class_all);
	    if(file_exists($file)){
	    	unlink($file);
	    }
	    //var_dump($row_arr,$allColumn);die;
	    //初始化fid的值
	    $init_fid = 0;
	    foreach ($row_arr as $v) {
             //父节点  
	        if(substr($v['node_title'],-2)=="WK"){
	            $node_title = str_replace('WK', '', $v['node_title']);
    	        $node_fid = 0;
	        }else{
	            //字节点
	        	$node_fid = $init_fid;
	            $node_title = $v['node_title'];
	        }
	        $data['node_title'] = $node_title;
	        $data['node_fid'] = $node_fid;
	        $data['code'] = $v['code'];
	        $data['node_order'] = 0;
	        
	        $data = $data+$post;
	        //var_dump($data); 
            $last_id = Models_Unit::init()->insert($data)  ;
            Modules_Admin_Models_UnitNode::init()->updatePidPath($last_id);
	        if($node_fid==0){
              $init_fid = $last_id;
	        }  

	    }
	    
	    $PHPExcel->garbageCollect();
	    $this->flash_page('unit', $res,null,'treegrid');
	    
	    
	}
	
	public  function _blankTrim($str)
	{
	    $str = trim($str);
	    //$str = str_replace(" ", "", $str);
	    //$str = str_replace("　", "", $str);
	    $str = htmlspecialchars($str, ENT_QUOTES);
	    return $str;
	}
 
 
	
}