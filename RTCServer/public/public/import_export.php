<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/HS.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Col.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/TXTHelper.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/PinYin.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/LdapHelper.class.php");?>
<?php  require_once(__ROOT__ . "/vendor/PHPExcel/PHPExcel.php");?>
<?php  require_once __ROOT__ . '/vendor/PHPExcel/PHPExcel/Reader/Excel2007.php';?>
<?php  require_once __ROOT__ . '/vendor/PHPExcel/PHPExcel/Reader/Excel5.php';?>
<?php  require_once(__ROOT__ . "/vendor/PHPExcel/PHPExcel/IOFactory.php");?>
<?php
isPublicNet();
$op = g ( "op" );
$printer = new Printer ();
$fileHelper = new TXTHelper ();
$excelHelper = new PHPExcel ();

switch ($op) {
	
	case "import_user" :
		import_user ();
		break;
		
	case "import_ldap_user" :
		import_ldap_user ();
		break;
	
	case "export_user" :
		export_user ();
		break;
	
	case "export_user_bywhere" :
		export_user_bywhere ();
		break;

	case "export_user_online" :
		export_user_online ();
		break;
		
	case "import_dept" :
		import_dept ();
		break;
	
	case "export_dept" :
		export_dept ();
		break;
		
	case "import_rtx" :
		import_rtx ();
		break;
	
		
	case "import_col" :
		import_col ();
		break;
		
	case "export_col" :
		export_col ();
		break;
		
	default :
		break;
}

function import_ldap_user(){
	recordLog ( get_lang("import_export_start_time")."：" . date ( "Y-m-d H:i:s" ) );
	$result = array("status" => 1,"msg" => "");
	Global $printer;
	$domain = g("domain");
	$adminUser = g("adminuser");
	$adminPassword = g("adminpassword");
	$adLdap = new LdapHelper($domain,$adminUser,$adminPassword);
	$dept = new Department();
	$dept ->isLdap = true;
	
	$adLdap->connect();
	
	if(!$adLdap->ldapBind)
	{
		$result = array("status" => 0,"msg" => get_lang("import_export_warning"));
	}
	
	if($result ["status"] == 1)
	{
		$params = array();
		$params[] = array("name"=> "domain","value"=> $domain,"type"=> "AntAuthenConfig");
		$config = new SYSConfig ();
		$config -> setConfig($params);
	}
	
	if($result ["status"] == 1)
	{
		$arrDepts = $adLdap->list_org();
//		echo var_dump($arrDepts);
//		exit();
		foreach($arrDepts as $key=>$val)
		{
			$deptInfo = $dept->getIdByPath($val);
			
			if($deptInfo)
				$result ["status"] = 1;
			else
				$result ["status"] = 0;
		}
	}

	if($result ["status"] == 1)
	{
		recordLog(get_lang("import_export_warning1"));
		foreach ($adLdap->orgUnit as $key=>$val)
		{
			$arrUsers = $adLdap->list_user($val);
		//echo var_dump($arrUsers);

			$hs = new HS ();
			$hs->isLdap = true;
			$hs->import_user ( $arrUsers );
		}
				//exit();
	}
	
//	$user = new User ();
//	$user->setPinYin ();
//	recordLog ( get_lang("import_export_end_time")."：" . date ( "Y-m-d H:i:s" ) );
	// printer
	if ($result ["status"])
		$printer->success ();
	else
		$printer->fail ( $result ["msg"] );
}

function import_user() 
{
	recordLog ( get_lang("import_export_start_time")."：" . date ( "Y-m-d H:i:s" ) );
	Global $printer;
	Global $fileHelper;
	Global $excelHelper;
	
	$file = g ( "file" );
//	$isQuick = g ( "quick", "0" );
	// file to array
	//$data = $fileHelper->file2array ( "../" . $file );
	$data = $excelHelper->excelToArray(RTC_CONSOLE. "/" . $file);
//	echo var_dump($data);
//	exit();
	// array to db
	$hs = new HS ();
//	if ($isQuick == "1")
//		$result = $hs->import_user_quick ( $data );
//	else
		$result = $hs->import_user ( $data );
		
		// set pinyin
//	$user = new User ();
//	$user->setPinYin ();
	
	recordLog ( get_lang("import_export_end_time")."：" . date ( "Y-m-d H:i:s" ) );
	// printer
	if ($result ["status"])
		$printer->success ();
	else
		$printer->fail ( $result ["msg"] );
}


function import_dept() 
{
	Global $printer;
	Global $fileHelper;
	Global $excelHelper;
	
	$file = g ( "file" );
	// file to array
	//$data = $fileHelper->file2array ( "../" . $file );
	$data = $excelHelper->excelToArray(RTC_CONSOLE. "/" . $file);
//	echo var_dump($data);
//	exit();
	if (count ( $data ) == 0)
		$printer->fail (get_lang("import_export_warning2"));
	
	$flag = count ( $data [0] ) == 3 ? 1 : 0; // 1列表示路径导入 3列表示表格导入

	if ($flag) {
		$data_new = array ();
		foreach ( $data as $row ) {
			if (count ( $row ) < 3) {
				$printer->fail (get_lang("import_export_warning3"));
			}
			$data_new [] = array (
							"id" => $row [0],
							"name" => $row [1],
							"parent_id" => $row [2] 
			);
		}
		$data = $data_new;
	}
	// array to db
	$hs = new HS ();
	if ($flag)
		$result = $hs->import_dept ( $data );
	else
		$result = $hs->import_dept_bypath ( $data );
		
		// printer
	if ($result ["status"])
		$printer->success ();
	else
		$printer->fail ( $result ["msg"] );
}

function import_rtx() 
{
	Global $printer ;
	
	$file = g("file");
	$file = RTC_CONSOLE . "/" . $file ;

	if(! strpos($file,"xml"))
		$printer -> fail(get_lang("valid_file_type_error")) ;
		
	if (! file_exists($file))
		$printer -> fail(get_lang("valid_file_not_exist")) ;
	
	
	$content = readFileContent($file);
	$content = str_replace("'","\"",$content) ;
	$content = str_replace("<?xml version=\"1.0\" encoding=\"gb2312\"?>","",$content) ;
//	$content = str_replace("<BODY>","",$content) ;
//	$content = str_replace("</BODY>","",$content) ;
	//$content = str_replace("[Port]",$_SERVER["SERVER_PORT"],$content) ;

	//得到属性
	$col_name = "" ;
	$col_data = iconv_str($content);

	
	$col_desc = "" ;
	$col_addintype = 1 ;  
	
	$data = readXMLFile($file);
	$hs = new HS ();
	$db = new DB();
	foreach($data as $item)
	{
		$tag = $item["tag"] ;
		if($tag=="ITEM"){
			$row = array ();
			switch(count($item["attributes"])){
				case 19 :
				    array_push($row,$item["attributes"]["ID"],$item["attributes"]["USERNAME"],$item["attributes"]["NAME"],(int)$item["attributes"]["GENDER"]+1,'',$item["attributes"]["MOBILE"],'','123',$item["attributes"]["EMAIL"],$item["attributes"]["PHONE"],$item["attributes"]["ACCOUNTSTATE"]==''?"1":"0",$item["attributes"]["ID"]);
					$hs->import_an_rtxuser ( $row );
					break;
//				case 24 :
//					if($item["attributes"]["POSITION"]) echo count($item["attributes"]).'|'.$item["attributes"]["ID"].'|'.$item["attributes"]["POSITION"].'<br>';
//					break;
				case 8 :
					$data = array (
							"TypeID" => substr(((int)$item["attributes"]["DEPTID"]+1000000),-6),
							"TypeName" => $item["attributes"]["DEPTNAME"],
							"ParentID" => substr(((int)$item["attributes"]["PDEPTID"]+1000000),-6),
							"Description" => $item["attributes"]["DEPTDESCRIPTION"],
							"ItemIndex" => $item["attributes"]["SORTID"],
							"CreatorID"=>CurUser::getUserId(),
							"CreatorName"=>CurUser::getUserName()
					);
					$params = $db->parseDataParam ( $data );
					$sql = $db->getInsertSQL ( "Users_Ro", $params );
					$db -> execute ($sql);
					break;
				case 3 :
					$sql = " update Users_ID set UppeID='" . substr(((int)$item["attributes"]["DEPTID"]+1000000),-6) . "' where UserID='" . $item["attributes"]["USERID"] . "'";
					$db -> execute($sql);
					break;
			}
		}
	}
	// array to db
	$user = new Model("Users_ID","UserID");
	$user -> updateForm("Users_RoVesr");
	$user -> updateForm("Users_IDVesr");
		// set pinyin
//	$user = new User ();
//	$user->setPinYin ();
	
	recordLog ( get_lang("import_export_end_time")."：" . date ( "Y-m-d H:i:s" ) );
	// printer
	$printer->success ();
}

function import_col() 
{
	recordLog ( get_lang("import_export_start_time")."：" . date ( "Y-m-d H:i:s" ) );
	Global $printer;
	Global $fileHelper;
	Global $excelHelper;
	
	$file = g ( "file" );
	$data = $excelHelper->excelToArray(RTC_CONSOLE. "/" . $file);
//		echo var_dump($data);
//	exit();
	$col = new Col();
	$result = $col->import_user ( $data );

	recordLog ( get_lang("import_export_end_time")."：" . date ( "Y-m-d H:i:s" ) );
	// printer
	if ($result ["status"])
		$printer->success ();
	else
		$printer->fail ( $result ["msg"] );
}


function export_user() 
{
	Global $printer;
	
	// db to array
	$hs = new HS ();
	$data = $hs->export_user ();
//	echo var_dump($data);
//	exit();
	// array to file
	Global $fileHelper;
	//$file = $fileHelper->array2file ( $data, "user_" . getAutoId () );
    $file = arrayToExcel_user ( $data, "user_" . getAutoId () );
	
	$printer->success ( $file );
}


function export_user_bywhere() 
{
	Global $printer;
	
	// db to array
	$hs = new HS ();
	$data = $hs->export_user_bywhere ( stripslashes(g ( "where" )), g ( "path" ) );
	// array to file
	Global $fileHelper;
	//$file = $fileHelper->array2file ( $data, "user_" . getAutoId () );
	$file = arrayToExcel_user ( $data, "user_" . getAutoId () );
	
	$printer->success ( $file );
}

function export_user_online() 
{
	Global $printer;
	
	// db to array
	$hs = new HS ();
	$data = $hs->export_user_byonline ( stripslashes(g ( "where" )) );
//	echo var_dump($data);
//	exit();
	// array to file
	Global $fileHelper;
	//$file = $fileHelper->array2file ( $data, "user_" . getAutoId () );
    $file = arrayToExcel_online ( $data, "onlineuser_" . getAutoId () );
	
	$printer->success ( $file );
}

function export_dept() 
{
	Global $printer;
	
	// db to array
	$hs = new HS ();
	$data = $hs -> export_dept ();
//	echo var_dump($data);
//	exit();
	// array to file
	Global $fileHelper;
	//$file = $fileHelper->array2file ( $data, "dept_" . getAutoId () );
	$file = arrayToExcel_dept ( $data, "dept_" . getAutoId () );
	
	$printer->success ( $file );
}

function export_col() 
{
	Global $printer;
	
	// db to array
	$col = new Col();
	$data = $col->export_user ();
//	echo var_dump($data);
//	exit();
	// array to file
	Global $fileHelper;
	//$file = $fileHelper->array2file ( $data, "user_" . getAutoId () );
    $file = arrayToExcel_col ( $data, "col_" . getAutoId () );
	$printer->success ( $file );
}

function arrayToExcel_user($data,$file = ""){
	if ($file == "")
		$file = getAutoId() ;
	$file = "../Data/export/". $file .".xls" ;

	if (file_exists($file))
		unlink($file) ;
		
	//$file_path = str_replace("/","\\",$file);
	$dir = substr($file,0,strrpos($file,"/"));

	if(!file_exists($dir))
	   mkdirs($dir);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('firstsheet');
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	//add data
	$i = 2;
	$objPHPExcel->getActiveSheet()->setCellValue('A1', get_lang("class_PHPExcel_UppeID"));
	//$objPHPExcel->getActiveSheet()->getCell('A1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', get_lang("class_PHPExcel_UserName"));
	//$objPHPExcel->getActiveSheet()->getCell('B1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', get_lang("class_PHPExcel_FcName"));
	//$objPHPExcel->getActiveSheet()->getCell('C1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', get_lang("class_PHPExcel_UserIco"));
	//$objPHPExcel->getActiveSheet()->getCell('D1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', get_lang("class_PHPExcel_Effigy"));
	//$objPHPExcel->getActiveSheet()->getCell('E1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', get_lang("class_PHPExcel_Tel1"));
	//$objPHPExcel->getActiveSheet()->getCell('F1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', get_lang("class_PHPExcel_Jod"));
	//$objPHPExcel->getActiveSheet()->getCell('G1')->setDataType('n');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', get_lang("class_PHPExcel_UserPaws"));
	//$objPHPExcel->getActiveSheet()->getCell('H1')->setDataType('n');
	foreach ($data as $line){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $line[0]);
		//$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $line['username']);
		//$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $line['fcname']);
		//$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $line['userico']);
		//$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $line['effigy']);
		//$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $line['tel1']);
		//$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $line['jod']);
		//$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setDataType('n');
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $line['userpaws']);
		//$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setDataType('n');
		$i++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($file);
	return $file ;

// Create new PHPExcel object
//$objPHPExcel = new PHPExcel();
//
//$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->setCellValue('A1', "Firstname");
//$objPHPExcel->getActiveSheet()->setCellValue('B1', "Lastname");
//$objPHPExcel->getActiveSheet()->setCellValue('C1', "Phone");
//$objPHPExcel->getActiveSheet()->setCellValue('D1', "Fax");
//$objPHPExcel->getActiveSheet()->setCellValue('E1', "Is Client ?");
//
//
//
//
//// Add data
//for ($i = 2; $i <= 100; $i++) {
//	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, "FName $i")
//	                              ->setCellValue('B' . $i, "LName $i")
//	                              ->setCellValue('C' . $i, "PhoneNo $i")
//	                              ->setCellValue('D' . $i, "FaxNo $i")
//	                              ->setCellValue('E' . $i, true);
//}
//
//
//// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);
//
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', $file));
}

function arrayToExcel_online($data,$file = ""){
	if ($file == "")
		$file = getAutoId() ;
	$file = "../Data/export/". $file .".xls" ;

	if (file_exists($file))
		unlink($file) ;
		
	//$file_path = str_replace("/","\\",$file);
	$dir = substr($file,0,strrpos($file,"/"));

	if(!file_exists($dir))
	   mkdirs($dir);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('firstsheet');
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	//add data
	$i = 2;
	$objPHPExcel->getActiveSheet()->setCellValue('A1', get_lang("online_list_table_account"));
	$objPHPExcel->getActiveSheet()->setCellValue('B1', get_lang("online_list_table_user"));
	$objPHPExcel->getActiveSheet()->setCellValue('C1', get_lang("field_dept"));
	$objPHPExcel->getActiveSheet()->setCellValue('D1', get_lang("user_list_col_sex"));
	$objPHPExcel->getActiveSheet()->setCellValue('E1', get_lang("online_list_table_version"));
	$objPHPExcel->getActiveSheet()->setCellValue('F1', get_lang("online_list_table_logintime"));
	$objPHPExcel->getActiveSheet()->setCellValue('G1', get_lang("online_list_table_mac"));
	$objPHPExcel->getActiveSheet()->setCellValue('H1', get_lang("online_list_table_ip"));
	foreach ($data as $line){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $line['username']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $line['fcname']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $line['path']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $line['userico']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $line['usericoline']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $line['logintime']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $line['mac']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $line['localip']);
		$i++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($file);
	return $file ;
}

function arrayToExcel_dept($data,$file = ""){
	if ($file == "")
		$file = getAutoId() ;
	$file = "../Data/export/". $file .".xls" ;
	
	if (file_exists($file))
		unlink($file) ;

	//$file_path = str_replace("/","\\",$file);
	$dir = substr($file,0,strrpos($file,"/"));

	if(!file_exists($dir))
	   mkdirs($dir);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('firstsheet');
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	//add data
	$i = 2;
	$objPHPExcel->getActiveSheet()->setCellValue('A1', get_lang("class_PHPExcel_UppeID"));
	$objPHPExcel->getActiveSheet()->setCellValue('B1', get_lang("class_PHPExcel_ItemIndex"));
	foreach ($data as $line){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $line['path']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $line['itemindex']);
		$i++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($file);
	return $file ;
}

function arrayToExcel_col($data,$file = ""){
	if ($file == "")
		$file = getAutoId() ;
	$file = "../Data/export/". $file .".xls" ;
	
	if (file_exists($file))
		unlink($file) ;

	//$file_path = str_replace("/","\\",$file);
	$dir = substr($file,0,strrpos($file,"/"));

	if(!file_exists($dir))
	   mkdirs($dir);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('firstsheet');
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	//add data
	$i = 2;
	$objPHPExcel->getActiveSheet()->setCellValue('A1', get_lang("class_PHPExcel_Col_Ro"));
	$objPHPExcel->getActiveSheet()->setCellValue('B1', get_lang("class_PHPExcel_Col_Form"));
	foreach ($data as $line){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $line[0]);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, js_unescape($line['ncontent']));
		$i++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($file);
	return $file ;
}
?>