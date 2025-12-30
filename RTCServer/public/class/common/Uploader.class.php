<?php
/**
 * 上传文件

 * @date    20140730
 */

class Uploader
{

	//=================================================================
	//上传文件
	//Array ( [status] => 1 [filename] => BAS 4.0.zip [filesize] => 430 [filepath] => /data/temp/1410589758.zip  [factpath]c:\datadata\temp\1410589758.zip)
	//=================================================================
	function upload($file,$autoFileName = 1,$file_path = "",$file_name)
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
//		if ($file["size"] == 0)
//			return $result;

		if ($file_name == "") $file_name = $file["name"] ;

		if ($file_path == "")
			$file_path = date("Ymd",getAutoId()) ;

		if ($file_name == "") $file_saveas = $file["name"] ;
		else $file_saveas = $file_name ;


		if ($autoFileName)
		{
			$file_saveas = create_guid(1) . strrchr($file_saveas, '.');
		}

		$factpath = RTC_CONSOLE . "/" . $file_path;
		mkdirs($factpath);
		$factpath = $factpath . "/" . $file_saveas ;
		move_uploaded_file($file["tmp_name"],$factpath);


		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("/","\\",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		return $result ;
	}
	
	function upload1($file,$autoFileName = 1,$file_path = "")
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
		//文件大小判断
		if ($file["size"] == 0)
			return $result;
	
		
		//文件大小判断
		if ($file["size"] > (UPLOAD_SIZE_LIMIT * 1024 * 1024))
		{
			$result["error"] = str_replace("{FileSize}",UPLOAD_SIZE_LIMIT,get_lang("valid_upload_size_limit"));
			return $result;
		}

		$file_name = $file["name"] ;

		if ($file_path == "")
			$file_path = date("Ymd",getAutoId()) ;

		$file_saveas = $file["name"] ;


		if ($autoFileName)
		{
			$file_saveas = create_guid(0) . strrchr($file_saveas, '.');
		}

		$factpath = RTC_CONSOLE . "/" . $file_path;
		mkdirs($factpath);
		$factpath = $factpath . "/" . $file_saveas ;
		
		//20151202 jc 中文会乱码
		move_uploaded_file($file["tmp_name"],iconv_str($factpath,"utf-8","GBK") );

		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("\\","/",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		

		return $result ;
	}
	
	function upload2($file,$autoFileName,$file_path = "")
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
		//文件大小判断
		if ($file["size"] == 0)
			return $result;
	
		
		//文件大小判断
		if ($file["size"] > (UPLOAD_SIZE_LIMIT * 1024 * 1024))
		{
			$result["error"] = str_replace("{FileSize}",UPLOAD_SIZE_LIMIT,get_lang("valid_upload_size_limit"));
			return $result;
		}

		if($autoFileName) $file_name = $autoFileName ;
		else{
            $fileext = strrchr($file["name"], '.');
			$file_name = str_replace($fileext,"",$file["name"]) . '_' . create_guid(0) . $fileext ;
		}

		if ($file_path == "")
			$file_path = date("Ymd",getAutoId()) ;

		//$file_saveas = $autoFileName ;

		$factpath = RTC_CONSOLE . "/" . $file_path;
		mkdirs($factpath);
		
//		$doc = new Doc();
		$file_saveas = $file_name ;
		$factpath = $factpath . "/" . $file_saveas ;
		

		
		//20151202 jc 中文会乱码
		move_uploaded_file($file["tmp_name"],iconv_str($factpath,"utf-8","GBK") );

		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("\\","/",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		

		return $result ;
	}
	
	function upload3($file,$autoFileName = 1,$file_path = "",$file_name)
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
//		if ($file["size"] == 0)
//			return $result;

		if ($file_name == "") $file_name = $file["name"] ;

		if ($file_path == "")
			$file_path = date("Ymd",getAutoId()) ;

		if ($file_name == "") $file_saveas = $file["name"] ;
		else $file_saveas = $file_name ;


		if ($autoFileName)
		{
			$file_saveas = create_guid(1) . strrchr($file_saveas, '.');
		}

		$factpath =  __ROOT__  . "/" . $file_path;
		mkdirs($factpath);
		$factpath = $factpath . "/" . $file_saveas ;
		move_uploaded_file($file["tmp_name"],$factpath);


		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("/","\\",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		return $result ;
	}
	
	function upload4($file,$autoFileName = 1,$file_path = "",$file_name)
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
//		if ($file["size"] == 0)
//			return $result;

		if ($file_name == "") $file_name = $file["name"] ;

		if ($file_path == "")
			$file_path = date("Ymd",getAutoId()) ;

		if ($file_name == "") $file_saveas = $file["name"] ;
		else $file_saveas = $file_name ;


		if ($autoFileName)
		{
			$file_saveas = create_guid1() . strrchr($file_saveas, '.');
		}

		$factpath = RTC_CONSOLE . "/" . $file_path;
		mkdirs($factpath);
		$file_type = strtolower(substr($file_saveas,strrpos($file_saveas,".")+1)) ;
		$factpath = $factpath . "/" . $file_saveas ;
		
		//file_put_contents("J:/php/RTCServer/Web/Data/20240223/7.log", $file["size"] . PHP_EOL, FILE_APPEND);
		
		if((int)$file["size"]<204800) move_uploaded_file($file["tmp_name"],$factpath);
		else{
			switch($file_type)
			{
				case "png":
					$job = array('scaling'=>['size'=>"750,750"]);  
					$image = new ImageFilter($file["tmp_name"], $job, $factpath); 
					$image->outimage();
					break ;
				case "jpg":case "jpeg":case "gif":
					$t = new ThumbHandler ();
					$t->setSrcImg ( $file["tmp_name"] );
					$t->setCutType ( 1 );
					$t->setDstImg ( $factpath );
					$t->createImg ( 70);
					break ;
				default:
					move_uploaded_file($file["tmp_name"],$factpath);
					break ;
			}
		}

		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("/","\\",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		return $result ;
	}
	
	function upload5($file,$autoFileName = 1,$file_path = "",$file_name)
	{
		$result = array("status"=>0,"filename"=>"","filesize"=>0,"filepath"=> 0) ;
		
		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo($file["name"]);
		if (in_array($fileParts['extension'],$fileTypes)){
			$result["error"] = get_lang("class_doc_warning8");
			return $result;
		}
		if ($file_name == "") $file_name = $file["name"] ;

		if ($file_name == "") $file_saveas = $file["name"] ;
		else $file_saveas = $file_name ;


		if ($autoFileName)
		{
			$file_saveas = create_guid(1) . strrchr($file_saveas, '.');
		}

		$factpath = __ROOT__ . "/";
		mkdirs($factpath);
		$factpath = $factpath . "/" . $file_saveas ;
		move_uploaded_file($file["tmp_name"],$factpath);


		$result["status"] = 1 ;
		$result["filename"] = $file_name ;
		$result["filesize"] = $file["size"] ;
		$result["filepath"] = str_replace("\\","/",($file_path . "/" . $file_saveas)) ;  //虚拟路径
		$result["factpath"] = str_replace("/","\\",$factpath) ;							 //实际路径
		$result["filesaveas"] = $file_saveas;
		return $result ;
	}

}

?>