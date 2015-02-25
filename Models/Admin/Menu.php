<?php

class Models_Admin_Menu extends Cola_Model
{

    protected $_table = 'sys_module';

    /**
     * 按父ID查找菜单子项
     *
     * @param integer $parentid
     *            父菜单ID
     * @param integer $with_self
     *            是否包括他自己
     * @return array 返回用户有权限的菜单数组
     */
    public function getMenu ($parentid, $with_self = 0)
    {
         
            
            $key = $this->cache_key('getMenu',array($parentid,$with_self));
            $result = $this->cache()->get($key);
            if(!$result){
                $parentid = intval($parentid);
                $result = $this->sql(
                        "SELECT * FROM $this->_table WHERE module_fid={$parentid} AND module_show=1 ORDER BY module_order ASC;");
                if ($with_self) {
                    $result2[] = $this->db->row(
                            "SELECT * FROM $this->_table WHERE id={$parentid}");
                    $result = array_merge($result2, $result);
                }
                
                $this->cache()->set($key,$result);
            }
            
            return $result;
            
       
    }

    /**
     * 根据菜单id获取当前位置
     *
     * @param integer $menuid
     *            菜单id
     * @return string 返回当前位置字符串
     */
    public function getCurrentPos ($id)
    {
         
            $key = $this->cache_key('getCurrentPos',array($id));
            $data = $this->cache()->get($key);
            if(!$data){
                $data = $this->db->row(
                        "SELECT id, module_title, module_fid FROM $this->_table WHERE id='{$id}'");
                $str = '';
                if ($data['module_fid']) {
                    $str = $this->getCurrentPos($data['module_fid']);
                }
                $this->cache()->set($key,$data);
            }
            return $str . $data['module_title'] ;
    }

    /**
     * 获取所有菜单
     *
     * @param string $fields
     *            要回返的字段
     */
    public function getAllMenu ($fields = '*')
    {
        $data = $this->sql(
                "SELECT {$fields} FROM $this->_table ORDER BY module_order ASC,id DESC");
        return $data;
    }

    /**
     * 取出最新的一期目录名称和ID
     */
    public function getLatestMenuInfo ()
    {
        $latestMenuInfoSql = "SELECT * from `menu_info` WHERE `menu_is_available`=1  ORDER BY `menu_id` DESC LIMIT 0,1";
        $latestMenuInfoResult = $this->sql($latestMenuInfoSql);
        return (array) $latestMenuInfoResult;
    }

    /**
     * 取出最新的一期目录名称和ID
     */
    public function getTop5MenuInfo ()
    {
        $latestMenuInfoSql = "SELECT * from `menu_info` WHERE `menu_is_available`=1 ORDER BY `menu_id` DESC  LIMIT 0,5";
        $latestMenuInfoResult = $this->sql($latestMenuInfoSql);
        return (array) $latestMenuInfoResult;
    }

    /**
     * 期号分页取出
     */
    public function getMenusList ($in_page = 1, $in_limit = 20)
    {
        $page = intval($in_page);
        $limit = intval($in_limit);
        
        try {
            $totalSql = "SELECT count(*) as `total_items` from `menu_info` ";
            $totalResult = $this->sql($totalSql);
            $totalItems = $totalResult[0]['total_items'];
            $totalPages = ceil($totalItems / $limit);
            if ($totalPages == 0) {
                $totalPages = 1;
            }
            if ($page > $totalItems)
                $page = $totalPages;
            $start = ($page - 1) * $limit;
            
            $menuListSql = "SELECT * from `menu_info`  ORDER BY `menu_id` DESC LIMIT {$start}, {$limit}";
            $menuListResult = $this->sql($menuListSql);
            
            $resultArray = array(
                    'result' => (array) $menuListResult,
                    'totalItems' => $totalItems
            );
            return (array) $resultArray;
        } catch (Exception $e) {
            echo $e;
        }
    }
    
    // 增加期号的方法
    public function addMenu ($in_menuName)
    {
        $menuName = $this->escape($in_menuName);
        $addMenuSql = "INSERT INTO `menu_info` (`menu_name`,`menu_is_available`) VALUES ('" .
                 $menuName . "',1) ";
        $addMenuResult = $this->sql($addMenuSql);
        return $addMenuResult;
    }
    
    // 单独修改有效期
    public function modifyMenuAvailable ($in_menuId, $in_menuAvailable)
    {
        $menuId = intval($in_menuId);
        $menuAvailable = intval($in_menuAvailable);
        $modifyMenuAvailableSql = "UPDATE `menu_info` SET `menu_is_available` = " .
                 $menuAvailable . " WHERE `menu_id`=" . $menuId . " ";
        try {
            $modifyMenuAvailableResult = $this->sql($modifyMenuAvailableSql);
            return $modifyMenuAvailableResult;
        } catch (Exception $e) {
            echo $e;
        }
    }
    
    // 单独修改名称
    public function modifyMenuName ($in_menuId, $in_menuName)
    {
        $menuId = intval($in_menuId);
        $menuName = $this->escape($in_menuName);
        
        $modifyMenuAvailableSql = "UPDATE `menu_info` SET `menu_name` = '" .
                 $menuName . "' WHERE `menu_id`=" . $menuId . " ";
        try {
            $modifyMenuAvailableResult = $this->sql($modifyMenuAvailableSql);
            return $modifyMenuAvailableResult;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getSingleMenu ($in_menuId)
    {
        $menuId = intval($in_menuId);
        $singleMenuSql = "SELECT * FROM `menu_info` WHERE `menu_id`=" . $menuId .
                 " ";
        try {
            $singleResult = $this->sql($singleMenuSql);
            return (array) $singleResult;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function deleteMenus ($in_menuId)
    {
        $menuId = intval($in_menuId);
        $delSql = "DELETE FROM  `menu_info` WHERE `menu_id`=" . $menuId;
        try {
            $delResult = $this->sql($delSql);
            return $delResult;
        } catch (Exception $e) {
            echo $e;
        }
    }
}