<?php
/**
 * 投诉建议
 * @author daishijiang
 *
 * @copyright  Copyright (c) 2013 Wuhan Bo Sheng Education Information Co., Ltd.
 *
 */
class Models_Admin_Ts extends Cola_Model
{
    function __construct ()
    {
        $this->_pk = 'id';
        $this->_table = 'user_ts';
    }
    /**
     * 获取所有投诉信息
     * @return array
     */
    function get_all_ts(){
        $sql = "select * from user_ts";
        return $this->sql($sql);
    }   
}
