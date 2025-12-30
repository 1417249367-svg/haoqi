<?php  require_once("../class/fun.php");?>
<?php

//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))&&g ( "source" )=='kefu'){
//
//}else{
////header("Access-Control-Allow-Origin: *");
////header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//}
isPublicNet();
$file_path = js_unescape(g ( "file", "" ));
$file_name = substr ( $file_path, strrpos ( $file_path, "/" ) + 1 );
$extend_name = strtolower ( substr ( $file_path, strrpos ( $file_path, "." ) + 1 ) );

if (substr ( $file_path, 0, 1 ) == "/")
	$file_path = ".." . $file_path;
//	echo $file_path;
//	exit();
if (! file_exist ( $file_path )) {
	// 检查文件是否存在
	echo "文件找不到";
	exit ();
} else {
	ob_clean ();
	
	$file_path = iconv_str($file_path,"utf-8","gbk");   //不转码找不到文件
	$file_name = iconv_str($file_name,"utf-8","gbk");  //不转码文件名会乱码
	$file = fopen ( $file_path, "r" ); // 打开文件
	// 输入文件标签
	Header ( "Content-type: application/octet-stream" );
	Header ( "Accept-Ranges: bytes" );
	Header ( "Accept-Length: " . filesize ( $file_path ) );
	Header ( "Content-Disposition: attachment; filename=" . $file_name );
	// 输出文件内容
	echo fread ( $file, filesize ( $file_path ) );
	fclose ( $file );
	exit ();
}
?>
