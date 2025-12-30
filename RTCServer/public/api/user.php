<?php
/**
 * user.php
 * @author  zwz
 * @date    2014 上午9:07:11
 */
require_once('fun.php');
require_once (__ROOT__ . "/class/common/PinYin.class.php");
class RTCUser {

	private $user;

	function RTCUser() {
		$this->user = new User();
	}

	// 增加用户
	function userAdd($UserName, $FcName, $UserPaws, $Sequence, $Constellation, $Tel1, $Tel2, $UserIco, $Jod, $remark, $UppeID, $IsManager, $UserState, $token) {
		recordLog("1");
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$userId = $this->user->getUserId ( $UserName );
		recordLog("2");
		
		
		// 用户已经存在
		if ($userId > 0)
			return Response::result ( USER_IS_EXIST, array (
					'userid' => $userId
			) );
		$py = new PinYin ();
		$fields = array (
		        'UppeID' => $UppeID,
				'UserName' => $UserName,
				'UserPaws' => $UserPaws,
				'FcName' => $FcName,
				'Jod' => $Jod,
				'Tel1' => $Tel1,
				'Tel2' => $Tel2,
				'UserIco' => $UserIco,
				'Constellation' => $Constellation,
				'remark' => $remark,
				'Sequence' => $Sequence,
				'UserState' => $UserState,
				'IsManager' => $IsManager
//				'col_firstspell' => $py->getFirstPY ( $userName ),
//				'col_allspell' => $py->getAllPY ( $userName )
		);
//		echo var_dump($fields);
//		exit();

		// 创建帐号，返回用户id
		$userId = $this->user->save ( $fields );
		recordLog("3");
		return Response::result ( USER_OP_SUCCESS, array (
				'userid' => $userId
		) );
	}

	// 删除用户
	function userDelete($UserNames, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$arrUser = explode ( ",", $UserNames );

		$i = 0;
		foreach ( $arrUser as $UserName ) {
			$userId = $this->user->getUserId ( $UserName );

			// 用户不存在
			if ($userId == 0) {
				$result [$i] ['code'] = USER_NOT_EXIST;
			} else {
				$file = RTC_CONSOLE."/MyPic/".$userId.".jpg";
				if (file_exists ( $file )) unlink ( $file );
				$result [$i] ['code'] = $this->user->deleteAnUser ("'".$userId."'") > 0 ? USER_OP_SUCCESS : SYS_ERROR_UNDEFINED;
			}

			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $UserName;
			$i ++;
		}
		$this->user -> updateForm("Users_IDVesr");
		return Response::result ( 0, $result );
	}

	// 用户更新
	function userUpdate($UserName, $FcName, $UserPaws, $Sequence, $Constellation, $Tel1, $Tel2, $UserIco, $Jod, $remark, $UppeID, $IsManager, $UserState, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$this->user->clearParam();
		$this->user->addParamWhere("UserName", $UserName);
		$count = $this->user->getCount();

		// 用户不存在
		if ($count == 0)
			return Response::result ( USER_NOT_EXIST );

		$py = new PinYin ();

		//检查重名
//		if($this->user->getUserId($UserName,$userId)>0)
//			return Response::result ( USER_DUPLICATE_NAME );
		$this->user->clearParam();
		if($UppeID) $this->user->addParamField("UppeID",$UppeID);
		if($UserPaws) $this->user->addParamField("UserPaws",$UserPaws);
		if($FcName) $this->user->addParamField("FcName",$FcName);
		if($Jod) $this->user->addParamField("Jod",$Jod);
		if($Tel1) $this->user->addParamField("Tel1",$Tel1);
		if($Tel2) $this->user->addParamField("Tel2",$Tel2);
		if($UserIco) $this->user->addParamField("UserIco",$UserIco);
		if($Constellation) $this->user->addParamField("Constellation",$Constellation);
		if($remark) $this->user->addParamField("remark",$remark);
		if($Sequence) $this->user->addParamField("Sequence",$Sequence);
		if($UserState) $this->user->addParamField("UserState",$UserState);
		if($IsManager) $this->user->addParamField("IsManager",$IsManager);
		$this->user->addParamWhere("UserName", $UserName);
		$this->user->update();
		$user_id = $this->user->getUserId ( $UserName );
		if(g("roleid")){
			$this->user -> delete_Role($user_id);
			$arrroleid = explode ( ",", g("roleid") );
			foreach ( $arrroleid as $roleid ) {
				if ($roleid != "") {
						$this->user -> insertRole($user_id,$roleid);
				}
			}
		}
		$this->user -> updateUsers_IDForm($user_id);
		$this->user -> updateForm("Users_IDVesr");
		return Response::result ( USER_OP_SUCCESS );
	}

	// 获取用户信息
	function userInfo($UserName, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$userId = $this->user->getUserId ( $UserName );
		// 用户不存在
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		$this->user->addParamWhere ( "UserName", $UserName );
		$this->user->field = "UserID as userid,UserName as loginname,FcName as username,Sequence as itemindex, Constellation as email, Tel1 as mobile, Tel2 as phone, UserIco as sex, Jod as jobtitle, remark as description, IsManager as issuper, UserState as desabled";
		$arrUserInfo = $this->user->getDetail ();

		// 去重
		//$arrUserInfo = row_fliter_doublecolumn ( $arrUserInfo, 1 );
		return Response::result ( USER_OP_SUCCESS, $arrUserInfo );
	}
	
	/*
	method	判断用户是否在线
	param	$UserNames 多个帐号以逗号分隔,不用含域名
	*/
	function getUserOnlineStatus($UserNames, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$arrUser = explode ( ",", $UserNames );

		$i = 0;
		foreach ( $arrUser as $UserName ) {
			$userId = $this->user->getUserId ( $UserName );

			// 用户不存在
			if ($userId == 0) {
				$result [$i] ['code'] = USER_NOT_EXIST;
			} else {
				$this->user->clearParam();
				$this->user->addParamWhere ( "UserName", $UserName );
				$this->user->field = "UserIcoLine";
				$arrUserInfo = $this->user->getDetail ();
				$result [$i] ['usericoline'] = $arrUserInfo["usericoline"];
			}

			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $UserName;
			$i ++;
		}
		return Response::result ( 0, $result );
	}

	// 用户验证
	function userValid($UserName, $UserPaws, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$userId = $this->user->getUserId ( $UserName );
		// 用户不存在
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		$this->user->addParamWhere ( "UserName", $UserName );
		$this->user->field = "UserPaws";
		$arrUserInfo = $this->user->getDetail ();
		$result = $this->user->validPassword($UserPaws, $arrUserInfo["userpaws"]);
		if(!$result)
			return Response::result(USER_ERROR_PASSWORD);
		return Response::result(USER_VALID_SUCCESS);
	}

	// 设置用户密码
	function setPassword($UserName, $UserPaws, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$userId = $this->user->getUserId ( $UserName );
		// 用户不存在
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		if ($this->user->savePassword ( $userId, $UserPaws ) > 0)
			return Response::result ( USER_OP_SUCCESS );
		else
			return Response::result ( SYS_ERROR_UNDEFINED );
	}

	// 获取用户列表
	function listUser($pageIndex, $pageSize, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$recordCount = 0;
		$db = new DB ();
		$sql_count = "select  count(*) as c  from hs_user";
		$sql_list = "select col_id as userid,col_loginname as loginname,col_name as username,col_itemindex as itemindex, col_email as email, col_mobile as mobile, col_o_phone as phone, col_sex as sex, col_o_jobtitle as jobtitle, col_description as description, col_isSuper as issuper, col_disabled as desabled from hs_user";

		$recordCount = $db->executeDataValue ( $sql_count );

		if ($recordCount > 0) {
			if ($pageIndex == - 1)
				$pageIndex = get_page_count ( $recordCount, $pageSize );
			$data = $db->page ( $sql_list, $pageIndex, $pageSize );
			$data = table_fliter_doublecolumn ( $data, 1 );
		} else {
			$pageIndex = 0;
			$data = array ();
		}
		return Response::result ( USER_OP_SUCCESS, array (
						'recordcount' => $recordCount,
						'users' => $data
		) );
	}

	//禁用启用帐号
	function disableUser($UserName,$UserState,$token)
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$userId = $this->user->getUserId ( $UserName );
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		$this->user->clearParam();
		$this->user->addParamWhere("UserID", $userId);
		if($UserState == 0)
			$this->user->addParamField("UserState",0,"int");
		else
			$this->user->addParamField("UserState",1,"int");
		$this->user->update();
		return Response::result ( USER_OP_SUCCESS );
	}

}
//$serviceName="RTCUser";
//require_once ("service.inc.php");
?>