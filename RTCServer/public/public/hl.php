<?php
require_once ("fun.php");
require_once (__ROOT__ . "/class/ant/SysConfig.class.php");

$op = g ( "op" );

$printer = new Printer ();

switch ($op) {
	case "valid_password" :
		valid_password ();
		break;
	case "get_server" :
		get_server ();
		break;
	case "set_server" :
		set_server ();
		break;
}

// ================================================================
// 验证互联密码
// ================================================================
function valid_password() {
	Global $printer;

	$server_name = g ( "server" );
	$server_port = g ( "port", "8181" );

	$domain = g ( "domain" );
	$password = MyMD5 ( g ( "password" ) );

	$url = "http://" . $server_name . ":" . $server_port . "/checkcon?Cid=" . $domain . "&Key=" . $password;

	error_reporting ( 0 );
	$content = $content = file_get_contents ( $url );

	if ($content == "1")
		$printer->success ();
	else if ($content == "")
		$printer->fail ( "连接失败" );
	else
		$printer->fail ( "连接密码错误" );
}

// ================================================================
// 得到互联服务器信息
// ================================================================
function get_server() {
	Global $printer;

	$result = array (
					"password" => "",
					"centerserver_ip" => "",
					"centerserver_port" => "",
					"fileserver_ip" => "",
					"fileserver_port" => "",
					"avserver_ip" => "",
					"avserver_port" => ""
	);

	$config = new SYSConfig ();
	$data = $config->listByGenre ();

	foreach ( $data as $row ) {
		$name = strtolower ( $row ["col_name"] );
		$value = $row ["col_data"];
		switch ($name) {
			case "cspwd" :
				$result ["password"] = DBPwdDecrypt ( $value, KEY_HL );
				break;

			case "csaddr" :
				$result ["centerserver_ip"] = $value;
				break;
			case "csaddrport" :
				$result ["centerserver_port"] = $value;
				break;

			case "centerfileserveraddr" :
				$result ["fileserver_ip"] = $value;
				break;
			case "centerfileserverport" :
				$result ["fileserver_port"] = $value;
				break;

			case "centeravserveraddr" :
				$result ["avserver_ip"] = $value;
				break;
			case "centeravserverport" :
				$result ["avserver_port"] = $value;
				break;
		}
	}

	$printer->out_arr ( $result );
}

// ================================================================
// 保存互联服务器信息
// ================================================================
function set_server() {
	Global $printer;

	$result = array (
					"status" => "1",
					"msg" => ""
	);

	$config = new SYSConfig ();
	$config->set ( "CenterServerInfo", "CSPWD", DBPwdEncrypt ( g ( "password" ), KEY_HL ) );
	$config->set ( "CenterServerInfo", "CSAddr", g ( "centerserver_ip" ) );
	$config->set ( "CenterServerInfo", "CSAddrPort", g ( "centerserver_port" ) );


	$printer->out_arr ( $result );
}

?>