<?php
require_once ("../class/fun.php");
require_once (__ROOT__ . "/class/ant/webconfig.class.php");

$arr = array ();
$arr ["DEBUG"] = 1;
$arr ["ISINSTALL"] = 1;

$config = new WebConfig();
$config->init ();
$config->setValue ( $arr );

header( "Location:../admin/account/login.html" );
?>

