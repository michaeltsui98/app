<?php
/**
 * 文档视频预览
 * @author michael
 *
 */
class Controllers_Info extends Cola_Controller
{
 
    /**
     * 详细页
     */
    function indexAction($id=null){
         
        if($id==null){
            $id = $this->getVar('doc_id');
        }
        if(!$id){
            $this->messagePage('/','请求地址不对',2000);
        }
        
        //浏览者uid
        $uuid = $_SESSION['user']['user_id'];
        $this->view->uuid = $uuid;
        

        //var_dump($this->view->base_node);die;
        //资源类型
        $this->view->resource_type = Cola::getConfig('_resourceType');
        //文档信息
        $doc = new Models_Resource();
        $doc_info = $doc->cached('get_doc_info',array($id),(3600*10));

        $is_ok = $doc_info['is_ok'];


        $is_admin = Modules_Admin_Models_SysUser::init()->cached('checkAdminByUid',array($uuid),3600*5);
        if(!$is_admin) {

            if ($is_ok == 2) {
                //没有通过审核的资源只有自己可以看
                if ($uuid != $doc_info['uid']) {
                    $this->messagePage('/', '没有通过审核的资源不能查看', 3000);
                }
            } elseif ($is_ok != 1) {
                //待审核的资源也只有自己可以看
                if ($uuid != $doc_info['uid']) {
                    $this->messagePage('/', '资源正在审核中,暂不能查看', 3000);
                }
            }
        }
        //资源节点
        $this->view->base_node = Models_Node::getAllNode();
        if(strtolower($doc_info['doc_ext_name'])=='flv' or strtolower($doc_info['doc_ext_name']) == 'mp4'){
            $video_info = Models_Video::init()->cached('getInfoByObj',array($doc_info['file_id'],'file'),3600*10);
        }
        //var_dump($doc_info);


        if(isset($video_info['vid']) and $video_info['vid']){
             $this->view->is_yun = true;
             $this->view->video_info  = $video_info;

        }else{
            $this->view->is_yun = false;
        }

        //$doc->clear_doc_info_cache($id);
        if(!isset($doc_info['doc_id'])  and !$doc_info['doc_id']){
            
            //Models_Resource::init()->del_index($id);
        	$this->messagePage('/','资源已经不存在了...',2000);
        }
        $status = array(0=>"转换中",1=>"转换完成",2=>"转换失败",3=>'重复资源');
        if(in_array($doc_info['doc_status'],array(0,2))){
            $doc->unSetCache('get_doc_info',array($id));
        	$this->messagePage('/',$status[$doc_info['doc_status']],1000);
        }
         //上传者uid
        $uid = $doc_info['uid'];
        
        //文档浏览+1,一用户一个小时加一次
        $cookie_name = "view_{$uuid}_{$id}";
        $cookie_val = Cola_Request::cookie($cookie_name);
        if(!$cookie_val){
            Cola_Response::cookie($cookie_name,1,time()+3600,"/");
            $views = $doc->get_doc_val($id);
            $doc->view_add($id,$views);
        }
        
        //获取资源用户信息
        $dd = new Models_Client();
        $user_info = $dd->viewUserInfo($uid);
        
        
         
        //星星的值
        if($doc_info['doc_remarks']){
            $star_val = $doc_info['doc_remark_val']/$doc_info['doc_remarks'];
        }else{
            $star_val = 0 ;
        }
        $doc_star = Models_Resource::init()->get_star($star_val);
        $this->view->doc_star = $doc_star;
        
        //var_dump(function_exists('rar_open'));;die;
        
        
        //是否收藏过了
        //$is_fav = $doc->is_fav($uuid, $id,'doc');
        
        //var_dump($uid,$uuid,$is_fav);die;
        
        //当前用户看到几页了
        /* $mark_page = $doc->get_mark_page($uuid, $id);
        $mark_page OR $mark_page = 1; */
        
        //生成共享地址
        $url = HTTP_DODOWENKU.'/info/'.$id;
        $desc = isset($doc_info['doc_content'])?$doc_info['doc_content']:'';
        $pics = HTTP_MFS_IMG.$doc_info['doc_page_key'];
        $share_url = $doc->get_shar_url($doc_info['doc_title'], $url,$pics, $desc, 1);
        $this->view->pics = $pics;
       /* 
        $this->view->top_title = $doc_info['doc_title'];*/
        $doc_summery = strtr($doc_info['doc_summery'],array(' '=>'',"\r"=>'',"\n"=>'',"\t"=>'',"\r\n"=>''));
    
        $this->view->top_desc = htmlentities($doc_summery,ENT_QUOTES,'UTF-8'); 
        
        //其它分类
        $this->view->cate_name = '';
        if(!$doc_info['xd'] and $doc_info['node_id']){
        	$cate = Models_Node::init()->getParentCateById($doc_info['node_id']);
        	$this->view->cata_name = $cate['pname'].' | '.$cate['sname'];
        } 

       /// var_dump($this->view->cate_name);die;
         
       
        
        
        //资源浏览类型
        $perview_type = Models_Resource::init()->getPerviewType($doc_info['cate_id'], $doc_info['doc_ext_name']);
        $this->view->perview_type =$perview_type;
        
        
        $this->view->swf_url = HTTP_MFS_IMG.$doc_info['doc_swf_key'];
        $this->view->file_url = Cola::$_config->get('_resourceUrl').'/'.$doc_info['file_key'];
        //$rar_file = rar_open($this->view->file_url);
        
        $this->view->info = $doc_info;
        //var_dump($doc_info);
        $this->view->doc = $doc;
        $this->view->user_info = $user_info;
        
        $this->view->share_url = $share_url;

        //相关性资源
        $relate_resource = $this->relateResource(15);
        $this->view->relate_resource = $relate_resource['data'];
        
        //单元节点名称
        $this->view->unit_name = Models_Unit::init()->getUnitNameById($doc_info['nid']);;
        
        
        $this->view->vars = get_defined_vars();
        $this->view->page_title = $doc_info['doc_title'].' - 资源查看';
        $this->view->css = array('detail/css/index.css');
        
        $this->view->js = array('detail/script/detail_preview.js','script/comment.js');
        if($doc_info['cate_id']!=4){
            $this->display('Info/index','layout/index');
            die;
        }elseif($doc_info['cate_id']==4){
            
            $this->redirect('/info/down/id/'.$id);
            die;
        }
    }
    /**
     * 评分页面
     */
    public function remarkAction(){
        $this->tpl();
    }
    /**
     * 相关性资源
     */
    public function relateResource($limit){
        $info = $this->view->info;
        if($this->view->info['xd']){
            $query = " node_id:{$this->view->info['xd']}  AND  node_id:{$this->view->info['xk']} AND node_id:{$this->view->info['bb']} AND node_id:{$this->view->info['nj']} ";
        }else{
        	$query = " node_id:{$this->view->info['node_id']} ";
        }
        $query .= " NOT id:{$this->view->info['doc_id']}  NOT  resource_type:8 ";
        return Models_Search::inits()->indexQuery($query,false,null,false,false,1,$limit);
    }
 
    
    /**
     * 获取swf_key
     */
/*     function get_keyAction(){
        $id = $this->getVar('id');
        //文档信息
        $doc = new Models_Resource();
        $doc_info = $doc->get_doc_info($id);
        $this->renderJsonpData(array('swf_key'=>HTTP_MFS_IMG.$doc_info['doc_swf_key']));
        
    } */
    /**
     * 文档收藏
     */
    function favAction(){
        $id = $this->getVar('id');
        if(!$id){
            $this->renderJsonpData(array('msg'=>'收藏的对象不成在','status'=>-1));
        }
        $doc = new Models_Resource();
        $uid = $_SESSION['user']['user_id'];
        if(!$uid){
            $this->renderJsonpData(array('msg'=>'请登录!','status'=>-1));
        }
        $doc_info = $doc->get_doc_info($id);
        if($uid ==$doc_info['uid']){
            $this->renderJsonpData(array('msg'=>'不能收藏自己的文档','status'=>-1));
        }
        $is_fav = $doc->is_fav($uid, $id,'doc');
        if($is_fav){
            $this->renderJsonpData(array('msg'=>'已经收藏过了','status'=>-1));
        }
        $data['uid'] = $uid;
        $data['obj_type'] = 'doc';
        $data['obj_id'] = $id;
        $data['on_time'] = $_SERVER['REQUEST_TIME'];
        //防止重复收藏
        $count = Cola_Model::init()->table('resource_fav')->count("obj_id = '$id' and obj_type='doc' and uid = '$uid'");
        
        if(!$count){
            $res =  Cola_Model::init()->table('resource_fav')->insert($data);
            $doc->fav_add($id);
        }
        $doc->clear_doc_info_cache($id);
       
        $this->renderJsonpData(array('msg'=>'收藏成功！','status'=>1));
        
    }
    /**
     * 资源浏览+1
     */
    function viewsAction(){
        $id = $this->getVar('id');
        $uuid = $_SESSION['user']['user_id'];
        if(!$id){
            $this->renderJsonpData(array('status'=>0,'msg'=>'参数不对'));
        	return false;
        }
        $doc = new Models_Resource();
        $cookie_name = "view_{$uuid}_{$id}";
        $cookie_val = Cola_Request::cookie($cookie_name);
        if(!$cookie_val){
            Cola_Response::cookie($cookie_name,1,time()+3600,"/");
            $views = $doc->get_doc_val($id);
            $doc->view_add($id,$views);
        }
        $this->renderJsonpData(array('status'=>1,'msg'=>'ok'));
    }
    
    /**
     * 评论
     */
    function mark_postAction(){
        $ff = $this->getVar('zs',0);
        $ty = $this->getVar('ty',0);
        $id = $this->getVar('id');
        $uid = $_SESSION['user']['user_id'];
        if(!$uid){
            $this->renderJsonpData(array('msg'=>'请登录!','status'=>-1));
        }
        $data['uid'] = $uid;
        $data['obj_id'] = $id;
        $data['obj_type'] = 'doc';
        $data['ff'] = $ff;
        $data['ty'] = $ty;
        $doc = new Models_Resource();
        $is_mark = $doc->is_mark($uid, $id,'doc');

        if($is_mark){
            $this->renderJsonpData(array('msg'=>'已经评论过了','status'=>-1));
        }
        $res = Cola_Model::init()->insert($data,'doc_remark');
        $val =(int)$ff+$ty;
        $doc->mark_add($id,$val);
        //取当前分数
        //$cond = array('fileds' => 'doc_remark_val/doc_remarks', 'where' => "doc_id = '$id'");
        $remark_info = $doc->get_count_mark($id, 'doc');
        $remarks = number_format($remark_info['mark'],2);
        //更新评分数索引
        $doc->update_index($id, array('remark'=>$remarks));
        $doc->clear_doc_info_cache($id);
        $this->renderJsonpData(array('msg'=>'评价成功！','status'=>1));
    }
    /**
     * 保存文档翻页的页数
     */
    function go_pageAction(){
        
        $id= $this->getVar('id');
        $p = $this->getVar('p',1);
        if(!$id ){
            return false;
        }
        $uid = $_SESSION['user']['user_id'];
        if(!$uid){
            $this->renderJsonpData(array('msg'=>'请登录!','status'=>-1));
        }
        $doc = new Models_Resource();
        $res = $doc->set_mark_page($uid, $id, $p);
    }
    /**
     * 文档下载
     */
    function downAction(){
        $id = $this->getVar('id');
        $uid = $this->getVar('user_id',$_SESSION['user']['user_id']);
        if(!$id){
            return false;
        }
        $doc = new Models_Resource();
        $doc_info = $doc->get_doc_info($id);
        //$file_info = $doc->get_file_info($doc_info['disk_id'],$doc_info['file_id']);
        //$is_file = $doc->get_file_info($file_info['file_path']);
        $key = $doc_info['file_key'];
        $url = $doc->get_file_url($key, $doc_info['doc_file_name']);
        //var_dump($url);die;
        
        if(!$uid){
            if(!Cola_Request::get('callback') and !Cola_Request::isAjax()){
            	$this->messagePage('/','请先登录!');
            }
            $this->renderJsonpData(array('status'=>-1,'msg'=>'请先登录!'));
        }
        if(!$url){
            if(!Cola_Request::get('callback') and !Cola_Request::isAjax()){
                $this->messagePage('/','要下载的文件找不到了!');
            }
//             $this->abort('原文件已经不存在了');
            //$_SERVER[HTTP_REFERER];
            //$this->messagePage($_SERVER[HTTP_REFERER],'原始文档不存');
            $this->renderJsonpData(array('status'=>-1,'msg'=>'要下载的文件找不到了!'));
            die; 
        }
        //自己下自己的不生成记录
        if($uid == $doc_info['uid']){
          $this->redirect($url);
          die();   
        }
        
        if($url){

            $doc->down_add($id);
            $doc->down_log($uid, $id, $doc_info['doc_credit']);
        }
        $doc->clear_doc_info_cache($id);
        if($this->getVar('app_key')){
            $this->renderJsonpData(array('status'=>'ok','data'=>$url));
        }else{ 
            $this->redirect($url);
        }
        
    }
    
    
}

