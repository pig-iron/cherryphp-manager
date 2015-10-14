<?php
namespace module;
class mdataset
{
	public function __construct()
	{

	}
	
	public static function get_emailtype($params)
	{
		$stats=0;
		$sql1="SELECT * FROM rogmgr_gamedata WHERE type='emailtype'";
		$all=\Init::db()->fetch_query($sql1);
		if ($all){
			$stats=1;
		}
		return array("stats"=>$stats,"data"=>$all);
	}
	
	public static function set_emailtype($params)
	{
		$sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['jsondata']."' WHERE type='emailtype'";
		$stats=\Init::db()->sql_query($sql1);
        \module\mlog::sysLog("修改emailtype，value:".$params['jsondata']);
		return array("stats"=>$stats);
	}
	
	public static function get_itemsetting($params)
	{
		$stats=0;
		$sql1="SELECT * FROM rogmgr_gamedata WHERE type='itemsetting'";
		$all=\Init::db()->fetch_query($sql1);
		if ($all){
			$stats=1;
		}
		return array("stats"=>$stats,"data"=>$all);
	}
	
	public static function set_itemsetting($params)
	{
		$sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['jsondata']."' WHERE type='itemsetting'";
		$stats=\Init::db()->sql_query($sql1);
        \module\mlog::sysLog("修改itemsetting，value:".$params['jsondata']);
		return array("stats"=>$stats);
	}
	
	public static function get_rewardsetting($params)
	{
		$stats=0;
		$sql1="SELECT * FROM rogmgr_gamedata WHERE type='rewardsetting'";
		$all=\Init::db()->fetch_query($sql1);
		if ($all){
			$stats=1;
		}
		return array("stats"=>$stats,"data"=>$all);
	}
	
	public static function set_rewardsetting($params)
	{
		$sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['jsondata']."' WHERE type='rewardsetting'";
		$stats=\Init::db()->sql_query($sql1);
        \module\mlog::sysLog("修改rewardsetting，value:".$params['jsondata']);
		return array("stats"=>$stats);
	}
	
	public static function get_multipleactivity($params)
	{
		$stats=0;
		$sql1="SELECT * FROM rogmgr_gamedata WHERE type='multipleactivity'";
		$all=\Init::db()->fetch_query($sql1);
		if ($all){
			$stats=1;
		}
		return array("stats"=>$stats,"data"=>$all);
	}
	
	public static function set_multipleactivity($params)
	{
		$sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['jsondata']."' WHERE type='multipleactivity'";
		$stats=\Init::db()->sql_query($sql1);
        \module\mlog::sysLog("修改multipleactivity，value:".$params['jsondata']);
		return array("stats"=>$stats);
	}
	
	public static function get_reward($params)
	{
		$stats=0;
		$sql1="SELECT * FROM rogmgr_gamedata WHERE type='reward'";
		$all=\Init::db()->fetch_query($sql1);
		if ($all){
			$stats=1;
		}
		return array("stats"=>$stats,"data"=>$all);
	}
	
	public static function set_reward($params)
	{
		$sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['jsondata']."' WHERE type='reward'";
		$stats=\Init::db()->sql_query($sql1);
        \module\mlog::sysLog("修改reward，value:".$params['jsondata']);
		return array("stats"=>$stats);
	}	
	
}