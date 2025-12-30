<?php  
require_once("fun.php");
require_once(__ROOT__ . "/class/common/FileUtil.class.php");

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "load" :
		load ();
		break;
	case "save" :
		save ();
		break;
	case "setconfig":
		setconfig ();
		break;
	case "init":
		init();
		break ;
	case "init_all":
		init_all();
	default :
		break;
}

function init_all()
{
	//20151106 更新所有服务器上的配置
	//sysconfig::initAllServerConfig();
	
	global $printer;
	$printer->success();
}

function init()
{
	bulidAppValue();
	
	global $printer;
	$printer->success();
}

function load() 
{
	global $printer;
	$printer->isfliter = 1;

	$genre = g ( "genre" );
	$config = new SYSConfig ();
	$data = $config->load( $genre );

	$json = "";
	foreach ( $data as $row ) {
		$name = $row ["col_name"];
		$value = $printer->fliterByJson ( $row ["col_data"] );
		$json .= ($json == "" ? "" : ",") . "\"" . $name . "\":\"" . $value . "\"";
	}
	$json = "{" . $json . "}";

	$printer->out_str ( $json );
}
function save() 
{
	global $printer;

	$config = new SYSConfig ();
	$genre = g ( "genre" );
	$arr_data = explode ( ",", g ( "data" ) );
	$arr_param = array();
	
	foreach ( $arr_data as $item ) {
		$pos = strpos ( $item, ":" );
		if ($pos > 0) {
			$name = substr ( $item, 0, $pos );
			$value = substr ( $item, $pos + 1 );
			$arr_param[] = $config -> create_param($name,$value,$genre) ;
		}
	}
	
	$config -> setConfig($arr_param);
	
	//20151106 更新所有服务器上的配置
	//sysconfig::initAllServerConfig();
	
	$printer->success ();
}

//from admin/set/set.php
/*
method	设置配置
		1、保存到数据库 2、保存到antserver 3、保存到webserver
*/
function setconfig()
{
	global $printer;

	$names = explode(",",g("names"));
	$values = explode(",",g("values"));
	$types = explode(",",g("types"));
	

	$params = array();
	$i = 0 ;
	for($i=0;$i<count($names);$i++)
	{
		if($names[$i]){
		$value = $values[$i] ;
		$value = str_replace("@@@",",",$value) ;
		$value = str_replace("'"," ",$value) ;
		$params[] = array("name"=> $names[$i],"value"=> $value,"type"=> $types[$i]);
		//$params[strtoupper($names[$i])] = $value;
		}
	}
//	echo var_dump($params);
//	exit();
	$config = new SYSConfig ();
 	$config -> setConfig($params);
 	
 	//20151106 更新所有服务器上的配置
 	//sysconfig::initAllServerConfig();
 	if(g("old_rtc_console")!=g("rtc_console")){
		$fu = new FileUtil();
		$fu->copyDir(g("old_rtc_console"), g("rtc_console"));
	}
 	
	$printer -> success();
}
?>