var DOC_FILE 		= 100 ;
var DOC_ROOT 		= 102;
var DOC_FOLDER 		= 105 ;
var DOCACE_VIEW		= 1;
var DOCACE_UPDATE	= 2;
var DOCACE_MANAGE	= 8;
var DOCACE_DOWNLOAD	= 16;
var DOCACE_CREATE	= 32;
var DOCACE_DELETE	= 64;
var DOCACE_RENAME	= 128;
var DOCACE_SEND		= 256;
var DOCACE_VERSION 	= 512;

var search_key = tools.$('#search_key');
//var mask = tools.$("#mask");
//var menu = tools.$('.content-menu')[0];
//var navBtn = tools.$('.navbtn')[0];
//var arrayBtn = tools.$('.arraybtn')[0];
//arrayBtn.onOff = true;
	
var ids = "" ;
var isflash = flashChecker().f ?1:0 ;
///////////////////////////////////////////////////////////////////////////////////////////
//check_path
///////////////////////////////////////////////////////////////////////////////////////////
function check_path()
{
	if (ispath)
		return 1 ;
	else
	{
		myAlert(langs.doc_error_path);
		return 0 ;
	}
}

///////////////////////////////////////////////////////////////////////////////////////////
//init flash upload
//不是路径，相关按钮不显示
//路径都显示，并根据权限判断disabled
///////////////////////////////////////////////////////////////////////////////////////////
function init_cmd_btn()
{
	//隐藏所有按钮
	$("#upload_disabled,#upload_swf,#upload_form,#upload_bigform,.btn_cmd").hide();

	//不是路径
	//alert(root_type+"|"+parent_id);
	if (label == "recent"||label == "search"||file_type!=0||(root_type==1&&parent_id=="0"))
		return ;

//	if (can(DOCACE_CREATE))
//	{
		if (isflash)
		{
			//swf upload
			$("#upload_swf").show();
			init_upload_swf();
		}
//		else
//		{
			// html upload
			$("#upload_form").show();
			$("#upload_bigform").show();
//		}
//	}
//	else
//	{
//		$("#upload_disabled").show();
//	}


	init_cmd_btn_container();
}

///////////////////////////////////////////////////////////////////////////////////////////
function init_cmd_btn1()
{
	//隐藏所有按钮
	$("#upload_disabled,#upload_swf,#upload_form,.btn_cmd").hide();

//	if (can(DOCACE_CREATE))
//	{
		if (isflash)
		{
			//swf upload
			$("#upload_swf").show();
			init_upload_swf1();
		}
		else
		{
			// html upload
			$("#upload_form").show();
		}
//	}
//	else
//	{
//		$("#upload_disabled").show();
//	}


	init_cmd_btn_container1();
}

//用于 body, doc_list
function init_cmd_btn_container(container)
{
	if (container == undefined)
		container = $("body");

	//$(".btn_cmd",container).hide();

	//不是路径
	//alert(JSON.stringify(aces));
	if (label == "recent"||label == "search"){
	  $(".doc_item").each(function(){
		  if($(this).attr("data-myid")=="Public") var roottype=1;
		  else var roottype=3;
		  set_btn_enabled($(".btn_doc_download",this),can(DOCACE_DOWNLOAD,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_qrcode",this),can(DOCACE_DOWNLOAD,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_delete",this),can(DOCACE_DELETE,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_move",this),can(DOCACE_MANAGE,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_edit",this),can(DOCACE_RENAME,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_online_edit",this),can(DOCACE_UPDATE,roottype,$(this).attr("data-path")));
		  set_btn_enabled($(".btn_doc_shareto",this),can(DOCACE_SEND,roottype,$(this).attr("data-path")));
		  if(!is_oos($(this).attr("data-name"))) set_btn_enabled($(".btn_doc_online_edit",this),false);
	  });
	}else{
		  if(file_type==0){
			  set_btn_enabled($(".btn_doc_download",$(".nav")),can(DOCACE_DOWNLOAD,root_type));
			  set_btn_enabled($(".btn_doc_delete",$(".nav")),can(DOCACE_DELETE,root_type));
			  set_btn_enabled($(".btn_folder_create",$(".nav")),can(DOCACE_CREATE,root_type));
			  set_btn_enabled($(".btn_doc_move",$(".nav")),can(DOCACE_MANAGE,root_type));
			  set_btn_enabled($(".btn_doc_shareto",$(".nav")),can(DOCACE_SEND,root_type));
		  };
		  $(".doc_item").each(function(){
			  set_btn_enabled($(".btn_doc_download",this),can(DOCACE_DOWNLOAD,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_qrcode",this),can(DOCACE_DOWNLOAD,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_delete",this),can(DOCACE_DELETE,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_move",this),can(DOCACE_MANAGE,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_edit",this),can(DOCACE_RENAME,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_online_edit",this),can(DOCACE_UPDATE,root_type,$(this).attr("data-path")));
			  set_btn_enabled($(".btn_doc_shareto",this),can(DOCACE_SEND,root_type,$(this).attr("data-path")));
			  if(!is_oos($(this).attr("data-name"))) set_btn_enabled($(".btn_doc_online_edit",this),false);
		  })
	}

	if (label == "recent"||label == "search"||file_type!=0){
		 $(".btn_cmd",$(".nav")).hide();
	}
	if(root_type==1&&parent_id=="0"&&file_type==0){
		  $(".doc_item").each(function(){
			  set_btn_enabled($(".btn_doc_view",this),false);
		  });
	}
	//$(".btn_cmd",container).show();
}

function init_cmd_btn_container1(item_id,container)
{
	if (container == undefined)
		container = $("#jqContextMenu");
	
	var doc_item = $("#" + item_id);	
	var roottype = root_type;
	if (label == "recent"||label == "search"){
		  if($(doc_item).attr("data-myid")=="Public") var roottype=1;
		  else var roottype=3;	
	}
	$("li",container).show();
	set_btn_enabled($(".btn_doc_download",container),can(DOCACE_DOWNLOAD,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_qrcode",container),can(DOCACE_DOWNLOAD,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_delete",container),can(DOCACE_DELETE,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_move",container),can(DOCACE_MANAGE,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_edit",container),can(DOCACE_RENAME,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_online_edit",container),can(DOCACE_UPDATE,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_shareto",container),can(DOCACE_SEND,roottype,$(doc_item).attr("data-path")));
	set_btn_enabled($(".btn_doc_set",container),can(DOCACE_VERSION,roottype,$(doc_item).attr("data-path")));
	if(!is_oos($(doc_item).attr("data-name"))) set_btn_enabled($(".btn_doc_online_edit",container),false);
	if($(doc_item).attr("data-myid")!="Public") set_btn_enabled($(".btn_doc_set",container),false);
	if(root_type==1&&parent_id=="0"&&file_type==0) set_btn_enabled($(".btn_doc_view",container),false);
}

//设置按钮的是否有效
function set_btn_enabled(els,enabled)
{
	//alert(enabled);
	if (enabled)
		$(els).show();
		
	else
		$(els).hide();
}

function init_upload_swf()
{
	var lbl_upload_count = $("#upload_container .upload_count") ;
	//alert(parent_type+"|"+parent_id+"|"+root_type+"|"+root_id+"|"+Msg_ID);
	$('#file_upload').uploadify({
		'formData'     : {
			'loginname' : curr_loginname,
			'password' : curr_password,
			'parent_type' : parent_type,
			'parent_id'     :parent_id,
			'root_type'   :root_type,
			'root_id'     : root_id,
			'flag'		  : 'swf'
		},
		'width':80,
		'height':34,
		'queueID':'upload_queue',
		"fileSizeLimit":UPLOAD_SIZE_LIMIT,
		'buttonImage':'/static/uploadify/btn_upload.png',
		'swf'      : '/static/uploadify/uploadify.swf',
		'uploader' : '/public/cloud.php?op=doc_upload',
		'checkExisting' : '/public/cloud.php?op=doc_checkExisting',
		onDialogClose:function(queueData){
			if (queueData.filesQueued == 0)
				return ;

			$("#upload_container").show();
			var count = queueData.filesSelected ;
			$(lbl_upload_count).html(count);
		},
		onUploadSuccess:function(file, response){
			var data = eval("(" + response + ")") ;
			file_upload_callback(data);
			//计数
			var count = parseInt($(lbl_upload_count).html())-1 ;
			$(lbl_upload_count).html(count);
		},

		onQueueComplete:function(file, response){
			$("#upload_container").hide();
			init_upload_swf();
		}
	});



}

function init_upload_swf1()
{
	var lbl_upload_count = $("#upload_container .upload_count") ;
	//alert(parent_type+"|"+parent_id+"|"+root_type+"|"+root_id);
	$('#file_upload').uploadify({
		'formData'     : {
			'loginname' : curr_loginname,
			'password' : curr_password,
			'parent_type' : parent_type,
			'parent_id'     :parent_id,
			'root_type'   :root_type,
			'root_id'     : root_id,
			'flag'		  : 'swf'
		},
		'width':80,
		'height':34,
		'fileTypeExts':'*.ods;*.xls;*.xlsb;*.xlsm;*.xlsx;*.doc;*.docm;*.docx;*.dot;*.dotm;*.dotx;*.odt;*.odp;*.pot;*.potm;*.potx;*.pps;*.ppsm;*.ppsx;*.ppt;*.pptm;*.pptx',
		'queueID':'upload_queue',
		"fileSizeLimit":UPLOAD_SIZE_LIMIT,
		'buttonImage':'/static/uploadify/btn_upload.png',
		'swf'      : '/static/uploadify/uploadify.swf',
		'uploader' : '/public/cloud.php?op=doc_onlinefile_upload',
		onDialogClose:function(queueData){
			if (queueData.filesQueued == 0)
				return ;

			$("#upload_container").show();
			var count = queueData.filesSelected ;
			$(lbl_upload_count).html(count);
		},
		onUploadSuccess:function(file, response){
			var data = eval("(" + response + ")") ;
			file_upload_callback1(data);
			//计数
			var count = parseInt($(lbl_upload_count).html())-1 ;
			$(lbl_upload_count).html(count);
		},

		onQueueComplete:function(file, response){
			$("#upload_container").hide();
		}
	});



}

///////////////////////////////////////////////////////////////////////////////////////////
//htmlinput file_upload_html
///////////////////////////////////////////////////////////////////////////////////////////
function file_upload_html()
{
	var url = getAjaxUrl("cloud","doc_upload",query + "&root_type=" + root_type + "&flag=html");
	var file_path = $("#inputfile").val();
	var file = document.getElementById("inputfile").files[0];
	if (!file) return ;
	if(file.size>1024*2014*256){
		myAlert(langs.doc_limit);
		return ;
	}
	
	var data = {'loginname':curr_loginname,'password':curr_password,'parent_type':parent_type,'parent_id':parent_id,'root_type':root_type,'root_id':root_id,'filename':file.name,'flag':'ie'} ;
	//console.log('doc_checkExisting:'+JSON.stringify(data));
	$.ajax({
		type : 'POST',
		dataType:"json",
		async : false,
		url : '/public/cloud.php?op=doc_checkExisting',
		data : data,
		success : function(result) {
			//console.log('doc_checkExisting1:'+JSON.stringify(result));
			switch(parseInt(result.status))
			{
				case 2:
					if(result.msg){
						var overwrite = confirm(langs.doc_exists_confirm.replace("{name}",file.name));
						if (overwrite) {
							url = url + "&existname=" + result.msg;
						}
					}
					break;
			}
		}
	});
	
	$("#form_upload").attr("target","frm_hidden").attr("action",url).submit();
}


function file_upload_callback(result)
{
	if (result.status == undefined){
		if(result.existname) doc_set_html3(result.rows,result.existname);
		else doc_set_html(result.rows,1);
		//Msg_ID=guid();
	}else
		showTips('err', result.msg);
}

function file_upload_html1()
{
	var url = getAjaxUrl("cloud","doc_onlinefile_upload",query + "&root_type=" + root_type + "&flag=html");
	var file_path = $("#inputfile").val();
    if(!is_oos(file_path)){
		 myAlert(langs.doc_error_oos);
		 return ;
	}
	$("#form_upload").attr("target","frm_hidden").attr("action",url).submit();
}

function file_upload_callback1(result)
{
	if (result.status == undefined){
		//if(file_type==2) 
		doc_set_html(result.rows,2);
	}
	else
		showTips('err', result.msg);
}

function file_upload_callback2(result)
{
	if (result.status == undefined){
		doc_set_html2(result.rows,1);
		//Msg_ID=guid();
	}else
		showTips('err', result.msg);
}
///////////////////////////////////////////////////////////////////////////////////////////
//doc_attr
///////////////////////////////////////////////////////////////////////////////////////////
function doc_attr(item_id)
{
	var arr_item = item_id.split("_");
	var url = "doc_attr.html?doc_type=" + arr_item[0] + "&doc_id=" + arr_item[1] ;
	dialog("attr",langs.doc_attr,url) ;
}

function doc_shareto(item_id)
{
	ids = get_ids2(item_id) ;
	if (ids == "")
		return ;
	var arr_id = ids.split(",");
	var doc_item = $("#" + arr_id[0]);

	var url = "doc_shareto.html?myid=" + $(doc_item).attr("data-myid") + "&sids=" + escape(ids);
	dialog("attr",langs.path_share,url) ;
}

function doc_set(item_id)
{
	var doc_item = $("#" + item_id);
	var url = site_address + "/admin/doc/doc_tree2.html?" + query + "&parent_type=" + DOC_FOLDER + "&parent_id=" + $(doc_item).attr("data-file-id");
	window.open(url);
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_search
///////////////////////////////////////////////////////////////////////////////////////////
function doc_search()
{
	var value = $("#search_key").val();
	var url = location.hash ;
	if (value != "")
		url = "#search/" + encode64(value) + "-" + root_type + "-" + parent_id + "-0" ;
	load_data(url);
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_share
///////////////////////////////////////////////////////////////////////////////////////////
function doc_edit(item_id)
{
	var doc_item = $("#" + item_id);
	var url = site_address + "/cloud/include/doceditor.php?OnlineID="+$(doc_item).attr("data-id")+"&"+query ;
	window.open(url);
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_share
///////////////////////////////////////////////////////////////////////////////////////////
function doc_share(item_id)
{
	//var doc_item = $("#" + item_id);
	var texturl = site_address + "/cloud/include/doceditor.php?OnlineID="+item_id ;
	$("#texturl").show();
	$("#texturl").val(texturl);
	$("#texturl").select(); // 选择对象 
	document.execCommand("Copy"); // 执行浏览器复制命令
//	window.clipboardData.setData("Text",url);
	myAlert(langs.doc_clipboardData); 
	$("#texturl").hide();
}



//function doc_share(item_id)
//{
//	var doc_item = $("#" + item_id);
//	var url = "http://" + site_address + "/cloud/include/doceditor.php?OnlineID="+$(doc_item).attr("data-id") ;
//	window.clipboardData.setData("Text",url);
//	myAlert(langs.doc_clipboardData); 
//}


function doc_share1(item_id)
{
	var url = site_address + "/cloud/include/doceditor.php?OnlineID="+item_id ;
	window.clipboardData.setData("Text",url);
	myAlert(langs.doc_clipboardData); 
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_move
///////////////////////////////////////////////////////////////////////////////////////////
function doc_move(item_id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}
	ids = get_ids2(item_id) ;
	if (ids == "")
		return ;

	dialog("move",langs.doc_move,"doc_move.html?root_id=" + root_id) ;
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_delete
///////////////////////////////////////////////////////////////////////////////////////////
function doc_delete(item_id)
{

	ids = get_ids2(item_id) ;
	if (ids == "")
		return ;

	var name = get_select_name(ids);
	if (window.confirm(langs.doc_dir_delete_confirm.replace("{dir}",name)) == false)
		return ;

	var url = getAjaxUrl("cloud","doc_delete",query);
	var data = {"root_type":root_type,"ids":ids} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
				remove_list_items(ids);
			else
				myAlert(result.msg);
	   }
	});
}

function doc_delete1(item_id)
{

	ids = get_ids(item_id) ;
	if (ids == "")
		return ;

	var name = get_select_name(ids);
	if (window.confirm(langs.doc_dir_delete_confirm.replace("{dir}",name)) == false)
		return ;
		
	var doc_item = $("#" + ids);
	var url = getAjaxUrl("cloud","doc_onlinefile_delete",query);
	var data = {"file_type":file_type,"doc_id":$(doc_item).attr("data-id"),"name":escape(name)} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
				remove_list_items(ids);
			else
				myAlert(result.msg);
	   }
	});
}
function doc_player(item_id)
{
	var doc_item = $("#" + item_id);
	var url = site_address + "/addin/videoPlayer.php?name="+$(doc_item).attr("data-target")+"&col_id=" + $(doc_item).attr("data-file-id")+"&FormFileType=1&"+query ;
	window.open(url);
}
///////////////////////////////////////////////////////////////////////////////////////////
//doc_open(item_id)
///////////////////////////////////////////////////////////////////////////////////////////
function doc_open(item_id)
{
	var doc_item = $("#" + item_id);
	var curr_type = $(doc_item).attr("data-type") ;
	var curr_filetype = $(doc_item).attr("data-filetype") ;

	if (curr_type == DOC_FILE)
	{
		var roottype = root_type;
		if (label == "recent"||label == "search"){
			  if($(doc_item).attr("data-myid")=="Public") var roottype=1;
			  else var roottype=3;	
		}
		switch(curr_filetype)
		{
			case "mpeg":case "mp3":
				if(can(DOCACE_UPDATE,roottype,$(doc_item).attr("data-path"))) doc_player(item_id);
				else doc_checkbox(item_id);
				break;
			case "pdf":
				if(can(DOCACE_UPDATE,roottype,$(doc_item).attr("data-path"))) doc_onlinefile(item_id);
				else doc_checkbox(item_id);
				break;
			case "doc":case "xls":case "ppt":
				if(can(DOCACE_UPDATE,roottype,$(doc_item).attr("data-path"))) doc_onlinefile(item_id);
				else doc_checkbox(item_id);
				break;
			default:
				doc_checkbox(item_id);
				break;
		}
	}
	else
	{
		//open folder
		//alert($(doc_item).attr("data-name") + "_" + $(doc_item).attr("data-type") + "_" + $(doc_item).attr("data-id") + "_" + $(doc_item).attr("data-rootid"));
		hash_to(encode64($(doc_item).attr("data-name")) + "_" + $(doc_item).attr("data-type") + "_" + $(doc_item).attr("data-id") + "_" + $(doc_item).attr("data-rootid"),hash.param) ;
	}
}

function doc_checkbox(item_id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}
	var fileList = tools.$('.file-list')[0]; // 文件展示区容器
	var fileItem = tools.$('.file-item', fileList);
	var allCheckbox = tools.$('.checkbox', fileList);
	var checkedAll = tools.$('.cheched-all')[0]; // 全选按钮
	var doc_item = $("#" + item_id);
	tools.removeClass(checkedAll, 'checked');
	tools.each(fileItem, function (item, index) {
		tools.removeClass(item, 'file-checked');
		tools.removeClass(allCheckbox[index], 'checked');
	});
	$(doc_item).parent().addClass("file-checked");
	$(".checkbox",doc_item).addClass("checked");
}


///////////////////////////////////////////////////////////////////////////////////////////
//doc_download
///////////////////////////////////////////////////////////////////////////////////////////
function doc_download(item_id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}


	ids = get_ids2(item_id) ;
	
	if (ids == "")
		return ;

	//alert(ids);
	var arr_id = ids.split(",");
	if (arr_id.length == 1)
	{
		//只有一个文件/文件夹
		var arr_item = ids.split("_");
		var doc_item = $("#" + arr_id[0]);
		if (arr_item[0] == DOC_FILE)
		{
			var url = get_download_url(arr_id[0]) ;
			//document.write(url);
			doc_download_go(url) ;
			return ;
		}
	}

	showLoading(langs.text_downloading);
	var name = get_select_name(ids) + ".zip" ;
	var url = getAjaxUrl("cloud","doc_download",query);
	var data = {"ids":ids,"name":name,"root_type":root_type} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				hideLoading();
				var url =  "label=msg&root_type=" + root_type + "&parent_type=" + parent_type + "&name=" + encodeURI(result.msg)  ;
				url = "/public/cloud.html?op=getfile&" + url + "&myid=" + urlrequest("myid") ;
				doc_download_go(url) ;
			}
			else
			{
				myAlert(result.msg);
				hideLoading();
			}
	   }
	});
}

function get_download_url(id)
{
	var doc_item = $("#" + id);
	var url =  "&root_type=" + root_type + "&root_id=" + $(doc_item).attr("data-rootid") + "&parent_type=" + parent_type + "&parent_id=" + $(doc_item).attr("data-rootid") +
			  "&id=" + $(doc_item).attr("data-id") + "&name=" + escape($(doc_item).attr("data-target"))+ "&filename=" +  escape($(doc_item).attr("data-name")) + "&myid=" + urlrequest("myid")  ;
	//myAlert(url);
	url = "/public/cloud.html?op=getfile&" + url ;
	return url ;
}

function doc_download_go(url)
{
	frm_hidden.location.href = url ;
}

///////////////////////////////////////////////////////////////////////////////////////////
//二维码下载
///////////////////////////////////////////////////////////////////////////////////////////
function doc_qrcode(id)
{
	var url = site_address + get_download_url(id) + "&loginname=" + curr_loginname + "&password=" + curr_password ;

	var doc_item = $("#" + id);

	var html =  "<div><img src='/public/qrcode.html?size=3&encode=1&text=" + escape(url) + "'></div>" +
				"<div>" + $(doc_item).attr("data-name") + "</div>" +
				"<div style='padding:5px;font-size:0.9em;'>" + $(".doc_size",doc_item).html() + "</div>" +
				"<div style='padding:5px;'><input type='button' class='btn btn_primary' value='"+langs.btn_close+"' data-dismiss='modal' aria-hidden='true' /></div>" ;
	showLoading(html,400,200);
}

function doc_save()
{
	if(parseInt(_curr_userid)){
		ids = get_ids2() ;
		if (ids == "")
			return ;
		dialog("share",langs.doc_save_to,"doc_share.html?root_id=" + root_id) ;
	}else{
		var url = decodeURI(hash.url);
		if (hash.param != "")
			url += "?" + hash.param ;
		url=site_address + "/cloud/include/share.html"+url;
		//alert(url);
		location.href = "../account/login.html?op=relogin&gourl="+escape(url) ;	
	}
	showLoading(html,310,200);
}


function folder_qrcode()
{
	var url = hash.url;
	if (hash.param != "")
		url += "?" + hash.param ;
	url=site_address + "/cloud/include/share.html"+url;

	var html =  "<div><img src='/public/qrcode.html?size=3&encode=1&text=" + escape(url) + "'></div>" +
				"<div>"+langs.doc_folder_qrcode+"</div>" +
				"<div style='padding:5px;'><input type='button' class='btn btn_primary' value='"+langs.btn_close+"' data-dismiss='modal' aria-hidden='true' /></div>" ;
	showLoading(html,400,200);
}

///////////////////////////////////////////////////////////////////////////////////////////
//doc_rename
///////////////////////////////////////////////////////////////////////////////////////////
function doc_rename(id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}

	var doc_item = $("#" + id);

	//已经是编辑状态
	if ($(".doc_name .file-edtor",doc_item).length>0)
		return ;

	//还原以前编辑的
	$(".doc_item .doc_name .file-edtor").each(function(){
		var old_value = $(this).parent().parent().attr("data-oldvalue");
		$(this).parent().html(old_value);
	})

	var container_name = $(".doc_name",doc_item) ;
	var value = $(doc_item).attr("data-name") ;
	$(doc_item).attr("data-oldvalue",value);



	var ipt = $("<span class='file-edtor'><input type='text' value='" + value + "' class='edtor'></span>") ;
	$(container_name).html(ipt) ;
	$(".edtor",ipt)
		.click(function(e){
			e.stopPropagation();
		})
		.blur(function(e){
			doc_rename_save(doc_item,ipt);
		})
		.focus()
		.select();

}

function doc_rename_save(doc_item,ipt)
{
	if ($(".doc_name .edtor",doc_item).val()==""||$(".doc_name .edtor",doc_item).val()==$(doc_item).attr("data-oldvalue")){
		$(ipt).parent().html($(doc_item).attr("data-oldvalue")) ;
		return ;
	}
	var url = getAjaxUrl("cloud","doc_rename",query);
	var data = {"doc_type":$(doc_item).attr("data-type"),"doc_id":$(doc_item).attr("data-id"),"name":$('.edtor',ipt).val(),"root_type":root_type} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
				$(ipt).parent().html($('.edtor',ipt).val()) ;
			else
			{
				$(ipt).parent().html($(doc_item).attr("data-oldvalue")) ;
				myAlert(result.msg);
			}
	   }
	});
}

function doc_rename1(id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}

	var doc_item = $("#" + id);

	//已经是编辑状态
	if ($(".doc_name .form-control",doc_item).length>0)
		return ;

	//还原以前编辑的
	$(".doc_item .doc_name .form-control").each(function(){
		var old_value = $(this).parent().parent().attr("data-oldvalue");
		$(this).parent().html(old_value);
	})

	var container_name = $(".doc_name",doc_item) ;
	var value = $(doc_item).attr("data-name") ;
	$(doc_item).attr("data-oldvalue",value);
	$(doc_item).attr("data-oldvalue1",'<a href="'+site_address+'/cloud/include/doceditor.php?OnlineID='+$(doc_item).attr("data-id")+'&loginname='+curr_loginname+'&password='+curr_password+'" target="_blank">'+value+'</a>');



	var ipt = $("<input type='text' class='form-control' value='" + value + "' style='padding:2px;margin-top:4px;width:90%;'/>") ;
	$(container_name).html(ipt) ;
	$(ipt)
		.click(function(e){
			e.stopPropagation();
		})
		.blur(function(e){
			doc_rename_save1(doc_item,ipt);
		})
		.focus()
		.select();

}

function doc_rename_save1(doc_item,ipt)
{
	if ($(".doc_name .form-control",doc_item).val()==""||$(".doc_name .form-control",doc_item).val()==$(doc_item).attr("data-oldvalue")){
		$(ipt).parent().html($(doc_item).attr("data-oldvalue1")) ;
		return ;
	}
	var url = getAjaxUrl("cloud","doc_onlinefile_rename",query);
	var data = {"doc_type":$(doc_item).attr("data-type"),"doc_id":$(doc_item).attr("data-id"),"name":$(ipt).val()} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
				$(ipt).parent().html('<a href="'+site_address+'/cloud/include/doceditor.php?OnlineID='+$(doc_item).attr("data-id")+'&loginname='+curr_loginname+'&password='+curr_password+'" target="_blank">'+$(ipt).val()+'</a>') ;
			else
			{
				$(ipt).parent().html($(doc_item).attr("data-oldvalue1")) ;
				myAlert(result.msg);
			}
	   }
	});
}

function doc_az(id,e)
{
	var doc_item = $("#" + id);
	var url = getAjaxUrl("cloud","doc_onlinefile_az",query);
	var data = {"file_type":file_type,"doc_id":$(doc_item).attr("data-id")} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
				//doc_refresh() ;
				$(doc_item).insertBefore($(".doc_item").eq(0));    //移动节点
			else
				myAlert(result.msg);
	   }
	});
}

function doc_col(id,e)
{
	var doc_item = $("#" + id);
	var url = getAjaxUrl("col","createcol",query);

	var listtype="@";
	var filetarget=window.location.href;
	var title=left(filetarget.replace(/\s+/g,""),20);
	var data = {"doc_type":DOC_FILE,"title":title,"content":escape(filetarget),"usid":curr_userid,"types":listtype} ;
    //document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				myAlert(langs.doc_col_success);
			}
			else
			{
				myAlert(langs.doc_col_failed);
			}
	   }
	}); 
}

function left(mainStr,lngLen) { 
if (lngLen>0) {return mainStr.substring(0,lngLen)} 
else{return null} 
}

function folder_create()
{
	dialog("folder",langs.folder_create,"folder_edit.html") ;
}

function doc_create(doctype)
{
	if(doctype==1){
		 var Stext="template/new.docx";
		 var filesize=11310;
	}else{
		 var Stext="template/new.xlsx";
		 var filesize=8257;
	}
	var url = getAjaxUrl("cloud","doc_onlinefile_save",query);
	var data = {"usname":escape(curr_myfcname),"filename":escape(getFullFileName(Stext)),"filesize":filesize,"target_file":escape(Stext)} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status == undefined){
				//if(file_type==2) 
				//alert(JSON.stringify(result));
				doc_set_html(result.rows,2);
			}
			else
			{
				myAlert(result.msg);
			}
	   }
	});
	
}

function doc_restore()
{
	var doc_item = $("#100_"+pageindex+"_0");
	if (window.confirm(langs.doc_restore_confirm.replace("{dir}",$(doc_item).attr("data-sid"))) == false)
			return ;
	var url = getAjaxUrl("cloud","doc_revisedfile_save",query);
	var data = {"doc_sid":$(doc_item).attr("data-sid"),"doc_id":$(doc_item).attr("data-id"),"target_file":escape($(doc_item).attr("data-target"))} ;
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status == undefined){
				var sid=$("#sidebar .submenu li").length;
				var html = '<li id="100_'+sid+'_0" data-sid="'+sid+'" data-id="'+result.rows[0].onlineid+'" data-name="'+result.rows[0].todate+" "+result.rows[0].totime+langs.doc_restore.replace("{dir}",sid)+'" data-target="'+result.rows[0].filpath+'" onclick="сonnectEditor1('+sid+');"><span class="dtime">'+result.rows[0].todate+" "+result.rows[0].totime+langs.doc_restore.replace("{dir}",sid)+'</span><br><span class="description">'+result.rows[0].description+'</span></li>' ;
				$(".submenu").prepend(html) ;
			}
			else
			{
				myAlert(result.msg);
			}
	   }
	});
	
}

function doc_onlinefile(id,e){
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}

	var doc_item = $("#" + id);
	if($(doc_item).attr("data-filetype")=="pdf"){
		var url = get_download_pdf_url(id) ;
		window.open(url);
		return ;
	}
	
	var url = "usname=" + escape(_curr_myfcname) + "&filename=" + escape($(doc_item).attr("data-name")) + "&filesize=" + $(doc_item).attr("data-filesize") + "&target_file=" + $(doc_item).attr("data-target") + 
			  "&col_id=" + $(doc_item).attr("data-file-id") + "&FormFileType=5&" + query + "&myid=" + _curr_userid ;
	url = "/public/cloud.html?op=doc_onlinefile_save&" + url ;
	window.open(url);
	
//	var url = getAjaxUrl("cloud","doc_onlinefile_save",query+"&myid="+_curr_userid);
//	var data = {"usname":escape(_curr_myfcname),"filename":escape($(doc_item).attr("data-name")),"filesize":$(doc_item).attr("data-filesize"),"target_file":$(doc_item).attr("data-target"),"col_id":$(doc_item).attr("data-file-id"),"FormFileType":1} ;
//	//alert(url+JSON.stringify(data));
//	$.ajax({
//	   type: "POST",
//	   dataType:"json",
//	   data:data,
//	   url: url,
//	   success: function(result){
//			if (result.status == undefined){
//				var url = site_address + "/cloud/include/doceditor.php?OnlineID="+result.rows[0].col_id+"&"+query ;
//				window.open(url);
//			}
//			else
//				alert(result.msg);
//	   }
//	});

}

function get_download_pdf_url(id)
{
	var doc_item = $("#" + id);
//	var url = query+"&label=" + label + "&root_type=" + root_type + "&root_id=" + $(doc_item).attr("data-rootid") + "&parent_type=" + DOC_FOLDER + "&parent_id=" + $(doc_item).attr("data-rootid") +
//			  "&id=" + $(doc_item).attr("data-file-id") + "&name=" + $(doc_item).attr("data-target")+ "&filename=" +  escape($(doc_item).attr("data-name"))  ;
//	//alert(url);
//	url = site_address + "/public/cloud.html?op=getpdffile1&" + url + "&myid=" + urlrequest("myid") ;
	var url = query + "&FormFileType=1&col_id=" + $(doc_item).attr("data-file-id") + "&name=" + encode64(encodeURI($(doc_item).attr("data-target")));
	url = site_address + "/public/cloud.html?op=getpdffile4&" + url ;
	return url ;
}


function get_select_name(ids)
{
	var arr_id = ids.split(",");
	var name = $("#" + arr_id[0]).attr("data-name") ;
	if (arr_id.length>1)
		name = name + "...(" + arr_id.length + ")"+langs.get_select_name ;
	return name ;
}

///////////////////////////////////////////////////////////////////////////////////////////
//权限相关
///////////////////////////////////////////////////////////////////////////////////////////
var ace_data = [{"doc_type":105,"doc_id":1,"power":1},{"doc_type":102,"doc_id":1,"power":1}] ;
var path_data =  [{"doc_type":105,"doc_id":1,"root_id":1},{"doc_type":102,"doc_id":1,"root_id":1}] ;
var my_root_id = 1 ;

//调用此函数，必须先得到 power
function can(op,roottype,rootid)
{
	//褰撳墠鏄釜浜烘枃浠跺す
//	if (root_id == my_root_id)
//		return true ;
	if (roottype == 1){
		 var power = get_power1(op,rootid);
		 //alert(power);
		 var can = (power & op) == op ;
		 if(_isadmin) var can = 1 ;
	}else{
		 power = get_power(op);
		 var can = (power & op) != op ;
	}
	return can ;
}


//判断是否在aces中
function get_power(op)
{
	var s;
	//因为路径是从跟开始，所以这个倒序
//	if (roottype == 1){
//		if (op == DOCACE_CREATE)
//			s = "21" ;
//		else if (op == DOCACE_DOWNLOAD)
//			s = "22" ;
//	}
//	else if (roottype == 3){
		if (op == DOCACE_CREATE||op == DOCACE_DELETE||op == DOCACE_MANAGE||op == DOCACE_RENAME)
			s = "2" ;
		else if (op == DOCACE_SEND)
			return 1 ;
		else if (op == DOCACE_DOWNLOAD||op == DOCACE_UPDATE)
			s = "10" ;
//	}
//alert(s);
//alert(JSON.stringify(aces));
	for(var j=0;j<aces.length;j++)
	{
		if (aces[j] == s)
			return 1 ;
	}

	return -1 ;
}

//判断是否在aces中
function get_power1(op,rootid)
{
	if(rootid) path_data = JSON.parse(rootid);
	for(var i=path_data.length-1;i>=0;i--)
	{
//		alert(path_data[i].col_rootid+"|"+path_data[i].col_id);
		for(var j=0;j<ace_data.length;j++)
		{
			//alert(ace_data[j].doc_id +"|"+ path_data[i].col_id);
			if (String(ace_data[j].doc_id) == String(path_data[i].doc_id)) return ace_data[j].power ;
		}
	}
	return 0 ;
}

///////////////////////////////////////////////////////////////////////////////////////////
//dir tree
///////////////////////////////////////////////////////////////////////////////////////////
var rootId = 0 ;
var path = "" ;
var nodeId = "" ;
var nodeText = "" ;
var op = "" ;
var tree ;
function loadTree(container_id)
{
    tree=new dhtmlXTreeObject(container_id,"100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("cloud","get_root_tree","loginname=" + curr_loginname + "&password=" + curr_password+"&root_id=0") ;
    tree.setXMLAutoLoading(url);
	tree.loadXML(url,function(){
		var arr_nodeId = getCookie("BA-getTreeId").split("/");
	  　　$.each(arr_nodeId,function(i,item){
			setTimeout(function(){
				tree.openItem(item);
			}, i*500);
	  　　});
		$("#container_target_tree .loading").remove();
	});

}

function loadTree1(container_id,root_id)
{
    tree=new dhtmlXTreeObject(container_id,"100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("cloud","get_tree","loginname=" + curr_loginname + "&password=" + curr_password+"&root_id="+root_id+"&root_type=" + root_type) ;
	//console.log(url);
    tree.setXMLAutoLoading(url);
    //tree.loadXML(url);
	tree.loadXML(url,function(){
		var arr_nodeId = getCookie("BA-getTreeId").split("/");
	  　　$.each(arr_nodeId,function(i,item){
			setTimeout(function(){
				//console.log('arr_nodeId:'+i*500);
				tree.openItem(item);
			}, i*500);
	  　　});
	  $("#container_target_tree .loading").remove();
	});
}

function treeClick()
{
	path = getTreePath(tree) ;
	nodeId = tree.getSelectedItemId();

	$("#target_path_name").html(path).attr("folder_id",nodeId);

}

function selectItem(item_id)
{
		var doc_item = $("#" + item_id);
		var chk=doc_item.find(":checkbox");
		if(chk.is(":checked"))
		{
			chk.prop("checked",false);
		}
		else
		{
			chk.prop("checked",true);
		}
}

function doc_clipboard()
{
	var texturl = location.href.replace("cloud/include/yunpan2.html","cloud/include/yunpan.html") ;
	var html =  '<textarea class="form-control" rows="5" name="texturl" id="texturl" style="width:95%;">'+texturl+'</textarea>' +
				'<div>' + langs.doc_clipboardData + '</div>' +
				'<div style="padding:5px;"><input type="button" class="btn btn-primary" value="'+langs.doc_clipboard+'" onClick="doc_chrome();" />&nbsp;&nbsp;<input type="button" class="btn btn-default" value="'+langs.doc_close+'" onClick="hideLoading();" /></div>' ;
	showLoading(html,500,400);
}

function doc_chrome()
{
	var copyText = location.href.replace("cloud/include/yunpan2.html","cloud/include/yunpan.html") ;
	// ie浏览器
	if (window.clipboardData) {
	  window.clipboardData.clearData();
	  window.clipboardData.setData("Text", copyText);
	}
}