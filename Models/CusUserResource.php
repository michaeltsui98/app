<?php

/**
 * 用户自定义分类的资源
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_CusUserResource extends Cola_Model
{

    protected  $_pk = 'id';
    protected  $_table = 'cus_user_resource';

    /**
     * 取用户自定义资源列表
     * @param $user_id
     * @param $cus_id
     * @param $cate_id
     * @param $source
     * @param $key
     * @param $page
     * @param $limit
     * @return bool|\multitype
     */
    public function getUserResource($user_id,$cus_id,$cate_id,$source,$key,$page,$limit){
        $where = " 1 ";
        if ($cate_id) {
            $where .= " and j.cate_id = '$cate_id' ";
        }
        if ($source) {
            $where .= " and j.source = '$source' ";
        }
        if ($key) {
            $where .= " and j.doc_title like '%$key%'";
        }
        if($cus_id) {

            $sql = "select * from (
                SELECT a.doc_id did FROM `cus_user_resource` a
                LEFT JOIN cus_cate b on a.cus_id = b.id
                where  b.obj_id = '$user_id'
                and b.obj_type = 'user' and b.id = '$cus_id'
                )  as i
                LEFT JOIN
                (
                select
                a.doc_id,a.uid,a.user_name,a.doc_title,a.doc_summery,a.cate_id,a.xd,a.xk,a.bb,a.nj,a.node_id,a.nid,a.doc_views,
                a.doc_favs,a.doc_remarks,a.doc_remark_val,a.doc_downs,a.doc_credit,a.doc_status,a.is_ok,a.is_hidden,a.on_time,
                a.cus_id,a.attr,b.source,b.created_at,c.doc_page_key,c.doc_ext_name,c.doc_pages,c.file_size
                 from resource a right join
                (SELECT a.doc_id, 'down' as source ,a.on_time as created_at  from doc_down_log a where a.uid= '$user_id'
                UNION
                SELECT a.obj_id as doc_id , 'fav' as source,a.on_time as created_at from resource_fav  a where a.uid = '$user_id' and a.obj_type= 'doc'
                union
                select a.doc_id ,'upload' as source ,a.on_time as created_at from resource a where a.uid = '$user_id')
                as b on a.doc_id = b.doc_id
                left join resource_file c on a.file_id = c.file_id
                where a.doc_id >0
                ) as j
                on i.did = j.doc_id
                where $where  order by i.did desc
                 ";
        }else{

            $sql = "select * from (

                select
                a.doc_id,a.uid,a.user_name,a.doc_title,a.doc_summery,a.cate_id,a.xd,a.xk,a.bb,a.nj,a.node_id,a.nid,a.doc_views,
                a.doc_favs,a.doc_remarks,a.doc_remark_val,a.doc_downs,a.doc_credit,a.doc_status,a.is_ok,a.is_hidden,a.on_time,
                a.cus_id,a.attr,b.source,b.created_at,c.doc_page_key,c.doc_ext_name,c.doc_pages,c.file_size
                 from resource a right join
                (SELECT a.doc_id, 'down' as source ,a.on_time as created_at from doc_down_log a where a.uid= '$user_id'
                UNION
                SELECT a.obj_id as doc_id , 'fav' as source ,a.on_time as created_at from resource_fav  a where a.uid = '$user_id' and a.obj_type= 'doc'
                union
                select a.doc_id ,'upload' as source ,a.on_time as created_at from resource a where a.uid = '$user_id')
                as b on a.doc_id = b.doc_id
                left join resource_file c on a.file_id = c.file_id
                where a.doc_id >0
                ) as j

                where $where  order by j.doc_id desc
                 ";
        }
      return   $this->getListBySql($sql,$page,$limit);

    }

    
    
     
     
}
 