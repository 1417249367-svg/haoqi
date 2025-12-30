<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Col.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php

//ob_clean ();
//if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
//
//}else{
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
//}
isPublicNet();
$op = g ( "op" );
$printer = new Printer ();
switch ($op) {
	case "col_list":
		col_list();
		break ;
	case "create" :
		save ();
		break;
	case "createcol" :
		savecolform ();
		break;
	case "colro_delete" :
		colro_delete ();
		break;
	case "col_delete" :
		col_delete ();
		break;
	case "col_move":
		col_move();
		break ;
	case "detail" :
		detail ();
		break;
	default :
		break;
}

//得到列表
function col_list()
{
	Global $printer;

	$label = g("label");
	if ($label == "colro")
	{
		coc_list_ro();
		return ;
	}
	if ($label == "colro_public")
	{
		coc_list_ro_public();
		return ;
	}

	$sortby = g("sortby","ID desc");
	$pagesize = g("pagesize",100);
	$pageindex = g("pageindex",1);
	$recordcount = 0 ;

	$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
	$root_id = g("root_id",0);  	//
	$parent_type = g("parent_type",0);
	$parent_id = g("parent_id","00000000");
	$file_type = g("file_type");
	$key = g("key");

	$col = new Col();
	//加载文件
	$result_col = $col -> list_form($parent_type,$parent_id,$root_type,$root_id,$file_type,$key,$sortby,$pageindex,$pagesize,CurUser::getUserId());

	$data = $result_col["data"] ;
	$recordcount = $result_col["count"] ;
//var_export($data_folder);
//var_export($data);
//exit();
	$printer -> out_list($data,$recordcount,0);
}

function coc_list_ro()
{
	Global $printer;

	$label = g("label");

	$sortby = g("sortby","TypeID");
	$pagesize = g("pagesize",100);
	$pageindex = g("pageindex",1);
	$recordcount = 0 ;

	$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
	$root_id = g("root_id",0);  	//
	$parent_type = g("parent_type",0);
	$parent_id = g("parent_id","00000000");
	$file_type = g("file_type");
	$key = g("key");
	$vesr = g("vesr");

	$col = new Col();
	$data_col = array();
	$result_ro = $col -> list_ro($parent_type,$parent_id,$root_type,$root_id,$sortby,CurUser::getUserId());
	if($result_ro["vesr"]!=$vesr) $data_col = $col -> list_form($parent_type,$parent_id,$root_type,$root_id,$file_type,$key,$sortby,$pageindex,$pagesize,CurUser::getUserId());

	$data_ro = $result_ro["data"] ;
	$vesr = $result_ro["vesr"] ;
	$data = array_merge($data_ro,$data_col) ;

	$printer -> out_list($data,$vesr,0);
}

function coc_list_ro_public()
{
	Global $printer;

	$label = g("label");

	$sortby = g("sortby","TypeID");
	$pagesize = g("pagesize",100);
	$pageindex = g("pageindex",1);
	$recordcount = 0 ;

	$root_type = g("root_type",0);  // 0不限制 1公共文档  2个人文档
	$root_id = g("root_id",0);  	//
	$parent_type = g("parent_type",0);
	$parent_id = g("parent_id","00000000");
	$file_type = g("file_type");
	$key = g("key");
	$vesr = g("vesr");

	$col = new Col();
	$data_col = array();
	$result_ro = $col -> list_ro($parent_type,$parent_id,$root_type,$root_id,$sortby,'Public');
	if($result_ro["vesr"]!=$vesr) $data_col = $col -> list_form($parent_type,$parent_id,$root_type,$root_id,$file_type,$key,$sortby,$pageindex,$pagesize,'Public');

	$data_ro = $result_ro["data"] ;
	$vesr = $result_ro["vesr"] ;
	$data = array_merge($data_ro,$data_col) ;

	$printer -> out_list($data,$vesr,0);
}

function save() {
	Global $printer;
	$doc_id = g("doc_id","");
	$doc_type = g("doc_type");
	$name = g ( "name" );
	$colro_myid = g ( "colro_myid" );
	if($colro_myid) $myid='Public';
	else $myid=CurUser::getUserId();
	$col = new Col();
	if ($col -> exist_name($doc_type,$name,$myid))
		$printer -> fail("[" . $name . "]".get_lang("cloud_isexists"));
	//$col -> updateColForm();
	if($doc_id){
		$col_form = $col -> edit_col($doc_id,$name);
		$printer -> success();
	}else{
		$col_form = $col -> save_col($name,$myid);
		$printer->success ( "id:" . $col_form["TypeID"] );
	}
//	$ids .= ($ids?",":"") . $col_form["TypeID"] ;
//	//返回数据
//	if (substr($ids,","))
//		$sql = " TypeID in(" . $ids . ")" ;
//	else
//		$sql = " TypeID=" . $ids  ;
//	$sql = " select TypeID as col_id,TypeName as col_name,MyID from Col_Ro where " . $sql;
//	$data = $col -> db -> executeDataTable($sql) ;
//	$printer -> out_list($data,-1,0);

}

function savecolform() {
	Global $printer;
	$doc_id = g("doc_id","");
	$doc_type = g("doc_type");
	$parent_id = g("parent_id");
	$title = g ( "title" );
	$content = g("content");
	//$usname = g("usname");
	$usid = g("usid",CurUser::getUserId());
	$types = g("types","");
	$colro_myid = g ( "colro_myid" );
	if($colro_myid) $myid='Public';
	else $myid=CurUser::getUserId();
	$col = new Col();
	$col -> updateColForm();
	if($doc_id){
		 $col_form = $col -> edit_colform($parent_id,$doc_id,$title,$content,$types,g ( "iskefu" ));
		 $printer -> success();
	}else{
		 if(!$parent_id) $parent_id=$col -> db -> executeDataValue("select TypeID as c from Col_Ro where TypeName = 'RTC' and MyID='" . CurUser::getUserId() . "'");
		 $col_form = $col -> save_colform($parent_id,$title,$content,$usname,$usid,$types,$myid);
		 $printer->success ( "id:" . $col_form["ID"] );
	}
}

function colro_delete()
{
	Global $printer;

	$parent_type = g("parent_type");
	$parent_id = g("parent_id");
	$root_type = g("root_type");
	$root_id = g("root_id");
	
	$arr_id = explode(",",g("ids"));
	
	$colro_myid = g ( "colro_myid" );
	$col = new Col();
	if($colro_myid){
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
				$sql = " select count(*) as c from Col_Form where UpperID=" . $arr_item[1] ;
				$count = $col -> db -> executeDataValue($sql);
				if($count) $printer -> fail(get_lang("cloud_warning17"));
				$col -> delete_db(DOC_VFOLDER,$arr_item[1]);
			}
		}
	}else{
		$taget_id=$col -> db -> executeDataValue("select TypeID as c from Col_Ro where TypeName = 'RTC' and MyID='" . CurUser::getUserId() . "'");
		foreach($arr_id as $id)
		{
			if ($id)
			{
				$arr_item = explode("_",$id);
				$col -> delete_db(DOC_VFOLDER,$arr_item[1]);
				$col -> move(DOC_VFOLDER,$parent_id,$taget_id);
			}
		}
	}
	$col -> updateColForm();
	$printer -> success();
}

function col_delete()
{
	Global $printer;

	$parent_type = g("parent_type");
	$parent_id = g("parent_id");
	$root_type = g("root_type");
	$root_id = g("root_id");

	$arr_id = explode(",",g("ids"));

	$col = new Col();
	foreach($arr_id as $id)
	{
		if ($id)
		{
			$arr_item = explode("_",$id);
			$col -> delete_db(DOC_FILE,$arr_item[1]);
		}
	}
	$col -> updateColForm();
	$printer -> success();
}

function col_move()
{
	Global $printer;

	$taget_id = g("target_id") ;
	$arr_id = explode(",",g("ids"));

	$col = new Col();
	$col -> updateColForm();
	foreach($arr_id as $id)
	{
		if ($id)
		{
			$arr_item = explode("_",$id);
			$col -> move(DOC_FILE,$arr_item[1],$taget_id);
		}
	}
	$printer -> success();
}

function detail() {
	Global $printer;

	$tableName = f ( "table", "Col_Form" );
	$fldId = f ( "fldid", "ID" );
	$fields = f ( "fields", "*" );
	$id = f ( "id", 1 );

	$db = new Model ( $tableName, $fldId );
	$db->addParamWhere ( $fldId, $id, "=", "int" );
	$row = $db->getDetail ();

	$printer->out_detail ( $row, "", 0 );
}
	
?>