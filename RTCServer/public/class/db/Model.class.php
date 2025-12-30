<?php
/**
 * 数据库操作类

 * @date    20140325
 */

class Model
{
	//数据库操作类
	public $db ;

	//表名
	public $tableName 	= "" ;
	//主键
	public $fldId 			= "UserID" ;

	public $field 		= "*" ;
	public $where 		= "" ;
	public $order 		= "" ;
	public $orderdesc 	= "" ;
	public $whereParam	= array() ;
	public $fieldParam	= array() ;

	public $_validate	=	array();

	function __construct($tableName,$fldId = "ID")
	{
		$this -> tableName = $tableName ;
		$this -> fldId = $fldId ;
		$this -> db = new DB();
		//$this -> DefaultRole = $this -> getDefaultRole();
	}

    /**
     * 设置显示字段
     * @param $field
     */
	function field($field)
	{
		$this -> field = $field ;
	}

    /**
     * 设置查询条件
     * @param $where
	 * @param $whereParam 如果是参数形式
     */
	function where($where,$whereParam = array())
	{
		$this -> where = $where ;
		$this -> whereParam = $whereParam ;
	}

    /**
     * 设置排序
     * @param $order
     */
	function order($order)
	{
		$this -> order = $order ;
	}
	
	function orderdesc($order)
	{
		$this -> orderdesc = $order ;
	}

	function addParamFields($fields)
	{
		foreach($fields as $key=>$value)
			$this -> addParamField($key,$value) ;
	}

    /**
     * 添加字段参数
     * $name 	字段
	 * $value 	值
	 * $type 	类型 int string date
     */
	function addParamField($name,$value,$type = "string" )
	{
		if ($name == "")
			return;
		$this -> fieldParam[$name] = array("name"=>$name,"value"=>$value,"type"=>$type) ;
	}

	function addParamWheres($fields)
	{
		foreach($fields as $key=>$value)
			$this -> addParamWhere($key,$value) ;
	}

    /**
     * 添加查询参数
     * $name 	字段
	 * $value 	值
	 * $op  	运算符	= <> ...
	 * $type 	类型 int string date
     */
	function addParamWhere($name,$value,$op = "=",$type = "string" )
	{
		$exp = $this -> db -> getSearchExp($name,$value,$op,$type);
		$this -> addWhere($exp);
	}


	function addWhere($where)
	{
		$this -> where .= (($this -> where == "")?" where ":" and ") . $where ;
	}

    /**
     * 将参数传到数据库参数
     */
	function bulidParam()
	{
		if ( empty($this -> fieldParam) && empty($this -> whereParam) )
			return array();
		$param = $this -> db -> unionParam($this -> fieldParam,$this -> whereParam) ;
		return $param ;
	}

    /**
     * 清除参数
     */
	function clearParam()
	{
		$this -> where = "" ;
		$this -> whereParam = array();
		$this -> fieldParam = array();
	}

    /**
     * 插入数据
     */
	function insert()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getInsertSQL($this -> tableName,$this -> fieldParam) ;
//		echo $sql;
//		exit();
		$this -> db -> execute($sql,$param) ;
	}
    /**
     * 插入用户数据
     */
	function insertPic($fldList)
	{
//		$sql = " select ".$fields.",A.PtpFolderID from PtpFolder A where " . $where ;
//		
//		$sql = "Delete from PtpFolder where MyID='".CurUser::getUserId()."' and PtpFolderID='".$ptpfolderid."'" ;
//		$this -> db -> execute($sql) ;
//			
//		$doc_dir = new DocDir();
//		$result = $doc_dir -> insert($parent_type,$parent_id,$name);
			
		$param = $this -> bulidParam();
		$sql = "insert into Users_Pic(UserID) values('" . $fldList . "')" ;
		$this -> db -> execute($sql,$param) ;
	}
	
    /**
     * 插入用户权限数据
     */
	function insertRole($fldList,$RoleID)
	{
		if ($RoleID == "") $RoleID = $this -> DefaultRole;
		$param = $this -> bulidParam();
		$sql = "insert into Users_Role(UserID,RoleID) values('" . $fldList . "'," . $RoleID . ")" ;
//		echo $sql;
//		exit();
		$this -> db -> execute($sql,$param) ;
	}

    /**
     * 更新数据
     */
	function update()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getUpdateSQL($this -> tableName,$this -> fieldParam,$this -> where) ;
//		echo $sql;
//		exit();
		$this -> db -> execute($sql,$param) ;
	}
	
    /**
     * 更新数据标识
     */
	function updateForm($fldList)
	{
		$param = $this -> bulidParam();
		$sql = "update UpDateForm set " . $fldList . "=" . $fldList . " + 1" ;
		$this -> db -> execute($sql,$param) ;
		setValue($fldList,$fldList);
//		switch ($fldList) {
//			case "Users_RoVesr" :
//				setValue("Users_Ro",$fldList);
//				break;
//			case "Users_IDVesr" :
//			    setValue("Users_ID",$fldList);
//				break;
//			case "Clot_RoVesr" :
//			    setValue("Clot_Ro",$fldList);
//				break;	
//			case "Clot_FormVesr" :
//			    setValue("Clot_Form",$fldList);
//				break;	
//		}
		
	}
	
	function updateUsers_IDForm($userid)
	{
		$param = $this -> bulidParam();
		$sql = "update Users_ID set Users_IDVesr=Users_IDVesr + 1 where UserID='".$userid."'" ;
		$this -> db -> execute($sql,$param) ;
	}
	
	function updateClot_RoForm($fldList,$typeid)
	{
		$param = $this -> bulidParam();
		$sql = "update Clot_Ro set " . $fldList . "=" . $fldList . " + 1 where TypeID='".$typeid."'" ;
		$this -> db -> execute($sql,$param) ;
	}


    /**
     * 删除数据
     */
	function delete()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getDeleteSQL($this -> tableName,$this -> where) ;
		$this -> db -> execute($sql,$param) ;
	}
	
    /**
     * 删除用户权限数据
     */
	function delete_Role($fldList)
	{
		$param = $this -> bulidParam();
		$sql = "delete from Users_Role where UserID='". $fldList ."'" ;
//		echo $sql;
//		exit();
		$this -> db -> execute($sql,$param) ;
	}

    /**
     * 查询数据
	 * @return array
     */
	function getList()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getSelectSQL($this -> tableName,$this -> field,$this -> where,$this -> order);
		//		echo $sql;
//		exit();
		return $this -> db -> executeDataTable($sql,$param) ;
	}

    /**
     * TOP数据
	 * @param $top 前几条
	 * @return array
     */
	function getTop($top)
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getTopSQL($this -> tableName,$this -> field,$this -> where,$this -> order,$top) ;
//						echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql,$param) ;
		return $data ;
	}

    /**
     * 分页数据
	 * @param $pageIndex 从1页开始
	 * @param $pageSize 页数
	 * @return array
     */
	function getPage($pageIndex,$pageSize,$count)
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getPageSQL($this -> tableName,$this -> fldId,$this -> field,$this -> where,$this -> order,$this -> orderdesc,$pageIndex,$pageSize,$count) ;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql,$param) ;
		//$data = $this -> db -> execute($sql,$params,1,0);
//		echo var_dump($data);
//exit();
		return $data ;
	}
	
	function getMsgPage($pageIndex,$pageSize,$count)
	{
		$this -> db = new DB();
		$param = $this -> bulidParam();
		$sql = $this -> db -> getPageSQL($this -> tableName,$this -> fldId,$this -> field,$this -> where,$this -> order,$this -> orderdesc,$pageIndex,$pageSize,$count) ;
//		echo $sql;
//		exit();
        $data = $this -> db -> dbEntity -> executeMsg($sql,$params);
		return $data ;
	}

    /**
     * 统计数量
	 * @return int
     */
	function getCount()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getSelectSQL($this -> tableName,"count(*) as c ",$this -> where);
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataValue($sql,$param) ;
		return $data ;
	}

    /**
     * 得到某一条
	 * @return array
     */
	function getDetail()
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getSelectSQL($this -> tableName,$this -> field,$this -> where);
//				echo $sql;
//		exit();
//file_put_contents("F:/php/RTCServer/Web/Data/7.log", $sql . PHP_EOL, FILE_APPEND);
		$data = $this -> db -> executeDataRow($sql,$param) ;
		return $data ;
	}

    /**
     * 得到某列数据
	 * @return 多行以 ,号分
     */
	function getField($field)
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getSelectSQL($this -> tableName,$field,$this -> where);
		$data = $this -> db -> executeDataTable($sql,$param) ;
		$result  = "" ;

		foreach($data as $row )
		{
			if ($result != "")
				$result .= "," ;
			$result .= $row[0] ;
		}
		return $result ;
	}

    /**
     * 得到某值
	 * @return 多行以 ,号分
     */
	function getValue($field)
	{
		$param = $this -> bulidParam();
		$sql = $this -> db -> getSelectSQL($this -> tableName,$field." as c",$this -> where);
		$data = $this -> db -> executeDataValue($sql,$param) ;
		return $data ;
	}

    /**
     * 得到默认角色
	 * @return 多行以 ,号分
     */
	function getDefaultRole()
	{
		$param = $this -> bulidParam();
		$sql = "Select ID as c from Role where DefaultRole=1";
		$data = $this -> db -> executeDataValue($sql,$param) ;
		return $data ;
	}

    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSave($op = "",$fldId = "" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields($keyfields_str,$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>$checkFields);
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;


		// save
		if ($op == "create")
		{
			$user_id = $this -> getMaxId();
			if(empty($user_id)) $user_id=0;
			$user_id=$user_id+1;
		    $my = getEmpInfo(g("deptid"));
			$this -> addParamField("UppeID",$my["empid"]);
			$this -> addParamField("UserID",$user_id);
			
			$result = $this -> insert();
			$id = $user_id;
		}
		else
		{
			$this -> addParamWhere($fldId,$id) ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSaveRole($op = "",$fldId = "ID" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields($keyfields_str,$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>$checkFields);
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;


		// save
		if ($op == "create")
		{
			$result = $this -> insert();
			$id = $this -> getMaxId();
		}
		else
		{
			$this -> addParamWhere($fldId,$id,"=","int") ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
	
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSaveGroup($op = "",$fldId = "" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields($keyfields_str,$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>$checkFields);
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;


		// save
		if ($op == "create")
		{
//			$sql = " select max(TypeID) as c from Clot_Ro";
//		    $types =$this -> db -> executeDataValue($sql);
//			if(empty($types)) $types="Clot000000";
//			$newid=substr($types,-6);
//			$newid=$newid+1;
//			$newid=$newid+1000000;
//            $ClotIDS="Clot".substr($newid,-6);
			$groupId = $this ->getGroupId();
			$this -> addParamField("TypeID",$groupId);
			
			$result = $this -> insert();
			$id = $groupId;
		}
		else
		{
			$this -> addParamWhere("TypeID",$id) ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSaveGrant($op = "",$fldId = "ID" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields("userid",$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>"user_key");
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;


		// save
		if ($op == "create")
		{
			$result = $this -> insert();
			$id = $this -> getMaxId();
		}
		else
		{
			$this -> addParamWhere($fldId,$id,"=","int") ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSaveAddin($op = "",$fldId = "Plug_ID" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields("plug_name",$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>"plug_name");
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;


		// save
		if ($op == "create")
		{
			$sql = " select max(Plug_Index)+1 as c from Plug";
		    $Plug_Index =$this -> db -> executeDataValue($sql);
			$this -> addParamField("Plug_Index",$Plug_Index);
			
			$result = $this -> insert();
			$id = $this -> getMaxId();
		}
		else
		{
			$this -> addParamWhere($fldId,$id,"=","int") ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
	
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSaveAddinVesr($op = "",$fldId = "" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",","plug_bie");
		$fieldtypes = explode(",","int");

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkAddinVesr("plug_bie",$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "") return;

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,$fldId,$fieldtypes[$key]) ;


		// save
		if ($op == "create") $this -> insert();

	}
    /**
     * 自动保存数据
	 * @return status   msg
     */
	function autoSavePlug($op = "",$fldId = "Plug_ID" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "")
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");
		print $flitersql;

		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}

		// Bulid Param
		$this -> clearParam();
		$i = 0;
		foreach ($fields as $key=>$field)
		{
			$sql[$i] = " update Role set Plug='" . f($field) . "' where RoleName ='" . $field . "'";
			$i++;
		}
		$this -> db -> execute($sql);
		return array("status"=>1,"id"=>$id);

	}
	
    /**
     method	自动保存数据
	 param	$op					create/edit
	 param	$fieldId			col_id
	 param	$fields_str 		col_loginname,col_name,col_sex
	 param	$keyfields_str		col_loginname
	 param	$flitersql		
	 param	$fieldtypes_str		string,string,int
	 param	$fields_append 		array(array("name"=>$name,"value"=>$value,"type"=>$type),...)
	 return array(status=>1,msg=>"")
     */
	function autoSave1($op = "",$fldId = "" ,$fields_str = "",$keyfields_str = "",$flitersql = "",$fieldtypes_str = "",$fields_append = array())
	{
		//auto get
		if ($op == "")
			$op = g("op") ;
		if ($fldId == "")
			$fldId = $this -> fldId;

		//字段
		if ($fields_str == "")
			$fields_str = f("fields");

		//字段类型
		if ($fieldtypes_str == "")
			$fieldtypes_str = f("fieldtypes");

		//关键字段
		if ($keyfields_str == "")
			$keyfields_str = f("keyfields");

		//关键字段判断条件
		if ($flitersql == "")
			$flitersql = g("flitersql");


		$fields = explode(",",$fields_str);
		$fieldtypes = explode(",",$fieldtypes_str);

		$id = f("id",0);

		//format fieldtypes 由index变成key
		$i = 0 ;
		foreach($fields as $key=>$field)
		{
			$fieldtype = "string" ;
			if (isset($fieldtypes[$i]) )
				$fieldtype = $fieldtypes[$i] ;
			$fieldtypes[$key] = $fieldtype ;
			$i += 1 ;
		}


		//CheckField is Exist
		$checkFields = $this -> checkKeyFields($keyfields_str,$flitersql,$fldId,$id,$fieldtypes);
		if ($checkFields != "")
		{
			$result = array("status"=>0,"msg"=>$checkFields);
			return $result ;
		}

		// Bulid Param
		$this -> clearParam();
		foreach($fields as $key=>$field)
			$this -> addParamField($field,f($field),$fieldtypes[$key]) ;

		// 添加附加字段
		foreach($fields_append as $field)
			$this -> addParamField($field["name"],$field["value"],$field["type"]) ;


		// save
		if ($op == "create")
		{
			$result = $this -> insert();
			$id = $this -> getMaxId();
		}
		else
		{
			$this -> addParamWhere($fldId,$id) ;
			$result = $this -> update();
		}

		return array("status"=>1,"id"=>$id);

	}
    /**
     * 检查是否重复
	 * @return status   msg
     */
	function checkKeyFields($keyfields_str,$flitersql,$fldId,$id = 0,$fieldtypes = array())
	{
		$result = "" ;

		if ($keyfields_str == "")
			return "";

		$keyfields = explode(",",$keyfields_str);
		foreach($keyfields as $key=>$field)
		{
			if ($field == "")
				continue ;

			$fieldtype = "string" ;
			if (isset($fieldtypes[$key]) )
				$fieldtype = $fieldtypes[$key] ;

			$this -> clearParam();
			$this -> addParamWhere($field,f($field),"=",$fieldtype);
			if ($id != 0)
				$this -> addParamWhere($fldId,$id,"<>");

			$c = $this -> getCount();

			if ($c>0)
			{
				if ($result != "")
					$result .= ";" ;
				$result .= $field ;
			}
		}

		return $result ;
	}
	
	    /**
     * 检查是否重复
	 * @return status   msg
     */
	function checkAddinVesr($keyfields_str,$flitersql,$fldId,$id = 0,$fieldtypes = array())
	{
		$result = "" ;

		if ($keyfields_str == "")
			return "";

		$keyfields = explode(",",$keyfields_str);
		foreach($keyfields as $key=>$field)
		{
			if ($field == "")
				continue ;

			$fieldtype = "string" ;
			if (isset($fieldtypes[$key]) )
				$fieldtype = $fieldtypes[$key] ;

			$this -> clearParam();
			$this -> addParamWhere($field,$fldId,"=",$fieldtype);
			if ($id != 0)
				$this -> addParamWhere($fldId,$id,"<>");

			$c = $this -> getCount();

			if ($c>0)
			{
				if ($result != "")
					$result .= ";" ;
				$result .= $field ;
			}
		}

		return $result ;
	}


	function getMaxId()
	{
		return $this -> db -> getMaxId($this -> tableName,$this -> fldId) ;
	}

	function swap($fld_swap,$curr_id,$curr_value,$swap_id,$swap_value)
	{
		$this -> setAddinValue($curr_id,$fld_swap,$swap_value);
		$this -> setAddinValue($swap_id,$fld_swap,$curr_value);
		return 1 ;
	}

	function setValue($id,$fld_name,$fld_value)
	{
		if (strpos($id,",")>0)
			$sql =  ($this -> fldId) . " in ('" . str_replace(",","','",$id) . "')" ;
		else
			$sql =  ($this -> fldId) . " ='" . $id . "'" ;
			
		$sql = " update " . ($this -> tableName) . " set " . $fld_name . "='" . $fld_value . "' where " . $sql;
//		echo $sql;
//		exit();
		return $this -> db -> execute($sql);
	}
	
	function setValue1($id,$fld_name,$fld_value)
	{
		if (strpos($id,",")>0)
			$sql =  ($this -> fldId) . " in (" . $id . ")" ;
		else
			$sql =  ($this -> fldId) . " =" . $id ;
			
		$sql = " update " . ($this -> tableName) . " set " . $fld_name . "=" . $fld_value . " where " . $sql;
//		echo $sql;
//		exit();
		return $this -> db -> execute($sql);
	}
	
	function setDefaultRole($id,$fld_name,$fld_value)
	{
		$sql = " update " . ($this -> tableName) . " set " . $fld_name . "=0";
		$this -> db -> execute($sql);	
		$sql = " update " . ($this -> tableName) . " set " . $fld_name . "=" . $fld_value . " where " . ($this -> fldId) . " =" . $id;
//		echo $sql;
//		exit();
		return $this -> db -> execute($sql);
	}
	
	function setAddinValue($id,$fld_name,$fld_value)
	{
		if (strpos($id,",")>0)
			$sql =  ($this -> fldId) . " in (" . $id . ")" ;
		else
			$sql =  ($this -> fldId) . " =" . $id . "" ;
			
		$sql = " update " . ($this -> tableName) . " set " . $fld_name . "=" . $fld_value . " where " . $sql;
//		echo $sql;
//		exit();
		return $this -> db -> execute($sql);
	}
	/*
	*设置关联数据
	*$tableName : hs_relation
	*$field_key : {col_hsitemtype->2,col_hsitemid->1,col_dhsitemtype->1}
	*$field_data: col_hsitemid
	*$my_ids: 1,2,3
	*$field_other:{col_reltype->1,col_ref->1}
	*$flag  0 append  1 reset
	*return  {"add"=>$arr_insert,"delete"=>$arr_delete} 
	*/
	function setRelationData($field_keys,$field_data,$my_ids,$field_others,$flag = 0)
	{
		//得到数据库的内容
		$this -> clearParam();
		$this -> addParamWheres($field_keys);
		$this -> field($field_data) ;
		$data = $this -> getList();

		$ids_db = $this -> db -> getColumnValues($data,$field_data) ;
		
		//比较数据 得到INSERT IDS 与DELETE IDS
		$arr_db = explode(",",$ids_db);
		$arr_my = explode(",",$my_ids);
		$arr_delete = array_diff($arr_db, $arr_my) ;
		$arr_insert = array_diff($arr_my, $arr_db) ;

		//DELETE DATA 重置数据，先删除后加添
		$ids_delete = implode(",",$arr_delete) ;
		if (($flag == 1) && ($ids_delete != ""))
		{
			$this -> addParamWhere($field_data,$ids_delete,"in","int");
			$this -> delete();
		}

		//INSERT DATA 删除数据
		foreach($arr_insert as $id)
		{
			$this -> clearParam();
			$this -> addParamFields($field_keys);
			$this -> addParamFields($field_others);
			$this -> addParamField($field_data,$id);
			$this -> insert();
		}
		
		return array("add"=>$arr_insert,"delete"=>$arr_delete) ;
	}
}

?>