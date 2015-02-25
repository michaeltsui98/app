<?php

include 'const.inc.php';
include 'url.inc.php';
include 'db.inc.php';
include 'cache.inc.php';
include 'queue.inc.php';
include 'fs.inc.php';
include 'webservices.inc.php';
include 'xhprof.inc.php';
include 'node.inc.php';
include 'database.php';
$config = array(
    'site_name'=>'多多文库-中小学教育资源分享平台- wenku.dodoedu.com',
    'site_desc'=>'多多文库是中小学专业的教育资料文库和在线互动式文档分享平台，在这里，您可以和千万网友分享自己手中的文档，全文阅读其他用户的文档，同时，也可以利用分享文档获取的积分下载文档。',
    '_search' => array(
            'file' => 'wenku',
            'charset' => 'UTF-8'
    ),
    '_resource_search' => array(
            'file' => 'resource',
            'charset' => 'UTF-8'
    ),
    '_modelsHome'      => 'Models',
    '_controllersHome' => 'Controllers',
    '_viewsHome'       => 'views',
    '_widgetsHome'     => 'widgets',
    '_modules'=>array('Admin'),
);

$config = array_merge($config, $constConfig, $urlConfig, $cacheConfig, $dbConfig, $fsConfig, $queueConfig, $webServicesConfig, $xhprofConfig,$nodeConfig,$ormdbConfig);
