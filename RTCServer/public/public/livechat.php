<?php  require_once("../class/fun.php");?>
<?php  require_once('../class/im/Msg.class.php');?>
<?php  require_once('../class/lv/LiveChat.class.php') ; ?>
<?php  require_once('../class/hs/EmpXML.class.php');?>
<?php  require_once('../class/hs/EmpRelation.class.php');?>
<?php
// -------------------------------------------------------------------
// 1 应答模式
// 2 直接接入查式
// 3 自动分配模式
// -------------------------------------------------------------------
//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
//
//}else{
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//}
isPublicNet();
$op = g ( "op" );
$op = strtolower ( $op );
$printer = new Printer ();

switch ($op) {
	case "get_tree":
		get_tree();
		break ;
	case "detail" :
		detail ();
		break;
	case "list" :
		getList ();
		break;
	case "setvalue" :
		setFieldValue ();
		break;
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "delete" :
		delete ();
		break;
	case "swap" :
		swap ();
		break;
	case "search_user" :
		Search_User();
		break;
	case "is_exist_chater" :
		Is_Exist_Chater ();
		break;
	case "listchater" :
		ListChater ();
		break;
	case "chaterdetail" :
		ChaterDetail ();
		break;
	case "transfer" :
		Transfer ();
		break;
	case "listonlinechater" :
		ListOnlineChater ();
		break;
	case "getrelationuser" :
		getRelationUser ();
		break;
	case "setrelationuser3" :
		setRelationUser3 ();
		break;
	case "connectchat" :
		ConnectChat ();
		break;
	case "connectchat1" :
		ConnectChat1 ();
		break;
	case "recvchat" :
		RecvChat ();
		break;
	case "closechat" :
		CloseChat ();
		break;
	case "waitqueue" :
		WaitQueue ();
		break;
	case "postrate" :
		PostRate ();
		break;
	case "savehistory" :
		SaveHistory ();
		break;
	case "saveattach" :
		SaveAttach ();
		break;
	case "uploadattach" :
		UploadAttach ();
		break;
	case "uploadscreenhot" :
		UploadScreenhot ();
		break;
	case "uploadpicture" :
		UploadPicture ();
		break;
	case "setuploadfile" :
		SetUploadFile ();
		break;
	
	case "listfile" :
		ListFile ();
		break;
	case "listlink" :
		ListLink ();
		break;
	
	case "savestatus" :
		SaveStatus ();
		break;
	case "saveuserinfo" :
		SaveUserInfo ();
		break;
	
	case "postmessage" :
		PostMessage ();
		break;
	case "register" :
		Register ();
		break;
	
	default :
		Response . Write ( GetAppUrl () );
		break;
}

function delete() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$id = g ( "id" );

	if (! $id)
		$printer->fail ();
		
	$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
	$db = new DB ();
	$result = $db->execute ( $sql );

	$printer->out ( $result );
}

function setFieldValue() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "userid" );
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new Model ( $tableName, $fldId );
	$result = $db->setValue1 ( $id, $fldname, $fldvalue );
	$printer->out ( $result );
}

function swap() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "col_id" );

	$fldSwap = g ( "fldswap" );
	$curr_id = g ( "curr_id" );
	$curr_value = g ( "curr_value" );
	$swap_id = g ( "swap_id" );
	$swap_value = g ( "swap_value" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->swap ( $fldSwap, $curr_id, $curr_value, $swap_id, $swap_value );

	$printer->out ( $result );
}

$xml = "" ;
function get_tree()
{
	Global $printer;

	$admin = CurUser::isAdmin() ;
	$nodeId = g("id") ;
	$loadUser = g("loaduser",0);
	$loadAll = g("loadall",0);
	$parent = getEmpInfo($nodeId);
	$isroot = g("isroot",1);  		//0 不显示结构结点		1显示


	$empXML = new EmpXML();

	//不显示组织结构结点
	if ($isroot == "0")
		$empXML -> rootName = "" ;

	$data = $empXML -> get_livechat($nodeId,$loadUser,$loadAll);
	$printer -> out_xml($data);
}

// 得到关连的数据
function getRelationUser() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;

	$relation = new EmpRelation ();

	$data = $relation->getRelationData1 ( $parentEmpType, $parentEmpId, $childEmpType );

	$printer->out_list ( $data, -1, 0 );
}

function getList() {
	Global $printer;

	$tableName = f ( "table", "lv_link" );
	$fldId = f ( "fldid", "linkid" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "linkid desc" );
			$fldSortdesc = f ( "fldsortdesc", "linkid asc" );
			break ;
		default:
			$fldSort = f ( "fldsort", "linkid desc" );
			$fldSortdesc = f ( "fldsortdesc", "linkid asc" );
			break;
	}
	
	$where = stripslashes(f ( "wheresql", "" ));

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	
	
	$db = new Model ( $tableName, $fldId );
	$db->where ( $where );
	$count = $db->getCount ();

	$db->order ( $fldSort );
	$db->orderdesc ( $fldSortdesc );
	$db->field ( $fldList );
	if ($ispage == 0)
		$data = $db->getList ();
	else
		$data = $db->getPage ( $pageIndex, $pageSize, $count );
	if($tableName=="lv_link"){
		$lvdb = new DB();
		foreach($data as $k=>$v){
			$sql = "select * from lv_chater where userid=" . $data[$k]['chater'] . "";
			$row = $lvdb->executeDataRow($sql);
			$data[$k]['username'] = $row['username'];
		}
	}
	$printer->out_list ( $data, $count, 0 );
}

function detail() {
	Global $printer;

	$tableName = f ( "table", "OtherForm" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "*" );
	
	$group = new Model ( $tableName, $fldId );
	$groupId = g ( "id", 0 );
	$group->field ( $fldList );
	//$group->addWhere ( $fldId . "=" . $groupId );
	$group->addParamWhere($fldId,$groupId,"=","int") ;
	$row_group = $group->getDetail ();
	
	$append = "";
	$relation = new EmpRelation ();
	$data = $relation->getRelationData1 ( EMP_GROUP, $groupId, EMP_USER );
	$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );

	$printer->out_detail ( $row_group, $append, 0 );
}

function save() 
{
	Global $printer;
	Global $op;

	$tableName = f ( "table", "OtherForm" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "*" );
	
	$label = g("label");
	
	if ($label == "lv_chater")
	{
		save_lv_chater();
		return ;
	}
	
	$user = new Model ( $tableName, $fldId );

	$result = $user->autoSaveRole ( $op, $fldId, $fields, $keyfields, $flitersql );
	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
		
	$groupId = $result ["id"];
	$memberIds = g ( "memberIds" );
	$relation = new EmpRelation ();
	$relation -> setRelation3 ( 0, EMP_GROUP, $groupId, "", EMP_USER, $memberIds, $flag );

	$printer->success ();
}

function save_lv_chater() 
{
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );
	$loginname = f ( "loginname" );
	
//	$livechat = new LiveChat ();
//	if ($livechat -> exist_name($loginname))
//		$printer -> fail("[" . $loginname . "]".get_lang("cloud_isexists"));

	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSaveRole ( $op, $fldId, $fields, $keyfields, $flitersql );

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else
		$printer->success ( "id:" . $result ["id"] );
}

// 设置关系的数据 db:1,2,5 curr:1,2,3,4 delete:5 insert:3,4
function setRelationUser3() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;
	$childEmpId = g ( "userid" );
	$flag = g ( "flag", 1 );

	$relation = new EmpRelation ();
	$relation->setRelation3 ( 0, $parentEmpType, $parentEmpId, "", $childEmpType, $childEmpId, $flag );
	
	$printer->Success ();
}


// 列出客服人员
function Search_User() {
	global $printer;
	
	$key = g("key");
	$db = new Model ("Users_ID");
	$db->field("FcName as username,Jod as jobtitle,'' as deptname,Tel2 as phone,Tel1 as mobile,Constellation as email");
	$db->where ("where UserName='" . $key . "'");
	$data = $db-> getList();
 
	$printer->out_list($data,-1,0);
}

// 列出客服人员
function ListChater() {
	global $printer;
	
	$db = new Model ( "lv_chater" );
	$data = $db->getList ();
	
	$printer->out_list($data,-1,0);
}

function ListOnlineChater() {
	global $printer;
	
	$db = new DB();
	$sql = "select aa.*,bb.UserID,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";

	$data = $db -> executeDataTable($sql) ;

	$printer->out_list($data,-1,0);
}

function Is_Exist_Chater() {
	global $printer;

	$db = new DB();
	$sql = "select count(*) as c from lv_chater as aa,Users_ID as bb where aa.LoginName='" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName";
	$result = $db -> executeDataValue($sql);
	if ($result){	
		$printer -> success(phpescape(IPADDRESS));
	}else
		$printer -> fail();
	
}

function ChaterDetail () {
	global $printer;
	$Chater = g ("Chater");
	
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterDetail ($Chater);
	
	$printer->out_arr ( $data );
}

function Transfer () {
	global $printer;
	$chatId = g ("chatid");
	$Chater = g ("Chater");
	$youid = g ( "youid" );
	$myid = g ( "myid" );
	
	$db = new Model("lv_chat");
	$db -> addParamField("Chater", $Chater);
	$db -> addParamWhere("ChatId", $chatId);
	$db -> update();
	
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterDetail ($Chater);
	$content = str_replace("{name}",$data ["username"],date("G:i:s").get_lang("livechat_message5"));
	$livechat -> SendKefuMessage($chatId,$youid,$Chater,$data ["username"],3,$content,0);
	$livechat -> SendKefuMessage($chatId,$Chater,$youid,$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0);
	if($data ["welcome"]) $livechat -> SendKefuMessage($chatId,$Chater,$youid,$data ["username"],1,$data ["welcome"],1);
	
	$msg = new Msg ();
	$msg -> sendKfMessage($youid, $Chater, $content);
	
	$printer->out_list($data,-1,0);
}
// 连接会话
function ConnectChat() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	$result = array ();
	
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) );
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["ip"] = $_SERVER ['REMOTE_ADDR'];
	$user ["area"] = "";
	
	$user = $livechat->GetUser ( $user );
//	echo g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) ).'|'.$user ["userid"];
//	exit();

	$connectType = g("connectType",1);
	$chatId = g ("chatid");
	$append = "";
	if(g ("chater")!=''){
		$db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatId);
		$db -> addParamWhere("chater", g ("chater"));
		$row = $db -> getDetail();
		if (count($row)){
		// merge
			$Chater=$row ["chater"];
			$result ["status"] = $row ["status"];
			$result ["chatid"] = $chatId;
			$result ["connecttype"] = $connectType;
			$result ["userid"] = $user ["userid"];
			$result ["username"] = $user ["username"];
			$result ["error"] = 0;
			$data = $livechat->GetChaterDetail ($Chater);
			$result ["talker"] = $Chater;
			if (count($data)){
				$result ["talkername"] = $data ["username"];
				$result ["welcome"] = $data ["welcome"];
			}
		
			if($row ["status"]<2) $printer->out_arr ( $result );	
		}
		 $data = $livechat->GetChaterDetail (g ("chater"));
	}else{
		$db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatId);
		//$db -> addParamWhere("Status", 2,"<","int");
		$row = $db -> getDetail();
		if (count($row)){
		// merge
			$Chater=$row ["chater"];
			$result ["status"] = $row ["status"];
			$result ["chatid"] = $chatId;
			$result ["connecttype"] = $connectType;
			$result ["userid"] = $user ["userid"];
			$result ["username"] = $user ["username"];
			$result ["error"] = 0;
			$data = $livechat->GetChaterDetail ($Chater);
			$result ["talker"] = $Chater;
			if (count($data)){
				$result ["talkername"] = $data ["username"];
				$result ["welcome"] = $data ["welcome"];
			}
		
			if($row ["status"]<2) $printer->out_arr ( $result );	
		}
		$data = $livechat->GetChaterRo ();
		if (count($data)){
			$result ["error"] = 1;
			$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );
			$printer->out_detail ( $result, $append, 0 );
		}
		else $data = $livechat->GetChaterRnd ($Chater);
	}
	
	if (count($data)){
	if($user ["userid"]==$Chater||$user ["userid"]==$data ["loginname"]||$user ["userid"]==g ("chater")){
	$result ["error"] = 3;
	$result ["msg"] = get_lang("livechat_message6");
	$printer->out_arr ( $result );
	}
	// create chat // "status"=>$status,"chatid"=>$chatId
	$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,g ("chatid"));
	$livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0);
	$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0);
	if(g ("goods_info")!='') $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],1,g ("goods_info"),1);
	if($data ["welcome"]) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,$data ["welcome"],1);
	// merge
	$result = $chat;
	$result ["connecttype"] = $connectType;
	$result ["userid"] = $user ["userid"];
	$result ["username"] = $user ["username"];
	$result ["talker"] = $data ["loginname"];
	$result ["talkername"] = $data ["username"];
	$result ["welcome"] = $data ["welcome"];
	$result ["error"] = 0;

	$printer->out_arr ( $result );
	}else{
	$result ["error"] = 2;
	$printer->out_arr ( $result );
	}
}

// 连接会话
function ConnectChat1() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) );

	$result = array ();
	$append = "";
	$data = $livechat->GetChaterForm (g ( "chater" ),g ( "typeid" ));
	if (count($data)){
		if($user ["userid"]==$data ["loginname"]){
		$result ["error"] = 3;
		$result ["msg"] = get_lang("livechat_message6");
		$printer->out_arr ( $result );
		}
		// create chat // "status"=>$status,"chatid"=>$chatId
		$connectType = g("connectType",1);
		$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,g ("chatid"));
		$livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0);
		$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0);
		if(g ("goods_info")!='') $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],1,g ("goods_info"),1);
		if($data ["welcome"]) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,$data ["welcome"],1);
		// merge
		$result = $chat;
		$result ["connecttype"] = $connectType;
		$result ["userid"] = $user ["userid"];
		$result ["username"] = $user ["username"];
		$result ["talker"] = $data ["loginname"];
		$result ["talkername"] = $data ["username"];
		$result ["welcome"] = $data ["welcome"];
		$result ["error"] = 0;
		$printer->out_arr ( $result );
	}else{
	$result ["error"] = 2;
	$printer->out_arr ( $result );
	}
}

// / <summary>
// / 关闭一个会话
// / </summary>
function CloseChat() {
	global $printer;
	
	$Chater = g ( "Chater" );
	$chatId = g ( "chatid" );
	$closeRole = g ( "CloseRole" );
	
	$livechat = new LiveChat ();
	if($Chater)	$result = $livechat->CloseChat1 ( $Chater, $closeRole );
	else $result = $livechat->CloseChat ( $chatId, $closeRole );
	
	$printer->success ();
}

// / <summary>
// / 接收一个会话，客服用
// / </summary>
function RecvChat() {
	global $printer;
	
	$chatId = g ( "chatid" );
	$visiter_loginname = g ( "visiter_loginname" );
	$livechat = new LiveChat ();
	$result = $livechat->RecvChat ( $chatId,$visiter_loginname );
	$printer->out ( $result );
}

// / <summary>
// / 得到排认号
// / </summary>
function WaitQueue() {
	global $printer;
	
	$chatId = g ( "chatid" );
	
	$livechat = new LiveChat ();
	$queue = $livechat->GetQueue ( $chatId );
	$status = $queue == 0 ? CHAT_STATUS_CONN : CHAT_STATUS_WAIT;
	
	$json = "{\"status\":" . $status . ",\"queue\":" . $queue . "}";
	print $json;
}
function PostRate() {
	global $printer;
	
	$chat = new Model ( "lv_chat" );
	$chat->addParamField ( "rate", g ( "rate" ) );
	$chat->addParamField ( "ratenote", g ( "note" ) );
	$chat->addParamWhere ( "chatid", g ( "chatid" ) ,"=","int" );
	$result = $chat->update();

	$printer->success();
}

function SaveHistory() {

	
	global $printer;
	
	/*不保存，此字段用来存放 访客的帐号 20150114*/
	/*
	$chat = new Model ( "lv_chat" );
	$chat->addParamField ( "NContent", g ( "content" ) );
	$chat->addParamWhere ( "chatid", g ( "chatid" ) );
	$result = $chat->update ();
	*/
	$printer-> success();
}

function SaveAttach() {

	global $printer;
	
	$attachDB = new Model("lv_file");
	$attachDB->addParamField("fileid", getAutoId());
	$attachDB->addParamField("chatid", g("chatid"));
	$attachDB->addParamField("chater", g("chater"));
	$attachDB->addParamField("username", g("username"));
	$attachDB->addParamField("filename", g("filename"));
	$attachDB->addParamField("filesize", g("filesize"));
	$attachDB->addParamField("filepath", g("filepath"));
	$attachDB->addParamField("flag", g("flag"));
	$attachDB->addParamField("createUser", g("createUser"));
	$result = $attachDB->insert();
	
	$printer-> success();
}
// / <summary>
// / 发表留言
// / </summary>
function PostMessage() {
	global $printer;
	
	$userId = GetValue("BIGANTLIVE_USERID");

	$user = array (
					"userid" => g ( "userid" ),
					"username" => g ( "username" ),
					"phone" => g ( "phone" ),
					"email" => g ( "email" ) 
	);
	
	$livechat = new LiveChat ();
	
	if ($userId == "") {
		$user = $livechat->CreateUser ( $user );
		$userId = $user ["userid"];
	}
	
	$msg = new Model ( "lv_message" );
	$msg->addParamFields ( $user );
	$msg->addParamField ( "id", getAutoId () );
	$msg->addParamField ( "userid", $userId );
//	$msg->addParamField ( "ip", getAutoId () );
	$msg->addParamField ( "usertext", g ( "usertext" ) );
	$msg->insert ();
	
	$printer->success ();
}

// / <summary>
// / 发表留言
// / </summary>
function Register() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array (
					"userid" => g ( "userid" ),
					"username" => g ( "username" ),
					"phone" => g ( "phone" ),
					"email" => g ( "email" ) 
	);
	$user = $livechat->CreateUser ( $user );
	
	$printer->success ();
}

// / <summary>
// / 设置上传开关
// / </summary>
function SetUploadFile() {
	global $printer;
	
	$chat = new Model ( "lv_chat" );
	$chat->addParamField ( "chatid", g ( "chatid" ) );
	$chat->addParamField ( "allowuploadfile", g ( "allowuploadfile" ) );
	$result = $chat->update ();
	
	$printer->success ();
}

// / <summary>
// / (访客或客服)发送文件
// / </summary>
function UploadAttach() {
	global $printer;
	
	// upload file
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file );
	}
	$result ["filepath"] = getRootPath () . $result ["filepath"];
	
	// append param
	$result ["fileid"] = g ( "fileid" );
	$result ["flag"] = g ( "flag", 1 );
	$result ["chatid"] = g ( "chatid" );
	$result ["chater"] = g ( "chater" );
	$result ["username"] = g ( "username" );
	$result ["flag"] = g ( "flag", 1 );
	
	// save db
	$livechat = new LiveChat ();
	$status = $livechat->SaveFile ( $result ["chatid"], $result ["flag"], $result ["chater"], $result ["username"], $result ["filename"], $result ["filepath"], $result ["filesize"] );
	
	// print
	$html = $printer->parseArray ( $result );
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	$printer->out_str ( $html );
}
function UploadScreenhot() {
	global $printer;
	
	// upload file
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file );
	}
	$result ["filepath"] = $result ["filepath"];
	
	// append param
	$result ["flag"] = g ( "flag", 1 );
	$result ["chatid"] = g ( "chatid" );
	$result ["chater"] = g ( "chater" );
	$result ["username"] = g ( "username" );
	$result ["flag"] = g ( "flag", 1 );
	
	// save db
	$livechat = new LiveChat ();
	$status = $livechat->SaveFile ( $result ["chatid"], $result ["flag"], $result ["chater"], $result ["username"], $result ["filename"], $result ["filepath"], $result ["filesize"] );
	
	// print
	$printer->out_arr ( $result );
}
function UploadPicture() {
	global $printer;
	$loginName = g ( "loginname" );
	$folder = g ( "folder" );
	
	// upload file
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file );
	}
	$result ["filepath"] = getRootPath () . $result ["filepath"];
	
	// save picture
	if (($folder == "face") && ($loginName != "")) {
		$chater = new Model ( "lv_chatER" );
		$chater->addParamField ( "Picture", $result ["filepath"] );
		$chater->addParamWhere ( "LoginName", $loginName );
		$chater->update ();
	}
	
	// printer
	$html = $printer->parseArray ( $result );
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	$printer->out_str ( $html );
}
function ListFile() {
	global $printer;
	
	$chatId = g ( "chatid" );
	$flag = g ( "flag", 0 );
	
	$livechat = new LiveChat ();
	$data = $livechat->ListFile ( $chatId, $flag );
	
	$printer->out_list($data,-1,0);
}
function ListLink() {
	global $printer;
	
	$chatId = g ( "chatid" );
	$chater = g ( "chater" );
	
	$livechat = new LiveChat ();
	$data = $livechat->ListLink ( $chater );
	
	$printer->out_list($data,-1,0);
}
function SaveStatus() {
	global $printer;
	
	$loginname = g ( "loginname" );
	$status = g ( "status", "0" );
	
	$db = new Model ( "lv_chatER" );
	$db->addParamWhere ( "loginname", $loginname );
	$db->addParamField ( "status", $status );
	$db->update ();
	
	$printer->success ();
}
function SaveUserInfo() {
	global $printer;
	
	$loginname = g ( "loginname" );
	$status = g ( "status" );
	
	$db = new Model ( "lv_chatER" );
	$db->addParamWhere ( "loginname", $loginname );
	$db->addParamField ( "DeptName", g ( "DeptName" ) );
	$db->addParamField ( "JobTitle", g ( "JobTitle" ) );
	$db->addParamField ( "Phone", g ( "Phone" ) );
	$db->addParamField ( "Mobile", g ( "Mobile" ) );
	$db->addParamField ( "Email", g ( "Email" ) );
	$db->update ();
	
	$printer->success ();
}

?>