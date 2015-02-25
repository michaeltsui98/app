<?php

/**
 * 用户关系
 * @author michael
 * @version 1.0 2013/10/23
 */
class Models_UserRelation extends Cola_Model
{
     
    protected $_pk = 'id';

    protected $_table = 'user_relation';

    /**
     * 保存用户，班级，学校关系
     */
    function save_relation(){
        $study = $_SESSION['user']['study'];
        if(!$study){
            return false;
        }
        $uid = $_SESSION['user']['user_id'];
        foreach ($study as $k=>$v){
            $school_id = $v['school_id'];
            $class_id = $v['class_id'];
            $count = $this->count("uid= '$uid' and class_id = '$class_id' and school_id = '$school_id' ");
            
            //如果关系存就跳出,否则就生成关系
            if($count){
                continue;
            }else{
                $this->insert(array('uid'=>$uid,'class_id'=>$class_id,'school_id'=>$school_id));
            }     
        }
    }
    
}

 