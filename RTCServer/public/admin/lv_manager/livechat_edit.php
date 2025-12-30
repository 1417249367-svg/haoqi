<?php  require_once("../include/fun.php");?>
<script language="javascript" src="../assets/js/sysconfig.js?ver=20150512"></script>
           <form  id="form1" method="post" class="form-horizontal">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang('chater_list_attributes')?></a></li>
                         <li><a href="#board" data-toggle="tab"><?=get_lang('chater_list_generate')?></a></li> 
                    </ul>
                    <div class="tab-content" id="base">
                        <div class="form-group">
                            <label class="control-label" for="ipaddress"><?=get_lang('chater_list_server')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_alert_enteripaddress')?>" class="form-control data-field  specialCharValidate" required id="ipaddress"  name="ipaddress"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="switchType"><?=get_lang('chater_list_switchtype')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="switchType" name="switchType" value="1"><i class="fl" style="padding:5px;"><?=get_lang("chater_list_switchtype_alert1")?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="waitTime" name="waitTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_switchtype_alert2")?></i></label>
							</div>
                        </div>                 
                        <div class="form-group">
                            <label class="control-label" for="rejectType"><?=get_lang('chater_list_rejecttype')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="rejectType" name="rejectType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_rejecttype_alert1')?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="intervalTime" name="intervalTime" style="width:60px" /><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_rejecttype_alert2')?></i> </label>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="welcomeText"><?=get_lang('chater_edit_lb_welcome')?></label>
                            <div class="control-value">
                                <textarea name="welcomeText" id="welcomeText" placeholder="<?=get_lang('chater_edit_ph_welcome')?>" class="form-control specialCharValidate data-field"  rows="3" > </textarea>
                            </div>
                        </div>
                    </div>

                    
					<div class="tab-content" id="board">
                        <div class="form-group">
                            <label class="control-label" for="webcode"><a href="#" onclick="chater_view();"><?=get_lang('chater_list_preview')?></a><br><br><a href="#" onclick="copyUrl2()"><?=get_lang('chater_list_copy')?></a></label>
                            <div class="control-value"><textarea name="webcode" id="webcode" placeholder="" class="form-control" rows="5" maxlength="100"></textarea> </div>
                        </div>
                    </div>

                    <div class="tab-content" id="tag" style="padding:5px;">
                            <div id="tag_container" class="tag_list"></div>
                    </div>
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
				<input type="hidden" class="data-field" id="user_id" name="user_id" />
              </div>
            </form>

<script type="text/javascript">

var dataForm ;
var treeUser ;
var treeOrg ;
var groupId = "1" ;
var groupName = "<?=g("groupname") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";
genre = "LivechatConfig" ;

$(document).ready(function(){
//	$("#btn_save").click(function(){
//        saveForm();
//        return false ;
//    })
    formatTabs("tabs");
	load_config();
	$("#btn_save").click(function(){
		save_config();
	})
   //livechat_detail_init();
})

function load_data(result)
{   
	$("#ipaddress").val(replaceAll(result.ipaddress,"@@@","\\")) ;
	$("#waitTime").val(replaceAll(result.waitTime,"@@@","\\")) ;
	$("#intervalTime").val(replaceAll(result.intervalTime,"@@@","\\")) ;
	$("#welcomeText").val(replaceAll(result.welcomeText,"@@@","\\")) ;
	if (result.switchType == 1)
		$("#switchType").attr("checked",true);
	if (result.rejectType == 1)
		$("#rejectType").attr("checked",true);


}

function get_data()
{
	clear_data();
	append_data("ipaddress",$("#ipaddress").val());
	append_data("waitTime",$("#waitTime").val());
	append_data("intervalTime",$("#intervalTime").val());
	append_data("welcomeText",$("#welcomeText").val());
	append_data("switchType",$("#switchType").is(":checked")?1:-1);
	append_data("rejectType",$("#rejectType").is(":checked")?1:-1);
}
</script>