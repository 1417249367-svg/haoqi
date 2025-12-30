<?php  require_once("../include/fun.php");?>
<?php
$ord = 0 ;
if (g("id") == "")
{
	$sql = " select count(*)+1 as c from lv_chater " ;
	$db = new DB();
	$ord = $db -> executeDataValue($sql);
}
?>

           <form id="form" method="post" class="form-horizontal" data-obj="livechat_kf" data-table="lv_chater" data-fldid="id" data-fldname="loginname" data-label="lv_chater" enctype="multipart/form-data" >
              <div class="modal-body" style="padding-top:0px;">
                    <div>
                        <div class="user-photo" >
                            <img id="img_picture" class="photo" title="<?=get_lang('chater_edit_photo')?>" style="width:90px;height:90px" />
                            <input type="file" id="file_picture" name="file_picture"  class="file-picture pic" onchange="uploadFile(this)"/>
                        </div>
                    </div>

                    <div class="form-group form-group-left" style="margin-top:0px;padding-top:0px">
                        <label class="control-label" for="loginname"><?=get_lang('chater_edit_lb_account')?></label>
                        <div class="control-value"><input type="text" name="loginname" id="loginname" placeholder="<?=get_lang('chater_edit_ph_account')?>" class="form-control specialCharValidate data-field data-keyfield" maxlength="50" value=""  required /> </div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="username" ><?=get_lang('chater_edit_lb_name')?></label>
                        <div class="control-value"><input type="text" name="username" id="username" placeholder="<?=get_lang('chater_edit_ph_name')?>" class="form-control specialCharValidate data-field" maxlength="20"  required /> </div>
                    </div>
                    <div class="clear"></div>

                    <div class="form-group form-group-left">
                        <label class="control-label" for="dept"><?=get_lang('chater_edit_lb_dept')?></label>
                        <div class="control-value"><input type="text" name="deptname" id="deptname" placeholder="<?=get_lang('chater_edit_ph_dept')?>" class="form-control specialCharValidate data-field form-control"    maxlength="50"  /></div>
                    </div>
                    <div class="form-group form-group-right">
                         <label class="control-label" for="jobtitle"><?=get_lang('chater_edit_lb_job')?></label>
                         <div class="control-value"><input type="text" name="jobtitle" id="jobtitle" placeholder="<?=get_lang('chater_edit_ph_job')?>" class="form-control specialCharValidate data-field form-control"    maxlength="50"  /></div>
                    </div>
                    <div class="clear"></div>


                    <div class="form-group form-group-left">
                        <label class="control-label" for="phone"><?=get_lang('chater_edit_lb_tel')?></label>
                        <div class="control-value"><input type="text" name="phone" id="phone" placeholder="<?=get_lang('chater_edit_ph_tel')?>" class="form-control specialCharValidate data-field form-control"  maxlength="50"  /></div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="mobile"><?=get_lang('chater_edit_lb_mobile')?></label>
                        <div class="control-value"><input type="text" name="mobile" id="mobile" placeholder="<?=get_lang('chater_edit_ph_mobile')?>" class="form-control specialCharValidate data-field form-control"   maxlength="50" /> </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="form-group form-group-left">
                        <label class="control-label" for="email"><?=get_lang('chater_edit_lb_email')?></label>
                        <div class="control-value"><input type="text" name="email" id="email" placeholder="<?=get_lang('chater_edit_ph_email')?>" class="form-control specialCharValidate data-field"  maxlength="50"  /></div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="reception"><?=get_lang('chater_edit_lb_reception')?></label>
                        <div class="control-value"><input type="text" name="reception" id="reception" value="1000" placeholder="<?=get_lang('chater_edit_ph_reception')?>" class="form-control specialCharValidate data-field"   maxlength="50" /> </div>
                    </div>
                    <div class="clear"></div>

                    <div class="form-group">
                        <label class="control-label" for="welcome"><?=get_lang('chater_edit_lb_welcome')?></label>
                        <div class="control-value">
                            <textarea name="welcome" id="welcome" placeholder="<?=get_lang('chater_edit_ph_welcome')?>" class="form-control specialCharValidate data-field"  rows="3" > </textarea>
                       <!-- <div id="welcome"></div>-->
                        </div>
                    </div>

                    <div class="form-group form-group-left">
                        <label class="control-label" for="defaultreception"><?=get_lang('chater_list_chatgpt_reception')?></label>
                        <div class="control-value">
                            <select name="defaultreception" id="defaultreception" class="form-control data-field form-control"  >
                                <option value="0"><?=get_lang('chater_list_chatgpt_reception3')?></option>
                                <option value="1"><?=get_lang('chater_list_chatgpt_reception1')?></option>
                                <option value="2"><?=get_lang('chater_list_chatgpt_reception2')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-right">
                        <label class="control-label" for="ord"><?=get_lang('chater_edit_lb_order')?></label>
                        <div class="control-value">
                            <input type="text" name="ord" id="ord" placeholder="<?=get_lang('chater_edit_ph_order')?>" class="form-control specialCharValidate data-field int form-control"    maxlength="6"  required value="<?=$ord?>" />
                        </div>
                    </div>
                    
                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
                <input type="hidden" name="picture" id="picture"class="form-control data-field"   maxlength="50"  />
				<input type="hidden" name="userid" id="userid"class="form-control data-field" value="<?=getAutoId()?>" />
                <input type="hidden" name="checkloginname" id="checkloginname"class="form-control" value="1" />
                <input type="hidden" name="status" id="status"class="form-control data-field" value="1"/>
              </div>
            </form>

<script type="text/javascript">
var dataForm ;
var userId = "<?=g("id") ?>";
var appPath = "<?=getRootPath() ?>";
var defaultImg = appPath + "/livechat/assets/img/default.png" ;

$(document).ready(function(){
   
   $("#img_picture").attr("src", defaultImg) ;

   if (userId != "")
   {
	    $("#loginname").attr("disabled",true);
   }
   if (!userId) CKEDITOR.replace('welcome');
   dataForm = $("#form").attr("data-id",userId).dataForm({getcallback:chater_getCallBack,savecallback:chater_saveCallBack});
    $("#btn_save").click(function(){
        saveUserInfo();
        return false ;
    })

	$("#loginname").blur(function(){checkLoginName();})
})

function checkLoginName()
{
	if (userId != "")
		return ;

	var _loginName = $("#loginname").val();
	var _pos = _loginName.indexOf("@");
	if (_pos > -1)
		_loginName = _loginName.substring(0,_pos);

    var url = getAjaxUrl("livechat_kf","search_user") ;
	//document.write(url+"&key="+_loginName);
    $.ajax({
       type: "POST",
       dataType:"json",
       data:{"key":_loginName},
       url: url,
       success: function(result){
            if (result.recordcount > 0)
			{
				var row = result.rows[0] ;
				$("#username").val(row.username) ;
				$("#jobtitle").val(row.jobtitle) ;
				$("#deptname").val(row.deptname) ;
				$("#phone").val(row.phone) ;
				$("#mobile").val(row.mobile) ;
				$("#email").val(row.email) ;
				$("#checkloginname").val(1) ;
			}
			else
			{
				$("#checkloginname").val(0) ;
				myAlert("<?=get_lang('chater_edit_alert')?>");
			}
       },
       error: function(result){

       }
    });
}

function saveUserInfo()
{
    if ($("#checkloginname").val() == 0)
    {
        setElementError($("#loginname"),"<?=get_lang('chater_edit_alert')?>");
        return false ;
    }
	if ($("#loginname").val() == "")
    {
        setElementError($("#loginname"),"<?=get_lang('chater_edit_error_account')?>");
        return false ;
    }
    if ($("#username").val() == "")
    {
        setElementError($("#username"),"<?=get_lang('chater_edit_error_name')?>");
        return false ;
    }
    var ord = $("#ord").val();

    if (isNaN(ord))
		ord = 0 ;

    if(ord <= 0 )
	{
    	setElementError($("#ord"),"<?=get_lang('chater_edit_error_ord')?>");
    	return;
	}
	
    var reception = $("#reception").val();
    if (isNaN(reception))
		reception = 0 ;
    if(reception < 0 )
	{
    	setElementError($("#reception"),langs.livechat_edit_reception_require_integer);
    	return;
	}
	for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
	var welcome=$("#welcome").val();
	welcome=replaceAll(welcome,"\n","");
	var Request = new Object(); 
	var newContent= welcome.replace(/<img [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{e@"+Request['name']+"|0|0|}";
		return newStr;
	});
	newContent= newContent.replace(/<video [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{i@"+Request['name']+"|0|0|FileRecv/MessageVideoPlay.png}";
		return newStr;
	});
	 $("#welcome").val(newContent);
    dataForm.save();
}
</script>