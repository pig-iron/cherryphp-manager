<?php
namespace library\i18n;
class lang
{
    public function __construct()
    {
        
    }
    
    public static function setlanguage()
    {
        if (isset($_COOKIE['lang'])){
            $lang=\module\mauthrules::preventinjection($_COOKIE['lang']);
        }else{
            setcookie("lang","en_US",time()+3600,'/');
            $lang="en_US";
        }
        switch($lang){
            case "zh_CN":
                putenv('LANG=zh_CN' );   
                setlocale(LC_ALL, 'zh_CN' );
                $domain='zh_CN' ;                    
                bindtextdomain($domain ,"./library/i18n/locale"); 
                bind_textdomain_codeset($domain ,'UTF-8');
                textdomain($domain);
            break;
            case "en_US":
                putenv('LANG=en_US' );   
                setlocale(LC_ALL, 'en_US' );
                $domain='en_US' ;                    
                bindtextdomain($domain,"./library/i18n/locale");
                bind_textdomain_codeset($domain ,'UTF-8');
                textdomain($domain);
            break;
        }
    }
}

