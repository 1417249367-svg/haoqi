<?php


require_once ("../class/fun.php");


$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "list" :
		get_list();
		break;
	case "save" :
		save ();
		break;
}


function get_list() 
{
	global $printer;
	
	$col_type = g('col_type');
	$db = new DB();
	$sql = "select * from rtc_keyword where col_type = ".$col_type;
	$result = $db->executeDataTable($sql);	
	$printer->out_list ( $result,-1,0);
}

/*
method	保存
return	{status:1,msg:""}
*/
function save() 
{
	global $printer;
	
	$col_type = g('col_type');
	$col_keyword = htmlspecialchars(g('col_keyword'));
	
	$db = new DB();
	$sql = "select count(*) as c from rtc_keyword where col_type = ".$col_type;
	$result = $db->executeDataValue($sql);
	
	if($result){
		$sql = "update rtc_keyword set col_keyword = '".$col_keyword."' where col_type=".$col_type ;
	}else{
	    $guid = create_guid();
		$sql = "insert into rtc_keyword (col_id,col_type,col_keyword) values('".$guid."',$col_type,'".$col_keyword."')";
	}
	
	$res = $db->execute($sql);
	if($res)
	   $printer -> success ( $result );
	else 
	   $printer->fail();
}



?>