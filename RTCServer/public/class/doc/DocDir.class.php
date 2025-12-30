<?php
/**
 * 文档管理的目录管理

 * @date    20140828
 */

class DocDir 
{
	//数据库操作类
	public $db ;
	public $relation ;
	
	function __construct()
	{
		$this -> db = new DB();
		$this -> relation = new DocRelation();
	}
	
//	function insert($parentType,$parentId,$name)
//	{
//		$childType = DOC_VFOLDER ;
//		$tableName = "PtpFolder";
//		
//
//		//添加数据
//		switch (DB_TYPE)
//		{
//			case "access":
//				$sql = "Select max(clng(PtpFolderID)) as c from PtpFolder where MyID='".getValue("myid")."'";
//				break ;
//			default:
//				$sql = "Select max(CONVERT(int,PtpFolderID)) as c from PtpFolder where MyID='".getValue("myid")."'";
//				break;
//		}
////		echo $sql;
////		exit();
//		$childEmpId  =$this -> db -> executeDataValue($sql);
//		if(empty($childEmpId)) $childEmpId=0;
//		$childEmpId=$childEmpId+1;
//		$childEmpId=$childEmpId+100000000;
//		$childEmpId=substr($childEmpId,-8);
//			
//		$fields = array("PtpFolderID"=>$childEmpId,"UsName"=>$name,"MyID"=>getValue("myid"),"ParentID" => $parentId,"CreatorID" => CurUser::getUserId(),"CreatorName" => CurUser::getLoginName());
//		$folder = new Model($tableName);
//		$folder -> addParamFields($fields);
//		$folder -> insert();
//		
//		//得到ID
// 		$childId = $this -> db -> getMaxId($tableName,"ID");
//		//添加关系
//		//$this -> relation -> addRelation($parentType,$parentId,$childType,$childId);
//		
//		return array("type"=>$childType,"id"=>$childId,"ptpfolderid"=>$childEmpId);
//	}

	function insert($parentType,$parentId,$name,$myid)
	{
		$childType = DOC_VFOLDER ;
		$tableName = "PtpFolder";
		

		//添加数据
		$fields = array("UsName"=>$name,"MyID"=>$myid,"ParentID" => $parentId,"To_Type" => g("root_type",3),"CreatorID" => CurUser::getUserId(),"CreatorName" => CurUser::getLoginName());
		$folder = new Model($tableName);
		$folder -> addParamFields($fields);
		$folder -> insert();
		//得到ID
 		$childId = $this -> db -> getMaxId($tableName,"PtpFolderID");
		$doc = new Doc();
		$doc -> get_root_dir(g("root_type",3),$childId) ;
		//添加关系
		//$this -> relation -> addRelation($parentType,$parentId,$childType,$childId);
		
		return array("type"=>$childType,"ptpfolderid"=>$childId);
	}
	
//	function insert1($parentType,$parentId,$name)
//	{
//		$childType = DOC_VFOLDER ;
//		$tableName = "PtpFolder";
//		
//
//		//添加数据
//		switch (DB_TYPE)
//		{
//			case "access":
//				$sql = "Select max(clng(PtpFolderID)) as c from PtpFolder where MyID='".CurUser::getUserId()."'";
//				break ;
//			default:
//				$sql = "Select max(CONVERT(int,PtpFolderID)) as c from PtpFolder where MyID='".CurUser::getUserId()."'";
//				break;
//		}
////		echo $sql;
////		exit();
//		$childEmpId  =$this -> db -> executeDataValue($sql);
//		if(empty($childEmpId)) $childEmpId=0;
//		$childEmpId=$childEmpId+1;
//		$childEmpId=$childEmpId+100000000;
//		$childEmpId=substr($childEmpId,-8);
//			
//		$fields = array("PtpFolderID"=>$childEmpId,"UsName"=>$name,"MyID"=>CurUser::getUserId(),"ParentID" => $parentId,"CreatorID" => CurUser::getUserId(),"CreatorName" => CurUser::getLoginName());
//		$folder = new Model($tableName);
//		$folder -> addParamFields($fields);
//		$folder -> insert();
//		
//		//得到ID
// 		$childId = $this -> db -> getMaxId($tableName,"ID");
//		//添加关系
//		//$this -> relation -> addRelation($parentType,$parentId,$childType,$childId);
//		
//		return array("type"=>$childType,"id"=>$childId,"ptpfolderid"=>$childEmpId);
//	}	
	
	function update($rootId,$parentType,$parentId,$childType,$childId,$name)
	{
		$tableName = $this -> getTableName($childType) ;


		$data = array("UsName"=>$name) ;
		$params = $this -> db -> parseDataParam($data) ;
		$sql = $this -> db -> getUpdateSQL($tableName,$params," where PtpFolderID='" . $childId . "' and MyID='".getValue("myid")."'") ;
//echo $sql;
//exit();
		$result = $this -> db -> execute($sql,$params) ;
		return $childId ;
	}
	

	
	function detail($doc_type,$doc_id)
	{
		$tableName = $this -> getTableName($doc_type) ;
		$sql = " select * from " . $tableName . " where PtpFolderID='" . $doc_id . "' and MyID='".getValue("myid")."'";
//		echo $sql;
//		exit();
		return $this -> db -> executeDataRow($sql) ;
	}
	
	
	function delete($doc_type,$doc_id)
	{
		$tableName = $this -> getTableName($doc_type) ;

		$arr_sql = array();
//		$arr_sql[] = " delete from " . $tableName . " where MyID='" . getValue("myid") . "' and PtpFolderID='" . $doc_id . "'" ;
		
//		if ($doc_type == DOC_ROOT)
//		{
//			$arr_sql[] = " delete from TAB_DOC_ROOT_LINK where col_p_objid=" . $doc_id ;	//删除下级关系
//		}
//		if ($doc_type == DOC_VFOLDER)
//		{
			$arr_sql[] = " delete from PtpFolderForm where MyID='" . getValue("myid") . "' and PtpFolderID='" . $doc_id . "'" ;	//删除下级关系
			//$arr_sql[] = " delete from TAB_DOC_VFOLDER_LINK where col_s_objid=" . $doc_id . " and col_s_classid=" . DOC_VFOLDER ; //删除上级关系
			//$arr_sql[] = " delete from TAB_DOC_ROOT_LINK where col_s_objid=" . $doc_id . " and col_s_classid=" . DOC_VFOLDER ; //删除上级关系
//		}
		
		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;
			
	}
	
	function doc_retime($doc_id)
	{
		$where="PtpFolderID='".$doc_id."' and MyID='".getValue("myid")."'";
		$sql = " update PtpFolder set ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where " . $where ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}
 
	function getTableName($dirType)
	{
		switch($dirType)
		{
			case DOC_ROOT:
				return "PtpFolder";
			case DOC_FILE:
				return "PtpFile";
			default:
				return "PtpFolder" ;
		}
	}
}
?>



