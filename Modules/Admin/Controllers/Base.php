<?php

/**
 * 后台的基础控制器，其它控制器必须继承
 * 
 * @author michaeltsui98@qq.com  2014-04-17
 *
 */


class Modules_Admin_Controllers_Base extends  Controllers_Base {
	
    
    
    public $html;
    
    /**
     * 前置执行Action
     */
    public function adminBefore()
    {
        
        // 如果用户没有登录，或者没有选择学科，退出到登录界面
        if(!isset($_SESSION['admin_user']) ){
            $this->redirect('/admin/sign');
            die;
        }
        
        $user = $_SESSION['admin_user'];
        /* 后台菜单列表 */
        $menu = Modules_Admin_Models_SysModule::init()->getMenu($user['user_group_id']);
        //var_dump($menu);
        $this->view->c = $this->c;
        $this->view->a = $this->a;
        $this->view->menu = $menu;
        $this->view->user = $user;
        //后台数据生成请求地址
        $this->view->getJsonDataUrl  = url($this->c, 'jsonAction');
        //后台添加数据的url
        $this->view->addUrl  = url($this->c, 'addAction');
        $this->view->addDoUrl  = url($this->c, 'addDoAction');
        //后台修改数据的url
        $this->view->editUrl  = url($this->c, 'editAction');
        $this->view->editDoUrl  = url($this->c, 'editDoAction');
        //后台删除数据的url
        $this->view->delUrl  = url($this->c, 'delAction');
    }
    
    /**
     * 获取当前请求的Action的信息
     * @return array
     */
    function getComment(){
        $cola = Cola::getInstance()->getDispatchInfo();
        $rc = new ReflectionClass($cola['controller']);
         
        $fundoc = $rc->getMethod($cola['action'])->getDocComment();
        $clsdoc = $rc->getDocComment();
    
        //$fundoc = trim(substr($fundoc, 11,-2));
        preg_match('/\*[\s]+?([^ ]+)\n/i', $fundoc,$fat);
        preg_match('/@var[\s]*([^ ]+)\n/i', $clsdoc,$mat);
        $data['controller'] = $cola['controller'];
        $data['c']  = substr($cola['controller'], 12);
        $data['action']  = $cola['action'];
        $data['a'] = substr($cola['action'], 0,-6);
        $data['clsdoc'] = trim($mat[1]);
        $data['fundoc'] = trim($fat[1]);
        return $data;
    }
    /**
     * 生成系统操作日志
     * @param string $msg
     */
    function sysLog($msg=NULL){
        $info = $this->getComment();
        $prefix = $info['clsdoc'].'/'.$info['fundoc'].'/';
        $data['log_msg'] = $prefix .$msg;
        $data['module_controller']  = $info['c'];
        $data['module_action']  = $info['a'];
        $data['uid'] = $_SESSION['user']['uid'];
        $data['user_name']  =  $_SESSION['user']['real_name'];
        $data['log_time'] = $_SERVER['REQUEST_TIME'];
        $model = new Models_Admin_Log;
        $model->insert($data);
    }
    
	public function __construct(){
		parent::__construct();
		$this->adminBefore();
	}
	
	public function page($page,$limit,$count,$ajax){
	    $url = Cola_Model::init()->getPageUrl();
	    $pager = new Cola_Com_Pager($page, $limit, $count, $url, $ajax);
	    return $html = $pager->html();
	}
	
 
	
	/**
	 * easyUI ajax 刷新页面
	 * @param string $table_id  table id="user-dg"  取 user
	 * @param string $status
	 * @param string $message
	 */
	public function flash_page($table_id,$status,$message=null,$type=null){
		null===$message and $message = '操作成功';
		if($type!=null){
		    //刷新treegrid
			$arr = array('status'=>$status,'message'=>$message,'success_callback'=>"ajax_flash('$table_id','$type');");
		}else{
		    //刷新datagrid
			$arr = array('status'=>$status,'message'=>$message,'success_callback'=>"ajax_flash('$table_id');
			   $.messager.show({
                title:'Tips info',
                msg:'$message',
                showType:'show'
            });");
		}
		$this->abort($arr);
	}
	
	public  function alert_page($message){
	    $arr = array('status'=>1,'message'=>$message,'success_callback'=>"$.messager.alert('Tips info','$message','info');");
	    $this->abort($arr);
	}
		
} 