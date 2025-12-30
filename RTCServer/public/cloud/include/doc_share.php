<?php 
require_once("../include/fun.php");
?>
              <div class="modal-body">
                    <div class="target_name"> 
						<span class="icon50 icon_folder"></span> 行政中心
                    </div>
                    <div class="target_path"> 
                        <dl>
							<dt><?=get_lang('save_to')?>： <span id="target_path_name"></span></dt>
							<dd style="height:200px; overflow:auto;"><div id="container_target_tree"></div></dd>
						</dl>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_ok')?></button>
              </div>
			 
<script type="text/javascript">

$(document).ready(function(){
	var arr_id = ids.split(",");
	var names = $("#" + arr_id[0]).attr("data-name") ;
	if (arr_id.length>1)
		names += "...(" + arr_id.length + "<?=get_lang('doc_move_alert1')?>)" ;
	var icon = ("," + ids).indexOf(DOC_FILE)>-1?"icon_file":"icon_folder" ;
	$(".target_name").html('<span class="icon50 ' + icon + '"></span>' + names);

	
	
	loadTree("container_target_tree");
	
	$("#btn_save").click(function(){
		doc_share_save();
		return false ;
	})
})

function doc_share_save()
{
	var node_id = tree.getSelectedItemId();
	if (node_id == "")
	{
		myAlert("<?=get_lang('doc_move_alert2')?>");
		return ;
	}

	var target_item = node_id.split("_");
	var target_type = target_item[0] ;
	var target_id = target_item[1] ;

	setLoadingBtn($("#btn_save"));
	
	var url = getAjaxUrl("cloud","doc_save",query);
	var data = {"ids":ids,"target_type":target_type,"target_id":target_id,"root_type":3} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			
			if (result.status)
			{ 
				dialogClose("share");
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