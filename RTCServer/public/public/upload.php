<?php  require_once("../class/fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/Uploader.class.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Group.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/Doc.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/imagefilter.class.php");?>
<?php

$printer = new Printer ();

isPublicNet();
$op = g ( "op" );
switch ($op) {
	case "upload" :
		upload ();
		break;
	case "group" :
		group ();
		break;
	case "logo" :
		logo ();
		break;
	case "banner" :
		banner ();
		break;
	case "pan" :
		pan ();
		break;
	case "ad" :
		ad ();
		break;
	case "delete" :
		delete ();
		break;
	case "screenhot" :
		upload_screenhot ();
		break;
	case "kefufile" :
		upload_kefufile ();
		break;
	case "kefufiles" :
		upload_kefufiles ();
		break;
	case "ckeditor" :
		ckeditor ();
		break;
	case "txt" :
		upload_txt ();
		break;
	default :
	    upload_file();
		break;
}

function upload() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function group() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file, g("autoFileName"), g("file_path"), g("file_name").".jpg"  );
	}
	$group = new Group ();
	$sql = "update Clot_Pic set pic=pic+1 where ClotID='". g("file_name") ."'";
	$group -> db -> execute($sql);
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function ckeditor() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload4 ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	$result["uploaded"] = 1 ;
	//$result["fileName"] = $result["filename"] ;
	$result["url"] = getRootPath()."/public/cloud.html?op=getfile&myid=livechat&label=msg&name=".$result["filepath"] ;
	// print
	$html = $printer->parseArray ( $result );
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function logo() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload3 ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ",'logo');</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function banner() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload3 ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
//	$group = new Group ();
//	$sql = "update OtherForm set logo=logo+1 where id=1";
//	$group -> db -> execute($sql);
//	
//	$file = __ROOT__ . str_replace("\\\\","/",(g("file_path"))) . g("file_name");
//	file_copy(__ROOT__ . g("file_path") . g("file_name"),__ROOT__ . "/Data/MyPic/" . g("file_name"));
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ",'banner');</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function pan() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload3 ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
//	$group = new Group ();
//	$sql = "update OtherForm set logo=logo+1 where id=1";
//	$group -> db -> execute($sql);
//	
//	$file = __ROOT__ . str_replace("\\\\","/",(g("file_path"))) . g("file_name");
//	file_copy(__ROOT__ . g("file_path") . g("file_name"),__ROOT__ . "/Data/MyPic/" . g("file_name"));
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ",'pan');</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

function ad() {
	Global $printer;
	
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload3 ( $file, g("autoFileName"), g("file_path"), g("file_name")  );
	}
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	$result = array_merge ( $result, $attr );
	$html = $printer->parseArray ( $result );
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ",'ad');</script>";
	recordLog ( $html );
	$printer->out_str ( $html );
}

function delete() {
	Global $printer;
	// 删除文件
//	$file = __ROOT__ . str_replace("\\\\","/",(g("file_path"))) . g("file_name");
	$file = __ROOT__ . g("file_path") . g("file_name");
//	echo format_path($file);
//	exit();
    file_delete($file);
//	if (file_exists ( $file ))
//		unlink ( $file );
	$printer->success ();
}

function upload_screenhot() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload1 ( $file );
	}
	
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$query = str_replace ( "---", "@", $query );
	
	$attr = $printer->str2array ( "&", "=", $query );
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$printer->out_str ( $html );
}

function upload_all() {
	$uploader = new Uploader ();
	$count = 0;
	foreach ( $_FILES as $file ) {
		$result = $uploader->upload ( $file );
		if ($result ["status"])
			$count += 1;
	}
	
	$printer->out_str ( $count );
}
function upload_file() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload2 ( $file, g("autoFileName"));
	}
	
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	
	//recordLog ( $html );
	$printer->out_str ( $html );
}

function upload_kefufile() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload2 ( $file, g("autoFileName") );
	}
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );

	//recordLog ( $html );
	$printer->out_str ( $html );
}

function upload_kefufiles() {
	Global $printer;
	
	// upload
	$kefufiles = array ();
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload2 ( $file, g("autoFileName") );
		array_push($kefufiles,$result);
	}
	// print
	$html = $printer->parseArray ( $kefufiles );
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	//recordLog ( $html );
	$printer->out_str ( $html );

}

function upload_txt() {
	Global $printer;
	
	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload5 ( $file, g("autoFileName"), g("file_path"), g("file_name"));
	}
	// query union
	$query = $_SERVER ['QUERY_STRING'];
	$attr = $printer->str2array ( "&", "=", $query );
	
	$result = array_merge ( $result, $attr );
	
	// print
	$html = $printer->parseArray ( $result );
	
	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";
	
	recordLog ( $html );
	$printer->out_str ( $html );
}

?>
