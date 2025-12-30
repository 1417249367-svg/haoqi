
<?php

//导入导出消耗的时候较多，设置无时间限制
set_time_limit(0);

/*-------------------------------------------
人员模型
组织导入导出
deptid,deptname,parent_deptid
userid,username,deptid
---------------------------------------------*/
class HS
{

	//数据库操作类
	public $db ;
 	public $dept ;
	public $relation ;
	public $fields_user = array();
	public $fields_rtxuser = array();
	public $index_loginname = 0 ; 	//col_loginname 在 EXPORT_USER_FIELD 中的index
	public $index_deptpath = 0 ; 	//部门路径都放在 EXPORT_USER_FIELD 的最前面
	public $valid_user_exist = 0 ;  //验证是否存在（在初始化时，不需要验证）
	public $isLdap = false;     //域同步标记

	function __construct()
	{
		$this -> db = new DB();
		$this -> dept = new Department();
		$this -> relation = new EmpRelation();

		$this -> fields_user = explode(",",EXPORT_USER_FIELD) ;
		$this -> fields_rtxuser = explode(",",EXPORT_USER_FIELD.",Constellation,Tel2,UserState,UserID") ;
		$this -> index_deptpath = 0 ;
		$this -> index_loginname = array_value_index("UserName",$this -> fields_user) + 1; //第一列为部门
		$this -> index_fcname = array_value_index("FcName",$this -> fields_user) + 1;
		$this -> index_userid = array_value_index("UserID",$this -> fields_user) + 1;

	}


	/*
	method：检查数据格式是否正确
	*/
	function check_user_data($data)
	{
		if (count($data) == 0)
			return array("status"=>0,"msg"=>get_lang("class_hs_warning2"));
	
		//采用系统的导入用户字段
//		if($this->isLdap)
//			$this -> fields_user = explode(",",EXPORT_USER_FIELD . ",col_userdata") ;
		
		//判断列数是否正确 第一列固定为部门列	
		if (! valid_column_length($data,count($this -> fields_user) + 1))
			return $result = array("status"=>0,"msg"=>get_lang("class_hs_warning"));

		return array("status"=>1,"msg"=>"");
	}

	/*
	method:生成人员插入SQL dept,EXPORT_USER_FIELD
	param:$data   array(array(deptname,loginname,username...),array(deptname,loginname,username...))
	param:$user_table 因为有可能先到临时表
	*/
	function bulid_insert_user($data,$user_table = "hs_user")
	{
		$sqls = array();

		//生成字段名
		$field_names = "col_deptinfo" . array2str($this -> fields_user,",") ;
		
		foreach($data as $row)
		{
			$field_values = $this -> bulid_insert_user_value($row);
			$sql = " insert into " . $user_table . "(" . $field_names . ") values(" . $field_values . ")" ;
			$sqls[] =  $sql ;
		}
		
		return $sqls ;
	}
	
	/*
	method:生成人员插入值
	param:$row  array(deptname,loginname,username...)
	*/
	function bulid_insert_user_value($row)
	{
		$field_values = "" ;
		foreach($row as $key=>$value)
		{
			$field_values .= ($field_values?",":"") .  "'" . $value . "'" ;
		}
		return $field_values ;
	}
	
	/*
	method:判断用户是否存在
	param:$row  array(deptname,loginname,username...)
	*/
	function is_exists_user($row)
	{
		$loginname = $row[$this -> index_loginname] ;
		$sql = " select count(*) as c from hs_user where col_loginname='" . $loginname . "'" ;
		$count = $this -> db -> executeDataValue($sql);
		return $count > 0 ;
	}

	/*
	method:用户导入 array to db
	param:$data  array(array(deptname,loginname,username...),array(deptname,loginname,username...))
	*/
	function import_user($data)
	{
		error_reporting(0);
		$result = $this -> check_user_data($data);

		if ($result["status"] == 0)
			return $result ;


		//用于存放部门信息，优化
		hash_clear();

		foreach($data as $row)
		{
			//是否有deptpath列
			if (count($row)>= $this -> index_deptpath) $dept_id = $this -> import_an_dept($row[$this -> index_deptpath]);
			//导入用户
			if ($dept_id) $user_id = $this -> import_an_user($row,$dept_id);
		}

		return $result ;
	}


	/*
	method:导入用户(不进行是否存在的判断)
	*/
	function import_user_quick($data)
	{
		error_reporting(0);
		$result = $this -> check_user_data($data);
		recordLog($result);
		if ($result["status"] == 0)
			return $result ;

		$sqls = array();
		$sqls[] = "SELECT * into tbl_temp FROM hs_user WHERE 1=2";

		define("FIELD_DEPT_INFO","col_deptinfo");

		//生成导入HS_USER的SQL
		$field_names = FIELD_DEPT_INFO ;
		foreach($this -> fields_user as $field)
			$field_names .= "," .  $field ;
		foreach($data as $row)
		{
			$field_values = "" ;
			foreach($row as $key=>$value)
			{
				if($key ==3 && trim($value)=="")
					$value = 0;
				$field_values .= ($field_values?",":"") .  "'" . $value . "'" ;
			}
			$sql = " insert into hs_user(" . $field_names . ",col_) values(" . $field_values . ")" ;
			$sqls[] =  $sql ;
		}
		$this -> db -> execute($sqls);

		//分组得到部门
		$sql = " select " . FIELD_DEPT_INFO . " from hs_user where " . FIELD_DEPT_INFO . "<>'' group by " . FIELD_DEPT_INFO ;
		$data_dept = $this -> db -> executeDataTable($sql);
		foreach($data_dept as $key=>$row)
		{
			//创建部门
			$deptinfo = $this -> dept -> getIdByPath($row[FIELD_DEPT_INFO]);
			$data_dept[$key]["deptinfo"] = $deptinfo;

		}


		//批量生成relation
		$sqls = array();
		foreach($data_dept as $row)
		{
			$deptinfo = $row["deptinfo"] ;
			$where = " where " . FIELD_DEPT_INFO . "='" . $row[FIELD_DEPT_INFO] . "'" ;
			//生成relation
			$sql = " insert into hs_relation(col_hsitemtype,col_hsitemid,col_viewid,col_reltype,col_dhsitemtype,col_dhsitemid,col_dhsitemname) " .
			   " select " . $deptinfo["emptype"] . "," . $deptinfo["empid"] . "," . $deptinfo["viewid"] . ",1,1,col_id,col_name from hs_user   " . $where;
			$sqls[] = $sql ;

			//update hs_user
			$sql = " update hs_user set col_deptinfo='" . $deptinfo["empname"] . "',col_deptid=" . $deptinfo["empid"] . " where " . $where;
			$sqls[] = $sql ;
		}
		$this -> db -> execute($sqls);

		return $result ;
	}
	




	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//导入用户 返回用户ID
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	function import_an_user($row,$dept_id)
	{
		Global $valid_user_exist ;

		$count_field = count($this -> fields_user) ;

		if (count($row)<= $count_field)
			return 0 ;
			
		if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $row[$this -> index_loginname]) > 0) return 0 ;
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $row[$this -> index_fcname]) > 0) return 0 ;

		$user = new Model("Users_ID","UserID");
		//判断用户是否存在
		$user_id = 0 ;
		$user -> clearParam();
		$user -> addParamWhere("UserName",$row[$this -> index_loginname]);
		$valid_user_exist = $user->getCount()>0 ? true : false;
		
		
		if ($valid_user_exist)
		{
			recordLog($row[$this -> index_loginname] . get_lang("class_hs_warning1"));
			$user -> clearParam();
			$user -> addParamWhere("UserName",$row[$this -> index_loginname]);
			$user_id = $user -> getValue("UserID");
		}
//		echo $user_id;
//		exit();
		if (! $user_id)
		{
			//不存在 新增
			$user -> clearParam();
			
			$user_id = $user -> getMaxId();
			if(empty($user_id)) $user_id=0;
			$user_id=$user_id+1;
		    $my = getEmpInfo($dept_id);
			$user -> addParamField("UppeID",$my["empid"]);
			$user -> addParamField("UserID",$user_id);
			for($i=0;$i<=$count_field;$i++)
			{
				if($this -> fields_user[$i]=="UserIco")
				{
					if(trim($row[$i+1]) == "") $row[$i+1] = 1;
					$user -> addParamField($this -> fields_user[$i],$row[$i+1],"int");
				}
				else $user -> addParamField($this -> fields_user[$i],$row[$i+1]);

				//是域用户则标记 col_domainid 为 100
				//if($this->isLdap)
				//	$user -> addParamField("col_domainid",100,"int");
			}
			$user -> insert();
			$user -> insertPic($user_id);
			$PtpFolder = new User ();
			$PtpFolder -> insert2("RTC",$user_id);
			$PtpFolder -> insert3("RTC",$user_id);
			$DefaultRole = $user -> getDefaultRole();
			$user -> insertRole($user_id,$DefaultRole);
			$user -> updateForm("Users_IDVesr");


		}
		else
		{
			//存在 更新
			//$user -> addParamWhere("col_id",$user_id);
			//$user -> update();
		}

		return $user_id ;
	}
	
	function import_an_rtxuser($row)
	{
		Global $valid_user_exist ;

		$count_field = count($this -> fields_rtxuser) ;
//		echo var_dump($this -> fields_rtxuser);
//echo $row[$this -> index_loginname].'|'.$count_field,'<br>';
//exit();
		if (count($row)<= $count_field)
			return 0 ;
			
		if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $row[$this -> index_loginname]) > 0) return 0 ;
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $row[$this -> index_fcname]) > 0) return 0 ;

		$user = new Model("Users_ID","UserID");
		//判断用户是否存在
		$user_id = 0 ;
		$user -> clearParam();
		$user -> addParamWhere("UserName",$row[$this -> index_loginname]);
		$valid_user_exist = $user->getCount()>0 ? true : false;
		
		
		if ($valid_user_exist)
		{
			recordLog($row[$this -> index_loginname] . get_lang("class_hs_warning1"));
			$user -> clearParam();
			$user -> addParamWhere("UserName",$row[$this -> index_loginname]);
			$user_id = $user -> getValue("UserID");
		}
//		echo $user_id;
//		exit();
		if (! $user_id)
		{
			//不存在 新增
			$user -> clearParam();
			
			$user_id = $row[$this -> index_userid];
//			if(empty($user_id)) $user_id=0;
//			$user_id=$user_id+1;
//			$user -> addParamField("UserID",$user_id);
            $user -> addParamField("UppeID","000001");
			for($i=0;$i<=$count_field;$i++)
			{
				if($this -> fields_rtxuser[$i]=="UserIco")
				{
					if(trim($row[$i+1]) == "") $row[$i+1] = 1;
					$user -> addParamField($this -> fields_rtxuser[$i],$row[$i+1],"int");
				}
				else $user -> addParamField($this -> fields_rtxuser[$i],$row[$i+1]);

				//是域用户则标记 col_domainid 为 100
				//if($this->isLdap)
				//	$user -> addParamField("col_domainid",100,"int");
			}
			$user -> insert();
			$user -> insertPic($user_id);
			$PtpFolder = new User ();
			$PtpFolder -> insert2("RTC",$user_id);
			$PtpFolder -> insert3("RTC",$user_id);
			$DefaultRole = $user -> getDefaultRole();
			$user -> insertRole($user_id,$DefaultRole);

		}
		else
		{
			//存在 更新
			//$user -> addParamWhere("col_id",$user_id);
			//$user -> update();
		}

		return $user_id ;
	}

  
	/*
	method:创建一个部门  每次导入都会放到内存中，先判断内存是否存在，存在则返回
	param:$path 触点软件/技术中心
	*/
	function import_an_dept($path)
	{
		if (trim($path) == "")
			return "" ;

		//先从内存中取数据,重复数据放到内存中
		$node_id = hash_get($path);

		if ($node_id == "null")
		{
			$data = $this -> dept -> getIdByPath($path);
			$node_id = getEmpId($data["viewid"],$data["emptype"],$data["empid"]) ;
			hash_add($path,$node_id);
		}
		return $node_id ;
	}

	//导入关系
	function import_an_relation($node_id,$user_id)
	{
		//没有部门
		if ($node_id == "")
			return 1 ;

		$parent = getEmpInfo($node_id);
		$this -> relation -> insert($parent["viewid"],$parent["emptype"],$parent["empid"],"",EMP_USER,$user_id,"") ;

		return 1;
	}

	//用户导入 array to db
	//id,name,parent_id
	function import_dept($data)
	{
		$result = array("status"=>1,"msg"=>"");

		if (count($data) == 0)
		{
			$result = array("status"=>0,"msg"=>get_lang("class_hs_warning2"));
			return $result ;
		}
		else
		{
			$row = $data[0] ;
			if (count($row) < 3)
			{
				$result = array("status"=>0,"msg"=>get_lang("class_hs_warning"));
				return $result ;
			}
		}

		
		//先解释成路径格式
		$data = relation2path($data);
		$data_path = array();

		foreach($data as $row)
			$data_path[] = $row["path"] ;

		//根据路径导入
		$this -> import_dept_bypath($data_path);

		return $result ;
	}

	//用户导入 array to db
	//dept_path (触点软件_技术中心)
	function import_dept_bypath($data)
	{
		$result = array("status"=>1,"msg"=>"");

		if (count($data) == 0)
		{
			$result = array("status"=>0,"msg"=>get_lang("class_hs_warning2"));
			return $result ;
		}
		foreach($data as $key => $row)
		{
			//jc 20150610 增加部门排序(支持带itemindex与不带)
			$path = $row[0];
			if (count($row) > 1)
				$itemindex = $row[1];
			else
				$itemindex = 1000 ;
			if(!$itemindex) $itemindex = 1000 ;
//			echo $path;
//			exit();
			$node = $this -> dept -> getIdByPath($path,true,$itemindex);
		}

		return $result;
	}

	//烽火定制
	function import_dept_bypath2($data)
	{
	    Global $arrDept;
	    $result = array("status"=>1,"msg"=>"");

	    if (count($data) == 0)
	    {
	        $result = array("status"=>0,"msg"=>get_lang("class_hs_warning2"));
	        return $result ;
	    }

	    foreach($data as $row)
	    {
            $arr_temp = explode("/",$row['path']);
	        $node = $this -> dept -> getIdByPath($row['path'],true,$row['itemIndex']);
	        $node_id = getEmpId($node["viewid"],$node["emptype"],$node["empid"]) ;
            $arrDept[$row['path']] = array('viewid' => $node["viewid"],'empid' => $node["empid"],'emptype' => $node["emptype"], 'empname' => $arr_temp[count($arr_temp)-1]);
	    }


	    return $result;
	}





	//导出用户 db to array 用户需带 dept_path ,否则无法导入
	//要导出 dept_path,需从部门找用户，因为用户属于多个部门
	function export_user($empType = 0,$empId=0,$where = "")
	{
		$data_dept = $this -> dept -> get_all($empType,$empId) ;
		$data = array();
		//根据部门得到用户
		foreach($data_dept as $row_dept)
		{
			$curr_empType 	= $row_dept["emptype"] ;
			$curr_empId 	= $row_dept["empid"] ;
			$path 			= $row_dept["path"] ;
			$sql = " select " . EXPORT_USER_FIELD . " from Users_ID where UppeID like '%" .  $curr_empId . "%'" ;
			if ($where)
				$sql .= $where ;
			$data_user = $this -> db -> executeDataTable($sql);
			$data = $this -> fill_user_data($data_user,$path,$data);

		}
//        echo var_dump($data);
//		exit();
//		//添加不在任何部门下的人员
//		if (($empType == 0) && ($where == ""))
//		{
//			$sql = " select " . EXPORT_USER_FIELD . " from hs_user where col_id not in " .
//				"( select col_dhsitemid from hs_relation where col_dhsitemtype=" . EMP_USER  . ")" ;
//			$data_user = $this -> db -> executeDataTable($sql);
//			$data = $this -> fill_user_data($data_user,"",$data);
//		}
		return $data ;
	}

	function export_user_bywhere($where,$path)
	{
		$data = array();

		$sql = " select " . EXPORT_USER_FIELD . " from Users_ID " . $where ;
		$data_user = $this -> db -> executeDataTable($sql);


		$data = $this -> fill_user_data($data_user,$path,$data);

		return $data ;

	}
	
	function export_user_byonline($where)
	{
		$data = array();

		$sql = " select * from Users_ID " . $where ;
		$data_user = $this -> db -> executeDataTable($sql);

		$dept = new Department();
		foreach($data_user as $k=>$v){
			$data_user[$k]['path'] = $dept -> getSubDeptNameByUser($data_user[$k]['uppeid']);
			
			switch ($data_user[$k]['userico'])
			{
				case "1":
					$data_user[$k]['userico']=get_lang("user_edit_lb_gender1");
					break ;
				case "2":
					$data_user[$k]['userico']=get_lang("user_edit_lb_gender2");
					break ;
				default:
					$data_user[$k]['userico']="";
					break;
			}
			
			switch ($data_user[$k]['usericoline'])
			{
				case "1":
					$data_user[$k]['usericoline']=get_lang("online_list_table_usericoLine1");
					break ;
				case "2":
					$data_user[$k]['usericoline']=get_lang("online_list_table_usericoLine2");
					break ;
				case "3":
					$data_user[$k]['usericoline']=get_lang("online_list_table_usericoLine3");
					break ;
			}
			
		}

		return $data_user ;

	}

	//将用户填充到总的数据列表中
	function fill_user_data($curr_data,$dept_path,$total_data)
	{
		//$curr_data = table_fliter_doublecolumn($curr_data); //executeDataTable表格的列是重复的，index fieldname,去掉index列
		foreach($curr_data as $curr_row)
		{
			$curr_row =	array_merge(array($dept_path),$curr_row) ;
			$total_data[] = $curr_row ;		  //将部门下的人员添加到总的人员列表

		}
		return $total_data ;
	}


	//导出部门	db to array
	function export_dept($empType = 0,$empId=0)
	{
		$data_all = $this -> dept -> get_all($empType,$empId) ;
		$data_all = relation2path($data_all);

		//jc 20150610 增加 itemindex 导出
		$data = array();
		foreach($data_all as $row)
			$data[] = array("path"=>$row["path"],"itemindex"=>$row["itemindex"]);

		return $data ;
	}

	function import_user_to_tmp($row,$modifyTime = "" ){

	    $count_field = count($this -> fields_user) ;

	    if (count($row)<= $count_field)
	        return 0 ;


	    $m = new Model("temp_user");
	    $m -> clearParam();
	    for($i=0;$i<=$count_field;$i++)
	    {
    	    if($this -> fields_user[$i]=="col_sex" && trim($row[$i+1]) == "")
    	        $row[$i+1] = 0;
	        $m -> addParamField($this -> fields_user[$i],$row[$i+1]);
	    }
	    $m->addParamField("col_deptinfo", $row[0]);
	    $m->addParamField("col_dt_modify", $modifyTime);
	    $m -> insert();
	}


}

?>