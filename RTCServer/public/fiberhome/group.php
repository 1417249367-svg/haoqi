<?php

/**
 * 群组同步推送系统

 * @date    20150519
 */
require_once("sync_push.php");

$printer = new Printer ();

$op = g("optype");
$group_id = g("data");
switch($op)
{
	case "CREATE":
		group_change_push($group_id,1);
		break ;
	case "EDIT":
		group_change_push($group_id,2);
		break ;
	case "DELETE":
		group_delete_push($group_id);
		break ;
}



?>