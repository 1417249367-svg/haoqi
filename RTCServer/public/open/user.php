<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Passport.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Department.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Role.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/PinYin.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "get_user_depts": //定制项目中使用 20150525
		get_user_depts();
		break ;
	case "get_dept_with_loginname": //定制项目中使用 201500608
		get_dept_with_loginname();
		break ;
	case "get_user_online_status":
		get_user_online_status();
		break ;
	default :
		die("aaa");
		break;
}


/*
method	根据人员姓名得到部门
return
<data>
  <user id="1" loginname="aa">
	<dept id="emptype_empid" path="触点软件/开发一部" />
    <dept id="emptype_empid" path="触点软件/开发二部" />
  </user>
<data>
*/
function get_user_depts()
{
	$username = g("username");

	$relation = new EmpRelation();
	$xml = "";
	
	//根据用户姓名得到ID
	$sql = " select col_id,col_name,col_loginname from hs_user where col_name='" . $username . "'" ;
	$data_user = $relation  -> db -> executeDataTable($sql);
	

	//根据用户ID，得到所在的部门
	foreach($data_user as $row_user)
	{
		$xml .= "<user id=\"" . $row_user["col_id"] . "\" username=\"" . $row_user["col_name"] . "\" loginname=\"" . $row_user["col_loginname"] . "\">" ;

		//根据所在部门得到部门路径
		$data_dept = get_user_depts_with_userid($row_user["col_id"]);
		$xml_dept = "" ;
		foreach($data_dept as $row_dept)
		{
			$xml .= "<dept id=\"" . $row_dept["col_hsitemtype"] . "_" . $row_dept["col_hsitemid"]. "\" path=\"" . $row_dept["path_name"] . "\" />";
		}

		$xml .= "</user>" ;
	}
	$xml = "<data>" . $xml . "</data>" ;
	
	recordLog("--------------------------------");
	recordLog($xml);
	Global $printer;
	$printer -> out_xml($xml);
}


/*
method	根据帐号获取部门
return
<data>
  <dept id="emptype_empid" path_id="4_1/2_1" path_name="触点软件/开发一部" />
<data>
*/
function get_dept_with_loginname()
{
	$loginname = g("loginname");
	$loginname = removeDomain($loginname);
	$relation = new EmpRelation();
	$xml = "";
	
	//根据用户姓名得到ID
	$sql = " select col_id as c from hs_user where col_loginname='" . $loginname . "'" ;
	$user_id = $relation  -> db -> executeDataValue($sql);
	
	//根据用户ID，得到所在的部门
	$data_dept = get_user_depts_with_userid($user_id);
	foreach($data_dept as $row_dept)
	{
		$id  = $row_dept["col_hsitemtype"] . "_" . $row_dept["col_hsitemid"] ;
		$path_id = $row_dept["path_id"] ;
		$path_name = $row_dept["path_name"] ;
		$xml .= "<dept id=\"" . $id . "\" path_id=\"" . $path_id . "\"  path_name=\"" . $path_name . "\" />";
	}
	$xml = "<data>" . $xml . "</data>" ;
	
	Global $printer;
	$printer -> out_xml($xml);
}

/*
method	根据用户ID，得到用户部门 （上级部门）
return	array(array("col_hsitemtype"=>2,"col_hsitemid"=>1,"dept_path"=>"触点软件/技术中心"))
*/
function get_user_depts_with_userid($userid)
{
	$relation = new EmpRelation();

	//得到用户的所属部门
	$sql = " select col_hsitemtype,col_hsitemid from hs_relation where col_dhsitemtype=1 and col_dhsitemid=" . $userid . 
		   " and col_viewid in(select col_id from hs_view where col_type=1)";
	$data_dept = $relation -> db -> executeDataTable($sql);
	
	foreach($data_dept as $key => $row)
	{
		//得取部门路径
		$path_data = $relation -> get_path_data($row["col_hsitemtype"],$row["col_hsitemid"],1);
		
		//得到路径
		$path = $relation -> format_path_data($path_data); 
		
		$data_dept[$key]["path_name"] = $path["path_name"] ;
		$data_dept[$key]["path_id"] = $path["path_id"] ;
	}

	return $data_dept ;
}

/*
method	得到用户在线状态
*/
function get_user_online_status()
{
	$loginnames = g("loginnames");
	
	//加入域名
	$loginnames = userAppendDomain($loginnames);

	//得到状态
	$url = "http://" . RTC_SERVER. ":" . RTC_PORT . "/syscmd?cmdname=GetJsUserState&LoginNames=" . $loginnames ;
	$url = "http://127.0.0.1:6660/syscmd.php?cmdname=GetJsUserState&LoginNames=jc@aipu.com" ;

	$content = send_http_post($url);
	
	//解析数据
	$content = str_replace("var UserList=","",$content);
	die($content);
}

?>