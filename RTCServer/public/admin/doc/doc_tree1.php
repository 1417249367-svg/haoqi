<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DOC_TREE") ;
$parent_type = g("parent_type");
$parentId = g("parent_id");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/userpicker1.js"></script>
	<script type="text/javascript" src="../assets/js/doc.js"></script>
	<script type="text/javascript" src="../assets/js/bioace.js"></script>
</head>
<body>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
					  <button type="button" class="btn btn-default" action-type="ace_user_picker1"><?=get_lang("doc_btn_addpower")?></button>
					  <button type="button" class="btn btn-default" action-type="ace_delete"><?=get_lang("doc_btn_delpower")?></button>
                    </div>

				</div>
				<!--End SearchBar-->
 
				<!--List--->
				<div class="clearfix">
                        <div class="clist1">
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
										  <td style="width:65px"><input type="checkbox" class="chk_power8" onclick="chk_power_All(8,this.checked)"><?=get_lang("doc_power_manage")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power16" onclick="chk_power_All(16,this.checked)"><?=get_lang("doc_power_download")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power32" onclick="chk_power_All(32,this.checked)"><?=get_lang("doc_power_create")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power64" onclick="chk_power_All(64,this.checked)"><?=get_lang("doc_power_delete")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power128" onclick="chk_power_All(128,this.checked)"><?=get_lang("doc_power_rename")?></td>
										  <td style="width:65px"><input type="checkbox" class="chk_power256" onclick="chk_power_All(256,this.checked)"><?=get_lang("doc_power_sendfile")?></td>
                                          <td style="width:65px"><input type="checkbox" class="chk_power256" onclick="chk_power_All(512,this.checked)"><?=get_lang("doc_power_permission")?></td>
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
    
 
</body>
</html>
<script language="javascript" >

var dataList ;
var parent_type = "<?=$parent_type ?>";
var parent_id = "<?=$parentId ?>";
$(document).ready(function(){
	treeClick();
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

    $("#datalist").attr("data-query","classid=" + parent_type + "&objid=" + parent_id) ;
    
    if (dataList == undefined)
        dataList = $("#datalist").dataList(ace_formatData,ace_callback);
    else
        dataList.reload();

}


</script>
