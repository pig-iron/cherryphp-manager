<?php
namespace module;
class mauthorization
{
	public function __construct()
	{

	}
	
	public static function get_rules($params)
	{
		if ($params['page']!=='0'){
			$s_page=$params['page']*PAGE-PAGE;
			$sql1="SELECT * FROM rogmgr_rules_data LIMIT ".$s_page.",".PAGE;
		}else{
			$sql1="SELECT * FROM rogmgr_rules_data";
		}
		$sql2="SELECT count(*) as counts FROM rogmgr_rules_data";
		$all_total=\Init::db()->fetch_query($sql2);
		$all=\Init::db()->fetch_query($sql1);
		return array("total"=>$all_total,"data"=>$all);
	}
	
	public static function get_rules_one($params)
	{
		$sql1="SELECT * FROM rogmgr_rules_data";
		$all=\Init::db()->fetch_query($sql1);
		$sql2="SELECT * FROM rogmgr_rules_data WHERE id='".$params['id']."'";
		$one=\Init::db()->fetch_query($sql2);
		$alls=array("all"=>$all,"one"=>$one);
		return $alls;
	}
	
	public static function rules_add($params)
	{
		$sql1="SELECT * FROM rogmgr_rules_data WHERE id='".$params['id']."'";
		$all=\Init::db()->fetch_query($sql1);
		$sql2="SELECT * FROM rogmgr_rules_data WHERE deep='".($all[0]['deep']+1)."' and pid='".$all[0]['id']."' ORDER BY rid DESC";
		$all_deep=\Init::db()->fetch_query($sql2);
		// print_r($sql2);exit;
		if (!empty($all_deep)){ 
			/*
			** 有子项，寻找最大子项值，更新所有大于最大子项右值的其他项的左右值全部+2，新值的左值等于最大子项右值+1，新值的右值等于最大子项右值+2
			*/
			$big_rgt=$all_deep[0]['rid'];
			$big_deep=$all_deep[0]['deep'];
			$sql3="call rogmgr.add_rules_right('".$params['name']."',".$big_rgt.",".$big_deep.",".$params['id'].");";
			$stats=\Init::db()->sql_query($sql3);
			if (!$stats){
				$drop_add_rules_right='DROP PROCUDURE add_rules_right;';
				\Init::db()->sql_query($drop_add_rules_right);
				$procedure_add_rules_right="
				CREATE PROCEDURE add_rules_right(IN `big_name` VARCHAR(255) CHARSET utf8, IN `big_rgt` INT, IN `big_deep` INT, IN `id` INT)
				BEGIN
				DECLARE t_error INTEGER DEFAULT 0;  
				DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
				START TRANSACTION;  
				UPDATE rogmgr_rules_data set lid=lid+2 WHERE lid>big_rgt;     
				UPDATE rogmgr_rules_data set rid=rid+2 WHERE rid>big_rgt;
				INSERT INTO rogmgr_rules_data set lid=big_rgt+1, rid=big_rgt+2, name=big_name, deep=big_deep, pid=id;
				IF t_error = 1 THEN  
				ROLLBACK;  
				ELSE
				COMMIT;
				END IF;  
				END;
				";
				\Init::db()->sql_query($procedure_add_rules_right);
				$sql3="call rogmgr.add_rules_right('".$params['name']."',".$big_rgt.",".$big_deep.",".$params['id'].");";
				$stats=\Init::db()->sql_query($sql3);
                self::cache_rules_kv();
                \module\mlog::sysLog("添加权限项，ID:".$params['id']);
				return array("stats"=>$stats);
			}
            self::cache_rules_kv();
            \module\mlog::sysLog("添加权限项，ID:".$params['id']);
			return array("stats"=>$stats);
		}else{
			/*
			** 无子项，上一级项目即为最大子项，更新所有大于最大子项左值的其他项的左右值全部+2，新值的左值等于最大子项左值+1，新值的右值等于最大子项左值+2
			*/
			$big_lft=$all[0]['lid'];
			$big_deep=$all[0]['deep'];
			
			$sql3="call rogmgr.add_rules_sub('".$params['name']."',".$big_lft.",".$big_deep.",".$params['id'].");";
			$stats=\Init::db()->sql_query($sql3);
			if (!$stats){
				$drop_add_rules_sub='DROP PROCUDURE add_rules_sub;';
				\Init::db()->sql_query($drop_add_rules_sub);
				$procedure_add_rules_sub='
				CREATE PROCEDURE add_rules_sub(IN `big_name` VARCHAR(255) CHARSET utf8, IN `big_lft` INT, IN `big_deep` INT, IN `id` INT)
				BEGIN
				DECLARE t_error INTEGER DEFAULT 0;  
				DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
				START TRANSACTION;  
				UPDATE rogmgr_rules_data set lid=lid+2 WHERE lid>big_lft;     
				UPDATE rogmgr_rules_data set rid=rid+2 WHERE rid>big_lft;
				INSERT INTO rogmgr_rules_data set lid=big_lft+1, rid=big_lft+2, name=big_name, deep=big_deep+1, pid=id;
				IF t_error = 1 THEN  
				ROLLBACK;
				ELSE
				COMMIT;
				END IF;
				END;
				';
				\Init::db()->sql_query($procedure_add_rules_sub);
				$sql3="call rogmgr.add_rules_sub('".$params['name']."',".$big_lft.",".$big_deep.",".$params['id'].");";
				$stats=\Init::db()->sql_query($sql3);
                self::cache_rules_kv();
                \module\mlog::sysLog("添加权限项，ID:".$params['id']);
				return array("stats"=>$stats);
			}
            self::cache_rules_kv();
            \module\mlog::sysLog("添加权限项，ID:".$params['id']);
			return array("stats"=>$stats);
		}
	}
	
	public static function rules_delete($params)
	{
		$sql1="SELECT * from rogmgr_rules_data WHERE id='".$params['id']."'";
		$all=\Init::db()->fetch_query($sql1);
		$big_rgt=$all[0]['rid'];
		$sql3="call rogmgr.delete_rules(".$params['id'].",".$big_rgt.");";
		$stats=\Init::db()->sql_query($sql3);
		if (!$stats){
			$delete_rules='DROP PROCUDURE delete_rules;';
			\Init::db()->sql_query($delete_rules);
			$procedure_delete_rules='
			CREATE PROCEDURE delete_rules(IN `t_id` INT, IN `big_rgt` INT)
			BEGIN
			DECLARE t_error INTEGER DEFAULT 0;  
			DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
			START TRANSACTION;  
			UPDATE rogmgr_rules_data set lid=lid-2 WHERE lid>big_rgt;     
			UPDATE rogmgr_rules_data set rid=rid-2 WHERE rid>big_rgt;
			DELETE FROM rogmgr_rules_data WHERE id=t_id;
			IF t_error = 1 THEN  
			ROLLBACK;
			ELSE
			COMMIT;
			END IF;
			END;
			';
			\Init::db()->sql_query($procedure_delete_rules);
			$sql3="call rogmgr.delete_rules(".$params['id'].",".$big_rgt.");";
			$stats=\Init::db()->sql_query($sql3);
            self::cache_rules_kv();
            \module\mlog::sysLog("删除权限项，ID:".$params['id']);
			return array("stats"=>$stats);
		}
        self::cache_rules_kv();
        \module\mlog::sysLog("删除权限项，ID:".$params['id']);
		return array("stats"=>$stats);
	}
	
    public static function get_rules_kv(){
        if ($_COOKIE['rogmgr_user']){
            if (file_exists(APP_PATH."cache/rules_kv.map")){
                return require_once(APP_PATH."cache/rules_kv.map");
            }else{
                self::cache_rules_kv();
                return require(APP_PATH."cache/rules_kv.map");
            }
        }else{
			echo "<script>window.location.href='/index'</script>";
		}
    }
    
    public static function cache_rules_kv(){
        $sql1="SELECT id,name from rogmgr_rules_data";
        $all=\Init::db()->fetch_query($sql1);
        $allkv=array();
        foreach ($all as $v){
            $allkv[$v['name']]=$v['id'];
        }
        file_put_contents(APP_PATH."cache/rules_kv.map","<?php return ".var_export($allkv,true)."; ?>");
    }
    
	public static function rules_update($params)
	{
		$ids=array("id"=>$params['pid']);
		\module\mauthorization::rules_delete($ids);
		$stats=\module\mauthorization::rules_add($params);
		return $stats;
	}
	
	public static function get_role($params)
	{
		if ($params['page']!=='0'){
			$s_page=$params['page']*PAGE-PAGE;
			$sql1="SELECT * FROM rogmgr_user_rules LIMIT ".$s_page.",".PAGE;
		}else{
			$sql1="SELECT * FROM rogmgr_user_rules";
		}
		$sql2="SELECT count(*) as counts FROM rogmgr_user_rules";
		$all_total=\Init::db()->fetch_query($sql2);
		$all=\Init::db()->fetch_query($sql1);
		return array("total"=>$all_total,"data"=>$all);
	}
	
	public static function get_role_one($params)
	{
		$sql1="SELECT * FROM rogmgr_rules_data";
		$all=\Init::db()->fetch_query($sql1);
		$sql2="SELECT * FROM rogmgr_user_rules WHERE id='".$params['id']."'";
		$one=\Init::db()->fetch_query($sql2);
		$alls=array("all"=>$all,"one"=>$one);
		return $alls;
	}
	
	public static function role_add($params)
	{
		$sql="INSERT INTO rogmgr_user_rules SET name='".$params['name']."', rules='".$params['rules']."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("添加角色,角色名称:".$params['name']."角色权限项:".$params['rules']);
		return array("stats"=>$stats);
	}
	
	public static function role_update($params)
	{
		$sql="UPDATE rogmgr_user_rules SET name='".$params['name']."', rules='".$params['rules']."' WHERE id='".$params['id']."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("修改角色,ID:".$params['id']."角色名称:".$params['name']."角色权限项:".$params['rules']);
		return array("stats"=>$stats);
	}

	public static function role_delete($params)
	{
		$sql="DELETE FROM rogmgr_user_rules WHERE id='".$params['id']."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("删除角色,ID:".$params['id']);
		return array("stats"=>$stats);
	}
	
	public static function get_admin($params)
	{
		if ($params['page']!=='0'){
			$s_page=$params['page']*PAGE-PAGE;
			$sql1="SELECT a.id,a.name,b.name AS rulesname FROM rogmgr_admin AS a LEFT JOIN rogmgr_user_rules AS b ON a.urid=b.id  LIMIT ".$s_page.",".PAGE;
		}else{
			$sql1="SELECT a.id,a.name,b.name AS rulesname FROM rogmgr_admin AS a LEFT JOIN rogmgr_user_rules AS b ON a.urid=b.id";
		}
		$sql2="SELECT count(*) as counts FROM rogmgr_admin";
		$all_total=\Init::db()->fetch_query($sql2);
		$all=\Init::db()->fetch_query($sql1);
		return array("total"=>$all_total,"data"=>$all);
	}
	
	public static function get_admin_one($params)
	{
		$sql1="SELECT * FROM rogmgr_user_rules";
		$all=\Init::db()->fetch_query($sql1);
		$sql="SELECT * FROM rogmgr_admin WHERE id='".$params['id']."'";
		$one=\Init::db()->fetch_query($sql);
		$alls=array("all"=>$all,"one"=>$one);
		return $alls;
	}
	
    public static function auth_admin($params)
	{
		$sql1="SELECT * FROM rogmgr_admin WHERE name='".$params['user']."'";
		$all=\Init::db()->fetch_query($sql1);
        if ($all[0]['passwd']==md5($params['pass'])){
            $sql="SELECT rules FROM rogmgr_user_rules WHERE id='".$all[0]['urid']."'";
            $rules=\Init::db()->fetch_query($sql);
            $alls=array("state"=>1,"rules"=>$rules[0]['rules']);
            return $alls;
        }else{
            $alls=array("state"=>0,"rules"=>"");
            return $alls;
        }
	}
    
	public static function admin_add($params)
	{
		$sql="INSERT INTO rogmgr_admin set name='".$params['name']."', urid='".$params['uid']."', passwd='".md5($params['passwd'])."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("添加管理员".$params['name']);
		return array("stats"=>$stats);
	}
	
	public static function admin_update($params)
	{
		$sql="UPDATE rogmgr_admin SET name='".$params['name']."', urid='".$params['urid']."' WHERE id='".$params['id']."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("更新管理员信息,ID:".$params['id']."管理员名称:".$params['name']."角色ID:".$params['urid']);
		return array("stats"=>$stats);
	}

	public static function admin_delete($params)
	{
		$sql="DELETE FROM rogmgr_admin WHERE id='".$params['id']."'";
		$stats=\Init::db()->sql_query($sql);
        \module\mlog::sysLog("删除管理员,ID:".$params['id']);
		return array("stats"=>$stats);
	}
	
	public static function admin_chpass_check($params)
	{
		$sql="SELECT * FROM rogmgr_admin WHERE id='".$params['id']."'";
		$all=\Init::db()->fetch_query($sql);
		if (md5($params['oldpass'])==$all[0]['passwd']){
			return true;
		}else{
			return false;
		}
	}
	
	public static function admin_chpass($params)
	{
		$is_true=self::admin_chpass_check($params);
		if ($is_true){
			$sql="UPDATE rogmgr_admin SET passwd='".md5($params['newpass'])."' WHERE id='".$params['id']."'";
			$stats=\Init::db()->sql_query($sql);
            \module\mlog::sysLog("修改管理员密码,ID:".$params['id']);
			return array("stats"=>$stats);
		}else{
			return array("stats"=>0);
		}
	}
}
