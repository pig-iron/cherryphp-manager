<?php
class Router
{
    public function __Construct()
    {
    }
    
    public static function RouterMap()
    {
        return require_once(APP_PATH.'router.php');
    }
}