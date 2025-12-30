<?php
/**
 * department.php
 * @author  zwz
 * @date    2014年10月10日 11:33:21
 */
require_once('fun.php');
class RTCDepartment {
	private $department;
	function RTCDepartment() {
		$this->department = new Department ();
	}

	// 部门增加
	function deptAdd($path, $itemIndex, $description, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$arrDeptInfo = $this->department->getIdByPath ( $path );
		$tbName = $this->department->getTableName ( $arrDeptInfo ['emptype'] );

		// 写入部门排序和描述
		$sql = "update " . $tbName . " set ItemIndex=" . $itemIndex . ",Description='" . $description . "' where TypeID='" . $arrDeptInfo ['empid'] . "'";
		$result = $this->department->db->execute ( $sql );
		return $this->formatResult ( $result, $arrDeptInfo );
	}

	// 部门删除
	function deptDelete($path, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$arrDeptInfo = $this->department->getIdByPath ( $path, false );

		$empType = $arrDeptInfo ['emptype'];
		$empId = $arrDeptInfo ['empid'];

		// 找不到部门
		if ($empId == 0)
			return Response::result ( DEPT_NOT_EXIST );

		if ($this->department -> checkHasChild($empType, $empId))
			return Response::result ( DEPT_OP_FAILED );
		$tbName = $this->department->getTableName ( $empType );

		$sql = "delete from " . $tbName . " where TypeID='" . $empId . "'";
		//return $sql;
		$result = $this->department->db->execute ( $sql );
		$user = new Model ( "Users_Ro" );
		$user -> updateForm("Users_RoVesr");
		return $this->formatResult ( $result, $arrDeptInfo );
	}

	// 部门更新
	function deptUpdate($path, $newName, $itemIndex, $description, $token) {

		// 检查token
		if (! authenticate ( $token )) {
			return Response::result ( SYS_ERROR_TOKEN, array () );
		}
		// 获取部门信息
		$arrDeptInfo = $this->department->getIdByPath ( $path, false );
		$empType = $arrDeptInfo ['emptype'];
		$empId = $arrDeptInfo ['empid'];

		// 找不到部门
		if ($empId == 0)
			return Response::result ( DEPT_NOT_EXIST );
			
		if (!$newName)
			return Response::result ( DEPT_IS_EMPTY );

		$isExist = $this->department->isExist ( $arrDeptInfo ['parentemptype'], $arrDeptInfo ['parentempid'], $empType, $empId, $newName );

		// 检查是否与现有部门重名
		if ($isExist)
			return Response::result ( DEPT_DUPLICATE_NAME );

		$tbName = $this->department->getTableName ( $empType );

		$sql = "update " . $tbName . " set TypeName='" . $newName . "',ItemIndex=" . $itemIndex . ",Description='" . $description . "' where TypeID='" . $empId . "'";
		$result = $this->department->db->execute ( $sql );
		$user = new Model ( "Users_Ro" );
		$user -> updateForm("Users_RoVesr");
		return $this->formatResult ( $result, $arrDeptInfo );
	}

	// 获取部门信息
	function deptInfo($path, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

			// 获取部门信息
		$arrDeptInfo = $this->department->getIdByPath ( $path, false );
		$viewId = $arrDeptInfo ['viewid'];
		$empType = $arrDeptInfo ['emptype'];
		$empId = $arrDeptInfo ['empid'];

		// 找不到部门
		if ($empId == 0)
			return Response::result ( DEPT_NOT_EXIST );

		$tbName = $this->department->getTableName ( $empType );
		$sql = "select TypeName as name,ItemIndex as itemindex,Description as description from " . $tbName . " where TypeID='" . $empId . "'";

		$result = $this->department->db->executeDataRow ( $sql );

		if (count ( $result ) > 0) {
			//$result = row_fliter_doublecolumn ( $result, 1 );
			$result = array_merge ( array (
					"viewid" => $viewId,
					"emptype" => $empType,
					"empid" => $empId
			), $result );
			return Response::result ( DEPT_OP_SUCCESS, $result );
		} else {
			return Response::result ( DEPT_NOT_EXIST );
		}
	}

	// 设置部门成员,多帐号以,分隔
	function deptSetMember($path, $UserNames,$isClear,$token) {

		// 检查token
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );



	    // 获取部门信息
		$arrDeptInfo = $this->department->getIdByPath ( $path, false );
		$viewId = $arrDeptInfo ['viewid'];
		$empType = $arrDeptInfo ['emptype'];
		$empId = $arrDeptInfo ['empid'];

		// 部门不存在
		if ($empId == 0)
			return Response::result ( DEPT_NOT_EXIST );
		if (!$UserNames)
			return Response::result ( USER_NOT_EXIST );
		$arrLoginNames = explode ( ",", $UserNames );
		$i = 0;

		foreach ( $arrLoginNames as $UserName ) {
			// 获取用户id
			$user = new User ();
			$user -> addParamWhere("UserName", $UserName);
			$row = $user->getDetail ();
			$userId = $row['userid'];

			if($isClear==1)
			{
				$UppeID = "'".$empId."'";
			}else{
				if(strpos($row['uppeid'],$empId)) $UppeID = "UppeID";
				else $UppeID = "UppeID+',".$empId.",'";
			}

			if ($userId == 0) {
				$result [$i] ['code'] = USER_NOT_EXIST;
			} else {
				// 建立关系
				$user->db->execute(" update Users_ID set UppeID=" . $UppeID . ",Users_IDVesr=Users_IDVesr + 1 where UserID ='" . $userId . "'");
				$result [$i] ['code'] = DEPT_OP_SUCCESS;
			}

			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $UserName;

			$i ++;
		}
		$user = new User ();
		$user -> updateForm("Users_IDVesr");
		return Response::result ( 0, $result );
	}

	// 部门移除成员,多帐号以,分隔
	function deptRemoveMember($path, $loginNames, $token) {

		// 检查token
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		// 获取部门信息
		$arrDeptInfo = $this->department->getIdByPath ( $path, false );
		$viewId = $arrDeptInfo ['viewid'];
		$empType = $arrDeptInfo ['emptype'];
		$empId = $arrDeptInfo ['empid'];

		// 部门不存在
		if ($empId == 0)
			return Response::result ( DEPT_NOT_EXIST );
		$arrLoginNames = explode ( ",", $loginNames );
		$i = 0;
		$user = new User ();
		$empRelation = new EmpRelation ();
		foreach ( $arrLoginNames as $loginName ) {

			// 获取用户id
			$userId = $user->getUserId ( $loginName );
			if ($userId == 0) {
				$result [$i] ['code'] = USER_NOT_EXIST;
			} else {

				// 建立关系
				$empRelation->delete($viewId,$empType,$empId,EMP_USER,$userId);
				$result [$i] ['code'] = DEPT_OP_SUCCESS;
			}

			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $loginName;

			$i ++;
		}
		return Response::result ( 0, $result );
	}

	// 格式化返回值
	private function formatResult($result, $arrDeptInfo, $arrOther = array()) {
		if ($result > 0) {
			$result = array (
					'viewid' => $arrDeptInfo ['viewid'],
					'emptype' => $arrDeptInfo ['emptype'],
					'empid' => $arrDeptInfo ['empid']
			);
			if (count ( $arrOther ) > 0)
				$result = array_merge ( $result, $arrOther );
			return Response::result ( DEPT_OP_SUCCESS, $result );
		} else {
			return Response::result ( SYS_ERROR_UNDEFINED );
		}
	}
}
$serviceName="RTCDepartment";
require_once ('service.inc.php');