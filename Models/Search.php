<?php

/**
 * 全文索检
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Search extends Cola_Model
{

    public  static $s;
    
    /**
     * 
     * @param array $config
     * @return static | self
     */
    public static  function inits($config =null){
        $config or $config = Cola::getConfig('_resource_search');
        self::$s =  new Cola_Com_Search($config);
        
        $cls =   get_called_class();
        if(!isset(self::$_instance[$cls])){
            self::$_instance[$cls] = new static();
        }
        return self::$_instance[$cls];
 
    }
    
   
    
    
    /**
     * 更新索引内容
     * @param int $id
     * @param array $data
     * @return boolean
     */
    function update_index($id,$data){
       $s = self::$s;
       if(!$id){
           return false;
       }
       
        $d = $this->indexQuery(" id:{$id} ");
        $add = false;
        if(isset($d['data'][0])){
            $d = $d['data'][0];
            $d = current($d);
        }else{
            $d = array();
            $add = true;
        }



       $d['id']  = $id;
       
       if(!$data){
           return false;
       }
       foreach ($data as $k=>$v){
           $d[$k] = $v;
       }
       return $s->set($d,$add);
    }
    /**
     * 添加索引
     * @param array $data
     * @return boolean
     */
    function add_index($data){
        if(!$data){
            return false;
        }
       $s = self::$s;
        return (bool)$s->set($data);
    }
    /**
     * 删除索引
     * @param unknown_type $ids
     * @param unknown_type $type
     * @return boolean
     */
    function del_index($ids){
         $s = self::$s;
        return (bool) $s->delete($ids);
    }

    /**
     * 索引查询
     * @param string $where  索引查询条件
     * @param bool $is_fuzzy  开启模糊查询
     * @param string $sort_field 排序字段
     * @param bool $asc true|false 升|降序
     * @param bool $relevance_first   是否优先相关性排序, 默认为否
     * @param int $page 当前页数
     * @param int $pagesize 每页数量
     * @param bool $is_page  是否分页
     * @return multitype:array
     */
    function indexQuery($where,$is_fuzzy=false,$sort_field=null,$asc=false,$relevance_first=false,$page=1,$pagesize=20,$is_page=false,$addRange=""){
        $s = self::$s;
        
        $search = $s->getSearch()->search;
        
         $count = 0;
         $search->setFuzzy($is_fuzzy)->setQuery($where);
         if(isset($addRange[0])){
         	$search->addRange($addRange[0],$addRange[1],$addRange[2]);
         }
         if($is_page){
            $count = $search->count();
        }
        
        if($sort_field){
            $search->setSort($sort_field,$asc,$relevance_first);
        }
        if($is_page){
            $search->setLimit($pagesize, max(0, ($page-1)*$pagesize));
        }
        $docs =$search->search();
        return array('data'=>$docs,'count'=>$count);
    }
    
    function getSearchServer(){
        $s = self::$s;
    	return $s->getSearch()->search;
    }
    public function getSearch(){
        return  self::$s->getSearch()->search;
    }
    public function getIndex(){
        return self::$s->getSearch()->index;
    }
    /**
     * 更新搜索
     */
    public function flushIndex(){
        return  $this->getIndex()->flushIndex();
    }
    /**
     * 更新日志
     */
    public function flushLogging(){
        return  $this->getIndex()->flushLogging();
    }
    /**
     * 关闭连接
     */
    public function close(){
        return  $this->getIndex()->close();
    }
}
 