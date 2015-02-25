<?php

class Models_User_Album extends Cola_Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'doc_album';
    
    /**
     * Primary key
     *
     * @var string
     */
    protected $_pk = 'album_id';
    
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
     * 获取某用户的文集
     * @param array $Uid
     * @return MyDocData
     */
    public function getMyAlbum($Uid, $limit, $url, $ajax = 0){
        $page = v('page');
        $order = v('order');
        $type = v('type');
        if($type==""){
            $type = "desc";
        }
        switch ($order) {
            case 'p':
                $order_type = "remarks";
                break;
            case 'l':
                $order_type = "views";
                break;
            case 't':
                $order_type = "on_time";
                break;
            default:
                $order_type = "on_time";
                break;
        }
        $sql = "SELECT *,truncate(remarks/remark_num,2) as remark   
                FROM ".$this->_table." 
                WHERE uid = '$Uid'  
                ORDER BY $order_type $type";
        $MyDocData = $this->sql_pager($sql, $page, $limit, $url, $ajax);
        return $MyDocData;
    }
    
    /**
     * 获取文集详细信息
     * @param int $Id
     * @return AlbumData
     */
    function getAlbumInfo($Id){
        $sql = "SELECT *,truncate(remarks/remark_num,2) as remark   
                FROM ".$this->_table." 
                WHERE album_id = '$Id'";
        return $this->db()->row($sql);
    }
    
    
}
