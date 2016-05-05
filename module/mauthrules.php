<?php
namespace module;
class mauthrules
{
	public function __construct()
	{
       
	}
    
    public static function authtoken()
    {
        $r_t=self::preventinjection($_COOKIE['r_t']);
        if (!empty($_SESSION[$r_t]) && !empty($_SESSION[$r_t."_salt"])){
            if ($r_t==md5($_SESSION[$r_t].$_SESSION[$r_t."_salt"])){
                return $_SESSION[$_SESSION[$r_t].'_rules'];
            }else{
                setcookie("r_t","",time()-3600,'/');
                unset($_SESSION[$params['user']]);
                unset($_SESSION[$params['user']."_rules"]);
                session_destroy();
                return false;
            }
        }else{
            setcookie("r_t","",time()-3600,'/');
            unset($_SESSION[$params['user']]);
            unset($_SESSION[$params['user']."_rules"]);
            session_destroy();
            return false;
        }
    }
    
    public static function preventinjection($str)
    {
        if (empty($str)){
            return false;
        }else{
            $str = htmlspecialchars($str);
            $str = str_replace( '/', "", $str);
            $str = str_replace("\\", "", $str);
            $str = str_replace("&gt", "", $str);
            $str = str_replace("&lt", "", $str);
            $str = str_replace("<SCRIPT>", "", $str);
            $str = str_replace("</SCRIPT>", "", $str);
            $str = str_replace("<script>", "", $str);
            $str = str_replace("</script>", "", $str);
            $str=str_replace("select","select",$str);
            $str=str_replace("join","join",$str);
            $str=str_replace("union","union",$str);
            $str=str_replace("where","where",$str);
            $str=str_replace("insert","insert",$str);
            $str=str_replace("delete","delete",$str);
            $str=str_replace("update","update",$str);
            $str=str_replace("like","like",$str);
            $str=str_replace("drop","drop",$str);
            $str=str_replace("create","create",$str);
            $str=str_replace("modify","modify",$str);
            $str=str_replace("rename","rename",$str);
            $str=str_replace("alter","alter",$str);
            $str=str_replace("cas","cast",$str);
            $str=str_replace("&","&",$str);
            $str=str_replace(">",">",$str);
            $str=str_replace("<","<",$str);
            $str=str_replace(" ",chr(32),$str);
            $str=str_replace(" ",chr(9),$str);
            $str=str_replace("    ",chr(9),$str);
            $str=str_replace("&",chr(34),$str);
            $str=str_replace("'",chr(39),$str);
            $str=str_replace("<br />",chr(13),$str);
            $str=str_replace("''","'",$str);
            $str=str_replace("css","'",$str);
            $str=str_replace("CSS","'",$str);
            return $str;
        }
    }
}