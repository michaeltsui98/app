<?php

/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2015/1/6
 * Time: 12:46
 */
class Orm_CmsRelate extends Cola_Orm
{

    protected $table = 'cms_relate';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function belongsToManyContent()

    {

        return $this->belongsToMany('Article', 'article_tag', 'tag_id', 'article_id');

    }

}