<?php
/** 
 * cherryphp-framework main class
 * This file is cherryphp-framework main class,the project "index.php" file must be included this file.
 * @author      Einstein.F
 * @version     0.0.3 
 * @license     GPL
 */
class Cherry
{
    public function __Construct()
    {
    }
    
    public static function Prepare($config)
    {
		
        Define('DS',DIRECTORY_SEPARATOR);
        Define('FRAMEWORK_DIR',dirname(dirname(__FILE__))."/cherryphp");
        Define('APP_DIR', dirname(dirname(__FILE__)));
        spl_autoload_register(array('Cherry','LoadClass'));
		Init::$Router=require(APP_DIR.DS.'router.php');
		if(!empty($config)){
			Init::$Config=require $config."config.php";
		}else{
			Init::$Config=require APP_DIR.DS.'config.php';
        }
		foreach (Init::$Config['define'] as $k=>$v){
			Define($k,Init::$Config['define'][$k]);
		}
		#spl_autoload_register(array('Cherry','appClass'));
        return new self;
    }
    
    public function Execute()
    {
        new Dispatch();
    }
	
	public static function getConfig($params){
		if (empty($params)){
			return Init::$Config;
		}else{
			return isset(Init::$Config[$params])?Init::$Config[$params]:"";
		}
	}
	
	public static function Exe($class)
	{
		$aa=explode("<=>",$class);
		$classname=str_replace("_",DS,$aa[0]);
		$action=$aa[1];
		if (!empty($aa[2])){
			$param=$aa[2];
		}else{
			$param=null;
		}
		$classapp=$_SERVER['DOCUMENT_ROOT'].DS.$classname.'.php';
		if (is_file($classapp)){
            require_once $classapp;
        }
		$classobj=new $aa[0];
		return $classobj->$action($param);
	}
 
    public static function LoadClass($class)
    {
        $classname=str_replace('\\','/',$class);
        $framework_class_path=FRAMEWORK_DIR.DS.$classname.'.php';

        $script_class_path=APP_DIR.DS.$classname.'.php';
        if (is_file($framework_class_path))
        {
            require_once $framework_class_path;
        }else if (is_file($script_class_path)){
            require_once $script_class_path;
        }
    }
	
}