<?php
///public/install.html?op=install&CompanyName=3423&rad_dbtype=-1&drp_dbtype=6&DBServer=192.168.0.53&DBName=antdb&DBUser=root&DBPassword=test&DBLoginMode=0&DBType=6&keys=DBType,CompanyName,DBServer,DBPort,DBName,DBUser,DBPassword,DBLoginMode&values=6,3423,192.168.0.53,3306,antdb,root,test,0&types=REG_DWORD,REG_SZ,REG_SZ,REG_DWORD,REG_SZ,REG_SZ,REG_SZ,REG_DWORD

//不验证登录  jc 20150821
$is_login = 0 ;

require_once ("../class/fun.php");
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
require_once(__ROOT__ . "/class/common/Regedit.class.php");
require_once(__ROOT__ . "/class/ant/AntService.class.php");

$db = new DB();
$op = g ( "op" );
$printer = new Printer ();




switch ($op) {
	case "init" :
		init (); 
		break;
	case "install" :
		install ();
		break;
	case "install_2" :
		install_2();
		break;
	case "update" :
		update ();
		break;
	case "save_config":
		save_config();
		break ;
	case "restart":
		restart();
		break ;
	default :
		break;
}




/*
method	在手动调用数据后，需要重加加载WEB内容中的数据
*/
function init() 
{
	//加载全局函数
	bulidAppValue();
	
	//重新加载内容数据
	//bulidApplcation();
}

 
/*
method	安装程序
*/
function install() 
{

	
	global $printer;
	global $db;
	$result = array ("status" => 1,"msg" => "","init" => 1);


	// 权限判断 20151008 将外面放到函数里，因为install_2时，ISINSTALL=1，会被禁止掉
	if (! isLocal())
		$printer->fail("text_install_limit");
	
	$DBType = g("dbtype");
	$DBServer = g("dbserver");
	$DBName = g("dbname");
	$DBUser = g("dbuser");
	$DBPassword = g("dbpassword");
	$DBPort = g("dbport");
	$DBFile = g("dbfile");
	
	
	println("--------------install-------------------");

    //if ($DBType != "access"){
	//检查连接
	$db = new DB ( $DBType, $DBServer, $DBName, $DBUser, $DBPassword,$DBFile, $DBPort);

	$status = $db->testConn (); // 0 connect fail 1 成功 2 成功 但没有数据库


	//数据库连接组件有问题
//	echo $status;
//	exit();
	if ($status == -1) {
		$result = array ("status" => 0,"msg" => "db module error","init" => 0);
		$printer->out_arr( $result ); // end
		return ;
	}

	if ($status == 0) {
		$result = array ("status" => 0,"msg" => get_lang("error_db_connect_error"),"init" => 0);
		$printer->out_arr( $result ); // end
		return ;
	}

	//创建数据库
	if ($status == 2) 
		$db->createDataBase();

//	if ($os != "windows")
//		$result = array ("status" => 1,"msg" => "","init" => 1);
	//创建表
	$hastable = $db->hasTable ( "Users_ID" );
	
	if (! $hastable) 
	{
		init_db( $DBType, $db );
		$result = array ("status" => 1,"msg" => "","init" => 1);
	}
	//}
	//保存配置信息
	//【注意，这里只保存数据库的配置，其它配置到重新提交一次】
	// 因为其它配置要保存数据库，而数据库的配置文件现在还为空
	$config = new SYSConfig();
	$config -> setDBConfig($DBType,$DBServer,$DBPort,$DBName,$DBUser,$DBPassword);
	
	//这里提交配置项【数据库配置，与参数配置要分两次提交，这样config.inc.php有内容】
//	$url = getRootPath() . "/public/install.html?op=install_2&init=" . $result ["init"] . "&companyname=" . g("companyname") ;
//	send_http_request($url) ;
	
	//重启服务异常 重启服务经常需要很长时间，所以不在这里执行，返回后，再ajax方式到 public/service下执行
	/*
	recordLog("重启服务");
	if ($result ["status"] > 0)
		restart();
	*/
	
	//输入结果
	recordLog(get_lang("install_warning"));
	$printer->out_arr( $result,0); // isEnd=0 表示下面还可以执行


}

/*
method	安装程序二次调用，在写入config.inc.php的数据库连接设置之后
*/
function install_2()
{
	//这里提交配置项【数据库配置，与参数配置要分两次提交，这样config.inc.php有内容】
	save_config() ;

	//重新加载内容数据
	//bulidApplcation();
}


/*
method 保存配置
*/
function save_config() 
{
	$config = new SYSConfig();

	$init = g("init") ;
	if ($init){
		$params = array();
		$params[] = $config->create_param("RTC_CONSOLE",$_SERVER['DOCUMENT_ROOT'].'/Data');	
		$params[] = $config->create_param("RTCServer_IP",'http://'.RTC_SERVER.':98');
		$params[] = $config->create_param("Jump_RTCServer_IP",'http://'.RTC_SERVER.':98');
		$params[] = $config->create_param("ipaddress",'http://'.RTC_SERVER.':97',"LivechatConfig");
		$params[] = $config->create_param("VerifyUserDevice",1);
		$params[] = $config->create_param("OpenPlatForm",1);
		if(getOS()=='linux'){
			 $params[] = $config->create_param("Transcode",1);
		}
		
		$config -> setConfig($params);
//		if(is_domain($_SERVER['SERVER_NAME'])){
//			 $arr_sql[] = "update Plug set Plug_Target='http://".RTC_SERVER.":98/cloud/include/onlinefile.html?loginname=[UserName]&password=[PassWord]' where Plug_Name='OfficeOnlineServer'";
//			 $arr_sql[] = "update Plug set Plug_Target='http://".RTC_SERVER.":98/cloud/include/yunpan.html?loginname=[UserName]&password=[PassWord]' where Plug_Name='CloudDisk'";
//		}
		$arr_sql[] = "update Plug set Plug_Param='http://".RTC_SERVER.":96,http://".RTC_SERVER.":98,http://".RTC_SERVER.":96' where Plug_Name='OfficeOnlineServer'";
		$arr_sql[] = "update Plug set Plug_Param='http://".RTC_SERVER.":96,http://".RTC_SERVER.":98,http://".RTC_SERVER.":96' where Plug_Name='phone_OfficeOnlineServer'";
		if(getOS()=='linux') $arr_sql[] = "update OtherForm set OneRun='YSRDLL',RuDate='lk',RuDate1='lk',RuDate2='i',RuDate3='lk',LastRun='mkabd' where ID=1";
		$db = new DB ();
		$db->execute($arr_sql);
	}
	
//	//配置其它参数
//	$companyName =  g("CompanyName") ;
//  
//	$params = array();
//	$params[] = $config->create_param("CompanyName",$companyName);
//	//20160311 windows覆盖安装先获取注册表的值
//	$DomainName = readRegDN();
//	if($DomainName==""){
//	    //如果是初次安装，设置域名
//	    $params[] = $config->create_param("DomainName",getDomainName($companyName));
//	}else{
//	    $params[] = $config->create_param("DomainName",$DomainName);
//	}
//
//
//	//配置系统设置
//	$config -> setConfig($params);
	
	//如果是初次安装，设置文档系统
//	if ($init)
//		install_docserver();

}

/*
method 得到域名
*/
function getDomainName($companyName)
{
	//先取系统配置(webconfig 的域名带@,antserver中不带)
	$domainName = BIGANT_DOMAIN;
	$domainName = str_replace("@","",$domainName) ;
	
	//不存在生成一个
	if ($domainName == "")
	{
		$py = new PinYin();
		$domainName =  $py->getFirstPY( $companyName );
	}
	
	$domainName =strtolower( $domainName );
	return $domainName ; 
}





/*
method 重启服务
*/
function restart() 
{
	$service = new AntService ();
	$service->restartAll();
}



/*
method 初始化数据
*/
function init_db($DBType) 
{
	global $db ;

	
	$sqls = get_createsql ( $DBType );
//	echo var_dump($sqls);
//	exit();
	$db -> execute ($sqls);

	return 1;
}


/*
method	得到创建语句
		这里禁止用 getAppValue,因为配置表还未生成
*/
function get_createsql($DBType)
{
    global $db ;
	
	$default_ConsoleDir = get_default_consoledir() ;
	$default_DataDir = get_default_datadir() ;
	
	//得到创建脚本
    $file_create = __ROOT__ . "/install/dbcreate/" . get_sqlname($DBType) . ".sql" ;
    $sqls = $db -> readSQLFile($file_create);

    $company_name = g("CompanyName","test");
	//$install_date = ascom_encrypt(date("Y-m-d")) ;
	
	//生成系统初始化数据
	$file_init = __ROOT__ . "/install/dbcreate/" . get_sqlname($DBType) . "_init.sql" ;
 	$arr_initsql = readInitSql($file_init) ;
	$sqls = array_merge($sqls,$arr_initsql) ;
	
    return $sqls ;
}

/*
method	添加到初始化的内容
*/
function readInitSql($file_init)
{
	if (! file_exists($file_init))
		return array();

	$file_content = readFileContent($file_init) ;
//	$file_content = str_replace("{CompanyName}",g("CompanyName","test"),$file_content);
//	$file_content = str_replace("{WebPort}",$_SERVER['SERVER_PORT'],$file_content);
	
	$arr_initsql = explode(";",$file_content);
	return $arr_initsql ;
}

 
/*
method	升级数据库 
*/
function update() 
{
	error_reporting ( 0 );

	global $printer;
	
	$db = new DB ();

	$result = array ("status" => 1,"msg" => "");

	$update_type = g ( "type" );

	// 得到SQL语句
	$filepath = __ROOT__ . "/install/dbupdate/" . $update_type . "/" . $db  -> dbType . ".sql";
	
	if (! is_file($filepath))
	{
		$printer -> fail("not find update file");
		return ;
	}

	
	$sqls = $db->readSQLFile ( $filepath );

	//执行升级脚本连接
	$db->execute ( $sqls );
	
	switch ($update_type)
	{
		case "dbupdate_20180731":
			$data_user = array();
			$arr_sql = array();
			$sql = "Select max(TypeID) as m,ClotID from MessengClot_Text group by ClotID";
			$data_user = $db-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "update Clot_Form set last_ack_typeid1=".$data_user[$k]['m'].",last_ack_typeid2=".$data_user[$k]['m'].",last_ack_typeid3=".$data_user[$k]['m'].",last_ack_typeid4=".$data_user[$k]['m'].",last_ack_typeid5=0,last_ack_typeid6=0,last_ack_typeid7=0,last_ack_typeid8=0 where UpperID='".$data_user[$k]['clotid']."'" ;
			}
			$db->execute($arr_sql);
			break ;
		case "dbupdate_20181107":
			$data_user = array();
			$arr_sql = array();
			$sql = "Select * from PtpFolder where ParentID<>'0'";
			$data_user = $db-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$sql = "Select * from PtpFolder where PtpFolderID1='".$data_user[$k]['parentid']."' and MyID='".$data_user[$k]['myid']."'";
				$data = $db-> executeDataRow( $sql );
				if (count($data)){
					$arr_sql[] = "update PtpFolder set ParentID='".$data["ptpfolderid"]."' where PtpFolderID='".$data_user[$k]['ptpfolderid']."'" ;
				}
			}
			$arr_sql[] = "update ClotFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update LeaveFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update OnlineFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update OnlineRevisedFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update PtpFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update MD5File set FilPath=replace(FilPath,'\','/')";
			$db->execute($arr_sql);
			
			$sql = "Select * from PtpFolder";
			$data_user = $db-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "update PtpFile set PtpFolderID='".$data_user[$k]['ptpfolderid']."' where PtpFolderID='".$data_user[$k]['ptpfolderid1']."' and MyID='".$data_user[$k]['myid']."'";
				$arr_sql[] = "update PtpFolderForm set PtpFolderID='".$data_user[$k]['ptpfolderid']."' where PtpFolderID='".$data_user[$k]['ptpfolderid1']."' and MyID='".$data_user[$k]['myid']."'";
				$arr_sql[] = "update PtpForm set PtpFolderID='".$data_user[$k]['ptpfolderid']."' where PtpFolderID='".$data_user[$k]['ptpfolderid1']."' and MyID='".$data_user[$k]['myid']."'";
			}
			$db->execute($arr_sql);
			break ;
		case "dbupdate_access2sqlserver":
		    $accessdb = new DB("access",DB_SERVER,DB_NAME,"","seekinfo",DB_PATH) ;
			$data_user = array();
			$arr_sql = array();
			$sql = "Select * from Users_WinInfo";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Users_WinInfo] ([WindowsInfo], [UserName], [Upan], [LocalIP], [UserIcoLine]) VALUES ('".$data_user[$k]['windowsinfo']."', '".$data_user[$k]['username']."', '".$data_user[$k]['upan']."', '".$data_user[$k]['localip']."', ".$data_user[$k]['usericoline'].")" ;
			}
			$sql = "Select * from Users_Role";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Users_Role] ([UserID], [RoleID]) VALUES ('".$data_user[$k]['userid']."', ".$data_user[$k]['roleid'].")" ;
			}
			$sql = "Select * from Users_Ro";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Users_Ro] ([TypeID], [TypeName], [ParentID], [Description], [ItemIndex], [CreatorID], [CreatorName]) VALUES ('".$data_user[$k]['typeid']."', '".$data_user[$k]['typename']."', '".$data_user[$k]['parentid']."', '".$data_user[$k]['description']."', '".$data_user[$k]['itemindex']."', '".$data_user[$k]['creatorid']."', '".$data_user[$k]['creatorname']."')" ;
			}
			$sql = "Select * from Users_Pic";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Users_Pic] ([UserID], [pic], [Sfile]) VALUES ('".$data_user[$k]['userid']."', ".$data_user[$k]['pic'].", ".$data_user[$k]['sfile'].")" ;
			}
			$sql = "Select * from Users_ID";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Users_ID] ([UppeID], [UserID], [UserName], [UserPaws], [FcName], [Age], [Jod], [Tel1], [Tel2], [Address], [Say], [UserIco], [UserIcoLine], [School], [Effigy], [Constellation], [remark], [Sequence], [binding], [LoginTime], [UserState], [NetworkIP], [LocalIP], [Mac], [Registration_Id], [PlatForm], [LocalIPList], [MacList], [IsVerify], [IsManager], [Fav_FormVesr], [Col_FormVesr], [CreatorID], [CreatorName]) VALUES ('".$data_user[$k]['uppeid']."', '".$data_user[$k]['userid']."', '".$data_user[$k]['username']."', '".$data_user[$k]['userpaws']."', '".$data_user[$k]['fcname']."', '".$data_user[$k]['age']."', '".$data_user[$k]['jod']."', '".$data_user[$k]['tel1']."', '".$data_user[$k]['tel2']."', '".$data_user[$k]['address']."', '".$data_user[$k]['say']."', ".$data_user[$k]['userico'].", ".$data_user[$k]['usericoline'].", '".$data_user[$k]['school']."', '".$data_user[$k]['effigy']."', '".$data_user[$k]['constellation']."', '".$data_user[$k]['remark']."', ".$data_user[$k]['sequence'].", ".$data_user[$k]['binding'].", '".$data_user[$k]['logintime']."', ".$data_user[$k]['userstate'].", '".$data_user[$k]['networkip']."', '".$data_user[$k]['localip']."', '".$data_user[$k]['mac']."', '".$data_user[$k]['registration_id']."', '".$data_user[$k]['platform']."', '".$data_user[$k]['localiplist']."', '".$data_user[$k]['maclist']."', ".$data_user[$k]['isverify'].", ".$data_user[$k]['ismanager'].", ".$data_user[$k]['fav_formvesr'].", ".$data_user[$k]['col_formvesr'].", '".$data_user[$k]['creatorid']."', '".$data_user[$k]['creatorname']."')" ;
			}
			$sql = "Select * from Role";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Role] ([RoleName], [Description], [Permissions], [Plug], [PtpSize], [PtpType], [PubSize], [PubType], [ClotSize], [ClotType], [UsersSize], [UsersType], [DepartmentPermission], [Department], [SmsCount], [DefaultRole], [CreatorID], [CreatorName]) VALUES ('".$data_user[$k]['rolename']."', '".$data_user[$k]['description']."', '".$data_user[$k]['permissions']."', '".$data_user[$k]['plug']."', ".$data_user[$k]['ptpsize'].", '".$data_user[$k]['ptptype']."', ".$data_user[$k]['pubsize'].", '".$data_user[$k]['pubtype']."', ".$data_user[$k]['clotsize'].", '".$data_user[$k]['clottype']."', ".$data_user[$k]['userssize'].", '".$data_user[$k]['userstype']."', ".$data_user[$k]['departmentpermission'].", '".$data_user[$k]['department']."', ".$data_user[$k]['smscount'].", ".$data_user[$k]['defaultrole'].", '".$data_user[$k]['creatorid']."', '".$data_user[$k]['creatorname']."')" ;
			}
//			$sql = "Select * from MD5File";
//			$data_user = $accessdb-> executeDataTable( $sql );
//			foreach($data_user as $k=>$v){
//				$arr_sql[] = "INSERT [MD5File] ([MyID], [FormFileType], [TypePath], [PcSize], [ToDate], [ToTime], [FilPath], [MD5Hash]) VALUES ('".$data_user[$k]['myid']."', ".$data_user[$k]['formfiletype'].", '".$data_user[$k]['typepath']."', '".$data_user[$k]['pcsize']."', '".$data_user[$k]['todate']."', '".$data_user[$k]['totime']."', '".$data_user[$k]['filpath']."', '".$data_user[$k]['md5hash']."')" ;
//			}
			$sql = "Select * from LeaveFile";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				if (!$data_user[$k]['msg_id']) $data_user[$k]['msg_id']=create_guid1();
				$arr_sql[] = "INSERT [LeaveFile] ([Msg_ID], [UserID1], [UserID2], [TypePath], [PcSize], [ToDate], [SendTy], [FilPath]) VALUES ('".$data_user[$k]['msg_id']."', '".$data_user[$k]['userid1']."', '".$data_user[$k]['userid2']."', '".$data_user[$k]['typepath']."', '".$data_user[$k]['pcsize']."', '".$data_user[$k]['todate']."', ".$data_user[$k]['sendty'].", '".$data_user[$k]['filpath']."')" ;
			}
			$sql = "Select * from Messeng_Text";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				if (!$data_user[$k]['msg_id']) $data_user[$k]['msg_id']=create_guid1();
				$arr_sql[] = "INSERT [Messeng_Text] ([Msg_ID], [MyID], [YouID], [FcName], [To_Type], [To_Date], [To_Time], [UserText], [FontInfo], [IsReceipt1], [IsReceipt2]) VALUES ('".$data_user[$k]['msg_id']."', '".$data_user[$k]['myid']."', '".$data_user[$k]['youid']."', '".$data_user[$k]['fcname']."', ".$data_user[$k]['to_type'].", '".$data_user[$k]['to_date']."', '".$data_user[$k]['to_time']."', '".$data_user[$k]['usertext']."', '".$data_user[$k]['fontinfo']."', 2, 2)" ;
			}
			$sql = "Select * from MessengClot_Text";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				if (!$data_user[$k]['msg_id']) $data_user[$k]['msg_id']=create_guid1();
				$arr_sql[] = "INSERT [MessengClot_Text] ([Msg_ID], [ClotID], [MyID], [YouID], [FcName], [To_Type], [To_Date], [To_Time], [UserText], [FontInfo]) VALUES ('".$data_user[$k]['msg_id']."', '".$data_user[$k]['clotid']."', '".$data_user[$k]['myid']."', '".$data_user[$k]['youid']."', '".$data_user[$k]['fcname']."', ".$data_user[$k]['to_type'].", '".$data_user[$k]['to_date']."', '".$data_user[$k]['to_time']."', '".$data_user[$k]['usertext']."', '".$data_user[$k]['fontinfo']."')" ;
			}
			$sql = "Select * from Col_Ro";
			$data_user = $accessdb-> executeDataTable( $sql );
			$arr_sql[] = "SET IDENTITY_INSERT [Col_Ro] ON" ;
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Col_Ro] ([TypeID], [TypeName], [ToDate], [ToTime], [MyID]) VALUES ('".$data_user[$k]['typeid']."', '".$data_user[$k]['typename']."', '".$data_user[$k]['todate']."', '".$data_user[$k]['totime']."', '".$data_user[$k]['myid']."')" ;
			}
			$arr_sql[] = "SET IDENTITY_INSERT [Col_Ro] OFF" ;
			$sql = "Select * from Col_Form";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Col_Form] ([UpperID], [Title], [NContent], [UsName], [UsID], [TypeS], [ToDate], [ToTime], [MyID]) VALUES (".$data_user[$k]['upperid'].", '".$data_user[$k]['title']."', '".$data_user[$k]['ncontent']."', '".$data_user[$k]['usname']."', '".$data_user[$k]['usid']."', '".$data_user[$k]['types']."', '".$data_user[$k]['todate']."', '".$data_user[$k]['totime']."', '".$data_user[$k]['myid']."')" ;
			}
			$sql = "Select * from ClotFile";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				if (!$data_user[$k]['msg_id']) $data_user[$k]['msg_id']=create_guid1();
				$arr_sql[] = "INSERT [ClotFile] ([Msg_ID], [MyID], [UsName], [ClotID], [TypePath], [PcSize], [ToDate], [ToTime], [FilPath], [FileState]) VALUES ('".$data_user[$k]['msg_id']."', '".$data_user[$k]['myid']."', '".$data_user[$k]['usname']."', '".$data_user[$k]['clotid']."', '".$data_user[$k]['typepath']."', '".$data_user[$k]['pcsize']."', '".$data_user[$k]['todate']."', '".$data_user[$k]['totime']."', '".$data_user[$k]['filpath']."', ".$data_user[$k]['filestate'].")" ;
			}
			$sql = "Select * from Clot_Ro";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Clot_Ro] ([TypeID], [TypeName], [Remark], [To_Date], [Sender], [UserState], [Disk_Space], [IsPublic], [OwnerID], [ItemIndex], [CreatorID], [CreatorName]) VALUES ('".$data_user[$k]['typeid']."', '".$data_user[$k]['typename']."', '".$data_user[$k]['remark']."', '".$data_user[$k]['todate']."', ".$data_user[$k]['sender'].", ".$data_user[$k]['userstate'].", '".$data_user[$k]['diskspace']."', ".$data_user[$k]['ispublic'].", '".$data_user[$k]['ownerid']."', ".$data_user[$k]['itemindex'].", '".$data_user[$k]['creatorid']."', '".$data_user[$k]['creatorname']."')" ;
			}
			$sql = "Select * from Clot_Pic";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Clot_Pic] ([ClotID], [ClotInfo], [pic], [Sfile]) VALUES ('".$data_user[$k]['clotid']."', ".$data_user[$k]['clotinfo'].", ".$data_user[$k]['pic'].", ".$data_user[$k]['sfile'].")" ;
			}
			$sql = "Select * from Clot_Form";
			$data_user = $accessdb-> executeDataTable( $sql );
			foreach($data_user as $k=>$v){
				$arr_sql[] = "INSERT [Clot_Form] ([UpperID], [UserID], [IsAdmin], [remark], [last_ack_typeid1], [last_ack_typeid2], [last_ack_typeid3], [last_ack_typeid4]) VALUES ('".$data_user[$k]['upperid']."', '".$data_user[$k]['userid']."', ".$data_user[$k]['admin'].", '".$data_user[$k]['remark']."','999999','999999','999999','999999')" ;
			}
			$arr_sql[] = "update ClotFile set FilPath=replace(FilPath,'\','/')";
			$arr_sql[] = "update LeaveFile set FilPath=replace(FilPath,'\','/')";
//			echo var_dump($arr_sql);
//			exit();
            $db = new DB ();
			$db->execute($arr_sql);
			break ;
		default:

			break;
	}
	$content = new SimpleIniIterator(__ROOT__ . '/Data/Config.ini');
	$content->setIniValue('date2', str_replace("dbupdate_","",$update_type), 'updated_date');
	
	//执行配置脚本（取注册表中的数据）
	//config_reg2tbl() ;
		
	//生成本地配置
	//bulidAppValue();
	
	$printer->out_arr( $result );
	
}

/*
method	将注册表中的数据移到配置表中
		4.1 to 4.2 的修改
*/
function config_reg2tbl()
{
	global $os ;
	
//	if ($os != "windows")
//		return ;
		
	$config = new AntConfig();
	
	$sqls = array();
	$sqls[] = " delete from  tab_config where col_genre='SysConfig' " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ProductName','即时通讯','SysConfig') " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AppName','即时通讯管理器','SysConfig') " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AppCompany','触点软件','SysConfig')" ; 
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AppUrl','http://www.haoqiniao.cn','SysConfig') " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AppVersion','4.2.01 Rel','SysConfig') " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ReleaseDate','2015-04-27','SysConfig')" ;
	
	$value = $config -> get_regvalue("DomainName");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('DomainName','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("CompanyName");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('CompanyName','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("ConsoleDir") ;
	$value = str_replace("\\","/",$value);
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ConsoleDir','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("DataDir");
	$value = str_replace("\\","/",$value);
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('DataDir','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("WorkDir");
	$value = str_replace("\\","/",$value);
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('WorkDir','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("AntDocServerFlag");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntDocServerFlag','" . $value . "','SysConfig')   " ;
	
	$value = $config -> get_regvalue("AntServerFlag");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntServerFlag','" . $value . "','SysConfig')  " ;
	
	$value = $config -> get_regvalue("AutoAway");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AutoAway','" . $value . "','SysConfig')" ;
	
	$value = $config -> get_regvalue("AutoAwayTime");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AutoAwayTime','" . $value . "','SysConfig')  " ;
	
	$value = $config -> get_regvalue("AutoClear");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AutoClear','" . $value . "','SysConfig')" ;
	
	$value = $config -> get_regvalue("MsgLife");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('MsgLife','" . $value . "','SysConfig') " ;

	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntServer_IP','127.0.0.1','SysConfig') " ;
	
	$value = $config -> get_regvalue("Port","6660");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntServer_Port','" . $value . "','SysConfig') " ;
	
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntAvServer_IP','','SysConfig') " ;
	
	$value = $config -> get_regvalue("AntAV_Port","6662");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntAvServer_Port','" . $value . "','SysConfig') " ;
	
	$value = $config -> get_regvalue("AntDS_Port","6661");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntDS_Port','" . $value . "','SysConfig') " ;
	
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntFileServer_IP','','SysConfig') " ;
	
	$value = $config -> get_regvalue("AntFileServer_Port","6663");
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntFileServer_Port','" . $value . "','SysConfig') " ;

	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ServerName','127.0.0.1','SysConfig') " ;

	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('SmsUrl','','SysConfig')" ;
	
	$value = "col_loginname,col_name,col_sex,col_email,col_mobile,col_o_jobtitle,col_pword,col_entype,col_o_phone,col_itemindex" ;
	
	//这里要将所有的配置项放入
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ExportImportUserFields','" . $value . "','SysConfig')    " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AntMeeting','1','SysConfig') " ;  
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('IOSPush','0','SysConfig')   " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('SyncPush','1','SysConfig')  " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('WebServerLoginErrorCount','5','SysConfig') " ;	
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('LiveChat','0','SysConfig')    " ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('AccessToken','123456','SysConfig')" ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('ApiReturnType','XML','SysConfig')" ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('SyncPushTargetType','0','AntServerExConfig')" ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('SyncPushTarget','','AntServerExConfig')" ;
	$sqls[] = "insert into tab_config(col_name,col_data,col_genre) values('OpenPlatForm','0','SysConfig')" ;
	
	global $db ;
	$db-> execute( $sqls );
}

/*
method	得到数据库类型
*/
function get_sqlname($dbType) 
{
	if ($dbType == "mariadb")
		$dbType = "mysql";
	return $dbType;
}

?>