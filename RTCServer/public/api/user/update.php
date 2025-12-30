<?php
//http://127.0.0.1:98/api/user/update.html?UppeID=000001,000003&FcName=李四&UserPaws=1234&UserName=lisi&Tel1=13888888877&Tel2=02088888877&remark=暂无&jod=工程师&Constellation=5153@163.com&UserIco=2&Sequence=909&IsManager=0&UserState=1&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/user.php");
$printer = new Printer();
$rtcuser = new RTCUser ();
$result=$rtcuser ->userUpdate(gi("UserName"),gi("FcName"),gi("UserPaws"),gi("Sequence"),gi("Constellation"),gi("Tel1"),gi("Tel2"),gi("UserIco"),gi("Jod"),gi("remark"),gi("UppeID"),gi("IsManager"),gi("UserState"),gi("token"));
$printer->out_str ($result);
?>