<?php
namespace mcp;
class main extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	public function index($params)
	{
		if (isset($_COOKIE['r_t']) && $_COOKIE['r_t']){
            $rules=\module\mauthrules::authtoken();
            if ($rules){
                $r_t=\module\mauthrules::preventinjection($_COOKIE['r_t']);
                $this->assign("agent",$_SESSION[$r_t]);
                $this->assign("rules",explode(",",$rules));
                $rules_kv=\module\mauthorization::get_rules_kv();
                $this->assign("rules_kv",$rules_kv);
                $this->render("mcp/main");
            }else{
                header("Location: ./login");
            }
		}else{
            header("Location: ./login");
        }
	}

}
