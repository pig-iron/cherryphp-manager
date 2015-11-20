<?php
namespace mcp;
class analytics extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	
	public function index($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['统计信息-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/analytics");
        }
    }
    public function gettoday($params)
    {
        $res=\module\manalytics::get_now();
        echo json_encode($res);
    }
    
    public function details($params)
    {
        $res=\module\manalytics::get_details($params);
        $this->assign("date",$res['date']);
        $this->assign("data",$res['data']);
        $this->assign("name",$res['name']);
        $this->render("mcp/analytics/analytics_details");
    }
}