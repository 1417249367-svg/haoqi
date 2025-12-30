<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\SDK\Sample;

use AlibabaCloud\SDK\Push\V20160801\Push;
use AlibabaCloud\Darabonba\Env\Env;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Console\Console;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Push\V20160801\Models\PushRequest;

class Sample {

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Push
     */
    public static function createClient($accessKeyId, $accessKeySecret){
        $config = new Config([]);
        // 您的AccessKey ID
        $config->accessKeyId = $accessKeyId;
        // 您的AccessKey Secret
        $config->accessKeySecret = $accessKeySecret;
        $config->regionId = "cn-hangzhou";
        return new Push($config);
    }
	
    /**
     * @param string[] $args
     * @return void
     */
    public static function main($deviceList,$PlatForm,$FcName,$UserText){

        $client = self::createClient("LTAI5tAGi9vWRVMQ6RLGpwBZ", "QMjWXQ1SIpTmFbG6P4T8N2cxJ98IJ4");
//        $request = new PushRequest([
//            "AppKey" => "335613771",
//            "PushType" => "MESSAGE",
//            "DeviceType" => "ANDROID",
//            "StoreOffline" => true,
//            "AndroidRemind" => "true",
//            "Target" => "DEVICE",
//            "TargetValue" => $deviceList,
//            "Title" => $FcName,
//            "Body" => $UserText,
//            "AndroidPopupTitle" => $FcName,
//            "AndroidPopupBody" => $UserText,
//            "AndroidNotificationChannel" => "143307",
//            "AndroidNotifyType" => "BOTH",
//            "AndroidOpenType" => "ACTIVITY",
//            "AndroidActivity" => "org.zywx.rtc.widgetone.uexbaidumap",
//            "AndroidPopupActivity" => "org.zywx.rtc.widgetone.uexbaidumap",
//            "AndroidNotificationHonorChannel" => "NORMAL",
//            "AndroidMessageOppoCategory" => "IM",
//            "AndroidMessageOppoNotifyLevel" => "2",
//            "AndroidMessageVivoCategory" => "IM",
//            "AndroidBadgeClass" => "org.zywx.rtc.widgetone.uexbaidumap",
//            "AndroidBadgeAddNum" => "1",
//            "AndroidMeizuNoticeMsgType" => "1"
//			
//        ]);
        $AndroidOppoPrivateTitleParameters="{\"my_title\":\"".$FcName."\"}";
		$AndroidOppoPrivateContentParameters="{\"my_content\":\"".$UserText."\"}";
//        $AndroidOppoPrivateTitleParameters=array("my_title"=>$FcName);
//		$AndroidOppoPrivateContentParameters=array("my_content"=>$UserText);
		$request = new PushRequest([
			"appKey" => 335613771,
			"pushType" => "MESSAGE",
			"deviceType" => "ANDROID",
			"target" => "DEVICE",
			"targetValue" => $deviceList,
			"storeOffline" => true,
			"title" => $FcName,
			"body" => $UserText,
			"androidNotifyType" => "BOTH",
			"androidRemind" => true,
			"androidOpenType" => "ACTIVITY",
			"androidActivity" => "com.uzmap.pkg.EntranceActivity",
			"androidPopupActivity" => "com.uzmap.pkg.EntranceActivity",
			"androidPopupTitle" => $FcName,
			"androidPopupBody" => $UserText,
			"androidNotificationChannel" => "143307",
			"androidNotificationHonorChannel" => "NORMAL",
			"androidMessageOppoCategory" => "IM",
			"androidMessageOppoNotifyLevel" => 2,
			"androidOppoPrivateMsgTemplateId" => "6904629165b94201399ec1c0",
			"androidOppoPrivateTitleParameters" => $AndroidOppoPrivateTitleParameters,
			"androidOppoPrivateContentParameters" => $AndroidOppoPrivateContentParameters,
			"androidMessageVivoCategory" => "IM",
			"androidVivoPushMode" => 0,
			"androidBadgeClass" => "org.zywx.rtc.widgetone.uexbaidumap",
			"androidBadgeAddNum" => 1,
			"androidMeizuNoticeMsgType" => 1
        ]);
        $response = $client->push($request);
        Console::log(Utils::toJSONString(Tea::merge($response->body)));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
	require_once $path;
}
function g($name, $defaultValue = "") {
	// php这里区分大小写，将两者都变为小写
	$_GET = array_change_key_case ( $_GET, CASE_LOWER );
	$name = strtolower ( $name );

	$v = isset ( $_GET [$name] ) ? $_GET [$name] : "";
	if ($v == "") {
		$_POST = array_change_key_case ( $_POST, CASE_LOWER );
		$v = isset ( $_POST [$name] ) ?$_POST [$name] : "";
	}

	if ($v == "")
		return $defaultValue;
	else
	{
		// 20141011 jc :  js_unescape($v)会引起 where ( col_subject like '%123%' ) 会变成 where ( col_subject like '%3%' )
		//$v =  js_unescape($v) ;
		$v = trim($v);
		return $v;
	}

}
Sample::main(g("deviceList"),g("PlatForm"),g("FcName"), g("UserText"));