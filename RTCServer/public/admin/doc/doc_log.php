<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DOC_LOG") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/doc_log.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>

				<div class="page-header"><h1><?=get_lang("doc_log_title")?></h1></div>
 
				<!--List--->
				<div class="clearfix">
                        <div class="ctree">
							<div class="widget widget-default">
							  <div class="widget-heading"><?=get_lang("doc_tree_title")?></div>
							  <div class="widget-body" style="overflow:hidden">
									<div id="container_tree" class="container-tree" ></div>
							  </div>
							</div>
                        </div>
                        <div class="clist">
							<div class="widget widget-default">
							  <div class="widget-heading" id="path"><?=get_lang("doc_path_title")?></div>
							  <div class="widget-body">

									<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list" data-ispage="0" data-obj="cloud" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="*">
									  <thead>
										<tr>
										  <td data-sortfield="col_name"><?=get_lang("attach_list_table_filename")?></td>
                                          <td data-sortfield="pcsize"><?=get_lang('attach_list_table_filesize')?></td>
                                          <td data-sortfield="todate"  style="width:150px;"><?=get_lang('attach_list_table_senddate')?></td>
										  <td style="width:120px"></td>
										</tr>
									  </thead>
									  <tbody>
									  </tbody>
									</table>

									<script type="text/x-jquery-tmpl" id="tmpl_list">
										<tr class="doc_item" id="${col_id}" data-name="${col_name}" data-target="${filpath}">
											<td><a href="javascript:void(0);" onclick="doc_download('${col_id}',this)">${col_name}</a></td>
											<td>${filesize_text}</td>
											<td>${col_dt_create}</td>
											<td><a href="javascript:void(0);" onclick="doc_download('${col_id}',this)"><?=get_lang('doc_power_download')?></a></td>
										</tr>
									</script>


							  </div>
							</div>
                        </div>
				</div>
				<!--End List--->
				<?php  require_once("../include/footer.php");?>
    
 
</body>
</html>
<script language="javascript" >

var dataList ;

$(document).ready(function(){
	loadTree("container_tree");
	
	$(".widget-body,#container_tree").height($(document).height()-235);
})


function treeClick()
{
	path = getTreePath(tree) ;
	nodeId = tree.getSelectedItemId();
	$("#path").html(path);

    $("#datalist").attr("data-query", "label=doc_log&nodeId=" + nodeId);
    
    if (dataList == undefined)
        dataList = $("#datalist").dataList(formatData);
    else
        dataList.reload();

}

function formatData(_data)
{
	for (var i = 0; i < _data.length; i++) {
		_data[i].filesize_text = get_filesize(_data[i].pcsize);
		_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
	}
	return _data ;

}


</script>
