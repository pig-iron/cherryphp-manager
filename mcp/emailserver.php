<?php
namespace mcp;
class emailserver extends \cherryphp\CherryView
{
	public function __construct()
	{
	}
    
    public function index()
    {
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['邮件服务器-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/emailserver"); 
        }        
    }

	public function getEmailServer($params)
	{
		$getobj=new \module\mzkserver;
        $res=$getobj->getEmailServer($params);
		echo json_encode($res);
	}

}
