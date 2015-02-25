<?php

    /**
     * 资源收藏
     * @author michael
     * @version 1.0 2013/8/12 14:17:34
     */
    class Models_Fav extends Cola_Model
    {

        protected $_pk = 'id';

        protected $_table = 'resource_fav';


        /**
         * 删除收藏的资源
         * @param string $uid
         * @param int    $obj_id
         * @return Ambigous <multitype:, boolean, mixed, resource>
         */
        function del_fav($obj_id, $uid)
        {
            $sql = "delete  from resource_fav where uid = '$uid' and obj_type='doc' and obj_id = '$obj_id'";
            $sql2 = "update resource set doc_favs = if(doc_favs>0,doc_favs-1,0) where  doc_id = '$obj_id' ";
            $res = $this->sql($sql);
            $this->sql($sql2);
            return $res;
        }


    }

 