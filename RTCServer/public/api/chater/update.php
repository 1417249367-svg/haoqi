<?php
//http://127.0.0.1:98/api/chater/update.html?loginname=lisi&username=李四&deptname=客服部&jobtitle=工程师&phone=02088888877&mobile=13888888877&email=5153@163.com&reception=900&welcome=欢迎语&status=1&ord=805&token=23456
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/api/chater.php");
$printer = new Printer();
$rtcchater = new RTCChater ();
$result=$rtcchater ->chaterUpdate(gi("loginname"),gi("username"),gi("deptname"),gi("jobtitle"),gi("phone"),gi("mobile"),gi("email"),gi("reception",1000),gi("welcome"),gi("status",1),gi("ord",1000),gi("token"));
$printer->out_str ($result);
?>