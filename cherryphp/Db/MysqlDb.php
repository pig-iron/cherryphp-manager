<?php
namespace Db;
class MysqlDb extends \Db\BaseDb
{
	protected static $_mysql;
	protected $_sql;
	public static function Prepare($params)
	{
		parent::getInstance($params);
		self::$_mysql=new self($params);
		return self::$_mysql;
	}

    public function fetch_query($sql)
    {

		$resLink=parent::sqlQuery(self::$_mysql->_db,$sql);
		while($resource=mysqli_fetch_array($resLink,MYSQL_ASSOC))
        {
            $result[]=$resource;
        }
        if(!empty($result)){
            return $result;
        }else{
            return false;
        }
    }
	    
    public function sql_query($sql)
    {
		return $resLink=parent::sqlQuery(self::$_mysql->_db,$sql);
    }
	
	public function getRows()
    {
       return parent::sqlQuery($this->_sql);
    }
	
	public function insert()
	{
		return parent::sqlQuery($this->_sql);
	}
	
	public function update()
	{
		return parent::sqlQuery($this->_sql);
	}
	
	public function delete()
	{
		return parent::sqlQuery($this->_sql);
	}
	
}