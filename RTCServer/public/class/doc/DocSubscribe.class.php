<?php
/**
 * 云文档订阅类

 * @date    20141211
 */

class DocSubscribe extends Model {
	
	function __construct() {
		$this-> tableName = "tab_doc_file_subscribe";
		$this-> db = new DB ();
	}

	function add($doc_type,$doc_id,$emp_type,$emp_id,$emp_name = "",$emp_loginname = "")
	{
		$fields = array("col_classid"=>$doc_type,"col_objid"=>$doc_id,"col_flag"=>1,
			"col_hsitemtype"=>$emp_type,"col_hsitemid"=>$emp_id,"col_hsitemname"=>$emp_name,"col_hsitemloginname"=>$emp_loginname);
			
		$this -> clearParam();
		$this -> addParamFields($fields);
		$this -> insert();
		
		$id = $this -> getMaxId();
		return $id ;
		
	}

	function cancel($id)
	{
		$fields = array("col_id"=>$id);
			
		$this -> clearParam();
		$this -> addParamWheres($fields);
		$this -> delete();
	}
	
	function get($doc_type,$doc_id,$emp_type,$emp_id)
	{
		$fields = array("col_classid"=>$doc_type,"col_objid"=>$doc_id,"col_hsitemtype"=>$emp_type,"col_hsitemid"=>$emp_id,);
			
		$this -> clearParam();
		$this -> addParamWheres($fields);
		$data = $this -> getDetail();
		return $data;
	}
}
?>



