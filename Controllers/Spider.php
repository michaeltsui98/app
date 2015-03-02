<?php

/**
 * 数据采集程序
 * Class Controllers_Spider
 */
class Controllers_Spider extends Cola_Controller
{

    const  APP_URL = "http://www.cpajia.com/index.php?m=index&a=search";
    const  CHANNEL_URL = "http://www.cpajia.com/index.php?m=channel&a=search";
    const  OFFICIAL = "http://www.cpajia.com/index.php?m=official&a=search";

    /**
     *
     * 收集应用信息
     * @example http://dev.app.com/spider/appProduct?page=1
     */
    public function appProductAction()
    {
        $param = 'PageIndex';
        $page = $this->getVar('page', 1);
        $is_official = $this->getVar('is_official');
        $url = self::APP_URL;
        if ($is_official) {
            $url = self::OFFICIAL;
        }
        $limit = 20;
        set_time_limit(0);
        $data = json_decode(Cola_Com_Http::post($url, array($param => $page)), 1);
        unset($data[0]);
        foreach ($data as $k => $v) {
            //var_dump(date('Y-m-d',$v['updatetime'])==date('Y-m-d',time()));die;
            if (date('Y-m-d',$v['updatetime'])==date('Y-m-d',time())) {
                $this->saveAppToDB($v);
            }

        }

    }

    /**
     * 收集渠道信息
     * @example http://dev.app.com/spider/appChannel?page=1
     */
    public function appChannelAction()
    {
        $param = 'PageIndex';
        $page = $this->getVar('page', 1);

        $url = self::CHANNEL_URL;

        set_time_limit(0);
        $data = json_decode(Cola_Com_Http::post($url, array($param => $page)), 1);
        unset($data[0]);
        foreach ($data as $k => $v) {

            if (date('Y-m-d',$v['updatetime'])==date('Y-m-d',time())) {
                $this->saveChannelToDB($v);
            }

        }
    }

    /**
     * 写channel 到数据库
     * @param $v
     */
    public  function saveChannelToDB($v){
        $type_arr =  array_flip(Cola::getConfig('_channelType'));
        $level_arr = array_flip( Cola::getConfig('_channelNum'));
        $d = array();
        $d['channel_level']  =(int) $level_arr[$v['channellevel']];
        $d['type']  =(int) $type_arr[$v['channeltype']];
        $d['company']  = $v['companyname'];
        $d['created_at']  = $v['createtime'];
        $d['updated_at']  = $v['updatetime'];
        $d['hits']  = $v['hits'];
        $d['content']  = $v['infos'];
        $d['listorder']  = $v['listorder2'];
        $d['mobile']  = $v['mobile'];
        $d['platform']  = $v['platform_device'];
        $d['qq']  = $v['qqnumber'];
        $d['readgroup']  = $v['readgroup'];
        $d['readpoint']  = $v['readpoint'];
        $d['recommend']  = $v['recommend'];
        $d['status']  = $v['status'];
        $d['summary']  = $v['summary'];
        $d['tel']  = $v['telphone'];
        $d['wxh']  = $v['wx'];
        $d['weburl']  = $v['weburl'];
        $d['user_id']  = $v['userid'];
        $d['user_name']  = $v['username'];
        $d['cid']  = $v['id'];
        //var_dump($d);die;
        Models_AppChannel::init()->insert($d);

    }
    /**
     * 写app到数据库
     * @param $v array
     */
    public function saveAppToDB($v)
    {

        $t = array();
        $t['cate_id'] = $v['catid'];
        $t['user_id'] = $v['userid'];
        $t['user_name'] = $v['username'];
        $t['title'] = $v['title'];
        $t['title_style'] = $v['title_style'];
        $t['thumb'] = $v['thumb'];
        $t['keywords'] = $v['keywords'];
        $t['desc'] = $v['description'];
        $t['content'] = $v['content'];
        $t['url'] = $v['url'];
        $t['template'] = $v['template'];
        $t['posid'] = $v['posid'];
        $t['status'] = $v['status'];
        $t['read_group'] = $v['readgroup'];
        $t['listorder'] = $v['listorder'];
        $t['hits'] = $v['hits'];
        $t['created_at'] = $v['createtime'];
        $t['updated_at'] = $v['updatetime'];
        $t['lang'] = $v['lang'];
        $t['platform'] = $v['platform'];
        $t['balance'] = $v['balance'];
        $t['dataview'] = $v['dataview'];
        $t['qq'] = $v['qq'];
        $t['phone'] = $v['phone'];
        $t['wxh'] = $v['wxh'];
        $t['price'] = $v['price'];
        $t['showimg'] = $v['showimg'];
        $t['company'] = $v['company'];
        $t['cooperation'] = $v['cooperation'];
        $t['official'] = $v['official'];
        $t['website'] = $v['website'];
        $t['tel'] = $v['tel'];
        $t['summary'] = $v['summary'];
        $t['aid'] = $v['id'];
        Models_AppProduct::init()->insert($t);

    }


}

?>