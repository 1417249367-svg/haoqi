<?php

class syscmd    
{    
	//得到MAC地址
	function get_mac()
	{
		$data = $this -> exec_cmd("ipconfig","/all");
		$temp_array = array();    
		$result = "" ;

		foreach ($data as $value )    
		{    
			if ( preg_match( "/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i", $value, $temp_array ) )    
			{    
				$result = $temp_array[0];    
				break;    
			}    
		}    
		unset($temp_array);  
		return $result;
	}

 	//执行cmd命令
	function exec_cmd($cmd,$param = "")    
	{    
		$data = "" ;
		switch ( strtolower(PHP_OS) )    
		{     
			default:    
			$data = $this->forWindows($cmd,$param);    
			break;    
		}    
		return $data ;
	}    


	//windows的执行方式
	function forWindows($cmd,$param)    
	{    
		@exec($cmd . " " . $param , $this->return_array);    
		if ( $this->return_array )    
				return $this->return_array;    
		else
		{    
			$ipconfig = $_SERVER["WINDIR"]."\\system32\\" . $cmd . ".exe";    
			if ( is_file($ipconfig) )    
				@exec($ipconfig." /all", $this->return_array);    
			else   
				@exec($_SERVER["WINDIR"]."\\system\\" . $cmd . ".exe " . $param, $this->return_array);    
			return $this->return_array;    
		}    

	}    

}   

?>