<?php
class Cache_McaChe
{
    private $_memcache;
	
    public function __construct($params)
    {
        $this->_memcache=new Memcache;
        $this->_memcache->addServer($params['cachehost'],$params['cacheport']);
    }
    
    public function _Cset($key,$res,$times=600)
    {   
        $this->_memcache->set($key,$res,0,$times);
    }
    
    public function _Cget($params)
    {
        return $this->_memcache->get($params);
    }
	
	public function _Cdel($key)
    {
        return $this->_memcache->delete($key,0);
    }
}
