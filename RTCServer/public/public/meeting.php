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

function save() {
	Global $printer;
	Global $op;

	$m = new Model ( "tab_meet" );
	$arr_userIds = explode("," , g("userids"));
	$arr_loginNames = explode("," , g("loginnames"));
	$arr_userNames = explode("," , g("usernames"));

	$result = $m->autoSave ();
	set_meeting_user(g("col_id"),CurUser::getUserId(),CurUser::getLoginName(),CurUser::getUserName(),1);
	foreach ($arr_userIds as $key=>$val){
		set_meeting_user(g("col_id"),$arr_userIds[$key],$arr_loginNames[$key] ,$arr_userNames[$key],0);
	}
	$printer->success ();
}

function delete() {
	Global $printer;
	$meetingId = g ( "meetingid" );

	$db = new DB ();
	$sql[] = "delete from tab_meet where col_id='" . $meetingId . "'" ;
	$sql[] = "delete from tab_meet_member where col_meetid='" . $meetingId . "'" ;
	$sql[] = "delete from Tab_Meet_File where col_meetid='" . $meetingId . "'" ;
	$sql[] = "delete from Tab_Meet_File_Group where col_meetid='" . $meetingId . "'" ;
	$sql[] = "delete from Tab_Meet_Msg_XXX where col_meetid='" . $meetingId . "'" ;

	$result = $db->execute($sql);
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
	$field_user = g ( "field_user", "col_name + '(' + col_mobile + ')'" );

	$parent = getEmpInfo ( $nodeId );

	$empXML = new EmpXML ();
	$empXML->viewType = $viewType;
	$empXML->viewOwnerId = $viewOwnerId;
	$empXML->rootName = "";
	$empXML->Field_UserName = $field_user;
	$data = $empXML->get_tree ( $nodeId, $loadUser, $loadAll );
	$printer->out_xml ( $data );
}

function set_meeting_user($meetingId,$userId,$loginName,$userName,$isAdmin=0){
	$m = new Model ( "tab_meet_member" );
	$arrFields = array (
			'col_meetid' => $meetingId,
			'col_userlogin' => js_unescape($loginName) . RTC_DOMAIN,
			'col_username' => js_unescape($userName),
			'col_userid' => $userId,
			'col_joinstate' => 1,
			'col_isadmin' => $isAdmin
	);

	$m->clearParam();
	$m->addParamFields($arrFields);
	$result = $m->insert();
	if($isAdmin != 1)
		meeting_notice($meetingId,$loginName,$userId);
	return $result;
}

function select_group(){
	Global $printer;
	$groupId = g( "groupid" );
	$group = new Group();
	$data = $group->listMember($groupId);


	$printer->out_list($data);
}

function get_attenders($type = 1){
	Global $printer;
	Global $op;

	$isAdmin = 0;

	$meetingId = g ( "meetingid" );
	$m = new Model ( "tab_meet_member" );
	$m->field="col_username";
	$m->addParamWhere("col_meetid", $meetingId);
	$data = $m->getList();
	$data = table_fliter_doublecolumn($data);
	$attenders ="";

	if(count($data) > 0){
		$attenders =$printer->array2str($data, "、");
		$status = 1;
	}
	else {
		$status=0;
	}

	$m->clearParam();
	$m->addParamWhere("col_userid", CurUser::getUserId(),"=","int");
	$m->addParamWhere("col_meetid", $meetingId);
	$isAdmin = $m->getValue("col_isadmin");
	if($type==1)
		$printer->out ( $status,"attenders:" . $attenders . ",isadmin:" . $isAdmin);
	else
		return $attenders;
}

function get_meeting_state(){
	Global $printer;

	$meetingId = g("meetingid");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "select * from tab_meet where col_id='" . $meetingId . "'";
	$data = $db->executeDataRow($sql);
	if(count($data))
	{
		$sql_count = " select count(*) as c from Tab_Meet_Member where Col_MeetID='" . $meetingId . "' and Col_State=1" ;
		$count = $db -> executeDataValue($sql_count);
		if($count){
			 if($data['col_isvideo']) $res=$count.get_lang("meeting_alert1").get_lang("meeting_alert3");
			 else $res=$count.get_lang("meeting_alert1").get_lang("meeting_alert2");
			 $printer ->out_arr(array('status' => 1,'isvideo' => $data['col_isvideo'],'msg' => $res));
		}
	}
	$printer -> fail();
}

function get_meeting_info(){
	Global $printer;

	$meetingId = g("meetingid");
	$userId = CurUser::getUserId();
	$isaudio = (int)g("isaudio");
	$isvideo = (int)g("isvideo");
	$logintype = (int)g("point");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "select a.col_id as meetingid,a.col_name as meetingname,a.col_createdate as meetingtime,a.col_createname as meetingcreator,a.col_state,b.col_username as username,b.col_userid as userid,b.col_isadmin as userrole,b.col_userlogin as

loginname,b.col_logintype,b.col_state as

state from tab_meet a,tab_meet_member b where a.col_id='" . $meetingId . "' and b.col_meetid='" . $meetingId ."' and b.col_userid=" . $userId ;

	$data = $db->executeDataRow($sql);
	//$data = row_fliter_doublecolumn($data,1);
	if(count($data)>0){
		$sql_count = " select count(*) as c from Tab_Meet_Member where Col_MeetID='" . $meetingId . "' and Col_State=1" ;
		$count = $db -> executeDataValue($sql_count);
		if($data['state']){
			if($data['col_logintype']!=$logintype) $printer ->out_arr(array('status' => 1,'logintype' => $data['col_logintype'],'state' => 1,'msg' => $meetingId));
		}
	}else{
		$count = 0;
		$sql = "select * from Clot_Ro where TypeID='" . $meetingId . "'";
		$data_folder = $db->executeDataRow($sql);
		if(count($data_folder)>0)
		{
			$sql = "insert into Tab_Meet(Col_ID,Col_Name,Col_Desc,Col_CreateLogin,Col_CreateName,Col_CreateID,Col_CreateDate,Col_IsAudio,Col_IsVideo,Col_State)  values('" . $data_folder['typeid'] . "','" . $data_folder['typename'] . "','" . $data_folder['remark'] . "','" . CurUser::getLoginName() . "','" . CurUser::getUserName() . "','" . CurUser::getUserId() . "','" . getNowTime() . "'," . $isaudio . "," . $isvideo . ",1) ";
			$db->execute($sql);
		}
		$group = new Group();
		$data_file = $group->listMember($meetingId);
		$sql = "delete from tab_meet_member where col_meetid='" . $meetingId . "'" ;
		$db->execute($sql);
		foreach($data_file as $k=>$v){
			$sql = "insert into Tab_Meet_Member(Col_MeetID,Col_UserLogin,Col_UserName,Col_UserID,Col_IsAdmin) values('" . $meetingId . "','" . $data_file[$k]['col_loginname'] . "','" . $data_file[$k]['col_name'] . "'," . $data_file[$k]['col_id'] . "," . $data_file[$k]['isadmin'] . ") ";
			$db->execute($sql);
		}
	}
	$printer ->out_arr(array('status' => 1,'state' => $count,'msg' => $meetingId));
}

function get_meet_member_info(){
	Global $printer;

	$meetingId = g("meetingid");
	$userId = CurUser::getUserId();
	$socketId = g("socketId");
	$isaudio = (int)g("isaudio");
	$isvideo = (int)g("isvideo");
	$logintype = (int)g("LoginType");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = " update tab_meet_member set Col_UserLogin='" . CurUser::getLoginName() . "',Col_socketId='" . $socketId . "',Col_LoginType=" . $logintype . ",Col_IsAudio=" . $isaudio . ",Col_IsVideo=" . $isvideo . ",Col_State=1 where Col_MeetID='" . $meetingId ."' and Col_UserID=" . $userId;
	$db -> execute($sql);
	$sql_count = " select count(*) as c from tab_meet_member where col_meetid='" . $meetingId ."' and col_state=1" ;
	$count = $db -> executeDataValue($sql_count);
	$sql = "select a.UserIco,a.UserIcoLine,b.* from Users_ID a,tab_meet_member b where a.UserID=b.col_userid and b.col_meetid='" . $meetingId ."' and b.col_state=1" ;
	$data = $db->executeDataTable($sql);
	$printer -> out_list($data,$count,0);
}

function get_meet_an_member_info(){
	Global $printer;

	$meetingId = g("meetingid");
	$userId = CurUser::getUserId();
	$socketId = g("socketId");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "select a.UserIco,a.UserIcoLine,b.* from Users_ID a,tab_meet_member b where a.UserID=b.col_userid and b.col_meetid='" . $meetingId ."' and b.col_state=1 and b.Col_socketId='" . $socketId ."'" ;
//	echo $sql;
//	exit();
	$data = $db->executeDataTable($sql);
	$printer -> out_list($data,-1,0);
}

function update_meet_member_info(){
	Global $printer;

	$meetingId = g("meetingid");
	$userId = CurUser::getUserId();
	$socketId = g("socketId");
	$isaudio = (int)g("isaudio");
	$isvideo = (int)g("isvideo");
	$logintype = (int)g("LoginType");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = " update tab_meet_member set Col_IsVideo=" . $isvideo . " where Col_MeetID='" . $meetingId ."' and Col_UserID=" . $userId;
	$db -> execute($sql);
	$printer -> success();
}

// / <summary>
// / 关闭一个会话
// / </summary>
function close_meet() {
	global $printer;
	
	$meetingId = g("meetingid");
	$userId = CurUser::getUserId();
	
	//if($meetingId.substr($tmpString,0,4)!='Clot') return ;
	
	$db = new DB();
	$sql = " update tab_meet_member set Col_State=0 where Col_MeetID='" . $meetingId ."' and Col_UserID=" . $userId;
	$db -> execute($sql);
	$printer->success ();
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
	$isaudio = (int)g("isaudio");
	$isvideo = (int)g("isvideo");
	$logintype = (int)g("point");

	//CurUser::setUserId($userId);
	$db = new DB();
	$sql = "select * from Tab_Chat where ((MyID='" . $userId . "' and YouID='" . $youid . "') or (MyID='" . $youid . "' and YouID='" . $userId . "')) and Status<>2" ;

	$data = $db->executeDataRow($sql);
	if(count($data)>0){
	    if($data['myid']==CurUser::getUserId()) $col_logintype=$data['logintype1'];
	    else $col_logintype=$data['logintype2'];
		if($col_logintype==$logintype) $printer ->out_arr(array('status' => 0,'chatid' => $data['chatid'],'msg' => $youid));
		else $printer ->out_arr(array('status' => 1,'chatid' => $data['chatid'],'logintype' => $data['status'],'msg' => $youid));
	}else{
		$sql = "select * from Tab_Chat where ((YouID='" . $youid . "' and LoginType2=2) or (MyID='" . $youid . "' and LoginType1=2)) and Status=1" ;
		$data = $db->executeDataRow($sql);
		if(count($data)>0) $printer ->out_arr(array('status' => 2,'chatid' => $data['chatid'],'msg' => $youid));
		
//		$sql = "select * from Tab_Chat where ((YouID='" . $youid . "' and LoginType1=2) or (MyID='" . $youid . "' and LoginType1=2)) and Status=0" ;
//		$data = $db->executeDataRow($sql);
//		if(count($data)>0) $printer ->out_arr(array('status' => 2,'chatid' => $data['chatid'],'msg' => $youid));
		
		$Id = getAutoId() ;
		$db = new Model("Tab_Chat");
		$db -> addParamField("chatid",$Id);
		$db -> addParamField("MyID",$userId);
		$db -> addParamField("YouID",$youid);
		$db -> addParamField("LoginType1",$logintype);
		$db -> addParamField("IsAudio",$isaudio);
		$db -> addParamField("IsVideo",$isvideo);
		$db -> addParamField("Status",0);
		$db -> addParamField("ip",$_SERVER['REMOTE_ADDR']);
		$db -> insert();
	}
	$printer ->out_arr(array('status' => 1,'chatid' => $Id,'logintype' => -1,'msg' => $youid));
}

function close_chat() {
	global $printer;
	
	$ChatId = g("ChatId");
	$userId = CurUser::getUserId();
	$youid = g ( "youid" );
	
	//if($meetingId.substr($tmpString,0,4)!='Clot') return ;
	
	$db = new DB();
	$sql = " update Tab_Chat set Status=2 where ChatId=" . $ChatId;
	$db -> execute($sql);
	$printer ->out_arr(array('status' => 1,'chatid' => $ChatId,'msg' => $youid));
}
//function start_meeting(){
//	Global $printer;
//
//	$meetingId = g("meetingid");
//
//	//CurUser::setUserId($userId);
//	$db = new DB();
//	$sql = "select * from tab_meet where col_id='" . $meetingId . "'";
//
//	$data = $db->executeDataRow($sql);
//	if(count($data)>0)
//	{
//
//		if($data['col_state']){
//			$sql_count = " select count(*) as c from Tab_Meet_Member where col_id='" . $meetingId . "' and Col_State=1" ;
//			$count = $db -> executeDataValue($sql_count);
//			if($count){
//				 if($data['col_isvideo']) $printer -> success($count.get_lang("meeting_alert1").get_lang("meeting_alert3"));
//				 else $printer -> fail($count.get_lang("meeting_alert1").get_lang("meeting_alert2"));
//			}
//		}else{
//			$sql = " update tab_meet set Col_CreateLogin='" . CurUser::getLoginName() . "',Col_CreateName='" . CurUser::getUserName() . "',Col_CreateID='" . CurUser::getUserId() . "',Col_CreateDate='" . getNowTime() . "',Col_State=1 where OnlineID =" . $doc_id;
//		    $db -> execute($sql);
//		}
//	}
//}

//帐号或名称要转化为unicode编码
function get_join_url($data){
    $url = "upsoft://meeting/?from=meeting2";
    $url .= "&Name=" . urlencode(utf8_unicode($data['username']));
    $url .= "&Role=" . $data['userrole'];
    $url .= "&UID=" . $data['userid'];
    $url .= "&MID=" . g("meetingid");
    $url .= "&Account=" . urlencode(utf8_unicode($data['loginname']));
    $url .= "&MS=" . $_SERVER['SERVER_NAME'] . ":" . MEETING_SERVER_PORT;
    $url .= "&RS=" . $_SERVER['SERVER_NAME'] . ":" . MEETING_TRANSFER_PORT;
    $url .= "&PPT=showplay&FS=" . $_SERVER['SERVER_NAME'] . ":" . MEETING_FILE_PORT;

	return $url;
}

function meeting_notice($meetingId,$loginName,$userId){
	$msg = new MsgSender();

	//考虑到域验证和webservice验证，
	//会议提醒发送人固定为admin  2015.02.04
	$user = new User();
	$user->field = "col_loginname,col_pword,col_entype";
	$user->addParamWhere("col_loginname", "admin");
	$arr_user = $user->getDetail();
	$arr_user = row_fliter_doublecolumn($arr_user,1);
	$msg->sendAntMessge($arr_user['col_loginname'], CurUser::getUserName(), $arr_user['col_entype'], $arr_user['col_pword'], $loginName, 0, "Text/Url", "会议邀请通知", "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER["SERVER_PORT"] . "/meeting/meeting_notice.html?userid=" . $userId . "&meetingid=" . $meetingId);
}
?>