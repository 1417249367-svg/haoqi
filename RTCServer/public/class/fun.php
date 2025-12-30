<?php
/**
 * 组件装配

 * @date    20140725
 */
$_GET = array_change_key_case($_GET, CASE_LOWER);
date_default_timezone_set('PRC');

define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/config/config.inc.php");
require_once (__ROOT__ . "/class/common/Site.inc.php");
require_once (__ROOT__ . "/class/common/lang.php"); //添加语言管理模块
require_once (__ROOT__ . "/class/common/Printer.class.php");
require_once (__ROOT__ . "/class/common/define.inc.php");
require_once (__ROOT__ . "/class/common/CurUser.class.php");
require_once (__ROOT__ . "/class/common/Application.class.php");
require_once (__ROOT__ . "/class/os/os.php"); 	// os 要在 db 类之前(db类用到os)
require_once (__ROOT__ . "/class/db/DB.class.php");
require_once (__ROOT__ . "/class/db/Model.class.php");
require_once (__ROOT__ . "/class/ant/AntLog.class.php");
require_once (__ROOT__ . "/class/ant/SYSConfig.class.php");
require_once (__ROOT__ . "/class/ant/webconfig.class.php");
require_once (__ROOT__ . "/class/hs/Passport.class.php");
//require_once (__ROOT__ . "/class/hs/EmpRelation.class.php");
//require_once (__ROOT__ . "/class/hs/User.class.php");
//require_once (__ROOT__ . "/class/hs/Role.class.php");
error_reporting(E_ALL^E_NOTICE^E_WARNING);

$app = new Application();


//登记参数
$url = $_SERVER['REQUEST_URI'] ;
$data = $url ;
foreach ($_POST as $name => $value) {
	$data .= "&" . $name . "=" . $value  ;
}
recordLog($data);

//$uri_loginname = g ( "loginname" );
//$uri_password = g ( "password" );
////if (($uri_loginname != "") && ($uri_password != "")) {
//$user = new User ();	
//$data = $user->listRole (CurUser::getUserId());
//foreach($data as $k=>$v){
//	$roleId=$data[$k]['id'];
//}
//$role = new Role ();
//$data = $role->listFunACE ( $roleId );
//foreach($data as $k=>$v){
//	$departmentpermission=$data[$k]['departmentpermission'];
//	$department=$data[$k]['department'];
//}
//setValue("departmentpermission",$departmentpermission);
//setValue("department",$department);
////}
/*
method:得到系统参数
param:$name
param:$defaultValue
*/
function getAppValue($name = "",$defaultValue = "")
{
	global $arrSysConfig ;
	
	$name = strtolower($name);
	$value = "" ;

	if (isset($arrSysConfig[$name]))
		$value = $arrSysConfig[$name] ;

	if ($value == "")
		$value = $defaultValue ;

	return trim($value) ;

}


/*
method:生成Applcation数据
param:$name
param:$defaultValue
*/
//function bulidAppValue()
//{
//	$sql = "select col_name,col_data from tab_config" ;
//	$db = new DB();
//	$data = $db -> executeDataTable($sql) ;
//	
//	global $app ;
//	$arr = array();
//	foreach($data as $row)
//	{
//		$name = strtolower($row["col_name"]) ;
//		$value = $row["col_data"] ;
//		$arr[$name] = $value ;
//	}
//	$app -> setData($arr);
//	return $arr ;
//}

/**
 * 登录根据 ADDIN
 */
function loginByAddin()
{
	
	
	//插件中加入验证
	$userId = g("userid",0);
	$loginName = g("loginname");
	$password = g("password");
	//echo $loginName ."|".CurUser::getLoginName() ;
	//exit();
    //如果传的LOGINNAME与当前的LOGINNAME相同，不做登录
	if ($loginName)
	{
		// by loginname
		//$loginName = removeDomain($loginName);
		//echo $currLoginName ."|".CurUser::getLoginName() ;
		$currLoginName = CurUser::getLoginName() ;
		if ($currLoginName == $loginName)
			return ;
	}
	//如果传的USERID与当前的USERID相同，不做登录
	if ($userId)
	{
		// by userid
		$currUserId = CurUser::getUserId() ;
		if ($currUserId == $userId)
			return ;
		
		$m = new Model("Users_ID");
		$m->addParamWhere("UserID",$userId,"=","int");
		$loginName = $m->getValue("username");
	}
	
	//如果LOGINNAME有值，则做登录操作
	if ($loginName)
	{
	    $passport = new Passport();
	    
	    //$result = $passport -> login($loginName,$password,1) ;   // loginname:10280
	    
	    //考虑到AD域,这里不做验证 jc 20150806
	    $result = $passport -> setLoginInfo_LoginName($loginName) ;	
	    
	    if ($result["status"] == "0")
	    {
	        print($result["errnum"]);
	        die();
	    }
	}
	
}



?>