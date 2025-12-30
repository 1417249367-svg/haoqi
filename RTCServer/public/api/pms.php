<?php
/**
*file pms.php
*@author zwz
*@date 2015-1-14 上午8:42:01
*@version : v1.0
*/

require_once ("fun.php");
class PMS {

	private $msgSender;

	function PMS() {
		$this->msgSender = new MsgSender();
	}

	// 发送消息
	function sendMessage($sendLoginName, $sendUserName, $sendPassWord,$email,$subject, $content) {
		recordLog($content);
		$db = new  DB();
		$receiver = $db->executeDataValue("select col_loginname as c from hs_user where col_email='" . $email . "'");
		if($receiver != "")
		{
			$this->msgSender->sendMessage($sendLoginName, $sendUserName, 0, $sendPassWord, $receiver, 0, "Text/Html", $subject, $content, "");
			return Response::result ($this->msg->errCode );
		}
	}
}
$serviceName = "PMS";
require_once ('service.inc.php');