<?php  require_once("fun.php");?>

<?php  require_once(__ROOT__ . "/class/doc/DocXML.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocDir.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocFile.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/DocRelation.class.php");?>
<?php  require_once(__ROOT__ . "/class/doc/Doc.class.php");?>
<?php

$op = g ( "op" );
$printer = new Printer ();
setValue("myid","Public");

switch ($op) {
	case "path_create" :
		path_create ();
		break;
	case "create" :
		create ();
		break;
	case "edit" :
		edit ();
		break;
	case "delete" :
		delete ();
		break;
	case "detail" :
		detail ();
		break;
	case "get_tree" :
		get_tree ();
		break;
}

// 创建文档根目录的文件夹
function path_create() {
	Global $printer;
	
	$path = g ( "path" );
	
	if (! strpos ( $path, ":\\" ))
		$printer->fail (get_lang("docdir_error"));
	
	if (file_exist ( $path )) {
		$printer->success ();
	} else {
		error_reporting ( 0 );
		mkdirs ( $path );
		
		//需要转码
		if (file_exist ( $path ))
			$printer->success ( $path );
		else
			$printer->fail (get_lang("docdir_error1"));
	}
}
function create() {
	Global $printer;
	
	$parentid = g ( "parentid" );
	$name = f ( "usname" );
	$myid = f ( "myid" );
	
	$docdir = new DocDir ();
	
	$result = $docdir->insert ( 0, $parentid, $name, $myid );
	
	if ($result == "0")
		$printer->fail ( "errnum:102202" );
	else
		$printer->success ( "id:" . DocXML::get_node_id ( $result ["type"], $result ["ptpfolderid"], DOC_ROOT, "0", $parent ["root_id"] ) );
}
//function create() {
//	global $printer;
//	
//	$parent = DocXML::get_node_info ( g ( "parentid" ) );
//	$name = f ( "usname" );
//	
//	$docdir = new DocDir ();
//	
//	$result = $docdir->insert ( $parent ["curr_type"], $parent ["curr_id"], $name );
//	
//	if ($result == "0")
//		$printer->fail ( "errnum:102202" );
//	else
//		$printer->success ( "id:" . DocXML::get_node_id ( $result ["type"], $result ["id"], $parent ["curr_type"], $parent ["curr_id"], $parent ["root_id"] ) );
//}
function edit() {
	Global $printer;
	
	$node = DocXML::get_node_info ( g ( "id" ) );
	$name = f ( "usname" );
	
	$docdir = new DocDir ();
	$result = $docdir->update ( $node ["root_id"], $node ["parent_type"], $node ["parent_id"], $node ["curr_type"], $node ["curr_id"], $name );
	$docdir -> doc_retime($node ["curr_id"]);
	
	if ($result == "0")
		$printer->fail ( "errnum:102202" );
	else
		$printer->success ();
}
function detail() {
	Global $printer;
	
	$node = DocXML::get_node_info ( g ( "id" ) );
	$childType = $node ["curr_type"];
	$childId = $node ["curr_id"];
	
	$docdir = new DocDir ();
	$row = $docdir->detail ( $childType, $childId );
	
	$printer->out_detail ( $row );
}
function delete() {
	Global $printer;
	
	$node = DocXML::get_node_info ( g ( "id" ) );
	
	$docdir = new DocDir ();
	
	$result = $docdir->delete ( $node ["curr_type"], $node ["curr_id"] );
	
	$doc = new Doc();
	$doc -> delete($node ["curr_type"],$node ["curr_id"],$node ["parent_id"]);
	
	if ($result)
		$printer->success ();
	else
		$printer->fail ( "errnum:102203" );
}
function get_tree() {
	Global $printer;
	
	$node_id = g ( "id","0" );
	
	$docXML = new DocXML ();
	$data = $docXML->get_root_tree ( $node_id );
	$printer->out_xml ( $data );
}

?>