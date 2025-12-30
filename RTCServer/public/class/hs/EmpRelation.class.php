<?php
/**
 * 关联管理类

 * @date    20140331
 */

class EmpRelation
{
	//数据库操作类
	public $db ;
	public $arr_parent;

	function __construct()
	{
		$this -> db = new DB();

	}
    function TopTypeID($parentEmpIds)
    {
        $sql = "Select max(TypeID) as c from MessengClot_Text where ClotID='". $parentEmpIds ."'";
		$TypeID=$this -> db -> executeDataValue($sql);
		if(!$TypeID) $TypeID=0;
		return $TypeID;
    }
	/*
	*设置关联数据
	*$flag  0 append  1 reset
	*return  {"add"=>$arr_insert,"delete"=>$arr_delete} 
	*/
    function setRelation($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
        $data_user = $this->getRelationData ( EMP_GROUP, $parentEmpIds, EMP_USER );
		foreach($data_user as $k=>$v){
			$UserID1.=$data_user[$k]['col_id']."," ;
		}
		$UserID_Arr1 = explode ( ",", $UserID1 );
		$fields = explode ( ",", $childEmpIds );
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$UserID2.=$my_ids[0]."," ;
		}
		$UserID_Arr2 = explode ( ",", $UserID2 );
		$diffA = array_diff($UserID_Arr1, $UserID_Arr2);
		$arr_sql = array();
		
		foreach($diffA as $id)
		{
			if ($id)
			{
				$arr_sql[] = "Delete from Clot_Form where UpperID='". $parentEmpIds ."' and UserID='". $id ."'";
			}
		}
		$this -> db -> execute($arr_sql);

		unset($arr_sql);
		
		$TypeID=$this -> TopTypeID($parentEmpIds);
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$data = $this -> db -> executeDataRow("select * from Clot_Form where UpperID='". $parentEmpIds ."' and UserID='". $my_ids[0] ."'");
			if (count($data)){
				$arr_sql[] = "update Clot_Form set IsAdmin=". $my_ids[1] .",remark='". $my_ids[2] ."' where UpperID='". $parentEmpIds ."' and UserID='". $my_ids[0] ."'";
			}else{
				$arr_sql[] = "insert into Clot_Form(UpperID,UserID,IsAdmin,remark,last_ack_typeid1,last_ack_typeid2,last_ack_typeid3,last_ack_typeid4) values('". $parentEmpIds ."','". $my_ids[0] ."',". $my_ids[1] .",'". $my_ids[2] ."',". $TypeID .",". $TypeID .",". $TypeID .",". $TypeID .")";
			}
		}
		$this -> db -> execute($arr_sql);
		
        $sql = "delete from Clot_Form where UpperID='". $parentEmpIds ."' and id not in(select min(id) from Clot_Form where UpperID='". $parentEmpIds ."' group by UserID)";
		$this -> db -> execute($sql) ;
//		echo var_dump($arr_sql);
//		exit();
		
		//return $result ;
    }
	
    function setRelation1($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		$sql = " select * from OnlineFile where OnlineID=". $parentEmpIds;
		$row = $this->db->executeDataRow($sql);
		$sql = "Delete from OnlineForm where OnlineID=". $parentEmpIds;
		$this -> db -> execute($sql) ;
		
		$fields = explode ( ",", $childEmpIds );
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$sql = "insert into OnlineForm(MyID,OnlineID,UserID,Authority,ToDate,ToTime) values('".$row["myid"]."','". $parentEmpIds ."','". $my_ids[0] ."',". $my_ids[1] .",'". date("Y-m-d H:i:s") ."','". date("Y-m-d H:i:s") ."')";
			$this -> db -> execute($sql) ;
		}
		
		//return $result ;
    }
	
    function setRelation2($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		$doc = new Doc();
		$fields = explode ( ",", $childEmpIds );
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$sql = "select count(*) as c from PtpFolderForm where UserID='". $my_ids[0] ."' and To_Type=". $my_ids[1] ." and PtpFolderID='". $parentEmpIds ."'";
			$count = $this -> db -> executeDataValue($sql) ;
			if ($count == 0){
				$sql = "insert into PtpFolderForm(MyID,UserID,To_Type,PtpFolderID,ToDate,ToTime) values('Public','". $my_ids[0] ."',". $my_ids[1] .",'". $parentEmpIds ."','". date("Y-m-d H:i:s") ."','". date("Y-m-d H:i:s") ."')";
				//echo $sql;
				$this -> db -> execute($sql) ;
				//$data = $doc -> get_parent_auto(DOC_VFOLDER,$parentEmpIds); //得到上层目录
				$data = $doc -> get_path_data(DOC_VFOLDER,$parentEmpIds);
				foreach($data as $k=>$v){
					if($data[$k]['doc_id']=="0"){
						if (!DocAce::can2(DOCACE_VIEW,DOC_VFOLDER,$data[$k]['col_id'],0,1,$my_ids[1],$my_ids[0])) $this->setRelation2 ( 0, $parentEmpType, $data[$k]['col_id'], "", $childEmpType, $field, $flag );	
					}
				}
			}
		}
		
		//return $result ;
    }
	
    function setRelation3($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		if(!$childEmpIds) return ;
		$sql = "Delete from lv_chater_form where TypeID=". $parentEmpIds;
		$this -> db -> execute($sql) ;
		$fields = explode ( ",", $childEmpIds );
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$sql = "insert into lv_chater_form(UserID,LoginName,UserName,TypeID) values('". $my_ids[0] ."','". $my_ids[1] ."','". $my_ids[2] ."',". $parentEmpIds .")";
			$this -> db -> execute($sql) ;
		}
    }
	
    function setRelation6($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		$sql = "Delete from lv_chater_notice where TypeID=". g ( "mode" );
		$this -> db -> execute($sql) ;
		$fields = explode ( ",", $childEmpIds );
		foreach ( $fields as $field ) {
			if($field){
				$my_ids = explode ( "-", $field );
				$sql = "insert into lv_chater_notice(UserID,LoginName,UserName,TypeID) values('". $my_ids[0] ."','". $my_ids[1] ."','". $my_ids[2] ."',". g ( "mode" ) .")";
				$this -> db -> execute($sql) ;
			}
		}
    }
	
    function setRelation4($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		$fields = explode ( ",", $childEmpIds );
		$arr_sql = array();
		foreach ( $fields as $field ) {
			$my_ids = explode ( "-", $field );
			$arr_sql[] = "insert into Board_Visiter(col_BoardID,Col_HsItem,Col_HsItem_Name,Col_HsItem_ID) values('". $parentEmpIds ."','". $my_ids[1] ."','". $my_ids[2] ."',". $my_ids[0] .")";
		}
		$this -> db -> execute($arr_sql);
//		echo var_dump($arr_sql);
//		exit();
    }
	
    function setRelation5($viewId,$parentEmpType, $parentEmpIds, $parentEmpName, $childEmpType, $childEmpIds,$flag)
    {
		$fields = explode ( ",", $childEmpIds );
		$arr_sql = array();
		foreach ( $fields as $field ) {
			$my_ids = explode ( "|", $field );
			$arr_sql[] = "insert into Board_Attach(Col_BoardID,col_FileSize,col_FilePath,col_FileName) values('". $parentEmpIds ."',". $my_ids[0] .",'". $my_ids[1] ."','". $my_ids[2] ."')";
		}
		$this -> db -> execute($arr_sql);
//		echo var_dump($arr_sql);
//		exit();
    }

    function isRelation($parentType, $parentId, $childType, $childId)
    {
		$m = new Model("Clot_Form");
		$fields = array('UpperID' => $parentId,'UserID' => $childId);
		$m->addParamWheres($fields);
		$count = $m->getCount();
		if($count >0 )
			return true;
		return false;
    }

    function getRelationData($parentEmpType, $parentEmpId, $childEmpType)
    {
//        $fldList = "A.*";
//        $tableName = $this -> getTableName($childEmpType);
//
//        if ($tableName == "HS_USER")
//            $fldList = " A.col_id,A.col_name,A.col_loginname";

//        $sql = "select Users_ID.UserID as col_id,Users_ID.FcName as col_name,Users_ID.UserName as col_loginname from Users_ID,Users_Role where Users_Role.RoleID=" . $parentEmpId . " and Users_ID.UserID=Users_Role.UserID";
        $sql = "Select bb.UserID as col_id,bb.remark as col_name,aa.UserName as col_loginname,bb.IsAdmin from Users_ID as aa , Clot_Form as bb where aa.UserID=bb.UserID and bb.UpperID='" . $parentEmpId . "' and aa.UserState=1 order by bb.IsAdmin Desc";

		return $this -> db -> executeDataTable($sql) ;

    }
	
    function getRelationData1($parentEmpType, $parentEmpId, $childEmpType)
    {
        $sql = "select UserId as col_id,UserName as col_name,LoginName as col_loginname from lv_chater_form where TypeID=" . $parentEmpId;

		return $this -> db -> executeDataTable($sql) ;

    }

    function getRelationData2($parentEmpType, $parentEmpId, $childEmpType)
    {
        $sql = "select UserId as col_id,UserName as col_name,LoginName as col_loginname from lv_chater_notice where TypeID=" . g ( "mode" );

		return $this -> db -> executeDataTable($sql) ;

    }
 
	function insert($viewId,$parentEmpType,$parentEmpId,$parentEmpName,$childEmpType,$childEmpId,$childEmpName,$deptPath = "")
	{
		$result = 0 ;
		
		$userIds = $childEmpId ;
		$arrChildEmpId = explode(",",$childEmpId) ;
		$arrChildEmpName = explode(",",$childEmpName) ;
		foreach($arrChildEmpId as $key=>$childEmpId)
		{
			$childEmpName = "" ;
			if ($key<count($arrChildEmpName))
				$childEmpName = $arrChildEmpName[$key] ;
				
			//判断是否存在
			$sql = " select count(*) from hs_relation where col_hsitemtype=" . $parentEmpType . " and col_hsitemid=" . $parentEmpId.
				   " and col_dhsitemtype=" . $childEmpType . " and col_dhsitemid=" . $childEmpId. "  and col_viewid=" . $viewId ;
			$c = $this -> db -> executeDataValue($sql) ;
			
			//不存在，添加
			if ($c == 0)
			{
				$sql = " insert into hs_relation(col_viewid,col_hsitemtype,col_hsitemid,col_hsitemname,col_dhsitemtype,col_dhsitemid,col_dhsitemname,col_reltype) " .
						" values(" . $viewId . "," . $parentEmpType . "," . $parentEmpId . ",'" . $parentEmpName. "'," . $childEmpType . "," . $childEmpId . ",'" . $childEmpName. "',1)" ;
		
				$this -> db -> execute($sql) ;
				
				$result = 1 ;
			}
		}


		//如果是设置人员部门关系
		if ($childEmpType == EMP_USER)
		{
			$user = new User();
			$user -> setUserDeptInfo($userIds,$parentEmpType,$parentEmpId,$parentEmpName,$deptPath) ;
		}


		return 1 ;

	}


	function getName($empType,$empId)
	{
		$tableName = $this -> getTableName($empType);
		$sql = " select col_name as c from " . $tableName . " where col_id=" . $empId ;
		return $this -> db -> executeDataValue($sql) ;
	}

    /**
     * delete
	 * jc 20150716 支持多个 $childEmpId 1,2
     * @return 0 fail > 1 success
     */
	function delete($viewId = 0 ,$parentEmpType = 0,$parentEmpId = 0 ,$childEmpType = 0,$childEmpId = 0)
	{
//		$sql = EmpRelation::getRelationWhere($viewId,$parentEmpType,$parentEmpId,$childEmpType,$childEmpId);
//
//		if ($sql == "")
//			return 0 ;

		$sql = " delete from Clot_Form where UpperID='".$parentEmpId."' and UserID='".$childEmpId."'";

		$result = $this -> db -> execute($sql) ;
		
//		//如果是设置人员部门关系
//		if ($childEmpType == EMP_USER)
//		{
//			$user = new User();
//			$user -> setUserDeptInfo($childEmpId,0,0,"","") ;
//		}

		return $result ;
	}

    /**
     * 设置子对象
     * @return 0 fail > 1 success
     */
	function setChilds($viewId = 0,$parentEmpType,$parentEmpId,$childEmpType,$childEmpIds)
	{
		$sqls[0] = "delete from hs_relation where col_hsitemtype=" . $parentType . " and col_hsitemid=" . $parentId ;
		$arr_id = explode(",",$childEmpIds);
		foreach($arr_id as $childEmpId)
		{
			if ($childEmpId)
			{
				$sqls[count($sqls)] = " insert into hs_relation(col_viewid,col_hsitemtype,col_hsitemid,col_dhsitemtype,col_dhsitemid,col_reltype) " .
						" values(" . $viewId . "," . $parentEmpType . "," . $parentEmpId . "," . $childEmpType . "," . $childEmpId . ",1)" ;
			}
		}
		$result = $this -> db -> execute($sqls) ;
		return $result ;
	}

    /**
     * 设置父对象
     * @return 0 fail > 1 success
     */
 	function setParent($empType,$empId,$parentType,$parentId,$targetType,$targetId,$targetName = "",$targetPath = "")
	{
		$sql = "update Users_Ro set ParentID='" . $targetId . "' where ParentID='" . $parentId . "' and TypeID='" . $empId . "'" ;
		$result = $this -> db -> execute($sql) ;
		
		//人员col_alldeptinfo 也会有变化
		
		
		return $result ;
	}

    /**
     * 得到子孙
     */
	private $ids = "" ;
	function getChildIds($empType,$empId,$childEmpType)
	{
		$this -> ids = "" ;
		$this -> getChildIds2($empType,$empId,$childEmpType) ;
		return $this -> ids ;
	}

	function getChildIds2($empType,$empId,$childEmpType)
	{
		$sql = EmpRelation::getRelationWhere(-1 ,$empType,$empId ,$childEmpType,-1);
		$sql = $this -> db -> getSelectSQL("hs_relation","col_dhsitemtype,col_dhsitemid",$sql,"");

		$data = $this -> db -> executeDataTable($sql);
		foreach($data as $row)
		{
			$curr_type = $row["col_dhsitemtype"] ;
			$curr_id = $row["col_dhsitemid"] ;
			$this -> ids .= ($this -> ids == ""?"":",") . $curr_id ;
			$this -> getChildIds2($curr_type,$curr_id,$childEmpType) ;
		}
	}




	/*
	method	转换路径数据
	param	$path_data:array(array("emptype"=>1,"empid"=>1,"empname"=>"a"),array("emptype"=>1,"empid"=>1,"empname"=>"b"))
	return	array("path_id"=>"4_1/2_1","path_name"=>"a/b")
	*/
	function format_path_data($path_data)
	{
		$path_name = "" ;
		$path_id = "" ;
		
		if  (count($path_data) == 0)
			return array("path_id"=>"","path_name"=>"");

		foreach($path_data as $row)
		{
			$path_name =  $row["empname"] . ($path_name == ""?"":"/") . $path_name;
			$path_id =   $row["emptype"] . "_" . $row["empid"] . ($path_id == ""?"":"/") . $path_id;
		}
		return array("path_id"=>$path_id,"path_name"=>$path_name);
	}

	/*
	method	得到路径名称 
	param	$empType
	param	$empId
	return	array()
	*/
	function get_path_name($empType,$empId,$isSelf = 0)
	{
		$data = $this -> get_path_data($empType,$empId,$isSelf);
		$path = $this -> format_path_data($data);
		return $path["path_name"];
	}

	/*
	method	得到路径数据
	param	$empType
	param	$empId
	return	array(array(emptype=>4,empid=>1,empname=>""),array(emptype=>4,empid=>1,empname=>""))
	*/
	function get_path_data($empType,$empId,$isSelf = 0)
	{
		$this -> arr_parent = array();
		
		if ($empId == 0)
			return $this -> arr_parent ;

		if ($isSelf)
		{
			$sql = " select col_name as c from " . $this -> getTableName($empType) . " where col_id=" . $empId ;
			$empName = $this -> db -> executeDataValue($sql);
			$this -> arr_parent[] = array("emptype"=> $empType,"empid"=> $empId,"empname"=> $empName );
		}

		$this -> get_path_data2($empType,$empId);

		return $this -> arr_parent ;

	}


	/*
	method	得到上级(递归)
	param	$empType
	param	$empId
	return	array(array(emptype=>4,empid=>1,empname=>""),array(emptype=>4,empid=>1,empname=>""))
	*/
	function get_path_data2($empType,$empId)
	{
		if ($empType == EMP_VIEW)
			return ;
		$data = $this -> get_parent($empType,$empId);
		if (count($data))
		{
			$empType = $data[0]["emptype"] ;
			$empId = $data[0]["empid"] ;
			$empName = $data[0]["empname"] ;
			
			$this -> arr_parent[] = array("emptype"=> $empType,"empid"=> $empId,"empname"=> $empName );
			$this -> get_path_data2($empType,$empId,$empName) ;
		}
	}

	/*
	method	得到上级(非递归)
	param	$empType
	param	$empId
	return	array(array(emptype=>4,empid=>1,empname=>""),array(emptype=>4,empid=>1,empname=>""))
	*/
	function get_parent($empType,$empId)
	{
		$sql = "select col_hsitemid as empid, col_hsitemtype as emptype from hs_relation where col_dhsitemtype=" . $empType . " and col_dhsitemid=" . $empId ;
		
		//人员有多个上级 ,找到系统视图下的人员
		if ($empType == 1)
		{
			$sql .= " and col_viewid in(select col_id from hs_view where col_type=1)" ;
		}
		
		$arr_parent_info = $this->db->executeDataTable($sql);
		$arr_parent_info = table_fliter_doublecolumn($arr_parent_info,1);
		$result = array();
		$i = 0 ;
		foreach ($arr_parent_info as $row)
		{
			$fields = "col_name as empname ,col_id as empid";
			if($row['emptype'] == 4)
				 $fields .=",col_type";
			else
				$fields .=",1 as col_type";
			$sql = "select " . $fields . " from " . $this->getTableName($row['emptype']) . " where col_id=" . $row['empid'] ;
			$data = $this->db->executeDataRow($sql);

			if (count($data) == 0)
				continue ;
				
			//排除群组和我的联系人
			if($data['col_type'] == 1 )
			{
				$result[$i]['empname'] = $data['empname'];
				$result[$i]['empid'] = $row['empid'];
				$result[$i]['emptype'] = $row['emptype'];
				$i++ ;
			}
		}
		return $result;
	}


	
	static function getRelationWhere($viewId = 0 ,$parentEmpType = 0,$parentEmpId = 0 ,$childEmpType = 0,$childEmpId = 0)
	{
		$db = new DB();
		
		$sql = "" ;
		
		if ($parentEmpType > -1)
			$sql = $db -> addWhere($sql,"col_hsitemtype=" . $parentEmpType) ;

		if ($parentEmpId > -1)
			$sql = $db -> addWhere($sql,"col_hsitemid=" . $parentEmpId) ;

		if ($childEmpType > -1)
			$sql = $db -> addWhere($sql,"col_dhsitemtype=" . $childEmpType) ;

		if ($childEmpId > -1)
		{
			if (strpos($childEmpId,",")>0)
				$sql = $db -> addWhere($sql,"col_dhsitemid in(" . $childEmpId . ")") ;
			else
				$sql = $db -> addWhere($sql,"col_dhsitemid=" . $childEmpId) ;
		}

		if ($viewId > 0)
			$sql = $db -> addWhere($sql,"col_viewid=" . $viewId) ;

		return $sql ;
	}

	function getTableName($empType)
	{
		switch($empType)
		{
			case EMP_USER:
				return "HS_USER";
			case EMP_DEPT:
				return "HS_GROUP";
			case EMP_ROLE:
				return "HS_ROLE";
			default:
				return "HS_VIEW" ;
		}
	}
}
