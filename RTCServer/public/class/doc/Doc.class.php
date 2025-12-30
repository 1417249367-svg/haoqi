<?php
/**
 * 云文档类

 * @date    20141209
 */

class Doc
{
	//数据库操作类
	public $db ;
	public $relation ;
	public $temp ;

	public $path = array();

	function __construct()
	{
		$this -> db = new DB();
		$this -> relation = new DocRelation();
		$this -> doc_dir = new DocDir();
	}

	function save_to_file($image,$target_dir){
		$filename = get_basename($this  -> modify_file($target_dir.'/'.$image,$image)) ;
		if(!file_exists($target_dir)){
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning14") . str_replace("\\","/",$target_dir) . get_lang("class_doc_warning1"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
			return array("status"=>0,"msg"=>get_lang("class_doc_warning")."[" . str_replace("\\","/",$target_dir) . "]".get_lang("class_doc_warning1"));
		}
			
        //if(preg_match("/[\',;%+]/",$image)) return array("status"=>0,"msg"=>get_lang("class_doc_warning7"));

		$target_file = $filename ;  // root_dir/guid_filename

		return array("status"=>1,"target"=>$target_file,"filename"=>$filename,"filesize"=>0);
		

	} 

	function upload_file($file,$target_dir)
	{
		//$filename = get_basename($this  -> modify_file(iconv_str($target_dir.'/'.$file["name"],"utf-8","gbk"),$file["name"])) ;
		$search = array('\'',',',';','%','+');
		$filename = str_replace($search,chr(32),$file["name"]);
		
//		return array("status"=>0,"msg"=>$this  -> modify_file($target_dir.'/'.$file["name"],$file["name"]));
//		echo $filename;
//		exit();
		//$filename = $file["name"] ;
		$filesize = $file["size"] ;

//		if(!$filesize){
//			$antLog = new AntLog();
//			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning13"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
//			return array("status"=>0,"msg"=>get_lang("class_doc_warning10"));
//		}
		
		if(!file_exists(iconv_str($target_dir,"utf-8","gbk"))){
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning14") . str_replace("\\","/",$target_dir) . get_lang("class_doc_warning1"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
			return array("status"=>0,"msg"=>get_lang("class_doc_warning")."[" . str_replace("\\","/",$target_dir) . "]".get_lang("class_doc_warning1"));
		}
			
        //if(preg_match("/[\',;%+]/",$file["name"])) return array("status"=>0,"msg"=>get_lang("class_doc_warning7"));

		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo(strtolower($file["name"]));
		if (in_array($fileParts['extension'],$fileTypes)){
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning15"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
			 return array("status"=>0,"msg"=>get_lang("class_doc_warning8"));
		}

		$target_file = $file["name"] ;  // root_dir/guid_filename
		move_uploaded_file($file["tmp_name"], iconv_str($target_dir . "/" . $filename,"utf-8","gbk"));

		return array("status"=>1,"target"=>$filename,"filename"=>$filename,"filesize"=>$filesize);
	}
	
	function upload_file1($filename,$target_dir)
	{
		$filename = get_basename($this  -> modify_file(iconv_str($target_dir.'/'.$filename,"utf-8","gbk"),$filename)) ;
		//$filesize = $file["size"] ;

		if(!file_exists(iconv_str($target_dir,"utf-8","gbk"))){
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning14") . str_replace("\\","/",$target_dir) . get_lang("class_doc_warning1"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
			return array("status"=>0,"msg"=>get_lang("class_doc_warning")."[" . str_replace("\\","/",$target_dir) . "]".get_lang("class_doc_warning1"));
		}
		
		$fileTypes = array('asp','php'); // File extensions
		$fileParts = pathinfo(strtolower($filename));
		if (in_array($fileParts['extension'],$fileTypes)){
			$antLog = new AntLog();
			$antLog->log(CurUser::getUserName().get_lang("class_doc_warning12").$filename.get_lang("class_doc_warning15"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],20);
		 return array("status"=>0,"msg"=>get_lang("class_doc_warning8"));
		}
		$target_file = iconv_str($filename,"gbk","utf-8") ;  // root_dir/guid_filename

		return array("status"=>1,"target"=>$target_file,"filename"=>$filename,"filesize"=>$filesize);
	}
	
//	function upload_file2($file,$target_dir)
//	{
//		$filename = $file["name"] ;
//		$filesize = $file["size"] ;
//
//		if(!$filesize)
//			return array("status"=>0,"msg"=>get_lang("class_doc_warning10"));
//		
//		if(!file_exists($target_dir))
//			return array("status"=>0,"msg"=>get_lang("class_doc_warning")."[" . str_replace("\\","/",$target_dir) . "]".get_lang("class_doc_warning1"));
//		
//		$fileTypes = array('asp','php'); // File extensions
//		$fileParts = pathinfo(strtolower($file["name"]));
//		if (in_array($fileParts['extension'],$fileTypes)) return array("status"=>0,"msg"=>get_lang("class_doc_warning8"));
//
//		$target_file = $file["name"] ;  // root_dir/guid_filename
//		move_uploaded_file($file["tmp_name"], iconv_str($target_dir . "/" . $filename,"utf-8","gbk"));
//
//		return array("status"=>1,"target"=>$target_file,"filename"=>$filename,"filesize"=>$filesize);
//	}

	function save_file($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FileState)
	{
		if(g("Msg_ID")) $Msg_ID=g("Msg_ID");
		else $Msg_ID=create_guid(0);
		$file_item = array();
		$file_item["MyID"] = getValue("myid") ;
		$file_item["Msg_ID"] = $Msg_ID ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["UsName"] = CurUser::getUserName() ;
		$file_item["PtpFolderID"] = $parent_id ;
		$file_item["FilPath"] = $target_file ;
		$file_item["To_Type"] = g("root_type",3) ;
		$file_item["FileState"] = $FileState ;
		$file_item["CreatorID"] = CurUser::getUserId() ;
		$file_item["CreatorName"] = CurUser::getLoginName() ;
		//$file_item = array_merge($file_item,$file_attr) ;

		//insert tab_doc_file
		$doc_file = new Model("PtpFile");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,1,$Msg_ID);
		$file_item["ID"] = $file_id ;
        $antLog = new AntLog();
		$antLog->log(CurUser::getUserName().get_lang("class_doc_warning2").$filename,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);

//		if($FileState){
//		$doc_file_vesr = new Model ( "PtpFile" );
//		$doc_file_vesr -> updateForm("PtpFile_Vesr");
//		
//		$ch = curl_init();
//		$url = "http://".RTC_SERVER.":99/services/OnlineFile.asp?CmdStr=PtpFile";
//		curl_setopt($ch, CURLOPT_URL, $url); 
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//		curl_exec($ch); 
//		curl_close ($ch); 
//		}

		//insert into relation
//		$doc_relation = new Model($this->get_table_link($parent_type));
//		$doc_relation -> clearParam();
//		$doc_relation -> addParamFields($file_link);
//		$doc_relation -> addParamField("col_s_objid",$file_id);
//		$doc_relation -> insert();

		return $file_item ;
	}
	
//	function update_file($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FileState)
//	{
//		$file_item = array();
//		$sql = "update PtpFile set PcSize='" . $filesize . "',FilPath='" . $target_file . "',OnlineID=0,FileState=" . $FileState . ",ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "',CreatorID='" . CurUser::getUserId() . "',CreatorName='" . CurUser::getLoginName() . "' where MyID='" . getValue("myid") . "' and PtpFolderID='" . $parent_id . "' and TypePath='" . $filename . "'";
//		$this -> db -> execute($sql) ;
//		$doc_file = new Model("PtpFile");
//		$doc_file -> addParamWhere("MyID", getValue("myid"));
//		$doc_file -> addParamWhere("PtpFolderID", $parent_id);
//		$doc_file -> addParamWhere("TypePath", $filename);
//		$file_item = $doc_file -> getDetail();
//		$file_item["ID"] = $file_item["id"] ;
//		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,1,$file_item["msg_id"]);
//        $antLog = new AntLog();
//		$antLog->log(CurUser::getUserName().get_lang("class_doc_warning11").$filename,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);
//
//		return $file_item ;
//	}
	
	function save_file1($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FileState)
	{
		$Msg_ID=create_guid(0);
		$file_item = array();
		$file_item["MyID"] = CurUser::getUserId() ;
		$file_item["Msg_ID"] = $Msg_ID ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["UsName"] = CurUser::getUserName() ;
		$file_item["PtpFolderID"] = $parent_id ;
		$file_item["FilPath"] = $target_file ;
		$file_item["To_Type"] = g("root_type",3) ;
		$file_item["FileState"] = $FileState ;
		$file_item["CreatorID"] = CurUser::getUserId() ;
		$file_item["CreatorName"] = CurUser::getLoginName() ;
		$doc_file = new Model("PtpFile");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,1,$Msg_ID);
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file2($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FileState)
	{
		if(!$filesize){
			$default_dir = RTC_CONSOLE."/".$target_file ;
			$default_dir = iconv_str($default_dir,"utf-8","gbk");
			$filesize=filesize($default_dir);
		}
		$file_item = array();
		$file_item["MyID"] = getValue("myid") ;
		$file_item["Msg_ID"] = g("Msg_ID") ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["UsName"] = CurUser::getUserName() ;
		$file_item["PtpFolderID"] = $parent_id ;
		$file_item["FilPath"] = $target_file ;
		$file_item["To_Type"] = g("root_type",3) ;
		$file_item["FileState"] = $FileState ;
		$file_item["CreatorID"] = CurUser::getUserId() ;
		$file_item["CreatorName"] = CurUser::getLoginName() ;
		$doc_file = new Model("PtpFile");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,1,g("Msg_ID"));
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file3($target_file,$filename,$filesize,$myid,$usname,$FormFileType,$Authority1 = 0)
	{
		$file_item = array();
		$file_item["MyID"] = $myid ;
		$file_item["UsName"] = $usname ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["FilPath"] = $target_file ;
		$file_item["FormFileType"] = $FormFileType ;
		$file_item["Authority1"] = $Authority1 ;
		$doc_file = new Model("OnlineFile","OnlineID");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$file_item["OnlineID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file4($doc_id,$target_file,$filename,$filesize,$myid,$usname,$description,$callbackjson)
	{
		$file_item = array();
		$file_item["MyID"] = $myid ;
		$file_item["UsName"] = $usname ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["OnlineID"] = $doc_id ;
		$file_item["FilPath"] = $target_file ;
		$file_item["Description"] = $description ;
		$file_item["CallbackJSON"] = $callbackjson ;
		$file_item["CreatorID"] = CurUser::getUserId() ;
		$file_item["CreatorName"] = CurUser::GetUserName() ;
		$doc_file = new Model("OnlineRevisedFile","ID");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file5($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FileState)
	{
		if(g("Msg_ID")) $Msg_ID=g("Msg_ID");
		else $Msg_ID=create_guid(0);
		$file_item = array();
		$file_item["MyID"] = CurUser::getUserId() ;
		$file_item["Msg_ID"] = $Msg_ID ;
		$file_item["UsName"] = CurUser::getUserName() ;
		$file_item["ClotID"] = $parent_id ;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["FilPath"] = $target_file ;
		$file_item["FileState"] = $FileState ;
		$doc_file = new Model("ClotFile");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,4,$Msg_ID);
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file7($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id)
	{
		$file_item = array();
		$file_item["Msg_ID"] = g("Msg_ID") ;
		$file_item["UserID1"] = $parent_id ;
		$file_item["UserID2"] = CurUser::getUserId() ;;
		$file_item["TypePath"] = $filename ;
		$file_item["PcSize"] = $filesize ;
		$file_item["SendTy"] = 0 ;
		$file_item["FilPath"] = $target_file ;
		$doc_file = new Model("LeaveFile");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$this -> save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,2,g("Msg_ID"));
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}
	
	function save_file8($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FormFileType,$Msg_ID)
	{
		$default_dir = RTC_CONSOLE."/".$target_file ;
		$default_dir = iconv_str($default_dir,"utf-8","gbk");
		//$filename = iconv_str($filename,"utf-8","gbk");

		$fileTypes = array('wmv','avi','3gp','mkv','mov','mpg','mpeg'); // File extensions
		$fileParts = pathinfo(strtolower($filename));
		if (!in_array($fileParts['extension'],$fileTypes)) return ;
		
		if(g("context")) $MD5Hash=g("context");
		else $MD5Hash=file_md5_100($default_dir);
		$row = $this -> db -> executeDataRow("select * from MD5VideoFile where Context='" . $MD5Hash . "'");
		if (count($row)){
			switch ($FormFileType) {
				case 1 :
					$sql = "update PtpFile set OnlineID=".$row["id"]." where Msg_ID='" . $Msg_ID . "'";
					$this -> db -> execute($sql) ;
					break;
				case 2 :
					$sql = "update LeaveFile set OnlineID=".$row["id"]." where Msg_ID='" . $Msg_ID . "'";
					$this -> db -> execute($sql) ;
					break;
				case 4 :
					$sql = "update ClotFile set OnlineID=".$row["id"]." where Msg_ID='" . $Msg_ID . "'";
					$this -> db -> execute($sql) ;
					break;	
			}
			return ;
		}
		if(TRANSCODE){
			if(!file_exists($default_dir)) return ;
			$originalPath = RTC_CONSOLE."/".$target_file ;
			$url = "http://".RTC_SERVER.":95/?originalPath=".phpescape($originalPath)."&FormFileType=".$FormFileType."&Msg_ID=".$Msg_ID."&context=".$MD5Hash;
//			$ch = curl_init();
//			curl_setopt($ch, CURLOPT_URL, $url); 
//			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//			curl_exec($ch); 
//			curl_close ($ch); 
			curl_yibu($url);
		}
		return 1;
	}
	
	function save_file9($target_file,$filename,$filesize,$FormFileType,$context)
	{	
		$data = $this -> db -> executeDataRow("select * from MD5VideoFile where Context='" . $context . "'");
		if (count($data)==0){
			$file_item = array();
			$file_item["MyID"] = CurUser::getUserId() ;
			$file_item["FormFileType"] = $FormFileType ;
			$file_item["TypePath"] = $filename ;
			$file_item["PcSize"] = $filesize ;
			$file_item["FilPath"] = $target_file ;
			$file_item["Context"] = $context ;
			$doc_file = new Model("MD5VideoFile");
			$doc_file -> clearParam();
			$doc_file -> addParamFields($file_item);
			$doc_file -> insert();
			$file_id = $doc_file -> getMaxId();
			$file_item["ID"] = $file_id ;
			return $file_item ;
		}

	}
	
	function save_file6($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FormFileType)
	{	
		$default_dir = RTC_CONSOLE . "/" . $target_file;
		//$default_dir = str_replace("/","\\",$default_dir) ;	
		$default_dir = iconv_str($default_dir,"utf-8","gbk");
		//$MD5Hash = md5_file($default_dir);
		if(g("context")) $MD5Hash=g("context");
		else $MD5Hash=file_md5_100($default_dir);
		$sql = " delete from MD5File where FilPath='" . $target_file . "'" ;
		$this -> db -> execute($sql) ;
		$data = $this -> db -> executeDataRow("select * from MD5File where MD5Hash='" . $MD5Hash . "'");
		if (count($data)==0){
			$file_item = array();
			$file_item["MyID"] = CurUser::getUserId() ;
			$file_item["FormFileType"] = $FormFileType ;
			$file_item["TypePath"] = $filename ;
			$file_item["PcSize"] = $filesize ;
			$file_item["FilPath"] = $target_file ;
			$file_item["MD5Hash"] = $MD5Hash ;
			$doc_file = new Model("MD5File");
			$doc_file -> clearParam();
			$doc_file -> addParamFields($file_item);
			$doc_file -> insert();
//			$file_id = $doc_file -> getMaxId();
//			$file_item["ID"] = $file_id ;
//			return $file_item ;
		}

	}
	
	function save_ptpform($userid,$parent_id)
	{
		$file_item = array();
		$file_item["MyID"] = CurUser::getUserId() ;
		$file_item["UserID"] = $userid ;
		$file_item["PtpFolderID"] = $parent_id ;
		$doc_file = new Model("PtpForm");
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
		$file_id = $doc_file -> getMaxId();
		$file_item["ID"] = $file_id ;
		return $file_item ;
	}


	function doc_rename($parent_type,$parent_id,$doc_type,$doc_id,$name)
	{
		if ($this -> exist_name($doc_type,$parent_id,$doc_type,$name))
			return 0 ;
		$tablename = DOC::get_table_obj($doc_type);
		
		if($doc_type==DOC_FILE){
			$tableName_colData="TypePath";
			$where="Msg_ID='". $doc_id . "'";
		}else{
			$tableName_colData="UsName";
			$where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		}
		
		$sql = " update " . $tablename . " set " .$tableName_colData. "='" . $name . "',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where " . $where ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}
	
	function doc_rename1($parent_type,$parent_id,$doc_type,$doc_id,$name)
	{
		if ($this -> exist_name2($doc_type,$parent_id,$doc_type,$name))
			return 0 ;
		
		$sql = " update OnlineFile set TypePath='" . $name . "',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where OnlineID=" . $doc_id ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}

	function doc_retime($doc_id)
	{
		$where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		$sql = " update PtpFolder set ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where " . $where ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}
	
//	function get_ptpfolderid($PtpFolderID)
//	{
//		$param = array("MyID"=>getValue("myid"),"PtpFolderID"=>$PtpFolderID) ;
//
//		$root = new Model("PtpFolder");
//		$root -> addParamWheres($param);
//		$id = $root -> getValue("ID");
//		if($id) return $id ;
//		else return $PtpFolderID ;
//	}
	
//	function get_ptpfileid($Msg_ID)
//	{
////		if(strpos($typepath,"|")){
////			$arr = explode("|",$typepath);
//
//		$param = array("Msg_ID"=>$Msg_ID) ;
//
//		$root = new Model("PtpFile");
//		$root -> addParamWheres($param);
//		$id = $root -> getValue("ID");
//		return $id ;
////		}else return $typepath ;
//
//	}
	
	function get_leavefileid($typepath)
	{
		if(strpos($typepath,"|")){
			$arr = explode("|",$typepath);

		$param = array("UserID2"=>$arr[0],"UserID1"=>$arr[2],"TypePath"=>trim($arr[1])) ;

		$root = new Model("LeaveFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("ID");
		return $id ;
		}else return $typepath ;

	}
	
	function get_clotfileid($typepath)
	{
		if(strpos($typepath,"|")){
			$arr = explode("|",$typepath);

		$param = array("MyID"=>$arr[0],"ClotID"=>$arr[2],"TypePath"=>trim($arr[1])) ;
//		echo var_dump($param);
//		exit();

		$root = new Model("ClotFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("ID");
		return $id ;
		}else return $typepath ;

	}
	
	function modify_ptpfile($typepath,$ptpfolderid)
	{
		$param = array("MyID"=>getValue("myid"),"PtpFolderID"=>$ptpfolderid,"TypePath"=>$typepath) ;

		$root = new Model("PtpFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("ID");
		
		$param = array("MyID"=>getValue("myid"),"ParentID"=>$ptpfolderid,"UsName"=>$typepath) ;

		$root = new Model("PtpFolder");
		$root -> addParamWheres($param);
		$folderid = $root -> getValue("PtpFolderID");

		if ($id||$folderid)
		{
			$fileext = strrchr($typepath, '.');
			return str_replace($fileext,"",$typepath).date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999). $fileext ;
		}else return $typepath ;
	}
	
	function modify_onlinefile($typepath)
	{
		$param = array("MyID"=>CurUser::getUserId(),"TypePath"=>$typepath) ;

		$root = new Model("OnlineFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("OnlineID");

		if ($id)
		{
			$fileext = strrchr($typepath, '.');
			return str_replace($fileext,"",$typepath).date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999). $fileext ;
		}else return $typepath ;
	}
	
	function modify_clotfile($typepath,$ptpfolderid)
	{
		$param = array("MyID"=>CurUser::getUserId(),"ClotID"=>$ptpfolderid,"TypePath"=>$typepath) ;

		$root = new Model("ClotFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("ID");

		if ($id)
		{
			$fileext = strrchr($typepath, '.');
			return str_replace($fileext,"",$typepath).date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999). $fileext ;
		}else return $typepath ;
	}
	
	function modify_leavefile($typepath,$ptpfolderid)
	{
		$param = array("UserID2"=>CurUser::getUserId(),"UserID1"=>$ptpfolderid,"TypePath"=>$typepath) ;

		$root = new Model("LeaveFile");
		$root -> addParamWheres($param);
		$id = $root -> getValue("ID");

		if ($id)
		{
			$fileext = strrchr($typepath, '.');
			return str_replace($fileext,"",$typepath).date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999). $fileext ;
		}else return $typepath ;
	}
	
	function modify_file($files_url,$typepath)
	{

			if (is_file($files_url)){
				$fileext = strrchr($files_url, '.');
				return str_replace($fileext,"",$typepath).'/'.str_replace($fileext,"",$typepath).date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999). $fileext ;
			}
			else return $files_url ;
	}

	function exist_name($parent_type,$parent_id,$doc_type,$name,$elseId = 0)
	{
		$sql = "" ;
		switch($doc_type)
		{
			case DOC_ROOT:
			case DOC_VFOLDER:
				$sql = " select count(*) as c from PtpFolder where MyID='" . getValue("myid") . "' and ParentID='" . $parent_id . "' and UsName='" . $name . "'" ;
				break ;
			default:
				$sql = " select count(*) as c from PtpFile where MyID='" . getValue("myid") . "' and PtpFolderID='" . $parent_id . "' and TypePath='" . $name . "'" ;
				break ;
		}

		if ($elseId)
			$sql = " and col_id<>" . $elseId ;
			
//echo $sql;
//exit();
		$result = $this -> db -> executeDataValue($sql);
		return $result ;
	}

	function exist_name1($parent_type,$parent_id,$doc_type,$name,$elseId = 0)
	{
		$sql = "" ;
		switch($doc_type)
		{
			case DOC_ROOT:
			case DOC_VFOLDER:
				$sql = " select count(*) as c from PtpFolder where MyID='" . CurUser::getUserId() . "' and ParentID='" . $parent_id . "' and UsName='" . $name . "'" ;
				break ;
			default:
				$sql = " select count(*) as c from PtpFile where MyID='" . CurUser::getUserId() . "' and PtpFolderID='" . $parent_id . "' and TypePath='" . $name . "'" ;
				break ;
		}

		if ($elseId)
			$sql = " and col_id<>" . $elseId ;
			
//echo $sql;
//exit();
		$result = $this -> db -> executeDataValue($sql);
		return $result ;
	}
	
	function exist_name2($parent_type,$parent_id,$doc_type,$name,$elseId = 0)
	{

		$sql = " select count(*) as c from OnlineFile where MyID='" . CurUser::getUserId() . "' and TypePath='" . $name . "'" ;
		if ($elseId)
			$sql = " and OnlineID<>" . $elseId ;
		$result = $this -> db -> executeDataValue($sql);
		return $result ;
	}
	
	function exist_name4($OnlineID)
	{

		$sql = " select count(*) as c from OnlineFile where OnlineID=" . $OnlineID ;
		$result = $this -> db -> executeDataValue($sql);
		return $result ;
	}
	
	function exist_name3($parent_type,$parent_id,$doc_type,$name,$elseId = 0)
	{
		$sql = "" ;
		switch($doc_type)
		{
			case DOC_ROOT:
			case DOC_VFOLDER:
				$sql = " select PtpFolderID as Msg_ID from PtpFolder where MyID='" . getValue("myid") . "' and ParentID='" . $parent_id . "' and UsName='" . $name . "'" ;
				break ;
			default:
				$sql = " select Msg_ID from PtpFile where MyID='" . getValue("myid") . "' and PtpFolderID='" . $parent_id . "' and TypePath='" . $name . "'" ;
				break ;
		}

		if ($elseId)
			$sql = " and col_id<>" . $elseId ;
			
//echo $sql;
//exit();
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}

	function move($doc_type,$doc_id,$target_type,$target_id)
	{
		//如果是自己的话，返回
//		if (($doc_type == $target_type) && ($doc_id == $target_id))
//			return 0 ;

		$arr_sql = array();

//		//删除以前的关系
//		$arr_sql[] = " delete from TAB_DOC_ROOT_LINK     where col_s_objid=" . $doc_id  . " and col_s_classid=" . $doc_type;
//		$arr_sql[] = " delete from TAB_DOC_VFOLDER_LINK  where col_s_objid=" . $doc_id  . " and col_s_classid=" . $doc_type;
//
//		//添加新的关系
//		$tableName = $target_type == DOC_ROOT?"TAB_DOC_ROOT_LINK":"TAB_DOC_VFOLDER_LINK";
//		$arr_sql[] = "insert into " . $tableName .
//			"(col_p_objid,col_s_classid,col_s_objid,col_style,col_isref,col_reltype) " .
//			" values(" . $target_id. "," . $doc_type. "," . $doc_id . ",0,0,0)" ;
		$fields = $this -> get_fields_child($doc_type,$root_id,'') ;
		$row = $this -> get_detail($doc_type,$doc_id,$fields);
		if ($this -> exist_name($doc_type,$target_id,$doc_type,$row["col_name"]))
			return 0 ;
		switch($doc_type)
		{
			case DOC_ROOT:case DOC_VFOLDER:
				$arr_sql[] = "update PtpFolder set ParentID='".$target_id."',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where PtpFolderID='" . $doc_id  . "' and MyID='".getValue("myid")."'";
				break ;
			default:
				$arr_sql[] = "update PtpFile set PtpFolderID='".$target_id."',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where Msg_ID='". $doc_id . "'";
				break ;
		}
//			echo var_dump($arr_sql);
//			exit();

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}
	
	function istop($file_type,$doc_id)
	{
		$arr_sql = array();


		
		switch (DB_TYPE)
		{
			case "access":
				switch ($file_type) {
					case 1 :
					$arr_sql[] = "update OnlineHeat set IsTop=iif(IsTop,0,1) where MyID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
						break;
					case 2 :
					$arr_sql[] = "update OnlineFile set IsTop=iif(IsTop,0,1) where OnlineID=" . $doc_id;
						break;
					case 3 :
					$arr_sql[] = "update OnlineForm set IsTop=iif(IsTop,0,1) where UserID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
						break;	
				}
				break ;
			default:
				switch ($file_type) {
					case 1 :
					$arr_sql[] = "update OnlineHeat set IsTop=case when IsTop=0 then 1 else 0 end where MyID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
						break;
					case 2 :
					$arr_sql[] = "update OnlineFile set IsTop=case when IsTop=0 then 1 else 0 end where OnlineID=" . $doc_id;
						break;
					case 3 :
					$arr_sql[] = "update OnlineForm set IsTop=case when IsTop=0 then 1 else 0 end where UserID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
						break;	
				}
				break;
		}
		

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//删除离线文件
	////////////////////////////////////////////////////////////////////////////////////////////////
	function delete_db1($Msg_ID)
	{
		//删除数据
//		$data = $this -> db -> executeDataRow("select * from LeaveFile where Msg_ID='" . $Msg_ID . "'");
//		if (count($data)){
//			$root_dir = $this -> get_root_dir(4,$data["userid2"]) ;
//			file_delete($root_dir . "/" . $data["typepath"]);
//		}
		
		$arr_sql = array();
		$arr_sql[] = " delete from LeaveFile where Msg_ID='" . $Msg_ID . "'" ;
		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}
	
	function delete_db3($Msg_ID)
	{
		//删除数据
		$data = $this -> db -> executeDataRow("select * from ClotFile where Msg_ID='" . $Msg_ID . "'");
		if (count($data)){
			$root_dir = $this -> get_root_dir(6,$data["clotid"]) ;
			//file_delete($root_dir["default_dir"] . "/" . $data["typepath"]);
		}
		
		$arr_sql = array();
		$arr_sql[] = " delete from ClotFile where Msg_ID='" . $Msg_ID . "'" ;

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}
	
	function delete_db2($doc_id,$file_type)
	{
		//删除数据
		$arr_sql = array();
		switch ($file_type) {
			case 1 :
			$arr_sql[] = "delete from OnlineHeat where MyID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
				break;
			case 2 :
			$data = $this -> db -> executeDataRow("select * from OnlineFile where OnlineID=" . $doc_id);
			if (count($data)){
				if(substr($data["filpath"],0,10)=="OnlineFile"){
				$default_dir = RTC_CONSOLE . "/" . $data["filpath"] ;
				//file_delete($default_dir);
				}
			}
			$sql = "Select * from OnlineRevisedFile where OnlineID=" . $doc_id ;
			$data = $this -> db -> executeDataTable($sql) ;
			foreach($data as $row){
				$default_dir = RTC_CONSOLE . "/" . $row["filpath"] ;
				//file_delete($default_dir);
			}
			$arr_sql[] = "delete from OnlineHeat where OnlineID=" . $doc_id;
			$arr_sql[] = "delete from OnlineForm where OnlineID=" . $doc_id;
			$arr_sql[] = "delete from OnlineFile where FormFileType=7 and OnlineID=" . $doc_id;
			$arr_sql[] = "delete from OnlineRevisedFile where OnlineID=" . $doc_id;
				break;
			case 3 :
			$arr_sql[] = "delete from OnlineForm where UserID='".CurUser::GetUserId()."' and OnlineID=" . $doc_id;
				break;	
		}
//		echo var_dump($arr_sql);
//		exit();

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//删除文件或文件夹 (包括子孙)
	////////////////////////////////////////////////////////////////////////////////////////////////
	function delete($doc_type,$doc_id,$root_id)
	{
		//得到自己
		$data = $this -> get_child_data($doc_type,$doc_id,$root_id,1,1) ;
		
        $antLog = new AntLog();
		foreach($data as $row)
		{
			if (count($row) ==0)
				continue ;
			$id = $row["col_id"] ;
			$curr_type = $row["col_doctype"] ;
			$curr_id = $row["col_id"] ;
			$root_id = $row["col_rootid"] ;
			$name = $row["col_name"] ;

			
			if ($curr_type == DOC_FILE)
			{
				$root_dir = $this -> get_root_dir(0,$root_id) ;
				$antLog->log(CurUser::getUserName().get_lang("class_doc_warning3").$root_dir["default_dir"] . "/" . $name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
				//file_delete($root_dir["default_dir"] . "/" . $name);
			}
			elseif ($curr_type == DOC_VFOLDER){
				$root_dir = $this -> get_root_dir(0,$curr_id) ;
				$antLog->log(CurUser::getUserName().get_lang("class_doc_warning16").$root_dir["default_dir"],CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);
				//
				//@rmdir(iconv_str($root_dir["default_dir"],"utf-8","gbk"));
			}

			//删除数据
			$this -> delete_db($curr_type,$curr_id,$id);

		    //$antLog->log(CurUser::getUserName().get_lang("class_doc_warning3").$name,CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],23);

		}
//					exit();

	}

	function delete_db($doc_type,$doc_id,$id)
	{
		//删除数据
		$arr_sql = array();
		if($doc_type==DOC_FILE){
			$where="ID=". $id;
		}else{
			$where="PtpFolderID='".$id."'";
		}
		$arr_sql[] = " delete from " . (DOC::get_table_obj($doc_type)) . " where " . $where ;
//		echo " delete from " . (DOC::get_table_obj($doc_type)) . " where ID=" . $id;
//		exit();

		if ($doc_type != DOC_FILE)
		{
			//ROOT
			$arr_sql[] = " delete from PtpForm where MyID='".getValue("myid")."' and PtpFolderID='" . $doc_id . "'" ;	//删除下级关系
		}
//		else
//		{
//			if ($doc_type == DOC_VFOLDER)
//				" delete from TAB_DOC_VFOLDER_LINK where col_p_objid=" . $doc_id ;	//删除下级关系
//
//			//FOLDER
//			$arr_sql[] = " delete from TAB_DOC_VFOLDER_LINK where col_s_objid=" . $doc_id . " and col_s_classid=" . $curr_type ; //删除上级关系
//			$arr_sql[] = " delete from TAB_DOC_ROOT_LINK where col_s_objid=" . $doc_id . " and col_s_classid=" . $curr_type ; //删除上级关系
//		}
//			foreach($arr_sql as $sql){
//				recordLog($sql . ";");
//				echo $sql;
////				exit();
//			}

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//删除文件或文件夹 (包括子孙)
	////////////////////////////////////////////////////////////////////////////////////////////////
	function save($doc_type,$doc_id,$root_id,$target_id,$FileState)
	{
		//得到自己
		$data = $this -> get_child_data($doc_type,$doc_id,$root_id,1,1) ;

        //$doc_dir = new DocDir();
		//$doc = new Doc();
		$this -> save_db($data,$root_id,$target_id,$FileState);
//echo var_dump($data);
//exit();
//					exit();

	}

	function save_db($data,$root_id,$parentId,$FileState)
	{
		$antLog = new AntLog();
		foreach($data as $row)
		{
			if (count($row) ==0)
				continue ;
			if ($row["col_state"]==0)
				continue ;
				$id = $row["col_id"] ;
				$curr_type = $row["col_doctype"] ;
				$curr_id = $row["col_id"] ;
				$rootid = (int)$row["col_rootid"] ;
				if(!$rootid) $rootid = 0 ;
				$name = $row["col_name"] ;
//				echo $this -> exist_name1($curr_type,$parentId,$curr_type,$name);
//				exit();
			if ($this -> exist_name1($curr_type,$parentId,$curr_type,$name))
				break ;
//				echo $rootid ."|". $root_id;
//				exit();
			if ($rootid == $root_id){
				$antLog->log(CurUser::getUserName().get_lang("class_doc_warning4").$name.get_lang("class_doc_warning5"),CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],21);
				switch($curr_type)
				{
					case DOC_ROOT:case DOC_VFOLDER:
						$result = $this -> doc_dir -> insert($curr_type,$parentId,$name,CurUser::getUserId());
						$this -> save_db($data,$id,$result["ptpfolderid"],$FileState);
						break ;
					default:
						$this -> save_file1($row["col_target"],$name,$row["pcsize"],DOC_VFOLDER,$parentId,$rootid,$FileState);
						break ;
				}
			}
		}


		//return $this -> db -> execute($arr_sql) > 0 ?1:0 ;
	}

	function list_root($root_type,$sortby = "UsName")
	{
//		if ($root_type == 3)
//		{
//			$root_id =  $this -> get_person_rootid();
//			return $this -> list_folder(DOC_ROOT,$root_id,$root_id);
//		}
		// list root
		$sql = "" ;
		if ($root_type == 1)
			$sql = "MyID='Public'" ;
		elseif ($root_type == 3)
			$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
		else
		    $sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
		if($sortby==2){
			$sortby = "A.UsName" ;
		}else{
			$sortby = "A.ToDate desc" ;
		}
		$sql = " select " . ($this -> get_fields_list(DOC_ROOT)) . " from PtpFolder A where " . $sql ;
		$sql = $sql . " and ParentID='0' order by MyID desc," . $sortby ;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql);

		return $data;
	}

	function list_folder($parent_type,$parent_id,$root_type,$root_id,$sortby = "UsName")
	{
		if ($root_type == 1)
			$sql = "MyID='Public'" ;
		elseif ($root_type == 3)
			$sql = "MyID='".CurUser::getUserId()."'and To_Type=3" ;
		else
		    $sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
		if($sortby==2){
			$sortby = "A.UsName" ;
		}else{
			$sortby = "A.ToDate desc" ;
		}
		$sql = " select " . ($this -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A where ".$sql." and ParentID='" . $parent_id . "' order by " . $sortby;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql);
		return $data;
	}

	function list_file($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{

		$sql = "" ;
//		if ((int)$parent_id)
//		{
//			// 按目录
//			if ($root_type == 1)
//				$sql = "MyID='Public'" ;
//			elseif ($root_type == 3)
//				$sql = "MyID='".CurUser::getUserId()."'" ;
//			else
//				$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
//			$sql = "where ". $sql . " and PtpFolderID='" . $parent_id . "' and FileState=1" ;
//
//		}
//		else
//		{
			//按类型
			if ($file_type)
			{
				if ($root_type == 1)
					$sql = "MyID='Public'" ;
				elseif ($root_type == 3)
					$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
				else
					$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;

				switch ($file_type) {
					case 1 :
				    $sql = "where ". $sql . " and (TypePath like '%.doc' or TypePath like '%.docx' or TypePath like '%.xls' or TypePath like '%.xlsx' or TypePath like '%.ppt' or TypePath like '%.pptx' or TypePath like '%.wps' or TypePath like '%.et' or TypePath like '%.dps' or TypePath like '%.pdf' or TypePath like '%.txt') and FileState=1" ;
						break;
					case 2 :
				    $sql = "where ". $sql . " and (TypePath like '%.bmp' or TypePath like '%.jpeg' or TypePath like '%.gif' or TypePath like '%.jpg' or TypePath like '%.png' or TypePath like '%.ico') and FileState=1" ;
						break;
					case 3 :
				    $sql = "where ". $sql . " and (TypePath like '%.mp3' or TypePath like '%.wav' or TypePath like '%.asf' or TypePath like '%.aac' or TypePath like '%.vqf' or TypePath like '%.wma') and FileState=1" ;
						break;	
					case 4 :
				    $sql = "where ". $sql . " and (TypePath like '%.rm' or TypePath like '%.rmvb' or TypePath like '%.wmv' or TypePath like '%.avi' or TypePath like '%.mp4' or TypePath like '%.3gp' or TypePath like '%.mkv' or TypePath like '%.mov') and FileState=1" ;
						break;
				}
				
			}
			else
			{
				if ($root_type == 1)
					$sql = "MyID='Public'" ;
				elseif ($root_type == 3)
					$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
				else
					$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
				$sql = "where ". $sql . " and PtpFolderID='" . $parent_id . "' and FileState=1" ;
			}

//		}

		$sql_count = " select count(*) as c from PtpFile A " . $sql ;
		$count = $this -> db -> executeDataValue($sql_count);
		
//		$sql_list = " select " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A " . $sql . " order by " . $sortby;
//		
////		echo $sql_list;
////		exit();
//		$data = $this -> db -> page($sql_list,$pageindex,$pagesize,$count);
		
		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_name Desc" ;
			$sortbydesc = "col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_dt_create ASC" ;
			$sortbydesc = "col_dt_create Desc" ;
		}

		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
//		echo $sql_list;
//		exit();
		$data = $this -> db -> executeDataTable($sql_list) ;

//		foreach($data as $k=>$v){
//			//$data[$k]['col_name']=phpescape($data[$k]['col_name']);
//			$data[$k]['col_name'] = str_replace("月-","月到",$data[$k]['col_name']) ;
//			}


		return array("data"=>$data,"count"=>$count);
	}
	
	function list_folder10($parent_type,$parent_id,$root_type,$root_id,$sortby = "UsName")
	{
		if ($root_type == 1)
			$sql = "MyID='Public'" ;
		elseif ($root_type == 3)
			$sql = "MyID='".CurUser::getUserId()."'and To_Type=3" ;
		elseif ($root_type == 2)
			$sql = "MyID='".CurUser::getUserId()."' and To_Type=2" ;
		else
		    $sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
		if($sortby==2){
			$sortby = "A.UsName" ;
		}else{
			$sortby = "A.ToDate desc" ;
		}
		$sql = " select " . ($this -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A where ".$sql." and ParentID='" . $parent_id . "' order by " . $sortby;

		$data = $this -> db -> executeDataTable($sql);
		if ($root_type == 1){
			foreach($data as $k=>$v){
				if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_id'],0)) unset($data[$k]);
			}
		}
		return array_values($data);
	}

	function list_file10($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{

		$sql = "" ;
			//按类型
			if ($file_type)
			{
				$display=1;
				if(PUBLICDOCUMENTS){
					$display=0;
					$db2 = new DB();
					$sql = "select LoginName from lv_chater_notice where TypeID=4";	
					$data2 = $db2 -> executeDataTable($sql);
					foreach($data2 as $value){
						 if(in_array(CurUser::getUserName(), $value)) $display=1;
					}
				}
				if($display) $sql = "MyID='Public' or " ;
				if ($root_type == 1){
					if(!$display) return array("data"=>array(),"count"=>0,"pageindex"=>$pageindex);
					$sql = "MyID='Public'" ;
				}elseif ($root_type == 3)
					$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
				elseif ($root_type == 2)
					$sql = "MyID='".CurUser::getUserId()."' and To_Type=2" ;
				else
					$sql = "(". $sql . "MyID='".CurUser::getUserId()."')" ;
				
//				if ($root_type == 1)
//					$sql = "MyID='Public'" ;
//				elseif ($root_type == 3)
//					$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
//				elseif ($root_type == 2)
//					$sql = "MyID='".CurUser::getUserId()."' and To_Type=2" ;
//				else
//					$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;

				switch ($file_type) {
					case 1 :
				    $sql = "where ". $sql . " and (TypePath like '%.doc' or TypePath like '%.docx' or TypePath like '%.xls' or TypePath like '%.xlsx' or TypePath like '%.ppt' or TypePath like '%.pptx' or TypePath like '%.wps' or TypePath like '%.et' or TypePath like '%.dps' or TypePath like '%.pdf' or TypePath like '%.txt') and FileState=1" ;
						break;
					case 2 :
				    $sql = "where ". $sql . " and (TypePath like '%.bmp' or TypePath like '%.jpeg' or TypePath like '%.gif' or TypePath like '%.jpg' or TypePath like '%.png' or TypePath like '%.ico') and FileState=1" ;
						break;
					case 3 :
				    $sql = "where ". $sql . " and (TypePath like '%.mp3' or TypePath like '%.wav' or TypePath like '%.asf' or TypePath like '%.aac' or TypePath like '%.vqf' or TypePath like '%.wma') and FileState=1" ;
						break;	
					case 4 :
				    $sql = "where ". $sql . " and (TypePath like '%.rm' or TypePath like '%.rmvb' or TypePath like '%.wmv' or TypePath like '%.avi' or TypePath like '%.mp4' or TypePath like '%.3gp' or TypePath like '%.mkv' or TypePath like '%.mov') and FileState=1" ;
						break;
					case 5 :
				    $sql = "where ". $sql . " and not (TypePath like '%.doc' or TypePath like '%.docx' or TypePath like '%.xls' or TypePath like '%.xlsx' or TypePath like '%.ppt' or TypePath like '%.pptx' or TypePath like '%.wps' or TypePath like '%.et' or TypePath like '%.dps' or TypePath like '%.pdf' or TypePath like '%.txt' and TypePath like '%.bmp' or TypePath like '%.jpeg' or TypePath like '%.gif' or TypePath like '%.jpg' or TypePath like '%.png' or TypePath like '%.ico' and TypePath like '%.rm' or TypePath like '%.rmvb' or TypePath like '%.wmv' or TypePath like '%.avi' or TypePath like '%.mp4' or TypePath like '%.3gp' or TypePath like '%.mkv' or TypePath like '%.mov' and TypePath like '%.mp3' or TypePath like '%.wav' or TypePath like '%.asf' or TypePath like '%.aac' or TypePath like '%.vqf' or TypePath like '%.wma') and FileState=1" ;
						break;
				}
				
			}
			else
			{
				if ($root_type == 1)
					$sql = "MyID='Public'" ;
				elseif ($root_type == 3)
					$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
				elseif ($root_type == 2){
				    if(g("filetype")!="2") $sql = "MyID='".CurUser::getUserId()."' and " ;
					$sql .= "To_Type=2" ;
				}else
					$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
				$sql = "where ". $sql . " and PtpFolderID='" . $parent_id . "' and FileState=1" ;
			}

//		}

		$sql_count = " select count(*) as c from PtpFile A " . $sql ;
		$count = $this -> db -> executeDataValue($sql_count);

		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_name Desc" ;
			$sortbydesc = "col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_dt_create ASC" ;
			$sortbydesc = "col_dt_create Desc" ;
		}

		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
		$data = $this -> db -> executeDataTable($sql_list) ;


//					foreach($data as $k=>$v){
//						//$data[$k]['col_name']=phpescape($data[$k]['col_name']);
//						$data[$k]['col_name'] = str_replace("月-","月到",$data[$k]['col_name']) ;
//						}
		
		if ($root_type == 1){
			if ($file_type)
			{
					foreach($data as $k=>$v){
						$display=1;
						if(PUBLICDOCUMENTS_VIEW){
							if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0)){
								 $display=0;
								 unset($data[$k]);
							}
						}
						if($display){
							$pathdata = array ();
							$path_data = $this -> get_path_data(DOC_FILE,$data[$k]['col_rootid']);
							if (count($path_data)>0)
							{
								$node = $path_data[count($path_data)-1] ;
								$rootid = $node["col_id"] ;
							}
							foreach(array_reverse($path_data) as $node)
							{
								array_push($pathdata,array("doc_type"=> DOC_VFOLDER,"doc_id"=> $node["col_id"],"root_id"=> $rootid));
							}
							$data[$k]['pathdata']=json_encode($pathdata);
							//$data[$k]['pathdata1']=!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0);
						}
					}
					if(PUBLICDOCUMENTS_VIEW&&$count&&($row2<$count)&&empty($data)) return $this -> list_file10($parent_type,$parent_id,$root_type,$root_id,$file_type,g("sortby","ID desc"),$pageindex+1,$pagesize);
			}
		}
		return array("data"=>array_values($data),"count"=>$count,"pageindex"=>$pageindex);
	}
	
	function list_file18($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{

		$sql1 = "where MyID='Public' and ParentID='" . $parent_id . "'" ;
		$sql = "where MyID='Public' and PtpFolderID='" . $parent_id . "' and FileState=1" ;


		$sql_count1 = " select count(*) as c from PtpFolder A " . $sql1 ;
		$sql_count = " select count(*) as c from PtpFile A " . $sql ;
		$count1 = $this -> db -> executeDataValue($sql_count1);
		$count = $count1 + $this -> db -> executeDataValue($sql_count);
		
		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_doctype ASC,col_name Desc" ;
			$sortbydesc = "col_doctype desc,col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_doctype ASC,col_dt_create ASC" ;
			$sortbydesc = "col_doctype desc,col_dt_create desc" ;
		}

		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " * FROM (select " . ($this -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A "  . $sql1 . " union all select " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql . ") C order by " . $sortbydesc . ") D order by " . $sortbyasc . ") E order by " . $sortbydesc;
		$data = $this -> db -> executeDataTable($sql_list) ;
		
		foreach($data as $k=>$v){
			if ($data[$k]['col_doctype'] == DOC_VFOLDER){
				if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_id'],0)) unset($data[$k]);
			}
		}
		if($count&&($row2<$count)&&empty($data)) return $this -> list_file18($parent_type,$parent_id,$root_type,$root_id,$file_type,g("sortby","ID desc"),$pageindex+1,$pagesize);
		return array("data"=>array_values($data),"count"=>$count,"pageindex"=>$pageindex);
	}

	function doc_list_recent1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{
		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_name Desc" ;
			$sortbydesc = "col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_dt_create ASC" ;
			$sortbydesc = "col_dt_create Desc" ;
		}
		$display=1;
		if(PUBLICDOCUMENTS){
			$display=0;
			$db2 = new DB();
			$sql = "select LoginName from lv_chater_notice where TypeID=4";	
			$data2 = $db2 -> executeDataTable($sql);
			foreach($data2 as $value){
				 if(in_array(CurUser::getUserName(), $value)) $display=1;
			}
		}

		$doc = new DOC();
		if($display) $sql_where = "MyID='Public' or " ;
		$sql_where = "where (". $sql_where . "MyID='".CurUser::getUserId()."') and To_Type<>2 and FileState=1" ;

 		$sql_count = " select count(*) as c from PtpFile A "  . $sql_where ;
		$count = $this -> db -> executeDataValue($sql_count);
		
		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql_where . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
		$data = $this -> db -> executeDataTable($sql_list) ;
		setValue("myid","Public");
		foreach($data as $k=>$v){
			if ($data[$k]['to_type'] == 1){
				$display=1;
				if(PUBLICDOCUMENTS_VIEW){
					if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0)){
						 $display=0;
						 unset($data[$k]);
					}
				}
				if($display){
					$pathdata = array ();
					$path_data = $this -> get_path_data(DOC_FILE,$data[$k]['col_rootid']);
					if (count($path_data)>0)
					{
						$node = $path_data[count($path_data)-1] ;
						$root_id = $node["col_id"] ;
					}
					foreach(array_reverse($path_data) as $node)
					{
						array_push($pathdata,array("doc_type"=> DOC_VFOLDER,"doc_id"=> $node["col_id"],"root_id"=> $root_id));
					}
					$data[$k]['pathdata']=json_encode($pathdata);
					//$data[$k]['pathdata1']=!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0);
				}
			}
		}
//		echo var_dump($data);
//		exit();
		if(PUBLICDOCUMENTS_VIEW&&$count&&($row2<$count)&&empty($data)) return $this -> doc_list_recent1($parent_type,$parent_id,$root_type,$root_id,$file_type,g("sortby","ID desc"),$pageindex+1,$pagesize);
		return array("data"=>array_values($data),"count"=>$count,"pageindex"=>$pageindex);
	}
	
	function doc_list_search1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{
		Global $printer;
		
		$sql_where = "" ;
		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_name Desc" ;
			$sortbydesc = "col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_dt_create ASC" ;
			$sortbydesc = "col_dt_create Desc" ;
		}

		$display=1;
		if(PUBLICDOCUMENTS){
			$display=0;
			$db2 = new DB();
			$sql = "select LoginName from lv_chater_notice where TypeID=4";	
			$data2 = $db2 -> executeDataTable($sql);
			foreach($data2 as $value){
				 if(in_array(CurUser::getUserName(), $value)) $display=1;
			}
		}

		$count = 0 ;
		$key = g("key") ;
//		if($display) $sql_where = "MyID='Public' or " ;
//		$sql_where = "where (". $sql_where . "MyID='".CurUser::getUserId()."') and To_Type<>2 and FileState=1" ;
		
		if($display) $sql_where = "MyID='Public' or " ;
		if ($root_type == 1){
			if(!$display) return array("data"=>array(),"count"=>0,"pageindex"=>$pageindex);
			$sql_where = "MyID='Public'" ;
		}elseif ($root_type == 3)
			$sql_where = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
		elseif ($root_type == 2)
			$sql_where = "MyID='".CurUser::getUserId()."' and To_Type=2" ;
		else
			$sql_where = "(". $sql_where . "MyID='".CurUser::getUserId()."')" ;
			
		$sql_where = "where ". $sql_where . " and FileState=1" ;
							
		if ($key)
		{
			$doc = new DOC();
			if($parent_id){
				$PtpFolderIDs=$parent_id;
				$this->get_an_ptpfolder(0, $parent_id);
				if(count($this->temp)>0)
				{
					foreach ($this->temp as $row)
					{
						if($PtpFolderIDs)
							$PtpFolderIDs .= "," . $row['empid'];
						else
							$PtpFolderIDs = $row['empid'];
					}
				}
				if($PtpFolderIDs) $sql_where = $doc -> db -> addWhere($sql_where,"PtpFolderID in (" . $PtpFolderIDs . ")");
			}
			$sql_where = $doc -> db -> addWhere($sql_where,"TypePath like '%" . $key . "%'");
	
			$sql_count = " select count(*) as c from PtpFile A "  . $sql_where ;
			$count = $doc -> db -> executeDataValue($sql_count);
			
			$row1 = ($pageindex - 1) * $pagesize ;
			$row2 = $row1 + $pagesize ;
			if($row2>$count) $pagesize=$count-$row1;
			
			$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($doc -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql_where . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
//			echo $sql_list;
//			exit();
			$data = $doc -> db -> executeDataTable($sql_list) ;
			setValue("myid","Public");
			foreach($data as $k=>$v){
				if ($data[$k]['to_type'] == 1){
					$display=1;
					if(PUBLICDOCUMENTS_VIEW){
						if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0)){
							 $display=0;
							 unset($data[$k]);
						}
					}
					if($display){
						$pathdata = array ();
						$path_data = $this -> get_path_data(DOC_FILE,$data[$k]['col_rootid']);
						if (count($path_data)>0)
						{
							$node = $path_data[count($path_data)-1] ;
							$root_id = $node["col_id"] ;
						}
						foreach(array_reverse($path_data) as $node)
						{
							array_push($pathdata,array("doc_type"=> DOC_VFOLDER,"doc_id"=> $node["col_id"],"root_id"=> $root_id));
						}
						$data[$k]['pathdata']=json_encode($pathdata);
						//$data[$k]['pathdata1']=!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0);
					}
				}
			}
			if(PUBLICDOCUMENTS_VIEW&&$count&&($row2<$count)&&empty($data)) return $this -> doc_list_search1($parent_type,$parent_id,$root_type,$root_id,$file_type,g("sortby","ID desc"),$pageindex+1,$pagesize);
		}
		else
		{
			$data_file = array();
		}
		return array("data"=>array_values($data),"count"=>$count,"pageindex"=>$pageindex);
	}
	
	function doc_list_search2($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{

		$sql = "" ;
		$key = g("key") ;
			//按类型
		if ($key)
		{
			$display=1;
			if(PUBLICDOCUMENTS){
				$display=0;
				$db2 = new DB();
				$sql = "select LoginName from lv_chater_notice where TypeID=4";	
				$data2 = $db2 -> executeDataTable($sql);
				foreach($data2 as $value){
					 if(in_array(CurUser::getUserName(), $value)) $display=1;
				}
			}
			if($display) $sql = "MyID='Public' or " ;
			if ($root_type == 1){
				if(!$display) return array("data"=>array(),"count"=>0,"pageindex"=>$pageindex);
				$sql = "MyID='Public'" ;
			}elseif ($root_type == 3)
				$sql = "MyID='".CurUser::getUserId()."' and To_Type=3" ;
			elseif ($root_type == 2)
				$sql = "MyID='".CurUser::getUserId()."' and To_Type=2" ;
			else
				$sql = "(". $sql . "MyID='".CurUser::getUserId()."')" ;
	
			$sql = "where ". $sql . " and TypePath like '%" . $key . "%' and FileState=1" ;
	
//			$doc = new DOC();
//			if($parent_id){
//				$PtpFolderIDs=$parent_id;
//				$this->get_an_ptpfolder(0, $parent_id);
//				if(count($this->temp)>0)
//				{
//					foreach ($this->temp as $row)
//					{
//						if($PtpFolderIDs)
//							$PtpFolderIDs .= "," . $row['empid'];
//						else
//							$PtpFolderIDs = $row['empid'];
//					}
//				}
//				if($PtpFolderIDs) $sql = $doc -> db -> addWhere($sql,"PtpFolderID in (" . $PtpFolderIDs . ")");
//			}
			
			$sql_count = " select count(*) as c from PtpFile A " . $sql ;
			$count = $this -> db -> executeDataValue($sql_count);
	
			if($sortby==2){
				$sortby = "A.TypePath" ;
				$sortbyasc = "col_name Desc" ;
				$sortbydesc = "col_name ASC" ;
			}else{
				$sortby = "A.ToDate desc" ;
				$sortbyasc = "col_dt_create ASC" ;
				$sortbydesc = "col_dt_create Desc" ;
			}
	
			$row1 = ($pageindex - 1) * $pagesize ;
			$row2 = $row1 + $pagesize ;
			if($row2>$count) $pagesize=$count-$row1;
			
			$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
			$data = $this -> db -> executeDataTable($sql_list) ;
			
			if ($root_type == 1){
				foreach($data as $k=>$v){
					$display=1;
					if(PUBLICDOCUMENTS_VIEW){
						if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0)){
							 $display=0;
							 unset($data[$k]);
						}
					}
					if($display){
						$pathdata = array ();
						$path_data = $this -> get_path_data(DOC_FILE,$data[$k]['col_rootid']);
						if (count($path_data)>0)
						{
							$node = $path_data[count($path_data)-1] ;
							$rootid = $node["col_id"] ;
						}
						foreach(array_reverse($path_data) as $node)
						{
							array_push($pathdata,array("doc_type"=> DOC_VFOLDER,"doc_id"=> $node["col_id"],"root_id"=> $rootid));
						}
						$data[$k]['pathdata']=json_encode($pathdata);
						//$data[$k]['pathdata1']=!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_rootid'],0);
					}
				}
				if(PUBLICDOCUMENTS_VIEW&&$count&&($row2<$count)&&empty($data)) return $this -> doc_list_search2($parent_type,$parent_id,$root_type,$root_id,$file_type,g("sortby","ID desc"),$pageindex+1,$pagesize);
			}
			
		}
		return array("data"=>array_values($data),"count"=>$count,"pageindex"=>$pageindex);
	}


	function list_root0($root_type,$sortby = "UsName")
	{
//		if ($root_type == 3)
//		{
//			$root_id =  $this -> get_person_rootid();
//			return $this -> list_folder(DOC_ROOT,$root_id,$root_id);
//		}

		// list root
		$sql = "" ;
		if ($root_type == 1)
			$sql = "MyID='Public'" ;
		elseif ($root_type == 3)
			$sql = "MyID='".getValue("myid")."' and To_Type=3" ;
		else
		    $sql = "(MyID='Public' or MyID='".getValue("myid")."')" ;
		if($sortby==2){
			$sortby = "A.UsName" ;
		}else{
			$sortby = "A.ToDate desc" ;
		}
		$sql = " select " . ($this -> get_fields_list(DOC_ROOT)) . " from PtpFolder A where " . $sql ;
		$sql = $sql . " and ParentID='0' order by MyID desc," . $sortby ;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql);

		return $data;
	}

	function list_folder0($parent_type,$parent_id,$root_type,$root_id,$sortby = "UsName")
	{
		if ($root_type == 1)
			$sql = "MyID='Public'" ;
		elseif ($root_type == 3)
			$sql = "MyID='".getValue("myid")."'and To_Type=3" ;
		else
		    $sql = "(MyID='Public' or MyID='".getValue("myid")."')" ;
		if($sortby==2){
			$sortby = "A.UsName" ;
		}else{
			$sortby = "A.ToDate desc" ;
		}
		$sql = " select " . ($this -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A where ".$sql." and ParentID='" . $parent_id . "' order by " . $sortby;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql);
		return $data;
	}

	function list_file0($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{

		$sql = "" ;
//		if ((int)$parent_id)
//		{
//			// 按目录
//			if ($root_type == 1)
//				$sql = "MyID='Public'" ;
//			elseif ($root_type == 3)
//				$sql = "MyID='".CurUser::getUserId()."'" ;
//			else
//				$sql = "(MyID='Public' or MyID='".CurUser::getUserId()."')" ;
//			$sql = "where ". $sql . " and PtpFolderID='" . $parent_id . "' and FileState=1" ;
//
//		}
//		else
//		{
			//按类型
			if ($file_type)
			{
				if ($root_type == 1)
					$sql = "MyID='Public'" ;
				elseif ($root_type == 3)
					$sql = "MyID='".getValue("myid")."' and To_Type=3" ;
				else
					$sql = "(MyID='Public' or MyID='".getValue("myid")."')" ;

				switch ($file_type) {
					case 1 :
				    $sql = "where ". $sql . " and (TypePath like '%.doc' or TypePath like '%.docx' or TypePath like '%.xls' or TypePath like '%.xlsx' or TypePath like '%.ppt' or TypePath like '%.pptx' or TypePath like '%.wps' or TypePath like '%.et' or TypePath like '%.dps' or TypePath like '%.pdf' or TypePath like '%.txt') and FileState=1" ;
						break;
					case 2 :
				    $sql = "where ". $sql . " and (TypePath like '%.bmp' or TypePath like '%.jpeg' or TypePath like '%.gif' or TypePath like '%.jpg' or TypePath like '%.png' or TypePath like '%.ico') and FileState=1" ;
						break;
					case 3 :
				    $sql = "where ". $sql . " and (TypePath like '%.mp3' or TypePath like '%.wav' or TypePath like '%.asf' or TypePath like '%.aac' or TypePath like '%.vqf' or TypePath like '%.wma') and FileState=1" ;
						break;	
					case 4 :
				    $sql = "where ". $sql . " and (TypePath like '%.rm' or TypePath like '%.rmvb' or TypePath like '%.wmv' or TypePath like '%.avi' or TypePath like '%.mp4' or TypePath like '%.3gp' or TypePath like '%.mkv' or TypePath like '%.mov') and FileState=1" ;
						break;
				}
				
			}
			else
			{
				if ($root_type == 1)
					$sql = "MyID='Public'" ;
				elseif ($root_type == 3)
					$sql = "MyID='".getValue("myid")."' and To_Type=3" ;
				else
					$sql = "(MyID='Public' or MyID='".getValue("myid")."')" ;
				$sql = "where ". $sql . " and PtpFolderID='" . $parent_id . "' and FileState=1" ;
			}

//		}

		$sql_count = " select count(*) as c from PtpFile A " . $sql ;
		$count = $this -> db -> executeDataValue($sql_count);
		
//		$sql_list = " select " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A " . $sql . " order by " . $sortby;
//		
////		echo $sql_list;
////		exit();
//		$data = $this -> db -> page($sql_list,$pageindex,$pagesize,$count);


		if($sortby==2){
			$sortby = "A.TypePath" ;
			$sortbyasc = "col_name Desc" ;
			$sortbydesc = "col_name ASC" ;
		}else{
			$sortby = "A.ToDate desc" ;
			$sortbyasc = "col_dt_create ASC" ;
			$sortbydesc = "col_dt_create Desc" ;
		}

		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A "  . $sql . "   order by  " . $sortby . ") B order by " . $sortbyasc . ") C order by " . $sortbydesc;
//		echo $sql_list;
//		exit();
		$data = $this -> db -> executeDataTable($sql_list) ;

//		foreach($data as $k=>$v){
//			//$data[$k]['col_name']=phpescape($data[$k]['col_name']);
//			$data[$k]['col_name'] = str_replace("月-","月到",$data[$k]['col_name']) ;
//			}


		return array("data"=>$data,"count"=>$count);
	}


	function list_file1($parent_type,$parent_id,$root_type,$root_id,$file_type,$sortby = "col_name",$pageindex = 1,$pagesize = 20)
	{
		//按类型
		switch ($file_type) {
			case 1 :
		    $sql_count = " select count(*) as c from OnlineHeat where MyID='".CurUser::getUserId()."'" ;
			break;
			case 2 :
			$sql_count = " select count(*) as c from OnlineFile where MyID='".CurUser::getUserId()."'" ;
			break;
			case 3 :
			$sql_count = " select count(*) as c from OnlineForm where UserID='".CurUser::getUserId()."'" ;
			break;
		}
		$count = $this -> db -> executeDataValue($sql_count);
		
		$row1 = ($pageindex - 1) * $pagesize ;
		$row2 = $row1 + $pagesize ;
		if($row2>$count) $pagesize=$count-$row1;
		
		switch ($file_type) {
			case 1 :
			$sql_list = "SELECT " .($this -> get_fields_list2(DOC_OnlineFILE)). " from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " * from OnlineHeat where MyID='".CurUser::getUserId()."' order by IsTop desc,ToDate desc) cc order by IsTop asc,ToDate asc) aa,OnlineFile bb where aa.OnlineID=bb.OnlineID order by aa.IsTop desc,aa.ToDate desc" ;
				break;
			case 2 :
			$sql_list = "SELECT " .($this -> get_fields_list2(DOC_OnlineFILE)). " from (SELECT TOP " . $pagesize . " * FROM (SELECT TOP " . $row2  . " * from OnlineFile where MyID='".CurUser::getUserId()."' order by IsTop desc,ToDate desc) cc order by IsTop asc,ToDate asc) bb order by IsTop desc,ToDate desc" ;
				break;
			case 3 :
			$sql_list = "SELECT " .($this -> get_fields_list2(DOC_OnlineFILE)). " from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " * from OnlineForm where UserID='".CurUser::getUserId()."' order by IsTop desc,ToDate desc) cc order by IsTop asc,ToDate asc) aa,OnlineFile bb where aa.OnlineID=bb.OnlineID order by aa.IsTop desc,aa.ToDate desc" ;
				break;	
		}
//		echo $sql_list;
//		exit();
		$data = $this -> db -> executeDataTable($sql_list) ;

		return array("data"=>$data,"count"=>$count);
	}
	
	function list_file2($C_vesr)
	{
		$sql = "Select PtpFolder_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select * from PtpFolder A where (MyID='Public' or MyID='".CurUser::getUserId()."')";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file16($C_vesr)
	{
		$sql = "Select PtpFolder_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select * from PtpFolder A where MyID='".CurUser::getUserId()."' and To_Type=2";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file3($C_vesr)
	{
		$sql = "Select PtpFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select * from PtpFile A where MyID='".CurUser::getUserId()."' and FileState=1";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file14($C_vesr)
	{
		$sql = "Select PtpFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select * from PtpFile A where MyID='".CurUser::getUserId()."' and To_Type=2 and FileState=1";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file15($C_vesr)
	{
		$sql = "Select PtpFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select * from PtpFile A where MyID='".CurUser::getUserId()."' and To_Type=3 and FileState=1";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file8($tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		setValue("myid","Public");
		$data = array();
		$where = stripslashes(" where MyID='Public' and FileState=1");
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
		
//		$sql = " select * from PtpFile A where MyID='Public' and FileState=1";
//		$data = $this -> db -> executeDataTable($sql);
		foreach($data as $k=>$v){
//			$can = DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['ptpfolderid'],0);
//			$data[$k]['can'] = $can ;
			if (!DocAce::can(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['ptpfolderid'],0)) unset($data[$k]);
		}
		return array("data"=>array_values($data),"count"=>$count);
	}
	
	function list_file9($C_vesr)
	{
		$data = array();
//		$sql = " select * from PtpFolderForm A where MyID='Public'";
//		$data = $this -> db -> executeDataTable($sql);
		$ace = new DocAce();
		$data = $ace -> get_all_ace1() ;
		return array("data"=>$data);
	}
	
	function list_file11($root_type)
	{
		$data = array();
		$ace = new DocAce();
		$data1 = $ace -> get_all_ace1() ;
		$data3 = $ace -> get_all_ace();
		return array("data1"=>$data1,"data3"=>$data3);
	}
	
	function list_file17($root_type)
	{
		$data = array();
		$ace = new DocAce();
		$data = $ace -> get_all_ace();
		return array("data"=>$data);
	}
	
	function list_file12($parent_type,$parent_id,$root_type,$root_id,$sortby)
	{
		$data = array();
		$data1 = array();
		$sql = " select " . DOC_ROOT . " as col_doctype,MyID,UserID,PtpFolderID from PtpForm A where UserID='".CurUser::getUserId()."'";
		$data = $this -> db -> executeDataTable($sql);
		foreach($data as $k=>$v){
			$sql = " select " . ($this -> get_fields_list(DOC_VFOLDER,$root_id)) . " from PtpFolder A where PtpFolderID=" . $data[$k]['ptpfolderid'];
			//echo $sql;
			$data_folder = $this -> db -> executeDataTable($sql);
			$data1 = array_merge($data1,$data_folder) ;
		}
		return array("data"=>$data1);
	}
	
	function list_file13($parent_type,$parent_id,$root_type,$root_id,$sortby)
	{
		$data = array();
		$sql = " select " . DOC_ROOT . " as col_doctype,MyID,UserID,PtpFolderID from PtpForm A where (MyID='".CurUser::getUserId()."' and PtpFolderID='".$parent_id."')";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_file4($C_vesr)
	{
		$sql = "Select PtpForm_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = " select " . DOC_ROOT . " as col_doctype,MyID,UserID,PtpFolderID from PtpForm A where (MyID='".CurUser::getUserId()."' or UserID='".CurUser::getUserId()."')";
		$data = $this -> db -> executeDataTable($sql);
		
		foreach($data as $k=>$v){
			if($data[$k]['userid']==CurUser::getUserId()){
			$userid=$data[$k]['myid'];
			$sql = " select * from PtpFolder where MyID='".$userid."'";
			$data_folder = $this -> db -> executeDataTable($sql);
			foreach($data_folder as $k=>$v){
				$data_folder[$k]['col_doctype'] = DOC_VFOLDER ;
			}
			$data = array_merge($data,$data_folder) ;
			$sql = " select * from PtpFile where MyID='".$userid."' and FileState=1";
			$data_file = $this -> db -> executeDataTable($sql);
			foreach($data_file as $k=>$v){
				$data_file[$k]['col_doctype'] = DOC_FILE ;
			}
			$data = array_merge($data,$data_file) ;
			}
		}
		

		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file5($C_vesr)
	{
		$sql = "Select LeaveFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select * from LeaveFile where (UserID1='".CurUser::getUserId()."') or UserID2='".CurUser::getUserId()."'";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file7($YouID,$C_vesr)
	{
		$sql = "Select LeaveFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select * from LeaveFile where (UserID1='".CurUser::getUserId()."' and UserID2='".$YouID."') or (UserID1='".$YouID."' and UserID2='".CurUser::getUserId()."')";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file6($ClotID,$C_vesr)
	{
		$sql = "Select ClotFile_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select * from ClotFile where ClotID='".$ClotID."' and FileState = 1";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//将虚拟的文件生成为实际的文件/文件夹
	////////////////////////////////////////////////////////////////////////////////////////////////
	function bulid_folder($data,$target_folder,$root_dir)
	{
		foreach($data as $row)
		{
			$curr_type = $row["col_doctype"] ;
			$curr_id = $row["col_id"] ;
			$root_id = $row["col_rootid"] ;
			$name = $row["col_name"] ;
			$path = trim($row["col_path"]) ;
			$target = $row["col_target"] ;

			if ($path)
				$path = $path . "/";

			if ($curr_type == DOC_ROOT)
				$name = $this -> format_root_name($name);

			if (($curr_type == DOC_FILE)||($curr_type == DOC_LeaveFile))
			{
				//copy
				$source_file = RTC_CONSOLE . "/" . $target ;
				$target_file = $target_folder . "/" .  $path .  $name ;
//echo $source_file.'|'.$target_file.'<br>';
				file_copy($source_file,$target_file);
			}
			else
			{
				$curr_dir = $target_folder . "/" . $path .  $name ;
//				echo $curr_dir.'<br>';
				mkdirs($curr_dir);
			}

		}

	}



	public $data ;
	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到子孙数据
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_child_data($doc_type,$doc_id,$root_id,$isleep,$isself = 1)
	{
		$this -> data = array();
		$path = "" ;
		if ($isself)
		{
			$fields = $this -> get_fields_child($doc_type,$root_id,'') ;
			$row = $this -> get_detail($doc_type,$doc_id,$fields);

			//修改path
			$name = $row["col_name"] ;

//			if ($doc_type == DOC_ROOT)
//				$name = $this -> format_root_name($name);

			$path = "/" . $name   ;
			$this -> data[] = $row ;
		}

		if ($doc_type == DOC_VFOLDER)
			$this -> get_child_data2($doc_type,$doc_id,$row["col_id"],$path,$isleep);

		return $this -> data ;
	}


	// col_id,col_name,col_doctype,col_rootid,col_target
	function get_child_data2($doc_type,$doc_id,$root_id,$path = '',$isleep = 1)
	{
		$fields_folder = $this -> get_fields_child(DOC_VFOLDER,$root_id) ;
		$data_folder = $this -> relation -> getRelationData($doc_type,$doc_id,DOC_VFOLDER,$fields_folder);
		//echo var_dump($data_folder);
		foreach($data_folder as $row)
		{
			$this -> get_child_data2($row["col_doctype"],$row["col_id"],$row["col_rootid"],$path . "/" . $row["col_name"],$isleep);
			$row["col_path"]=$path;
			$this -> data[] = $row ;
		}
//var_dump($data_folder);
		$fields_file = $this -> get_fields_child(DOC_FILE,$root_id) ;
		$data_file = $this -> relation -> getRelationData($doc_type,$doc_id,DOC_FILE,$fields_file);
		foreach($data_file as $k=>$v){
			$data_file[$k]['col_path']=$path;
		}
//		echo var_dump($data_file);
		$this -> data = array_merge($this -> data,$data_file);

	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到路径
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_path_data($doc_type,$doc_id)
	{
		Global $path;

		$path = array();
		$this -> get_path_data2($doc_type,$doc_id) ;
		return $path ;

	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到路径
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_path_data2($doc_type,$doc_id)
	{
		Global $path;

		//得到VFOLDER关系
		$data = $this -> get_parent_auto($doc_type,$doc_id);
		if (count($data))
		{
			$path[] = $data ;
			$this -> get_path_data2($data["doc_type"],$data["doc_id"]) ;
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到上级结点，自动判断上级结点
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_parent_auto($doc_type,$doc_id)
	{
		$data = $this -> get_parent(DOC_VFOLDER,$doc_type,$doc_id);
		if (count($data))
			return $data ;
		else
			return $this -> get_parent(DOC_ROOT,$doc_type,$doc_id);
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到上级结点，指定上次节点类型
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_parent($parent_type,$doc_type,$doc_id)
	{
		//$table_name = ($parent_type == DOC_ROOT)?"root":"vfolder" ;
		$sql = " select " . $parent_type . " as doc_type,PtpFolderID as col_id, ParentID as doc_id,  UsName as doc_name "  .
				" from PtpFolder where PtpFolderID='" .  $doc_id . "'" ;
				//echo $sql;
		$data = $this -> db -> executeDataRow($sql);
		return $data ;
	}
	
	function get_an_ptpfolder($empType, $empId) 
	{
		$parent_id = $empType . "_" . $empId;
		$sql = "select * from PtpFolder where ParentID=" . $empId;

		$child = $this->db->executeDataTable ( $sql );
		foreach ( $child as $row ) 
		{
			$empId = $row ["ptpfolderid"] ;
			$this->temp [] = array (
					"emptype" => $empType,
					"empid" => $empId,
					"id" => $empType . "_" . $empId,
					"parent_id" => $parent_id,
					"name" => $row ["usname"]
			);
			$this->get_an_ptpfolder ($empType, $empId);
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到个人文档，不存在创建
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_person_rootid()
	{
		$param = array("col_type"=>3,"col_ownerid"=>CurUser::getUserId()) ;

		$root = new Model("tab_doc_root");
		$root -> addParamWheres($param);
		$root_id = $root -> getValue("col_id");

		if (! $root_id)
		{
			$param["col_name"] = "MyRoot" ;
			$root -> addParamFields($param);
			$root -> insert();
			$root_id = $root -> getMaxId();
		}

		return $root_id ;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到ROOT的存储路径
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_root_dir($root_type,$root_id)
	{
//		$default_dir = RTC_CONSOLE . "\\DocData\\Default" ;
//		if ($root_type == 3)
//			return $default_dir ;
//
//		if ($root_id == getValue("doc_myroot"))
//			return $default_dir ;
			
		if ($root_type == 4)
		    $fil_dir = "LeaveFile/" . $root_id ;
		else if ($root_type == 5)
		    $fil_dir = "OnlineFile/" . CurUser::getUserId() . "/1" ;
		else if ($root_type == 6)
		    $fil_dir = "ClotFile/" . $root_id ;
		else if ($root_type == 8)
		    $fil_dir = $root_id ;
		else{
		    $path_text = "" ;
			$path_data = $this -> get_path_data(DOC_VFOLDER,$root_id);
			foreach($path_data as $node)
			{
				$name = $node["doc_name"] ;
				$path_text = $name . ($path_text?"/":"") . $path_text ;
			}
			if($path_text) $fil_dir = "DownLoad/" . getValue("myid") . "/" . $path_text;
			else $fil_dir = "DownLoad/" . getValue("myid");
		}
		//$default_dir = str_replace("/","\\",$default_dir) ;
		$default_dir=RTC_CONSOLE . "/" . $fil_dir;
		mkdirs($default_dir);
		return array("default_dir"=>$default_dir,"fil_dir"=>$fil_dir);

//		$sql = "select col_datapath as c from tab_doc_root where col_id=" . $root_id ;
//		$datapath = $this -> db -> executeDataValue($sql);
//		if (trim($datapath) == "")
//			$datapath = $default_dir ;
//
//		return $datapath ;
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到文档/文件夹的信息
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_detail($doc_type,$doc_id,$fields = "*")
	{
		if($doc_type==DOC_FILE||$doc_type==DOC_LeaveFile) $where="Msg_ID='". $doc_id . "'";
		else $where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		$sql = " select " . $fields . " from " . $this -> get_table_obj($doc_type) . " A where " . $where ;
//		echo $sql;
//		exit();
		$row = $this -> db -> executeDataRow($sql);
		//$row['col_name'] = str_replace("月-","月到",$row['col_name']) ;
		return $row ;
	}
	
	function get_detail2($doc_type,$doc_id,$fields = "*")
	{
		if($doc_type==DOC_FILE||$doc_type==DOC_LeaveFile) $where="ID=". $doc_id;
		else $where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		$sql = " select " . $fields . " from " . $this -> get_table_obj($doc_type) . " A where " . $where ;
//		echo $sql;
//		exit();
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}

	function get_detail1($doc_type,$doc_id,$fields = "*")
	{
		$sql = "select " . $fields . " from OnlineFile where OnlineID=" . $doc_id;
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}
	
	function setMember($doc_id, $userIds, $flag) {
	
		$relation = new EmpRelation ();
		$result = $relation -> setRelation1 ( 0, EMP_GROUP, $doc_id, "", EMP_USER, $userIds, $flag );
	
	}
	
    function onlineform_username($doc_id,$formfiletype)
    {
		switch ($formfiletype) {
			case 4 :
				$sql = "Select ClotID from ClotFile where OnlineID=".$doc_id ;
				$data = $this -> db -> executeDataTable($sql) ;
				foreach($data as $row){
					$ptpform .= ($ptpform?",":"") . $row["clotid"];
				}
				break;
			default:
				$sql = "Select aa.UserName from Users_ID as aa , OnlineForm as bb  where aa.UserID=bb.UserID and bb.OnlineID=".$doc_id." and aa.UserState=1 union all Select top 1 aa.UserName from Users_ID as aa , OnlineForm as bb  where aa.UserID=bb.MyID and bb.OnlineID=".$doc_id." and aa.UserState=1" ;
				$data = $this -> db -> executeDataTable($sql) ;
				foreach($data as $row){
					if($row["username"]!=CurUser::getLoginName()) $ptpform .= ($ptpform?",":"") . $row["username"];
				}
				break;
		}

		return array("ptpform"=>$ptpform);
    }


	function format_root_name($name)
	{
		if (strtolower($name) == "myroot")
			return get_lang("class_doc_warning6") ;
		else
			return $name ;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//DOC_ROOT,DOC_FOLDER,DOC_FILE要一样
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_fields_child($doc_type,$root_id = 0,$path = "")
	{
		$fields = $doc_type . " as col_doctype," ;

		switch($doc_type)
		{
			case DOC_ROOT:
				return $fields . "PtpFolderID as col_rootid,'' as col_path, '' as col_target,'0' as PcSize,PtpFolderID as col_id,UsName as col_name,1 as col_state" ;
			case DOC_VFOLDER:
				return $fields . $root_id . " as col_rootid,'" . $path . "'  as col_path, '' as col_target,'0' as PcSize,PtpFolderID as col_id,UsName as col_name,1 as col_state" ;
			case DOC_LeaveFile:
				return $fields . "0 as col_rootid,'" . $path . "'  as col_path, FilPath as col_target,PcSize,ID as col_id,TypePath as col_name,1 as col_state" ;
			default:
				return $fields . "PtpFolderID as col_rootid,'"  . $path  . "' as col_path, FilPath as col_target,PcSize,ID as col_id,TypePath as col_name,FileState as col_state" ;
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//DOC_ROOT,DOC_FOLDER,DOC_FILE要一样
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_fields_list($doc_type,$root_id = 0)
	{
		switch (DB_TYPE)
		{
			case "access":
				$fields = "(A.ToDate+A.ToTime) as col_dt_create,A.MyID," . $doc_type . " as col_doctype," ;
				break ;
			default:
				$fields = "A.ToDate as col_dt_create,A.MyID," . $doc_type . " as col_doctype," ;
				break;
		}
		switch($doc_type)
		{
			case DOC_ROOT:
				return $fields . "'' as Msg_ID,A.PtpFolderID as col_rootid,'' as FilPath,'0' as PcSize,A.PtpFolderID as col_id,REPLACE(A.UsName,'月-','月到') as col_name" ;
			case DOC_VFOLDER:
				return $fields . "'' as Msg_ID," . $root_id . " as col_rootid,'' as FilPath,'0' as PcSize,A.PtpFolderID as col_id,REPLACE(A.UsName,'月-','月到') as col_name,To_Type,CreatorID,CreatorName" ;
			default:
				return $fields . "Msg_ID,PtpFolderID as col_rootid,FilPath,PcSize,A.ID as col_id,REPLACE(A.TypePath,'月-','月到') as col_name,To_Type,CreatorID,CreatorName" ;
		}
	}

//	function get_fields_list1($doc_type,$root_id = 0)
//	{
//		$fields = "(A.ToDate+A.ToTime) as col_dt_create,A.MyID," . $doc_type . " as col_doctype," ;
//		switch($doc_type)
//		{
//			case DOC_ROOT:
//				return $fields . "A.PtpFolderID as col_rootid,'' as FilPath,0 as PcSize,A.PtpFolderID as col_id,A.UsName as col_name" ;
//			case DOC_VFOLDER:
//				return $fields . "A.PtpFolderID as col_rootid,'' as FilPath,0 as PcSize,A.PtpFolderID as col_id,A.UsName as col_name" ;
//			default:
//				return $fields . "(select ID from PtpFolder where MyID=A.MyID and PtpFolderID=A.PtpFolderID) as col_rootid,FilPath,PcSize,A.ID as col_id,A.TypePath as col_name" ;
//		}
//	}
	
	function get_fields_list2($doc_type)
	{
		switch (DB_TYPE)
		{
			case "access":
				$fields = "(bb.ToDate+bb.ToTime) as col_dt_create,bb.MyID," . $doc_type . " as col_doctype,0 as col_rootid,UsName,FilPath,PcSize,bb.OnlineID as col_id,bb.TypePath as col_name" ;
				break ;
			default:
				$fields = "bb.ToDate as col_dt_create,bb.MyID," . $doc_type . " as col_doctype,0 as col_rootid,UsName,FilPath,PcSize,bb.OnlineID as col_id,REPLACE(bb.TypePath,'月-','月到') as col_name" ;
				break;
		}
		return $fields ;
	}

	static function get_table_obj($doc_type)
	{
		switch($doc_type)
		{
			case DOC_ROOT:
				return "PtpFolder";
			case DOC_FILE:
				return "PtpFile";
			case DOC_LeaveFile:
				return "LeaveFile";
			default:
				return "PtpFolder" ;
		}
	}

	static function get_table_Link($doc_type)
	{
		switch($doc_type)
		{
			case DOC_ROOT:
				return "TAB_DOC_ROOT_LINK";
			default:
				return "TAB_DOC_VFOLDER_LINK" ;
		}
	}


}
?>



