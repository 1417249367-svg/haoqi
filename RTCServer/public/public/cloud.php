<?php
	//header("Content-Type:text/html;charset=utf-8");
	require_once("fun.php");
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
		case "list" :
			doc_list_doc_log ();
			break;
		case "doc_list":
			doc_list();
			break ;
		case "doc_list1":
			doc_list1();
			break ;
		case "doc_rename":
			doc_rename();
			break ;
		case "doc_delete":
			doc_delete();
			break ;
		case "doc_ptpfolder_delete":
			doc_ptpfolder_delete();
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
		case "doc_webrtcPic_upload":
			doc_webrtcPic_upload();
			break ;
		case "doc_SetverPic_upload":
			doc_SetverPic_upload();
			break ;
		case "doc_download":
			doc_download();
			break ;
		case "create" :
			create();
			break;
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
		case "doc_bigupload":
			doc_bigupload();
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
		case "doc_attr2":
			doc_attr2();
			break ;
		case "get_root_tree":
			get_root_tree();
			break ;
		case "get_root_log":
			get_root_log();
			break ;
		case "get_tree":
			get_tree();
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
		case "getlatestfile":
			getlatestfile();
			break ;
		case "getpdffile":
			getpdffile();
			break ;
		case "getpdffile1":
			getpdffile1();
			break ;
		case "getpdffile2":
			getpdffile2();
			break ;
		case "getpdffile3":
			getpdffile3();
			break ;
		case "getpdffile4":
			getpdffile4();
			break ;
		case "getonlinefile":
			getonlinefile();
			break ;
		case "getvideofile":
			getvideofile();
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
		case "doc_onlinefile1_save":
			doc_onlinefile1_save();
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
		case "get_onlinefile_id":
			get_onlinefile_id();
			break;
		case "doc_videofile_save":
			doc_videofile_save();
			break ;
		case "doc_checkExisting":
			doc_checkExisting();
			break ;
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
		$isroot = g("isroot",0);  		//0 不显示结构结点		1显示

		$docXML = new DocXML();

		if ($node_id)
			$data = $docXML -> get_tree($node_id);
		else{
			if ($isroot == "0")
				$docXML -> rootName = "" ;
			$data = $docXML -> get_root_tree($root_id);  //得到ROOT下的文件
		}

		$printer -> out_xml($data);
	}
	

	function get_tree()
	{
		Global $printer;
		$node_id = g("id") ;
		$root_id = g("root_id") ;
		$doc = new Doc();
		$path_data = $doc -> get_path_data(DOC_VFOLDER,$root_id);
		//$this -> get_path_data2($doc_type,$doc_id); //得到上层目录
//				echo var_dump($path_data);
//		exit();
		//得到root_id
		if (count($path_data)>0)
		{
			$node = $path_data[count($path_data)-1] ;
			$col_id = $node["col_id"];
			$docXML = new DocXML();
			if ($node_id)
				$data = $docXML -> get_tree($node_id);
			else
			    $data = $docXML -> get_root_tree1($col_id);
		}

		$printer -> out_xml($data);
	}
	
	function get_root_log()
	{
		Global $printer;

		$node_id = g("id") ;
		$root_id = g("root_id") ;
		$isroot = g("isroot",0);  		//0 不显示结构结点		1显示
		
		$directory = RTC_CONSOLE . "/log"; // 当前目录
		$filesAndDirectories = scandir($directory);
		 
		// 排除当前目录和上级目录的引用'.'和'..'
		$filesAndDirectories = array_diff($filesAndDirectories, array('.', '..'));
		
		foreach($filesAndDirectories as $row)
		{
			$xml = '<item id="' . $row . '" text="' . $row . '" im0="folder.png" im1="folder.png" im2="folder.png"></item>' .$xml . "\n" ;
		}
		$xml = '<tree id="0">' . $xml . '</tree>' ;

		$printer -> out_xml($xml);
	}
	
	function doc_list_doc_log()
	{
		Global $printer;

		$nodeId = g ( "nodeId" ) ;
		$dir = RTC_CONSOLE . "/log";
		$files = glob($dir."/".$nodeId."/*");
		usort($files, function($a, $b) {
			return filemtime($b) - filemtime($a);
		});

		$data = array ();
		foreach($files as $row)
		{
			$col_name=get_basename($row);
			array_push($data,array("doc_type"=> DOC_FILE,"col_id"=> pathinfo($col_name, PATHINFO_FILENAME),"col_name"=> $col_name,"filpath"=> "log/".$nodeId."/".$col_name,"pcsize"=> filesize($row),"col_dt_create"=> date('Y-m-d H:i:s', filemtime($row)),"nodeId"=> $nodeId));
		}

		$printer->out_list($data,-1,0);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到地址
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getmsgpath($file_name)
	{
		//$file_name = str_replace(chr(92).chr(92),chr(92),$file_name) ;
		$arrfile = explode(chr(47),$file_name);

		for($j=0;$j<count($arrfile)-1;$j++){   
			$path.=($path?"/":"").$arrfile[$j] ;
			//$path.="/".$arrfile[$j];
		}
		$path = iconv_str(format_path($path),"utf-8","gbk");
		return $path ;
	}
	function getlatestpath($filpath)
	{
		$arrfile = explode(chr(47),js_unescape($filpath));
		$path = RTC_CONSOLE."/";
		for($j=0;$j<count($arrfile)-1;$j++){   
			$path=$path.$arrfile[$j]."/";
		}
		$path = iconv_str(format_path($path),"utf-8","gbk");
		return $path ;
	}
	
	function getlatestpathname($filpath)
	{
		$arrfile = explode(chr(47),js_unescape($filpath));
		$file_name = iconv_str($arrfile[count($arrfile)-1],"utf-8","gbk") ;
		return $file_name ;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到地址
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getpath()
	{
//		$root_type = g("root_type",0) ;
//		$root_id = g("root_id",0) ;
		
//		$file_name = str_replace(chr(92).chr(92),chr(92),js_unescape(g("name"))) ;
		$arrfile = explode(chr(47),js_unescape(g("name")));
//		$file_name = iconv_str($arrfile[count($arrfile)-1],"UTF-8","GBK") ;
//		echo $file_name;
//		exit();

//		$doc = new Doc();
		$path = RTC_CONSOLE."/";
		for($j=0;$j<count($arrfile)-1;$j++){   
			$path=$path.$arrfile[$j]."/";
		}
		$path = iconv_str(format_path($path),"utf-8","gbk");
		//$path = format_path(RTC_CONSOLE."\\".$arrfile[0]."\\".$arrfile[1]."\\");
		return $path ;
	}
	
	function getpathname()
	{
//		$root_type = g("root_type",0) ;
//		$root_id = g("root_id",0) ;
		
		//$file_name = str_replace(chr(92).chr(92),chr(92),js_unescape(g("name"))) ;
		$arrfile = explode(chr(47),js_unescape(g("name")));
		$file_name = iconv_str($arrfile[count($arrfile)-1],"UTF-8","GBK") ;
//		echo $file_name;
//		exit();

//		$doc = new Doc();
//		$path = format_path(RTC_CONSOLE."\\".$arrfile[0]."\\".$arrfile[1]."\\");
		return $file_name ;
	}
	
	function getpathname1()
	{
		$arrfile = explode(chr(47),base64_decode(js_unescape(g("name"))));
		$file_name = iconv_str($arrfile[count($arrfile)-1],"UTF-8","GBK") ;
		return js_unescape($file_name) ;
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
		
		if ($label == "onlinefile")
		{
			getfile4();
			return ;
		}
		
		if ($label == "oos")
		{
			getfile2();
			return ;
		}
		
		if ($label == "msg")
		{
			getfile3();
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
		$sql = " select * from PtpFile where Msg_ID='" . g("id") . "'";

		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)){
			 setValue("myid",$data["myid"]);
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}

		//权限判断
		if (! (DocAce::can(DOCACE_DOWNLOAD,$parent_type,$parent_id,$root_id)||g("myid")))
//		    $printer -> fail("你没有权限下载");
			$printer -> out_str('<script type="text/javascript">alert("'.get_lang("cloud_authority_error").'");</script>') ;

//		$file_name = getpathname() ;
//		$file_path = getpath();

		$root_dir = $doc -> get_root_dir(0,$parent_id) ;

		$antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_download").$root_dir["default_dir"]."/".iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		$printer -> out_stream2($file_name,$file_path,$typepath);
	}
	
	function getlatestfile()
	{
		Global $printer;
 		$label = g("label");
		if ($label == "leavefile")
		{
			getlatestfile1();
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
		
		//权限判断
		if (! (DocAce::can(DOCACE_DOWNLOAD,$parent_type,$parent_id,$root_id)||g("myid")))
			$printer -> out_str('<script type="text/javascript">alert("'.get_lang("cloud_authority_error").'");</script>') ;

		$file_name = getpathname() ;
		$file_path = getpath();
		
		$doc = new Doc();
		//得到详情
		$sql = " select * from PtpFile where Msg_ID='" . g("id") . "'";
		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)){
			 setValue("myid",$data["myid"]);
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}

		$root_dir = $doc -> get_root_dir(0,$parent_id) ;

		$antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_download").$root_dir["default_dir"]."/".iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		$printer -> out_stream2($file_name,$file_path,$typepath);
	}
	
	function getlatestfile1()
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
		if (! DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE,$parent_type,$parent_id,$root_id))
			//$printer -> fail("你没有权限下载");
			$printer -> out_str('<script type="text/javascript">alert("'.get_lang("cloud_authority_error").'");</script>') ;
		
		$file_name = getpathname() ;
		$file_path = getpath();
		
		$doc = new Doc();
		//得到详情
		$sql = " select * from LeaveFile where Msg_ID='" . g("id") . "'";
		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)){
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_download_leavefile").iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		
		$printer -> out_stream($file_name,$file_path);
	}
	
	function getpdffile()
	{
		Global $printer;
		
		$file_name = getpathname() ;
		$file_path = getpath();
		
//		$arrfile = explode(chr(47),urldecode(g("name")));
//		$file_name = iconv_str($arrfile[count($arrfile)-1],"UTF-8","GBK") ;
//		echo $file_name.$file_path;
//		exit();
		$printer -> out_pdf($file_name,$file_path);
//		if(__ROOT__.'/Data'==RTC_CONSOLE) $url = getRootPath().'/Data/'.js_unescape(g("name"));
//		else $url = RTC_VIDEO_IP.'/'.js_unescape(g("name"));
//		header("Location:/cloud/include/pdf.html?file=".$url."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
		die();
	}
	
	function getpdffile1()
	{
		Global $printer;
		
		$file_name = getpathname() ;
		//$file_name = getpathname1() ;
		$url = phpescape(phpescape(getRootPath()."/public/cloud.html?op=getpdffile&name=".g("name")."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword()));
		header("Location:/vendor/pdfjs/web/viewer.html?formfiletype=".g("FormFileType")."&col_id=".g("col_id",0)."&filename=".$file_name."&file=".$url."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
		die();
	}
	
	function getpdffile2()
	{
		Global $printer;
		
		$file_name = getpathname1() ;
		$url = phpescape(phpescape(getRootPath()."/public/cloud.html?op=getpdffile&name=".base64_decode(js_unescape(g("name")))."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword()));
		header("Location:/vendor/pdfjs/web/viewer.html?formfiletype=".g("FormFileType")."&col_id=".g("col_id",0)."&filename=".$file_name."&file=".$url."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
		die();
	}
	
	function getpdffile4()
	{
		Global $printer;
		
		$file_name = getpathname1() ;
		$url = phpescape(phpescape(getRootPath()."/public/cloud.html?op=getpdffile&name=".base64_decode(js_unescape(g("name")))."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword()));
//		echo "/vendor/pdfjs/web/viewer.html?formfiletype=".g("FormFileType")."&col_id=".g("col_id",0)."&filename=".$file_name."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword();
//		exit();
		header("Location:/vendor/pdfjs/web/viewer.html?formfiletype=".g("FormFileType")."&col_id=".g("col_id",0)."&filename=".$file_name."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
		die();
	}
	
	function getpdffile3()
	{
		Global $printer;
		
		$FormFileType = g("FormFileType");
		$doc = new Doc();
		switch ($FormFileType) {
			case 1 :
				$sql = " select * from PtpFile where Msg_ID='" . g("col_id") . "'";
				$data = $doc -> db -> executeDataRow($sql);
				if (count($data)){
					 setValue("myid",$data["myid"]);
					 $typepath = $data["typepath"] ;
					 $file_name = getlatestpathname($data["filpath"]) ;
					 $file_path = getlatestpath($data["filpath"]);
				}
				break;
			case 2 :
				$sql = " select * from LeaveFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($data)){
					 $typepath = $data["typepath"] ;
					 $file_name = getlatestpathname($data["filpath"]) ;
					 $file_path = getlatestpath($data["filpath"]);
				}
				break;
			case 4 :
				$sql = " select * from ClotFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($data)){
					 $typepath = $data["typepath"] ;
					 $file_name = getlatestpathname($data["filpath"]) ;
					 $file_path = getlatestpath($data["filpath"]);
				}
				break;	
		}

		
//		$file_name = getpathname() ;
//		$file_path = getpath();
//		echo $file_path.$file_name;
//		exit();
		$printer -> out_pdf($file_name,$file_path);
	}
	
	function getonlinefile()
	{
		Global $printer;
		$FormFileType = g("FormFileType");
		$ids = "" ;
		
		$doc = new Doc();
		$doc_file = new Model("OnlineFile");

		switch ($FormFileType) {
			case 1 :
				$sql = " select TypePath,PcSize,FilPath from PtpFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				break;
			case 2 :
				$sql = " select TypePath,PcSize,FilPath from LeaveFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				$printer->out_arr ( $row );
				break;
			case 4 :
				$sql = " select TypePath,PcSize,FilPath from ClotFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				break;	
		}
		$printer->out_arr ( $row );
		//返回数据
	}
	
	function getvideofile()
	{
		Global $printer;
		$filpath = js_unescape(g("target_file"));
		$default_dir = RTC_CONSOLE."/".$filpath ;
		$default_dir = iconv_str($default_dir,"utf-8","gbk");
		
		$fileTypes = array('wmv','avi','3gp','mkv','mov','mpg','mpeg'); // File extensions
		$fileParts = pathinfo(strtolower($filpath));
		if (in_array($fileParts['extension'],$fileTypes)){
			$MD5Hash=file_md5_100($default_dir);
			$doc = new Doc();
			$row = $doc -> db -> executeDataRow("select * from MD5VideoFile where Context='" . $MD5Hash . "'");
			if (count($row)){
				 $filpath = $row["filpath"];
			}
		}
		if(__ROOT__.'/Data'==RTC_CONSOLE) $url = getRootPath().'/Data/'.$filpath;
		else $url = RTC_VIDEO_IP.'/'.$filpath;
//		echo phpescape($url);
//		exit();
		$printer->success ( phpescape($url) );
		//返回数据
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
		if (! DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE,$parent_type,$parent_id,$root_id))
			//$printer -> fail("你没有权限下载");
			$printer -> out_str('<script type="text/javascript">alert("'.get_lang("cloud_authority_error").'");</script>') ;
		
		$file_name = getpathname() ;
		$file_path = getpath();
		
		$doc = new Doc();
		//得到详情
		$sql = " select * from LeaveFile where Msg_ID='" . g("id") . "'";
		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)){
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_download_leavefile").iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		
		$printer -> out_stream($file_name,$file_path);
	}
	
	function getfile4()
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
		
		$file_name = getpathname() ;
		$file_path = getpath();
		
		$doc = new Doc();
		$data = $doc -> db -> executeDataRow("select * from OnlineFile where OnlineID = ".g("id"));
		if (count($data)) {
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}
		//得到详情
		$sql = "select top 1 * from OnlineRevisedFile where OnlineID = ".g("id")." order by ID desc";
		$data = $doc -> db -> executeDataRow($sql);
		if (count($data)){
			 $typepath = $data["typepath"] ;
			 $file_name = getlatestpathname($data["filpath"]) ;
			 $file_path = getlatestpath($data["filpath"]);
		}
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_download_onlinefile").iconv_str($file_name,"GBK","UTF-8"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
		
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
	//下载文件(单个文件)
	////////////////////////////////////////////////////////////////////////////////////////////////
	function getfile3()
	{
		Global $printer;
		
		$file_name = getpathname() ;
		$file_path = getpath();
//		echo $file_name.$file_path;
//		exit();
		$printer -> out_stream($file_name,$file_path);
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
			if($parent_type == DOC_LeaveFile) $can = DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE,$parent_type,$parent_id,$root_id);
			else $can = DocAce::can(DOCACE_UPDATE,$parent_type,$parent_id,$root_id)||g("myid") ;
//		}

		if ($can){
			
			$doc = new Doc();
			if(g("id")){
				switch (g("parent_type")) {
					case 104 :
						$sql = " select * from LeaveFile where Msg_ID='" . g("col_id") . "'";
						$data = $doc -> db -> executeDataRow($sql);
						if (count($data)){
							 //$typepath = $data["typepath"] ;
							 $file_pathname = getlatestpathname($data["filpath"]) ;
							 $file_path = getlatestpath($data["filpath"]);
						}
						break;
					default:
						switch (g("data_type")) {
							case 104 :
								$sql = " select * from LeaveFile where Msg_ID='" . g("id") . "'";
								$data = $doc -> db -> executeDataRow($sql);
								if (count($data)){
									 //$typepath = $data["typepath"] ;
									 $file_pathname = getlatestpathname($data["filpath"]) ;
									 $file_path = getlatestpath($data["filpath"]);
								}
								break;
							case 101 :
								$sql = " select * from ClotFile where Msg_ID='" . g("id") . "'";
								$data = $doc -> db -> executeDataRow($sql);
								if (count($data)){

									 //$typepath = $data["typepath"] ;
									 $file_pathname = getlatestpathname($data["filpath"]) ;
									 $file_path = getlatestpath($data["filpath"]);
								}
								break;
							default:
								//得到详情
								$sql = " select * from PtpFile where Msg_ID='" . g("id") . "'";
								$data = $doc -> db -> executeDataRow($sql);
								if (count($data)){
									 setValue("myid",$data["myid"]);
									 //$typepath = $data["typepath"] ;
									 $file_pathname = getlatestpathname($data["filpath"]) ;
									 $file_path = getlatestpath($data["filpath"]);
								}
								break;
						}
						break;
				}
				
			}else{		
				$file_path = getpath();
				$file_pathname = getpathname();
			}
			$file_type = strtolower(substr($file_pathname,strrpos($file_pathname,".")+1)) ;
			
			$filepath=$file_path.$file_pathname;
			if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
				
			}else{
				if(filesize($file_path.$file_pathname)<204800||(($file_type!="jpg")&&($file_type!="jpeg")&&($file_type!="png")&&($file_type!="gif"))) $filepath=$file_path.$file_pathname;
				else{
					if (! file_exists($file_path."small/".$file_pathname)){
						if($file_type=="png"){
						   $job = array('scaling'=>['size'=>"750,750"]);  
						   $image = new ImageFilter($file_path.$file_pathname, $job, $file_path."small/".$file_pathname); 
						   $image->outimage();
						}else{
							$t = new ThumbHandler ();
							$t->setSrcImg ( $file_path.$file_pathname );
							$t->setCutType ( 1 );
							$t->setDstImg ( $file_path."small/".$file_pathname );
							$t->createImg ( 50);
						}
					}
					$filepath=$file_path."small/".$file_pathname;
					if (! file_exists($filepath)) $filepath=$file_path.$file_pathname;
				}
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
		header("Location:../cloud/include/yunpan.html");
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
		$fullPath = g("fullPath") ;
		$existname = g("existname");
		$label = g("label");
		
		if ($fullPath)
		{
			folder_create1();
			return ;
		}
		Global $printer;
		$doc = new Doc();

		$doc_file = new Model("PtpFile");
		
		if($root_type==1&&$parent_id=="0") doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error")."!\"}") ;
		//权限判断
        $FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		//得到存放目录 target_dir
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		//$target_dir = $root_dir["default_dir"] ;
		//上传文件
		$ids = "" ;
		//file_put_contents("F:/php/RTCServer/Web/Data/7.log", $parent_id . PHP_EOL, FILE_APPEND);
		foreach($_FILES as $file)
		{
			if($existname) $doc -> delete(DOC_FILE,$existname,$parent_id);
//			if(!$existname){
				$file["name"] = $doc  -> modify_ptpfile($file["name"],$parent_id);
								//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
				$result = $doc -> upload_file($file, $root_dir["default_dir"]);
	
				if ($result["status"] == 0)
					doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
	
				$file_item = $doc -> save_file($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,$FileState);
//			}else{
//				$result = $doc -> upload_file2($file, $target_dir);
//	
//				if ($result["status"] == 0)
//					doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
//
//				$file_item = $doc -> update_file("DownLoad".chr(47).getValue("myid").chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,$FileState);
//			}
			$doc -> save_file6($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,1);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
		}
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
			$result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_file"),5);
			doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error1")."\"}") ;
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
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;
		
//		foreach($data as $k=>$v){
//			//$data[$k]['col_name']=phpescape($data[$k]['col_name']);
//			$data[$k]['col_name'] = str_replace("月-","月到",$data[$k]['col_name']) ;
//			}

		$response = $printer -> parseList($data,0);
		//$response = '{"rows":[' . $response . ']}' ;
		$response = '{"existname":"' . $existname . '","rows":[' . $response . ']}' ;

		//用 list 是方便脚本的数据绑定
		doc_upload_callback($response);
	}
	
	function doc_bigupload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$filename = g("filename") ;
		$fullPath = g("fullPath") ;
		$label = g("label");
		
		Global $printer;
		if ($label == "upload")
		{
			doc_bigupload2();
			return ;
		}
		if ($label == "merge")
		{
			doc_bigupload3();
			return ;
		}
		$doc = new Doc();
		$doc_file = new Model("PtpFile");
		if($root_type==1&&$parent_id=="0") doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error")."!\"}") ;
		//得到存放目录 target_dir
		$FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		//上传文件
		$ids = "" ;
		$filename = $doc  -> modify_ptpfile($filename,$parent_id);
		$result = $doc -> upload_file1($filename, $root_dir["default_dir"]);
		if ($result["status"] == 0)
			doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
		$row = $doc -> db -> executeDataRow("select * from MD5File where MD5Hash='" . g("context") . "'");
		if (count($row)){
			$file_item = $doc -> save_file($row["filpath"],$result["target"],$row["pcsize"],$parent_type,$parent_id,$root_id,$FileState);
			//$doc -> save_file8($row["filpath"],$result["target"],$row["pcsize"],$parent_type,$parent_id,$root_id,1,$file_item["ID"]);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
			$doc -> doc_retime($parent_id);
			if (!$FileState){
				$result = manager_username();
				ptpform_sendmsg($result,get_lang("cloud_file"),5);
				doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error1")."\"}") ;
			}else{
				$result = ptpform_username($file_item["PtpFolderID"]);
				ptpform_sendmsg($result["ptpform"],$result["usname"],1);
				$doc_file_vesr = new Model ( "PtpFile" );
				$doc_file_vesr -> updateForm("PtpFile_Vesr");
			}
			//返回数据
			if (strpos($ids,","))
				$sql = " ID in(" . $ids . ")" ;
			else
				$sql = " ID=" . $ids  ;
			$sql = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A where " . $sql;
			$data = $doc_file -> db -> executeDataTable($sql) ;
	
			$response = $printer -> parseList($data,0);
			$response = '{"status":1,"rows":[' . $response . ']}' ;
	
			//用 list 是方便脚本的数据绑定
			doc_upload_callback($response);
		}
		//返回数据
		$sql = " select BlobNum from MD5BigFile where Context='".g("context")."'";
		$data = $doc_file -> db -> executeDataTable($sql) ;
		$response = $printer -> parseList($data,0);
		
		$result = $doc -> exist_name3($parent_type,$parent_id,DOC_FILE,g("filename"));
		
		if ($result["msg_id"]) $response = '{"status":3,"msg":"' . $result["msg_id"] . '","rows":[' . $response . ']}' ;
		else $response = '{"status":2,"rows":[' . $response . ']}' ;
		//用 list 是方便脚本的数据绑定
		doc_upload_callback($response);
	}
	
	function doc_bigupload2()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$fullPath = g("fullPath") ;
		$label = g("label");
		
		Global $printer;
		$doc = new Doc();
		$bigdoc = new BigUpload();
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		$bigdoc -> moveFile($root_dir["default_dir"],$_FILES['chunk']['tmp_name'],g("hash"),g("filename"),g("context"));
		if($_FILES['chunk']['size']) $bigdoc -> save_file($root_dir["fil_dir"].chr(47).g("context").chr(47).g("filename").chr(95).chr(95).g("hash"),g("filename"),$_FILES['chunk']['size'],$parent_type,$parent_id,$root_id,1,g("hash"),g("context"));
		$printer->success ();
	}
	
	function doc_bigupload3()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$fullPath = g("fullPath") ;
		$existname = g("existname");
		$label = g("label");
		
		Global $printer;
		$doc = new Doc();
		$doc_file = new Model("PtpFile");
		$bigdoc = new BigUpload();
		//权限判断
        $FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		
		$ids = "" ;
		//$bigdoc -> delete_db(1);
		

		if($existname) $doc -> delete(DOC_FILE,$existname,$parent_id);
//		if(!$existname){
			$target = $doc  -> modify_ptpfile(g("filename"),$parent_id);
//			$search = array('\'',',',';','%','+');
//			$target = str_replace($search,"",$target);
			$filename = get_basename($doc  -> modify_file($root_dir["default_dir"].'/'.$target,$target)) ;
			
			$bigdoc -> fileMerge($root_dir["default_dir"],$filename,g("filename"),g("total_blob_num"),g("context"));
			$file_item = $doc -> save_file($root_dir["fil_dir"].chr(47).$filename,$target,g("filesize"),$parent_type,$parent_id,$root_id,$FileState);
//		}else{
//			$target = g("filename");
//			@unlink(iconv_str($target_dir.'/'.$target,"utf-8","gbk"));
//			$filename = g("filename") ;
//			
//			$bigdoc -> fileMerge($target_dir,$filename,g("filename"),g("total_blob_num"),g("context"));
//			$file_item = $doc -> update_file("DownLoad".chr(47).getValue("myid").chr(47).$filename,$target,g("filesize"),$parent_type,$parent_id,$root_id,$FileState);
//		}
		
		$doc -> save_file6($root_dir["fil_dir"].chr(47).$filename,$target,g("filesize"),$parent_type,$parent_id,$root_id,1);
		//$doc -> save_file8("DownLoad".chr(47).getValue("myid").chr(47).$filename,$target,g("filesize"),$parent_type,$parent_id,$root_id,1,$file_item["ID"]);
		$ids .= ($ids?",":"") . $file_item["ID"] ;
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
			$result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_file"),5);
			doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error1")."\"}") ;
		}else{
			$result = ptpform_username($file_item["PtpFolderID"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],1);
			$doc_file_vesr = new Model ( "PtpFile" );
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
		}
		//返回数据
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

		$response = $printer -> parseList($data,0);
		//$response = '{"rows":[' . $response . ']}' ;
		$response = '{"existname":"' . $existname . '","rows":[' . $response . ']}' ;

		//用 list 是方便脚本的数据绑定
		doc_upload_callback($response);
	}
	
	function doc_upload2($parent_id)
	{
		//变量
		$parent_type = g("parent_type",0) ;
		//$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$fullPath = g("fullPath") ;

		Global $printer;
		$doc = new Doc();

		$doc_file = new Model("PtpFile");
		
		if($root_type==1&&$parent_id=="0") doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error")."!\"}") ;
		//权限判断
        $FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		//得到存放目录 target_dir
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
			$file["name"] = $doc  -> modify_ptpfile($file["name"],$parent_id);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;

			$file_item = $doc -> save_file($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,$FileState);
			$doc -> save_file6($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,1);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
		}
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
			$result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_file"),5);
			//doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error1")."\"}") ;
		}else{
			$result = ptpform_username($file_item["PtpFolderID"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],1);
			$doc_file_vesr = new Model ( "PtpFile" );
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
		}
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
		$root_dir = $doc -> get_root_dir(5,$root_id) ;
		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
			$file["name"] = $doc  -> modify_onlinefile($file["name"]);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
				
			$filpath="OnlineFile".chr(47).CurUser::getUserId().chr(47)."1".chr(47).$result["filename"];
			$file_item = $doc -> save_file3($filpath,$result["filename"],$result["filesize"],CurUser::getUserId(),CurUser::getUserName(),7);
			$doc -> save_file6($filpath,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,7);
			$ids .= ($ids?",":"") . $file_item["OnlineID"] ;
		}

		//返回数据
		if (strpos($ids,","))
			$sql = " OnlineID in(" . $ids . ")" ;
		else
			$sql = " OnlineID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list2(DOC_OnlineFILE)) . " from OnlineFile bb where " . $sql;
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

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_RENAME,$parent_type,$parent_id,$root_id))))
			$printer -> fail(get_lang("cloud_error2"));
		if (preg_match('/[\/:*?"<>|]/', $name) > 0&&$doc_type!=DOC_FILE) $printer->fail (get_lang("cloud_error10"));


		$doc = new Doc();
		$result = $doc -> doc_rename($parent_type,$parent_id,$doc_type,$doc_id,$name);
		
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
			$printer -> fail(($doc_type == DOC_FILE?get_lang("file"):get_lang("folder")) . get_lang("cloud_isexists"));
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
		$result = $doc -> doc_rename1($parent_type,$parent_id,$doc_type,$doc_id,$name);

		if ($result)
			$printer -> success();
		else
			$printer -> fail(($doc_type == DOC_FILE?get_lang("file"):get_lang("folder")) . get_lang("cloud_isexists"));
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

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_DELETE,$parent_type,$parent_id,$root_id))))
			$printer -> fail(get_lang("cloud_error3"));


		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				if(strpos($col_id,"|")){
//					$arr = explode("|",$col_id);
//					$result = ptpform_username($arr[2]);
//					ptpform_sendmsg($result["ptpform"],$result["usname"],1);
//				}else
				if($arr_item[0]==DOC_VFOLDER){
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
				$arr_item = explode("_",$id);
//				$col_myid=$arr_item[0];
//				$col_rootid=$arr_item[count($arr_item)-1];
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				echo $col_myid."<br>";
//				echo $col_id."<br>";
//				echo $col_rootid."<br>";
//				exit();
				$doc -> delete($arr_item[0],$arr_item[1],$arr_item[2]);
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
				$arr_item = explode("_",$id);
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				$arr = explode("|",$col_id);
				$doc -> delete_db1($arr_item[1]);
				$antLog->log(CurUser::getUserName().get_lang("cloud_delete_leavefile").$arr_item[1],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
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
				$arr_item = explode("_",$id);
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				$arr = explode("|",$col_id);
				$doc -> delete_db3($arr_item[1]);
				$antLog->log(CurUser::getUserName().get_lang("cloud_delete_clotfile").$arr_item[1],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
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
		$antLog->log(CurUser::getUserName().get_lang("cloud_delete_onlinefile").js_unescape(g("name")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);

		$printer -> success();
	}
	
	function doc_ptpfolder_delete()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type",0);
		$root_id = g("root_id",0);
		
		$file_type = g("file_type");

		$doc_id = g("doc_id");

		$doc = new Doc();
		$antLog = new AntLog();
		
		$dir = g("usname");
		$empty_dirs = find_empty_dirs($dir);
		//print_r($empty_dirs);
		foreach($empty_dirs as $empty_dir)
		{
			if ($empty_dir)
			{
				$arr_item = explode("/",str_replace($dir."/","",$empty_dir));
				folder_create3($arr_item,0,0);
			}
		}

		$sql = " select " . ($doc -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A where UsName like '%.pdf' or UsName like '%.doc' or UsName like '%.docx' or UsName like '%.prt' or UsName like '%.xls' or UsName like '%.xlsx' or UsName like '%.ppt' or UsName like '%.pptx' or UsName like '%.stp' or UsName like '%.jt' or UsName like '%.jpg' or UsName like '%.png' or UsName like '%.rar' or UsName like '%.zip' or UsName like '%.CATPart' or UsName like '%.CATProduct' or UsName like '%.dll' or UsName like '%.cache' or UsName like '%.pbd' or UsName like '%.exe'";
//		echo $sql;
//		exit();
		$data = $doc -> db -> executeDataTable($sql) ;
		
		foreach($data as $row)
		{
			$id = $row["col_id"] ;
			$curr_type = $row["col_doctype"] ;
			$curr_id = $row["col_id"] ;
			$root_id = $row["col_rootid"] ;
			$name = $row["col_name"] ;

			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning16").$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
			$root_dir = $doc -> get_root_dir(0,$curr_id) ;
			//echo $root_dir["default_dir"];
			@rmdir($root_dir["default_dir"]);
			//file_delete($root_dir["default_dir"]);

			//删除数据
			$doc -> delete_db($curr_type,$curr_id,$id);

		}
		//exit();
		$printer -> success();
	}
	
	function get_onlinefile_id()
	{
		Global $printer;
		
		$youid = g ( "youid" );
		$doc = new Doc();
		$row = $doc -> db -> executeDataRow("select top 1 * from OnlineFile where MyID='".CurUser::getUserId()."' and FilPath='".g("filpath")."' order by OnlineID desc");
		if (count($row)) $printer ->out_arr(array('status' => 1,'onlineid' => $row["onlineid"],'typepath' => $row["typepath"],'msg' => $youid));
	}
	
	function doc_move()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parentId");
		$root_id = g("root_id");

		$taget_type = g("taget_type") ;
		$taget_id = g("target_id") ;
		$arr_id = explode(",",g("ids"));

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_MANAGE,$parent_type,$parent_id,$root_id))))
			$printer -> fail(get_lang("cloud_error4"));

		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
//				$col_myid=$arr_item[0];
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
				$result = $doc -> move($arr_item[0],$arr_item[1],$taget_type,$taget_id);
				if (!$result) $printer->fail (get_lang("cloud_warning18"));
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
		$target_type = g("target_type");
		$target_id = g("target_id");

		$arr_id = explode(",",g("ids"));

//		if (! DocAce::can(DOCACE_MANAGE))
//			$printer -> fail("你没有权限管理");
//echo getValue("myid");
//exit();
        setValue("myid",CurUser::getUserId());
        $FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		if (g("myid")) setValue("myid",g("myid"));
		$doc = new Doc();
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
//				$col_myid=$arr_item[0];
//				$col_rootid=$arr_item[count($arr_item)-1];
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				$doc -> save($col_myid,$doc -> get_ptpfileid($col_id),$col_rootid,$FileState);

				$doc -> save($arr_item[0],$arr_item[1],$arr_item[2],$target_id,$FileState);

			}
		}

		if (!$FileState)
		    $printer -> fail(get_lang("cloud_error5"));
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
		$FormFileType = g("FormFileType");
		$ids = "" ;
		
		$doc = new Doc();
		$doc_file = new Model("OnlineFile");
		if($FormFileType){
		switch ($FormFileType) {
			case 1 :
				$sql = " select * from PtpFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  $filename = $row["typepath"];
					  $filename = $doc  -> modify_onlinefile($filename);
					  $file_item = $doc -> save_file3($row["filpath"],$filename,$row["pcsize"],$row ["creatorid"],$row["usname"],$FormFileType);
					  $sql = "update PtpFile set OnlineID=".$file_item["OnlineID"]." where Msg_ID='" . g("col_id") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				break;
			case 2 :
				$sql = " select * from LeaveFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  $filename = $row["typepath"];
					  $filename = $doc  -> modify_onlinefile($filename);
					  $file_item = $doc -> save_file3($row["filpath"],$filename,$row["pcsize"],$row ["userid2"],js_unescape(g("usname")),$FormFileType,1);
					  $sql = "update LeaveFile set OnlineID=".$file_item["OnlineID"]." where Msg_ID='" . g("col_id") . "'";
					  $doc -> db -> execute($sql) ;
//					  if ($row["userid1"]==CurUser::getUserId()) $memberIds = $row["userid2"]."-1";
//					  else 
					  $memberIds = $row["userid1"]."-1";
					  $doc->setMember ( $file_item["OnlineID"], $memberIds, 1 );
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				break;
			case 4 :
				$sql = " select * from ClotFile where Msg_ID='" . g("col_id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  $filename = $row["typepath"];
					  $filename = $doc  -> modify_onlinefile($filename);
					  $file_item = $doc -> save_file3($row["filpath"],$filename,$row["pcsize"],$row ["myid"],$row["usname"],$FormFileType,1);
					  $sql = "update ClotFile set OnlineID=".$file_item["OnlineID"]." where Msg_ID='" . g("col_id") . "'";
					  $doc -> db -> execute($sql) ;
					  $relation = new EmpRelation ();
					  $data_file = $relation->getRelationData ( $parentEmpType, $row["clotid"], $childEmpType );
					  $memberIds="";
					  foreach($data_file as $k=>$v){
						  if ($data_file[$k]['col_id']!=$row ["myid"]) $memberIds .= (isset($memberIds)?",":"") . $data_file[$k]['col_id']."-1";
					  }
					  $doc->setMember ( $file_item["OnlineID"], $memberIds, 1 );
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				break;	
			case 5 :
				$sql = " select * from PtpFile where Msg_ID='" . g("col_id") . "'";
//				echo $sql;
//				exit();
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  $filename = $row["typepath"];
					  $filename = $doc  -> modify_onlinefile($filename);
					  $file_item = $doc -> save_file3($row["filpath"],$filename,$row["pcsize"],$row ["creatorid"],$row["usname"],1);
					  $sql = "update PtpFile set OnlineID=".$file_item["OnlineID"]." where Msg_ID='" . g("col_id") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				header("Location:/cloud/include/doceditor.php?OnlineID=".$ids."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
				die();
				break;
		}
		}else{
		$filename = $doc  -> modify_onlinefile($filename);
		$file_item = $doc -> save_file3(str_replace("\\\\","\\",js_unescape(g("target_file"))),$filename,g("fileSize"),CurUser::getUserId(),js_unescape(g("usname")),7);
		$ids .= ($ids?",":"") . $file_item["OnlineID"] ;
		}
		//返回数据
		if (strpos($ids,","))
			$sql = " OnlineID in(" . $ids . ")" ;
		else
			$sql = " OnlineID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list2(DOC_OnlineFILE)) . " from OnlineFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

//		$response = $printer -> parseList($data,0);
//		$response = 'rows:[' . $response . ']' ;
		//$printer -> success($response);
		$printer -> out_list($data,-1,0);



	}
	
	function doc_onlinefile1_save()
	{
		Global $printer;
		$filename = js_unescape(g("filename"));
		$FormFileType = g("FormFileType");
		$ids = "" ;
		$arr_id = explode(",",g("ids"));
		
		$doc = new Doc();
		$doc_file = new Model("OnlineFile");
		if($FormFileType){
		foreach($arr_id as $id)
		{
			if ($id)
			{
				switch ($FormFileType) {
					case 1 :
						$sql = " select * from PtpFile where ID=" . $id;
						$row = $doc -> db -> executeDataRow($sql);
						if (count($row)){
						   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
						   else{
							  $filename = $doc  -> modify_onlinefile($row ["typepath"]);
							  $file_item = $doc -> save_file3($row["filpath"],$row ["typepath"],$row["pcsize"],$row ["creatorid"],$row["usname"],$FormFileType);
							  $sql = "update PtpFile set OnlineID=".$file_item["OnlineID"]." where ID=" . $id;
							  $doc -> db -> execute($sql) ;
							  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
						   }
						}
						break;
					case 2 :
						$sql = " select * from LeaveFile where ID=" . $id;
						$row = $doc -> db -> executeDataRow($sql);
						if (count($row)){
						   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
						   else{
							  $filename = $doc  -> modify_onlinefile($row ["typepath"]);
							  $file_item = $doc -> save_file3($row["filpath"],$row ["typepath"],$row["pcsize"],$row ["userid2"],CurUser::getUserName(),$FormFileType,1);
							  $sql = "update LeaveFile set OnlineID=".$file_item["OnlineID"]." where ID=" . $id;
							  $doc -> db -> execute($sql) ;
//							  if ($row["userid1"]==CurUser::getUserId()) $memberIds = $row["userid2"]."-1";
//							  else 
							  $memberIds = $row["userid1"]."-1";
							  $doc->setMember ( $file_item["OnlineID"], $memberIds, 1 );
							  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
						   }
						}
						break;
					case 4 :
						$sql = " select * from ClotFile where ID=" . $id;
						$row = $doc -> db -> executeDataRow($sql);
						if (count($row)){
						   if($row ["onlineid"]&&$doc  -> exist_name4($row ["onlineid"])) $ids .= ($ids?",":"") . $row["onlineid"] ;
						   else{
							  $filename = $doc  -> modify_onlinefile($row ["typepath"]);
							  $file_item = $doc -> save_file3($row["filpath"],$row ["typepath"],$row["pcsize"],$row ["myid"],$row["usname"],$FormFileType,1);
							  $sql = "update ClotFile set OnlineID=".$file_item["OnlineID"]." where ID=" . $id;
							  $doc -> db -> execute($sql) ;
							  $relation = new EmpRelation ();
							  $data_file = $relation->getRelationData ( $parentEmpType, $row["clotid"], $childEmpType );
							  $memberIds="";
							  foreach($data_file as $k=>$v){
								  if ($data_file[$k]['col_id']!=$row ["myid"]) $memberIds .= (isset($memberIds)?",":"") . $data_file[$k]['col_id']."-1";
							  }
							  $doc->setMember ( $file_item["OnlineID"], $memberIds, 1 );
							  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
						   }
						}
						break;	
				}
			}
		}
		
		}
		//返回数据
		if (strpos($ids,","))
			$sql = " OnlineID in(" . $ids . ")" ;
		else
			$sql = " OnlineID=" . $ids  ;
		$sql = " select " . ($doc -> get_fields_list2(DOC_OnlineFILE)) . " from OnlineFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;
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
			$printer -> fail(get_lang("cloud_error6"));
		$file_item = $doc -> save_file4(g("doc_id"),str_replace("\\\\","\\",js_unescape(g("target_file"))),$data["typepath"],$data["pcsize"],$data["myid"],$data["usname"],CurUser::GetUserName().get_lang("cloud_revisedfile1").g("doc_sid").get_lang("cloud_revisedfile2"));
		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (strpos($ids,","))
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
	
	function doc_videofile_save()
	{
		Global $printer;
		$filename = js_unescape(g("filename"));
		$FormFileType = g("FormFileType");
		$ids = "" ;
		$filpath = str_replace(RTC_CONSOLE."/","",g("exchangeFile")) ;
		
		
		$doc = new Doc();
		$doc_file = new Model("MD5VideoFile");
		switch ($FormFileType) {
			case 1 :
				$sql = " select * from PtpFile where ID='" . g("id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update PtpFile set OnlineID=".$file_item["ID"]." where ID='" . g("id") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["ID"] ;  
				   }
				}
				break;
			case 2 :
				$sql = " select * from LeaveFile where ID='" . g("id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update LeaveFile set OnlineID=".$file_item["ID"]." where ID='" . g("id") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["ID"] ;  
				   }
				}
				break;
			case 4 :
				$sql = " select * from ClotFile where ID='" . g("id") . "'";
				$row = $doc -> db -> executeDataRow($sql);
				if (count($row)){
				   if($row ["onlineid"]) $ids .= ($ids?",":"") . $row["onlineid"] ;
				   else{
					  //$filpath = str_replace(strrchr($row["filpath"], '/'),"",$row["filpath"]).'/convert/'.$filename;
					  $file_item = $doc -> save_file9($filpath,$filename,g("filesize"),$FormFileType,g("context"));
					  $sql = "update ClotFile set OnlineID=".$file_item["ID"]." where ID='" . g("id") . "'";
					  $doc -> db -> execute($sql) ;
					  $ids .= ($ids?",":"") . $file_item["OnlineID"] ;  
				   }
				}
				break;	
		}
		//返回数据
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from MD5VideoFile bb where " . $sql;
		$data = $doc_file -> db -> executeDataTable($sql) ;

		$printer -> out_list($data,-1,0);
	}
	
	function doc_checkExisting()
	{
		Global $printer;
		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$name = g("filename");
		$doc_type = DOC_FILE ;

		$doc = new Doc();
//		$doc_file = new Model("PtpFile");
//		if($root_type==1&&$parent_id=="0") doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error")."!\"}") ;
//		//得到存放目录 target_dir
//		$FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
//		$target_dir = $doc -> get_root_dir($root_type,$root_id) ;
//		//上传文件
//		$ids = "" ;
//		
//		$result = $doc -> upload_file1(g("filename"), $target_dir);
//		if ($result["status"] == 0)
//			doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
//		$row = $doc -> db -> executeDataRow("select * from MD5File where MD5Hash='" . g("context") . "'");
//		if (count($row)){
//			$file_item = $doc -> save_file($row["filpath"],$result["target"],$row["pcsize"],$parent_type,$parent_id,$root_id,$FileState);
//			$ids .= ($ids?",":"") . $file_item["ID"] ;
//			$doc -> doc_retime($parent_id);
//			if (!$FileState){
//				$result = manager_username();
//				ptpform_sendmsg($result,get_lang("cloud_file"),5);
//				doc_upload_callback("{\"status\":0,\"msg\":\"".get_lang("cloud_error1")."\"}") ;
//			}else{
//				$result = ptpform_username($file_item["PtpFolderID"]);
//				ptpform_sendmsg($result["ptpform"],$result["usname"],1);
//				$doc_file_vesr = new Model ( "PtpFile" );
//				$doc_file_vesr -> updateForm("PtpFile_Vesr");
//			}
//			//返回数据
//			if (substr($ids,","))
//				$sql = " ID in(" . $ids . ")" ;
//			else
//				$sql = " ID=" . $ids  ;
//			$sql = " select " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A where " . $sql;
//			$data = $doc_file -> db -> executeDataTable($sql) ;
//	
//			$response = $printer -> parseList($data,0);
//			$response = '{"status":1,"rows":[' . $response . ']}' ;
//	
//			//用 list 是方便脚本的数据绑定
//			doc_upload_callback($response);
//		}
		if(!INQUIRYBOX) doc_upload_callback("{\"status\":2,\"msg\":\"\"}") ;
		$result = $doc -> exist_name3($parent_type,$parent_id,$doc_type,$name);
		doc_upload_callback("{\"status\":2,\"msg\":\"" . $result["msg_id"] . "\"}") ;



	}
	
	function doc_m_upload()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_id = g("root_id");

		$filename = g("filename");

//        if(preg_match("/[\',;%+]/",$filename)) doc_upload_callback("{\"status\":0,\"msg\":\"" . get_lang("class_doc_warning7") . "\"}") ;

//		if (! DocAce::can(DOCACE_MANAGE))
//			$printer -> fail("你没有权限管理");
        $FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		
		
		$doc = new Doc();
		if(!$parent_id){
		$data = $doc -> db -> executeDataRow("select PtpFolderID from PtpFolder where UsName = 'RTC' and MyID='" . CurUser::getUserId() . "'");
		if (count($data)) $parent_id = $data["ptpfolderid"] ;
		else{
		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,'0','RTC',CurUser::getUserId());
		$parent_id = $result["ptpfolderid"];
		$new_parent_id=$parent_id;
		}
		}
		$filename = $doc  -> modify_ptpfile($filename,$parent_id);
		$file_item = $doc -> save_file2(js_unescape(g("target_file")),$filename,g("fileSize"),DOC_VFOLDER,$parent_id,$root_id,$FileState);
		
		$doc -> doc_retime($parent_id);

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_file"),5);
		    $printer -> fail(get_lang("cloud_error5"));
		}else{
			$result = ptpform_username($file_item["PtpFolderID"]);
			ptpform_sendmsg($result["ptpform"],$result["usname"],1);
			$doc_file_vesr = new Model ( "PtpFile" );
			$doc_file_vesr -> updateForm("PtpFile_Vesr");
		}

		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (strpos($ids,","))
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
        $FileState = DocAce::can(DOCACE_UPLOAD_CLOTFILE,$parent_type,$parent_id,$root_id);
		$root_dir = $doc -> get_root_dir(6,$parent_id) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{
			$file["name"] = $doc  -> modify_clotfile($file["name"],$parent_id);
							//doc_upload_callback("{\"status\":0,\"msg\":\"".$file["name"]."\"}") ;		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
			$filpath="ClotFile".chr(47).$parent_id.chr(47).$result["filename"];

		    $file_item = $doc -> save_file5($filpath,$result["filename"],$result["filesize"],DOC_VFOLDER,$parent_id,$root_id,$FileState);
			$doc -> save_file6($filpath,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,4);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
			
			//if($FileState) messenge_sendmsg($parent_id,"{b@".$filpath."}",1);
		}

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_clotfile"),5);
		    $printer -> fail(get_lang("cloud_error1"));
		}else{
			$doc_file_vesr = new Model ( "ClotFile" );
			$doc_file_vesr -> updateForm("ClotFile_Vesr");
		}
		//返回数据
		//返回数据
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from ClotFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;
//		foreach($data as $k=>$v){
//			$data[$k]['label'] = "ClotFile" ;
//		}

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_m_clotfile_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$UserText = js_unescape(g("UserText"));
		
		$m=strpos($UserText,"{")+1;
		$n=strpos($UserText,"}")-$m;
		$TempString=substr($UserText, $m, $n);
		$tType=substr($TempString,0,2);
		$tString=substr($TempString,2);
		
		$label = g("label");

		Global $printer;
		$doc = new Doc();
		$doc_file = new Model("ClotFile");
        $FileState = DocAce::can(DOCACE_UPLOAD_CLOTFILE,$parent_type,$parent_id,$root_id);
		$root_dir = $doc -> get_root_dir(8,getmsgpath($tString)) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{		
			$file["name"] = $doc  -> modify_clotfile($file["name"],$parent_id);
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;

		    $file_item = $doc -> save_file5($tString,$result["filename"],$result["filesize"],DOC_VFOLDER,$parent_id,$root_id,$FileState);
			$doc -> save_file6($tString,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,4);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
			
			//if($FileState) messenge_sendmsg($parent_id,"{b@".$tString."}",11);
		}

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_clotfile"),5);
		    $printer -> fail(get_lang("cloud_error1"));
		}else{
			$doc_file_vesr = new Model ( "ClotFile" );
			$doc_file_vesr -> updateForm("ClotFile_Vesr");
		}
		//返回数据
		//返回数据
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from ClotFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;
		foreach($data as $k=>$v){
			$data[$k]['label'] = "ClotFile" ;
		}

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_leavefile_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$UserText = js_unescape(g("UserText"));
		
		$m=strpos($UserText,"{")+1;
		$n=strpos($UserText,"}")-$m;
		$TempString=substr($UserText, $m, $n);
		$tType=substr($TempString,0,2);
		$tString=substr($TempString,2);
		
		$label = g("label");

		Global $printer;
		$doc = new Doc();
		$doc_file = new Model("LeaveFile");
		$root_dir = $doc -> get_root_dir(8,getmsgpath($tString)) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{		
			$file["name"] = $doc  -> modify_leavefile($file["name"],$parent_id);
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;

		    $file_item = $doc -> save_file7($tString,$result["filename"],$result["filesize"],DOC_VFOLDER,$parent_id,$root_id);
			$doc -> save_file6($tString,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,2);
			$ids .= ($ids?",":"") . $file_item["ID"] ;
		}

		$doc_file_vesr = new Model ( "LeaveFile" );
		$doc_file_vesr -> updateForm("LeaveFile_Vesr");
		//返回数据
		//返回数据
		if (strpos($ids,","))
			$sql = " ID in(" . $ids . ")" ;
		else
			$sql = " ID=" . $ids  ;
		$sql = " select * from LeaveFile A where " . $sql;
		$data = $doc -> db -> executeDataTable($sql) ;
		foreach($data as $k=>$v){
			$data[$k]['label'] = "LeaveFile" ;
		}

		$response = $printer -> parseList($data,0);
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_kefufile_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$UserText = js_unescape(g("UserText"));
		
		$m=strpos($UserText,"{")+1;
		$n=strpos($UserText,"}")-$m;
		$TempString=substr($UserText, $m, $n);
		$tType=substr($TempString,0,2);
		$tString=substr($TempString,2);
		
		$label = g("label");

		Global $printer;
		$doc = new Doc();
		$root_dir = $doc -> get_root_dir(8,getmsgpath($tString)) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
				
			$doc -> save_file6($tString,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,9);
			//$doc -> save_file8($tString,$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,9,0);
		}

		//$response = '{\"msg_id\":\"'.g("Msg_ID").'\",\"filpath\":\"'.g("UserText").'\",\"label\":\"'.$label.'\"}';
		$response = '{"msg_id":"'.g("Msg_ID").'","filpath":"'.phpescape($UserText).'","label":"'.$label.'"}';
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	
	function doc_videopic_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$duration = s_to_hs(g("duration",0)) ;
		$UserText = js_unescape(g("UserText"));
		
		$m=strpos($UserText,"{")+1;
		$n=strpos($UserText,"}")-$m;
		$TempString=substr($UserText, $m, $n);
		$tType=substr($TempString,0,2);
		$tString=substr($TempString,2);

		$label = g("label");

		Global $printer;
		$doc = new Doc();
		$root_dir = $doc -> get_root_dir(8,getmsgpath($tString)) ;

		//上传文件
		$ids = "" ;
		
		foreach($_FILES as $file)
		{		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
				
			$DstImg=$root_dir["default_dir"]."/small/".$result["filename"];
			
			//$DstImg = str_replace("/","\\",$DstImg);
			$dir = substr($DstImg,0,strrpos($DstImg,"/"));
	
			if(!file_exists($dir))
			   mkdirs($dir);
			//$DstUserText=substr(getmsgpath($tString),1)."/small/".$result["filename"];
				
			if (! file_exists($DstImg)){
				$t = new ThumbHandler();
				$t->setSrcImg($root_dir["default_dir"] ."/". $result["filename"]); //ori file；
				$t->setDstImg($DstImg);//masked file
				$t->setMaskFont(format_path(__ROOT__.'/static/fonts/simfang.ttf')); //字体
				$t->setMaskFontSize(25);//文字大小
				$t->setMaskWord($duration);//文字；
				$t->setMaskTxtPct(0); //合并度；
				$t->setImgDisplayQuality(9);
				$t->setCutType ( 1 );
				$t->createImg(25); //处理并保存文件；
				
				$t->setSrcImg($DstImg); //ori file；
				$t->setDstImg($DstImg);//masked file
				$t->setMaskImg(format_path(__ROOT__.'/static/img/video_slide_play.png'));
				$t->setMaskImgPct(75); //合并度
				$t->setMaskOffsetX(10);
				$t->setMaskOffsetY(20);
				$t->setMaskPosition(5); //水印位置；
				$t->setImgDisplayQuality(9);
				$t->createImg(100); //处理并保存文件；
				
//				$t->setSrcImg($DstImg); //ori file；
//				$t->setDstImg($DstImg);//masked file
//				$t->setCutType ( 1 );
//				$t->createImg ( 25);
			}
		}

		//$response = '{\"msg_id\":\"'.g("Msg_ID").'\",\"filpath\":\"'.g("UserText").'\",\"label\":\"'.$label.'\"}';
		$response = '{"fileUrl":"'.g("fileUrl").'","fileSize":"'.g("fileSize",0).'","duration":"'.g("duration",0).'","filePic":"'.g("filePic").'","label":"'.$label.'"}';
		$response = '{"rows":[' . $response . ']}' ;
		doc_upload_callback($response);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_webrtcPic_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",3) ;
		$root_id = g("root_id",0) ;

		Global $printer;
		$FileState = DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id);
		$doc = new Doc();

		//上传文件
		$ids = "" ;
		
        $filename=date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".jpg";
		$result = $doc -> save_to_file($filename, $root_dir["default_dir"]); 

		if ($result["status"] == 0)
			doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
			
		$image=base64_decode(str_replace('data:image/jpeg;base64,','',g("data",0))); 
		$fp=fopen($root_dir["default_dir"].'/'.$filename,'w'); 
		fwrite($fp,$image); 
		fclose($fp); 
			
		if(!$parent_id){
			$data = $doc -> db -> executeDataRow("select PtpFolderID from PtpFolder where UsName = 'RTC' and MyID='" . CurUser::getUserId() . "'");
			if (count($data)) $parent_id = $data["ptpfolderid"] ;
			else{
				$doc_dir = new DocDir();
				$result = $doc_dir -> insert($parent_type,'0','RTC',CurUser::getUserId());
				$parent_id = $result["ptpfolderid"];
				$new_parent_id=$parent_id;
			}
		}
		$root_dir = $doc -> get_root_dir($root_type,$parent_id) ;
		
		$file_item = $doc -> save_file($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,$FileState);
		$doc -> save_file6($root_dir["fil_dir"].chr(47).$result["filename"],$result["target"],$result["filesize"],$parent_type,$parent_id,$root_id,1);

		$doc -> doc_retime($parent_id);
		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (strpos($ids,","))
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
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// 文件上传
	////////////////////////////////////////////////////////////////////////////////////////////////
	function doc_SetverPic_upload()
	{
		//变量
		$parent_type = g("parent_type",0) ;
		$parent_id = g("parent_id",0) ;
		$root_type = g("root_type",0) ;
		$root_id = g("root_id",0) ;
		$UserText = js_unescape(g("UserText"));
		
		$m=strpos($UserText,"{")+1;
		$n=strpos($UserText,"}")-$m;
		$TempString=substr($UserText, $m, $n);
		$tType=substr($TempString,0,2);
		$tString=substr($TempString,2);
		$arr_item = explode("|",$tString);
		
//		echo $tString;
//		exit();
		
		$label = g("label");
		
		if ($label == "LeaveFile")
		{
			doc_leavefile_upload();
			return ;
		}
		
		if ($label == "KefuFile")
		{
			doc_kefufile_upload();
			return ;
		}
		
		if ($label == "ClotFile")
		{
			doc_m_clotfile_upload();
			return ;
		}
		
		if ($label == "VideoPic")
		{
			doc_videopic_upload();
			return ;
		}

		Global $printer;
		$doc = new Doc();
		$root_dir = $doc -> get_root_dir(8,getmsgpath($arr_item[0])) ;

		//上传文件
		$ids = "" ;
		
//		echo $target_dir;
//		exit();
		
		foreach($_FILES as $file)
		{		
			$result = $doc -> upload_file($file, $root_dir["default_dir"]);

			if ($result["status"] == 0)
				doc_upload_callback("{\"status\":0,\"msg\":\"" . $result["msg"] . "\"}") ;
				
			$doc -> save_file6($arr_item[0],$result["filename"],$result["filesize"],$parent_type,$parent_id,$root_id,8);
		}

		//$response = '{\"msg_id\":\"'.g("Msg_ID").'\",\"filpath\":\"'.g("UserText").'\",\"label\":\"'.$label.'\"}';
		$response = '{"msg_id":"'.g("Msg_ID").'","filpath":"'.phpescape($UserText).'","label":"'.$label.'"}';
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
		
//		if(preg_match("/[\',;%+]/",$filename)) doc_upload_callback("{\"status\":0,\"msg\":\"" . get_lang("class_doc_warning7") . "\"}") ;

		$target_file = str_replace("{b@","",js_unescape(g("target_file")));
		$target_file = str_replace("}","",$target_file);

        $FileState = DocAce::can(DOCACE_UPLOAD_CLOTFILE,$parent_type,$parent_id,$root_id);

		$doc = new Doc();
		$filename = $doc  -> modify_clotfile($filename,$parent_id);
		$file_item = $doc -> save_file5($target_file,$filename,g("fileSize"),DOC_VFOLDER,$parent_id,$root_id,$FileState);

		if (!$FileState){
		    $result = manager_username();
			ptpform_sendmsg($result,get_lang("cloud_clotfile"),5);
		    $printer -> fail(get_lang("cloud_error1"));
		}else{
			$doc_file_vesr = new Model ( "ClotFile" );
			$doc_file_vesr -> updateForm("ClotFile_Vesr");
		}

		$ids .= ($ids?",":"") . $file_item["ID"] ;
		//返回数据
		if (strpos($ids,","))
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

	function create()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$name = g("col_name");
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;
		
		$label = g("label");
		
		if ($label == "onlinefile")
		{
			save_onlinefile();
			return ;
		}

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id))))
			$printer->fail ( "errnum:101001,msg:col_name" );

		$doc = new Doc();
		if ($doc -> exist_name($parent_type,$parent_id,$doc_type,$name))
			$printer->fail ( "errnum:10008,msg:col_name" );

		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,$parent_id,$name,getValue("myid"));
		
		$doc -> doc_retime($parent_id);
		
		$root_dir = $doc -> get_root_dir(0,$result["ptpfolderid"]) ;
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_create_folder").$root_dir["default_dir"],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);

		$doc_type = $result["type"] ;
		$fields = $doc -> get_fields_list($doc_type,$root_id) ;
		$sql = " select " . $fields . " from PtpFolder A where ptpfolderid=" . $result["ptpfolderid"] ;
		$data = $doc -> db -> executeDataTable($sql) ;
		
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		if(g("memberIds")){
			$arr_id = explode(",",g("memberIds"));
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
		$printer -> success();
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

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id))))
			$printer -> fail(get_lang("cloud_error7"));

		$doc = new Doc();
		if ($doc -> exist_name($parent_type,$parent_id,$doc_type,$name))
			$printer -> fail("[" . $name . "]".get_lang("cloud_error8"));

		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,$parent_id,$name,getValue("myid"));
		
		$doc -> doc_retime($parent_id);
		
		$root_dir = $doc -> get_root_dir(0,$result["ptpfolderid"]) ;
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_create_folder").$root_dir["default_dir"],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);

		$doc_type = $result["type"] ;
		$fields = $doc -> get_fields_list($doc_type,$root_id) ;
		$sql = " select " . $fields . " from PtpFolder A where ptpfolderid=" . $result["ptpfolderid"] ;
		$data = $doc -> db -> executeDataTable($sql) ;
		
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		if(g("ptpform")){
			$arr_id = explode(",",g("ptpform"));
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
	
	function folder_create1()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$name = g("name");
		$fullPath = g("fullPath") ;
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if (getValue("myid")=="Public"&&(!(DocAce::can(DOCACE_CREATE,$parent_type,$parent_id,$root_id))))
			$printer -> fail(get_lang("cloud_error7"));

		$doc = new Doc();
		$arr_item = explode("/",$fullPath);
		//if(preg_match("/['&]/",str_replace($arr_item[count($arr_item)-1],"",$fullPath))) $printer -> fail(get_lang("class_doc_warning9"));
		folder_create2($arr_item,0,$parent_id);
		$search = array(chr(37),chr(38),chr(39));
		$name = str_replace($search,chr(32),$arr_item[0]);
		
		//$name = str_replace(chr(39),chr(32),str_replace(chr(38),chr(32),$arr_item[0]));
		$sql = " select " . ($doc -> get_fields_list(DOC_VFOLDER)) . " from PtpFolder A where ParentID='" . g("parent_id",0) . "' and UsName = '".$name."' and MyID='" . getValue("myid") . "'";
		$data = $doc -> db -> executeDataTable($sql) ;
		

		//用 list 是方便脚本的数据绑定
		$printer -> out_list($data,-1,0);
	}
	
	function folder_create2($arr_item,$kk,$parent_id)
	{
		Global $printer;

		$parent_type = g("parent_type");
		//$parent_id = g("parent_id");
		//$root_type = g("root_type");
		//$root_id = g("root_id");
		//$name = g("name");
		//$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;
		//$name = str_replace(chr(39),chr(32),str_replace(chr(38),chr(32),$arr_item[$kk]));
		$search = array(chr(37),chr(38),chr(39));
		$name = str_replace($search,chr(32),$arr_item[$kk]);
		//$name = $arr_item[$kk];
		
//		echo (count($arr_item)-1).'|'.$kk.'|'.$parent_id;
		if(count($arr_item)-1<=$kk){
			 doc_upload2($parent_id);
			 return ;
		}
		$doc = new Doc();
		$data = $doc -> db -> executeDataRow("select PtpFolderID from PtpFolder where ParentID='" . $parent_id . "' and UsName = '".$name."' and MyID='" . getValue("myid") . "'");
//		echo "select PtpFolderID from PtpFolder where ParentID='" . $parent_id . "' and UsName = '".$name."' and MyID='" . getValue("myid") . "'";
//		exit();
		if (count($data)) $new_parent_id = $data["ptpfolderid"] ;
		else{
		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,$parent_id,$name,getValue("myid"));
		$new_parent_id = $result["ptpfolderid"];
		
		$doc -> doc_retime($parent_id);
		
		$root_dir = $doc -> get_root_dir(0,$new_parent_id) ;
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_create_folder").$root_dir["default_dir"],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		}

		$kk++;
		folder_create2($arr_item,$kk,$new_parent_id);
	}
	
	function folder_create3($arr_item,$kk,$parent_id)
	{
		Global $printer;

		$parent_type = g("parent_type");
		$search = array(chr(37),chr(38),chr(39));
		$name = str_replace($search,chr(32),$arr_item[$kk]);

		if(count($arr_item)<=$kk){
			 return ;
		}
		$doc = new Doc();
		$data = $doc -> db -> executeDataRow("select PtpFolderID from PtpFolder where ParentID='" . $parent_id . "' and UsName = '".$name."' and MyID='" . getValue("myid") . "'");
		if (count($data)) $new_parent_id = $data["ptpfolderid"] ;
		else{
		$doc_dir = new DocDir();
		$result = $doc_dir -> insert($parent_type,$parent_id,$name,getValue("myid"));
		$new_parent_id = $result["ptpfolderid"];
		
		$doc -> doc_retime($parent_id);
		
		$root_dir = $doc -> get_root_dir(0,$new_parent_id) ;
		
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_create_folder").$root_dir["default_dir"],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);
		$doc_file_vesr = new Model ( "PtpFolder" );
		$doc_file_vesr -> updateForm("PtpFolder_Vesr");
		}

		$kk++;
		folder_create3($arr_item,$kk,$new_parent_id);
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
			//$YouUserNames1=split(",",$result["ptpform"]);
			$YouUserNames1 = explode(",",$result["ptpform"]);
			
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."'" ;
			$doc -> db -> execute($sql) ;
			$arr_id = explode(",",g("ptpform"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$ptpfolderid);
				}
			}
			$result=ptpform_username($ptpfolderid);
			//$YouUserNames2=split(",",$result["ptpform"]);
			$YouUserNames2 = explode(",",$result["ptpform"]);
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			$diffB = array_diff($YouUserNames2, $YouUserNames1);
			ptpform_sendmsg(implode(",",$diffB),$result["usname"],2);
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_warning").g("ptpform"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],24);
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
			ptpform_sendmsg($result["ptpform"],get_lang("cloud_warning1"),4);
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("cloud_warning2").trim(g("ptpformid")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],24);
			
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
			//$YouUserNames1=split(",",$result["ptpform"]);
			$YouUserNames1 = explode(",",$result["ptpform"]);
			
			$doc = new Doc();
			$arr_id = explode(",",g("ptpform"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$ptpfolderid);
				}
			}
			$result=ptpform_username($ptpfolderid);
			//$YouUserNames2=split(",",$result["ptpform"]);
			$YouUserNames2 = explode(",",$result["ptpform"]);
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			$diffB = array_diff($YouUserNames2, $YouUserNames1);
			ptpform_sendmsg(implode(",",$diffB),$result["usname"],2);
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_warning3").g("ptpform"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],24);
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
			//$YouUserNames1=split(",",$result["ptpform"]);
			$YouUserNames1 = explode(",",$result["ptpform"]);
			
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."' and UserID in ('" . str_replace(",","','",trim(g("ptpform"))) . "')" ;
			//echo $sql;
			//exit();
			$doc -> db -> execute($sql) ;
			
			$result=ptpform_username($ptpfolderid);
			//$YouUserNames2=split(",",$result["ptpform"]);
			$YouUserNames2 = explode(",",$result["ptpform"]);
			
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("cloud_warning4").trim(g("ptpform")),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],24);
			
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
		
		if ($label == "folder")
		{
			doc_list_folder();
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
		
		if ($label == "ptpfolder2")
		{
			doc_list_ptpfolder2();
			return ;
		}
		
		if ($label == "ptpfile")
		{
			doc_list_ptpfile();
			return ;
		}
		
		if ($label == "ptpfile2")
		{
			doc_list_ptpfile2();
			return ;
		}
		
		if ($label == "ptpfile3")
		{
			doc_list_ptpfile3();
			return ;
		}
		
		if ($label == "publicfile")
		{
			doc_list_publicfile();
			return ;
		}
		
		if ($label == "ptpfolderform")
		{
			doc_list_ptpfolderform();
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
		$parent_id = g("parent_id","0");
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
	
	function doc_list1()
	{
		Global $printer;

 		$label = g("label");
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");
		if ($label == "recent")
		{
			doc_list_recent1();
			return ;
		}
		if ($label == "search")
		{
			doc_list_search1();
			return ;
		}
		if ($label == "search2")
		{
			doc_list_search2();
			return ;
		}
		if ($label == "ptpfolderace")
		{
			doc_list_ptpfolderace();
			return ;
		}
		if ($label == "ptpfolderace1")
		{
			doc_list_ptpfolderace1();
			return ;
		}
		if ($label == "sharefile"&&g("filetype")=="2"&&$parent_id=="0")
		{
			doc_list_ptpform1();
			return ;
		}
		
		if ($label == "ptpform")
		{
			doc_list_ptpform2();
			return ;
		}

		$doc = new DOC();
		$data_folder = array();
		
		if ($root_type == 1&&(! $file_type)){
			$result_file = $doc -> list_file18($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);
			$data_file = $result_file["data"] ;
			$recordcount = $result_file["count"] ;
			$pageindex = $result_file["pageindex"] ;
			$data1 = $doc -> list_file11($root_type);
			$printer -> out_list3($data_file,$data1["data1"],$data1["data3"],$pageindex,$recordcount,0);
		}
		
		if ($pageindex == 1)
		{
			//文件夹不作分页，故分页时不显示
			if (! $file_type)
			{
				if ($parent_type)
					$data_folder = $doc -> list_folder10($parent_type,$parent_id,$root_type,$root_id,$sortby);
				else
					$data_folder = $doc -> list_root($root_type,$sortby);
			}
		}

		//加载文件
		$result_file = $doc -> list_file10($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$pageindex = $result_file["pageindex"] ;
		$data = array_merge($data_folder,$data_file) ;
		
		$data1 = $doc -> list_file11($root_type);

		$printer -> out_list3($data,$data1["data1"],$data1["data3"],$pageindex,$recordcount,0);
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
		$sql_where = "where (MyID='Public' or MyID='".CurUser::getUserId()."') and To_Type=3 and FileState=1" ;
		
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

	function doc_list_search1()
	{
		Global $printer;
		
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");

		$doc = new DOC();
		$result_file = $doc -> doc_list_search1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$pageindex = $result_file["pageindex"] ;
		
		$data1 = $doc -> list_file11($root_type);
		
		$printer -> out_list3($data,$data1["data1"],$data1["data3"],$pageindex,$recordcount,0);
	}
	
	function doc_list_search2()
	{
		Global $printer;
		
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");

		$doc = new DOC();
		$result_file = $doc -> doc_list_search2($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$pageindex = $result_file["pageindex"] ;
		
		$data1 = $doc -> list_file11($root_type);
		
		$printer -> out_list3($data,$data1["data1"],$data1["data3"],$pageindex,$recordcount,0);
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
		$sql_where = "where (MyID='Public' or MyID='".CurUser::getUserId()."') and To_Type=3 and FileState=1" ;

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
	
 	function doc_list_recent1()
	{
		Global $printer;

		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");

		$doc = new DOC();
		$result_file = $doc -> doc_list_recent1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$pageindex = $result_file["pageindex"] ;
		
		$data1 = $doc -> list_file11($root_type);
		
		$printer -> out_list3($data,$data1["data1"],$data1["data3"],$pageindex,$recordcount,0);
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
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$curr_path = g("curr_path");
		$arr_id = explode(",",js_unescape(g("sids")));
		
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
					$data_folder = $doc -> list_folder0($parent_type,$parent_id,$root_type,$root_id,$sortby);
				else
					$data_folder = $doc -> list_root0($root_type,$sortby);
			}
		}

		//加载文件
		$result_file = $doc -> list_file0($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby,$pageindex,$pagesize);

		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;
		$data = array_merge($data_folder,$data_file) ;
		
		}else{
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
//				$col_myid=$arr_item[0];
//				unset($arr_item[0]);
//				unset($arr_item[count($arr_item)]);
//				$col_id=implode('_',$arr_item);
//				if($col_myid == DOC_FILE) $recordcount+=1;
				$result_file = $doc -> get_detail($arr_item[0],$arr_item[1],$doc -> get_fields_list($arr_item[0]));
				$data[] = $result_file;
			}
		}
		}

		$printer -> out_list($data,$recordcount,0);
	}
	
 	function doc_list_folder()
	{
		Global $printer;
		
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$curr_path = g("curr_path");
		$arr_id = explode(",",js_unescape(g("sids")));
		
		$root_type=3;

		$doc = new Doc();
			
		$data_folder = array();

		$data_folder = $doc -> list_folder($parent_type,$parent_id,$root_type,$root_id,$sortby);


		$printer -> out_list($data_folder,-1,0);
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
		$parent_id = g("parent_id","0");
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
//		echo var_dump($data_file);
//		exit();

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_ptpfolder2()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file16($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;
//		echo var_dump($data_file);
//		exit();

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
	
 	function doc_list_ptpfile2()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file14($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_ptpfile3()
	{
		Global $printer;
		$vesr = g("vesr");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file15($vesr);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["vesr"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}
	
 	function doc_list_publicfile()
	{
		Global $printer;
		
		$tableName = f ( "table", "PtpFile" );
		$fldId = f ( "fldid", "ID" );
		$fldList = f ( "fldlist", "*" );
	
		switch (DB_TYPE)
		{
			case "access":
				$fldSort = f ( "fldsort", "ID ASC" );
				$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
				break ;
			default:
				$fldSort = f ( "fldsort", "ID ASC" );
				$fldSortdesc = f ( "fldsortdesc", "ID DESC" );
				break;
		}
	
		$ispage = f ( "ispage", "1" );
		$pageIndex = f ( "pageindex", 1 );
		$pageSize = f ( "pagesize", 100 );
		
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file8($tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
		$data_file = $result_file["data"] ;
		$recordcount = $result_file["count"] ;

		$printer -> out_list($data_file,$recordcount,0);
	}

 	function doc_list_ptpfolderform()
	{
		Global $printer;
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file9($vesr);
		$data_file = $result_file["data"] ;

		$printer -> out_list($data_file,-1,0);
	}
	
 	function doc_list_ptpfolderace()
	{
		Global $printer;
		$doc = new Doc();
		$data = array();
		//加载文件
		$root_type = g("root_type",0) ;
		$result_file = $doc -> list_file11($root_type);
		$data_file = $result_file["data"] ;

		$printer -> out_list($data_file,-1,0);
	}
	
 	function doc_list_ptpfolderace1()
	{
		Global $printer;
		$doc = new Doc();
		$data = array();
		//加载文件
		$root_type = g("root_type",0) ;
		$result_file = $doc -> list_file17($root_type);
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
	
 	function doc_list_ptpform1()
	{
		Global $printer;
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file12($parent_type,$parent_id,$root_type,$root_id,$sortby);
		$data = $result_file["data"] ;

		$data1 = $doc -> list_file11($root_type);

		$printer -> out_list3($data,$data1["data1"],$data1["data3"],$pageindex,-1,0);
	}
	
 	function doc_list_ptpform2()
	{
		Global $printer;
		$sortby = g("sortby","ID desc");
		$pagesize = g("pagesize",100);
		$pageindex = g("pageindex",1);
	 	$recordcount = 0 ;

		$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
		$root_id = g("root_id",0);  	//
		$parent_type = g("parent_type",0);
		$parent_id = g("parent_id","0");
		$file_type = g("file_type");
		$key = g("key");
		$doc = new Doc();
		$data = array();
		//加载文件
		$result_file = $doc -> list_file13($parent_type,$parent_id,$root_type,$root_id,$sortby);
		$data = $result_file["data"] ;

		$printer -> out_list($data,-1,0);
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
		$label = g("label");
		if ($label == "ptpform")
		{
			ptpform_save();
			return ;
		}
		$filefactpath = g ( "filefactpath", "" );
		$doc = new Doc();
		$doc_id = g ( "id", 0 );
		$Authority1 = g ( "Authority1", 0 );
		$Authority2 = g ( "Authority2", 0 );
		$Authority3 = g ( "Authority3", 1 );
		
		$sql = " update OnlineFile set Authority1=" . $Authority1 . ",Authority2=" . $Authority2 . ",Authority3=" . $Authority3 . " where OnlineID =" . $doc_id;
		$doc -> db -> execute($sql);
	
		$memberIds = g ( "memberIds" );
		$doc->setMember ( $doc_id, $memberIds, 1 );

		$printer->success ();
	}
	
	function ptpform_save()
	{
		Global $printer;

		$parent_type = g("parent_type");
		$parent_id = g("parent_id");
		$root_type = g("root_type");
		$root_id = g("root_id");
		$ptpfolderid = g ( "id", 0 );
		$doc_type = $parent_type?DOC_VFOLDER:DOC_ROOT ;

		if(g("memberIds")){
			$result = ptpform_username($ptpfolderid);
			//$YouUserNames1=split(",",$result["ptpform"]);
			$YouUserNames1 = explode(",",$result["ptpform"]);
			
			$doc = new Doc();
			$sql = "Delete from PtpForm where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."'" ;
			$doc -> db -> execute($sql) ;
			$arr_id = explode(",",g("memberIds"));
			foreach($arr_id as $id)
			{
				if ($id)
				{
					$doc -> save_ptpform($id,$ptpfolderid);
				}
			}
			$result=ptpform_username($ptpfolderid);
			//$YouUserNames2=split(",",$result["ptpform"]);
			$YouUserNames2 = explode(",",$result["ptpform"]);
			$diffA = array_diff($YouUserNames1, $YouUserNames2);
			ptpform_sendmsg(implode(",",$diffA),$result["usname"],3);
			$diffB = array_diff($YouUserNames2, $YouUserNames1);
			ptpform_sendmsg(implode(",",$diffB),$result["usname"],2);
			$doc_file_vesr = new Model ( "PtpForm" );
			$doc_file_vesr -> updateForm("PtpForm_Vesr");
		}
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_warning").g("memberIds"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],24);
		//用 list 是方便脚本的数据绑定
		$printer -> success();
	}
	
	function save_onlinefile() {
		Global $printer;
		Global $op;

		$filefactpath = g ( "filefactpath", "" );
		$doc = new Doc();
		
		$arr_id = explode(",",g("memberIds1"));
		foreach($arr_id as $doc_id)
		{
			if ($doc_id)
			{
				$Authority1 = g ( "Authority1", 0 );
				$Authority2 = g ( "Authority2", 0 );
				$Authority3 = g ( "Authority3", 1 );
				
				$sql = " update OnlineFile set Authority1=" . $Authority1 . ",Authority2=" . $Authority2 . ",Authority3=" . $Authority3 . " where OnlineID =" . $doc_id;
				$doc -> db -> execute($sql);
			
				$memberIds = g ( "memberIds" );
				$doc->setMember ( $doc_id, $memberIds, 1 );
			}
		}
		


		$printer->success ();
	}

	function detail() {
		Global $printer;
 		$label = g("label");
		if ($label == "ptpform")
		{
			ptpform_detail();
			return ;
		}
		
		$doc = new Doc();
		$doc_id = g ( "id", 0 );
		
        $row = $doc -> get_detail1(DOC_FILE,$doc_id,"Authority1,Authority2,Authority3");
	
		$append = "";
		$sql = "Select bb.UserID as col_id,aa.FcName as col_name,aa.UserName as col_loginname,aa.UserIco,aa.UserIcoLine,bb.Authority from Users_ID as aa , OnlineForm as bb where aa.UserID=bb.UserID and bb.OnlineID=" . $doc_id . " and aa.UserState=1 order by bb.ID asc";
		$data = $doc -> db -> executeDataTable($sql);
		$append = $printer->union ( $append, '"members":[' . ($printer->parseList ( $data, 0 )) . ']' );
	
		$printer->out_detail ( $row, $append, 0 );
	}
	
	function ptpform_detail() {
		Global $printer;
		
		$doc = new Doc();
		$doc_id = g ( "id", 0 );

		$row = $doc -> get_detail(DOC_VFOLDER,$doc_id,$doc -> get_fields_list(DOC_VFOLDER));
	
		$append = "";
		$sql = "Select bb.UserID as col_id,aa.FcName as col_name,aa.UserName as col_loginname,aa.UserIco,aa.UserIcoLine from Users_ID as aa , PtpForm as bb where aa.UserID=bb.UserID and bb.MyID='".CurUser::getUserId()."' and bb.PtpFolderID='" . $doc_id . "' and aa.UserState=1";
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
		
		$search = array('\'',',',';','%','+',chr(37),chr(38),chr(39),chr(160),chr(194));
		$name = str_replace($search,chr(32),g("name"));
		//$name = g("name"); // filename or zipname
		$arr_id = explode(",",$ids) ;

		//权限判断
//		if (DocAce::can(DOCACE_NETWORK_PHONE)&&((!is_private_ip(clientIP()))||ismobile()))
//			$printer -> fail("你没有权限在外网或手机中下载");
		//权限判断
		if (! (DocAce::can(DOCACE_DOWNLOAD,$parent_type,$parent_id,$root_id)||g("myid")))
			$printer -> fail(get_lang("cloud_authority_error"));


		//存放文件或文件夹
		$data_list = array();

		//遍历选中节点的数据
		foreach($arr_id as $id)
		{
			//得到子孙文件夹与文件
			$arr_item = explode("_",$id);
			$arr_id = $arr_item[1];
			$data = $doc -> get_child_data($arr_item[0],$arr_id,$arr_item[2],1,1) ;
			$data_list[] = array("doc_type"=>$arr_item[0],"doc_id"=>$arr_id,"root_id"=>$arr_item[2],"root_type"=>$root_type,"data"=>$data);
		}

		//验证有效性
//		echo var_dump($data_list);
//		exit();
		doc_download_valid($data_list);

		//得到相关目录
		$target = RTC_CONSOLE . "/temp/" . date("Ymd") ;
		$target_folder = $target .  "/" . str_replace(".zip","",$name) ;
		$target_zip = $target .  "/" . $name ;

		//生成文件夹
		foreach($data_list as $data_item)
		{
			$root_dir = $doc -> get_root_dir($data_item["root_type"],$data_item["root_id"]) ;
			$result = $doc -> bulid_folder($data_item["data"],$target_folder,$root_dir["default_dir"]);
		}

		//打包文件
		$zip = new Ziper();
		$zip -> zipFolder($target_folder,$target_zip);

		//得到地址
		$target_zip = str_replace(RTC_CONSOLE."/","",$target_zip) ;

		//删除当前目录
		deldir(iconv_str($target_folder,"UTF-8","GBK"));
		//exit();
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_warning5").$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
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
		if (! DocAce::can(DOCACE_DOWNLOAD_LEAVEFILE,$parent_type,$parent_id,$root_id))
			$printer -> fail(get_lang("cloud_authority_error"));


		//存放文件或文件夹
		$data_list = array();

		//遍历选中节点的数据
		foreach($arr_id as $id)
		{
			//得到子孙文件夹与文件
			$arr_item = explode("_",$id);
			//$arr_id = $doc -> get_leavefileid($arr_item[1]);
			$data = $doc -> get_child_data($arr_item[0],$arr_item[1],$arr_item[2],1,1) ;
			$data_list[] = array("doc_type"=>$arr_item[0],"doc_id"=>$arr_item[1],"root_id"=>$arr_item[0],"root_type"=>$root_type,"data"=>$data);
		}

		//验证有效性
//		echo var_dump($data_list);
//		exit();
		doc_download_valid($data_list);

		//得到相关目录
		$target = RTC_CONSOLE . "/temp/" . date("Ymd") ;
		$target_folder = $target .  "/" . str_replace(".zip","",$name) ;
		$target_zip = $target .  "/" . $name ;

		//生成文件夹
		foreach($data_list as $data_item)
		{
			$root_dir = $doc -> get_root_dir($data_item["root_type"],$data_item["root_id"]) ;
			$result = $doc -> bulid_folder($data_item["data"],$target_folder,$root_dir["default_dir"]);
		}

		//打包文件
		$zip = new Ziper();
		$zip -> zipFolder($target_folder,$target_zip);

		//得到地址
		$target_zip = str_replace(RTC_CONSOLE."/","",$target_zip) ;

		//删除当前目录
		deldir(iconv_str($target_folder,"UTF-8","GBK"));

        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("cloud_warning6").$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
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
			$printer -> fail(get_lang("cloud_error9"));

		//用 out_str,而不用fail, 因为msg中有,号，会认为是特殊字符
		if (DOWN_SIZE_LIMIT>0)
		{
			if ($file_size > (DOWN_SIZE_LIMIT * 1024))
				$printer -> out_msg(0,get_lang("cloud_warning7") . round($file_size / 1024,2) . get_lang("cloud_warning8") .DOWN_SIZE_LIMIT . "MB");
		}

		if (DOWN_COUNT_LIMIT>0)
		{
			if ($file_count > DOWN_COUNT_LIMIT)
				$printer -> out_msg(0,get_lang("cloud_warning7") . $file_count . get_lang("cloud_warning9") .DOWN_COUNT_LIMIT . get_lang("cloud_warning10"));
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
		if($doc_type==DOC_FILE) $where="Msg_ID='". $doc_id . "'";
		else $where="PtpFolderID='".$doc_id."'";
		$fields = $doc -> get_fields_list($doc_type) ;
		$sql = " select ".$fields.",A.PtpFolderID from " . (Doc::get_table_obj($doc_type)) . " A where " . $where ;
//		echo $sql;
//		exit();
		

		$data = $doc -> db -> executeDataRow($sql);
		if (count($data) == 0)
			$printer -> fail(get_lang("cloud_error6"));

        //if($doc_type==DOC_FILE) setValue("myid",$data["myid"]);

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
		if($doc_type!=DOC_FILE) $path_data=array_slice($path_data,1);
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
	
	function doc_attr2()
	{
		Global $printer;

		$doc_type = g("doc_type",0);
		$doc_id = g("doc_id",0);

		$doc = new Doc();
		//得到路径
		$root_id = 0 ;
		$root_type = 1 ;
		$path_url = "" ;
		$path_text = "" ;
		$path_data = $doc -> get_path_data($doc_type,$doc_id);

		//得到root_id
		if (count($path_data)>0)
		{
			$node = $path_data[count($path_data)-1] ;
			$root_id = $node["doc_id"] ;
			$root_type = $data["myid"]== "Public"?1:3  ;
		}
		//if($doc_type!=DOC_FILE) $path_data=array_slice($path_data,1);
		//转换成hash的路径
		foreach($path_data as $node)
		{
			$name = $node["doc_name"] ;
			$path_text = $name . ($path_text?"/":"") . $path_text ;
			$path_url = get_doc_node($node["doc_type"],$node["col_id"],$root_id,$name). ($path_url?"/":"") . $path_url ;
		}
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
		//消息的内容
		switch($operation)
		{
			case 1:
			    $ncontent = get_lang("cloud_warning11");
				$data_id = 2;
				break ;
			case 2:
				$ncontent = get_lang("cloud_warning12").chr(34).$ntitle.chr(34).get_lang("cloud_warning13");
				$data_id = 2;
				break ;
			case 3:
				$ncontent = get_lang("cloud_warning14");
				$data_id = 2;
				break ;
			case 4:
				$ncontent = chr(34).CurUser::getUserName().chr(34).get_lang("cloud_warning15");
				$data_id = 1;
				break ;
			case 5:
				$ncontent = chr(34).CurUser::getUserName().chr(34).get_lang("cloud_warning16");
				$data_id = 1;
				break ;
		}
		//消息的链接地址，当消息类型为3启用
		if($operation==5) $nlink = "";
		else $nlink = "?TargetType=2*data_type=sharefile*data_id=".$data_id;
	
		$msg = new Msg ();
		$msg ->sendRTCMessge(CurUser::getLoginName(),$UserNames,$ntitle, $ncontent,$nlink,3);
		
		}
    }
	
    function messenge_sendmsg($UserNames,$ncontent,$operation)
    {
		if($UserNames){
//		$Msg = new COM("RTCCom.Message");
//		//消息发送者的 UserName
//		$Msg->MyUserName = urlencode(CurUser::getLoginName());
//		//消息接收者的帐号，多个用逗号分隔，当消息类型为0、2、3启用
//		$Msg->YouUserNames = urlencode($UserNames);
//		//消息接收者的群组名称，多个用逗号分隔，当消息类型为1启用
//		//$YouUserNames = "财务群,技术讨论群";
//		//消息的标题，当消息类型为2、3启用
//		$Msg->ntitle = "";
//		//消息的内容
////		switch($operation)
////		{
////			case 1:
////			    $ncontent = "文件共享有更新，赶紧去看看新增了哪些好内容把！";
////				$data_id = 2;
////				break ;
////		}
//		$Msg->ncontent = urlencode($ncontent);
//		//消息的链接地址，当消息类型为3启用
//		$Msg->nlink = "";
//		//消息类型  0消息 1群组消息 2公告 3通知
//		$MsgType = $operation;
//		$Msg->Login(RTC_SERVER,6004);
//		$Msg->SendMessage($MsgType);
		
		$msg = new Msg ();
		$msg ->sendRTCMessge(CurUser::getLoginName(),$UserNames,"", $ncontent,"",$operation);
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