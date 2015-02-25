<?php
/**
 * 文档列表页
 * @author michael
 *
 */
class Controllers_List extends Controllers_Base
{
    
    public function indexAction(){
        $xdname = $this->getVar("xdname");
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $id = $params['id'];
        
        $nid = (int)$params['nid'];
        $this->view->nid = $nid;
        $this->view->type = (int)$this->getVar('type');
        $this->view->order = (int)$this->getVar('order',1);
        
        $xd_list = Modules_Admin_Models_NodeKind::init()->cached('getList',array(1, 1000,0),900);
        $xd_arr = array();
        foreach ($xd_list['rows'] as $v){
        	$xd_arr[$v['id']] = $v;
        }
        $this->view->page_title = $xd_arr[$id]['name']."资源列表页";
        $this->view->id = isset($params['id'])?$params['id']:1;
        
        //学科列表
        //$defalut_xk = Modules_Admin_Models_NodeKind::init()->getList(1, 1000,$id);
        $defalut_xk = Modules_Admin_Models_NodeKind::init()->cached('getList',array(1,1000,$id),3600);
        $xk_arr = $defalut_xk['rows'];
        $this->view->xk = isset($params['xk'])?$params['xk']:$xk_arr[0]['id'];

        //版本列表
        $defalut_bb = Modules_Admin_Models_NodeKind::init()->cached('getList',array(1, 1000,$this->view->xk),3600);
        $bb_arr = $defalut_bb['rows'];
        $this->view->bb = isset($params['bb'])?$params['bb']:$bb_arr[0]['id'];
        
        //年级列表
        $defalut_nj = Modules_Admin_Models_NodeKind::init()->cached('getList',array(1, 1000,$this->view->bb),3600);
        $nj_arr = $defalut_nj['rows'];
        $this->view->nj = isset($params['nj'])?$params['nj']:$nj_arr[0]['id'];
        
        //取知识节点
        $code_arr = Models_Node::init()->cached('getParentCodeById',array($this->view->nj),3600);
        $unit = Models_Unit::init()->cached('getUnit',array($code_arr['xd'], $code_arr['xk'], $code_arr['bb'], $code_arr['nj']),3600);
        $this->view->unit = $unit['rows'];
        
        //取资源类型
        $resource_type = Cola::getConfig('_resourceType');
        $this->view->resource_type = $resource_type;
        
        //查询条件
        $query = " node_id:{$code_arr['xd']}  AND  node_id:{$code_arr['xk']} ";
         
        if(isset($code_arr['bb'])){
            $query .= " AND node_id:{$code_arr['bb']} ";
        }
        if(isset($code_arr['nj'])){
            $query .= " AND node_id:{$code_arr['nj']} ";
        }
        
        if($nid){
            $query .= " AND unit_pid_path:{$nid} ";
        }
        
        if($this->view->type==8){
            $query .= "  AND (resource_type:8) ";
        }elseif($this->view->type>0){
            $query .= "  NOT (resource_type:8) AND resource_type:{$this->view->type} ";
        }elseif($this->view->type==0){
            $query .= "  NOT (resource_type:8) ";
        }
        //审核与隐藏的资源不显示
        $query .= "  AND is_ok:1 AND is_hidden:0 ";
        
        //排序条件，默认按时间倒序
        $order = $this->getVar('order',1);
        $this->view->order = $order;
        if($order==1){
            $order_field = 'on_time';
            $asc = false;
        }elseif($order==2){
            $order_field = 'views';
            $asc = false;
        }
        
        //取资源
        $page = $this->getVar('page',1);
        $page_size = 20;
        $resources = Models_Search::inits()->indexQuery($query,true,$order_field,$asc,false,$page,$page_size,true);
       // var_dump($query,$resources);die;
         
        $this->view->resources = $resources['data'];
        
        $this->view->resource_list = $this->resourceList();
        

        $pager = new Cola_Com_Pager($page, $page_size, $resources['count'], Cola_Model::init()->getPageUrl());
        $this->view->page_html = $pager->html();
        
        
        $this->view->xdname = $xdname;
        $this->view->id = $id;
        $this->view->xk_arr = $xk_arr;
        $this->view->bb_arr = $bb_arr;
        $this->view->nj_arr = $nj_arr;
        $this->view->css = array('normalList/css/index.css');
        $this->view->js = array('normalList/script/list.js');
        $this->setLayout($this->getCurrentLayout('index.htm'));
    	$this->tpl();
    }
    
    /**
     * 资源列表,对应不同的模板
     */
    public function resourceList(){
        
        $type = $this->view->type;
        //资源数据对应不同的模板输出
        if($type==1 or $type==2 or $type==3){  //文档
            $tpl_name = "views/List/listDoc.htm";
        }elseif($type==4  or $type== 0){  //素村
            $tpl_name = "views/List/listFile.htm";
        }elseif($type==5 or $type == 6){ //视频
            $tpl_name = "views/List/listVideo.htm";
        }elseif($type==8){
            //背课夹
            //$list_content = $this->bkjList();
        }
        return $this->tpl($tpl_name,'',true);
    }
    /**
     * 非标准资源列表
     */
    public  function nonstandardAction(){
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $id = $params['id'];
        $this->view->page_title = "专业资源";
        //取非专业资源分类
        $cate_list = Modules_Admin_Models_NodeCate::init()->cached('getAllList',array(),900);
        $this->view->unit = $cate_list['rows'];
        
        if(!$params['nid']){
            $params['nid'] = $id;
        }
        
        $query = "";
        if($params['nid']){
            //$query .= " node_id:{$params['nid']}  ";
            $query .= " pid_path:{$params['nid']}  ";
        }
        //审核与隐藏的资源不显示
        $query .= " AND is_ok:1 AND is_hidden:0 " ;




        //排序条件，默认按时间倒序
        $order = $this->getVar('order',1);
        $this->view->order = $order;
        if($order==1){
            $order_field = 'on_time';
            $asc = false;
        }elseif($order==2){
            $order_field = 'views';
            $asc = false;
        }
        
        //取资源
        $page = $this->getVar('page',1);
        $page_size = 15;
        $resources = Models_Search::inits()->indexQuery($query,true,$order_field,$asc,false,$page,$page_size,true);
        //var_dump($query,$resources['data']);die;
         
        $this->view->resources = $resources['data'];
        
        $pager = new Cola_Com_Pager($page, $page_size, $resources['count'], Cola_Model::init()->getPageUrl());
        $this->view->page_html = $pager->html();
        
         
        $this->view->id = $id;
        $this->view->nid = $params['nid'];
        $this->view->css = array('nonstandardlList/css/index.css');
        $this->view->js = array('normalList/script/list.js');
        $this->setLayout($this->getCurrentLayout('index.htm'));
        $this->tpl();
    }
    
}

