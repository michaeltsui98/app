<?php

class Models_User_Fav extends Cola_Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'doc_fav';
    
    /**
     * Primary key
     *
     * @var string
     */
    protected $_pk = 'id';
    
    /**
     * @var Cola_Com_Cache
     */
    
    protected  $_cache= NULL;
    /**
     * @var 是否缓存
     */
    protected $_isCache = true;

    /**
     * 构造
     */
    public function __construct() {
        //$this->_cache = $this->cache('_qacachequestion');
    }

    /**
     * 获取某用户收藏文档
     * @param array $Uid
     * @return MyDocData
     */
    public function getMyFavDoc($Uid, $limit, $url, $ajax = 0){
        $page = v('page');
        $sql = "SELECT *   
                FROM ".$this->_table." 
                WHERE uid = '$Uid' AND obj_type = 'doc'  
                ORDER BY on_time DESC";
        $MyDocData = $this->sql_pager($sql, $page, $limit, $url, $ajax);
        return $MyDocData;
    }
    
    /**
     * 获取某用户收藏文档
     * @param array $Uid
     * @return MyDocData
     */
    public function getMyFavAlbum($Uid, $limit, $url, $ajax = 0){
        $page = v('page');
        $sql = "SELECT *   
                FROM ".$this->_table." 
                WHERE uid = '$Uid' AND obj_type = 'album'  
                ORDER BY on_time DESC";
        $MyDocData = $this->sql_pager($sql, $page, $limit, $url, $ajax);
        return $MyDocData;
    }
    
}
