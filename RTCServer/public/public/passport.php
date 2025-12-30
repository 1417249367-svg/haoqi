<?php
require_once("fun.php");
require_once(__ROOT__ . "/class/hs/User.class.php");
//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
//
//}else{
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//}
isPublicNet();
$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "login" :
		login ();
		break;
	case "logout" :
		logout ();
		break;
	case "password_encrypt" :
		password_encrypt ();
		break;
	case "check_admin_password" :
		check_admin_password ();
		break;
}
function password_encrypt() 
{
	$password = g ( "password" );
	$password = md5 ( $password );
	print ($password) ;
}


function login() 
{
	Global $printer;
	
	$loginName = g ( "txt_loginname" );
	$password = g ( "txt_password" );
	$ismanager = g ( "ismanager",0 );
	$isclient = g ( "isclient",0 );
	$isEncrypt = g ( "isencrypt",0 );
	// test db connect
	
	$db = new DB ();
	$status = $db->testConn ();
	if ($status == 0)
		$printer->fail ( "errnum:10000" );

	$passport = new Passport ();
	$result = $passport->login ( $loginName, $password, $ismanager, $isclient,$isEncrypt ); // loginname:10280
	

	if ($result ["status"]) {
		$printer->success ();
	} else {
		$printer->fail ( "errnum:" . $result ["errnum"] );
	}
}


function logout() {
	Global $printer;
	if(g ( "gourl")=="livechat"){
		$doc_file = new Model("Users_ID");
		$doc_file -> addParamField("UserIcoLine", 0);
		$doc_file -> addParamWhere("UserName", g ( "myid"));
		$doc_file -> update();	
	}
	CurUser::setUserId ( 0 );
	CurUser::setUserName ( "" );
	CurUser::setLoginName("");
	CurUser::setPassword("");
	CurUser::setAdmin("");
	$printer->success ();
}

function check_admin_password() {
	Global $printer;
	
	$user = new Model ( "Users_ID" );
	$user->addParamWhere ( "UserName", "admin" );
	$row = $user->getDetail ();

	if (count ( $row ) == 0){
		$adminuser = new User ();
		$file = __ROOT__."/Data/MyPic/1.jpg";
		if (file_exists ( $file )) unlink ( $file );
		$adminuser->deleteAnUser ("'1'");

		$sql = " select min(TypeID) as c from Users_Ro";
		$types =$adminuser -> db -> executeDataValue($sql);
		$sql = " insert into Users_ID(UppeID,UserID,FcName,UserName,Tel1,UserIco,IsManager) values('" . $types . "','1','admin','admin','13888888888',1,1)" ;
		$adminuser -> db -> execute($sql);
		$adminuser -> insertPic(1);
		$adminuser -> insert2("RTC",1);
		$adminuser -> insert3("RTC",1);
		$adminuser -> delete_Role(1);
		$DefaultRole = $adminuser -> getDefaultRole();
		$adminuser -> insertRole(1,$DefaultRole);
		$adminuser -> updateForm("Users_IDVesr");
		
		$printer->success ();
	}
	
	if (trim($row ["userpaws"]) != "")
		$printer->fail ();
	
	$printer->success ();
}

?>