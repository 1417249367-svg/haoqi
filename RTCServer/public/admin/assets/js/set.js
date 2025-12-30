$(document).ready(function(){
	init();
	$("#form1").validate({
		submitHandler: function(form) {
			save();
			return false;
		}
	});
});

function chater_ro_member3(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1,4);
}


function doc_action()
{
	if($("select[name='DB_TYPE']").val()=="mssql") $("#DB_INFO").show();
	else $("#DB_INFO").hide();
}


function init()
{
	$("[name=AntServerFlag]").each(function(){
		var val = parseInt($(this).val());
		if ((antServerFlag & val) == val)
			$(this).attr("checked",true);
	})

	$("[name=ServerFlagEx]").each(function(){
		var val = parseInt($(this).val());
		if ((serverFlagEx & val) == val)
			$(this).attr("checked",true);
	})
    $("input[name='Type'][value='"+Type+"']").attr("checked",true);
//	if (userapply == "1")
//	    $("[name=userapply]").attr("checked",true);
	if (chats == "1")
	    $("[name=chats]").attr("checked",true);
	if (logs == "1")
	    $("[name=logs]").attr("checked",true);
	if (control_computer == "1")
	    $("[name=control_computer]").attr("checked",true);
	if (lock_screen == "1")
	    $("[name=lock_screen]").attr("checked",true);
	if (offline_information == "1")
	    $("[name=offline_information]").attr("checked",true);
	if (minimize == "1")
	    $("[name=minimize]").attr("checked",true);
	if (CheckIM0 == "1")
	    $("[name=CheckIM0]").attr("checked",true);
	if (CheckIM1 == "1")
	    $("[name=CheckIM1]").attr("checked",true);
	if (delete_chats == "1")
	    $("[name=delete_chats]").attr("checked",true);
	if (delete_offline_notices == "1")
	    $("[name=delete_offline_notices]").attr("checked",true);
	if (delete_server_files == "1")
	    $("[name=delete_server_files]").attr("checked",true);
//	$("input[name='userapply'][value='"+userapply+"']").attr("checked",true);
    $("input[name='delete_offline_files'][value='"+delete_offline_files+"']").attr("checked",true);
	$("[name=chatsday]").val(chatsday);
	$("[name=noticeday]").val(noticeday);
	$("[name=server_capacity]").val(server_capacity);
	$("[name=interval_time]").val(interval_time);
//	$("[name=DB_TYPE]").val(DB_TYPE);
//	$("[name=DB_SERVER]").val(DB_SERVER);
//	$("[name=DB_PORT]").val(DB_PORT);
//	$("[name=DB_USER]").val(DB_USER);
//	$("[name=DB_PWD]").val(DB_PWD);
//	$("[name=DB_NAME]").val(DB_NAME);
//	doc_action();
}


function save()
{
	$("#pnl_success").hide();
	setLoadingBtn($("#btn_save"));
	//得到相关的值
	antServerFlag = 0 ;
	$("[name=AntServerFlag]").each(function(){
		if ($(this).is(":checked"))
			antServerFlag += parseInt($(this).val());
	})

	//2用多设备同时在线   4启用音视频中转服务
	serverFlagEx = 0 ;
	$("[name=ServerFlagEx]").each(function(){
		if ($(this).is(":checked"))
			serverFlagEx += parseInt($(this).val());
	})

 
	//添加数据
	names = values = types = "";
	_addItem("AntServerFlag",antServerFlag,"AntServerConfig");
	_addItem("ServerFlagEx",serverFlagEx,"AntServerConfig");   
	
	_addInputItem("MsgLife","AntServerConfig");
	_addCheckedItem("AutoClear","AntServerConfig");
	_addCheckedItem("AutoAway","AntServerConfig");
	_addInputItem("AutoAwayTime","AntServerConfig");
	
	//20150924 去掉数据目录，在后台设置中已经有了
	//_addInputItem("DataDir", "AntServerConfig");
	
	//20150924 添加在线客服与开放平台
	_addCheckedItem("LiveChat","SysConfig");
	_addCheckedItem("OpenPlatForm","SysConfig");
	_addCheckedItem("Transcode","SysConfig");
	_addCheckedItem("PublicDocuments","SysConfig");
	_addCheckedItem("PublicDocuments_View","SysConfig");

	_addInputItem("P2PThreshold","BigAntClientExt"); //P2P的阀值
	
	//_addCheckedItem("SyncPushTargetType","AntServerExConfig"); //启用数据同步推送
	var SyncPushTargetType = $("[name=SyncPushTargetType]").is(':checked')?1:0 ; 
	if ((SyncPushTargetType != 0) && ($("#drp_SyncPushMsgType").val() != undefined))
		SyncPushTargetType = $("#drp_SyncPushMsgType").val();


	_addItem("SyncPushTargetType",SyncPushTargetType,"AntServerExConfig");
	_addInputItem("SyncPushTarget","AntAuthenConfig"); //数据同步推送URL
	
	_addItem("SyncPushLog",$("#SyncPushLog").val(),"AntServerExConfig"); //是否启用系统推送日志
	
	
	//_addRadioItem("Type","AntAuthenConfig"); //启用WebService登录验证（需定制开发）
	_addInputItem("Target","AntAuthenConfig"); //WebService登录验证URL
	

	_addInputItem("TargetReturn","AntAuthenConfig"); //三方接口数据返回类型	
	
	_addCheckedItem("IOSPush","AntServerConfig"); //ISOPush
	
	_addCheckedItem("EnableKeyWord","SysConfig"); //启用敏感词过滤
	
	_addCheckedItem("CustomerServiceMode","SysConfig");
	
	_addCheckedItem("VerifyUserDevice","SysConfig"); //启用设备号验证
	_addCheckedItem("InquiryBox","SysConfig");
	
	_addItem("Type",$("input[name='Type']:checked").val(),"AntAuthenConfig");
	//var userapply = $("[name=userapply]").is(":checked")?1:0 ;
	var chats = $("[name=chats]").is(":checked")?1:0 ;
	var logs = $("[name=logs]").is(":checked")?1:0 ;
	var control_computer = $("[name=control_computer]").is(":checked")?1:0 ;
	var lock_screen = $("[name=lock_screen]").is(":checked")?1:0 ;
	var offline_information = $("[name=offline_information]").is(":checked")?1:0 ;
	var minimize = $("[name=minimize]").is(":checked")?1:0 ;
	var CheckIM0 = $("[name=CheckIM0]").is(":checked")?1:0 ;
	var CheckIM1 = $("[name=CheckIM1]").is(":checked")?1:0 ;
	var delete_chats = $("[name=delete_chats]").is(":checked")?1:0 ;
	var delete_offline_notices = $("[name=delete_offline_notices]").is(":checked")?1:0 ;
	var delete_server_files = $("[name=delete_server_files]").is(":checked")?1:0 ;
	
	var data = {"chats":chats,
				"logs":logs,
				"control_computer":control_computer,
				"lock_screen":lock_screen,
				"offline_information":offline_information,
				"minimize":minimize,
				"CheckIM0":CheckIM0,
				"CheckIM1":CheckIM1,
				"chatsday":$("input[name='chatsday']").val(),
				"delete_chats":delete_chats,
				"delete_offline_files":$("input[name='delete_offline_files']:checked").val(),
				"noticeday":$("input[name='noticeday']").val(),
				"interval_time":$("input[name='interval_time']").val(),
				"delete_offline_notices":delete_offline_notices,
				"server_capacity":$("input[name='server_capacity']").val(),
				"delete_server_files":delete_server_files,
				"names":names,
				"values":values,
				"types":types
//				,
//				"DB_TYPE":$("select[name='DB_TYPE']").val(),
//				"DB_SERVER":$("input[name='DB_SERVER']").val(),
//				"DB_PORT":$("input[name='DB_PORT']").val(),
//				"DB_USER":$("input[name='DB_USER']").val(),
//				"DB_PWD":$("input[name='DB_PWD']").val(),
//				"DB_NAME":$("input[name='DB_NAME']").val()
				};
	
	var url = getAjaxUrl("regedit","save") ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status){
				$("#pnl_success").show();
				var speed=200;//滑动的速度
                $('body,html').animate({ scrollTop: 0 }, speed);
			}else
				myAlert(result.msg);
			setSubmitBtn($("#btn_save"));
	   }
	});
}
var names,values,types ;

function _addInputItem(name,type)
{
	var value = $("[name=" + name + "]").val() ;
 
	_addItem(name,value,type);
}

function _addCheckedItem(name,type)
{
	var value = $("[name=" + name + "]").is(':checked')?1:0 ;
 
	_addItem(name,value,type);
}
 
 //方便添加数据
function _addItem(name,value,type)
{
	if (names != "")
	{
		names += ",";
		values += ",";
		types += ",";
	}
	
	names += name ;
	values += value ;
	types += type ;
}

function set_ios()
{
	var url = "ios_set.html" ;
	dialog("ios",langs.config_ios_title ,url) ;
}


function set_ios_post()
{
	$("#pnl_success").hide();

	dialogClose("ios");

	var data ="IOSAppKey:" + trim($("#IOSAppKey").val()) + ",IOSMasterKey:" + trim($("#IOSMasterKey").val());
	var url = getAjaxUrl("sysconfig","save") ;

	showLoading(langs.text_saving);

	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{genre:"AntServerConfig",data:data},
	   url: url,
	   success: function(result){
			if (result.status)
				$("#pnl_success").show();
			else
				myAlert(getErrorText(result.errnum));
			hideLoading();
	   }
	});
}

function clear_msg()
{
	var html = langs.config_clear_confim ;
	html = html.replace("{days}",'<input type="text"  class="txt"  id="txt_days" style="width:80px" value="' + $("#MsgLife").val() + '" />');
     var content ='<div class="modal-body">' +
               '     <div class="form-group">' + html + '</div> ' +
			   '	 <div class="form-group">' + langs.config_clear_tip + '</div>' +
			   '</div>' +
			   '<div class="modal-footer">' +
               '  	<input type="button" class="btn btn-default" data-dismiss="modal" value="' + langs.btn_cancel + '"/>' +
               '  	<input type="button" class="btn btn-danger" id="btn_clear_post" onclick="clear_msg_post()" value="' + langs.btn_clear + '" />' +
               '</div>' ;


	dialogByContent("dialog",langs.text_tip,content,400,300);
}

function clear_msg_post()
{
	//检查输入
	var days = $("#txt_days").val();

    if (isNaN(days))
    	days = 0 ;

    if(days <= 0 )
	{
    	myAlert(langs.config_clear_days_error);
    	return;
	}


    dialogClose("dialog");

	showLoading(langs.config_clear_doing);
	var url = getAjaxUrl("ant","clear_msg") ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{days:days},
	   url: url,
	   success: function(result){
		    myAlert(langs.config_clear_success);
			hideLoading();
	   }
	});
}