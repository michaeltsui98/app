<?php
/**
 * 
 * @author michael
 * 
 */
class Orm_SchLog extends  Cola_Orm  {

    
    
    /**
     * @var 设置表名
     */
    protected $table = 'sch_log';
    /**
     * @var 设置主键名
     */
    protected $primaryKey = 'log_id';
    
    /**
     * 重置数据库连接
     */
   // protected $connection = "dev";
    
    public $timestamps = false;  
    
    public function getLog($id=1){
        return $this->whereRaw("id = ?",array($id))->get()->toArray();
    }
    
    
    
    
     

}