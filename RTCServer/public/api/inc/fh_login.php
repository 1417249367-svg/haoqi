<?php
/**
*file fh_service.php
*@author zwz
*@date 2014-12-8 下午5:26:48
*@version : v1.0
*/
function verifyAccount($loginName, $password, $enType) {

    $url = FIBERHOME_API . "?method=mapps.userservice.userlogininfo&v=2.0&format=json";

	if ($enType == "aten") {

		$password = DBPwdDecrypt ( $password );
		$password = aes_encrypt ( $password, ENCRYPTION_KEY );
		$password = bin2hex ( $password );
	} else if ($enType == "non") {
		$password = aes_encrypt ( $password, ENCRYPTION_KEY );
		$password = bin2hex ( $password );
	} else {
		$result ['status'] = 0;
		$result ['msg'] = "密码错误";
		return $result;
	}
	$password = strtoupper ( $password );
	$url .= "&username=" . $loginName . RTC_DOMAIN;
	$url .= "&password=" . $password;

	$res = "[" . send_http_request($url) . "]";
	recordLog($url);
	recordLog($res);

	$arr = json_decode ( $res );
	if ($arr [0]->code > 0)
		$arr [0]->message = "登录成功";
	$result ['status'] = $arr [0]->code;
	$result ['msg'] = $arr [0]->message;
	return $result;
}

function aes_encrypt($val, $ky) {
	$key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
	for($a = 0; $a < strlen ( $ky ); $a ++)
		$key [$a % 16] = chr ( ord ( $key [$a % 16] ) ^ ord ( $ky [$a] ) );
	$mode = MCRYPT_MODE_ECB;
	$enc = MCRYPT_RIJNDAEL_128;
	$val = str_pad ( $val, (16 * (floor ( strlen ( $val ) / 16 ) + (strlen ( $val ) % 16 == 0 ? 2 : 1))), chr ( 16 - (strlen ( $val ) % 16) ) );
	return mcrypt_encrypt ( $enc, $key, $val, $mode, mcrypt_create_iv ( mcrypt_get_iv_size ( $enc, $mode ),MCRYPT_RAND ));
}