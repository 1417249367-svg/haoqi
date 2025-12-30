<?php
/**
 * API页面组件装配

 * @date    20140325
 */
require_once ("../class/fun.php");
require_once (__ROOT__ . "/class/hs/EmpRelation.class.php");
require_once (__ROOT__ . "/class/hs/Department.class.php");

$url = $_SERVER ["REQUEST_URI"];

// 登记参数
$data = $url;
foreach ( $_POST as $name => $value ) {
	$data .= "&" . $name . "=" . $value;
}
recordLog ( $data );


?>