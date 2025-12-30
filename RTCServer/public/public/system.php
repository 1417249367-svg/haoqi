<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/Regedit.class.php");?>
<?php  require_once(__ROOT__ . "/class/ant/AntWebConfig.class.php");?>
<?php
/*
 * 设置系统的值
 * 2014-11-20
 */

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "set_companyname" :
		set_companyname ();
		break;
	case "set_language" :
		set_language ();
		break;
	case "bulid_app_value":
		bulidAppValue();
		break ;
	default :
		break;
}
function set_companyname() {
	Global $printer;
	
	$path = g ( "path", REG_PATH_SERVER );
	$keys = explode ( ",", "CompanyName" );
	$types = explode ( ",", "REG_SZ" );
	$values = explode ( ",", g ( "value" ) );
	
	$regedit = new Regedit ();
	$regedit -> set_batch ( $path, $keys, $values, $types );
	
	// rewrite config
	$webconfig = new AntWebConfig ();
	$webconfig-> init ();
	
	$printer->success ();
}

function set_language() {
	Global $printer;
	
	$lang = g ("lang","en");
	$config_content = file_get_contents(__ROOT__ . '/config/config.inc.php');
	$config_content = preg_replace('/(LANG_TYPE",[\'"])(.*?)([\'"])/','${1}'.$lang.'${3}',$config_content);  
	file_put_contents(__ROOT__ . '/config/config.inc.php',$config_content);
	
	$printer->success ();
}

?>