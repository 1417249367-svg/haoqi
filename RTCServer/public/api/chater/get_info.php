<?php
//http://127.0.0.1:98/api/chater/get_info.html?loginname=lisi&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/chater.php");
$printer = new Printer();
$rtcchater = new RTCChater ();
$result=$rtcchater ->chaterInfo(gi("loginname"),gi("token"));
$printer->out_str ($result);
?>