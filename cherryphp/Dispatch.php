<?php
class Dispatch
{
    public function __Construct() //获取URL或PHP输入数据
    {
        if (strstr($_SERVER['CONTENT_TYPE'],"multipart/form-data"))
        {
            $httpdata=array();
            if (!empty($_FILES)){
                foreach($_FILES as $k=>$v){
                    $httpdata[$k]=$v;
                }
            }
            if (!empty($_GET)){
                foreach($_GET as $k=>$v){
                    $httpdata[$k]=$v;
                }
            }
            if (!empty($_POST)){
                foreach($_POST as $k=>$v){
                    $httpdata[$k]=$v;
                }
            }
            $this->U($_SERVER['REQUEST_URI'],$httpdata);
        }
        else if (file_get_contents("php://input")!=="")
        {
            $posturl=file_get_contents("php://input");
            $postarr=str_replace(array('=','&'),DS,$posturl);
            $this->U($_SERVER['REQUEST_URI'].'/'.$postarr);
        }
        else
        {
            if ($_SERVER['REQUEST_URI']=="/" or $_SERVER['REQUEST_URI']==$_SERVER['PATH_INFO']."/"){
                $this->U($_SERVER['REQUEST_URI']."index");
            }
            else
            {
                $this->U($_SERVER['REQUEST_URI']);
            }
        }
    }
    
    private static function U($url,$httpdata="") //URL组装
    {
		$url=str_replace($_SERVER['PATH_INFO'],'',$url);
		// print_r($url);
        if (strstr($url,"?")){
            $part_url=explode('?',$url);
            $part_class=explode('/',$part_url[0]);
            $part_class=array_splice($part_class,1);
            $part_classs=array_splice($part_class,1);
            $Class=Init::$Router[$part_class[0]][0];
            $Action=empty($part_class[1])?"":$part_class[1];
            if (empty($Action)){
                $Action=Init::$Router[$part_class[0]][1];
            }
            $part_params=str_replace('&',"=",$part_url[1]);
            $Params=explode('=',$part_params);
            if (!empty($part_classs)){
                foreach($part_classs as $v){
                    array_push($Params,$v);
                }
            }
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
                include(APP_PATH.ERROR404); 
                return false;
            }
			if (!empty(Init::$Router[$RequestArr[0]][2])){
				$Params=array_merge($Params,explode("/",Init::$Router[$RequestArr[0]][2]));
			}
        }
       
        
        
        
        if ($httpdata==""){
            $s=count($Params);
            $ParamArr=Array();
            for ($i=0;$i<$s;$i++)
            {
                if ($i%2!=0 and $i!==0){
                    $ParamArr[$Params[$i-1]]=self::preventinjection(urldecode($Params[$i]));
                }
            }
        }else{
           
            $ParamArr=Array();
            foreach($httpdata as $k=>$v)
            {
                if (!is_array($v)){
                    $ParamArr[$k]=self::preventinjection(urldecode($v));
                }else{
                    $ParamArr[$k]=$v;
                }
            }
        }
		$Create=new $Class;
		$Action=empty($Action)?"index":$Action;
		if (method_exists($Create,$Action)){
			$Create->$Action($ParamArr);
		}else{
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			include(APP_PATH.ERROR404); 
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
    
    public static function preventinjection($str)
    {
        $str = htmlspecialchars($str);
        // $str = str_replace( '/', "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace("&gt", "", $str);
        $str = str_replace("&lt", "", $str);
        $str = str_replace("<SCRIPT>", "", $str);
        $str = str_replace("</SCRIPT>", "", $str);
        $str = str_replace("<script>", "", $str);
        $str = str_replace("</script>", "", $str);
        $str = str_replace("select","select",$str);
        $str = str_replace("join","join",$str);
        $str = str_replace("union","union",$str);
        $str = str_replace("where","where",$str);
        $str = str_replace("insert","insert",$str);
        $str = str_replace("delete","delete",$str);
        $str = str_replace("update","update",$str);
        $str = str_replace("like","like",$str);
        $str = str_replace("drop","drop",$str);
        $str = str_replace("create","create",$str);
        $str = str_replace("modify","modify",$str);
        $str = str_replace("rename","rename",$str);
        $str = str_replace("alter","alter",$str);
        $str = str_replace("cas","cast",$str);
        $str = str_replace("&","&",$str);
        $str = str_replace(">",">",$str);
        $str = str_replace("<","<",$str);
        $str = str_replace(" ",chr(32),$str);
        $str = str_replace(" ",chr(9),$str);
        $str = str_replace("    ",chr(9),$str);
        $str = str_replace("&",chr(34),$str);
        $str = str_replace("'",chr(39),$str);
        $str = str_replace("<br />",chr(13),$str);
        $str = str_replace("''","'",$str);
        $str = str_replace("css","'",$str);
		$str = str_replace("quot;","",$str);
        $str = str_replace("CSS","'",$str);
        return $str;
        
    }
}