<?php
class Dispatch
{
    public function __Construct() //获取URL或PHP输入数据
    {
        if (file_get_contents("php://input")!=="")
        {
            $posturl=file_get_contents("php://input");
            $postarr=str_replace(array('=','&'),DS,$posturl);
            $this->U($_SERVER['REQUEST_URI'].'/'.$postarr);
        }else{
            if ($_SERVER['REQUEST_URI']=="/"){
                $this->U($_SERVER['REQUEST_URI']."index");
            }else{
                $this->U($_SERVER['REQUEST_URI']);
            }
        }
    }
    
    private static function U($url) //URL组装
    {
		if (strpos($url,"?")){
			$part_url=explode('?',$url);
			$part_class=explode('/',$part_url[0]);
			$part_class=array_splice($part_class,1);
			$Class=Init::$Router[$part_class[0]][0];
			$Action=$part_class[1];
			$part_params=str_replace('&',"=",$part_url[1]);
			$Params=explode('=',$part_params);
		}else{
			$Params=explode('/',$url);
			$RequestArr=array_splice($Params,1,2);
			if (class_exists($RequestArr[0])){
				$Class=$RequestArr[0];
				$Params=array_splice($Params,1);
				$Action=(!empty($RequestArr[1]))?$RequestArr[1]:"";
				
			}else if(isset(Init::$Router[$RequestArr[0]])){
				$Class=Init::$Router[$RequestArr[0]][0];
				if (empty($RequestArr[1])){
					$Action=Init::$Router[$RequestArr[0]][1];
					$Params=explode("/",Init::$Router[$RequestArr[0]][2]);
				}else{
					if (empty(Init::$Router[$RequestArr[0]][1])){
						$Action=$RequestArr[1];
						$Params=array_splice($Params,1);
					}else{
						$Action=Init::$Router[$RequestArr[0]][1];
						$Params[0]=$RequestArr[1];
					}
				}
			}else{
				header("HTTP/1.0 404 Not Found");
				header("Status: 404 Not Found");
				include(APP_PATH.error404); 
				return false;
			}
		}
		
	
		$s=count($Params);
		$ParamArr=Array();
		for ($i=0;$i<$s;$i++)
		{
			if ($i%2!=0 and $i!==0){
				$ParamArr[$Params[$i-1]]=urldecode($Params[$i]);
			}
		}
		$Create=new $Class;
		$Action=empty($Action)?"index":$Action;
		if (method_exists($Create,$Action)){
            $ParamArr = Init::db()->check_param($ParamArr);
			$Create->$Action($ParamArr);
		}else{
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			include(APP_PATH.error404); 
		}
		
    }
	
    public static function ParseUrl($url) //URL重写转换
    {
        $urls=explode(DS,$url);
        $host=isset($_SERVER['HTTP_X_FORWARDED_HOST'])?$_SERVER['HTTP_X_FORWARDED_HOST']:(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'');
        
        if (class_exists($urls[0]))
        {
			if (strpos($host,APP_PORT)){
				return "http://".$host.DS.$url;
			}else{
				return "http://".$host.":".APP_PORT.DS.$url;
			}
        }else{
            return "http://".$host.":".APP_PORT.DS.APP_TPL.DS.$url;
        }
        
    }
}