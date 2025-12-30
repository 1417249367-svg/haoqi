<?php  require_once("../include/fun.php");?>
           <form id="form_folder" method="post" class="form-horizontal" data-obj="">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang('txt_folder_name')?></label> 
                        <div class="control-value">
                            <input type="text"  id="txt_folder_name" placeholder="<?=get_lang('txt_folder_name')?>" class="form-control specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
              </div>
            </form>
<script type="text/javascript">
$(document).ready(function(){
   $("#form_folder").validate({
        submitHandler: function(form) {
            folder_create_save();
            return false;
        }
    })

});

function folder_create_save()
{
	setLoadingBtn($("#btn_save"));
	
	var url = getAjaxUrl("cloud","folder_create","loginname=" + curr_loginname + "&password=" + curr_password);
	var data = {"parent_type":parent_type,"parent_id":parent_id,"root_type":root_type,"root_id":root_id,"name":$("#txt_folder_name").val()} ;
	//console.log(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
	   		if (result.status == undefined)
			{
				//success
				doc_set_html(result.rows,2);
				dialogClose("folder");
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