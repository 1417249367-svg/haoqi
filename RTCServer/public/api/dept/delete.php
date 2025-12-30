<?php
//http://127.0.0.1:98/api/dept/delete.html?path=策划部/研究中心&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/department.php");
$printer = new Printer();
$rtcuser = new RTCDepartment ();
$result=$rtcuser ->deptDelete(gi("path"),gi("token"));
$printer->out_str ($result);
?>