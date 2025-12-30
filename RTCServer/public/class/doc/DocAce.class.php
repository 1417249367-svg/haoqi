<?php  require_once( __ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpRelation.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Department.class.php");?>
<?php

/*文档操作  
浏览,更新,管理,下载,创建,删除,重命名,发送,文件定版
1,2,8,16,32,64,128,256,512
*/
define("DOCACE_VIEW",			1) ;  		
define("DOCACE_UPDATE",			2) ;	
define("DOCACE_EDIT",			16384) ;	
define("DOCACE_MANAGE",			8) ;		
define("DOCACE_DOWNLOAD",		16) ; 		
define("DOCACE_CREATE",			32) ;		
define("DOCACE_DELETE",			64) ;		
define("DOCACE_RENAME",			128) ;		
define("DOCACE_SEND",			256) ;		
define("DOCACE_VERSION",		512) ;	
define("DOCACE_DOWNLOAD_LEAVEFILE",		1024) ; 
define("DOCACE_NETWORK_PHONE",		2048) ; 
define("DOCACE_DOWNLOAD_CLOTFILE",		4096) ; 
define("DOCACE_UPLOAD_CLOTFILE",		8192) ; 
/**
 * 云文档权限类

 * @date    20141210
 */

class DocAce
{
	//数据库操作类
	public $db ;
	public $doc ;

	function __construct()
	{
		$this -> db = new DB();
		$this -> doc = new Doc();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//权限判断  
	////////////////////////////////////////////////////////////////////////////////////////////////
	static function can($op,$doc_type,$doc_id,$root_id = 0)
	{
		$docace  = new DocAce(); 
		//有时，从手机连过来，需重新初始化数据
		//if (getValue("doc_myroot") == 0)
			$docace -> load_all_ace();

		
		$my_root_id = getValue("doc_myroot") ;
		$aces = getValue("doc_aces") ;

		
		//个人文档，所有权限
//		if ($root_id == $my_root_id)
//			return 1 ;
			

        if (getValue("myid")=="Public"){
			$power = $docace -> get_power($op,$doc_type,$doc_id,$aces);  //到数据库中递归查询父目录的
			$can = (($power & $op) == $op) ? 1:0;  //与运算是否=原值
			if(CurUser::isAdmin()) $can = 1;
		}
		else{
			 $power = $docace -> get_power_item($op,$aces);				//已经传入路
			 $op=($op == 1) ? 2:$op;
			 $can = (($power & $op) == $op) ? 0:1;  //与运算是否=原值
//			 			 echo $op;
//			 exit();
		}
        

//echo $aces;
//		exit();


		return $can ;
	}
	
	static function can1($op,$doc_type,$doc_id,$root_id = 0,$root_type)
	{
		$docace  = new DocAce(); 
		$data = $docace -> get_all_ace1();
		foreach($data as $row){
			$aces .= ($aces?",":"") . DOC_VFOLDER . "_" . $row["ptpfolderid"] . "_" . $row["docace"];
		}

		$power = $docace -> get_power($op,$doc_type,$doc_id,$aces);  //到数据库中递归查询父目录的
		$can = (($power & $op) == $op) ? 1:0;  //与运算是否=原值
		if(CurUser::isAdmin()) $can = 1;

		return $can ;
	}
	
	static function can2($op,$doc_type,$doc_id,$root_id = 0,$root_type,$emp_type,$emp_id)
	{
		$docace  = new DocAce(); 
		$data = $docace -> get_all_ace2($emp_type,$emp_id);
		foreach($data as $row){
			if ((string)$row["ptpfolderid"] == (string)$doc_id) return 1 ;
		}
		return 0 ;
	}
	
	static function can3($op,$doc_type,$doc_id,$root_id = 0)
	{
		$docace  = new DocAce(); 
		$data = $docace -> get_all_ace();
		
		$aces = "" ;
		foreach($data as $row){
			$aces .= ($aces?",":"") . $row["permissions"];
		}

	    $power = $docace -> get_power_item($op,$aces);				//已经传入路
	    $op=($op == 1) ? 2:$op;
	    $can = (($power & $op) == $op) ? 0:1;  //与运算是否=原值

		return $can ;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取所有权限,并存放到session中
	////////////////////////////////////////////////////////////////////////////////////////////////
	function load_all_ace()
	{
		$aces = "" ;
		
		//加入我的文档  1019 是所有权限
//		$root_id =  $this -> doc -> get_person_rootid();
//		$aces .= DOC_ROOT . "_" . $root_id . "_" . 1019;
		
		//加入所有权限
		if (getValue("myid")=="Public"){
			$data = $this -> get_all_ace1();
			foreach($data as $row){
				$aces .= ($aces?",":"") . DOC_VFOLDER . "_" . $row["ptpfolderid"] . "_" . $row["docace"];
			}
		}else{
			$data = $this -> get_all_ace();
			foreach($data as $row){
				$aces .= ($aces?",":"") . $row["permissions"];
				setValue("PtpSize",$row["ptpsize"]);
				setValue("PtpType",$row["ptptype"]);
				setValue("PubSize",$row["pubsize"]);
				setValue("PubType",$row["pubtype"]);
			}
		}
		setValue("doc_myroot",1);
		setValue("doc_aces",$aces);

	}
	

	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到路径
	////////////////////////////////////////////////////////////////////////////////////////////////
//	function get_path_data2($doc_type,$doc_id)
//	{
//		//得到VFOLDER关系
//		Global $path;
//		$data = $this -> doc -> get_parent_auto($doc_type,$doc_id); //得到上层目录
//
//		if (count($data))
//		{
//			if($data["doc_id"]=="00000000") $path = $data;
//			else $this -> get_path_data2($data["doc_type"],$data["doc_id"]) ;
//		}
//	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取某权限(自动取上级节点来继承)  
	//得到路径，从最近一层计算，以最近一层为准
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_power($op,$doc_type,$doc_id,$aces)
	{
		$power = $this -> get_power_item1($op,$doc_type,$doc_id,$aces);

		if ($power == -1)
		{
			// 没有权限设置
			$data = $this -> doc -> get_parent_auto($doc_type,$doc_id); //得到上层目录

			if (count($data) > 0)
				return $this ->  get_power($op,$data["doc_type"],$data["doc_id"],$aces); //递归
		}
		else
		{
			//返回当前层
			return $power ; 
		}

		return 0 ;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取某权限(自动取上级节点来继承)  
	//得到路径，从最近一层计算，以最近一层为准
	////////////////////////////////////////////////////////////////////////////////////////////////
//	function get_power($op,$doc_type,$doc_id,$aces)
//	{
//		// 没有权限设置
//		//echo var_dump($doc_type."|".$doc_id);
//		Global $path;
//
//		$doc = new Doc();
//		$path_data = $doc -> get_path_data($doc_type,$doc_id);
//		//$this -> get_path_data2($doc_type,$doc_id); //得到上层目录
//				//echo $path["col_id"];
//		//exit();
//		//得到root_id
//		if (count($path_data)>0)
//		{
//			$node = $path_data[count($path_data)-1] ;
////			echo var_dump($node);
////		exit();
//			$power = $this -> get_power_item1($op,$node["doc_type"],$node["col_id"],$aces);
//			if ($power > -1)
//				return $power ;
//		}
//
//		return 0 ;
//	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//判断是否在当然用户权限值中
	//return  power  -1 表示不存在
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_power_item1($op,$doc_type,$doc_id,$aces)
	{
		//文件格式，直接返回没有
		if ($doc_type == DOC_FILE)
			return -1 ;
		
		//$data_ace  doctype_docid_power
//					echo $doc_id;
//			exit();
		$data_ace = explode(",",$aces);

		foreach($data_ace as $ace)
		{
			$item = explode("_",$ace);
			if ((string)$item[1] == (string)$doc_id){
				return $item[2] ;
			}	
		}
		return -1 ;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//判断是否在当然用户权限值中
	//return  power  -1 表示不存在
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_power_item($op,$aces)
	{
		//文件格式，直接返回没有
//		if ($doc_type == DOC_FILE)
//			return -1 ;
//        if (getValue("myid")=="Public"){
//			if ($op == DOCACE_CREATE)
//				$item = "21" ;
//			elseif ($op == DOCACE_DOWNLOAD)
//				$item = "22" ;
//		}
//		else {
			if ($op == DOCACE_CREATE)
				$item = "2" ;
			elseif ($op == DOCACE_DOWNLOAD)
				$item = "10" ;
			elseif ($op == DOCACE_UPDATE)
				$item = "10" ;
			if ($op == DOCACE_DOWNLOAD_LEAVEFILE)
				$item = "12" ;
			elseif ($op == DOCACE_NETWORK_PHONE)
				$item = "13" ;
			elseif ($op == DOCACE_UPLOAD_CLOTFILE)
				$item = "3" ;
			elseif ($op == DOCACE_DOWNLOAD_CLOTFILE)
				$item = "11" ;
//		}
		//$data_ace  doctype_docid_power
		$data_ace = explode(",",$aces);

		foreach($data_ace as $ace)
		{
			//$item = explode("_",$ace);
			if ($ace == $item)
				return 1 ;
		}
		return -1 ;
	}
	

	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取所有权限
	//返回数组
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_all_ace()
	{
		//得到用户
		$user_id = CurUser::getUserId();

		//得到角色
		$user = new User();
		$data = $user -> listRole($user_id) ;

		$role_ids = table_column_tostring($data,"id");
		//得到所有的权限
		//$sql = $this -> get_ace_sql(EMP_USER,$user_id) ;
		if ($role_ids)
			$sql = $this -> get_ace_sql(EMP_ROLE,$role_ids)  ;

		$data = $this -> db -> executeDataTable($sql);
		return $data ;
	}
	
 
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取权限SQL 
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_ace_sql($emp_type,$emp_id)
	{
		if (strpos(",",$emp_id) == -1)
			$sql = " ID=" . $emp_id ;
		else
			$sql = " ID in (" . $emp_id . ")" ;
			
		$sql = " select Permissions,PtpSize,PtpType,PubSize,PubType from Role where" . $sql;
		return $sql ;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取所有权限
	//返回数组
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_all_ace1()
	{
		//得到用户
		$user_id = CurUser::getUserId();
		
		//得到部门
		$dept = new Department();
		$deptIds = $dept -> getSubDeptByUser($user_id);
		
		//得到所有的权限
		$sql = $this -> get_ace_sql1(EMP_USER,$user_id) ;
		$data_file = $this -> db -> executeDataTable($sql);
		$data_folder = array();
		if ($deptIds){
			$sql = $this -> get_ace_sql1(EMP_DEPT,$deptIds)  ;
			$data_folder = $this -> db -> executeDataTable($sql);
		}
//echo $sql;
//exit();
        $data = array_merge($data_file,$data_folder) ;
		
		return $data ;
	}
	
 	function get_all_ace2($emp_type,$emp_id)
	{
		//得到用户
		$data_file = array();
		if($emp_type==1){
			$user_id = $emp_id;
			//得到部门
			$dept = new Department();
			$deptIds = $dept -> getSubDeptByUser($user_id);
			
			//得到所有的权限
			$sql = $this -> get_ace_sql1(EMP_USER,$user_id) ;
			$data_file = $this -> db -> executeDataTable($sql);
		}else{
			$deptIds = $emp_id;
		}
		
		$data_folder = array();
		if ($deptIds){
			$sql = $this -> get_ace_sql1(EMP_DEPT,$deptIds)  ;
			$data_folder = $this -> db -> executeDataTable($sql);
		}
//echo $sql;
//exit();
        $data = array_merge($data_file,$data_folder) ;
		
		return $data ;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	//获取权限SQL 
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_ace_sql1($emp_type,$emp_id)
	{
		
		if($emp_type==1) $sql = " To_Type=1" ;
		else $sql = " To_Type<>1" ;
		if (strpos(",",$emp_id) == -1)
			$sql = $sql." and UserID='" . $emp_id . "'" ;
		else
			$sql = $sql." and UserID in (" . $emp_id . ")" ;
			
		$sql = " select PtpFolderID,DocAce from PtpFolderForm where" . $sql . " and MyID='Public' order by ID desc";
		return $sql ;
	}

}
?>



