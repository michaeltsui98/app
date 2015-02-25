<?php

/**
 * 登录
 * @author michael
 * @version 2014-07-10
 *
 */
class Controllers_Sign extends Controllers_Base
{
 
    /**
     * 首页
     */
    function indexAction ()
    {
        $dd = new Models_Client();
        $tokens =  $dd->getToken();
        $this->view->access_tokens = $tokens['access_token'];
        $this->view->appKey = DD_AKEY;
        $this->view->callBackUrl = DD_CALLBACK_URL;
        $this->view->ref = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:HTTP_DODOWENKU;
        //$this->view->hidden_top = false;
        $this->view->hidden_search = true;
        $this->view->hidden_nav = true;
        $this->view->hidden_footer = true;
        $this->view->css = array('index/css/index.css');
        $this->setLayout($this->getCurrentLayout('index.htm'));
        $this->tpl();
        
    }
  
    /**
     * 退出
     */
    function outAction ()
    {
        $i = strpos($_SERVER['HTTP_REFERER'], 'User');
        session_destroy();
        foreach ($_SESSION as $k => $v) {
            unset($_SESSION[$k]);
        }
        if ($i === false) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect('/');
        }
    }
   
}

