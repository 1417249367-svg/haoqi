<?php
use xmpush\Builder;
use xmpush\HttpBase;
use xmpush\Sender;
use xmpush\Constants;
use xmpush\Stats;
use xmpush\Tracer;
use xmpush\Feedback;
use xmpush\DevTools;
use xmpush\Subscription;
use xmpush\TargetedMessage;
use xmpush\Region;

include_once(dirname(__FILE__) . '/autoload.php');

$secret = '692DGH9G1AW0FMZ1spPqlQ==';
$package = 'org.zywx.rtc.widgetone.uexbaidumap';

// 常量设置必须在new Sender()方法之前调用
Constants::setPackage($package);
Constants::setSecret($secret);

$payload = '{"test":1,"ok":"It\'s a string"}';
//MiPushSingleDeviceNotification('PWSmeAH3l2l2Eg2uuDd3zzgJ8Ej38ET0vlw/8kkBADr0KFBldjtSFY+YyVMcO8',1,'admin','admin:好得');
function MiPushSingleDeviceNotification($CID,$PlatForm,$FcName,$UserText)
{
$sender = new Sender();
$sender->setRegion(Region::China);// 支持海外

// message1 演示自定义的点击行为
$message1 = new Builder();
$message1->title($FcName);  // 通知栏的title
$message1->description($UserText); // 通知栏的descption
$message1->passThrough(0);  // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
$message1->payload($payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
$message1->extra(Constants.EXTRA_PARAM_NOTIFY_EFFECT, Constants.NOTIFY_LAUNCHER_ACTIVITY); // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
$message1->notifyId(2); // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
$message1->build();
// 打印返回结果
print_r($sender->send($message1, $CID)->getRaw());
}

function MiPushDeviceListMultipleNotification($deviceList,$PlatForm,$FcName,$UserText)
{
$sender = new Sender();
$sender->setRegion(Region::China);// 支持海外

// message1 演示自定义的点击行为
$message1 = new Builder();
$message1->title($FcName);  // 通知栏的title
$message1->description($UserText); // 通知栏的descption
$message1->passThrough(0);  // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
$message1->payload($payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
$message1->extra(Constants.EXTRA_PARAM_NOTIFY_EFFECT, Constants.NOTIFY_LAUNCHER_ACTIVITY); // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
$message1->notifyId(2); // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
$message1->build();

// 打印返回结果
print_r($sender->sendToIds($message1, $deviceList)->getRaw());
}
?>
