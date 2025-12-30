<?php
// 这只是使用样例,不应该直接用于实际生产环境中 !!

require_once '';
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
	require_once $path;
}
use AlibabaCloud\SDK\Sample;
//require_once __DIR__ . \DIRECTORY_SEPARATOR . 'Sample.php';
//$Sample = new Sample();
//$response = $Sample->main('fe2fcefa432549e2bebdc28fd037c13c',1,'admin', 'admin:gh751ao');
Sample::main('fe2fcefa432549e2bebdc28fd037c13c',1,'admin', 'admin:gh751ao');

//JPushDeviceListSingleNotification('fe2fcefa432549e2bebdc28fd037c13c',1,'admin', 'admin:gh751ao','');
//function JPushDeviceListSingleNotification($deviceList,$PlatForm,$FcName,$UserText,$Tel)
//{
//$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
//
//if (file_exists($path)) {
//    require_once $path;
//}
//Sample::main($deviceList,$PlatForm,$FcName,$UserText);
//}
//
//function JPushDeviceListMultipleNotification($deviceList,$PlatForm,$FcName,$UserText)
//{
//$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'emasPush' . \DIRECTORY_SEPARATOR . 'autoload.php';
//if (file_exists($path)) {
//    require_once $path;
//}
//Sample::main($deviceList,$PlatForm,$FcName,$UserText);
//}
