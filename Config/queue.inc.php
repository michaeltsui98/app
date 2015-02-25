<?php

$queueConfig = array(
    //文档转pdf队列
    '_docQueue' => array(
            'adapter' => 'Httpsqs',
            'host' => '172.16.0.5',
            'port' => '1212',
            'name' => 'wenku'
    ),
    //PDF转swf队列
    '_resQueue' => array(
            'adapter' => 'Httpsqs',
            'host' => '172.16.0.5',
            'port' => '1212',
            'name' => 'resource'
    ),
    '_noticeQueue' => array(
            'adapter' => 'Httpsqs',
            'host' => '172.16.0.5',
            'port' => '1212',
            'name' => 'notice',
    ),
    //系统通知
    '_notifyQueue' => array(
            'adapter' => 'Httpsqs',
            'host' => '172.16.0.5',
            'port' => '1212',
            'name' => 'notify'
    ),
     
);
