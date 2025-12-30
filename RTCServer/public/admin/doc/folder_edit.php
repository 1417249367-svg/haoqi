<?php  require_once("../include/fun.php");?>
           <form id="form_folder" method="post" class="form-horizontal" data-obj="docdir">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("doc_lb_foldername")?></label> 
                        <div class="control-value">
                            <input type="text" name="usname" id="usname" placeholder="<?=get_lang("doc_ph_foldername")?>" class="form-control data-field specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
				<input type="hidden" name="myid" class="data-field" value="Public"> 
                <input type="hidden" name="root_type" class="data-field" value="1"> 
				<input type="hidden" name="parentid" value="<?=g("parentid") ?>"> 
              </div>
            </form>
<script type="text/javascript">
var id = "<?=g("id") ?>";

var folder_dataForm ;

$(document).ready(function(){
   folder_dataForm = $("#form_folder").attr("data-id",id).dataForm({savecallback:folder_savecallback});
   $("#form_folder").validate({
        submitHandler: function(form) {
            folder_dataForm.save();
            return false;
        }
    })

});

</script>