<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpXML.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();
$m = new Model ( "rtc_sms_address" );
$owner = CurUser::getLoginName() ;


switch ($op) {
	case "add" :
		add();
		break;
	case "delete" :
		delete ();
		break;
	case "list" :
		list_address();
		break;
	default :
		break;
}



function add() {
	
	Global $printer;
	Global $owner ;
	Global $m ;
	$m -> clearParam();
	$m -> addParamField("col_name",g("name")) ;
	$m -> addParamField("col_mobile",g("mobile")) ;
	$m -> addParamField("col_owner",$owner) ;
	$m -> insert();

	$printer->success();
}

function delete() {
	
	Global $printer;
	Global $owner ;
	Global $m ;
	
	$m -> clearParam();
	$m -> addParamWhere("col_id",g("id")) ;
	$m -> delete();

	$printer->success();
}

function list_address() {
	
	Global $printer;
	Global $owner ;
	Global $m ;
	
	$m -> clearParam();
	$m -> addParamWhere("col_owner",$owner) ;
	$result = $m -> getList();

	$printer->out_list( $result );

}

?>