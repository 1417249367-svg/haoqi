<?php
//http://127.0.0.1:98/api/group/get_info.html?TypeID=Clot000028&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/group.php");
$printer = new Printer();
$rtcuser = new RTCGroup ();
$result=$rtcuser ->groupInfo(gi("TypeID"),gi("token"));
$printer->out_str ($result);
?>