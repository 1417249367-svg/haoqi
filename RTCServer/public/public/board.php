<?php  require_once("../class/fun.php");?>
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
function get_list() {
	Global $printer;
	
	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	$tableName = f ( "table", "board" );
	$fldList = f ( "fldlist", "col_id,col_creator_id,col_creator_name,col_subject,col_attachmentcount,col_clickcount,col_dt_create,col_ispublic,col_creator" );
	$fldSort = f ( "fldsort", "col_id" );
	$where = f ( "wheresql", "" );
	
	$board = new Model ( "board" );
	
	// 根据组织树查询(某部门创建的)
	$nodeid = g ( "nodeid" );
	if ($nodeid != "") {
		// 根据部门查询
		$arr_node = explode ( "_", $nodeid );
		if (count ( $arr_node ) > 3) {
			$emp_type = $arr_node [1];
			$emp_id = $arr_node [2];
//			$ids = "";
//			$relation = new EmpRelation ();
//			$ids = $relation->getChildIds ( $emp_type, $emp_id, 1 );
//			
//			if ($ids == "")
//				$ids = "0";
//			
//			$db = new DB ();
//			$field_loginname = $db->getSelectFieldAdd ( "col_loginname", "'" . RTC_DOMAIN . "'" );
			$where = getWhereSQL ( $where, " col_creator in(select UserName from Users_ID where UppeID like '%" . $emp_id . "%') " );
		}
		
		// 权限判断
		$currLoginName = g ( "loginname" );
		$where = getWhereSQL ( $where, " (col_ispublic=1 or col_creator='" . $currLoginName . "' or col_id in(select col_boardid from board_visiter where col_hsitem='" . $currLoginName . "'))" );
	}
	
	$board->where ( $where );
	$count = $board->getCount ();
	
	$board->order ( $fldSort );
	$board->field ( $fldList );
	if ($ispage == 0)
		$data = $board->getList ();
	else
		$data = $board->getPage ( $pageIndex, $pageSize, $count );
		
		
	foreach($data as $k=>$v){
		$doc_file = new Model ( "Board_Visiter" );
		$doc_file -> addParamWhere("Col_HsItem_ID", CurUser::getUserId());
		$doc_file -> addParamWhere("col_BoardID",$data[$k]['col_id']) ;
		$doc_file -> addParamWhere("col_Readed",1) ;
		$row = $doc_file->getDetail ();
		if(count($row)==0) $data[$k]['col_readed']=0;
		else $data[$k]['col_readed']=1;
	}
	
	$printer->out_list ( $data, $count, 0 );
}

?>