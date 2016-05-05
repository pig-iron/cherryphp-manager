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
    
    public function C_zRevRange($a,$b,$c)
    {
        return $this->_redis->zRevRange($a,$b,$c);
    }
    
    public function C_zDelete($a,$b)
    {
        return $this->_redis->zDelete($a,$b);
    }
    
    public function C_zIncrBy($a,$b,$c)
    {
        return $this->_redis->zIncrBy($a,$b,$c);
    }
    
    public function C_zCount($a,$b,$c)
    {
        return $this->_redis->zCount($a,$b,$c);
    }
    
    public function C_zRemRangByRank($a,$b,$c)
    {
        return $this->_redis->zRemRangByRank($a,$b,$c);
    }
}
