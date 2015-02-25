<?php

/**
 * 手机应用
 * @author michael
 *
 */
class Controllers_App extends Controllers_Base
{
 
    function __construct ()
    {
        $this->layout = $this->getCurrentLayout('index.htm');
    }
 
    /**
     * 首页
     */
    function indexAction ()
    {
        
        //$this->view->css = array('index/css/index.css');
        $this->view->hidden_search = true;
        $this->view->hidden_nav = true;
        
        $this->setLayout($this->layout);
        $this->tpl();
        
    }
     
 
}

