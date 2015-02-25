<?php
/**
 * 资源上传接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_Upload extends Models_Interface_Base {
     
    
    public function test(){
        
        $arr = array();
        $arr['doc_title'] = 'title';
        $arr['doc_summery'] = 'title';
        $arr['node_id'] = 'title';
        $arr['cate_id'] = '124';
        $arr['tags']['aaa'] = 'aaaa';
        $arr['is_hidden'] = '0';
        $arr['doc_soruce'] = '2';
        $arr['xd'] = 'xd001';
        $arr['xk'] = 'GS0024';
        $arr['bb'] = 'v11';
        $arr['nj'] = 'GO003';
        $arr['nid'] = '2';
        $arr['doc_credit'] = '2';
        $arr['role_id'] = '2';
        $arr['obj_type'] = 'lkt';
        $arr['obj_id'] = '1';
        $arr['cus_id'] = '2';
        return $arr;
        
        
        
    }
    
     /**
      * 上传资源
      * @param string $json 
      * @return Ambigous 
      * @example http://dev-wenku.dodoedu.com/interface/index/access_token/7f61f51e7d64b52b2097770360c8bbe4/c/Models_Interface_Upload/m/resource?json
      * {"doc_title":"title","doc_summery":"title","node_id":"title","cate_id":"124","tags":{"aaa":"aaaa"},"is_hidden":"0","doc_soruce":"2","xd":"xd001","xk":"GS0024","bb":"v11","nj":"GO003","nid":"2","doc_credit":"2","role_id":"2","obj_type":"lkt","obj_id":"1","cus_id":"2"}
      */
      public function resource($json){
          
          //定义上传的参数
          $post = array();
          //return $json;
          if($json){
              $json_arr = json_decode($json,1);
          }
         // return $json_arr;
          //var_dump($json_arr);
          if($json_arr){
            $post += $json_arr;
          }else{
              return $this->rtnArr('error', '上传参数为空，或者有错误!');
          }
          //return $post;
         // var_dump($post);
          //die;
          //return $_FILES;
          if(!$_FILES['file1']['size']){
             return  $this->rtnArr('error', '上传资源文件大小不能为空');
          }
          $fileName = $_FILES['file1']['name'];
          $fileExt = pathinfo($fileName,PATHINFO_EXTENSION);
          $cate_id = isset($json_arr['cate_id'])?$json_arr['cate_id']:1;
          if(!Models_Upload::init()->checkFileType($cate_id, $fileExt)){
              return $this->rtnArr('error', '不支持此资源文件类型');
          }
          
          $file_path = $_FILES['file1']['tmp_name'];
          $file_path2 = $_FILES['file1']['tmp_name'].'.'.$fileExt;
          $file_size = $_FILES['file1']['size'];
          if(is_uploaded_file($file_path)){
              move_uploaded_file($file_path, $file_path2);
          }else{
             return  $this->rtnArr('error','文件上传失败');
          }
          
          //定义上传的文件 
          $files = array();
          $files[0]['file_path'] = $file_path2;
          $files[0]['file_name'] = $fileName;
          $files[0]['file_ext'] = $fileExt;
          $post['file_size'] = $file_size;
          
          //通过node_id 找出xd,xk 的code
          if(!$post['xd'] and $post['node_id']){
              $node_arr = Models_Node::init()->getParentCodeById($post['node_id']);
              $post = array_merge($post, $node_arr);
          }
          
          //$post['node_id']>80000 or
          if(!isset($post['zs']) and $post['node_id']){
              if($post['node_id']>80000){
                  $post['cate_id'] = 1;
                  //专业资源tree node
                  $post['pid_path'] = Modules_Admin_Models_NodeCate::init()->getPidPath($post['node_id']);
              }else{
                  //标准资源，但是没有知识节点的 tree node
                  $post['pid_path'] = Modules_Admin_Models_NodeKind::init()->getPidPath($post['node_id']);
              }
          }elseif(isset($post['zs'])){
              //知识节点的父ID
              $post['pid_path'] = Modules_Admin_Models_UnitNode::init()->getPidPath($post['zs']);
          }
          
         $res =  Models_Upload::init()->uploadData($files, $post);
         return $this->rtnArr('success', '上传成功',$res);
      }
      
      
 
      
}