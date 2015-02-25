<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2015/1/6
 * Time: 12:46
 */

    class Orm_Resource extends Cola_Orm {

    protected   $table = 'resource';
    protected  $primaryKey = 'doc_id';
    public  $timestamps = false;

    public  function getOne(){
        $allUsers = self::simplePaginate(15);

    }
}