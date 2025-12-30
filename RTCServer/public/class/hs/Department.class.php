<?php
/**
 * 部门管理类

 * @date    20140505
 */
class Department {
	// 数据库操作类
	public $db;
	public $relation;
	public $temp ;
	public $deptIds = "";
	public $deptNames = "";
	public $ids = "";
	public $isLdap = false;     //域同步标记


	function __construct()
	{
		$this -> db = new DB();
		$this -> relation = new EmpRelation();
	}

	/**
	 * insert
	 * @return array("viewid"=>$viewId,"emptype"=>$emptype,"empid"=>$empid,"status":1) status 0 exist 1 success
	 */
	function insert($viewId, $parentEmpType, $parentEmpId, $name, $description,$itemIndex = 1000,$isCreate = true) {
		$childEmpType = ($parentEmpType == 0) ? EMP_VIEW : EMP_DEPT;

		$tableName = $this->getTableName ( $childEmpType );

		// 判断是否存在
		$result = $this->getIdByName ( $parentEmpType, $parentEmpId, $childEmpType, 0, $name );

		if ($result) 
		{
            $result ["status"] = 0;
            return $result;
        }

		if ($isCreate) {
			// 添加数据
			$childEmpId = $this->db->getMaxId ( "Users_Ro", "TypeID" );
			if(empty($childEmpId)) $childEmpId=0;
			$childEmpId=$childEmpId+1;
			$childEmpId=$childEmpId+1000000;
			$childEmpId=substr($childEmpId,-6);
			$data = array (
					"TypeID" => $childEmpId,
					"TypeName" => $name,
					"ParentID" => $parentEmpId,
					"Description" => $description,
					"ItemIndex" => $itemIndex,
					"CreatorID"=>CurUser::getUserId(),
					"CreatorName"=>CurUser::getUserName()
			);

			//是域部门则标记 col_domainid 为 100
//			if($this->isLdap)
//				$data['col_domainid'] = 100;
//
//			if ($childEmpType == EMP_VIEW)
//				$data["col_type"] = 1;
//			if ($childEmpType == EMP_DEPT)
//				$data["col_style"] = 1;
			$params = $this->db->parseDataParam ( $data );
			$sql = $this->db->getInsertSQL ( "Users_Ro", $params );
//			echo $sql;
//			exit();
			$result = $this->db->execute ( $sql, $params );
			$user = new Model ( "Users_Ro" );
		    $user -> updateForm("Users_RoVesr");
//$this -> db -> execute($sql) ;
			if ($parentEmpType == 0)
				$viewId = $childEmpId;
//				// 添加关系
//			if ($childEmpType != EMP_VIEW) {
//				$sql = "insert into hs_relation(col_hsitemtype,col_hsitemid,col_dhsitemtype,col_dhsitemid,col_viewid,col_reltype) " . 
//				" values(" . $parentEmpType . "," . $parentEmpId . "," . $childEmpType . "," . $childEmpId . "," . $viewId . ",1)";
//
//				$this->db->execute ( $sql );
//			}
			return array (
					"viewid" => $viewId,
					"emptype" => $childEmpType,
					"empid" => $childEmpId,
					"status" => 1
			);
		} else {
			return array (
					"viewid" => $viewId,
					"emptype" => $childEmpType,
					"empid" => 0,
					"status" => 0
			);
		}
	}
	function update($viewId, $parentEmpType, $parentEmpId, $childEmpType, $childEmpId, $name, $description,$itemIndex = 1000) {
		$tableName = $this->getTableName ( $childEmpType );

		// 判断是否存在
		if ($this->isExist ( $parentEmpType, $parentEmpId, $childEmpType, $childEmpId, $name ) > 0)
			return "";

			// 正确
		$data = array (
				"col_name" => $name,
				"col_description" => $description,
				"col_itemindex" => $itemIndex
		);
		$params = $this->db->parseDataParam ( $data );
		$sql = $this->db->getUpdateSQL ( $tableName, $params, " where col_id=" . $childEmpId );

		$result = $this->db->execute ( $sql, $params );
		return $childEmpId;
	}

	/**
	 * isExist
	 * @return 0 not exist > 1 exist
	 */
	function isExist($parentEmpType,$parentEmpId,$childEmpType,$childEmpId,$empName)
	{
		$tableName = $this -> getTableName($childEmpType) ;

		$sql = " select count(*) as c from " . $tableName. " where TypeName='" . $empName . "'" ;

		//去掉自己
		if ($childEmpId > 0)
			$sql .= " and TypeID<>'" . $empId . "'" ;

		$count = $this -> db -> executeDataValue($sql) ;

		return $count > 0 ;
	}

	/**
	 * getIdByName 可以用于判断是否存在
	 *
	 * @return "" not exist 2_1 exist
	 */
	function getIdByName($parentEmpType, $parentEmpId, $childEmpType, $elseChildEmpId = 0, $empName = "") {
		$viewId = 0;
		//$tableName = $this->getTableName ( $childEmpType );

		$sql = " select TypeID as c from Users_Ro where TypeName='" . $empName . "' and ParentID='". $parentEmpId . "'";
//		echo $sql;
//		exit();
//		// 视图不需要到关系表中判断
//		if ($parentEmpType > 0)
//			$sql .= " and col_id In(select col_dhsitemid from hs_relation where col_hsitemtype=" . $parentEmpType . " and col_hsitemid=" . $parentEmpId . " AND col_dhsitemtype=" . $childEmpType . " )";
//		else
//			$sql .= " and col_type=1";    //排除群组等视图   2015.01.23
//			// 去掉自己
//		if ($elseChildEmpId > 0)
//			$sql .= " and col_id<>" . $elseChildEmpId;

		$id = $this->db->executeDataValue ( $sql );

		if ($parentEmpType == 0)
			$viewId = $id;

		if ($id)
			return array (
					"viewid" => $viewId,
					"emptype" => $childEmpType,
					"empid" => $id
			);
		else
			return "";
	}

	/**
	 * Delete View or Org
	 *
	 * @param mixed $childEmpType
	 * @param mixed $childEmpId
	 * @return 0 fail 1 success
	 */
	function delete($empType, $empId) 
	{
		// 判断是否有子节点
		/*
		$sql = " select count(*) from hs_relation where col_hsitemtype=" . $empType . " and col_hsitemid=" . $empId;
		$result = $this->db->executeDataValue ( $sql );
		if ($result > 0)
			return 0 ;
		*/
			
		//jc 20150608 判断是否有子节点，relation表可能不干净，与真实表关联
		if ($this -> checkHasChild($empType, $empId))
			return 0 ;


		$tableName = $this -> getTableName($empType) ;
		$sql = " delete from Users_Ro where TypeID='" . $empId . "'" ;
		return $this -> db -> execute($sql) ;

	}
	
	/**
	 method	判断是否有子节点
	 *
	 */
	function checkHasChild($empType, $empId)
	{
		//$sql_where  =  " where col_hsitemtype=" . $empType . " and col_hsitemid=" . $empId ;
		
		//判断人员
		$sql = " select count(*) as c from Users_ID where UppeID like '%" . $empId . "%'" ;
		$result = $this->db->executeDataValue ( $sql );
		if ($result > 0)
			return 1 ;
			
		//判断部门
		$sql = " select count(*) as c from Users_Ro where ParentID='" . $empId . "' " ;
		$result = $this->db->executeDataValue ( $sql );
		if ($result > 0)
			return 1 ;
		
		return 0 ;
	}


	/**
	 * Detail View or Org
	 *
	 * @param mixed $childEmpType
	 * @param mixed $childEmpId
	 * @return 0 fail 1 success
	 */
	function detail($empType, $empId) {
		//$tableName = $this->getTableName ( $empType );
		$sql = " select * from Users_Ro where TypeID='" . $empId . "'";
		return $this->db->executeDataRow ( $sql );
	}




	/*
	 * 得到子结点 return array id,name,empType,viewId,parentEmpType,parentEmpId,child
	 */
	function getChildData($empType, $empId, $isLoadUser = 0, $field_UserName = "",$viewType = 1,$viewOwnerId=0,$companyId=0) {
		if ($field_UserName == "")
			$field_UserName = "FcName";

		$childEmpType = ($this->getChildType ( $empType ));

		// get child
		//$sql = $isLoadUser ? "select (cc.c+dd.d) from (select count(*) as c from Users_ID where UppeID like '%".$empId."%') as cc,(select count(*) as d from Users_Ro where ParentID='".$empId."') as dd" : "select count(*) as c from Users_Ro where ParentID='".$empId."'";

		if ($childEmpType == EMP_VIEW)
		{
			switch (DB_TYPE)
			{
				case "access":
					$sql_view = " where ParentID='".$empId."' order by clng(ItemIndex) desc" ;
					break ;
				default:
					$sql_view = " where ParentID='".$empId."' order by CONVERT(int,ItemIndex) desc" ;
					break;
			}
			

			
			
			
			//if ($viewOwnerId > 0)
				//$sql_view .= " and col_ownerid=" . $viewOwnerId ;
			$sql = " select TypeID as id, TypeName as name ,4 as emptype,'' as loginname" .
				"  from Users_Ro " . $sql_view;
				
			//如果是群组，只显示我所在的群组
			if ($viewType == 8)
			{
				$userId = CurUser::getUserId();
				$sql = "Select TypeID as id, TypeName as name ,4 as emptype,'' as loginname from Clot_Ro as aa,Clot_Form as bb where bb.UserID='".$userId."' and aa.TypeID=bb.UpperID";
			}
//			
			//我的联系人
			if ($viewType == 2)
			{
				$userId = CurUser::getUserId();
				$sql = "Select aa.UserID as id ," . $field_UserName . "," . EMP_USER . " as empType, UserName as loginName from Users_ID as aa,Fav_Form as bb where bb.MyID='".$userId."' and aa.UserID=bb.UserID";
			}
		}
		else
		{		
			switch (DB_TYPE)
			{
				case "access":
					$sql = " select TypeID as id ,TypeName as name," . $childEmpType . " as empType,'' as loginName from Users_Ro where ParentID='".$empId."' order by clng(ItemIndex) desc";
					break ;
				default:
					$sql = " select TypeID as id ,TypeName as name," . $childEmpType . " as empType,'' as loginName from Users_Ro where ParentID='".$empId."' order by CONVERT(int,ItemIndex) desc";
					break;
			}
			
			if ($isLoadUser == 1) {
				$sql = " select * from (select TOP 100 percent TypeID as id ,TypeName as name," . $childEmpType . " as empType,'' as loginName from Users_Ro where ParentID='".$empId."') a";
				$sql .= " union all select * from (select TOP 100 percent UserID as id ," . $field_UserName . "," . EMP_USER . " as empType, UserName as loginName from Users_ID where UppeId like '%" . $empId . "%' and UserState=1) b";
				if ($viewType == 8) $sql = "Select aa.UserID as id ," . $field_UserName . "," . EMP_USER . " as empType, UserName as loginName from Users_ID as aa,Clot_Form as bb where bb.UpperID='".$empId."' and aa.UserID=bb.UserID";
			}
		}
		//$sql .=  " order by emptype desc,id " ;
		//echo $sql;
		//exit();
		$data = $this->db->executeDataTable ( $sql );

		return $data;
	}

	// 根据路径生成多级部门
	// $path: 触点软件/技术部
	// $isCreate: true 不存在则增加   false  仅查询
	// return: array("viewid"=>4,"emptype"=>2,"empid"=>1,"empname"=>"aaa")
	function getIdByPath($path, $isCreate = true,$itemIndex=1000) 
	{
		$arr_dept = explode ( "/", $path );
		$view_id = 0;
		$emp_type = 0;
		$emp_id = "000000";
		$parentEmpType=0;
		$parentEmpId=0;
//			echo var_dump($arr_dept);
//			exit();
		foreach ( $arr_dept as $key => $name ) {
			$result = $this->insert ( $view_id, $emp_type, $emp_id, $name, "", $itemIndex , $isCreate );
			
			//$key 为序号
			if($key==0)
				$view_id = $result ["viewid"];
			if($key==(count($arr_dept)-2)){
				$parentEmpType=$result ["emptype"];
				$parentEmpId = $result ["empid"];
			}
			$emp_type = $result ["emptype"];
			$emp_id = $result ["empid"];
		}

		$emp_name = $arr_dept[count($arr_dept) - 1] ;
		return array (
				"viewid" => $view_id,
				"emptype" => $emp_type,
				"empid" => $emp_id,
				"empname" => $emp_name,
				"parentemptype" => $parentEmpType,
				"parentempid" => $parentEmpId
		);
	}

	// 得到子孙结点
	// return: array(array("emptype"=>2,"empid"=>1,"empname"->"触点软件","path"->"触点软件","itemindex"->1))
	function get_all($empType = 0, $empId = 0)
	{
		$this->temp = array ();
		$this->path = "";
		$this->get_an_dept ( 0, "000000" );
		$this->temp = relation2path ( $this->temp );
		return $this->temp;
	}

	// 递归得到子数据
	function get_an_dept($empType, $empId) 
	{
		$parent_id = $empType . "_" . $empId;
		
		//$field = " col_id as id,col_name as name,col_itemindex as itemindex" ;
		
		//if ($empType == 0) 
		//	$sql = "select " . EMP_VIEW . " as emptype," . $field. " from hs_view where col_type=1 order by col_itemindex";
		//else 
			switch (DB_TYPE)
			{
				case "access":
					$sql = "select * from Users_Ro where ParentID='" . $empId . "' order by clng(ItemIndex) desc";
					break ;
				default:
					$sql = "select * from Users_Ro where ParentID='" . $empId . "' order by CONVERT(int,ItemIndex) desc";
					break;
			}

		$child = $this->db->executeDataTable ( $sql );
		foreach ( $child as $row ) 
		{
			//$empType = $row ["emptype"] ;
			$empId = $row ["typeid"] ;
			$this->temp [] = array (
					"emptype" => $empType,
					"empid" => $empId,
					"id" => $empType . "_" . $empId,
					"parent_id" => $parent_id,
					"name" => $row ["typename"],
					"itemindex" => $row ["itemindex"]
			);
			$this->get_an_dept ($empType, $empId);
		}
	}


    function getSubDeptByUser($userId)
    {
        $this -> deptIds = "";
        $sql = " select UppeID from Users_ID where UserID='" . $userId . "'";

        $data = $this -> db -> executeDataTable($sql) ;
        foreach ($data as $row)
		{
            $currEmpId = $row["uppeid"];
			$this -> deptIds .= ($this -> deptIds == ""?"":",") . "'" . $currEmpId . "'";
			
			$arr_success = explode(",",$currEmpId);
			foreach($arr_success as $value)
			{
				if ($value == "")
					continue ;
				$this -> getSubDept2($value);
			}
			
            
		}
        return $this -> deptIds;
    }
	
    function getSubDeptNameByUser($currEmpId)
    {
        $this -> deptNames = "";
		
		$arr_success = explode(",",$currEmpId);
		foreach($arr_success as $value)
		{
			if ($value == "")
				continue ;
			$this -> deptIds = "";
			$this -> getSubDept3($value);
			$this -> deptNames .= ($this -> deptNames == ""?"":",") . $this -> deptIds;
		}

        return $this -> deptNames;
    }

    function getSubDept($empType,$empId)
    {
		$this -> temp = array ();
        $this -> deptIds = "";
        $this -> getSubDept2($empType, $empId);
        return $this -> deptIds;
    }

    function getSubDept2($empId)
    {
        $sql = " select ParentID from Users_Ro where TypeID='" . $empId . "'";

        $data = $this -> db -> executeDataTable($sql) ;
        foreach ($data as $row)
        {
            $currEmpId = $row["parentid"];
            if ($currEmpId != "000000"){
				$this -> deptIds .= ($this -> deptIds == ""?"":",") . "'" . $currEmpId . "'";
                $this -> getSubDept2($currEmpId);
			}
        }
    }
	
    function getSubDept3($empId)
    {
        $sql = " select TypeName,ParentID from Users_Ro where TypeID='" . $empId . "'";

        $data = $this -> db -> executeDataTable($sql) ;
        foreach ($data as $row)
        {
            $currEmpId = $row["parentid"];
			$currEmpName = $row["typename"];
            //if ($currEmpId != "000000"){
				$this -> deptIds = $currEmpName . ($this -> deptIds == ""?"":"/") . $this -> deptIds;
                $this -> getSubDept3($currEmpId);
			//}
        }
    }
	
	function getPath($empType,$empId)
	{
		$data = $this -> get_all($empType,$empId);
		$path = "" ;
		foreach($data as $row)
		{
			//$path .= "/" . $row["emp
		}
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//得到子对象ID
	/////////////////////////////////////////////////////////////////////////////////////////////////////
    function getSubIds($empType, $empId, $subEmpType,$isInSelf)
    {
		global $ids ;
        $ids = "";
        $this -> getSubIds2($empType, $empId, $subEmpType);

        if ($isInSelf && ($empType == $subEmpType))
        {
            $ids = $empId . ($ids?",":"") . $ids;
        }
        return $ids;
    }

	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//得到子对象ID
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	function getSubIds2($parentEmpType,$parentEmpId,$subEmpType)
    {
		global $ids ;
		$sql = " select UserName from Users_ID where UppeID like '%" . $parentEmpId . "%'" ;
        $data = $this -> db -> executeDataTable($sql);
        foreach ($data as $row)
        {
            $UserName = $row["username"];
            $ids .= ($ids?",":"") . $UserName;
			$sql = " select * from Users_Ro where ParentID='" . $parentEmpId . "' " ;
			$child = $this->db->executeDataTable ( $sql );
			foreach ( $child as $ro_row ) 
			{
				$empId = $ro_row ["typeid"] ;
				$this -> getSubIds2($parentEmpType, $empId, $subEmpType);
			}
        }
    }
	
	/*
	method	生成部门数据，并生成路径，数据库读取少，效率高
			得到视图
			得到部门
			程序中找到路径
	return	array("id"=>"","path"=>"")
	*/
	function bulidPathData()
	{
		$data_relation = array();
		
		$db = new DB();
		
		//得到视图的数据
		$sql = " select col_id,col_name from hs_view where col_type=1" ;
		$data = $db -> executeDataTable($sql) ;
		foreach($data as $row)
		{
			$data_relation[] = array("id"=>4 . "_" . $row["col_id"],
									 "name"=>$row["col_name"],
									 "viewid"=>$row["col_id"],
									 "parent_id"=>"0"
									 );
		}
	
		//得到部门的数据(包括上级关系)
		$sql = " select A.col_id,A.col_name,col_hsitemtype,col_hsitemid,col_viewid from hs_group A,hs_relation B " . 
			   " where col_dhsitemtype=2 and A.col_id=b.col_dhsitemid " .
			   " and col_name<>'我的联系人'" .  //过滤掉个人视图
			   " order by col_id desc" ;
		$data = $db -> executeDataTable($sql) ;
		foreach($data as $row)
		{
			$data_relation[] = array("id"=>2 . "_" . $row["col_id"],
									 "name"=>$row["col_name"],
									 "viewid"=>$row["col_viewid"],
									 "parent_id"=>$row["col_hsitemtype"] . "_" . $row["col_hsitemid"]
									 );
		}
		
		$data_relation = relation2path($data_relation);
		
		return $data_relation ;
	}

	function getChildType($childEmpType)
	{
		switch($childEmpType)
		{
			case 0:
				return EMP_VIEW;
			case EMP_VIEW :
				return EMP_DEPT;
			default :
				return EMP_DEPT;
		}
	}
	function getTableName($empType) {
		switch ($empType) {
			case 0 :
				return "Users_Ro";
			case EMP_USER :
				return "HS_USER";
			case EMP_DEPT :
				return "Users_Ro";
			case EMP_ROLE :
				return "HS_ROLE";
			default :
				return "Users_Ro";
		}
	}
}

?>