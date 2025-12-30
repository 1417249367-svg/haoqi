<?php
/**
 * 操作系统装配
 * @author  jincun
 * @date    201508
 */
$os = getOS();

 
//antconfig 的类
require_once (__ROOT__ . "/class/os/" . $os . "_antconfig.class.php");

//组件调用等相关函数
require_once (__ROOT__ . "/class/os/" . $os . "_fun.php");

//取mac地址类
require_once (__ROOT__ . "/class/os/mac_address.class.php");


//if ($os == "windows")
//{
//	require_once (__ROOT__ . "/class/os/regedit.class.php");
//}
/*
method	得到操作系统
*/
function getOS()
{
	return strtoupper(substr(PHP_OS,0,3))==='WIN'?'windows':'linux';
}





/*
method	得到MAC地址
*/
function getMacAddr()
{
	$mac = new GetMacAddr(PHP_OS);  
	return $mac->mac_addr;
}



/*
method 得到AntServer文件存放的地址
		Linux版本分消息服务地址与文件服务地址
2015-08-31.1 jc
*/
function getAntFileDir()
{
	global $os ;
	$dir = BIGANT_DATADIR . "/uploadfile/"  ;
	
	//is linux
	if ($os != "windows")
		$dir = str_replace("im_msgserver","im_fileserver",BIGANT_DATADIR) ;

	return $dir ;
}


?>