<?php

/**
 * app产品
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_AppProduct extends Cola_Model
{

    protected  $_table = 'app_product';
    protected  $_pk = 'id';


    /**
     * 取应用信息 for mobile
     * @param $id
     * @return array
     */
    public  function getInfo($id){
        return $this->load($id);
    }

    /**
     * 取应用的列表信息 for mobile
     * @param $page
     * @param $limit
     * @return bool|\multitype
     */
    public  function getList($page,$limit){
        $sql = "select id,title,price,balance,updated_at from {$this->_table}    order by updated_at  desc";
        return $this->getListBySql($sql,$page,$limit);
    }

    public function getAppIds($ids){
        $aids = implode(',',$ids);
        $sql = "select aid from {$this->_table} where aid in ($aids)";
        $res = Models_AppProduct::init()->sql($sql);
        $ids = array();
        foreach($res as $v){
            $ids[] = $v['aid'];
        }
        return $ids;
    }
}
 