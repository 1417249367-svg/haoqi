<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/wx.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgReader.class.php");?>
<?php  require_once('../class/lv/LiveChat.class.php') ; ?>
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
$userId = CurUser::getUserId() ;
$printer = new Printer ();
switch ($op) {
	case "read" :
		read ();
		break;
	case "btf2html" :
		btf2html ();
		break;
	case "list" :
		get_list ();
		break;
	case "get_package" :
		get_package ();
		break;
	case "get_file" :
		get_file ();
		break;
	case "get_file1" :
		get_file1 ();
		break;
	case "getimg" :
		getimg ();
		break;
	case "getimg1" :
		getimg1 ();
		break;
	case "msg_ack" :
		msg_ack ();
		break;
	case "get_offline_msg" :
		get_offline_msg ();
		break;
	case "all_ack_status" :
		all_ack_status ();
		break;
	case "GetKefuMessage" :
		GetKefuMessage ();
		break;
	case "RetractMessage" :
		RetractMessage ();
		break;
	case "RetractallMessage" :
		RetractallMessage ();
		break;
	case "GetKefuClotMessage" :
		GetKefuClotMessage ();
		break;
	case "setuserform" :
		setUserForm ();
		break;
	default :
		break;
}

// 默认显示最后一页
function get_list() {
	Global $printer;
	
	$dt1 = g ( "dt1", "2014-10-20" );
	$dt2 = g ( "dt2", "" );
	$user1 = g ( "user1", "" );
	$user2 = g ( "user2", "" );
	$key = g ( "key" );
	
	$sortBy = g ( "sortby" );
	$sortDir = g ( "sortdir", 0 );
	$pageIndex = g ( "page", 1 );
	$pageSize = g ( "pagesize", 20 );
	
	$label = g("label");
	
	if ($label == "messeng")
	{
		doc_list_messeng();
		return ;
	}
	
	if ($label == "messeng_acks")
	{
		doc_list_messeng_acks();
		return ;
	}
	
	if ($label == "messengclot")
	{
		doc_list_messengclot();
		return ;
	}
	
	if ($label == "messengclot_acks")
	{
		doc_list_messengclot_acks();
		return ;
	}
	
	if ($label == "messengkefu")
	{
		doc_list_messengkefu();
		return ;
	}
	
	if ($label == "messengkefu_one")
	{
		doc_list_messengkefu_one();
		return ;
	}
	
	if ($label == "messengkefuclot_one")
	{
		doc_list_messengkefuclot_one();
		return ;
	}
	
	if ($label == "messengkefu_chat")
	{
		doc_list_messengkefu_chat();
		return ;
	}
	
	if ($label == "messengkefu_history")
	{
		doc_list_messengkefu_history();
		return ;
	}
	
	if ($label == "messengkefuclot_history")
	{
		doc_list_messengkefuclot_history();
		return ;
	}
	
	if ($label == "messengkefu_acks")
	{
		doc_list_messengkefu_acks();
		return ;
	}
	
	if ($label == "messengkefu_getchaters")
	{
		doc_list_messengkefu_getchaters();
		return ;
	}
	
	if ($label == "messengkefuclot")
	{
		doc_list_messengkefuclot();
		return ;
	}
	
	if ($label == "messengkefuclot_acks")
	{
		doc_list_messengkefuclot_acks();
		return ;
	}
	
	if ($label == "messengkefuclot_getChaters")
	{
		doc_list_messengkefuclot_getChaters();
		return ;
	}
	
	if ($label == "messengnotice")
	{
		doc_list_messengnotice();
		return ;
	}
	
	if ($label == "messengverify")
	{
		doc_list_messengverify();
		return ;
	}
	
	if ($label == "chat")
	{
		doc_list_chat();
		return ;
	}
	
	if ($label == "remote")
	{
		doc_list_remote();
		return ;
	}
	
	if ($label == "leavefile")
	{
		doc_list_leavefile();
		return ;
	}
	
	
	if ($label == "msg_list")
	{
		doc_list_msg();
		return ;
	}
	
	if ($label == "messengkefuclot_search")
	{
		doc_list_messengkefuclot_search();
		return ;
	}
	
	$reader = new MsgReader ();
	$msg = new Msg ();
	$sql_where = $msg->getWhereSql ( $user1, $user2, $dt1, $dt2, $key );
	
	$sql_count = "select  count(*) as c  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where;
	$sql_list = "select  A.col_id,col_subject,col_sender,col_sendername,A.col_senddate,col_datapath  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where . " order by A.col_senddate ";
	// recordLog($sql_list);
	$count = $msg->db->executeDataValue ( $sql_count );
	$data = $msg->db->executeDataTable ( $sql_list );
	
	$html = "";
	foreach ( $data as $row ) {
		$html .= '<div class="msg-item ' . ($row ["col_sender"] == $user1 ? "msg-1" : "msg-2") . '"	msg-id="' . $row ["col_id"] . '" msg-datapath="' . $row ["col_datapath"] . '">';
		$html .= '<span class="msg-user">' . $row ["col_sendername"] . '</span>';
		$html .= '<span class="msg-date">' . getLocalTime ( $row ["col_senddate"] ) . '</span>';
		$html .= '<div class="msg-content">';
		$reader->read ( $row ["col_id"], $row ["col_datapath"] );
		$html .= $reader->html;
		$html .= '</div> ';
		$html .= '</div>';
	}
	
	$html = $count . ";" . $html;
	
	$printer->out_str ( $html );
}

function doc_list_messeng()
{
	Global $printer;

	$tableName = f ( "table", "Messeng_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,to_type,to_date,to_time,usertext,fontinfo,isreceipt1,isreceipt2,isack1,isack2,isack3,isack4" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messeng($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messeng_acks()
{
	Global $printer;

	$tableName = f ( "table", "Messeng_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "TypeID,msg_id,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	
	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messeng_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengclot()
{
	Global $printer;

	$tableName = f ( "table", "MessengClot_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,clotid,myid,youid,to_type,to_date,to_time,usertext,fontinfo" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengclot($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengclot_acks()
{
	Global $printer;

	$tableName = f ( "table", "Msg_Acks" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "ID,msg_id,clotid,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	$arr_sql = array();

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengclot_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengkefuclot()
{
	Global $printer;

	$tableName = f ( "table", "MessengKefuClot_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,clotid,pid,typename,picture,myid,youid,fcname,to_type,to_date,to_time,usertext,fontinfo" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengkefuclot($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file1 = $result_file["data_user"] ;
	$data_file2 = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
//		echo $printer->parseList ($data_file1, 0 );
//		exit();
	$printer->out_list1 ($data_file1,$data_file2,$data_file3,$recordcount, 0 );
}

function doc_list_messengkefuclot_acks()
{
	Global $printer;

	$tableName = f ( "table", "lv_chater_KefuMsg_Acks" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "ID,msg_id,clotid,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	$arr_sql = array();

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengkefuclot_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_leavefile()
{
	Global $printer;

	$tableName = f ( "table", "LeaveFile" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_leavefile($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$printer->out_list ( $data_file, -1, 0 );
}

function doc_list_msg() {
	Global $printer;

	$tableName = f ( "table", "users_id" );
	$fldId = f ( "fldid", "userid" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "UserState ASC,Sequence Desc, CInt(UserID) Desc" );
			$fldSortdesc = f ( "fldsortdesc", "UserState DESC,Sequence ASC, CInt(UserID) ASC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "UserState ASC,Sequence Desc, CONVERT(int,UserID) Desc" );
			$fldSortdesc = f ( "fldsortdesc", "UserState DESC,Sequence ASC, CONVERT(int,UserID) ASC" );
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

	$doc = new DB();
	foreach($data as $k=>$v){
		$sql = "select top 1 * from Users_ID where UserID ='".$data[$k]['youid']."' order by UserID desc";
		$user_detail = $doc -> executeDataRow($sql) ;
		$data[$k]['fcname1']=$user_detail ["fcname"] ;
	}

	$printer->out_list ( $data, $count, 0 );
}

function doc_list_messengkefuclot_search() {
	Global $printer;

	$tableName = f ( "table", "MessengKefuClot_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,clotid,pid,typename,picture,myid,youid,fcname,to_type,to_date,to_time,usertext,fontinfo" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	$msg = new Msg ();
	$result_file = $msg -> list_messengkefuclot_search($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengkefu()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,fcname,picture,chatid,to_type,to_date,to_time,usertext,fontinfo,isreceipt1,isreceipt2,isack1,isack2,isack3,isack4" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	$msg = new Msg ();
	if($myid){
		if($youid) $result_file = $msg -> list_kefumesseng3($point,$myid,$youid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		else{
			 //$msg -> sendKfMessage($myid, f ( "chater",""), get_lang("livechat_message2"));
			 $result_file = $msg -> list_kefumesseng1($point,$myid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		}
		 //doc_list_messengkefu_acks();
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$printer->out_list ( $data_file, $recordcount, 0 );
	}else{
		msg_ack();
		if((int)g("isOffline")){
			 $result_file = $msg -> list_kefumesseng6($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
			 $recordcount = $result_file["count"] ;
		}else{
			 $result_file = $msg -> list_kefumesseng2($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
			 $recordcount = -1 ;
		}
		//doc_list_messengkefu_acks();
		$data_file1 = $result_file["data_user"] ;
		$data_file2 = $result_file["data"] ;
		$printer->out_list1 ( $data_file1,$data_file2,$data_file3,$recordcount, 0 );
	}
}


function doc_list_messengkefu_one()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,fcname,chatid,to_type,to_date,to_time,usertext,fontinfo,isreceipt1,isreceipt2,isack1,isack2,isack3,isack4" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	$data = array ();
	$livechat = new LiveChat ();
	
	$user = array ();
	$user ["userid"] = $myid;
	$user = $livechat->GetUser ( $user );
	
	if(WELCOMETYPE&&ismobile()&&(!$user ["cookiehcid1"])){
		if(f ( "youid","")){
			$row = $livechat->GetChaterDetail (f ( "youid",""));
			if (count($row)){
				$data[0]['usertext'] = $row['welcome'];
				if($data[0]['usertext']) $printer->out_list ( $data, 1, 0 );
			}
		}
		if(g ( "typeid" )){
			$db = new DB();
			$sql = "select * from lv_chater_ro where TypeID=" . g ( "typeid" ) . "";
			$row = $db->executeDataRow($sql);
			if (count($row)){
				$data[0]['usertext'] = $row['welcome'];
				if($data[0]['usertext']) $printer->out_list ( $data, 1, 0 );
			}
		}
		$data[0]['usertext'] = WELCOMETEXT;
		if($data[0]['usertext']) $printer->out_list ( $data, 1, 0 );
	}
	$msg = new Msg ();
	if($myid){
	   //$msg -> sendKfMessage($myid, f ( "chater",""), get_lang("livechat_message2"));
	   $result_file = $msg -> list_kefumesseng4($point,$user ["cookiehcid1"],$myid,$youid,$tableName,$fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		 //doc_list_messengkefu_acks();
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$printer->out_list ( $data_file, $user ["cookiehcid1"], 0 );
	}
}

function doc_list_messengkefuclot_one()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefuClot_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,clotid,myid,youid,fcname,to_type,to_date,to_time,usertext,fontinfo" );
	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	$data = array ();
	$livechat = new LiveChat ();
	
	$user = array ();
	$user ["userid"] = $myid;
	$user = $livechat->GetUser ( $user );
	
	if(WELCOMETYPE&&ismobile()&&(!$user ["cookiehcid1"])){
		if(f ( "youid","")){
			$row = $livechat->GetChaterDetail (f ( "youid",""));
			if (count($row)){
				$data[0]['usertext'] = $row['welcome'];
				$printer->out_list ( $data, 1, 0 );
			}
		}
		if(g ( "typeid" )){
			$db = new DB();
			$sql = "select * from lv_chater_ro where TypeID=" . g ( "typeid" ) . "";
			$row = $db->executeDataRow($sql);
			if (count($row)){
				$data[0]['usertext'] = $row['welcome'];
				$printer->out_list ( $data, 1, 0 );
			}
		}
		$data[0]['usertext'] = WELCOMETEXT;
		$printer->out_list ( $data, 1, 0 );
	}
	$msg = new Msg ();
	if($myid){
	   $result_file = $msg -> list_messengkefuclot4($point,$tableName,$fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$printer->out_list ( $data_file, $user ["cookiehcid1"], 0 );
	}
}

function doc_list_messengkefu_chat()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,fcname,chatid,to_type,to_date,to_time,usertext,fontinfo,isreceipt1,isreceipt2,isack1,isack2,isack3,isack4" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	$msg = new Msg ();
	if($myid){
	   //$msg -> sendKfMessage($myid, f ( "chater",""), get_lang("livechat_message2"));
	   $result_file = $msg -> list_kefumesseng5($point,f ( "chatId",""),$myid,$youid,$tableName,$fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		 //doc_list_messengkefu_acks();
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$printer->out_list ( $data_file, $recordcount, 0 );
	}
}


function doc_list_messengkefu_history()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$lastTypeID = f ( "lastTypeID",0);
	$lastMsg_ID = f ( "lastMsg_ID", "" );
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,fcname,chatid,to_type,to_date,to_time,usertext,fontinfo,isreceipt1,isreceipt2,isack1,isack2,isack3,isack4" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID ASC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID ASC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 10 );
	
	$msg = new Msg ();
	if($lastMsg_ID){
	$sql = "select TypeID as c from MessengKefu_Text where Msg_ID='" . $lastMsg_ID . "'";
	$lastTypeID = $msg -> db -> executeDataValue($sql);
	}
	$result_file = $msg -> list_kmessengkefu_history($point,$myid,$youid,$lastTypeID,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengkefuclot_history()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	$lastTypeID = f ( "lastTypeID",0);
	$lastMsg_ID = f ( "lastMsg_ID", "" );
	$tableName = f ( "table", "MessengKefuClot_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,clotid,myid,youid,fcname,to_type,to_date,to_time,usertext,fontinfo" );
	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID ASC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID ASC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 10 );
	
	$msg = new Msg ();
	if($lastMsg_ID){
	$sql = "select TypeID as c from MessengKefuClot_Text where Msg_ID='" . $lastMsg_ID . "'";
	$lastTypeID = $msg -> db -> executeDataValue($sql);
	}
	$result_file = $msg -> list_kmessengkefuclot_history($point,$myid,$youid,$lastTypeID,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}


function doc_list_messengkefu_acks()
{
	Global $printer;

	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "TypeID,msg_id" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	
	$msg = new Msg ();
	$result_file = $msg -> list_kefumesseng_acks($point,$myid,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengkefu_getchaters()
{
	Global $printer;

	$myid = f ( "myid","");
	$tableName = f ( "table", "lv_chat" );
	$fldId = f ( "fldid", "ChatId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ChatId ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ChatId ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	
	$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='".$Chater."' and CONVERT(varchar(100), InTime, 23)='" . date("Y-m-d") . "'";
	$db = new DB();
	
	$msg = new Msg ();
	$sql = " select distinct Chater,bb.* from lv_chat as aa,lv_chater as bb where aa.UserId ='47230530123104' and aa.Chater =bb.LoginName";
	$data_user = $msg -> db -> executeDataTable($sql);

	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}

function doc_list_messengnotice()
{
	Global $printer;

	$tableName = f ( "table", "MessengNotice_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "typeid,msg_id,myid,youid,ntitle,ncontent,nlink,to_ip,to_date" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	//msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengnotice($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$printer->out_list ( $data_file, -1, 0 );
}

function doc_list_messengverify()
{
	Global $printer;

	$tableName = f ( "table", "MessengVerify_Type" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_messengverify($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["count"] ;
	$printer->out_list ( $data_file, $recordcount, 0 );
}


function doc_list_chat()
{
	Global $printer;

	$tableName = f ( "table", "Tab_Chat" );
	$fldId = f ( "fldid", "Ord" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "Ord ASC" );
			$fldSortdesc = f ( "fldsortdesc", "Ord DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "Ord ASC" );
			$fldSortdesc = f ( "fldsortdesc", "Ord DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_chat($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$printer->out_list ( $data_file, -1, 0 );
}

function doc_list_remote()
{
	Global $printer;

	$tableName = f ( "table", "remote_chat" );
	$fldId = f ( "fldid", "Ord" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "Ord ASC" );
			$fldSortdesc = f ( "fldsortdesc", "Ord DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "Ord ASC" );
			$fldSortdesc = f ( "fldsortdesc", "Ord DESC" );
			break;
	}
	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_remote($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file = $result_file["data"] ;
	$printer->out_list ( $data_file, -1, 0 );
}


function GetKefuMessage()
{
	Global $printer;

	$point = (int)g("point");
	$myid = g ( "myid" );
	$msg_id = g ( "msg_id" );

	$msg = new Msg ();
	$result = $msg -> list_kefumesseng_detail($point,$msg_id);
	
	if(g ( "youid" )){
		$db = new Model("lv_user");
		$db -> clearParam();
		$db -> addParamWhere("userid",g ( "youid" ));
		$detail =  $db -> getDetail() ;
		
		$sql_count = "select count(*) as c from lv_source where UserId='".g ( "youid" )."'";
		$visitcount = $msg->db -> executeDataValue($sql_count);
		
		if($detail ["usericoline"]) $result['usericoline']=$detail ["usericoline"];
		else $result['usericoline']=1;
		$result['visitcount']=$visitcount;
		//$result['isweixin']=$detail ["isweixin"];
		if($detail ["isweixin"]) $result['isweixin']=$detail ["isweixin"];
		else $result['isweixin']=0;
		$result['headimgurl']=$detail ["headimgurl"];
		
		$sql_form = "select * from lv_user_form where UserId='" . g ( "youid" ) . "' and To_Type=3 and MyID='".CurUser::getUserId()."'";
		$data1 = $msg -> db -> executeDataTable($sql_form) ;
		$result[$k]['user_form']=$printer->parseList ( $data1, 0 );
	}else{
		if($result['youid']!=$myid) $printer -> fail();
	}
	
	if($result['myid']==$myid) $ack_id = $point+1;
	else{
		 $ack_id = $point+3;
		 if($result['to_type']=="1") $sql = "IsReceipt1=1,IsReceipt2=1,";
	}
	$sql = "update MessengKefu_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $result['msg_id'] . "'" ;
	
	$msg->db->execute($sql);
	//msg_ack();

	$printer->out_arr ( $result );	
}

function RetractMessage()
{
	Global $printer;

	$bie = g ( "MessagesType" );
	$msgid = g ( "msgid" );

	$msg = new Msg ();
	$sqls = array();
	switch($bie)
	{
		case "0":
		    $sql = "select top 1 * from Messeng_Text where Msg_ID='" . $msgid . "'" ;
			$row = $msg -> db -> executeDataRow($sql);
			if (count($row)){
				if($row["to_type"]==5) $FormFileType="2";
				else $FormFileType="0";
				$sqls[] = "delete from Messeng_Text where Msg_ID='" . $msgid . "'" ;
				$sqls[] = "delete from LeaveFile where Msg_ID='" . $msgid . "'" ;
			}
			else $FormFileType="3";
			break ;
		case "1":
		    $sql = "select top 1 * from ClotFile where Msg_ID='" . $msgid . "'" ;
			$row = $msg -> db -> executeDataRow($sql);
			if (count($row)) $FormFileType="4";
			else $FormFileType="0";
			$sqls[] = "delete from MessengClot_Text where Msg_ID='" . $msgid . "'" ;
			$sqls[] = "delete from ClotFile where Msg_ID='" . $msgid . "'" ;
			break ;
		case "2":
		    $sqls[] = "delete from MessengKefu_Text where Msg_ID='" . $msgid . "'" ;
			$FormFileType="5";
			break ;
		case "5":
		    $sqls[] = "delete from MessengKefuClot_Text where Msg_ID='" . $msgid . "'" ;
			$FormFileType="6";
			break ;
	}
	$msg->db->execute($sqls);
	$printer ->out_arr(array('status' => 1,'msg' => $FormFileType));
	//$printer -> success($FormFileType);
}

function RetractallMessage()
{
	Global $printer;

	$bie = g ( "MessagesType" );
	$youid = f ( "youid","");
	$myid = f ( "myid","");

	$msg = new Msg ();
	$sqls = array();
	switch($bie)
	{
//		case "0":
//		    $sql = "select top 1 * from Messeng_Text where Msg_ID='" . $msgid . "'" ;
//			$row = $msg -> db -> executeDataRow($sql);
//			if (count($row)){
//				if($row["to_type"]==5) $FormFileType="2";
//				else $FormFileType="0";
//				$sqls[] = "delete from Messeng_Text where Msg_ID='" . $msgid . "'" ;
//				$sqls[] = "delete from LeaveFile where Msg_ID='" . $msgid . "'" ;
//			}
//			else $FormFileType="3";
//			break ;
//		case "1":
//		    $sql = "select top 1 * from ClotFile where Msg_ID='" . $msgid . "'" ;
//			$row = $msg -> db -> executeDataRow($sql);
//			if (count($row)) $FormFileType="4";
//			else $FormFileType="0";
//			$sqls[] = "delete from MessengClot_Text where Msg_ID='" . $msgid . "'" ;
//			$sqls[] = "delete from ClotFile where Msg_ID='" . $msgid . "'" ;
//			break ;
		case "2":
		    $sqls[] = "delete from MessengKefu_Text where (MyID='".$myid."' and YouID='".$youid."') or (YouID='".$myid."' and MyID='".$youid."')" ;
			$FormFileType="5";
			break ;
		case "5":
		    $sqls[] = "delete from MessengKefuClot_Text where ClotID='" . $youid . "'" ;
			$FormFileType="6";
			break ;
	}
	$msg->db->execute($sqls);
	$printer ->out_arr(array('status' => 1,'msg' => $FormFileType));
	//$printer -> success($FormFileType);
}

function GetKefuClotMessage()
{
	Global $printer;

	$point = (int)g("point");
	$myid = g ( "myid" );
	$msg_id = g ( "msg_id" );
	$append = "";
	
	$Msg_IDs1="";
	$Msg_IDs2="";

	$msg = new Msg ();
	$result = $msg -> list_kefuclotmesseng_detail($point,$msg_id);
	
	$sql = "select aa.TypeID,aa.PID,aa.TypeName,aa.Remark,cc.* from lv_chater_Clot_Ro as aa,lv_user as cc where aa.UserId=cc.UserId and aa.TypeID=".$result['clotid'];
	$detail = $msg -> db -> executeDataRow($sql);
	if(g ( "youid" )){
		$sql_count = "select count(*) as c from lv_source where UserId='".$detail ["userid"]."'";
		$visitcount = $msg->db -> executeDataValue($sql_count);
		
		//$result['typeid']=$detail ["typeid"];
		$result['typename']=$detail ["typename"];
		$result['remark']=$detail ["remark"];
		if($detail ["usericoline"]) $result['usericoline']=$detail ["usericoline"];
		else $result['usericoline']=1;
		$result['visitcount']=$visitcount;
		if($detail ["isweixin"]) $result['isweixin']=$detail ["isweixin"];
		else $result['isweixin']=0;
		$result['headimgurl']=$detail ["headimgurl"];
		$sql = "select * from lv_chater_Clot_Form where TypeID =".g ( "youid" );
		$data = $msg -> db -> executeDataTable($sql) ;
		$append = $printer->union ( $append, '"clot_form":[' . ($printer->parseList ( $data, 0 )) . ']' );
		
		$sql_form = "select * from lv_user_form where UserId='" . $detail ["typeid"] . "' and To_Type=6 and MyID='".CurUser::getUserId()."'";
		$data1 = $msg -> db -> executeDataTable($sql_form) ;
		$append = $printer->union ( $append, '"user_form":[' . ($printer->parseList ( $data1, 0 )) . ']' );
	}else{
		if(g ( "clotid" )){
			if($result['clotid']!=g ( "clotid" )) $printer -> fail();
		}
//	   $livechat = new LiveChat ();
//	   $result['pid']=$detail ["pid"];
//	   $row = $livechat->GetChaterRoDetail ($detail ["pid"]);
//	   $result['groupname']=$row['typename']."-群聊";
	}
	if($result['clotid']==$myid) $result['isread']=0;
	else $result['isread']=1;
	
//	if($result['myid']==$myid){
//		 $Msg_IDs1 .= "'".$result['msg_id']."',";
//	}else{
//		 $Msg_IDs2 .= "'".$result['msg_id']."',";
//		 if($result['to_type']=="1") $sql = "update lv_chater_KefuMsg_Acks set IsReceipt1=1,IsReceipt2=1 where Msg_ID='" .  $result['msg_id'] . "' and YouID='".$myid."'" ;
//	}
//	
//	if($Msg_IDs1){
//		$ack_id = $point+1;
//		$Msg_IDs1=substr($Msg_IDs1, 0, -1);
//		$sql = " select max(TypeID) as c,ClotID from MessengKefuClot_Text where Msg_ID in (" . $Msg_IDs1 . ") group by ClotID";
//		$data_user = $msg -> db -> executeDataTable($sql);
//		foreach($data_user as $k=>$v){
//			$arr_sql[] = "update lv_chater_Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where TypeID=".$data_user[$k]['clotid']." and UserID='".$myid."'" ;
//		}
//	}
//	if($Msg_IDs2){
//		$ack_id = $point+3;
//		$Msg_IDs2=substr($Msg_IDs2, 0, -1);
//		$sql = " select max(TypeID) as c,ClotID from MessengKefuClot_Text where Msg_ID in (" . $Msg_IDs2 . ") group by ClotID";
//		$data_user = $msg -> db -> executeDataTable($sql);
//		foreach($data_user as $k=>$v){
//			$arr_sql[] = "update lv_chater_Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where TypeID=".$data_user[$k]['clotid']." and UserID='".$myid."'" ;
//		}
//	}
//	$msg->db->execute($sql);
    $printer->out_detail ( $result, $append,0 );
	//$printer->out_arr ( $result );	
}

function setUserForm () {
	global $printer;
	$userId = g ( "userid");
	$typeId = g ( "typeid");
	$to_type = g ( "to_type");

	$db = new DB ();
	switch (g ( "oType")) {
	case 0 :
		$sql = "Delete from lv_user_form where UserId='".$userId."' and TypeID=".$typeId." and To_Type=".$to_type." and MyID='".CurUser::getUserId()."'" ;
		break;
	case 1 :
		$sql = "insert into lv_user_form(UserId,TypeID,To_Type,MyID) values('".$userId."',".$typeId.",".$to_type.",'".CurUser::getUserId()."')" ;
		break;	
	}
	
//	echo $sql;
//	exit();
	$db -> execute($sql) ;
	$printer->success ();
}

// 读取消息内容
function read() {
	Global $printer;
	
	$msgid = g ( "msgid" );
	$datapath = g ( "datapath" );
	
	$reader = new MsgReader ();
	$result = $reader->read ( $msgid, $datapath );
	$html = $reader->html;
	$printer->out_str ( $html );
}

// 转换消息内容成HTML
function btf2html() {
	Global $printer;
	
	$content = g ( "content" );
	$msgid = g ( "msgid" );
	$datapath = g ( "datapath" );
	
	$reader = new MsgReader ();
	$html = $reader->btf2html ( $content, $msgid, $datapath );
	
	$printer->out_str ( $html );
}

// 得到消息附件
function get_package() {
	Global $printer;
	
	$msgid = g ( "msgid" );
	$datapath = g ( "datapath" );
	
	$reader = new MsgReader ();
	$package_file = $reader->get_file_bymsg ( $msgid, $datapath );
	
	if ($package_file == "")
		$printer->fail ( "文件不存在" );
	else
		$printer->success ( $package_file );
}

function get_file() {
	Global $printer;
	
	$fileguid = g ( "fileguid" );
	
	$reader = new MsgReader ();
	$package_file = $reader->get_file_byguid ( $fileguid );
	
	if ($package_file == "")
		$printer->fail ( "文件不存在" );
	else
		$printer->success ( $package_file );
}
function get_file1() {
	Global $printer;
	$package_file = __ROOT__ . "/templets/xiazai/RTC.zip";
	if (!file_exist($package_file)){
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
	}
	$printer->success ();
}
function getimg() {
	$url = g ( "url" );
	$file_path = __ROOT__ . "/Data/" . $url;
	//$file_path = str_replace ( "/", "\\", $file_path );
	// $file_path = iconv_str($file_path,"utf-8","gbk");
	
	$file_type = substr ( $file_path, strrpos ( $file_path, "." ) + 1 );
	
//	echo $file_path;
//	exit();
	
	$file = fopen ( $file_path, "r" ); // 打开文件
	                               
	// 输出
	ob_clean ();
	Header ( "Content-type:image/" . $file_type );
	echo fread ( $file, filesize ( $file_path ) );
	
	fclose ( $file );
	exit ();
}

/**
 * 得到图片
 * @url
 * /public/msg_kf.html?op=getimg&url=20150925/{F7385860-05BD-4EC3-B813-A5EEA771EECA}.png-0D7A3327633211E5886B005056C00008
 * return  图片文件内容
 */
function getimg1() {
	
	$url = g ( "url" );
	//2015-08-31.1 jc get source folder 
	$file_path = RTC_CONSOLE . "/" . $url;
	
	//$file_path = str_replace ( "\\", "/", $url );
	// $file_path = iconv_str($file_path,"utf-8","gbk");
	
//	echo $file_path;
//	exit();
	
	$file_type = substr ( $file_path, strrpos ( $file_path, "." ) + 1 );
	
	$file = fopen ( $file_path, "r" ); // 打开文件
	                               
	// 输出
	ob_clean ();
	Header ( "Content-type:image/" . $file_type );
	echo fread ( $file, filesize ( $file_path ) );
	
	fclose ( $file );
	exit ();
}


function msg_ack() {
	Global $printer;
	
	$yid = g ( "YouID" );
	$bie = g ( "MessagesType" );
	$point = (int)g("point");
	
	if(CurUser::getLoginName()) $myid=CurUser::getLoginName();
	else $myid=g ( "myid" );
	
	$Msg_IDs1="";
	$Msg_IDs2="";
	$Msg_IDs3="";
	$Msg_IDs4="";
	
	$msg = new Msg ();
	
	$arr_sql = array();
//if($bie=="0"){	
	if(g("Msg_IDs1")){
	  $arr_id = explode(",",g("Msg_IDs1"));
	  foreach($arr_id as $id)
	  {
		  if ($id)
		  {
			  $arr_item = explode("_",$id);
			  $sql = "";
			  switch($arr_item[0])
			  {
				  case "1": case "3":
					  $ack_id = $point+1;
					  break ;
				  case "2":
					  $ack_id = $point+3;
					  $sql = "IsReceipt1=1,IsReceipt2=1,";
					  break ;
				  case "4":
					  $ack_id = $point+3;
					  break ;
			  }
			  $arr_sql[] = "update Messeng_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $arr_item[1] . "'" ;
		  }
	  }
	}
//}else{
	if(g("Msg_IDs2")){
	  unset($arr_id);
	  unset($arr_item);
	  $arr_id = explode(",",g("Msg_IDs2"));
	  foreach($arr_id as $id)
	  {
		  if ($id)
		  {
			  $arr_item = explode("_",$id);
			  switch($arr_item[0])
			  {
				  case "1": case "3":
					  $Msg_IDs1 .= "'".$arr_item[1]."',";
					  break ;
				  case "2":
					  $Msg_IDs2 .= "'".$arr_item[1]."',";
					  $arr_sql[] = "update Msg_Acks set IsReceipt1=1,IsReceipt2=1 where Msg_ID='" . $arr_item[1] . "' and YouID='".CurUser::getUserId()."'" ;
					  break ;
				  case "4":
					  $Msg_IDs2 .= "'".$arr_item[1]."',";
					  break ;
			  }
		  }
	  }
	}

	if(g("Msg_IDs3")){
	  unset($arr_id);
	  unset($arr_item);
	  $arr_id = explode(",",g("Msg_IDs3"));
	  foreach($arr_id as $id)
	  {
		  if ($id)
		  {
			  $arr_item = explode("_",$id);
			  $sql = "";
			  switch($arr_item[0])
			  {
				  case "1": case "3":
					  $ack_id = $point+1;
					  break ;
				  case "2":
					  $ack_id = $point+3;
					  $sql = "IsReceipt1=1,IsReceipt2=1,";
					  break ;
				  case "4":
					  $ack_id = $point+3;
					  break ;
			  }
			  $arr_sql[] = "update MessengKefu_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $arr_item[1] . "'" ;
		  }
	  }
	}
	
	if(g("Msg_IDs0")){
	  unset($arr_id);
	  unset($arr_item);
	  $arr_id = explode(",",g("Msg_IDs0"));
	  foreach($arr_id as $id)
	  {
		  if ($id)
		  {
			  $ack_id = $point+1;
			  $arr_sql[] = "update Notice_Acks set IsAck".$ack_id."=0 where Msg_ID='" . $id . "'" ;
		  }
	  }
	}
	
	if(g("Msg_IDs4")){
	  unset($arr_id);
	  unset($arr_item);
	  $arr_id = explode(",",g("Msg_IDs4"));
	  foreach($arr_id as $id)
	  {
		  if ($id)
		  {
			  $arr_item = explode("_",$id);
			  switch($arr_item[0])
			  {
				  case "1": case "3":
					  $Msg_IDs3 .= "'".$arr_item[1]."',";
					  break ;
				  case "2":
					  $Msg_IDs4 .= "'".$arr_item[1]."',";
					  $arr_sql[] = "update lv_chater_KefuMsg_Acks set IsReceipt1=1,IsReceipt2=1 where Msg_ID='" . $arr_item[1] . "' and YouID='".$myid."'" ;
					  break ;
				  case "4":
					  $Msg_IDs4 .= "'".$arr_item[1]."',";
					  break ;
			  }
		  }
	  }
	}
	
	if($Msg_IDs1){
		$ack_id = $point+1;
		$Msg_IDs1=substr($Msg_IDs1, 0, -1);
		$sql = " select max(TypeID) as c,ClotID from MessengClot_Text where Msg_ID in (" . $Msg_IDs1 . ") group by ClotID";
		$data_user = $msg -> db -> executeDataTable($sql);
		foreach($data_user as $k=>$v){
			$arr_sql[] = "update Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where UpperID='".$data_user[$k]['clotid']."' and UserID='".CurUser::getUserId()."'" ;
		}
	}
	if($Msg_IDs2){
		$ack_id = $point+3;
		$Msg_IDs2=substr($Msg_IDs2, 0, -1);
		$sql = " select max(TypeID) as c,ClotID from MessengClot_Text where Msg_ID in (" . $Msg_IDs2 . ") group by ClotID";
//			echo $sql;
//	exit();
		$data_user = $msg -> db -> executeDataTable($sql);
		foreach($data_user as $k=>$v){
			$arr_sql[] = "update Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where UpperID='".$data_user[$k]['clotid']."' and UserID='".CurUser::getUserId()."'" ;
		}
	}
	if($Msg_IDs3){
		$ack_id = $point+1;
		$Msg_IDs3=substr($Msg_IDs3, 0, -1);
		$sql = " select max(TypeID) as c,ClotID from MessengKefuClot_Text where Msg_ID in (" . $Msg_IDs3 . ") group by ClotID";
		$data_user = $msg -> db -> executeDataTable($sql);
		foreach($data_user as $k=>$v){
			$arr_sql[] = "update lv_chater_Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where TypeID=".$data_user[$k]['clotid']." and UserID='".$myid."'" ;
		}
	}
	if($Msg_IDs4){
		$ack_id = $point+3;
		$Msg_IDs4=substr($Msg_IDs4, 0, -1);
		$sql = " select max(TypeID) as c,ClotID from MessengKefuClot_Text where Msg_ID in (" . $Msg_IDs4 . ") group by ClotID";
		$data_user = $msg -> db -> executeDataTable($sql);
		foreach($data_user as $k=>$v){
			$arr_sql[] = "update lv_chater_Clot_Form set last_ack_typeid".$ack_id."=".$data_user[$k]['c']." where TypeID=".$data_user[$k]['clotid']." and UserID='".$myid."'" ;
		}
	}
//}
//echo var_dump($arr_sql);
//exit();
    $msg -> db -> execute($arr_sql);
//	echo var_dump($arr_sql);
//	exit();
//	$result = $msg -> db -> execute($arr_sql) > 0 ?1:0 ;
//	if ($result)
//		$printer -> success();
//	else
//		$printer -> fail("error");
}


function all_ack_status()
{
	Global $printer;


	$point = (int)g("point");

	$ispage = f ( "ispage", "0" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 100 );
	$arr_sql = array();

	msg_ack();
	$msg = new Msg ();
	$result_file = $msg -> list_status();
	$data_file1 = $result_file["data"] ;
	$msg = new Msg ();

	$tableName = f ( "table", "Messeng_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "msg_id,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$result_file = $msg -> list_messeng_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file2 = $result_file["data"] ;
	
	$tableName = f ( "table", "Msg_Acks" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "msg_id,clotid,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break;
	}
	$result_file = $msg -> list_messengclot_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file3 = $result_file["data"] ;
	
	$myid = f ( "myid","");
	$tableName = f ( "table", "MessengKefu_Text" );
	$fldId = f ( "fldid", "TypeID" );
	$fldList = f ( "fldlist", "msg_id,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "TypeID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "TypeID DESC" );
			break;
	}
	$result_file = $msg -> list_kefumesseng_acks($point,$myid,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file4 = $result_file["data"] ;
	
	$tableName = f ( "table", "lv_chater_KefuMsg_Acks" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "msg_id,clotid,youid" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ID ASC" );
			$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
			break;
	}
	$result_file = $msg -> list_messengkefuclot_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
	$data_file5 = $result_file["data"] ;
	
	$printer->out_list4 ( $data_file1,$data_file2,$data_file3,$data_file4,$data_file5,-1, 0 );
}


?>