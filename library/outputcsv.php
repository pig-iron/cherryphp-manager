<?php
namespace library;
class outputcsv
{
    public function __Construct()
    {
        
    }
    
	public static function downCSV($header,$data,$filename,$title = ''){

		$filename .= ".csv";
		header("Content-Type: application/vnd.ms-execl");
		header("Content-Type: application/vnd.ms-excel; charset=gbk");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");

		$outData = '';
		if(!empty($title)){
			$outData .= $title."\n";
		}
		//echo $outData; exit;
		$outDataTmp = implode(",",$header);
		$outData .= $outDataTmp."\n";

		foreach($data as $key => $val){
			$outData .= implode(',',$val)."\n";

		}
		return $outData;
	}
}
