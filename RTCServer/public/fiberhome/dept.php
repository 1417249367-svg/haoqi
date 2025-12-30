<?php

/**
 * 部门同步推送系统

 * @date    20150519
 */
 
 
require_once("sync_push.php");



$op = g("optype");

switch($op)
{
	case "EDIT":
		dept_edit_push(g("data"));
		break ;
}

?>
