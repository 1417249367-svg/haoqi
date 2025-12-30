<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/ant/AntService.class.php");?>

<?php
$op = g ( "op" );
$printer = new Printer ();

define ( "ALL_SERVICES", "RTC_Main_Service,RTC_Site_Service,RTC_Upload_Service,RTC_Download_Service,RTC_SetverPic_Service,RTC_Telnet_Service" );

switch ($op) {
	case "get_status" :
		get_status ();
		break;
	case "set_status" :
		set_status ();
		break;
	case "set_port" :
		set_port ();
		break;
	case "restart":
		restart();
		break ;
	default :
		break;
}

/*
method	重启服务
*/
function restart()
{
	$service = new AntService ();
	$service->restartAll();
}



//function get_status() {
//	Global $printer;
//	$services = g ( "services", ALL_SERVICES );
//	
//	$arr_service = explode(",",$services);
//	$append = "";
//	foreach($arr_service as $my_service)
//	{
//		if ($my_service){
//			if(win32_start_service_ctrl_dispatcher($my_service)) $status="0";
//			else $status="1";
//			$data.=($data == ""?"":",").'{"@attributes":{"name":"'.$my_service.'","status":"'.$status.'"}}';
//		}
//			
//	}
//	$append = $printer->union ( $append, '"Strvice":[' . $data . ']' );
//	$xml = $printer->out_detail ( "", $append, 0 );
//	
//	$result = simplexml_load_string($xml);
//	$result = json_encode($result);
//	
//	ob_clean ();
//	print $result;
//}

function get_status() {
	Global $printer;
	$services = g ( "services", ALL_SERVICES );
	
	$service = new AntService ();
	$data_file = $service->get_status ( $services );
	
	//$result = simplexml_load_string($xml);
	//$result = json_encode($xml);
	$printer -> out_list($data_file,-1,0);
	
//	ob_clean ();
//	print $result;
}

function set_status() {
	$services = g ( "services", ALL_SERVICES );
	$service_op = g ( "service_op" );
	
	$service = new AntService ();
	
	switch ($service_op) {
		case "start" :
			$service->start ( $services );
			//$service->start ( "AntGuard" );
			break;
		case "stop" :
			//$service->stop ( "AntGuard" );        //停止服务的时候要把守护服务停止掉
			$service->stop ( $services );
			break;
		case "restart" :
			$service->reStart ( $services );
			break;
	}
	
	ob_clean ();
	print "{\"service\":\"" . $services . "\",\"op\":\"" . $service_op . "\"}";
}
function set_port() {
	$service_name = g ( "service" );
	$service_port = g ( "port" );
	
	$service = new AntService ();
	$service->set_port ( $service_name, $service_port );
	
	ob_clean ();
	print "{\"service\":\"" . $service_name . "\",\"port\":\"" . $service_port . "\"}";
}
?>