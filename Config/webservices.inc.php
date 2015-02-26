<?php

$webServicesConfig = array(
    '_webServicesCircle' => array(
        'adapter' => 'Rest',
        'servers' => array(
            'default' => array(
                'host' => 'http://172.16.0.4',
                'port' => 9080,
                'name' => 'circle',
                'services' => '/Circle/Circle',
                'options' => array(
                    //设置执行超时时间，单位毫秒
                    'timeout' => 15,
                ),
            ),
            'slave' => array(
                'host' => 'http://172.16.0.4',
                'port' => 9081,
                'name' => 'circle',
                'services' => '/Circle/Circle',
                'options' => array(
                    //设置执行超时时间，单位毫秒
                    'timeout' => 15,
                ),
            )
        )
    ),

);