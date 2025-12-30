<?php
define("MENU","WEBSERVER_SET") ;

require_once("../include/fun.php");

 
?>

<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/sysconfig.js?ver=20150512"></script>
<style>
fieldset {
	padding: 5px;
	margin-bottom: 20px;
}

fieldset legend {
	padding: 5px;
	margin: 0px;
}

fieldset div {
	padding: 2px 0px;
	margin: 0px;
	float:left;
	width:33%;
	height:auto;
	min-height:30px;
}
.line2{width:50%;}
.line2 span,.line1 span{width:80px;float:left;}
.line2 input{width:400px}
.line1{clear:both;width:100%;float:none;}
i{color:#999;font-size:0.9em;}
</style>
</head>
<body>
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('webserver_config_title')?></h1></div>
				<div id="pnl_success" class="alert alert-success" style="display:none;font-size:14px;" ><?=get_lang('base_alert_success')?></div>
                <form  id="form1" method="post" class="form-horizontal">
				

					<fieldset>
						<legend><?=get_lang('webserver_config_antserver')?></legend>
						<div class="line1"><?=get_lang('webserver_lb_ant_server')?> <input type="text"  class="txt"  data-type="SysConfig"   id="RTCServer_IP"  name="RTCServer_IP" value="<?=RTC_SERVER_AGENT?>"   style="width:200px;"  /> <i>(<?=get_lang('webserver_lb_ant_server_tip')?>)</i></div>
						<div class="line1"><?=get_lang('webserver_lb_ant_consoledir')?>  <input type="text"  class="txt"  data-type="SysConfig"   id="RTC_DATADIR"  name="RTC_DATADIR" value="<?=RTC_DATADIR?>"   style="width:400px;"  /></div>
						<div class="line1"><?=get_lang('webserver_lb_ant_datadir')?><input type="text"  class="txt"  data-type="SysConfig"   id="RTC_CONSOLE"  name="RTC_CONSOLE" value="<?=RTC_CONSOLE?>"  style="width:400px;"  /></div>
					</fieldset>

					
					<fieldset>
						<legend><?=get_lang('webserver_config_common')?></legend>
                        <div class="line1">
                        	<?=get_lang('webserver_lb_log_level')?>
                        	<select id="LOG_LEVEL"   name="LOG_LEVEL"  data-type="SysConfig"  >
                        		<option value="0" <?=LOG_LEVEL == 0?"selected":""?>><?=get_lang('webserver_lb_log_level_close')?> </option>
                        		<option value="1" <?=LOG_LEVEL == 1?"selected":""?>><?=get_lang('webserver_lb_log_level_error')?> </option>
                        		<option value="2" <?=LOG_LEVEL == 2?"selected":""?>><?=get_lang('webserver_lb_log_level_info')?> </option>
                        		<option value="3" <?=LOG_LEVEL == 3?"selected":""?>><?=get_lang('webserver_lb_log_level_debug')?> </option>
                        	</select>
                        </div>
                        <div class="line1"><?=get_lang('set_login_error_count')?> <input type="text"  class="txt digits"  data-type="SysConfig"  id="LOGIN_ERROR_COUNT"  name="LOGIN_ERROR_COUNT" value="<?=LOGIN_ERROR_COUNT?>" style="width:80px" /> <i>(<?=get_lang('set_login_error_count_tip')?>)</i></div>
						<div class="line1"><?=get_lang('webserver_lb_export_field')?> <input type="text"  class="txt"   data-type="SysConfig"  id="EXPORT_USER_FIELD"  name="EXPORT_USER_FIELD" value="<?=EXPORT_USER_FIELD?>" style="width:800px" /></div>
					</fieldset>
					
					<fieldset style="margin-bottom:0px;">
						<legend><?=get_lang('webserver_config_added')?></legend>
						<div class="line1">
							<?=get_lang('set_userapply')?>
                            <select data-type="SysConfig"  id="UserApply" name="UserApply"><option value="2"><?=get_lang('set_userapply2')?></option><option value="0"><?=get_lang('set_userapply0')?></option><option value="1"><?=get_lang('set_userapply1')?></option></select>
                        </div>
                        <div class="line1">
							<?=get_lang('webserver_lb_push_toket')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="ACCESS_TOKEN"  name="ACCESS_TOKEN" value="<?=ACCESS_TOKEN?>" style="width:200px" />
                        </div>
						<div class="line1">
							<?=get_lang('webserver_lb_api_return_type')?>
                            <select data-type="SysConfig"  id="ApiReturnType" name="ApiReturnType"><option value="XML">XML</option><option value="JSON">JSON</option></select>
                        </div>
                        <div class="line1">
							<?=get_lang('webserver_lb_back_onlineminute')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="BackOnlineMinute"  name="BackOnlineMinute" value="<?=BACKONLINEMINUTE?>" style="width:100px" />
                        	<?=get_lang('set_checkbox_minutes')?>
                        </div>
						<div class="line1" style="margin-bottom:0px;">
							<?=get_lang('webserver_lb_sms_url')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="SMS_URL"  name="SMS_URL" value="<?=SMS_URL?>" style="width:800px" />
                            <div style="margin-left:90px;width:100%;font-size:0.9em;"><i><?=get_lang("webserver_lb_sms_sample")?></i></div>
                        </div>
						<div class="line1" style="margin-bottom:0px;">
							<?=get_lang('webserver_lb_push_sms')?> 
                            <select id="SMS_PUSH"   name="SMS_PUSH"  data-type="SysConfig"  >
                        		<option value="0" <?=SMS_PUSH == 0?"selected":""?>><?=get_lang('webserver_lb_log_level_close')?> </option>
                        		<option value="1" <?=SMS_PUSH == 1?"selected":""?>><?=get_lang('webserver_lb_log_level_open')?> </option>
                        	</select>
                            <div style="margin-left:90px;width:100%;font-size:0.9em;"><i><?=get_lang("webserver_lb_push_sms_desc")?></i></div>
                        </div>
						<div class="line1">
							<?=get_lang('webserver_lb_smtp_info')?> 
                            
                            <?=get_lang('webserver_lb_smtp_server')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="SmtpServer"  name="SmtpServer" value="<?=SMTPSERVER?>" />&nbsp;&nbsp;
                            
							<?=get_lang('webserver_lb_smtp_port')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="SmtpPort"  name="SmtpPort" value="<?=SMTPPORT?>" />&nbsp;&nbsp;
                            
                            <?=get_lang('webserver_lb_smtp_account')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="SmtpAccount"  name="SmtpAccount" value="<?=SMTPACCOUNT?>" />&nbsp;&nbsp;                           
                            
                            <?=get_lang('webserver_lb_smtp_password')?> 
                            <input type="text"  class="txt"  data-type="SysConfig"  id="SmtpPassword"  name="SmtpPassword" value="<?=SMTPPASSWORD?>" />&nbsp;&nbsp;
                        </div>
						<div class="line1" style="margin-bottom:0px;">
							<?=get_lang('webserver_lb_push_email')?> 
                            <select id="EMAIL_PUSH"   name="EMAIL_PUSH"  data-type="SysConfig"  >
                        		<option value="0" <?=EMAIL_PUSH == 0?"selected":""?>><?=get_lang('webserver_lb_log_level_close')?> </option>
                        		<option value="1" <?=EMAIL_PUSH == 1?"selected":""?>><?=get_lang('webserver_lb_log_level_open')?> </option>
                        	</select>
                            <div style="margin-left:90px;width:100%;font-size:0.9em;"><i><?=get_lang("webserver_lb_push_email_desc")?></i></div>
                        </div>
					</fieldset>

					<div class="form-group" style="padding:0px 20px;">
						<input type="submit"  class="btn btn-primary"  value="<?=get_lang('btn_save')?>"/>
					</div>
                </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">

$(document).ready(function(){
	$("#UserApply").val("<?=USERAPPLY?>");
	$("#ApiReturnType").val("<?=APIRETURNTYPE?>");
	$("#form1").validate({
		submitHandler: function(form) {
			save_auto();
			return false;
		}
	});
	
	var is_windows = "<?=$os == "windows"?"1":"0"?>";
	if (is_windows == "0")
		$(".windows").hide();
	
});

</script>