<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpXML.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "create" :
		save ();
		break;
	case "send_sms" :
		send_sms ();
		break;
	case "get_orgtree" :
		get_orgtree ();
		break;
	case "delete" :
		delete ();
		break;
	default :
		break;
}

// / <summary>
// / 发送到远程的短信服务器
// / </summary>
function send_sms() {
	// die('{"Msg":"企业ID或用户ID不存在！","ExecuteState":0}');

	//$sms_url = g ( "sms_url" );
    $content = g ( "content" );
	$mobile = g ( "mobile" );

	$sms_url = str_replace("{content}", $content, SMS_URL);
	$sms_url = str_replace("{mobile}", urlencode($mobile), $sms_url);

//echo $sms_url;
//exit();
	recordLog($sms_url);
	$response = "";

	error_reporting ( 0 );


	$response = file_get_contents ( $sms_url );

	recordLog($response);
	ob_clean ();
	print ($response) ;
}
function save() {
	Global $printer;
	Global $op;

	$user = new Model ( "rtc_sms" );

	$result = $user->autoSave1 ();

	$printer->success ();
}
function delete() {
	Global $printer;
	$arrSmsId = explode ( ",", g ( "smsid" ) );

	$db = new DB ();

	foreach ( $arrSmsId as $smsId ) {
		if ($smsId)
			$result = $db->execute ( "delete from rtc_sms where col_id=" . $smsId );
	}

	$printer->out ( $result );
}
function get_orgtree() {
	Global $printer;

	$admin = CurUser::isAdmin ();
	$nodeId = g ( "id" );
	$loadUser = g ( "loaduser", 1 );
	$loadAll = g ( "loadall", 0 );
	$viewType = g ( "viewtype", 1 );
	$viewOwnerId = g ( "ownerid", 0 );
	$field_user = g ( "field_user", "fcname + '(' + tel1 + ')' as name" );
	
	if($viewType==8) $loadAll=1;

	$parent = getEmpInfo ( $nodeId );

	$empXML = new EmpXML ();
	$empXML->viewType = $viewType;
	$empXML->viewOwnerId = $viewOwnerId;
	$empXML->rootName = "";
	$empXML->Field_UserName = $field_user;
	$data = $empXML->get_tree( $nodeId, $loadUser, $loadAll );
	$printer->out_xml ( $data );
}

?>