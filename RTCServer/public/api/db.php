<?php
/**
*file db.php
*@author zwz
*@date 2014-12-29 下午3:10:39
*@version : v1.0
*/

define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/config/config.inc.php");
require_once (__ROOT__ . "/class/common/Site.inc.php");

	$op = g ( "op", "" );

	switch ($op) {
		case "getdbinfo":
			getDBInfo();
			break;
		default :
			break;
	}


	//会议服务获取数据库配置信息
	function getDBInfo()
	{
		$xml = "<DBInfo DBServer='" . DB_SERVER ."' DBFile='". DB_PATH ."' DBName='" . DB_NAME . "' DBUser='" . DB_USER . "' DBPassword='" . DBPwdEncrypt(DB_PWD) . "' DBType='" . getDBType(DB_TYPE) . "' DBPort='" . DB_PORT . "' DBLoginMode='0'></DBInfo>";
		ob_clean();
		print ($xml);
	}
