<?php  require_once("fun.php");?>

<?php
$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "list" :
		get_list ();
		break;
	case "set_value" :
		set_value ();
		break;
}
function get_list() {
	Global $printer;
	
	$classId = g ( "classid" );
	$objId = g ( "objid" );
	
	$ace = new Model ( "tab_bioace" );
	$ace->addParamWheres ( array (
					"col_classid" => $classId,
					"col_objid" => $objId 
	) );
	$ace->order ( "col_hsitemtype desc" );
	$data = $ace->getList ();
	
	$printer->out_list ( $data );
}
function set_value() {
	Global $printer;
	
	$id = g ( "id" );
	$power = g ( "power" );
	
	$ace = new Model ( "tab_bioace" );
	$ace->setValue ( $id, "col_power", $power );
	
	$printer->success ();
}
function set_data() {
	Global $printer;
	
	$classId = g ( "classid" );
	$objId = g ( "objid" );
	$empType = g ( "EmpType" );
	$empIds = g ( "EmpIds" );
	$empNames = g ( "EmpNames" );
	$flag = g ( "flag" ); // 0 append 1 set
	$funName = g ( "funName" );
	$funGenre = g ( "funGenre" );
	$power = g ( "power", 1 );
	
	$ace = new Model ( "tab_bioace" );
	
	$field_other = array (
					"col_funname" => $funName,
					"col_fungenre" => $funGenre,
					"col_power" => 1 
	);
	$arr_EmpId = explode ( ",", $empIds );
	$arr_EmpName = explode ( ",", $empNames );
	for($i = 0; $i < count ( $arr_EmpId ); $i ++) {
		$empId = $arr_EmpId [$i];
		$empName = $arr_EmpName [$i];
		$field_keys = array (
						"col_classid" => $classId,
						"col_objid" => $objId,
						"col_hsitemtype" => $empType,
						"col_hsitemid" => $empId,
						"col_hsitemname" => $empName 
		);
		$ace->setRelationData ( $field_keys, "col_dhsitemid", $childEmpId, $field_other, $flag );
	}
	$printer->success ();
}

?>