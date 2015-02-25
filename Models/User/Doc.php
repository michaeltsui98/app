<?php

/**
 * 我的文档数据模型
 *
 * @author    Dai Shi Jiang <daishijiang66@gmail.com> *
 * @copyright (c) 2013 Wuhan Bo Sheng Education Information Co., Ltd.
 */
class Models_User_Doc extends Cola_Model {

    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'doc';

    /**
     * Primary key
     *
     * @var string
     */
    protected $_pk = 'doc_id';

    /**
     * @var Cola_Com_Cache
     */
    protected $_cache = NULL;

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
     * 获取某用户的文档
     * @param array $Uid
     * @return MyDocData
     */
    public function getMyDoc($Uid, $limit, $url, $ajax = 0){
        $page = v('page');
        $order = v('order');
        $type = v('type');
        if($type==""){
            $type = "desc";
        }
        switch ($order) {
            case 'p':
                $order_type = "uid";
                break;
            case 's':
                $order_type = "doc_status";
                break;
            case 't':
                $order_type = "on_time";
                break;
            default:
                $order_type = "on_time";
                break;
        }
        $sql = "SELECT *
                FROM ".$this->_table."
                WHERE uid = '$Uid'
                ORDER BY $order_type $type";
        $MyDocData = $this->sql_pager($sql, $page, $limit, $url, 1);
        return $MyDocData;
    }

    /**
     * 获取文档的详细信息
     * @param array $Uid
     * @return MyDocData
     */
    public function getDocInfo($doc_id){
        $sql = "SELECT *,doc_remark_val/doc_remarks as remark
                FROM ".$this->_table."
                WHERE doc_id = '$doc_id'";
        $MyDocData = $this->db()->row($sql);
        return $MyDocData;
    }

    /**
     * 移动文档进入文集
     * @param array $cate_id
     * @param array $doc_id
     * @return MyDocData
     */
    public function moveDocToAblum($cate_id, $doc_id){
        $doc_id = explode(',', $doc_id);
        foreach ($doc_id as $key => $value) {
            $data['album_id'] = $cate_id;
            $data['doc_id'] = $value;
            $is_exit = $this->sql("select * from doc_album_info where album_id = '$cate_id' and doc_id = '$value'");
            if(!count($is_exit)){
                $status = Cola_Model::init()->table('doc_album_info')->insert($data);
            }
        }
        return $status;
    }

    /**
     * 判断该文档是否可以移动
     * @param string $doc_id
     * @param string $user_id
     * @return ture or false
     */
    public function isDocCanMove($doc_id,$user_id){
        $doc_id = explode(',', $doc_id);
        /* 移动文集数据 */
        foreach ($doc_id as $key => $value) {
            $doc_info = $this->getDocInfo($value);
            if($doc_info['doc_status']!=1){
                return "文档不符合要求";
            }
            if($doc_info['uid']!=$user_id){
                return "请移动您自己的文档";
            }
        }
        return "成功";
    }

}
