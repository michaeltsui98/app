<?php

$cacheConfig = array(
    '_routecache' => array(
            'adapter' => 'File'
    ),
    '_cache' => array(
            'adapter' => 'Memcached',
            'servers' => array(
                    'default' => array(
                            'host' => '172.16.0.3',
                            'port' => 8888,
                            'persistent' => true
                    )
            )
    ),
    '_redis' => array(
        'adapter' => 'redis',
          
                'host' => '172.16.0.5',
                'port' => 6379,
                'persistent' => false
    ),
    '_sessionCache' => array(
                'host' => '172.16.0.3:8888',
    ),

);
