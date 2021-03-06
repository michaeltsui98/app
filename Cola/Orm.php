<?php
 //orm init
use  Illuminate\Database\Eloquent\Model  as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
//use Illuminate\Pagination\Factory as Pagination;
use Illuminate\Pagination\Paginator as Pagination;
 

require COLA_DIR.DIRECTORY_SEPARATOR.'Illuminate/support/helpers.php';

$capsule = new Capsule;
$connect = Cola::getConfig('database');

$capsule->addConnection($connect['connections']['mysql']);
// 注册分页类
$capsule->getContainer()->bind('paginator', 'Cola\Paginator',true);
//$capsule->getContainer()->bind('view', 'Illuminate\View\FileViewFinder',true);


// Set the event dispatcher used by Eloquent models... (optional)

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
 
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent(); 



/**
 * 
 * @author michael
 *
 */
abstract class Cola_Orm extends Eloquent 
{
    
    
    protected static $_instance = array();
    
    /**
     * @return self | static
    */
    public static function init()
    {
        $cls = get_called_class();
    
        if (isset(self::$_instance[$cls]) && is_object(self::$_instance[$cls])) {
            return self::$_instance[$cls];
        }
        return self::$_instance[$cls] = new static();
    }
}