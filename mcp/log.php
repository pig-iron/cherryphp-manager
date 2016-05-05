<?php
namespace mcp;
class log extends \cherryphp\CherryView
{
    private static $rules;
	public function __construct()
	{
        self::$rules=\module\mauthrules::authtoken();
	}
	
	public function index($params)
	{
        $this->assign("rules",explode(",",self::$rules));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['log/loginfo/view'],explode(",",self::$rules))){
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
