<?php

/*
 * linux 函数
 * JC 2015-5-15
 */

/**
 * 得到应用的路径
 * @return string
 */
function  get_app_dir(){
	
	return dirname(dirname(__ROOT__)) ;
}

/**
 * 默认的路径
 * @return string
 */
function get_default_consoledir()
{
	return get_app_dir() . "/im_common" ;
}

/**
 * 默认的路径
 * @return string
 */
function get_default_datadir()
{
	return get_app_dir() . "/im_msgserver/data" ;
}


/**
 * 得到所有服务的状态
 * @param unknown $my_services 逗号分隔 
 * @return void|string <ServiceStatus><Strvice name="AntServer" status="2"></Strvice></ServiceStatus>
 */
function ascom_service_status($my_services)
{
	if ($my_services == "")
		return ;
	$arr_service = explode(",",$my_services);
	$xml = "" ;
	foreach($arr_service as $my_service)
	{
		//status -1不存在， 0停止， 1运行
		$status= antcom_interface_1("get_status", format_service_name($my_service));
		$xml .= "<Strvice name=\"" . $my_service. "\" status=\"" . $status . "\"></Strvice>" ;
	}

	$xml = "<ServiceStatus>" . $xml . "</ServiceStatus>" ;

	return $xml;

}


/**
 * 停止服务
 * @param unknown $my_services 逗号分隔 
 */
function ascom_service_stop($my_services)
{
	ascom_serivce_cmd("stop",$my_services);
}


/**
 * 重启服务
 * @param unknown $my_services
 */
function ascom_service_start($my_services)
{
	ascom_serivce_cmd("start",$my_services);
}


/*

/**
 * 重启服务
 * @param unknown $my_services
 */
function ascom_service_restart($my_services)
{
	ascom_serivce_cmd("restart",$my_services);
}


/**
 * 操作服务器 stop/start,restart
 * @param unknown $cmd
 * @param unknown $my_services 逗号分隔 
 * @return void|unknown
 */
function ascom_serivce_cmd($cmd,$my_services)
{
	if ($my_services == "")
		return ;
	$arr_service = explode(",",$my_services);
	foreach($arr_service as $my_service)
	{
		//result 0成功，NULL失败
		$result = antcom_interface_1($cmd, format_service_name($my_service));
	}
	return $result ;
}
 

/**
 * 实际的名称与显示的名称可能不一样，需要转换一下
 * @param unknown $service_name
 * @return string|unknown
 */
function format_service_name($service_name)
{
	if (strtolower($service_name) == "avserver")
		return "AntAvServer" ;
	if (strtolower($service_name) == "fileserver")
		return "AntFileServer" ;
	return $service_name ;
}


/**
 * 序列号管理写入
 * @param unknown $file_path 文件路径+名称
 * @param unknown $activation_code
 */
function ascom_license_write($file_path,$activation_code)
{
	$result = antcom_interface_2("write_file", $file_path, $activation_code);
}


/**
 * 序列号解密
 * @param  $activation_code 文件路径+名称
 * @return unknown 
 */
function ascom_license_decrypt($activation_code)
{
	$content = antcom_interface_1("decrypt_sn", $activation_code);
	return $content ;
}



/**
 * 解密
 * @param unknown $content 加密内容
 * @param string $key
 * @return 解密的内容
 */
function ascom_decryp($content,$key = "2B9i7g1A14n20t")
{
   	$content = antcom_interface_2("decrypt_dbpw", $content,$key);
	return $content ;
}


/**
 * 加密
 * @param  $content 加密内容
 * @param string $key 
 * @return 加密的内容
 */
function ascom_encrypt($content,$key = "2B9i7g1A14n20t")
{
    $content = antcom_interface_2("encrypt_dbpw", $content,$key);
	return $content ;
}



/**
 * 互联加密
 * @param  $content 加密内容
 * @return 解密的内容 
 */
function ascom_encrypt_hl($content)
{
    $content = antcom_interface_1("encrypt_md5", $content);
	return $content ;
}
 




/**
 * RTF格式转换
 * @param  $rtf 内容
 * @return  html内容
 */
//function rtf2html($rtf)
//{
//    $content = antcom_interface_1("rtf2text", $rtf);
//	return $content ;
//}

/*
mothed	发送消息
param	$msgModel 消息对象 
param	$sendUserName
param	$sendLoginName
param	$sendPassword
param	$passwordType 0明文 1密文
---------------------------------------------------
int antcom_interface_send_msg(
const std::string& server_ip,
const std::string& server_port,
const std::string& send_login_name,
const std::string& send_user_name,
const std::string& pwd_type,
const std::string& password,
const std::string& recv_login_names,
const std::string& recv_user_names,
const std::string& content_type,
const std::string& subject,
const std::string& content,
const std::string& attachement,
const std::string& msg_type,
const std::string& msg_flag,
const std::string& talk_id,
const std::string& extdata,
const std::string& token
 )
*/
function antcom_sendmsg($msgModel,
						$sendUserName,$sendLoginName,$sendPassword, $passwordType = 0,
						$antServerIP  = "",$antServerPort = 6660 )
{
	
	if ($antServerIP == "")
	{
		// 注意 JC 20150814 BIGANT_SERVER 函数，在 config 中的值为 127.0.0.1时，会取URL中的地址，这样代理的情况下有问题
		//$antServerIP = BIGANT_SERVER ;
		$antServerIP = BIGANT_SERVER_FACT ;
		
	}
	
	if($antServerPort == "")
	{  
	    //注意LM 20151023 修改端口 要去取AntServer_Port
	    $antServerPort = getAppValue("AntServer_Port","6660");
	}

	
	$token = "" ;
	
	//LINUX 改为MD5
	if ($passwordType == 1)
		$passwordType = "MD5" ;
	

	//消息内容要转码 否则linnux下面会出现乱码
	$content = iconv("gbk","utf-8",$msgModel -> content) ;
	$subject = iconv("gbk", "utf-8", $msgModel -> subject);
    $result = antcom_interface_send_msg($antServerIP, $antServerPort,
					$sendLoginName,$sendUserName,$passwordType,$sendPassword,
					$msgModel -> recvLoginNames,$msgModel -> recvUserNames,
					$msgModel -> contentType,$subject,$content,
					$msgModel -> attachment,
					$msgModel -> msgType,$msgModel -> msgFlag,$msgModel -> talkId,
					$msgModel -> extData,$token) ;
    
    recordLog("SERVER:" . $antServerIP . ":" . $antServerPort,3);
    recordLog("SEND ACCOUNT:" . $sendLoginName,3);
    recordLog("SEND PASSWORD:" . $sendPassword,3);
    recordLog("RECVER ACCOUNT:" . $msgModel -> recvLoginNames,3  );
    recordLog("RECVER NAME:" . $msgModel -> recvUserNames ,3 );
    recordLog("TALK ID:" . $msgModel -> talkId ,3);
    recordLog("SEND CONTENT :" . $msgModel-> content,3);
    recordLog("CONTENT Type :" . $msgModel-> contentType,3);
    recordLog("MsgType:" . $msgModel -> msgType,3 );
    recordLog("MsgFLAG:" . $msgModel-> msgFlag,3);
    recordLog("RESULT:" . $result,3);
	
	switch ($result){
		case 0:
			return MSG_OP_SUCCESS;
		case 1:
			return MSG_NET_ERROR;
		default:
			return MSG_SEND_ERROR;
	}

}

/**
 * 发送邀请加好友的请求
 * @param unknown $send_login_name  不带域名
 * @param unknown $send_name
 * @param unknown $entype
 * @param unknown $password
 * @param unknown $friend_loginname 带域名
 * @param unknown $msg
 * @param unknown $friend_viewid
 * @param unknown $friend_groupid
 */
function antcom_invite_user(
		$send_login_name,$send_name,$entype,$password,
		$friend_loginname,
		$friend_viewid,$friend_groupid,$msg)
{
	/*
	 int antcom_interface_invite_user((const std::string& server_ip,
	 		const std::string& server_port,
	 		const std::string& send_login_name,
	 		const std::string& send_name,
	 		const std::string& pwd_type,
	 		const std::string& password,
	 		const std::string& friend_login_name,
	 		const std::string& parent_type,
	 		const std::string& parent_id,
	 		const std::string& view_id,
	 		const std::string& desc
	 );
	 		*/
	antcom_interface_invite_user(BIGANT_SERVER_FACT,BIGANT_PORT,
		$send_login_name,$send_name,$entype,$password,
		$friend_loginname,
		2,$friend_groupid,$friend_viewid,$msg
	);
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
	antcom_interface_send_cmd(BIGANT_SERVER_FACT,BIGANT_PORT,$cmdName, $param, $attr , $body);
}


/**
 * 判断环境 ascom
 * @return boolean
 */
function install_ascom()
{
	return  function_exists('antcom_interface_send_msg') ;
}



/**
 * 判断环境 antcom
 * @return boolean
 */
function install_antcom()
{
	return  function_exists('antcom_interface_send_msg') ;
}


/**
 * 安装文档服务
 */
function install_docserver()
{

}


/**
 * 格式化文件路径 小写,  /
 * @param unknown $path
 * @return mixed
 */
function format_filepath($path)
{
	$path = strtolower($path);
	$path = str_replace("\\","/",$path);
	return $path ;
}



/**
 * 得到名称数据库类型代号
 * @param unknown $dbTypeName 数据库类型名称 linux antserver两者一致,windows同用数字
 * @return $dbTypeName
 */
function  getDBTypeCode($dbTypeName)
{
	return $dbTypeName ;
}


/**
 * 得到名称数据库类型名称
 * @param  $dbTypeCode 数据库类型代号 linux antserver两者一致,windows同用数字
 * @return $dbTypeName
 */
function getDBTypeName($dbTypeCode)
{
	return $dbTypeCode ;
}



/**
 * 得到注册表的值
 * @param unknown $path
 * @return unknown
 */
function getRegeditValue($path)
{
	return $path;
}

function readRegDN(){
    return "";
}

?>
