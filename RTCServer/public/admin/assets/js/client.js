var id = "" ;
function client_edit(_id)
{
	if (_id == undefined)
		id = "" ;
	else
		id = getSelectedId(_id) ;

	var title = (id == ""?langs.client_create:langs.client_edit) ;
	var url = "../tools/client_edit.html?" + (id == ""?"":"clientid=" + id );
	dialog("client",title ,url) ;
}

function client_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;

	if (confirm("你确定要删除吗？"))
		dataList.del(id) ;
}



function client_link(url)
{
	var url = "../tools/view_url.html?" + (url == ""?"":"url=" + url );
	dialog("client","查看链接" ,url) ;
}

function client_detail_init()
{
	dataForm = $("#form-client").attr("data-id",clientId).dataForm({savecallback:client_saveCallBack});
}


function client_formatData(data)
{
	for (var i = 0; i < data.length; i++) {
        data[i].col_size = get_filesize(data[i].col_size);
        data[i].col_url = "http://" + serverAddr + ":" + serverPort + data[i].col_url ;
    }
	return data;
}

function client_saveCallBack()
{
	dataList.reload();
	dialogClose("client");
}

function client_search()
{

	dataList.search(get_where()) ;
}

function get_where()
{
	var where = "";
	var key =  $("#key").val() ;
	if (key != "")
		where = getWhereSql(where, "(col_name like '%" + key + "%') or (col_version like '%" + key + "%')") ;
	return where ;
}

function saveForm()
{
	if ($("#col_name").val() == "")
    {
        setElementError($("#col_name"),"请输入客户端名称");
        return false ;
    }
	if ($("#col_version").val() == "")
    {
        setElementError($("#col_version"),"请输入客户端版本");
        return false ;
    }
	if ($("#col_url").val() == "")
    {
        alert("请上传客户端安装包！");
        return false ;
    }
    dataForm.save();
}

var loading = "";

function uploadFile()
{
	loading = layer.load('正在上传安装包，请稍候……');
    var url = getAjaxUrl("client","upload") ;
    $("#form-client").attr("action",url).attr("target","frm_Upload").submit();
}


function uploadComplete(file)
{
	if(file.status>0)
	{
		$("#col_name").val(file.filename);
	    $("#col_version").val(file.version);
	    $("#col_size").val(file.filesize);
	    $("#col_url").val(file.filepath);
	}
	layer.close(loading);
}
