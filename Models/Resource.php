<?php

/**
 * 文档管理
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Resource extends Models_Base
{

    protected $_pk = 'doc_id';

    protected $_table = 'resource';

    
    public static $doc_status = array('0'=>'转换中','1'=>'转换完成','2'=>'转换失败','3'=>'内容重复');
    public static $status_color = array('0'=>'#00a0e9','1'=>'#009944','2'=>'#e60012','3'=>'#b28850'); 
    function get_doc ($limit, $where, $url, $ajax = 0, $order)
    {
        $page = v('page');
        $sql = "select * from {$this->_table} " . $where;
        
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
    	$sql = "SELECT count(doc_id) as c FROM `{$this->_table}` where file_md5 = '$md5_code'";
    	$count = $this->db->col($sql);
    	if($count){
    		$this->update($doc_id, array('doc_status'=>'3','file_md5'=>$md5_code));
    	}
    	return $count;
    }
    
    /**
     * 统计用户的资源是否复名
     */
    function checkResourceTitle($title,$user_id){
        $title = $this->escape($title); 
        return $this->count("doc_title = $title and uid = '$user_id'");
    }
  
 
    
    /**
     * 获取文档信息
     *
     * @param int $id
     * @param int $cate_id 1 文档类5,6视频类            
     * @return multitype:
     */
    function get_doc_info ($id,$cate_id=1)
    {
        
        $data = Models_Video::init()->getVideoResouceInfo($id,$cate_id);
        $data['remarks'] = $data['doc_remarks'];
        if(!$data){
            //如果资源不存在了，就删除索引，解决手工删数据库后，索引还在的问题
            $this->del_index($id);
        }
        
        return $data;
    }
    /**
     * 通过文件ID 取资源的summery
     * @param unknown $file_id
     */
    function getResourceSummery($file_id){
        $sql = "select doc_summery from {$this->_table} where file_id = '$file_id'  and doc_summery is not null  limit 1";
        return $this->db->col($sql);
    }
    
    function clear_doc_info_cache($id){
        $key  = $this->cache_key('get_doc_info',array($id));
        $res = $this->cache()->delete($key);
        return $res;
    }
    /**
     * 获取文件信息
     * @param int $id
     * @return mixed
     */
    function get_file_info($doc_id){


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
    
        $config = Cola::$_config->get('_resourceFs');
        $fs = new Cola_Com_Mogilefs($config['domain'], $config['class'], $config['trackers']);
        $mime_type = Cola::getConfig('mime_type');
        if ($key and $fs->exists($key)) {
            $fileInfo = $fs->fileinfo($key);
            $pathinfo = pathinfo($fileName);
            if($mime_type[$pathinfo['extension']]){
                $ctype = $mime_type[$pathinfo['extension']];
            }else{
                $ctype = 'application/octet-stream';
            }
            $gate = HTTP_MFS_DISK;
            $data['key'] = $key;
            $data['type'] = $type;
            $data['fileName'] = $fileName;
            $data['fileType'] = $ctype;
            $data['sign'] = md5($key.'dododisk');
            $data['domain'] = 'resource';
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
                ,count(uid) count
                FROM `doc_remark`
                where obj_id = '$id' and obj_type='$type'";
        return $this->db->row($sql);
    }
    /**
     * 文档浏览+1
     * @param int $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function view_add($id,$views=null){
        $sql = "update {$this->_table} set doc_views = doc_views+1 where doc_id= '$id'";
        if($views){
            $views += 1;
            Models_Search::inits()->update_index($id, array('views'=>$views));
        }else{
            $info = $this->get_doc_info($id);
            $views = (int)$info['doc_views']+1;            
            Models_Search::inits()->update_index($id, array('views'=>$views));
        }
        return $this->sql($sql);
    }
    /**
     * 获取浏览数,收藏数，评论数
     * @param int $id
     * @return number
     */
    function get_doc_val($id,$filed='doc_views'){
         $sql = "select $filed from {$this->_table} where doc_id = '$id'";
         return (int)$this->db->col($sql);    
    }
    
    
    /**
     * 收藏+1
     * @param unknown_type $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function fav_add($id){
       $sql = "update {$this->_table} set doc_favs = doc_favs+1 where doc_id= '$id'";
        return $this->sql($sql);
    }
     
    
    /**
     * 评价数+1,总分++
     * @param unknown_type $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function mark_add($id,$val){
       $sql = "update {$this->_table} set doc_remarks = doc_remarks+1,doc_remark_val = ifnull(doc_remark_val,0)+$val where doc_id= '$id'";
        return $this->sql($sql);
    }
    /**
     * 下载数加+1
     * @param int $id
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function down_add($id){
       $sql = "update {$this->_table} set doc_downs = doc_downs+1 where doc_id= '$id'";
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
        $sql = "select * from {$this->_table} where (is_recommend=1 and doc_status=1) or xd = '$xd' limit 0,5";
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
       return  $is_fav = (bool)Cola_Model::init()->table('resource_fav')->count("uid= '$uid' and obj_type='doc' and obj_id='$id' ");
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
        $data['site'] = '多多资源中心';
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
       return  Models_ResourceFile::init()->getStar($num);
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
   /*  function get_relation_doc($ct0,$ct1,$ct2,$ct3,$limit){
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
        $sql = "select * , truncate(doc_remark_val/doc_remarks,2) remark from {$this->_table} where $where $limit";
        return $this->sql($sql);
        
    } */
    /**
     * 删除doc 的 封面图片，pdf文件，swf文件
     * @param int $id
     */
    function del_doc_file($id){
        $doc_info = $this->load($id);
        
        //资源状态为3的资源不删除原始文件
        if((int)$doc_info['doc_status'] == 3){
        	return false;
        }
        //删除文档与视频的封面图片
        $imgfs = $this->mogfs('_imgFs');
        if($doc_info['doc_page_key'] and $imgfs->exists($doc_info['doc_page_key'])){
            $imgfs->delete($doc_info['doc_page_key']);
        }
        //删除文件的pdf文件
        $pdffs = $this->mogfs('_pdfFs');
        if($doc_info['doc_pdf_key'] and $pdffs->exists($doc_info['doc_pdf_key'])){
            $pdffs->delete($doc_info['doc_pdf_key']);
        }
        //删除文档的swf文件
        $swffs = $this->mogfs('_swfFs');
        if($doc_info['doc_swf_key'] and $swffs->exists($doc_info['doc_swf_key'])){
           $swffs->delete($doc_info['doc_swf_key']);
          
        }
        //删除原始文件
        $filefs = $this->mogfs('_resourceFs');
        if($doc_info['file_key'] and $filefs->exists($doc_info['file_key'])){
           $filefs->delete($doc_info['file_key']);
          
        }
         
    }
    /**
     * 删除文档如
     * @param int $id
     */
    function del_doc($id){
        $key = $this->cache_key('get_doc_info', array(0=>$id));
        $this->cache()->delete($key);
        $sql = "delete a.*,b.* from resource a 
                left join video b
                on a.doc_id = b.obj_id and b.obj_type = 'resource'
                where a.doc_id = '$id' ";
        
        return $this->sql($sql);
    }
    /**
     * 删除我收藏的
     * @param string $user_id
     * @param int $id
     */
    function delMyFavResource($user_id,$id){
    	$this->sql("delete FROM `resource_fav` where uid = '$user_id' and obj_id = '$id'
                and obj_type='doc' ");
    	return $this->sql("update `{$this->_table}` set  doc_favs = doc_favs-1 where doc_id = '$id'");
    	
    }
    /**
     * 删除我上传的资源
     * @param string $user_id
     * @param int $id
     */
    function delMyUploadResource($user_id,$id){
        //删除索引
    	$this->del_index($id);
    	//删除文件
    	//$this->del_doc_file($id);
    	//删除数据库
    	$key = $this->cache_key('get_doc_info', array(0=>$id));
        $this->cache()->delete($key);
        Models_Search::inits()->flushIndex();

        //删除收藏的资源
        Models_Fav::init()->del_fav($user_id,$id);
        //删除下载的资源
        Models_User_Down::init()->del($user_id,$id);
    	return $this->sql("delete from {$this->_table} where uid = '$user_id' and doc_id = '$id'");
    }
    
    /**
     * 资源删除,可以是用户的资源，也可以是对象的资源
     * @param string $obj_type user|school|site
     * @param string $obj_id
     * @param int $id
     * @
     */
    public function deleteResource($obj_type,$obj_id,$id){
        if($obj_type=='user'){
            $user_id = $obj_id;
            if($user_id){
                $result =  $this->sql("delete from {$this->_table} where uid = '$user_id' and doc_id = '$id'");
            }
        }else{
            $result =  $this->sql("delete from {$this->_table} where obj_type='$obj_type' and obj_id = '$obj_id' and doc_id = '$id'");
        }

        //删除索引
        $this->del_index($id);
        //删除数据库
        $key = $this->cache_key('get_doc_info', array(0=>$id));
        $this->cache()->delete($key);
        Models_Search::inits()->flushIndex();
        
        return $result;
    }
    
    /**
     * 删除我们下载
     * @param string $user_id
     * @param int $id
     */
    public  function delMyDownResource($user_id,$id){
    	$sql = "delete FROM `doc_down_log` where uid = '$user_id' and doc_id = '$id'";
    	return $this->sql($sql);
    }
    /**
     * 字节换为大小
     *
     * @param int $bytes
     */
    public function bytesToSize ($bytes)
    {
        if ($bytes > 0) {
            $units = array(
                    0 => 'B',
                    1 => 'KB',
                    2 => 'MB',
                    3 => 'GB'
            );
            $log = log($bytes, 1024);
            $power = (int) $log;
            $size = pow(1024, $log - $power);
            return round($size, 2) . ' ' . $units[$power];
        } else {
            return 0;
        }
    }
    static $_fs = array();
    public function mogfs ($config = '_imgFs')
    {
        $cfg = Cola::getConfig($config);
        return static::$_fs[$config] = new Cola_Com_Mogilefs($cfg['domain'],
                $cfg['class'], $cfg['trackers']);
    }

    /**
     * 我下载的资源
     * @param string $user_id
     * @param number $cate_id
     * @param number $page
     * @param number $limit
     * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
     */
    public function myDown($user_id,$cate_id=0,$xk='',$page=1,$limit=20){
        $where = "";
        if($xk){
        	$where .= " and  b.xk = '$xk' ";
        }
        if($cate_id){
            $where .= " and  b.cate_id = '$cate_id' ";
        }
         
        $sql = "select
        b.doc_id as id ,b.doc_title as title ,
        b.doc_summery summery ,
        b.user_name , b.doc_views views,
        b.doc_credit credit,
        round(b.doc_remark_val/b.doc_remarks,1) remark,
        c.doc_ext_name file_type, c.file_key,c.doc_pages pages ,
        c.doc_page_key page_key, b.on_time,c.file_size,a.on_time down_time,
        b.doc_downs downs, a.uid
        from doc_down_log a inner join resource b
        on a.doc_id = b.doc_id
        left join resource_file c
        on b.file_id = c.file_id
        where   a.uid = '$user_id' $where  order by a.id desc";
        return $this->getListBySql($sql, $page, $limit);
        
    }
    /**
     * 我收藏的
     * @param unknown $user_id
     * @param number $cate_id
     * @param string $xk
     * @param number $page
     * @param number $limit
     */
    public function myFav($user_id,$cate_id=0,$xk='',$page=1,$limit=20){
        $where = "";
        if($xk){
        	$where .= " and  b.xk = '$xk' ";
        }
        if($cate_id){
            $where .= " and  b.cate_id = '$cate_id' ";
        }
        $sql = "select 
                b.doc_id as id ,b.doc_title as title ,
                b.doc_summery summery ,
                b.user_name , b.doc_views views,b.doc_credit credit,
                round(b.doc_remark_val/b.doc_remarks,1) remark,
                c.doc_ext_name file_type,
                c.file_key,c.doc_pages pages ,c.doc_page_key page_key,
                b.on_time,c.file_size,a.on_time fav_time, b.doc_favs favs,
                a.uid,b.uid user_id
                from resource_fav a inner join resource b
                on a.obj_id = b.doc_id
                left join resource_file c 
                on b.file_id = c.file_id 
                where a.obj_type='doc'  and a.uid = '$user_id' $where order by a.id desc";
        
        return Models_Resource::init()->getListBySql($sql, $page, $limit);
        
    }
    /**
     * 取文件预览类型
     * @param int $cate_id
     * @param string $ext
     * @return string
     */
    public  function getPerviewType($cate_id,$ext){
        $type = 'isTxt';
        $cate_id = (int)$cate_id;
        $ext = strtolower($ext);
        if($ext == 'zip' or $ext == 'rar'){
               $type = 'isDown';
        }elseif($ext == 'ppt' or $ext == 'pps' or $ext == 'pptx' or $ext == 'pot' or $ext == 'ppsx'){
                $type = 'isPpt';
        }elseif($ext == 'mp4' or $ext == 'flv'){
            $type = 'isVideo';
        }
        return $type;
    }
    /**
     * 统计用户上传的资源数
     * @param string $user_id
     * @param string $xk 学科CODE
     * @return Ambigous <number, boolean>
     */
    public function getCountUploadResource($user_id,$xk){
        return $this->count("uid = '$user_id' and xk = '$xk'");
    }
    /**
     * 取我上传的资源列表
     * @param string $user_id
     * @param string $xk 学科CODE
     * @param int $type 资源类型
     */
    public function getMyUploadResrouce($user_id,$xk,$type,$page,$limit,$order_field='doc_id',$order='desc'){
        $where = "";
        if($xk){
            $where = " and b.xk='$xk' ";
        }
        if($type){
            $where .= " and b.cate_id = '$type' ";
        }
        
        if($order_field){
            $order_field = "b.$order_field";
        }else{
            $order_field = "b.doc_id";
        }
        if(!$order){
            $order = 'desc';
        }
        
        
        $sql = "select
        b.doc_id as id ,b.doc_title as title ,
        b.doc_summery summery ,
        b.user_name , b.doc_views views,
        b.doc_credit credit,
				b.doc_status ,
        round(b.doc_remark_val/b.doc_remarks,1) remark,
        if( c.doc_ext_name is null ,RIGHT(b.doc_file_name, INSTR(REVERSE(b.doc_file_name),'.')-1),c.doc_ext_name)
as  file_type, 
        c.file_key,c.doc_pages pages ,
        c.doc_page_key page_key, b.on_time,c.file_size,
        b.doc_downs downs, b.uid,b.uid user_id
        from resource b
        left join resource_file c
        on b.file_id = c.file_id
        where   b.uid = '$user_id' $where  order by $order_field $order";
        return $this->getListBySql($sql, $page, $limit);
    }
    /**
     * 根据对象取资源
     * @param string $obj_id
     * @param string $obj_type
     * @param number $cus_id
     * @param string $doc_title
     * @param number $page
     * @param number $limit
     * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
     */
    public  function getResourceByObj($obj_id,$obj_type,$cus_id,$doc_title='',$page=1,$limit=20){
        if(!$obj_id or !$obj_type){
            return false;
        }
            
        $where =""; 
        if($doc_title){
            $where .= " and b.doc_title like '%{$doc_title}%'" ;
        }
        if($cus_id){
            $sql = "select b.*,round(b.doc_remark_val/b.doc_remarks,1) remark, c.doc_ext_name,c.doc_page_key,c.doc_pages,c.file_size from (
            select id from cus_cate where FIND_IN_SET('$cus_id',pid_path)
            ) a
            left join resource b
            on b.cus_id = a.id
            left join resource_file c
            on b.file_id  = c.file_id
            where 1 $where  order by b.doc_id desc ";
        }else{
            $sql = "SELECT a.*,round(a.doc_remark_val/a.doc_remarks,1) remark,
                 b.doc_ext_name 
                    FROM `resource` a 
                left join resource_file b 
                on a.file_id = b.file_id 
                where 
                a.obj_id = '$obj_id' and a.obj_type ='$obj_type' 
                 $where order by a.doc_id desc ";
        }
       return $this->getListBySql($sql, $page, $limit);
       
      // Models_Interface_Resource::init()->getNoStandResourceByObj($obj_type, $obj_id, $cus_id, $cate_id, $order_field, $order);
    }
    /**
     * 取对象上传的资源
     * @param string $obj_id
     * @param string $obj_type
     * @param int $cate_id
     * @param int $source 1为学科资源 2为校本资源
     * @param int $cus_id 自定义分类 
     * @param string $doc_title
     * @param number $page
     * @param number $limit
     * @return boolean|Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
     * @example  http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Resource/m/getObjUploadResource?obj_id=121502&obj_type=school&cate_id=&cus_id=&doc_title=&page=1&limit=20
     */
    public  function getObjUploadResource($obj_id,$obj_type,$cate_id,$source,$cus_id,$doc_title='',$page=1,$limit=20){
        $where =""; 
        
        if(!$obj_id or !$obj_type){
            return false;
        }else{
            $where .= " and b.obj_id= '$obj_id' and b.obj_type = '$obj_type' ";
        }
        
        
            
        if($doc_title){
            $where .= " and b.doc_title like '%{$doc_title}%'" ;
        }
        if($cate_id){
            $where .= " and b.cate_id = '{$cate_id}'" ;
        }
        
        //1为学科资源,2为校本资源
        if($source==2){
            $where .= " and (b.cus_id is not null and b.cus_id >0)";
        }elseif($source==1){
            $where .= " and (b.cus_id is null or b.cus_id = 0) ";
        }
        
        if($cus_id){
            $where .= " and b.cus_id = $cus_id";
        }
         
        $sql = "select b.*,round(b.doc_remark_val/b.doc_remarks,1) remark, c.doc_ext_name,c.doc_page_key,c.doc_pages,c.file_size   
        from resource b
        left join resource_file c
        on b.file_id  = c.file_id
        where 1 $where  order by b.doc_id desc ";
            
            
        //   var_dump($sql);
         
       return $this->getListBySql($sql, $page, $limit);
    }
    /**
     * 取（对象）学校的标准资源
     * @param string $obj_type  school=>学校
     * @param string $obj_id
     * @param string $xd
     * @param string $xk
     * @param string $bb
     * @param string $nj
     * @param string $unit_id
     * @param number $type
     * @param string $order_field
     * @param string $order
     * @param number $page
     * @param number $limit
     * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
     */
    public function getStandResourceByObj($obj_type,$obj_id,$xd,$xk,$bb,$nj,$unit_id,$type=0,$order_field='doc_id',$order='desc',$page=1,$limit=20){
        $where = "";
        if($xd){
            $where .= " and b.xd = '$xd'";
        }
        if($xk){
            $where .= " and b.xk = '$xk'";
        }
        if($bb){
            $where .= " and b.bb = '$bb'";
        }
        if($nj){
            $where .= " and b.nj = '$nj'";
        }
        if($type){
            $where .= " and b.cate_id = '$type'";
        }
        if($obj_type){
            $where .= " and b.obj_type = '$obj_type'";
        }
        if($obj_id){
            $where .= " and b.obj_id = '$obj_id'";
        }
        if($unit_id){
            $sql = "select b.*,c.doc_ext_name,c.doc_page_key,c.doc_pages,c.file_size from(
            SELECT id FROM `unit_node`  where FIND_IN_SET('$unit_id',fid_path)
            ) a
            LEFT JOIN resource b
            on b.nid = a.id
            left join resource_file c
            on b.file_id = c.file_id
            where b.doc_id >0  $where order by $order_field $order ";
        }else{
            $sql = "select b.*,c.doc_ext_name,c.doc_page_key,c.doc_pages ,c.file_size from resource b
            left join resource_file c
            on b.file_id = c.file_id
            where b.doc_id >0  $where order by $order_field $order ";
        }
    
        return $this->getListBySql($sql, $page, $limit);
    }

    /**
     * 编辑资源
     * @param int   $id doc_id
     * @param array $data array('doc_title','doc_summery','xd','xk','bb','nj','node_id','nid','file_path')
     * @param array $file   array('file_name','file_path','file_size')
     * @param boolean $is_admin 是否为管理员
     * @return array
     */
    public function editResource($id,array $data,array $file= array(),$is_admin=false){
        $id = (int)$id;
        if(!$id or !$data){
           return $this->msgArr('error', '参数不能为空');
        }

        //分离出资源数据与标签数据
        $tags = '';
        if(isset($data['tags'])){
            $tags =  array_pop($data);
        }
        $is_cus = false;
        //判断是数科资源还是自定义资源,看cus_id 是否有值
        if(isset($data['cus_id']) and $data['cus_id']){
            //自定义资源
            $is_cus = true;
        }elseif(isset($data['xd']) and !isset($data['node_id'])){
            //学科资源 算出node_id
            switch (1) {
                case (isset($data['nj']) and $data['nj']):
                     $data['node_id'] = $data['nj'];
                break;
                case (isset($data['bb']) and $data['bb']):
                     $data['node_id'] = $data['bb'];
                break;
                case (isset($data['xk']) and $data['xk']):
                     $data['node_id'] = $data['xk'];
                break;
                case (isset($data['xd']) and $data['xd']):
                     $data['node_id'] = $data['xd'];
                break;
                default:
                    $data['node_id'] = $data['nj'];
                break;
            } 
 
            //通过node_id 算出xd,xk,bb,nj 对应的code
            if(is_numeric($data['xd']) and $data['node_id']){
                $node_arr = Models_Node::init()->getParentCodeById($data['node_id']);
                
                $data = array_merge($data, $node_arr);
            }
            $xd = isset($data['xd'])?$data['xd']:'';
            $xk = isset($data['xk'])?$data['xk']:'';
            $bb = isset($data['bb'])?$data['bb']:'';
            $nj = isset($data['nj'])?$data['nj']:'';
        }elseif(isset($data['node_id']) and $data['node_id']){
            $node_arr = Models_Node::init()->getParentCodeById($data['node_id']);
            $data = array_merge($data, $node_arr);
            $xd = isset($data['xd'])?$data['xd']:'';
            $xk = isset($data['xk'])?$data['xk']:'';
            $bb = isset($data['bb'])?$data['bb']:'';
            $nj = isset($data['nj'])?$data['nj']:'';
        }

        if(!isset($data['cate_id']) or !$data['cate_id']) {
            $data['cate_id'] = 1;
        }




        //如果有文件存在，修改资源状态，修改审核状态，如果是后台管理员添加，审核状态默认为1通过 ,
        //后台管理员添加的资源为正版资源
        //是否为新增资源文件,默认为false
        $isNewFile  = false;
        if(!empty($file) and $file['file_path']){
            $data['doc_status'] = 0;
            //不是后台管理员编辑的资源，资源审核状态设为0
            $data['is_ok'] = $is_admin?1:0;
            //保存要更新的资源文件及资源文件表
            //print_r($data);


            $arr =  $this->editResourceFile($file,$data);

            //$data[] =  $arr['data'][''];
            $isNewFile  = $arr['isNewFile'];

            if(isset($arr['data'])) {
                $data['doc_status'] = $arr['data']['doc_status'];
                $data['doc_summery'] = $arr['data']['doc_summery'];
                $data['file_id'] = $arr['data']['file_id'];
            }

        }

        $data['doc_file_name'] = $file['file_name'];



        //更新资源表
        $res = Models_Resource::init()->update($id, $data);

        $data['doc_id'] = $id;
        $data['file_size'] = $file['file_size'];
        $data['file_path'] = $file['file_path'];

        $data['doc_ext_name'] = pathinfo($file['file_name'],PATHINFO_EXTENSION);

        if(isset($arr['file_data'])){
            $data['file_key']  = $arr['file_data']['file_key'];
            $data['file_md5']  = $arr['file_data']['file_md5'];
        }




        //算出pid_path ,没有知识节点，有基础节点
        if(!isset($data['nid']) and $data['node_id']){
            if($data['node_id']>80000){
                //专业资源tree node
                $data['pid_path'] = Modules_Admin_Models_NodeCate::init()->getPidPath($data['node_id']);
            }else{
                //标准资源，但是没有知识节点的 tree node
                $data['pid_path'] = Modules_Admin_Models_NodeKind::init()->getPidPath($data['node_id']);
            }
        }
        //知识节点的父ID
        if(isset($data['nid']) and $data['nid']){
            $data['unit_pid_path']  = Modules_Admin_Models_UnitNode::init()->getPidPath($data['nid']);
        }
        //取知识节点名称
        if($data['nid']){
            $data['zs_name'] = Models_Unit::init()->getUnitNameById($data['nid']);
            $zs = Models_Unit::init()->getUnitNameById($data['nid']);
        }

        //获取文档的节点名称
        $node_arr = Models_Node::init()->getNodeName(array($data['xd'],$data['xk'],$data['bb'],$data['nj']));
        //var_dump($node_arr);die;
        if($zs){
            array_push($node_arr, $zs);
        }
        if($node_arr){
            $data['node_name'] = implode('+', $node_arr);
        }

        //节点id，前四个是基础节点的四级深度的节点ID,后面是,zt,nid,cate_id
        $kn_arr['xd'] = $data['xd'];
        $kn_arr['xk'] = $data['xk'];
        $kn_arr['bb'] = $data['bb'];
        $kn_arr['nj'] = $data['nj'];

        if($data['nid']){
            $kn_arr['nid'] = $data['nid'];
        }
        //$kn_arr['node_id'] = $data['node_id'];
        $data['node_ids']  =  implode(',', array_values($kn_arr));


        //如果是新文件就加入队列
        if($isNewFile){
            $data['is_edit'] = 1;
            //print_r($data);exit;
            $data['session']  = $_SESSION;
            $data =  $this->resourceToQueue($data,$file);
        }
        //var_dump('eeee');


        //更新资源标签
        $this->editResourceTag($id,$tags,$_SESSION['user']['user_id']);

        //var_dump('bbbbb');die;

        return $this->msgArr('success', '编辑成功',$data);
        
    }

    /**
     * 将要转转换的资源信息放放到对应的队列中
     * @param array $data 资源数据信息
     * @param array $file 资源文件信息
     * @return mixed
     * @throws \Exception
     */
    public function resourceToQueue($data,$file){

        if($data['cate_id']==1 or $data['cate_id']==2 or $data['cate_id']==3 or $data['cate_id']==7 or $data['cate_id']==9){    //文档

                //如果是本地的pdf,txt就用这个队列
                $ext_name_arr = array('pdf','txt','xls','xlsx');


                //$ext_name_arr = array('pdf','txt');
                if(in_array(strtolower($data['doc_ext_name']),$ext_name_arr,1)){

                    $res = Cola_Com_Queue_Doc::init()->put($data);

                    //如果是office文档系列，就放到专用的 office  to pdf 队列
                }else{
                    $httpsqs = new   Cola_Com_Queue_Httpsqs(Cola::getConfig('_docQueue'));
                    $data['pdf_key'] = Models_Upload::init()->getFsKey($file['file_path'],'pdf');
                    $res = $httpsqs->put(json_encode($data));

                }
            //var_dump($res);
        }elseif($data['cate_id']==5 or $data['cate_id']==6){   //视频
                 $video = new Models_Video();
                //生成图片
                $pages =  $video->getVideoTime($file['file_path']);
                $data['doc_pages'] = $pages;
                $image_path = $video->getVideoImage($file['file_path']);
                $page_key = $video->saveImageTofs($image_path);
                $data['doc_page_key'] = $page_key;

                //视频的封面与时长
                Models_ResourceFile::init()->update($data['file_id'],array('doc_page_key'=>$page_key,'doc_pages'=>$pages));
                //将视频写到视频云中
                if($data['vid']){
                    $video_info = Models_Sdk_Polyv::init()->getById($data['vid']);
                    $video_info['obj_type'] = 'file';
                    $video_info['obj_id'] = $data['file_id'];
                    //var_dump($video_info);
                    $result =  Models_Video::init()->insert($video_info);
                    //var_dump($result);
                }
            //更新资源索引
            $this->editResourceIndex($data['doc_id'],$data);
            //删除上传的临时文件
            if(file_exists($file['file_path'])){
                unlink($file['file_path']);
            }

        }elseif($data['cate_id']==4){
            //更新资源索引
            $this->editResourceIndex($data['doc_id'],$data);
            //删除上传的临时文件
            if(file_exists($file['file_path'])){
                unlink($file['file_path']);
            }
        }

        if(isset($data['session'])){
            unset($data['session']);
        }
        return $data;
    }
    /**
     * 更新资源文件信息及资源文件表
     * @param array $file
     * @param array $data
     * @return array 返回数据 array('data'=>$data,'isNewFile'=>$isNewFile)
     */
    public  function editResourceFile(array $file,array $data= array()){
         //判断文件是否已经存在,如果有存在一样的，就只更新信息，如果不在就走正常流程
         //1.取文件的md5码
         $file_md5 = Models_Video::init()->getFileMd5($file['file_path']);
         //获取相同的资源
         $file_info = Models_ResourceFile::init()->getFileInfoByMd5($file_md5);
         $data['doc_status']  = 0;
         $isNewFile = false;
        //没有相同的文件存在

         if(!isset($file_info['file_id'])){
            if(file_exists($file['file_path'])){
                  if(!isset($file['file_ext'])){
                      $file['file_ext'] = pathinfo($file['file_path'],PATHINFO_EXTENSION);
                  }
                 //保存在mogfiles之前，先删除之前的文件
                 //$old_file_info  = Models_ResourceFile::init()->getFileInfo($data['doc_id']);
                 //Models_ResourceFile::init()->delFsFile($old_file_info['file_key']);
                //如果没有相同的文件就保存文件mogfiles
                 $data['file_key']  = Models_Upload::init()->getFileKey().'.'.$file['file_ext'];
                 Models_Upload::init()->uploadToResourceFs($data['file_key'], $file['file_path']);
                 $file_data['file_key'] = $data['file_key'];
                 $file_data['doc_ext_name'] = $file['file_ext'];
                 $file_data['file_md5'] = $file_md5;
                 $file_data['file_size'] = $file['file_size'];
             }
             if($data['cate_id']==4 or $data['cate_id']==5 or $data['cate_id']==6){
                 $data['doc_status'] = 1;
             }
             //先生成文件信息,产生file_id
             $data['file_id'] = Models_ResourceFile::init()->insert($file_data);
             $isNewFile = true;
             $file_info = $file_data;
         }else{
             $data['doc_summery'] = Models_Resource::init()->cached('getResourceSummery',array($file_info['file_id']),3600);
             //有重复的文件存在
             $data['doc_status'] = 3;
             $data['file_id'] = $file_info['file_id'];
         }
         return  array('data'=>$data,'isNewFile'=>$isNewFile,'file_data'=>$file_info);
     }

    /**
     * 更新资源标签
     * @param int   $doc_id 资源ID
     * @param array $tags 资源标签
     * @param string $user_id
     * @return bool|mixed
     */
    public function editResourceTag($doc_id,$tags,$user_id){
        if(!empty($tags)){
            $c = new Models_Client;
            $p= array('target_id'=>$doc_id,'target'=>'doc','tags_array'=>json_encode(array_values($tags)),'creater_id'=>$user_id);
            return $c->add_tag($p);
        }
        return false;
    }

    /**
     * 更新资源全文索引
     * @param  int  $doc_id 资源ID
     * @param array $data 资源信息
     * @return bool
     */
    public function editResourceIndex($doc_id,$data){

        $index_arr = array();
        $xd  = $data['xd'];
        $xk  = $data['xk'];
        $bb  = $data['bb'];
        $nj  = $data['nj'];

        $index_arr['title'] = $data['doc_title'];
        $index_arr['summery'] = $data['doc_summery'];
        //资源类型
        $index_arr['resource_type'] = $data['cate_id'];
        $index_arr['node_name'] = Cola::$_config['_xd'][$xd].'+'.Cola::$_config['_xk'][$xk].'+'.Cola::$_config['_bb'][$bb].'+'.Cola::$_config['_nj'][$nj].'+'.$data['zs_name'];
        $index_arr['node_id'] = "$xd,$xk,$bb,$nj,{$data['nid']}";
        //资源基础节点path
        $index_arr['pid_path'] = $data['pid_path'];
        //资源知识节点path
        $index_arr['unit_path'] = $data['unit_pid_path'];
        //资源文件类型
        $index_arr['file_type'] = $data['doc_ext_name'];
        //资源文件key
        $index_arr['file_key'] = $data['file_key'];
        //资源文件大小
        $index_arr['file_size'] = $data['file_size'];
        //页数与时长
        if(isset($data['doc_pages'])){
            $index_arr['pages'] = $data['doc_pages'];
        }
        //封面与截图
        if(isset($data['doc_page_key'])){
            $index_arr['page_key'] = $data['doc_page_key'];
        }
        //资源转换状态
        $index_arr['doc_status'] = $data['doc_status'];
        //资源审核状态
        $index_arr['is_ok'] = $data['is_ok'];
        //正版资源，还是官方资源
        if(isset($data['arr'])){
            $index_arr['arr'] = $data['arr'];
        }

        $res =  Models_Search::inits()->update_index($doc_id, array_filter($index_arr));
        Models_Search::init()->flushIndex();
        Models_Search::inits()->close();
        return $res;
    }
    
}

 