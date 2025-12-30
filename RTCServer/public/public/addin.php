<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/Uploader.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/Ziper.class.php");?>
<?php
$op = g("op") ;

$printer = new Printer();

switch($op){
	case "create" :
		save ();
		break;
	case "edit" :
		save ();
		break;
	case "delete" :
		delete ();
		break;
	case "list" :
		getList ();
		break;
	case "detail" :
		detail ();
		break;
	case "setvalue" :
		setFieldValue ();
		break;
	case "swap" :
		swap ();
		break;
	case "import":
		import();
		break;


}
function save() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$keyfields = f ( "keyfields", "" );
	$flitersql = f ( "flitersql", "" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->autoSaveAddin ( $op, $fldId, $fields, $keyfields, $flitersql );

	if (! $result ["status"]){
		$printer->fail ( "errnum:10008,msg:" . $result ["msg"] );
	}
	else{
		$vesr = new Model ( "PlugVesr", f ( "plug_bie" ) );
		$vesr->autoSaveAddinVesr ( $op, $fldId, $fields, $keyfields, $flitersql );
		$db -> updateForm("Plug_Vesr");
		$printer->success ( "id:" . $result ["id"] );
	}
}
function delete() {
	Global $printer;
	Global $op;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "ID" );
	$id = g ( "id" );

	if (! $id)
		$printer->fail ();

	$sql = " delete from " . $tableName . " where " . $fldId . " in(" . $id . ")";
	$db = new DB ();
	$result = $db->execute ( $sql );
	
	$vesr = new Model ( $tableName, $fldId );
	$vesr -> updateForm("Plug_Vesr");
	$printer->out ( $result );
}
function getList() {
	Global $printer;

	$tableName = f ( "table", "plug" );
	$fldId = f ( "fldid", "plug_id" );
	$fldList = f ( "fldlist", "*" );
	$fldSort = f ( "fldsort", "Plug_Index,Plug_ID" );
	$fldSortdesc = f ( "fldsortdesc", "Plug_Index desc,Plug_ID desc" );
	$where = stripslashes(f ( "wheresql", "" ));

	$ispage = f ( "ispage", "1" );
	$pageIndex = f ( "pageindex", 1 );
	$pageSize = f ( "pagesize", 20 );

	
	
	$db = new Model ( $tableName, $fldId );
	$db->where ( $where );
	$count = $db->getCount ();

	$db->order ( $fldSort );
	$db->orderdesc ( $fldSortdesc );
	$db->field ( $fldList );
	if ($ispage == 0)
		$data = $db->getList ();
	else
		$data = $db->getPage ( $pageIndex, $pageSize, $count );
	$printer->out_list ( $data, $count, 0 );
}
function detail() {
	Global $printer;

	$tableName = f ( "table", "AdminGrant" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$id = f ( "id", 1 );

	$db = new Model ( $tableName, $fldId );
	$db->addParamWhere ( $fldId, $id, "=", "int" );
	$row = $db->getDetail ();

	$printer->out_detail ( $row, "", 0 );
}
function setFieldValue() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "plug_id" );
	$id = g ( "id" );
	$fldname = g ( "fldname" );
	$fldvalue = g ( "fldvalue" , false );
//	if($fldvalue==1) $fldvalue="true";
//	else $fldvalue="false";

	if (! $id)
		$printer->fail ();

	$db = new Model ( $tableName, $fldId );
	$result = $db->setAddinValue ( $id, $fldname, $fldvalue );
	$db -> updateForm("Plug_Vesr");
	$printer->out ( $result );
}
function swap() {
	Global $printer;

	$tableName = f ( "table" );
	$fldId = f ( "fldid", "Plug_ID" );

	$fldSwap = g ( "fldswap" );
	$curr_id = g ( "curr_id" );
	$curr_value = g ( "curr_value" );
	$swap_id = g ( "swap_id" );
	$swap_value = g ( "swap_value" );

	$db = new Model ( $tableName, $fldId );
	$result = $db->swap ( $fldSwap, $curr_id, $curr_value, $swap_id, $swap_value );
        $db -> updateForm("Plug_Vesr");
	$printer->out ( $result );
}
//================================================================
//导入插件 
//================================================================
function import()
{
	Global $printer ;
	
	$file = g("file");
	$file = RTC_CONSOLE . "/" . $file ;

	if(! strpos($file,"xml"))
		$printer -> fail(get_lang("valid_file_type_error")) ;
		
	if (! file_exists($file))
		$printer -> fail(get_lang("valid_file_not_exist")) ;
		
	//read xml
	$content = readFileContent($file);
	$content = str_replace("'","\"",$content) ;
	$content = str_replace("<?xml version=\"1.0\" encoding=\"gb2312\"?>","",$content) ;
	$content = str_replace("<BODY>","",$content) ;
	$content = str_replace("</BODY>","",$content) ;
	//$content = str_replace("[Port]",$_SERVER["SERVER_PORT"],$content) ;

	//得到属性
	$col_name = "" ;
	$col_data = iconv_str($content);

	
	$col_desc = "" ;
	$col_addintype = 1 ;  

	$addin = new Model("Plug");
	
	$data = readXMLFile($file);
	foreach($data as $item)
	{
		$tag = $item["tag"] ;
		println($tag);
		$value = $item["value"] ;
		switch($tag){
			case "NAME" :
				$Name = $value ;
				break;
			case "SITE" :
				$Site = $value ;
				break;
			case "TARGETTYPE" :
				$TargetType = $value ;
				break;
			case "HEIGHT" :
				$Height = $value ;
				break;
			case "WIDTH" :
				$Width = $value ;
				break;
			case "TARGET":
				$Target = str_replace(chr(9), '',str_replace(chr(9), '',str_replace(chr(13), '',str_replace(chr(10), '', $value)))) ;
				break;
			case "DISPLAYNAME" :
				$DisplayName = $value ;
				break;
			case "DESC" :
				$Desc = $value ;
				break;
			case "PARAM" :
				$Param = str_replace(chr(9), '',str_replace(chr(9), '',str_replace(chr(13), '',str_replace(chr(10), '', $value)))) ;
				break;
			case "IMAGE" :
				$Image = str_replace(chr(9), '',str_replace(chr(9), '',str_replace(chr(13), '',str_replace(chr(10), '', $value)))) ;
				break;
			case "BIE" :
				$Bie = $value ;
				//判断是否存在
				$addin -> clearParam();
				$addin -> addParamWhere("Plug_Name",$Name);
				$id = $addin -> getValue("Plug_ID");
				
				//insert
				if (! $id)
				{
					$sql = " select max(Plug_Index)+1 as c from Plug" ;
					$Plug_Index = $addin -> db -> executeDataValue($sql);
					
					$addin -> clearParam();
					$addin -> addParamField("Plug_Name",$Name);
					$addin -> addParamField("Plug_Site",$Site);
					$addin -> addParamField("Plug_Height",$Height);
					$addin -> addParamField("Plug_Width",$Width);
					$addin -> addParamField("Plug_TargetType",$TargetType);
					$addin -> addParamField("Plug_Target",$Target);
					$addin -> addParamField("Plug_DisplayName",$DisplayName);
					$addin -> addParamField("Plug_Desc",$Desc);
					$addin -> addParamField("Plug_Param",$Param);
					$addin -> addParamField("Plug_Image",$Image);
					$addin -> addParamField("Plug_Index",$Plug_Index);
					$addin -> addParamField("Plug_Bie",$Bie);
					$addin -> insert();
					$vesr = new Model ( "PlugVesr", $Bie );
					$vesr->autoSaveAddinVesr ( "create", $fldId, $fields, $keyfields, $flitersql );
				}
				else
				{
					//$printer -> fail("插件已经存在");
				}
				
				break;
		}
			
	}
	$addin -> updateForm("Plug_Vesr");
	$printer -> success();


}

?>