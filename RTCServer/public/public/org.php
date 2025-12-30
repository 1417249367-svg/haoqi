<?php  require_once("fun.php");?>

<?php  require_once(__ROOT__ . "/class/hs/EmpRelation.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Department.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpXML.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php
	$op = g("op") ;
	$printer = new Printer();


	switch($op)
	{
		case "create":
			save();
			break ;
		case "edit":
			save();
			break ;
		case "delete":
			delete();
			break ;
		case "detail":
			detail();
			break ;
		case "get_tree":
			get_tree();
			break ;
		case "get_tree1":
			get_tree1();
			break ;
		case "get_tree_all":
			get_tree_all();
			break ;
		case "dept_move":
			dept_move();
			break ;
        case "member_add":
            member_add();
            break;
        case "member_remove":
            member_remove();
            break;
        case "member_move":
            member_move();
            break;
        case "member_copy":
            member_copy();
            break;
		case "get_users":
			get_users();
			break ;
		case "get_user_count":
			get_user_count();
			break;
		case "get_dept_user":
		    get_dept_user();
		    break;
		case "get_dept":
		    get_dept();
		    break;
	}




	function save()
	{
		Global $printer;
		Global $op;

		$node_parent = g("parentid") ;
		$node_my = g("id");
		$name = g("typename");


		$dept = new Department();
		$parent = getEmpInfo($node_parent);
		$my = getEmpInfo($node_my);

		if ($op == "create")
			$my["emptype"] = ($parent["emptype"] == 0) ? EMP_VIEW : EMP_DEPT;




		//数据库对象
		$db = new Model("Users_Ro","TypeID");
		$fields = array(
			"TypeName"=>f("typename"),
			"Description"=>f("description"),
			"ItemIndex"=>f("itemindex"),
			"CreatorID"=>CurUser::getUserId(),
			"CreatorName"=>CurUser::getUserName()
		);


		//视图的话加入此属性
//		if ($my["emptype"] == EMP_VIEW)
//        {
//            $fields["col_style"] = f("col_style") ;
//            $fields["col_type"] = 1 ;
//        }
//		if ($my["emptype"] == EMP_DEPT)
//			$fields["col_style"] = 1 ;

		//添加插入参数


		if ($op == "create")
		{
			//判断是否存在
			$result = $dept -> getIdByName ($parent["emptype"], $parent["empid"], $my["emptype"], $my["empid"], $name );
			if ($result)
				$printer -> fail("errnum:102202") ;
			$my["empid"] = $db -> getMaxId();
			if(empty($my["empid"])) $my["empid"]=0;
			$my["empid"]=$my["empid"]+1;
			
			$my["empid"]=$my["empid"]+1000000;
			$my["empid"]=substr($my["empid"],-6);
			
			$fields["TypeID"] = $my["empid"] ;
			$fields["ParentID"] = $parent["empid"] ;
		    $db -> addParamFields($fields);
			//插入
			$db -> insert();


//			//得到我的VIEWID
//			if ($my["emptype"] == EMP_VIEW)
//			{
//				//视图
//				$my["viewid"] = $my["empid"] ;
//			}
//			else
//			{
//				//部门
//				$my["viewid"] = $parent["viewid"] ;
//
//				//添加关系
//				$relation = new EmpRelation();
//				$relation -> insert($parent["viewid"],$parent["emptype"],$parent["empid"],"",$my["emptype"], $my["empid"],$name);
//			}

			//生成nodeid
			$node_my = getEmpId($my["viewid"],$my["emptype"],$my["empid"],$parent["emptype"], $parent["empid"],"") ;
		}
		else
		{
		    $db -> addParamFields($fields);
			//更新
			$db -> addParamWhere("TypeID",$my["empid"]) ;
			$db -> update();
		}
		$db -> updateForm("Users_RoVesr");
		$printer -> success("id:" . $node_my . ",name:" . $name);
	}

	function create()
	{
		Global $printer;
		$parent = getEmpInfo(g("parentid"));
        $name = f("col_name");
        $desc = f("col_description");
		$itemindex = f("col_itemindex");

		$dept = new Department();
        $result = $dept -> insert($parent["viewid"], $parent["emptype"], $parent["empid"], $name, $desc,$itemindex);

        if ($result["status"] == "0")
            $printer -> fail("errnum:102202");
        else
            $printer -> success("id:" . getEmpId($result["viewid"],$result["emptype"],$result["empid"],$parent["emptype"], $parent["empid"],"") . ",name:" . $name);
	}

	function edit()
	{
		Global $printer;
		$parent = getEmpInfo(g("parentid"));
		$nodeid = g("id");
		$my = getEmpInfo($nodeid);
        $name = f("col_name");
        $desc = f("col_description");
		$itemindex = f("col_itemindex");

		$dept = new Department();
        $id = $dept -> update($parent["viewid"], $parent["emptype"], $parent["empid"],$my["emptype"], $my["empid"], $name, $desc,$itemindex);

        if ($id == "")
            $printer -> fail("errnum:102202");
        else
            $printer -> success("id:" . $nodeid . ",name:" . $name);
	}

	function delete()
	{
		Global $printer;
		$nodeId = g("id") ;
		$parent = getEmpInfo($nodeId);
		$empType = $parent["emptype"] ;
		$empId = $parent["empid"] ;
		$dept = new Department();
		$result = $dept -> delete($empType, $empId);

        if ($result){
			$db = new Model ( "Users_Ro" );
			$db -> updateForm("Users_RoVesr");
			$printer -> success();
		}
        else
			$printer -> fail("errnum:102203");

	}

	function detail()
	{
		Global $printer;
		$nodeId = g("id") ;
		$parent = getEmpInfo($nodeId);
		recordLog($nodeId) ;
		$empType = $parent["emptype"] ;
		$empId = $parent["empid"] ;
		$dept = new Department();
		$row = $dept -> detail($empType, $empId);

		$printer -> out_detail($row,'',0);
	}

	$xml = "" ;
	function get_tree()
	{
		Global $printer;

		$admin = CurUser::isAdmin() ;
		$nodeId = g("id") ;
		$loadUser = g("loaduser",0);
		$loadAll = g("loadall",0);
		$parent = getEmpInfo($nodeId);
		$isroot = g("isroot",1);  		//0 不显示结构结点		1显示


		$empXML = new EmpXML();
		$empXML->isAdmin = g("isadmin",1);

		//不显示组织结构结点
		if ($isroot == "0")
			$empXML -> rootName = "" ;

		if (($nodeId == "") && (! $admin) )
		{
			//分级管理
			$user_id = CurUser::getUserId();
			$data = $empXML -> create_tree_bypower($user_id,$loadUser,$loadAll);
		}
		else
		{
			$data = $empXML -> get_tree($nodeId,$loadUser,$loadAll);
		}
		$printer -> out_xml($data);
	}

	function get_tree1()
	{
		Global $printer;

		$nodeId = g("id") ;
		$loadUser = g("loaduser",0);
		$loadAll = g("loadall",0);
		$parent = getEmpInfo($nodeId);
		$isroot = g("isroot",1);  		//0 不显示结构结点		1显示


		$empXML = new EmpXML();

		//不显示组织结构结点
		if ($isroot == "0")
			$empXML -> rootName = "" ;

		$data = $empXML -> get_tree($nodeId,$loadUser,$loadAll);
		$printer -> out_xml($data);
	}


    function get_tree_all()
    {
		Global $printer;


		$empXML = new EmpXML();
		$data = $empXML -> get_tree_all();
		$printer -> out_xml($data);
    }



	function dept_move()
	{
		Global $printer;
		$source = getEmpInfo(g("deptid"));
		$target = getEmpInfo(g("targetid"));

        $relation = new EmpRelation();
        $result = $relation -> setParent($source["emptype"],$source["empid"], $source["parenttype"],$source["parentid"],$target["emptype"],$target["empid"]);
        if ($result){
			$db = new Model ( "Users_Ro" );
			$db -> updateForm("Users_RoVesr");
            $printer -> success();
		}
        else
            $printer -> fail("errnum:102204");
	}

    /**
     * 添加成员
     * @param $deptid
     * @param $userid
	 * @return  0 fail 1 success
     */
	function member_add()
	{

		Global $printer;
		$nodeId = g("deptid") ;
		$parent = getEmpInfo($nodeId);
		$userId = g("userid") ;
		$deptPath = g("dept_path") ;
		
	    $db = new DB();
		$sql = " update Users_ID set UppeID=UppeID+',".$parent["empid"].",',Users_IDVesr=Users_IDVesr + 1 where UserID ='" . $userId . "'";
//		echo $sql;
//		exit();
		$db->execute($sql);
		$user = new User ();
		$user -> updateForm("Users_IDVesr");
		
	    $printer->success ();
	}

    /**
     * 移除成员
     * @param $deptid
     * @param $userid
	 * @return  0 fail 1 success
     */
	function member_remove()
	{
		Global $printer;
		$nodeId = g("deptid") ;
		$parent = getEmpInfo($nodeId);
		$userId = g("userid") ;

        $relation = new EmpRelation();
        $result = $relation -> delete($parent["viewid"],$parent["emptype"], $parent["empid"], EMP_USER, $userId);

        if ($result)
            $printer -> success();
        else
            $printer -> fail("errnum:102204");
	}

    /**
     * 移动到其它位置(先删除关系，再建立关系)
     * @param $deptid
	 * @param $targetid
     * @param $userid
	 * @return  0 fail 1 success
     */
	function member_move()
	{
		Global $printer;
		$parent = getEmpInfo(g("deptid"));
		$target = getEmpInfo(g("targetid"));
		$targetName = g("targetname");
		
		$userId = g("userid") ;
		$deptPath = g("dept_path") ;
		
        $relation = new EmpRelation();

		$relation -> delete($parent["viewid"],$parent["emptype"], $parent["empid"], EMP_USER, $userId);
        $relation -> insert($target["viewid"],$target["emptype"], $target["empid"],$targetName,EMP_USER, $userId ,"",$deptPath);

        $printer -> success();
	}

    /**
     * 复制到其它位置(先删除关系，再建立关系)
     * @param $deptid
	 * @param $targetid
     * @param $userid
	 * @return  0 fail 1 success
     */
	function member_copy()
	{
		Global $printer;
		$target = getEmpInfo(g("targetid"));
		$targetName = g("targetname");
		
		$userId = g("userid") ;
		$deptPath = g("dept_path") ;

        $relation = new EmpRelation();
		$relation -> insert($target["viewid"],$target["emptype"], $target["empid"], $targetName,EMP_USER, $userId,"",$deptPath);

        $printer -> success();
	}

	///////////////////////////////////////////////////////////////////////
	//得到组织下的人员
	///////////////////////////////////////////////////////////////////////
	function get_users()
	{
		Global $printer;

		$nodes = explode(",",g("parents"));
		$fields = g("fields","col_id,col_name");
		$userIds = "" ;

        $dept = new Department();

        //得到所有的 userid
		foreach($nodes as $node)
		{
			$item = getEmpInfo($node);
			if ($item["emptype"] == EMP_USER)
				$userIds .= ($userIds == ""?"":",") . $item["empid"] ;
			else
			{
				$ids = $dept -> getSubIds($item["emptype"], $item["empid"], EMP_USER,0);
				$userIds .= ($userIds == ""?"":",") . $ids ;
			}
		}


        //根据userid得到用户信息
        if ($userIds == "")
            $userIds = "0";

        $sql = " select " . $fields . " from hs_user where col_id in(" . $userIds . ")";

        $data = $dept -> db -> executeDataTable($sql);

        $printer -> out_list($data);
	}

	/*
	 * 得到部门下用户数量包含下级部门
	 */
	function get_user_count()
	{

		Global $printer;
		$deptInfo = getEmpInfo(g("deptId"));
		$deptIds="";
		$db = new DB();

		if($deptInfo['empid'] != 0)
		{
			$dept = new Department();
			$dept->get_an_dept($deptInfo['emptype'], $deptInfo['empid']);

			if(count($dept->temp)>0)
			{
				foreach ($dept->temp as $row)
				{
					if($deptIds)
						$deptIds .= "," . $row['empid'];
					else
						$deptIds = $row['empid'];
				}
			}



			$sql = "select count(UserID) as c from Users_ID where (UppeId like '%" . $deptInfo['empid'] . "%') ";
//			if($deptIds != "")
//				$sql .= " or (col_hsitemtype=2 and col_hsitemid in (" . $deptIds . ") and col_dhsitemtype=1)";

		}
		else
		{
			$sql = "select count(UserID) as c from Users_ID";
		}
//		echo $sql;
//		exit();
		$count = $db->executeDataValue($sql);

		if($count)
			$printer ->out_arr(array('status' => 1,'usercount' => $count));
		else
			$printer -> fail();

	}


	/*
	 * 得到部门下用户包含下级部门
	 */
	function get_dept_user()
	{

	    Global $printer;
	    $deptInfo = getEmpInfo(g("deptid"));
	    $deptIds="";
	    $db = new DB();

//	    if($deptInfo['empid'] != 0)
//	    {
	        $dept = new Department();
	        $dept->get_an_dept($deptInfo['emptype'], $deptInfo['empid']);

	        if(count($dept->temp)>0)
	        {
	            foreach ($dept->temp as $row)
	            {
				$sql .= " or UppeID like '%".$row['empid']."%'";
	            }
	        }
	        $sql = "select UserID as col_id,FcName as col_name,UserName as col_loginname from Users_ID where (UppeID like '%".$deptInfo['empid']."%'".$sql.") and UserState=1";

//	    }
//	    else
//	    {
//	        $sql = "select col_id,col_name,col_loginname from hs_user";
//	    }
	    $arr = $db->executeDataTable($sql);

	    $printer ->out_list($arr,count($arr),0);

	}
	
	/*
	 * 得到部门
	 */
	function get_dept()
	{

	    Global $printer;
	    $deptInfo = getEmpInfo(g("deptid"));
	    $deptIds="";
	    $db = new DB();

//	    if($deptInfo['empid'] != 0)
//	    {

	        $sql = "select TypeID as col_id,TypeName as col_name,4 as col_loginname from Users_Ro where ParentID = '000000'";

//	    }
//	    else
//	    {
//	        $sql = "select col_id,col_name,col_loginname from hs_user";
//	    }
	    $arr = $db->executeDataTable($sql);

	    $printer ->out_list($arr,count($arr),0);

	}
?>