<?php
require_once("fun.php");
require_once(__ROOT__ . "/class/ant/BIOACE.class.php");

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "list" :
		get_list ();
		break;
	case "delete" :
		delete ();
		break;
	case "set_power" :
		set_power ();
		break;
	case "set_powers" :
		set_powers ();
		break;
	case "set_data" :
		set_data ();
		break;
}

function get_list() 
{
	Global $printer;
	
	$classId 	= g ( "classid" );
	$objId 		= g ( "objid" );
	
	$ace = new BIOACE();
	$data = $ace->get_ace($classId,$objId);
	
	$printer->out_list($data,-1,0);
}

function delete() 
{
	Global $printer;
	
	$id 		= g ("id");
	$classId 	= g ( "classid",0);
	$objId 		= g ( "objid",0);
	
	$ace = new BIOACE();
	$result = $ace->delete_ace($id,$classId,$objId);

	$printer->out($result);
}

function set_power() 
{
	Global $printer;
	
	$id = g ( "id" );
	$power = g ( "power" );
	
	$ace = new BIOACE();
	$result = $ace->set_ace_power($id,$power);

	$printer->out($result);
}

function set_powers() 
{
	Global $printer;
	
	$power = g ( "power" );
	
	$ace = new BIOACE();
	$result = $ace->set_ace_powers($id,$power);

	$printer->out($result);
}


function set_data() 
{
	Global $printer;
	
	$classId 	= g("classid");
	$objId 		= g("objid");
	$empType 	= g("EmpType");
	$empIds 	= g("EmpIds");
	$empNames 	= g("EmpNames");
	$flag 		= g("flag"); // 0 append 1 set
	$funName 	= g("funName", "DocAce");
	$funGenre 	= g("funGenre");
	$power 		= g("power", 1);

	$ace = new BIOACE();
	$result = $ace->set_ace($classId,$objId,$funName,$funGenre,$power,$empType,$empIds,$empNames);

	$printer->out($result);
}



?>