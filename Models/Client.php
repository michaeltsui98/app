<?php
/**
 *  client业务封装
 * @author    michael
 * @modify    2014-07-08
 * @copyright Copyright (c) 2012 Wuhan Bo Sheng Education Information Co., Ltd.
 * @version 1.2
 */
class Models_Client extends Models_DDClient
{

    public $is_debug = FALSE;
    
    /**
     * 获得用户的基本资料http请求
     */
    public function getUserInfo()
    {
      return Models_DDClient::getInstance()->getDataByApi('user/base', array(),$this->is_debug);  
    }

    /**
     * 获得用户详细资料curl
     * @return array
     */
    public function getUserCompleteInfoCurl()
    {
       $data =  Models_DDClient::getInstance()->getDataByApi('user/complete', array(),$this->is_debug);
       return $data['data'];
    }
    /**
     * 获取主站多多社区的session 信息
     * @return mixed
     */
    public function getMainSession()
    {
        $data =  Models_DDClient::getInstance()->getDataByApi('user/getmainsession', array(),$this->is_debug);
        return $data['data'];

    }

    /**
     * 获取用户绑定的翼学通号码
     */
    public function getUserEStudyNumber()
    {
        $data =  Models_DDClient::getInstance()->getDataByApi('user/estudynumber', array(),$this->is_debug);
        return $data['data'];
    }

    /**
     * 根据ID查找个人资料
     * @param string      $userId
     */
    public function searchUserInfo($userId)
    {
        $data =  Models_DDClient::getInstance()->getDataByApi('user/searchuserinfo', array(),$this->is_debug);
        return $data['data'];
    }
    /**
     * 不登录取用户信息
     * @param string $uid
     */
    function viewUserInfo($uid)
    {
        $param['app_key'] = DD_AKEY;
        $param['user_id'] = $uid;
        $data =  Models_DDClient::getInstance()->getDataByApi('user/viewuserinfo', $param,$this->is_debug);
        if(isset($data['errcode']) and $data['errcode']){
            return array();
        }
        return  $data['data']; 
    }

    /**
     * 获取学校信息
     * @param string $uid
     * @return Ambigous <string, mixed, multitype:unknown mixed string number >
     */
    public function getSchoolInfo($uid)
    {
        $param['user_id'] = $uid;
        $data =  Models_DDClient::getInstance()->getDataByApi('school/schoolinfo', $param,$this->is_debug);
        return  $data['data'];
    }

    /**
     * 添加标签
     * @param array $param     target_id,target,tags_array,creater_id
     * @return mixed
     */
    function add_tag($param)
    {
        if(empty($param)){
        	return false;
        }
        $data =  Models_DDClient::getInstance()->getDataByApi('tag/updatetagrelation', $param,$this->is_debug);
        return  $data['data'];
    }

    function get_tag($target_id, $target)
    {
        $param = array();
        $param['target_id'] = $target_id;
        $param['target'] = $target;
        $data =  Models_DDClient::getInstance()->getDataByApi('tag/gettagrelation', $param,$this->is_debug);
        return  $data['data'];
    }
    /**
     * 删除标签
     * @param int $target_id
     * @param string $target
     * @return mixed
     */
    function del_tag($target_id, $target)
    {
        $param = array();
        $param['target_id'] = $target_id;
        $param['target'] = $target;
        $data =  Models_DDClient::getInstance()->getDataByApi('tag/deltagrelation', $param,$this->is_debug);
        return  $data['data'];
    }
    /**
     * 发送消息 
     * @param array $param
     * @return Ambigous <>
     */
    function push_msg(array $param)
    {
        $data =  Models_DDClient::getInstance()->getDataByApi('message/pushmessagebycustom', $param,$this->is_debug);
        return  $data['status'];
    }
    /**
     * 取指定用户的网盘信息
     * @param string $uid            
     * @return mixed
     */
    function get_disk_info($uid)
    {
        $param['obj_id'] = $uid;
        $data =  Models_DDClient::getInstance()->getDataByApi('disk/getdiskinfo', $param,$this->is_debug);
        return  $data['data'];
    }

    /**
     * 添加文件到 网盘
     *
     * @param int $disk_id            
     * @param string $user_id            
     * @param string $file_key            
     * @param int $file_ori_size            
     * @param string $file_name            
     * @param string $file_ext            
     * @param int $dir_id            
     * @return mixed $disk_id,$file_id
     */
    function add_disk_file($disk_id, $user_id, $file_key, $file_ori_size, $file_name,
        $file_ext, $dir_id = 0)
    {
         
        $param['dir_id'] = $dir_id;
        $param['disk_id'] = $disk_id;
        $param['user_id'] = $user_id;
        $param['file_key'] = $file_key;
        $param['file_ori_size'] = $file_ori_size;
        $param['file_name'] = $file_name;
        $param['file_ext'] = $file_ext;
        $param['is_share'] = 1;
        $data =  Models_DDClient::getInstance()->getDataByApi('disk/adddiskfile', $param,$this->is_debug);
        return  $data['data'];
        
    }
    /**
     * 更新网盘信息
     * @param int $disk_id
     * @param int $file_id
     * @param array $data
     * @return mixed
     */
    function update_disk_file($disk_id, $file_id, $data)
    {
        $param['disk_id'] = $disk_id;
        $param['file_id'] = $file_id;
        $data =  Models_DDClient::getInstance()->getDataByApi('disk/updatediskfile', $param,$this->is_debug);
        return  $data['data'];
    }

    /**
     * 获取网盘文件信息
     *
     * @param int $disk_id            
     * @param int $file_id            
     * @return mixed
     */
    function get_disk_file($disk_id, $file_id)
    {
        $param['disk_id'] = $disk_id;
        $param['file_id'] = $file_id;
        $data =  Models_DDClient::getInstance()->getDataByApi('disk/getdiskfile', $param,$this->is_debug);
        return  $data['data'];
    }
    /**
     * 删除网盘文件
     * @param string $uid
     * @param int $disk_id
     * @param int $file_id
     * @return mixed
     */
    function del_disk_file($uid, $disk_id, $file_id)
    {
        $param['uid'] = $uid;
        $param['disk_id'] = $disk_id;
        $param['file_id'] = $file_id;
        $data =  Models_DDClient::getInstance()->getDataByApi('disk/delfile', $param,$this->is_debug);
        return  $data['data'];
    }
    /**
     * 获取小站信息,公共接口，不需要token
     * @param     $elementId 组件ID
     * @param     $elementType 组件类型： Blog | Album| Forum
     * @param int $limit 获取的条数
     * @return Ambigous <string, mixed, multitype:unknown mixed string number >
     */
    public function getSiteInfo($elementId = '72662181', $type = 'Forum', $limit =
        10)
    {
        $param['element_id'] = $elementId;
        $param['element_type'] = $type;
        $param['limit'] = $limit;
        $data =  Models_DDClient::getInstance()->getDataByApi('site/getsiteelementdata', $param,$this->is_debug);
        return  $data['data'];
    }
    /**
     * 添加文件到网盘
     * @param int $disk_id
     * @param int $dir_id
     * @param string $file 文件物理路径
     * @param string $obj_id  uid,class_id,school_id  //用来验证数据一致性的
     * @throws Exception
     * @return mixed
     */
    public function filePostSchoolDisk($disk_id, $dir_id, $file, $obj_id, $file_name)
    {
        $token = Models_DDClient::getInstance()->getToken();
        $data = array(
            'disk_id' => $disk_id,
            'dir_id' => $dir_id,
            'file' => '@' . $file,
            'obj_id' => $obj_id,
            'file_name' => $file_name,
            'is_share' => 1);
        $data += array('access_token' => $token['access_token'], 'refresh_token' => $token['refresh_token']);
        $url = DOMAIN_NAME . '/DDApi/disk/addschoolfile';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        $query = json_decode($result, 1);
        
        if (isset($query['errcode']) && $query['errcode']>0) {
            throw new Exception("error:disk/addschoolfile." . var_export($data, 1) .
                var_export($query, 1));
        }
        return $query;
    }
  


}
