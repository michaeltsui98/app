<?php


//后台管理的静态文件地址
define('STATIC_ADMIN_PATH', '/static/');

define('STATIC_PATH', 'http://'.$_SERVER['HTTP_HOST']);
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
    
    '_resourceType'=>array(
            1=>'教案',2=>"课件",3=>'题库',4=>'素材',5=>'微视频',6=>'观摩课',
            //8=>'备课夹'
    ),
    '_resourceFileType'=>array(
	   1=>'*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.ppsx;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub',
	   2=>'*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.ppsx;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub',
	   3=>'*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.ppsx;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub',
	   4=>'*.jpg;*.jpeg;*.rar;*.zip;*.png;*.gif',
	   5=>'*.mp4;*.flv',
	   6=>'*.mp4;*.flv',
	   7=>'*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.ppsx;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub',
	   9=>'*.doc;*.docx;*.ppt;*.pptx;*.xls;*.xlsx;*.vsd;*.pot;*.pps;*.ppsx;*.rtf;*.wps;*.et;*.dps;*.pdf;*.txt;*.epub',
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
