<?php
//http://127.0.0.1:98/api/chater/delete.html?loginnames=lisi,zhoulin&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/chater.php");
$printer = new Printer();
$rtcchater = new RTCChater ();
$result=$rtcchater ->chaterDelete(gi("loginnames"),gi("token"));
$printer->out_str ($result);
?>