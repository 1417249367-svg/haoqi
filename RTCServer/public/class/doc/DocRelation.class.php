<?php
/**
 * 关联管理类

 * @date    20140331
 */

class DocRelation 
{
	//数据库操作类
	public $db ;

	function __construct()
	{
		$this -> db = new DB();

	}

    function addRelation($parentType,$parentId,$childType,$childId)
    {
		$fields = array("col_style"=>0,"col_isref"=>0,"col_reltype"=>0,"col_p_objid"=>$parentId,"col_s_classid"=>$childType,"col_s_objid"=>$childId);
		
		$tableName = $this -> getTableName($parentType);
		$relation = new Model($tableName);
		$relation -> addParamFields($fields);
		$relation -> insert();
		
		return true ;
    }
	

    function getRelationData($parentType, $parentId, $childType,$fields = "A.*")
    {
        $tableName_Relation = $this -> getTableName($parentType);
		$tableName_Data = $this -> getTableName1($childType);

        if($childType==DOC_FILE) $tableName_colData="PtpFolderID";
		else $tableName_colData="ParentID";

        $sql = " select " . $fields . " from " . $tableName_Data . "    A" .
            " where " .$tableName_colData. "='" . $parentId . "' and MyID='" . getValue("myid") . "'";
//echo $sql;
		return $this -> db -> executeDataTable($sql) ;

    }



	
	function getTableName($DocType)
	{
		switch($DocType)
		{
			case DOC_ROOT:
				return "TAB_DOC_ROOT_LINK";
			default:
				return "TAB_DOC_VFOLDER_LINK" ;
		}
	}
	
	function getTableName1($dirType)
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