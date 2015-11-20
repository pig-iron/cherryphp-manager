<?php
namespace mcp;
class login extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	public function index($params)
	{
		$this->render("mcp/login");
	}
	public function auth($params)
	{
        $auth=\module\mauthorization::auth_admin($params);
        if ($auth['state']==1){
            setcookie("rogmgr_user",$params['user'],time()+3600,'/');
            setcookie("rogmgr_rules",$auth['rules'],time()+3600,'/');
            echo json_encode(array("state"=>1,"auth"=>1));
        }else{
            echo json_encode(array("state"=>0,"auth"=>0));
        }
	}
	
	public function logout($params)
	{
		setcookie("rogmgr_user","",time()-3600,'/');
        setcookie("rogmgr_rules","",time()-3600,'/');
		echo json_encode(array("state"=>1,"auth"=>0));
	}
    
    public function get_kv($params){
        
        $sql2="SELECT * FROM rogmgr_admin WHERE id='".$params['id']."'";
        // $aaa=chr(0xbf).chr(0x27).' OR username = username /*';
        print_r($sql2);exit;
        $one=\Init::db()->fetch_query($sql2);
        print_r($one);exit;
        \module\mauthorization::get_rules_kv();
    }
}
