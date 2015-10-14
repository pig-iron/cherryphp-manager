<?php
namespace mcp;
class gameserver extends \cherryphp\CherryView
{
	public function __construct()
	{
	}
    
    public function index()
    {
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['游戏服务器'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/gameserver"); 
        }        
    }
    
    public function showBattleServer()
    {
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['BattleServer-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/battleserver"); 
        }        
    }
    
    public function showLogin()
    {
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['Login-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/loginserver");
        }        
    }
    
    public function showServer()
    {
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['Server-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/defaultserver"); 
        }        
    }
    public function getall(){
        $getobj=new \module\mzkserver;
        $res=$getobj->getAllServer();
        echo "<pre>";
        print_r($res);
    }
	public function getBattleServer($params)
	{
		$getobj=new \module\mzkserver;
        $res=$getobj->getBattleServer($params);
		echo json_encode(array("total"=>$res['total'],"data"=>$res['data']));
	}
    
    public function activeServer($params)
    {
        $getobj=new \module\mzkserver;
        $res=$getobj->activeServer($params);
		echo json_encode($res);
    }
    
	public function reActiveServer($params)
    {
        $getobj=new \module\mzkserver;
        $res=$getobj->reActiveServer($params);
		echo json_encode($res);
    }
    
	public function getLogin($params)
	{
		$getobj=new \module\mzkserver;
        $res=$getobj->getLogin($params);
		echo json_encode(array("total"=>$res['total'],"data"=>$res['data']));
	}
    
    public function getServer($params)
	{
		$getobj=new \module\mzkserver;
        $res=$getobj->getServer($params);
		echo json_encode(array("total"=>$res['total'],"data"=>$res['data']));
	}

}
