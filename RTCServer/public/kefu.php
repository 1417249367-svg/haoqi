<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once(__ROOT__ . "/class/fun.php");
require_once(__ROOT__ . "/class/im/MsgReader.class.php");
require_once(__ROOT__ . "/class/im/wx.class.php");
require_once(__ROOT__ . "/class/lv/LiveChat.class.php") ;
require_once(__ROOT__ . "/class/common/visitorInfo.class.php") ;
$userId = getValue("BIGANTLIVE_USERID"); //是否注册过
$status = g("status"); //客服是否在线
$query =  "?" . $_SERVER['QUERY_STRING'];

$op = g("act") ;
switch($op)
{
	case "SendSubscribeMessage1":
		SendSubscribeMessage1();
		break ;
}

if(WEIXINTYPE){
	if ((!isWeixin())&&(!isMiniProgram())){
		echo '<h1 align="center">请从从微信打开!如需解除入口限制请联系管理员</h1>';
		exit();
	}
}
$config = new SYSConfig();
$params = array();
if(SWITCHDOMAINTYPE){
	if((int)getAppValue("jump_domain")==1){
		$db = new Model ( "lv_chater_domain", "TypeID" );
		$db->addParamWhere("Status",1,"=","int") ;
		$row = $db->getDetail ();
		$db1 = new DB();
		$sql = "select top 1 * from lv_chater_domain where TypeID >".$row ["typeid"]." order by TypeID";
		$row1 = $db1->executeDataRow($sql);
		if (count($row1)) $db->swap ( "Status", $row ["typeid"], 1, $row1 ["typeid"], 0 );
		$params[] = $config->create_param("Jump_Domain",0,"LivechatConfig");
	}else $params[] = $config->create_param("Jump_Domain",1,"LivechatConfig");
}
if(!Jump_RTCServer_IP){
	//$params = array();
	$params[] = $config->create_param("Jump_RTCServer_IP",RTC_SERVER_AGENT);
	//$config -> setConfig($params);
}
$config -> setConfig($params);

//测试
//header("Location:index.html" . $query); 

//if(g ( "typeid" )==38){
//	header("Location:https://www.jkopaykefu.cyou/livechat/getjs/kefu.html" . $query); 
//	exit();
//}

if (ismobile())
{
//if(g("username")){
//	 header("Location:http://z.cdtim.cn:98/kefu.html"); 
//	 exit();
//}
	if (SWITCHWECHAT&&isWeixin()){
		$wx  = new WXClass();
		if(isMiniProgram()){
			if(WECHAT_DOMAIN1){
				$accessToken = $wx->getAccessToken1();
				//print_r(g("userid").'|'.g("nickname").'|'.g("mobile").'|'.g("avatar").'|'.g("weixin_openid"));
				//echo var_dump(json_decode(g("user"))).'<br>';
				//echo json_decode(var_dump(g("user"))).'<br>';
				//echo json_decode(g("user")).'<br>';
				//exit();
	//			if ($wx->CkeckAccessToken($accessToken, g("userid")) == 0) {     //判断access_token是否有效，如果无效获取新的access_token
	//				  $res = $wx->GetRefresh_Token($accessToken);                    //或缺新的access_token
	//				  $accessToken=$res['access_token'];
	//			}
				lv_user_getDetail($accessToken, g("userid"));
			}else
				header("Location:".Jump_RTCServer_IP."/livechat/getjs/kefu_miniprogram.html" . $query); 
		}else{
			if(WECHAT_TOKEN){
				if (isset($_GET['code'])) {     //判断是否有code传过来，如果没有调用函数请求code
					$res = $wx->GetAccess_Token($_GET['code']);     //使用code获取access_token和openid
			
					if ($wx->CkeckAccessToken($res['access_token'], $res['openid']) == 0) {     //判断access_token是否有效，如果无效获取新的access_token
						  $res = $wx->GetRefresh_Token($res['refresh_token']);                    //或缺新的access_token
					}
					lv_user_getDetail($res['access_token'], $res['openid']);
				} else {
					$wx->Get_Code();
				}
			}else
				header("Location:".Jump_RTCServer_IP."/livechat/getjs/kefu.html" . $query); 
		}
	}else if (isMiniProgram()){
//		echo "livechat/getjs/kefu_miniprogram.html" . g("userid");
//		exit();
		 header("Location:".Jump_RTCServer_IP."/livechat/getjs/kefu_miniprogram.html" . $query); 
	}else header("Location:".Jump_RTCServer_IP."/livechat/getjs/kefu.html" . $query); 
}
else
	header("Location:".Jump_RTCServer_IP."/livechat/getjs/kefu.html" . $query); 

function SendSubscribeMessage1()
{
	 $next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu.html?' . $_SERVER['QUERY_STRING'] . '&userid='.g("openid");
//	 echo $next_url;
//	 exit();
	 header("location:" . $next_url);
	 exit;
}	

function lv_user_getDetail($accessToken,$openid)
{
	$query =  "?" . $_SERVER['QUERY_STRING'];
	$db = new Model("lv_user");
	$db -> clearParam();
	$db -> addParamWhere("userid",$openid);
	$detail =  $db -> getDetail() ;
		
	$wx  = new WXClass();
	$livechat = new LiveChat ();
	$moban = g("moban");
	if (count($detail) == 0)
	{
		 if(isMiniProgram()){
			// create user
			$user ["cookieHCID7"] = 1;
			$user ["isweixin"] = 1;
			$user ["subscribe"] = 0;
			$user ["userid"] = $openid;
			$user ["username"] = g("nickname");
			$user ["headimgurl"] = g("avatar");
			$detail = $livechat -> CreateUser($user);
		 }else{
			$userinfo = $wx->Get_User_Info($accessToken, $openid);        //获取用户信息
			$userinfo1 = $wx->Get_User_Subscribe($openid);
	
			$user = array ();
			$result = array ();
		
			 if(empty($userinfo1['subscribe'])){
				 if(empty($moban)) $subscribe=0;
				 else $subscribe=1;
			 }else $subscribe=$userinfo1['subscribe'];
			 
	
			// create user
			$user ["cookieHCID7"] = 0;
			$user ["isweixin"] = 1;
			$user ["subscribe"] = $subscribe;
			$user ["userid"] = $userinfo['openid'];
			$user ["username"] = $userinfo['nickname'];
			$user ["sex"] = $userinfo['sex'];
			$user ["language"] = $userinfo['language'];
			$user ["city"] = $userinfo['city'];
			$user ["province"] = $userinfo['province'];
			$user ["country"] = $userinfo['country'];
			$user ["headimgurl"] = $userinfo['headimgurl'];
			$user ["privilege"] = $userinfo['privilege'];
			$detail = $livechat -> CreateUser($user);
		 }
	}else{
//		 if(empty($moban)) $subscribe=0;
//		 else $subscribe=1;
		 if($moban){
			$subscribe=1;
			$detail['subscribe']=$subscribe;
			$livechat -> setSubscribe ( $openid, $subscribe );
		 }
	}
//			echo var_dump($res);
//			echo var_dump($userinfo);
//			echo var_dump($userinfo1);
//			echo var_dump($user);
//			echo var_dump($detail);
//			exit();

	if($detail['subscribe']==1){
	   $next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu.html'. $query . '&userid='.$openid;
	}else{
		if(isMiniProgram()) $next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu_miniprogram.html'. $query . '&userid='.$openid;
		else{
			switch((int)WECHAT_SUBSCRIBE)
			{
				case 0:
					//if(WECHAT_GROUPID) $next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu_miniprogram.html'. $query . '&userid='.$openid;
					//else 
					$wx->getSubscribemsg($openid);
					break ;
				case 1:
					$next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu_subscribe.html'. $query . '&userid='.$openid;
					break ;
				case 2:
					$next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu.html'. $query . '&userid='.$openid;
					break ;
			}
		}
//			   if(WECHAT_SUBSCRIBE) $next_url = Jump_RTCServer_IP.'/livechat/getjs/kefu_subscribe.html'. $query . '&userid='.$res['openid'];
//			   else $wx->getSubscribemsg($res['openid']);
	}
//	echo $next_url;
//	exit();
   header("location:" . $next_url);
   exit;
}	
?>
