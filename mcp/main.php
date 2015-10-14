<?php
namespace mcp;
class main extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	public function index($params)
	{
		if ($_COOKIE['rogmgr_user']){
            $this->assign("agent",$_COOKIE['rogmgr_user']);
            $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
            $rules_kv=\module\mauthorization::get_rules_kv();
            $this->assign("rules_kv",$rules_kv);
			$this->render("mcp/main");
		}else{
			header('location: ../login');
		}
	}

}
