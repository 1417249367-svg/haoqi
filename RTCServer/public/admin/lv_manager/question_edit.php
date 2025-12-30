<?php  require_once("../include/fun.php");?>
<?php
//$chater = new Model("lv_question");
//$data = $chater -> getList();
$ord = 0 ;
if (g("id") == "")
{
	$sql = " select count(*)+1 as c from lv_question " ;
	$db = new DB();
	$ord = $db -> executeDataValue($sql);
}
$chater = new Model("lv_chater");
$data = $chater -> getList();
?>
           <form id="form_question" method="post" class="form-horizontal" data-table="lv_question" data-fldid="questionid" data-fldname="subject"  enctype="multipart/form-data" >      
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
                        <label class="control-label" for="subject"><?=get_lang('question_edit_lb_subject')?></label> 
                        <div class="control-value">
                            <input type="text" id="subject" name="subject"  class="form-control specialCharValidate data-field" required  />
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="usertext"><?=get_lang('question_edit_lb_usertext')?></label> 
                        <div class="control-value">
                            <textarea name="usertext" id="usertext" placeholder="<?=get_lang("question_edit_lb_usertext_desc")?>" class="form-control data-field specialCharValidate" rows="10" maxlength="3000"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group form-group-left">
                        <label class="control-label" for="to_type"><?=get_lang('chater_edit_lb_status')?></label>
                        <div class="control-value">
                            <select name="to_type" id="to_type" class="form-control data-field form-control"  >
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
                    
                    <div class="form-group">
                        <label class="control-label" for="col_match"><?=get_lang('chater_edit_lb_match')?></label>
                        <div class="control-value">
                            <select name="col_match" id="col_match" class="form-control data-field form-control"  >
                                <option value="0"><?=get_lang('chater_edit_option_match0')?></option>
                                <option value="1"><?=get_lang('chater_edit_option_match1')?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="col_receive"><?=get_lang('chater_edit_lb_receives_reminders')?></label>
                        <div class="control-value">
                            <label class="checkbox-inline"><input class="data-field" type="checkbox" id="col_receive" name="col_receive" value="1" value-unchecked="0"/> <?=get_lang("chater_edit_lb_receives_reminders_alert")?></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="col_top"><?=get_lang('chater_edit_lb_top_questions')?></label>
                        <div class="control-value">
                            <label class="checkbox-inline"><input class="data-field" type="checkbox" id="col_top" name="col_top" value="1" value-unchecked="0"/> <?=get_lang("chater_edit_lb_top_questions_alert")?></label>
                        </div>
                    </div>

                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
				<input type="hidden" name="questionid" id="questionid"class="form-control data-field" value="<?=getAutoId()?>" /> 
              </div>
            </form>
             
<script type="text/javascript">
var dataForm ;
var QuestionId = "<?=g("id") ?>"; 
$(document).ready(function(){
   if (!QuestionId) CKEDITOR.replace('usertext');
   dataForm = $("#form_question").attr("data-id",QuestionId).dataForm({getcallback:question_getCallBack,savecallback:question_saveCallBack});
    $("#btn_save").click(function(){
        save();
        return false ;
    })
    
    
})




</script>