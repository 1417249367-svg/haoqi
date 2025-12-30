<?php
//http://127.0.0.1:98/api/message/send_user_by_path.html?sendUserName=lisi&path=策划部/研究中心&content=内容&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/message.php");
$printer = new Printer();
$rtcuser = new RTCMessage ();
$result=$rtcuser ->sendMessageByPath(gi("sendUserName"),gi("path"),gi("content"),gi("token"));
$printer->out_str ($result);
?>