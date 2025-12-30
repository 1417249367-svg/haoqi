<?php 
require_once("../include/fun.php");
?>
              <div class="modal-body">
                    <div class="target_name"> 
						<span class="icon50 icon_folder"></span> 行政中心
                    </div>
                    <div class="target_path"> 
                        <dl>
							<dt><?=get_lang('move_to')?>： <span id="target_path_name"></span></dt>
							<dd style="height:200px; overflow:auto;"><div id="container_target_tree"></div></dd>
						</dl>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_ok')?></button>
              </div>
			 
<script type="text/javascript">
var parentId=0;
$(document).ready(function(){
	var arr_id = ids.split(",");
	var names = $("#" + arr_id[0]).attr("data-name") ;
	if (arr_id.length>1)
		names += "...(" + arr_id.length + "<?=get_lang('doc_move_alert1')?>)" ;
	var icon = ("," + ids).indexOf(DOC_FILE)>-1?"icon_file":"icon_folder" ;
	$(".target_name").html('<span class="icon50 ' + icon + '"></span>' + names);

	if(parseInt(parent_id)) parentId=parent_id;
	else parentId=$("#" + arr_id[0]).attr("data-rootid");
	if(root_type==1) loadTree1("container_target_tree",parentId);
	else loadTree("container_target_tree");
	
	//tree.selectItem('105_11_105_10_');

	
	$("#btn_save").click(function(){
		doc_move_save();
		return false ;
	})
})

function doc_move_save()
{
	var node_id = tree.getSelectedItemId();
	if (node_id == "")
	{
		myAlert("<?=get_lang('doc_move_alert2')?>");
		return ;
	}
//console.log('node_id:'+node_id);
	var target_item = node_id.split("_");
	var target_type = target_item[0] ;
	var target_id = target_item[1] ;
	
	//判断是否没有变成
	//console.log(parentId +"|"+ target_id);
	if (parentId == target_id)
	{
		myAlert("<?=get_lang('doc_move_alert3')?>");
		return ;
	}
	
    var curr_pathname="";
	var arr_url = hash.url.replace("#","").split("/") ;
	for(var i=0;i<arr_url.length;i++)
	{
		var arr_item = arr_url[i].split("_");
		if (path_valid(arr_url,i)) curr_pathname += arr_item[0]+"/";

	}
	
	var arr_id = ids.split(",");
	for(var i=0;i<arr_id.length;i++)
	{
		var curr_item = arr_id[i].split("_");
		var curr_type = curr_item[0] ;
		var curr_id = curr_item[1] ;

		var destPath = getTreePath(tree,node_id);
		var sourcePath = curr_pathname+$("#"+arr_id[i]).attr("data-name");
		//alert(destPath+"|"+sourcePath+"|"+hash.url);
		if((destPath.indexOf(sourcePath)>=0)&&(curr_type!=DOC_FILE))
		{
			myAlert(getErrorText("102206"));
			return ;
		}
		
	}

	setLoadingBtn($("#btn_save"));
	
	
	var url = getAjaxUrl("cloud","doc_move",query);
	var data = {"parent_type":parent_type,"parentId":parentId,"ids":ids,"target_type":target_type,"target_id":target_id,"root_type":root_type} ;
	//console.log(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
	   		
	   		if (result.status)
			{
				setCookie("BA-getTreeId",getTreeId(tree)) ;
				//if(parseInt(parent_id)) 
				remove_list_items(ids);  
				dialogClose("move");
			}
			else
			{
				setSubmitBtn($("#btn_save"));
				myAlert(result.msg);
			}
       }
    }); 

}


</script>