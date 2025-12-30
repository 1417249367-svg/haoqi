function chater_domain_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1);
}

function chater_domain_list_init()
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
				myAlert(langs.livechat_chater_domain_delete_default);
			})
		})
		
	})
	clear_data();
	append_data("Jump_RTCServer_IP",$(".row-" + id).attr("data-name"));
	Switch_saveCallBack();
}


function chater_domain_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.livechat_chater_domain_create:langs.livechat_chater_domain_edit) ;
	var url = "../lv_manager/chater_domain_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
	dialog("chater_domain",title ,url,{width:0,height:150,isClear:true}) ;
}

var id = "" ;
function chater_domain_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function chater_domain_detail_init()
{
	dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});
}

function saveForm()
{
    if ($("#typename").val() == "")
    {
        setElementError($("#typename"),langs.livechat_chater_domain_name_require);
        return false ;
    }
	
	if(left($("#typename").val(), 7)=="http://"||left($("#typename").val(), 8)=="https://"){
	var TempString=$("#typename").val();
	}else{
	var TempString="http://"+$("#typename").val();
	}
	if(right(TempString, 1)=="/"){
	TempString=TempString.substring(0,TempString.length-1);
	}
	$("#typename").val(TempString);
	
    dataForm.save();
}

function group_getCallBack(data)
{

}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("chater_domain");
}

var loading = "";
function uploadFile()
{
	if(limitAttach("file_picture"))
	{
		loading = layer.load(langs.text_uploading);
	    var url = getAjaxUrl("upload","upload","autoFileName=0&file_path=\\Data\\MyPic\\&file_name=" +  groupId) ;
		//document.write(url);
	    $("#form-group").attr("action",url).attr("target","frm_Upload").submit();
	}
}

function uploadComplete(file)
{
	//alert(url+JSON.stringify(param));
	if(file.status>0)
	{
//	    $("#filename").val(file.filename);
//	    $("#filefactpath").val(file.factpath);
	    $("#img_picture").attr("src",replaceAll(file.filepath,"//","/"));
//	    $("#col_photo").val("AntWeb://Faces/" + file.filesaveas);
//	    $("#filesaveas").val(file.filesaveas);
	}
	layer.close(loading);
}
