<?php
class Col extends Model {

	function __construct() {
		$this->tableName = "Col_Ro";
		$this->db = new DB ();
	}
	
	function list_ro($parent_type,$parent_id,$root_type,$root_id,$sortby = "TypeID",$myid)
	{
		$sql = "Select Col_FormVesr as c from Users_ID where UserID = '".CurUser::getUserId()."'" ;
		$Col_FormVesr = $this -> db -> executeDataValue($sql);
		$sql = "Select " . DOC_VFOLDER . " as col_doctype,TypeID,TypeName from Col_Ro where MyID = '".$myid."' order by " . $sortby;
//		echo $sql;
//		exit();
		$data = $this -> db -> executeDataTable($sql);
//		foreach($data_folder as $k=>$v){
//			$sql_count = "Select count(*) as c from Col_Form where MyID = '".CurUser::getUserId()."' and UpperID=" . $data_folder[$k]['typeid'] ;
//			$count = $this -> db -> executeDataValue($sql_count);
//			$data[$k]['count'] = $count;
//
//		}
		return array("data"=>$data,"vesr"=>$Col_FormVesr);
	}
	
	function list_form($parent_type,$parent_id,$root_type,$root_id,$file_type,$key,$sortby = "ID desc",$pageindex = 1,$pagesize = 20,$myid)
	{
		$sql = "Select * from Col_Form where MyID = '".$myid."'";
		$data = $this -> db -> executeDataTable($sql);
		foreach($data as $k=>$v){
			$data[$k]['col_doctype'] = DOC_FILE ;
			//$data[$k]['ToDate'] = $data[$k]['ToDate']+$data[$k]['ToTime'] ;
		}
		return $data;
	}

//	function list_form($parent_type,$parent_id,$root_type,$root_id,$file_type,$key,$sortby = "ID desc",$pageindex = 1,$pagesize = 20)
//	{
//		$sql = '';
//		$file_type_sql = '';
//		$search_key_sql = '';
//			//按类型
//		$sql = "MyID='"  .CurUser::getUserId() . "'" ;
//		$sql = "where " . $sql . " and UpperID=".$parent_id ;
//		if ($file_type)
//		{
//			switch ($file_type) {
//				case 1 :
//				$file_type_sql = "" ;
//				    break;
//				case 2 :
//				$file_type_sql = " and TypeS='e@'" ;
//					break;
//				case 3 :
//				$file_type_sql = " and TypeS='d@'" ;
//					break;
//				case 4 :
//				$file_type_sql = " and TypeS='i@'" ;
//					break;	
//				case 5 :
//				$file_type_sql = " and (TypeS='c@' or TypeS='o@')" ;
//					break;
//				case 6 :
//				$file_type_sql = " and TypeS=''" ;
//					break;
//			}
//			
//		}
//		if ($key)
//		{
//			$search_key_sql = " and Content like '%".$key."%'" ;
//		}
//
//		$sql_count = " select count(*) as c from Col_Form A " . $sql.$file_type_sql.$search_key_sql ;
//		$count = $this -> db -> executeDataValue($sql_count);
//		
////		$sql_list = " select " . ($this -> get_fields_list(DOC_FILE)) . " from PtpFile A " . $sql . " order by " . $sortby;
////		
//////		echo $sql_list;
//////		exit();
////		$data = $this -> db -> page($sql_list,$pageindex,$pagesize,$count);
//
//		$row1 = ($pageindex - 1) * $pagesize ;
//		$row2 = $row1 + $pagesize ;
//		if($row2>$count) $pagesize=$count-$row1;
//		
//		$sql_list = "SELECT * from (SELECT TOP " . $pagesize . " * FROM (select TOP " . $row2  . " * from Col_Form A "  . $sql.$file_type_sql.$search_key_sql . " order by (A.ToDate+A.ToTime) desc) order by ToDate ASC) order by ToDate desc";
////		echo $sql_list;
////		exit();
//		$data = $this -> db -> executeDataTable($sql_list) ;
//		foreach($data as $k=>$v){
//			$sql = "Select * from Users_ID where UserID='" . $data[$k]['usid'] . "'" ;
//			$row = $this -> db->executeDataRow($sql);
////			$data[$k]['todate'] = date("Y-m-d",$data[$k]['todate']) ;
////			$data[$k]['totime'] = date("H:i:s",$data[$k]['totime']) ;
//			$data[$k]['fcname'] = $row['fcname'];
//			$data[$k]['userico'] = $row['userico'];
//
//		}
//		return array("data"=>$data,"count"=>$count);
//	}
	
	function exist_name($doc_type,$name,$myid)
	{
		$sql = "" ;
		switch($doc_type)
		{
			case DOC_VFOLDER:
				$sql = " select count(*) as c from Col_Ro where MyID='" . $myid . "' and TypeName='" . $name . "'" ;
				break ;
			default:
				$sql = " select count(*) as c from Col_Form where MyID='" . $myid . "' and UpperID=" . $parent_id . " and Title='" . $name . "'" ;
				break ;
		}
		$result = $this -> db -> executeDataValue($sql);
		return $result ;
	}
	
	function save_col($name,$myid)
	{
		$col_item = array();
		$col_item["TypeName"] = $name ;
		$col_item["MyID"] = $myid ;
		$col_form = new Model("Col_Ro","TypeID");
		$col_form -> clearParam();
		$col_form -> addParamFields($col_item);
		$col_form -> insert();
		$col_id = $col_form -> getMaxId();
		$col_item["TypeID"] = $col_id ;
		return $col_item ;
	}
	
	function edit_col($doc_id,$name)
	{	
		$sql = "update Col_Ro set TypeName='" . $name . "',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where TypeID=" . $doc_id ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}
	
	function save_colform($parent_id,$title,$content,$usname,$usid,$types,$myid)
	{
		$col_item = array();
		$col_item["UpperID"] = $parent_id ;
		$col_item["Title"] = $title ;
		$col_item["NContent"] = $content ;
		//$col_item["UsName"] = $usname ;
		$col_item["UsID"] = $usid ;
		$col_item["TypeS"] = $types ;
		$col_item["MyID"] = $myid ;
		$col_form = new Model("Col_Form");
		$col_form -> clearParam();
		$col_form -> addParamFields($col_item);
		$col_form -> insert();
		$col_id = $col_form -> getMaxId();
		$col_item["ID"] = $col_id ;
		return $col_item ;
	}
	
	function edit_colform($parent_id,$doc_id,$title,$content,$types,$iskefu)
	{	
		if($iskefu) $sql = "UpperID=" . $parent_id . ",TypeS='" . $types . "',";
		$sql = "update Col_Form set ".$sql."Title='" . $title . "',NContent='" . $content . "',ToDate='" . date("Y-m-d H:i:s") . "',ToTime='" . date("Y-m-d H:i:s") . "' where ID=" . $doc_id ;
		$result = $this -> db -> execute($sql);
		return 1 ;
	}
	
	function delete_db($doc_type,$id)
	{
		//删除数据
		$arr_sql = array();
		switch($doc_type)
		{
			case DOC_VFOLDER:
				$arr_sql[] = " delete from Col_Ro where TypeID=" . $id;
				break ;
			default:
				$arr_sql[] = " delete from Col_Form where ID=" . $id ;
				break ;
		}

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;
	}
	
	function move($doc_type,$doc_id,$target_id)
	{
		$arr_sql = array();
		switch($doc_type)
		{
			case DOC_ROOT:case DOC_VFOLDER:
				$arr_sql[] = "update Col_Form set UpperID=".$target_id." where UpperID=" . $doc_id . " and MyID='" . CurUser::getUserId() . "'";
				break ;
			default:
				$arr_sql[] = "update Col_Form set UpperID=".$target_id." where ID=" . $doc_id;
				break ;
		}
//			echo var_dump($arr_sql);
//			exit();

		return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

	}
	
	function updateColForm()
	{
		$db = new Model("Users_ID");
		$sql = "update Users_ID set Col_FormVesr=Col_FormVesr + 1 where UserID = '".CurUser::getUserId()."'" ;
		$db -> db -> execute($sql) ;
	}
	
	function check_user_data($data)
	{
		if (count($data) == 0)
			return array("status"=>0,"msg"=>get_lang("class_hs_warning2"));
		
		//判断列数是否正确 第一列固定为部门列	
		if (! valid_column_length($data,2))
			return $result = array("status"=>0,"msg"=>get_lang("class_hs_warning"));

		return array("status"=>1,"msg"=>"");
	}
	
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
			if (count($row)>= 0) $dept_id = $this -> import_an_dept($row[0]);
			//导入用户
			if ($dept_id) $this -> import_an_user($row,$dept_id);
		}

		return $result ;
	}
	
	/*
	method:创建一个部门  每次导入都会放到内存中，先判断内存是否存在，存在则返回
	param:$path 触点软件/技术中心
	*/
	function import_an_dept($name)
	{
		if (trim($name) == "")
			return "" ;

		$colro_myid = g ( "colro_myid" );
		if($colro_myid) $myid='Public';
		else $myid=CurUser::getUserId();

		$sql = " select TypeID as c from Col_Ro where MyID='" . $myid . "' and TypeName='" . $name . "'" ;

		$result = $this -> db -> executeDataValue($sql);
		if (!$result){
			$col_form = $this -> save_col($name,$myid);
			return $col_form["TypeID"] ;
		}else
			return $result ;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//导入用户 返回用户ID
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	function import_an_user($row,$dept_id)
	{
		Global $valid_user_exist ;

		$count_field = 2 ;

		if (count($row)<= $count_field)
			return 0 ;

		$title = substr($row[1],0,15);
		$content = phpEscape1($row[1]);
		//$usname = g("usname");
		$usid = g("usid",CurUser::getUserId());
		$types = g("types","");
		$colro_myid = g ( "colro_myid" );
		if($colro_myid) $myid='Public';
		else $myid=CurUser::getUserId();

		$this -> save_colform($dept_id,$title,$content,$usname,$usid,$types,$myid);
		$this -> updateColForm();
	}
	
	function export_user()
	{
		$colro_myid = g ( "colro_myid" );
		$sortby = g("sortby","TypeID");
		if($colro_myid) $myid='Public';
		else $myid=CurUser::getUserId();
		$data = array();
		$data_dept = $this -> list_ro($parent_type,$parent_id,$root_type,$root_id,$sortby,$myid);
		//根据部门得到用户
		foreach($data_dept['data'] as $row_dept)
		{
			$path = $row_dept["typename"] ;
			$sql = "Select * from Col_Form where UpperID = ".$row_dept["typeid"];
			$data_user = $this -> db -> executeDataTable($sql);
			$data = $this -> fill_user_data($data_user,$path,$data);

		}
		return $data ;
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
}

?>