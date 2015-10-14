<?php
class Cache_McaChe
{
    private $_memcache;
	
    public function __construct($params)
    {
        $this->_memcache=new Memcache;
        $this->_memcache->addServer($params['cachehost'],$params['cacheport']);
    }
    
    public function _Cset($params)
    {   
        $param=explode(',',$params);
        $this->_memcache->set($param[0],$param[1],$param[2],$param[3]);
    }
    
    public function _Cget($params)
    {
        return $this->_memcache->get($params);
    }
}
