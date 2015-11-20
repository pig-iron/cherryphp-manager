<?php
namespace module;
class mbbs
{
	public function __construct()
	{

	}
	
	public static function getAllLog($params)
	{
		if ($params['page']!=='0'){
			$s_page=$params['page']*PAGE-PAGE;
			$sql1="SELECT * FROM rogmgr_log ORDER BY ctime DESC LIMIT ".$s_page.",".PAGE;
		}else{
			$sql1="SELECT * FROM rogmgr_log ORDER BY ctime DESC";
		}
		$sql2="SELECT count(*) as counts FROM rogmgr_log";
		$all_total=\Init::db()->fetch_query($sql2);
		$all=\Init::db()->fetch_query($sql1);
		return array("total"=>$all_total,"data"=>$all);
	}
	
	public static function getOneLog($params)
	{
		$sql1="SELECT * FROM rogmgr_log";
		$all=\Init::db()->fetch_query($sql1);
		$sql2="SELECT * FROM rogmgr_log WHERE id='".$params['id']."'";
		$one=\Init::db()->fetch_query($sql2);
		$alls=array("all"=>$all,"one"=>$one);
		return $alls;
	}
    
    public static function sysLog($msg){
        $sql="INSERT INTO `rogmgr`.`rogmgr_log` (`id`, `admin`, `msg`, `ctime`) VALUES (NULL, '".$_COOKIE['rogmgr_user']."', '".$msg."', CURRENT_TIMESTAMP);";
        \Init::db()->sql_query($sql);
    }

}
