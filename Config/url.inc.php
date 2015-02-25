<?php

$urlConfig = array(
        
        '_urls' => array(
        
                '{^Wdiget\/node_select$}i' => array(
                        'controller' => 'Controllers_Widget',
                        'action' => 'node_selectAction',
                ),
                '{^(View|view)/(\d+)$}i' => array(
                        'controller' => 'Controllers_Info',
                        'action' => 'indexAction',
                        'maps' => array(
                                2 => 'doc_id',
                        ),
                ),
                '{^(Info|info)/(\d+)$}i' => array(
                        'controller' => 'Controllers_Info',
                        'action' => 'indexAction',
                        'maps' => array(
                                2 => 'doc_id',
                        ),
                ),
 
                '{^search([^ ]+)$}i' => array(
                        'controller' => 'Controllers_Search',
                        'action' => 'indexAction',
                        'maps' => array(
                                1 => 'param',
                        ),
                ),
               
                '{^(xiaoxue|chuzhong|gaozhong)([^ ]+)$}i' => array(
                        'controller' => 'Controllers_List',
                        'action' => 'indexAction',
                        'maps' => array(
                                1=>'xdname',
                                2=>'param',
                        ),
                ),
                '{^professional([^ ]+)?$}i' => array(
                        'controller' => 'Controllers_List',
                        'action' => 'nonstandardAction',
                        'maps' => array(
                                1 => 'param',
                        ),
                ),
                
                 
        
        ),
);
