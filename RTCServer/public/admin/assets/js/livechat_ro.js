function chater_ro_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1,1);
}

function chater_ro_member1(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1,2);
}

function chater_ro_member2(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1,3);
}

function chater_ro_member4(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(4,objId,1,5);
}

function chater_ro_list_init()
{
	dataList = $("#datalist").dataList();
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


function chater_ro_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.livechat_chater_ro_create:langs.livechat_chater_ro_edit) ;
	var url = "../lv_manager/chater_ro_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
	dialog("chater_ro",title ,url,{width:0,height:500,isClear:true}) ;
}

var id = "" ;
function chater_ro_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function chater_ro_detail_init()
{
	formatTabs("tabs","250px");

	$(".group-column,#container_treeuser").height(260);
	dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});

	//init treeuser
	loadTreeUser();

	//init org
	//loadTag(EMP_GROUP,groupId);

}

function saveForm()
{
    if ($("#typename").val() == "")
    {
        setElementError($("#typename"),langs.livechat_chater_ro_name_require);
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
    	myAlert(langs.livechat_chater_ro_order_require_integer);
    	return;
	}
	
   var my_ids = getMemberIds() ;
   if(my_ids==''){
	  myAlert(langs.doc_dir_warning);
	  return ;
   }

    $("#memberIds").val(my_ids);
	for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
	var welcome=$("#welcome").val();
	welcome=replaceAll(welcome,"\n","");
	var Request = new Object(); 
	var newContent= welcome.replace(/<img [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{e@"+Request['name']+"|0|0|}";
		return newStr;
	});
	newContent= newContent.replace(/<video [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{i@"+Request['name']+"|0|0|FileRecv/MessageVideoPlay.png}";
		return newStr;
	});
	 $("#welcome").val(newContent);
    dataForm.save();
}



function group_getCallBack(data)
{
	// init member
	for(var i=0;i<data.members.length;i++)
		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname,data.members[i].isadmin);
	CKEDITOR.replace('welcome');
	CKEDITOR.instances.welcome.setData(PastImgEx1(data.welcome));
}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("chater_ro");
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

	
	///////////////////////////////////////////////////////////////////////////////////////////
	//doc_share
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_share(typeid)
	{
		//var doc_item = $("#" + item_id);
		var texturl = site_address + "/kefu.html?typeid="+typeid ;
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_clipboardData); 
		$("#texturl").hide();
	}
	
	function doc_js(typeid)
	{
		//var doc_item = $("#" + item_id);
		var texturl = '<script>'
					+'var _rtckf = _rtckf || [];'
					+'(function() {'
						+'var kf = document.createElement("script");'
						+'kf.src = "' + site_address + '/livechat/getjs/?typeid=' + typeid + '";'
						+'var s = document.getElementsByTagName("script")[0];'
						+'s.parentNode.insertBefore(kf, s);'
					+'})();'
					+'<\/script>';
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_jsclipboardData); 
		$("#texturl").hide();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//二维码下载
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_qrcode(typeid,username,picture)
	{
		var url = site_address + "/kefu.html?typeid="+typeid+"&sourceurl=qrcode" ;
	
		if(!picture) picture="MyPic/default.png";
		//document.write("/public/qrcode.html?myid=public&size=3&logo=" + picture + "&encode=1&text=" + escape(url));
		var html =  "<div><img src='/public/qrcode.html?myid=public&size=6&logo=" + picture + "&encode=1&text=" + escape(url) + "'></div>" +
					"<div>" + username + "</div>" +
					"<div style='padding:5px;'><input type='button' class='btn btn_primary' value='"+langs.btn_close+"' data-dismiss='modal' aria-hidden='true' /></div>" ;
		showLoading(html,310,200);
	}

