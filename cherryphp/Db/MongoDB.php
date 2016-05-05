<?php
namespace Db;
class MongoDB
{
	protected static $_mysql;
	protected $_sql;
    protected static $_db = null;
    protected static $_instance = null;
	public static function Prepare($params)
	{
		self::getInstance($params);
		self::$_mysql=new self($params);
		return self::$_mysql;
	}
    
    public static function getInstance($params)
    {
        if (!self::$_instance)
        {
            self::$_instance=new self($params);
        }
        return self::$_instance;
    }
    
    protected function __construct($params)
    {
        $dbLocal=$params['dblocal'];
        $dbname=$params['dbname'];
        $mdb=new \MongoClient($dbLocal) or die("connect to ".$conn_string . " failed!");
        self::$_db = $mdb->selectDB($dbname);
		return self::$_db;
    }
    
    public static function listcollection(){
        return self::$_db->listCollections();
    }
    public static function selectcollection($params){
        return self::$_db->selectCollection($params);
    }
    public static function command($params){
        return self::$_db->command($params);
    }
    
}