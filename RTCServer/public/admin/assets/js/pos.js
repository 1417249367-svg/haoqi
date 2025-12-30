var id = "" ;

function pos_list_init()
{
	dataList = $("#datalist").attr("data-where",get_where()).dataList(formatData);
	$("#key").keyup(function(){
		pos_search();
	})
}

function formatData(data)
{
	for (var i = 0; i < data.length; i++) {
		data[i].col_img_url = data[i].col_pos_imgpath.replace("AntWeb://Posidx","http://" + serverAddr + ":" + rtcPort + "/Posidx");
	}
    return data ;
}

function pos_edit(_id){

	if (_id == undefined)
		id = "" ;
	else
	{
		id = getSelectedId(_id) ;;
	}
	var title = (id == ""?langs.pos_create:langs.pos_edit) ;
	title += "<small style='color:#f00;'>(图标尺寸为16px*16px)</small>";
	var url = "../hs/pos_edit.html?" + (id == ""?"":"posidx=" + id ) ;
	dialog("pos",title ,url) ;
}

function pos_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;
	if (confirm("你确定要删除吗？"))
		dataList.del(id) ;
}

function pos_search(){
	dataList.search(get_where()) ;
}

function get_where()
{
	var where = "";
	var key =  $("#key").val() ;
	if (key != "")
		where = getWhereSql(where, "col_pos_name like '%"  + key + "%'") ;
	return where ;
}

function pos_detail_init()
{
	dataForm = $("#form-pos").attr("data-id",posidx).dataForm({getcallback:pos_getCallBack,savecallback:pos_saveCallBack});
}

function pos_getCallBack(data)
{
	if(data.col_pos_imgpath !="" )
	{
		photo_url = data.col_pos_imgpath.replace("AntWeb://Posidx/","http://" + serverAddr + ":" + rtcPort + "/Posidx/");
		$("#pos_img").attr("src",photo_url);
	}
}

function pos_saveCallBack()
{
	dataList.reload();
	dialogClose("pos");
}


function saveForm()
{
	var posIdx = $("#col_pos_idx").val();
    if (isNaN(posIdx))
    	posIdx = 0 ;


	if(posIdx <= 0)
	{
    	setElementError($("#col_pos_idx"),"序号必须是正整数");
    	return;
	}

    if ($("#col_pos_name").val() == "")
    {
        setElementError($("#col_pos_name"),"请输入铭牌名称");
        return false ;
    }

    if($("#col_pos_imgpath").val() == "" )
	{
    	myAlert("请上传铭牌图标");
        return false ;
	}

    dataForm.save();
}

var loading = "";

function uploadFile()
{
	if(limitAttach("updatefile"))
	{
		loading = layer.load('图片上传中……');
	    var url = getAjaxUrl("upload","livechat") ;
	    $("#form-pos").attr("action",url).attr("target","frm_Upload").submit();
	}
}

function uploadComplete(file)
{
	if(file.status>0)
	{
	    $("#filename").val(file.filename);
	    $("#filefactpath").val(file.factpath);
	    $("#pos_img").attr("src",file.filepath);
	    $("#col_pos_imgpath").val("AntWeb://Posidx/" + file.filesaveas);
	    $("#filesaveas").val(file.filesaveas);
	}
	layer.close(loading);
}