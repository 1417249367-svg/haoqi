<?php  require_once("fun.php");?>
<?php

$op = g ( "op", "" );
$printer = new Printer ();

switch ($op) {
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "delete" :
		delete ();
		break;
	case "detail" :
		detail ();
		break;
	case "list" :
		getList ();
		break;
	case "setvalue" :
		setFieldValue ();
		break;
	case "swap" :
		swap ();
		break;
	default :
		break;
}
function save() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSaveGrant ( $op, $fldId, $fields, $keyfields, $flitersql );

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else
		$printer->success ( "id:" . $result ["id"] );
}
function delete() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$id = g ( "id" );

	if (! $id)
		$printer->fail ();

//    if($tableName=="AdminGrant"){
//	$sql = " delete from " . $tableName . " where " . $fldId . "=" . $id;
//	}else{
//	$id = "'" . str_replace ( ",", "','", $id ) . "'";
//	$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
//	}
	
	switch ($tableName)
	{
		case "AdminGrant":
			$sql = " delete from " . $tableName . " where " . $fldId . "=" . $id;
			break ;
		case "lv_message":case "lv_chat":case "lv_chater":
			$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
			break ;
		default:
			$id = "'" . str_replace ( ",", "','", $id ) . "'";
			$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
			break;
	}
	$db = new DB ();
	$result = $db->execute ( $sql );

	$printer->out ( $result );
}
function getList() {
	Global $printer;

	$tableName = f ( "table", "users_id" );
	$fldId = f ( "fldid", "userid" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "UserState ASC,Sequence Desc, CInt(UserID) Desc" );
			$fldSortdesc = f ( "fldsortdesc", "UserState DESC,Sequence ASC, CInt(UserID) ASC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "UserState ASC,Sequence Desc, CONVERT(int,UserID) Desc" );
			$fldSortdesc = f ( "fldsortdesc", "UserState DESC,Sequence ASC, CONVERT(int,UserID) ASC" );
			break;
	}
	
	$where = stripslashes(f ( "wheresql", "" ));

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	
	
	$db = new Model ( $tableName, $fldId );
	$db->where ( $where );
	$count = $db->getCount ();

	$db->order ( $fldSort );
	$db->orderdesc ( $fldSortdesc );
	$db->field ( $fldList );
	if ($ispage == 0)
		$data = $db->getList ();
	else
		$data = $db->getPage ( $pageIndex, $pageSize, $count );
		//echo var_dump($data);
	$printer->out_list ( $data, $count, 0 );
}
function detail() {
	Global $printer;

	$tableName = f ( "table", "AdminGrant" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$id = f ( "id", 1 );

	$db = new Model ( $tableName, $fldId );
	$db->addParamWhere ( $fldId, $id, "=", "int" );
	$row = $db->getDetail ();

	$printer->out_detail ( $row, "", 0 );
}
function setFieldValue() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "userid" );
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();
		
	if ($tableName == "lv_chater")
	{
		setFieldValue1();
		return ;
	}

	$db = new Model ( $tableName, $fldId );
	$result = $db->setValue ( $id, $fldname, $fldvalue );
	$db -> updateUsers_IDForm($id);
	$db -> updateForm("Users_IDVesr");
	$printer->out ( $result );
}

function setFieldValue1() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "userid" );
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new Model ( $tableName, $fldId );
	$result = $db->setValue1 ( $id, $fldname, $fldvalue );
	$printer->out ( $result );
}

function swap() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "col_id" );

	$fldSwap = g ( "fldswap" );
	$curr_id = g ( "curr_id" );
	$curr_value = g ( "curr_value" );
	$swap_id = g ( "swap_id" );
	$swap_value = g ( "swap_value" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->swap ( $fldSwap, $curr_id, $curr_value, $swap_id, $swap_value );

	$printer->out ( $result );
}

?>


