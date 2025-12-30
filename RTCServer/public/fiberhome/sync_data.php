<?php
require_once("fun.php");
set_time_limit(0);

//全局变量
$arrDept = array();
$modifyTime = getNowTime(); //用来判断此次更新
$path = __ROOT__ . "/data/fiberhome";

//临时表的字段
$field_user = "col_deptinfo,col_loginname,col_name,col_sex,col_email,col_mobile,col_o_jobtitle," .
			  "col_pword,col_entype,col_o_phone,col_dt_modify" ;
			  
$dataFileName ; //request.zip中的文件名  response.zip也要到这个名称

//$db = new DB("mysql","127.0.0.1","antdb41","root","www.upsoft01.com") ;
//$db = new DB("mssql","(local)","antdb41","sa","") ;

$db = new DB();

//关闭数据库日志
$db -> isLog = 0 ;



//同步数据
recordLog("sync_data:开始导入" .($db->dbType) . ":" . ($db->dbName) . ":" . getNowTime());
sync_data();

//打开数据库日志
$db -> isLog = 1 ;

//http://localhost:8041/fiberhome/sync_data.html?filename=syncdata-201505221506-request.zip
/*
method:导入组织结构(部门与人员) 注意存在的人员不能动，因为相关表有人员ID,所以只能更新，不能全部删除再导入
       1.删除临时表中不存在
	   2.更新临时表中存在
	   3.新增临时表中才有的
return:response.zip
*/
function sync_data()
{
	
	//数据定义
	global $modifyTime ;
    $fileName = g("filename","");
 
    //得到request.zip中的数据
    $arr_import = get_request_zip_data($fileName);
	

	//测试数据
	/*
	$arr_import = json_decode('{"department":[' . 
							'{"itemIndex":"99999999","path":"通讯录"}' . 
							',{"itemIndex":"1","path":"通讯录/业务产品部"}' . 
							',{"itemIndex":"99999999","path":"通讯录/业务产品部3"}' . 
							'],"user":[' .
							'{"email":"","isClear":"1","itemIndex":"99999999","jobTitle":"","loginName":"100003","mobile":"",' .
							'"passWord":"100003","passWordType":"0","path":"通讯录/业务产品部","phone":"","sex":"1","userName":"100003","userid":""}' .
							']}',true);
	*/
	

    //导入部门
    import_dept($arr_import['department']);
	recordLog("sync_data:导入部门成功" . getNowTime());
	
	
	//创建用户临时表
	create_user_temptable(); 
	recordLog("sync_data:创建用户临时表" . getNowTime());

	
    //导入人员到临时表
	import_user_temptable($arr_import['user']);
	recordLog("sync_data:导入用户到临时表成功" . getNowTime());

    //将人员从临时表导到正式表中
    import_user_from_template();
    recordLog("sync_data:导入用户到正式表成功" . getNowTime());
 	
    //更新所有的部门信息
	import_user_relation();
    recordLog("sync_data:导入用户关系成功" . getNowTime());

    //组装返回的数据文件
    sync_data_callback();
	
    //删除临时表
    drop_user_temptable(); 

    recordLog("结束导入：" . getNowTime());
	
	ob_clean();
	print("end");
}

/*
method:得到request.zip中的内容
param:$fileName request包的名称
return:json的数据包
*/
function get_request_zip_data($fileName)
{
	global $dataFileName ;
	global $path ;
	
	//得到数据文件
    $fileInfo = pathinfo($fileName);
    $dataFileName = $fileInfo['filename'] . ".txt";

    //解压文件
    $zip = new Ziper();
    $arr_zip = $zip->unZip($path . "/" . $fileName);
    $dataFilePath = $arr_zip['target'] . "/" . $dataFileName;
	
    //读数据文件
    $jsonData = trim(readFileContent($dataFilePath));
    $jsonData = @iconv("UTF-8", "UTF-8//IGNORE", $jsonData);
	
    //转成数组
    $arrData = json_decode($jsonData,true);
	
	return $arrData ;
}

function create_user_temptable()
{
	global $db;
	//创建用户临时表
    $sqlFile = __ROOT__ . "/install/dbimport/" . ($db -> dbType) . ".sql" ;
	
    $sqls = $db -> readSQLFile($sqlFile);
    $db->execute($sqls);
	
	//这里异常会执行下去，所以清除一个错误打印
	ob_clean();

}

function drop_user_temptable()
{
	global $db;
	
    //删除临时表
    $sql[] = "drop table temp_user";
	
	$db->execute($sql);
	
	//这里异常会执行下去，所以清除一个错误打印
	ob_clean();
}


/*
method	导入部门
param	$data array(array("path"=>"","itemIndex"=>1),array("path"=>"","itemIndex"=>1))
return	array(array("viewid"=>4,"emptype"=>2,"empid"=>1,"empname"=>"aaa"),array("viewid"=>4,"emptype"=>2,"empid"=>1,"empname"=>"aaa"))
*/
function import_dept($data,$is_delete = 1)
{
	
	$list_db = list_dept_bypath() ;

	//得到增删改的数据
	$result = compare_dept($list_db,$data);
	$arr_delete = $result["delete"] ;
	$arr_insert = $result["insert"] ;
	$arr_update = $result["update"] ;
	


	//增数据
	import_dept_insert($arr_insert);
	
	//删除数
	if ($is_delete)
		import_dept_delete($arr_delete);
	
	//修改数据
	import_dept_update($arr_update);
}


/*
method	导入部门(只是插入) 已经存在，不会再创建
param	$data array(array("path"=>"","itemIndex"=>1),array("path"=>"","itemIndex"=>1))
return	array(array("viewid"=>4,"emptype"=>2,"empid"=>1,"empname"=>"aaa"),array("viewid"=>4,"emptype"=>2,"empid"=>1,"empname"=>"aaa"))
*/
function import_dept_insert($data)
{
	global $arrDept ;
	global $db;
	$dept = new Department();

	foreach($data as $row)
	{
		$dept_path = $row['path'] ;
		
		//先从内存中取数据,重复数据放到内存中
		if (! array_key_exists($dept_path,$arrDept))
		{
			$deptInfo = $dept -> getIdByPath($dept_path,true,$row['itemIndex']);
			$deptInfo["itemIndex"] = $row['itemIndex'] ; //增加一个属性，后面重新更新有用
			$arrDept[$dept_path] = $deptInfo ;
			$deptInfo["deptpath"] = $dept_path;
		}
	}
	
	//更新 itemIndex , 在getIdByPath设置itemIndex ，上级部门不存在，创建后也会用同样的itemIndex,所以重新设置
	//统一用 import_dept_update
	$arr_update = array();
	foreach($arrDept as $deptpath => $deptinfo)
	{
		$arr_update[] = array("emptype"=>$deptinfo["emptype"],"empid"=>$deptinfo["empid"],
								"path"=>$deptpath,"itemIndex"=>$deptinfo["itemIndex"]);
	}
		
	import_dept_update($arr_update);

	return $arrDept ;
}

/*
method	更新部门
param	$data array(array("emptype"=>"4","empid"=>1,"path"=>"","itemIndex"=>1000),...)
return	true
*/
function import_dept_update($data)
{
	global $db;

	//更新 itemIndex , 在getIdByPath设置itemIndex ，上级部门不存在，创建后也会用同样的itemIndex,所以重新设置
	$sqls = array();
	foreach($data as $item)
	{
		$empType = $item["emptype"] ;
		$empId = $item["empid"] ;
		$path = $item["path"] ;
		$itemIndex = $item["itemIndex"] ;
		
		if ($empType == EMP_VIEW)
			$sqls[] = " update hs_view set col_itemindex=" . $itemIndex . " where col_id=" . $empId ;
		else
			$sqls[] = " update hs_group set col_itemindex=" . $itemIndex . ",col_deptpath='" . $path . "' where col_id=" . $empId ;
		
	}
	$db->execute($sqls);
}


/*
method	更新部门
param	$data array(array("emptype"=>"4","empid"=>1,"itemIndex"=>1000),...)
return	true
*/
function import_dept_delete($data)
{
	global $db;
	$dept = new Department();
	
	//更新 itemIndex , 在getIdByPath设置itemIndex ，上级部门不存在，创建后也会用同样的itemIndex,所以重新设置
	$sqls = array();
	foreach($data as $item)
	{
		$empType = $item["emptype"] ;
		$empId = $item["empid"] ;
		$tableName = $empType == EMP_VIEW?"hs_view":"hs_group" ;
		$sqls[] = " delete from " . $tableName . " where col_id=" . $empId ;
		$sqls[] = " delete from hs_relation where col_hsitemtype=" . $empType . " and col_hsitemid=" . $empId ; //删除我是父亲
		$sqls[] = " delete from hs_relation where col_dhsitemtype=" . $empType . " and col_dhsitemid=" . $empId ; //删除我的儿子
	}
	$db->execute($sqls);
}

/*
method:将人员导入临时表
return:$data 人员数据
*/
function import_user_temptable($data)
{
	 if(count($data) == 0)
	 	return ;
		
	global $db;
	global $modifyTime ;
	global $field_user ;
	//生成导入sql
	$sqls = array();
	$sqls[] = " delete from temp_user" ; //从免表没有删除，有上次数据
	$i=0;
	

	foreach ($data as $row)
	{
		$i++;
		//方便测试
		//if ($i>200)
			//break ;
		
		$arr_param = array();
		$arr_param[] = $db -> createParam("col_deptinfo",$row["path"]);
		$arr_param[] = $db -> createParam("col_loginname",$row["loginName"]) ;
		$arr_param[] = $db -> createParam("col_name",$row["userName"]) ;
		$arr_param[] = $db -> createParam("col_sex",$row["sex"]) ;

		$arr_param[] = $db -> createParam("col_email",$row["email"]) ;
		$arr_param[] = $db -> createParam("col_mobile",$row["mobile"]) ;
		$arr_param[] = $db -> createParam("col_o_jobtitle",$row["jobTitle"]) ;
		$arr_param[] = $db -> createParam("col_pword",$row["passWord"]) ;
		$arr_param[] = $db -> createParam("col_entype",$row["passWordType"]) ;
		$arr_param[] = $db -> createParam("col_o_phone",$row["phone"]) ;
		$arr_param[] = $db -> createParam("col_dt_modify",$modifyTime) ;
		$sqls[] = $db -> getInsertSQL("temp_user",$arr_param) ;

	}
	recordLog("需导入数据:" . count($sqls));
	
	//执行操作
	$db->execute($sqls);
}

/*
method:将人员从临时表导到正式表中
*/
function import_user_from_template()
{
	global $db;
	global $field_user ;
	
    //清除部门关系 (系统视图下的关系)
    $sqls[] = " delete from hs_relation where col_dhsitemtype=1 and col_viewid in (select col_id from hs_view where col_type=1)";

    //删除人员与关系  正式表>临时表 
    $sqls[] = " delete from hs_relation where col_dhsitemtype=1 " .
			  " and col_dhsitemid in (select col_id from hs_user where " .
			  " (col_loginname not in (select col_loginname from temp_user)) and col_issystem=0)";
    $sqls[] = " delete from hs_user where  (col_loginname not in (select col_loginname from temp_user)) and col_issystem=0";

    //更新人员  正式表=临时表
	$arr_field = explode(",",$field_user);
	$sql_set = "" ;
	foreach($arr_field as $field)
		 $sql_set .= ($sql_set == ""?"":",") . "hs_user." . $field . "=temp_user." . $field ;
	$sql_set = " set " . $sql_set ; 

				
	if ($db -> dbType == "mssql")
	{
		$sqls[] = " update hs_user " . $sql_set . " from hs_user, temp_user where hs_user.col_loginname = temp_user.col_loginname " ;
	}
	else
	{
		$sqls[] = " update hs_user inner join temp_user on hs_user.col_loginname = temp_user.col_loginname " . $sql_set ;
	}

	

    //新增人员 临时表>正式表
    $sqls[] = " insert into hs_user(" . $field_user . ",col_alldeptinfo) select " . $field_user . ",col_deptinfo from temp_user " .
			  " where (col_loginname not in (select col_loginname from hs_user)) " .
			  " and (col_loginname not in ('admin','ant_secretary','ant_guest_web'))"; //

	
	//执行操作
	$db->execute($sqls);
}

/*
method:设置人员的关系 col_deptinfo 存在所属部门路径 只能一个部门
param: $arr_dept 部门数据 array("aipu/devp"=>array(viewid=>1,emptype=4,empid=1,empname=aaa),"aipu/sale"=>array(viewid=>1,emptype=4,empid=1,empname=aaa))
*/
function import_user_relation()
{
	global $db;
	global $arrDept ; //得到刚才导入的部门数据
	$sqls = array();
	
	//得到用户中所有部门 现在部门路径存在 col_deptinfo
	$sql = " select col_deptinfo from hs_user where col_deptinfo<>'' group by col_deptinfo" ;
	$data_dept = $db -> executeDataTable($sql);
	
	foreach($data_dept as $row)
	{
		$deptpath = $row["col_deptinfo"] ;
		
		//不存在则取消息
		if (! array_key_exists($deptpath,$arrDept))
			continue ;
		
		$deptinfo = $arrDept[$deptpath];
		$where = " where col_deptinfo='" . $deptpath . "'" ;
		
		//同样部门的人设置关系
		$sql = " insert into hs_relation(col_hsitemtype,col_hsitemid,col_viewid,col_reltype,col_dhsitemtype,col_dhsitemid,col_dhsitemname) " .
		   " select " . $deptinfo["emptype"] . "," . $deptinfo["empid"] . "," . $deptinfo["viewid"] . ",1,1,col_id,col_name from hs_user   " . $where;
		$sqls[] = $sql ;

		//同样部门的人设置当前部门
		$sql = " update hs_user set col_deptinfo='" . $deptinfo["empname"] . "',col_deptid=" . $deptinfo["empid"] . " " . $where;
		$sqls[] = $sql ;

	}

	//执行操作
	$db->execute($sqls);
}


/*
method:返回同步的结果到MOS
param:$fileName request包的名称
*/
function sync_data_callback()
{
	global $db;
	global $modifyTime ;
	global $dataFileName ;
	global $path;
	
 
	//得到这次更新的人员
    $users = $db ->executeDataTable("select col_id as userid,col_loginname as loginname from hs_user where col_dt_modify='" . $modifyTime . "'");
    $users = table_fliter_doublecolumn($users,1);

    //组装返回的数据文件
    $response = array("ecid"=>str_replace("@", "", RTC_DOMAIN),"users"=>$users);
    $response = json_encode($response);

	//生成文件并打包
    $responseName = str_replace("request.txt", "response", $dataFileName);
    mkdirs($path . "/" . $responseName );
    file_put_contents($path . "/" . $responseName . "/" . $responseName . ".txt", $response);
	$zip = new Ziper();
    $zip->zipFolder($path . "/" . $responseName, $path . "/" . $responseName . ".zip");

    //调用反馈接口
    $callBackUrl = FIBERHOME_API . "?method=mapps.rtc.syncdata.callback&v=3.0&format=json";
    $callBackUrl .= "&username=admin" . RTC_DOMAIN;
    $callBackUrl .= "&syncfile=/data/fiberhome/" . $responseName . ".zip";
    $callBackResult = send_http_request($callBackUrl);
}

//-------------------------------------------------------------------------------------------------------------------------------
// 辅助函数
//-------------------------------------------------------------------------------------------------------------------------------

/*
method	得到部门路径及itemindex
return	array(array("id"=>"4_1","path"=>"aipu","itemIndex":1),...)
*/
function list_dept_bypath()
{
	global $db;
	$list = array();
	
	
	$sql = " select col_id,col_name,col_itemindex from hs_view where col_type=1" ;
	$list_view = $db -> executeDataTable($sql);
	foreach($list_view as $row)
		$list[] = array("emptype"=>4,"empid"=>$row["col_id"] ,"path"=>$row["col_name"],"itemIndex"=>$row["col_itemindex"]);

	$sql = " select col_id,col_deptpath,col_itemindex from hs_group where col_deptpath<>''" ;
	$list_group = $db -> executeDataTable($sql);
	foreach($list_group as $row)
		$list[] = array("emptype"=>2,"empid"=>$row["col_id"] ,"path"=>$row["col_deptpath"],"itemIndex"=>$row["col_itemindex"]);

	return $list ;
}

/*
method	比较部门 2015-06-24
param	$arr_db array(array(id=>"4_1","path"=>"","itemindex"=>1),array(id=>"2_1","path"=>"","itemindex"=>1))
param	$arr_my array(array("path"=>"","itemindex"=>1),array("path"=>"","itemindex"=>1))
return	"delete":array(array("id":"4_1","path"=>"","itemindex"=>1))  "insert":array "update":array
*/
function compare_dept($arr_db,$arr_my)
{
 

	//得到比较的数据,比较只能是path
	$arr_db_path = list2array($arr_db,"path");
	$arr_my_path = list2array($arr_my,"path");
	

	
	//得到要修改的内容
	$arr_delete_path = array_diff($arr_db_path, $arr_my_path) ;
	$arr_insert_path = array_diff($arr_my_path, $arr_db_path) ; 

	//补全数据
	$arr_delete = array2list($arr_delete_path,$arr_db,"path");
	$arr_insert = array2list($arr_insert_path,$arr_my,"path");
	$arr_update = compare_dept_update($arr_db,$arr_my);
	
	
	println("<br>delete-----------------------------------------");
	var_dump($arr_delete);
	println("<br>insert-----------------------------------------");
	var_dump($arr_insert);
	println("<br>update-----------------------------------------");
	var_dump($arr_update);
	
	
	
	
	return array("delete"=>$arr_delete,"insert"=>$arr_insert,"update"=>$arr_update) ;

}

/*
method	得到更新的数据 2015-06-24
param	$arr_db:array(array,...)
param	$arr_my:array(array,...)
return	array(array("emptype","empid"=>))
*/
function compare_dept_update($arr_db,$arr_my)
{
	$arr_update = array();
	
	//得到更新的数据
	foreach($arr_db as $item_db)
	{
		foreach($arr_my as $item_my)
		{
			if (($item_db["path"] == $item_my["path"]) && ($item_db["itemIndex"] != $item_my["itemIndex"]))
			{
				$item_my["emptype"] = $item_db["emptype"] ;
				$item_my["empid"] = $item_db["empid"] ;
				$arr_update[] = $item_my ;
			}
		}
	}
	
	return $arr_update ;
}

 
?>