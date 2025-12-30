<?php
/**

 * 消息发送类

 * @date    20150519
//===========================================================================
// receiver
//===========================================================================
1)	jc@aipu.com;test@aipu.com
2)  Ant_View:1
3)  Ant_Group:1
4)  Ant_GroupDis:1
5)	Ant_Online


//===========================================================================
// content
//===========================================================================
1)	APPUPDATE
2)	EXITAPP


//===========================================================================
// msgtype
//===========================================================================
#define MSGTYPE_MSG (0)
#define MSGTYPE_MSEND (1) // 群发
#define MSGTYPE_CMD (2) // System command
#define MSGTYPE_AFFICHE (3) // 公告，antadmin上发的公告
#define MSGTYPE_TALK (4) // 消息类型为会议(MSGTYPE_MEET)
#define MSGTYPE_MAIL (5) // Mail
#define MSGTYPE_WEB (6) // Web
#define MSGTYPE_BOARD (7) // 客户端发公告，在view上右键，或组上右键，或多选用户右键
#define MSGTYPE_TEMP_TALK (8) //
 #define MSGTYPE_GROUPVIEW (9) // 消息类型
#define MSGTYPE_AUTO_REPLY (10) // 表示消息是系统的自动回复
#define MSGTYPE_GROUP_DIS (11) // 群聊消息
#define MSGTYPE_URLFILE (12) // 表示消息内容是一个URL的文件
#define MSGTYPE_P2PFILE (13) // P2P文件传输的消息
#define MSGTYPE_GROUP_DIS_OPT (14) // 固定群人员变更


//===========================================================================
// msgflag
//===========================================================================
#define MSGFLAG_SERVER_NOSAVE ( 1 ) // 服务端不保存消息
#define MSGFLAG_CLIENT_NOSAVE ( 2 ) // 客户端不保存消息
#define MSGFLAG_NOAUTO_IOPEN ( 4 ) // 客户端不自动设置IOpen
#define MSGFLAG_NOAUTO_IOPEN_QUITE ( 8 ) // 客户端彻底不设置IOpen
#define MSGFLAG_SEND_AT_ONCE ( 16 ) // 消息不进行通知，直接发送到客户端
#define MSGFLAG_FORCE_POPUPTIP ( 32 ) // 强制 Popup Tip , 不管消息有没有Download 过,都显示Tip
#define MSGFLAG_LOCAL_MSG ( 64 ) // 本地消息
#define MSGFLAG_NORECCHECK ( 128 ) // 没接收者时返回提示
#define MSGFLAG_FROM_WEBGUEST ( 256 ) // From Web guest
#define MSGFLAG_NO_OPENNTY ( 512 ) // 不进行打开通知
#define MSGFLAG_SENDONLY_ONLINE ( 1024 ) // 只发给在线用户
#define MSGFLAG_RESERTBUTTON ( 2048 ) // 重置Button
#define MSGFLAG_ATTITUDESET ( 4096 ) // 回复个人态度的
#define MSGFLAG_GETATTACHPATH_FROMADDIN ( 8192 ) // 由Addin指定附件存放的位置
#define MSGFLAG_SHOWON_READDLG ( 16384) // 在 ReadDlg 中显示,指定为消息模式
#define MSGFLAG_SHOW_ATONCE ( 32768) // 不先显示Tip,而是马上显示消息
#define MSGFLAG_SENDTO_WEB ( 65536) // 发送到web上去
#define MSGFLAG_CONFIRM ( 131072) // 本消息要进行签收,要输入密码才能打开
#define MSGFLAG_SHOWATTACH (262144) // 直接显示附件的内容,用作截图的
#define MSGFLAG_BCC (524288) // BCC
#define MSGFLAG_AUTOREPLY (1048576) // Auto reply
#define MSGFLAG_NOREPLACE_EMOTICONS (2097152) // 不把内容替换成表情符
#define MSGFLAG_MEETING_TOP_MSG (4194304) // 临时群置顶消息
#define MSGFLAG_SEND_AT_EXIT (8388608) // 接收消息，直接退出客户端
#define MSGFLAG_RECEIVERONLY_ONLINE (16777216) // 接收者只能在线用户（父节点为部门或单位才有效）
-------------------------------------------------------------------------------------
 */

class MsgSender
{
	private $msg;
	private $session;
	private $login;
	public $errCode;

	function __construct()
	{
		$this->msg = new COM ("AntCom.AntMsg" );
		$this->session = new COM ("AntCom.AntSyncSession" );
		$this->login = new COM ("AntCom.AntLoginInfo" );
 
	}



	function sendMessage($sendLoginName, $sendUserName, $passwordType, $sendPassword, $receivers, $msgType, $contentType, $subject, $content,$attachment){
		return $this->sendAntMessge($sendLoginName, $sendUserName, $passwordType, $sendPassword, 
							 $receivers, "", 
							 $contentType, $subject, $content,$attachment,
							 $msgType,0,"","");
	}

	//公告的msgFlag必须等于3不然会重复提醒
	function sendBoard($sendLoginName, $sendUserName, $passwordType, $sendPassword, $receivers, $subject, $content,$attachment){
		return $this->sendAntMessge($sendLoginName, $sendUserName, $passwordType, $sendPassword, 
							$receivers, "",
							"Text/Text", $subject, $content,$attachment,
							7, 3,"","");
	}
	

	/**
	 *
	 * method:用于通知形式的消息
	 * @param $msgFlag
	 * @param $msgType
	 * @param $talkId
	 * @param $recvLoginNames
	 * @param $recvUserNames
	 * @param $subject
	 * @param $content
	 * @param $sendUserName //虽然以系统帐号发送，但是显示别人的发送的
	 */
	function sendAntNotify($msgFlag,$msgType,$talkId,$recvLoginNames, $recvUserNames,$subject,$content,$sendUserName = "") 
	{
		return $this->sendAntMessge("", $sendUserName, 0, "", 
							$recvLoginNames, $recvUserNames,
							"Text/Text", $subject, $content,"",
							$msgType,$msgFlag,$talkId,"");
	}
	
	/**
	 *
	 * method:发送命令消息
	 * @param $msgFlag 0
	 * @param $msgType
	 * @param $recver
	 * @param $content
	 * @param $extData 扩展内容
	 */
	function sendCmd($msgFlag,$msgType,$recver,$content,$extData = "") 
	{
		return $this->sendAntMessge("", "", 0, "", 
							$recver, "",
							"Text/Text", "", $content,"",
							$msgType,$msgFlag,"",$extData);
	}
	
	/*
	method	发送退出命令
	*/
	function sendCmdByExit($recvLoginNames)
	{
		$msgFlag = 16 ;
		$msgType = 14 ;
		$content = "EXITAPP" ;
		return $this -> sendCmd($msgFlag,$msgType,$recvLoginNames,$content);
	}
	
	/*
	method	发送在线更新命令
	*/
	function sendCmdByUpdate()
	{
		$msgFlag = 1+2+512+1024+16 ;
		$msgType = 14 ;
		$recvLoginNames = "Ant_Online";
		$content = "APPUPDATE" ;
		return $this -> sendCmd($msgFlag,$msgType,$recvLoginNames,$content);
	}

	/**
	 *
	 * 发送消息
	 * @param string $sendLoginName
	 * @param string $sendUserName
	 * @param int $passwordType
	 * @param string $sendPassword
	 * @param string $recvLoginNames  不需要加入域名，函数里会自动加入
	 * @param string $recvUserNames			
	 * @param string $contentType  	Text/Text(文本格式) Text/Html(HTML格式)  Text/URL(网址格式)
	 * @param string $subject
	 * @param string $content
	 * @param string $attachment
	 * @param string $msgType		0消息 1群发 2系统命令 3公告 4会议
	 * @param string $msgFlag	0	
	 * @param string $talkId
	 * @param string $extData	扩展的功能
	 */
	function sendAntMessge($sendLoginName, $sendUserName, $passwordType, $sendPassword, 
			$recvLoginNames, $recvUserNames = "",
			$contentType, $subject, $content, $attachment = "",
			$msgType = 0,$msgFlag=0,$talkId = "",$extData = "") 
	{
		
		if ($sendLoginName == "")
		{
			$sendLoginName = "sysnotifier";
			$passwordType = 0 ;
			//$sendPassword = getAppValue("serverid") ;
			
			$db = new DB();
			$sendPassword = $db -> executeDataValue("select col_data as c from tab_config where col_name='serverid'");
		}
		
		//内容处理
		$recvLoginNames = str_replace(",",";",$recvLoginNames);
		$recvUserNames = str_replace(",",";",$recvUserNames);
		
		//如果不是特殊消息 
		$isSpecialMsg = strpos($recvLoginNames,"Ant_") !== false ; // 不存在=false
		if (! $isSpecialMsg)
			$recvLoginNames = userAppendDomain($recvLoginNames,";");
		
		//编码
		$subject = mb_convert_encoding($subject,"gb2312","utf-8"); 
		$content = mb_convert_encoding($content,"gb2312","utf-8");
		$sendLoginName = mb_convert_encoding($sendLoginName,"gb2312","utf-8"); 
		$sendUserName = mb_convert_encoding($sendUserName,"gb2312","utf-8");
		$recvLoginNames = mb_convert_encoding($recvLoginNames,"gb2312","utf-8");
		$extData = mb_convert_encoding($extData,"gb2312","utf-8");
		
		//参数设置
		$this->msg->Subject = $subject;
		$this->msg->MsgType = $msgType;
		$this->msg->MsgFlag = $msgFlag;
		$this->msg->ContentType = $contentType;
		$this->msg->TalkID = $talkId;
		$this->msg->SetProp("extdata",$extData);
		$this->msg->Content = $content;
		$this->msg->AddReceiver ( $recvLoginNames , $recvUserNames );
		if ($attachment != "")
			$this->msg->AddAttach($attachment, "");
			
		$this->login->Server = RTC_SERVER;
		$this->login->ServerPort = RTC_PORT;
		$this->login->LoginName = $sendLoginName;
		$this->login->UserName = $sendUserName;
		$this->login->PasswordType = $passwordType;  // 0明码 1 MD5
		$this->login->Password = $sendPassword;

		$this->session->Login ( $this->login );
		$result = $this->session->SendMsg ( $this->msg, 0);

		
		recordLog("Server:" . RTC_SERVER . ":" . RTC_PORT);
		recordLog("SendAccount:" . $sendLoginName  );
		recordLog("SendPassword:" . $sendPassword  );
		recordLog("RecvAccount:" . $recvLoginNames  );
		recordLog("RecvUserName:" . $recvUserNames  );
		recordLog("TalkID:" . $talkId  );
		recordLog("MsgType:" . $msgType  );
		recordLog("MsgFlag:" . $msgFlag  );
		recordLog("Content:" . $this->msg->Content);
		recordLog($result);
		

		
		switch ($result){
			case 1:
				return MSG_OP_SUCCESS;
			case 0:
				return MSG_NET_ERROR;
			default:
				return MSG_ACCOUNT_ERROR;
		}
	}
	
	function getTalkId($viewId)
	{
		// domain_viewid_viewid
		$talkId = str_replace("@","",RTC_DOMAIN) . "_" . $viewId . "_" . $viewId ; 
		return $talkId ;
	}
}


 
?>