<?php

/**
 * 文档上传
 * @author michael
 *
 */
class Controllers_Upload extends Controllers_Base
{
 
    function __construct ()
    {
        parent::__construct();
        $sid = $this->getVar('PHPSESSID');
        if ($sid) {
            // flash 上传时要重先注册session_id
            if (session_id() != $sid) {
                session_destroy();
                session_id($sid);
                session_start();
            }
        }
        // 判断用户是否登录
        if (! is_login()) {
            if ($this->getVar('is_jsonp')) {
                $this->renderJsonpData(array(
                        'status' => '0',
                        'msg' => '请先登录!'
                ));
            }elseif(Cola_Request::isAjax()){
                $this->echoJson('login', '请先登录!');
            } else {
                $this->tologin();
            }
        }
    }
    
    function isLoginAction(){
        if(is_login()){
            $this->renderJsonpData(array(
                        'status' => '1',
                        'msg' => '已经登录',
                        'sid' => session_id(),
                ));
        } 
    }
    /**
     * 跳到登录页面
     */
     function tologin ()
    {
        $index = new Models_Index();
        $c = Cola::getInstance();
        $path = $c->getDispatchInfo();
        $c = str_replace("Controllers_", "", $path['controller']);
        $a = str_replace("Action", "", $path['action']);
        $parme = http_build_query($this->get());
        $c_url = HTTP_DODOWENKU . "/$c/$a?$parme";
        $url = $index->getOauthUrl($c_url);
        $this->redirect('/index');
    } 

    /**
     * 打开上传页面
     */
    function indexAction ()
    {
         
        $this->view->page_title = '资源文件上传';
        
        $obj_type = $this->getVar('obj_type');
        $obj_id = $this->getVar('obj_id');
        
        //var_dump($_SESSION);
         
        
        //资源分类，1.指定人员才可以上传标准资源，2。普通用户只可以到学科
        $this->view->get_node_url = url($this->c, 'echoNodeJsonAction');
         
        
        $this->view->css = array(
                'upload/css/index.css',
                //'esui/themes/default/easyui.css',
                //'esui/themes/icon.css',
        );
        $this->view->js = array(
                'script/swfupload/swfupload.js','script/app.js','syup/syup.js','upload/script/resUpload.js'
                
        );
        $this->view->sid = session_id();
        
        $this->view->resource_type = Cola::getConfig('_resourceType');
        $this->view->file_type = json_encode(Cola::getConfig('_resourceFileType'));
        
        $this->view->obj_type = $obj_type;
        $this->view->obj_id = $obj_id;
        $this->view->vars = get_defined_vars();
        
        $this->setLayout($this->getCurrentLayout('index.htm'));
        $this->tpl();
    }
    /**
     * 返回节点json
     */
    public function echoNodeJsonAction(){
        $id = $this->getVar('id',0);
    	$data = Modules_Admin_Models_NodeKind::init()->getAllList(1, 5000,$id);
    	$this->view->data =$data;
    	$this->abort($data['rows']);
    	//$this->tpl();
    }
    /**
     * 返加节点html
     */
    public function echoNodeHtmlAction(){
        $id = $this->getVar('id',0);
    	$data = Modules_Admin_Models_NodeKind::init()->cached('getAllList',array(1, 5000,$id),900);
    	$this->view->data =$data['rows'];
    	//$this->tpl();
    	if(Cola_Request::get('callback')){
    	    $content =$this->tpl('','',1);
    	    $this->renderJsonpData($content);
    	    //$this->echoJson('success', $content);
    	}else{
    	    $this->tpl();
    	}
    	
    }
    

    /**
     * 返回基础节点的节点信息
     */
    function base_nodeAction ()
    {
        $b = new Models_Base();
        $id = (int) v('fid');
        $arr1 = $b->get_sub($id);
        $arr2 = $b->count_sub_num($id);
        foreach ($arr1 as $k => $v) {
            $arr1[$k]['c'] = $arr2[$v['id']];
        }
        $this->abort($arr1);
    }

    /**
     * 获取知识节点,树形数组
     */
 /*    function get_knAction ()
    {
        $ct0 = $this->getVar('ct0');
        $ct1 = $this->getVar('ct1');
        $ct2 = $this->getVar('ct2');
        $ct3 = $this->getVar('ct3');
        $kn = new Models_Know();
        $kn_data = $kn->get_know($ct0, $ct1, $ct2, $ct3, null);
        $tree_data = $kn->get_tree($kn_data);
        $this->abort($tree_data);
    } */

    /**
     * 将上传信息保存到文库表,同时生成队列
     */
   /*  function upload_postAction ()
    {
        $this->upload();
        $this->abort(array(
                'msg' => '提交成功',
                'errorno' => 1
        ));
    } */

    

    /**
     * 删除未提交的临时文件
     */
    function del_tmpAction ()
    {
        //@fastcgi_finish_request();
        $tmp = $this->getVar('tmp', array());
        foreach ($tmp as $v) {
             unlink($v);
        }
    }

    /**
     * 删除单个文件
     */
    function delTmpAction ()
    {
        $tmp_files = $_SESSION['tmp_file'];
        if ($tmp_files) {
            foreach ($tmp_files as $tmp) {
                if (file_exists($tmp)) {
                    // unlink($tmp);
                }
            }
        }
        $this->renderJsonpData(array(
                'status' => 1,
                'msg' => $tmp_files
        ));
    }


    function resUploadPostAction ()
    {
        $post = $this->getVar();
        $post = $post['data'];
        //var_dump($post);die;
        $is_jsonp = $this->getVar('is_jsonp');
        $up = new Models_Upload();
        // var_dump($post);
        $tips = array(
                'status' => 1,
                'msg' => '上传成功'
        );
        
        // 判断是否有文件
        if (! $post['file']) {
            $tips = array(
                    'status' => 0,
                    'msg' => '没有找到上传的文件'
            );
            $this->renderJsonpData($tips);
            exit();
        }
        //检查资源名称是否重复
        if(Models_Resource::init()->checkResourceTitle($post['doc_title'], $this->user_info['user_id'])){
            $this->renderJsonpData(array('status'=>0,'msg'=>'同名资源文件已经存在'));
        }
        // 取文件信息
        $files = array();
        
        $temp = explode(';', $post['file']);
        foreach ($temp as $key => $tmp) {
            list ($file_path, $file_name) = explode(',', $tmp, 2);
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $cate_id = $post['cate_id']?$post['cate_id']:1;
            // 判断文件类型是否正确
            if (! $up->checkFileType($cate_id, $file_ext)) {
                continue;
            }
            // die;
            $files[$key]['file_name'] = $file_name;
            $files[$key]['file_path'] = $file_path;
            $files[$key]['file_ext'] = $file_ext;
        }
        // var_dump($files);
        if (empty($files)) {
            $tips = array(
                    'status' => 0,
                    'msg' => '资源文件的类型不符合要求'
            );
            // var_dump($tips);
            if ($is_jsonp) {
                $this->renderJsonpData($tips);
            } else {
                $this->messagePage('/upload', $tips['msg']);
            }
        }
        
        //通过node_id 找出xd,xk 的code
        if(!$post['xd'] and $post['node_id']){
            $node_arr = Models_Node::init()->getParentCodeById($post['node_id']);
            $post = array_merge($post, $node_arr);
        }
        
        //$post['node_id']>80000 or
        if(!isset($post['zs']) and $post['node_id']){
            
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


        if(!$post['cate_id']){
            $post['cate_id'] = 1;
        }
        $post['attr'] = 1;
       
       //  var_dump($post['pid_path']);die;
        $res = $up->uploadData($files, $post);
         
        if(isset($res['status'])){
            if(Cola_Request::isAjax() or Cola_Request::get('callback')){
                $this->renderJsonpData($res);
            }
            $this->messagePage('/upload',$res['msg']);
        }
        // die;
        if ($is_jsonp or Cola_Request::isAjax()) {
            $this->renderJsonpData(array(
                    'status' => 1,
                    'msg' => $res
            ));
        } else {
            $this->messagePage('/upload', '上传成功！');
        }
    }

    /**
     * 资源文件上传，返回临时文件地址
     */
    function resUploadAction ()
    {
        $data = array();
        if (count($_FILES) > 0) {
            foreach ($_FILES as $value) {
                $file_path = $value['tmp_name'];
                $fileExt = pathinfo($value['name'], PATHINFO_EXTENSION);
                $file_path2 = $value['tmp_name'] . '.' . $fileExt;
                $file_size = $value['size'];
                if (is_uploaded_file($file_path)) {
                    move_uploaded_file($file_path, $file_path2);
                }
                $files[$file_path2] = $value['name'];
                
                $data['size'] = $value['size'];
                $data['file_path'] = $file_path2;
                $data['file_name'] = $value['name'];
                $this->abort($data);
            }
        }
        $this->abort($data);
    }
    /**
     * 生成上传表单
     */
     function uploadAction(){
        if(!$_FILES['file1']['size']){
            $this->echoJson('error', '文件大小不能为空');
        }
        $frm_id = $this->getVar('frm_id');
        $fileName = $_FILES['file1']['name'];
        $fileExt = pathinfo($fileName,PATHINFO_EXTENSION);
 
        if(!Models_Upload::init()->checkFileType('1', $fileExt)){
        	$this->echoJson('error', '文件类型不对');
        }
        
        $file_path = $_FILES['file1']['tmp_name'];
        $file_path2 = $_FILES['file1']['tmp_name'].'.'.$fileExt;
        $file_size = $_FILES['file1']['size'];
        if(is_uploaded_file($file_path)){
            move_uploaded_file($file_path, $file_path2);
        }else{
            $this->echoJson('error','文件上传失败');
        }
        //第一节点
        $id = $this->getVar('id',0);
        $data = Modules_Admin_Models_NodeKind::init()->cached('getAllList',array(1, 5000,$id),900);
        $this->view->data =$data['rows'];
        
        
        $title_name =  substr($fileName,0, strlen($fileName)-(strlen($fileExt)+1));
        $resource_type = Cola::getConfig('_resourceType');
        $this->view->resource_type = $resource_type;
        $this->view->vars = get_defined_vars();
        $content =$this->tpl('Upload/form','',1);
        $this->echoJson('success', $content);
    } 
    /**
     * 第三方组件上传后生成的from
     */
     function vuploadAction(){
        if(!$_FILES['file1']['size']){
            $this->echoJson('error', '文件大小不能为空');
        }
        $frm_id = $this->getVar('frm_id');
        $fileName = $_FILES['file1']['name'];
        $fileExt = pathinfo($fileName,PATHINFO_EXTENSION);
 
        if(!Models_Upload::init()->checkFileType('1', $fileExt)){
        	$this->echoJson('error', '文件类型不对');
        }
        
        $file_path = $_FILES['file1']['tmp_name'];
        $file_path2 = $_FILES['file1']['tmp_name'].'.'.$fileExt;
        $file_size = $_FILES['file1']['size'];
        if(is_uploaded_file($file_path)){
            move_uploaded_file($file_path, $file_path2);
        }else{
            $this->echoJson('error','文件上传失败');
        }
        //第一节点
        $id = $this->getVar('id',0);
        $data = Modules_Admin_Models_NodeKind::init()->cached('getAllList',array(1, 5000,$id),900);
        $this->view->data =$data['rows'];
        
        
        $title_name =  substr($fileName,0, strlen($fileName)-(strlen($fileExt)+1));
        $resource_type = Cola::getConfig('_resourceType');
        $this->view->resource_type = $resource_type;
        
        $this->view->obj_id = $this->getVar('obj_id');
        $this->view->obj_type = $this->getVar('obj_type');
        $this->view->cus_id = $this->getVar('cus_id');
        $this->view->is_xb = $this->getVar('is_xb');
        
        
        //获取自定义菜单
        $cus_cate = Models_CusCate::init()->getCate($this->view->obj_id, $this->view->obj_type);
        $this->view->cus_cate = $cus_cate;
        
        $this->view->vars = get_defined_vars();
        $content =$this->tpl('Upload/vform','',1);
        $this->echoJson('success', $content);
    } 
    function vlistAction(){
        
        $page = $this->getVar('page',1);
        $cus_id = (int)$this->getVar('cus_id');
        $obj_id = $this->getVar('obj_id');
        $obj_type = $this->getVar('obj_type');
        $doc_title = $this->getVar('key');
        $limit = $this->getVar('limit',5);
        
        $this->view->page = $page;
        $this->view->cus_id = $cus_id;
        $this->view->obj_id = $obj_id;
        $this->view->obj_type = $obj_type;
        $this->view->key = $doc_title;
        $this->view->status = Models_Resource::$doc_status;
        
        $data = Models_Resource::init()->getResourceByObj($obj_id, $obj_type, $cus_id,$doc_title,$page,$limit);
        //var_dump($data);die;
        $this->view->data = $data['rows'];
        
        $pager = new Cola_Com_Pager($page,$limit,$data['total'],STATIC_PATH.Cola_Model::init()->getPageUrl(),1);
        $this->view->pagehtml = $pager->html();
       // var_dump($this->view->pagehtml);die;
        $this->view->vars = get_defined_vars();
        $content =$this->tpl('Upload/vlist','',1);
        //$this->echoJson('success', $content);
        $this->renderJsonpData($content);
    }
    
    

    
    /**
     * 资源子节点
     */
    function nodeAction ()
    {
        $b = new Models_Node();
        $id = (int) $this->getVar('fid');
        $is_jsonp = (int) $this->getVar('jsonp');
        $arr1 = $b->getSubNode($id);
        $node = Models_Public_Node::getAllNode();
        $arr = array();
        foreach ($arr1 as $k => $v) {
            $arr[$v['id']][$v['code']] = $node[$v['code']];
        }
        
        $this->renderJsonpData($arr);
    }

    /**
     * 取单元节点
     */
    function unitAction ()
    {
        $is_jsonp = (int) $this->getVar('jsonp');
        $xd = $this->getVar('xd');
        $xk = $this->getVar('xk');
        $bb = $this->getVar('bb');
        $nj = $this->getVar('nj');
        $res = Models_Unit::init()->getUnit($xd, $xk, $bb, $nj, 'option');
        $this->renderJsonpData($res['rows']);
    }
}

