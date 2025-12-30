<?php
//http://127.0.0.1:98/api/dept/add_by_path.html?path=策划部/研究中心&ItemIndex=599&Description=描述&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );

//require_once (__ROOT__ . "/class/common/Site.inc.php");
//echo gi("path");
//exit();
require_once (__ROOT__ . "/api/department.php");
$printer = new Printer();
$rtcuser = new RTCDepartment ();
$result=$rtcuser ->deptAdd(gi("path"),gi("ItemIndex",1000),gi("Description"),gi("token"));
$printer->out_str ($result);
?>