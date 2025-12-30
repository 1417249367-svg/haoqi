<?php
require_once ("../class/fun.php");
require_once (__ROOT__ . "/class/ant/Register.class.php");

$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "get_info" :
		get_info ();
		break;
	case "activation" :
		activation ();
		break;
}
function get_info() {
	Global $printer;
	
	$reg = new Register ();
	
	// 得到激活码
	$activation_code = $reg->get_activation_code ();
	
	// 解析激活码
	$data = $reg->get_reginfo ( $activation_code );
	
	$printer->out_arr ( $data );
}
function activation() {
	Global $printer;
	
	$reg = new Register ();
	
	// 得到激活码
	$activation_code = g ( "code" );
	
	// 解析激活码
	$data = $reg->get_reginfo ( $activation_code );
	
	// 验证激活码
	$result = $reg->save_activation_code ( $activation_code );
	
	$printer->out_arr ( $result );
}
function check_reginfo($data) {
	if (! array_key_exists ( "machinecode", $data ))
		return 0;
	if (! array_key_exists ( "users", $data ))
		return 0;
	if ($data ["users"] == 0)
		return 0;
	
	return 1;
}

?>