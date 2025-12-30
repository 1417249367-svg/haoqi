<?php
//http://127.0.0.1:98/api/group/add.html?TypeName=测试群&Remark=测试群公告&UserName=zhoulin&Sender=1&ItemIndex=500&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/group.php");
$printer = new Printer();
$rtcuser = new RTCGroup ();
$result=$rtcuser ->groupAdd(gi("TypeName"),gi("UserName"),gi("Sender",0),gi("ItemIndex",1000),gi("Remark"),gi("token"));
$printer->out_str ($result);
?>