<?php
/**
 * 文档对外的接口类
 * @author michael
 *
 */
class Controllers_Interfaces_Upload extends Controllers_Interfaces_Base 
{
    
    
    /**
     * 资源上传接口
     */
    public function resUploadAction(){
        $sid = $this->getVar('PHPSESSID');
        if($sid){
            if(session_id()!=$sid){
                session_destroy();
                session_id($sid);
                session_start();
            }
        }
        
        $status = 'error';
        if(!$_FILES){
            $this->abort(array('status'=>$status,'msg'=>'FILES is empty'));
        }
        $file_name = $this->getVar('file_name');
        
        $files = array();
        $file = $_FILES['file'];
        $file_path = $file['tmp_name'];
        $fileExt = pathinfo($file_name,PATHINFO_EXTENSION);
        $file_path2 = $file['tmp_name'].'.'.$fileExt;
        $file_size = $file['size'];
        if(is_uploaded_file($file_path)){
            move_uploaded_file($file_path, $file_path2);
        }
        $files[$file_path2] = $file_name; 
        $_SESSION['tmp_file'][] = $file_path2;
        $this->abort($files);
    }
     
}

?>