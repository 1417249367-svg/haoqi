<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Group.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Tag.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");?>

<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php


$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "delete" :
		delete ();
		break;
	case "detail" :
		detail ();
		break;
	case "list":
		getList();
		break ;
	case "setvalue" :
		setFieldValue ();
		break;
	default :
		break;
}


function getList() {
	Global $printer;

	$tableName = f ( "table", "clot_ro" );
	$fldId = f ( "fldid", "typeid" );
	$fldList = f ( "fldlist", "*" );
	$fldSort = f ( "fldsort", "typeid" );
	$fldSortdesc = f ( "fldsortdesc", "typeid desc" );
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
//$db = new DB();
//$sqls= "SELECT * from (SELECT TOP 1 * FROM (SELECT TOP 20 * FROM clot_ro order by typeid) A order by typeid desc) B order by typeid";
//$getResults=$db -> executeDataTable($sqls,$params,1,0);
////$getResults= sqlsrv_query($conn, $tsql);
//echo var_dump($getResults);
//exit();
	$printer->out_list ( $data, $count, 0 );
}

function save() {
	Global $printer;
	Global $op;
	$filefactpath = g ( "filefactpath", "" );
	$group = new Group ();

	$result = $group->autoSaveGroup ();

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );

	$groupId = $result ["id"];

    if ($op == "create") {
	$sql = "INSERT INTO Clot_Pic(ClotID) values('". $groupId ."')";
	$group -> db -> execute($sql);
	}

	$memberIds = g ( "memberIds" );
	$group->setMember ( $groupId, $memberIds, 1 );

//	$tag = new Tag ();
//	$tagIds = g ( "tagIds" );
//	$tag->setTag ( 4, $groupId, $tagIds, 1 );

//	// 如果新上传了头像则要裁剪
//	if ($filefactpath != "") {
//			$filesaveas = g ( "filesaveas" );
//			mkdirs(RTC_DATADIR . "\\WebRoot\\Faces");
//			copy($filefactpath, RTC_DATADIR . "\\WebRoot\\Faces\\" . $filesaveas);
//
//
//			//裁剪不支持png图片   2015.01.23
//			/*
//			$t = new ThumbHandler ();
//			$t->setSrcImg ( $filefactpath );
//			$t->setCutType ( 1 );
//			$t->setDstImg ( RTC_DATADIR . "\\WebRoot\\Faces\\" . $filesaveas );
//			$t->createImg ( 85, 85 );
//			*/
//
//	}
	$group -> updateForm("Clot_RoVesr");
	$group -> updateForm("Clot_FormVesr");
	$group -> updateForm("ClotFile_Vesr");
	$group -> updateClot_RoForm("Users_IDVesr",$groupId);
	$group -> updateClot_RoForm("Users_FormVesr",$groupId);
	if (! $result ["status"])
	{
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	}
	else
	{
	    //发送推送  
	    //AntSync::sync_push("GROUP", $groupId, strtoupper($op));
	    $printer->success ();
	}
}
function delete() {
	Global $printer;
	Global $op;
	$arrGroupId = explode ( ",", g ( "id" ) );

	$group = new Group ();
	foreach ( $arrGroupId as $groupId )
	{
		if ($groupId)
		{
			$file = RTC_CONSOLE."/MyPic/".$groupId.".jpg";
			if (file_exists ( $file )) unlink ( $file );
			$result = $group->deleteAnGroup ( $groupId );
			//发送推送
//			if($result == 1)
//			    AntSync::sync_push("GROUP", $groupId, strtoupper($op));
		}
	}
	$group -> updateForm("Clot_RoVesr");
	$group -> updateForm("Clot_FormVesr");
	$group -> updateForm("ClotFile_Vesr");
	$printer->out ( $result );
}
function detail() {
	Global $printer;

	$group = new Group ();
	$groupId = g ( "id", 0 );
	$group->field ( "*" );
	$group->addWhere ( "TypeID='" . $groupId . "'" );
	$row_group = $group->getDetail ();

	$append = "";
	$sql = "select pic from Clot_Pic where ClotID='". $groupId ."'" ;
	$data = $group -> db -> executeDataTable($sql);
	$append = $printer->union ( $append, '"pic":[' . ($printer->parseList ( $data, 0 )) . ']' );
	// member
	$data = $group->listMember ( $groupId );
	$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );

	$printer->out_detail ( $row_group, $append, 0 );
}
function setFieldValue() {
	Global $printer;

	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new Model("Clot_Ro","TypeID");
	$result = $db->setValue ( $id, $fldname, $fldvalue );
	$db -> updateForm("Clot_RoVesr");
	$group -> updateClot_RoForm("Users_IDVesr",$id);
	$printer->out ( $result );
}

?>