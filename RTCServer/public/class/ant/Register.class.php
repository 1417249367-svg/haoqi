<?php  require_once(__ROOT__ . "/class/common/SysCmd.class.php");?>
<?php
/**
 * 注册管理

 * @date    20141024
 */

class Register
{
	//得到激活文件地址
	function get_activation_filepath()
	{
		$file_path = RTC_CONSOLE ;
		$file_path .= "\\servera.dll" ;
		return $file_path ;
	}

	//得到激活码
	function get_activation_code()
	{
		$file_path = $this -> get_activation_filepath() ;
		return readFileContent($file_path);
	}

	//保存激活码
	// 1 success
	function save_activation_code($activation_code)
	{
		$result = array("status"=>1,"msg"=>"");

		//解析激活码
		$data = $this -> get_reginfo($activation_code);

		//验证激活码
		$result = $this -> check_activation_code($data) ;
		if ($result["status"] == 0)
			return $result ;

		//保存激活码

		if(!file_exists(RTC_CONSOLE))
		{
			$result = array("status"=>0,"msg"=>"配置的服务器路径错误");
			return $result ;
		}

		$file_path = $this -> get_activation_filepath() ;

		$ascom =  new COM("ASCom.AntServerCtrl") ;
		$ascom -> WriteFile($file_path,$activation_code);

		return $result ;
	}

	function check_activation_code($data)
	{
		$result = array("status"=>1,"msg"=>"");

		if ($data["machinecode"] == "")
			return array("status"=>0,"msg"=>"激活码错误");

		if ($data["users"] <= 0)
			return array("status"=>0,"msg"=>"激活码错误");

		//得到mac address
		$mac_addr = $this -> get_mac();

		if ($data["machinecode"] != ($mac_addr))
			return array("status"=>0,"msg"=>"激活码错误[机器码不符]");

		return $result ;
	}



	//得到注册信息
	//$activation_code 激活码
	function get_reginfo($activation_code = "")
	{
		//ASE解密
		$ascom =  new COM("ASCom.AntServerCtrl") ;
		$content = $ascom -> MyDecrypt($activation_code);

		//转换为数组
		$data = str2array($content,"\n",":",1);

		//确保有以下值
		if (! array_key_exists("users",$data))
			$data["users"] = 0 ;

		if (! array_key_exists("machinecode",$data))
			$data["machinecode"] = "" ;

		if (! array_key_exists("expiredate",$data))
			$data["expiredate"] = "" ;


		//组件返回的到期时间多了个 " 0"   "2999/1/1 0"
		$expiredate = $data["expiredate"] ;
		$expiredate = str_replace("/","-",$expiredate) ;
		$pos = strpos($expiredate," ");
		if ($pos)
			$expiredate = substr($expiredate,0,$pos) ;
		$data["expiredate"] = $expiredate ;

		return $data;
	}



	function get_mac()
	{
		$cmd = new SysCmd();
		$mac_addr = $cmd -> get_mac();
		$mac_addr = str_replace("-","",$mac_addr);
		return $mac_addr;
	}
}
?>