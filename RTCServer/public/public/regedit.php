<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/CharsetConv.class.php");?>
<?php
	$op = g("op") ;
	$printer = new Printer();


	switch($op)
	{
		case "save":
			save();
			break ;
		case "saveclient":
			saveclient();
			break ;
		default:
			break;
	}

	function save()
	{
		
		Global $printer;
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
		//$UserApply = g("UserApply",0);
		$chats = g("chats",0);
		$logs = g("logs",0);
		$control_computer = g("control_computer",1);
		$lock_screen = g("lock_screen",0);
		$offline_information = g("offline_information",0);
		$minimize = g("minimize",0);
		$CheckIM0 = g("CheckIM0",0);
		$CheckIM1 = g("CheckIM1",0);
		$delete_chats = g("delete_chats",0);
		$chatsday = g("chatsday",0);
		$delete_offline_files = g("delete_offline_files",0);
		$delete_offline_notices = g("delete_offline_notices",0);
		$noticeday = g("noticeday",0);
		$interval_time = g("interval_time",0);
		$delete_server_files = g("delete_server_files",0);
		$server_capacity = g("server_capacity",0);
//		$DB_TYPE = g("DB_TYPE","access");
//		$DB_SERVER = g("DB_SERVER","");
//		$DB_PORT = g("DB_PORT","");
//		$DB_USER = g("DB_USER","");
//		$DB_PWD = g("DB_PWD","");
//		$DB_NAME = g("DB_NAME","");

		
//        $db = new DB();
//		$sql = "update OtherForm set UserApply=".$UserApply." where ID=1";
//		$db->execute($sql);
		
//	    $config_content = file_get_contents(__ROOT__ . '/config/config.inc.php');
//		$config_content = preg_replace('/(DB_TYPE",[\'"])(.*?)([\'"])/','${1}'.$DB_TYPE.'${3}',$config_content);  
//		if($DB_TYPE=="access"){
//		$config_content = preg_replace('/(DB_USER",[\'"])(.*?)([\'"])/','${1}${3}',$config_content);
//		$config_content = preg_replace('/(DB_PWD",[\'"])(.*?)([\'"])/','${1}seekinfo${3}',$config_content);
//		}else{
//		$config_content = preg_replace('/(DB_SERVER",[\'"])(.*?)([\'"])/','${1}'.$DB_SERVER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PORT",[\'"])(.*?)([\'"])/','${1}'.$DB_PORT.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_USER",[\'"])(.*?)([\'"])/','${1}'.$DB_USER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PWD",[\'"])(.*?)([\'"])/','${1}'.$DB_PWD.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_NAME",[\'"])(.*?)([\'"])/','${1}'.$DB_NAME.'${3}',$config_content); 
//	    }
//		file_put_contents(__ROOT__ . '/config/config.inc.php',$config_content);
		
//	    $config_content = file_get_contents(__ROOT__ . '/inc/config.ini');
//		$config_content = preg_replace('/(DB_TYPE=[\'"])(.*?)([\'"])/','${1}'.$DB_TYPE.'${3}',$config_content);  
//		if($DB_TYPE=="access"){
//		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}${3}',$config_content);
//		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}seekinfo${3}',$config_content);
//		}else{
//		$config_content = preg_replace('/(DB_SERVER=[\'"])(.*?)([\'"])/','${1}'.$DB_SERVER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PORT=[\'"])(.*?)([\'"])/','${1}'.$DB_PORT.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}'.$DB_USER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}'.$DB_PWD.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_NAME=[\'"])(.*?)([\'"])/','${1}'.$DB_NAME.'${3}',$config_content); 
//	    }
//		file_put_contents(__ROOT__ . '/inc/config.ini',$config_content);
		
	    $content = new SimpleIniIterator(__ROOT__ . '/Data/DataBase.ini');
//		$content->setIniValue('DB_TYPE', $DB_TYPE, 'server_connection');
//		$content->setIniValue('DB_SERVER', $DB_SERVER, 'server_connection');
//		$content->setIniValue('DB_PORT', $DB_PORT, 'server_connection');
//		$content->setIniValue('DB_USER', $DB_USER, 'server_connection');
//		$content->setIniValue('DB_PWD', $DB_PWD, 'server_connection');
//		$content->setIniValue('DB_NAME', $DB_NAME, 'server_connection');

		$content->setIniValue('chats', $chats, 'server_connection');
		$content->setIniValue('logs', $logs, 'server_connection');
		$content->setIniValue('control_computer', $control_computer, 'server_connection');
		$content->setIniValue('lock_screen', $lock_screen, 'server_connection');
		$content->setIniValue('offline_information', $offline_information, 'server_connection');
		$content->setIniValue('minimize', $minimize, 'server_connection');
		$content->setIniValue('CheckIM0', $CheckIM0, 'server_connection');
		$content->setIniValue('CheckIM1', $CheckIM1, 'server_connection');
		$content->setIniValue('options', $delete_chats, 'delete_chats');
		$content->setIniValue('chatsday', $chatsday, 'delete_chats');
		$content->setIniValue('interval_time', $interval_time, 'message_push');
		$content->setIniValue('options', $delete_offline_files, 'delete_offline_files');
		$content->setIniValue('options', $delete_offline_notices, 'delete_offline_notices');
		$content->setIniValue('noticeday', $noticeday, 'delete_offline_notices');
		$content->setIniValue('options', $delete_server_files, 'delete_server_files');
		$content->setIniValue('server_capacity', $server_capacity, 'delete_server_files');
						
        $printer -> success();
	}

	function saveclient()
	{
		
		Global $printer;
		
        $db = new DB();
		$sql = "update OtherForm set WebName='".g("WebName")."',WebUrl='".g("WebUrl")."',WebRun=".g("WebRun",0)." where ID=1";
		$db->execute($sql);
		
	    $content = new SimpleIniIterator(__ROOT__ . '/templets/xiazai/DataBase.ini');
		$content->setIniValue('WebNa', g("WebNa"), 'Web');
		$content->setIniValue('ServerIp', g("ServerIp"), 'server_connection');
		$content->setIniValue('Option1', g("Option1",0), 'server_connection');
		$content->setIniValue('CheckIM1', g("Server_CheckIM1",0), 'server_connection');
		$content->setIniValue('CheckIM2', g("Server_CheckIM2",0), 'server_connection');
		
		$content->setIniValue('CheckIM0', g("CheckIM0",0), 'software_settings');
		$content->setIniValue('CheckIM1', g("CheckIM1",0), 'software_settings');
		$content->setIniValue('CheckIM2', g("CheckIM2",0), 'software_settings');
		$content->setIniValue('CheckIM3', g("CheckIM3",0), 'software_settings');
		$content->setIniValue('CheckIM4', g("CheckIM4",0), 'software_settings');
		$content->setIniValue('CheckIM5', g("CheckIM5",0), 'software_settings');
		$content->setIniValue('CheckIM6', g("CheckIM6",0), 'software_settings');
		$content->setIniValue('CheckIM7', g("CheckIM7",0), 'software_settings');
		$content->setIniValue('CheckIM8', g("CheckIM8",0), 'software_settings');
		$content->setIniValue('CheckIM9', g("CheckIM9",0), 'software_settings');
//		$content->setIniValue('CheckIM10', g("CheckIM10",0), 'software_settings');
		$content->setIniValue('CheckIM11', g("CheckIM11",0), 'software_settings');
		$content->setIniValue('CheckIM13', g("CheckIM13","False"), 'software_settings');
		$content->setIniValue('CheckIM14', g("CheckIM14",0), 'software_settings');
		
//		$content->setIniValue('CheckTab0', g("CheckTab0",0), 'software_settings');
//		$content->setIniValue('CheckTab1', g("CheckTab1",0), 'software_settings');
//		$content->setIniValue('CheckTab2', g("CheckTab2",0), 'software_settings');
//		$content->setIniValue('CheckTab3', g("CheckTab3",0), 'software_settings');
//		$content->setIniValue('CheckTab4', g("CheckTab4",0), 'software_settings');
		$content->setIniValue('CheckTab5', g("CheckTab5",0), 'software_settings');
		$content->setIniValue('CheckTab6', g("CheckTab6",0), 'software_settings');
//		$content->setIniValue('CheckTab7', g("CheckTab7",0), 'software_settings');
//		$content->setIniValue('CheckTab8', g("CheckTab8",0), 'software_settings');
		$content->setIniValue('CheckTab9', g("CheckTab9",0), 'software_settings');
		$content->setIniValue('CheckTab10', g("CheckTab10",0), 'software_settings');
		$content->setIniValue('CheckTab11', g("CheckTab11",0), 'software_settings');
		$content->setIniValue('CheckTab12', g("CheckTab12",0), 'software_settings');
		$content->setIniValue('CheckTab13', g("CheckTab13",0), 'software_settings');
		$content->setIniValue('CheckTab14', g("CheckTab14",0), 'software_settings');
		
		$content->setIniValue('HotKey0', g("HotKey0"), 'software_settings');
		$content->setIniValue('HotKey1', g("HotKey1"), 'software_settings');
//		$content->setIniValue('Skins', g("Skins"), 'software_settings');
		
		$str = file_get_contents(__ROOT__ . '/templets/xiazai/DataBase.ini');
		$obj = new CharsetConv('utf-8', 'ansi');
		$response = $obj->convert($str);
		file_put_contents(__ROOT__ . '/templets/xiazai/DataBase.ini', $response, true);
		
		$zip=new ZipArchive();
	    if($zip->open(__ROOT__ . '/templets/xiazai/RTC.zip',ZipArchive::CREATE)===TRUE){
	    $zip->addFile(__ROOT__ . '/templets/xiazai/DataBase.ini','DataBase.ini');
	    $zip->addFile(__ROOT__ . '/templets/xiazai/RTC_Client.exe','RTC_Client.exe');
		if(file_exist(__ROOT__."/templets/xiazai/logo.ico")) 
		   $zip->addFile(__ROOT__ . '/templets/xiazai/logo.ico','logo.ico');
		if(file_exist(__ROOT__."/templets/xiazai/ClientLogo.jpg")) 
		   $zip->addFile(__ROOT__ . '/templets/xiazai/ClientLogo.jpg','ClientLogo.jpg');
		if(file_exist(__ROOT__."/templets/xiazai/logo.png")) 
		   $zip->addFile(__ROOT__ . '/templets/xiazai/logo.png','logo.png');
	    $zip->close();
		}
		
        $printer -> success();
	}



?>