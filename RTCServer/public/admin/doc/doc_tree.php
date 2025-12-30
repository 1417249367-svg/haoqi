<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DOC_TREE") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/userpicker1.js"></script>
	<script type="text/javascript" src="../assets/js/doc.js?ver=202500626"></script>
	<script type="text/javascript" src="../assets/js/bioace.js?ver=202500730"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>

				<div class="page-header"><h1><?=get_lang("doc_public_title")?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
					  <!--<button type="button" class="btn btn-default" action-type="root_create">新增根目录</button>-->
					  <button type="button" class="btn btn-default" action-type="folder_create"><?=get_lang("doc_btn_createfolder")?></button>
                      <button type="button" class="btn btn-default" action-type="dir_edit"><?=get_lang("doc_btn_editfolder")?></button>
                      <button type="button" class="btn btn-default" action-type="dir_delete"><?=get_lang("doc_btn_delfolder")?></button>
					  <button type="button" class="btn btn-default" action-type="ace_user_picker"><?=get_lang("doc_btn_addpower")?></button>
					  <button type="button" class="btn btn-default" action-type="ace_delete"><?=get_lang("doc_btn_delpower")?></button>
                      <button type="button" class="btn btn-default" action-type="batch_import"><?=get_lang("doc_btn_batch")?></button>
                      <button type="button" class="btn btn-default" style="display:none;" action-type="folder_clean"><?=get_lang("doc_btn_clean")?></button>
                    </div>

				</div>
				<!--End SearchBar-->
 
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

									<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list" data-ispage="0" data-obj="bioace" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="*">
									  <thead>
										<tr>
										  <td style="width:65px"><input type="checkbox" name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
										  <td data-sortfield="col_hsitemtype" style="width:60px"><?=get_lang("field_type")?></td>
										  <td data-sortfield="col_hsitemname"><?=get_lang("field_name")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power1" onclick="chk_power_All(1,this.checked)"><?=get_lang("doc_power_view")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power2" onclick="chk_power_All(2,this.checked)"><?=get_lang("doc_power_edit")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power16384" onclick="chk_power_All(16384,this.checked)"><?=get_lang("doc_power_edit1")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power8" onclick="chk_power_All(8,this.checked)"><?=get_lang("doc_power_manage")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power16" onclick="chk_power_All(16,this.checked)"><?=get_lang("doc_power_download")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power32" onclick="chk_power_All(32,this.checked)"><?=get_lang("doc_power_create")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power64" onclick="chk_power_All(64,this.checked)"><?=get_lang("doc_power_delete")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power128" onclick="chk_power_All(128,this.checked)"><?=get_lang("doc_power_rename")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power256" onclick="chk_power_All(256,this.checked)"><?=get_lang("doc_power_sendfile")?></td>
                                          <td style="width:65px"><input type="checkbox" class="chk_power512" onclick="chk_power_All(512,this.checked)"><?=get_lang("doc_power_permission")?></td>
										  <!--<td style="width:65px">定版</td>-->
										</tr>
									  </thead>
									  <tbody>
									  </tbody>
									</table>

									<script type="text/x-jquery-tmpl" id="tmpl_list">
										<tr class="doc_ace row-${id}" id="ace_${id}" data-id="${id}">
											<td><input  type="checkbox"  name="chk_Id" value="${id}" /></td>
											<td>${col_hsitemtype_name}</td>
											<td class="emptype_${to_type}">${col_hsitemname}</td>
											<td><input type="checkbox" class="chk_power" value="1"></td>
											<td><input type="checkbox" class="chk_power" value="2"></td>
											<td><input type="checkbox" class="chk_power" value="16384"></td>
											<td><input type="checkbox" class="chk_power" value="8"></td>
											<td><input type="checkbox" class="chk_power" value="16"></td>
											<td><input type="checkbox" class="chk_power" value="32"></td>
											<td><input type="checkbox" class="chk_power" value="64"></td>
											<td><input type="checkbox" class="chk_power" value="128"></td>
											<td><input type="checkbox" class="chk_power" value="256"></td>
											<td><input type="checkbox" class="chk_power" value="512"></td>
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
	$(".chk_power1").attr("checked",false);
	$(".chk_power2").attr("checked",false);
	$(".chk_power8").attr("checked",false);
	$(".chk_power16").attr("checked",false);
	$(".chk_power32").attr("checked",false);
	$(".chk_power64").attr("checked",false);
	$(".chk_power128").attr("checked",false);
	$(".chk_power256").attr("checked",false);
	$(".chk_power512").attr("checked",false);
	$(".chk_power16384").attr("checked",false);
	path = getTreePath(tree) ;
	nodeId = tree.getSelectedItemId();
	$("#path").html(path);

	var arr_node = nodeId.split("_");
	classId = arr_node[0] ;
	objId = arr_node[1] ;
	if(classId=="102"){
		$(".btn-default").eq(1).hide();
		$(".btn-default").eq(2).hide();
		$(".btn-default").eq(3).hide();
		$(".btn-default").eq(4).hide();
	}else{
		$(".btn-default").eq(1).show();
		$(".btn-default").eq(2).show();
		$(".btn-default").eq(3).show();
		$(".btn-default").eq(4).show();
	}
    $("#datalist").attr("data-query","classid=" + classId + "&objid=" + objId) ;
    
    if (dataList == undefined)
        dataList = $("#datalist").dataList(ace_formatData,ace_callback);
    else
        dataList.reload();

}
</script>
