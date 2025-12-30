<?php  require_once("../include/fun.php");?>
           <form id="form_folder" method="post" class="form-horizontal" data-obj="docdir">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("doc_lb_foldername")?></label> 
                        <div class="control-value">
                            <input type="text" name="usname" id="usname" placeholder="<?=get_lang("doc_ph_foldername")?>" class="form-control data-field"   maxlength="50" value="D:\RTCtemp"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
              </div>
            </form>
<script type="text/javascript">
var id = "<?=g("id") ?>";

var folder_dataForm ;

$(document).ready(function(){
   $("#form_folder").validate({
        submitHandler: function(form) {
			 var url = getAjaxUrl("cloud","doc_ptpfolder_delete","root_id=0&root_type=1") ;
			 //console.log(url+"usname="+$("#usname").val());
			 $.ajax({
				 type: "POST",
				 data:{"usname":$("#usname").val()},
				 dataType:"json",
				 url: url,
				 success: function(result){
					  if (result.status)
						  myAlert(langs.doc_dir_warning1);
				 }
			 }); 
            return false;
        }
    })

});

</script>