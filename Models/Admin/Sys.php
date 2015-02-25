<?php
/**
 * 系统管理
 * @author daishijiang
 *
 * @copyright  Copyright (c) 2013 Wuhan Bo Sheng Education Information Co., Ltd.
 *
 */
class Models_Admin_Sys extends Cola_Model
{
    function __construct ()
    {
        $this->_pk = 'uid';
        $this->_table = 'admin_user';
    }
    /**
     * 获取所有用户信息
     * @return array
     */
    function get_all_user(){
        $sql = "select * from admin_user";
        return $this->sql($sql);
    }
    
    /**
     * 获取某个用户信息
     * @return array
     */
    function get_user_info($uid){
        $sql = "select * from admin_user where uid = '$uid'";
        return $this->db->row($sql);
    }
    
    
}
