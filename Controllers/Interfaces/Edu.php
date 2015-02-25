<?php
/**
 * 教育关系对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Edu extends Controllers_Interfaces_Base 
{
    
    /**
     * 获取教育的资源关系
     */
    public function getResRelationAction(){
    	$xd = $this->getVar('xd');
    	$xk = $this->getVar('xk');
    	$bb = $this->getVar('bb');
    	$nj = $this->getVar('nj');
        $status = 'error';
        if(!$xd or !$xk or !$bb or !$nj){
            $this->abort(array('status'=>$status,'msg'=>'params error'));
        }
        $pid = (int)Modules_Admin_Models_NodeEdu::init()->getId($xd, $xk, $bb, $nj);
        $data = Modules_Admin_Models_NodeEdu::init()->getSubByPid($pid);
        $this->abort(array('status'=>'ok','data'=>$data ));
    }
    
}

?>