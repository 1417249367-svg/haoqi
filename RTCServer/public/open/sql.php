<?php  require_once("fun.php");?>
<?php
$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "select": //定制项目中使用 201500608
		sql_select();
		break ;
	default :
		sql_execute();
		break;
}


/*
method	根据人员姓名得到部门
return
<data>
  <user id="1" loginname="aa">
	<dept id="emptype_empid" path="触点软件/开发一部" />
    <dept id="emptype_empid" path="触点软件/开发二部" />
  </user>
<data>
*/
function sql_select()
{
	Global $printer;
	$db = new DB();
//	echo g("sql");
//	exit();
	$data = $db -> executeDataTable(g("sql")) ;
	$printer -> out_list($data,-1,0);
}

function sql_execute()
{
	Global $printer;
	$db = new DB();
	$data = $db -> execute(g("sql")) ;
	$printer -> success();
}
?>