<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpXML.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Group.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/Api.inc.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgSender.class.php");?>
<?php  require_once(__ROOT__ . "/config/meeting.inc.php");?>

<?php
//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
//
//}else{
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//}
isPublicNet();
$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "create" :
		save ();
		break;
	case "delete":
		delete();
		break;
	case "get_orgtree" :
		get_orgtree ();
		break;
	case "get_attenders" :
		get_attenders();
		break;
	case "select_group" :
		select_group();
		break;
	case "get_meeting_state" :
		get_meeting_state();
		break;
	case "get_meeting_info" :
		get_meeting_info();
		break;
	case "get_meet_member_info" :
		get_meet_member_info();
		break;
	case "get_meet_an_member_info" :
		get_meet_an_member_info();
		break;
	case "update_meet_member_info" :
		update_meet_member_info();
		break;
	case "close_meet" :
		close_meet();
		break;
	case "get_chat_state" :
		get_chat_state();
		break;
	case "get_chat_info" :
		get_chat_info();
		break;
	case "close_chat" :
		close_chat();
		break;
	default :
		break;
}

function get_chat_state(){
	Global $printer;

	$youid = g ( "youid" );
	$userId = CurUser::getUserId();
	$logintype = (int)g("point");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "update Tab_Chat set status=2 where status<2 and datediff(hour,ConnectTime,getdate())>1 ";
	$db -> execute($sql);
	$sql = "select * from Tab_Chat where ((MyID='" . $userId . "' and YouID='" . $youid . "' and LoginType1<>" . $logintype . ") or (MyID='" . $youid . "' and YouID='" . $userId . "' and LoginType2<>" . $logintype . ")) and Status<>2";

	$data = $db->executeDataRow($sql);
	if(count($data)>0)
	{
	   $printer ->out_arr(array('status' => 1,'isvideo' => $data['isvideo'],'msg' => $youid));
	}
	$printer -> fail();
}

function get_chat_info(){
	Global $printer;

	$youid = g ( "youid" );
	$userId = CurUser::getUserId();

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "select * from remote_chat where ((MyID='" . $userId . "' and YouID='" . $youid . "') or (MyID='" . $youid . "' and YouID='" . $userId . "')) and Status=0" ;

	$data = $db->executeDataRow($sql);
	if(count($data)>0) $printer ->out_arr(array('status' => 2,'chatid' => $data['chatid'],'msg' => $youid));
		
	$Id = getAutoId() ;
	$db = new Model("remote_chat");
	$db -> addParamField("chatid",$Id);
	$db -> addParamField("MyID",$userId);
	$db -> addParamField("YouID",$youid);
	$db -> addParamField("Status",0);
	$db -> addParamField("ip",$_SERVER['REMOTE_ADDR']);
	$db -> insert();

	$printer ->out_arr(array('status' => 1,'chatid' => $Id,'logintype' => -1,'msg' => $youid));
}

function close_chat() {
	global $printer;
	
	$Status = g("Status",2);
	$userId = g ( "myid" );
	$youid = g ( "youid" );
	
	//if($meetingId.substr($tmpString,0,4)!='Clot') return ;
	
	$db = new DB();
	$sql = " update remote_chat set Status=" . $Status . " where MyID='" . $userId . "' and YouID='" . $youid . "'";
	$db -> execute($sql);
	$printer ->out_arr(array('status' => $Status,'chatid' => $ChatId,'msg' => $userId));
}
?>