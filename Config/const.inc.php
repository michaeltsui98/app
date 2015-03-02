<?php


//后台管理的静态文件地址
define('STATIC_ADMIN_PATH', BASE_PATH.'/static/');

define('STATIC_PATH', 'http://'.$_SERVER['HTTP_HOST'].BASE_PATH);
//模板缓存
define('TPL_CACHE', 0);
define('HTTP_DODOWENKU', 'http://dev-wenku.dodoedu.com');
define('HTTP_DODOEDU', 'http://dev.dodoedu.com');
define('DOMAIN_NAME', HTTP_DODOEDU);
define('HTTP_DODOXUE', 'http://xue.dodoedu.com');
//分布图片文件
define('HTTP_MFS_IMG', 'http://dev-images.dodoedu.com/wenku/');
define('HTTP_APP_IMG', 'http://dev-images.dodoedu.com/');
define('HTTP_MFS_DISK', 'http://dev-images.dodoedu.com/download.php?');
define('HTTP_SHARE', 'http://dev.dodoedu.com/share/index?');

define('HTTP_UI', 'http://dev-images.dodoedu.com/shequPage/');
 
/* 站内应用生成的APPID */
define("DD_APPID", '63');
/* APP_KEY */  
define("DD_AKEY", '2a42f76304529c8174f11ca6ad3573a6');
/* APP_SERCET */
define("DD_SKEY", '46abe1137dbafe0d');

define('DD_PRE', 'wenku');

/* 回调地址，这个不是已经写过去了么,估计是未授权就跳，但是可能是多此一举 */
define("DD_CALLBACK_URL", 'http://dev-wenku.dodoedu.com/index/callback');
/* 多多社区API地址 */
define("DD_API_URL", 'http://dev.dodoedu.com/DDApi/');

define("POLY_READTOKEN", 'j0kvE6vcZc-10xumNmVi1-rm1UjftGnZ');
define("POLY_WRITETOKEN", 'Rg777U73S2rcefA-udc09iQ94WStov8r');
define("POLY_PRIVATEKEY", 'WCfI0uRnHY');



//Debug true显示报错信息，false 跳转到404页面
//define('DEBUG', TRUE);

$constConfig = array(
    //产品类别
    '_appType'=>array(
        1=>'软件',2=>'游戏',
    ),
    //产品来源
    '_official'=>array(
        0=>'用户',1=>'官方',
    ),
    //产品平台
    '_platform'=>array(
        1=>'安卓',2=>'苹果',3=>'PC',
    ),
    //结算方式
    '_balance'=>array(
       1=>'日结',
       2=>'周结',
       3=>'双周结',
       4=>'月结',
    ),
    //数据查看
    '_dataview' => array(
        '1' => '有后台',
        '2' => '截图'
    ),
    //合作方式
    '_cooperation' => array(
        '1' => '付费',
        '2' => '换量'
    ),
    //渠道类型
    '_channelType' => array(
        // 应用 网站 联盟 市场 预装 其它
        '1' => '应用',
        '2' => '网站',
        '3' => '联盟',
        '4' => '市场',
        '5' => '预装',
        '6' => '其它',
    ),
    //渠道量级
    '_channelNum' => array(
        // 0-99 100-499 500-999 1000-2999 3000以上
        '1' => '0-99',
        '2' => '100-499',
        '3' => '500-999',
        '4' => '1000-2999',
        '5' => '3000以上',
    ),

    '_userSex' => array(
        '1' => '男',
        '2' => '女'
    ),


    '_userRole' => array(
        '1' => '学生',
        '2' => '教师',
        '3' => '家长',
        '4' => '教育从业者'
    ),
    
    
     
);
