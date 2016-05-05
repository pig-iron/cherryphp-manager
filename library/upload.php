<?php
namespace library;
class upload
{
    public function __Construct()
    {
        
    }
    
	public static function upload_file($file,$diypath,$filename="",$exts=""){
		if (empty($diypath)){
			$diypath="/".date("Ymd",time())."/";
		}
		if (empty($exts)){
			$ext=substr(strrchr($file["name"], '.'), 1);
		}else{
			$ext=$exts;
		}
			
        if ($file["error"] > 0){
            return false;
        }else{
            
            if (!empty($ext)){
                if (is_dir(APP_PATH.UPLOAD_DIR . $diypath)){
                    if (file_exists(APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext))
                    {
						unlink(APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
						move_uploaded_file($file["tmp_name"], APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
                        return UPLOAD_DIR . $diypath. $filename.".".$ext;
                    }else{
                        move_uploaded_file($file["tmp_name"], APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
                        return UPLOAD_DIR . $diypath. $filename.".".$ext;
                    }
                }else{
                    mkdir(APP_PATH.UPLOAD_DIR . $diypath,0777,true);
                    if (file_exists(APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext))
                    {
                        unlink(APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
						move_uploaded_file($file["tmp_name"], APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
                        return UPLOAD_DIR . $diypath. $filename.".".$ext;
                    }else{
                        move_uploaded_file($file["tmp_name"],APP_PATH.UPLOAD_DIR . $diypath. $filename.".".$ext);
                        return UPLOAD_DIR . $diypath. $filename.".".$ext;
                    }
                }
            }else{
                return false;
            }
        }
        
	}
    
    public static function upload_img_file_base64($params)
    {
        $str = $params['imgdata'];
        $type = $params['type'];

        switch($type){
            case 'image/png':
                $ext='.png';
                break;
            case 'image/jpg';
                $ext='.jpg';
                break;
            case 'image/jpeg':
                $ext='.jpg';
                break;
            case 'image/bmp':
                $ext='.bmp';
                break;
            default:
                $ext='.jpg';
        }
        $imgname=md5(rand(1,10000).time());
		if (!empty($params['dir_path'])){
			$diypath="/".$params['dir_path']."/";
		}else{
			$diypath="/".date('Ymd')."/";
		}
		
        $file_path=APP_PATH.UPLOAD_DIR .$diypath."tmp/".$imgname.$ext;
        if(!file_exists(dirname($file_path))){
            mkdir(dirname($file_path),0777,true);
        }
        $img_content = str_replace('data:'.$type.';base64,','',$str);
        $img_content = base64_decode($img_content);
        $result =file_put_contents($file_path,$img_content);
        return UPLOAD_DIR . $diypath."tmp/".$imgname.$ext;
    }
    
}
