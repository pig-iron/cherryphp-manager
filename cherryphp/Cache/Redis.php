<?php
namespace Cache;
class Redis
{
    private $_redis;
	protected static $_instance = null;
    
    public function __construct($params)
    {
        $this->_redis=new \Redis();
        $this->_redis->connect($params['host'],$params['port']);
    }
    
    public function _Cset($params)
    {   
        return $this->_redis->set($params[0],$params[1]);
    }
    
    public function _Cget($params)
    {
        return $this->_redis->get($params);
    }
    
    public function _Ckeys($params)
    {
        return $this->_redis->keys($params);
    }
    
    public function _Cdel($params)
    {
        return $this->_redis->delete($params);
    }
}
