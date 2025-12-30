<?php
/**
 * 压缩与解压功能

 * @date    20140716
 */

class Ziper
{

    public $zip  ;
	public $folder = "";
	public $zipFile= "";

	function unZip($zip_file,$target_dir = "")
	{
		$result = array("status"=>0,"target"=>"") ;

		if ($target_dir == "")
			$target_dir = substr($zip_file,0,strrpos($zip_file,"."));

		$this -> zip = new ZipArchive() ;
		
		if ($this -> zip -> open($zip_file))
		{
			//创建文件
			$this -> zip -> extractTo($target_dir);
			$this -> zip ->close();
			$result["status"] = 1 ;
			$result["target"] = $target_dir ;

		}
		else
		{
			$result["msg"] = "Could not open archive";
		}
		return $result;
	}

    function  zipFolder($folder, $zipFile)
    {
		if(strtoupper(substr(PHP_OS,0,3)) != "WIN"){
			$folder = iconv('utf-8', 'gbk', $folder);
			$zipFile = iconv('utf-8', 'gbk', $zipFile);
		}
		
		//echo $folder.'<br>';

		$this -> zip = new ZipArchive() ;
		$this -> folder = $folder;
		$this -> zipFile = $zipFile;
		$this -> zip -> open($this -> zipFile, ZIPARCHIVE::CREATE);
		$this -> addZipEntry($this -> folder);

		$this -> zip-> close();
		//exit();
    }

	function addZipEntry($folder)
	{
		if (! is_dir($folder))
			return ;

		$current_dir = opendir($folder);
		

		while(($file = readdir($current_dir)) !== false)
		{
			$sub_dir = $folder . DIRECTORY_SEPARATOR . $file;
			if($file == '.' || $file == '..')
			{
				continue;
			}
			else if(is_dir($sub_dir))
			{
				$this -> addZipEntry($sub_dir);
			}
			else
			{
				$file = $folder . '/' . $file ;
				$abs_file = str_replace($this->folder,"",$file) ;
				$abs_file = substr($abs_file,1);
				//echo $file.'|'.$abs_file.'<br>';
				$this -> zip -> addFile($file,$abs_file);
			}
		}
	}
}
?>



