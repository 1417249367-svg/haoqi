<?php  require_once("../include/fun.php");?>
<?php
$chater = new Model("lv_chater");
$data = $chater -> getList();
?>
           <form id="form_link" method="post" class="form-horizontal" data-table="lv_link" data-fldid="linkid" data-fldname="linkname"  enctype="multipart/form-data" >      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label" for="chater"><?=get_lang('link_edit_lb_owner')?></label> 
                        <div class="control-value">
                            <select id="chater" name="chater" class="form-control data-field">
                                <option value=""><?=get_lang('link_edit_option')?></option>
								<?php
								foreach($data as $row)
								{
								?>
                                <option value="<?=$row["userid"]?>"><?=$row["username"]?></option>
								<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="linkname"><?=get_lang('link_edit_lb_name')?></label> 
                        <div class="control-value">
                            <input type="text" id="linkname" name="linkname"  class="form-control specialCharValidate data-field" required  />
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="linkurl"><?=get_lang('link_edit_lb_path')?></label> 
                        <div class="control-value">
                            <input type="text" id="linkurl" name="linkurl"  class="form-control data-field"  required/>
                            <a href="javascript:void(0);" onclick="$('#container_link').toggle()"><?=get_lang('link_edit_attach')?></a>
                            <div id="container_link" style="display:none;">
                                <input type="file" id="file" name="file"  class="form-control pull-left mr" style="width:350px;" />
                                <button type="button" class="btn btn-default pull-left" id="btn_upload" onclick="uploadFile()" ><?=get_lang('link_edit_btn_upload')?></button>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
				<input type="hidden" name="linkid" id="linkid"class="form-control data-field" value="<?=getAutoId()?>" /> 
              </div>
            </form>
             
<script type="text/javascript">
var dataForm ;
var linkId = "<?=g("id") ?>"; 
$(document).ready(function(){
   dataForm = $("#form_link").attr("data-id",linkId).dataForm({getcallback:link_getCallBack,savecallback:link_saveCallBack});
    $("#btn_save").click(function(){
        save();
        return false ;
    })
    
    
})




</script>