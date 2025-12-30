function group_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1);
}

function group_tag(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;
	tag_picker(4,objId,1);
}



function group_list_init()
{
	dataList = $("#datalist").attr("data-where",get_where()).dataList(formatData,listCallBack);
	$("#key").keyup(function(){
		group_search();
	})
}

function formatData(data)
{
	for(i=0;i<data.length;i++)
	{
		data[i].col_usedspace = get_filesize(data[i].col_usedspace);
		data[i].col_grouptype = (data[i].col_dtype==1) ? langs.group_type_fixed : langs.group_type_temp;
		data[i].to_date = toDate(data[i].to_date,1);
	}
    return data ;
}

function listCallBack()
{
    formatTagRow(4) ;
}

function group_search(){

	dataList.search(get_where()) ;
}

function get_where()
{
	var where = "";
	//where = getWhereSql(where,"col_type=8");

	var key =  $("#key").val() ;
	if (key != "")
		where = getWhereSql(where, "(TypeName like '%" + key + "%')") ;
	return where ;
}

function group_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.group_create:langs.group_edit) ;
	var url = "../hs/group_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
	dialog("group",title ,url,{width:0,height:350,isClear:true}) ;
}

var id = "" ;
function group_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function group_detail_init()
{
	formatTabs("tabs","250px");

	$(".group-column,#container_treeuser").height(260);
	dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});


	//init searchinput
	user_search_init() ;

	//init treeuser
	loadTreeUser();

	//init org
	//loadTag(EMP_GROUP,groupId);

}

function saveForm()
{
    if ($("#typename").val() == "")
    {
        setElementError($("#typename"),langs.group_name_require);
        return false ;
    }
	
    if(specialCharValidate($("#typename").val()))
    {
    	setElementError($("#typename"),langs.vaild_special_char);
    	return;
    }
	
    var diskSpace = $("#disk_space").val();
    var itemIndex = $("#itemindex").val();

    if (isNaN(diskSpace))
		diskSpace = 0 ;
    if(isNaN(itemIndex))
    	itemIndex = 0;

    if(diskSpace <= 0 )
	{
    	setElementError($("#disk_space"),langs.group_diskspace_require_integer);
    	return;
	}

    if(itemIndex <= 0 )
	{
    	myAlert(langs.group_order_require_integer);
    	return;
	}

    $("#memberIds").val(getMemberIds());
    dataForm.save();
}



function group_getCallBack(data)
{
	var url = "/public/msg.html?op=getimg1&url=MyPic/"+data.typeid+".jpg" ; 
	//document.write(url);
	if(data.pic[0].pic !="0" ) $("#img_picture").attr("src",url);

	//详情加载后加初始化树，因为要先取到详情的ORGIDS

	// init member
	for(var i=0;i<data.members.length;i++)
		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname,data.members[i].isadmin);

}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("group");
}

var loading = "";
function uploadFile()
{
	if(limitAttach("file_picture"))
	{
		loading = layer.load(langs.text_uploading);
	    var url = getAjaxUrl("upload","group","autoFileName=0&file_path=MyPic/&file_name=" +  groupId) ;
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
	    $("#img_picture").attr("src",get_download_img_url(replaceAll(file.filepath,"//","/")));
		//alert($("#img_picture").attr("src"));
//	    $("#col_photo").val("AntWeb://Faces/" + file.filesaveas);
//	    $("#filesaveas").val(file.filesaveas);
	}
	layer.close(loading);
}
