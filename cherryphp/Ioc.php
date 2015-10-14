<?php
namespace cherryphp;
class Ioc
{
    private static $registry = array();
    public function __construct()
    {
    }
    
    public static function register($name,\Closure $closure)
    {
        static::$registry[$name]=$closure;
    }
    
    public static function resolve($name)
    {
       if ( static::registered($name) )
       {
          $name = static::$registry[$name];
          return $name();
       }
       throw new Exception('Nothing registered with that name, fool.');
	}
	
	public static function registered($name)
    {
      return array_key_exists($name, static::$registry);
	}
}
