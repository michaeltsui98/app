<?php

/**
 * 文档管理
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Doc extends Cola_Model
{

    protected $_pk = 'doc_id';

    protected $_table = 'doc';

 
    function get_doc ($limit, $where, $url, $ajax = 0, $order)
    {
        $page = v('page');
        $sql = "select * from doc " . $where;
        
        $ordertype = "order by doc_id desc";
        if ($order == "view") {
            $ordertype = "order by doc_views desc";
        } elseif ($order == "down") {
            $ordertype = "order by doc_downs desc";
        }
        $sql = $sql.$ordertype;
        return $this->sql_pager($sql, $page, $limit, $url, $ajax);
    }
	/**
	 * 比较文件的内容是否有存在，如果存在，改变文档的状态
	 * @param string $md5_code
	 * @param int $doc_id
	 * @return int
	 */
    function compareText($md5_code,$doc_id){
    	$sql = "SELECT count(doc_id) as c FROM `doc` where file_md5 = '$md5_code'";
    	$count = $this->db->col($sql);
    	if($count){
    		$this->update($doc_id, array('doc_status'=>'3','file_md5'=>$md5_code));
    	}
    	return $count;
    }
 
    
    /**
     * 获取文档信息
     *
     * @param int $id            
     * @return multitype:
     */
    function get_doc_info ($id)
    {
        $sql = "select * from doc where doc_id = '$id'";
        $sql2 = "select count(*) from doc_remark where obj_type='doc' and obj_id='$id'";
        // 文档被评的次数
        $remarks = $this->db->col($sql2);
        $key = $this->cache_key('get_doc_info', array(0=>$id));
        $data = $this->cache()->get($key);
        if (! $data) {
            $data = $this->db->row($sql);
            $this->cache()->set($key, $data);
        }
        $data['remarks'] = $remarks;
        return $data;
    }
    
    function clear_doc_info_cache($id){
        $key  = $this->cache_key('get_doc_info',array(0=>$id));
        $this->cache()->delete($key);
    }
    /**
     * 获取文件信息
     * @param int $id
     * @return mixed
     */
    function get_file_info($disk_id,$file_id){
        $dd = new Models_DDClient();
        return  $dd->get_disk_file($disk_id, $file_id);
    }
    /**
     * 获取文件下载地址
     * @param string $key
     * @param string $fileName
     * @param string $type
     * @return string|boolean
     */
    public function get_file_url($key,$fileName,$type='down'){
        set_time_limit(0);
        $up = new Models_Upload();
    
        $config = $this->config['_diskFs'];
        $fs = new Cola_Com_Mogilefs($config['domain'], $config['class'], $config['trackers']);
        if ($key and $fs->exists($key)) {
            $fileInfo = $fs->fileinfo($key);
            $pathinfo = pathinfo($fileName);
            if(Models_Upload::$mime_type[$pathinfo['extension']]){
                $ctype = Models_Upload::$mime_type[$pathinfo['extension']];
            }else{
                $ctype = 'application/octet-stream';
            }
            $gate = HTTP_MFS_DISK;
            $data['key'] = $key;
            $data['type'] = $type;
            $data['fileName'] = $fileName;
            $data['fileType'] = $ctype;
            $data['sign'] = md5($key.'dododisk');
    
            $url = http_build_query($data);
            return $gate.$url;
        } else {
            return FALSE;
        }
    }
    /**
     * 取文档/文集总评分
     * @param int $id
     * @param string $type doc,album
     * @return number
     */
    function get_count_mark($id,$type='doc'){
        $sql ="SELECT sum(ff+ty)/(count(uid)) as mark 
                FROM `doc_remark`
                where obj_id = '$id' and obj_type='$type'";
        return (float)$this->db()->col($sql);
    }
    /**
     * 文档浏览+1
     * @param int $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function view_add($id){
        $sql = "update doc set doc_views = doc_views+1 where doc_id= '$id'";
        return $this->sql($sql);
    }
    /**
     * 获取浏览数,收藏数，评论数
     * @param int $id
     * @return number
     */
    function get_doc_val($id,$filed='doc_views'){
         $sql = "select $filed from doc where doc_id = '$id'";
         return (int)$this->db()->col($sql);    
    }
    
    
    /**
     * 收藏+1
     * @param unknown_type $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function fav_add($id){
       $sql = "update doc set doc_favs = doc_favs+1 where doc_id= '$id'";
        return $this->sql($sql);
    }
     
    
    /**
     * 评价数+1,总分++
     * @param unknown_type $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function mark_add($id,$val){
       $sql = "update doc set doc_remarks = doc_remarks+1,doc_remark_val = ifnull(doc_remark_val,0)+$val where doc_id= '$id'";
        return $this->sql($sql);
    }
    /**
     * 下载数加+1
     * @param int $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function down_add($id){
       $sql = "update doc set doc_downs = doc_downs+1 where doc_id= '$id'";
        return $this->sql($sql);
    }
    /**
     * 生成下载记录，包含付费信息
     * @param string $uid
     * @param int $id
     * @param int $credit
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function down_log($uid,$id,$credit){
        $sql = "select count(*) from doc_down_log where uid = '$uid' and doc_id='$id'";
        $is_down = $this->db()->col($sql);
        if($is_down){
            $sql = "update doc_down_log set down_num = down_num+1 where uid='$uid' and doc_id = '$id'";
        }else{
            $t = $_SERVER['REQUEST_TIME'];
            $sql = "insert into doc_down_log (uid,doc_id,down_num,credit,on_time) values
                                            ('$uid','$id',1,'$credit','$t') ";
        }
        return $this->sql($sql);
    }
    
    /**
     * 获取文档当前查看页
     * @param string $uid
     * @param int $id
     * @return int $page 
     */
    function get_mark_page($uid,$id){
        /* $sql = "select mark_page from doc_book_mark where uid='$uid' and doc_id = '$id'";
        return (int)$this->db()->col($sql); */
        $key = "mark:$uid:$id";
        $res = $this->cache('_redis')->get($key);
        return $res;
    }
    /**
     * 标记看到的页面
     * @param string $uid
     * @param int $id
     * @param int $page
     */
    function set_mark_page($uid,$id,$page){
        
        $key = "mark:$uid:$id";
        $res = $this->cache('_redis')->set($key,$page);
        return $res;
    }
    
    /**
     * 更新文档索引
     * @param int $id
     * @param array $data
     */
    function update_index($id,$data){
       $se = Models_Search::inits();
       return (bool) $se->update_index($id, $data);
    }
    /**
     * 删除索引
     * @param int $id
     * @return boolean
     */
    function del_index($id){
        $se = Models_Search::inits();
       return (bool) $se->del_index($id);
    }

    /**
     * 获取推荐的文档
     *
     * @param int $xd            
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function get_recommend_doc ($xd)
    {
        $sql = "select * from doc where (is_recommend=1 and doc_status=1) or xd = '$xd' limit 0,5";
        $key = $this->cache_key('get_recommend_doc', func_get_args());
        $data = $this->cache()->get($key);
        if (! $data) {
            $data = $this->sql($sql);
            $this->cache()->set($key, $data);
        }
        return $data;
    }
    /**
     * 判断文集与文档是否被评价过
     * @param string $uid
     * @param int $id  对象ID
     * @param string $type 对象类型
     * @return boolean
     */
    function is_mark($uid,$id,$type='doc'){
        $where = "uid ='$uid' and obj_type='$type' and obj_id='$id'";
        return $is_mark = (bool) Cola_Model::init()->table('doc_remark')->count($where);
    }
    /**
     * 文档或文集是否收藏过
     * @param string $uid
     * @param int $id
     * @param string $type doc,album
     * @return boolean
     */
    function is_fav($uid,$id,$type='doc'){
       return  $is_fav = (bool)Cola_Model::init()->table('doc_fav')->count("uid= '$uid' and obj_type='doc' and obj_id='$id' ");
    }
    /**
     * 生成共享地址
     * @param string $title
     * @param string $url
     * @param string $desc
     * @param string $pics
     * @param bool $is_pic
     * @return string
     */
    function get_shar_url($title,$url,$pics,$desc,$is_obj){
        
        $uri = HTTP_SHARE;
        $data['title'] = $title;
        $data['url'] = $url;
        $data['desc'] = $desc;
        $data['pics'] = $pics;
        //$site = Cola::Config()->get('site_name');
        $data['site'] = '多多文库';
        $data['is_obj'] = $is_obj;
        $data['obj'] = '文档';
       // var_dump($data,http_build_query($data));die;
        return $uri.http_build_query($data);
    }

    /**
     * 生成星星，总分是十分制，生成五颗星,小于1，大于0.1的生成半颗星
     *
     * @param float $num            
     * @return html;
     */
    function get_star ($num)
    {
         return get_star($num);
    }
    /**
     * 用户的文档统计信息
     * @param string $uid
     * @return multitype:
     */
    function doc_count($uid){
      $sql = "select 
                count(*) upload_docs,
                sum(a.doc_downs) doc_downs,
                sum(a.doc_favs) doc_favs,
                b.albums, 
                b.album_favs,c.doc_faved,d.album_faved,
                (count(*)+c.doc_faved) total_doc
                from doc a 
                left join (
                select count(*) albums,sum(favs) album_favs from doc_album where uid = '$uid'
                ) b 
                on  1=1
                left join (
                select count(*) doc_faved from doc_fav where uid = '$uid'  and obj_type = 'doc'
                ) c on 1=1
                left join (
                select count(*) album_faved from doc_fav where uid = '$uid'  and obj_type = 'album'
                ) d on 1=1
                where a.uid = '$uid'"; 
      return $this->db()->row($sql);   
    }
    /**
     * 更新文档信息
     * @param int $id
     * @param array $data
     */
    function update_doc($id, $data){
        $this->update($id, $data);
        $key = $this->cache_key('get_doc_info', array(0=>$id));
        $res = $this->cache()->delete($key);
        return (bool)$this->update_index($id, $data);
        
    }
    /**
     * 获取相关性文档
     * @param int $ct0
     * @param int $ct1
     * @param int $ct2
     * @param int $ct3
     * @param int $limit
     */
    function get_relation_doc($ct0,$ct1,$ct2,$ct3,$limit){
        $where = "1 ";
        if($ct0){
            $where .= " and xd = '$ct0'";
        }
        if($ct1){
            $where .= " and xk = '$ct1'";
        }
        if($ct2){
            $where .= " and nj = '$ct2'";
        }
        if($ct3){
            $where .= " and bb = '$ct3'";
        }
        $sql = "select * , truncate(doc_remark_val/doc_remarks,2) remark from doc where $where $limit";
        return $this->sql($sql);
        
    }
    /**
     * 删除doc 的 封面图片，pdf文件，swf文件
     * @param int $id
     */
    function del_doc_file($id){
        $doc_info = $this->load($id);
        $imgfs = $this->mogfs('_imgFs');
        if($doc_info['doc_page_key'] and $imgfs->exists($doc_info['doc_page_key'])){
            $imgfs->delete($doc_info['doc_page_key']);
        }
        
        
        $pdffs = $this->mogfs('_pdfFs');
        if($doc_info['doc_pdf_key'] and $pdffs->exists($doc_info['doc_pdf_key'])){
            $pdffs->delete($doc_info['doc_pdf_key']);
        }
        
        $swffs = $this->mogfs('_swfFs');
        
        if($doc_info['doc_swf_key'] and $swffs->exists($doc_info['doc_swf_key'])){
           $swffs->delete($doc_info['doc_swf_key']);
          
        }
         
    }
    /**
     * 删除文档如
     * @param unknown_type $id
     */
    function del_doc($id){
        $key = $this->cache_key('get_doc_info', array(0=>$id));
        $this->cache()->delete($key);
        return $this->delete($id);
    }
    
    static $_fs = array();
    public function mogfs ($config = '_imgFs')
    {
        $cfg = Cola::getConfig($config);
        return static::$_fs[$config] = new Cola_Com_Mogilefs($cfg['domain'],
                $cfg['class'], $cfg['trackers']);
    }
}

 