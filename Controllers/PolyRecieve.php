<?php
/**
 * 保利威视，回调接收器
 * @author michael
 *
 */

class Controllers_PolyRecieve extends Cola_Controller
{
    /**
     * @example vid：视频id
     *   type：回调类型
     *   pass: 通过
     *  nopass: 未通过
     *   del: 删除
     *  @example  vid 视频id
     *  df 视频清淅度版本，1为流畅、2为高清、3为超清。
     */
    public function indexAction(){
        
       // Cola_Com_Log::factory('File')->log(var_export($this->getVar()));
          
        file_put_contents(S_ROOT.'/log/log.txt', var_export($this->get(),1).date('Y-m-d H:i:s') . "\n", FILE_APPEND | LOCK_EX);
         $vid = $this->getVar('vid');
         if(!$vid){
             return false;
         }
         $type = $this->getVar('type');
         $df = $this->getVar('df');
         if($type){
             //doc_status  0=>"转换中",1=>"转换完成",2=>"转换失败",3=>'内容相同'
             switch ($type) {
                 case 'pass':
                   $status = '60';
                   $doc_status = '1';  
                 break;
                 case 'nopass':
                 case 'del':
                   $status = '51';  
                   $doc_status = '2';  
                 break;
             }
             //更新视频状态
             Models_Video::init()->update($vid, array('status'=>$status));
             
             //更新资源状态
             $sql = "update `resource_file` a 
                        left join resource b
                        on a.file_id = b.file_id
                        set b.doc_status = '$doc_status'
                        where a.file_key = '$vid'";
             Models_Resource::init()->sql($sql);
             
         }
         
         //更新视频码流
         if($df){
             Models_Video::init()->update($vid, array('df'=>$df));
         }
    }
}

 