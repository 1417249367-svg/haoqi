<?php  require_once("../include/fun.php");?>
<?php
define("MENU","LIVECHAT_SET") ;
$ad=file_exist(__ROOT__."/templets/xiazai/ad.png")?1:0;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_ro.js"></script>
	<script type="text/javascript" src="../assets/js/userpicker3.js"></script>
	<script language="javascript" src="../assets/js/sysconfig.js"></script>
    <script type="text/javascript" src="../assets/js/skin.js"></script>
    <script src="/static/js/msg_reader.js"></script>
    <script src="/static/js/ckeditor/ckeditor.js"></script>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("lvchat_private_title")?></h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" ><?=get_lang("doc_private_notice")?></div>
                    <form id="form-client" method="post" class="form-horizontal" enctype="multipart/form-data" style="width:800px;">
					<fieldset>
						<legend><?=get_lang('chater_list_server_configuration')?></legend>
                        <div class="form-group">
                            <label class="control-label" for="ipaddress"><?=get_lang('chater_list_server')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_alert_enteripaddress')?>" class="form-control data-field  specialCharValidate" required id="ipaddress"  name="ipaddress"/> </div>
                        </div>
                        
                        <div class="form-group">                            
                        <label class="control-label" for="chaterMode"><?=get_lang('chater_list_mode')?></label>
                            <div class="control-value">
                            <input type="radio"  name="chaterMode" value="0"/><?=get_lang('chater_list_mode_alert1')?><input type="radio"  name="chaterMode" value="1"/><?=get_lang('chater_list_mode_alert2')?>
                            </div>
                        </div>
                        <div class="form-group">                            
                        <label class="control-label" for="chaterDistribution"><?=get_lang('chater_list_distribution')?></label>
                            <div class="control-value">
                            <input type="radio"  name="chaterDistribution" value="0"/><?=get_lang('chater_list_distribution_alert1')?><input type="radio"  name="chaterDistribution" value="1"/><?=get_lang('chater_list_distribution_alert2')?>
                            </div>
                        </div>
                        <div class="form-group">                            
                        <label class="control-label" for="GuestSession"><?=get_lang('chater_list_guestsession')?></label>
                            <div class="control-value">
                            <input type="radio"  name="GuestSession" value="1"/><?=get_lang('chater_list_guestsession_alert1')?><input type="radio"  name="GuestSession" value="2"/><?=get_lang('chater_list_guestsession_alert2')?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="oldVisitorType"><?=get_lang('chater_list_oldvisitor')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="oldVisitorType" name="oldVisitorType" value="1"><i class="fl" style="padding:5px;"><?=get_lang("chater_list_oldvisitor_alert1")?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="oldVisitorTime" name="oldVisitorTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_oldvisitor_alert2")?></i></label>
							</div>
                        </div>   
                        
                        <div class="form-group">
                            <label class="control-label" for="voiceVideoType"><?=get_lang('chater_list_voicevideo')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="voiceVideoType" name="voiceVideoType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_voicevideo_alert1')?></i> </label>
							</div>
                        </div>
                         
                        <div class="form-group">
                            <label class="control-label" for="showHistoryType"><?=get_lang('chater_list_showhistory')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="showHistoryType" name="showHistoryType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_showhistory_alert1')?></i> </label>
							</div>
                            <div class="control-value">
                                <label class="checkbox-inline" ><i class="fl" style="padding:5px;"><?=get_lang("chater_list_history_alert1")?></i> <input type="text"  class="form-control data-field specialCharValidate fl digits"  min="0" max="9999" id="clearHistoryTime" name="clearHistoryTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_history_alert2")?></i><input type="button" class="btn btn-info btn-xs" id="btn_ios" value="<?=get_lang('chater_list_history_alert1')?>" onclick="clearHistory()" /></label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="switchType"><?=get_lang('chater_list_reminder')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="switchType" name="switchType" value="1"><i class="fl" style="padding:5px;"><?=get_lang("chater_list_reminder_alert1")?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="waitTime" name="waitTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_reminder_alert2")?></i></label>
							</div>
                        </div>   
                        
                        <div class="form-group">
                            <label class="control-label" for="freeType"><?=get_lang('chater_list_transfer')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="freeType" name="freeType" value="1"><i class="fl" style="padding:5px;"><?=get_lang("chater_list_transfer_alert1")?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="freeTime" name="freeTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_transfer_alert2")?></i></label>
							</div>
                        </div> 
                          
                        <div class="form-group">
                            <label class="control-label" for="websiteType"><?=get_lang('chater_list_websitetype')?></label>
                            <div class="control-value">
                            <input type="radio"  name="websiteType" value="0"/><?=get_lang('chater_list_websitetype_alert5')?><input type="radio"  name="websiteType" value="1"/><?=get_lang('chater_list_websitetype_alert2')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" action-data="1" action-type="chater_ro_member"><?=get_lang("btn_setkefumember")?></a><input type="radio"  name="websiteType" value="2"/><?=get_lang('chater_list_websitetype_alert4')?>
                            </div>

                            
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="dialogType" name="dialogType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_websitetype_alert3')?></i> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fl" style="padding:5px;"><a href="javascript:void(0);" action-data="1" action-type="chater_ro_member1"><?=get_lang("btn_setkefumember1")?></a></i></label>
							</div>
                            </div>
                        <div class="form-group">
                            <label class="control-label" for="switchWeChat"><?=get_lang('chater_list_switchweChat')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="switchWeChat" name="switchWeChat" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_switchweChat_alert2')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/lv_manager/chater_wechat_list.html?flag=1"><?=get_lang("btn_setpublic")?></a></i> </label>
							</div>
                        </div>  
                        <div class="form-group">
                            <label class="control-label" for="switchBack"><?=get_lang('chater_list_switchBack')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="switchBack" name="switchBack" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_switchBack_alert1')?></i> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fl" style="padding:5px;"><a href="javascript:void(0);" action-data="1" action-type="chater_ro_member2"><?=get_lang("btn_setkefumember2")?></a></i> </label>
							</div>
                        </div>  
                        <div class="form-group">
                            <label class="control-label" for="sendWelcome"><?=get_lang('chater_list_sendWelcome')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="sendWelcome" name="sendWelcome" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_sendWelcome_alert1')?></i> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fl" style="padding:5px;"><a href="javascript:void(0);" action-data="1" action-type="chater_ro_member4"><?=get_lang("btn_setkefumember4")?></a></i> </label>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="switchDomainType"><?=get_lang('chater_list_switchDomainType')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="switchDomainType" name="switchDomainType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_switchDomainType_alert1')?></i> </label>
							</div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label" for="rejectType"><?=get_lang('chater_list_rejecttype')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="rejectType" name="rejectType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_rejecttype_alert2')?></i> </label>
							</div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label" for="weixinType"><?=get_lang('chater_list_weixintype')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="weixinType" name="weixinType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_weixintype_alert2')?></i> </label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="beatTime"><?=get_lang('chater_list_heartbeat')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><i class="fl" style="padding:5px;"><?=get_lang("chater_list_heartbeat")?></i><input type="text"  class="form-control data-field specialCharValidate fl digits"  min="0" max="9999" id="beatTime" name="beatTime" style="width:60px" /><i class="fl" style="padding:5px;"><?=get_lang("chater_list_heartbeat_alert1")?></i> </label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="cdnType"><?=get_lang('chater_list_cdntype')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="cdnType" name="cdnType" value="1"><input type="text" placeholder="<?=get_lang('chater_edit_lb_cdn_title')?>" class="form-control data-field  specialCharValidate fl" required id="cdnLink"  name="cdnLink" style="width:200px" /><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_cdntype_alert2')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://k.qiyeim.com/a/news/fangan/207.html" target="_blank"><?=get_lang("btn_setcdn")?></a></i> </label>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="welcomeText"><?=get_lang('chater_invite_lb_welcome')?></label>
                            <div class="control-value"><input type="checkbox" id="welcomeType" name="welcomeType" value="1">
                                <textarea name="welcomeText" id="welcomeText" placeholder="<?=get_lang('chater_invite_ph_welcome')?>" class="form-control specialCharValidate data-field"  rows="3" > </textarea>
                            </div>
                        </div>
					</fieldset>
                                            
					<fieldset>
						<legend><?=get_lang('chater_list_chatgpt_configuration')?></legend>
                        
                        <div class="form-group">
                            <label class="control-label" for="DefaultReception"><?=get_lang('chater_list_chatgpt_reception')?></label>
                            <div class="control-value">
                                <select name="DefaultReception" id="DefaultReception" class="form-control data-field form-control"    style="width:120px;" >
                                    <option value="0"><?=get_lang('chater_list_chatgpt_reception3')?></option>
                                    <option value="1"><?=get_lang('chater_list_chatgpt_reception1')?></option>
                                    <option value="2"><?=get_lang('chater_list_chatgpt_reception2')?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ChatGPTTransferType"><?=get_lang('chater_list_chatgpt_transfer')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="ChatGPTTransferType" name="ChatGPTTransferType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_chatgpt_transfer_desc')?></i> </label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ChatGPTAutoTransferType"><?=get_lang('chater_list_chatgpt_autotransfer')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="ChatGPTAutoTransferType" name="ChatGPTAutoTransferType" value="1"><i class="fl" style="padding:5px;"><?=get_lang("chater_list_chatgpt_autotransfer_desc")?></i> <input type="text"  class="form-control data-field  specialCharValidate fl digits"  min="0" max="9999" id="ChatGPTAutoTransferTime" name="ChatGPTAutoTransferTime" style="width:60px" /> <i class="fl" style="padding:5px;"><?=get_lang("chater_list_chatgpt_autotransfer_desc1")?></i></label>
							</div>
                        </div>  
                                
                        <div class="form-group">
                            <label class="control-label" for="ChatGPTType"><?=get_lang('chater_list_chatgpt')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="ChatGPTType" name="ChatGPTType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_chatgpt_desc')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://k.qiyeim.com/a/news/fangan/209.html" target="_blank"><?=get_lang("btn_setcdn")?></a></i> </label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="ChatGPTAppid"><?=get_lang('chater_list_chatgpt_API_Key')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_chatgpt_API_Key_desc')?>" class="form-control data-field  specialCharValidate" required id="ChatGPTAppid"  name="ChatGPTAppid"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ChatGPTKey"><?=get_lang('chater_list_chatgpt_Secret_Key')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_chatgpt_Secret_Key_desc')?>" class="form-control data-field  specialCharValidate" required id="ChatGPTKey"  name="ChatGPTKey"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DefaultModel"><?=get_lang('chater_list_chatgpt_Model')?></label>
                            <div class="control-value">
                                <select name="DefaultModel" id="DefaultModel" class="form-control data-field form-control"    style="width:120px;" onChange="doc_url();">
                                    <option value="0"><?=get_lang('chater_list_chatgpt_Model')?></option>
                                    <option value="1"><?=get_lang('chater_list_chatgpt_Model1')?></option>
                                    <option value="2"><?=get_lang('chater_list_chatgpt_Model2')?></option>
                                    <option value="3"><?=get_lang('chater_list_chatgpt_Model3')?></option>
                                    <option value="4"><?=get_lang('chater_list_chatgpt_Model4')?></option>
                                    <option value="5"><?=get_lang('chater_list_chatgpt_Model5')?></option>
                                    <option value="6"><?=get_lang('chater_list_chatgpt_Model6')?></option>
                                    <option value="7"><?=get_lang('chater_list_chatgpt_Model7')?></option>
                                    <option value="8"><?=get_lang('chater_list_chatgpt_Model8')?></option>
                                    <option value="9"><?=get_lang('chater_list_chatgpt_Model9')?></option>
                                    <option value="10"><?=get_lang('chater_list_chatgpt_Model10')?></option>
                                    <option value="11"><?=get_lang('chater_list_chatgpt_Model11')?></option>
                                    <option value="12"><?=get_lang('chater_list_chatgpt_Model12')?></option>
                                    <option value="13"><?=get_lang('chater_list_chatgpt_Model13')?></option>
                                    <option value="14"><?=get_lang('chater_list_chatgpt_Model14')?></option>
                                    <option value="15"><?=get_lang('chater_list_chatgpt_Model15')?></option>
                                    <option value="16"><?=get_lang('chater_list_chatgpt_Model16')?></option>
                                    <option value="17"><?=get_lang('chater_list_chatgpt_Model17')?></option>
                                    <option value="18"><?=get_lang('chater_list_chatgpt_Model18')?></option>
                                    <option value="19"><?=get_lang('chater_list_chatgpt_Model19')?></option>
                                    <option value="20"><?=get_lang('chater_list_chatgpt_Model20')?></option>
                                    <option value="21"><?=get_lang('chater_list_chatgpt_Model21')?></option>
                                    <option value="22"><?=get_lang('chater_list_chatgpt_Model22')?></option>
                                    <option value="23"><?=get_lang('chater_list_chatgpt_Model23')?></option>
                                    <option value="24"><?=get_lang('chater_list_chatgpt_Model24')?></option>
                                    <option value="25"><?=get_lang('chater_list_chatgpt_Model25')?></option>
                                    <option value="26"><?=get_lang('chater_list_chatgpt_Model26')?></option>
                                    <option value="27"><?=get_lang('chater_list_chatgpt_Model27')?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="DefaultModelurl"><?=get_lang('chater_list_chatgpt_API_Url')?></label>
                            <div class="control-value"><input type="text" class="form-control data-field  specialCharValidate" required id="DefaultModelurl"  name="DefaultModelurl"/> </div>
                        </div>
                    </fieldset>
                                           
					<fieldset>
						<legend><?=get_lang('chater_list_baidu_translate_configuration')?></legend>
                        <div class="form-group">
                            <label class="control-label" for="translateType"><?=get_lang('chater_list_baidu_translate')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="translateType" name="translateType" value="1"><i class="fl" style="padding:5px;"> <?=get_lang('chater_list_baidu_translate_desc')?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://k.qiyeim.com/a/news/fangan/208.html" target="_blank"><?=get_lang("btn_setcdn")?></a></i> </label>
							</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="translateAppid"><?=get_lang('chater_list_baidu_translate_appid')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_baidu_translate_appid_desc')?>" class="form-control data-field  specialCharValidate" required id="translateAppid"  name="translateAppid"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="translateKey"><?=get_lang('chater_list_baidu_translate_key')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_baidu_translate_key_desc')?>" class="form-control data-field  specialCharValidate" required id="translateKey"  name="translateKey"/> </div>
                        </div>
                    </fieldset>
                    
					<fieldset>
						<legend><?=get_lang('chater_list_advertising_configuration')?></legend>
                        <div class="form-group">
                            <label class="control-label" for="switchAd"><?=get_lang('chater_edit_lb_ad')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" class="fl" id="switchAd" name="switchAd" value="1"><input type="text" placeholder="<?=get_lang('chater_edit_lb_adlink_alert')?>" class="form-control data-field  specialCharValidate" required id="adlink"  name="adlink" style="width:300px" /> </label>
							</div>
                        </div>    
                        
                       <div class="form-group" style="height: 60px;margin: auto;position: relative;"><?=get_lang('chater_edit_lb_ad_img')?>:
                            <img id="img_ad" class="photo"  title="<?=get_lang('chater_edit_lb_ad_title')?>" alt="<?=get_lang('chater_edit_lb_ad_title')?>" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_ad" name="file_ad"  class="logo-picture pic" onchange="uploadFile('ad')" style="outline: none;" accept=".png"/> <a href="#" onClick="clear_data('ad')"><?=get_lang('chater_delete_lb_ad_title')?></a>
                        </div>
                    </fieldset>

                        <div class="form-group">
                            <label class="control-label"></label>
                            <div class="control-value"><input type="button"  class="btn btn-primary"  id="btn_save"  value="<?=get_lang("btn_save")?>" /> <input type="hidden" id="ad" name="ad" value="<?=$ad?>"/><!--<input type="hidden" id="OldChatGPTAppid" name="OldChatGPTAppid"/>--></div>
                        </div>
                    </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">
genre = "LivechatConfig" ;

$(document).ready(function(){
    formatTabs("tabs");
	load_config();
	$("#btn_save").click(function(){
//		if((!$("#ChatGPTAppid").val())||$("#ChatGPTAppid").val()==$("#OldChatGPTAppid").val()){
			//console.log('suss2');
			save_config();
//			return ;
//		}
//		var IsChatGPTAppid=0;
//		var xhr = new XMLHttpRequest();
//		xhr.open("POST", "https://api.openai.com/v1/completions", false);
//		xhr.setRequestHeader("Content-Type", "application/json");
//		xhr.setRequestHeader("Authorization", "Bearer " + $("#ChatGPTAppid").val());
//		xhr.onreadystatechange=function()
//		{
//			//console.log('suss',JSON.stringify(xhr));
//			if (xhr.readyState==4 && xhr.status==200){
//				console.log('suss',xhr.responseText);
//				IsChatGPTAppid=1;
//				$("#OldChatGPTAppid").val($("#ChatGPTAppid").val());
//				save_config();
//				return ;
//			}
//		}
//		var data = JSON.stringify({
//			prompt: "test",
//			max_tokens: 2048,
//			model: "text-davinci-003"
//		});
//		xhr.send(data);
//		if(!IsChatGPTAppid) myAlert(langs.lv_ChatGPT_warning);
	})
})

function load_data(result)
{   
	$("#ipaddress").val(replaceAll(result.ipaddress,"@@@","\\")) ;
	$("#oldVisitorTime").val(result.oldVisitorTime) ;
	$("#clearHistoryTime").val(result.clearHistoryTime) ;
	$("#waitTime").val(replaceAll(result.waitTime,"@@@","\\")) ;
	$("#freeTime").val(result.freeTime) ;
	$("#intervalTime").val(replaceAll(result.intervalTime,"@@@","\\")) ;
	$("#beatTime").val(result.beatTime) ;
	$("#ChatGPTAutoTransferTime").val(result.ChatGPTAutoTransferTime) ;
	//$("#welcomeText").val(replaceAll(result.welcomeText,"@@@","\\")) ;
	CKEDITOR.replace('welcomeText');
	CKEDITOR.instances.welcomeText.setData(PastImgEx1(result.welcomeText));
	$("input[name='chaterMode'][value='"+result.chaterMode+"']").attr("checked",true);
	$("input[name='chaterDistribution'][value='"+result.chaterDistribution+"']").attr("checked",true);
	$("input[name='GuestSession'][value='"+result.GuestSession+"']").attr("checked",true);
	$("input[name='websiteType'][value='"+result.websiteType+"']").attr("checked",true);
	if (result.welcomeType == 1)
		$("#welcomeType").attr("checked",true);
	if (result.oldVisitorType == 1)
		$("#oldVisitorType").attr("checked",true);
	if (result.switchType == 1)
		$("#switchType").attr("checked",true);
	if (result.freeType == 1)
		$("#freeType").attr("checked",true);
//	if (result.websiteType == 1)
//		$("#websiteType").attr("checked",true);
	if (result.dialogType == 1)
		$("#dialogType").attr("checked",true);
//	if (result.connectchatType == 1)
//		$("#connectchatType").attr("checked",true);
	if (result.rejectType == 1)
		$("#rejectType").attr("checked",true);
	if (result.weixinType == 1)
		$("#weixinType").attr("checked",true);
	if (result.cdnType == 1)
		$("#cdnType").attr("checked",true);
	if (result.voiceVideoType == 1)
		$("#voiceVideoType").attr("checked",true);
	if (result.showHistoryType == 1)
		$("#showHistoryType").attr("checked",true);
	if (result.switchAd == 1)
		$("#switchAd").attr("checked",true);
	$("#cdnLink").val(result.cdnLink) ;
    $("#adlink").val(result.adlink) ;
    if($("[name=ad]").val()==1) $("#img_ad").attr("src","/templets/xiazai/ad.png");
	else $("#img_ad").attr("src","../assets/img/icon_ad.png");
	
	if (result.switchWeChat == 1)
		$("#switchWeChat").attr("checked",true);
	if (result.switchBack == 1)
		$("#switchBack").attr("checked",true);
	if (result.sendWelcome == 1)
		$("#sendWelcome").attr("checked",true);
	if (result.switchDomainType == 1)
		$("#switchDomainType").attr("checked",true);
	if (result.translateType == 1)
		$("#translateType").attr("checked",true);
	$("#translateAppid").val(result.translateAppid) ;
	$("#translateKey").val(result.translateKey) ;
	var DefaultReception=result.DefaultReception;
	if(!DefaultReception) var DefaultReception=0;
	//$("select[name='DefaultReception'][value='"+DefaultReception+"']").attr("selected",true);
	$("select[name='DefaultReception'] option[value='"+DefaultReception+"']").attr("selected",true);
	if (result.ChatGPTType == 1)
		$("#ChatGPTType").attr("checked",true);
	$("#ChatGPTAppid").val(result.ChatGPTAppid) ;
	$("#ChatGPTKey").val(result.ChatGPTKey) ;
	$("#DefaultModel").val(result.DefaultModel) ;
	$("#DefaultModelurl").val(result.DefaultModelurl) ;
//	$("#OldChatGPTAppid").val(result.ChatGPTAppid) ;
	if (result.ChatGPTTransferType == 1)
		$("#ChatGPTTransferType").attr("checked",true);
	if (result.ChatGPTAutoTransferType == 1)
		$("#ChatGPTAutoTransferType").attr("checked",true);
//    $("#weChat_domain").val(result.weChat_domain) ;
//	$("#weChat_appid").val(result.weChat_appid) ;
//	$("#weChat_sercet").val(result.weChat_sercet) ;
//	$("#weChat_token").val(result.weChat_token) ;
//	$("#weChat_moban_id").val(result.weChat_moban_id) ;
//	$("input[name='weChat_subscribe'][value='"+result.weChat_subscribe+"']").attr("checked",true);
//	$("#weChat_subscribe_id").val(result.weChat_subscribe_id) ;
//	$("#weChat_subscribe_id2").val(result.weChat_subscribe_id2) ;
//	$("input[name='weChat_Mode'][value='"+result.weChat_Mode+"']").attr("checked",true);
//	$("#weChat_customer_service_link").val(result.weChat_customer_service_link) ;
//	$("#weChat_wechat_customer_service_link").val(result.weChat_wechat_customer_service_link) ;
}

function get_data()
{
	clear_data();
	if(left($("#ipaddress").val(), 7)=="http://"||left($("#ipaddress").val(), 8)=="https://"){
	var TempString=$("#ipaddress").val();
	}else{
	var TempString="http://"+$("#ipaddress").val();
	}
	if(right(TempString, 1)=="/"){
	TempString=TempString.substring(0,TempString.length-1);
	}
	if(!$("#ipaddress").val()) TempString='';
	var TempcdnLink=replaceAll(replaceAll($("#cdnLink").val(),"https://",""),"http://","");
	if(right(TempcdnLink, 1)=="/"){
	TempcdnLink=TempcdnLink.substring(0,TempcdnLink.length-1);
	}
	
	for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
	var welcome=$("#welcomeText").val();
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
	 $("#welcomeText").val(newContent);
	
	append_data("ipaddress",TempString);
	append_data("oldVisitorTime",$("#oldVisitorTime").val());
	append_data("clearHistoryTime",$("#clearHistoryTime").val());
	append_data("waitTime",$("#waitTime").val());
	append_data("freeTime",$("#freeTime").val());
	append_data("intervalTime",$("#intervalTime").val());
	append_data("beatTime",$("#beatTime").val());
	append_data("welcomeText",$("#welcomeText").val());
	append_data("chaterMode",$("input[name='chaterMode']:checked").val());
	append_data("chaterDistribution",$("input[name='chaterDistribution']:checked").val());
	append_data("GuestSession",$("input[name='GuestSession']:checked").val());
	append_data("websiteType",$("input[name='websiteType']:checked").val());
	append_data("welcomeType",$("#welcomeType").is(":checked")?1:-1);
	append_data("oldVisitorType",$("#oldVisitorType").is(":checked")?1:-1);
	append_data("switchType",$("#switchType").is(":checked")?1:-1);
	append_data("freeType",$("#freeType").is(":checked")?1:-1);
//	append_data("websiteType",$("#websiteType").is(":checked")?1:-1);
	append_data("dialogType",$("#dialogType").is(":checked")?1:-1);
//	append_data("connectchatType",$("#connectchatType").is(":checked")?1:-1);
	append_data("rejectType",$("#rejectType").is(":checked")?1:-1);
	append_data("weixinType",$("#weixinType").is(":checked")?1:-1);
	append_data("cdnType",$("#cdnType").is(":checked")?1:-1);
	append_data("voiceVideoType",$("#voiceVideoType").is(":checked")?1:-1);
	append_data("showHistoryType",$("#showHistoryType").is(":checked")?1:-1);
	append_data("switchAd",$("#switchAd").is(":checked")?1:-1);
	append_data("cdnLink",TempcdnLink);
	append_data("adlink",$("#adlink").val());
	append_data("ChatGPTAutoTransferTime",$("#ChatGPTAutoTransferTime").val());
	
//	var TempString=replaceAll(replaceAll($("#weChat_domain").val(),"https://",""),"http://","");
//	if(right(TempString, 1)=="/"){
//	TempString=TempString.substring(0,TempString.length-1);
//	}
//	$("#weChat_wechat_customer_service_link").val(window.location.protocol+'//'+TempString+'/vendor/wx/?act=openid');
	append_data("switchWeChat",$("#switchWeChat").is(":checked")?1:-1);
	append_data("switchBack",$("#switchBack").is(":checked")?1:-1);
	append_data("sendWelcome",$("#sendWelcome").is(":checked")?1:-1);
	append_data("switchDomainType",$("#switchDomainType").is(":checked")?1:-1);
	append_data("translateType",$("#translateType").is(":checked")?1:-1);
	append_data("translateAppid",$("#translateAppid").val());
	append_data("translateKey",$("#translateKey").val());
	append_data("DefaultReception",$("select[name='DefaultReception']").val());
	append_data("ChatGPTType",$("#ChatGPTType").is(":checked")?1:-1);
	append_data("ChatGPTAppid",$("#ChatGPTAppid").val());
	append_data("ChatGPTKey",$("#ChatGPTKey").val());
	append_data("DefaultModel",$("select[name='DefaultModel']").val());
	append_data("DefaultModelurl",$("#DefaultModelurl").val());
	append_data("ChatGPTTransferType",$("#ChatGPTTransferType").is(":checked")?1:-1);
	append_data("ChatGPTAutoTransferType",$("#ChatGPTAutoTransferType").is(":checked")?1:-1);
//	append_data("weChat_domain",TempString);
//	append_data("weChat_appid",$("#weChat_appid").val());
//	append_data("weChat_sercet",$("#weChat_sercet").val());
//	append_data("weChat_token",$("#weChat_token").val());
//	append_data("weChat_moban_id",$("#weChat_moban_id").val());
//	append_data("weChat_subscribe",$("input[name='weChat_subscribe']:checked").val());
//	append_data("weChat_subscribe_id",$("#weChat_subscribe_id").val());
//	append_data("weChat_subscribe_id2",$("#weChat_subscribe_id2").val());
//	append_data("weChat_Mode",$("input[name='weChat_Mode']:checked").val());
//	append_data("weChat_customer_service_link",$("#weChat_customer_service_link").val());
//	append_data("weChat_wechat_customer_service_link",$("#weChat_wechat_customer_service_link").val());

}

function clearHistory()
{
   var url = getAjaxUrl("livechat_kf","clearhistory") ;
   //document.write(url+"&data="+data);
   $.ajax({
       type: "POST",
	   data:{clearHistoryTime:$("#clearHistoryTime").val()},
       dataType:"json",
       url: url,
       success: function(result){
    	   if(result.status)
		   {
    		   $("#pnl_success").show();
		   }
    	   else
		   {
		   		myAlert(result.msg);
		   }
			
       }
   });
}

function doc_url()
{
	var url;
	switch(parseInt($("#DefaultModel").val()))
	{
		case 1:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/completions";
			break;
		case 2:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/eb-instant";
			break;
		case 3:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/bloomz_7b1";
			break;
		case 4:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/qianfan_bloomz_7b_compressed";
			break;
		case 5:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/llama_2_7b";
			break;
		case 6:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/llama_2_13b";
			break;
		case 7:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/llama_2_70b";
			break;
		case 8:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/qianfan_chinese_llama_2_7b";
			break;
		case 9:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 10:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 11:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 12:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/chatglm2_6b_32k";
			break;
		case 13:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 14:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 15:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 16:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/aquilachat_7b";
			break;
		case 17:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 18:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 19:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 20:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 21:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 22:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 23:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 24:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 25:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 26:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
		case 27:
			url="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{申请发布时填写的API地址}";
			break;
	}
	$("#DefaultModelurl").val(url);
}

</script>