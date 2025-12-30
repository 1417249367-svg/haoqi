<?php  require_once("../class/fun.php");?>
<?php  require_once('../class/im/Msg.class.php');?>
<?php  require_once('../class/im/wx.class.php');?>
<?php  require_once('../class/im/wxjssdk.class.php');?>
<?php  require_once('../class/lv/LiveChat.class.php') ; ?>
<?php  require_once('../class/hs/EmpXML.class.php');?>
<?php  require_once('../class/hs/EmpRelation.class.php');?>
<?php  require_once('../class/common/visitorInfo.class.php');?>
<?php  require_once('../class/common/keyword.class.php');?>
<?php
// -------------------------------------------------------------------
// 1 应答模式
// 2 直接接入查式
// 3 自动分配模式
// -------------------------------------------------------------------
//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))&&g ( "source" )=='kefu'){
//
//}else{
////header("Access-Control-Allow-Origin: *");
////header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
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
	case "setdefaultvalue" :
		setDefaultValue ();
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
	case "listevaluate" :
		ListEvaluate ();
		break;
	case "listchatro" :
		ListChatRo ();
		break;
	case "listchat" :
		ListChat ();
		break;
	case "listchat1" :
		ListChat1 ();
		break;
	case "listchat2" :
		ListChat2 ();
		break;
	case "listchater" :
		ListChater ();
		break;
	case "chaterdetail" :
		ChaterDetail ();
		break;
	case "chaterrodetail" :
		ChaterRoDetail ();
		break;
	case "getchater" :
		GetChater ();
		break;
	case "transfer" :
		Transfer (g ("Chater"));
		break;
	case "transfer1" :
		Transfer1 ();
		break;
	case "listonlinechater" :
		ListOnlineChater ();
		break;
	case "listonlinechater1" :
		ListOnlineChater1 ();
		break;
	case "listonlinechater2" :
		ListOnlineChater2 ();
		break;
	case "listonlinechater3" :
		ListOnlineChater3 ();
		break;
	case "searchonlinechater" :
		SearchOnlineChater ();
		break;
	case "listwebuser" :
		loadWebUser ();
		break;
	case "listuser" :
		loadUser ();
		break;
	case "listclotform" :
		loadClotForm ();
		break;
//	case "getmsgacksmember" :
//		getMsgAcksMember ();
//		break;
	case "getrelationuser" :
		getRelationUser ();
		break;
	case "getrelationuser2" :
		getRelationUser2 ();
		break;
	case "setrelationuser3" :
		setRelationUser3 ();
		break;
	case "setrelationuser6" :
		setRelationUser6 ();
		break;
	case "getchaterro" :
		GetChaterRo ();
		break;
	case "connectchat" :
		ConnectChat ();
		break;
	case "connectchat1" :
		ConnectChat1 ();
		break;
	case "connectchat2" :
		ConnectChat2 ();
		break;
	case "initinvite" :
		initInvite ();
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
	case "connectsource" :
		ConnectSource ();
		break;
	case "closesource" :
		CloseSource ();
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
		
	case "questiondetail" :
		QuestionDetail ();
		break;
		
	case "sourcedetail" :
		SourceDetail ();
		break;
		
	case "listtrack" :
		ListTrack ();
		break;
		
	case "listtrack1" :
		ListTrack1 ();
		break;
		
	case "userdetail" :
		UserDetail ();
		break;

	case "userdetail1" :
		UserDetail1 ();
		break;
		
	case "userdetail2" :
		UserDetail2 ();
		break;
		
	case "saveuserdetail" :
		SaveUserDetail ();
		break;
		

	case "evaluatedetail" :
		EvaluateDetail ();
		break;
		
	case "listro" :
		listRo ();
		break;
			
	case "userform" :
		UserForm ();
		break;

	case "setuserform" :
		setUserForm ();
		break;
	case "lvchaterrodetail" :
		LvChaterRoDetail ();
		break;
		
	case "wxsignature" :
		wxsignature ();
		break;	
		
	case "getcode" :
		getcode ();
		break;	
		
	case "deleteuser" :
		deleteUser ();
		break;
		
	case "listclot_ro" :
		ListClot_Ro ();
		break;
	case "get_usericoline":
		get_usericoline();
		break ;
	case "clearhistory":
		clearhistory();
		break ;
	default :
		//Response . Write ( GetAppUrl () );
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

function setDefaultValue() {
	Global $printer;
	
	$tableName = f ( "table" );
	$fldId = f ( "fldid", "userid" );
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new Model ( $tableName, $fldId );
	$result = $db->setDefaultRole ( $id, $fldname, $fldvalue );
	
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

function getRelationUser2() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;

	$relation = new EmpRelation ();

	$data = $relation->getRelationData2 ( $parentEmpType, $parentEmpId, $childEmpType );

	$printer->out_list ( $data, -1, 0 );
}

function getList() {
	Global $printer;

	$tableName = f ( "table", "lv_link" );
	$fldId = f ( "fldid", "linkid" );
	$fldList = f ( "fldlist", "*" );

	$label = g("label");
	if ($label == "listvisitor")
	{
		ListVisitor();
		return ;
	}
	
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
	if($tableName=="lv_link"||$tableName=="lv_question"||$tableName=="lv_quicktalk"){
		$lvdb = new DB();
		foreach($data as $k=>$v){
			$sql = "select * from lv_chater where userid=" . $data[$k]['chater'] . "";
			$row = $lvdb->executeDataRow($sql);
			$data[$k]['username'] = $row['username'];
		}
	}
	if($tableName=="lv_message"){
		$lvdb = new DB();
		foreach($data as $k=>$v){
			if($data[$k]['groupid']){
				$sql = "select * from lv_chater_ro where TypeID=" . $data[$k]['groupid'] . "";
				$row = $lvdb->executeDataRow($sql);
				if(empty($row['typename'])) $data[$k]['typename'] = get_lang("livechat_message14");
				else $data[$k]['typename'] = $row['typename'];
			}else if($data[$k]['chater']){
				$data[$k]['typename'] = $data[$k]['chater'];
			}else $data[$k]['typename'] = get_lang("livechat_message15");
		}
	}
	if($tableName=="Clot_Silence"){
		$lvdb = new DB();
		foreach($data as $k=>$v){
			$sql = "select * from Users_ID where UserID='" . $data[$k]['myid'] . "'";
			$row = $lvdb->executeDataRow($sql);
			$data[$k]['username'] = $row['username'];
//			if((int)$data[$k]['to_type']==3){
			$sql = "select * from lv_user where UserId='" . $data[$k]['youid'] . "'";
			$row = $lvdb->executeDataRow($sql);
			$data[$k]['uname'] = $row['username'];
			$data[$k]['phone'] = $row['phone'];
//			}else{
//			$sql = "select cc.* from lv_chater_Clot_Ro as aa,lv_user as cc where aa.UserId=cc.UserId and aa.TypeID=".$data[$k]['youid'];
//			$row = $lvdb->executeDataRow($sql);
//			$data[$k]['youid'] = $row['userid'];
//			$data[$k]['uname'] = $row['username'];
//			$data[$k]['phone'] = $row['phone'];
//			}
		}
	}
	if($tableName=="lv_chat"){
		$lvdb = new DB();
		foreach($data as $k=>$v){
			$sql = "select * from Users_ID where UserName='" . $data[$k]['chater'] . "'";
			$row = $lvdb->executeDataRow($sql);
			$data[$k]['myid'] = $row['userid'];
		}
		foreach($data as $k=>$v){
			$sql = "select * from lv_chater_ro where TypeID=" . $data[$k]['groupid'] . "";
			$row = $lvdb->executeDataRow($sql);
			if(empty($row['typename'])) $data[$k]['grouptypename'] = get_lang("livechat_message14");
			else $data[$k]['grouptypename'] = $row['typename'];
		}
		foreach($data as $k=>$v){
			$sql = "select * from lv_chater_theme where TypeID=" . $data[$k]['themeid'] . "";
			$row = $lvdb->executeDataRow($sql);
			if(empty($row['typename'])) $data[$k]['themetypename'] = get_lang("livechat_message11");
			else $data[$k]['themetypename'] = $row['typename'];
		}
		foreach($data as $k=>$v){
			$inoutnum=0;
			$inouttimes=0;
			$first_inouttime=0;
			$intime=$data[$k]['intime'];
			$myid=$data[$k]['userid'];
			$sql = " select * from MessengKefu_Text where To_Type=1 and ChatId=" . $data[$k]['chatid'];
			$data_file = $lvdb->executeDataTable($sql) ;
//			echo $sql;
//			echo var_dump($data_file);
//			exit();
			foreach($data_file as $m=>$n){
				if($data_file[$m]['myid']!=$myid){
					 $myid=$data_file[$m]['myid'];
					  if($data_file[$m]['myid']==$data[$k]['chater']){
						  $inoutnum++;
						  $inouttimes+=strtotime($data_file[$m]['to_date'])-strtotime($intime);
						  //echo strtotime($data_file[$k]['to_date']).' '.strtotime($intime);
						  if($inoutnum==1) $first_inouttime=$inouttimes;
					  }else{
						  $intime=$data_file[$m]['to_date'];
					  }
				}
			}
			if($data[$k]['outtime']) $outtime=$data[$k]['outtime'];
			else $outtime=getNowTime();
			if($inoutnum>0) $inouttime=$inouttimes/$inoutnum;
			else $inouttime=strtotime($outtime)-strtotime($data[$k]['intime']);
			if(!$first_inouttime) $first_inouttime=strtotime($outtime)-strtotime($data[$k]['intime']);
			$data[$k]['first_inouttime'] = $first_inouttime;
			$data[$k]['inouttime'] = $inouttime;
			$data[$k]['chat_time'] = strtotime($outtime)-strtotime($data[$k]['intime']);
		}
	}
	$printer->out_list ( $data, $count, 0 );
}

function detail() {
	Global $printer;

	$tableName = f ( "table", "OtherForm" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "*" );
	$label = g("label");
	
	if ($label == "lv_user")
	{
		lv_user_detail();
		return ;
	}
	
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

function lv_user_detail() {
	Global $printer;

	$tableName = f ( "table", "OtherForm" );
	$fldId = f ( "fldid", "ID" );
	$fldList = f ( "fldlist", "*" );
	
	$group = new Model ( $tableName, $fldId );
	$groupId = f ( "id" );
	$group->field ( $fldList );
	$group->addParamWhere($fldId,$groupId) ;
	$row_group = $group->getDetail ();

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
	
	if ($label == "lv_user")
	{
		save_lv_user();
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
	
	if(f ( "mobile" )){
        $db = new Model("Users_ID");
        $db -> addParamField("Tel1", f ( "mobile" ));
		$db -> addParamWhere("UserName", $loginname);
		$db -> update();
	}

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else
		$printer->success ( "id:" . $result ["id"] );
}

function save_lv_user() 
{
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );
	$loginname = f ( "loginname" );
	
	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSave ( $op, $fldId, $fields, $keyfields, $flitersql );


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

function setRelationUser6() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;
	$childEmpId = g ( "userid" );
	$flag = g ( "flag", 1 );

	$relation = new EmpRelation ();
	$relation->setRelation6 ( 0, $parentEmpType, $parentEmpId, "", $childEmpType, $childEmpId, $flag );
	
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
function ListEvaluate() {
	Global $printer;

	$tableName = f ( "table", "lv_chat" );
	$fldId = f ( "fldid", "ChatId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ChatLevel desc,ChatId desc" );
			$fldSortdesc = f ( "fldsortdesc", "ChatLevel asc,ChatId asc" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ChatLevel asc,ChatId desc" );
			$fldSortdesc = f ( "fldsortdesc", "ChatLevel desc,ChatId asc" );
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
		$data_user = $db->getList ();
	else
		$data_user = $db->getPage ( $pageIndex, $pageSize, $count );
		
	foreach($data_user as $k=>$v){
		$sql = "select * from lv_user where UserId='".$data_user[$k]['userid']."'";
		$db = new DB();
		$lv_user_detail = $db -> executeDataRow($sql) ;
		if(empty($lv_user_detail["username"])) $data_user[$k]['username']=$lv_user_detail["area"];
		else $data_user[$k]['username']=$lv_user_detail["username"];
		if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
		$data_user[$k]['area']=$lv_user_detail["area"];
	}
		
	$printer->out_list ( $data_user, $count, 0 );
}

function ListChatRo() {
	global $printer;
	$where = stripslashes(f ( "wheresql", "" ));
	switch (g ( "drp_type")) {
	case 0 :
		$sql = "select count(distinct UserId) as groupcount,groupid,Chater as uid from lv_chat ".$where ;
		break;
	case 1 :
		$sql = "select count(distinct UserId) as groupcount,groupid,themeid as uid from lv_chat ".$where ;
		break;	
	case 2 :
		$sql = "select count(distinct UserId) as groupcount,groupid,chatlevel as uid from lv_chat ".$where ;
		break;	
	}

	$db = new DB();
	$sql_count = "select count(distinct UserId) as c from lv_chat";
	$totalcount = $db -> executeDataValue($sql_count);
	$data_user = $db -> executeDataTable($sql) ;
	
	foreach($data_user as $k=>$v){
		switch (g ( "drp_type")) {
		case 0 :
			$sql = "select * from lv_chater where LoginName='" . $data_user[$k]['uid'] . "'";
			$row = $db->executeDataRow($sql);
			$data_user[$k]['username'] = $row['username'];
			$sql = "select * from lv_chat where groupid=".$data_user[$k]['groupid']." and Chater='".$data_user[$k]['uid']."'" ;
			$data = $db -> executeDataTable($sql) ;
			break;
		case 1 :
			$sql = "select * from lv_chater_theme where TypeID=" . $data_user[$k]['uid'] . "";
			$row = $db->executeDataRow($sql);
			if(empty($row['typename'])) $data_user[$k]['username']=get_lang('livechat_message11');
			else $data_user[$k]['username']=$row['typename'];
			$sql = "select * from lv_chat where groupid=".$data_user[$k]['groupid']." and themeid=".$data_user[$k]['uid'] ;
			$data = $db -> executeDataTable($sql) ;
			break;	
		case 2 :
			switch($data_user[$k]['uid'])
			{
				case "0":
					$data_user[$k]['username'] = get_lang("livechat_message11");
					break ;
				case "1":
					$data_user[$k]['username'] = get_lang("livechat_message12");
					break ;
				case "2":
					$data_user[$k]['username'] = get_lang("livechat_message13");
					break ;
			}
			$sql = "select * from lv_chat where groupid=".$data_user[$k]['groupid']." and chatlevel=".$data_user[$k]['uid'] ;
			$data = $db -> executeDataTable($sql) ;
			break;	
		}
		
		$all_first_inouttime=0;
		$all_inouttime=0;
		$all_chat_time=0;
		$all_rate=0;
		$enable_inoutnum=0;
		$chat_timenum=0;
		$ratenum=0;
		foreach($data as $o=>$p){
//			$inoutnum=0;
//			$inouttimes=0;
//			$first_inouttime=0;
//			$intime=$data[$o]['intime'];
//			$myid=$data[$o]['userid'];
//			$sql = " select * from MessengKefu_Text where To_Type=1 and ChatId=" . $data[$o]['chatid'];
//			$data_file = $db->executeDataTable($sql) ;
//			foreach($data_file as $m=>$n){
//				if($data_file[$m]['myid']!=$myid){
//					 $myid=$data_file[$m]['myid'];
//					  if($data_file[$m]['myid']==$data[$o]['chater']){
//						  $inoutnum++;
//						  $inouttimes+=strtotime($data_file[$m]['to_date'])-strtotime($intime);
//						  if($inoutnum==1) $first_inouttime=$inouttimes;
//					  }else{
//						  $intime=$data_file[$m]['to_date'];
//					  }
//				}
//			}
//			if($inoutnum>0){
//				 $enable_inoutnum++;
//				 $inouttime=$inouttimes/$inoutnum;
//			}else{
//				 $inouttime=0;
//			}
//			$all_first_inouttime += $first_inouttime;
//			$all_inouttime += $inouttime;
//			if($data[$o]['outtime']){
//				$chat_timenum++;
//				$all_chat_time += (strtotime($data[$o]['outtime'])-strtotime($data[$o]['intime']));
//			}
			if($data[$o]['rate']>0){
				$ratenum++;
				$all_rate += $data[$o]['rate'];
			}
		}
//		if($enable_inoutnum){
//			$data_user[$k]['first_inouttime'] = $all_first_inouttime/$enable_inoutnum;
//			$data_user[$k]['inouttime'] = $all_inouttime/$enable_inoutnum;
//		}else{
//			$data_user[$k]['first_inouttime'] = 0;
//			$data_user[$k]['inouttime'] = 0;	
//		}
//		if($chat_timenum) $data_user[$k]['chat_time'] = $all_chat_time/$chat_timenum;
//		else $data_user[$k]['chat_time'] = 0;
		if($ratenum) $data_user[$k]['rate'] = round($all_rate/$ratenum,2);
		else $data_user[$k]['rate'] = 0;
//		$data_user[$k]['enable_inoutnum'] = $enable_inoutnum;
		
		$sql = "select * from lv_chater_ro where TypeID='".$data_user[$k]['groupid']."'";
		$detail = $db -> executeDataRow($sql) ;
		

		
		if(empty($detail ["typename"])) $data_user[$k]['typename']=get_lang('livechat_message14');
		else $data_user[$k]['typename']=$detail ["typename"];
		$data_user[$k]['totalcount']=$totalcount;
	}
	
	$printer->out_list($data_user,-1,0);
}

// 列出客服人员
function ListChat() {
	Global $printer;
	$keyword = new keyword();

	$tableName = f ( "table", "lv_chat" );
	$fldId = f ( "fldid", "ChatId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "ChatId desc" );
			$fldSortdesc = f ( "fldsortdesc", "ChatId asc" );
			break ;
		default:
			$fldSort = f ( "fldsort", "ChatId desc" );
			$fldSortdesc = f ( "fldsortdesc", "ChatId asc" );
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
		$data_user = $db->getList ();
	else
		$data_user = $db->getPage ( $pageIndex, $pageSize, $count );
		
	foreach($data_user as $k=>$v){	
		$sql = "select top 1 * from lv_source where UserId='".$data_user[$k]['userid']."' order by SourceId desc";
		$db = new DB();
		$detail = $db -> executeDataRow($sql) ;
		
		$sql = "select * from lv_user where UserId='".$data_user[$k]['userid']."'";
		$db = new DB();
		$lv_user_detail = $db -> executeDataRow($sql) ;
		if(empty($lv_user_detail["username"])) $data_user[$k]['username']=$lv_user_detail["area"];
		else $data_user[$k]['username']=$lv_user_detail["username"];
		if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
		
		$sql = "select * from lv_chater where LoginName='".$data_user[$k]['chater']."'";
		$db = new DB();
		$lv_chater_detail = $db -> executeDataRow($sql) ;
		$data_user[$k]['fcname']=$lv_chater_detail ["username"];
		
		$sql = "select top 1 myid,youid,to_type from MessengKefu_Text where ChatId='".$data_user[$k]['chatid']."' order by TypeID desc";
		$db = new DB();
		$lv_messeng_detail = $db -> executeDataRow($sql) ;
		$data_user[$k]['myid']=$lv_messeng_detail ["myid"];
		$data_user[$k]['youid']=$lv_messeng_detail ["youid"];
		$data_user[$k]['to_type']=$lv_messeng_detail ["to_type"];
		
		$sql_count = "select count(*) as c from lv_source where UserId='".$data_user[$k]['userid']."'";
		$visitcount = $db -> executeDataValue($sql_count);
		$data_user[$k]['launchurl']=$detail ["launchurl"];
		$data_user[$k]['sourceid']=$detail ["sourceid"];
		$data_user[$k]['area']=$detail ["area"];
		$data_user[$k]['channel']=$keyword->getChannel($detail ["sourceurl"]);
		if(!$data_user[$k]['channel']) $data_user[$k]['channel']='-';
		//$data_user[$k]['intime']=$detail ["intime"];
		$data_user[$k]['visitcount']=$visitcount;
	}
		
	$printer->out_list ( $data_user, $count, 0 );
}

function ListChat1() {
	global $printer;
	
	$keyword = new keyword();
	$livechat = new LiveChat ();
	
	$arr_id = explode(",",g("UserIds"));
	$data_file1 = array ();
	foreach($arr_id as $id)
	{
		if ($id)
		{
			$sql = "select top 1 * from lv_chat where UserId ='".$id."' order by ChatId desc";
			$db = new DB();
			$detail = $db -> executeDataRow($sql) ;
			if($detail ["status"]=='2') array_push($data_file1,array("doc_id"=> $id));
		}
	}
	$db = new Model("lv_chat");
	$db -> addParamWhere("Chater", g("loginname"));
	$db -> addParamWhere("status", CHAT_STATUS_WAIT, "=", "int");
	$data_user = $db -> getList();
	foreach($data_user as $k=>$v){
		if(in_array($data_user[$k]['userid'], $arr_id)){
			 unset($data_user[$k]);
			 continue;
		}
		$user ["userid"] = $data_user[$k]['userid'];
		$userdetail = $livechat->GetUser ( $user );
		
		$sql = "select top 1 * from lv_chat as aa,lv_chater_theme as bb where aa.UserId='".$data_user[$k]['userid']."' and aa.Status=2 and aa.ThemeId=bb.TypeID order by aa.ChatId desc";
		$db = new DB();
		$theme_detail = $db -> executeDataRow($sql) ;
		
		$sql = "select top 1 * from lv_source where UserId='".$data_user[$k]['userid']."' order by SourceId desc";
		$db = new DB();
		$detail = $db -> executeDataRow($sql) ;
		
		$sql_count = "select count(*) as c from lv_source where UserId='".$data_user[$k]['userid']."'";
		$visitcount = $db -> executeDataValue($sql_count);
		
		if(empty($userdetail["username"])) $data_user[$k]['username']=$userdetail["area"];
		else $data_user[$k]['username']=$userdetail["username"];
		if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
		$data_user[$k]['usericoline']=$userdetail ["usericoline"];
		$data_user[$k]['isweixin']=$userdetail ["isweixin"];
		$data_user[$k]['headimgurl']=$userdetail ["headimgurl"];
		$data_user[$k]['sourceid']=$detail ["sourceid"];
		$data_user[$k]['sourceurl']=$detail ["sourceurl"];
		$data_user[$k]['launchurl']=$detail ["launchurl"];
		$data_user[$k]['area']=$detail ["area"];
		$data_user[$k]['channel']=$keyword->getChannel($detail ["sourceurl"]);
		if(!$data_user[$k]['channel']) $data_user[$k]['channel']='-';
		$data_user[$k]['browser']=$detail ["browser"];
		$data_user[$k]['ip']=$detail ["ip"];
		$data_user[$k]['intime']=$detail ["intime"];
		$data_user[$k]['visitcount']=$visitcount;
		if(empty($theme_detail["typename"])) $data_user[$k]['typename']=get_lang("livechat_message11");
		else $data_user[$k]['typename']=$theme_detail["typename"];
		
		$sql_form = "select * from lv_user_form where UserId='" . $data_user[$k]['userid'] . "' and To_Type=3 and MyID='".CurUser::getUserId()."'";
		$data1 = $db -> executeDataTable($sql_form) ;
		$data_user[$k]['user_form']=$printer->parseList ( $data1, 0 );
	}
	$printer->out_list1 ($data_file1,$data_user,$data_file3,-1, 0 );
	//$printer->out(1, $UserIds );
}

function ListChat2() {
	global $printer;
	
	$keyword = new keyword();
	$livechat = new LiveChat ();
	
	$arr_id = explode(",",g("UserIds"));
	$data_file1 = array ();
	foreach($arr_id as $id)
	{
		if ($id)
		{
			$sql = "select top 1 * from lv_chat where ChatId =".$id;
			$db = new DB();
			$detail = $db -> executeDataRow($sql) ;
			if($detail ["chater"]!=g("loginname")) array_push($data_file1,array("doc_id"=> $detail ["userid"]));
		}
	}
	$printer->out_list1 ($data_file1,$data_user,$data_file3,-1, 0 );
	//$printer->out(1, $UserIds );
}

// 列出客服人员
function ListChater() {
	global $printer;
	
	$db = new Model ( "lv_chater" );
	$data = $db->getList ();
	
	$printer->out_list($data,-1,0);
}

function loadClotForm() {
	global $printer;
	
	$db = new Model ("lv_chater_Clot_Form");
	$db->where ("where TypeID=" . g("typeid") . " and UserID<>'" . g("UserID") . "'");
	$data = $db-> getList();
 
	$printer->out_list($data,-1,0);
}

function ListOnlineChater() {
	global $printer;
	
	$livechat = new LiveChat ();
	$data = $livechat->ListOnlineChater ();

	$printer->out_list($data,-1,0);
}

function ListOnlineChater1() {
	global $printer;
	
	if(g ( "UserIcoLine" )!="") $sql_view = " and bb.UserIcoLine=".g ( "UserIcoLine" ) ;
	$db = new DB();
	$sql = "select aa.*,bb.UserID,bb.UserIco,bb.UserIcoLine,bb.NetworkIP,bb.LoginTime from lv_chater as aa,Users_ID as bb where aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName".$sql_view." order by bb.UserIcoLine desc";
	$data_user = $db -> executeDataTable($sql) ;
	
	foreach($data_user as $k=>$v){
		$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='" . $data_user[$k]['loginname'] . "' and Status=1";
		$count = $db -> executeDataValue($sql_count);
		$data_user[$k]['chatcount']=$count;
		$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='" . $data_user[$k]['loginname'] . "'";
		$count = $db -> executeDataValue($sql_count);
		$data_user[$k]['receptioncount']=$count;
	}

	$printer->out_list($data_user,-1,0);
}

function ListOnlineChater2() {
	global $printer;
	
	$db = new DB();
	$sql = "select aa.*,bb.UserID,bb.UserIco,bb.UserIcoLine,bb.NetworkIP,bb.LoginTime,bb.ExpireTime from lv_chater as aa,Users_ID as bb where aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and aa.LoginName='".g ( "chater" )."' order by bb.UserIcoLine desc";
	$row = $db -> executeDataRow($sql) ;
	
	$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='" . g ( "chater" ) . "' and Status=1 and CONVERT(varchar(100), InTime, 23)='" . date("Y-m-d") . "'";
	$count = $db -> executeDataValue($sql_count);
	$row['chatcount']=$count;
	$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='" . g ( "chater" ) . "' and CONVERT(varchar(100), InTime, 23)='" . date("Y-m-d") . "'";
	$count = $db -> executeDataValue($sql_count);
	$row['receptioncount']=$count;
	$printer->out_arr ( $row );
}

function ListOnlineChater3() {
	global $printer;
	
	if(!FREETYPE) $printer -> fail();
	$livechat = new LiveChat ();
	$data = $livechat->ListOnlineChater ();

	shuffle($data);
	Transfer ($data[0]['loginname']);
	//$randomElement = $data[0];
	//$printer -> out_arr($data[0]);

	//$printer->out_list($data,-1,0);
}

function SearchOnlineChater() {
	global $printer;
	
	$livechat = new LiveChat ();
	$data = $livechat->SearchOnlineChater ();

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

function GetChater () {
	global $printer;

	$livechat = new LiveChat ();
	$data = $livechat->GetChater ();
	
	$printer -> out_list($data,-1,0);
}

function ChaterDetail () {
	global $printer;
	$Chater = g ("Chater");
	
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterDetail ($Chater);
	
	$printer->out_arr ( $data );
}

function ChaterRoDetail () {
	global $printer;
	$Chater = g ("Chater");
	$typeid = g ("typeid");
	
	$livechat = new LiveChat ();
	if($Chater){
		$data = $livechat->GetChaterDetail ($Chater);
	}elseif($typeid){
		$data = $livechat->GetChaterRoDetail ($typeid);
	}else{
		$data = $livechat->GetChaterRo ();
		if (count($data)) $printer->success ();
		else{
			$db = new DB();
			$sql = "select aa.LoginName from lv_chater as aa,Users_ID as bb where aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";
			$data = $db -> executeDataTable($sql);
			if (count($data)) $printer->success ();
		}
	}
	
	$printer->out_arr ( $data );
}

function Transfer ($Chater) {
	global $printer;
	$chatId = g ("chatid");
	//$Chater = g ("Chater");
	$youid = g ( "youid" );
	$myid = g ( "myid" );
	$To_Type = g ( "To_Type",1 );
	
	$db = new Model("lv_chat");
	$db -> addParamField("Chater", $Chater);
	$db -> addParamWhere("ChatId", $chatId);
	$db -> update();

	
	$db = new Model ( "lv_transfer" );
	$db->addParamField ( "ChatId", $chatId );
	$db->addParamField ( "MyID", $myid );
	$db->addParamField ( "YouID", $youid );
	$db->addParamField ( "Chater", $Chater );
	$db->addParamField ( "To_Type", $To_Type );
	$db->insert ();
	
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterDetail ($Chater);
	$content = str_replace("{name}",$data ["username"],date("G:i:s").get_lang("livechat_message5"));
	$livechat -> SendKefuMessage($chatId,$youid,$Chater,$data ["username"],3,$content,0,$Chater,$data ["picture"]);
	$livechat -> SendKefuMessage($chatId,$Chater,$youid,$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),1,$Chater,$data ["picture"]);
	if($data ["welcome"]){
		$db = new Model("lv_chat");
		$db -> addParamWhere("Chater", $Chater);
		$db -> addParamWhere("UserId", $youid);
		$db -> addParamWhere("Status", 2);
		$row = $db -> getDetail();
		$issend = $livechat->Getissend ( $Chater );
		if (count($row)==0||$issend==1){
			$arr_welcome = explode("<hr />",$data ["welcome"]);
			foreach($arr_welcome as $welcome)
			{
				if($welcome) $livechat -> SendKefuMessage($chatId,$Chater,$youid,$data ["username"],1,phpescape($welcome),1,$Chater,$data ["picture"]);
			}
		} 
	}
	
	if($To_Type==1){
		$msg = new Msg ();
		$msg -> sendKfMessage($youid, $Chater, $content,0);
	}
	
	$printer->out_arr ( $data );
}

function Transfer1 () {
	global $printer;
	
	switch ((int)g ("cookieHCID5")) {
		case 1 :
			$cookieHCID5=0;
			$defaultreception=2;
			break;
		default:
			$cookieHCID5=1;
			$defaultreception=1;
			break;
	}
	
	$db = new Model("lv_user_reception");
	$db -> clearParam();
	$db -> addParamField("defaultreception",$defaultreception);
	$db -> addParamWhere("myid", g ("myid"));
	$db -> addParamWhere("youid", g ("youid"));
	$db -> addParamWhere("to_type", g ("lv_chater_ro_to_type"));
	$result = $db->update();

	$printer -> out_msg(1,$cookieHCID5);
}


function GetChaterRo() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	
	$data = $livechat->GetChaterRo ();
	foreach($data as $k=>$v){
		array_push($user,array("username"=> $data[$k]['typename'],"id"=> $data[$k]['typeid'],"avatar"=> "assets/img/default.png","sign"=> $data[$k]['description']));
	}
//	echo json_encode($user,JSON_UNESCAPED_SLASHES);
//		exit();
//$url = 'http://www.chyblog.com/static/admin/upload/1545023021.jpg';echo str_replace("\\/", "/", json_encode($url));
	$result = "{\"groupname\":\"\",\"id\":1,\"online\":0,\"list\":" . str_replace("\\/", "/", json_encode($user, JSON_UNESCAPED_UNICODE)) . "}" ;
	$result = "{\"mine\":{\"username\":\"".get_lang("livechat_message8")."\",\"id\":\"".g ("id")."\",\"status\":\"online\",\"sign\":\"\",\"avatar\":\"assets/img/face.png\"},\"friend\":[" . $result . "]}" ;
	$result = "{\"code\":0,\"msg\":\"\",\"data\":" . $result . "}" ;
	$printer->out_str($result) ;
}

function setChaterCookie() {
	$db = new Model("lv_user");
	if(!g ("chater")){
		$db -> addParamWhere("userid", g ("userid"));
		$row = $db -> getDetail();
		if (count($row)){
			//file_put_contents("F:/php/RTCServer/Web/Data/7.log", var_dump($row) . PHP_EOL, FILE_APPEND);
			if($row["cookiehcid2"]&&$row["cookiehcid2"]!='undefined'){
				//file_put_contents("F:/php/RTCServer/Web/Data/7.log", $row ["cookiehcid1"] . PHP_EOL, FILE_APPEND);
				$db -> clearParam();
				$db -> addParamField("cookiehcid1","");
				$db -> addParamWhere("userid", g ("userid"));
				$db -> update();
			}
		}
	}
	$db -> clearParam();
	$db -> addParamField("cookiehcid2",g ("chater"));
	$db -> addParamWhere("userid", g ("userid"));
	$db -> update();
}
// 连接会话
function ConnectChat() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	$result = array ();

	setChaterCookie();
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
	
	$param = array("YouID"=>$user ["userid"],"To_Type"=>3) ;
	$root = new Model("Clot_Silence");
	$root -> addParamWheres($param);
	$TypeID = $root -> getValue("TypeID");
	if($TypeID){
		$result ["error"] = 2;
		$printer->out_arr ( $result );
	}
//	if(g ("chater")=='admin'&&empty(g ( "username"))){
//		$result ["error"] = 2;
//		$printer->out_arr ( $result );
//	}
//	$arrStr = explode(".",$_SERVER['REMOTE_ADDR']);
//	$ip=$arrStr[0].'.'.$arrStr[1].'.'.$arrStr[2];
//	if($ip=="220.196.160"||$ip=="180.101.245"||$ip=="59.83.208"){
//		$result ["error"] = 2;
//		$printer->out_arr ( $result );
//	}
	//if(!$user ["username"]) $user ["username"]=$user ["area"];
//	echo g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) ).'|'.$user ["userid"];
//	exit();
	
//	if(ismobile()) $UserIcoLine=3;
//	else $UserIcoLine=1;
//	$db = new Model("lv_user");
//	$db -> addParamField("UserIcoLine",$UserIcoLine);
//	$db -> addParamWhere("userid", $user ["userid"]);
//	$db -> update();

	$connectType = g("connectType",1);
	$chatId = $user ["cookiehcid1"];
	$append = "";
	$gchater=g ("chater");
	if($gchater==get_lang("livechat_message7")) $gchater='';

	if($gchater!=''){
		$db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatId);
		$db -> addParamWhere("chater", $gchater);
		$db -> addParamWhere("userid", g ("userid"));
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
			$data = $livechat->GetChaterDetail1 ($Chater);
			$result ["talker"] = $Chater;
			if (count($data)){
				$reception = array ();
				$reception ["myid"] = $user ["userid"];
				$reception ["youid"] = $data ["loginname"];
				$reception ["to_type"] = 0;
				$reception ["chaterreception"] = $data ["defaultreception"];
				$reception ["chater_roreception"] = 0;
				$reception = $livechat->GetReception ( $reception );
				
				$result ["talkername"] = $data ["username"];
				$result ["picture"] = $data ["picture"];
				$result ["welcome"] = $data ["welcome"];
				$result ["cookiehcid5"] = $reception ["defaultreception"];
				
				if($row ["status"]<2){
					$issend = $livechat->Getissend ( $data ["loginname"] );
					if((!g ( "isnotsend" ))&&$issend){
						$arr_welcome = explode("<hr />",$data ["welcome"]);
						foreach($arr_welcome as $welcome)
						{
							if($welcome) $livechat -> SendKefuMessage($result ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
						}
						 if(g ("goods_info")!='') $livechat -> SendKefuMessage($chatId,$user ["userid"],$data ["loginname"],$data ["username"],1,g ("goods_info"),1,$data ["loginname"],$data ["picture"]);
						 $data = $livechat->GetQuestion ($data ["userid"]);
						 $append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
					}
					 $printer->out_detail ( $result, $append, 0 );
				}
			}
		}
		 $data = $livechat->GetChaterDetail ($gchater);
	}else{
		if($user ["chater"]!=''){
			$data = $livechat->GetChaterDetail1 ($user ["chater"]);
			if (count($data)) $ischater=1;
		}
		if(!$ischater){
			$db = new Model("lv_chat");
			$db -> addParamWhere("ChatId", $chatId);
			$db -> addParamWhere("userid", g ("userid"));
			//$db -> addParamWhere("Status", 2,"<","int");
			$row = $db -> getDetail();
			if (count($row)){
			// merge
				$Chater=$row ["chater"];
				$OutTime=$row ["outtime"];
				$result ["status"] = $row ["status"];
				$result ["chatid"] = $chatId;
				$result ["connecttype"] = $connectType;
				$result ["userid"] = $user ["userid"];
				$result ["username"] = $user ["username"];
				$result ["error"] = 0;
				$data = $livechat->GetChaterDetail1 ($Chater);
				$result ["talker"] = $Chater;
				if (count($data)){
					$reception = array ();
					$reception ["myid"] = $user ["userid"];
					$reception ["youid"] = $data ["loginname"];
					$reception ["to_type"] = 0;
					$reception ["chaterreception"] = $data ["defaultreception"];
					$reception ["chater_roreception"] = 0;
					$reception = $livechat->GetReception ( $reception );
					
					$result ["talkername"] = $data ["username"];
					$result ["picture"] = $data ["picture"];
					$result ["welcome"] = $data ["welcome"];
					$result ["cookiehcid5"] = $reception ["defaultreception"];
					if($row ["status"]<2){
						$issend = $livechat->Getissend ( $data ["loginname"] );
//						if(SENDWELCOME){
//							$issend=0;
//							$db2 = new DB();
//							$sql = "select LoginName from lv_chater_notice where TypeID=5";	
//							$data2 = $db2 -> executeDataTable($sql);
//							foreach($data2 as $value){
//								 if(in_array($data ["loginname"], $value)) $issend=1;
//							}
							if((!g ( "isnotsend" ))&&$issend){
								$arr_welcome = explode("<hr />",$data ["welcome"]);
								foreach($arr_welcome as $welcome)
								{
									if($welcome) $livechat -> SendKefuMessage($result ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
								}
								$data = $livechat->GetQuestion ($data ["userid"]);
								$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
							}
//						}
						$printer->out_detail ( $result, $append, 0 );
					}
				}
	
			}
			$data = $livechat->GetChaterRo ();
			if (count($data)){
				//$livechat->RequestSource($user ["userid"],g ("loginname"), "","",$connectType = 0,0,0);
				$result ["talker"] = get_lang("livechat_message7");
				$result ["error"] = 1;
				$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );
				$data = $livechat->GetQuestion ('');
				$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
				$printer->out_detail ( $result, $append, 0 );
			}
			else{
				if(OLDVISITORTYPE){
					 if(strtotime(getNowTime())-strtotime($OutTime)>OLDVISITORTIME) $Chater='';
				}
				 $data = $livechat->GetChaterRnd ($Chater);
			}
		}
	}
	
	if (count($data)){
	if($user ["userid"]==$Chater||$user ["userid"]==$data ["loginname"]||$user ["userid"]==$gchater){
	$result ["error"] = 3;
	$result ["msg"] = get_lang("livechat_message6");
	$printer->out_arr ( $result );
	}
	// create chat // "status"=>$status,"chatid"=>$chatId
	if((int)$data ["usericoline"]>0) $kefumsg=get_lang("livechat_message1");
	else $kefumsg=get_lang("livechat_message0");
//	$kefumsg=get_lang("livechat_message1");
	$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,0);
	$reception = array ();
	$reception ["myid"] = $user ["userid"];
	$reception ["youid"] = $data ["loginname"];
	$reception ["to_type"] = 0;
	$reception ["chaterreception"] = $data ["defaultreception"];
	$reception ["chater_roreception"] = 0;
	$reception = $livechat->GetReception ( $reception );
	if((!g ( "isnotsend" ))&&$connectType==1){
		if(DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0,$data ["loginname"],$data ["picture"]);
		$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],$kefumsg),0,$data ["loginname"],$data ["picture"]);
		if((g ("goods_info")!='')&&DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],1,g ("goods_info"),1,$data ["loginname"],$data ["picture"]);
		if($data ["welcome"]){
			$db = new Model("lv_chat");
			$db -> addParamWhere("Chater", $data ["loginname"]);
			$db -> addParamWhere("UserId", $user ["userid"]);
			$db -> addParamWhere("Status", 2);
			$row = $db -> getDetail();
			$issend = $livechat->Getissend ( $data ["loginname"] );
			if (count($row)==0||$issend==1){
				$arr_welcome = explode("<hr />",$data ["welcome"]);
				foreach($arr_welcome as $welcome)
				{
					if($welcome) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
				}
			} 
		}
	}
	// merge
	$result = $chat;
	$result ["connecttype"] = $chat ["connectType"];
	$result ["userid"] = $user ["userid"];
	$result ["username"] = $user ["username"];
	$result ["talker"] = $data ["loginname"];
	$result ["talkername"] = $data ["username"];
	$result ["picture"] = $data ["picture"];
	$result ["welcome"] = $data ["welcome"];
	$result ["cookiehcid5"] = $reception ["defaultreception"];
	if(SWITCHBACK){
		$db2 = new DB();
		$sql = "select LoginName from lv_chater_notice where TypeID=3";	
		$data2 = $db2 -> executeDataTable($sql);
		foreach($data2 as $value){
			 if(in_array($data ["loginname"], $value)) $result ["mobileback"] = 1;
		}
	}
	$result ["error"] = 0;
	
	$data1 = $livechat->GetQuestion ($data ["userid"]);
	$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data1, 0 )) . ']' );
//	 $data = $livechat->GetMeetingPlug ();
//	 $append = $printer->union ( $append, '"meetingplug":[' . ($printer->parseList ( $data, 0 )) . ']' );
	$printer->out_detail ( $result, $append, 0 );
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
	
	setChaterCookie();
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
		//file_put_contents("F:/php/RTCServer/Web/Data/7.log", $user["cookiehcid1"].'|'.g ("userid") . PHP_EOL, FILE_APPEND);
	$param = array("YouID"=>$user ["userid"],"To_Type"=>3) ;
	$root = new Model("Clot_Silence");
	$root -> addParamWheres($param);
	$TypeID = $root -> getValue("TypeID");
	if($TypeID){
		$result ["error"] = 2;
		$printer->out_arr ( $result );
	}
//	if(g ( "typeid" )==7&&g ( "username")==''){
//		$result ["error"] = 2;
//		$printer->out_arr ( $result );
//	}

	//if(!g ("chatid")){
		$row = $livechat->GetChaterRoDetail (g ( "typeid" ));
		if ((int)$row ["to_type"])
		{
			ConnectChat3();
			return ;
		}
	//}

	$result = array ();
	$connectType = g("connectType",1);
	$chatId = $user ["cookiehcid1"];
	$append = "";
	
	$db = new Model("lv_chat");
	$db -> addParamWhere("ChatId", $chatId);
	$db -> addParamWhere("userid", g ("userid"));
	$row = $db -> getDetail();

	if (count($row)){
	// merge
		$Chater=$row ["chater"];
		$OutTime=$row ["outtime"];
		$result ["status"] = $row ["status"];
		$result ["chatid"] = $chatId;
		$result ["connecttype"] = $connectType;
		$result ["userid"] = $user ["userid"];
		$result ["username"] = $user ["username"];
		$result ["error"] = 0;
		$data = $livechat->GetChaterDetail1 ($Chater);
		$result ["talker"] = $Chater;
		if (count($data)){
			$reception = array ();
			$reception ["myid"] = $user ["userid"];
			$reception ["youid"] = $data ["loginname"];
			$reception ["to_type"] = 0;
			$reception ["chaterreception"] = $data ["defaultreception"];
			$reception ["chater_roreception"] = 0;
			$reception = $livechat->GetReception ( $reception );
			
			$result ["talkername"] = $data ["username"];
			$result ["picture"] = $data ["picture"];
			$result ["welcome"] = $data ["welcome"];
			$result ["cookiehcid5"] = $reception ["defaultreception"];
			if($row ["status"]<2){
				$issend = $livechat->Getissend ( $data ["loginname"] );
//				if(SENDWELCOME){
//					$issend=0;
//					$db2 = new DB();
//					$sql = "select LoginName from lv_chater_notice where TypeID=5";	
//					$data2 = $db2 -> executeDataTable($sql);
//					foreach($data2 as $value){
//						 if(in_array($data ["loginname"], $value)) $issend=1;
//					}
					if((!g ( "isnotsend" ))&&$issend){
						$arr_welcome = explode("<hr />",$data ["welcome"]);
						foreach($arr_welcome as $welcome)
						{
							if($welcome) $livechat -> SendKefuMessage($result ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
						}
						$data = $livechat->GetQuestion ($data ["userid"]);
						$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
					}
//				}
				$printer->out_detail ( $result, $append, 0 );
			}
		}

	}

	if(OLDVISITORTYPE){
		 if(strtotime(getNowTime())-strtotime($OutTime)>OLDVISITORTIME) $Chater='';
	}
	$data = $livechat->GetChaterForm ($Chater,g ( "typeid" ));
//	echo $data ["loginname"];
//	exit();
    //file_put_contents("F:/php/RTCServer/Web/Data/7.log", $data ["loginname"] . PHP_EOL, FILE_APPEND);
	if (count($data)){
		if($user ["userid"]==$data ["loginname"]){
		$result ["error"] = 3;
		$result ["msg"] = get_lang("livechat_message6");
		$printer->out_arr ( $result );
		}
		$db = new DB();
		$sql = "select * from lv_chater_ro where TypeID=" . g ( "typeid" ) . "";
		$row = $db->executeDataRow($sql);
		$data ["welcome"] = $row['welcome'];
		// create chat // "status"=>$status,"chatid"=>$chatId
		$connectType = g("connectType",1);
		$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,g ("typeid"));
		$reception = array ();
		$reception ["myid"] = $user ["userid"];
		$reception ["youid"] = $data ["loginname"];
		$reception ["to_type"] = 0;
		$reception ["chaterreception"] = $data ["defaultreception"];
		$reception ["chater_roreception"] = $row['defaultreception'];
		$reception = $livechat->GetReception ( $reception );
		if((!g ( "isnotsend" ))&&$connectType==1){
			if(DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0,$data ["loginname"],$data ["picture"]);
			$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0,$data ["loginname"],$data ["picture"]);
			if((g ("goods_info")!='')&&DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],1,g ("goods_info"),1,$data ["loginname"],$data ["picture"]);
			if($data ["welcome"]){
				$db = new Model("lv_chat");
				$db -> addParamWhere("Chater", $data ["loginname"]);
				$db -> addParamWhere("UserId", $user ["userid"]);
				$db -> addParamWhere("Status", 2);
				$row = $db -> getDetail();
				$issend = $livechat->Getissend ( $data ["loginname"] );
				if (count($row)==0||$issend==1){
					$arr_welcome = explode("<hr />",$data ["welcome"]);
					foreach($arr_welcome as $welcome)
					{
						if($welcome) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
					}
				} 
			}
		}
		// merge
		$result = $chat;
		$result ["connecttype"] = $chat ["connectType"];
		$result ["userid"] = $user ["userid"];
		$result ["username"] = $user ["username"];
		$result ["talker"] = $data ["loginname"];
		$result ["talkername"] = $data ["username"];
		$result ["picture"] = $data ["picture"];
		$result ["welcome"] = $data ["welcome"];
		$result ["cookiehcid5"] = $reception ["defaultreception"];
		if(SWITCHBACK){
			$db2 = new DB();
			$sql = "select LoginName from lv_chater_notice where TypeID=3";	
			$data2 = $db2 -> executeDataTable($sql);
			foreach($data2 as $value){
				 if(in_array($data ["loginname"], $value)) $result ["mobileback"] = 1;
			}
		}
		$result ["error"] = 0;
		
		$data = $livechat->GetQuestion ($data ["userid"]);
		$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
//		 $data = $livechat->GetMeetingPlug ();
//		 $append = $printer->union ( $append, '"meetingplug":[' . ($printer->parseList ( $data, 0 )) . ']' );
		$printer->out_detail ( $result, $append, 0 );
	}else{
	$result ["error"] = 2;
	$printer->out_arr ( $result );
	}
}

// 连接会话
function ConnectChat3() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
	
	$param = array("YouID"=>$user ["userid"],"To_Type"=>6) ;
	$root = new Model("Clot_Silence");
	$root -> addParamWheres($param);
	$TypeID = $root -> getValue("TypeID");
	if($TypeID){
		$result ["error"] = 3;
		$printer->out_arr ( $result );
	}
	
//	$sql_count = "select count(*) as c from lv_chater_Clot_Ro as aa,Clot_Silence as cc where aa.TypeID=cc.YouID and cc.To_Type=6 and aa.UserId='".$user ["userid"]."'";
//	$TypeID = $livechat -> db -> executeDataValue($sql_count);
//	if($TypeID){
//		$result ["error"] = 2;
//		$printer->out_arr ( $result );
//	}
	
	
	$data = $livechat->GetClot_Ro (g ( "typeid" ), $user );

	$result = array ();
	$connectType = g("connectType",1);
	$chatId = g ("chatid");
	$append = "";
		
	if (count($data)){
		$db = new DB();
		$row = $livechat->GetChaterRoDetail (g ( "typeid" ));
		$data ["welcome"] = $row['welcome'];
		// create chat // "status"=>$status,"chatid"=>$chatId
		$connectType = g("connectType",1);
		
		$reception = array ();
		$reception ["myid"] = $user ["userid"];
		$reception ["youid"] = $data ["typeid"];
		$reception ["to_type"] = 1;
		$reception ["chaterreception"] = 0;
		$reception ["chater_roreception"] = $data['defaultreception'];
		$reception = $livechat->GetReception ( $reception );
		
		$dbForm = new Model("lv_chater_Clot_Form");
		$sql = "select * from lv_chater_form where TypeID =".g ( "typeid" );
		$data_user = $db -> executeDataTable($sql) ;
		
		$row1 = $livechat->GetChaterDetail ($data_user[0]['loginname']);
		if(!g ( "isnotsend" )){
			if(DIALOGTYPE) $livechat -> SendKefuClotMessage($data ["typeid"],$data ["userid"],$data ["typename"],$data ["pid"],$row ["typename"],"",3,date("G:i:s").get_lang("livechat_message2"));
			$livechat -> SendKefuClotMessage($data ["typeid"],$data_user[0]['loginname'],$data_user[0]['username'],$data ["pid"],$row ["typename"],$row1["picture"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")));
			if((g ("goods_info")!='')&&DIALOGTYPE) $livechat -> SendKefuClotMessage($data ["typeid"],$data ["userid"],$data ["typename"],$data ["pid"],$row ["typename"],"",1,g ("goods_info"));
			if($data ["welcome"]){
				if (count($data_user)){
					$arr_welcome = explode("<hr />",$data ["welcome"]);
					foreach($arr_welcome as $welcome)
					{
						if($welcome) $livechat -> SendKefuClotMessage($data ["typeid"],$data_user[0]['loginname'],$data_user[0]['username'],$data ["pid"],$row ["typename"],$row1["picture"],1,phpescape($welcome));
					}
				} 
			}
		}
		//if($data ["welcome"]) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,$data ["welcome"],1);
		// merge
		//$result = $chat;
		
		$result ["connecttype"] = $connectType;
		$result ["userid"] = $user ["userid"];
		$result ["username"] = $user ["username"];
		$result ["talker"] = $data ["typeid"];
		$result ["talkername"] = $row ["typename"];
		$result ["picture"] = '';
		$result ["welcome"] = $data ["welcome"];
		$result ["cookiehcid5"] = $reception ["defaultreception"];
		$result ["to_type"] = 1;
		$result ["error"] = 0;
		
		$data = $livechat->GetQuestion ($data_user[0]['userid']);
		$append = $printer->union ( $append, '"questions":[' . ($printer->parseList ( $data, 0 )) . ']' );
		$printer->out_detail ( $result, $append, 0 );
	}else{
	$result ["error"] = 2;
	$printer->out_arr ( $result );
	}
}

// 连接会话
function ConnectChat2() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	$result = array ();

	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
	
	if($user ["isweb"]==0){
		$result ["error"] = 4;
		$result ["msg"] = get_lang("livechat_message18");
		$printer->out_arr ( $result );
	}
	
	if($user ["status"]!=0){
		$result ["error"] = 5;
		$result ["msg"] = get_lang("livechat_message19");
		$printer->out_arr ( $result );
	}

	$connectType = g("connectType",1);
	$chatId = g ("chatid");
	$append = "";

	$db = new Model("lv_chat");
	$db -> addParamWhere("UserId", $user ["userid"]);
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
		$result ["usericoline"] = $user ["usericoline"];
		$result ["error"] = 0;
		$data = $livechat->GetChaterDetail ($Chater);
		$result ["talker"] = $Chater;
		if (count($data)){
			$result ["talkername"] = $data ["username"];
			$result ["picture"] = $data ["picture"];
			$result ["welcome"] = $data ["welcome"];
			
			if($row ["status"]<2){
//				$arr_welcome = explode("<hr />",$data ["welcome"]);
//				foreach($arr_welcome as $welcome)
//				{
//					if($welcome) $livechat -> SendKefuMessage($result ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"]);
//				}
				 $printer->out_arr ( $result );	
			}
		}
	}
	 $data = $livechat->GetChaterDetail (g ("chater"));
	
	if (count($data)){
	if($user ["userid"]==$Chater||$user ["userid"]==$data ["loginname"]||$user ["userid"]==g ("chater")){
	$result ["error"] = 3;
	$result ["msg"] = get_lang("livechat_message6");
	$printer->out_arr ( $result );
	}
	// create chat // "status"=>$status,"chatid"=>$chatId
	$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,0);
	if(DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0,$data ["loginname"],$data ["picture"]);
	$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0,$data ["loginname"],$data ["picture"]);
	if($data ["welcome"]){
//		$db = new Model("lv_chat");
//		$db -> addParamWhere("Chater", $data ["loginname"]);
//		$db -> addParamWhere("UserId", $user ["userid"]);
//		$db -> addParamWhere("Status", 2);
//		$row = $db -> getDetail();
//		if (count($row)==0){
			$arr_welcome = explode("<hr />",$data ["welcome"]);
			foreach($arr_welcome as $welcome)
			{
				if($welcome) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
			}
//		} 
	}
	//if($data ["welcome"]) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,$data ["welcome"],1);
	// merge
	$db = new DB ();
	$sql_count = "select count(*) as c from lv_source where UserId='".$user ["userid"]."'";
	$visitcount = $db -> executeDataValue($sql_count);
	$result = $chat;
	$result ["connecttype"] = $chat ["connectType"];
	$result ["userid"] = $user ["userid"];
	$result ["username"] = $user ["username"];
	$result ["usericoline"] = $user ["usericoline"];
	$result ["isweixin"] = $user ["isweixin"];
	$result ["headimgurl"] = $user ["headimgurl"];
	$result ["talker"] = $data ["loginname"];
	$result ["talkername"] = $data ["username"];
	$result ["picture"] = $data ["picture"];
	$result ["welcome"] = $data ["welcome"];
	$result ["visitcount"] = $visitcount;
	$result ["error"] = 0;
	
	$printer->out_arr ( $result );
	}else{
	$result ["error"] = 2;
	$printer->out_arr ( $result );
	}
}
// 连接会话
//function ConnectChat4() {
//	global $printer;
//	$livechat = new LiveChat ();
//	$user = array ();
//	$result = array ();
//
//	// create user
//	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
//	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
//	$user ["phone"] = g ( "phone" );
//	$user ["email"] = g ( "email" );
//	$user ["qq"] = g ( "qq" );
//	$user ["wechat"] = g ( "wechat" );
//	$user ["remarks"] = js_unescape(g ( "remarks" ));
//	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
//	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
//	
//	$user = $livechat->GetUser ( $user );
//	
//	if($user ["isweb"]==0){
////		$result ["error"] = 4;
////		$result ["msg"] = get_lang("livechat_message18");
////		$printer->out_arr ( $result );
//		return ;
//	}
//	
//	if($user ["status"]!=0){
////		$result ["error"] = 5;
////		$result ["msg"] = get_lang("livechat_message19");
////		$printer->out_arr ( $result );
//		return ;
//	}
//
//	$connectType = g("connectType",1);
//	$chatId = g ("chatid");
//	$append = "";
//
//	$db = new Model("lv_chat");
//	$db -> addParamWhere("UserId", $user ["userid"]);
//	$db -> addParamWhere("chater", g ("chater"));
//	$row = $db -> getDetail();
//	if (count($row)){
//	// merge
//		$Chater=$row ["chater"];
//		$result ["status"] = $row ["status"];
//		$result ["chatid"] = $chatId;
//		$result ["connecttype"] = $connectType;
//		$result ["userid"] = $user ["userid"];
//		$result ["username"] = $user ["username"];
//		$result ["usericoline"] = $user ["usericoline"];
//		$result ["error"] = 0;
//		$data = $livechat->GetChaterDetail ($Chater);
//		$result ["talker"] = $Chater;
//		if (count($data)){
//			$result ["talkername"] = $data ["username"];
//			$result ["picture"] = $data ["picture"];
//			$result ["welcome"] = $data ["welcome"];
//			
//			if($row ["status"]<2) return ;	
//		}
//	}
//	 $data = $livechat->GetChaterDetail (g ("chater"));
//	
//	if (count($data)){
//	if($user ["userid"]==$Chater||$user ["userid"]==$data ["loginname"]||$user ["userid"]==g ("chater")){
////	$result ["error"] = 3;
////	$result ["msg"] = get_lang("livechat_message6");
////	$printer->out_arr ( $result );
//	return ;
//	}
//	// create chat // "status"=>$status,"chatid"=>$chatId
//	$chat = $livechat->RequestChat ( $user ["userid"],g ("loginname"), $user ["username"], $data ["loginname"],$connectType,0);
//	if(DIALOGTYPE) $livechat -> SendKefuMessage($chat ["chatid"],$user ["userid"],$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0,$data ["loginname"]);
//	$livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],3,str_replace("{name}",$data ["username"],get_lang("livechat_message1")),0,$data ["loginname"]);
//	if($data ["welcome"]){
////		$db = new Model("lv_chat");
////		$db -> addParamWhere("Chater", $data ["loginname"]);
////		$db -> addParamWhere("UserId", $user ["userid"]);
////		$db -> addParamWhere("Status", 2);
////		$row = $db -> getDetail();
////		if (count($row)==0){
//			$arr_welcome = explode("<hr />",$data ["welcome"]);
//			foreach($arr_welcome as $welcome)
//			{
//				if($welcome) $livechat -> SendKefuMessage($chat ["chatid"],$data ["loginname"],$user ["userid"],$data ["username"],1,phpescape($welcome),1,$data ["loginname"]);
//			}
////		} 
//	}
//	// merge
////	$db = new DB ();
////	$sql_count = "select count(*) as c from lv_source where UserId='".$user ["userid"]."'";
////	$visitcount = $db -> executeDataValue($sql_count);
////	$result = $chat;
////	$result ["connecttype"] = $chat ["connectType"];
////	$result ["userid"] = $user ["userid"];
////	$result ["username"] = $user ["username"];
////	$result ["usericoline"] = $user ["usericoline"];
////	$result ["isweixin"] = $user ["isweixin"];
////	$result ["headimgurl"] = $user ["headimgurl"];
////	$result ["talker"] = $data ["loginname"];
////	$result ["talkername"] = $data ["username"];
////	$result ["picture"] = $data ["picture"];
////	$result ["welcome"] = $data ["welcome"];
////	$result ["visitcount"] = $visitcount;
////	$result ["error"] = 0;
//	
////	$printer->out_arr ( $result );
//	}
////	else{
////	$result ["error"] = 2;
////	$printer->out_arr ( $result );
////	}
//}
// 连接会话
function initInvite() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	$result = array ();

	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
	
	if($user ["isweb"]==0){
		$result ["error"] = 4;
		$result ["msg"] = get_lang("livechat_message18");
		$printer->out_arr ( $result );
	}
	
	if($user ["status"]!=0){
		$result ["error"] = 5;
		$result ["msg"] = get_lang("livechat_message19");
		$printer->out_arr ( $result );
	}

	$connectType = g("connectType",1);
	$chatId = g ("chatid");
	$append = "";


	 $data = $livechat->GetChaterDetail (g ("chater"));
	
	if (count($data)){
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
	$UserId = g ( "UserId" );
	$chatId = g ( "chatid" );
	$closeRole = g ( "CloseRole" );
	
	$livechat = new LiveChat ();
	if($Chater){
		  if($UserId) $result = $livechat->CloseChat2 ( $UserId, $Chater, $closeRole );
		  else $result = $livechat->CloseChat1 ( $Chater, $closeRole );
	}else $result = $livechat->CloseChat ( $chatId, $closeRole );
	
	$printer->success ();
}

// 连接会话
function ConnectSource() {
	global $printer;
	$livechat = new LiveChat ();
	$user = array ();
	$result = array ();

	setChaterCookie();
	// create user
	$user ["userid"] = g ( "userid", GetValue ( "BIGANTLIVE_USERID" ) );
	$user ["username"] = js_unescape(g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) ));
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = js_unescape(g ( "remarks" ));
	$user ["othertitle"] = js_unescape(g ( "othertitle" ));
	$user ["otherurl"] = js_unescape(g ( "otherurl" ));
	
	$user = $livechat->GetUser ( $user );
	
	$row = $livechat->GetChaterRoDetail (g ( "typeid" ));

	$connectType = g("connectType",1);
	$chatId = $user ["cookiehcid1"];
	$append = "";
	
	if(!g ("isend")) $livechat->RequestSource(g ("typeid"),$user ["userid"],g ("chater"),$user ["username"],"",$connectType = 0,0,0,g ( "isweb", 0 ));
	
	if(ismobile()) $UserIcoLine=3;
	else $UserIcoLine=1;
	
	$db = new Model("lv_user");
	$db -> addParamField("UserIcoLine",$UserIcoLine);
	$db -> addParamField("IsWeb",g ( "isweb", 0 ));
	$db -> addParamField("LoginName",g ("chater"));
	$db -> addParamField("TypeID",g ("typeid"));
	$db -> addParamWhere("userid", $user ["userid"]);
	$db -> addParamField("LastTime", getNowTime(),"datetime");
	$db -> update();
	
	$result ["connectchattype"] = 0;
	if(WEBSITETYPE==2&&(!$chatId)&&(!ismobile())){
		//ConnectChat4();
		$result ["connectchattype"] = 1;
	}
	$result ["talker"] = get_lang("livechat_message7");
	$result ["username"] = $user ["username"];
	$result ["usericoline"] = $UserIcoLine;
	$result ["to_type"] = $row ["to_type"];
	$result ["error"] = g ( "isweb", 0 );
	$printer->out_detail ( $result, $append, 0 );
}

function CloseSource() {
	global $printer;
	
	$Chater = g ( "Chater" );
	$UserId = g ( "UserId" );
	$chatId = g ( "chatid" );
	$closeRole = g ( "CloseRole" );
	
	$livechat = new LiveChat ();
	if(ismobile()) $UserIcoLine=2;
	else $UserIcoLine=0;
	$livechat->CloseChat2 ( $UserId, $Chater, $closeRole );
	
	$db = new Model("lv_user");
	$db -> addParamField("UserIcoLine",$UserIcoLine);
	$db -> addParamField("Status",2);
	$db -> addParamField("IsWeb",0);
	$db -> addParamWhere("userid", $UserId);
	$db -> update();
	
	//$livechat->setUserIcoLine ( $userid, $UserIcoLine );
	
	$printer->success ();
}

function loadWebUser() {
	Global $printer;
	$keyword = new keyword();

	$where="";
	if(CHATERMODE){
		$db = new DB();
		$sql = "select * from lv_chater_form where LoginName ='".f ( "loginname", "" )."'";
		$data_user = $db -> executeDataTable($sql) ;
		$TypeIDs="";
		foreach($data_user as $k=>$v){
			$TypeIDs .= ($TypeIDs?",":"") . $data_user[$k]['typeid'];
		}
		if($TypeIDs) $where = "and (LoginName ='".f ( "loginname", "" )."' or TypeID in (" . $TypeIDs . "))";
		else $where = "and LoginName ='".f ( "loginname", "" )."'";
	}

	$tableName = f ( "table", "lv_user" );
	$fldId = f ( "fldid", "UserId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "LastTime desc" );
			$fldSortdesc = f ( "fldsortdesc", "LastTime asc" );
			break ;
		default:
			$fldSort = f ( "fldsort", "LastTime desc" );
			$fldSortdesc = f ( "fldsortdesc", "LastTime asc" );
			break;
	}
	
	$where = stripslashes(f ( "wheresql", "" )).$where;

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

	foreach($data as $k=>$v){
		$sql = "select top 1 * from lv_source where UserId='".$data[$k]['userid']."' order by SourceId desc";
		$db = new DB();
		$detail = $db -> executeDataRow($sql) ;
		
		$sql_count = "select count(*) as c from lv_source where UserId='".$data[$k]['userid']."'";
		$visitcount = $db -> executeDataValue($sql_count);
		
		$sql_count = "select count(*) as c from lv_track where SourceId=".$detail ["sourceid"];
		$depth = $db -> executeDataValue($sql_count);
		
		if(empty($data[$k]["username"])) $data[$k]['username']=$data[$k]["area"];
		else $data[$k]['username']=$data[$k]["username"];
		if(empty($data[$k]['username'])) $data[$k]['username']=get_lang("livechat_message9");
		$data[$k]['launchurl']=$detail ["launchurl"];
		$data[$k]['area']=$detail ["area"];
		$data[$k]['channel']=$keyword->getChannel($detail ["sourceurl"]);
		if(!$data[$k]['channel']) $data[$k]['channel']='-';
		$data[$k]['intime']=$data[$k]['lasttime'];
		$data[$k]['depth']=$depth;
		$data[$k]['visitcount']=$visitcount;
	}

	$printer->out_list ( $data, $count, 0 );
}

function loadUser() {
	Global $printer;
	$keyword = new keyword();

	$where="";

	if(g ( "searchtype")) $tableName = f ( "table", "(select distinct aa.* from lv_user as aa,lv_user_form as bb where aa.UserId=bb.UserId and bb.TypeID in (".g ( "TypeID").")) as cc" );
	else $tableName = f ( "table", "lv_user" );

	//$tableName = f ( "table", "lv_user" );
	$fldId = f ( "fldid", "UserId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "LastTime desc" );
			$fldSortdesc = f ( "fldsortdesc", "LastTime asc" );
			break ;
		default:
			$fldSort = f ( "fldsort", "LastTime desc" );
			$fldSortdesc = f ( "fldsortdesc", "LastTime asc" );
			break;
	}
	
	$where = stripslashes(f ( "wheresql", "" )).$where;

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
		
	foreach($data as $k=>$v){
		if(empty($data[$k]["username"])) $data[$k]['username']=$data[$k]["area"];
		else $data[$k]['username']=$data[$k]["username"];
		if(empty($data[$k]['username'])) $data[$k]['username']=get_lang("livechat_message9");
	}

	$printer->out_list ( $data, $count, 0 );
}
// / <summary>
// / 接收一个会话，客服用
// / </summary>
function RecvChat() {
	global $printer;
	
	$userId = g ( "userid" );
	$chatId = g ( "chatid" );
	$visiter_loginname = g ( "visiter_loginname" );
	$livechat = new LiveChat ();
	$db = new Model("lv_chat");
	$db -> addParamWhere("Chater", $visiter_loginname);
	$db -> addParamWhere("UserId", $userId);
	$db -> addParamWhere("Status", 0);
	$row = $db -> getDetail();
	$result = $livechat->RecvChat ( $userId,$row["chatid"],$visiter_loginname );
	$printer->out ( $result );
}

// / <summary>
// / 得到排认号
// / </summary>
function WaitQueue() {
	global $printer;
	
	$chatId = g ( "chatid" );
	
	$livechat = new LiveChat ();
	$result_file = $livechat->GetQueue ( $chatId );
	//$status = $queue == 0 ? CHAT_STATUS_CONN : CHAT_STATUS_WAIT;
	$printer->out_arr ( $result_file );
//	$json = "{\"status\":" . $result_file["status"] . ",\"queue\":" . $result_file["queue"] . "}";
//	print $json;
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
	$msg->addParamField ( "groupid", g ( "groupid" ) );
	$msg->addParamField ( "chater", g ( "chater" ) );
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
					"email" => g ( "email" ),
					"qq" => g ( "qq" ),
					"wechat" => g ( "wechat" ),
					"remarks" => g ( "remarks" )  
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

function QuestionDetail () {
	global $printer;
	$QuestionId = g ("QuestionId");
//$printer ->out_arr(array('status' => 1,'msg' => 'dg'));
	$livechat = new LiveChat ();
	$data = $livechat->GetQuestionDetail ($QuestionId);
	
	$youid = g ( "youid" );
	$myid = g ( "myid" );
	$chatid = g ( "chatid" );
	$fcname = g ( "fcname" );
	$to_type = g ( "to_type" );
	$usertext = g ( "usertext" );
	$point = (int)g("point");
	
	
	$msg = new Msg ();
	if (g("lv_chater_ro_to_type"))
	{
		$msg_id = $msg -> SendKefuClotMessage($point,g ( "msg_id" ),$myid,$youid,$fcname,"","","",$to_type,str_replace("{name}",$data ["subject"],date("G:i:s").get_lang("livechat_message20")));
		$data["msg_id"] = $msg_id ;
	}else{
		$msg_id = $msg -> SendKefuMessage($point,g ( "msg_id" ),$myid,$youid,$chatid,$fcname,"",$to_type,str_replace("{name}",$data ["subject"],date("G:i:s").get_lang("livechat_message20")),$youid);
		$data["msg_id"] = $msg_id ;
	}

	$printer->out_arr ( $data );
}

function SourceDetail () {
	global $printer;
	$ChatId = g ("chatid");
	$UserId = g ("userid");
	
	$livechat = new LiveChat ();
	$data = $livechat->GetSourceDetail ($ChatId,$UserId);
	
	$printer->out_arr ( $data );
}

function ListTrack () {
	global $printer;
	
	$ChatId = g ("chatid");
	$UserId = g ("userid");
	
	$livechat = new LiveChat ();
	$data = $livechat->ListTrack ($ChatId,$UserId);
	
	$printer->out_list($data,-1,0);
}


function ListTrack1 () {
	global $printer;
	
	$SourceId = g ("sourceid");
	
	$livechat = new LiveChat ();
	$data = $livechat->ListTrack1 ($SourceId);
	
	$printer->out_list($data,-1,0);
}

function UserDetail () {
	global $printer;
	
	$livechat = new LiveChat ();
	
	$user ["userid"] = g ( "userid");
	$user ["username"] = g ( "username");
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	
	$data = $livechat->GetUser ( $user );
	
	$printer->out_arr ( $data );
}


function UserDetail1 () {
	global $printer;
	
	$keyword = new keyword();
	$livechat = new LiveChat ();
	
	$user ["userid"] = g ( "userid");
	$user ["username"] = g ( "username");
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	
	$data_user = $livechat->GetUser ( $user );
	
	$sql = "select top 1 * from lv_chat as aa,lv_chater_theme as bb where aa.UserId='".$user ["userid"]."' and aa.Status=2 and aa.ThemeId=bb.TypeID order by aa.ChatId desc";
	$db = new DB();
	$theme_detail = $db -> executeDataRow($sql) ;
	
	$sql = "select top 1 * from lv_source where UserId='".$user ["userid"]."' order by SourceId desc";
	$db = new DB();
	$detail = $db -> executeDataRow($sql) ;
	
	$sql_count = "select count(*) as c from lv_source where UserId='".$data_user['userid']."'";
	$visitcount = $db -> executeDataValue($sql_count);
	
	$sql = "select top 1 * from lv_chat where UserId ='".$user ["userid"]."' order by ChatId desc";
	$chat_detail = $db -> executeDataRow($sql) ;
	
	if(empty($data_user["username"])) $data_user['username']=$data_user["area"];
	else $data_user['username']=$data_user["username"];
	if(empty($data_user['username'])) $data_user['username']=get_lang("livechat_message9");
	$data_user['sourceid']=$detail ["sourceid"];
	$data_user['sourceurl']=$detail ["sourceurl"];
	$data_user['launchurl']=$detail ["launchurl"];
	$data_user['area']=$detail ["area"];
	$data_user['channel']=$keyword->getChannel($detail ["sourceurl"]);
	//if(!$data_user['channel']) $data_user['channel']=$data_user['headimgurl'];
	if(!$data_user['channel']) $data_user['channel']='-';
	$data_user['browser']=$detail ["browser"];
	$data_user['ip']=$detail ["ip"];
	$data_user['intime']=$detail ["intime"];
	$data_user['visitcount']=$visitcount;
	$data_user['chatid']=$chat_detail ["chatid"];
	if(empty($theme_detail["typename"])) $data_user['typename']=get_lang("livechat_message11");
	else $data_user['typename']=$theme_detail["typename"];
	
	$sql_form = "select * from lv_user_form where UserId='" . $data_user['userid'] . "' and To_Type=3 and MyID='".CurUser::getUserId()."'";
	$data1 = $db -> executeDataTable($sql_form) ;
	$data_user['user_form']=$printer->parseList ( $data1, 0 );
	
	$printer->out_arr ( $data_user );
}

function UserDetail2 () {
	global $printer;
	
	$keyword = new keyword();
	$livechat = new LiveChat ();
	
	$user ["userid"] = g ( "userid");
	$user ["username"] = g ( "username");
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	
	$db = new DB();
	$result = array();
	
	$sql = "select aa.TypeID,aa.PID,aa.TypeName,aa.Remark,cc.* from lv_chater_Clot_Ro as aa,lv_user as cc where aa.UserId=cc.UserId and aa.TypeID=".g ( "youid" );
	$detail = $db -> executeDataRow($sql);

	$sql_count = "select count(*) as c from lv_source where UserId='".$detail ["userid"]."'";
	$visitcount = $db -> executeDataValue($sql_count);
	
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
	$data = $db -> executeDataTable($sql) ;
	$append = $printer->union ( $append, '"clot_form":[' . ($printer->parseList ( $data, 0 )) . ']' );
	
	$sql_form = "select * from lv_user_form where UserId='" . $detail ["typeid"] . "' and To_Type=6 and MyID='".CurUser::getUserId()."'";
	$data1 = $db -> executeDataTable($sql_form) ;
	$append = $printer->union ( $append, '"user_form":[' . ($printer->parseList ( $data1, 0 )) . ']' );
		
	$printer->out_detail ( $result, $append,0 );
}


function SaveUserDetail () {
	global $printer;
	$user = array (
					"username" => g ( "username" ),
					"phone" => g ( "phone" ),
					"email" => g ( "email" ),
					"qq" => g ( "qq" ),
					"wechat" => g ( "wechat" ),
					"remarks" => g ( "remarks" )  
	);

	$db = new Model("lv_user");
	$db -> clearParam();
	$db -> addParamFields($user);
	$db -> addParamWhere("userid",g ( "userid"));
	$db -> update();
	if((int)g ( "category")==6){
		$db = new Model("lv_chater_Clot_Ro");
		$db -> clearParam();
		$db -> addParamField("typename",g ( "typename"));
		$db -> addParamWhere("typeid",g ( "typeid"));
		$db -> update();
	}
	
	$evaluate = array (
					"username" => g ( "username" ),
					"themeid" => g ( "themeid",0 ),
					"chatlevel" => g ( "chatlevel",0 )
	);
	$db = new Model("lv_chat");
	$db -> clearParam();
	$db -> addParamFields($evaluate);
	$db -> addParamWhere("chatid",g ( "chatid"));
	$db -> update();

	
	$printer->success ();
}

function EvaluateDetail () {
	global $printer;
	if((int)g ( "category")==6){
		EvaluateDetail1();
		return ;
	}
	$chatId = g ( "chatid");
	$userId = g ( "userid");
	$append = "";

	$sql = "select aa.*,cc.* from lv_chat as aa,lv_user as cc where aa.UserId=cc.UserId and aa.ChatId=".$chatId;
	$db = new DB();
	$result = $db -> executeDataRow($sql) ;
   
	$db = new Model("lv_chater_theme");
	$db -> addParamWhere("Status", 1, "=", "int");
	$data = $db -> getList();
   
   $append = $printer->union ( $append, '"theme":[' . ($printer->parseList ( $data, 0 )) . ']' );
   $printer->out_detail ( $result, $append, 0 );
}

function EvaluateDetail1 () {
	global $printer;
	$chatId = g ( "chatid");
	$userId = g ( "userid");
	$append = "";

	$sql = "select * from lv_user where UserId='".$userId."'";
	$db = new DB();
	$result = $db -> executeDataRow($sql) ;
   
	$db = new Model("lv_chater_theme");
	$db -> addParamWhere("Status", 1, "=", "int");
	$data = $db -> getList();
   
   $append = $printer->union ( $append, '"theme":[' . ($printer->parseList ( $data, 0 )) . ']' );
   $printer->out_detail ( $result, $append, 0 );
}

function listRo () {
	global $printer;
	$livechat = new LiveChat ();
	$data = $livechat->listRo ();
	$printer->out_list($data,-1,0);
}

function UserForm () {
	global $printer;
	$userId = g ( "userid");
	$append = "";
	
	$livechat = new LiveChat ();
	
	$user ["userid"] = g ( "userid");
	$user ["username"] = g ( "username");
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	
	$userrow = $livechat->GetUser ( $user );
	
	$data = $livechat->listUserRo ( $userId );
	$append = $printer->union ( $append, '"userro":[' . ($printer->parseList ( $data, 0 )) . ']' );
	
	$data = $livechat->listUserForm ( $userId );
	$append = $printer->union ( $append, '"userform":[' . ($printer->parseList ( $data, 0 )) . ']' );


	$printer->out_detail ( $userrow, $append, 0 );
}

//function setUserForm () {
//	global $printer;
//	$userId = g ( "userid");
//	$typeId = g ( "typeid");
//	$to_type = g ( "to_type");
//
//	$db = new DB ();
//	switch (g ( "oType")) {
//	case 0 :
//		$sql = "Delete from lv_user_form where UserId='".$userId."' and TypeID=".$typeId." and To_Type=".$to_type." and MyID='".CurUser::getUserId()."'" ;
//		break;
//	case 1 :
//		$sql = "insert into lv_user_form(UserId,TypeID,To_Type,MyID) values('".$userId."',".$typeId.",".$to_type.",'".CurUser::getUserId()."')" ;
//		break;	
//	}
//	
////	echo $sql;
////	exit();
//	$db -> execute($sql) ;
//	$printer->success ();
//}


function LvChaterRoDetail () {
	global $printer;
	$chatId = g ( "chatid");
	$userId = g ( "userid");
	$append = "";

	$sql = "select cc.* from lv_chat as aa,lv_chater_ro as cc where aa.GroupId=cc.TypeID and aa.ChatId=".$chatId;
	$db = new DB();
	$result = $db -> executeDataRow($sql) ;
	
	$printer->out_arr ( $result );
}

function wxsignature () {
	global $printer;

	$jssdk = new JSSDK(WECHAT_APPID,WECHAT_SERCET);
	$result = $jssdk -> getSignPackage() ;
	
	$printer->out_arr ( $result );
}

function getcode () {
	global $printer;
	
	$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
	$code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".WECHAT_APPID."&redirect_uri=".phpescape($http_type.WECHAT_DOMAIN."/kefu.html?".g ( "query"))."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
//		echo $code_url;
//		exit();
	header("location:" . $code_url);
	exit;
}

function ListVisitor()
{
	Global $printer;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	if(g ( "TypeID")) $tableName = f ( "table", "(select distinct aa.* from lv_user as aa,lv_user_form as bb where aa.UserId=bb.UserId and bb.TypeID in (".g ( "TypeID").")) as cc" );
	else $tableName = f ( "table", "lv_user" );
	$fldId = f ( "fldid", "UserId" );
	$fldList = f ( "fldlist", "*" );

	switch (DB_TYPE)
	{
		case "access":
			$fldSort = f ( "fldsort", "maxTypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "maxTypeID ASC" );
			break ;
		default:
			$fldSort = f ( "fldsort", "maxTypeID DESC" );
			$fldSortdesc = f ( "fldsortdesc", "maxTypeID ASC" );
			break;
	}
	$point = (int)g("point");

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
		$data_user = $db->getList ();
	else
		$data_user = $db->getPage ( $pageIndex, $pageSize, $count );
		
	$visitdb = new DB ();
	foreach($data_user as $k=>$v){
		$sql_count = "select count(*) as c from lv_source where UserId='".$data_user[$k]['userid']."'";
		$visitcount = $visitdb -> executeDataValue($sql_count);
		$data_user[$k]['visitcount']=$visitcount;
		if(empty($data_user[$k]['username'])) $data_user[$k]['username']=$data_user[$k]["area"];
		if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
	}
		
	$printer->out_list ( $data_user, $count, 0 );

//	$msg = new Msg ();
//	$sql = "select aa.* from lv_user as aa,lv_user_form as bb where aa.UserId=bb.UserId and bb.TypeID in (".g ( "TypeID").")";
//	$result_file = $msg -> list_kefumesseng6($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
//	$data_file1 = $result_file["data_user"] ;
//	$recordcount = $result_file["count"] ;
//	$printer->out_list ( $data_file1,$recordcount, 0 );
}

function deleteUser() {
	Global $printer;
	Global $op;

	$youid = f ( "youid","");
	$myid = f ( "myid","");
	
	if((int)g ( "category")==6) $printer->success ();

	if (! $youid)
		$printer->fail ();
		
	$sql = " delete from MessengKefu_Text where (MyID='".$myid."' and YouID='".$youid."') or (YouID='".$myid."' and MyID='".$youid."')";
	$db = new DB ();
	$result = $db->execute ( $sql );

	$printer->out ( $result );
}

function ListClot_Ro() {
	global $printer;
	
	$pid = g("pid");
	$db = new Model ("lv_chater_Clot_Ro");
	$db->where ("where PID=" . $pid);
	$data = $db-> getList();
 
	$printer->out_list($data,-1,0);
}

function get_usericoline() {
	global $printer;
	
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterDetail (g("loginname"));
	$printer -> success($data ["usericoline"]);
}

function clearhistory() {
	global $printer;

	$sqls = array(
		" Delete from MessengKefu_Text where datediff(hour,To_Date,getdate())>".g("clearHistoryTime"),
		" Delete from lv_chat where datediff(hour,intime,getdate())>".g("clearHistoryTime"),
		" Delete from lv_track where datediff(hour,InTime,getdate())>".g("clearHistoryTime"),
		" Delete from lv_source where datediff(hour,InTime,getdate())>".g("clearHistoryTime"),
		" Delete from MessengKefuClot_Text where datediff(hour,To_Date,getdate())>".g("clearHistoryTime"),
		" Delete from lv_chater_KefuMsg_Acks where IsReceipt1=0 and IsReceipt2=0 and datediff(hour,To_Date,getdate())>".g("clearHistoryTime")
	) ;

	$db = new DB ();
	$result = $db->execute ( $sqls );

	$printer->out ( $result );
}
?>