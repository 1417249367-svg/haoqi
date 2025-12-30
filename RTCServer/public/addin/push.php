<?php

header("Content-Type: text/html; charset=utf-8");
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/class/fun.php");
require_once (__ROOT__ . "/class/lv/LiveChat.class.php") ;
require_once (__ROOT__ . "/class/common/visitorInfo.class.php") ;
require_once (__ROOT__ . "/vendor/phpmailer/class.phpmailer.php");
require_once (__ROOT__ . "/vendor/getui/igetui.php");
//require_once (__ROOT__ . "/vendor/jpush/jpush/index.php");
//require_once (__ROOT__ . "/vendor/HuaweiPush/PushNcMsg.php");
require_once (__ROOT__ . "/vendor/hmspush/src/example/push_notification_msg.php");
//require_once (__ROOT__ . "/vendor/hmspush/src/example/push_common/test_sample_push_msg_common.php");
//require_once (__ROOT__ . "/vendor/hmspush/src/push_admin/Constants.php");
require_once (__ROOT__ . "/vendor/mipush/index.php");

define('BigData',urldecode($_GET["bigdata"]));
//	echo BigData;
//	exit();
pushMessage();

function PastEtaEx($RTB,$fcname)
{
  $arrEx = explode ( "@", $RTB );
  $arrcount=count($arrEx);
  for ($i=0; $i<$arrcount-1; $i++) {
	$m=strpos($RTB,"@")+1;
	$n=strpos($RTB,":")-$m;
	$TempString=substr($RTB, $m, $n);
	if(($TempString=="everyone")||($TempString==$fcname)) return 1 ;
  } 
  return 0 ;
}

function JPushDeviceListSingleNotification($deviceList,$PlatForm,$FcName,$UserText,$Tel)
{
	$url = getRootPath()."/vendor/emasPush/src/Sample.php";
	$postData = array(
		'deviceList'  => $deviceList,
		'PlatForm' => $PlatForm,
		'FcName'=> $FcName,
		'UserText' => $UserText
	);
		
//			 echo $url;
//			 exit; 

	postHttp($url, $postData);
}

function JPushDeviceListMultipleNotification($deviceList,$PlatForm,$FcName,$UserText)
{
	$url = getRootPath()."/vendor/emasPush/src/Sample.php";
	$postData = array(
		'deviceList'  => join(',', $deviceList),
		'PlatForm' => $PlatForm,
		'FcName'=> $FcName,
		'UserText' => $UserText
	);
		
//			 echo var_dump($postData);
//			 exit; 

	postHttp($url, $postData);
}


function pushMessage()
{
    //$igt->connect();
    //消息模版：
    // 1.TransmissionTemplate:透传功能模板
    // 2.LinkTemplate:通知打开链接功能模板
    // 3.NotificationTemplate：通知透传功能模板
    // 4.NotyPopLoadTemplate：通知弹框下载功能模板
	//$arr_id = split("p|",BigData);
	putenv("gexin_pushSingleBatch_needAsync=false");

	$igt = new IGeTui(HOST, APPKEY, MASTERSECRET);
	$batch = new IGtBatch(APPKEY, $igt);
	$batch->setApiUrl(HOST);

	$arr_id = explode("p|",BigData);
	foreach($arr_id as $id)
	{
		if ($id)
		{
			$arr_item = explode("|",$id);
			switch($arr_item[3])
			{
				case "1":
					$param = array("UserID"=>$arr_item[2]) ;
					$root = new Model("Users_ID");
					$root -> addParamWheres($param);
					$FcName = $root -> getValue("FcName");
					if($arr_item[0]==$arr_item[2]) $FcName = "我的电脑";
					$MessengText = $FcName.":".$arr_item[4];

					$param = array("MyID"=>$arr_item[0],"YouID"=>$arr_item[2],"To_Type"=>1) ;
					$root = new Model("Clot_Silence");
					$root -> addParamWheres($param);
					$TypeID = $root -> getValue("TypeID");
					if(!$TypeID){
						$result=SendNotification($arr_item[0],$FcName,$MessengText);
						if($result["status"]==1) $batch->add($result["message"], $result["target"]);
						elseif($result["status"]==2) JPushDeviceListSingleNotification($result["target"],1,$FcName,$MessengText,$result["tel1"]);//添加元素
						elseif($result["status"]==3) HuaweiPushSingleDeviceNotification($result["target"],1,$FcName,$MessengText);//添加元素
						elseif($result["status"]==4) MiPushSingleDeviceNotification($result["target"],1,$FcName,$MessengText);//添加元素
					}	
					break ;
				case "2":
				    $array_huawei = array();//定义数组
					$array_xiaomi = array();//定义数组
					$array_jpush = array();//定义数组
					$param = array("UserID"=>$arr_item[1]) ;
					$root = new Model("Users_ID");
					$root -> addParamWheres($param);
					$ClotFormName = $root -> getValue("FcName");
					$param = array("TypeID"=>$arr_item[2]) ;
					$root = new Model("Clot_Ro");
					$root -> addParamWheres($param);
					$FcName = $root -> getValue("TypeName");
					$MessengText = $ClotFormName."(".$FcName."):".$arr_item[4];

					$db = new DB();
					$data=$db -> executeDataTable("select * from Clot_Form where UpperID='".$arr_item[0]."' and UserID<>'".$arr_item[1]."'");
					foreach($data as $row){
						$param = array("MyID"=>$row["userid"],"YouID"=>$arr_item[2],"To_Type"=>2) ;
						$root = new Model("Clot_Silence");
						$root -> addParamWheres($param);
						$TypeID = $root -> getValue("TypeID");
						if((!$TypeID)||PastEtaEx($arr_item[4],$row["remark"])){
							//echo $row["userid"]."|".$FcName."|".$MessengText;
							$result=SendNotification($row["userid"],$FcName,$MessengText);
							if($result["status"]==1) $batch->add($result["message"], $result["target"]);
							elseif($result["status"]==2) array_push($array_jpush,$result["target"]);//添加元素
							elseif($result["status"]==3) array_push($array_huawei,$result["target"]);//添加元素
							elseif($result["status"]==4) array_push($array_xiaomi,$result["target"]);//添加元素
						}
					}
					if(!empty($array_jpush)) JPushDeviceListMultipleNotification($array_jpush,1,$FcName,$MessengText);
					if(!empty($array_huawei)) HuaweiPushDeviceListMultipleNotification($array_huawei,1,$FcName,$MessengText);
					if(!empty($array_xiaomi)) MiPushDeviceListMultipleNotification($array_xiaomi,1,$FcName,$MessengText);
					break ;
				case "3":
					$livechat = new LiveChat ();
					$user = array ();
					// create user
					$user ["userid"] = $arr_item[2];
					$user ["username"] = g ( "username", GetValue ( "BIGANTLIVE_USERNAME" ) );
					$user ["phone"] = g ( "phone" );
					$user ["email"] = g ( "email" );
					
					$user = $livechat->GetUser ( $user );
					$FcName = $user ["username"];
					$MessengText = $user ["username"].":".$arr_item[4];
					
					$param = array("MyID"=>$arr_item[0],"YouID"=>$arr_item[2],"To_Type"=>3) ;
					$root = new Model("Clot_Silence");
					$root -> addParamWheres($param);
					$TypeID = $root -> getValue("TypeID");
					if(!$TypeID){
						$result=SendNotification($arr_item[0],$FcName,$MessengText);
						if($result["status"]==1) $batch->add($result["message"], $result["target"]);
						elseif($result["status"]==2) JPushDeviceListSingleNotification($result["target"],1,$FcName,$MessengText,$result["tel1"]);//添加元素
						elseif($result["status"]==3) HuaweiPushSingleDeviceNotification($result["target"],1,$FcName,$MessengText);//添加元素
						elseif($result["status"]==4) MiPushSingleDeviceNotification($result["target"],1,$FcName,$MessengText);//添加元素	
					}
					break ;
				case "4":
				    $array_huawei = array();//定义数组
					$array_xiaomi = array();//定义数组
					$array_jpush = array();//定义数组
					$FcName = $arr_item[1];
					$MessengText = $FcName.":".$arr_item[4];
					$user_id = explode(",",$arr_item[0]);
					foreach($user_id as $id)
					{
						if ($id){
							$result=SendNotification($id,$FcName,$MessengText);
							if($result["status"]==1) $batch->add($result["message"], $result["target"]);
							elseif($result["status"]==2) array_push($array_jpush,$result["target"]);//添加元素
							elseif($result["status"]==3) array_push($array_huawei,$result["target"]);//添加元素
							elseif($result["status"]==4) array_push($array_xiaomi,$result["target"]);//添加元素
						}
					}
					if(!empty($array_jpush)) JPushDeviceListMultipleNotification($array_jpush,1,$FcName,$MessengText);
					if(!empty($array_huawei)) HuaweiPushDeviceListMultipleNotification($array_huawei,1,$FcName,$MessengText);
					if(!empty($array_xiaomi)) MiPushDeviceListMultipleNotification($array_xiaomi,1,$FcName,$MessengText);
					break ;
				case "6":
				    $array_huawei = array();//定义数组
					$array_xiaomi = array();//定义数组
					$array_jpush = array();//定义数组
					$param = array("UserID"=>$arr_item[1]) ;
					$param = array("UserID"=>$arr_item[1],"TypeID"=>$arr_item[2]) ;
					$root = new Model("lv_chater_Clot_Form");
					$root -> addParamWheres($param);
					$ClotFormName = $root -> getValue("remark");
					$param = array("TypeID"=>$arr_item[2]) ;
					$root = new Model("lv_chater_Clot_Ro");
					$root -> addParamWheres($param);
					$FcName = $root -> getValue("TypeName");
					$MessengText = $ClotFormName."(".$FcName."):".$arr_item[4];

					$db = new DB();
					//$data=$db -> executeDataTable("select * from lv_chater_Clot_Form where TypeID='".$arr_item[0]."' and UserID<>'".$arr_item[1]."'");
					$data=$db -> executeDataTable("select aa.*,bb.UserID as UID from lv_chater_Clot_Form as aa,Users_ID as bb where aa.TypeID='".$arr_item[0]."' and aa.UserID=bb.UserName and aa.UserID<>'".$arr_item[1]."'");
					foreach($data as $row){
						//echo $row["uid"].'<br>';
						$param = array("MyID"=>$row["uid"],"YouID"=>$arr_item[0],"To_Type"=>6) ;
						$root = new Model("Clot_Silence");
						$root -> addParamWheres($param);
						$TypeID = $root -> getValue("TypeID");
						if(!$TypeID){
							$result=SendNotification($row["uid"],$FcName,$MessengText);
							//echo $row["uid"].'<br>'.var_dump($result);
							if($result["status"]==1) $batch->add($result["message"], $result["target"]);
							elseif($result["status"]==2) array_push($array_jpush,$result["target"]);//添加元素
							elseif($result["status"]==3) array_push($array_huawei,$result["target"]);//添加元素
							elseif($result["status"]==4) array_push($array_xiaomi,$result["target"]);//添加元素
						}
					}
					if(!empty($array_jpush)) JPushDeviceListMultipleNotification($array_jpush,1,$FcName,$MessengText);
					if(!empty($array_huawei)) HuaweiPushDeviceListMultipleNotification($array_huawei,1,$FcName,$MessengText);
					if(!empty($array_xiaomi)) MiPushDeviceListMultipleNotification($array_xiaomi,1,$FcName,$MessengText);
					break ;
			}
		}
	}
    try {
        $rep = $batch->submit();
        var_dump($rep);
        echo("<br><br>");
    }catch(Exception $e){
        $rep=$batch->retry();
        var_dump($rep);
        echo ("<br><br>");
    }
}

function SendNotification($UserID,$FcName,$MessengText)
{
	$param = array("UserID"=>$UserID) ;
	$root = new Model("Users_ID");
	$root -> addParamWheres($param);
	$row = $root->getDetail ();
	$Registration_Id = $row['registration_id'];
	$PlatForm = $row['platform'];
	$ManuFacturer = $row['manufacturer'];
	$Tel1 = $row['tel1'];
	$Constellation = $row['constellation'];
	if($Registration_Id)
	{
	if($PlatForm=="1"){
		switch($ManuFacturer)
		{
			case "huawei":
				return array("target"=>$Registration_Id,"status"=>3);
			case "xiaomi":
				return array("target"=>$Registration_Id,"status"=>4);
			default:
				return array("target"=>$Registration_Id,"tel1"=>$Tel1,"status"=>2);
		}
	}elseif($PlatForm=="0"){
		$template = IGtNotificationTemplateDemo($Registration_Id,$PlatForm,$FcName,$MessengText);
		$message = new IGtSingleMessage();
		$message->set_isOffline(true);//是否离线
		$message->set_offlineExpireTime(12 * 1000 * 3600);//离线时间
		$message->set_data($template);//设置推送消息类型送
		$target = new IGtTarget();
		$target->set_appId(APPID);
		$target->set_clientId($Registration_Id);
		return array("message"=>$message,"target"=>$target,"status"=>1);
	}else return array("status"=>0);
	}else return array("status"=>0);
}

function smtp_mail ($sendto_email, $subject, $body, $user_name) {
//	$arr_id = explode(",",$send_email);
//	$arr_item = explode("@",$arr_id[0]);
	$mail = new PHPMailer();
	$mail->SMTPDebug = 1;			// 开启Debug
	$mail->IsSMTP();                // 使用SMTP模式发送新建
	$mail->Host = SMTPSERVER; // QQ企业邮箱SMTP服务器地址
	$mail->Port = SMTPPORT;  //邮件发送端口，一定是465
	$mail->SMTPAuth = true;         // 打开SMTP认证，本地搭建的也许不会需要这个参数
//	$mail->SMTPSecure = "ssl";		// 打开SSL加密，这一句一定要
	$mail->Username = SMTPACCOUNT;   // SMTP用户名  
	$mail->Password = SMTPPASSWORD;        // 为QQ邮箱SMTP的独立密码，即授权码
	$mail->From = SMTPACCOUNT;      // 发件人邮箱
	$mail->FromName =  "好奇鸟RTC";  // 发件人

	$mail->CharSet = "UTF-8";            // 这里指定字符集！
	$mail->Encoding = "base64";
	$mail->AddAddress($sendto_email,$user_name);  // 收件人邮箱和姓名
	//$mail->AddBCC("邮箱", "ff");
	//$mail->AddBCC("邮箱", "ff");这些可以暗送
	//$mail->AddReplyTo("test@jbxue.com","aaa.com");
	//$mail->WordWrap = 50; // set word wrap
	//$mail->AddAttachment("/qita/htestv2.rar"); // 附件
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");
	$mail->IsHTML(true);  // send as HTML
	// 邮件主题
	$mail->Subject = $subject;
	// 邮件内容
	/*
	$mail->Body = "   
		<html><head>
			<meta http-equiv=\"Content-Language\" content=\"zh-cn\">   
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=GB2312\">   
		</head>   
		<body>   
			你好，请链接将在24h内过期。请尽快验证您的邮箱~
		</body>   
		</html>   
		";  
		*/
$mail->Body =$body;
	$mail->AltBody ="text/html";
	if(!$mail->Send())
	{
		$error=$mail->ErrorInfo;
		/*if($error=="smtpnot")//自定义错误，没有连接到smtp，掉包的情况，出现这种情况可以重新发送
		 {
		sleep(2);
		$song=<a href="http://www.jbxue.com/shouce/php5/function.explode.html" target="_blank" class="infotextkey">explode</a>("@",$sendto_email);
		$img="<img height='0' width='0' src='http://www.jbxue.com/email.php?act=img&mail=".$sendto_email."&table=".$mail_table."' />";
		smtp_mail($sendto_email,"发送".$song[0].$biaoti, 'NULL', 'abc',$sendto_email,$host,$mailname,$mailpass,
				$img."发送".$song[0].$con,'$mail_table');//发送邮件
		}*/
		//$sql="insert into error(error_name,error_mail,error_smtp,error_time,error_table) values('$error','$sendto_email','$mailname',now(),'$mail_table')";
		//$query=<a href="http://www.jbxue.com/shouce/php5/function.mysql-query.html" target="_blank" class="infotextkey">mysql_query</a>($sql);//发送失败把错误记录保存下来
		return false;
	}else {
		return true;
	}
}

function getHttp($url = '')
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

	$output = curl_exec($ch);

	curl_close($ch);

	return $output;
}

function postHttp($url, $data = '')
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

	$output = curl_exec($ch);

	curl_close($ch);

	return $output;
}


//function HuaweiPushSingleDeviceNotification($CID,$PlatForm,$FcName,$UserText)
//{
//	$testPushMsgSample = new TestPushMsgCommon();
//	$testPushMsgSample->sendPushMsgMessageByMsgType(Constants::PUSHMSG_NOTIFICATION_MSG_TYPE);
//	
//	$message = '{
//		"notification": {
//			"title": "'.$FcName.'",
//			"body": "'.$UserText.'",
//			"image": "https://res.vmallres.com/pimages//common/config/logo/SXppnESYv4K11DBxDFc2.png"
//		},
//		"android": {
//			"category": "IM",
//			"notification": {
//				"click_action": {
//					"type": 3
//				}
//		
//			}
//		},
//		"token": ["'.$CID.'"]
//	}';
//	
//	$testPushMsgSample->sendPushMsgRealMessage(json_decode($message));
//}

?>

