<?php
namespace Db;
class BaseMysqlDb
{
    public $_db = null;
    protected static $_instance = null;
    
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
        $dbPort=$params['dbport'];
        $dbUser=$params['dbuser'];
        $dbPass=$params['dbpass'];
        $dbName=$params['dbname'];
		
        $this->_db=mysqli_connect($dbLocal,$dbUser,$dbPass,$dbName,$dbPort)or die(mysql_error());
		
        mysqli_query($this->_db,"SET NAMES '".\Init::$Config['charset']."'");
		return $this->_db;
    }
	
    public function sqlQuery($db,$sql)
    {
		return mysqli_query($db,$sql);
    }
}