<?php

//window系统有32,64位 注册表路径应设置为统一的路径
define("REG_PATH_APP","HKEY_LOCAL_MACHINE\\SOFTWARE\\BigAntSoft\\") ;
define("REG_PATH_SERVER","HKEY_LOCAL_MACHINE\\SOFTWARE\\BigAntSoft\\AntServer\\") ;

/**
 * windows 函数
 * @author  jincun
 * @date    20150511
 */
 
 

function get_default_consoledir()
{
	return getRegValue(REG_PATH_SERVER,"ConsoleDir") ;
}

function get_default_datadir()
{
	return getRegValue(REG_PATH_SERVER,"DataDir") ;
}


/*
mothed:得到所有服务的状态
param:$arr_service 
return:<ServiceStatus><Strvice name="AntServer" status="2"></Strvice></ServiceStatus>
*/
function ascom_service_status($my_services)
{
	if ($my_services == "")
		return ;
	$arr_service = explode(",",$my_services);
	$ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
	foreach($arr_service as $my_service)
	{
		if ($my_service)
			$ascom -> AddService(format_service_name($my_service));
	}

	$xml = $ascom -> GetAllStatus();

	return $xml;
}

/*
mothed:停止服务
param:$arr_service 
*/
function ascom_service_stop($my_services)
{
	if ($my_services == "")
		return ;
	$arr_service = explode(",",$my_services);
	$ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
	foreach($arr_service as $my_service)
	{
		if ($my_service)
			$ascom -> Stop(format_service_name($my_service));
	}

}

/*
mothed:启动服务
param:$arr_service 
*/
function ascom_service_start($my_services)
{
	if ($my_services == "")
		return ;
	$arr_service = explode(",",$my_services);
	
	$ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
	foreach($arr_service as $my_service)
	{
		if ($my_service)
			$ascom -> Start(format_service_name($my_service));
	}

}

/*
mothed:启动服务
param:$arr_service 
*/
function ascom_service_restart($my_services)
{
	ascom_service_stop($my_services);
	sleep(0.1);
	ascom_service_start($my_services);

}

/*
mothed:实际的名称与显示的名称可能不一样，需要转换一下
*/
function format_service_name($service_name)
{
	if (strtolower($service_name) == "antavserver")
		return "AvServer" ;
	if (strtolower($service_name) == "antfileserver")
		return "FileServer" ;
	return $service_name ;
}

/*
mothed:序列号管理写入
param:$file_path 文件路径+名称
param:$activation_code 激活码
*/
function ascom_license_write($file_path,$activation_code)
{
	$ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
	$ascom -> WriteFile($file_path,$activation_code);
}

/*
mothed:序列号解密
param:$file_path 文件路径+名称
param:$activation_code 激活码
return:解密的内容
*/
function ascom_license_decrypt($activation_code)
{
    $ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
    $content = $ascom -> MyDecrypt($activation_code);
	return $content ;
}



/*
mothed:解密
param:$content 加密内容
param:$key 
return:解密的内容
*/
function ascom_decryp($content,$key = "2B9i7g1A14n20t")
{
    $ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
    $content = $ascom -> DBPwdDecrypt($content,$key);
	return $content ;
}

/*
mothed:加密
param:$content 加密内容
param:$key 
return:加密的内容
*/
function ascom_encrypt($content,$key = "2B9i7g1A14n20t")
{
    $ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
    $content = $ascom -> DBPwdEncrypt($content,$key);
	return $content ;
}


/*
mothed:互联加密
param:$content 加密内容
param:$key 
return:解密的内容
*/
function ascom_encrypt_hl($content)
{
    $ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
    $content = $ascom -> MyMD5($content);
	return $content ;
}
 
 
/*
mothed:RTF格式转换
param:$rtf 内容
return:html内容
*/
//function rtf2html($rtf)
//{
//    $ascom =  new COM("ASCom.AntServerCtrl") or die("WScript.Shell Error") ;
//    $content = $ascom -> RTF2HTML($rtf);
//	$content = iconv_str($content) ;
//	return $content ;
//}

/*
mothed	发送消息
param	$msgModel 消息对象 
param	$sendUserName
param	$sendLoginName
param	$sendPassword
param	$passwordType 0明文 1密文
return  int
*/
function antcom_sendmsg($msgModel,
						$sendUserName,$sendLoginName,$sendPassword, $passwordType = 0,
						$antServerIP  = "",$antServerPort = "" )
{
	//声明对象
	$antMsg = new COM ("AntCom.AntMsg" );
	$antSession = new COM ("AntCom.AntSyncSession");
	$antLogin = new COM ("AntCom.AntLoginInfo" );
	
	if ($antServerIP == "")
	{
		// 注意 JC 20150814 BIGANT_SERVER 函数，在 config 中的值为 127.0.0.1时，会取URL中的地址，这样代理的情况下有问题
		//$antServerIP = BIGANT_SERVER ;
		$antServerIP = BIGANT_SERVER_FACT ;
		
	}
	if($antServerPort == "")
	{
	    $antServerPort = getAppValue("AntServer_Port","6660");
	}
		

	//设置消息
	$antMsg-> Subject = $msgModel -> subject;
	$antMsg-> MsgType = $msgModel -> msgType;
	$antMsg-> MsgFlag = $msgModel -> msgFlag;
	$antMsg-> TalkID = $msgModel -> talkId;
	$antMsg-> SetProp("extdata",$msgModel -> extData);
	$antMsg-> ContentType =  $msgModel -> contentType;
	$antMsg-> Content =  $msgModel -> content;
	$antMsg-> AddReceiver ($msgModel -> recvLoginNames,$msgModel -> recvUserNames);
	if ($msgModel -> attachment != "")
		$antMsg->AddAttach($msgModel -> attachment, "");
	
	//设置登录
	$antLogin->Server = $antServerIP;
	$antLogin->ServerPort = $antServerPort;
	$antLogin->LoginName = $sendLoginName;
	$antLogin->UserName = $sendUserName;
	$antLogin->PasswordType = $passwordType;
	$antLogin->Password = $sendPassword;

	//发送消息
	$antSession->Login ( $antLogin );
	$result = $antSession->SendMsg ($antMsg, 0 );

	recordLog("Server:" . $antServerIP . ":" . $antServerPort,3);
	recordLog("SendAccount:" . $sendLoginName,3);
	recordLog("SendPassword:" . $sendPassword,3);
	recordLog("RecvAccount:" . $msgModel -> recvLoginNames,3  );
	recordLog("RecvUserName:" . $msgModel -> recvUserNames ,3 );
	recordLog("TalkID:" . $msgModel -> talkId ,3);
	recordLog("Content:" . $msgModel-> content,3);
	recordLog("ContentType:" . $msgModel-> ContentType,3);
	recordLog("MsgType:" . $msgModel -> msgType,3 );
	recordLog("MsgFLAG:" . $msgModel-> msgFlag,3);
	
	switch ($result){
		case 1:
			return MSG_OP_SUCCESS;
		case 0:
			return MSG_NET_ERROR;
		default:
			return MSG_SEND_ERROR;
	}
}

/**
 * 发送邀请加好友的请求
 * @param unknown $send_login_name
 * @param unknown $send_name
 * @param unknown $entype
 * @param unknown $password
 * @param unknown $friend_loginname
 * @param unknown $msg
 * @param unknown $friend_viewid
 * @param unknown $friend_groupid
 */
function antcom_invite_user(
		$send_login_name,$send_name,$entype,$password,
		$friend_loginname,
		$friend_viewid,$friend_groupid,$msg)
{

}

/**
 *
 * @param unknown $cmdName
 * @param unknown $param array("0")
 * @param unknown $attr array("loginname"=>"jc")
 * @param unknown $body
 */
function antcom_send_cmd($cmdName,$param,$attr,$body = "")
{
	
}

 
//判断环境 ascom
function install_ascom()
{
	if (install_com() == 0)
		return false ;
		
	$result = new COM("ASCom.AntServerCtrl") ;
	return $result ;
}

//判断环境 antcom
function install_antcom()
{
	if (install_com() == 0)
		return false ;

	$result = new COM("AntCom.AntMsg") ;
	return $result ;
}

function install_com()
{
	$result = get_extension_funcs('com_dotnet');
	return $result == false?0:1 ;
}


/*
method	安装文档服务
*/
function install_docserver()
{
	//不能这种写法，因为 install_docserver 在安装时调用，安装时sysconfig刚写入，BIGANT_CONSOLE 取不到值
	//$console_dir = BIGANT_CONSOLE ;
	
	//从数据库直接取
	$config = new SysConfig();
	$console_dir = $config -> get("ConsoleDir") ;
	recordLog("ConsoleDir:" . $console_dir);
	
	//创建相关目录
    $dir_default = $console_dir . "/DocData/Default" ;
    $dir_public  = $console_dir . "/DocData/Public" ;
    mkdirs($dir_default);
    mkdirs($dir_public);
	
	//初始化文档管理相关数据
    $sqls[] = "INSERT INTO tab_config(col_genre,col_name,col_data) VALUES('AntDocConfig','AntDocDefaultDataPath','" . $dir_default . "')" ;
    $sqls[] = "INSERT INTO tab_config(col_genre,col_name,col_data) VALUES('AntAuthenConfig','Target','')" ;
    $sqls[] = "INSERT INTO tab_config(col_genre,col_name,col_data) VALUES('AntAuthenConfig','Type','0')" ;
    $sqls[] = "INSERT INTO tab_doc_root(col_name,col_datapath,col_type) VALUES('" . get_lang("doc_manager_public") . "','" . $dir_public . "',1)" ;
    $sqls[] = "INSERT INTO tab_bioace(col_hsitemid,col_hsitemtype,col_classid,col_objid,col_funname,col_power,col_hsitemname) values(1,3,102,1,'DocAce',499,'everyone')" ; 
	$db = new DB ();
	$db->execute ( $sqls );
}

/*
mothed	格式化文件路径 小写,  /
*/
function format_filepath($path)
{
	$path = str_replace("\\","/",$path);
	return $path ;
}



/*
method:根据bigant的数据库类型 转换成系统的数据库类型
#define ATDB_DBTYPE_ACCESS		(0)
#define ATDB_DBTYPE_SQLSERVER	(1)
#define ATDB_DBTYPE_ACCESS2		(2)
#define ATDB_DBTYPE_ORACLE		(3)
#define ATDB_DBTYPE_SOADB		(4)	// 使用 SOAClient 访问 SOA 数据库
#define ATDB_DBTYPE_UDLFILE		(5)
#define ATDB_DBTYPE_MYSQL		(6)
*/
$arr_dbtype = array("access"=>0,"mssql"=>1,"oracle"=>3,"mysql"=>6,"mariadb"=>7);

/*
method	得到名称数据库类型代号
param	$dbTypeName:数据库类型名称
*/
function  getDBTypeCode($dbTypeName)
{
	global $arr_dbtype ;
	$dbTypeName = strtolower($dbTypeName) ;
	foreach($arr_dbtype as $key=>$value)
	{
		if ($key == $dbTypeName)
			return $value ;
	}
	return 7 ;
}

/*
method	得到名称数据库类型名称
param	$dbTypeCode:数据库类型代号
*/
function getDBTypeName($dbTypeCode)
{
	global $arr_dbtype ;
	foreach($arr_dbtype as $key=>$value)
	{
		if ($value == $dbTypeCode)
			return $key ;
	}
	return "mariadb" ;
}

function getRegValue($regPath,$key,$defaultValue = "")
{
	$regedit = new Regedit();

	//得到注册表值
	$value = $regedit -> get($regPath . "\\" . $key) ;
	
	if ($value == "")
		$value = $defaultValue ;
	return $value ;
	
}
/**
 * 获取注册表的值
 * @return Ambigous <string, string>
 */
function readRegDN(){
    return getRegValue(REG_PATH_SERVER,"DomainName");
} 

?>