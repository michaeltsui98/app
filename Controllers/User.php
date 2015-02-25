<?php
/**
 * 我的文档
 * @author daishijiang
 *
 * @copyright  Copyright (c) 2013 Wuhan Bo Sheng Education Information Co., Ltd.
 *
 */
class Controllers_User extends Controllers_Base
{
    
    function __construct(){
        parent::__construct();
        //判断用户是否登录
        if(!is_login()){
            $this->redirect('/');
        }
        $this->layout = $this->getCurrentLayout('index.htm');
    }
    /**
     * 我的文库
     */
    function indexAction(){
        
        $this->view->page_title = "我的资源中心";

        $this->view->cus_id = $cus_id =  $this->getVar('cus_id',0);
        $this->view->source = $source = $this->getVar('source','upload');
        $this->view->cate_id = $cate_id= $this->getVar('cate_id',0);
        $this->view->key = $key = $this->getVar('key');

        $user_id = $_SESSION['user']['user_id'];

        $xd_info = Models_Circle::init()->getCurClassSchoolByUserId($user_id);
        $this->view->user_info += $xd_info;

        //资源编辑上传要用的到的参数
        $this->view->sid = session_id();
        $this->view->file_type = Cola::getConfig("_resourceFileType")[1];

        //资源类型
        $this->view->resource_type = Cola::getConfig('_resourceType') ;
        //用户资源自定义分类
        $cus_cate = Models_CusCate::init()->getCate($user_id,'user');
        $this->view->cus_cate = $cus_cate['rows'];
        $page = $this->getVar('page',1);
        $limit = 20;
        //取用户资源
        $res = Models_CusUserResource::init()->getUserResource($user_id,$cus_id,$cate_id,$source,$key,$page,$limit);
        $this->view->resources = (array) $res['rows'];
        $total = $res['total'];
        //var_dump($res);die;
        $pager = new Cola_Com_Pager($page, $limit, $total, Cola_Model::init()->getPageUrl());
        $this->view->page_html = $pager->html();

        //资源状态
        $this->view->status = Models_Resource::$doc_status;
        $this->view->color = Models_Resource::$status_color;
        $this->view->source_arr = array('upload'=>'上传','down'=>'下载','fav'=>'收藏');

        $this->view->resource_list = $this->resourceList();

        $this->view->css = array('myresource/css/index.css','upload/css/index.css');
        $this->view->js = array('script/dialog.js','myresource/script/my_search.js','syup/syup.js','myresource/script/my_list.js');
        $this->setLayout($this->layout);
        $this->tpl();
    }
    /**
     * 资源列表,对应不同的模板
     */
    public function resourceList(){

        $cate_id = $this->view->cate_id;
        //资源数据对应不同的模板输出
        //if($cate_id==1 or $cate_id==2 or $cate_id==3){  //文档
         //   $tpl_name = "views/User/mydocList.htm";
        //}elseif($cate_id==4  or $cate_id== 0){  //素村
            $tpl_name = "views/User/myfileList.htm";
        //}
         
        return $this->tpl($tpl_name,'',true);
    
    }
    /**
     * 删除资源,删除我上传的，删除我下载的，删除我收藏的
     */
    public function delAction(){
    	$s  = $this->getVar('s');
    	$id = $this->getVar('id');
    	$user_id = $this->user_info['user_id'];
    	
    	if($s=='upload'){
    		$res = Models_Resource::init()->delMyUploadResource($user_id, $id);
    	}elseif($s=='down'){
            $res =  Models_User_Down::init()->del($user_id,$id);
    	}elseif($s=='fav'){
            $res = Models_Fav::init()->del_fav($user_id,$id);
    	}
    	
        $this->echoJson('success', '删除成功',array($res));
    }
    
    /**
     * 开打编辑页
     */
    public function editResoruceAction(){
        $id  = $this->getVar("id");
        $this->view->id = $id;
        $this->view->resource_type = Cola::getConfig('_resourceType');
        
        //初始化第一级菜单
        $data = Modules_Admin_Models_NodeKind::init()->cached('getAllList',array(1, 5000,0),900);
        $this->view->data =$data['rows'];
        
        //取资源信息
        $info = Models_Resource::init()->cached('get_doc_info',array($id),900);
        $this->view->info = $info;
        //var_dump($info);die;
        $this->view->uid = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'';
        $this->view->user_name = isset($_SESSION['user']['user_realname'])?$_SESSION['user']['user_realname']:'';

        //初始化分类菜单
        $node_arr = Models_Node::init()->getParentCodeById($info['node_id']);
        if($node_arr['xd']){
             $node_names = Models_Node::init()->getNodeName(array_values($node_arr));
             $node_name = implode('&gt;', $node_names);
             //初始化第二级菜单，并确认，一级菜单的选中项
             $this->view->select = $this->getIdByCode($node_arr['xd'], $data['rows']);
            // var_dump($this->view->select);die;
             if($this->view->select){
                 $data1 = Modules_Admin_Models_NodeKind::init()->getAllList(1, 500,$this->view->select);
                 $this->view->data1 =$data1['rows'];
             }
             //三级菜单，及选中
             $this->view->select1 = $this->getIdByCode($node_arr['xk'], $data1['rows']);
             
             if($this->view->select1){
                 $data2 = Modules_Admin_Models_NodeKind::init()->getAllList(1, 500,$this->view->select1);
                 $this->view->data2 =$data2['rows'];
             }
             //四级菜单及选中
             $this->view->select2 = $this->getIdByCode($node_arr['bb'], $data2['rows']);
             
             if($this->view->select2){
                 $data3 = Modules_Admin_Models_NodeKind::init()->getAllList(1, 500,$this->view->select2);
                 $this->view->data3 =$data3['rows'];
             }
             $this->view->select3 = $this->getIdByCode($node_arr['nj'], $data3['rows']);
        }elseif($info['node_id']>80000){
        	$node_names = Models_Node::init()->getParentCateById($info['node_id']);
        	if(!empty($node_names)){
                $node_name = $node_names['pname'].'&gt;'.$node_names['sname'];   	
        	}else{
                $node_name = "请选择分类";   	
        	}
        	$this->view->select = $node_names['pid'];
        	$this->view->select1 = $node_names['sid'];
        	$data1 = Modules_Admin_Models_NodeKind::init()->getAllList(1, 500,$node_names['pid']);
        	$this->view->data1 =$data1['rows'];
        }else{
            $node_name = "请选择分类";
        }
        $this->view->node_name =$node_name;
        //var_dump($this->view->data3);die;
        
        
        $this->tpl();
    }
    
    public function getIdByCode($code,$data){
        if(!$code){
        	return false;
        }
            
    	foreach ($data as $v){
    		if($v['code']==$code){
    			return $v['id'];
    		}
    	}
    }
    
    /**
     * 编辑保存
     */
    public function editPostAction(){
        $id = (int)$this->getVar('id');


        $file = $this->post('file');
        if(!$id){
            $this->echoJson('error', '编辑参数错误');
        }
        $data = $this->post('data');
        $data['attr'] = 1;
        $tags = $this->post('tags');
        if(!empty($tags)){
            $data['tags'] = $tags;
        }


        $res = Models_Resource::init()->editResource($id, $data,$file,false);
        Models_Resource::init()->unSetCache('get_doc_info',array($id));

        $this->echoJson('success','提交成功',$res);

    }

    /**
     * 添加自定义分类
     */
    public  function  add_cusAction(){
        $this->tpl();
    }

    /**
     * 保存自定义分类
     */
    public  function  add_cusDoAction(){
        $user_id = $this->user_info['user_id'];
        $name = $this->getVar('name');
        if(!$name){
            $this->echoJson('error','分类名称不能为空');
        }
        $res = Models_CusCate::init()->addCate($name,0,$user_id,'user');
        $this->echoJson('success','添加成功',array($res));
    }

    /**
     * 删除自定义分类
     */
    public  function del_cusAction(){
        $id = $this->getVar('cus_id');
        $res = Models_CusCate::init()->del($id);
        if($res){
            $this->echoJson('success','删除成功');
        }else{
            $this->echoJson('error','删除失败,该分类下面有资源存在,请先删除');
        }
    }

    /**
     * 设为公开
     */
    public  function  set_publicAction(){
        $id = $this->getVar('id');
        $user_id = $this->user_info['user_id'];
        $data = array('is_hidden'=>0);
        $res = Models_Resource::init()->sql("update resource set is_hidden=0 where doc_id = '$id' and  uid = '$user_id' and is_ok=1 ");
        if($res){
             Models_Resource::init()->update_index($id,$data);
             $this->echoJson('success','设置成功');
        }else{
            $this->echoJson('error','您的没资源没有通过审核，不能设为公开');
        }
    }

    /**
     * 设置资源分类
     */
    public  function  moveCusAction(){
        $doc_id = $this->getVar("doc_id");
        $cus_id = $this->getVar("cus_id");
        $data = array('cus_id'=>$cus_id,'doc_id'=>$doc_id,'created_at'=>$_SERVER['REQUEST_TIME']);
        $count = Models_CusUserResource::init()->count("cus_id = '$cus_id' and doc_id = '$doc_id'");
        if($count){
            $this->echoJson('error','该分类下已经有这个资源了');
        }
        $res = Models_CusUserResource::init()->insert($data);

        $this->echoJson('success','设置分类成功',array($res));

    }



    
}

