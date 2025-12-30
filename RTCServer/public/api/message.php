<?php
/**
 * message.php
 * @author  zwz
 * @date    2014 上午9:07:19
 */
require_once ("fun.php");
require_once (__ROOT__ . "/class/im/MsgSender.class.php");
require_once (__ROOT__ . "/class/im/MsgReader.class.php");
require_once (__ROOT__ . "/class/hs/Group.class.php");

class RTCMessage 
{

	function RTCMessage() {
		
	}
	
	/*
	method	发送退出命令
	param	$receivers 以分号分隔，支持带或不带域名
	*/
	function sendNotify($recvUserNames,$title, $content,$link,$token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		
		$msg = new Msg ();
		$result = $msg ->sendRTCMessge('admin',$recvUserNames,$title, $content,$link,3);

		return Response::result ($result);
	}
	
	/*
	method	发送退出命令
	param	$receivers 以分号分隔，支持带或不带域名
	*/
	function sendCmdByExit($recvLoginNames,$token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$msgFlag = 16 ;
		$msgType = 14 ;
		$msgSender = new MsgSender ();
		$result = $msgSender -> sendAntNotify($msgFlag,$msgType,"",$recvLoginNames,"","","EXITAPP","") ;

		return Response::result ($result);
	}
	
	/*
	method	发送消息全部参数
	param	$receivers 以分号分隔，支持带或不带域名
	*/
	function sendMessageByAll($sendLoginName, $sendUserName, $passWordType, $sendPassWord, 
				$recvLoginNames, $recvUserNames,
				$contentType, $subject, $content, $attachMent, 
				$msgType = 0,$msgFlag=0,$talkId = "",$extData = "",
				$token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$msgSender = new MsgSender ();
		$result = $msgSender -> sendAntMessge($sendLoginName, $sendUserName, $passWordType, $sendPassWord, 
											$recvLoginNames, $recvUserNames, 
											$contentType, $subject, $content, $attachMent,
											$msgType,$msgFlag,$talkId,$extData);

		return Response::result ($result);
	}


	/*
	method	发送消息(根据接者者)
	param	$receivers 以分号分隔，支持带或不带域名
	*/
	function sendMessage($sendUserName, $recvUserNames, $content, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$msg = new Msg ();
		$result = $msg ->sendRTCMessge($sendUserName,$recvUserNames,"", $content,"",0);
		return Response::result ($result);
	}


	/*
	method	发送消息(根据部门)
	param	$path 触点软件/技术中心
	*/
	function sendMessageByPath($sendUserName, $path, $content, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$receivers = "";

		if ($path != "") {
			$dept = new Department ();
			$arrDept = $dept->getIdByPath ( $path,false );

			if (!$arrDept ['empid'])
				return Response::result ( DEPT_NOT_EXIST );

			$recvUserNames = $dept->getSubIds ( $arrDept ['emptype'], $arrDept ['empid'], 1, false );
		}

		$msg = new Msg ();
		$result = $msg ->sendRTCMessge($sendUserName,$recvUserNames,"", $content,"",0);
		
		return Response::result ( $result  );
	}


	/*
	method	发送消息(根据群组)
	param	$groupId
	*/
	function sendMessageByGroup($sendUserName, $groupId, $content, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
			
			
 		//--群组有效验证-------------------------------------------------
		$group = new Group();
		$user = new User();
		//判断群组是否存在
		$result = $group -> isGroupId($groupId) ;
		if (! $result)
			return Response::result(GROUP_NOT_EXIST);
			
		$userId = $user->getUserId ( $sendUserName );
		//判断是否是群组成员
		$result = $group -> isGroupMemberByLoginName($result,$userId) ;
		if (! $result)
			return Response::result(GROUP_USER_NOT_EXIST);
			
		$msg = new Msg ();
		$result = $msg ->sendRTCMessge($sendUserName,$groupId,"", $content,"",1);
		
		return Response::result ($result);
	}


	/*
	method	发送公告
	param	$groupId
	*/
	function sendBoard($sendLoginName, $sendUserName, $passWordType, $sendPassWord, $receivers, $subject, $content, $attachMent, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
			
		$msgSender = new MsgSender ();
		$result = $msgSender -> sendBoard ( $sendLoginName, $sendUserName, $passWordType, $sendPassWord, $receivers, $subject, $content, $attachMent );
		
		return Response::result ($result);
	}


	/*
	method	列出消息
	return	
	*/
	function msgList($sendLoginName, $receiveLoginName, $fromDate, $toDate, $pageIndex, $pageSize, $token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$recordCount = 0;
		$db = new DB ();

		$msg = new Msg ();
		$sql_where = $msg->getWhereSql ( $sendLoginName, $receiveLoginName, $fromDate, $toDate, "" );

		$sql_count = "select  count(*) as c  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where;
		$sql_list = "select  A.col_id,col_subject,col_sender,col_sendername," . ($db->getSelectDateField ( "A.col_senddate" )) . ",col_datapath  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where . " order by A.col_senddate ";
		$recordCount = $msg->db->executeDataValue ( $sql_count );
		if ($recordCount > 0) {
			if ($pageIndex == - 1)
				$pageIndex = get_page_count ( $recordCount, $pageSize );
			$data = $msg->db->page ( $sql_list, $pageIndex, $pageSize );
			$data = table_fliter_doublecolumn ( $data, 1 );
		} else {
			$pageIndex = 0;
			$data = array ();
		}
		return Response::result ( MSG_OP_SUCCESS, $data );
	}


	/*
	method	获取消息内容
	return msgtype,msgtitle,sender,sendername,receiver,talkid,msgcontent
	*/
	function getMsgContent($msgId,$token) 
	{
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );
		$m = new Model("ant_msg");
		$m->addParamWhere("col_id", $msgId);
		$arr = $m->getDetail();

		if(count($arr)==0)
		{
		    return Response::result ( MSG_NOT_EXIST );
		}

		$reader = new MsgReader ();
		$reader->msgTitle = $arr['col_subject'];
		$reader->read ( $msgId,  $arr['col_datapath']);

		$data ['msgtype'] = $reader->msgType;
		$data ['msgtitle'] = $reader->msgTitle;
		$data ['sender'] = $arr['col_sender'];
		$data ['sendername'] = $arr['col_sendername'];

		$m->tableName = "ant_msg_rece";
		$m->fldId = "col_msgid";
		$m->clearParam();
		$m->addParamWhere("col_msgid", $msgId);
		$receiver = $m->getField("col_receiver");
		$data ['receiver'] = $receiver;
        $data ['talkid'] = $arr['col_talkid'];
        $data ['msgcontent'] = $reader->html;
        if(strtoupper(RESULT_TYPE) == "XML")
        {
		  $data ['msgcontent'] = "<![CDATA[" . $reader->html . "]]>";
        }
		return Response::result ( MSG_OP_SUCCESS, $data );
	}
	
	/*
	method	判断用户是否在线
	param	$loginNames 多个帐号以逗号分隔,不用含域名
	*/
	function getUserOnlineStatus($loginNames, $token) {
		if (! authenticate ( $token ))
			return Response::result ( SYS_ERROR_TOKEN );

		$loginNames = mb_convert_encoding(userAppendDomain( $loginNames,","),"gb2312","utf-8");
		$url = "http://" . RTC_SERVER . ":" . RTC_PORT . "/syscmd?cmdname=GetJsUserState&LoginNames=" . $loginNames ;
		$result = send_http_request($url) ;
		
		recordLog("getUserOnlineStatus:" . $url) ;
		
		//判断是否获取到正确的内容
		$isSuccess = strpos("var UserList=",$result) == 0?1:0 ;
		
		$msg = "" ;
		if ($isSuccess)
		{
			$result = str_replace("var UserList=","",$result);
			$data = json_decode($result,true);
			foreach($data as $item)
				$msg .= ($msg == ""?"":",") . $item["Online"] ;
		}
		
	
		return Response::result ($isSuccess,$msg);
	}
}


$serviceName = "RTCMessage";
require_once ('service.inc.php');