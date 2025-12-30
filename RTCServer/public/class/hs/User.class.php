<?php
/**
 * 人员管理类

 * @date    20140325
 */
class User extends Model {
	function __construct() {
		$this->tableName = "Users_ID";
		$this->db = new DB ();
		//$this -> DefaultRole = $this -> getDefaultRole();
	}
	
//	function insert2($parentId,$name,$userId)
//	{
//		$childType = DOC_VFOLDER ;
//		$tableName = "PtpFolder";
//		
//
//		//添加数据
//		switch (DB_TYPE)
//		{
//			case "access":
//				$sql = "Select max(clng(PtpFolderID)) as c from PtpFolder where MyID='".$userId."'";
//				break ;
//			default:
//				$sql = "Select max(CONVERT(int,PtpFolderID)) as c from PtpFolder where MyID='".$userId."'";
//				break;
//		}
//		$childEmpId  =$this -> db -> executeDataValue($sql);
//		if(empty($childEmpId)) $childEmpId=0;
//		$childEmpId=$childEmpId+1;
//		$childEmpId=$childEmpId+100000000;
//		$childEmpId=substr($childEmpId,-8);
//			
//		$fields = array("PtpFolderID"=>$childEmpId,"UsName"=>$name,"MyID"=>$userId,"ParentID" => $parentId);
//		$folder = new Model($tableName);
//		$folder -> addParamFields($fields);
//		$folder -> insert();
//		//得到ID
// 		$childId = $this -> db -> getMaxId($tableName,"ID");
//		
//		return array("type"=>$childType,"id"=>$childId,"ptpfolderid"=>$childEmpId);
//	}
	
	function insert2($name,$userId)
	{
		$childType = DOC_VFOLDER ;
		$tableName = "PtpFolder";
		

		//添加数据
		$fields = array("UsName"=>$name,"MyID"=>$userId,"CreatorID" => CurUser::getUserId(),"CreatorName" => CurUser::getLoginName());
		$folder = new Model($tableName);
		$folder -> addParamFields($fields);
		$folder -> insert();
		
		//得到ID
 		$childId = $this -> db -> getMaxId($tableName,"PtpFolderID");
		
		//添加关系
		//$this -> relation -> addRelation($parentType,$parentId,$childType,$childId);
		
		return array("type"=>$childType,"ptpfolderid"=>$childId);
	}
	
	function insert3($name,$userId)
	{
		$childType = DOC_VFOLDER ;
		$tableName = "Col_Ro";

		$fields = array("TypeName"=>$name,"MyID"=>$userId);
		$folder = new Model($tableName);
		$folder -> addParamFields($fields);
		$folder -> insert();
		//得到ID
 		$childId = $this -> db -> getMaxId($tableName,"TypeID");
		
		return array("type"=>$childType,"id"=>$childId);
	}
	
	function deleteAnUser($userId) {
		$sqls = array (
				"delete from Users_ID where UserID=" . $userId,
				"delete from Users_Role where UserID=" . $userId,
				"delete from LeaveFile where UserID1=" . $userId . " or UserID1='".str_replace("'","",$userId) . "m'",
				//"delete from Messeng_Type where UserID1=" . $userId . " or UserID1='".str_replace("'","",$userId) . "m'",
				"delete from Users_Pic where UserID=" . $userId,
				"delete from PtpForm where MyID=" . $userId . " or UserID=" . $userId,
				"delete from PtpFolder where MyID=" . $userId,
				"delete from PtpFile where MyID=" . $userId,
				"delete from OnlineFile where FormFileType=7 and MyID=" . $userId,
				"delete from OnlineForm where MyID=" . $userId . " or UserID=" . $userId,
				"delete from OnlineHeat where MyID=" . $userId,
				"delete from OnlineRevisedFile where MyID=" . $userId,
				"delete from Col_Ro where MyID=" . $userId,
				"delete from Col_Form where MyID=" . $userId
		);
		$result = $this->db->execute ( $sqls );
		return $result;
	}
	
	function deleteRole($userId) {
		$sql = "delete from Users_Role where UserID=" . $userId;
		$result = $this->db->execute ( $sql );
		return $result;
	}


	function savePassword($userId, $password, $passWordType = 0) {
		$sql = "update Users_ID set UserPaws='" . ($passWordType == 1 ? md5 ( $password ) : $password) . "' where UserID=" . $userId;
		$result = $this->db->execute ( $sql );
		return $result;
	}

	/*
	* 修改密码
	* @return array("result"=>1,"data"=>$row)
	*/
	function setPassword($userId,$old_password,$new_password)
	{
		$user = new Model("Users_ID");

		$user->field ( "UserPaws" );
		$user->addParamWhere ( "UserID", $userId );
		$row = $user->getDetail ();

		$result = array (
				"status" => 1,
				"errnum" => 0
		);

		if (count ( $row ) == 0)
			return array (
					"status" => 0,
					"errnum" => 102001
			);

		if (! $this->validPassword ( $old_password, trim($row ["userpaws"]), 0 ))
			return array (
					"status" => 0,
					"errnum" => 102002
			);

		$sql = "update Users_ID set UserPaws='" . trim($new_password) . "' where UserID='" . $userId ."'";
		$this->db->execute ( $sql );

		return $result;
	}
	
	
	function validPassword($password, $dbPassword, $enType) 
	{
		if ($enType == 0)
			return $password == $dbPassword;
		else
			return md5 ( $password ) == $dbPassword;
	}

	function listRole($userId) 
	{
		$sql = " Select Role.ID,Role.RoleName from Users_Role,Role where Users_Role.UserID='" . $userId . "' and Users_Role.RoleID=Role.ID";
		return $this->db->executeDataTable ( $sql );
	}

	function save($fields, $userId = "") 
	{
		$user = new Model ( "Users_ID","UserID" );
		$user->addParamFields ( $fields );

		// 用户存在则更新
		if ($userId != "") {
			$user->addParamWhere ( "UserID", $userId);
			$user->update ();
		}else{
			$user_id = $user -> getMaxId();
			if(empty($user_id)) $user_id=0;
			$user_id=$user_id+1;
			$user -> addParamField("UserID",$user_id);
			$user -> insert ();
			$this -> insertPic($user_id);
			$this -> insert2("RTC",$user_id);
			$this -> insert3("RTC",$user_id);
		}
		
		$user -> delete_Role($user_id);
		$arrroleid = explode ( ",", g("roleid") );
		foreach ( $arrroleid as $roleid ) {
			if ($roleid != "") {
					$user -> insertRole($user_id,$roleid);
			}
		}
		$user -> updateUsers_IDForm($user_id);
		$user -> updateForm("Users_IDVesr");
		if ($userId != "") {
			return $userId;
		}else{
			return $user_id;
		}
	}

	/*
	 * 获取用户id
	 */
	function getUserId($loginName, $userId = "") {
		$user = new Model ( "Users_ID" );
		$user->addParamWhere ( "UserName", $loginName );

		// 修改时判断是否重名
		if ($userId != "")
			$user->addParamWhere ( "UserID", $userId);
		$userId = $user->getValue ( "UserID" );
		if ($userId != "")
			return $userId;
		return 0;
	}
	
	function getChaterId($loginName, $userId = "") {
		$user = new Model ( "lv_chater" );
		$user->addParamWhere ( "LoginName", $loginName );

		// 修改时判断是否重名
		if ($userId != "")
			$user->addParamWhere ( "UserId", $userId);
		$userId = $user->getValue ( "UserID" );
		if ($userId != "")
			return $userId;
		return 0;
	}
	
	/*得到用户信息*/
	function listUserWithUserIdArray($arr_id)
	{
		$ids = array2str($arr_id) ;

		if ($ids == "")
			return array();
			
		$sql = " select col_id,col_loginname,col_name from hs_user where col_id in(" . $ids . ")" ;
		return $this-> db -> executeDataTable( $sql );
	}
	
	/*得到用户信息*/
	function listUserWithLoginNames($loginnames)
	{
		if ($loginnames == "")
			return array();
			
		$sql = " select UserID,UserName,0 as IsAdmin,FcName from Users_ID where UserName in('" . str_replace(",","','",$loginnames) . "')" ;
		return $this-> db -> executeDataTable( $sql );
	}

	//设置拼音（未设置的）
	function setPinYin()
	{
		$py = new PinYin();

		$sql = "select col_id,col_name from hs_user where col_allspell='' or col_allspell is null " ;
		$data = $this -> db -> executeDataTable($sql);
		$sqls = array();

		$i=0;

		foreach($data as $row)
		{
			$all_py = strtoupper( $py -> getAllPY($row["col_name"])) ;
			$first_py = strtoupper($py -> getFirstPY($row["col_name"])) ;

			//名字为英文会返回空
			if($all_py == "")
				$all_py = $first_py = strtoupper($row["col_name"]);
			$sqls[$i] = " update hs_user set col_allspell='" . $all_py . "' ,col_firstspell='" . $first_py . "' where col_id=" . $row["col_id"] ;
			$i++;
		}

 		$this -> db ->  execute($sqls);

		return 1 ;
	}
	
	/*
	method	设置人员部门路径
			jc 20150716
	*/
	function setUserDeptInfo($userId,$parentEmpType,$parentEmpId,$parentEmpName,$parentPath)
	{
		if (($parentEmpType == 0) || ($parentEmpType == EMP_VIEW) || ($parentEmpType == EMP_DEPT))
		{
			$this -> clearParam();
			$this -> addParamField("col_dt_modify",getNowTime(),"datetime");
			$this -> addParamField("col_deptid",$parentEmpId);
			$this -> addParamField("col_deptinfo",$parentEmpName);
			$this -> addParamField("col_alldeptinfo",$parentPath);
			$this -> addWhere("col_id in(" . $userId . ")");
			$this -> update();
		}
	}
	
	/*
	method	设置人员部门路径
			得到人员 
			批量更新同个部门人员的路径
	*/
	function set_path_with_user($whereSql = "")
	{
		$sql = "select col_id from hs_user  " . ($whereSql == ""?"":" where " . $whereSql);
		$data_user = $this -> db -> executeDataTable($sql);

		//根据人员得到部门路径
		$relation = new EmpRelation();

		$sqls = array();
		foreach($data_user as $row)
		{
			$user_id = $row["col_id"] ;
			$path_name = $relation -> get_path_name(1, $user_id,0);
			
			if ($path_name != "")
				$sqls[] = " update hs_user set col_alldeptinfo='" . $path_name . "' where col_id=" . $user_id;
		}
		$this -> db ->  execute($sqls);
		return 1 ;
	}

	/*
	method	设置部门路径 
			col_alldeptinfo 生成完整的部门路径
			触点软件/技术中心/研发一部
	param	$field_dept   col_alldeptinfo/col_deptinfo
	param	$dept_level  0 全部  >0 最后N级
	*/
	function setPath($field_dept = "col_alldeptinfo",$dept_level = 0)
	{
		$dept = new Department();
		$sqls = array();
		
		//得到部门数据
		$data = $dept -> bulidPathData() ;
		
		$i = 0 ;
		foreach($data as $row)
		{
			$arr_id = explode("_",$row["id"]) ;
			$emp_type = $arr_id[0] ;
			$emp_id = $arr_id[1] ;
			$path = $row["path"] ;
			
			if ($dept_level > 0)
				$path = $this -> getPathByLevel($path,$dept_level);
				
			//更新部门下的人员路径
			$sqls[] = " update hs_user set " . $field_dept . "='" . $path . "'  where col_id in(select col_dhsitemid from hs_relation " . 
				   " where col_dhsitemtype=1 and col_hsitemtype=" . $emp_type . " and col_hsitemid=" . $emp_id . ")" ;
					   
		}
		
		$this -> db -> execute($sqls) ;

	}
	
	/*
	method	得到级别
	param	$path	触点软件/技术中心/研发一部
	param	$level  2
	return 	技术中心/研发一部
	*/
	function getPathByLevel($path,$level)
	{
		$arr = explode("/",$path) ;
		$max = count($arr) ;
		
		//如果需要的级别大于当前级别，全部返回
		if ($level > $max)
			return $path;
			
		$path = "" ;
		for($i=($max-1);$i>($max-$level-1);$i--)
			$path = $arr[$i] . ($path?"/":"") . $path ;
		
		return $path ;
	}


	function getPath($userId)
	{
	    $empRel = new EmpRelation();
	    $path_name = $empRel -> get_path_name(1, $userId);
	    return $path_name;
	}

	function clearUserDeptRel($userId){
        $sql = "delete from hs_relation where col_dhsitemid in (" . $userId . ") and col_dhsitemtype=1 and col_viewid in (select col_id from hs_view where col_type=1)";
        $this->db->execute($sql);
	}

	//短信扩展号
	function getAddNum($userId) {
		$this->clearParam ();
		$this->addParamWhere ( "col_Id", $userId ,"=" ,"int" );
		$addNum = $this->getValue ( "col_addnum" );
		if ($addNum == 0) {
			$this->clearParam ();
			$this->fldId = "Col_AddNum";
			$addNum = $this->getMaxId () + 1;
			$this->clearParam ();
			$this->fldId = "Col_Id";
			$this->setValue($userId, "col_addnum", $addNum);
			return $addNum;
		}
		else
			return $addNum;
	}
	
	function list_file2($C_vesr)
	{
		$sql = "Select Users_RoVesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select TypeID,TypeName,ParentID,Description,ItemIndex from Users_Ro order by CONVERT(int,ItemIndex) desc,ParentID asc";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file3($C_vesr,$UserIds)
	{
		$sql = "Select Users_IDVesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		$data1 = array();
		if($S_vesr==$C_vesr){
		$sql = "Select UserID,UserIcoLine,NetworkIP,LocalIP from Users_ID where UserState=1";
		$data = $this -> db -> executeDataTable($sql);
		}else{
			
		//if($UserIds){
		  $arr_id = explode(",",$UserIds);
		  
		  $sql = "Select UppeID,UserID,UserName,FcName,Age,Jod,Tel1,Tel2,Address,Say,UserIco,UserIcoLine,School,Effigy,Constellation,remark,Sequence,NetworkIP,LocalIP,Users_IDVesr from Users_ID where UserState=1";
		  $data = $this -> db -> executeDataTable($sql);
		  
		  $i=0;
		  foreach($arr_id as $id)
		  {
			  if ($id)
			  {
				  $arr_item = explode("_",$id);
				  $IsExist = 0;
				  foreach($data as $k=>$v){
					  if($data[$k]['userid']==$arr_item[0]){
						  $IsExist = 1;
						  break ;
					  }	
				  }
				  if($IsExist==0){
					   $data1[$i]['userid'] = $arr_item[0] ;
					   $i++;
				  }
			  }
		  }
		  
		  foreach($data as $k=>$v){
			  $IsExist = 0;
			  foreach($arr_id as $id)
			  {
				  if ($id)
				  {
					  $arr_item = explode("_",$id);
					  if($data[$k]['userid']==$arr_item[0]){
						  $IsExist = 1;
						  if($data[$k]['users_idvesr']==$arr_item[1]) unset($data[$k]);
						  else $data[$k]['ac'] = 2 ;
						  break ;
					  }

				  }
			  }
			  if($IsExist==0) $data[$k]['ac'] = 1 ;
			  //$data[$k]['userpaws'] = "" ;
		  }

		//}

		
//		$sql = "Select UppeID,UserID,UserName,UserPaws,FcName,Age,Jod,Tel1,Tel2,Address,Say,UserIco,UserIcoLine,School,Effigy,Constellation,remark,Sequence,NetworkIP,LocalIP from Users_ID where UserState=1";
//		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"data1"=>$data1,"vesr"=>$S_vesr);
	}
	
	function list_file4($C_vesr,$Clot_Ros)
	{
		$sql = "Select Clot_RoVesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
			//$sql = "Select bb.* from (Select * from Clot_Form where UserID='".CurUser::getUserId()."') as aa,Clot_Ro as bb where aa.UpperID=bb.TypeID";
			$sql = "Select * from Clot_Ro";
			$data = $this -> db -> executeDataTable($sql);
			//if($Clot_Ros){
				$arr_id = explode(",",$Clot_Ros);

				$i=0;
				foreach($arr_id as $id)
				{
					if ($id)
					{
						$arr_item = explode("_",$id);
						$IsExist = 0;
						foreach($data as $k=>$v){
							if($data[$k]['typeid']==$arr_item[0]){
								$IsExist = 1;
								break ;
							}	
						}
						if($IsExist==0){
							 $data1[$i]['typeid'] = $arr_item[0] ;
							 $i++;
						}
					}
				}
				
				foreach($data as $k=>$v){
					$IsExist = 0;
					foreach($arr_id as $id)
					{
						if ($id)
						{
							$arr_item = explode("_",$id);
							if($data[$k]['typeid']==$arr_item[0]){
								$IsExist = 1;
								if($data[$k]['users_idvesr']==$arr_item[1]) unset($data[$k]);
								else $data[$k]['ac'] = 2 ;
								break ;
							}
	  
						}
					}
					if($IsExist==0) $data[$k]['ac'] = 1 ;
				}
			//}
			return array("data"=>$data,"data1"=>$data1,"vesr"=>$S_vesr);
		}
		return array("data"=>$data,"data1"=>$data1,"vesr"=>$S_vesr);
	}
	
	function list_file5($C_vesr,$Clot_Forms)
	{
		$sql = "Select Clot_FormVesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){

			//if($Clot_Forms){
				$arr_id = explode(",",$Clot_Forms);
				$i=0;
				foreach($arr_id as $id)
				{
					if ($id)
					{
						$arr_item = explode("_",$id);
						$sql = "Select Users_FormVesr as c from Clot_Ro where TypeID='".$arr_item[0]."'";
						$users_formvesr = $this -> db -> executeDataValue($sql);
						if($users_formvesr!=$arr_item[1]){
							$sql = "Select UpperID,UserID,IsAdmin as Admin,remark from Clot_Form where UpperID='".$arr_item[0]."' order by UpperID Asc";
							$data_file = $this -> db -> executeDataTable($sql);
							$data = array_merge($data,$data_file) ;
							$data1[$i]['typeid'] = $arr_item[0] ;
							$data1[$i]['users_formvesr'] = $users_formvesr ;
							$i++;
						}
					}
				}
			//}
		
		}
		return array("data"=>$data,"data1"=>$data1,"vesr"=>$S_vesr);
	}

	function list_file6($C_vesr)
	{
		$sql = "Select Fav_FormVesr as c from Users_ID where UserID='".CurUser::getUserId()."'" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select UserID from Fav_Form where MyID='".CurUser::getUserId()."'";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	
	function list_file7($C_vesr)
	{
		$sql = "Select Plug_Vesr as c from UpDateForm where ID = 1" ;
		$S_vesr = $this -> db -> executeDataValue($sql);
		$data = array();
		if($S_vesr!=$C_vesr){
		$sql = "Select * from Plug where Plug_Enabled=1";
		$data = $this -> db -> executeDataTable($sql);
		}
		return array("data"=>$data,"vesr"=>$S_vesr);
	}
	
	function list_file8($C_vesr)
	{
		$data = array();
		$sql = "Select SUpDate,UserApply,IPAddress,WebName,WebUrl,WebRun from OtherForm where id =1";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_file9($key)
	{
		
		$sql = "Select * from Clot_Ro where TypeID like '%".$key."%' or TypeName like '%".$key."%' order by TypeID Asc";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
}

?>