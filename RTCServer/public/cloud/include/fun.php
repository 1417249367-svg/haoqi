<?php 

require_once("../../class/fun.php");
require_once(__ROOT__ . "/config/cloud.inc.php");
require_once(__ROOT__ . "/class/doc/DocXML.class.php");
require_once(__ROOT__ . "/class/doc/DocDir.class.php");
require_once(__ROOT__ . "/class/doc/DocFile.class.php");
require_once(__ROOT__ . "/class/doc/DocRelation.class.php");
require_once(__ROOT__ . "/class/doc/Doc.class.php");
require_once(__ROOT__ . "/class/doc/DocAce.class.php");
require_once(__ROOT__ . "/class/doc/DocSubscribe.class.php");
require_once (__ROOT__ . "/class/hs/Passport.class.php");

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
	
	// 解析URL并获取其中的各个部分
	$parsedUrl = parse_url($url);
	$queryString = $parsedUrl['query']; //查询字符串部分
	// 将查询字符串转换为关联数组形式
	parse_str($queryString, $paramsArray);
	// 从关联数组中删除指定的参数（这里以"param2"为例）
	unset($paramsArray["loginname"]);
	unset($paramsArray["password"]);
	// 重新构建查询字符串
	$newQueryString = http_build_query($paramsArray);
	// 更新URL中的查询字符串部分
	$updatedUrl = "http://".$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . ($newQueryString ? "?" : "") . $newQueryString;
	
	if ($uri_loginname != CurUser::getLoginName ()) {
		$uri_loginname = js_unescape ( $uri_loginname ); // 中文解码
		$passport = new Passport ();
		$result = $passport->login ( $uri_loginname, $uri_password, $uri_ismanager,0,1); // 密码为加密过的

		if ($result ["status"] == 0) {
			if(strrpos ( $url, "index" )||strrpos ( $url, "onlinefile" )){
			header("Location:../account/login.html?op=logout&gourl=".phpescape($url));
			}else{
			print ('{"status":0,"errnum":' . $result ["errnum"] . '}') ;
			die ();
			}
		}else header("Location:".$updatedUrl);
	}else header("Location:".$updatedUrl);
}

// 权限判断
$islogin_valid = ! (strrpos ( $url, "passport" )||strrpos ( $url, "myid" ));
if ($islogin_valid && (CurUser::getUserId () <= 0)) {
	recordLog (get_lang("fun_error"));
	print ('{"status":0,"errnum":101001,"msg":"'.get_lang("fun_error1").'"}') ;
	die ();
}

//加载基础语言
addLangModel1("cloud");

ob_clean();
?>