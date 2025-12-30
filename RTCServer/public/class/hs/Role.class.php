<?php
/**
 * 角色管理

 * @date    20140510
 */
class Role extends Model {

	public $relation;
	function __construct() {
		$this->tableName = "Role";
		$this->db = new DB ();
		$this->relation = new EmpRelation ();
	}
	function deleteAnRole($roleId) {
		$sqls = array (
				"delete from Role where ID=" . $roleId,
				"delete from Users_Role where RoleID=" . $roleId,
		);
		$result = $this->db->execute ( $sqls );
		return $result;
	}
	function setMember($roleId, $userIds, $flag) {
		$relation = new EmpRelation ();
		$relation->setRelation ( 0, EMP_ROLE, $roleId, "", EMP_USER, $userIds, $flag );
	}
	function listMember($roleId) {
		$relation = new EmpRelation ();
		return $relation->getRelationData ( EMP_ROLE, $roleId, EMP_USER );
	}
	function setOrgAce($roleId, $orgIds, $flag) {
		$sql = "";

		if ($flag == 1) {
			$sql = " delete from hs_BIIAce where col_hsitemtype=3 and col_hsitemid=" . $roleId . "  and Col_FunName='ViewAce' ";
			$this->db->execute ( $sql );
		}

		if ($orgIds == "")
			return;

        $arr_id = explode(",",$orgIds);
        foreach($arr_id as $id)
        {
			$item = explode("_",$id); // emptype_empid
            $sql = " insert into hs_BIIAce(col_hsitemtype,col_hsitemid,col_dhsitemtype,col_dhsitemid,col_power,col_funname,col_fungenre) " .
                " values(" . EMP_ROLE . "," . $roleId . "," . $item[0] . "," . $item[1] . ",1,'ViewAce','RTCAce')";
            $this -> db -> execute($sql);
        }
    }

	// / <summary>
	// / 列出某人能访问的视图
	// / </summary>
	// / <param name="userId"></param>
	// / <returns></returns>
	function listOrgAce() {
//        $sql = "select col_dhsitemid from hs_BIIAce where col_hsitemtype=" . EMP_ROLE .  " and col_hsitemid in(" . $roleId . ")  and col_funname='ViewAce' ";
//        $sql = " select col_id,col_name,4 as emptype from hs_view where col_id in(" . $sql . " and col_dhsitemtype=4)" .
//            " union " .
//            " select col_id,col_name,2 as emptype from hs_group where col_id in(" . $sql . " and col_dhsitemtype=2)";
          $sql = "select * from Role";
        return $this -> db -> executeDataTable($sql);
    }

	// / <summary>
	// /
	// / </summary>
	// / <param name="roleId"></param>
	// / <param name="orgIds">viewId_empType_empId,viewId_empType_empId</param>
	function setFunACE($roleId, $power, $attachSize, $mSends) {
		$arr_sql = array ();
		$arr_sql [0] = " delete from hs_ItemAce where col_hsitemtype=3 and col_hsitemid=" . $roleId . " and Col_FunGenre='RTCAce' ";
		$arr_sql [1] = " insert into hs_ItemAce(col_hsitemtype,col_hsitemid,Col_FunName,Col_FunGenre,Col_Power)  values(" . EMP_ROLE . "," . $roleId . ",'BaseAce','RTCAce'," . $power . ") ";
		$arr_sql [2] = " insert into hs_ItemAce(col_hsitemtype,col_hsitemid,Col_FunName,Col_FunGenre,Col_Power)  values(" . EMP_ROLE . "," . $roleId . ",'AttachSize','RTCAce'," . $attachSize . ") ";
		$arr_sql [3] = " insert into hs_ItemAce(col_hsitemtype,col_hsitemid,Col_FunName,Col_FunGenre,Col_Power)  values(" . EMP_ROLE . "," . $roleId . ",'MSends','RTCAce'," . $mSends . ") ";
		$this->db->execute ( $arr_sql );
		return true;
	}
	function listFunACE($roleId) {
		if ($roleId == "")
			return array ();

		$sql = "select * from Role where ID=" . $roleId;

		return $this->db->executeDataTable ( $sql );
	}
	function getFunAce($data) {
		$baseace = 0;
		$attachsize = 0;
		$attachsends = 0;
		foreach ( $data as $row ) {
			$funName = strtolower ( $row ["col_funname"] );
			$power = $row ["col_power"];

			if ($funName == "baseace")
				$baseace += $power;

			if ($funName == "attachsize")
				$attachsize = $power;

			if ($funName == "msends")
				$attachsends = $power;
		}

		return array (
				"baseace" => $baseace,
				"attachsize" => $attachsize,
				"attachsends" => $attachsends
		);
	}

	function save($fields, $roleId = "") {
		$this->clearParam();
		$this->addParamFields ( $fields );

		// 用户存在则更新
		if ($roleId != "") {
			$this->addParamWhere ( "col_id", $roleId , "=", "int" );
			return $this->update ();
		}
		$this->insert ();
		return $this->getMaxId ();
	}

	/*
	 * 获取角色id
	 */
	function getRoleId($roleName, $roleId = "") {

		$this->clearParam();
		$this->addParamWhere ( "col_name", $roleName );

		// 修改时判断是否重名
		if ($roleId != "")
			$this->addParamWhere ( "col_id", $roleId, "<>", "int" );
		$roleId = $this->getValue ( "col_id" );
		if ($roleId != "")
			return $roleId;
		return 0;
	}
}

?>