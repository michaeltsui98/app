<?php
/**
 * 基础节点对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Node extends Controllers_Interfaces_Base 
{

    /**
     * 取资源类型
     */
    public function getResourceTypeAction(){
    	$this->abort(Cola::$_config->get('_resourceType'));
    }
    /**
     * 可上传的文件类型
     */
    public function getFileTypeAction(){
    	$this->abort(Cola::$_config->get('_resourceFileType'));
    }
    /**
     * 取年级
     */
    public function getNjAction(){
    	$this->abort(Cola::$_config->get('_nj'));
    }
    /**
     * 取版本
     */
    public function getBbAction(){
    	$this->abort(Cola::$_config->get('_bb'));
    }
    /**
     * 取学科
     */
    public function getXkAction(){
    	$this->abort(Cola::$_config->get('_xk'));
    }
    /**
     * 所能的基础节点
     */
    public function getTreeNodeAction(){
        $pid = $this->getVar('pid',0);
        $this->abort(Modules_Admin_Models_NodeKind::init()->getList(1, 1000,$pid));
    }
    
    
    /**
     * 获取基础子节点为的json
     */
    public function getSubNodeAction(){
        $b = new Models_Node();
        $id = (int)$this->getVar('id');
        $arr1 = $b->getSubNode($id);
        $node = Models_Public_Node::getAllNode();
         
        foreach ($arr1 as $k=>$v){
            $arr1[$k]['name'] = $node[$v['code']];
        }
        $this->abort($arr1);
    }
    
    /**
     * 获取基础节点信息
     */
    public function getNodeInfoByIdAction(){
        $b = new Models_Node();
        $id = (int)$this->getVar('id');
        $arr1 = $b->load($id);
        $this->abort($arr1);
    }
    
    /**
     * 学段，学科编号来取版本信息
     */
    public function getBbByXdAndXkAction(){
        $init_xd = $this->getVar('xd');
        $node = new Models_Node();
        $init_xd_id = $node->getXdIdByCode($init_xd);
        $init_xk_arr = $node->getSubNode($init_xd_id);
        $init_xk = $this->getVar('xk');
        $init_xk_id = 0;
        foreach ($init_xk_arr as $v){
            if($v['code'] == $init_xk){
                $init_xk_id= $v['id'];
            }
        }
        $this->abort($node->getSubNode($init_xk_id));
    }
    /**
     * 取节点ID
     */
    public function getNodeInfoByXdXkBbNjAction(){
        $xd = $this->getVar('xd');
        $xk = $this->getVar('xk');
        $bb = $this->getVar('bb');
        $nj = $this->getVar('nj');
    	$sql = "SELECT d.* FROM `node_kind` a
                left join node_kind b
                on a.id = b.pid
                left join node_kind c 
                on b.id = c.pid
                left join node_kind d
                on c.id = d.pid 
                where
                 a.`code` = '$xd'
                and b.`code` = '$xk'
                and c.`code` = '$bb'
                and d.`code` = '$nj'";
    	$this->abort(Cola_Model::init()->db->row($sql));
    }
    /**
     * 取知识节点
     */
    public function getUnitAction(){
        $xd = $this->getVar('xd');
        $xk = $this->getVar('xk');
        $bb = $this->getVar('bb');
        $nj = $this->getVar('nj');
        $type = $this->getVar('type','option');
        $select = $this->getVar('select');
        $res = Models_Unit::init()->getUnit($xd, $xk, $bb, $nj,$type,$select);
        $this->abort($res['rows']);
    }
    /**
     * 取知识子节点
     */
    public function getSubUnitAction(){
        $id = $this->getVar('id');
        $res = Models_Unit::init()->getSubUint($id);
        $this->abort($res['rows']);
    }
    /**
     * 取知识节点标题
     */
    public function getUnitTitleByIdAction(){
        $id = $this->getVar('id');
        $res = Models_Unit::init()->getUnitNameById($id);
        $this->abort(array('data'=>$res));
    }
    /**
     * 取节点信息
     */
    public function getUnitInfoByIdAction(){
        $id = $this->getVar('id');
        $filed = $this->getVar('filed','*');
        $sql = "select $filed from unit_node where id = '$id'";
        $res = Models_Unit::init()->db->row($sql);
        $this->abort(array('data'=>$res));
    }
    
    
    
}

?>