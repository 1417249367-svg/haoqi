<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/Uploader.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/Ziper.class.php");?>
<?php

$op = g ( "op" );

$printer = new Printer ();

switch ($op) {
	case "clear_msg" :
		clear_msg ();
		break;
	case "board_send" :
		board_send ();
		break;
}
// ================================================================
// 清除最近的数据
// ================================================================
function clear_msg() {
	Global $printer;
	
	// 删除几天前的数据
	$days = g ( "days", 7 );
	$dt = date ( 'Y-m-d 23:59:59', strtotime ( '-' . $days . ' day' ) );
	
	// 删除数据库记录
	$m = new Model ( "ant_msg" );
	$m->addParamWhere ( "col_senddate", $dt, "<", "date" );
	$m->delete ();
	
	//删除接收者表
	$m->tableName = "ant_msg_rece";
	$m->delete ();
	
	// 删除文件夹
	$dt = $dt = date ( 'Ymd' );
	$dir = RTC_DATADIR . "\\Message";
	$count = 0;
	
	$dh = opendir ( $dir );
	
	if (is_dir ( $dir )) {
		while ( $curr_folder = readdir ( $dh ) ) {
			$curr_folder = iconv_str ( $curr_folder );
			if (is_numeric ( $curr_folder )) {
				// 删除文件的文件夹以ymd命名
				if ($curr_folder <= $dt) {
					deldir ( $dir . "\\" . $curr_folder );
					$count = $count + 1;
				}
			}
		}
	}
	
	if ($count)
		$printer->success ();
	else
		$printer->fail ();
}

// ================================================================
// 发送公告
// ================================================================
function board_send() {
	Global $printer;
	
	$recv = g ( "recv" );
	$password = g ( "password" );
	$content = g ( "content" );
	
	$msg = new COM ( "AntCom.AntMsg" );
	$session = new COM ( "AntCom.AntSyncSession" );
	$login = new COM ( "AntCom.AntLoginInfo" );
	
	$msg->Subject = $content;
	$msg->ContentType = "Text/Text";
	$msg->Content = $content;
	$msg->AddReceiver ( $recv, "" );
	
	$login->Server = RTC_SERVER;
	$login->ServerPort = RTC_PORT;
	$login->LoginName = CurUser::getLoginName ();
	$login->PassWord = $password;
	
	$session->Login ( $login );
	$result = $session->SendMsg ( $msg, 0 );
	
	if ($result == 1) {
		$printer->success ();
	} else {
		if ($result == 205)
			$printer->fail ( "密码错误" );
		else
			$printer->fail ( "发送错误,请检查配置文件" );
	}
}

?>