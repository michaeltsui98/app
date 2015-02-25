<?php

/**
 * 文库首页model
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Index extends Cola_Model
{
    
    
    
    /**
     * 根据学段，学科，资源类型统计资源总数
     * @param string $xd
     * @param string $xk
     * @param string $type
     * @return integer
     */
    function countResource($xd=null,$xk=null,$type=null){
        $where = " ";
        if($xd){
            $where .= "  node_id:$xd  ";
        }
        if($xk){
            if($xd){
                $where .= " AND node_id:$xk ";
            }else{
                $where .= " node_id:$xk ";
            }
        }
        if($type){
            $where .= " AND resource_type:$type AND is_ok:1 AND is_hidden:0";
        }
       $data =  Models_Search::inits()->indexQuery($where,false,'on_time',false,false,1,1,true);
       return (int)$data['count'];
    }
    
    public function getUserInfo($data){
        $cache_key = 'user_info_'.$data['user_id'];
        $user_info = $this->cache->get($cache_key);
        if (!$user_info) {
            $DDClient = new Models_Client();
            $user_info = $DDClient->viewUserInfo($data['user_id']);
            if($user_info){
                $info = (array)Models_Circle::init()->getCurClassSchoolByUserId($data['user_id']);
                $user_info += $info;
                $this->cache->set($cache_key, $user_info,3600*5);
            }
        }
        return $user_info;
    }
    /**
     * 取上传资源最多的用户
     * @return Ambigous <multitype:, boolean>
     */
    public function getTopUser(){
       $data =  $this->sql("select count(doc_id) c,uid user_id,user_name from resource
                                where is_ok = 1 and is_hidden = 0
                                GROUP BY  uid
                                order by c desc
                                limit 10 ");
       $users =  array_map(array($this,'getUserInfo'), $data);
       //$users1 = array_filter($users);
       //var_dump($data,$users1);die;
       return array_map('array_merge', $data,$users);
       
    }
    /**
     * 获取推荐的文档，取最新的前10个
     */
    function get_recommend_doc ($xd=32,$limit=6)
    {
        $sql = "select doc_id, doc_title,doc_page_key,doc_ext_name from doc 
                where is_recommend =1 and xd='$xd'
                order by doc_id desc
                limit 0,$limit  ";
        $key = $this->cache_key('get_recommend',func_get_args());
        $data = $this->cache()->get($key);
        if (! $data) {
            $data = $this->sql($sql);
            $this->cache()->set($key, $data, 600);
        }
        return $data;
    }

    /**
     * 获取本周，本月，本年， 的文档排行榜
     * 按下载次数+阅读次数
     *
     * @param string $unit
     *            (week,month,year)
     * @return array;
     */
    function get_top_doc ($unit = 'week')
    {
        $sql = "select doc_id,doc_title,(doc_views+doc_downs) num from doc
                where DATE_SUB(CURDATE(),INTERVAL 1 $unit) <= DATE(FROM_UNIXTIME(on_time))
                order by (doc_views+doc_downs) desc limit 0,10";
        
        $key = $this->cache_key('get_top_doc', func_get_args());
        $data = $this->cache()->get($key);
        if (! $data) {
            $data = $this->sql($sql);
            $this->cache()->set($key, $data, 800);
        }
        return $data;
    }
    /**
     * 上传排行榜
     * @param string $unit (week,month,year)
     * @return Ambigous <multitype:, boolean, mixed, resource>
     */
    function upload_doc_top($unit='week'){
        $sql = "SELECT count(doc_id) doc_num,user_name,uid from doc 
                where DATE_SUB(CURDATE(),INTERVAL 1 $unit) <= DATE(FROM_UNIXTIME(on_time))
                group by uid order by doc_num desc ";
        $key = $this->cache_key('upload_doc_top', func_get_args());
        $data = $this->cache()->get($key);
        if (! $data) {
            $data = $this->sql($sql);
            $this->cache()->set($key, $data, 800);
        }
        return $data;
    }

    /**
     * 生成oauth登录的url
     *
     * @return string
     */
    function getOauthUrl ($refUrl=null)
    {
        if($refUrl==null){
            $refUrl = $_SERVER['HTTP_REFERER'];
        }
        $_SESSION['refUrl'] = $refUrl;
        $_SESSION['state'] = md5(uniqid(rand(), TRUE));
        $DDClient = new Models_DDClient();
        return $DDClient->getAuthorizeURL(DD_CALLBACK_URL, 'code' ,$_SESSION['state']);
    }
    /**
     * 是否登录
     * @return boolean
     */
    function is_login(){
       return (bool)$_SESSION['user']['user_id'];
    }
}
 