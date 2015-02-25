<?php
/**
 * 自定义分类接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_CusCate extends Models_Interface_Base {
     
      /**
       * 添加自定义分类
       * @param string $name  分类名称
       * @param int $pid 默认为0
       * @param string $obj_id
       * @param string $obj_type
       * @return Ambigous <number, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_CusCate/m/add?name=test&pid=0&obj_id=1&obj_name=site
       */
      public function add($name,$pid, $obj_id, $obj_type){
          return Models_CusCate::init()->addCate($name,$pid, $obj_id, $obj_type);
      }
      /**
       * 修改分类
       * @param int $id  分类id
       * @param string $name
       * @param string $pid
       * @return Ambigous <Ambigous, multitype:, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_CusCate/m/edit?id=6&name=ccc&pid=0
       */
      public function edit($id,$name,$pid=null){
          return Models_CusCate::init()->editCateById($id, $name, $pid);
      }
      /**
       * 删除分类
       * @param int $id 自定义分类
       * @return Ambigous <boolean, unknown>|multitype:string
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_CusCate/m/del?id=6
       */ 
      public function del($id){
          $count = Models_Resource::init()->count("cus_id = '$id'");
          if($count==0){
              return Models_CusCate::init()->delete($id);
          }else{
              return array('status'=>'error','msg'=>'该分类下还有资源存在，无法删除!');
          }
      }
      
      /**
       * 取自定义分类
       * @param string $obj_id
       * @param string $obj_type
       * @return Ambigous <multitype:, boolean, multitype:Ambigous, multitype:unknown Ambigous <multitype:, boolean> >
       * @example  http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_CusCate/m/getCate?obj_id=1&obj_type=site
       */
      public function getCate($obj_id,$obj_type){
          return Models_CusCate::init()->getCate($obj_id, $obj_type);
      }
      public function getCusCateBySql($obj_id,$obj_type){
          return Models_CusCate::init()->getCateBySql($obj_id, $obj_type);
      }
      
}