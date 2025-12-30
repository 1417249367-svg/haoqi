<?php
//http://127.0.0.1:98/api/message/send_group.html?sendUserName=lisi&recver=Clot000003&content=内容&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/message.php");
$printer = new Printer();
$rtcuser = new RTCMessage ();
$result=$rtcuser ->sendMessageByGroup(gi("sendUserName"),gi("recver"),gi("content"),gi("token"));
$printer->out_str ($result);
?>