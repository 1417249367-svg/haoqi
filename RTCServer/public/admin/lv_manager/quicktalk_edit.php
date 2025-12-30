<?php  require_once("../include/fun.php");?>
<?php
//$chater = new Model("lv_quicktalk");
//$data = $chater -> getList();
$ord = 0 ;
if (g("id") == "")
{
	$sql = " select count(*)+1 as c from lv_quicktalk " ;
	$db = new DB();
	$ord = $db -> executeDataValue($sql);
}
$chater = new Model("lv_chater");
$data = $chater -> getList();
?>
           <form id="form_quicktalk" method="post" class="form-horizontal" data-table="lv_quicktalk" data-fldid="talkid" data-fldname="subject"  enctype="multipart/form-data" >      
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
                        <label class="control-label" for="usertext"><?=get_lang('quicktalk_edit_lb_usertext')?></label> 
                        <div class="control-value">
                            <textarea name="usertext" id="usertext" placeholder="<?=get_lang("quicktalk_edit_lb_usertext_desc")?>" class="form-control data-field specialCharValidate" rows="10" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="form-group form-group-left">
                        <label class="control-label" for="status"><?=get_lang('chater_edit_lb_status')?></label>
                        <div class="control-value">
                            <select name="status" id="status" class="form-control data-field form-control"  >
                                <option value="1"><?=get_lang('chater_edit_option_status1')?></option>
                                <option value="0"><?=get_lang('chater_edit_option_status0')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="ord"><?=get_lang('chater_edit_lb_order')?></label>
                        <div class="control-value">
                            <input type="text" name="ord" id="ord" placeholder="<?=get_lang('chater_edit_ph_order')?>" class="form-control specialCharValidate data-field int form-control"    maxlength="50"  required value="<?=$ord?>" />
                        </div>
                    </div>
                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
				<input type="hidden" name="talkid" id="talkid"class="form-control data-field" value="<?=getAutoId()?>" /> 
              </div>
            </form>
             
<script type="text/javascript">
var dataForm ;
var talkid = "<?=g("id") ?>"; 
$(document).ready(function(){
   dataForm = $("#form_quicktalk").attr("data-id",talkid).dataForm({getcallback:quicktalk_getCallBack,savecallback:quicktalk_saveCallBack});
    $("#btn_save").click(function(){
        save();
        return false ;
    })
    
    
})




</script>