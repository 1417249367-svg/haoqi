<?php
/*
-----------------------------------------------------------------------------------------------------------------
method	短信发送
param	loginname
param	password
param	mode	默认值1		1支持部门发送    2支持部门自动钩选人员   3只支持选择人员
-----------------------------------------------------------------------------------------------------------------
demo	http://127.0.0.1:8000/addin/sms_send.html?loginname=jc@aipu&password=e10adc3949ba59abbe56e057f20f883e
to		/public/sms.html?op=send_sms

传入参数支持
mode		1支持部门发送    2支持部门自动钩选人员   3只支持选择人员
seluserid
seldeptid
*/
 

require_once("include/fun.php");



ob_clean();

if (SMS_URL == "")
{
	print("error:no config sms url");
	die();
}




?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>   
	<link type="text/css" rel="stylesheet" href="/addin/assets/css/sms.css" />
</head>
<body>
<form id="form" method="post" data-obj="sms"  data-table="rtc_sms" data-fldid="col_id" data-fldname="col_name">
	<ul id="tabs" class="nav nav-tabs">
		<li class="active"><a href="sms_send.html?<?=$_SERVER["QUERY_STRING"] ?>"><span class="icon_mail">发送短信</span></a></li>
		<li><a href="sms_list.html?<?=$_SERVER["QUERY_STRING"] ?>" ><span class="icon_mail_history">短信历史记录</span></a></li>
	</ul>


	<div  style="position:relative;padding:0px 10px;">
        <div class="mypanel box-form" class="fluent">
            <div class="mypanel-body">
		        <div class="form-group">
			        <label for="users">接收人</label>
			        <div>
				        <div id="view_users" style="height:50px; overflow:auto;padding:4px;" class="form-control fluent"><ul id="container_users" class="dotlist"></ul><div class="clear"></div></div>
			        </div>
		        </div>
		        <div class="form-group">
			        <div><label for="content" class="pull-left">内容</label><label  class="pull-right gray" id="col_content_tip"></label><div class="clear"></div></div>
			        <div>
				        <textarea  id="col_content" name="col_content" rows="8" class="form-control data-field"  maxlength="1000" ></textarea>
			        </div>
		        </div> 
            </div>
        </div>

		<?php  require_once("include/emp_picker.php");?>

        <div class="clear"></div>

	</div>

	<div class="bottom">
	    <div class="padding">
	        <div class="pull-left sms-info">
	           <label class="pull-left" style="">签名：</label>
	           <div class="pull-left" style="width:150px;"><input type="text" id="col_send_name" name="col_send_name" class="form-control data-field input-sm" value="<?=CurUser::GetUserName() ?>"/></div>
	           <label class="pull-left" style="margin-left:10px;display:none;">定时发送：</label>
	           <div class="pull-left" style="padding:8px 2px;margin-right:20px;display:none;"><input type="checkbox" id="chk_fix"  value="0"/></div>
	           <label class="pull-left container_time" style="display:none;">发送时间：</label>
	           <div class="pull-left container_time" style="display:none;width:150px;"><input type="text" id="col_send_time" name="col_send_time" class="form-control data-field input-sm datetimepicker"/></div>

	        </div>
	        <div class="pull-right">
	            <input type="button" value="发送" id="btn_save" class="btn btn-primary" style="padding:2px 20px;height:auto;" />
	            <input type="hidden" id="col_recv_mobile" name="col_recv_mobile" class="form-control data-field"/>
	            <input type="hidden" id="col_recv_name"  name="col_recv_name" class="form-control data-field" />
	            <input type="hidden" id="col_creator_id" name="col_creator_id" class="form-control data-field" value="<?=CurUser::GetUserId() ?>" />
	            <input type="hidden" id="col_creator_name" name="col_creator_name" class="form-control data-field input-sm" value="<?=CurUser::GetUserName() ?>"/>
	            <input type="hidden" id="col_dt_create" name="col_dt_create" class="form-control data-field" value="<?=getNowTime()?>" />
	            <input type="hidden" id="col_send_url" name="col_send_url" class="form-control data-field" />
	            <input type="hidden" id="col_status" name="col_status" class="form-control data-field" />
	            <input type="hidden" id="col_return" name="col_return" class="form-control data-field" />
                <input type="hidden" id="col_send_loginname" name="col_send_loginname" class="form-control data-field"  value="<?=CurUser::GetLoginName() ?>"/>
                <input type="hidden" id="col_flag" name="col_flag" value="0" class="form-control data-field" />
	        </div>
	        <div class="clear"></div>
	    </div>
	</div>

 </form>
</body>
</html>
<script type="text/javascript" src="assets/js/container_picker.js?ver=20151016"></script>
<script type="text/javascript" src="/addin/assets/js/sms.js?ver=20150617"></script>
<script type="text/javascript">

var dataForm ;
var dataList ;
var curr_time = "<?=getNowTime()?>";
var query = "<?=$_SERVER["QUERY_STRING"] ?>";
var select_userid = "<?=g("seluserid")?>"; //支持人员多选左健插件  1,2
var select_deptid = "<?=g("seldeptid")?>"; //支持多选左健插件 Ant_Group:1@asd;Ant_Group:2@asd 
var sendAccount = "<?= CurUser::getLoginName() ?>";
var _lang = "<?=LANG_TYPE?>";
//接收者限制
var sms_recver_limit = 5000 ; 

//1支持部门发送    2支持部门自动钩选人员   3只支持选择人员
var select_emp_mode = parseInt("<?=g("mode",3) ?>") ; 


$(document).ready(function(){
	
	// init tree container ,form
	sms_send_init();  	

})


</script>

 