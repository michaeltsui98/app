<?php

/**
 * 文辑
 * @author michael
 *
 */
class Controllers_Album extends Cola_Controller
{

    /**
     * 文辑浏览页
     */
    function indexAction ()
    {
        $id = $this->getVar('id');
        $page = $this->getVar('page',1);
        $limit = 15;
        $uid = $_SESSION['user']['user_id'];
        $album = new Models_Album();
        
        
        //文辑信息
        $album_info = $album->get_album_info($id);
        
        if(!$album_info){
            $this->messagePage('/','该文辑不存在！',2000);
        }
        
        //浏览数+1
        $cookie_name = "view_album_{$uid}_{$id}";
        $cookie_val = Cola_Request::cookie($cookie_name);
        if(!$cookie_val){
            Cola_Response::cookie($cookie_name,1,time()+3600,"/");
            $album->view_add($id);
        }
        $dd = new Models_DDClient();
        //用户信息
        //$user_info = $dd->searchUserInfo($album_info['uid']);
        
        //文辑内这的文档信息
        $url = get_url();
        $docs_info  = $album->get_album_docs($id, $page, $limit, $url);
        $docs = $docs_info['data'];
        $page = $docs_info['page'];
        $count = $docs_info['count'];
        //文辑评分
        //$remark = $album->album_remark($id);
        $doc = new Models_Doc();
        $star_html = $doc->get_star($album_info['remark']);

        
        //是否收藏
        $is_fav = $album->is_fav($id, $uid);
        
        //相关性文辑
        $relation = $album->relation_album($id);
        
        //判断是否出现删除
        $is_del = ($album_info['uid']==$uid);
        
        
        $this->view->vars = get_defined_vars();
        $this->display('album/index','master/default');
    }
    /**
     * 收藏文辑
     * @return boolean
     */
    function favAction(){
        $id = $this->getVar('id');
        $uid = $_SESSION['user']['uid'];
        if(!$id and !$uid){
            $this->abort(array('msg'=>'收藏参数错误','error'=>-1));
        }
        $album = new Models_Album();
        $is_fav = $album->is_fav($id, $uid);
        if(!$is_fav){
             $album->fav($id, $uid);
             $this->abort(array('msg'=>'收藏成功','error'=>1));
        }else{
            $this->abort(array('msg'=>'已经收藏过了','error'=>-1));
        }
    }
    /**
     * 文辑评分
     */
    function remarkAction(){
        $fs = (int)$this->getVar('fs',0)*2;
        $id = $this->getVar('id');
        $uid = $_SESSION['user']['user_id'];
        $data['uid'] = $uid;
        $data['obj_id'] = $id;
        $data['obj_type'] = 'album';
        $data['total_mark'] = $fs;
        $doc = new Models_Doc();
        $is_mark = $doc->is_mark($uid, $id,'album');
        
        if($is_mark){
            $this->abort(array('msg'=>'已经评论过了','error'=>-1));
        }
        $res = Cola_Model::init()->insert($data,'doc_remark');
        
        $album = new Models_Album();
        $album->mark_add($id,$fs);
        
        
        $this->abort(array('msg'=>'评价成功！','error'=>1));
    }
    /**
     * 删除文集中的文件
     */
    function del_fileAction(){
        $album_id = $this->getVar('album_id');
        $doc_id = $this->getVar('doc_id');
        $album = new Models_Album();
        $res = $album->del_album_info($album_id, $doc_id);
        $this->abort($res);
    }
}

