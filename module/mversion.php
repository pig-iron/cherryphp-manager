<?php
namespace module;
class mversion
{
	public static $aws;
	public function __construct()
	{
       
	}
	
	public static function get_version()
	{
        include(APP_PATH."library/aws.phar");
        $aws_config=\Init::$Config['aws'][0];
        self::$aws = \Aws\S3\S3Client::factory ( array (
            'key'          => $aws_config['key'],
            'secret'       => $aws_config['secret'],
            'region'       => $aws_config['region'],
            'curl.options' => array(
                'CURLOPT_CONNECTTIMEOUT' => 10,
                'CURLOPT_TIMEOUT'        => 10,
            )
        ));
        $aws_config=\Init::$Config['aws'][0];
        $result = self::$aws->listObjects(array(
            // Bucket is required
            'Bucket' => $aws_config['bucket'],
            'Prefix' => 'roggame/code/gamecode/',
        ));

        $array = $result['Contents'];
        $all = array();
        $idx = 0;
        for($i = 0; $i < count($array); $i++)
        {
            $strversion = str_replace("roggame/code/gamecode/", "",$array[$i]["Key"]);
            if($strversion == "")
                continue;
            $tmp = explode("/",$strversion);
            if(count($tmp) == 0)
                continue;
            if(!preg_match("/\d+$/", $tmp[0]))
                continue;
            $all[$tmp[0]] = 1;
        }
        $allversion = array();
        foreach($all as $key=>$value)
        {
            $allversion[$idx++] = $key;
        }
        return $allversion;
    }
    
    public static function get_db_version()
    {
        $sql1="SELECT * FROM rogmgr_gamedata WHERE type='version'";
		$res=\Init::db()->fetch_query($sql1);
		return $res;
    }
    
    public static function save_version($params)
    {
        $sql1="UPDATE rogmgr_gamedata SET jsondata='".$params['version']."' WHERE type='version'";
		$stats=\Init::db()->sql_query($sql1);
        $statss=\Init::cache('redis')->_Cset(array("global:server_version",$params['version']));
        if ($stats && $statss){
            $stats=1;
        }else{
            $stats=0;
        }
        \module\mlog::sysLog("修改version，value:".$params['version']);
		return array("stats"=>$stats);
    }
}