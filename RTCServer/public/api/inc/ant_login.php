<?php
/**
*@author zwz
*@date 2014-12-8 下午5:27:30
*@version : v1.0
*/

// 通用
function verifyAccount($loginName, $password, $enType) {
	$result ['status'] = 0;
	$user = new User ();
	$user->field = "col_pword,col_entype";
	$user->addParamWhere ( "col_loginname", $loginName );
	$arrUserInfo = $user->getDetail ();
	$arrUserInfo = row_fliter_doublecolumn ( $arrUserInfo, 1 );
	
	$dbEnType = $arrUserInfo ['col_entype'];
	$dbPassword = $arrUserInfo ['col_pword'];
	
	if (count ( $arrUserInfo ) > 0) {
		if ($enType == "aten") {
			$password = DBPwdDecrypt ( $password );
			$enType = "non";
			$password = encryptPassword ( $loginName, $password, $dbEnType );
		} else if ($enType == "non") {
			$password = encryptPassword ( $loginName, $password, $dbEnType );
		}
		
		if ($dbEnType == 0) {
			$dbPassword = encryptPassword ( $loginName, $dbPassword, getEnType ( $enType ) );
		}
		
		if ($dbPassword == $password) {
			$result ['status'] = 1;
			$result ['msg'] = "帐号验证成功";
		} else {
			$result ['msg'] = "密码错误";
		}
	} else {
		$result ['msg'] = "帐号不存在";
	}
	return $result;
}