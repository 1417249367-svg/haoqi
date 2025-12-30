<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/Uploader.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "detail" :
		detail ();
		break;
	case "upload" :
		upload ();
		break;
	default :
		break;
}
function save() {
	Global $printer;
	Global $op;
	$client = new Model ( "ant_client" );

	$result = $client->autoSave ();

	if (! $result ["status"])
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	else
		$printer->success ();
}
function detail() {
	Global $printer;

	$client = new Model ( "ant_client" );
	$clientId = g ( "id", 0 );
	$client->field ( "*" );
	$client->addWhere ( "col_id=" . $clientId );
	$row_client = $client->getDetail ();

	$printer->out_detail ( $row_client );
}
function upload() {
	Global $printer;

	// upload
	foreach ( $_FILES as $file ) {
		$uploader = new Uploader ();
		$result = $uploader->upload ( $file, 0, "\\data\\client" );
	}

	$fso = new COM ( 'Scripting.FileSystemObject' );
	$result ['version'] = $fso->GetFileVersion ( $result ["factpath"] );
	// print
	$html = $printer->parseArray ( $result );

	$html = "<script language='javascript'>parent.uploadComplete(" . $html . ");</script>";

	recordLog ( $html );
	$printer->out_str ( $html );
}
?>