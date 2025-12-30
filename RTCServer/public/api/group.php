<?php

/**
 * group.php

 * @date    20150521
 */
require_once ("fun.php");
require_once (__ROOT__ . "/class/hs/Group.class.php");
class RTCGroup {
	private $group;
	function RTCGroup() {
		$this->group = new Group ();
	}

	// 群组添加
	function groupAdd($groupName,$creator,$groupType,$itemIndex, $description, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$user = new User();
		$userId = $user ->getUserId($creator);
		if($userId == 0)
		    return Response::result ( CREATOR_NOT_EXIST );
		 
		$groupId = $this-> group -> addAnGroup($groupName,$groupType,$itemIndex, $description,$userId);

		if ($groupId){
			$this-> group -> updateForm("Clot_RoVesr");
			$this-> group -> updateForm("Clot_FormVesr");
			$this-> group -> updateForm("ClotFile_Vesr");
			$this-> group -> updateClot_RoForm("Users_IDVesr",$groupId);
			$this-> group -> updateClot_RoForm("Users_FormVesr",$groupId);
			return Response::result ( GROUP_OP_SUCCESS, array ('groupid' => $groupId) );
		}else
			return Response::result ( SYS_ERROR_UNDEFINED );
	}

	// 群组删除
	function groupDelete($groupId, $token) 
	{
		recordLog("WebSerivce:groupDelete:" . $groupId);

		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		if ($this->group->isExist ( $groupId )) 
		{
			$this->group->deleteAnGroup ( $groupId );
			$this-> group -> updateForm("Clot_RoVesr");
			$this-> group -> updateForm("Clot_FormVesr");
			$this-> group -> updateForm("ClotFile_Vesr");
			return Response::result ( GROUP_OP_SUCCESS );
		} 
		else
		{
			return Response::result ( GROUP_NOT_EXIST );
		}
	}

	// 群组更新
	function groupUpdate($groupId, $groupName, $itemIndex,$description, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		if ($this->group->isExist ( $groupId )) 
		{
			$this-> group -> updateAnGroup($groupId,$groupName,$itemIndex, $description);
			$this-> group -> updateForm("Clot_RoVesr");
			$this-> group -> updateClot_RoForm("Users_IDVesr",$groupId);
			return Response::result ( GROUP_OP_SUCCESS );
		} 
		else
		{
			return Response::result ( GROUP_NOT_EXIST );
		}
	}

	//获取群组信息
	function groupInfo($groupId ,$token)
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
			
		if ($this->group->isExist ( $groupId )) {
		    $data = $this->group->listMember ( $groupId );
		    //$data = table_fliter_doublecolumn($data,1);
		    $userCount = count($data);
		    $sql = "select TypeName as groupname,Remark as groupnotice,ItemIndex as itemindex,To_Date as createtime,CreatorName as creator from Clot_Ro where TypeID='" . $groupId . "'";
		    $db = new DB();
		    $arrGroupInfo = $db->executeDataRow($sql);
		    //$arrGroupInfo = row_fliter_doublecolumn($arrGroupInfo,1);
		    $arrGroupInfo['usercount'] = $userCount;
		    return Response::result ( GROUP_OP_SUCCESS , $arrGroupInfo );
		}
		else 
		{
		    return Response::result ( GROUP_NOT_EXIST );
		}

	}

	// 设置群组成员
	function groupSetMember($groupId, $loginNames, $token) 
	{
		recordLog("WebSerivce:groupSetMember:groupid=" . $groupId . ",loginames=" . $loginNames);
		
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
			
		//判断群组是否存在
		$isExist = $this->group->isExist ( $groupId ) ;
		if (! $isExist)
			return Response::result ( GROUP_NOT_EXIST );

		$user = new User ();
		
		//得到用户
		$userList = $user -> listUserWithLoginNames($loginNames);
		$userIds = table_column_tostring($userList,"userid",",") ;
		$loginNames = table_column_tostring($userList,"username",",") ;
		for($i=0;$i<count($userList);$i++) $IsAdmins .= (isset($IsAdmins)?",":"") . "0" ;
		//$IsAdmins = table_column_tostring($userList,"isadmin",",") ;
		$userNames = table_column_tostring($userList,"fcname",",") ;
		
		//添加成员
		$loginnames_return = $this->group->addMember($groupId,$userIds,$IsAdmins,$userNames,$loginNames);
		
		$this-> group -> updateForm("Clot_FormVesr");
		$this-> group -> updateClot_RoForm("Users_FormVesr",$groupId);
		//返回结果
		$result = $this -> response_loginname($loginNames,$loginnames_return,GROUP_OP_SUCCESS,GROUP_USER_EXIST);
		return Response::result ( 0, $result );
		

	}

	//群组踢除成员
	function groupKickMember($groupId, $loginNames, $token)
	{
		recordLog("WebSerivce:groupKickMember:groupid=" . $groupId . ",loginames=" . $loginNames);
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		//判断群组是否存在
		$isExist = $this->group->isExist ( $groupId ) ;
		if (! $isExist)
			return Response::result ( GROUP_NOT_EXIST );
		
		$user = new User ();
		
		//得到用户
		$userList = $user -> listUserWithLoginNames($loginNames);
		$userIds = table_column_tostring($userList,"userid",",") ;
		$loginNames = table_column_tostring($userList,"username",",") ;
		$userNames = table_column_tostring($userList,"fcname",",") ;
		
		//删除成员
		$loginnames_return = $this->group->removeMember($groupId,$userIds,$loginNames,$userNames);

		$this-> group -> updateForm("Clot_FormVesr");
		$this-> group -> updateClot_RoForm("Users_FormVesr",$groupId);
		//返回结果
		$result = $this -> response_loginname($loginNames,$loginnames_return,GROUP_OP_SUCCESS,GROUP_USER_NOT_EXIST);
		return Response::result ( 0, $result );

	}

	// 获取群组下成员
	function groupListMember($groupId, $token)
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		if ($this->group->isExist ( $groupId )) 
		{
			$data = $this->group->listMember ( $groupId );
			//$data = table_fliter_doublecolumn($data,1);
			return Response::result ( GROUP_OP_SUCCESS, $data );
		} 
		else
		{
			return Response::result ( GROUP_NOT_EXIST );
		}
	}
	
	/*
	meothed:返回结果
	return:
	*/
	function response_loginname($all_loginNames,$success_loginNames,$code_success,$code_fail)
	{
		//比较数据 得到INSERT IDS 与DELETE IDS
		$arr_all = explode(",",$all_loginNames);
		$arr_success = explode(",",$success_loginNames);
		$arr_fail = array_diff($arr_all, $arr_success) ; //所有的与成功的差值，则是失败的

		$result = array();
		$i = 0;
		foreach($arr_success as $value)
		{
			if ($value == "")
				continue ;
			$result [$i] ['code'] = $code_success ;
			$result [$i] ['loginname'] = $value ;
			$i++ ;
		}
		foreach($arr_fail as $value)
		{
			if ($value == "")
				continue ;
			$result [$i] ['code'] = $code_fail ;
			$result [$i] ['loginname'] = $value ;
			$i++ ;
		}
		return $result ;
	}
}

$serviceName = "RTCGroup";
require_once ('service.inc.php');