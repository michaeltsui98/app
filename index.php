<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'on');
date_default_timezone_set('Asia/Shanghai');
mb_internal_encoding('utf-8');
define('DEBUG', TRUE);
header("Content-Type:text/html;charset=utf-8");
define('S_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

define('BASE_PATH', '');

ob_start();

require 'Cola/Cola.php';
require 'Cola/Func.php';
include S_ROOT.'Models/AdminFunc.php';
$cola = Cola::getInstance();

// $xh = new Cola_Com_Xhprof ();
// $benchmark = new Cola_Com_Benchmark ();
$cola->boot();

/*$cfg = $cola->getConfig('_sessionCache');
ini_set('session.cookie_domain', '.dodoedu.com');
ini_set("session.save_handler", 'memcached');
ini_set("session.save_path", $cfg['host']);*/
isset($_SESSION) || session_start();
try {

//ini_get_all();
//session_destroy();
    $cola->dispatch();
//var_dump($_SESSION);die;    
} catch (Cola_Exception $e) {
    if (FALSE === DEBUG and defined('DEBUG')) {
        Cola_Exception::log($e);
        Cola_Exception::sendMail($e);
        header("Location: /404.html", true, 302);
        exit;
    }
    Cola_Exception::handler($e);
    
} catch (Cola_Exception_Dispatch $e) {
    if (defined('DEBUG') and FALSE === DEBUG) {
        Cola_Exception_Dispatch::log($e);
        Cola_Exception_Dispatch::sendMail($e);
        header("Location: /404.html", true, 302);
        exit;
    }
    Cola_Exception_Dispatch::handler($e);
}

//echo "<br />cost:", $benchmark->cost (), 's';
//echo $a = $xh->save ();