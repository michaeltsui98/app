<?php

/**
 * 自定义分类
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_CusCate extends Cola_Model
{

    protected  $_pk = 'id';
    protected  $_table = 'cus_cate';
    

    /**
     * 读取自定分类
     * @param string $obj_id 对象ID
     * @param string $obj_type  对象类型
     * @return array
     */
    public  function getCate($obj_id,$obj_type){
        $sql = "select * from {$this->_table} where obj_id = '$obj_id' and obj_type='$obj_type'";
        return  $this->getListBySql($sql, 1, 1000,'tree','id','pid','name');
    }
    /**
     * 直接取数据库
     * @param string $obj_id 对象ID
     * @param string $obj_type  对象类型
     * @return Ambigous <multitype:, boolean>
     */
    public  function getCateBySql($obj_id,$obj_type){
        $sql = "select * from {$this->_table} where obj_id = '$obj_id' and obj_type='$obj_type' order by id asc";
        return  $this->sql($sql);
    }
    /**
     * 添自定义分类
     * @param string $name  分类名称
     * @param int $pid 父分类ID  默认为0
     * @param string $obj_id  对象ID
     * @param string $obj_type  对象类型
     * @return int
     * 
     */
    public function addCate($name,$pid=0,$obj_id,$obj_type){
        $sql = "select id from $this->_table where name='$name' and pid='$pid' and obj_id='$obj_id' and obj_type='$obj_type'";
        $id = $this->db->col($sql);
        if($id){
            return $id;
        }
        $data = array('name'=>$name,'pid'=>$pid,'obj_id'=>$obj_id,'obj_type'=>$obj_type);
        $id = $this->insert($data);
        $this->updatePidPath($id);
        return $id;
    }
    /**
     * 编辑分类
     * @param string $name  分类名称
     * @param int $pid 父分类ID  默认为0
     * @param string $obj_id  对象ID
     * @param string $obj_type  对象类型
     * @return Ambigous <multitype:, boolean>
     */
    public function editCateByObj($name,$pid,$obj_id,$obj_type){
        $sql = "update  `cus_cate` set 
                `name` = '$name',pid = '$pid',
                pid_path = genCusPidPath(id)
                where 
                obj_id = '$obj_id' and obj_type = '$obj_type'";
        return $this->sql($sql);        
    }
    /**
     * 编辑分类
     * @param int $id
     * @param string $name
     * @param int $pid
     * @return Ambigous <multitype:, boolean>
     */
    public function editCateById($id,$name,$pid=0){
        $setpid = '';
        if((int)$pid>0){
            $setpid = ",pid = '$pid'";
        }
        $sql = "update  `cus_cate` set 
                `name` = '$name' $setpid,
                pid_path = genCusPidPath(id)
                where 
                id = '$id'";
        return $this->sql($sql);        
    }
    
    /**
	 * 更新pidPath
	 * @param int $id
	 * @return Ambigous <multitype:, boolean>
	 */
	public function updatePidPath($id){
	    return $this->sql("update {$this->_table} set pid_path = genCusPidPath($id) where id = '$id' ");
	}

    /**
     * 删除用户自定义分类，删除前先判断下面是不是有新的资源
     * @param $id
     * @return array
     */
	public function del($id){
          $sql = "delete a.* from cus_cate a left join cus_user_resource b
                    on a.id = b.cus_id
                    where a.id = '$id' and b.id is null ";
	    return $this->sql($sql);
	}


    
    
     
     
}
 