<?php
//http://127.0.0.1:98/api/user/disable_user.html?UserName=lisi&UserState=0&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/user.php");
$printer = new Printer();
$rtcuser = new RTCUser ();
$result=$rtcuser ->disableUser(gi("UserName"),gi("UserState"),gi("token"));
$printer->out_str ($result);
?>