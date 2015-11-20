<?php
namespace mcp;
class version extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	public function index()
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['版本发布-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $res=\module\mversion::get_version();
            $dbv=\module\mversion::get_db_version();
            $this->assign("ver_l",$res);
            $this->assign("dbv",$dbv);
            $this->render("mcp/version");
        }
    }
    public function save($params){
        $res=\module\mversion::save_version($params);
        echo json_encode($res);
    }
}