<?php
class Init
{
    private static $db = null;
    private static $dbConfig =null;
    private static $cacheConfig =null;
    private static $cache = null;  
    public static $Config = null;
    public static $Router = null;
	
    function __construct($param)
    {
        
    }
    
    public static function db($db=0){
        if(empty(self::$dbConfig)){
            self::$dbConfig=self::$Config['mysql'][$db];
        }
        if(empty(self::$db)){
            self::$db=\Db\MysqlDb::Prepare(self::$dbConfig);
        }
        return self::$db;
    }

    public static function cache($cache_type='memcache',$cache_id=0){
        if(empty($cacheConfig)){
            $cacheConfig=self::$Config[$cache_type][$cache_id];
        }
        if(empty(self::$cache)){
            switch($cache_type)
            {
                case 'memcache':
                return self::$cache=new \Cache\Memcache($cacheConfig);
                break;
                case 'redis':
                return self::$cache=new \Cache\Redis($cacheConfig);
                break;
            }
        }
        return self::$cache;
    }
}
