<?php
require_once('../config/config.inc.php') ;
if (ISINSTALL){
	header("Location:../admin/account/login.html");
}else
	header("Location:../install/index.html");
?>