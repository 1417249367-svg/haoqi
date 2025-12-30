<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once("fun.php");
require_once(__ROOT__ . "/class/hs/Passport.class.php");

$op = g ( "op" );
$printer = new Printer();

switch ($op) {
	case "oa" :
		redirect_oa ();
		break;
	case "check_token" :
		check_token ();
		break;
	case "email" :
		break;
}

// 跳转到OA
function redirect_oa() {
	$loginName = g ( "loginname" );
	$loginName = removeDomain ( $loginName );

	$url = "http://" . OA_ADDR . "/oa/";
	if ($loginName != "")
		$url .= "validateToken?type=l&account=" . $loginName . "&token=" . get_token ( $loginName );

	header ( "Location:" . $url );
}

// 从OA获取token
function get_token($loginName) {
	$url = "http://" . OA_ADDR . "/oa/validateToken?type=g&account=" . $loginName;
	$token = file_get_contents ( $url );
	return $token;
}

function check_token() {
	Global $printer;
	$UserName = g ( "UserName" );
	$user = new Model ( "Users_ID" );
	$user->addParamWhere ( "UserName", $UserName );
	$row = $user->getDetail ();
	if (count($row)){
		if(substr(md5($row ["username"].trim($row ["userpaws"])),8,16)==g ( "Token" )){
			if($row ["userstate"]==0) $printer -> out_str(g ( "callback" )."({msg:3})") ;
			else{
				  if($row ["usericoline"]==0) $printer -> out_str(g ( "callback" )."({msg:2})") ;
				  else $printer -> out_str(g ( "callback" )."({msg:1})") ;
			}
		}else  $printer -> out_str(g ( "callback" )."({msg:4})") ;
	}else  $printer -> out_str(g ( "callback" )."({msg:5})") ;
}
