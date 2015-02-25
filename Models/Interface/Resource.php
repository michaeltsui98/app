<?php
/**
 * 接口接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_Resource extends Models_Interface_Base {
     
      /**
       * 根据对象对资源列表,用于取小站
       * @param string $obj_id 对象ID
       * @param string $obj_type 对象类型
       * @param string $cus_id 自定义分类
       * @param string $status 资源状态
       * @param string $page 当前页数
       * @param string $limit 条数
       * @return Ambigous <number, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c
       * /Models_Interface_Resource/m/getListByObj?obj_id=64181726&obj_type=site&cus_id=19&status=1&page=1&limit=10
       */
      public function getListByObj($obj_id,$obj_type, $cus_id,$status,$page,$limit){
          $where  = '';
          if(empty($status)==false){
              $where .= "and a.doc_status = '$status'";
          }
          $sql = "SELECT a.doc_id,a.doc_title,a.doc_status,a.on_time,a.uid,a.user_name
                    ,a.xd,a.xk,a.bb,a.nj,a.node_id,a.nid,b.doc_ext_name,b.doc_page_key,b.doc_pages
                    FROM `resource` a left join 
                    resource_file b 
                    on a.file_id = b.file_id
                    where a.obj_id = '$obj_id' and a.obj_type = '$obj_type'
                    and cus_id = '$cus_id' $where";
          
          return $this->getListBySql($sql, $page, $limit);
      }
      /**
       * 取第三方的标准资源列表
       * @param string $obj_type
       * @param string $obj_id
       * @param string $xd
       * @param string $xk
       * @param string $bb
       * @param string $nj
       * @param int $unit_id
       * @param number $type
       * @param string $order_field
       * @param string $order
       * @param number $page
       * @param number $limit
       * @return Ambigous <number, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c
       * /Models_Interface_Resource/m/getStandResourceByObj?obj_id=64181726&obj_type=site&cus_id=19&status=1&page=1&limit=10 
       */      
      public function getStandResourceByObj($obj_type,$obj_id,$xd,$xk,$bb,$nj,$unit_id,$type=0,$order_field='doc_id',$order='desc',$page=1,$limit=20){
         return Models_Resource::init()->getStandResourceByObj($obj_type,$obj_id,$xd,$xk,$bb,$nj,$unit_id,$type,$order_field,$order,$page,$limit);
      }
      /**
       * 取第三方上传的资源，包括标准资源与非标准资源
       * @param string $obj_id
       * @param string $obj_type
       * @param int $cate_id
       * @param number $cus_id
       * @param string $doc_title
       * @param number $page
       * @param number $limit
       * @return Ambigous <boolean, Ambigous, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
       */
      public function getObjUploadResource($obj_id,$obj_type,$cate_id,$source,$cus_id,$doc_title='',$page=1,$limit=20){
         return Models_Resource::init()->getObjUploadResource($obj_id,$obj_type,$cate_id,$source,$cus_id,$doc_title,$page,$limit);
      }
      /**
       * 校本资源列表 或者第三方的一非标准资源列表
       * @param string $obj_type
       * @param string $obj_id
       * @param string $cus_id
       * @param string $cate_id
       * @param string $order_field
       * @param string $order
       * @param string $page
       * @param string $limit
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Resource/m/getNoStandResourceByObj?obj_type=school&obj_id=121502&cus_id=21&cate_id=0&order_field=doc_id&order=desc&page=1&limit=10
       */
      public function getNoStandResourceByObj($obj_type,$obj_id,$cus_id,$cate_id,$order_field,$order,$page=1,$limit=20){
          $where = "";
          if($obj_type){
              $where .= " and b.obj_type = '$obj_type'";
          }
          if($obj_id){
              $where .= " and b.obj_id = '$obj_id'";
          }
          if($cate_id){
              $where .= " and b.cate_id = '$cate_id'";
          }
          $where .= " and b.doc_status in(1,3) ";
          if($cus_id){
            $sql = "select b.*,c.doc_ext_name,c.doc_page_key,c.doc_pages,c.file_size from (
                      select id from cus_cate where FIND_IN_SET('$cus_id',pid_path)
                    ) a 
                    left join resource b 
                    on b.cus_id = a.id
                    left join resource_file c
                    on b.file_id  = c.file_id
                    where 1 $where  order by $order_field $order ";
          }else{
              $sql = "select b.*,c.doc_ext_name,c.doc_page_key,c.doc_pages,c.file_size from  
                      resource b
                      left join resource_file c
                      on b.file_id  = c.file_id
                      where 1 $where  order by $order_field $order ";
          }
          //return $sql;
          return $this->getListBySql($sql, $page, $limit);
      }
      /**
       * 取资源状态配置
       * @return multitype:string
       */
      public function getResourceStatus(){
          return Models_Resource::$doc_status;
      }
      
      
      /**
       * 取资源类型
       * @return Ambigous <Cola_Config, mixed, multitype:, unknown>
       */
      public function getResourceType(){
          return Cola::getConfig('_resourceType');
      }
      
      /**
       * 取资源下载地址，给接口用的
       * @param int $id
       * @param string $user_id
       * @return string
       */
      public  function getResourceUrl($id,$user_id){
          $uid = $user_id;
          if(!$id){
              return  array('status'=>-1,'msg'=>'资源ID不能为空');
          }
          $doc = new Models_Resource();
          $doc_info = $doc->get_doc_info($id);
          $key = $doc_info['file_key'];
          $url = $doc->get_file_url($key, $doc_info['doc_file_name']);
          if(!$uid){
              return array('status'=>-1,'msg'=>'请先登录!');
          }
          if(!$url){
              return array('status'=>-1,'msg'=>'要下载的文件找不到了!');
          }
          //自己下自己的不生成记录
          if($uid == $doc_info['uid']){
              return array('status'=>1,'msg'=>'is self','data'=>$url);
          }
          $doc->down_add($id);
          $doc->down_log($uid, $id, $doc_info['doc_credit']);
          $doc->clear_doc_info_cache($id);
          return array('status'=>1,'msg'=>'','data'=>$url);
      }
      /**
       * 我的上传的资源
       * @param string $user_id
       * @param string $xk
       * @param int $cate_id
       * @param int $page
       * @param int $limit
       * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m
       * /getMyUpload?user_id=s35951247001862320095&xk=&type=0&page=1&limit=10&order_field=doc_id&order=desc
       */
      public function getMyUpload($user_id,$xk,$cate_id,$page,$limit,$order_field='doc_id',$order='desc'){
          return Models_Resource::init()->getMyUploadResrouce($user_id, $xk, $cate_id, $page, $limit,$order_field,$order);
      }
      /**
       * 我的收藏的资源
       * @param string $user_id
       * @param string $xk
       * @param int $cate_id
       * @param int $page
       * @param int $limit
       * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m/
       * getMyFav?user_id=s35951247001862320095&xk=&type=0&page=1&limit=10&order_field=doc_id&order=desc
       */
      public function getMyFav($user_id,$xk,$cate_id,$page,$limit){
         return Models_Resource::init()->myFav($user_id,$xk,$cate_id,$page,$limit);
      }
      /**
       * 我的下载的资源
       * @param string $user_id
       * @param string $xk
       * @param int $cate_id
       * @param int $page
       * @param int $limit
       * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m/
       * getMyDownload?user_id=s35951247001862320095&xk=&type=0&page=1&limit=10&order_field=doc_id&order=desc
       */
      public function getMyDownload($user_id,$xk,$cate_id,$page,$limit){
         return Models_Resource::init()->myDown($user_id,$cate_id,$xk,$page,$limit);
      }
      /**
       * 取资源信息
       * @param int $id
       * @param int $cate_id 资源分类ID  0=>是所有类型 1=>'教案',2=>"课件",3=>'题库',4=>'素材',5=>'微视频',6=>'观摩课',
       * @return mixed
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m/getInfo?id=1135
       */
      public function getInfo($id,$cate_id){
         
          $doc_model = Models_Resource::init();
          $this->viewsPlus($id);
          return $doc_info = $doc_model->get_doc_info($id,$cate_id);
      }
      /**
       * 资源浏览数+1
       * @param int $id
       * @return Ambigous <Ambigous, multitype:, boolean>
       */
      public function viewsPlus($id){
          return Models_Resource::init()->view_add($id);
      }
      /**
       * 资源评分
       * @param string $user_id
       * @param int $id
       * @param int $zs
       * @param int $ty
       */
      public  function remark($user_id,$id,$zs,$ty){
          $ff = (int) $zs;
          $ty = (int) $ty;
          $uid = $user_id;
          if(!$uid){
             return  $this->rtnArr('error', '请登录!');
          }
          $data['uid'] = $uid;
          $data['obj_id'] = $id;
          $data['obj_type'] = 'doc';
          $data['ff'] = $ff;
          $data['ty'] = $ty;
          $doc = Models_Resource::init();
          $is_mark = $doc->is_mark($uid, $id,'doc');
          if($is_mark){
             return $this->rtnArr('error', '已经评价过了');
          }
           
          Cola_Model::init()->insert($data,'doc_remark');
          $val =$ff+$ty;
          $doc->mark_add($id,$val);
          //取当前分数
          $remark_info = $doc->get_count_mark($id, 'doc');
          $remarks = number_format($remark_info['mark'],2);
          //更新评分数索引
          $doc->update_index($id, array('remark'=>$remarks));
          
          $res = $doc->clear_doc_info_cache($id);
          //var_dump($res);die;
          return $this->rtnArr('success','评价成功！');
      }
      /**
       * 资源搜索
       * @param string $where
       * @param string $is_fuzzy
       * @param string $sort_field
       * @param string $asc
       * @param string $relevance_first
       * @param number $page
       * @param number $pagesize
       * @param string $is_page
       * @param string $addRange
       * @return Ambigous <multitype:unknown, multitype:string array string number >
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m/searchResource?
       */
      public function searchResource($where,$is_fuzzy=false,$sort_field=null,$asc=false,$relevance_first=false,$page=1,$pagesize=20,$is_page=false,$addRange=""){
          $data = Models_Search::inits()->indexQuery($where,$is_fuzzy,$sort_field,$asc,$relevance_first,$page,$pagesize,$is_page,$addRange);
          $arr = array();
          $arr['count'] = $data['count'];
          //var_dump(Models_Search::inits()->flushIndex());
          //var_dump($data['data']);die;
          
          foreach ($data['data'] as $key => $value) {
              $arr['data'][] = current($value);
          }
          //var_dump($arr);die;
          return $this->rtnArr('success', '',$arr);
      }
      /**
       * 取搜索热词
       * @param number $num
       * @return Ambigous <multitype:unknown, multitype:string array string number >
       */
      public function searchHotKey($num=10){
          $data = Models_Search::inits()->getSearch()->getHotQuery($num);
          return $this->rtnArr('success', '',$data);
      }
      
      /**
       * 编辑资源
       * @param int $id
       * @param string $json
       * @example 
       * http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Resource/m/editResource?id=1232&json={%22doc_title%22:%22\u4fdd\u5229\u5a01\u89c6\u4e91\u76f4\u64ad\u4ef7\u683c\u8868%22,%22xd%22:%222%22,%22xk%22:%228%22,%22bb%22:%2296%22,%22nj%22:%2297%22,%22nid%22:%226937%22,%22doc_summery%22:%22\u4fdd\u5229\u5a01\u89c6\u76f4\u64ad\u62a5\u4ef7\r\n\u4e00\u3001%20\u62a5\u4ef7\u65b9\u5f0f\uff1a\r\n1\u3001\u6309\u6708\u4ed8\u8d39\uff1a\r\n\u6700\u9ad8\u5e76\u53d1\u5728\u7ebf\u4eba\u6570\uff08\u4eba\uff09%201-499\r\n\u6bcf\u6708\u5355\u4ef7\uff08\u5143\/\u4eba\/\u6708\uff09\r\n\r\n30\r\n\r\n500-1499\r\n\r\n1500-2999\r\n\r\n3000-4999\r\n\r\n5000-9999\r\n\r\n10000%20\u4ee5\u4e0a\r\n\r\n%22,%22tags%22:{%22raptuta%22:%22raptuta%22}}
       */
      public function editResource($id,$json){
          $data = json_decode($json,1);
          return Models_Resource::init()->editResource($id, $data);
      }
      
      /**
       * 删除资源
       * @param string $obj_type
       * @param string $obj_id
       * @param int $id
       * @return Ambigous <multitype:, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/access_token/a89c46e06c00ec82088899eba75f29c2/c/Models_Interface_Resource/m/deleteResource?obj_id=&obj_type=&id=
       */
      
      public function deleteResource($obj_type,$obj_id,$id){
           $res = Models_Resource::init()->deleteResource($obj_type, $obj_id, $id);
           if($res){
               return $this->rtnArr('success', '删除成功');
           }else{
               return $this->rtnArr('error', '删除失败');
           }
      }
      
      
}