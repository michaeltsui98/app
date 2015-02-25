<?php

/**
 * 首页
 * @author michael
 *
 */
class Controllers_Index extends Controllers_Base
{

 
    function __construct ()
    {
        parent::__construct(); 
        $this->layout = $this->getCurrentLayout('index.htm');
    }
    public function topAction() {
        
    	$this->tpl('public/top');
    }
    public function searchAction() {
        //取资源类型
        $resource_type = Cola::getConfig('_resourceType');
        $this->view->resource_type = $resource_type;
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $this->view->key = isset($params['key'])?$params['key']:'';
        $this->view->type = isset($params['type'])?$params['type']:'';
        
        $this->tpl('public/search');
    }
    public function navAction() {
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $id = isset($params['id'])?$params['id']:'';
        $this->view->id = $id;
        $this->view->c = $this->c;
    	$this->tpl('public/nav');
    }
    /**
     * 首页
     */
    function indexAction ()
    {
        $this->view->page_title = "多多资源中心首页";
        
        //最新资源
        $type = $this->getVar('type',1);
        $sm_count = Models_Index::init()->countResource(null, 'GS0024', $type);
        $xl_count = Models_Index::init()->countResource(null, 'GS0025', $type);
        $yw_count = Models_Index::init()->countResource(null, 'GS001', $type);
        $where = " resource_type:$type  AND is_ok:1 AND is_hidden:0 ";
        $top_upload_resource = Models_Search::inits()->indexQuery($where,false,'on_time',false,false,1,15,true);
        //最新动态
       // var_dump($top_upload_resource['data'][0]);
       
        $addRange = array("resource_type" , "1", "6");
        $all_resource = Models_Search::inits()->indexQuery(" * ",false,'on_time',false,false,1,15,true,$addRange);
        $obj = Models_Index::init();
        //var_dump($all_resource['data']);die;
        $users = array_map(array($obj, 'getUserInfo'), $all_resource['data']);
        
        //热门文档
        $hot_doc = Models_Search::inits()->indexQuery(" file_type:doc OR file_type:docx OR file_type:pdf  AND is_ok:1 AND is_hidden:0 ",false,'views',false,false,1,10,true);
       
        //热门ppt
        $hot_ppt = Models_Search::inits()->indexQuery(" file_type:ppt OR file_type:pptx  AND is_ok:1 AND is_hidden:0",false,'views',false,false,1,10,true);
        //热门视频
        $hot_video = Models_Search::inits()->indexQuery(" file_type:mp4 OR file_type:flv  AND is_ok:1 AND is_hidden:0",false,'views',false,false,1,6,true);
        
        //活跃用户排行榜
        $top_users = Models_Index::init()->getTopUser();
         
        
        $this->view->top_users = $top_users;
        $this->view->hot_doc = $hot_doc;
        $this->view->hot_ppt = $hot_ppt;
        $this->view->hot_video = $hot_video;
        
        $this->view->users = $users;
        
        $this->view->sm_count = $sm_count;
        $this->view->xl_count = $xl_count;
        $this->view->yw_count = $yw_count;

        $this->view->all_resource = $all_resource;
        $this->view->top_upload_resource = $top_upload_resource;
        $this->view->type = $type;
        $this->view->css = array('index/css/index.css');
        $this->view->js = array('index/script/index_show.js');
        $this->setLayout($this->layout);
        $this->tpl();
        
    }
    /**
     * 关键字索引
     */
    public function suggestAction(){
        $key = $this->getVar('key');
        $res = (array)Models_Search::inits()->getSearch()->getExpandedQuery($key);
        $this->renderJsonpData($res);
        
    }
    /**
     * 热门搜索词
     */
    public function wordsAction(){
        $words = Models_Search::inits()->getSearch()->getHotQuery(10);
        $this->abort($words);
    }
    
    function testAction(){
        $user_id = 'y41880145309969310087';
        $user = Models_Index::init()->getUserInfo(array('user_id'=>$user_id));
        var_dump($user);
        
        $id = $this->getVar('id',1129);
       	$res = Models_Search::inits()->indexQuery("id:$id");
     	var_dump($res['data'][0]);
    	
    }
    
    /**
     * 登录回调
     */
    function callBackAction(){
        $DDClient = new Models_Client();
        if ($this->getVar('code')) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirectUri'] = DD_CALLBACK_URL;
            if (!isset($_SESSION['tokens']['access_token'])  OR $_GET['remote_login'] == 1) {
                try {
                    $tokens = $DDClient->getAccessToken('code', $keys);
                    $_SESSION['tokens'] = $tokens;
                    if(isset($_SESSION['user']['user_id']) and $_REQUEST['remote_login'] == 1){
                        Cola_Response::redirect('/');die;
                    }
                } catch (Exception $e) {
                    echo $e;
                }
            } else {
                $tokens = $_SESSION['tokens'];
            }
    
            if (! empty($tokens)) {
    
                $_SESSION['user']['uid']  = $_SESSION['user']['user_id'];
                $_SESSION['refUrl'] or $_SESSION['refUrl'] = '/';
                $is_admin = Modules_Admin_Models_SysUser::init()->checkAdminByUid($_SESSION['user']['user_id']);
                if($is_admin){
                    $_SESSION['is_admin']  = $is_admin;
                }
                 
                Cola_Response::redirect($_SESSION['refUrl']);
            }
        } else {
    
            Cola_Response::alert('非法请求',BASE_PATH);
        }
    }
     
}

