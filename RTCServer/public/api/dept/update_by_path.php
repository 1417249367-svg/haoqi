<?php
//http://127.0.0.1:98/api/dept/update_by_path.html?path=策划部/研究中心&TypeName=研发中心&ItemIndex=601&Description=研发中心描述&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/department.php");
$printer = new Printer();
$rtcuser = new RTCDepartment ();
$result=$rtcuser ->deptUpdate(gi("path"),gi("TypeName"),gi("ItemIndex",1000),gi("Description"),gi("token"));
$printer->out_str ($result);
?>