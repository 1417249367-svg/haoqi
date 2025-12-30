<?php
/**
 * 组件装配
 * @author  zwz
 * @date    20150403
 */
$_GET = array_change_key_case($_GET, CASE_LOWER);

require_once("../class/fun.php");
require_once(__ROOT__ . "/class/hs/Passport.class.php") ;
require_once(__ROOT__ . "/config/meeting.inc.php") ;

//插件中加入验证

$userId = g("userid",0);
$currUserId = CurUser::getUserId() ;


if ($currUserId != $userId)
{
	
	$m = new Model("hs_user");
	$m->addParamWhere("col_id",$userId,"=","int");
	$loginName = $m->getValue("col_loginname");
	$password = g("password");
	
	$passport = new Passport();
	$result = $passport -> login($loginName,$password,0) ;

	if ($result["status"] == "0")
	{
		print("登录错误");
		die();
	}
}

?>