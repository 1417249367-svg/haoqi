<?php

header("Content-Type: text/html; charset=utf-8");
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/class/fun.php");
require_once (__ROOT__ . "/vendor/phpmailer/class.phpmailer.php");
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/' . 'igetui/utils/AppConditions.php');

//http的域名
//define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//https的域名
//define('HOST','https://api.getui.com/apiex.htm');
               

//define('APPKEY','');
//define('APPID','');
//define('MASTERSECRET','');
//define('CID','');
//define('DEVICETOKEN','');
//define('Alias','请输入别名');

define('APPKEY','NXUfGqQLtE6hj0MAnRqt9A');
define('APPID','Z69LNWF6EPAI1oe6F5mbe8');
define('MASTERSECRET','hWiiuiS4im7zhrdZvhgxl1');
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
//define('CID',$_GET["registration_id"]);
define('DEVICETOKEN','');
//define('BigData',urldecode($_GET["bigdata"]));
//define('UserText',urldecode($_GET["UserText"]));
//define('FcName',urldecode($_GET["FcName"]));
//define('UserMessage',$_GET["uid"].':'.$_GET["category"].':'.urldecode($_GET["FcName"]));

//define('BEGINTIME','2015-03-06 13:18:00');
//define('ENDTIME','2015-03-06 13:24:00');

//getUserStatus();

//stoptask();

//setTag();

//getUserTags();

//pushMessageToSingle();

//pushMessageToSingleBatch();

//getPersonaTagsDemo();

//getUserCountByTagsDemo();

//pushMessageToList();

//pushMessageToApp();

//pushAPN();

//pushAPNL();

//getPushMessageResultDemo();



function getPersonaTagsDemo() {
    $igt = new IGeTui(HOST, APPKEY, MASTERSECRET);
    $ret = $igt->getPersonaTags(APPID);
    var_dump($ret);
}

function getUserCountByTagsDemo() {
	$igt = new IGeTui(HOST, APPKEY, MASTERSECRET);
    $tagList = array("金在中","龙卷风");
	$ret = $igt->getUserCountByTags(APPID, $tagList);
	var_dump($ret);
}

function getPushMessageResultDemo(){


//    putenv("gexin_default_domainurl=http://183.129.161.174:8006/apiex.htm");

    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);

    $ret = $igt->getPushResult("OSA-0522_QZ7nHpBlxF6vrxGaLb1FA3");
    var_dump($ret);

    $ret = $igt->queryAppUserDataByDate(APPID,"20140807");
    var_dump($ret);

    $ret = $igt->queryAppPushDataByDate(APPID,"20140807");
    var_dump($ret);
}

function pushAPN(){

    //APN简单推送
        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        $template = new IGtAPNTemplate();
        $apn = new IGtAPNPayload();
        $alertmsg=new SimpleAlertMsg();
        $alertmsg->alertMsg="";
        $apn->alertMsg=$alertmsg;
//        $apn->badge=2;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);
        $message = new IGtSingleMessage();

    //APN高级推送
//        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new DictionaryAlertMsg();
//        $alertmsg->body="body";
//        $alertmsg->actionLocKey="ActionLockey";
//        $alertmsg->locKey="LocKey";
//        $alertmsg->locArgs=array("locargs");
//        $alertmsg->launchImage="launchimage";
////        IOS8.2 支持
//        $alertmsg->title="Title";
//        $alertmsg->titleLocKey="TitleLocKey";
//        $alertmsg->titleLocArgs=array("TitleLocArg");
//
//        $apn->alertMsg=$alertmsg;
//        $apn->badge=7;
//        $apn->sound="test1.wav";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //PushApn老方式传参
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//    $template = new IGtAPNTemplate();
//    $template->set_pushInfo("actionLocKey", 6, "body", "", "payload", "locKey", "locArgs", "launchImage",1);
//    $message = new IGtSingleMessage();
////
//    $message->set_data($template);
   $ret = $igt->pushAPNMessageToSingle(APPID, DEVICETOKEN, $message);
    var_dump($ret);
}

function pushAPNL(){

    //APN简单推送
//        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new SimpleAlertMsg();
//        $alertmsg->alertMsg="";
//        $apn->alertMsg=$alertmsg;
////        $apn->badge=2;
////        $apn->sound="";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //APN高级推送
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $template = new IGtAPNTemplate();
    $apn = new IGtAPNPayload();
//        $alertmsg=new DictionaryAlertMsg();
//        $alertmsg->body="body";
//        $alertmsg->actionLocKey="ActionLockey";
//        $alertmsg->locKey="LocKey";
//        $alertmsg->locArgs=array("locargs");
//        $alertmsg->launchImage="launchimage";
////        IOS8.2 支持
//        $alertmsg->title="Title";
//        $alertmsg->titleLocKey="TitleLocKey";
//        $alertmsg->titleLocArgs=array("TitleLocArg");
//        $apn->alertMsg=$alertmsg;

//        $apn->badge=7;
//        $apn->sound="com.gexin.ios.silence";
    $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
    $template->set_apnInfo($apn);
    $message = new IGtSingleMessage();

    //PushApn老方式传参
//    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
//    $template = new IGtAPNTemplate();
//    $template->set_pushInfo("", 4, "", "", "", "", "", "");
//    $message = new IGtSingleMessage();

    //多个用户推送接口
    putenv("needDetails=true");
    $listmessage = new IGtListMessage();
    $listmessage->set_data($template);
    $contentId = $igt->getAPNContentId(APPID, $listmessage);
    //$deviceTokenList = array("3337de7aa297065657c087a041d28b3c90c9ed51bdc37c58e8d13ced523f5f5f");
    $deviceTokenList = array(DEVICETOKEN);
    $ret = $igt->pushAPNMessageToList(APPID, $contentId, $deviceTokenList);
    var_dump($ret);
}

//用户状态查询
function getUserStatus($CID) {
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $rep = $igt->getClientIdStatus(APPID,$CID);
    return $rep;
}

//推送任务停止
function stoptask(){

    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $igt->stop("OSA-1127_QYZyBzTPWz5ioFAixENzs3");
}

//通过服务端设置ClientId的标签
function setTag(){
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $tagList = array('','中文','English');
    $rep = $igt->setClientTag(APPID,CID,$tagList);
    var_dump($rep);
    echo ("<br><br>");
}

function getUserTags() {
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $rep = $igt->getUserTags(APPID,CID);
    //$rep.connect();
    var_dump($rep);
    echo ("<br><br>");
}

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

//
//服务端推送接口，支持三个接口推送
//1.PushMessageToSingle接口：支持对单个用户进行推送
//2.PushMessageToList接口：支持对多个用户进行推送，建议为50个用户
//3.pushMessageToApp接口：对单个应用下的所有用户进行推送，可根据省份，标签，机型过滤推送
//

//单推接口案例
function pushMessageToSingle(){
    //$igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $igt = new IGeTui(NULL,APPKEY,MASTERSECRET,false);

    //消息模版：
    // 1.TransmissionTemplate:透传功能模板
    // 2.LinkTemplate:通知打开链接功能模板
    // 3.NotificationTemplate：通知透传功能模板
    // 4.NotyPopLoadTemplate：通知弹框下载功能模板

//    	$template = IGtNotyPopLoadTemplateDemo();
//    	$template = IGtLinkTemplateDemo();
    	$template = IGtNotificationTemplateDemo();
//    $template = IGtTransmissionTemplateDemo();

    //个推信息体
    $message = new IGtSingleMessage();

    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600*12*1000);//离线时间
    $message->set_data($template);//设置推送消息类型
//	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
    //接收方
    $target = new IGtTarget();
    $target->set_appId(APPID);
    $target->set_clientId(CID);
//    $target->set_alias(Alias);


    try {
        $rep = $igt->pushMessageToSingle($message, $target);
        var_dump($rep);
        echo ("<br><br>");

    }catch(RequestException $e){
        $requstId =e.getRequestId();
        $rep = $igt->pushMessageToSingle($message, $target,$requstId);
        var_dump($rep);
        echo ("<br><br>");
    }

}

function pushMessageToSingleBatch()
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

					$param = array("MyID"=>$arr_item[0],"YouID"=>$arr_item[2]) ;
					$root = new Model("Clot_Silence");
					$root -> addParamWheres($param);
					$TypeID = $root -> getValue("TypeID");
					if(!$TypeID){
						$result=SendIGtNotification($arr_item[0],$FcName,$MessengText);
						if($result["status"]) $batch->add($result["message"], $result["target"]);
					}	
					break ;
				case "2":
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
						$param = array("MyID"=>$row["userid"],"YouID"=>$arr_item[2]) ;
						$root = new Model("Clot_Silence");
						$root -> addParamWheres($param);
						$TypeID = $root -> getValue("TypeID");
						if((!$TypeID)||PastEtaEx($arr_item[4],$row["remark"])){
							//echo $row["userid"]."|".$FcName."|".$MessengText;
							$result=SendIGtNotification($row["userid"],$FcName,$MessengText);
							if($result["status"]) $batch->add($result["message"], $result["target"]);	
						}
					}
					break ;
				case "3":
					$FcName = $arr_item[1];
					$MessengText = $FcName.":".$arr_item[4];
					$result=SendIGtNotification($arr_item[0],$FcName,$MessengText);
					if($result["status"]) $batch->add($result["message"], $result["target"]);	
					break ;
				case "4":
					$FcName = $arr_item[1];
					$MessengText = $FcName.":".$arr_item[4];
					$user_id = explode(",",$arr_item[0]);
					foreach($user_id as $id)
					{
						if ($id){
							$result=SendIGtNotification($id,$FcName,$MessengText);
							if($result["status"]) $batch->add($result["message"], $result["target"]);	
						}
					}
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

function SendIGtNotification($UserID,$FcName,$MessengText)
{
	$param = array("UserID"=>$UserID) ;
	$root = new Model("Users_ID");
	$root -> addParamWheres($param);
	$row = $root->getDetail ();
	$Registration_Id = $row['registration_id'];
	$PlatForm = $row['platform'];
	$Tel1 = $row['tel1'];
	$Constellation = $row['constellation'];
	if($Registration_Id)
	{
//		echo $Registration_Id;
//		exit();
	if($PlatForm=="1"){
		$rep=getUserStatus($Registration_Id);
//		echo var_dump($rep);
//		exit();
		if($rep['result']=="Offline"){
			if($Tel1){
//				$sql = "select * from Plug where Plug_Site = '12' and Plug_Enabled=1 order by Plug_Index desc";
//				$db = new DB();
//				$row =  $db -> executeDataRow($sql);
//				$Plug_Target = $row['plug_target'];
				
				if(SMS_URL&&SMS_PUSH){
					$Content = urlencode("您收到了一条用户发送的聊天信息,请即时登录触点通RTC进行回复.触点通RTC:www.haoqiniao.cn.");
	                $sms_url = str_replace("{mobile}",$Tel1,str_replace("{content}",$Content,SMS_URL));
					file_get_contents ( $sms_url );
//					$ch = curl_init();
//					$url = $Plug_Target;
//					curl_setopt($ch, CURLOPT_URL, $url); 
//					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
//					curl_exec($ch); 
//					curl_close ($ch); 
				}
			}
			if($Constellation){
//				$sql = "select * from Plug where Plug_Site='13' and Plug_Enabled=1 order by Plug_Index desc";
//				$db = new DB();
//				$row =  $db -> executeDataRow($sql);
//				$Plug_Target = $row['plug_target'];
				if(SMTPACCOUNT&&EMAIL_PUSH){
					smtp_mail ($Constellation, "[触点通RTC]您收到了一条用户发送的聊天信息", "尊敬的用户,您收到了一条用户发送的聊天信息,请即时登录触点通RTC进行回复.部分安卓手机系统会自行停止应用的运行，导致应用无法推送消息提醒。要正常地收到消息提醒，需要开启应用的保护，然后重启手机.触点通RTC:www.haoqiniao.cn.", "触点通RTC");
				}
			}
			return array("status"=>0);
		}else{
			$template = IGtNotificationTemplateDemo($Registration_Id,$PlatForm,$FcName,$MessengText);
			$message = new IGtSingleMessage();
			$message->set_isOffline(true);//是否离线
			$message->set_offlineExpireTime(12 * 1000 * 3600);//离线时间
			$message->set_data($template);//设置推送消息类型送
			$target = new IGtTarget();
			$target->set_appId(APPID);
			$target->set_clientId($Registration_Id);
			return array("message"=>$message,"target"=>$target,"status"=>1);
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
	$mail->FromName =  "触点通RTC";  // 发件人

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

//多推接口案例
function pushMessageToList()
{
    putenv("gexin_pushList_needDetails=true");
    putenv("gexin_pushList_needAsync=true");

    $igt = new IGeTui(HOST, APPKEY, MASTERSECRET);
    //消息模版：
    // 1.TransmissionTemplate:透传功能模板
    // 2.LinkTemplate:通知打开链接功能模板
    // 3.NotificationTemplate：通知透传功能模板
    // 4.NotyPopLoadTemplate：通知弹框下载功能模板


    //$template = IGtNotyPopLoadTemplateDemo();
    //$template = IGtLinkTemplateDemo();
    //$template = IGtNotificationTemplateDemo();
    $template = IGtTransmissionTemplateDemo();
    //个推信息体
    $message = new IGtListMessage();
    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
    $message->set_data($template);//设置推送消息类型
//    $message->set_PushNetWorkType(1);	//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
//    $contentId = $igt->getContentId($message);
    $contentId = $igt->getContentId($message,"toList任务别名功能");	//根据TaskId设置组名，支持下划线，中文，英文，数字

    //接收方1
    $target1 = new IGtTarget();
    $target1->set_appId(APPID);
    $target1->set_clientId(CID);
//    $target1->set_alias(Alias);

    $targetList[] = $target1;

    $rep = $igt->pushMessageToList($contentId, $targetList);

    var_dump($rep);

    echo ("<br><br>");

}

//群推接口案例
function pushMessageToApp(){
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $template = IGtTransmissionTemplateDemo();
    //$template = IGtLinkTemplateDemo();
    //个推信息体
    //基于应用消息体
    $message = new IGtAppMessage();
    $message->set_isOffline(true);
    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    $message->set_data($template);

    $appIdList=array(APPID);
    $phoneTypeList=array('ANDROID');
    $provinceList=array('浙江');
    $tagList=array('haha');
    //用户属性
    //$age = array("0000", "0010");


    //$cdt = new AppConditions();
   // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
   // $cdt->addCondition(AppConditions::REGION, $provinceList);
    //$cdt->addCondition(AppConditions::TAG, $tagList);
    //$cdt->addCondition("age", $age);

    $message->set_appIdList($appIdList);
    //$message->set_conditions($cdt->getCondition());

    $rep = $igt->pushMessageToApp($message,"任务组名");

    var_dump($rep);
    echo ("<br><br>");
}

//所有推送接口均支持四个消息模板，依次为通知弹框下载模板，通知链接模板，通知透传模板，透传模板
//注：IOS离线推送需通过APN进行转发，需填写pushInfo字段，目前仅不支持通知弹框下载功能

function IGtNotyPopLoadTemplateDemo(){
    $template =  new IGtNotyPopLoadTemplate();

    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    //通知栏
    $template ->set_notyTitle("个推");//通知栏标题
    $template ->set_notyContent("个推最新版点击下载");//通知栏内容
    $template ->set_notyIcon("");//通知栏logo
    $template ->set_isBelled(true);//是否响铃
    $template ->set_isVibrationed(true);//是否震动
    $template ->set_isCleared(true);//通知栏是否可清除
    //弹框
    $template ->set_popTitle("弹框标题");//弹框标题
    $template ->set_popContent("弹框内容");//弹框内容
    $template ->set_popImage("");//弹框图片
    $template ->set_popButton1("下载");//左键
    $template ->set_popButton2("取消");//右键
    //下载
    $template ->set_loadIcon("");//弹框图片
    $template ->set_loadTitle("地震速报下载");
    $template ->set_loadUrl("http://dizhensubao.igexin.com/dl/com.ceic.apk");
    $template ->set_isAutoInstall(false);
    $template ->set_isActived(true);
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息

    return $template;
}

function IGtLinkTemplateDemo(){
    $template =  new IGtLinkTemplate();
    $template ->set_appId(APPID);//应用appid
    $template ->set_appkey(APPKEY);//应用appkey
    $template ->set_title("请输入通知标题");//通知栏标题
    $template ->set_text("请输入通知内容");//通知栏内容
    $template ->set_logo("");//通知栏logo
    $template ->set_isRing(true);//是否响铃
    $template ->set_isVibrate(true);//是否震动
    $template ->set_isClearable(true);//通知栏是否可清除
    $template ->set_url("http://www.igetui.com/");//打开连接地址
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //iOS推送需要设置的pushInfo字段
//        $apn = new IGtAPNPayload();
//        $apn->alertMsg = "alertMsg";
//        $apn->badge = 11;
//        $apn->actionLocKey = "启动";
//    //        $apn->category = "ACTIONABLE";
//    //        $apn->contentAvailable = 1;
//        $apn->locKey = "通知栏内容";
//        $apn->title = "通知栏标题";
//        $apn->titleLocArgs = array("titleLocArgs");
//        $apn->titleLocKey = "通知栏标题";
//        $apn->body = "body";
//        $apn->customMsg = array("payload"=>"payload");
//        $apn->launchImage = "launchImage";
//        $apn->locArgs = array("locArgs");
//
//        $apn->sound=("test1.wav");;
//        $template->set_apnInfo($apn);
    return $template;
}

function IGtNotificationTemplateDemo($CID,$PlatForm,$FcName,$UserText){
	if($PlatForm==1){
		$template =  new IGtNotificationTemplate();
		$template->set_appId(APPID);//应用appid
		$template->set_appkey(APPKEY);//应用appkey
		$template->set_transmissionType(1);//透传消息类型
		$template->set_transmissionContent("");//透传内容
		$template->set_title($FcName);//通知栏标题
		$template->set_text($UserText);//通知栏内容
		$template->set_logo("icon.png");//通知栏logo
		$template->set_isRing(true);//是否响铃
		$template->set_isVibrate(true);//是否震动
		$template->set_isClearable(true);//通知栏是否可清除
	}else{
		$template =  new IGtTransmissionTemplate();
		$template->set_appId(APPID);//应用appid
		$template->set_appkey(APPKEY);//应用appkey
		$template->set_transmissionType(1);//透传消息类型
		$template->set_transmissionContent("");//透传内容
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //iOS推送需要设置的pushInfo字段
//        $apn = new IGtAPNPayload();
//        $apn->alertMsg = "alertMsg";
//        $apn->badge = 11;
//        $apn->actionLocKey = "启动";
//    //        $apn->category = "ACTIONABLE";
//    //        $apn->contentAvailable = 1;
//        $apn->locKey = "通知栏内容";
//        $apn->title = "通知栏标题";
//        $apn->titleLocArgs = array("titleLocArgs");
//        $apn->titleLocKey = "通知栏标题";
//        $apn->body = "body";
//        $apn->customMsg = array("payload"=>"payload");
//        $apn->launchImage = "launchImage";
//        $apn->locArgs = array("locArgs");
//
//        $apn->sound=("test1.wav");;
//        $template->set_apnInfo($apn);
		$apn = new IGtAPNPayload();
		$alertmsg=new DictionaryAlertMsg();
		$alertmsg->body=">>";
		$alertmsg->actionLocKey="查看";
		$alertmsg->locKey=$UserText;
		$alertmsg->locArgs=array("locargs");
		$alertmsg->launchImage="launchimage";
	//        IOS8.2 支持
		$alertmsg->title=$UserText;
		$alertmsg->titleLocKey=$FcName;
		$alertmsg->titleLocArgs=array("TitleLocArg");
	
		$apn->alertMsg=$alertmsg;
		$apn->badge=1;
		$apn->sound="";
		$apn->add_customMsg("payload","payload");
		$apn->contentAvailable=1;
		$apn->category="ACTIONABLE";
		$template->set_apnInfo($apn);
	}
    return $template;
}

function IGtTransmissionTemplateDemo(){
    $template =  new IGtTransmissionTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(1);//透传消息类型
    $template->set_transmissionContent("测试离线ddd");//透传内容
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    //APN简单推送
//        $template = new IGtAPNTemplate();
//        $apn = new IGtAPNPayload();
//        $alertmsg=new SimpleAlertMsg();
//        $alertmsg->alertMsg="";
//        $apn->alertMsg=$alertmsg;
////        $apn->badge=2;
////        $apn->sound="";
//        $apn->add_customMsg("payload","payload");
//        $apn->contentAvailable=1;
//        $apn->category="ACTIONABLE";
//        $template->set_apnInfo($apn);
//        $message = new IGtSingleMessage();

    //APN高级推送
    $apn = new IGtAPNPayload();
    $alertmsg=new DictionaryAlertMsg();
    $alertmsg->body="body";
    $alertmsg->actionLocKey="ActionLockey";
    $alertmsg->locKey="LocKey";
    $alertmsg->locArgs=array("locargs");
    $alertmsg->launchImage="launchimage";
//        IOS8.2 支持
    $alertmsg->title="Title";
    $alertmsg->titleLocKey="TitleLocKey";
    $alertmsg->titleLocArgs=array("TitleLocArg");

    $apn->alertMsg=$alertmsg;
    $apn->badge=7;
    $apn->sound="";
    $apn->add_customMsg("payload","payload");
    $apn->contentAvailable=1;
    $apn->category="ACTIONABLE";
    $template->set_apnInfo($apn);

    //PushApn老方式传参
//    $template = new IGtAPNTemplate();
//          $template->set_pushInfo("", 10, "", "com.gexin.ios.silence", "", "", "", "");

    return $template;
}



?>

