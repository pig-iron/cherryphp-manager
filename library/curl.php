<?php
namespace library;
class curl
{
    public function __Construct()
    {
        
    }
    
	public static function get($url){
		$ch = curl_init($url) ;  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        return $output = curl_exec($ch); 
	}
    
    public static function post($url,$data){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $return = curl_exec ($ch);
        curl_close ($ch);
        return $return;
	}
}