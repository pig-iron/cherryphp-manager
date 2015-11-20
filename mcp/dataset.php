<?php
namespace mcp;
class dataset extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	
	public function emailtype($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['邮件类型设置-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/emailtype");
        }
	}
	
	public function get_emailtype($params)
	{
		$res=\module\mdataset::get_emailtype($params);
		echo json_encode($res);
	}
	
	public function set_emailtype($params)
	{
		$res=\module\mdataset::set_emailtype($params);
		echo json_encode($res);
	}
	
	public function itemsetting($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['游戏道具设置-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/itemsetting");
        }
	}
	
	public function get_itemsetting($params)
	{
		$res=\module\mdataset::get_itemsetting($params);
		echo json_encode($res);
	}
	
	public function set_itemsetting($params)
	{
		$res=\module\mdataset::set_itemsetting($params);
		echo json_encode($res);
	}
	
	public function rewardsetting($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['奖励设置-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/rewardsetting");
        }
	}
	
	public function get_rewardsetting($params)
	{
		$res=\module\mdataset::get_rewardsetting($params);
		echo json_encode($res);
	}
	
	public function set_rewardsetting($params)
	{
		$res=\module\mdataset::set_rewardsetting($params);
		echo json_encode($res);
	}
	
	public function multipleactivity($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['多倍奖励活动-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/multipleactivity");
        }
	}
	
	public function get_multipleactivity($params)
	{
		$res=\module\mdataset::get_multipleactivity($params);
		echo json_encode($res);
	}
	
	public function set_multipleactivity($params)
	{
		$res=\module\mdataset::set_multipleactivity($params);
		echo json_encode($res);
	}
	
	public function reward($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['奖励发放-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $rewardsetting_data=\module\mdataset::get_rewardsetting($params);
            $this->assign("rewardsetting_data",json_encode($rewardsetting_data['data'][0]['jsondata']));
            $this->render("mcp/reward");
        }
	}
	
	public function get_reward($params)
	{
		$res=\module\mdataset::get_reward($params);
		echo json_encode($res);
	}
	
	public function set_reward($params)
	{
		$res=\module\mdataset::set_reward($params);
		echo json_encode($res);
	}	
    
    public function send_reward_show()
    {
        $this->render("mcp/reward/sendreward");
    }
	
}
