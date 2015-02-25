<?php

/**
 * 文档收藏
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Album extends Cola_Model
{

    protected $_pk = 'album_id';

    protected $_table = 'doc_album';
    /**
     * 返回文辑信息
     * @param int $id
     * @return Ambigous <multitype:, boolean>
     */
    function get_album_info($id){
        $sql = "select *,truncate(remarks/remark_num,2) remark from doc_album where album_id = '$id'";
       return $this->db()->row($sql);
    }
    /**
     * 获取文辑下的文档信息
     * @param int $id
     */
    function get_album_docs($id,$page,$limit,$url){
        $sql = "select b.doc_id,b.doc_title, truncate(b.doc_remark_val/b.doc_remarks,2) remark,b.doc_views,b.doc_downs,
                       b.doc_ext_name
                from doc_album_info a 
                left join doc b 
                on a.doc_id = b.doc_id
                where a.album_id = '$id'";
        return $this->sql_pager($sql, $page, $limit, $url);
    }
    /**
     * 文辑是否被收藏 
     * @param int $id
     * @param string $uid
     * @return Ambigous <string, NULL, mixed>
     */
    function is_fav($id,$uid){
        $sql = "select count(*) from doc_fav where uid = '$uid' and obj_type='album' and obj_id= '$id'";
        return $this->db()->col($sql);
    }
    /**
     * 收藏文辑
     * @param int $id
     * @param string $uid
     * @return Ambigous <boolean, mixed, resource>
     */
    function fav($id,$uid){
        $data['uid']  = $uid;
        $data['obj_id']  = $id;
        $data['obj_type']  = 'album';
        $data['on_time']  = $_SERVER['REQUEST_TIME'];
        $sql = "update doc_album set favs = ifnull(favs,0)+1 where album_id = '$id'";
        return $this->insert($data,'doc_fav');
    }
    /**
     * 浏览 +1
     * @param int $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function view_add($id){
        $sql = "update doc_album set views = ifnull(views,0)+1 where album_id = '$id'";
        return $this->sql($sql);
    }
    /**
     * 更新评价分数与评价次数,
     * @param int $id
     * @param int $remark
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function mark_add($id,$remark){
        $sql = "update doc_album set remarks = ifnull(remarks,0)+'$remark' ,remark_num=ifnull(remark_num,0)+1  where album_id = '$id'";
        return $this->sql($sql);
    }
    
    /**
     * 文辑评分
     * @param int $id
     */
    function album_remark($id){
        $sql ="SELECT truncate(sum(total_mark)/count(uid),2) as remark
                FROM `doc_remark`
                where obj_id = '$id' and obj_type='album' ";
        return (float)$this->db()->col($sql);
    }
    /**
     * 取相关性文辑
     * @param int $id
     */
    function relation_album($id){
        $sql = "SELECT b.*,truncate(b.remarks/b.remark_num,2) remark FROM `doc_album` a
                left join doc_album b
                on a.album_id = b.album_id
                where a.ct0=b.ct0 and a.ct1 = b.ct1
                and a.album_id != '$id'
                order by b.album_id desc
                limit 0,5";
        return $this->sql($sql);
    }
    /**
     * 与文档相关的文集
     * @param unknown_type $ct0
     * @param unknown_type $ct1
     */
    function doc_relation_album($ct0,$ct1,$ct2,$ct3,$limit){
        $where = " 1 ";
        if($ct0){
            $where .= "and ct0 = '$ct0'";
        }
        if($ct1){
            $where .= "and ct1 = '$ct1'";
        }
        if($ct2){
            $where .= "and ct2 = '$ct2'";
        }
        if($ct3){
            $where .= "and ct3 = '$ct3'";
        }
        
        $sql  = "select * , truncate(remarks/remark_num,2) remark from doc_album where 
                 $where order by album_id desc $limit";
        return $this->sql($sql);
    }
    /**
     * 更新文集信息
     * @param int $id
     * @param array $data
     * @return bool
     */
    function update_album($id, $data){
        return (bool)$this->update($id, $data);
        /* $key = $this->cache_key('get_album_info', array(0=>$id));
        $data = $this->cache()->del($key);
        return (bool)$this->del_index($id); */
    }
    /**
     * 指定的文集是否为空
     * @param int $id
     * @return bool
     */
    function is_empty($id){
        $sql = "SELECT count(id) FROM `doc_album_info` where album_id = '$id'";
        return (bool)$this->db()->col($sql);
    }
    /**
     * 删除文集中的文件
     * @param int $album_id
     * @param int $doc_id
     */
    function  del_album_info($album_id,$doc_id){
        //$sql = "delete * from doc_album_info where album_id = '$album_id' and doc_id = '$doc_id'";
        $uid  = $_SESSION['user']['user_id'];
        $sql = "delete a.* from `doc_album_info` a 
                left join doc_album b
                on a.album_id = b.album_id 
                where a.album_id = '$album_id' and a.doc_id = '$doc_id'
                and b.uid = '$uid'";
        $res = $this->sql($sql);
        if($res){
            //文集文件数 -1
            $sql = "update doc_album set file_num = if(file_num>0,file_num-1,0)  where album_id = '$album_id'";
            $this->sql($sql);
        }
        return $res;
    }
    
    
     
}

 