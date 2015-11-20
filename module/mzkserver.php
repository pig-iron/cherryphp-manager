<?php
namespace module;
class mzkserver
{
    public static $zk;
	public function __construct()
	{
        $zk_config=\Init::$Config['zookeeper'][0];
        self::$zk=\library\zookeeper\impl::getImpl($zk_config['ZOOKEEPER_HOST'],$zk_config['ZK_SERVER_PATH'],$zk_config['ZK_MAIL_PATH']);
	}
	
	public static function getAllServer()
	{
        $allserver_c=array();
        $allserver=self::$zk->getServers();
        foreach($allserver as $v){
            $allserver_c[$v['server_type']][]=$v;
        }
        return $allserver_c;
	}
	
	public static function getBattleServer($params)
	{
		$allserver=self::getAllServer();
        $all_total=array("counts"=>count($allserver['BattleServer']));
        $offset=$params['page']*10-10;
        $all=array_slice($allserver['BattleServer'],$offset,10);
		return array("total"=>$all_total,"data"=>$all);
	}
	
	public static function getLogin($params)
	{
		$allserver=self::getAllServer();
        $all_total=array("counts"=>count($allserver['Login']));
        $offset=$params['page']*10-10;
        $all=array_slice($allserver['Login'],$offset,10);
		return array("total"=>$all_total,"data"=>$all);
	}
    
    public static function getServer($params)
	{
		$allserver=self::getAllServer();
        $all_total=array("counts"=>count($allserver['Server']));
        $offset=$params['page']*10-10;
        $all=array_slice($allserver['Server'],$offset,10);
		return array("total"=>$all_total,"data"=>$all);
	}
    
    public static function activeServer($params)
	{
		$arr_sid = explode(",", $params['data']);
        foreach ($arr_sid as $key => $sid) {
            $request = '{"gmcmd":"active", "sid":"'. $sid .'"}';
            $retVal = self::$zk->sendGMCmd($request);
            \module\mlog::sysLog("激活服务器，ID:".$sid);
            return $retVal;
        }
    }
    
    public static function reActiveServer($params)
	{
		$arr_sid = explode(",", $params['data']);
        foreach ($arr_sid as $key => $sid) {
            $request = '{"gmcmd":"unactive", "sid":"'. $sid .'"}';
            $retVal = self::$zk->sendGMCmd($request);
            \module\mlog::sysLog("反激活服务器，ID:".$sid);
            return $retVal;
        }
    }
    
    public static function sendGMcode($params)
	{
        
        $request = '{';
        foreach ($params as $key => $sid) {
            $request .= '"'.$key.'":"'.$sid.'", ';
        }
        $request=substr($request,0,-2);
        $request .= '}';
        
        $retVal = self::$zk->sendGMCmd($request);
        \module\mlog::sysLog("发送GM命令:".$request);
        return $retVal;
        
    }
    
    public static function getEmailServer($params)
	{
        $allserver=self::$zk->getMails();
        $all_total=array("counts"=>count($allserver));
        $offset=$params['page']*10-10;
        $all=array_slice($allserver,$offset,10);
        return array("total"=>$all_total,"data"=>$all);
	}
}
