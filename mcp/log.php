<?php
namespace mcp;
class log extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	
	public function index($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['操作日志-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/log");
        }
	}
	
	
	
	public function getAllLog($params)
	{
		$getall=\module\mlog::getAllLog($params);
		echo json_encode($getall);
	}

	public function getOneLog($params)
	{
		$getone=\module\mlog::getOneLog($params);
		echo json_encode($getone);
	}
    

}
