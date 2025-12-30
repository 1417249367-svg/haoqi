<?php
	//header("Content-Type:text/html;charset=utf-8");
	require_once("fun1.php");
	require_once(__ROOT__ . "/config/cloud.inc.php");
	require_once(__ROOT__ . "/class/common/Ziper.class.php");
	require_once(__ROOT__ . "/class/common/BigUpload.class.php");
    require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");
	require_once(__ROOT__ . "/class/common/imagefilter.class.php");
	require_once(__ROOT__ . "/class/doc/DocXML.class.php");
	require_once(__ROOT__ . "/class/doc/DocDir.class.php");
	require_once(__ROOT__ . "/class/doc/DocFile.class.php");
	require_once(__ROOT__ . "/class/doc/DocRelation.class.php");
	require_once(__ROOT__ . "/class/doc/Doc.class.php");
	require_once(__ROOT__ . "/class/doc/DocAce.class.php");
	require_once(__ROOT__ . "/class/doc/DocSubscribe.class.php");
	require_once(__ROOT__ . "/class/im/Msg.class.php");
	
//	ob_clean ();
//	if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
//	
//	}else{
//	header("Access-Control-Allow-Origin: *");
//	header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//	}
    isPublicNet();
	$op = g("op") ;
	$printer = new Printer();
	$db = new DB();

    if (g("myid")) setValue("myid",g("myid"));
	else{
	if (g("root_type",0) == 1)
		setValue("myid","Public");
	else
		setValue("myid",CurUser::getUserId());
	}
			
	switch($op)
	{
//		case "doc_list":
//			doc_list();
//			break ;
//		case "doc_list1":
//			doc_list1();
//			break ;
//		case "doc_rename":
//			doc_rename();
//			break ;
//		case "doc_delete":
//			doc_delete();
//			break ;
//		case "doc_move":
//			doc_move();
//			break ;
//		case "doc_save":
//			doc_save();
//			break ;
//		case "doc_m_upload":
//			doc_m_upload();
//			break ;
//		case "doc_clotfile_upload":
//			doc_clotfile_upload();
//			break ;
//		case "doc_c_upload":
//			doc_c_upload();
//			break ;
//		case "doc_webrtcPic_upload":
//			doc_webrtcPic_upload();
//			break ;
//		case "doc_SetverPic_upload":
//			doc_SetverPic_upload();
//			break ;
//		case "doc_download":
//			doc_download();
//			break ;
//		case "create" :
//			create();
//			break;
//		case "folder_create":
//			folder_create();
//			break;
//		case "ptpform":
//			ptpform();
//			break;
//		case "ptpform_quit":
//			ptpform_quit();
//			break;
//		case "ptpform_add":
//			ptpform_add();
//			break;
//		case "ptpform_delete":
//			ptpform_delete();
//			break;
//		case "doc_upload":
//			doc_upload();
//			break;
//		case "doc_bigupload":
//			doc_bigupload();
//			break;
//		case "doc_subscribe_add":
//			doc_subscribe_add();
//			break;
//		case "doc_subscribe_cancel":
//			doc_subscribe_cancel();
//			break;
//		case "doc_attr":
//			doc_attr();
//			break ;
//		case "get_root_tree":
//			get_root_tree();
//			break ;
//		case "get_tree":
//			get_tree();
//			break ;
//		case "getimg":
//			getimg();
//			break ;
//		case "getmimg":
//			getmimg();
//			break ;
//		case "getfile":
//			getfile();
//			break ;
//		case "getlatestfile":
//			getlatestfile();
//			break ;
//		case "getpdffile":
//			getpdffile();
//			break ;
//		case "getonlinefile":
//			getonlinefile();
//			break ;
//		case "getpage":
//			getpage();
//			break ;
//		case "test":
//			$name = g("name");
//			println($name);
//			$path = "" . $name ;
//			println(file_exists($path)?"exists":"no exists");
//			break;
//		case "doc_onlinefile_save":
//			doc_onlinefile_save();
//			break ;
//		case "doc_revisedfile_save":
//			doc_revisedfile_save();
//			break ;
//		case "doc_onlinefile_upload":
//			doc_onlinefile_upload();
//			break;
//		case "doc_onlinefile_rename":
//			doc_onlinefile_rename();
//			break;
//		case "doc_onlinefile_az":
//			doc_onlinefile_az();
//			break;
//		case "doc_onlinefile_delete":
//			doc_onlinefile_delete();
//			break;
//		case "get_onlinefile_id":
//			get_onlinefile_id();
//			break;
		case "doc_videofile_save":
			doc_videofile_save();
			break ;
//		case "edit" :
//			save ();
//			break;
//		case "detail" :
//			detail ();
//			break;
	}
	
	function doc_videofile_save()
	{
		Global $printer;
		$filename = js_unescape(g("filename"));
		$FormFileType = g("FormFileType");
		$ids = "" ;
		$filpath = str_replace(RTC_CONSOLE."/","",js_unescape(g("exchangeFile"))) ;
		
		
		$doc = new Doc();
		$doc_file = new Model("MD5VideoFile");
		switch ($FormFileType) {
			case 1 :
				$sql = " select * from PtpFile where Msg_ID='" . g("Msg_ID") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update PtpFile set OnlineID=".$file_item["ID"]." where Msg_ID='" . g("Msg_ID") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["ID"] ;  
				   }
				}
				break;
			case 2 :
				$sql = " select * from LeaveFile where Msg_ID='" . g("Msg_ID") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update LeaveFile set OnlineID=".$file_item["ID"]." where Msg_ID='" . g("Msg_ID") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["ID"] ;  
				   }
				}
				break;
			case 4 :
				$sql = " select * from ClotFile where Msg_ID='" . g("Msg_ID") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update ClotFile set OnlineID=".$file_item["ID"]." where Msg_ID='" . g("Msg_ID") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				break;	
		}
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from MD5VideoFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

		$printer -> out_list($data,-1,0);
	}
?>