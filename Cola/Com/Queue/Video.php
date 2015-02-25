<?php
/**
 * 视频转换对列
 * @author michael
 * 
 *
 */
class Cola_Com_Queue_Video extends  Cola_Com_Queue_Abstract
{

    /**
     *
     * @var string host
     * @var int port
     * @var string name
     */
    protected static $_config = array();

    /**
     *
     * @var string $_uri
     */
    private static $_uri = null;

    private  static $_instance = NULL;
    /**
     * @param array $config
     * @return self
     */
    public static function init($config = NULL){
        if(self::$_instance === NULL){
            self::$_instance = new static($config);
        }
        return self::$_instance;
    }
    public function __construct($config=NULL)
    {
        if($config === NULL){
            $config = Cola::$_config->get('_videoQueue');
        }
        self::$_config = $config;
        self::$_uri = 'http://' . $config['host'] . ':' . $config['port'];
    }

    /**
     * Config
     *
     * Set or get configration
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public static function config($name = null, $value = null)
    {
        if (null == $name) {
            return self::$_config;
        }
        if (null == $value) {
            return isset(self::$_config[$name]) ? self::$_config[$name] : null;
        }
        self::$_config[$name] = $value;

        return $this;
    }

    /**
     * Put data to queue.
     * @param string $data json data
     * @param string $uri queue uri
     * @param string $name queue name
     * @return Boolean
     */
    public  function put($arr=array())
    {
        try {
            if (empty($arr)) return FALSE;
            
            $uri = self::$_uri;
            $name = self::config('name');

            $context = array(
                'opt'  => 'put',
                'name' => $name,
                'data' => json_encode($arr)
            );

            $data = Cola_Com_Http::get($uri, $context);

            if ('HTTPSQS_PUT_OK' == $data) {
                return TRUE;
            }

            return FALSE;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function get(){}

}