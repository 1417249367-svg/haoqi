<?php 
require_once(__ROOT__ . "/class/common/Site.inc.php");


/*------------------------------------------- 
文本操作
---------------------------------------------*/ 
class TXTHelper 
{ 
	public $sp = "\t" ;
	
	function __construct() 
	{ 
	
	} 


	function array2file($data,$file = "")
	{
		if ($file == "")
			$file = getAutoId() ;
		$file = "../Data/export/". $file .".txt" ;
		
		if (file_exists($file))
			unlink($file) ;
	
		$content = "" ;
		foreach($data as $row)
		{
			
			if (is_array($row))
			{
				$line = "" ;
				foreach($row as $key=>$value)
				{
					if ($line)
						$line .= $this->sp ;
					
					//2014-11-26 jc
					if (! $value)
						$value = " " ;
						
					$line .= $value ;
				}
					
			}
			else
			{
				$line = $row ;
			}
			$content .= $line . "\r\n" ;
		}
		writeFileContent($file,$content);
		return $file ;

	}
	
	function file2array($file)
	{
		$content = readFileContent($file) ;

		$data = array();
		$lines = explode("\r\n",$content);

		
		foreach($lines as $line)
		{
			if ($line == "")
				continue;
			$item = explode($this->sp,$line);
			if (count($item) > 1)
				$data[] = $item ;
			else
				$data[] = $line ;
		}

		return $data ;
	}
	
	//去掉一些不可见元素 var_dump string(4) 1
	function fliter_chr($str)
	{
		$len = strlen($str) ;
		$str_new = "" ;
		for($i=0;$i<$len;$i++)
		{
			$chr = substr($str,$i,1) ;
			$ascii = ord($chr) ;
			if (($ascii>126) && (($ascii<200)))
			{
			}
			else
			{
				$str_new .= $chr ;
			}
		}
		 return $str_new ;
	}
		
	
} 

?> 