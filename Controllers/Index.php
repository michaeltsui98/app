<?php

/**
 * 首页
 * @author michael
 *
 */
class Controllers_Index extends Controllers_Base
{

 
    function __construct ()
    {
        parent::__construct(); 
        $this->layout = $this->getCurrentLayout('index.htm');
    }
    public function topAction() {


    	$this->tpl('public/top');
    }
    public function searchAction() {
        //取资源类型
        $resource_type = Cola::getConfig('_resourceType');
        $this->view->resource_type = $resource_type;
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $this->view->key = isset($params['key'])?$params['key']:'';
        $this->view->type = isset($params['type'])?$params['type']:'';

        $this->tpl('public/search');
    }
    public function navAction() {
        $tmp = explode('/',$this->getVar("param"));
        $params = array();
        while (false !== ($next = next($tmp))) {
            $params[$next] = urldecode(next($tmp));
        }
        $id = isset($params['id'])?$params['id']:'';
        $this->view->id = $id;
        $this->view->c = $this->c;
    	$this->tpl('public/nav');
    }

    /**
     * 首页
     */
    function indexAction ()
    {
        $this->view->page_title = "app.com首页";


        $this->view->hidden_top = 1;
        $this->view->hidden_search = 1;
        $this->view->hidden_nav = 1;
         //echo '111';die;


        $this->view->css = array('index/css/index.css');
        //$this->view->js = array('index/script/index_show.js');
        $this->setLayout($this->layout);
        $this->tpl();

    }


}

