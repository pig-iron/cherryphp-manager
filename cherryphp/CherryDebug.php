<?php
class CherryDebug
{
    public function __Construct()
    {
    }
    
    public static function Excpt($msg)
    {
        echo "<pre>";
        throw new Exception($msg);
    }
    
    public static function CheckParam($param)
    {
        if (empty($param))
        {
            echo "<pre>";
            throw new Exception('=====The function Missing argument=====');
        }
    }
    
    public static function AppLog($msg)
    {
        error_log(date('Y/m/d H:i:s').": ".$msg."\n",3,APP_PATH.'Log'.DS.'debug'.date('Ymd').'.log');
    }
}