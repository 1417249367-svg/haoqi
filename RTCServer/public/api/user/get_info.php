<?php
//http://127.0.0.1:98/api/user/get_info.html?UserName=lisi&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/user.php");
$printer = new Printer();
$rtcuser = new RTCUser ();
$result=$rtcuser ->userInfo(gi("UserName"),gi("token"));
$printer->out_str ($result);
?>