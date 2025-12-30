<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Tag.class.php");?>

<?php
$op = g ( "op" );
$printer = new Printer ();

switch ($op) {
	case "load_all" :
		load_all ();
		break;
	case "list_type" :
		list_type ();
		break;
	case "delete_type" :
		delete_type ();
		break;
	
	case "add_tag" :
		add_tag ();
		break;
	case "list_tag" :
		list_tag ();
		break;
	case "delete_tag" :
		delete_tag ();
		break;
	
	case "set_data" :
		set_data ();
		break;
	case "get_data" :
		get_data ();
		break;
	case "get_relation" :
		get_relation ();
		break;
	
	case "search" :
		search ();
		break;
}

// / <summary>
// / [{type_id,type_name,tags:[{tag_id,tag_name},{tag_id,tag_name}]}],[{type_id,type_name,tags:[{tag_id,tag_name},{tag_id,tag_name}]}]
// / </summary>
function load_all() {
	$db = new DB ();
	$json = "";
	$sql = " select * from hs_tag_type";
	$dt_type = $db->executeDataTable ( $sql );
	
	foreach ( $dt_type as $dr_type ) {
		$type_id = $dr_type ["col_id"];
		$type_name = $dr_type ["col_name"];
		$sql = " select * from hs_tag where col_type_id=" . $type_id;
		
		if ($json != "")
			$json .= ",";
		
		$json .= "{\"col_id\":\"" . $type_id . "\",\"col_name\":\"" . $type_name . "\",\"tags\":[";
		
		$json_tag = "";
		$dt_tag = $db->executeDataTable ( $sql );
		foreach ( $dt_tag as $dr_tag ) {
			$tag_id = $dr_tag ["col_id"];
			$tag_name = $dr_tag ["col_name"];
			
			$json_tag .= ($json_tag == "" ? "" : ",") . "{\"col_id\":\"" . $tag_id . "\",\"col_type_id\":" . $type_id . ",\"col_name\":\"" . $tag_name . "\"}";
		}
		$json .= $json_tag;
		
		$json .= "]}";
	}
	$json = "[" . $json . "]";
	
	ob_clean ();
	print ($json) ;
}
function search() {
	Global $printer;
	$key = g ( "key" );
	$top = g ( "top", 10 );
	
	$db = new Model ( "hs_tag" );
	$db->addWhere ( "col_name like '%" . $key . "%'" );
	$db->field ( "col_name as name,col_id as id" );
	$db->order ( "col_name" );
	
	$data = $db->Top ( top, whereSql );
	$printer->out_list ( $data );
}
function list_type() {
	Global $printer;
	
	$sql = " select * from hs_tag_type";
	
	$db = new DB ();
	$data = $db->executeDataTable ( $sql );
	$printer->out_list ( $data );
}
function delete_type() {
	Global $printer;
	$type_id = g ( "id" );
	
	$sqls = array (
					" delete from hs_tag_type where col_id=" . $type_id,
					" delete from hs_tag where col_type_id=" . $type_id 
	);
	
	$db = new DB ();
	$result = $db->execute ( $sqls );
	
	$printer->success ();
}
function add_tag() {
	Global $printer;
	
	$type_id = g ( "type_id" );
	$name = g ( "name" );
	
	$db = new Model ( "hs_tag" );
	$db->clearParam ();
	$db->addParamField ( "Col_Type_Id", $type_id );
	$db->addParamField ( "Col_Name", $name );
	$db->insert ();
	
	$id = $db->getMaxId ();
	
	$printer->success ( "id:" . $id );
}
function list_tag() {
	Global $printer;
	
	$type_id = g ( "type_id" );
	$sql = " select * from hs_tag where col_type_id=" . $type_id;
	
	$db = new DB ();
	$data = $db->executeDataTable ( $sql );
	$printer->out_list ( $data );
}
function delete_tag() {
	Global $printer;
	
	$id = g ( "id" );
	$sql = " delete from hs_tag where col_id=" . $id;
	
	$db = new DB ();
	$result = $db->execute ( $sql );
	$printer->success ();
}
function set_data() {
	Global $printer;
	
	$empType = g ( "EmpType" );
	$empIds = g ( "EmpId" );
	$tagIds = g ( "tagIds" );
	$flag = g ( "flag" ); // 0 append 1 set
	
	$tag = new Tag ();
	$tag->SetTag ( $empType, $empIds, $tagIds, $flag );
	
	$printer->success ();
}
function get_data() {
	Global $printer;
	
	$empType = g ( "EmpType" );
	$empId = g ( "EmpId" );
	
	$tag = new Tag ();
	$data = $tag->getTag ( $empType, $empId );
	
	$printer->out_list ( $data );
}
function get_relation() {
	Global $printer;
	
	$empType = g ( "EmpType" );
	$empIds = g ( "EmpId" );
	
	$tag = new Tag ();
	$data = $tag->getRelation ( $empType, $empIds );
	
	$printer->out_list ( $data );
}
?>