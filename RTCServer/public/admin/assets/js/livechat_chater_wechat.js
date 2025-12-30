function chater_wechat_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1);
}

function chater_wechat_list_init()
{
	dataList = $("#datalist").dataList(formatData,listCallBack);
}

function formatData(data)
{
    return data ;
}

function listCallBack()
{
	$("input[name='defaultrole'][data-value='1']").attr("checked", true);
	var id=$("input[name='defaultrole'][data-value='1']").attr("id").substring(12);
	$(".row-" + id).each(function(){
		$("input[type=checkbox]",this).remove();
		$(".btn_delete",this).remove();
		
		$(".btn_disabled,.btn_delete,.btn_member",this).each(function(){
			$(this).unbind("click");
			$(this).click(function(){
				myAlert(langs.livechat_chater_wechat_delete_default);
			})
		})
		
	})
	clear_data();
	append_data("weChat_domain",$(".row-" + id).attr("data-domain"));
	append_data("weChat_appid",$(".row-" + id).attr("data-appid"));
	append_data("weChat_sercet",$(".row-" + id).attr("data-sercet"));
	append_data("weChat_token",$(".row-" + id).attr("data-token"));
	append_data("weChat_moban_id",$(".row-" + id).attr("data-moban_id"));
	append_data("weChat_subscribe",$(".row-" + id).attr("data-subscribe"));
	append_data("weChat_subscribe_id",$(".row-" + id).attr("data-subscribe_id"));
	append_data("weChat_subscribe_id2",$(".row-" + id).attr("data-subscribe_id2"));
	append_data("weChat_groupid",$(".row-" + id).attr("data-groupid"));
	append_data("weChat_domain1",$(".row-" + id).attr("data-domain1"));
	append_data("weChat_appid1",$(".row-" + id).attr("data-appid1"));
	append_data("weChat_sercet1",$(".row-" + id).attr("data-sercet1"));
	append_data("weChat_moban_id1",$(".row-" + id).attr("data-moban_id1"));
	Switch_saveCallBack();
}


function chater_wechat_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.livechat_chater_wechat_create:langs.livechat_chater_wechat_edit) ;
	var url = "../lv_manager/chater_wechat_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
	dialog("chater_wechat",title ,url,{width:0,height:480,isClear:true}) ;
}

var id = "" ;
function chater_wechat_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function chater_wechat_detail_init()
{
	formatTabs("tabs","250px");
	dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});
}

function saveForm()
{
    if ($("#domain").val() == "")
    {
        setElementError($("#domain"),langs.livechat_chater_domain_name_require);
        return false ;
    }
	//$("#subscribe").val($("input[name='subscribe']:checked").val());
	dataForm.save();
}

function group_getCallBack(data)
{
	$("input[name='subscribe'][value='"+data.subscribe+"']").attr("checked",true);
}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("chater_wechat");
}

var loading = "";
function import_txt()
{
	dialog("chater_wechat_import_txt",langs.import_txt,"../lv_manager/import_txt.html") ;
}

function import_upload(_flag)
{
	flag = _flag ;
	uploadFile($("#file_import"));
}

function uploadFile(ipt,saveFileName)
{
	var fileId = $(ipt).attr("id");
    var fileName = $(ipt).val() ;
    if (fileName == "")
    {
    	myAlert("请选择上传的文件");
        return ;
    }
		
	var url = getAjaxUrl("upload","txt","autoFileName=0") ;
    var _form = $("form");
    var action = $(_form).attr("action") ;
    var target = $(_form).attr("target") ;
    if (action == undefined)
        action = "" ;
    if (target == undefined)
        target = "" ;

    $(_form)
        .attr("action",url)
        .attr("target","frm_Upload")
        .submit();
     $(_form)
        .attr("action",action)
        .attr("target",target) ;
}

function uploadComplete(file)
{
	dialogClose("chater_wechat_import_txt");
}