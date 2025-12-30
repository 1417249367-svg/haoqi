<?php

/**
 * Push通知栏消息Demo
 * 本示例程序中的appId,appSecret,deviceTokens以及appPkgName需要用户自行替换为有效值
 */
require_once ('HuaweiPush.php');

//单个设备下发通知消息
function HuaweiPushSingleDeviceNotification($CID,$PlatForm,$FcName,$UserText)
{
	$HuaweiPush = new HuaweiPush('100047969', '21a2db5f5110e5e6f209debdf9337793'); // 用户在华为开发者联盟申请的appId和appSecret（会员中心->我的产品，点击产品对应的Push服务，点击“移动应用详情”获取）
	$accesstoken=ACCESSTOKEN;
	if (TOKENEXPIREDTIME <= time()) {
		$response = $HuaweiPush->RefreshToken();
		$accesstoken=$response['access_token'];
		
		$params = array();
		$params[] = array("name"=> "accesstoken","value"=> $accesstoken,"type"=> "PushConfig");
		array_push($params,array("name"=> "tokenexpiredtime","value"=> time() + $response['expires_in'],"type"=> "PushConfig"));
	//	echo var_dump($params);
	//	exit();
		$config = new SYSConfig ();
		$config -> setConfig($params);
	}
	
	$deviceTokens = array(); // 目标设备Token
	$deviceTokens[] = $CID;
	$body = $param = $action = $msg = $ext = $hps = $payload = array();
	
	// 仅通知栏消息需要设置标题和内容，透传消息key和value为用户自定义
	$body['title'] = $FcName; // 消息标题
	$body['content'] = $UserText; // 消息内容体
	$param['appPkgName'] = 'org.zywx.rtc.widgetone.uexbaidumap'; // 定义需要打开的appPkgName
	$action['type'] = 3; // 类型3为打开APP，其他行为请参考接口文档设置
	$action['param'] = $param; // 消息点击动作参数
	$msg['type'] = 3; // 3: 通知栏消息，异步透传消息请根据接口文档设置
	$msg['action'] = $action; // 消息点击动作
	$msg['body'] = $body; // 通知栏消息body内容
						  
	// 扩展信息，含BI消息统计，特定展示风格，消息折叠。
	$ext['biTag'] = 'Trump'; // 设置消息标签，如果带了这个标签，会在回执中推送给CP用于检测某种类型消息的到达率和状态
	$ext['icon'] = 'http://pic.qiantucdn.com/58pic/12/38/18/13758PIC4GV.jpg'; // 自定义推送消息在通知栏的图标,value为一个公网可以访问的URL
																			  
	// 华为PUSH消息总结构体
	$hps['msg'] = $msg;
	$hps['ext'] = $ext;
	$payload['hps'] = $hps;
	
	var_dump($HuaweiPush->SendPushMessage($accesstoken, $deviceTokens, $payload));
}

function HuaweiPushDeviceListMultipleNotification($deviceTokens,$PlatForm,$FcName,$UserText)
{
	$HuaweiPush = new HuaweiPush('100047969', '21a2db5f5110e5e6f209debdf9337793'); // 用户在华为开发者联盟申请的appId和appSecret（会员中心->我的产品，点击产品对应的Push服务，点击“移动应用详情”获取）
	$accesstoken=ACCESSTOKEN;
	if (TOKENEXPIREDTIME <= time()) {
		$response = $HuaweiPush->RefreshToken();
		$accesstoken=$response['access_token'];
		
		$params = array();
		$params[] = array("name"=> "accesstoken","value"=> $accesstoken,"type"=> "PushConfig");
		array_push($params,array("name"=> "tokenexpiredtime","value"=> time() + $response['expires_in'],"type"=> "PushConfig"));
	//	echo var_dump($params);
	//	exit();
		$config = new SYSConfig ();
		$config -> setConfig($params);
	}
	
	$body = $param = $action = $msg = $ext = $hps = $payload = array();
	
	// 仅通知栏消息需要设置标题和内容，透传消息key和value为用户自定义
	$body['title'] = $FcName; // 消息标题
	$body['content'] = $UserText; // 消息内容体
	$param['appPkgName'] = 'org.zywx.rtc.widgetone.uexbaidumap'; // 定义需要打开的appPkgName
	$action['type'] = 3; // 类型3为打开APP，其他行为请参考接口文档设置
	$action['param'] = $param; // 消息点击动作参数
	$msg['type'] = 3; // 3: 通知栏消息，异步透传消息请根据接口文档设置
	$msg['action'] = $action; // 消息点击动作
	$msg['body'] = $body; // 通知栏消息body内容
						  
	// 扩展信息，含BI消息统计，特定展示风格，消息折叠。
	$ext['biTag'] = 'Trump'; // 设置消息标签，如果带了这个标签，会在回执中推送给CP用于检测某种类型消息的到达率和状态
	$ext['icon'] = 'http://pic.qiantucdn.com/58pic/12/38/18/13758PIC4GV.jpg'; // 自定义推送消息在通知栏的图标,value为一个公网可以访问的URL
																			  
	// 华为PUSH消息总结构体
	$hps['msg'] = $msg;
	$hps['ext'] = $ext;
	$payload['hps'] = $hps;
	
	var_dump($HuaweiPush->SendPushMessage($accesstoken, $deviceTokens, $payload));
}