<?php

/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2015/1/6
 * Time: 12:46
 */
class Orm_AppProduct extends Cola_Orm
{

    protected $table = 'app_product';
    protected $primaryKey = 'id';
    public $timestamps = false;
   // protected $fillable = array('name', 'alias','url', 'is_ok','corder','created_at');
    protected $guarded = array('id');
   /* protected function getDateFormat()
    {
        return 'U';
    }*/




}