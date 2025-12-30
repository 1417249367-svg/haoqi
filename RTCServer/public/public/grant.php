<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/EmpRelation.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Department.class.php");?>
<?php
	$op = g("op") ;
	$printer = new Printer();
	switch($op)
	{
		case "add":
			add();
			break ;
		case "delete":
			delete();
			break ;
		case "list":
			getList();
			break ;
		default:
			break ;
	}
	
	function add()
	{
		Global $printer;
		
		$user_id = g("user_id");
		$dept_id = g("dept_id");
		$user_name = g("user_name");
		$dept_name = g("dept_name");

		$dept = getEmpInfo($dept_id);

        $relation = new EmpRelation();
        $result = $relation -> insert($dept["viewid"],EMP_USER,$user_id,$user_name,$dept["emptype"],$dept["empid"],$dept_name) ;

		$printer -> out($result);
	}
	
	function delete()
	{
		Global $printer;
		
		$id = g("id") ;
		
		if (! $id)
			$printer -> fail();

		$sql = " delete from hs_relation where col_id in(" . $id . ")" ;
		
		$db = new DB();
		$result = $db -> execute($sql) ;

		$printer -> out ($result) ;
	}
	
	function getList()
	{

		Global $printer;
		
		$db = new DB();
        $sql = "";
		
		$admin = CurUser::isAdmin() ;
        if (! $admin)
        {
			//得到所管辖的部门
			$userId = CurUser::getUserId() ;
			
			$dept = new Department();
            $deptIds = $dept -> getSubDeptByUser($userId);
            if ($deptIds == "")
                $deptIds = "0";
            $sql = $db ->addWhere($sql, "Col_DHSITEMTYPE=2 and Col_DHSITEMID in(" . $deptIds . ")");

        }

        $sql = $db ->addWhere($sql, "Col_HsItemType=1 and Col_HsItemId=HS_USER.COL_ID");

        $sql = "select HS_RELATION.COL_ID as id,HS_USER.COL_ID as user_id,HS_USER.COL_NAME as user_name,HS_USER.col_loginname as loginname ," .
        " col_dhsitemtype as emp_type, col_dhsitemid as emp_id,col_dhsitemname as emp_name " .
        " from HS_RELATION,HS_USER  " . $sql . 
        " order by Col_HsItemId ";

        $data = $db -> executeDataTable($sql) ;

		$printer -> out_list($data);

	}
	
	

?>