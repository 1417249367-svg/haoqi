<?php  require_once("../include/fun.php");?>
           <form id="form" method="post" class="form-horizontal" data-obj="livechat_kf" data-table="lv_user" data-fldid="userid" data-fldname="username" data-label="lv_user" enctype="multipart/form-data" >
              <div class="modal-body" style="padding-top:0px;">
                    <div class="form-group form-group-left" style="margin-top:0px;padding-top:0px">
                        <label class="control-label" for="username"><?=get_lang('user_edit_lb_name')?></label>
                        <div class="control-value"><input type="text" name="username" id="username" placeholder="<?=get_lang('user_edit_ph_name')?>" class="form-control specialCharValidate data-field" maxlength="50" value="" /> </div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="phone" ><?=get_lang('user_edit_lb_mobile')?></label>
                        <div class="control-value"><input type="text" name="phone" id="phone" placeholder="<?=get_lang('user_edit_ph_mobile')?>" class="form-control specialCharValidate data-field" maxlength="50"  required /> </div>
                    </div>
                    <div class="clear"></div>

                    <div class="form-group form-group-left">
                        <label class="control-label" for="email"><?=get_lang('user_edit_lb_email')?></label>
                        <div class="control-value"><input type="text" name="email" id="email" placeholder="<?=get_lang('user_edit_ph_email')?>" class="form-control specialCharValidate data-field"    maxlength="50"  /></div>
                    </div>
                    <div class="form-group form-group-right">
                         <label class="control-label" for="wechat"><?=get_lang('user_edit_lb_wechat')?></label>
                         <div class="control-value"><input type="text" name="wechat" id="wechat" placeholder="<?=get_lang('user_edit_ph_wechat')?>" class="form-control specialCharValidate data-field"    maxlength="50"  /></div>
                    </div>
                    <div class="clear"></div>


                    <div class="form-group form-group-left">
                        <label class="control-label" for="qq"><?=get_lang('user_edit_lb_qq')?></label>
                        <div class="control-value"><input type="text" name="qq" id="qq" placeholder="<?=get_lang('user_edit_ph_qq')?>" class="form-control specialCharValidate data-field"  maxlength="50"  /></div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="chater"><?=get_lang('user_edit_lb_chater')?></label>
                        <div class="control-value"><input type="text" name="chater" id="chater" placeholder="<?=get_lang('user_edit_ph_chater')?>" class="form-control specialCharValidate data-field"   maxlength="50" /> </div>
                    </div>
                    <div class="clear"></div>
                    


                    <div class="form-group">
                        <label class="control-label" for="remarks"><?=get_lang("user_edit_lb_remarks")?></label>
                        <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="remarks" name="remarks" maxlength="70" ></textarea> </div>
                        </div>
                    </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
              </div>
            </form>

<script type="text/javascript">
var dataForm ;
var userId = "<?=g("id") ?>";
var appPath = "<?=getRootPath() ?>";
var defaultImg = appPath + "/livechat/assets/img/default.png" ;

$(document).ready(function(){
   dataForm = $("#form").attr("data-id",userId).attr("data-query", "label=lv_user").dataForm({getcallback:user_getCallBack,savecallback:user_saveCallBack});
    $("#btn_save").click(function(){
        saveUserInfo();
        return false ;
    })

	$("#chater").blur(function(){checkLoginName();})
})

function user_saveCallBack()
{
	dataList.reload();
	dialogClose("user");
}

function user_getCallBack(data)
{

}


function checkLoginName()
{
	if (userId == "")
		return ;

	var _loginName = $("#chater").val();
	var _pos = _loginName.indexOf("@");
	if (_pos > -1)
		_loginName = _loginName.substring(0,_pos);
		
	if (_loginName == "")
		return ;

    var url = getAjaxUrl("livechat_kf","ChaterDetail") ;
	//document.write(url+"&chater="+_loginName);
    $.ajax({
       type: "POST",
       dataType:"json",
       data:{"chater":_loginName},
       url: url,
       success: function(result){
            if (result.status)
			{

			}
			else
			{
				$("#chater").val('');
				myAlert("<?=get_lang('user_edit_alert')?>");
			}
       },
       error: function(result){

       }
    });
}

function saveUserInfo()
{
	dataForm.save();
}
</script>