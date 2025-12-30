<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once("inc/fh_login.php");?>
<?php

$op = g ( "op" );
switch ($op) {
	case "verify" :
		verify ();
		break;
}
function verify() {
	$printer = new Printer ( "xml" );
	
	$loginName = g ( "loginname" );
	$password = g ( "password" );
	$enType = strtolower ( g ( "entype", "aten" ) );
	
	$result = verifyAccount ( $loginName, $password, $enType );
	
	$printer->out_array2 ( $result );
}
function encryptPassword($loginName, $password, $enType) {
	switch ($enType) {
		case 0 :
			return $password;
		case 1 :
			return md5 ( $password );
		case 2 :
			return md5 ( $loginName . $password );
	}
}
function getEnType($enType) {
	switch ($enType) {
		case "non" :
			return 0;
		case "md5" :
			return 1;
		case "md5ex" :
			return 2;
	}
}
?>