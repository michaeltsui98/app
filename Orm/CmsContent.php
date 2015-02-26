<?php

/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2015/1/6
 * Time: 12:46
 */
class Orm_CmsContent extends Cola_Orm
{

    protected $table = 'cms_content';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function relate(){
        return $this->belongsToMany('CmsRelate','cms_relate','');
    }

}