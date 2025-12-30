<?php
/**
 * API页面组件装配

 * @date    20140325
 */
require_once ("../class/fun.php");
require_once (__ROOT__ . "/class/ant/AntSync.class.php");
require_once (__ROOT__ . "/class/hs/EmpRelation.class.php");
require_once (__ROOT__ . "/class/hs/Department.class.php");
require_once(__ROOT__ . "/class/ant/AntLog.class.php");
require_once (__ROOT__ . "/class/hs/Passport.class.php");
require_once (__ROOT__ . "/class/hs/User.class.php");
require_once (__ROOT__ . "/class/hs/Role.class.php");

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

// 权限判断
$islogin_valid = ! (strrpos ( $url, "passport" )||strrpos ( $url, "myid" ));
if ($islogin_valid && (CurUser::getUserId () <= 0)) {
	recordLog (get_lang("fun_error"));
	print ('{"status":0,"errnum":101001,"msg":"'.get_lang("fun_error1").'"}') ;
	die ();
}


if(CurUser::getUserId()){
	$user = new User ();	
	$data = $user->listRole (CurUser::getUserId());
	foreach($data as $k=>$v){
		$roleId=$data[$k]['id'];
	}
	$role = new Role ();
	$data = $role->listFunACE ( $roleId );
	foreach($data as $k=>$v){
		$departmentpermission=$data[$k]['departmentpermission'];
		$department=$data[$k]['department'];
	}
	setValue("departmentpermission",$departmentpermission);
	setValue("department",$department);
}

?>