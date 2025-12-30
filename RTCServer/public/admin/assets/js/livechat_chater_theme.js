function chater_theme_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1);
}

function chater_theme_list_init()
{
	dataList = $("#datalist").dataList(formatData);
}

function formatData(data)
{
	for(i=0;i<data.length;i++)
	{
		if (data[i].groupid == 1) data[i].groupid = langs.livechat_chater_theme_ro1;
		else data[i].groupid = langs.livechat_chater_theme_ro2;
	}
    return data ;
}

function listCallBack()
{
    formatTagRow(4) ;
}


function chater_theme_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.livechat_chater_theme_create:langs.livechat_chater_theme_edit) ;
	var url = "../lv_manager/chater_theme_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
	dialog("chater_theme",title ,url,{width:0,height:350,isClear:true}) ;
}

var id = "" ;
function chater_theme_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function chater_theme_detail_init()
{
	dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});
}

function saveForm()
{
    if ($("#typename").val() == "")
    {
        setElementError($("#typename"),langs.livechat_chater_theme_name_require);
        return false ;
    }
	
    if(specialCharValidate($("#typename").val()))
    {
    	setElementError($("#typename"),langs.vaild_special_char);
    	return;
    }
	
    var itemIndex = $("#ord").val();

    if(isNaN(itemIndex))
    	itemIndex = 0;

    if(itemIndex <= 0 )
	{
    	myAlert(langs.livechat_chater_theme_order_require_integer);
    	return;
	}
    dataForm.save();
}

function group_getCallBack(data)
{

}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("chater_theme");
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
