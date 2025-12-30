<?php
//http://127.0.0.1:98/api/user/login.html?UserName=lisi&UserPaws=123&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/user.php");
$printer = new Printer();
$rtcuser = new RTCUser ();
$result=$rtcuser ->userValid(gi("UserName"),gi("UserPaws"),gi("token"));
$printer->out_str ($result);
?>