<?php
define ( "MENU", "SET" );

require_once ("../include/fun.php");
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
//	$db = new DB();
//	$sql = "Select ID,UserApply from OtherForm where ID=1";
//	$data = $db->executeDataRow($sql);
//	//echo var_dump($data);
//	$userapply=$data['userapply'];
	$content = new SimpleIniIterator(__ROOT__ . '/Data/DataBase.ini');
	//$content->setIniValue('NewKey', 'NewValue','NewNode');
	//$content->setIniValue('lock_screen', '1', 'server_connection');
	//$content->setIniValue('U-swappable_disk_alarm', '0', 'U-authorization');
//if(getOS()=='windows'){
//$antconfig = new AntConfig();
//$AntServerFlag = $antconfig->get_regvalue('AntServerFlag');
//$db = new DB();
//$sqls= "select col_data from tab_config where col_name = 'AntServerFlag'";
//$res = $db->executeDataValue($sqls);
//    if($res !== $AntServerFlag)
//    {
//    	$sqls= "update tab_config set col_data='".$AntServerFlag."' where col_name = 'AntServerFlag'";
//    	$db->execute($sqls);
//    	bulidAppValue();
//    }  
//} 
?>
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/set.js?ver=20240922"></script>
	<script type="text/javascript" src="../assets/js/userpicker4.js"></script>
	<style>
	fieldset {
		padding: 5px;
		margin-bottom: 20px;
	}
	
	fieldset legend {
		padding: 5px;
		margin: 0px;
	}
<?php 
    if(LANG_TYPE == 'en'){
?>	
	fieldset div {
		padding: 2px 0px;
		margin: 0px;
		float:left;
		width:45%;
		margin-right:3%;
		height:30px;
	}
<?php 
}else{
?>
	fieldset div {
		padding: 2px 0px;
		margin: 0px;
		float:left;
		width:30%;
		margin-right:3%;
		height:30px;
	}
<?php } ?>	
	.line1{clear:both;width:100%;float:none;}
	.nochecked{padding-left:15px;}
	i{color:gray;font-size:11px;}
	</style>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('set_title')?></h1></div>
				<div id="pnl_success" class="alert alert-success" style="display:none;font-size:14px;" ><?=get_lang('set_alert_success')?></div>
                <form  id="form1" method="post" class="form-horizontal">
					<fieldset>
						<legend><?=get_lang('base_title')?></legend>
<!--						<div><input type="checkbox" class="regval" name="chats" value="1"> <?=get_lang('set_chats')?></div>
                        <div><input type="checkbox" class="regval" name="logs" value="1"> <?=get_lang('set_logs')?></div>
                        <div><input type="checkbox" class="regval" name="control_computer" value="1"> <?=get_lang('set_control_computer')?></div>
						<div><input type="checkbox" class="regval" name="lock_screen" value="1"> <?=get_lang('set_lock_screen')?></div>
						<div><input type="checkbox" class="regval" name="offline_information" value="1"> <?=get_lang('set_offline_information')?></div>
						<div><input type="checkbox" class="regval" name="minimize" value="1"> <?=get_lang('set_minimize')?></div>
                        <div style="width:100%;"><input type="checkbox" class="regval" name="CheckIM0" value="1"> <?=get_lang('set_CheckIM0')?></div>-->
                        <div style="width:100%;"><input type="checkbox" class="regval" name="CheckIM1" value="1"> <?=get_lang('set_CheckIM1')?></div>
						<div style="width:100%;"><?=get_lang('set_delete_offline_files')?>： <input type="radio"  name="delete_offline_files" value="1"/><?=get_lang('set_delete_offline_files1')?><input type="radio"  name="delete_offline_files" value="2"/><?=get_lang('set_delete_offline_files2')?><input type="radio"  name="delete_offline_files" value="3"/><?=get_lang('set_delete_offline_files3')?></div>   
                        <div style="width:100%;"><?=get_lang('set_message_push')?><input type="text"  class="txt digits regval"  min="0" max="60" id="interval_time" name="interval_time" style="width:30px" /> <?=get_lang('set_message_push1')?></div>
                         <?php if ($os == "linux") {?><div style="width:100%;"><input type="checkbox" class="regval" name="delete_server_files" value="1"> <?=get_lang('set_delete_server_files')?> <input type="text"  class="txt digits regval"  min="0" max="100" id="server_capacity" name="server_capacity" style="width:30px" /> <?=get_lang('set_delete_server_files1')?> </div><?php }?>
                         <div style="width:100%;"><input type="checkbox" class="regval" name="delete_chats" value="1"> <?=get_lang('set_delete_offline_notices')?> <input type="text"  class="txt digits regval"  min="0" max="365" id="chatsday" name="chatsday" style="width:80px" /> <?=get_lang('set_chatsday')?> </div>
                         <div style="width:100%;"><input type="checkbox" class="regval" name="delete_offline_notices" value="1"> <?=get_lang('set_delete_offline_notices')?> <input type="text"  class="txt digits regval"  min="0" max="365" id="noticeday" name="noticeday" style="width:80px" /> <?=get_lang('set_noticeday')?> </div>
                         <!--<div>数据库类型: <select id="DB_TYPE"  name="DB_TYPE" onChange="doc_action();">
                                      <option value="access">Access</option>
                                      <option value="mssql">SQLServer</option>
                                  </select>
                        </div>-->
                        <!--<div id="DB_INFO">
                        <div>数据库服务器: <input type="text"  class="txt regval" id="DB_SERVER" name="DB_SERVER" style="width:200px" /></div>
                        <div>数据库端口: <input type="text"  class="txt regval" id="DB_PORT" name="DB_PORT" style="width:200px" /></div>
                        <div>数据库用户名: <input type="text"  class="txt regval" id="DB_USER" name="DB_USER" style="width:200px" /></div>
                        <div>数据库密码: <input type="password"  class="txt regval" id="DB_PWD" name="DB_PWD" style="width:200px" /></div>
                        <div>数据库名: <input type="text"  class="txt regval" id="DB_NAME" name="DB_NAME" style="width:200px" /></div>
                        </div>-->
                    </fieldset>
					<fieldset>
						<legend><?=get_lang('set_legend_server')?></legend>
						<div><input type="checkbox" name="Transcode" id="Transcode" <?=getAppValue("Transcode")== "1" ?"checked":""?>> <?=get_lang('set_checkbox_transcode')?></div>
						<div><input type="checkbox" name="PublicDocuments" id="PublicDocuments" <?=getAppValue("PublicDocuments")== "1" ?"checked":""?>> <span title="<?=get_lang('set_checkbox_publicdocuments')?>"><?=get_lang('set_checkbox_publicdocuments_file_type')?></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" action-data="1" action-type="chater_ro_member3"><?=get_lang("btn_setkefumember3")?></a></div>
                        <div>
                            <input type="checkbox" name="PublicDocuments_View" id="PublicDocuments_View" <?=getAppValue("PublicDocuments_View")== "1" ?"checked":""?> > <span title="<?=get_lang('set_checkbox_publicdocuments_view')?>"><?=get_lang('set_checkbox_publicdocuments_file_type_view')?></span>
                        </div>
                        <div>
                            <input type="checkbox" name="LiveChat" id="LiveChat" <?=getAppValue("LiveChat")== "1" ?"checked":""?> > <?=get_lang('set_livechat')?>
                        </div>
<!--                        <div>
                            <input type="checkbox" name="OpenPlatForm" id="OpenPlatForm" <?=getAppValue("OpenPlatForm")== "1" ?"checked":""?>> <?=get_lang('set_openplatform')?>
                        </div>-->
                        <div>
                            <input type="checkbox" name="VerifyUserDevice" id="VerifyUserDevice" <?=getAppValue("VerifyUserDevice")== "1" ?"checked":""?>> <?=get_lang('set_verifyuserdevice')?>
                        </div>
                        <div>
                            <input type="checkbox" name="InquiryBox" id="InquiryBox" <?=getAppValue("InquiryBox")== "1" ?"checked":""?>> <?=get_lang('set_inquirybox')?>
                        </div>
					</fieldset>
					<fieldset>
						<legend><?=get_lang('set_legend_client')?></legend>
                         <div><input type="checkbox" name="CustomerServiceMode" value="0" <?=getAppValue("customerservicemode")== "0" ?"":"checked"?>> <?=get_lang('enable_customerservicemode')?></div>
					</fieldset>
					<fieldset>
						<legend><?=get_lang('set_legend_integrate')?></legend>           
                        <!--- set authen---->
                        <div class="line1">
                            <input type="radio" name="Type" id="Type" value="0"> <?=get_lang('set_checkbox_system')?>
                            <input type="radio" name="Type" id="Type" value="1"> <?=get_lang('set_checkbox_verify')?>
                        	<input type="radio" name="Type" id="Type" value="2"> <?=get_lang('set_checkbox_enable_loginverify')?>
                        </div> 
                        <div id="div_authen_url"  class="line1 nochecked">
                            <?=get_lang('set_loginverify_url')?>
                            <input type="text"  class="txt"  id="Target"  name="Target" style="width:450px" value="<?=getAppValue("Target")?>" />
                            <i>示例地址：<?=getRootPath() . "/demo/authen/authen.html"?></i>
                            <div class="line1">
                                <label>接口数据返回类型</label>
                                <select name="TargetReturn" id="TargetReturn" >
                                  <option value ="JSON">JSON</option>
                                  <option value ="XML">XML</option>                          
                                </select>
                                <i class="TargetReturn"></i>&nbsp;&nbsp;<i>输入参数,loginname:帐号,password:密码,entype:0 密码未加密 1 密码md5加密</i>
                            </div>
                        </div>
					</fieldset>
					<div class="form-group" style="padding:0px 10px;">
						<input type="submit" id="btn_save" class="btn btn-primary"  value="<?=get_lang('base_btn_save')?>"/>
					</div>
                </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">
var DB_TYPE = "<?=$content->getIniValue('server_connection', 'DB_TYPE')?>" ;
var DB_SERVER = "<?=$content->getIniValue('server_connection', 'DB_SERVER')?>" ;
var DB_PORT = "<?=$content->getIniValue('server_connection', 'DB_PORT')?>" ;
var DB_USER = "<?=$content->getIniValue('server_connection', 'DB_USER')?>" ;
var DB_PWD = "<?=$content->getIniValue('server_connection', 'DB_PWD')?>" ;
var DB_NAME = "<?=$content->getIniValue('server_connection', 'DB_NAME')?>" ;
var chats = parseInt("<?=$content->getIniValue('server_connection', 'chats')?>") ;
var logs = parseInt("<?=$content->getIniValue('server_connection', 'logs')?>") ;
var control_computer = parseInt("<?=$content->getIniValue('server_connection', 'control_computer')?>") ;
var lock_screen = parseInt("<?=$content->getIniValue('server_connection', 'lock_screen')?>") ;
var offline_information = parseInt("<?=$content->getIniValue('server_connection', 'offline_information')?>") ;
var minimize = parseInt("<?=$content->getIniValue('server_connection', 'minimize')?>") ;
var CheckIM0 = parseInt("<?=$content->getIniValue('server_connection', 'CheckIM0')?>") ;
var CheckIM1 = parseInt("<?=$content->getIniValue('server_connection', 'CheckIM1')?>") ;
var chatsday = parseInt("<?=$content->getIniValue('delete_chats', 'chatsday')?>") ;
var delete_chats = parseInt("<?=$content->getIniValue('delete_chats', 'options')?>") ;
var delete_offline_files = parseInt("<?=$content->getIniValue('delete_offline_files', 'options')?>") ;
var interval_time = parseInt("<?=$content->getIniValue('message_push', 'interval_time')?>") ;
var noticeday = parseInt("<?=$content->getIniValue('delete_offline_notices', 'noticeday')?>") ;
var delete_offline_notices = parseInt("<?=$content->getIniValue('delete_offline_notices', 'options')?>") ;
var server_capacity = parseInt("<?=$content->getIniValue('delete_server_files', 'server_capacity')?>") ;
var delete_server_files = parseInt("<?=$content->getIniValue('delete_server_files', 'options')?>") ;

var Type = parseInt("<?=getAppValue("Type")?>") ;

var serverFlagEx = "<?=getAppValue("ServerFlagEx")?>" ;

var is_windows = "<?=$os == "windows"?"1":"0"?>";
if(is_windows){
	var antServerFlag = "<?=getAppValue("AntServerFlag",0)?>" ;	
}else{
	var antServerFlag = "<?=getAppValue("AntServerFlag",0)?>" ;
}
	
$(document).ready(function(){
	
	if (is_windows == "0")
		$(".windows").hide();
		
	//配置开关控件
	formatCheckSwitch();
    //status:1 成功，否则失败 示例:<result><status>1</status><msg></msg></result> 显示格式
    var TargetReturn = "<?=getAppValue("targetreturn")?>";  
    showTargetReturn(TargetReturn,$("#TargetReturn"),$(".TargetReturn"));

        
    $("#TargetReturn").change(function(){
        showTargetReturn($("#TargetReturn").val(),$("#TargetReturn"),$(".TargetReturn"));
    })


	function showTargetReturn(TarReVal,TarReObj,tipObj){
        if( TarReVal == "undefined" ){
        	TarReObj.val('JSON');
        	tipObj.text("status:1 成功，否则失败 示例:{\"status\":1,\"msg\":\"成功\"}");
        }                  	
    	if( TarReVal == 'XML'){
    		TarReObj.val(TarReVal);
    		tipObj.text("status:1 成功，否则失败 示例:<result><status>1</status><msg>成功</msg></result>");
        }
        if(TarReVal == 'JSON'){
        	TarReObj.val(TarReVal);
        	tipObj.text("status:1 成功，否则失败 示例:{\"status\":1,\"msg\":\"成功\"}");
        }
         	 
    }
})
</script>