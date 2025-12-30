<?php
/**
 * 权限分配

 * @date    20140826
 */

class BIOACE extends Model 
{

	public function __construct()
	{

		$this -> tableName = "PtpFolderForm" ;
		$this -> fldId = "ID" ;
		$this -> db = new DB();
	}
	
	/*
	method	得到权限列表
	param	$classId 
	param	$objId
	return	array()
	*/
	function get_ace($classId,$objId)
	{
	
		$this->addParamWheres ( array ("PtpFolderID" => $objId ) );
		$this->order ( "ID desc" );
		$data = $this->getList ();
		
		
		foreach($data as $k=>$v){
			$userid=$data[$k]['userid'];
			if($data[$k]['to_type']==1){
			$data_file = $this -> db -> executeDataRow("select * from Users_ID where UserID='".$userid."'");
			if (count($data_file)) $data[$k]['col_hsitemname'] = $data_file["fcname"] ;
			}else{
			$data_folder = $this -> db -> executeDataRow("select * from Users_Ro where TypeID='".$userid."'");
			if (count($data_folder)) $data[$k]['col_hsitemname'] = $data_folder["typename"] ;	 
			$data[$k]['to_type'] = 2 ;				 			
			}
		}
//		echo var_dump($data);
//		exit();
		return $data;
	}
	
	/*
	method	添加权限
	param	$classId 
	param	$objId
	return	true/false
	*/
	function set_ace($classId,$objId,$funName,$funGenre,$power,$empType,$empIds,$empNames)
	{
		$field_other = array ("col_funname" => $funName,"col_fungenre" => $funGenre,"col_power" => $power );
		$arr_EmpId = explode ( ",", $empIds );
		$arr_EmpName = explode ( ",", $empNames );
		for($i = 0; $i < count ( $arr_EmpId ); $i ++) {
			$empId = $arr_EmpId [$i];
			$empName = $arr_EmpName [$i];
			$field_keys = array (
							"col_classid" => $classId,
							"col_objid" => $objId,
							"col_hsitemtype" => $empType,
							"col_hsitemid" => $empId,
							"col_hsitemname" => $empName 
			);
			$this->setRelationData($field_keys, "col_hsitemid", $empId, $field_other, $flag );
		}
		
		
		//权限设置后回调处理
		$this -> set_ace_callback($classId,$objId);
		
		return true ;
	}
	
	
	/*
	method	添加权限
	param	$id 
	param	$power
	return 	true/false
	*/
	function set_ace_power($id,$power,$classId = 0,$objId = 0)
	{
		$this->setValue1 ( $id, "DocAce", $power );
		
		return true ;
	}
	
	/*
	method	添加权限
	param	$id 
	param	$power
	return 	true/false
	*/
	function set_ace_powers($id,$power,$classId = 0,$objId = 0)
	{
		$arr_EmpId = explode ( ",", $power );
		for($i = 0; $i < count ( $arr_EmpId ); $i ++) {
			$arr_EmpName = explode ( "-", $arr_EmpId [$i] );
			$this->setValue1 ( $arr_EmpName[0], "DocAce", $arr_EmpName[1] );
		}
		return true ;
	}
	
	/*
	method	删除权限
	param	$id 
	return 	true/false
	*/
	function delete_ace($ids,$classId = 0,$objId = 0 )
	{
		$this -> where = " where ID in(" . $ids . ")" ;
		$this -> delete();
		
		//权限设置后回调处理
		//$this -> set_ace_callback($classId,$objId);
		
		return true ;
	}
	
	/*
	method	设置权限后回调 
	*/
	function set_ace_callback($classId,$objId)
	{
		if ($classId != 102)
			return ;
		
		$this->addParamWheres ( array ("col_classid" => $classId,"col_objid" => $objId ) );
		$count =$this -> getCount();
		
		$sql = " update tab_doc_vfolder set col_style=" . ($count?4:0) . " where col_id=" . $objId ;
		$this -> db -> execute($sql) ;
	}
	
	
}
?>



