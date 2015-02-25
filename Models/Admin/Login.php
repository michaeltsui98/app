<?php

class Models_Admin_Login extends Cola_Model
{

    /**
     * 判断用户是否登录 
     * @param string $user_name
     * @param string $pwd
     * @return boolean
     */
    function check_login($user_name,$pwd){
        $sql = "select count(*) from admin_user where username= '$user_name'  and pwd = '$pwd'";
        return (bool) $this->db()->col($sql);
    }
    /**
     * 获取管理员的用户信息
     * @param string $user_name
     * @return array
     */
    function get_user_info($user_name,$is_uid=false){
        if($is_uid){
            $sql = "select * from admin_user where uid= '$user_name'";
        }else{
            $sql = "select * from admin_user where username= '$user_name'";
        }
        return  $this->db()->row($sql);
    }
    
    
}
