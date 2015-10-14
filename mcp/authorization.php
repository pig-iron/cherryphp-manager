<?php
namespace mcp;
class authorization extends \cherryphp\CherryView
{
	public function __construct()
	{

	}
	
	public function index($params)
	{
		if ($_COOKIE['rogmgr_user']){
		}else{
			header('location: ../login');
		}
	}
	
	public function role()
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['角色管理-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/role");
        }
	}
	
	public function role_add_show()
	{
		$this->render("mcp/role/role_add");
	}
	
	public function role_add($params)
	{
		$res_add_role=\module\mauthorization::role_add($params);
		echo json_encode($res_add_role);
	}
	
	public function role_update_show()
	{
		$this->render("mcp/role/role_update");
	}
	public function role_update($params)
	{
		$res_role_update=\module\mauthorization::role_update($params);
		echo json_encode($res_role_update);
	}
	
	public function role_delete($params)
	{
		$res_role_delete=\module\mauthorization::role_delete($params);
		echo json_encode($res_role_delete);
	}
	
	public function get_role($params)
	{
		$allrules=\module\mauthorization::get_role($params);
		echo json_encode($allrules);
	}
	
	public function get_role_one($params)
	{
		$allrules=\module\mauthorization::get_role_one($params);
		echo json_encode($allrules);
	}
	
	public function admin()
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['管理员管理-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/admin");
        }
	}
	
	public function admin_add_show()
	{
		$this->render("mcp/admin/admin_add");
	}
	
	public function admin_chpass_show()
	{
		$this->render("mcp/admin/admin_chpass");
	}
	
	public function admin_chpass_check($params)
	{
		$res_admin_chpass_check=\module\mauthorization::admin_chpass_check($params);
		echo json_encode($res_admin_chpass_check);
	}
	
	public function admin_chpass($params)
	{
		$res_admin_chpass=\module\mauthorization::admin_chpass($params);
		echo json_encode($res_admin_chpass);
	}
	
	public function admin_add($params)
	{
		$res_admin_add=\module\mauthorization::admin_add($params);
		echo json_encode($res_admin_add);
	}
	
	public function admin_update_show()
	{
		$this->render("mcp/admin/admin_update");
	}
	
	public function admin_update($params)
	{
		$res_admin_update=\module\mauthorization::admin_update($params);
		echo json_encode($res_admin_update);
	}
	
	public function admin_delete($params)
	{
		$res_admin_delete=\module\mauthorization::admin_delete($params);
		echo json_encode($res_admin_delete);
	}
	
	public function get_admin($params)
	{
		$allrules=\module\mauthorization::get_admin($params);
		echo json_encode($allrules);
	}
	
	public function get_admin_one($params)
	{
		$allrules=\module\mauthorization::get_admin_one($params);
		echo json_encode($allrules);
	}
	
	public function authorization($params)
	{
        $this->assign("rules",explode(",",$_COOKIE['rogmgr_rules']));
        $rules_kv=\module\mauthorization::get_rules_kv();
        $this->assign("rules_kv",$rules_kv);
        if (in_array($rules_kv['权限项管理-查看'],explode(",",$_COOKIE['rogmgr_rules']))){
            $this->render("mcp/authorization");
        }
	}
	
	public function get_rules($params){
		$allrules=\module\mauthorization::get_rules($params);
		echo json_encode($allrules);
	}
	
	public function get_rules_one($params){
		$allrules=\module\mauthorization::get_rules_one($params);
		echo json_encode($allrules);
	}
	
	public function rules_add_show($params)
	{
		$this->render("mcp/rules/rules_add");
	}
	
	public function rules_add($params)
	{
		$res_add_rules=\module\mauthorization::rules_add($params);
		echo json_encode($res_add_rules);
	}
	
	public function rules_delete($params)
	{
		$res_del_rules=\module\mauthorization::rules_delete($params);
		echo json_encode($res_del_rules);
	}
	
	public function rules_update_show($params)
	{
		$this->render("mcp/rules/rules_update");
	}
	
	public function rules_update($params)
	{
		$res_add_rules=\module\mauthorization::rules_update($params);
		echo json_encode($res_add_rules);
	}
	
}
