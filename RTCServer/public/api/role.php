<?php

/**
 * role.php
 * @author  zwz
 * @date    2014 上午9:07:51
 */
require_once ("fun.php");
require_once (__ROOT__ . "/class/hs/Role.class.php");
class AntRole {
	private $role;
	function AntRole() {
		$this->role = new Role ();
	}
	
	// 角色增加
	function roleAdd($roleName, $description, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		
		$fields = array (
						'col_name' => $roleName,
						'col_description' => $description,
						'col_disabled' => 0,
						'col_appname' => "RTC" 
		);
		
		$roleId = $this->role->save ( $fields );
		return Response::result ( ROLE_OP_SUCCESS, array (
						'roleid' => $roleId 
		) );
	}
	
	// 角色删除
	function roleDelete($roleName, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		
		$roleId = $this->role->getRoleId ( $roleName );
		if ($roleId == 0)
			return Response::result ( ROLE_NOT_EXIST );
		$this->role->deleteAnRole ( $roleId );
		$this->role->db->execute ( "delete from hs_relation where col_hsitemtype=" . EMP_GROUP . " and col_hsitemid=" . $roleId );
		return Response::result ( ROLE_OP_SUCCESS, array (
						'roleid' => $roleId 
		) );
	}
	function roleUpdate($roleId, $roleName, $description, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		
		$count = $this->role->db->executeDataValue ( "select count(*) as c from hs_role where col_id=" . $roleId ) > 0;
		
		// 角色不存在
		if ($count == 0)
			return Response::result ( ROLE_NOT_EXIST );
			
			// 检查重名
		if ($this->role->getRoleId ( $roleName, $roleId ) > 0)
			return Response::result ( ROLE_DUPLICATE_NAME );
		$fields = array (
						'col_name' => $roleName,
						'col_description' => $description 
		);
		
		$this->role->save ( $fields, $roleId );
		
		return Response::result ( ROLE_OP_SUCCESS );
	}
	function roleInfo($roleName, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		
		$roleId = $this->role->getRoleId ( $roleName );
		// 用户不存在
		if ($roleId == 0)
			return Response::result ( ROLE_NOT_EXIST );
		$this->role->addParamWhere ( "col_name", $roleName );
		$this->role->field = "col_id as roleid,col_name as rolename,col_description as description";
		$arrRoleInfo = $this->role->getDetail ();
		
		// 去重
		$arrRoleInfo = row_fliter_doublecolumn ( $arrRoleInfo, 1 );
		return Response::result ( ROLE_OP_SUCCESS, $arrRoleInfo );
	}
	function roleSetMember($roleName, $loginNames, $token) {
		// 检查token
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
			
			// 获取角色id
		$roleId = $this->role->getRoleId ( $roleName );
		
		// 部门不存在
		if ($roleId == 0)
			return Response::result ( ROLE_NOT_EXIST );
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
				$empRelation->setRelation ( $roleId, EMP_ROLE, $roleId, "", EMP_USER, $userId, 0 );
				$result [$i] ['code'] = ROLE_OP_SUCCESS;
			}
			
			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $loginName;
			
			$i ++;
		}
		return Response::result ( 0, $result );
	}
}

$serviceName = "AntRole";
require_once ('service.inc.php');