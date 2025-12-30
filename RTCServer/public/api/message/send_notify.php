<?php
//http://127.0.0.1:98/api/message/send_notify.html?recvUserNames=zhoulin,lijie&title=标题&content=内容&link=www.haoqiniao.cn?TargetType=1*UserName=(UserName)*UserPaws=(UserPaws)*FcName=(FcName)*Token=(Token)&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/message.php");
$printer = new Printer();
$rtcuser = new RTCMessage ();
$result=$rtcuser ->sendNotify(gi("recvUserNames"),gi("title"),gi("content"),gi("link"),gi("token"));
$printer->out_str ($result);
?>