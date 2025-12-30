<?php
/**
*file sync.php
*@author zwz
*@date 2015年3月4日 11:02:23
*@version : v1.0
*/

require_once ("fun.php");

$sendUserName="wangjin";
$recvUserNames="Clot000019,财务工程群";
$content="内容2";
$msg = new Msg ();
$msg ->sendRTCMessge($sendUserName,$recvUserNames,"", $content,"",1);
		
?>