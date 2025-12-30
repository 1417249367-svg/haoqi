<?php
require_once ("../class/fun.php");
require_once ("../class/hs/User.class.php");
require_once ("../class/hs/Passport.class.php");

$op = strtolower ( g ( "op" ) );

switch ($op) {
	case "getdata" :
		get_data ();
		break;
	default :
		break;
}
function get_data() {
	$printer = new Printer ( "xml" );
	$loginName = removeDomain ( g ( "loginname" ) );
	$client = strtolower ( g ( "client", "" ) );
	$user = new User ();
	$userId = $user->getUserId ( $loginName );
	if ($userId > 0) {
		$sql = "";
		$arr_role = $user->listRole ( $userId );
		$arr_role = table_fliter_doublecolumn ( $arr_role );
		if (count ( $arr_role ) > 1) {
			$roleId = "";
			foreach ( $arr_role as $key => $row ) {
				if ($key == 0)
					$roleId = $row [0];
				$roleId = $roleId . "," . $row [0];
			}
			$sql = " or col_id in(select col_hsitemid from hs_biiace where col_hsitemtype=11 and col_dhsitemtype=3 and col_dhsitemid in(" . $roleId . "))";
		}
		$sql = " select col_id as id,col_name as name,col_url as url from ant_interface where col_disabled=0 and (col_ispublic=1  " . $sql . ")";

		// 判断终端类型
		if ($client == "ios")
			$sql = $sql . " and col_type in (0,3)";
		elseif ($client == "android")
			$sql = $sql . " and col_type in (0,2)";
		else
			$sql = $sql . " and col_type in (0,1)";
		$sql = $sql . " order by col_index asc";

		$db = new DB ();
		$result = $db->executeDataTable ( $sql );
		$result = table_fliter_doublecolumn ( $result, 1 );
		$res ['recordcount'] = count ( $result );
		$res ['rows'] = $result;
		$printer->out_array2 ( $res, 0 );
	} else {
		$result = array (
						'status' => 0,
						'errnum' => 1,
						'msg' => '用户不存在'
		);
		$printer->out_array2 ( $result, 0 );
	}
}