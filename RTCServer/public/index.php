<?php
require_once('config/config.inc.php') ;
if (ISINSTALL){
	//if($_SERVER['HTTP_HOST']=='xn--efv386c.com') header("Location:kefu.html?typeid=24");
	//header("Location:admin/account/login.html");
}else
	header("Location:install/index.html");

?>