<?php
/**
 * 生成XML树

 * @date    20140331
 */

class  EmpXML
{
	public $viewType = 1 ;
	public $viewOwnerId = 0 ;
	public $Field_UserName = "";
	public $isAdmin = 0;
	public $xml ;
	public $rootName = "";

	function __construct()
	{
		$this -> db = new DB();
		$this -> rootName = get_lang("viewport_org");
	}

	function get_tree($nodeId,$loadUser = 0 ,$loadAll = 0)
	{

		$parent = getEmpInfo($nodeId);

		$xml_root = "" ;

		if (($nodeId == "") || ($nodeId == "0") )
		{
			if (($this -> rootName) == "")
				$xml_root = '<tree id="0">{XML}</tree>' ;
			else
				$xml_root = '<tree id="0"><item id="0_0_0" text="' . $this -> rootName . '" select="1" open="1" im0="org.gif" im1="org.gif" im2="org.gif">{XML}</item></tree>' ;
			$this -> create_tree(0,0,'000000',$loadUser,$loadAll);
		}
		else
		{
			$xml_root = '<tree id="' . $nodeId . '">{XML}</tree>' ;
			$this -> create_tree($parent["viewid"],$parent["emptype"],$parent["empid"],$loadUser,$loadAll) ;
		}

		$xml_root = str_replace("{XML}",$this -> xml,$xml_root) ;
		return $xml_root;


	}
	
	function get_livechat($nodeId,$loadUser = 0 ,$loadAll = 0)
	{

		$parent = getEmpInfo($nodeId);

		$xml_root = "" ;

		if (($nodeId == "") || ($nodeId == "0") )
		{
			if (($this -> rootName) == "")
				$xml_root = '<tree id="0">{XML}</tree>' ;
			else
				$xml_root = '<tree id="0"><item id="0_0_0" text="' . $this -> rootName. '" select="1" open="1" im0="org.gif" im1="org.gif" im2="org.gif">{XML}</item></tree>' ;
			$this -> create_list(0,0,'000000',$loadUser,$loadAll);
		}
		else
		{
			$xml_root = '<tree id="' . $nodeId . '">{XML}</tree>' ;
			$this -> create_list($parent["viewid"],$parent["emptype"],$parent["empid"],$loadUser,$loadAll) ;
		}

		$xml_root = str_replace("{XML}",$this -> xml,$xml_root) ;
		return $xml_root;


	}



    function get_tree_all($loadUser = 0 )
    {
		$this -> create_tree(0,0,'000000',$loadUser,1) ;

		$xml_root = '<tree id="0"><item id="0_0_0" text="' . ($this -> rootName) . '" select="1"  open="1" im0="org.gif" im1="org.gif" im2="org.gif">' . ($this -> xml) . '</item></tree>' ;
		//recordLog($xml_root);
		return $xml_root;
    }


	//根据授权生成树
	function create_tree_bypower($userId,$loadUser = 0 ,$loadAll = 0)
	{
		$xml_root = "" ;
		$xml_root = '<tree id="0">{XML}</tree>' ;

		//2014-11-18 授权信息由 hs_relation 改为 hs_grant
		/*
        	$sql = " select Col_DHsItemId as Id ,Col_DHsItemName as Name,Col_DHsItemType as EmpType,'' as LoginName,B.Col_HSITEMTYPE as ParentEmpType,B.Col_HSITEMID as ParentEmpId,Col_ViewId as ViewId ," .
	            " ( select count(*) from hs_relation C where C.col_hsitemid=B.Col_DHsItemId and C.col_hsitemType=B.Col_DHsItemType and C.Col_DHSITEMTYPE=2 ) as child ,0" .
	            " from HS_RELATION B " .
	            " where Col_HsItemType=1 and Col_HsItemId=" . $userId .
	            " order by EmpType desc,Col_DHsItemName   ";
		*/

		//2014-11-18 授权信息由 hs_grant
		switch (DB_TYPE)
		{
			case "access":
				$sql = "select aa.UppeID as id,bb.TypeName as name,2 as empType,'' as loginName from AdminGrant as aa,Users_Ro as bb where aa.UserID='".$userId."' and aa.UppeID=bb.TypeID order by clng(bb.ItemIndex) desc";
				break ;
			default:
				$sql = "select aa.UppeID as id,bb.TypeName as name,2 as empType,'' as loginName from AdminGrant as aa,Users_Ro as bb where aa.UserID='".$userId."' and aa.UppeID=bb.TypeID order by CONVERT(int,bb.ItemIndex) desc";
				break;
		}
//		echo $sql;
//		exit();
//        $sql = "select col_emp_id as id,col_emp_name as name,col_emp_type as emptype,'' as loginname," .
//             EMP_USER .   " as ParentEmpType,col_user_id as ParentEmpId,1 as child, 0 as viewid " .
//            "   from hs_grant where col_user_id=" . $userId ;

		$relation = new EmpRelation();
		$data = $relation -> db -> executeDataTable($sql);
//		echo var_dump($data);
//		exit();
		foreach($data as $row)
		{
			$this -> create_item($row,0,0,0,$loadUser,$loadAll);
		}
		$xml_root = str_replace("{XML}",$this -> xml,$xml_root) ;
		return $xml_root;
	}

	function create_tree($viewId,$parentEmpType,$parentEmpId,$loadUser = 0 ,$loadAll = 0 )
	{
		$isLoadChildCount = $loadAll?0:1 ;
		$dept = new Department();
		$data = $dept -> getChildData($parentEmpType,$parentEmpId,$loadUser,$this -> Field_UserName,$this -> viewType,$this -> viewOwnerId,0) ;
		foreach($data as $row)
		{
//		echo $this -> isAdmin."|".getValue("departmentpermission") ."|". getValue("department") ."|". $row["id"] ."|". strstr(getValue("department"),$row["id"])."<br>";
//		echo $loadAll && ($childCount>0) && ($parentEmpType != EMP_USER) && ($this -> isAdmin||getValue("departmentpermission")==0||(getValue("departmentpermission")==1&&strpos(getValue("department"),$currEmpId))||(getValue("departmentpermission")==2&&strpos(getValue("department"),$currEmpId)>0));
			if(($row["emptype"]==EMP_USER)||$this -> viewType == 8||$this -> isAdmin||getValue("departmentpermission")==0||(getValue("departmentpermission")==1&&(!strstr(getValue("department"),$row["id"])))||(getValue("departmentpermission")==2&&strstr(getValue("department"),$row["id"])))
			    $this -> create_item($row,$viewId,$parentEmpType,$parentEmpId,$loadUser,$loadAll);
		}
//		exit();

		return $this -> xml;
	}
	
	function create_list($viewId,$parentEmpType,$parentEmpId,$loadUser = 0 ,$loadAll = 0 )
	{
		$isLoadChildCount = $loadAll?0:1 ;
		$dept = new LiveChat();
		$data = $dept -> GetChater() ;
		foreach($data as $row)
		{
			$this -> create_item($row,$viewId,$parentEmpType,$parentEmpId,$loadUser,$loadAll);
		}

		return $this -> xml;
	}

	function create_item($row,$viewId,$parentEmpType,$parentEmpId,$loadUser = 0 ,$loadAll = 0)
	{
		$currEmpType = $row["emptype"] ;
		$currEmpId = $row["id"] ;
		


		//if empType=VIEW, viewId = empId
		if ($currEmpType == EMP_VIEW)
			$viewId = $currEmpId ;

		$nodeId = getEmpId($viewId,$currEmpType,$currEmpId,$parentEmpType,$parentEmpId,$row["loginname"]);
		$text = fliterTreeText($row["name"]) ;
		if ($currEmpType == EMP_USER){
			$img = " im0=\"user.png\" im1=\"user.png\" im2=\"user.png\"";
			$childCount = 0;
		}else{
			$sql = $loadUser ? "select (cc.c+dd.d) as child from (select count(*) as c from Users_ID where UppeID like '%".$currEmpId."%') cc,(select count(*) as d from Users_Ro where ParentID='".$currEmpId."') dd" : "select count(*) as child from Users_Ro where ParentID='".$currEmpId."'";
			if ($this -> viewType == 8) $sql = "select count(*) as child from Clot_Form where UpperID = '".$currEmpId."'";
			$relation = new EmpRelation();
			$data = $relation -> db -> executeDataTable($sql);
//			foreach($data as $rows)
//			{
				$childCount = $data[0]["child"] ;
//			}

			$img = " im0=\"folder.png\" im1=\"folder.png\" im2=\"folder.png\"";
		}
		$this -> xml .= '<item id="' . $nodeId . '" text="' . $text . '" child="' . $childCount . '" ' . $img . '>' ;
//		echo $loadAll ."|". $childCount ."|". $parentEmpType ."|". EMP_USER."<br>";
//		echo $this -> isAdmin."|".getValue("departmentpermission") ."|". getValue("department") ."|". $currEmpId ."|". strpos(getValue("department"),$currEmpId)."<br>";
//		echo $loadAll && ($childCount>0) && ($parentEmpType != EMP_USER) && ($this -> isAdmin||getValue("departmentpermission")==0||(getValue("departmentpermission")==1&&strpos(getValue("department"),$currEmpId))||(getValue("departmentpermission")==2&&strpos(getValue("department"),$currEmpId)>0));
//		exit();
		if ($loadAll && ($childCount>0) && ($parentEmpType != EMP_USER))
			$this -> create_tree($viewId,$currEmpType,$currEmpId,$loadUser,$loadAll) ;
		$this -> xml .= '</item>' . "\n" ;
	}
}
