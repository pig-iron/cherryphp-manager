<?php
namespace cherryphp;
class CherryView
{
    private static $_components = array();
	public static $_tpl_folder = "";
    public function __construct()
    {
    }
    public function set($params)
    {
		foreach($params as $k=>$v){
			static::$$k=$v;
		}
    }
    public static function assign($key,$value)
    {
        self::$_components[$key]=$value;
		return self::$_components;
    }
    
    public static function render($params)
    {
        if (!empty(self::$_components))
        {
			@extract(self::$_components,EXTR_PREFIX_SAME,'cherry');
        }
        $tpls=self::$_tpl_folder.DS.$params.'.html';
        include(APP_TPL.DS.$tpls);
        self::$_components=array();
    }
}
