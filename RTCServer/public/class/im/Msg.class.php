<?php
/**
 * 消息管理类

 * @date    20140325
 */

class Msg extends Model
{
	private $msg;
	private $session;
	private $login;
	public $errCode;

	function __construct()
	{
//		$this->msg = new COM ("AntCom.AntMsg" );
//		$this->session = new COM ("AntCom.AntSyncSession" );
//		$this->login = new COM ("AntCom.AntLoginInfo" );

		$this -> tableName = "Ant_Msg" ;
		$this -> NoticeFontInfo = "宋体,10,0,False,False,False";
		$this -> db = new DB();
	}



	//删除消息
	function deleteAn($msgId)
	{
		$sqls = array(
			" delete from ant_Msg where col_id='" . $msgId . "'",
			" delete from ant_Msg_Rece where col_msgid='" . $msgId . "'",
			" delete from ant_Msg_AttachMent where col_msgid='" . $msgId . "'"
		) ;

		$result = $this -> db -> execute($sqls) ;

		return $result ;
	}


	//得到查询
	function getWhereSql($sender,$recver, $dt1 = "", $dt2 = "", $key = "")
	{
        $this -> where = "";
        if ($sender != "")
        	$this  -> addWhere("  (MyID='" . $sender . "' or YouID='" . $sender . "') ");
		if($recver != "")
			$this  -> addWhere("  (MyID='" . $recver . "' or YouID='" . $recver . "') ");
		if($dt1 !="")
			$this  -> addParamWhere("To_Date",$dt1,">=","date") ;
		if($dt2 != "")
			$this  -> addParamWhere("To_Date",$dt2,"<=","date") ;

        if ($key != "")
            $this  -> addWhere( "UserText like '%" . $key . "%'");

        //$this -> addWhere("A.Col_Id=B.Col_MsgId");
		$sql = $this -> where ;
		$this -> where = "";

        return $sql;
	}
	
	function getWhereSql1($ClotID, $dt1 = "", $dt2 = "", $key = "")
	{
        $this -> where = "";
        if ($ClotID != "")
        	$this  -> addWhere("  (ClotID='" . $ClotID . "') ");
		if($dt1 !="")
			$this  -> addParamWhere("To_Date",$dt1,">=","date") ;
		if($dt2 != "")
			$this  -> addParamWhere("To_Date",$dt2,"<=","date") ;

        if ($key != "")
            $this  -> addWhere( "UserText like '%" . $key . "%'");

        //$this -> addWhere("A.Col_Id=B.Col_MsgId");
		$sql = $this -> where ;
		$this -> where = "";

        return $sql;
	}


	function sendMessage($sendLoginName, $sendUserName, $passWordType, $sendPassWord, $receivers, $msgType, $contentType, $subject, $content,$attachMent){
		$this->sendRTCMessge($sendLoginName, $sendUserName, $passWordType, $sendPassWord, 
							 $receivers,  
							 $contentType, $subject, $content,$attachMent,
							 $msgType,0,"");
	}
	
	function sendKfMessage($sendUserName, $receivers, $content, $msgType){
//		if($msgType){
//			$dbForm = new Model("lv_chater_Clot_Form");
//			$sql = "select * from lv_chater_Clot_Form where TypeID =".$receivers." and IsAdmin=0 and UserID<>'".CurUser::getLoginName()."'";
//			$data_user = $this -> db -> executeDataTable($sql) ;
//			foreach($data_user as $k=>$v){
//				$result .= ($result == ""?"":",") . $data_user[$k]['userid'];
//			}
//		}else $result = $receivers;
		if($msgType) $toType = 5;
		else $toType = 4;
		$this->sendRTCMessge($sendUserName,$receivers,"", $content,"",$toType);
	}

	//公告的msgFlag必须等于3不然会重复提醒
	function sendBoard($sendUserName, $receivers, $subject, $content,$attachMent){
		$this->sendRTCMessge($sendUserName,$receivers,$subject, $content,$attachMent,3);
	}
	
	//用于通知形式的消息
	function sendAntNotify($msgFlag,$msgType,$talkId,$recvLoginNames, $recvUserNames,$subject,$content) 
	{
		$sendLoginName = RTC_SEND_ACCOUNT;
		$sendUserName = "";
		$passWordType = 0 ;
		$sendPassWord = RTC_SEND_PASSWORD ;
		$this->sendRTCMessge($sendLoginName, $sendUserName, $passWordType, $sendPassWord, 
							$recvLoginNames, $recvUserNames,
							"Text/Text", $subject, $content,"",
							$msgType,$msgFlag,$talkId);
	}

	/**
	 *
	 * 发送消息
	 * @param string $sendLoginName
	 * @param string $sendUserName
	 * @param int $passWordType
	 * @param string $sendPassWord
	 * @param string $receivers  不需要加入域名，函数里会自动加入
	 * @param int $msgType
	 * @param string $contentType
	 * @param string $subject
	 * @param string $content
	 * @param string $attachMent

	 * @author zwz
	 * @date 2014-10-8上午9:48:23
	 * @version v1.0.0
	 */
	function sendRTCMessge($sendUserName, $recvUserNames = "",$subject, $content, $attachMent = "",$msgType) 
	{
//		$Msg = new COM("RTCCom.Message");
//		//消息发送者的 UserName
//		$Msg->MyUserName = urlencode($sendUserName);
//		//消息接收者的帐号，多个用逗号分隔，当消息类型为0、2、3启用
//		$Msg->YouUserNames = urlencode($recvUserNames);
//		//消息接收者的群组名称，多个用逗号分隔，当消息类型为1启用
//		//$YouUserNames = "财务群,技术讨论群";
//		//消息的标题，当消息类型为2、3启用
//		$Msg->ntitle = urlencode($subject);
//		//消息的内容
//		$Msg->ncontent = urlencode($content);
//		//消息的链接地址，当消息类型为3启用
//		$Msg->nlink = urlencode($attachMent);
//		//消息类型  0消息 1群组消息 2公告 3通知
//		$MsgType = $msgType;
//		$Msg->Login(RTC_SERVER,6004);
//		$Msg->SendMessage($MsgType);
		
		//创建一个socket套接流
		$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
		/****************设置socket连接选项，这两个步骤你可以省略*************/
		 //接收套接流的最大超时时间1秒，后面是微秒单位超时时间，设置为零，表示不管它
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
		 //发送套接流的最大超时时间为6秒
		socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 6, "usec" => 0));
		/****************设置socket连接选项，这两个步骤你可以省略*************/
	
		//连接服务端的套接流，这一步就是使客户端与服务器端的套接流建立联系
		if(socket_connect($socket,"127.0.0.1",6004) == false){
			echo 'connect fail massege:'.socket_strerror(socket_last_error());
			$result = 0;
		}else{
			$message = ".+interface_information|" .$sendUserName. "|" .$recvUserNames. "|" .$subject. "|" .$content. "|" .$attachMent. "|" .$msgType. "|#";
			//转为GBK编码，处理乱码问题，这要看你的编码情况而定，每个人的编码都不同
			$message = base64_encode(mb_convert_encoding($message,'GBK','UTF-8'));
			//向服务端写入字符串信息
	
			if(socket_write($socket,$message,strlen($message)) == false){
				echo 'fail to write'.socket_strerror(socket_last_error());
				$result = 0;
			}else{
				echo 'client write success'.PHP_EOL;
				//读取服务端返回来的套接流信息
				while($callback = socket_read($socket,1024)){
					echo 'server return message is:'.PHP_EOL.$callback;
					$result = 1;
				}
			}
		}
		socket_close($socket);//工作完毕，关闭套接
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
	

	
	//从talkId中提取出群ID
	function get_group_id($talkId)
	{
		$talkId = trim($talkId);
		if($talkId == "")
			return "";
		$arr = explode("_", $talkId);
		if(count($arr) == 2)
			return $arr[1];
		return "";
	}
		
	function list_messeng($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($point==0) $where = " and TypeID not in(Select TypeID from Messeng_Text where YouID='".CurUser::getUserId()."' and IsAck3=1 and IsAck4=1 and To_Type=5)";
		$where = stripslashes(" where (MyID='".CurUser::getUserId()."' and IsAck".$ack_id1."=1) or (YouID='".CurUser::getUserId()."' and IsAck".$ack_id2."=1".$where.")");
		
		//$where = stripslashes(" where (MyID='".CurUser::getUserId()."' and IsAck".$ack_id1."=1) or (YouID='".CurUser::getUserId()."' and IsAck".$ack_id2."=1 and TypeID not in(Select TypeID from Messeng_Text where YouID='".CurUser::getUserId()."' and IsAck3=1 and IsAck4=1 and To_Type=5))");
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
//		foreach($data as $k=>$v){
//			if($data[$k]['MyID']==CurUser::getUserId()||$data[$k]['IsReceipt'.$ack_id1]==1){
//				$arr_sql[] = "update Messeng_Text set IsReceipt".$ack_id1."=2 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
//			} ;
//		}
//		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}

	function list_messeng_acks($point,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (MyID='".CurUser::getUserId()."' and IsReceipt".$ack_id1."=1)");
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$arr_sql[] = "update Messeng_Text set IsReceipt".$ack_id1."=2 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_messengclot($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($point==0) $ack_id3 = 2;
		else $ack_id3 = 1;
		if($point==0) $ack_id4 = 4;
		else $ack_id4 = 3;
		
		$data_user = array();
		$sql = "Select * from Clot_Form where UserID='".CurUser::getUserId()."'";
		$data_user = $this -> db -> executeDataTable($sql);
		if (count($data_user)==0) return array("data"=>$data,"count"=>0);
		$sql="";
		foreach($data_user as $k=>$v){
			$sql.=($sql==""?"":" or ")."(ClotID='".$data_user[$k]['upperid']."' and ((MyID='".CurUser::getUserId()."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id1].") or (MyID<>'".CurUser::getUserId()."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id2].")))" ;
		}
		
		$where = stripslashes(" where ".$sql);
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );

		foreach($data as $k=>$v){
			foreach($data_user as $m=>$n){
				if($data_user[$m]['upperid'] == $data[$k]['clotid']){
					 if($data[$k]['myid']==CurUser::getUserId()) $data[$k]['isread']=(int)$data[$k]['typeid']>(int)$data_user[$m]['last_ack_typeid'.$ack_id3]?1:0 ;
					 else $data[$k]['isread']=(int)$data[$k]['typeid']>(int)$data_user[$m]['last_ack_typeid'.$ack_id4]?1:0 ;
				}
			}
		}
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}

	function list_messengclot_acks($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (MyID='".CurUser::getUserId()."' and IsReceipt".$ack_id1."=1)");
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$arr_sql[] = "update Msg_Acks set IsReceipt".$ack_id1."=2 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
		$arr_sql[] = "delete from Msg_Acks where IsReceipt1=2 and IsReceipt2=2" ;
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_leavefile($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
//		if($point==0) $sql = "bb.*";
//		else $sql = "aa.*";
		$sql = "Select bb.* from Messeng_Text as aa,LeaveFile as bb where (aa.YouID='".CurUser::getUserId()."' and aa.IsAck3=1 and aa.IsAck4=1) and aa.To_Type=5 and aa.Msg_ID=bb.Msg_ID";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_kefumesseng1($point,$myid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (MyID='".$myid."' and IsAck".$ack_id1."=1) or (YouID='".$myid."' and IsAck".$ack_id2."=1)");
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$sql = "";
			if($data[$k]['myid']==$myid) $ack_id = $point+1;
			else{
				 $ack_id = $point+3;
				 if($data[$k]['to_type']=="1") $sql = "IsReceipt1=1,IsReceipt2=1,";
				 //$row = $livechat->GetChaterDetail ($data[$k]['myid']);
//				 $data[$k]['avatar']=$row['picture'];
			}
			$arr_sql[] = "update MessengKefu_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
//			echo var_dump($arr_sql);
//			exit();
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_kefumesseng2($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		Global $printer;
		$db = new Model("lv_user");
		$detail = array();
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		
		$sql = "Select min(TypeID) as m,MyID from MessengKefu_Text where (YouID='".CurUser::getLoginName()."' and IsAck".$ack_id2."=1) group by MyID order by m asc";
		$data_user = $this -> db -> executeDataTable($sql);
		
		$sql="";
		foreach($data_user as $k=>$v){
			$db -> clearParam();
			$db -> addParamWhere("userid",$data_user[$k]['myid']);
			$detail =  $db -> getDetail() ;
			
			$sql_count = "select count(*) as c from lv_source where UserId='".$data_user[$k]['myid']."'";
			$visitcount = $this -> db -> executeDataValue($sql_count);
			
			$data_user[$k]['usericoline']=$detail ["usericoline"];
			$data_user[$k]['status']=$detail ["status"];
			$data_user[$k]['visitcount']=$visitcount;
			$data_user[$k]['isweixin']=$detail ["isweixin"];
			$data_user[$k]['headimgurl']=$detail ["headimgurl"];
			if(empty($detail ["username"])) $data_user[$k]['username']=$detail ["area"];
			else $data_user[$k]['username']=$detail ["username"];
			if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
			
			$sql_form = "select * from lv_user_form where UserId='" . $data_user[$k]['myid'] . "' and To_Type=3 and MyID='".CurUser::getUserId()."'";
			$data1 = $this -> db -> executeDataTable($sql_form) ;
//			echo parseList ( $data1, 0 );
//			exit();
			$data_user[$k]['user_form']=$printer->parseList ( $data1, 0 );
			
			$sql.=($sql==""?"":" or ")."((MyID='".$data_user[$k]['myid']."' or YouID='".$data_user[$k]['myid']."') and TypeID>=".$data_user[$k]['m'].")" ;
		}
		
		$where = stripslashes(" where ".$sql);

		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$sql = "";
			//echo $data[$k]['myid']."|".$data[$k]['youid']."|".CurUser::getLoginName();
			if(strtolower($data[$k]['myid'])==strtolower(CurUser::getLoginName())) $ack_id = $point+1;
			else{
				 if(strtolower($data[$k]['youid'])==strtolower(CurUser::getLoginName())){
					$ack_id = $point+3;
				    if($data[$k]['to_type']=="1") $sql = "IsReceipt1=1,IsReceipt2=1,";
				 }
			}
			$arr_sql[] = "update MessengKefu_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
					//echo var_dump($arr_sql);
			//exit();
		$msg_db->db->execute($arr_sql);
		return array("data_user"=>$data_user,"data"=>$data,"count"=>$count);
	}
	
	function list_kefumesseng3($point,$myid,$youid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (YouID='".$youid."' and IsAck".$ack_id1."=1) or (MyID='".$youid."' and IsAck".$ack_id2."=1)");
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$sql = "";
			if($data[$k]['myid']==$myid) $ack_id = $point+1;
			else{
				 $ack_id = $point+3;
				 if($data[$k]['to_type']=="1") $sql = "IsReceipt1=1,IsReceipt2=1,";
			}
			$arr_sql[] = "update MessengKefu_Text set ".$sql."IsAck".$ack_id."=0 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
//			echo var_dump($arr_sql);
//			exit();
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_kefumesseng4($point,$chatId,$myid,$youid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (YouID='".$myid."' and ChatId='".$chatId."' and IsAck".$ack_id2."=1)");
	
	    $msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$msg_db->order ( $fldSortdesc );
		//$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		$data = $msg_db->getTop(1);

		//$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>1);
	}

	function list_kefumesseng5($point,$chatId,$myid,$youid,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{	
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where ChatId='".$chatId."'");
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_kefumesseng6($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$db = new Model("lv_user");
		$detail = array();
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		
//		$sql = "Select max(TypeID) as m,MyID from MessengKefu_Text where (YouID='".CurUser::getLoginName()."' and IsAck".$ack_id2."=0) group by MyID order by m desc";		
//$data_user = $this -> db -> executeDataTable($sql);

		$msg_db = new Model ( "(Select max(TypeID) as m,MyID from MessengKefu_Text where (YouID='".CurUser::getLoginName()."' and IsAck".$ack_id2."=0) group by MyID) aa", "m" );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( "m DESC" );
		$msg_db->orderdesc ( "m ASC" );
		$msg_db->field ( "*" );
		if ($ispage == 0)
			$data_user = $msg_db->getList ();
		else
			$data_user = $msg_db->getPage ( $pageIndex, $pageSize, $count );
		
		$sql="";
		foreach($data_user as $k=>$v){
			$db -> clearParam();
			$db -> addParamWhere("userid",$data_user[$k]['myid']);
			$detail =  $db -> getDetail() ;
			
			$sql_count = "select count(*) as c from lv_source where UserId='".$data_user[$k]['myid']."'";
			$visitcount = $this -> db -> executeDataValue($sql_count);
			
			$sql = "select top 1 * from lv_chat where UserId ='".$data_user[$k]['myid']."' order by ChatId desc";
			$chat_detail = $this -> db -> executeDataRow($sql) ;

			$sql_max = "Select max(TypeID) as c from MessengKefu_Text where MyID='".CurUser::getLoginName()."' and YouID='".$data_user[$k]['myid']."' and IsAck".$ack_id1."=0";
			$maxTypeID = $this -> db -> executeDataValue($sql_max);
						
			$data_user[$k]['totype']=1;
			$data_user[$k]['usericoline']=$detail ["usericoline"];
			$data_user[$k]['status']=(int)$detail ["status"];
			$data_user[$k]['visitcount']=$visitcount;
			$data_user[$k]['isweixin']=$detail ["isweixin"];
			$data_user[$k]['headimgurl']=$detail ["headimgurl"];
			$data_user[$k]['chatid']=$chat_detail ["chatid"];
			if(empty($detail ["username"])) $data_user[$k]['username']=$detail ["area"];
			else $data_user[$k]['username']=$detail ["username"];
			if(empty($data_user[$k]['username'])) $data_user[$k]['username']=get_lang("livechat_message9");
			if($maxTypeID>$data_user[$k]['m']) $data_user[$k]['m']=$maxTypeID;
            //if(empty($detail ["status"])) unset($data_user[$k]);
		}
		
//	    $result_file = $this->list_kefumesseng2($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex,$pageSize);
//		$data_user = array_merge($data_user,$result_file["data_user"]) ;
//
//
//		return array("data_user"=>$data_user,"data"=>$result_file["data"],"count"=>$result_file["count"]);
		
		return array("data_user"=>$data_user,"data"=>$data,"count"=>$count);
	}

	function list_kmessengkefu_history($point,$myid,$youid,$lastTypeID,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($lastTypeID) $sql = " and TypeID<".$lastTypeID;
		else $sql = "";
		if(CHATERMODE) $where = stripslashes(" where ((MyID='".$myid."' and YouID='".$youid."') or (MyID='".$youid."' and YouID='".$myid."'))".$sql);
		else{
			 if(g("isclient")) $youid=$myid;
			 $where = stripslashes(" where (MyID='".$myid."' or YouID='".$myid."') and TypeID not in(Select TypeID from MessengKefu_Text where MyID='".$youid."' and To_Type=3)".$sql);
		}
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		return array("data"=>$data,"count"=>$count);
	}

	function list_kefumesseng_acks($point,$myid,$tableName, $fldId, $fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		$where = stripslashes(" where (MyID='".$myid."' and IsReceipt".$ack_id1."=1)");
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$arr_sql[] = "update MessengKefu_Text set IsReceipt".$ack_id1."=2 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_messengkefuclot($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		Global $printer;
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($point==0) $ack_id3 = 2;
		else $ack_id3 = 1;
		if($point==0) $ack_id4 = 4;
		else $ack_id4 = 3;
		
		if(CurUser::getLoginName()) $myid=CurUser::getLoginName();
		else $myid=g ( "myid" );
		$data_user = array();
		if(g ( "chater" )) $sql = " and TypeID=".g ( "chater" );
		$sql = "Select * from lv_chater_Clot_Form where UserID='".$myid."'".$sql;
//		echo $sql;
//		exit();
		$data_user = $this -> db -> executeDataTable($sql);
		if (count($data_user)==0) return array("data"=>$data,"count"=>0);
		$sql="";
		foreach($data_user as $k=>$v){
			$sql.=($sql==""?"":" or ")."(ClotID='".$data_user[$k]['typeid']."' and ((MyID='".$myid."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id1].") or (MyID<>'".$myid."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id2].")))" ;
		}
		
		$where = stripslashes(" where ".$sql);
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
			
		$livechat = new LiveChat ();
		foreach($data as $k=>$v){
			foreach($data_user as $m=>$n){
				if($data_user[$m]['typeid'] == $data[$k]['clotid']){
					 if($data[$k]['myid']==$myid) $data[$k]['isread']=(int)$data[$k]['typeid']>(int)$data_user[$m]['last_ack_typeid'.$ack_id3]?1:0 ;
					 else $data[$k]['isread']=(int)$data[$k]['typeid']>(int)$data_user[$m]['last_ack_typeid'.$ack_id4]?1:0 ;
//					 $row = $livechat->GetChaterDetail ($data[$k]['myid']);
//					 $data[$k]['avatar']=$row['picture'];
//					 $data[$k]['pid']=$data_user[$m]['pid'];
//					 $row = $livechat->GetChaterRoDetail ($data_user[$m]['pid']);
//					 $data[$k]['groupname']=$row['typename']."-群聊";
				}
			}
		}
		$msg_db->db->execute($arr_sql);
		
		$data_clot = array();
		
		foreach($data_user as $m=>$n){
			foreach($data as $k=>$v){
				if($data_user[$m]['typeid'] == $data[$k]['clotid']){
					$append = "";
					$sql = "select aa.TypeID as tid,aa.TypeName,aa.Remark,cc.* from lv_chater_Clot_Ro as aa,lv_user as cc where aa.UserId=cc.UserId and aa.TypeID=".$data_user[$m]['typeid'];
					$detail = $msg_db -> db -> executeDataRow($sql);
					$sql_count = "select count(*) as c from lv_source where UserId='".$detail ["userid"]."'";
					$visitcount = $msg_db->db -> executeDataValue($sql_count);
					
					$result['typeid']=$detail ["tid"];
					$result['typename']=$detail ["typename"];
					$result['remark']=$detail ["remark"];
					if($detail ["usericoline"]) $result['usericoline']=$detail ["usericoline"];
					else $result['usericoline']=1;
					$result['visitcount']=$visitcount;
					//$result['isweixin']=$detail ["isweixin"];
					if($detail ["isweixin"]) $result['isweixin']=$detail ["isweixin"];
					else $result['isweixin']=0;
					$result['headimgurl']=$detail ["headimgurl"];
					$sql = "select * from lv_chater_Clot_Form where TypeID =".$data_user[$m]['typeid'];
					$data1 = $msg_db -> db -> executeDataTable($sql) ;
					$result['clot_form']=$printer->parseList ( $data1, 0 );
					$sql_form = "select * from lv_user_form where UserId='" . $detail ["tid"] . "' and To_Type=6 and MyID='".CurUser::getUserId()."'";
					$data1 = $msg_db -> db -> executeDataTable($sql_form) ;
					$result['user_form']=$printer->parseList ( $data1, 0 );
					//$append = $printer->union ( $append, '"clot_form":[' . ($printer->parseList ( $data1, 0 )) . ']' );
					//$data2 = $printer -> getResult($result,'"clot_form":[' . ($printer->parseList ( $data1, 0 )) . ']' ) ;
					array_push($data_clot,$result);
					break;
				}
			}
		}

		return array("data_user"=>$data_clot,"data"=>$data,"count"=>$count);
	}
	
	function list_messengkefuclot_search($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		Global $printer;
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($point==0) $ack_id3 = 2;
		else $ack_id3 = 1;
		if($point==0) $ack_id4 = 4;
		else $ack_id4 = 3;
		
		if(CurUser::getLoginName()) $myid=CurUser::getLoginName();
		else $myid=g ( "myid" );
		$data_user = array();
		if(g ( "chater" )) $sql = " and TypeID=".g ( "chater" );
		$sql = "Select * from lv_chater_Clot_Form where UserID='".$myid."'".$sql;
//		echo $sql;
//		exit();
		$data_user = $this -> db -> executeDataTable($sql);
		if (count($data_user)==0) return array("data"=>$data,"count"=>0);
		$sql="";
		foreach($data_user as $k=>$v){
			$sql.=($sql==""?"":" or ")."ClotID='".$data_user[$k]['typeid']."'" ;
		}
		
		$where = stripslashes(f ( "wheresql", "" )." and (".$sql.")");
		//$where = stripslashes(" where ".$sql);
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );

		return array("data"=>$data,"count"=>$count);
	}

	
	function list_messengkefuclot4($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		Global $printer;
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($point==0) $ack_id3 = 2;
		else $ack_id3 = 1;
		if($point==0) $ack_id4 = 4;
		else $ack_id4 = 3;
		
		if(CurUser::getLoginName()) $myid=CurUser::getLoginName();
		else $myid=g ( "myid" );
		$data_user = array();
		if(g ( "chater" )) $sql = " and TypeID=".g ( "typeid" );
		$sql = "Select * from lv_chater_Clot_Form where UserID='".$myid."'".$sql;
//		echo $sql;
//		exit();
		$data_user = $this -> db -> executeDataTable($sql);
		if (count($data_user)==0) return array("data"=>$data,"count"=>0);
		$sql="";
		foreach($data_user as $k=>$v){
			$sql.=($sql==""?"":" or ")."(ClotID='".$data_user[$k]['typeid']."' and ((MyID='".$myid."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id1].") or (MyID<>'".$myid."' and TypeID>".$data_user[$k]['last_ack_typeid'.$ack_id2].")))" ;
		}
		
		$where = stripslashes(" where ".$sql);
		
	    $msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$msg_db->order ( $fldSortdesc );
		//$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		$data = $msg_db->getTop(1);

		return array("data"=>$data,"count"=>1);
	}
	
	function list_kmessengkefuclot_history($point,$myid,$youid,$lastTypeID,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if($lastTypeID) $sql = " and TypeID<".$lastTypeID;
		else $sql = "";
		$where = stripslashes(" where ClotID='".$youid."'".$sql);
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		return array("data"=>$data,"count"=>$count);
	}

	function list_messengkefuclot_acks($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;
		if(CurUser::getLoginName()) $myid=CurUser::getLoginName();
		else $myid=g ( "myid" );
		$where = stripslashes(" where (MyID='".$myid."' and IsReceipt".$ack_id1."=1)");
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
//			echo var_dump($data);
//			exit();
		foreach($data as $k=>$v){
			$arr_sql[] = "update lv_chater_KefuMsg_Acks set IsReceipt".$ack_id1."=2 where Msg_ID='" . $data[$k]['msg_id'] . "'" ;
		}
		$arr_sql[] = "delete from lv_chater_KefuMsg_Acks where IsReceipt1=2 and IsReceipt2=2" ;
		$msg_db->db->execute($arr_sql);
		return array("data"=>$data,"count"=>$count);
	}
	
	function list_messengnotice($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$ack_id1 = $point+1;
		$ack_id2 = $point+3;	
		$sql = "Select bb.* from Notice_Acks as aa,MessengNotice_Text as bb where aa.YouID='".CurUser::getUserId()."' and aa.IsAck".$ack_id1."=1 and aa.Msg_ID=bb.Msg_ID";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_messengverify($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		if($point==0) $UserId=CurUser::getUserId();
		else $UserId=CurUser::getUserId()."m";
		$where = stripslashes(" where UserID1='".$UserId."'");
		
		$msg_db = new Model ( $tableName, $fldId );
		$msg_db->where ( $where );
		$count = $msg_db->getCount ();
	
		$msg_db->order ( $fldSort );
		$msg_db->orderdesc ( $fldSortdesc );
		$msg_db->field ( $fldList );
		if ($ispage == 0)
			$data = $msg_db->getList ();
		else
			$data = $msg_db->getPage ( $pageIndex, $pageSize, $count );
			
		$sql = "Delete from MessengVerify_Type where UserID1='".$UserId."'" ;
		$msg_db->db->execute($sql);
			
		return array("data"=>$data,"count"=>$count);
	}

	function list_chat($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$sql = "select * from Tab_Chat where YouID='" . CurUser::getUserId() . "' and Status=0" ;
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_remote($point,$tableName, $fldId,$fldSort,$fldSortdesc,$fldList,$ispage,$pageIndex = 1,$pageSize = 20)
	{
		$arr_sql = array();
		$sql = "select * from remote_chat where YouID='" . CurUser::getUserId() . "' and Status=0" ;
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function list_kefumesseng_detail($point,$msg_id)
	{
		$ack_id1 = $point+3;
		$sql = "select * from MessengKefu_Text where Msg_ID='".$msg_id."'";
		$db = new DB();
		return $db -> executeDataRow($sql) ;
	}
	
	function list_kefuclotmesseng_detail($point,$msg_id)
	{
		$ack_id1 = $point+3;
		$sql = "select * from MessengKefuClot_Text where Msg_ID='".$msg_id."'";
		$db = new DB();
		return $db -> executeDataRow($sql) ;
	}
	
	function list_status()
	{
		$sql = "Select UserID,UserIcoLine,NetworkIP,LocalIP from Users_ID where UserState=1 and UserIcoLine>0";
		$data = $this -> db -> executeDataTable($sql);
		return array("data"=>$data);
	}
	
	function SendKefuMessage($point,$msg_id,$myid, $youid,$chatid,$fcname,$picture,$to_type,$usertext,$mychater)
	{
		$db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatid);
		$row = $db -> getDetail();
		if (count($row)){
			if ((int)$row ["status"]==0) $IsAck=2;
			else $IsAck=1;
		} 
		if(!$msg_id) $msg_id=create_guid1();
		$db = new Model("MessengKefu_Text","TypeID");
		$db -> addParamField("Msg_ID",$msg_id);
		$db -> addParamField("MyID",$myid);
		$db -> addParamField("YouID",$youid);
		$db -> addParamField("FcName",phpEscape1($fcname));  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
		$db -> addParamField("Picture",$picture);
		$db -> addParamField("ChatId",$chatid);
		$db -> addParamField("To_Type",$to_type);
		$db -> addParamField("UserText",$usertext);
		$db -> addParamField("FontInfo",$this -> NoticeFontInfo);
		if($point==1) $db -> addParamField("IsAck1",$IsAck);
		else $db -> addParamField("IsAck2",$IsAck);
		$db -> addParamField("IsAck3",$IsAck);
		$db -> addParamField("IsAck4",$IsAck);
		$db -> insert();
		$typeid = $db -> getMaxId();
		
		if($mychater==$myid) $userid=$youid;
		else $userid=$myid;
		$db = new Model("lv_user");
		$db -> addParamField("maxTypeID",$typeid);
		$db -> addParamField("myChater",$mychater);
		$db -> addParamWhere("userid", $userid);
		$db -> update();
		
		return $msg_id ;
	}
	
//	function SendKefuMessage1($point,$msg_id,$myid, $youid,$chatid,$fcname,$to_type,$usertext,$mychater)
//	{
//		if(!$msg_id) $msg_id=create_guid1();
//		$db = new Model("MessengKefu_Text");
//		$db -> addParamField("Msg_ID",$msg_id);
//		$db -> addParamField("MyID",$myid);
//		$db -> addParamField("YouID",$youid);
//		$db -> addParamField("FcName",$fcname);  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
//		$db -> addParamField("ChatId",$chatid);
//		$db -> addParamField("To_Type",$to_type);
//		$db -> addParamField("UserText",$usertext);
//		$db -> addParamField("FontInfo",$this -> NoticeFontInfo);
//		$db -> insert();
//		
//		return $msg_id ;
//	}
	
	
	function SendKefuClotMessage($point,$msg_id,$myid, $youid,$fcname,$pid,$typename,$picture,$to_type,$usertext)
	{
		if(!$msg_id) $msg_id=create_guid1();
		$db = new Model("MessengKefuClot_Text","TypeID");
		$db -> addParamField("Msg_ID",$msg_id);
		$db -> addParamField("ClotID",$youid);
		$db -> addParamField("PID",$pid);
		$db -> addParamField("TypeName",$typename."-群聊");
		$db -> addParamField("Picture",$picture);
		$db -> addParamField("MyID",$myid);
		$db -> addParamField("FcName",phpEscape1($fcname));  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
		$db -> addParamField("To_Type",$to_type);
		$db -> addParamField("UserText",$usertext);
		$db -> addParamField("FontInfo",$this -> NoticeFontInfo);
		$db -> insert();
		$typeid = $db -> getMaxId();
		
        $sql = "select * from lv_chater_Clot_Form where TypeID=".$youid;
        $db = new DB();
		$data = $db -> executeDataTable($sql) ;
//		echo var_dump($data);
//		echo $myid;
//		exit();
		foreach($data as $k=>$v){
			if($data[$k]['userid']==$myid){
				if($point==1){
					$sql="update lv_chater_Clot_Form set last_ack_typeid2=".$typeid." where TypeID=".$youid." and UserID='".$data[$k]['userid']."'";
				}else{
					$sql="update lv_chater_Clot_Form set last_ack_typeid1=".$typeid." where TypeID=".$youid." and UserID='".$data[$k]['userid']."'";
				}
				$this -> db -> execute($sql) ;
			}else{
				$sql = " delete from lv_chater_KefuMsg_Acks where Msg_ID='".$msg_id."' and YouID='".$data[$k]['userid']."'";
				$db = new DB ();
				$result = $db->execute ( $sql );
				$db = new Model ( "lv_chater_KefuMsg_Acks" );
				$db->addParamField ( "Msg_ID", $msg_id );
				$db->addParamField ( "ClotID", $youid );
				$db->addParamField ( "MyID", $myid );
				$db->addParamField ( "YouID", $data[$k]['userid'] );
				$db->insert ();
			}
		}
		
		return $msg_id ;
	}
	
    function GetQuestionMatch($point,$msg_id,$myid, $youid,$chatid,$fcname,$to_type,$usertext,$mychater)
    {
		$sql = "select * from lv_question where ((charindex(Subject,'".js_unescape($usertext)."')>0 and col_match=0) or (Subject='".js_unescape($usertext)."' and col_match=1)) and To_Type=1";
		$db = new DB();
		$row = $db -> executeDataRow($sql) ;
		if(empty($row['questionid'])){
			$col_receive = 2;
			$usertext="";
		}else{
			$col_receive=$row['col_receive'];
			$usertext=$row['usertext'].get_lang("msg_recv_chatgpt");
//			if($col_receive) $mychater_msg_id = $this -> SendKefuMessage($point,$msg_id,$myid,$youid,$chatid,$fcname,$to_type,phpescape($row['usertext']),$mychater);
//			else $mychater_msg_id = $this -> SendKefuMessage1($point,$msg_id,$myid,$youid,$chatid,$fcname,$to_type,phpescape($row['usertext']),$mychater);
		}
		return array("col_receive"=>$col_receive,"usertext"=>$usertext);
    }
	
    function GetErrCode($errcode)
    {
		switch($errcode)
		{
			case "invalid_api_key":
				$usertext = get_lang("msg_recv_chatgpt3");
				break ;
			case "context_length_exceeded":
				$usertext = get_lang("msg_recv_chatgpt4");
				break ;
			case "rate_limit_reached":
				$usertext = get_lang("msg_recv_chatgpt5");
				break ;
			case "access_terminated":
				$usertext = get_lang("msg_recv_chatgpt6");
				break ;
			case "no_api_key":
				$usertext = get_lang("msg_recv_chatgpt7");
				break ;
			case "insufficient_quota":
				$usertext = get_lang("msg_recv_chatgpt8");
				break ;
			case "account_deactivated":
				$usertext = get_lang("msg_recv_chatgpt9");
				break ;
			case "model_overloaded":
				$usertext = get_lang("msg_recv_chatgpt10");
				break ;
			default:
				$usertext = str_replace("{errcode}",$_SESSION['errcode'],get_lang("msg_recv_chatgpt11"));
				break ;
		}
		return $usertext;
    }
	
    function GetErrCode1($message,$errcode)
    {
		if (strpos($message, "Rate limit reached") === 0) { //访问频率超限错误返回的code为空，特殊处理一下
			$errcode = "rate_limit_reached";
		}
		if (strpos($message, "Your access was terminated") === 0) { //违规使用，被封禁，特殊处理一下
			$errcode = "access_terminated";
		}
		if (strpos($message, "You didn't provide an API key") === 0) { //未提供API-KEY
			$errcode = "no_api_key";
		}
		if (strpos($message, "You exceeded your current quota") === 0) { //API-KEY余额不足
			$errcode = "insufficient_quota";
		}
		if (strpos($message, "That model is currently overloaded") === 0) { //OpenAI服务器超负荷
			$errcode = "model_overloaded";
		}
		return $errcode;
    }
	
    /**
     * 使用 AK，SK 生成鉴权签名（Access Token）
     * @return string 鉴权签名信息（Access Token）
     */
    function getAccessToken(){
        $curl = curl_init();
        $postData = array(
            'grant_type' => 'client_credentials',
            'client_id' => CHATGPTAPPID,
            'client_secret' => CHATGPTKEY
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://aip.baidubce.com/oauth/2.0/token',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($postData)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rtn = json_decode($response);
        return $rtn->access_token;
    }
	
    function GetAnswer($msg_id,$col_receive,$usertext)
    {
		Global $printer;
		$mychater_msg_id=create_guid1();
		$to_type=1;
//						$usertext=get_lang("msg_recv_chatgpt");
		if(!CHATGPTAPPID){
			 //$to_type=3;
			 //$usertext=get_lang("msg_recv_chatgpt2");
			 $printer ->out_arr(array('status' => 1,'col_receive' => $col_receive,'msg' => $msg_id,'mychater_msg_id' => $mychater_msg_id,'usertext' => get_lang("msg_recv_chatgpt2"),'to_type' => 3));
		}
		if(!CHATGPTKEY){
			 $printer ->out_arr(array('status' => 1,'col_receive' => $col_receive,'msg' => $msg_id,'mychater_msg_id' => $mychater_msg_id,'usertext' => get_lang("msg_recv_chatgpt12"),'to_type' => 3));
		}
		if(!DEFAULTMODELURL){
			 $printer ->out_arr(array('status' => 1,'col_receive' => $col_receive,'msg' => $msg_id,'mychater_msg_id' => $mychater_msg_id,'usertext' => get_lang("msg_recv_chatgpt13"),'to_type' => 3));
		}
		if(!CHATGPTTYPE){
//							 $to_type=3;
//							 $usertext=get_lang("msg_recv_chatgpt1");
			 $printer ->out_arr(array('status' => 1,'col_receive' => $col_receive,'msg' => $msg_id,'mychater_msg_id' => $mychater_msg_id,'usertext' => get_lang("msg_recv_chatgpt1"),'to_type' => 3));
		}
		//return $this->getAccessToken();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => DEFAULTMODELURL."?access_token={$this->getAccessToken()}",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            
            CURLOPT_POSTFIELDS =>'{"messages":[{"role":"user","content":"'.js_unescape($usertext).'"}]}',
    
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),

        ));
        $response = curl_exec($curl);
        curl_close($curl);
		
		$answer = json_decode($response, true);
        return $answer['result'].get_lang("msg_recv_chatgpt");
//		
//		session_start();
//		$_SESSION['response'] = "";
//		$_SESSION['errmsg'] = "";
//		$ch = curl_init();
//		$headers  = [
//			'Accept: application/json',
//			'Content-Type: application/json',
//			'Authorization: Bearer ' . CHATGPTAPPID
//		];
//		
//		$postData = [
//			"model" => "gpt-3.5-turbo",
//			//"model" => "gpt-4",
//			"temperature" => 0,
//			"stream" => true,
//			"messages" => [],
//		];
//
//		$postData['messages'][] = ['role' => 'user', 'content' => js_unescape($usertext)];
//		$postData = json_encode($postData);
//		
//		$openai_callback = function ($ch, $data) {
//			$complete = json_decode($data);
//			if (isset($complete->error)) {
//				$_SESSION['errcode'] = $this -> GetErrCode1($complete->error->message,$complete->error->code);
////								if (strpos($complete->error->message, "Rate limit reached") === 0) { //访问频率超限错误返回的code为空，特殊处理一下
////									$_SESSION['errcode'] = "rate_limit_reached";
////								}
////								if (strpos($complete->error->message, "Your access was terminated") === 0) { //违规使用，被封禁，特殊处理一下
////									$_SESSION['errcode'] = "access_terminated";
////								}
////								if (strpos($complete->error->message, "You didn't provide an API key") === 0) { //未提供API-KEY
////									$_SESSION['errcode'] = "no_api_key";
////								}
////								if (strpos($complete->error->message, "You exceeded your current quota") === 0) { //API-KEY余额不足
////									$_SESSION['errcode'] = "insufficient_quota";
////								}
////								if (strpos($complete->error->message, "That model is currently overloaded") === 0) { //OpenAI服务器超负荷
////									$_SESSION['errcode'] = "model_overloaded";
////								}
//			} else {
//				$_SESSION['response'] .= $data;
//			}
//			return strlen($data);
//		};
//		
//		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//		curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//		curl_setopt($ch, CURLOPT_POST, 1);
//		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//		curl_setopt($ch, CURLOPT_WRITEFUNCTION, $openai_callback);
//		//curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:1081");
//		
//		curl_exec($ch);
//		curl_close($ch);
//		if($_SESSION['errcode']){
////							switch($_SESSION['errcode'])
////							{
////								case "invalid_api_key":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt3");
////									break ;
////								case "context_length_exceeded":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt4");
////									break ;
////								case "rate_limit_reached":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt5");
////									break ;
////								case "access_terminated":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt6");
////									break ;
////								case "no_api_key":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt7");
////									break ;
////								case "insufficient_quota":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt8");
////									break ;
////								case "account_deactivated":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt9");
////									break ;
////								case "model_overloaded":
////								    $result_file["usertext"] = get_lang("msg_recv_chatgpt10");
////									break ;
////								default:
////								    $result_file["usertext"] = str_replace("{errcode}",$_SESSION['errcode'],get_lang("msg_recv_chatgpt11"));
////									break ;
////							}
//			 $printer ->out_arr(array('status' => 1,'col_receive' => $col_receive,'msg' => $msg_id,'mychater_msg_id' => $mychater_msg_id,'usertext' => $this -> GetErrCode($_SESSION['errcode']),'to_type' => 3));
//		}
//		
//		$answer = "";
//		if (substr(trim($_SESSION['response']), -6) == "[DONE]") {
//			$_SESSION['response'] = substr(trim($_SESSION['response']), 0, -6) . "{";
//		}
//		$responsearr = explode("}\n\ndata: {", $_SESSION['response']);
//		
//		foreach ($responsearr as $v) {
//			$contentarr = json_decode("{" . trim($v) . "}", true);
//			if (isset($contentarr['choices'][0]['delta']['content'])) {
//				$answer .= $contentarr['choices'][0]['delta']['content'];
//			}
//		}
//		$answer .= get_lang("msg_recv_chatgpt");
//		return $answer;
    }
}

?>