<?php
/**
 * 通行证

 * @date    20140325
 */
require_once(__ROOT__ . "/config/cloud.inc.php");
require_once (__ROOT__ . "/class/common/Regedit.class.php");
require_once (__ROOT__ . "/class/common/LdapHelper.class.php");
require_once(__ROOT__ . "/class/ant/SYSConfig.class.php");
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
class Passport
{
    /**
     * 登录验证
     * @param $loginName 帐号
     * @param $password 密码
	 * @param $isEncrypt  0 明码 1 密码
     * @return array("result"=>1,"data"=>$row)
     */
	function login($loginName,$password,$ismanager = 0,$isclient = 0,$isEncrypt = 0)
	{
		ob_clean ();
		$printer = new Printer ();
		$isWebService = false;
		//$loginName = iconv_str($loginName,"gbk","utf-8");
		//$loginName = removeDomain($loginName);
        //$antLog = new AntLog();

        //$errorCount = $antLog->get_admin_error_count();

		$user = new Model("Users_ID");
		//$regedit = new Regedit();
		$user -> addParamWhere("UserName",$loginName) ;
		$row = $user -> getDetail() ;
//						echo var_dump($row);
//		exit();
		$result = array("status"=>1,"data"=>$row);
        //if($errorCount >= LOGIN_ERROR_COUNT && LOGIN_ERROR_COUNT > 0)
        //    return $result = array("status"=>0,"errnum"=>102006);

 		if (count($row) == 0)
        {
            //$antLog->log($loginName,"",3,$_SERVER['REMOTE_ADDR'],"",1);
            return $result = array("status"=>0,"errnum"=>102001);
        }

		$dbPassword = trim($row["userpaws"]);
		//if(DB_TYPE=="mssql"&&$dbPassword===null) $dbPassword='';
		$enType = 0;

		//空密码也是有MD5的,数据库里面保存的密码为明文时需要加密后才能比较
		if($isEncrypt){
			$dbPassword = md5($dbPassword);
		}
//
//		if (! $isEncrypt)
//		{
//		    $password = $this -> encryptPassword($password,$enType);
//		}

		switch(getAppValue("Type"))
		{
			case "0":
				if ($dbPassword != $password)
				{
					return $result = array("status"=>0,"errnum"=>102002);
				}
				break;
			case "1":
				$domain = getAppValue("domain");
				$adminUser = $row["username"];
				$adminPassword = $password;
				$adLdap = new LdapHelper($domain,$adminUser,$adminPassword);
				$adLdap->connect();
//				echo $domain.'+'.$adminUser.'+'.$adminPassword;
//exit();
				if((!$isEncrypt)&&(!$adLdap->ldapBind))
				{
					return $result = array("status"=>0,"errnum"=>102002);
				}
				break;
			case "2":
				$url = getAppValue("Target"); 
				//生成参数
				$param = array(
					"loginname"=> $row["username"],
					"password"=>$password,
					"entype"=>$isEncrypt
				);
				$result = send_http_post($url,$param);

				switch(getAppValue("targetreturn"))
				{
					case "JSON":
					$obj = json_decode($result, true);
//					if($obj["status"])
//					{
						if((int)$obj["status"] != 1)
						{
							return $result = array("status"=>0,"errnum"=>102002);
						}
//					}
					break;
					case "XML":
					$obj = simplexml_load_string($result);
//					if($obj->status)
//					{
						if((int)$obj->status != 1)
						{
							return $result = array("status"=>0,"errnum"=>102002);
						}
//					}
					break;
				}
				break;
//				$json = '{"status":0,"msg":"AD"}';
//				//if($result==$json){
//				echo $result."<br>";
//				echo $json;
//								echo $obj->status;
//				exit();
				//}

		}
		//判断是否开启了域验证，如果开启了则不验证密码
//		$antServerFlag = getAppValue("AntServerFlag");
//		$isAD = (($antServerFlag & 1024) == 1024) ? true:false;
//		
//		$isWebService = getAppValue("Type") == "1"; 



        /*
		if($isAD == false && $isWebService == false)
		{
            if ($dbPassword != $password)
                return $result = array("status"=>0,"errnum"=>102002);
		}
        */


        if ($row["userstate"]=="0")
        {
            return $result = array("status"=>0,"errnum"=>102003);
        }
        if ($row["expiretime"]>0&&$row["expiretime"]<strtotime(getNowTime()))
        {
            return $result = array("status"=>0,"errnum"=>102003);
        }
        if($ismanager){
			if ($row["ismanager"]=="0")
			{
			$user = new Model("AdminGrant");
			$user -> addParamWhere("UserID",$row["userid"]) ;
			$data = $user -> getDetail() ;
				if (count($data) == 0)
				{
					return $result = array("status"=>0,"errnum"=>102004);
				}	
			}
			$antRes=get_lang("class_passport_warning");
		}else $antRes=get_lang("class_passport_warning1");
		if(g ( "gourl" )=="livechat") $antRes=get_lang("class_passport_warning2");
		
		if($isclient){
			$point = (int)g("point");
			$content = file_get_contents(__ROOT__ . '/download/log.txt');
			$arr_logitem = explode("|",$content);
			if (g ( "updated_date" )&&((int)$arr_logitem[0] > (int)g ( "updated_date" )))
			   return $result = array("status"=>0,"errnum"=>102009);
			$data = array();
			$file_item = array();
			$append = "";
			$user = new User ();
			$role = new Role ();
			$data_folder = $user->listRole ($row["userid"]);
			foreach($data_folder as $k=>$v){
				$data_file = $role->listFunACE ( $data_folder[$k]['id'] );
				foreach($data_file as $k=>$v){
					$arr_id = explode(",",$data_file[$k]['permissions']);
					foreach($arr_id as $id)
					{
						if ($id=="19")
						{
							$IsLogin = false;
							$arr_item = explode(",",$row["localiplist"]);
							foreach($arr_item as $item)
							{
								$arr_ip = explode("-",$item);
								if (count($arr_ip)==1)
								{
									if ($item == $_SERVER['REMOTE_ADDR']){
									   $IsLogin = true;
									   break;
									}
								}elseif (count($arr_ip)==2){
									if (isInner($_SERVER['REMOTE_ADDR'], $arr_ip[0], $arr_ip[1]) == true){
									   $IsLogin = true;
									   break;
									}
								}
							}
							if($IsLogin == false)
							   return $result = array("status"=>0,"errnum"=>102007);
						}
						if ($id=="20")
						{
							$IsLogin = false;
							$arr_item = explode(",",$row["maclist"]);
							foreach($arr_item as $item)
							{
								if ($item == g ( "Mac" )){
								   $IsLogin = true;
								   break;
								}
							}
							if(!g ( "Mac" )) $IsLogin = true;
							if($IsLogin == false)
							   return $result = array("status"=>0,"errnum"=>102007);
						}
					}
					//$data = array_merge($data,$data_file) ;
					$plug .= ($plug?",":"") . $data_file[$k]['plug'];
					$permissions .= ($permissions?",":"") . $data_file[$k]['permissions'];
					$ptpsize = $data_file[$k]['ptpsize'];
					$ptptype = $data_file[$k]['ptptype'];
					$pubsize = $data_file[$k]['pubsize'];
					$pubtype = $data_file[$k]['pubtype'];
					$clotsize = $data_file[$k]['clotsize'];
					$clottype = $data_file[$k]['clottype'];
					$userssize = $data_file[$k]['userssize'];
					$userstype = $data_file[$k]['userstype'];
					$departmentpermission=$data_file[$k]['departmentpermission'];
					$department=$data_file[$k]['department'];


				}
			}
			if($point==1){
				$IsLogin = false;
				$arr_item = explode(",",$permissions);
				foreach($arr_item as $item)
				{
					if ($item=="14"){
					   $IsLogin = true;
					   break;
					}
				}
				if($IsLogin == false)
				   return $result = array("status"=>0,"errnum"=>102008);
			}
			$content = new SimpleIniIterator(__ROOT__ . '/Data/DataBase.ini');
//			$db = new DB();
//			$sql = "Select * from Clot_Silence where MyID='".$row["userid"]."'";
//			$data_clot = $db -> executeDataTable($sql);
////			echo var_dump($data_clot);
////			exit();
//			$append = $printer->union ( $append, '"clot":[' . ($printer->parseList ( $data_clot, 0 )) . ']' );
			$user = new Model("Plug");
			$user -> addParamWhere("Plug_Enabled",true) ;
			$user -> addParamWhere("Plug_Name","Meeting") ;
			$plugrow = $user -> getDetail() ;
			if (count($plugrow)){
				$file_item["meetingurl"] = $plugrow["plug_param"];
			}
			$file_item["status"] = 1 ;
			$file_item["md5password"] = md5($password) ;
			$file_item["plug"] = $plug ;
			$file_item["permissions"] = $permissions ;
			$file_item["ptpsize"] = $ptpsize ;
			$file_item["ptptype"] = $ptptype ;
			$file_item["pubsize"] = $pubsize ;
			$file_item["pubtype"] = $pubtype ;
			$file_item["clotsize"] = $clotsize ;
			$file_item["clottype"] = $clottype ;
			$file_item["userssize"] = $userssize ;
			$file_item["userstype"] = $userstype ;
			$file_item["departmentpermission"] = $departmentpermission ;
			$file_item["department"] = $department ;
			$file_item["userid"] = $row["userid"] ;
			$file_item["isverify"] = $row["isverify"] ;
			$file_item["ismanager"] = $row["ismanager"] ;
			$file_item["chatermode"] = CHATERMODE ;
			$file_item["customerservicemode"] = CUSTOMERSERVICEMODE ;
			$file_item["ipaddress"] = phpescape(IPADDRESS) ;
			$file_item["rtc_server_agent"] = phpescape(RTC_SERVER_AGENT) ;
			$file_item["switchtype"] = SWITCHTYPE ;
			$file_item["waittime"] = WAITTIME ;
			$file_item["freetype"] = FREETYPE ;
			$file_item["freetime"] = FREETIME ;
			$file_item["translatetype"] = TRANSLATETYPE ;
			$file_item["translateappid"] = TRANSLATEAPPID ;
			$file_item["translatekey"] = TRANSLATEKEY ;
			$file_item["beattime"] = BEATTIME ;
			$file_item["controlcomputer"] = $content->getIniValue('server_connection', 'control_computer') ;
			$file_item["upgradeddata"] = $arr_logitem[1] ;
//			array_push($result,$file_item);
//			$other_str = "\"userid\":" . $row["userid"] . ",\"isverify\":" . $row["isverify"] . ",\"controlcomputer\":" . $content->getIniValue('server_connection', 'control_computer') . ",\"upgradeddata\":" . $arr_logitem[1];
//			$append = $printer->union ( $append, "\"other\":{" . $ace_str . "}" );
			
			$doc_file = new Model("Users_ID");
			if($point==1){
			$doc_file -> addParamField("PlatForm", g ( "PlatForm" ));
			$doc_file -> addParamField("Registration_Id", g ( "Mac" ));
			$doc_file -> addParamField("ManuFacturer", g ( "ManuFacturer" ));
			}else{
			$doc_file -> addParamField("NetworkIP", g ( "NetworkIP" ));
			}
			$doc_file -> addParamField("Mac", g ( "Mac" ));
			if(empty($row["maclist"])) $doc_file -> addParamField("MacList", g ( "Mac" ));
			$doc_file -> addParamField("LoginTime", getNowTime());
			$doc_file -> addParamField("LocalIP", $_SERVER['REMOTE_ADDR']);
			if(empty($row["localiplist"])) $doc_file -> addParamField("LocalIPList", $_SERVER['REMOTE_ADDR']);
			if(g ( "gourl")=="livechat") $doc_file -> addParamField("UserIcoLine", 1);
			$doc_file -> addParamWhere("UserID", $row["userid"]);
			$doc_file -> update();
		}
		
		CurUser::setUserId($row["userid"]);
		CurUser::setUserName($row["fcname"]);
		CurUser::setLoginName($row["username"]);
		if($isEncrypt) CurUser::setPassword($password);
		else CurUser::setPassword(md5($password));
		if(getAppValue("Type")!="0") CurUser::setPassword($password);
		CurUser::setAdmin($row["ismanager"]);
		
//		echo getValue("department");
//		exit();
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().$antRes,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],25);
		//if ($row["col_disabled"] == "1")
			//return array("status"=>0,"errnum"=>102003);
		if($isclient)
		    $printer->out_detail ( $file_item, '', 0 );

		return $result ;
	}
	
	
	function setLoginInfo_LoginName($loginName)
	{
		$user = new Model("Users_ID");
		
		if (DB_TYPE == "oracle")
			$user -> addParamWhere("upper(UserName)",strtoupper($loginName)) ;
		else
			$user -> addParamWhere("UserName",$loginName) ;
			
		$row = $user -> getDetail() ;

		$this -> setLoginInfo($row);
		

		if (count($row) == 0)
			return array("status"=>0,"errnum"=>102001);
		else
			return array("status"=>1,"data"=>$row);
	}
	
	function setLoginInfo_UserId($userId)
	{
		$user = new Model("Users_ID");
		$user -> addParamWhere("UserID",$userId) ;
			
		$row = $user -> getDetail() ;
		
		$this -> setLoginInfo($row);
		if (count($row) == 0)
			return array("status"=>0,"errnum"=>102001);
		else
			return array("status"=>1,"data"=>$row);
	}
	
	/*
	method	设置登录信息
	*/
	function setLoginInfo($row,$password = "")
	{
		if (count($row) == 0)
			return ;
	
			
		//得到用户的角色
//		$db = new DB();
//		$sql = " select col_hsitemid from hs_relation where col_dhsitemtype=" . EMP_USER . " and col_dhsitemid=" . $row["col_id"] . " and col_hsitemtype=" . EMP_ROLE . " union " . " select col_id from hs_role where col_name='everyone' ";
//		$data_role = $db -> executeDataTable($sql) ;
//		$role_ids = table_column_tostring($data_role,"col_hsitemid");
//		
//		if ($role_ids == "")
//			$role_ids = "0" ;
		
		CurUser::setUserId($row["userid"]);
		CurUser::setUserName($row["fcname"]);
		CurUser::setLoginName($row["username"]);
		CurUser::setPassword(md5($password));
		CurUser::setAdmin($row["ismanager"]);

		
	}


	function encryptPassword($password,$entype)
	{
		switch($entype)
		{
			case 1:
				return md5($password);
			default:
				return $password ;
		}
	}

}

?>