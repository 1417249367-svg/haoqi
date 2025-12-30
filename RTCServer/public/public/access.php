<?php  require_once("fun.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "detail" :
		detail ();
		break;
	default :
		break;
}

function save() {
	Global $printer;
	Global $op;

	$m = new Model("ant_accesssystem");

	$result = $m->autoSave ();
	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	$accessId = $result ["id"];
	$printer->success ();
}

function detail() {
	Global $printer;

	$m = new Model("ant_accesssystem");
	$id = g ( "id", 0 );

	$m->addWhere ( "col_id=" . $id );
	$result = $m->getDetail ();

	$printer->out_detail ( $result );
}
function getList() {
	Global $printer;

	$nodeId = g ( "deptid" );
	$key = g ( "key" );
	$parent = getEmpInfo ( $nodeId );
	$viewId = $parent ["viewid"];
	$empType = $parent ["emptype"];
	$empId = $parent ["empid"];
	$fields = g ( "fldlist", "*" );
	$fldSort = f ( "fldsort", "col_itemindex,col_id" );

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	// 得到本部门
	$where = " where col_id in( select COL_DHSITEMID from HS_RELATION   where  COL_HSITEMID=" . $empId . " and COL_HSITEMTYPE=" . $empType . " and COL_DHSITEMTYPE=" . EMP_USER . ") ";

	if ($key != "")
		$where .= " and (HS_USER.Col_name like '%" . $key . "%' or Col_loginname like '%" . $key . "%')";

	$db = new Model ( "hs_user" );
	$db->order ( $fldSort );
	$db->field ( $fields );
	$db->where ( $where );
	$count = $db->getCount ();

	if ($ispage == 0)
		$data = $db->getList ();
	else
		$data = $db->getPage ( $pageIndex, $pageSize, $count );
	$printer->out_list ( $data, $count );
}
function search() {
	Global $printer;
	$top = g ( "top", 10 );
	$key = g ( "key" );
	$field_search = g ( "field_search", "col_name,col_loginname,col_firstspell,col_allspell" );
	$field_list = g ( "field_list", "col_id as id,col_name as name,col_loginname as loginname" );
	$field_order = "";

	$where = "";

	$fields = explode ( ",", $field_search );
	foreach ( $fields as $field ) {
		if ($field_order == "")
			$field_order = $field;
		$where .= ($where ? " or " : " where ") . $field . " like '%" . $key . "%'";
	}

	$db = new Model ( "hs_user" );
	$db->where ( $where );
	$db->order ( $field_order );
	$db->field ( $field_list );
	$data = $db->getTop ( $top );
	$printer->out_list ( $data );
}
function setPassword() {
	Global $printer;
	$userId = CurUser::getUserId ();
	$old_password = f ( "old_password" );
	$new_password = f ( "new_password" );

	$user = new User ();
	$result = $user->setPassword ( $userId, $old_password, $new_password );
	$printer->out ( $result ["status"], "errnum:" . $result ["errnum"] );
}

// 得到关连的数据
function getRelationUser() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;

	$relation = new EmpRelation ();

	$data = $relation->getRelationData ( $parentEmpType, $parentEmpId, $childEmpType );

	$printer->out_list ( $data );
}

// 设置关系的数据 db:1,2,5 curr:1,2,3,4 delete:5 insert:3,4
function setRelationUser() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;
	$childEmpId = g ( "userid" );
	$flag = g ( "flag", 1 );

	$relation = new EmpRelation ();

	$relation->setRelation ( 0, $parentEmpType, $parentEmpId, "", $childEmpType, $childEmpId, $flag );

	$printer->Success ();
}
function setFieldValue() {
	Global $printer;

	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new User ();
	$result = $db->setValue ( $id, $fldname, $fldvalue );

	$printer->out ( $result );
}

?>