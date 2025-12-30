<?php
define("CHAT_STATUS_WAIT",	0) ;		//等待
define("CHAT_STATUS_CONN",	1) ;  		//连接
define("CHAT_STATUS_CLOSE",	2) ;		//关闭


/**
 * 在线客服管理类
 * @author  jincun
 * @date    20140718
 */
class LiveChat 
{
	
	function __construct()
	{
		$this -> NoticeFontInfo = "宋体,10,0,False,False,False";
		$this -> db = new DB();
	}
		
    function GetChaterRo()
    {
		$sql = "select * from lv_chater_ro where Status=1 order by Ord ,TypeID";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function GetChaterRoDetail($TypeID)
    {
		$sql = "select * from lv_chater_ro where TypeID=" . $TypeID . " and Status=1 order by Ord ,TypeID";
		$db = new DB();
		return $db -> executeDataRow($sql) ;
    }
	
    function GetChaterForm($Chater,$TypeID)
    {
		$sql = "select aa.* from lv_chater as aa,Users_ID as bb,lv_chater_form as cc where cc.TypeID=".$TypeID." and bb.UserName='".$Chater."' and aa.Status=1 and bb.UserState=1 and cc.LoginName=bb.UserName and cc.LoginName=aa.LoginName and bb.UserIcoLine>0 and aa.Reception>".$this->GetChatCount ($Chater);
//		echo $sql;
//		exit();
		$db = new DB();
		$row = $db -> executeDataRow($sql);
		if (count($row)) $LoginName=$Chater;
		else{
			$sql = "select aa.LoginName,aa.Reception from lv_chater as aa,Users_ID as bb,lv_chater_form as cc where cc.TypeID=".$TypeID." and aa.UserName<>'".$Chater."' and aa.Status=1 and bb.UserState=1 and cc.LoginName=bb.UserName and cc.LoginName=aa.LoginName and bb.UserIcoLine>0 order by bb.UserIcoLine";
			$data1 = $db -> executeDataTable($sql) ;
			foreach($data1 as $k=>$v){
				 if($data1[$k]['reception']>$this->GetChatCount ($data1[$k]['loginname'])) $loginname1.=$data1[$k]['loginname'].',';
			}
			$loginname1=rtrim($loginname1, ",");
			$loginnamestr1=explode(',',$loginname1);
			if(!CHATERDISTRIBUTION){
				$sql = "select bb.Chater,count(distinct bb.UserId) as c from lv_chater as aa,lv_chat as bb,lv_chater_form as cc,Users_ID as dd where cc.TypeID=".$TypeID." and aa.UserName<>'".$Chater."' and aa.Status=1 and aa.LoginName=bb.Chater and aa.LoginName=cc.LoginName and aa.LoginName=dd.UserName and dd.UserIcoLine>0 and bb.InTime>DATEADD(mi,-30,getdate()) group by bb.Chater order by c";
				$data2 = $db -> executeDataTable($sql) ;
				foreach($data2 as $k=>$v){
					 $data = $this->GetChaterDetail ($data2[$k]['chater']);
					 if($data ["reception"]>$this->GetChatCount ($data2[$k]['chater'])) $loginname2.=$data2[$k]['chater'].',';
				}
				$loginname2=rtrim($loginname2, ",");
				$loginnamestr2=explode(',',$loginname2);
//					echo var_dump($loginnamestr1).'<br>';
//					echo var_dump($loginnamestr2).'<br>';
//					echo $sql;
//	exit();
				$diffA = array_diff($loginnamestr1, $loginnamestr2);
				if($diffA) $LoginName=current($diffA);
				else $LoginName=current($loginnamestr2);
			}else{
				$sql = "select top 1 * from lv_chat where GroupId =".$TypeID." order by ChatId desc";
				$db = new DB();
				$detail = $db -> executeDataRow($sql) ;
				$LoginName=getNextElm($detail ["chater"],$loginnamestr1) ;
			}
		}
		
		return $this->GetChaterDetail ($LoginName);
    }
	
    function GetChaterRnd($Chater)
    {
		$sql = "select aa.* from lv_chater as aa,Users_ID as bb where bb.UserName='".$Chater."' and aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 and aa.Reception>".$this->GetChatCount ($Chater);
		$db = new DB();
		$row = $db -> executeDataRow($sql);
		if (count($row)) $LoginName=$Chater;
		else{
			$sql = "select aa.LoginName,aa.Reception from lv_chater as aa,Users_ID as bb where aa.UserName<>'".$Chater."' and aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine";
			$data1 = $db -> executeDataTable($sql) ;
			foreach($data1 as $k=>$v){
				 if($data1[$k]['reception']>$this->GetChatCount ($data1[$k]['loginname'])) $loginname1.=$data1[$k]['loginname'].',';
			}
			$loginname1=rtrim($loginname1, ",");
			$loginnamestr1=explode(',',$loginname1);
			if(!CHATERDISTRIBUTION){
				$sql = "select bb.Chater,count(distinct bb.UserId) as c from lv_chater as aa,lv_chat as bb,Users_ID as cc where aa.UserName<>'".$Chater."' and aa.Status=1 and aa.LoginName=bb.Chater and aa.LoginName=cc.UserName and cc.UserIcoLine>0 and bb.InTime>DATEADD(mi,-30,getdate()) group by bb.Chater order by c";
				$data2 = $db -> executeDataTable($sql) ;
				foreach($data2 as $k=>$v){
					 $data = $this->GetChaterDetail ($data2[$k]['chater']);
					 if($data ["reception"]>$this->GetChatCount ($data2[$k]['chater'])) $loginname2.=$data2[$k]['chater'].',';
				}
				$loginname2=rtrim($loginname2, ",");
				$loginnamestr2=explode(',',$loginname2);
				$diffA = array_diff($loginnamestr1, $loginnamestr2);
				if($diffA) $LoginName=current($diffA);
				else $LoginName=current($loginnamestr2);
			}else{
				$sql = "select top 1 * from lv_chat order by ChatId desc";
				$db = new DB();
				$detail = $db -> executeDataRow($sql) ;
				$LoginName=getNextElm($detail ["chater"],$loginnamestr1) ;
			}
		}
		return $this->GetChaterDetail ($LoginName);
    }
	
    function GetChater()
    {
		$sql = "select UserId as id ,UserName as name," . EMP_USER . " as empType, loginName from lv_chater where Status=1";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function GetChaterDetail($LoginName)
    {
		//$sql = "select * from lv_chater where Status=1 and LoginName='".$LoginName."'";
		$sql = "select aa.*,bb.UserIcoLine from lv_chater as aa,Users_ID as bb where bb.UserName='".$LoginName."' and aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName";
//		echo $sql;
//		exit();
		$db = new DB();
		return $db -> executeDataRow($sql) ;
    }
	
    function GetChaterDetail1($LoginName)
    {
		$sql = "select aa.* from lv_chater as aa,Users_ID as bb where bb.UserName='".$LoginName."' and aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0";
		$db = new DB();
		return $db -> executeDataRow($sql) ;
    }
	
    function GetChatCount($Chater)
    {
		$sql_count = "select count(distinct UserId) as c from lv_chat where Chater='".$Chater."' and CONVERT(varchar(100), InTime, 23)='" . date("Y-m-d") . "'";
		$db = new DB();
		return $db -> executeDataValue($sql_count);
    }
	
	
    function GetQuestion($chater)
    {
        if($chater) $sql = "select * from lv_question where chater='" . $chater . "' and col_top=1 and To_Type=1 order by Ord ,QuestionId";
		else $sql = "select * from lv_question where chater='' and col_top=1 and To_Type=1 order by Ord ,QuestionId";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function GetQuestionDetail($QuestionId)
    {
		$sql = "select QuestionId,Subject,usertext,Ord from lv_question where QuestionId='".$QuestionId."'";
//		echo $sql;
//		exit();
		$db = new DB();
		return $db -> executeDataRow($sql) ;
    }
	
    function GetSourceDetail($ChatId,$UserId)
    {
		$sql = "select * from lv_source where ChatId='".$ChatId."' and UserId='".$UserId."'";
		$db = new DB();
		return $db -> executeDataRow($sql) ;
    }
	
//	function exist_name($name)
//	{
//		$sql = " select count(*) as c from lv_chater where LoginName='" . $name . "'" ;
//		$db = new DB();
//		$result = $db -> executeDataValue($sql);
//		return $result ;
//	}
	/**
     * 保存访客信息
     * @param unknown $user
     * @return array("userid"=>$userId,"username"=>$userName,"phone"=>$phone,"email"=>$email,"ip"=>$ip,"area"=>"")
     */
    function GetUser($user)
    {
		$detail = array();
		
		if ($user["userid"] == "")
			$user["userid"] = 0 ;

		//判断是否存在
		if ($user["userid"] != "0")
		{
			$db = new Model("lv_user");
			if($user["username"]) $db -> addParamField("username",$user["username"]);
			if($user["phone"]) $db -> addParamField("phone",$user["phone"]);
			if($user["email"]) $db -> addParamField("email",$user["email"]);
			if($user["qq"]) $db -> addParamField("qq",$user["qq"]);
			if($user["wechat"]) $db -> addParamField("wechat",$user["wechat"]);
			if($user["remarks"]) $db -> addParamField("remarks",$user["remarks"]);
			if($user["othertitle"]) $db -> addParamField("othertitle",$user["othertitle"]);
			if($user["otherurl"]) $db -> addParamField("otherurl",$user["otherurl"]);
			$db -> addParamWhere("userid", $user["userid"]);
			$db -> update();
			$db -> clearParam();
			$db -> addParamWhere("userid",$user["userid"]);
			$detail =  $db -> getDetail() ;
		}
		
		//新建
		if (count($detail) == 0)
		{
			$detail = $this -> CreateUser($user);
		}
		if(empty($detail ["username"])) $detail ["username"]=$detail ["area"];
		if(empty($detail ["username"])) $detail ["username"]=get_lang("livechat_message9");
		return $detail;
    }
	
    /**
     * 创建用户
     * @param unknown $user
     * @return $user
     */
    function CreateUser($user)
    {
		if (!$user["userid"]) $user["userid"] = getAutoId();
		$visitor = new visitorInfo();
		$visitor_ip = $visitor->getIp();
		$user ["ip"] = $visitor_ip;
		$user ["area"] = $visitor->findCityByIp($visitor_ip);
		$db = new Model("lv_user");
		$db -> clearParam();
		$db -> addParamFields($user);
		$db -> insert();
 
        SetValue("BIGANTLIVE_USERID", $user["userid"], -1);
        SetValue("BIGANTLIVE_USERNAME", $user["username"],-1);
        SetValue("BIGANTLIVE_PHONE", $user["phone"],-1);
        SetValue("BIGANTLIVE_EMAIL", $user["email"], -1);
		
		return $user;
    }
	
	/**
     * 保存访客信息
     * @param unknown $user
     * @return array("userid"=>$userId,"username"=>$userName,"phone"=>$phone,"email"=>$email,"ip"=>$ip,"area"=>"")
     */
    function GetClot_Ro($TypeID,$user)
    {
		$detail = array();
		
		if ($user["userid"] == "")
			$user["userid"] = 0 ;

		//判断是否存在
		if ($user["userid"] != "0")
		{
			$db = new Model("lv_chater_Clot_Ro");
			if($user["username"]) $db -> addParamField("typename",$user["username"]);
			$db -> addParamWhere("pid", $TypeID);
			$db -> addParamWhere("userid", $user["userid"]);
			$db -> update();
			$db -> clearParam();
			$db -> addParamWhere("pid", $TypeID);
			$db -> addParamWhere("userid", $user["userid"]);
			$detail =  $db -> getDetail() ;
		}

		//新建
		if (count($detail) == 0)
		{
			$detail = $this -> CreateClot_Ro($TypeID,$user);
		}
		if(empty($detail ["typename"])) $detail ["typename"]=$detail ["area"];
		if(empty($detail ["typename"])) $detail ["typename"]=get_lang("livechat_message9");
		return $detail;
    }
	
    /**
     * 创建用户
     * @param unknown $user
     * @return $user
     */
    function CreateClot_Ro($PID,$user)
    {
		$visitor = new visitorInfo();
		$visitor_ip = $visitor->getIp();
		$user ["ip"] = $visitor_ip;
		$user ["area"] = $visitor->findCityByIp($visitor_ip);
		if(empty($user ["username"])) $user ["username"]=$detail ["area"];
		if(empty($user ["username"])) $user ["username"]=get_lang("livechat_message9");
		$row = $this->GetChaterRoDetail ($PID);
//		echo var_dump($row);
//		exit();
		$db = new Model("lv_chater_Clot_Ro","TypeID");
		$db -> clearParam();
		$db -> addParamField("pid", $PID);
		$db -> addParamField("userid", $user["userid"]);
		$db -> addParamField("typename", $user["username"].'-'.$row['typename']);
		$db -> addParamField("remark", $row['typename']);
		$db -> addParamField("ip", $user["ip"]);
		$db -> addParamField("area", $user["area"]);
		$db -> insert();
		$typeid = $db -> getMaxId();

		$dbForm = new Model("lv_chater_Clot_Form");
		$sql = "select * from lv_chater_form where TypeID =".$PID;
		$data_user = $this -> db -> executeDataTable($sql) ;
		foreach($data_user as $k=>$v){
			$dbForm -> clearParam();
			$dbForm -> addParamField("pid", $PID);
			$dbForm -> addParamField("typeid", $typeid);
			$dbForm -> addParamField("userid", $data_user[$k]['loginname']);
			$dbForm -> addParamField("isadmin", 0);
			$dbForm -> addParamField("remark", $data_user[$k]['username']);
			$dbForm -> insert();
		}
		$dbForm -> clearParam();
		$dbForm -> addParamField("pid", $PID);
		$dbForm -> addParamField("typeid", $typeid);
		$dbForm -> addParamField("userid", $user["userid"]);
		$dbForm -> addParamField("isadmin", 1);
		$dbForm -> addParamField("remark", $user["username"]);
		$dbForm -> insert();

		$db = new Model("lv_chater_Clot_Ro");
		$db -> clearParam();
		$db -> addParamWhere("typeid", $typeid);
		$detail =  $db -> getDetail();
			
		return $detail;
    }
	
	function GetReception($reception)
	{		
		if($reception ["chaterreception"]) $DefaultReception=$reception ["chaterreception"];
		else{
			if($reception ["chater_roreception"]) $DefaultReception=$reception ["chater_roreception"];
			else $DefaultReception=DEFAULTRECEPTION;
		}
		$reception ["defaultreception"] = $DefaultReception;
		$db = new Model("lv_user_reception");
		$db -> clearParam();
		$db -> addParamWhere("myid", $reception ["myid"]);
		$db -> addParamWhere("youid", $reception ["youid"]);
		$db -> addParamWhere("to_type", $reception ["to_type"]);
		$detail =  $db -> getDetail() ;
		if (count($detail) == 0)
		{
			$detail = $this -> CreateReception($reception);
		}
		if((int)$detail ["defaultreception"]!=1) $detail ["defaultreception"]=0;
		return $detail;
		
	}
	
	function CreateReception($reception)
	{		
		$db = new Model("lv_user_reception");
		$db -> clearParam();
		$db -> addParamFields($reception);
		$db -> insert();
		return $reception;
		
	}
	/**
	 * 请求对话
	 * @param unknown $userId
	 * @param unknown $loginName
	 * @param unknown $userName
	 * @param unknown $chater
	 * @param number $connectType
	 * @return array
	 */
	function RequestChat($userId,$loginName, $userName,$chater,$connectType = 0,$GroupId)
	{		
		$db = new Model("lv_chat");
		$Id = getAutoId() ;
		$status = CHAT_STATUS_WAIT ;
		$connectTime = "1900-1-1" ;
        if ($connectType == 1)
        {
            $status = CHAT_STATUS_CONN ;
			$connectTime = getNowTime();
        }else{
			$sql = "select * from lv_chat where chater='".$chater."' and UserId='".$userId."' and CONVERT(varchar(100),ConnectTime, 23)<>'1900-01-01' and Status>0 and datediff(minute,InTime,getdate())<30";
			$db1 = new DB();
			$row = $db1 -> executeDataRow($sql) ;
			if (count($row)>0) $status = CHAT_STATUS_CONN ;
		}
		$db -> clearParam();
		$db -> addParamField("chatid",$Id);
		$db -> addParamField("GroupId",$GroupId);
		$db -> addParamField("chater",$chater);
		$db -> addParamField("userid",$userId);
		$db -> addParamField("NContent",$loginName);  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
		$db -> addParamField("username",$userName);
		$db -> addParamField("status",$status);
		$db -> addParamField("connecttime",$connectTime,"datetime");
		$db -> addParamField("intime",getNowTime(),"datetime");
		$db -> addParamField("ip",$_SERVER['REMOTE_ADDR']);
		$db -> insert();
		
		$this->setStatus ( $userId, $status );
		//$this -> RequestSource($userId,$loginName, $userName,$chater,$connectType = 0,$chatType,$Id);
		$db = new Model("lv_user");
		$db -> clearParam();
		$db -> addParamField("cookiehcid1",$Id);
		$db -> addParamWhere("userid", $userId);
		$db -> update();

		$msg = new Msg ();
		if((!g ( "isnotsend" ))&&DIALOGTYPE){
			$db2 = new DB();
			$sql = "select LoginName from lv_chater_notice where TypeID=2";	
			$data2 = $db2 -> executeDataTable($sql);
			foreach($data2 as $value){
				 if(in_array($chater, $value)) $msg -> sendKfMessage($userId, $chater, get_lang("livechat_message2"),0);
			}
		}
		if($status==CHAT_STATUS_WAIT) $connectType=2;
		else $connectType=1;
		return  array("status"=>$status,"chatid"=>$Id,"connectType"=>$connectType) ;
	}
	
	function RequestSource($typeid,$userId,$loginName, $userName,$chater,$connectType = 0,$chatType,$chatId,$isweb)
	{		
		switch ($chatType) {
			case 0 :
				$visitor_referer = g ( "sourceurl" );
				if(!$visitor_referer) return ;
				$sql = "select * from lv_track where UserId='".$userId."' and datediff(minute,InTime,getdate())<60";
				$db = new DB();
				$row = $db -> executeDataRow($sql) ;
//				$row = $this->GetSourceDetail($chatId,$userId);
				if (count($row)==0){
					$visitor = new visitorInfo();
					$keyword = new keyword();
					$visitor_ip = $visitor->getIp();
					$keywords = "-";
					$area = $visitor->findCityByIp($visitor_ip);
					$db = new Model("lv_source","SourceId");
					$db -> addParamField("chatid",$chatId);
					$db -> addParamField("chater",$chater);
					$db -> addParamField("userid",$userId);
					$db -> addParamField("username",$userName);
					
					$db -> addParamField("sourceurl",$visitor_referer);
					$db -> addParamField("launchurl",g ( "launchurl" ));
					$db -> addParamField("keyword",$keywords);
					
					$db -> addParamField("ip",$visitor_ip);
					$db -> addParamField("area",$area);
					$db -> addParamField("browser",$visitor->getBrowser());
					$db -> insert();
					$SourceId = $db -> getMaxId();	
					
					if(WEBSITETYPE==1&&$isweb){
						$db = new DB();
						$sql = "select aa.LoginName from lv_chater as aa,Users_ID as bb where aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";
						$data = $db -> executeDataTable($sql);
						$sql = "select LoginName from lv_chater_notice where TypeID=1";	
						$data2 = $db -> executeDataTable($sql);
						foreach($data as $k=>$v) if(in_array($v, $data2)) unset($data[$k]);
						if($loginName){
							foreach($data as $row){
								if($loginName==$row["loginname"]) $UserNames=$loginName;
							}
						}else if($typeid){
							$relation = new EmpRelation ();
							$data_file = $relation->getRelationData1 ( $parentEmpType, $typeid, $childEmpType );
							foreach($data as $row){
								foreach($data_file as $m=>$n){
									if($data_file[$m]['col_loginname']==$row["loginname"]){
										 $UserNames .= ($UserNames?",":"") . $row["loginname"];
									}
								}
							}
						}else{
							if(!CHATERMODE){
								foreach($data as $row){
									$UserNames .= ($UserNames?",":"") . $row["loginname"];
								}
							}
						}
						if($UserNames){
							$dp = new Model ( "Plug" );
							$dp->addParamWhere ( "Plug_Name", "Online_Service" );
							$row = $dp->getDetail ();
							$nlink=$row ["plug_target"]."*TargetType=1*data_type=visitors*data_id=".$userId;
							if(empty($userName)) $lvuserName=$area;
							else $lvuserName=$userName;
							$msg = new Msg ();
							$msg ->sendRTCMessge('admin',$UserNames,get_lang("livechat_message16"), $lvuserName.getNowTime().get_lang("livechat_message17"),$nlink,3);
						}
					}
					
				}else $SourceId = $row["sourceid"];	
				break;
			case 1 :
				$param = array("chatid"=>"0","userid"=>$userId) ;
				$db = new Model("lv_source");
				$db -> addParamField("chatid",$chatId);
				$db -> addParamField("chater",$chater);
				$db -> addParamField("username",$userName);
				$db -> addParamWheres($param);
				$db -> update();
				
				$db = new Model("lv_track");
				$db -> addParamField("chatid",$chatId);
				$db -> addParamField("chater",$chater);
				$db -> addParamField("username",$userName);
				$db -> addParamWheres($param);
				$db -> update();
				break;
		}	
		$this -> RequestTrack($SourceId,$userId,$loginName, $userName,$chater,$connectType = 0,$chatId);
	}
	
	function RequestTrack($SourceId,$userId,$loginName, $userName,$chater,$connectType = 0,$chatId)
	{		
		if(!g ( "launchurl" )) return ;
		$db = new Model("lv_track");
		$db -> addParamField("sourceid",$SourceId);
		$db -> addParamField("chatid",$chatId);
		$db -> addParamField("chater",$chater);
		$db -> addParamField("userid",$userId);
		$db -> addParamField("username",$userName);
		
		$db -> addParamField("trackurl",g ( "launchurl" ));  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)

		$db -> insert();
	}
	
	function SendKefuMessage($chatid, $userid, $chater,$username,$msgtype,$msg,$isack,$mychater,$picture)
	{
		$msg_id=create_guid1();
		$db = new Model("MessengKefu_Text","TypeID");
		$db -> addParamField("Msg_ID",$msg_id);
		$db -> addParamField("MyID",$userid);
		$db -> addParamField("YouID",$chater);
		$db -> addParamField("FcName",$username);  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
		$db -> addParamField("Picture",$picture);
		$db -> addParamField("ChatId",$chatid);
		$db -> addParamField("To_Type",$msgtype);
		$db -> addParamField("UserText",$msg);
		$db -> addParamField("FontInfo",$this -> NoticeFontInfo);
		if($isack){
		$db -> addParamField("IsAck1",1);
		$db -> addParamField("IsAck2",1);
		}
		$db -> addParamField("IsAck3",1);
		$db -> addParamField("IsAck4",1);
		$db -> insert();
		$typeid = $db -> getMaxId();
		
		if($mychater==$userid) $myuserid=$chater;
		else $myuserid=$userid;
		$db = new Model("lv_user");
		$db -> addParamField("maxTypeID",$typeid);
		$db -> addParamField("myChater",$mychater);
		$db -> addParamWhere("userid", $myuserid);
		$db -> update();
		
		return $msg_id ;
	}
	
	function SendKefuClotMessage($clotid, $userid,$username,$pid,$typename,$picture,$msgtype,$msg)
	{
		$msg_id=create_guid1();
		$db = new Model("MessengKefuClot_Text","TypeID");
		$db -> addParamField("Msg_ID",$msg_id);
		$db -> addParamField("ClotID",$clotid);
		$db -> addParamField("PID",$pid);
		$db -> addParamField("TypeName",$typename."-群聊");
		$db -> addParamField("Picture",$picture);
		$db -> addParamField("MyID",$userid);
		$db -> addParamField("FcName",phpEscape1($username));  //访客的帐号，这个很重要，是查询历史记录的参数(这里在登录前，所以无效)
		$db -> addParamField("To_Type",$msgtype);
		$db -> addParamField("UserText",$msg);
		$db -> addParamField("FontInfo",$this -> NoticeFontInfo);
		$db -> insert();
		return $msg_id ;
	} 
	/**
	 * 接受回话
	 * @param unknown $chatId
	 * @param string $visiter_loginName
	 * @return boolean
	 */
    function RecvChat($userId,$chatId,$visiter_loginName = "")
    {
        if ($chatId == "")
            return true;
			
		$data=$this -> GetChaterDetail($visiter_loginName);
		
        $db = new Model("MessengKefu_Text");
        $db -> addParamField("IsAck1", 1);
		$db -> addParamField("IsAck3", 1);
		$db -> addParamField("IsAck4", 1);
		$db -> addParamWhere("ChatId", $chatId);
		$db -> addParamWhere("IsAck1", 2);
        $db -> update();
		$db -> clearParam();
        $db -> addParamField("IsAck2", 1);
		$db -> addParamField("IsAck3", 1);
		$db -> addParamField("IsAck4", 1);
		$db -> addParamWhere("ChatId", $chatId);
		$db -> addParamWhere("IsAck2", 2);
		$db -> update();
		
		if((int)$data ["usericoline"]>0) $kefumsg=get_lang("livechat_message1");
		else $kefumsg=get_lang("livechat_message0");
		$this -> SendKefuMessage($chatId,$userId,$data ["loginname"],$data ["username"],3,date("G:i:s").get_lang("livechat_message2"),0,$data ["loginname"],$data ["picture"]);
		$this -> SendKefuMessage($chatId,$data ["loginname"],$userId,$data ["username"],3,str_replace("{name}",$data ["username"],$kefumsg),0,$data ["loginname"],$data ["picture"]);
		if((g ("goods_info")!='')) $this -> SendKefuMessage($chatId,$userId,$data ["loginname"],$data ["username"],1,g ("goods_info"),1,$data ["loginname"],$data ["picture"]);
		if($data ["welcome"]){
			$db = new Model("lv_chat");
			$db -> addParamWhere("Chater", $data ["loginname"]);
			$db -> addParamWhere("UserId", $userId);
			$db -> addParamWhere("Status", 2);
			$row = $db -> getDetail();
			if (count($row)==0){
				$arr_welcome = explode("<hr />",$data ["welcome"]);
				foreach($arr_welcome as $welcome)
				{
					if($welcome) $this -> SendKefuMessage($chatId,$data ["loginname"],$userId,$data ["username"],1,phpescape($welcome),1,$data ["loginname"],$data ["picture"]);
				}
			} 
		}
		$this->setStatus ( $userId, CHAT_STATUS_CONN );

        $db = new Model("lv_chat");
        $db -> addParamField("Status", CHAT_STATUS_CONN);
		$db -> addParamField("ConnectTime",getNowTime(),"datetime");
		$db -> addParamField("NContent",$visiter_loginName);   //访客的帐号，这个很重要，是查询历史记录的参数
		$db -> addParamWhere("ChatId", $chatId);
        return $db -> update();
    }
	
    /**
     * 关闭窗口
     * @param unknown $chatId
     * @param unknown $closeRole
     * @return boolean
     */
    function CloseChat($chatId, $closeRole)
    {
        if ($chatId == "")
            return true;

        $db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatId);
		$row = $db -> getDetail();
        if (count($row) == 0)
            return -1;

		//$this->setStatus ( $row["userid"], CHAT_STATUS_CLOSE );
		
		$sql_count = "select count(*) as c from MessengKefu_Text where ChatId=".$chatId." and MyID='".$row["userid"]."' and To_Type=1";
		$visitcount = $this -> db -> executeDataValue($sql_count);
		if($visitcount) $db -> addParamField("IsEnable", 1);
		
        $db -> addParamField("Status", CHAT_STATUS_CLOSE);
        $db -> addParamField("CloseRole", $closeRole);
		$db -> addParamField("OutTime", getNowTime(),"datetime");
		//$db -> addParamWhere("ChatId", $chatId);
        return $db -> update();
    }
	
    function CloseChat1($Chater, $closeRole)
    {
        if ($Chater == "")
            return true;
			
        $db = new Model("lv_chat");
		$db -> addParamWhere("Chater", $Chater);
		$db -> addParamWhere("CloseRole", CHAT_STATUS_CLOSE, "<>", "int");
		$data = $db -> getList();
		foreach($data as $k=>$v){
			//$this->setStatus ( $data[$k]['userid'], CHAT_STATUS_CLOSE );
			$sql_count = "select count(*) as c from MessengKefu_Text where ChatId=".$data[$k]['chatid']." and MyID='".$data[$k]['userid']."' and To_Type=1";
			$visitcount = $this -> db -> executeDataValue($sql_count);
			if($visitcount) $db -> addParamField("IsEnable", 1);
			$db -> addParamField("Status", CHAT_STATUS_CLOSE);
			$db -> addParamField("CloseRole", $closeRole);
			$db -> addParamField("OutTime", getNowTime(),"datetime");
			$db -> update();
		}
        return 1;
    }
	
    function CloseChat2($UserId, $Chater, $closeRole)
    {
        if ($Chater == ""||$UserId == "")
            return true;
			
        $db = new Model("lv_chat");
		$db -> addParamWhere("Chater", $Chater);
		$db -> addParamWhere("UserId", $UserId);
		$db -> addParamWhere("CloseRole", CHAT_STATUS_CLOSE, "<>", "int");
		$data = $db -> getList();
		foreach($data as $k=>$v){
			$this->setStatus ( $data[$k]['userid'], CHAT_STATUS_CLOSE );
			$sql_count = "select count(*) as c from MessengKefu_Text where ChatId=".$data[$k]['chatid']." and MyID='".$data[$k]['userid']."' and To_Type=1";
			$visitcount = $this -> db -> executeDataValue($sql_count);
			if($visitcount) $db -> addParamField("IsEnable", 1);
			$db -> addParamField("Status", CHAT_STATUS_CLOSE);
			$db -> addParamField("CloseRole", $closeRole);
			$db -> addParamField("OutTime", getNowTime(),"datetime");
			$db -> update();
		}
        return 1;
    }
	
    function setUserIcoLine($userid, $UserIcoLine)
    {
        if ($userid == "")
            return true;

		$db = new Model("lv_user");
		$db -> addParamField("UserIcoLine",$UserIcoLine);
		$db -> addParamWhere("userid", $userid);
        return $db -> update();
    }
	
    function setStatus($userid, $Status)
    {
        if ($userid == "")
            return true;

		$db = new Model("lv_user");
		$db -> addParamField("Status",$Status);
		$db -> addParamWhere("userid", $userid);
        return $db -> update();
    }
	
    function setSubscribe($userid, $Subscribe)
    {
        if ($userid == "")
            return true;

		$db = new Model("lv_user");
		$db -> addParamField("subscribe",$Subscribe);
		$db -> addParamWhere("userid", $userid);
        return $db -> update();
    }
    /**
     * 统计等待的人数
     * @param unknown $chatId
     * @return $queue
     */
    function GetQueue($chatId)
    {
        //自动关闭长时间的会话
        $this -> AutoCloseChat();

        $db = new Model("lv_chat");
		$db -> addParamWhere("ChatId", $chatId);
		$row = $db -> getDetail();


        if (count($row) == 0)
            return array("status"=>-1,"queue"=>$queue);

        $status = $row["status"];
        $dber = $row["chater"];
		
		$data=$this -> GetChaterDetail($dber);

		if (count($data)==0) return array("status"=>3,"queue"=>$queue);
		if((int)$data ["usericoline"]==0) return array("status"=>4,"queue"=>$queue);
			
		switch($status)
		{
			case CHAT_STATUS_CONN:
				return array("status"=>1,"queue"=>$queue);
				break ;
			case CHAT_STATUS_CLOSE:
				return array("status"=>2,"queue"=>$queue);
				break ;
		}

        //统计等待的人数
		$db -> where(" where status=0 and chater='" . $dber . "' and chatid<'" . $chatId . "'");
		$queue = $db -> getCount() ;
		return array("status"=>0,"queue"=>$queue);
    }
	
    /**
     * 自动关闭窗口
     */
    function AutoCloseChat()
    {
        $sql = "update lv_chat set status=2 where status<2 and datediff(hour,intime,getdate())>4 ";
		$db = new DB();
		$db -> execute($sql);
    }
	

    /**
     * 保存文件
     * @param unknown $chatId 空表示公共文件
     * @param unknown $flag 0 客服上传  1访客上传
     * @param unknown $chater
     * @param unknown $visitUserName
     * @param unknown $fileName
     * @param unknown $filePath
     * @param unknown $fileSize
     * @return  成功 2 无内容 3 大小超出</returns>
     */
    function SaveFile($chatId, $flag,$chater, $visitUserName,$fileName, $filePath, $fileSize)
    {
		$attach = new Model("lv_file");
 
        $attach -> clearParam();
        $attach -> addParamField("ChatId", $chatId);
        $attach -> addParamField("Chater", $chater);
        $attach -> addParamField("UserName", $visitUserName);
        $attach -> addParamField("FileName", $fileName);
        $attach -> addParamField("FileSize", $fileSize);
        $attach -> addParamField("FilePath", $filePath);
        $attach -> addParamField("Flag", $flag);
        $attach -> addParamField("CreateUser", ($flag == 0) ? $chater : $visitUserName);
        $attach -> insert();
 
        return 1;

    }
	

    /**
     * 列出文件
     * @param unknown $chatId
     * @param unknown $flag 0 客服上传  1访客上传
     * @return  DataTable
     */
    function ListFile($chatId, $flag)
    {
        $sql = " select * from lv_file where chatId='" . $chatId . "' and flag=" . $flag;

        //不要根据CHATID，而是根据 客服与访客(访客多次关闭，CHATID会变)
        if (($chatId != "") && ($flag == 0))
        { 
            //根据CHATID得到USERID
            //根据USERID得到所有的CHATID
            //根据CHATID，得到所有的FILE
			
            $sql = "  select * from lv_file where flag=" . $flag . " and  chatid<>0 and chatId in( " .
                    " select ChatId from lv_chat where UserId=( " .
                    " select UserId from lv_chat where CHATID='" . $chatId . "'" .
                    " ))";
					
        }

        $db = new DB();
		return $db -> executeDataTable($sql) ;
    }


    /**
     * 共享的链接
     * @param unknown $dper
     * @return  DataTable
     */
    function ListLink($chater)
    {
        if($chater) $sql = " select aa.* from LV_LINK as aa,lv_chater as bb where bb.LoginName='" . $chater . "' and bb.UserId=aa.Chater";
		else $sql = " select * from LV_LINK where chater=''";
//		echo $sql;
//		exit();
        $db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function ListTrack($ChatId,$UserId)
    {
        $sql = "select * from lv_track where ChatId='".$ChatId."' and UserId='".$UserId."'";
        $db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
	
    function ListTrack1($SourceId)
    {
        $sql = "select * from lv_track where SourceId=".$SourceId;
        $db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function listUserRo($userId)
    {
		$sql = "select * from lv_user_ro where Status=1 and TypeID not in(select TypeID from lv_user_form where UserId='" . $userId . "') order by Ord ,TypeID";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
	
    function listUserForm($userId)
    {
		$sql = "select aa.* from lv_user_ro as aa,lv_user_form as bb where bb.UserId='" . $userId . "' and aa.TypeID=bb.TypeID and aa.Status=1 order by aa.Ord ,aa.TypeID";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function listRo()
    {
		$sql = "select * from lv_user_ro where Status=1 order by Ord ,TypeID";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function GetMeetingPlug()
    {
		$sql = "Select * from Plug where Plug_Enabled=1 and Plug_Name='Meeting'";
		$db = new DB();
		return $db -> executeDataTable($sql) ;
    }
	
    function Getissend($loginname)
    {
		$issend=0;
		if(SENDWELCOME){
			$db2 = new DB();
			$sql = "select LoginName from lv_chater_notice where TypeID=5";	
			$data2 = $db2 -> executeDataTable($sql);
			foreach($data2 as $value){
				 if(in_array($loginname, $value)) $issend=1;
			}
		}
		return $issend ;
    }
	
    function ListOnlineChater()
    {
		$db = new DB();
		if(CHATERMODE){
		  $sql = "select * from lv_chater_form where LoginName ='".f ( "loginname", "" )."'";
		  $data_user = $db -> executeDataTable($sql) ;
		  $TypeIDs="";
		  foreach($data_user as $k=>$v){
			  $TypeIDs .= ($TypeIDs?",":"") . $data_user[$k]['typeid'];
		  }
		  if ($TypeIDs) $sql = "select distinct aa.*,bb.UserID,bb.FcName,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb,lv_chater_form as cc where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and cc.TypeID in (" . $TypeIDs . ") and aa.LoginName=bb.UserName and aa.LoginName=cc.LoginName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";
		  else $printer->out_list($data,-1,0);
	//	  echo $sql;
	//	  exit();
		}else $sql = "select aa.*,bb.UserID,bb.FcName,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";
	
	//	$sql = "select * from Users_ID where UserName ='".f ( "loginname", "" )."'";
	//	$db = new DB();
	//	$detail = $db -> executeDataRow($sql) ;
	//	$sql = "select aa.*,bb.UserID,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and bb.UppeID='".$detail ["uppeid"]."' and aa.LoginName=bb.UserName and bb.UserIcoLine>0 order by bb.UserIcoLine desc";
				
		$data = $db -> executeDataTable($sql) ;
		
		$sql = "select aa.*,bb.UserID,bb.FcName,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb,lv_transfer as cc where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 and aa.LoginName=cc.Chater and cc.MyID ='".f ( "loginname", "" )."'";
		$data1 = $db -> executeDataTable($sql) ;
		$result=array_intersect($data1,$data);
		//$result1=array_diff($data,$result);
		
		$result1 = array();
		foreach ($data as $item) {
			$found = false;
			foreach ($result as $compareItem) {
				if ($item['loginname'] == $compareItem['loginname']) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$result1[] = $item;
			}
		}
		
		//$result1 = array_udiff($data,$result, 'compareArrays');
		$result2=array_merge($data1,$result1) ;
		
		return $data ;
    }
	
    function SearchOnlineChater()
    {
		$db = new DB();
		$searchtxt = f ( "searchtxt", "" );
		if(CHATERMODE){
		  $sql = "select * from lv_chater_form where LoginName ='".f ( "loginname", "" )."'";
		  $data_user = $db -> executeDataTable($sql) ;
		  $TypeIDs="";
		  foreach($data_user as $k=>$v){
			  $TypeIDs .= ($TypeIDs?",":"") . $data_user[$k]['typeid'];
		  }
		  if ($TypeIDs) $sql = "select distinct aa.*,bb.UserID,bb.FcName,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb,lv_chater_form as cc where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and cc.TypeID in (" . $TypeIDs . ") and aa.LoginName=bb.UserName and aa.LoginName=cc.LoginName and bb.UserIcoLine>0 and (aa.LoginName like '%".$searchtxt."%' or aa.UserName like '%".$searchtxt."%' or bb.FcName like '%".$searchtxt."%') order by bb.UserIcoLine desc";
		  else $printer->out_list($data,-1,0);

		}else $sql = "select aa.*,bb.UserID,bb.FcName,bb.UserIco,bb.UserIcoLine from lv_chater as aa,Users_ID as bb where aa.LoginName<>'" . f ( "loginname", "" ) . "' and  aa.Status=1 and bb.UserState=1 and aa.LoginName=bb.UserName and bb.UserIcoLine>0 and (aa.LoginName like '%".$searchtxt."%' or aa.UserName like '%".$searchtxt."%' or bb.FcName like '%".$searchtxt."%') order by bb.UserIcoLine desc";
				
//		echo $sql;
//		exit();
		$data = $db -> executeDataTable($sql) ;
		
		return $data ;
    }
}
	
?>