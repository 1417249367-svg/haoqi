<?php
require_once ("fun.php");
require_once('../../class/im/MsgReader.class.php');
require_once('../../class/im/wx.class.php');
require_once('../../class/lv/LiveChat.class.php') ;
require_once('../../class/common/visitorInfo.class.php') ;
require_once('redis.php');

//session_start();


$act = isset($_GET['act']) ? $_GET['act'] : 'list';
switch ($act) {
    case 'SendMobanMessage':
        SendMobanMessage();
        break;
		
//    case 'list':
//        return $wx->getList();
//        break;

    case 'SendSubscribeMessage':
        SendSubscribeMessage();
        break;
		
    case 'SendSubscribeMessage1':
        SendSubscribeMessage1();
        break;
    
    default:
        # code...
        break;
}

function SendMobanMessage()
{
	//session_start();                //启动session
	$wx  = new WXClass();
	if (isset($_GET['code'])) {     //判断是否有code传过来，如果没有调用函数请求code
		$res = $wx->GetAccess_Token($_GET['code']);     //使用code获取access_token和openid

		if ($wx->CkeckAccessToken($res['access_token'], $res['openid']) == 0) {     //判断access_token是否有效，如果无效获取新的access_token
			  $res = $wx->GetRefresh_Token($res['refresh_token']);                    //或缺新的access_token
		}

		 $userinfo = $wx->Get_User_Info($res['access_token'], $res['openid']);        //获取用户信息

		$livechat = new LiveChat ();
		$user = array ();
		$result = array ();
	
		// create user
		$user ["isweixin"] = 1;
		$user ["userid"] = $userinfo['openid'];
		$user ["username"] = $userinfo['nickname'];
		$user ["sex"] = $userinfo['sex'];
		$user ["language"] = $userinfo['language'];
		$user ["city"] = $userinfo['city'];
		$user ["province"] = $userinfo['province'];
		$user ["country"] = $userinfo['country'];
		$user ["headimgurl"] = $userinfo['headimgurl'];
		$user ["privilege"] = $userinfo['privilege'];
		
//			 echo var_dump($userinfo);
//			 exit; 
		$user = $livechat->GetUser ( $user );

		 //$_SESSION['userinfo'] = $userinfo;                                      //将用户信息存入session中
		 $next_url = RTC_SERVER_AGENT.g("redirect_uri").(strpos(g("redirect_uri"),"?")?'&':'?').'userid='.$user ["userid"];
		                          //下一个页面地址
//			 echo $next_url;
//			 exit; 
		 header("location:" . $next_url);                                       //获取到信息后跳转到其他页面
		 exit;
	} else {
	$wx->Get_Code();
	}
}

function SendSubscribeMessage()
{
	$wx  = new WXClass();
	if (isset($_GET['code'])) {     //判断是否有code传过来，如果没有调用函数请求code
		$res = $wx->GetAccess_Token($_GET['code']);     //使用code获取access_token和openid

		if ($wx->CkeckAccessToken($res['access_token'], $res['openid']) == 0) {     //判断access_token是否有效，如果无效获取新的access_token
			  $res = $wx->GetRefresh_Token($res['refresh_token']);                    //或缺新的access_token
		}

		 $userinfo = $wx->Get_User_Info($res['access_token'], $res['openid']);        //获取用户信息

		$livechat = new LiveChat ();
		$user = array ();
		$result = array ();
	
		// create user
		$user ["isweixin"] = 1;
		$user ["userid"] = $userinfo['openid'];
		$user ["username"] = $userinfo['nickname'];
		$user ["sex"] = $userinfo['sex'];
		$user ["language"] = $userinfo['language'];
		$user ["city"] = $userinfo['city'];
		$user ["province"] = $userinfo['province'];
		$user ["country"] = $userinfo['country'];
		$user ["headimgurl"] = $userinfo['headimgurl'];
		$user ["privilege"] = $userinfo['privilege'];
		
		$user = $livechat->GetUser ( $user );
		
		$wx->getSubscribemsg($userinfo['openid']);

	} else {
	$wx->Get_Code();
	}
	
	
//	$wx  = new WXClass();
//	if (isset($_GET['action'])) {     //判断是否有code传过来，如果没有调用函数请求code
//		if($_GET['action']=='confirm'){
//	
//			$livechat = new LiveChat ();
//			$user = array ();
//			$result = array ();
//		
//			// create user
//			$user ["isweixin"] = 1;
//			$user ["userid"] = $_GET['openid'];
//			
//			$user = $livechat->GetUser ( $user );
//	
//		   $next_url = RTC_SERVER_AGENT.g("redirect_uri").(strpos(g("redirect_uri"),"?")?'&':'?').'userid='.$user ["userid"];
//		   header("location:" . $next_url);
//		   exit;
//		}else{
//			
//		}
//	} else {
//	  $wx->getSubscribemsg1();
//	}
}

function SendSubscribeMessage1()
{
//	 $wx  = new WXClass();
//	 $wx->sendSubscribemsg('lijie',g("openid"), 'fadf');
	 $next_url = RTC_SERVER_AGENT.g("redirect_uri").(strpos(g("redirect_uri"),"?")?'&':'?').'userid='.g("openid");
	 header("location:" . $next_url);
	 exit;
}