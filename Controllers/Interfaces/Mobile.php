<?php
/**
 * 文档对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Mobile extends Controllers_Interfaces_Base 
{
    
    /**
     * 获取学校的文档信息
     */
    public function getDocListBySchoolAction(){
    	$school_id = $this->getVar('school_id');
        $status = 'error';
        if(!$school_id){
            $this->abort(array('status'=>$status,'msg'=>'school_id is empty'));
        }
        $this->getDocData();
    }
   
}

?>