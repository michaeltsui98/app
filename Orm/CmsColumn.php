<?php

/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2015/1/6
 * Time: 12:46
 */
class Orm_CmsColumn extends Cola_Orm
{

    protected $table = 'cms_column';
    protected $primaryKey = 'id';
    public $timestamps = false;


    /**
     * 通过中间表关系表取来建立column 取 content 的关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function belongsToManyContent()

    {

        return $this->belongsToMany('Orm_CmsContent', 'cms_relate', 'column_id', 'content_id');

    }

}