<?php

class MessagePageWidget extends Cola_Com_Widget
{

    /**
     * 初始化Widget数据
     *
     * @param string $text
     */
    protected function _init($in_messageArray)
    {
        $this->view->turnUri = $in_messageArray[0];
        $this->view->viewMessage = $in_messageArray[1];
        $this->view->ms = $in_messageArray[2];
    }

}