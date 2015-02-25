<?php
/**
 * 文库,第三方调用的控制器
 * @author michael
 *
 */
class Controllers_Wenku extends Cola_Controller
{
   
    /**
     * select的ajax请求
     * 取学段，学科，版本，年级
     */
    function selectAjaxAction(){
    	$id = (int)$this->getVar('id',0);
    	$k = new Models_Node();
    	$data = $k->getSubNode($id);
    	$this->renderJsonpData($data);
    }
    
    /**
     * 取单元节点
     * 需要参数年级ID
     * 
     */
    function unitAction(){
        $nj_id = (int)$this->getVar('id');
        $u = new Models_Interface_Unit();
        $data = $u->getListByNjId($nj_id);
        $this->renderJsonpData($data);
    }
    
 
    
}

