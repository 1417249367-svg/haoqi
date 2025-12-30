<?php

/**
 * 消息同步推送系统

 * @date    20150519
 */
 
 
require_once("sync_push.php");


$msgId = g("data");
$msgType = g("datatype");
$newCount 	= g("newcount");
$receiver	= g("receiver") ;

//消息发送推送
msg_offline_push($msgId,$receiver,$newCount,$msgType);
 


 
?>
