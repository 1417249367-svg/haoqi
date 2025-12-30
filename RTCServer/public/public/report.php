<?php  require_once("../class/fun.php");?>
<?php  require_once(__ROOT__ . "/class/doc/Doc.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgReader.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpRelation.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "create" :
		save ();
		break;
	case "delete" :
		delete ();
		break;
	case "get_content" :
		get_content ();
		break;
	case "list" :
		get_list ();
		break;
	default :
		break;
}

function save() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSave1 ();

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
		
	$groupId = g ( "col_id" );
	$relation = new EmpRelation ();
	if(g ( "board_attach" )) $relation -> setRelation5 ( 0, EMP_GROUP, $groupId, "", EMP_USER, g ( "board_attach" ), $flag );
	if(g ( "col_ispublic" )) $receivers="*";
	else{ 
		$memberIds = g ( "memberIds" );
		$fields = explode ( ",", $memberIds );
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$receivers.=$my_ids[1].",";
		}
		$relation -> setRelation4 ( 0, EMP_GROUP, $groupId, "", EMP_USER, $memberIds, $flag );
	}

	$dp = new Model ( "Plug" );
	$dp->addParamWhere ( "Plug_Name", "Board" );
	$row = $dp->getDetail ();
	
	$attachMent=str_replace("board_list","board_detail",$row ["plug_target"])."*TargetType=1*boardId=".$groupId;
	$msg = new Msg ();
	$msg -> sendBoard(CurUser::getLoginName(), $receivers, g ( "col_subject" ), g ( "col_content" ),$attachMent);
	
	$printer->success ();
}

function get_content() {
	Global $printer;
	
	$id = g ( "id" );
	
//	if (! strpos ( $id, "{" ))
//		$id = "{" . $id . "}";
	$dp = new Model ( "board" );
	$dp->addParamWhere ( "col_id", $id );
	$row = $dp->getDetail ();
	
	$doc_file = new Model("Board_Visiter");
	if($row ["col_ispublic"]){
		$file_item = array();
		$file_item["col_BoardID"] = $id ;
		$file_item["Col_HsItem"] = CurUser::getLoginName() ;
		$file_item["Col_HsItem_Name"] = CurUser::getUserName() ;
		$file_item["Col_HsItem_ID"] = CurUser::getUserId() ;
		$file_item["col_Readed"] = 1 ;
		$file_item["col_Dt_Readed"] = getNowTime() ;
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
	}else{
		//$doc_file -> addParamFields($fields);
		$doc_file -> addParamField("col_Readed", 1);
		$doc_file -> addParamField("col_Dt_Readed", getNowTime());
		$doc_file -> addParamWhere("Col_HsItem_ID", CurUser::getUserId());
		$doc_file -> addParamWhere("col_BoardID",$id) ;
		$doc_file -> update();
	//$sql = "update Board_Visiter set col_Readed=1,col_Dt_Readed='".getNowTime()."' and Col_HsItem='".g ( "loginname" )."' where col_BoardID='" . $id . "'" ;
	}
//	echo $sql;
//	exit();
//	$dp -> db -> execute($sql);
	
	// 取出TEXT中的内容
	$html = $row ["col_content"];
	$datapath = date ( "Ymd", strtotime ( $row ["col_dt_create"] ) );
	
	$reader = new MsgReader ();
	$data = array();
	$sql = "Select * from Board_Attach where Col_BoardID='".$id."'";
	$data = $dp -> db -> executeDataTable($sql);
	foreach($data as $k=>$v){
		if(get_file_style($data[$k]['col_filename'])==2) $fileType=0;
		else $fileType=1;
		$content = $reader->get_file_html($id,$fileType,$data[$k]['col_filename'],$data[$k]['col_filesize'],$data[$k]['col_filepath'],$data[$k]['col_id']);
		$html=$html.$content;
	}
	
	$printer->out_str ( $html );
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
	
	if ($label == "leavefile")
	{
		doc_list_leavefile();
		return ;
	}
	
	if ($label == "groupkefumsg")
	{
		doc_list_groupkefumsg();
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
		$html .= '<span class="msg-date">' . $row ["col_senddate"] . '</span>';
		$html .= '<div class="msg-content">';
		$reader->read ( $row ["col_id"], $row ["col_datapath"] );
		$html .= $reader->html;
		$html .= '</div> ';
		$html .= '</div>';
	}
	
	$html = $count . ";" . $html;
	
	$printer->out_str ( $html );
}

function doc_list_leavefile()
{
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
		
	$db = new Model("Users_ID");
	foreach($data as $k=>$v){
		$db -> clearParam();
		$db -> addParamWhere("userid",$data[$k]['userid1']);
		$detail =  $db -> getDetail() ;
		$data[$k]['myfcname']=$detail ["fcname"];
		
		$db -> clearParam();
		$db -> addParamWhere("userid",$data[$k]['userid2']);
		$detail =  $db -> getDetail() ;
		$data[$k]['youfcname']=$detail ["fcname"];
	}
		
	$printer->out_list ( $data, $count, 0 );
}

function doc_list_groupkefumsg()
{
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
		
//	$msg_db = new DB();
//	foreach($data as $k=>$v){
//		$sql = "select cc.* from lv_chater_Clot_Ro as aa,lv_chater_ro as cc where aa.PID=cc.TypeID and aa.TypeID=".$data[$k]['clotid'];
//		$row = $msg_db->executeDataRow($sql);
//		$data[$k]['typename'] = $row['typename'];
//	}
		
	$printer->out_list ( $data, $count, 0 );
}

function delete() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$id = g ( "id" );

	if (! $id)
		$printer->fail ();

//    if($tableName=="AdminGrant"){
//	$sql = " delete from " . $tableName . " where " . $fldId . "=" . $id;
//	}else{
//	$id = "'" . str_replace ( ",", "','", $id ) . "'";
//	$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
//	}
	
	switch ($tableName)
	{
		case "AdminGrant":
			$sql = " delete from " . $tableName . " where " . $fldId . "=" . $id;
			break ;
		case "lv_message":case "lv_chat":case "lv_chater":
			$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
			break ;
		default:
			$id = "'" . str_replace ( ",", "','", $id ) . "'";
			$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
			break;
	}
	$db = new DB ();
	$result = $db->execute ( $sql );

	$printer->out ( $result );
}

?>