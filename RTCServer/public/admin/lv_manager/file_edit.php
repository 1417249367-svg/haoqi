<?php  require_once("../include/fun.php");?>

           <form id="form_file" method="post" class="form-horizontal" data-table="lv_file" data-fldid="fileid" data-fldname="filename"  enctype="multipart/form-data" >      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label" for="filename"><?=get_lang('file_edit_lb_name')?></label> 
                        <div class="control-value">
                            <input type="text" id="filename" name="filename"  class="form-control specialCharValidate data-field"  />
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="filepath"><?=get_lang('file_edit_lb_path')?></label> 
                        <div class="control-value">
                            <input type="text" id="filepath" name="filepath"  class="form-control specialCharValidate data-field"  />
                            <a href="javascript:void(0);" onclick="$('#container_link').toggle()"><?=get_lang('file_edit_attach')?></a>
                            <div id="container_link" style="display:none;">
                                <input type="file" id="file" name="file"  class="form-control pull-left mr" style="width:350px;" />
                                <button type="button" class="btn btn-default pull-left" id="btn_upload" onclick="uploadFile()" ><?=get_lang('file_edit_btn_upload')?></button>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
                <input type="hidden" id="flag" name="flag" value="0"  class="form-control specialCharValidate data-field"  />
                <input type="hidden" id="username" name="username" value=""  class="form-control specialCharValidate data-field"  />
                <input type="hidden" id="filesize" name="filesize" value=""  class="form-control specialCharValidate data-field"  />
				<input type="hidden" name="fileid" id="fileid"class="form-control data-field" value="<?=getAutoId()?>" /> 
              </div>
            </form>
            <iframe id="frm_Upload"  name="frm_Upload"  src="" style="display:none;"></iframe>
<script type="text/javascript">
var dataForm ;
var fileId = "<?=g("id") ?>"; 

$(document).ready(function(){
   dataForm = $("#form_file").attr("data-id",fileId).dataForm({getcallback:file_getCallBack,savecallback:file_saveCallBack});
    $("#btn_save").click(function(){
        save();
        return false ;
    })
    
    
})

</script>