<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Role.class.php");?>
<?php
set_time_limit(0);
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
	case "list" :
		getList ();
		break;
	case "setvalue" :
		setFieldValue ();
		break;
    case "role_one_key":
        role_one_key();
        break;
	default :
		break;
}
function save() {
	Global $printer;
	Global $op;
	
	$role = new Role ();
	$result = $role->autoSaveRole ();
	
	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else {
		$roleId = $result ["id"];
//		$power = g ( "powers", 0 );
//		$attachSize = g ( "attachSize", 0 );
//		$mSends = g ( "msends", 0 );
//		$memberIds = g ( "memberIds" );
//		$orgIds = g ( "orgIds" );
//		
//		$role->setMember ( $roleId, $memberIds, 1 );
//		$role->setOrgAce ( $roleId, $orgIds, 1 );
//		$role->setFunACE ( $roleId, $power, $attachSize, $mSends );
		
		$printer->success ();
	}
}
function delete() {
	Global $printer;
	$arrId = explode ( ",", g ( "id" ) );
	
	$role = new Role ();
	foreach ( $arrId as $id ) {
		if ($id)
			$result = $role->deleteAnRole ( $id );
	}
	
	$printer->out ( $result );
}
function detail() {
	Global $printer;
	
	$role = new Role ();
	$roleId = g ( "id", 0 );
	
	$role->addWhere ( "ID=" . $roleId );
	$role_row = $role->getDetail ();
	$append = "";
	
	// member
//	$data = $role->listMember ( $roleId );
//	$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );
	
	// org
	//$orgIds = "";
	//$data = $role->listOrgAce ( $roleId );
	//foreach ( $data as $row )
		//$orgIds = $data ["DepartmentPermission"] . "_" . $data ["Department"];
	//$append = $printer->union ( $append, "\"role\":" . ($printer->parseList ( $data, 0 )) . "" );
	
	// power
	//$data = $role->listFunACE ( $roleId );
	//$ace = $role->getFunACE ( $data );
	//$ace_str = "\"baseace\":" . $ace ["baseace"] . ",\"attachsize\":" . $ace ["attachsize"] . ",\"attachsends\":" . $ace ["attachsends"];
	//$append = $printer->union ( $append, "\"ace\":{" . $ace_str . "}" );
	
	$printer->out_detail ( $role_row, $append,0 );
}
function getList() {
	Global $printer;
	
	$fldList = f ( "fldlist", "*" );
	$fldSort = f ( "fldsort", "ID" );
	$fldSortdesc = f ( "fldsortdesc", "ID desc" );
	$where = stripslashes(f ( "wheresql", "" ));
	
	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );
	
	$db = new Model ( "Role" );
	$db->where ( $where );
	$count = $db->getCount ();
	
	$db->order ( $fldSort );
	$db->orderdesc ( $fldSortdesc );
	$db->field ( $fldList );
	$data = $db->getPage ( $pageIndex, $pageSize, $count );
	$printer->out_list ( $data, $count, 0 );
}
function setFieldValue() {
	Global $printer;
	
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" );
	
	if (! $id)
		$printer->fail ();
	
	$db = new Model ( "Role" );
	$result = $db->setDefaultRole ( $id, $fldname, $fldvalue );
	
	$printer->out ( $result );
}


////////////////////////////////////////////////////////////////////////

function role_one_key(){
    Global $printer;

    //遍历视图
    $m = new Model("hs_view");
    $m->addParamWhere("col_type",1,"=","int");
    $m->field = "col_id,col_name";
    $arrView = $m->getList();
    foreach($arrView as $row){
        $roleId = add_role($row['col_id'],$row['col_name'],4);

        $orgIds = get_sub_dept_ids($row['col_id'],4);

        $orgIds = $row['col_id'] . "," .$orgIds;

        set_role_ace($roleId,$orgIds);
    }

    //遍历Group
    $m->tableName = "hs_group";
    $m->clearParam();
    $m->addParamWhere("col_style",1,"=","int");
    $arrGroup = $m->getList();
    foreach($arrGroup as $row){
        $roleId = add_role($row['col_id'],$row['col_name'],2);
        $orgIds = get_orgIds($row['col_id'],2);
        $subIds = get_sub_dept_ids($row['col_id'],2);
        if($subIds != "")
            $orgIds .= "," . $subIds;
        set_role_ace($roleId,$orgIds);
    }

    $printer->success ();
}

//设置角色的组织权限
function set_role_ace($roleId,$orgIds){
    $role = new Role();
    $arrOrg = explode(",",$orgIds);
    $orgIds = "";
    foreach($arrOrg as $key=>$val)
    {
        if($key == 0)
            $orgIds = "4_" . $val;
        else
            $orgIds .= "," . "2_" . $val;
    }
    $role->setOrgAce($roleId,$orgIds,0);
}


/*
method	得到他的组织
*/
function get_orgIds($empId,$empType)
{
    $orgIds = "";
    $rel = new EmpRelation();
    $path_data = $rel-> get_path_data($empType,$empId);
	$orgId = $path_data[0]["empid"] ;
	
	
    $path = $orgId . "/" . $empId;
    $arrPath = explode("/",$path);
    $len =count($arrPath);
    for($i=1;$i<$len;$i++)
    {
        if($i != 1)
            $orgIds .= ",";
        $orgIds .= $arrPath[$i];
    }
    return $orgIds;
}

function get_sub_dept_ids($empId,$empType){
    $m = new Model("hs_relation");
    $m->clearParam();
    $m->addParamWhere("col_hsitemid",$empId,"=","int");
    $m->addParamWhere("col_hsitemtype",$empType,"=","int");
    $m->addParamWhere("col_dhsitemtype",2,"=","int");
    $deptIds = $m->getField("col_dhsitemid");
    return $deptIds;
}

//创建角色并设置角色成员
function add_role($empId,$empName,$empType){
    $role = new Role ();
    $roleName = "OneKey_". ($empType==4 ? "View" : "Group") . "_" . $empName . "_" . $empId;
    $roleDesc = get_lang("role_warning");
    $creatorName = CurUser::getUserName();
    $role->addParamWhere("col_name",$roleName,"=","string");
    $roleId = $role->getValue("col_id");
    if($roleId != "")
        $role->deleteAnRole($roleId);

    $role->clearParam();

    $fields = array (
        'col_name' => $roleName,
        'col_description' => $roleDesc,
        'col_disabled' => 0,
        'col_appname' => "RTC",
        'col_creator_name' => $creatorName
    );
    $roleId = $role->save ( $fields );

    set_role_member($roleId,$empId,$empType);

    return $roleId;
}

function set_role_member($roleId,$empId,$empType)
{
    $m = new Model("hs_relation");
    $m->clearParam();
    $m->addParamWhere("col_hsitemid",$empId,"=","int");
    $m->addParamWhere("col_hsitemtype",$empType,"=","int");
    $m->addParamWhere("col_dhsitemtype",1,"=","int");
    $memberIds = $m->getField("col_dhsitemid");
    $m->clearParam();
    $m->addParamWhere("col_hsitemid","select col_dhsitemid from hs_relation where col_hsitemid=" . $empId . " and col_hsitemtype=" . $empType . " and col_dhsitemtype=2","in","");
    $m->addParamWhere("col_hsitemtype",2,"=","int");
    $m->addParamWhere("col_dhsitemtype",1,"=","int");
    $childMemberIds = $m->getField("col_dhsitemid");
    if($childMemberIds != "")
        $memberIds .= "," . $childMemberIds;
    $role = new Role();
    $role->setMember ( $roleId, $memberIds, 1 );
}
?>