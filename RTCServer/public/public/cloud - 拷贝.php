<?php
	require_once("fun.php");
	require_once(__ROOT__ . "/config/cloud.inc.php");
	require_once(__ROOT__ . "/class/common/Ziper.class.php");
    require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");
	require_once(__ROOT__ . "/class/doc/DocXML.class.php");
	require_once(__ROOT__ . "/class/doc/DocDir.class.php");
	require_once(__ROOT__ . "/class/doc/DocFile.class.php");
	require_once(__ROOT__ . "/class/doc/DocRelation.class.php");
	require_once(__ROOT__ . "/class/doc/Doc.class.php");
	require_once(__ROOT__ . "/class/doc/DocAce.class.php");
	require_once(__ROOT__ . "/class/doc/DocSubscribe.class.php");

	$op = g("op") ;
	$printer = new Printer();
	$db = new DB();

    if (g("myid")) setValue("myid",g("myid"));
	else{
	if (g("root_type",0) == 1)
		setValue("myid","Public");
	elseif (g("root_type",0) == 3)
		setValue("myid",CurUser::getUserId());
	}
			
	switch($op)
	{
		case "doc_list":
			doc_list();
			break ;
		case "doc_rename":
			doc_rename();
			break ;
		case "doc_delete":
			doc_delete();
			break ;
		case "doc_move":
			doc_move();
			break ;
		case "doc_save":
			doc_save();
			break ;
		case "doc_m_upload":
			doc_m_upload();
			break ;
		case "doc_clotfile_upload":
			doc_clotfile_upload();
			break ;
		case "doc_c_upload":
			doc_c_upload();
			break ;
		case "doc_download":
			doc_download();
			break ;
		case "folder_create":
			folder_create();
			break;
		case "ptpform":
			ptpform();
			break;
		case "ptpform_quit":
			ptpform_quit();
			break;
		case "ptpform_add":
			ptpform_add();
			break;
		case "ptpform_delete":
			ptpform_delete();
			break;
		case "doc_upload":
			doc_upload();
			break;
		case "doc_subscribe_add":
			doc_subscribe_add();
			break;
		case "doc_subscribe_cancel":
			doc_subscribe_cancel();
			break;
		case "doc_attr":
			doc_attr();
			break ;
		case "get_root_tree":
			get_root_tree();
			break ;
		case "getimg":
			getimg();
			break ;
		case "getmimg":
			getmimg();
			break ;
		case "getfile":
			getfile();
			break ;
		case "getpage":
			getpage();
			break ;
		case "test":
			$name = g("name");
			println($name);
			$path = "" . $name ;
			println(file_exists($path)?"exists":"no exists");
			break;
		case "doc_onlinefile_save":
			doc_onlinefile_save();
			break ;
		case "doc_revisedfile_save":
			doc_revisedfile_save();
			break ;
		case "doc_onlinefile_upload":
			doc_onlinefile_upload();
			break;
		case "doc_onlinefile_rename":
			doc_onlinefile_rename();
			break;
		case "doc_onlinefile_az":
			doc_onlinefile_az();
			break;
		case "doc_onlinefile_delete":
			doc_onlinefile_delete();
			break;
		case "edit" :
			save ();
			break;
		case "detail" :
			detail ();
			break;
	}

	function get_root_tree()
	{
		Global $printer;

		$node_id = g("id") ;
		$root_id = g("root_id") ;

		$docXML = new DocXML();

		if ($node_id)
			$data = $docXML -> get_tree($node_id);
		else
			$data = $docXML -> get_root_tree($root_id);  //得到ROOT下的文件

		$printer -> out_xml($data);
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到地址
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getpath()
	{
//		$root_type = g("root_type",0) ;
//		$root_id = g("root_id",0) ;
		
		$file_name = js_unescape(g("name")) ;
		$arrfile = explode(chr(92).chr(92),$file_name);
		$file_name = iconv_str($arrfile[2],"UTF-8","GBK") ;
//		echo $file_name;
//		exit();

		$doc = new Doc();
		$path = format_path(RTC_CONSOLE."\\".$arrfile[0]."\\".$arrfile[1]."\\");
		return $path ;
	}
	
	function getpathname()
	{
//		$root_type = g("root_type",0) ;
//		$root_id = g("root_id",0) ;
		
		$file_name = js_unescape(g("name")) ;
		$arrfile = explode(chr(92).chr(92),$file_name);
		$file_name = iconv_str($arrfile[2],"UTF-8","GBK") ;
//		echo $file_name;
//		exit();

//		$doc = new Doc();
//		$path = format_path(RTC_CONSOLE."\\".$arrfile[0]."\\".$arrfile[1]."\\");
		return $file_name ;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//下载文件(单个文件)
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getfile()
	{
		Global $printer;
 		$label = g("label");
		if ($label == "leavefile")
		{
			getfile1();
			return ;
		}
		
		if ($label == "oos")
		{
			getfile2();
			return ;
		}

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		//非路径得到文件
		if ($parent_id == 0)
		{
			$parent_type =  DOC_FILE ;
			$parent_id = g("id") ;
		}
		
		$doc = new Doc();
		//得到详情
		$sql = " select * from PtpFile where ID=" . g("id");

		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)) setValue("myid",$data["myid"]);

		//权限判断
		if (! (DocAce::can(DOCACE_DOWNLOAD)||g("myid")))
//		    $printer -> fail("你没有权限下载");
			$printer -> out_str('<script type="text/javascript">alert("你没有权限下载");</script>') ;

//		$file_name = js_unescape(g("filename")) ;
		$file_name = getpathname() ;

		$file_path = getpath();
		
//		echo $file_path;
//		exit();
		$antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."下载云盘文件".iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		$printer -> out_stream($file_name,$file_path);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//下载文件(单个文件)
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getfile1()
	{
		Global $printer;
		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		//非路径得到文件
		if ($parent_id == 0)
		{
			$parent_type =  DOC_FILE ;
			$parent_id = g("id") ;
		}
		
		//权限判断
		if (! DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE))
			//$printer -> fail("你没有权限下载");
			$printer -> out_str('<script type="text/javascript">alert("你没有权限下载");</script>') ;
		
		$file_name = getpathname() ;
		$file_path = getpath();
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."下载离线文件".iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		
		$printer -> out_stream($file_name,$file_path);
	}
	
	function getfile2()
	{
		Global $printer;
		$url = $_SERVER ["REQUEST_URI"];
		$file_name = getpathname() ;
		$file_path = getpath();
		if(strrpos( $url, "contents" )) $printer -> out_stream($file_name,$file_path);		
		else{
		  $path=$file_path.$file_name;
		  if(file_exists($path)){
			$handle=fopen($path,"r");
			$size=filesize($path);
			$contents=fread($handle,$size);
			$SHA256=base64_encode(hash('sha256',$contents,true));
			$json=array(
			'BaseFileName'=>$file_name,
			'OwnerId'=>'admin',
			'Size'=>$size,
			'SHA256'=>$SHA256,
			'Version'=>'1',
			);
			echo json_encode($json);
		  }else echo json_encode(array());
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//查看图片
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getimg()
	{
		Global $printer;

		$can = 1;
		$parent_type = (int)g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		//$parent_id>0 表示有查看判断，不需要再权限判断
//		if ($parent_id == 0)
//		{
			//权限判断
			//$parent_type =  DOC_FILE ;
			//$parent_id = g("id") ;
			if($parent_type == DOC_LeaveFile) $can = DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE);
			else $can = DocAce::can(DOCACE_DOWNLOAD)||g("myid") ;
//		}

		if ($can){
			$file_path = getpath();
			$file_pathname = getpathname();
			$file_type = strtolower(substr($file_pathname,strrpos($file_pathname,".")+1)) ;
			if(($file_type!="jpg")&&($file_type!="gif")) $filepath=$file_path.$file_pathname;
			else{
				if (! file_exists($file_path."small/".$file_pathname)){
					$t = new ThumbHandler ();
					$t->setSrcImg ( $file_path.$file_pathname );
					$t->setCutType ( 1 );
					$t->setDstImg ( $file_path."small/".$file_pathname );
					$t->createImg ( 25);
				}
				$filepath=$file_path."small/".$file_pathname;
			}

		}
		else
		{
			//指向到空白的图片
			$filepath = __ROOT__ . "/static/img/img_nopower" . (g("type") == "thumb"?"_s":"") . ".png" ;
		}
//echo $file_path;
//exit();
		Global $printer;
		$printer -> out_img($filepath);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//查看图片
	////////////////////////////////////////////////////////////////////////////////////////////////
//	function getmimg()
//	{
//		Global $printer;
//
//		$can = 1;
//		$parent_type = (int)g("parent_type");
//		$parent_id = g("parent_id");
//		$root_id = g("root_id");
//
//		if($parent_type == DOC_LeaveFile) $can = DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE);
//		else $can = DocAce::can(DOCACE_DOWNLOAD)||g("myid") ;
//
//        $filepath="";
//		if ($can){
//			$file_path = getpath();
//			$file_pathname = getpathname();
//			$file_type = strtolower(substr($file_pathname,strrpos($file_pathname,".")+1)) ;
//			if(($file_type!="jpg")&&($file_type!="gif")) $filepath=$file_path.$file_pathname;
//			else{
//				if (! file_exists($file_path."small/".$file_pathname)){
//					$t = new ThumbHandler ();
//					$t->setSrcImg ( $file_path.$file_pathname );
//					$t->setCutType ( 1 );
//					$t->setDstImg ( $file_path."small/".$file_pathname );
//					$t->createImg ( 25);
//				}
//				$filepath=$file_path."small/".$file_pathname;
//			}
//
//		}
////echo $file_path;
////exit();
//		Global $printer;
//		$printer -> out_mimg($filepath);
//	}

	function getpage()
	{	
		//$url = "http://".RTC_SERVER.":98/cloud/include/index.html#public";
		//header("Location:"+$url);
		//sleep(3);
		header("Location:../cloud/include/index.html#public");
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;

		Global $printer;
		$doc = new Doc();

		$doc_file = new Model("PtpFile");
//		$doc_relation = new Model($parent_type == DOC_ROOT?"TAB_DOC_ROOT_LINK":"TAB_DOC_VFOLDER_LINK");
		//权限判断
        $FileState = DocAce::can(DOCACE_CREATE);
//		echo $FileState;
//		exit();
//		if (! DocAce::can(DOCACE_CREATE))
//			doc_upload_callback("{\"status\":0,\"msg\":\"没有权限操作\"}") ;


		//得到存放目录 target_dir
		$target_dir = $doc -> get_root_dir($root_type,$root_id) ;
//		$file_attr = array("col_creator_id"=>CurUser::getUserId(),"col_creator_name" => CurUser::getUserName(),"col_rootid"=>$root_id);
//		$file_link = array("col_p_objid" => $parent_id,"col_s_classid" => DOC_FILE);

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
//			$filename = $doc -> modify_file($target_dir.'\\'.$file["name"]) ;
//			if ($doc -> exist_name($parent_type,$parent_id,DOC_FILE,$filename))
//				doc_upload_callback("{\"status\":0,\"msg\":\"文件【" . $filename . "】已经存在\"}") ;


			$file["name"] = $doc  -> modify_ptpfile($file["name"],$parent_id);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $target_dir);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;

			$file_item = $doc -> save_file($result["target"],$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,$FileState);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
		}
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
			$result = manager_username();
			ptpform_sendmsg($result,"云盘文件",5);
			doc_upload_callback("{\"status\":0,\"msg\":\"请等待管理员通过审核\"}") ;
		}else{
			$result = ptpform_username($file_item["PtpFolderID"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],1);
			$doc_file_vesr = new Model ( "PtpFile" );
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
			
//			$ch = curl_init();
//			$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile";
//			curl_setopt($ch, CURLOPT_URL, $url); 
//			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//			curl_exec($ch); 
//			curl_close ($ch); 
		}
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;

		//用 list 是方便脚本的数据绑定
		doc_upload_callback($response);
	}

	function doc_upload_callback($response)
	{
		$flag = g("flag");

		//来自 input 方式
		if ($flag == "html")
			$response = '<script type="text/javascript">parent.file_upload_callback(' . $response. ')</script>' ;
		recordLog($response);
		ob_clean();
		print($response);
		die();
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_onlinefile_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;

		Global $printer;
		$doc = new Doc();

		$doc_file = new Model("OnlineFile");
		//得到存放目录 target_dir
		$target_dir = $doc -> get_root_dir(5,$root_id) ;
		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
			$file["name"] = $doc  -> modify_onlinefile($file["name"]);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $target_dir);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;

			$file_item = $doc -> save_file3("OnlineFile".chr(92).CurUser::getUserId().chr(92)."1".chr(92).$result["target"],$result["filename"],number_format(round($result["filesize"] / 1024)),CurUser::getUserName());
			$ids .= ($ids?",":"") . $file_item["OnlineID"] ;
		}

		//返回数据
		if (substr($ids,","))
			$sql = " OnlineID in(" . $ids . ")" ;
		else
			$sql = " OnlineID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list2(DOC_FILE)) . " from OnlineFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;

		//用 list 是方便脚本的数据绑定
		doc_upload_callback1($response);
	}

	function doc_upload_callback1($response)
	{
		$flag = g("flag");

		//来自 input 方式
		if ($flag == "html")
			$response = '<script type="text/javascript">parent.file_upload_callback1(' . $response. ')</script>' ;
		recordLog($response);
		ob_clean();
		print($response);
		die();
	}
	
	function doc_rename()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$doc_type = g("doc_type");
		$doc_id = g("doc_id");
		$name = g("name");

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE))))
			$printer -> fail("你没有权限修改");;

		$doc = new Doc();
		$result = $doc -> doc_rename($parent_type,$parent_id,$doc_type,$doc -> get_ptpfileid($doc_id),$name);
		
		$doc -> doc_retime($parent_id);

		if ($result){
			$doc_file_vesr = new Model ( "PtpFolder" );
			if($doc_type==DOC_FILE){
				$doc_file_vesr -> updateForm("PtpFile_Vesr");
				$cmdstr="PtpFile";
			}else{
				$doc_file_vesr -> updateForm("PtpFolder_Vesr");
				$cmdstr="PtpFolder";
			}	
//			$ch = curl_init();
//			$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=".$cmdstr;
//			curl_setopt($ch, CURLOPT_URL, $url); 
//			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//			curl_exec($ch); 
//			curl_close ($ch); 	
			$printer -> success();
		}else
			$printer -> fail(($doc_type == DOC_FILE?"文件":"文件夹") . "已经存在！");
	}
	
	function doc_onlinefile_rename()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$doc_type = g("doc_type");
		$doc_id = g("doc_id");
		$name = g("name");

		$doc = new Doc();
		$result = $doc -> doc_rename1($parent_type,$parent_id,$doc_type,$doc -> get_ptpfileid($doc_id),$name);

		if ($result)
			$printer -> success();
		else
			$printer -> fail(($doc_type == DOC_FILE?"文件":"文件夹") . "已经存在！");
	}

	function doc_delete()
	{
		Global $printer;
 		$label = g("label");
		if ($label == "leavefile")
		{
			doc_delete1();
			return ;
		}
		
		if ($label == "clotfile")
		{
			doc_delete2();
			return ;
		}

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");

		$arr_id = explode(",",g("ids"));

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE))))
			$printer -> fail("你没有权限删除");


		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
				if(strpos($col_id,"|")){
					$arr = explode("|",$col_id);
					$result = ptpform_username($arr[2]);
					ptpform_sendmsg($result["ptpform"],$result["usname"],1);
				}else{
					$result = ptpform_username($col_id);
					ptpform_sendmsg($result["ptpform"],$result["usname"],3);
				}
				break;
			}
		}

		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				$col_myid=$arr_item[0];
				$col_rootid=$arr_item[count($arr_item)-1];
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
//				echo $col_myid."<br>";
//				echo $col_id."<br>";
//				echo $col_rootid."<br>";
//				exit();
				$doc -> delete($col_myid,$doc -> get_ptpfileid($col_id),$col_rootid);
			}
		}
		
		$doc -> doc_retime($parent_id);
		
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		$doc_file_vesr -> updateForm("PtpFile_Vesr");
		$doc_file_vesr -> updateForm("PtpForm_Vesr");
		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile,PtpFolder,PtpForm";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 
		
		$printer -> success();
	}
	
	function doc_delete1()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");

		$arr_id = explode(",",g("ids"));

		$doc = new Doc();
		$antLog = new AntLog();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
				$arr = explode("|",$col_id);
				$doc -> delete_db1($doc -> get_leavefileid($col_id),trim($arr[0]),trim($arr[1]));
				$antLog->log(CurUser::getUserName()."删除离线文件".trim($arr[1]),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
			}
		}
		
		$doc_file_vesr = new Model ( "LeaveFile" );
		$doc_file_vesr -> updateForm("LeaveFile_Vesr");
		
		$printer -> success();
	}
	
	function doc_delete2()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");

		$arr_id = explode(",",g("ids"));

		$doc = new Doc();
		$antLog = new AntLog();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
				$arr = explode("|",$col_id);
				$doc -> delete_db3($doc -> get_clotfileid($col_id),trim($arr[2]),trim($arr[1]));
				$antLog->log(CurUser::getUserName()."删除群组文件".trim($arr[1]),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
			}
		}
		
		$doc_file_vesr = new Model ( "ClotFile" );
		$doc_file_vesr -> updateForm("ClotFile_Vesr");
		
		$printer -> success();
	}
	
	function doc_onlinefile_delete()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		
		$file_type = g("file_type");

		$doc_id = g("doc_id");

		$doc = new Doc();
		$antLog = new AntLog();

		$doc -> delete_db2($doc_id,$file_type);
		$antLog->log(CurUser::getUserName()."删除在线文档".js_unescape(g("name")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);

		$printer -> success();
	}

	function doc_move()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$taget_type = g("taget_type") ;
		$taget_id = g("target_id") ;
		$arr_id = split(",",g("ids"));

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE))))
			$printer -> fail("你没有权限管理");

		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				$col_myid=$arr_item[0];
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
				$doc -> move($col_myid,$doc -> get_ptpfileid($col_id),$taget_type,$taget_id);
			}
		}
		$doc -> doc_retime($taget_id);
		$doc -> doc_retime($parent_id);

		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		$doc_file_vesr -> updateForm("PtpFile_Vesr");
		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile,PtpFolder";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 

		$printer -> success();
	}
	
	function doc_onlinefile_az()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$file_type = g("file_type");
		$doc_id = g("doc_id");

		$doc = new Doc();
		$doc -> istop($file_type,$doc_id);
		$printer -> success();
	}
	
	function doc_save()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$arr_id = split(",",g("ids"));

//		if (! DocAce::can(DOCACE_MANAGE))
//			$printer -> fail("你没有权限管理");
//echo getValue("myid");
//exit();
        setValue("myid",CurUser::getUserId());
        $FileState = DocAce::can(DOCACE_CREATE);
		if (g("myid")) setValue("myid",g("myid"));
		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
//				$col_myid=$arr_item[0];
//				$col_rootid=$arr_item[count($arr_item)-1];
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				$doc -> save($col_myid,$doc -> get_ptpfileid($col_id),$col_rootid,$FileState);

				$doc -> save($arr_item[0],$doc -> get_ptpfileid($arr_item[1]),$arr_item[2],$FileState);

			}
		}

		if (!$FileState)
		    $printer -> fail("保存成功，请等待管理员通过审核!");
		else{
			$doc_file_vesr = new Model ( "PtpFolder" );
			$doc_file_vesr -> updateForm("PtpFolder_Vesr");
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
			$printer -> success();
		}


		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile,PtpFolder";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 


	}

	function doc_onlinefile_save()
	{
		Global $printer;
		$filename = js_unescape(g("filename"));

		$doc = new Doc();
		$doc_file = new Model("OnlineFile");
		$filename = $doc  -> modify_onlinefile($filename);
		$file_item = $doc -> save_file3(str_replace("\\\\","\\",js_unescape(g("target_file"))),$filename,g("fileSize"),js_unescape(g("usname")));
		$ids .= ($ids?",":"") . $file_item["OnlineID"] ;
		//返回数据
		if (substr($ids,","))
			$sql = " OnlineID in(" . $ids . ")" ;
		else
			$sql = " OnlineID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list2(DOC_FILE)) . " from OnlineFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

//		$response = $printer -> parseList($data,0);
//		$response = 'rows:[' . $response . ']' ;
		//$printer -> success($response);
		$printer -> out_list($data,-1,0);



	}
	
	function doc_revisedfile_save()
	{
		Global $printer;
		$filename = js_unescape(g("filename"));

		$doc = new Doc();
		$doc_file = new Model("OnlineFile");
		$sql = " select * from OnlineFile where OnlineID=" . g("doc_id");
		$data = $doc -> db -> executeDataRow($sql);
		if (count($data) == 0)
			$printer -> fail("数据不存在");
		$file_item = $doc -> save_file4(g("doc_id"),str_replace("\\\\","\\",js_unescape(g("target_file"))),$data["typepath"],$data["pcsize"],$data["myid"],$data["usname"],CurUser::GetUserName().'将文档恢复到第'.g("doc_sid").'版');
		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from OnlineRevisedFile where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

//		$response = $printer -> parseList($data,0);
//		$response = 'rows:[' . $response . ']' ;
		//$printer -> success($response);
		$printer -> out_list($data,-1,0);



	}
	
	function doc_m_upload()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$filename = g("filename");

//		if (! DocAce::can(DOCACE_MANAGE))
//			$printer -> fail("你没有权限管理");
        $FileState = DocAce::can(DOCACE_CREATE);

		$doc = new Doc();
		if(!$parent_id){
		$data = $doc -> db -> executeDataRow("select PtpFolderID from PtpFolder where UsName = 'RTC' and MyID='" . CurUser::getUserId() . "'");
		if (count($data)) $parent_id = $data["ptpfolderid"] ;
		else{
		$doc_dir = new DocDir();
		$result = $doc_dir -> insert1($parent_type,'00000000','RTC');
		$parent_id = $result["ptpfolderid"];
		$new_parent_id=$parent_id;
		}
		}
		$filename = $doc  -> modify_ptpfile($filename,$parent_id);
		$file_item = $doc -> save_file2(js_unescape(g("target_file")),$filename,g("fileSize"),DOC_VFOLDER,$parent_id,$root_id,$FileState);
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,"云盘文件",5);
		    $printer -> fail("保存成功，请等待管理员通过审核!");
		}else{
			$result = ptpform_username($file_item["PtpFolderID"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],1);
			$doc_file_vesr = new Model ( "PtpFile" );
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
		}

		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from PtpFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;
		foreach($data as $k=>$v){
			$data[$k]['col_id'] = $new_parent_id ;
			$data[$k]['myid'] = CurUser::getUserId() ;
			$data[$k]['col_name'] = 'RTC' ;
		}
		
		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile,PtpFolder";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 


	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_clotfile_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;

		Global $printer;
		$doc = new Doc();

		$doc_file = new Model("ClotFile");
        $FileState = DocAce::can(DOCACE_DOWNLOAD_CLOTFILE);
		$target_dir = $doc -> get_root_dir(6,$parent_id) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
			$file["name"] = $doc  -> modify_clotfile($file["name"],$parent_id);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $target_dir);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
			$filpath="ClotFile".chr(92).$parent_id.chr(92).$result["target"];

		    $file_item = $doc -> save_file5($filpath,$result["filename"],number_format(round($result["filesize"] / 1024)),DOC_VFOLDER,$parent_id,$root_id,$FileState);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
			
			if($FileState) messenge_sendmsg($parent_id,"{b@".$filpath."}",1);
		}

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,"群组文件",5);
		    $printer -> fail("请等待管理员通过审核!");
		}else{
			$doc_file_vesr = new Model ( "ClotFile" );
			$doc_file_vesr -> updateForm("ClotFile_Vesr");
		}
		//返回数据
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from ClotFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	
	function doc_c_upload()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$filename = g("filename");
		$target_file = str_replace("/","\\",js_unescape(g("target_file")));
		$target_file = str_replace("{b@","",$target_file);
		$target_file = str_replace("}","",$target_file);

        $FileState = DocAce::can(DOCACE_DOWNLOAD_CLOTFILE);

		$doc = new Doc();
		$filename = $doc  -> modify_clotfile($filename,$parent_id);
		$file_item = $doc -> save_file5($target_file,$filename,g("fileSize"),DOC_VFOLDER,$parent_id,$root_id,$FileState);

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,"群组文件",5);
		    $printer -> fail("请等待管理员通过审核!");
		}else{
			$doc_file_vesr = new Model ( "ClotFile" );
			$doc_file_vesr -> updateForm("ClotFile_Vesr");
		}

		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (substr($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from ClotFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile,PtpFolder";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 


	}


	function folder_create()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$name = g("name");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE))))
			$printer -> fail("你没有权限创建");

		$doc = new Doc();
		if ($doc -> exist_name($parent_type,$parent_id,$doc_type,$name))
			$printer -> fail("[" . $name . "]已经存在");

		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,$parent_id,$name);
		
		$doc -> doc_retime($parent_id);
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."创建文件夹".$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);

		$doc_type = $result["type"] ;
		$fields = $doc -> get_fields_list($doc_type,$root_id) ;
		$sql = " select " . $fields . " from PtpFolder A where ID=" . $result["id"] ;
		$data = $doc -> db -> executeDataTable($sql) ;
		
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		if(g("ptpform")){
			$arr_id = split(",",g("ptpform"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$result["ptpfolderid"]);
				}
			}
			
			$result = ptpform_username($result["ptpfolderid"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],2);
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFolder";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 

		//用 list 是方便脚本的数据绑定
		$printer -> out_list($data,-1,0);
	}
	
	function ptpform()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$ptpfolderid = g("ptpfolderid");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if(g("ptpform")){
			$result = ptpform_username($ptpfolderid);
			$YouUserNames1=split(",",$result["ptpform"]);
			
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."'" ;
			$doc -> db -> execute($sql) ;
			$arr_id = split(",",g("ptpform"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$ptpfolderid);
				}
			}
			$result=ptpform_username($ptpfolderid);
			$YouUserNames2=split(",",$result["ptpform"]);
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			$diffB = array_diff($YouUserNames2, $YouUserNames1);
			ptpform_sendmsg(implode(",",$diffB),$result["usname"],2);
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."修改共享成员为".g("ptpform"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
		//用 list 是方便脚本的数据绑定
		$printer -> success();
	}
	
	function ptpform_quit()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$ptpfolderid = g("ptpfolderid");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if(g("ptpformid")){
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".trim(g("ptpformid"))."' and PtpFolderID='".$ptpfolderid."' and UserID='".CurUser::getUserId()."'" ;
			$doc -> db -> execute($sql) ;
			
			$result=ptpform_username($ptpfolderid,trim(g("ptpformid")));
			ptpform_sendmsg($result["ptpform"],"文件共享",4);
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName()."退出共享".trim(g("ptpformid")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
			
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}

		//用 list 是方便脚本的数据绑定
		$printer -> success();
	}

	function ptpform_add()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$ptpfolderid = g("ptpfolderid");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if(g("ptpform")){
			$result = ptpform_username($ptpfolderid);
			$YouUserNames1=split(",",$result["ptpform"]);
			
			$doc = new Doc();
			$arr_id = split(",",g("ptpform"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$ptpfolderid);
				}
			}
			$result=ptpform_username($ptpfolderid);
			$YouUserNames2=split(",",$result["ptpform"]);
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			$diffB = array_diff($YouUserNames2, $YouUserNames1);
			ptpform_sendmsg(implode(",",$diffB),$result["usname"],2);
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."添加共享成员".g("ptpform"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
		//用 list 是方便脚本的数据绑定
		$printer -> success();
	}
	
	function ptpform_delete()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$ptpfolderid = g("ptpfolderid");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if(g("ptpform")){
			$result = ptpform_username($ptpfolderid);
			$YouUserNames1=split(",",$result["ptpform"]);
			
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."' and UserID in ('" . str_replace(",","','",trim(g("ptpform"))) . "')" ;
			//echo $sql;
			//exit();
			$doc -> db -> execute($sql) ;
			
			$result=ptpform_username($ptpfolderid);
			$YouUserNames2=split(",",$result["ptpform"]);
			
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName()."删除共享成员".trim(g("ptpform")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
			
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}

		//用 list 是方便脚本的数据绑定
		$printer -> success();
	}
	//得到列表
	function doc_list()
	{
		Global $printer;

 		$label = g("label");
		if ($label == "favitor")
		{
			doc_list_favitor();
			return ;
		}
		if ($label == "recent")
		{
			doc_list_recent();
			return ;
		}
		if ($label == "search")
		{
			doc_list_search();
			return ;
		}
		
		if ($label == "share")
		{
			doc_list_share();
			return ;
		}
		
		if ($label == "onlinefile")
		{
			doc_list_onlinefile();
			return ;
		}
		
		if ($label == "ptpfolder")
		{
			doc_list_ptpfolder();
			return ;
		}
		
		if ($label == "ptpfile")
		{
			doc_list_ptpfile();
			return ;
		}
		
		if ($label == "publicfile")
		{
			doc_list_publicfile();
			return ;
		}
		
		if ($label == "ptpform")
		{
			doc_list_ptpform();
			return ;
		}
		
		if ($label == "leavefile")
		{
			doc_list_leavefile();
			return ;
		}
		
		if ($label == "leavefile1")
		{
			doc_list_leavefile1();
			return ;
		}
		
		if ($label == "clotfile")
		{
			doc_list_clotfile();
			return ;
		}


		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","00000000");
		$file_type = g("file_type");
		$key = g("key");

//		if ((int)$parent_id)
//		{
//			if (! DocAce::can(DOCACE_VIEW))
//				$printer -> fail("你没有权限查看内容");
//		}
//        DocAce::can(DOCACE_CREATE);

		$doc = new DOC();
		$data_folder = array();
		if ($pageindex == 1)
		{
			//文件夹不作分页，故分页时不显示
			if (! $file_type)
			{
				if ($parent_type)
					$data_folder = $doc -> list_folder($parent_type,$parent_id,$root_type,$root_id,$sortby);
				else
					$data_folder = $doc -> list_root($root_type,$sortby);
			}
		}

		//加载文件
		$result_file = $doc -> list_file($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
//var_export($data_folder);
//var_export($data_file);
//exit();
		$data = array_merge($data_folder,$data_file) ;

		$printer -> out_list($data,$recordcount,0);
	}

	function doc_list_search()
	{
		Global $printer;
//
//		$sortby = g("sortby","ID desc");
//		$pagesize = g("pagesize",100);
//		$pageindex = g("pageindex",1);
//		$recordcount = 0 ;
//		$key = g("key") ;
//		$sql_where = "" ;
//
//		if ($key)
//		{
//			$doc = new DOC();
//			$sql_where = $doc -> db -> addWhere($sql_where,"TypePath like '%" . $key . "%'");
//			
//			$sql_count = " select count(*) as c from PtpFile" . $sql_where;
//			$recordcount = $doc -> db -> executeDataValue($sql_count);
//			
//			$sql_list = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A " . $sql_where . " order by " . $sortby;
//			$data_file = $doc -> db -> page($sql_list,$pageindex,$pagesize,$recordcount);
//
//		}
//		else
//		{
//			$data_file = array();
//		}
//
//		$printer -> out_list($data_file,$recordcount,0);
//		
		
		$sortby = "A.ID desc" ;
		$sortbyasc = "col_id ASC" ;
		$sortbydesc = "col_id Desc" ;
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
		$recordcount = 0 ;
		$key = g("key") ;
		$sql_where = "where (MyID='Public' or MyID='".CurUser::getUserId()."') and PtpFolderID not in(select PtpFolderID from PtpForm where MyID='".CurUser::getUserId()."') and FileState=1" ;
		
		if ($key)
		{
			$doc = new DOC();
			$sql_where = $doc -> db -> addWhere($sql_where,"TypePath like '%" . $key . "%'");
	
			$sql_count = " select count(*) as c from PtpFile A "  . $sql_where ;
			$recordcount = $doc -> db -> executeDataValue($sql_count);
			
			$row1 = ($pageindex - 1) * $pagesize ;
			$row2 = $row1 + $pagesize ;
			if($row2>$recordcount) $pagesize=$recordcount-$row1;
			
			$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql_where . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
			$data_file = $doc -> db -> executeDataTable($sql_list) ;
		}
		else
		{
			$data_file = array();
		}
		$printer -> out_list($data_file,$recordcount,0);
	}


 	function doc_list_favitor()
	{
		Global $printer;

		$sortby = g("sortby","A.col_dt_create desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);

		$doc = new DOC();
		$sql_where = $doc -> db -> addWhere($sql_where," B.col_classid=" . DOC_FILE );
		$sql_where = $doc -> db -> addWhere($sql_where," B.col_hsitemtype=" . EMP_USER . " and B.col_hsitemid=" . CurUser::getUserId() . " and A.col_id=B.col_objid ");

 		$sql_count = " select count(*) as c from tab_doc_file A,tab_doc_file_subscribe B "  . $sql_where ;
		$recordcount = $doc -> db -> executeDataValue($sql_count);
		
		$sql_list = " select " . ($doc -> get_fields_list(DOC_FILE,0,0)) . ",B.col_id as col_subscribe_id from tab_doc_file A,tab_doc_file_subscribe B "  . $sql_where . "   order by  " . $sortby;
		$data_file = $doc -> db -> page($sql_list,$pageindex,$pagesize,$recordcount);


		$printer -> out_list($data_file,$recordcount,0);
	}

 	function doc_list_recent()
	{
		Global $printer;

		$sortby = "A.ID desc" ;
		$sortbyasc = "col_id ASC" ;
		$sortbydesc = "col_id Desc" ;
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);

		$doc = new DOC();
		$sql_where = "where (MyID='Public' or MyID='".CurUser::getUserId()."') and PtpFolderID not in(select PtpFolderID from PtpForm where MyID='".CurUser::getUserId()."') and FileState=1" ;

 		$sql_count = " select count(*) as c from PtpFile A "  . $sql_where ;
		$recordcount = $doc -> db -> executeDataValue($sql_count);
		
		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$recordcount) $pagesize=$recordcount-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql_where . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
		
//		echo $sql_list;
//		exit();
		$data_file = $doc -> db -> executeDataTable($sql_list) ;
		//$data_file = $doc -> db -> page($sql_list,$pageindex,$pagesize,$recordcount);

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_share()
	{
		Global $printer;
		
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","00000000");
		$file_type = g("file_type");
		$curr_path = g("curr_path");
		$arr_id = split(",",js_unescape(g("sids")));
		
		if(g("myid")=="Public") $root_type=1;
		else $root_type=3;

		$doc = new Doc();
		$data = array();
		if($curr_path){
			
		$data_folder = array();
		if ($pageindex == 1)
		{
			//文件夹不作分页，故分页时不显示
			if (! $file_type)
			{
				if ($parent_type)
					$data_folder = $doc -> list_folder($parent_type,$parent_id,$root_type,$root_id,$sortby);
				else
					$data_folder = $doc -> list_root($root_type,$sortby);
			}
		}

		//加载文件
		$result_file = $doc -> list_file($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$data = array_merge($data_folder,$data_file) ;
		
		}else{
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = split("_",$id);
				$col_myid=$arr_item[0];
				unset($arr_item[0]);
				unset($arr_item[count($arr_item)]);
				$col_id=implode('_',$arr_item);
				if($col_myid == DOC_FILE) $recordcount+=1;
				$result_file = $doc -> get_detail($col_myid,$doc -> get_ptpfileid($col_id),$doc -> get_fields_list($col_myid));
				$data[] = $result_file;
			}
		}
		}

		$printer -> out_list($data,$recordcount,0);
	}
	
 	function doc_list_onlinefile()
	{
		Global $printer;
		
		$sortby = g("sortby","OnlineID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","00000000");
		$file_type = g("file_type");
		$curr_path = g("curr_path");
		
		$root_type=3;

		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_ptpfolder()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file2($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_ptpfile()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file3($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_publicfile()
	{
		Global $printer;
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file8($vesr);
		$data_file = $result_file["data"] ;

		$printer -> out_list($data_file,-1,0);
	}
		
		
 	function doc_list_ptpform()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file4($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_leavefile()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file5($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_leavefile1()
	{
		Global $printer;
		$yid = g("yid");
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file7($yid,$vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_clotfile()
	{
		Global $printer;
		$yid = g("yid");
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file6($yid,$vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
	
	function save() {
		Global $printer;
		Global $op;
		$filefactpath = g ( "filefactpath", "" );
		$doc = new Doc();
		$doc_id = g ( "id", 0 );
		$Authority1 = g ( "Authority1", 0 );
		$Authority2 = g ( "Authority2", 0 );
		
		$sql = " update OnlineFile set Authority1=" . $Authority1 . ",Authority2=" . $Authority2 . " where OnlineID =" . $doc_id;
		$doc -> db -> execute($sql);
	
		$memberIds = g ( "memberIds" );
		$doc->setMember ( $doc_id, $memberIds, 1 );

		$printer->success ();
	}

	function detail() {
		Global $printer;
	
		$doc = new Doc();
		$doc_id = g ( "id", 0 );
		
        $row = $doc -> get_detail1(DOC_FILE,$doc_id,"Authority1,Authority2");
	
		$append = "";
		$sql = "Select bb.UserID as col_id,aa.FcName as col_name,aa.UserName as col_loginname,aa.UserIco,aa.UserIcoLine,bb.Authority from Users_ID as aa , OnlineForm as bb where aa.UserID=bb.UserID and bb.OnlineID=" . $doc_id . " and aa.UserState=1 order by bb.ID asc";
		$data = $doc -> db -> executeDataTable($sql);
		$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );
	
		$printer->out_detail ( $row, $append, 0 );
	}

	function doc_download()
	{
		Global $printer;
 		$label = g("label");
		if ($label == "leavefile")
		{
			doc_download1();
			return ;
		}
		
		$doc = new Doc();

		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id",0);
		$root_id = g("root_id",0);
		$root_type = g("root_type",0);

		//得到下载的文件夹或文件
		$ids = g("ids");  	// doctype_docid_rootid,doctype_docid_rootid
		$name = g("name"); // filename or zipname
		$arr_id = explode(",",$ids) ;

		//权限判断
//		if (DocAce::can(DOCACE_NETWORK_PHONE)&&((!is_private_ip(clientIP()))||ismobile()))
//			$printer -> fail("你没有权限在外网或手机中下载");
		//权限判断
		if (! (DocAce::can(DOCACE_DOWNLOAD)||g("myid")))
			$printer -> fail("你没有权限下载");


		//存放文件或文件夹
		$data_list = array();

		//遍历选中节点的数据
		foreach($arr_id as $id)
		{
			//得到子孙文件夹与文件
			$arr_item = explode("_",$id);
			$arr_id = $doc -> get_ptpfileid($arr_item[1]);
			$data = $doc -> get_child_data($arr_item[0],$arr_id,$arr_item[2],1,1) ;
			$data_list[] = array("doc_type"=>$arr_item[0],"doc_id"=>$arr_id,"root_id"=>$arr_item[2],"root_type"=>$root_type,"data"=>$data);
		}

		//验证有效性
//		echo var_dump($data_list);
//		exit();
		doc_download_valid($data_list);

		//得到相关目录
		$target = __ROOT__ . "/data/temp/" . date("Ymd") ;
		$target_folder = $target .  "/" . str_replace(".zip","",$name) ;
		$target_zip = $target .  "/" . $name ;

		//生成文件夹
		foreach($data_list as $data_item)
		{
			$root_dir = $doc -> get_root_dir($data_item["root_type"],$data_item["root_id"]) ;
			$result = $doc -> bulid_folder($data_item["data"],$target_folder,$root_dir);
		}

		//打包文件
		$zip = new Ziper();
		$zip -> zipFolder($target_folder,$target_zip);

		//得到地址
		$target_zip = str_replace(__ROOT__,"",$target_zip) ;

		//删除当前目录
		deldir(iconv_str($target_folder,"UTF-8","GBK"));
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."下载多个云盘文件".$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		$printer -> success($target_zip);
	}
	
	function doc_download1()
	{
		Global $printer;
		$doc = new Doc();

		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id",0);
		$root_id = g("root_id",0);
		$root_type = 4;

		//得到下载的文件夹或文件
		$ids = g("ids");  	// doctype_docid_rootid,doctype_docid_rootid
		$name = g("name"); // filename or zipname
		$arr_id = explode(",",$ids) ;

		//权限判断
		if (! DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE))
			$printer -> fail("你没有权限下载");


		//存放文件或文件夹
		$data_list = array();

		//遍历选中节点的数据
		foreach($arr_id as $id)
		{
			//得到子孙文件夹与文件
			$arr_item = explode("_",$id);
			$arr_id = $doc -> get_leavefileid($arr_item[1]);
			$data = $doc -> get_child_data($arr_item[0],$arr_id,$arr_item[2],1,1) ;
			$data_list[] = array("doc_type"=>$arr_item[0],"doc_id"=>$arr_id,"root_id"=>$arr_item[0],"root_type"=>$root_type,"data"=>$data);
		}

		//验证有效性
//		echo var_dump($data_list);
//		exit();
		doc_download_valid($data_list);

		//得到相关目录
		$target = __ROOT__ . "/data/temp/" . date("Ymd") ;
		$target_folder = $target .  "/" . str_replace(".zip","",$name) ;
		$target_zip = $target .  "/" . $name ;

		//生成文件夹
		foreach($data_list as $data_item)
		{
			$root_dir = $doc -> get_root_dir($data_item["root_type"],$data_item["root_id"]) ;
			$result = $doc -> bulid_folder($data_item["data"],$target_folder,$root_dir);
		}

		//打包文件
		$zip = new Ziper();
		$zip -> zipFolder($target_folder,$target_zip);

		//得到地址
		$target_zip = str_replace(__ROOT__,"",$target_zip) ;

		//删除当前目录
		deldir(iconv_str($target_folder,"UTF-8","GBK"));

        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName()."下载多个离线文件".$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		$printer -> success($target_zip);
	}

	//验证有效性
	function doc_download_valid($data_list)
	{
		Global $printer;

		//判断文件数与大小
		$file_count = 0 ;
		$file_size = 0 ;
		foreach($data_list as $data_item)
		{
			$data = $data_item["data"] ;
			foreach($data as $row)
			{
				if (($row["col_doctype"] == DOC_FILE)||($row["col_doctype"] == DOC_LeaveFile))
				{
					$file_count += 1;
					$file_size  += (int)str_replace(",","",$row["pcsize"]);;
				}
			}
		}
		if ($file_count == 0)
			$printer -> fail("此文件夹没有文件");

		//用 out_str,而不用fail, 因为msg中有,号，会认为是特殊字符
		if (DOWN_SIZE_LIMIT>0)
		{
			if ($file_size > (DOWN_SIZE_LIMIT * 1024))
				$printer -> out_msg(0,"目前有" . round($file_size / 1024,2) . "M,打包文件大小限制为" .DOWN_SIZE_LIMIT . "MB");
		}

		if (DOWN_COUNT_LIMIT>0)
		{
			if ($file_count > DOWN_COUNT_LIMIT)
				$printer -> out_msg(0,"目前有" . $file_count . "个文件,打包文件数限制为" .DOWN_COUNT_LIMIT . "个");
		}
	}

	function doc_subscribe_add()
	{
		Global $printer;

		$docitem = get_doc_info(g("id"));

		$subscribe = new DocSubscribe();
		$subscribe_id = $subscribe -> add($docitem["doc_type"],$docitem["doc_id"],EMP_USER,CurUser::getUserId(),CurUser::getUserName()) ;

		$printer -> success($subscribe_id);
	}

	function doc_subscribe_cancel()
	{
		Global $printer;

		$subscribe_id = g("subscribe_id");
		$subscribe = new DocSubscribe();
		$result = $subscribe -> cancel($subscribe_id);

		$printer -> success();
	}

	function doc_attr()
	{
		Global $printer;

		$doc_type = g("doc_type",0);
		$doc_id = g("doc_id",0);

		$doc = new Doc();

		//权限判断
//		if (! DocAce::can(DOCACE_VIEW))
//			$printer -> fail("你没有权限查看");


		//得到详情
		if($doc_type==DOC_FILE) $where="ID=". $doc_id;
		else $where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		$fields = $doc -> get_fields_list($doc_type) ;
		$sql = " select ".$fields.",A.PtpFolderID from " . (Doc::get_table_obj($doc_type)) . " A where " . $where ;
//		echo $sql;
//		exit();
		

		$data = $doc -> db -> executeDataRow($sql);
		if (count($data) == 0)
			$printer -> fail("数据不存在");

        if($doc_type==DOC_FILE) setValue("myid",$data["myid"]);

		//得到路径
		$root_id = 0 ;
		$root_type = 1 ;
		$path_url = "" ;
		$path_text = "" ;
		$path_data = $doc -> get_path_data($doc_type,$data["ptpfolderid"]);

		//得到root_id
		if (count($path_data)>0)
		{
			$node = $path_data[count($path_data)-1] ;
			$root_id = $node["doc_id"] ;
			$root_type = $data["myid"]== "Public"?1:3  ;
		}

		//转换成hash的路径
		foreach($path_data as $node)
		{
			$name = $node["doc_name"] ;
//			if ($name == "MyRoot")
//				$name = "个人文档" ;
			$path_text = $name . ($path_text?"/":"") . $path_text ;
			$path_url = get_doc_node($node["doc_type"],$node["col_id"],$root_id,$name). ($path_url?"/":"") . $path_url ;
		}

//		if ($doc_type != DOC_FILE)
//		{
//			$path_url = "#all/" . $path_url . "/" . get_doc_node($doc_type,$doc_id,$root_id,$data["col_name"]) ;
//			$path_text = $path_text . "/" . $data["col_name"] ;
//		}

		//打印结果
		//$data = $printer -> removeDoubleColumn($data);
		$data["doc_type"] = $doc_type ;
		$data["doc_id"] = $doc_id ;
		$data["root_id"] = $root_id ;
		$data["root_type"] = $root_type ;
		$data["path_text"] = $path_text ;
		$data["path_url"] = $path_url ;

		$printer -> out_arr($data);

	}
	
//    function ServerLog($SubIt1,$SubIt2,$ip,$Ico)
//    {
//		$log_item = array();
//		$log_item["ToDate"] = getNowTime() ;
//		$log_item["Txt"] = $SubIt1 ;
//		$log_item["UserID"] = $SubIt2 ;
//		$log_item["Ip"] = $ip ;
//		$log_item["Ico"] = $Ico ;
//		$doc_log = new Model("ServerLog");
//		$doc_log -> clearParam();
//		$doc_log -> addParamFields($log_item);
//		$doc_log -> insert();
//    }
    function manager_username()
    {
		$doc = new Doc();
		$sql = "Select UserName from Users_ID where IsManager=1 and UserState=1" ;
		$data = $doc -> db -> executeDataTable($sql) ;
		foreach($data as $row){
			$ptpform .= ($ptpform?",":"") . $row["username"];
		}

		return $ptpform;
    }

    function ptpform_username($doc_id,$userId = 0)
    {
		$doc = new Doc();
		if($userId) $sql = "Select UserName from Users_ID where UserID='".$userId."' and UserState=1" ;
		else $sql = "Select aa.UserName from Users_ID as aa , PtpForm as bb  where aa.UserID=bb.UserID  and bb.MyID='".CurUser::getUserId()."' and bb.PtpFolderID='".$doc_id."' and aa.UserState=1" ;
		$data = $doc -> db -> executeDataTable($sql) ;
		foreach($data as $row){
			$ptpform .= ($ptpform?",":"") . $row["username"];
		}
		$row = $doc -> get_detail(DOC_VFOLDER,$doc_id,$doc -> get_fields_list(DOC_VFOLDER));

		return array("ptpform"=>$ptpform,"usname"=>$row["col_name"]);
    }
	
    function ptpform_sendmsg($UserNames,$ntitle,$operation)
    {
		if($UserNames){
		$Msg = new COM("RTCCom.Message");
		//消息发送者的 UserName
		$Msg->MyUserName = urlencode(CurUser::getLoginName());
		//消息接收者的帐号，多个用逗号分隔，当消息类型为0、2、3启用
		$Msg->YouUserNames = urlencode($UserNames);
		//消息接收者的群组名称，多个用逗号分隔，当消息类型为1启用
		//$YouUserNames = "财务群,技术讨论群";
		//消息的标题，当消息类型为2、3启用
		$Msg->ntitle = urlencode($ntitle);
		//消息的内容
		switch($operation)
		{
			case 1:
			    $ncontent = "文件共享有更新，赶紧去看看新增了哪些好内容把！";
				$data_id = 2;
				break ;
			case 2:
				$ncontent = "您已成为".chr(34).$ntitle.chr(34)."文件共享的一员，赶紧去看看有什么好的内容把！";
				$data_id = 2;
				break ;
			case 3:
				$ncontent = "您已被移出了该文件共享！";
				$data_id = 2;
				break ;
			case 4:
				$ncontent = chr(34).CurUser::getUserName().chr(34)."退出了文件共享！";
				$data_id = 1;
				break ;
			case 5:
				$ncontent = chr(34).CurUser::getUserName().chr(34)."上传了文件，请您通过审核！";
				$data_id = 1;
				break ;
		}
		$Msg->ncontent = urlencode($ncontent);
		//消息的链接地址，当消息类型为3启用
		if($operation==5) $Msg->nlink = "";
		else $Msg->nlink = urlencode("?TargetType=2*data_type=sharefile*data_id=".$data_id);
		//消息类型  0消息 1群组消息 2公告 3通知
		$MsgType = 3;
		$Msg->Login(RTC_SERVER,6004);
		$Msg->SendMessage($MsgType);
		}
    }
	
    function messenge_sendmsg($UserNames,$ncontent,$operation)
    {
		if($UserNames){
		$Msg = new COM("RTCCom.Message");
		//消息发送者的 UserName
		$Msg->MyUserName = urlencode(CurUser::getLoginName());
		//消息接收者的帐号，多个用逗号分隔，当消息类型为0、2、3启用
		$Msg->YouUserNames = urlencode($UserNames);
		//消息接收者的群组名称，多个用逗号分隔，当消息类型为1启用
		//$YouUserNames = "财务群,技术讨论群";
		//消息的标题，当消息类型为2、3启用
		$Msg->ntitle = "";
		//消息的内容
//		switch($operation)
//		{
//			case 1:
//			    $ncontent = "文件共享有更新，赶紧去看看新增了哪些好内容把！";
//				$data_id = 2;
//				break ;
//		}
		$Msg->ncontent = urlencode($ncontent);
		//消息的链接地址，当消息类型为3启用
		$Msg->nlink = "";
		//消息类型  0消息 1群组消息 2公告 3通知
		$MsgType = 1;
		$Msg->Login(RTC_SERVER,6004);
		$Msg->SendMessage($MsgType);
		}
    }

	//得到 doc的hash内容
    function get_doc_node($doc_type,$doc_id,$root_id,$name)
    {
		return $name . "_" . $doc_type . "_" . $doc_id . "_" . $root_id ;
    }

	//得到 doc的组合id的信息
    function get_doc_info($id)
    {
		$result = array("doc_type"=>"0","doc_id"=>"0","root_id"=>"0");

		if (($id == "") || empty($id))
			return $result ;

		$arr = explode("_",$id) ;	// to array


        if (count($arr) >= 3)
        {
			$result["doc_type"] = $arr[0] ;
			$result["doc_id"] = $arr[1] ;
			$result["root_id"] = $arr[2] ;
		}
		return $result ;
    }
?>