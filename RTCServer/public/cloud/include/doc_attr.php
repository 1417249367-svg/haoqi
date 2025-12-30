<?php 
require_once("../include/fun.php");
?>
              <div class="modal-body" style="padding:20px 40px">
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('doc_type_name')?></label>
				  <div class="control-value"><span name="doc_type_name" class="data-field"></span></div>
				</div>
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('col_name')?></label>
				  <div class="control-value"><span name="col_name" class="data-field"></span></div>
				</div>
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('path')?></label>
				  <div class="control-value"><div name="path" class="data-field path_to"></div></div>
				</div>
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('doc_type_file')?></label>
				  <div class="control-value"><span name="doc_attribution" class="data-field"></span></div>
				</div>
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('doc_type_file')?></label>
				  <div class="control-value"><span name="col_dt_create" class="data-field"></span></div>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_close')?></button>
              </div>
			 
<script type="text/javascript">
var doc_type = "<?=g("doc_type")?>" ;
var doc_id = "<?=g("doc_id")?>" ;
$(document).ready(function(){
	var url = getAjaxUrl("cloud","doc_attr",query);
	var data = {"doc_type":doc_type,"doc_id":doc_id} ;
	//console.log(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
		   //console.log(JSON.stringify(result));
			if (result.status == 0)
			{
				myAlert(result.msg) ;
			}
			else
			{
				data = format_data(result);
				$(".data-field").each(function(){
					var val = data[$(this).attr("name")] ;
					$(this).html(val);
				})
			}
       }
    }); 
})

function format_data(data)
{
	if (data.doc_type == DOC_FILE)
		data.doc_type_name = "<?=get_lang('doc_type_file')?>" ;
	else
		data.doc_type_name = "<?=get_lang('doc_type_folder')?>" ;
		
	if (data.to_type == 1){
		data.doc_attribution = "<?=get_lang('icon_folder_public')?>" ;
		data.path_url="#public/"+data.path_url;
	}else{
		data.doc_attribution = "<?=get_lang('icon_folder_person')?>" ;
		data.path_url="#person/"+data.path_url;
	}

	data.path = "<a href=\"javascript:void(0)\" onclick=\"path_to('" + data.path_url + "')\">" + data.path_text + "</a>" ;

	return data ;
}
 
function path_to(url)
{
	dialogClose("attr");
	location.href = "yunpan.html" + url ;
}
</script>

