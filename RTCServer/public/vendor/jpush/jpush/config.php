<?php
require __DIR__ . '/../autoload.php';

use JPush\Client as JPush;

$app_key = "f505d88a3124aeb1acd68a20";
$master_secret = "b18c664d911d4541fbdee87a";
//$registration_id = "170976fa8ad89c4bb4b";

$client = new JPush($app_key, $master_secret);
