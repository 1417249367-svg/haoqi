<?php
/**
 * user.php
 * @author  zwz
 * @date    2014 上午9:07:11
 */
require_once('fun.php');
require_once (__ROOT__ . "/class/common/PinYin.class.php");
class RTCChater {

	private $user;

	function RTCChater() {
		$this->user = new User();
	}

	// 增加用户
	function chaterAdd($loginname, $username, $deptname, $jobtitle, $phone, $mobile, $email, $reception, $welcome, $status, $ord, $token) {
		recordLog("1");
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$userId = $this->user->getUserId ( $loginname );
		recordLog("2");
		
		
		// 用户已经存在
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST);
			
		$userId = $this->user->getChaterId ( $loginname );
		// 用户已经存在
		if ($userId > 0)
			return Response::result ( USER_IS_EXIST, array (
					'userid' => $userId
			) );
		$fields = array (
		        'userid' => getAutoId(),
				'loginname' => $loginname,
				'username' => $username,
				'deptname' => $deptname,
				'jobtitle' => $jobtitle,
				'phone' => $phone,
				'mobile' => $mobile,
				'email' => $email,
				'reception' => $reception,
				'welcome' => $welcome,
				'status' => $status,
				'ord' => $ord
		);
//		echo var_dump($fields);
//		exit();
		$this->user->tableName = "lv_chater";
		$userId = $this->user->clearParam();
		$userId = $this->user->addParamFields($fields);
		$userId = $this->user->insert();
		recordLog("3");
		return Response::result ( USER_OP_SUCCESS);
	}

	// 删除用户
	function chaterDelete($loginnames, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$arrUser = explode ( ",", $loginnames );

		$i = 0;
		foreach ( $arrUser as $loginname ) {
			$userId = $this->user->getChaterId ( $loginname );

			// 用户不存在
			if ($userId == 0) {
				$result [$i] ['code'] = USER_NOT_EXIST;
			} else {
				$sql = "delete from lv_chater where UserId=" . $userId;
				$result [$i] ['code'] = $this->user->db->execute ( $sql ) > 0 ? USER_OP_SUCCESS : SYS_ERROR_UNDEFINED;
			}

			$result [$i] ['userid'] = $userId;
			$result [$i] ['loginname'] = $loginname;
			$i ++;
		}
		return Response::result ( 0, $result );
	}

	// 用户更新
	function chaterUpdate($loginname, $username, $deptname, $jobtitle, $phone, $mobile, $email, $reception, $welcome, $status, $ord, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
        
		$this->user->tableName = "lv_chater";
		$this->user->clearParam();
		$this->user->addParamWhere("loginname", $loginname);
		$count = $this->user->getCount();

		// 用户不存在
		if ($count == 0)
			return Response::result ( USER_NOT_EXIST );

		$py = new PinYin ();

		//检查重名
		$this->user->clearParam();
		if($username) $this->user->addParamField("username",$username);
		if($deptname) $this->user->addParamField("deptname",$deptname);
		if($jobtitle) $this->user->addParamField("jobtitle",$jobtitle);
		if($phone) $this->user->addParamField("phone",$phone);
		if($mobile) $this->user->addParamField("mobile",$mobile);
		if($email) $this->user->addParamField("email",$email);
		if($reception) $this->user->addParamField("reception",$reception);
		if($welcome) $this->user->addParamField("welcome",$welcome);
		if($status) $this->user->addParamField("status",$status);
		if($ord) $this->user->addParamField("ord",$ord);
		$this->user->addParamWhere("loginname", $loginname);
		$this->user->update();
		return Response::result ( USER_OP_SUCCESS );
	}

	// 获取用户信息
	function chaterInfo($loginname, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$userId = $this->user->getChaterId ( $loginname );
		// 用户不存在
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		$this->user->tableName = "lv_chater";
		$this->user->addParamWhere ( "loginname", $loginname );
		$this->user->field = "*";
		$arrUserInfo = $this->user->getDetail ();

		// 去重
		//$arrUserInfo = row_fliter_doublecolumn ( $arrUserInfo, 1 );
		return Response::result ( USER_OP_SUCCESS, $arrUserInfo );
	}

	//禁用启用帐号
	function disableChater($loginname,$status,$token)
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$userId = $this->user->getChaterId ( $loginname );
		if ($userId == 0)
			return Response::result ( USER_NOT_EXIST );
		$this->user->tableName = "lv_chater";
		$this->user->clearParam();
		$this->user->addParamWhere("UserId", $userId);
		if($status == 0)
			$this->user->addParamField("Status",0,"int");
		else
			$this->user->addParamField("Status",1,"int");
		$this->user->update();
		return Response::result ( USER_OP_SUCCESS );
	}

}
//$serviceName="RTCChater";
//require_once ("service.inc.php");
?>