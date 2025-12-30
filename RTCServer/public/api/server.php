<?php
/**
 * service.php
 * @author  jc
 * @date    2015-06-26
 */
require_once('fun.php');
class AntServer {

	private $user;

	function AntServer() {

	}

 
	/*
	method	判断用户是否在线
	param	$loginNames 多个帐号以逗号分隔,不用含域名
	*/
	function getUserOnlineStatus($loginNames, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$loginNames = mb_convert_encoding(userAppendDomain( $loginNames,","),"gb2312","utf-8");
		$url = "http://" . RTC_SERVER . ":" . RTC_PORT . "/syscmd?cmdname=GetJsUserState&LoginNames=" . $loginNames ;
		$result = send_http_request($url) ;
		
		recordLog("getUserOnlineStatus:" . $url) ;
		
		//判断是否获取到正确的内容
		$isSuccess = strpos("var UserList=",$result) == 0?1:0 ;
		
		$msg = "" ;
		if ($isSuccess)
		{
			$result = str_replace("var UserList=","",$result);
			$data = json_decode($result,true);
			foreach($data as $item)
				$msg .= ($msg == ""?"":",") . $item["Online"] ;
		}
		
	
		return Response::result ($isSuccess,$msg);
	}
}


$serviceName="AntServer";
require_once ("service.inc.php");