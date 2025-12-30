<?php  
require_once("../../class/fun.php");
	
//加载基础语言
addLangModel("admin");

$url = $_SERVER ["REQUEST_URI"];
// 登记参数
$data = $url;
foreach ( $_POST as $name => $value ) {
	$data .= "&" . $name . "=" . $value;
}
recordLog ( $data );

// 自动登录
$uri_loginname = g ( "loginname" );
$uri_password = g ( "password" );
$uri_ismanager = g ( "ismanager",0 );

if (($uri_loginname != "") && ($uri_password != "")) {
	if ($uri_loginname != CurUser::getLoginName ()) {
		$uri_loginname = js_unescape ( $uri_loginname ); // 中文解码
		$passport = new Passport ();
		$result = $passport->login ( $uri_loginname, $uri_password, $uri_ismanager,0,1); // 密码为加密过的

		if ($result ["status"] == 0) {
			print ('{"status":0,"errnum":' . $result ["errnum"] . '}') ;
			die ();
		}
	}
}
ob_clean();
?>