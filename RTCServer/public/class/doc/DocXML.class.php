
<?php
/**
 * 生成XML树

 * @date    20140828
 */

class  DocXML
{
	public $xml ;
	public $load_all = 0 ;
	public $root_id = 0 ;
	public $rootName = "";
	
	function __construct()
	{
		$this -> db = new DB();
		$this -> rootName = get_lang("doc_manager_public");
	}
	
	function get_tree($node_id)
	{
		
		$parent = DocXML::get_node_info($node_id);
		//echo var_dump($parent);
		
		if ($parent["curr_id"] == '0')
			$node_id = 0 ;
			
		$this -> create_tree($parent["curr_type"],$parent["curr_id"]) ;

		$this -> xml = '<tree id="' . $node_id . '">' . ($this -> xml) . '</tree>' ;

		return $this -> xml;


	}
	
	
	function get_root_tree($root_id)
	{
		$this -> create_tree(DOC_ROOT,$root_id) ;

		//$this -> xml = '<tree id="0">' . ($this -> xml) . '</tree>' ;
		
		if (($this -> rootName) == "")
			$this -> xml = '<tree id="0">' . ($this -> xml) . '</tree>' ;
		else
			$this -> xml = '<tree id="0"><item id="102_0_0_0_" text="' . $this -> rootName . '" select="1" open="1" im0="root.png" im1="root.png" im2="root.png">' . ($this -> xml) . '</item></tree>' ;

		return $this -> xml;


	}
	
	function get_root_tree1($root_id)
	{
		$this -> create_tree1(DOC_ROOT,$root_id) ;

		$this -> xml = '<tree id="0">' . ($this -> xml) . '</tree>' ;

		return $this -> xml;


	}

	//生成tree
	function create_tree1($parent_type,$parent_id)
	{
 		$data = $this -> get_data1($parent_type,$parent_id) ;

		foreach($data as $row)
		{
			$this -> create_item($row,$parent_type,"0");
		}

		return $this -> xml;
	}

	//生成tree
	function create_tree($parent_type,$parent_id)
	{
 		$data = $this -> get_data($parent_type,$parent_id) ;
		foreach($data as $row)
		{
			$this -> create_item($row,$parent_type,$parent_id);
		}

		return $this -> xml;
	}
	
	//生成xml item
	function create_item($row,$parent_type,$parent_id)
	{
		$curr_type = $row["col_type"] ;
		$curr_id = $row["ptpfolderid"] ;
		$curr_name = $row["usname"] ;
		$child = $row["child"] ;
		//if empType=VIEW, viewId = empId
		if ($curr_type == DOC_ROOT)
			$root_id = $curr_id ;
			
		$node_id = DocXML::get_node_id($curr_type,$curr_id,$parent_type,$parent_id,$root_id);

		if ($curr_type == DOC_ROOT)
			$img = " im0=\"root.png\" im1=\"root.png\" im2=\"root.png\"";
		else
			$img = " im0=\"folder.png\" im1=\"folder.png\" im2=\"folder.png\"";
		$this -> xml .= '<item id="' . $node_id . '" text="' . $curr_name . '" child="' . $child . '" ' . $img . '>' ;
		if ($this -> load_all)
			$this -> create_tree($curr_type,$curr_id) ;
		$this -> xml .= '</item>' . "\n" ;

	}
	
	//得到数据
	function get_data($parent_type,$parent_id)
	{
//		echo $parent_type."|".$parent_id;
//		exit();
//		if ($parent_id == 0)
//		{
//			$sql = "(select count(*) from tab_doc_root_link where col_p_objid=tab_doc_root.col_id and col_s_classid=105) as child" ;
//			$sql = " select col_id,col_name," . DOC_ROOT. " as col_type," . $sql . " from tab_doc_root where col_type=1" ;
//		}
//		else
//		{
			$sql = "(select count(*) from PtpFolder where MyID='" . getValue("myid") . "' and ParentID='" . $parent_id . "') as child" ;
//			if ($parent_type == DOC_ROOT)
//				$sql = " select col_id,col_name," . DOC_VFOLDER . " as col_type," . $sql . " from tab_doc_vfolder where col_id in(select col_s_objid from tab_doc_root_link where col_p_objid=" . $parent_id . ")" ;
//			else
				$sql = " select ptpfolderid,usname," . DOC_VFOLDER. " as col_type," . $sql . " from PtpFolder where MyID='" . getValue("myid") . "' and ParentID='" . $parent_id . "' and To_Type<>2 order by ToDate desc" ;
//		}
//echo $sql;
//exit();
		return $this -> db -> executeDataTable($sql);
	}
	
	//得到数据
	function get_data1($parent_type,$parent_id)
	{
//		echo $parent_type."|".$parent_id;
//		exit();
//		if ($parent_id == 0)
//		{
//			$sql = "(select count(*) from tab_doc_root_link where col_p_objid=tab_doc_root.col_id and col_s_classid=105) as child" ;
//			$sql = " select col_id,col_name," . DOC_ROOT. " as col_type," . $sql . " from tab_doc_root where col_type=1" ;
//		}
//		else
//		{
			$sql = "(select count(*) from PtpFolder where MyID='" . getValue("myid") . "' and PtpFolderID='" . $parent_id . "') as child" ;
//			if ($parent_type == DOC_ROOT)
//				$sql = " select col_id,col_name," . DOC_VFOLDER . " as col_type," . $sql . " from tab_doc_vfolder where col_id in(select col_s_objid from tab_doc_root_link where col_p_objid=" . $parent_id . ")" ;
//			else
				$sql = " select ptpfolderid,usname," . DOC_VFOLDER. " as col_type," . $sql . " from PtpFolder where MyID='" . getValue("myid") . "' and PtpFolderID='" . $parent_id . "' order by ToDate desc" ;
//		}
//echo $sql;
//exit();
		return $this -> db -> executeDataTable($sql);
	}
	
	//得到node id
	static function get_node_id($curr_type,$curr_id,$parent_type,$parent_id,$root_id)
	{
		return $curr_type . "_" . $curr_id . "_" . $parent_type . "_" . $parent_id . "_" . $root_id ;
	}
	
	//得到node info  curr_type curr_id parent_type parent_id root_id
	static function get_node_info($node_id)
	{
		$result = array("curr_type"=>"0","curr_id"=>"0","parent_type"=>"0","parent_id"=>"0","root_id"=>"0");
		
		if (($node_id == "") || empty($node_id))
			return $result ;
			
		$arr = explode("_",$node_id) ;	// to array
		

        if (count($arr) >= 3)
        {
			$result["curr_type"] = $arr[0] ;
			$result["curr_id"] = $arr[1] ;
			$result["parent_type"] = $arr[2] ;
			$result["parent_id"] = $arr[3] ;
			$result["root_id"] = $arr[4] ;
		}
		return $result ;
    }
}
	
?>