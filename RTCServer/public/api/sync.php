<?php
/**
*file sync.php
*@author zwz
*@date 2015年3月4日 11:02:23
*@version : v1.0
*/

require_once ("fun.php");
require_once (__ROOT__ . "/class/ant/AntSync.class.php");
class Sync {

	private $antSync;

	function Sync() {
		$this->antSync = new AntSync();
	}

	//反馈同步结果
	function feedBack($logId, $status, $result, $token) {
	    if (! authenticate ( $token ))
	        return Response::result ( SYS_ERROR_TOKEN );
	    $ip = $_SERVER['REMOTE_ADDR'];

	    $this->antSync->feedBack($logId, $ip, $status,$result);

        return Response::result ( SYNC_OP_SUCCESS );

	}
}
$serviceName = "Sync";
require_once ('service.inc.php');