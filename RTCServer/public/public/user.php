<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Passport.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Department.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Role.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/PinYin.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocDir.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocRelation.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/Doc.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocAce.class.php");?>
<?php
//header("Content-type: text/html; charset=gb2312"); 
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

//$user = new User();
//$deptPath = $user->getPath(15);


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
	case "list" :
		getList ();
		break;
	case "search" :
		search ();
		break;
	case "setpassword" :
		setPassword ();
		break;
	case "saveother" :
		saveOther ();
		break;
	case "saverole" :
		saveRole ();
		break;
	case "setdept" :
		setDept ();
		break;
	case "getrelationuser" :
		getRelationUser ();
		break;
	case "setrelationuser" :
		setRelationUser ();
		break;
	case "setrelationuser2" :
		setRelationUser2 ();
		break;
	case "setvalue" :
		setFieldValue ();
		break;
	case "setpinyin" :
		setPinYin ();
		break;
	case "setpath" :
		setPath ();
		break;
	case "set_dept_onekey":
		set_dept_onekey();
		break;
	case "setindex" :
		setindex();
		break;
	case "get_silence" :
		get_silence ();
		break;
	case "set_silence" :
		set_silence ();
		break;
	case "modify_isverify" :
		modify_isverify ();
		break;
	case "change_password" :
		change_password ();
		break;
	case "op_picture" :
		op_picture ();
		break;
	case "account_application" :
		account_application ();
		break;
	default :
		break;
}


function get_silence()
{
	Global $printer;
	$MyID = g ( "MyID" );
	$YouID = g ("YouID");
	$To_Type = g ("To_Type");
	
	$param = array("MyID"=>$MyID,"YouID"=>$YouID,"To_Type"=>$To_Type) ;
	$root = new Model("Clot_Silence");
	$root -> addParamWheres($param);
	$TypeID = $root -> getValue("TypeID");
	$printer->success ($TypeID);
}

function set_silence()
{
	Global $printer;
	$db = new DB();
	$MyID = g ( "MyID" );
	$YouID = g ("YouID");
	$To_Type = g ("To_Type");
	$Silence = g ( "Silence", 0 );
	if($To_Type==6){
		$sql = "select * from lv_chater_Clot_Ro where TypeID=" . $YouID . "";
		$row = $db->executeDataRow($sql);
		$YouID = $row['userid'];
	}
	if($Silence){
		$file_item = array();
		$file_item["MyID"] = $MyID ;
		$file_item["YouID"] = $YouID ;
		$file_item["TO_IP"] = g ("TO_IP") ;
		$file_item["Ncontent"] = g ("Ncontent") ;
		$file_item["To_Type"] = $To_Type ;
		$doc_file = new Model("Clot_Silence");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
	}else{
		 $sql = " delete from Clot_Silence where MyID='".$MyID."' and YouID='".$YouID."' and To_Type=".$To_Type ;
		 $db->execute($sql);
	}

	$printer->success ();
}

function modify_isverify()
{
	Global $printer;
	$IsVerify = g ( "IsVerify", 0 );
	
	$db = new Model("Users_ID");
	$db -> addParamField("IsVerify", $IsVerify);
	$db -> addParamWhere("UserID", CurUser::getUserId());
	$db -> update();
		
	$printer->success ();
}

function change_password()
{
	Global $printer;
	$UserPaws = g ( "UserPaws");
	
	$db = new Model("Users_ID");
	$db -> addParamField("UserPaws", $UserPaws);
	$db -> addParamWhere("UserID", CurUser::getUserId());
	$db -> update();
		
	$printer->success ();
}

function op_picture()
{
	Global $printer;
	$youid = g ("id");
	$oType = g ("oType");
	$mType = g ("mType");
	$pic = g ( "pic", 0 );

	switch ($mType)
	{
		case 1:
			$doc_file = new Model ( "Users_Pic" );
			$doc_file -> addParamWhere("UserID", $youid);
			$row = $doc_file->getDetail ();
			switch ($oType)
			{
				case 1:
					if(count($row)==0) $SeVise = 0;
					else $SeVise = $row ["pic"];
					if($pic!=$SeVise) $printer->success ($SeVise);
					else $printer -> fail();
					break ;
				case 2:
					if(count($row)==0){
						$file_item = array();
						$file_item["UserID"] = $youid ;
						$file_item["pic"] = $pic ;
						$doc_file -> clearParam();
						$doc_file -> addParamFields($file_item);
						$doc_file -> insert();
					}else{
						$doc_file -> clearParam();
						$doc_file -> addParamField("pic", $pic);
						$doc_file -> addParamWhere("UserID", $youid);
						$doc_file -> update();
					}
					break;
				case 3:
					if(count($row)==0){
						$file_item = array();
						$file_item["UserID"] = $youid ;
						$file_item["pic"] = $pic ;
						$doc_file -> clearParam();
						$doc_file -> addParamFields($file_item);
						$doc_file -> insert();
					}else{
						$doc_file -> clearParam();
						$doc_file -> addParamField("pic", $pic);
						$doc_file -> addParamWhere("UserID", $youid);
						$doc_file -> update();
					}
					$file = RTC_CONSOLE."/MyPic/".$youid.".jpg";
					if (file_exists ( $file )) unlink ( $file );
					break;
			}
			
			break ;
		case 2:
			$doc_file = new Model ( "Clot_Pic" );
			$doc_file -> addParamWhere("ClotID", $youid);
			$row = $doc_file->getDetail ();
			switch ($oType)
			{
				case 1:
					if(count($row)==0) $SeVise = 0;
					else $SeVise = $row ["pic"];
					if($pic!=$SeVise) $printer->success ($SeVise);
					else $printer -> fail();
					break ;
				case 2:
					if(count($row)==0){
						$file_item = array();
						$file_item["ClotID"] = $youid ;
						$file_item["pic"] = $pic ;
						$doc_file -> clearParam();
						$doc_file -> addParamFields($file_item);
						$doc_file -> insert();
					}else{
						$doc_file -> clearParam();
						$doc_file -> addParamField("pic", $pic);
						$doc_file -> addParamWhere("ClotID", $youid);
						$doc_file -> update();
					}
					break;
				case 3:
					if(count($row)==0){
						$file_item = array();
						$file_item["ClotID"] = $youid ;
						$file_item["pic"] = $pic ;
						$doc_file -> clearParam();
						$doc_file -> addParamFields($file_item);
						$doc_file -> insert();
					}else{
						$doc_file -> clearParam();
						$doc_file -> addParamField("pic", $pic);
						$doc_file -> addParamWhere("ClotID", $youid);
						$doc_file -> update();
					}
					$file = RTC_CONSOLE."/MyPic/".$youid.".jpg";
					if (file_exists ( $file )) unlink ( $file );
					break;
			}
			
			break;
	}
		
	$printer->success ();
}

function account_application()
{
	Global $printer;
	Global $valid_user_exist ;

	$UserName = g ("UserName");
	
	if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $UserName) > 0) $printer->fail (get_lang("register_alert5"));
	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', g ("FcName")) > 0) $printer->fail (get_lang("register_alert6"));
	
	if (USERAPPLY=='2') $printer->fail (get_lang("register_alert1"));

	$user = new Model("Users_ID","UserID");
	//判断用户是否存在
	$user_id = 0 ;
	$user -> clearParam();
	$user -> addParamWhere("UserName",$UserName);
	$valid_user_exist = $user->getCount()>0 ? true : false;
	if ($valid_user_exist) $printer->fail (get_lang("register_alert2"));
	else{
		//不存在 新增
		$user -> clearParam();
		$user_id = $user -> getMaxId();
		if(empty($user_id)) $user_id=0;
		$user_id=$user_id+1;
		$user -> addParamField("UppeID",g ("UppeID"));
		$user -> addParamField("UserID",$user_id);
		$user -> addParamField("UserIco",g ("UserIco"));
		$user -> addParamField("UserName",g ("UserName"));
		$user -> addParamField("FcName",g ("FcName"));
		$user -> addParamField("UserPaws",g ("UserPaws"));
		$user -> addParamField("Jod",g ("Jod"));
		$user -> addParamField("Tel1",g ("Tel1"));
		$user -> addParamField("Constellation",g ("Constellation"));
		$user -> addParamField("UserState",USERAPPLY);
		$user -> insert();
		$user -> insertPic($user_id);
		$PtpFolder = new User ();
		$PtpFolder -> insert2("RTC",$user_id);
		$PtpFolder -> insert3("RTC",$user_id);
		$DefaultRole = $user -> getDefaultRole();
		$user -> insertRole($user_id,$DefaultRole);
		$user -> updateForm("Users_IDVesr");
		if(USERAPPLY=='0'){
		  $result = manager_username();
		  $msg = new Msg ();
		  $msg -> sendBoard(g ("UserName"), $result, get_lang("register_alert3"), chr(34).g ("FcName")."(".g ("UserName").")".chr(34).get_lang("register_alert4"),'');	
		}else{
		  $ch = curl_init();
		  $url = "http://127.0.0.1:98/api/OnlineData.html?CmdStr=Users_ID";
		  curl_setopt($ch, CURLOPT_URL, $url); 
		  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
		  curl_exec($ch); 
		  curl_close ($ch); 	
		}
		$printer->success ();
	}
}

function setindex()
{
	Global $printer;
	$db = new DB();
	$data = $db->executeDataTable("select col_id from hs_user order by col_name asc");

	$data = table_fliter_doublecolumn($data,1);
	$i = 0;
	foreach ($data as $row)
	{
		$sql[$i] = " update hs_user set col_itemIndex=" . $i . " where col_id =" . $row['col_id'];
		$i++;
	}
	$db->execute($sql);
	$printer->success ();
}

function setPinYin() 
{
	Global $printer;

	$user = new User ();
	$user->setPinYin ();

	$printer->success ();
}

/*
method	设置部门路径
*/
function setPath() 
{
	Global $printer;

	$user = new User ();
	$user->setPath();
	$printer->success ();
}


/*
method	将col_deptinfo 设置成最后两级  新世纪版本特有功能
*/
function set_dept_onekey()
{
	Global $printer;

	$user = new User();
	
	//设置得到最后二级
	$user -> setPath("col_deptinfo",2);

	$printer -> success();

}

function setDept() 
{
	Global $printer;
	$flag = g ( "flag", 0 ); // 0 添加部门 1 重置部门
	$target = getEmpInfo ( g ( "targetid" ) );
	$targetName = g ("targetname");
	$dept_path = g("dept_path") ;
	$userId = stripslashes(g("userid")) ;
	
	$db = new DB();
	$data = $db->executeDataTable("select * from Users_ID where UserID in(" . $userId . ")");

	$i = 0;
	foreach ($data as $row)
	{
		if ($flag == 0){
			if(strpos($row['uppeid'],$target ["empid"])) $UppeID = "UppeID";
			else $UppeID = "UppeID+',".$target ["empid"].",'";
		}else $UppeID = "'".$target ["empid"]."'";
		$sql[$i] = " update Users_ID set UppeID=" . $UppeID . ",Users_IDVesr=Users_IDVesr + 1 where UserID ='" . $row['userid'] . "'";
		$i++;
	}
	$db->execute($sql);

//	$db = new DB();
//	if ($flag == 0) $UppeID = "UppeID+',".$target ["empid"].",'";
//	else $UppeID = "'".$target ["empid"]."'";
//	$sql = " update Users_ID set UppeID=" . $UppeID . " where UserID in(" . $userId . ")";
//	$db->execute($sql);
	$user = new User ();
	$user -> updateForm("Users_IDVesr");
	$printer->success ();
}

function saveOther()
 {
	Global $printer;

	$userId = stripslashes(g ( "userid" ));

	if ($userId == "")
		$printer->fail ();

	$user = new User ();
	$user->where ( " where UserID in(" . $userId . ")" );
	$password = g ( "col_userpaws" );
	if ($password != "******") {
		$user->addParamField ( "UserPaws", $password );
	}
	$user->addParamField ( "MacList", g ( "col_farserver" ) );
	$user->addParamField ( "LocalIPList", g ( "col_ipaddr" ) );
	$user->update ();

	$printer->success ();
}

function saveRole()
 {
	Global $printer;

	$userId = stripslashes(g ( "userid" ));
	$userId = str_replace("'","",$userId);

	if ($userId == "")
		$printer->fail ();

	$user = new User ();
//	$user->where ( " where UserID in(" . $userId . ")" );
//	$user->addParamField ( "MacList", g ( "col_farserver" ) );
//	$user->addParamField ( "LocalIPList", g ( "col_ipaddr" ) );
//	$user->update ();
	
	$arruser = explode ( ",", $userId );
	$arrroleid = explode ( ",", g("roleid") );
	foreach ( $arruser as $id ) {
	$user -> delete_Role($id);
	foreach ( $arrroleid as $roleid ) {
		if ($roleid != "") {
				$user -> insertRole($id,$roleid);
		}
	}
	}

	$printer->success ();
}


function save() 
{
	Global $printer;
	Global $op;

	//if (preg_match('/[\x{4e00}-\x{9fa5}]/u', g ("username")) > 0) $printer->fail (get_lang("register_alert5"));
	
	$user = new User ();

	$result = $user->autoSave ();
	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	$userId = $result ["id"];

	// create relation
//	if ($op == "create") {
//		$nodeId = g ( "deptid" );
//		$parent = getEmpInfo ( $nodeId );
//		$dept_name = g("col_deptinfo");
//		$dept_path = g("col_alldeptinfo") ;
//		
//		$relation = new EmpRelation ();
//		$relation->insert ( $parent ["viewid"], $parent ["emptype"], $parent ["empid"], $dept_name, EMP_USER, $userId, g("col_name"),$dept_path);
// 
//	}

//	// 设置拼音
//	$py = new PinYin ();
//	$name = g ( "col_name" );
//
	$field_update = array ();
//
//	$all_py = strtoupper($py->getAllPY ( $name ));
//	$first_py = strtoupper($py->getFirstPY ( $name ));
//
//
//	//英文为空
//	if($all_py == "")
//		$all_py = $first_py = strtoupper($name) ;
//
//	$field_update = array ();
//	$field_update ["col_allspell"] = $all_py;
//	$field_update ["col_firstspell"] = $first_py;
//    $field_update ["UserState"] = f ( "userstate" )==0?1:0;
	// 设置密码
//	$password = f ( "userpaws" );
//	if ($password != "******") {
//		$field_update ["userpaws"] = $password;
//	}

	// 更新数据
	if (count ( $field_update ) > 0) {
		$user->clearParam ();
		$user->addParamFields ( $field_update );
		$user->addWhere ( "UserID='" . $userId ."'");
		$user->update ();
	}
    if ($op == "create") {
	$user -> insertPic($userId);
	$user -> insert2("RTC",$userId);
	$user -> insert3("RTC",$userId);
	}
	$user -> delete_Role($userId);
	
	$arrroleid = explode ( ",", g("roleid") );
	foreach ( $arrroleid as $roleid ) {
		if ($roleid != "") {
				$user -> insertRole($userId,$roleid);
		}
	}
	$user -> updateUsers_IDForm($userId);
	$user -> updateForm("Users_IDVesr");
	$printer->success ();
}
function delete() {
	Global $printer;
	$arrUserId = explode ( ",", stripslashes(g ( "userid" )) );

	$user = new User ();
	$sql = "select * from OtherForm where ID=1" ;
	$data = $user -> db -> executeDataRow($sql);
	$User_ID=$data["user_id"];
	foreach ( $arrUserId as $userId ) {
		if ($userId){
			// 删除文件
			$file = RTC_CONSOLE."/MyPic/".str_replace("'","",$userId).".jpg";
			if (file_exists ( $file )) unlink ( $file );
			$result = $user->deleteAnUser ( $userId );
			$User_ID=str_replace(",".str_replace("'","",$userId).",",",",$User_ID);
		}
	}
	$sql = " update OtherForm set User_ID='" .$User_ID. "' where id=1" ;
	$user -> db -> execute($sql);
	$user -> updateForm("Users_IDVesr");
	$printer->out ( $result );
}

function detail() {
	Global $printer;

	$user = new User ();
	$userId = g ( "id", 0 );
	$append = "";
	
    if($userId!=0){
	$user->addWhere ( "UserID='" . $userId . "'");
	$userrow = $user->getDetail ();
	// role
	$data = $user->listRole ( $userId );
	$append = $printer->union ( $append, '"roles":[' . ($printer->parseList ( $data, 0 )) . ']' );
	}

	$role = new Role ();
	// org
	$data = $role->listOrgAce ();
	$append = $printer->union ( $append, '"orgs":[' . ($printer->parseList ( $data, 0 )) . ']' );

//	// power
//	$data = $role->listFunACE ( $roleIds );
//	$ace = $role->getFunACE ( $data );
//	$ace_str = "\"baseace\":" . $ace ["baseace"] . ",\"attachsize\":" . $ace ["attachsize"] . ",\"attachsends\":" . $ace ["attachsends"];
//	$append = $printer->union ( $append, "\"ace\":{" . $ace_str . "}" );

	$printer->out_detail ( $userrow, $append, 0 );
}
function getList() {
	Global $printer;

	$nodeId = g ( "deptid" );
	$key = g ( "key" );
	$parent = getEmpInfo ( $nodeId );
	$viewId = $parent ["viewid"];
	$empType = $parent ["emptype"];
	$empId = $parent ["empid"];
	$fields = g ( "fldlist", " *" );
	
	$label = g("label");
	if ($label == "users_ro")
	{
		doc_list_users_ro();
		return ;
	}
	
	if ($label == "users_id")
	{
		doc_list_users_id();
		return ;
	}
	
	if ($label == "clot_ro")
	{
		doc_list_clot_ro();
		return ;
	}
	
	if ($label == "search")
	{
		doc_list_clot_ro_search();
		return ;
	}
	
	if ($label == "clot_form")
	{
		doc_list_clot_form();
		return ;
	}
	
	if ($label == "fav_form")
	{
		doc_list_fav_form();
		return ;
	}
	
	if ($label == "plug")
	{
		doc_list_plug();
		return ;
	}
	
	if ($label == "other_tables")
	{
		doc_list_other_tables();
		return ;
	}
	
	if ($label == "online_list")
	{
		doc_list_online_list();
		return ;
	}
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

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	// 得到本部门
	$where = " where UppeId like '%" . $empId . "%' ";

	if ($key != "")
		$where .= " and (FcName like '%" . $key . "%' or UserName like '%" . $key . "%')";

	$db = new Model ( "Users_ID" );
	$db->order ( $fldSort );
	$db->orderdesc ( $fldSortdesc );
	$db->field ( $fields );
	$db->where ( $where );
	$count = $db->getCount ();
	if ($ispage == 0)
		$data = $db->getList ();
	else
		$data = $db->getPage ( $pageIndex, $pageSize, $count );
		//echo "->".$count."</br>";
		//var_dump ($data);
	$printer->out_list ( $data, $count,0 );
}

function doc_list_online_list() {
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
		
	$dept = new Department();
	foreach($data as $k=>$v){
		$data[$k]['path'] = $dept -> getSubDeptNameByUser($data[$k]['uppeid']);
	}
		//echo var_dump($data);
	$printer->out_list ( $data, $count, 0 );
}


function doc_list_users_ro()
{
	Global $printer;
	$vesr = g("vesr");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file2($vesr);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["vesr"] ;

	$printer -> out_list($data_file,$recordcount,0);
}

function doc_list_users_id()
{
	Global $printer;
	$vesr = g("vesr");
	$UserIds = g("UserIds");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file3($vesr,$UserIds);
	$data_file1 = $result_file["data"] ;
	$data_file2 = $result_file["data1"] ;
	$recordcount = $result_file["vesr"] ;

	//$printer -> out_list1($data_file,$recordcount,0);
	$printer->out_list1 ( $data_file1,$data_file2,$data,$recordcount, 0 );
}


function doc_list_clot_ro()
{
	Global $printer;
	$vesr = g("vesr");
	$Clot_Ros = g("Clot_Ros");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file4($vesr,$Clot_Ros);
	$data_file1 = $result_file["data"] ;
	$data_file2 = $result_file["data1"] ;
	$recordcount = $result_file["vesr"] ;

	$printer->out_list1 ( $data_file1,$data_file2,$data,$recordcount, 0 );
}

function doc_list_clot_ro_search()
{
	Global $printer;
	$key = g("key") ;
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file9($key);
	$data_file = $result_file["data"] ;

	$printer -> out_list($data_file,-1,0);
}



function doc_list_clot_form()
{
	Global $printer;
	$vesr = g("vesr");
	$Clot_Forms = g("Clot_Forms");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file5($vesr,$Clot_Forms);
	$data_file1 = $result_file["data"] ;
	$data_file2 = $result_file["data1"] ;
	$recordcount = $result_file["vesr"] ;

	$printer->out_list1 ( $data_file1,$data_file2,$data,$recordcount, 0 );
}

function doc_list_fav_form()
{
	Global $printer;
	$vesr = g("vesr");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file6($vesr);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["vesr"] ;

	$printer -> out_list($data_file,$recordcount,0);
}

function doc_list_plug()
{
	Global $printer;
	$vesr = g("vesr");
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file7($vesr);
	$data_file = $result_file["data"] ;
	$recordcount = $result_file["vesr"] ;

	$printer -> out_list($data_file,$recordcount,0);
}

function doc_list_other_tables()
{
	Global $printer;
	$user = new User ();
	$data = array();
	//加载文件
	$result_file = $user -> list_file8($vesr);
	$data_file = $result_file["data"] ;

	$printer -> out_list($data_file,-1,0);
}

function search() {
	Global $printer;
	$top = g ( "top", 10 );
	$key = g ( "key" );
	$field_search = g ( "field_search", "FcName,UserName" );
	$field_list = g ( "field_list", "UserID as id,FcName as name,UserName as loginname" );
	$field_order = "";

	$where = "";

	$fields = explode ( ",", $field_search );
	foreach ( $fields as $field ) {
		if ($field_order == "")
			$field_order = $field;
		$where .= ($where ? " or " : " where ") . $field . " like '%" . $key . "%'";
	}

	$db = new Model ( "Users_ID" );
	$db->where ( $where );
	$db->order ( $field_order );
	$db->field ( $field_list );
	$data = $db->getTop ( $top );
	$printer->out_list ( $data, -1, 0 );
}



function setPassword() {
	Global $printer;
	$userId = CurUser::getUserId ();
	$old_password = f ( "old_password" );
	$new_password = f ( "new_password" );

	$user = new User ();
	$result = $user->setPassword ( $userId, $old_password, $new_password );
	$printer->out ( $result ["status"], "errnum:" . $result ["errnum"] );
}

// 得到关连的数据
function getRelationUser() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;

	$relation = new EmpRelation ();

	$data = $relation->getRelationData ( $parentEmpType, $parentEmpId, $childEmpType );

	$printer->out_list ( $data, -1, 0 );
}

// 设置关系的数据 db:1,2,5 curr:1,2,3,4 delete:5 insert:3,4
function setRelationUser() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;
	$childEmpId = g ( "userid" );
	$flag = g ( "flag", 1 );

	$relation = new EmpRelation ();

	$relation->setRelation ( 0, $parentEmpType, $parentEmpId, "", $childEmpType, $childEmpId, $flag );
	
	$db = new User ();
	$db -> updateForm("Clot_FormVesr");
	$db -> updateClot_RoForm("Users_FormVesr",$parentEmpId);
	$printer->Success ();
}


function setFieldValue() {
	Global $printer;

	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );

	if (! $id)
		$printer->fail ();

	$db = new User ();
	$result = $db->setValue ( $id, $fldname, $fldvalue );
	$db -> updateForm("Users_IDVesr");
	$db -> updateUsers_IDForm($id);
	$printer->out ( $result );
}

// 设置关系的数据 db:1,2,5 curr:1,2,3,4 delete:5 insert:3,4
function setRelationUser2() {
	Global $printer;

	$parentEmpType = g ( "parentEmpType" );
	$parentEmpId = g ( "parentEmpId" );
	$childEmpType = EMP_USER;
	$childEmpId = g ( "userid" );
	$flag = g ( "flag", 1 );

	$relation = new EmpRelation ();

	$relation->setRelation2 ( 0, $parentEmpType, $parentEmpId, "", $childEmpType, $childEmpId, $flag );
	//exit();
	$db = new User ();
	$db -> updateForm("PtpFolder_Vesr");
	$printer->Success ();
}

?>