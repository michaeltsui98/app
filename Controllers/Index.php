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

        var_dump(function_exists('curl_init'));die;
        phpinfo();

         //var_dump($_SERVER);die;

        $url = 'http://www.163.com';
        $data = array();
       // echo $url ;


        /* Curl settings */

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        //curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $error = curl_errno($ch);
        var_dump(curl_getinfo($ch));
        curl_close($ch);
        //$query = json_decode($result, 1);

         echo $result;

        die;
        $this->view->css = array('index/css/index.css');
        //$this->view->js = array('index/script/index_show.js');
        $this->setLayout($this->layout);
        $this->tpl();

    }


}

