<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Role.class.php");?>
<?php
$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "get_data" :
		get_data ();
		break;
	case "set_data" :
		set_data ();
		break;
}
function get_data() {
	Global $printer;
	
//	$parentEmpType = g ( "ItemType" );
//	$parentEmpId = g ( "ItemId" );
//	
//	$ace = new Model ( "hs_biiace" );
//	$ace->addParamWheres ( array (
//					"col_hsitemtype" => $parentEmpType,
//					"col_hsitemid" => $parentEmpId 
//	) );
//	$data = $ace->getList ();
	
	$role = new Role ();
	// org
	$data = $role->listOrgAce ();
	
	$printer->out_list ( $data, -1, 0 );
}
function set_data() {
	Global $printer;
	Global $op;

	$tableName = f ( "table", "Role" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSavePlug ( $op, $fldId, $fields, $keyfields, $flitersql );

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else
		$printer->success ( "id:" . $result ["id"] );
}

?>