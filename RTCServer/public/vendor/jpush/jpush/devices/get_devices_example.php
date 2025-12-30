<?php
require __DIR__ . '/../config.php';
$client->device()->updateMoblie($registration_id, '18682009780');
// 获取指定设备的 Mobile,Alias,Tags 等信息
$response = $client->device()->getDevices($registration_id);
print_r($response);