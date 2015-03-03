<?php

/**
 * app渠道
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_AppChannel extends Cola_Model
{

    protected  $_table = 'app_channel';
    protected  $_pk = 'id';

    public function getChannelIds($ids){
        $aids = implode(',',$ids);
        $sql = "select cid from {$this->_table} where cid in ($aids)";
        $res = Models_AppProduct::init()->sql($sql);
        $ids = array();
        foreach($res as $v){
            $ids[] = $v['cid'];
        }
        return $ids;
    }
     
}
 