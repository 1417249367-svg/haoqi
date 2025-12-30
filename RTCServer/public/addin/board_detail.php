<?php  
//http://127.0.0.1:8000/addin/board_detail.html?loginname=ZS@aa&password=e10adc3949ba59abbe56e057f20f883e&boardId={CB6C1501-E5F4-47A1-9B92-785B57DD2E6A}
	require_once("include/fun.php");
	require_once(__ROOT__ . "/class/ant/board.class.php");
	require_once(__ROOT__ . "/class/im/Msg.class.php");
	require_once(__ROOT__ . "/class/im/MsgReader.class.php");
	$id = g("boardId");
//	$board = new Board();
//	$date = $board->db->getSelectDateField("col_dt_create");
//	$board->field = "col_id,col_creator_ID,col_creator_name,col_content,col_subject,col_dt_modify,$date,col_creator";
//	$board->addParamWhere("col_id",$id);
	
//	if (! strpos ( $id, "{" ))
//		$id = "{" . $id . "}";
	$dp = new Model ( "board" );
	$dp->addParamWhere ( "col_id", $id );
	$row = $dp->getDetail ();
	
	if (count($row) == 0)
	{
		die("公告不存在!");
	}
	
	$doc_file = new Model("Board_Visiter");
	if($row ["col_ispublic"]){
		$file_item = array();
		$file_item["col_BoardID"] = $id ;
		$file_item["Col_HsItem"] = CurUser::getLoginName() ;
		$file_item["Col_HsItem_Name"] = CurUser::getUserName() ;
		$file_item["Col_HsItem_ID"] = CurUser::getUserId() ;
		$file_item["col_Readed"] = 1 ;
		$file_item["col_Dt_Readed"] = getNowTime() ;
		$doc_file -> clearParam();
		$doc_file -> addParamFields($file_item);
		$doc_file -> insert();
	}else{
		$doc_file -> addParamFields($fields);
		$doc_file -> addParamField("col_Readed", 1);
		$doc_file -> addParamField("col_Dt_Readed", getNowTime());
		$doc_file -> addParamWhere("Col_HsItem_ID", CurUser::getUserId());
		$doc_file -> addParamWhere("col_BoardID",$id) ;
		$doc_file -> update();
	//$sql = "update Board_Visiter set col_Readed=1,col_Dt_Readed='".getNowTime()."' and Col_HsItem='".g ( "loginname" )."' where col_BoardID='" . $id . "'" ;
	}
//	echo $sql;
//	exit();
//	$dp -> db -> execute($sql);
	
	// 取出TEXT中的内容
	$html = $row ["col_content"];
	$datapath = date ( "Ymd", strtotime ( $row ["col_dt_create"] ) );
	
	$reader = new MsgReader ();
	$data = array();
	$sql = "Select * from Board_Attach where Col_BoardID='".$id."'";
	$data = $dp -> db -> executeDataTable($sql);
	foreach($data as $k=>$v){
		if(get_file_style($data[$k]['col_filename'])==2) $fileType=0;
		else $fileType=1;
		$content = $reader->get_file_html($id,$fileType,$data[$k]['col_filename'],$data[$k]['col_filesize'],$data[$k]['col_filepath'],$data[$k]['col_id']);
		$html=$html.$content;
	}
	
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/board.css" />
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
    <style>
	body{margin:0px}
	.article-info ul{padding:0px;margin:0px;}
	.article-info li{width:200px; padding:0px;margin:0px;}
	</style>
</head>
<body>
<div class="topbar">
        <div class="searchbar" id="searchbar">
                <div class="pull-left">
                    <button type="button" class="btn btn-default" action-type="board_return"><?=get_lang('btn_return')?></button>
                </div>
                <div class="clear"></div>
        </div>
    </div>
    <div class="article">
        <div class="article-header"><?= $row["col_subject"]?></div>
        <div class="article-info">
            <ul>
                <li><span>发送者:</span><?=$row["col_creator_name"]?></li>
                <li><span>创建时间:</span><?=$row["col_dt_create"]?></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="article-body"><?= $html?></div>
    </div>
</body>
</html>
<script type="text/javascript">
var query = "loginname=<?=g("loginname") ?>&password=<?=g("password") ?>" ;
function board_return(id)
{

	location.href = "board_list.html?" + query ;
}
</script>
