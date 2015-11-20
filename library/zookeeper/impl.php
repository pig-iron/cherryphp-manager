<?php
namespace library\zookeeper;
class impl extends \library\zookeeper\base
{
    private static $impl; //can not be extends
    private $zk;
    private $mailpath;
    private $serverpath;
    public function __construct($address, $ser_path, $mail_path) {
        $this->zk = new \library\zookeeper\base($address);
        $this->mailpath = $mail_path;
        $this->serverpath = $ser_path;
    }

    function __clone() {
        return self::$impl;
    }

    public static function getImpl($address, $ser_path, $mail_path) {
        if (empty(self::$impl)) {
            self::$impl = new self($address, $ser_path, $mail_path);
        }
        return self::$impl;
    }

    function Get($path) {
        $serverarr = array();
        $servers = $this->zk->getChildren($path);
        foreach($servers as $i=>$val) {
            $serverarr[] = json_decode($this->zk->get($path . '/'. $val), true);
        }
        return $serverarr;
    }

    public function  getServers() {
        return $this->Get($this->serverpath);
    }

    public function getMails() {
        return $this->Get($this->mailpath);
    }

    public function sendGMCmd($gmcmd) {
        global $lang;
        $cmdarr = json_decode($gmcmd, true);
        $res = array();
        $res['ret'] = 0;
        if(!is_array($cmdarr) || count($cmdarr) == 0) {
            $res['msg'] =  $lang[NOTJSON];
            return json_encode($res);
        }
        $mails = $this->getMails();
        if(!is_array($mails) || count($mails) == 0) {
            $res['msg'] = $lang[NOMAIL];
            return json_encode($res);
        }
        $ip = $mails[0][SERVICE_IP];
        $port = intval($mails[0][GMPORT]);
        set_time_limit(20);

        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if($sock < 0) {
            $res['msg'] = $lang[CREATE_SOCKET_FAILED] .' :' . socket_strerror($sock);
            return json_encode($res);
        }
        $conn = socket_connect($sock, $ip, $port);
        if($conn < 0){
            socket_close($sock);
            $res['msg'] = $lang[CREATE_CONN_FAILED] . ' :'. socket_strerror($conn);
            return json_encode($res);
        }

        $sendpack = pack("SSIa16IIa*", 1, 0, time(), $_COOKIE['rogmgr_user'], 0, strlen($gmcmd), $gmcmd);

        if(!socket_write($sock, $sendpack, strlen($sendpack))) {
            $res['msg'] = $lang[SEND_DATA_FAILED] . ' :'. socket_strerror($conn);
            return json_encode($res);
        }

        $resHeader = socket_read($sock, 32, PHP_BINARY_READ);
        $arrHeader = unpack("Sid/Sversion/Ilogid/a16provider/Ireserved/Ibdlen", $resHeader);
        $respack = socket_read($sock, $arrHeader["bdlen"],PHP_BINARY_READ);
        
        return $respack;
    }
}