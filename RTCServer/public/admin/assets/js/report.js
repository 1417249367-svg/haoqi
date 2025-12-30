var DOC_FILE 		= 100 ;
var DOC_ClotFile = 101 ;
var DOC_DownLoad = 103 ;
var DOC_LeaveFile = 104 ;
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
var show_img_sizelimit   = 2 * 1024 * 1024 ; // 图片显示大小限制 0 不限制，图片大小消耗内存  2M（2 * 1024 * 1024）

var ids = "" ;

var id = "" ;
var FormFileType;
var doc_data ;
function file_delete(_id)
{
   id = getSelectedId(_id) ;
   if (id == "")
		return ;
	if (confirm(langs.text_delete_config))
		dataList.del(id) ;
}

function urlrequest(paras) {
	var url = location.href;
	var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
	var paraObj = {}
	for (i = 0; j = paraString[i]; i++) {
		paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
	}
	var returnValue = paraObj[paras.toLowerCase()];
	if (typeof (returnValue) == "undefined") {
		return "";
	} else {
		return returnValue;
	}
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

	var url = get_download_url(item_id) ;
	doc_download_go(url) ;
}


function get_download_url(id)
{
	var doc_item = $("#" + id);
	if($(doc_item).attr("data-type")==DOC_ClotFile||$(doc_item).attr("data-type")==DOC_LeaveFile) var label="msg";
	else var label="";
	var url =  "&root_type=" + root_type + "&root_id=" + $(doc_item).attr("data-rootid") + "&parent_type=" + parent_type + "&parent_id=" + $(doc_item).attr("data-rootid") +
			  "&id=" + $(doc_item).attr("data-id") + "&name=" + escape($(doc_item).attr("data-target"))+ "&filename=" +  escape($(doc_item).attr("data-name")) + "&label=" + label + "&myid=public"  ;
	//console.log(id+url);
	url = "/public/cloud.html?op=getfile&" + url ;
	return url ;
}

function doc_download_go(url)
{
	frm_Upload.location.href = url ;
}

function listCallBack(rows,recordcount)
{
	//得到图片预览
	$(".doc_item[data-filetype=img]").each(function(){
		var roottype=1;
		var url = "root_type=" + root_type + "&root_id=" + $(this).attr("data-rootid") + "&parent_type=" + parent_type + "&parent_id=" + $(this).attr("data-rootid") + 
				  "&id=" + $(this).attr("data-id") + "&name=" +  escape($(this).attr("data-target")) + "&data_type=" + $(this).attr("data-type") + "&myid=public";
		url = "/public/cloud.html?op=getimg&" + url ; 
		//window.prompt("getimg",url);
		$(".doc_icon",this).html("<a href='" + url + "' rel='lightbox-group' target='_blank'><img class='icon_img' src='/static/img/pix.png'/></a>") ;								
	})
	
	//异步加载图片
	load_img();
	
	//lightbox
	formatViewer();
}


function load_img()
{
	//得到图片预览
	$(".doc_item[data-filetype=img]").each(function(){
		var doc_item = this ;
		var isload = 1 ;
		if (show_img_sizelimit > 0)
			isload = parseInt($(this).attr("data-filesize")) < show_img_sizelimit;

		if (isload)
		{
			var img = new Image();
			img.src = $(".doc_icon a",this).attr("href") + "&type=thumb" ;  // type
			img.onload=function(){$(".doc_icon img",doc_item).attr("src",$(this).attr("src")).removeClass("icon_img");};  
		}
	})
	
}

function doc_set(_id)
{
   id = getSelectedIdData(_id) ;
   if (id == "")
		return ;

	var url = getAjaxUrl("cloud","doc_onlinefile1_save");
	var data = {"ids":id,"FormFileType":FormFileType} ;
	//console.log(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status == undefined){
				doc_data=result.rows;
//					var val = "" ;
//					for (var i = 0; i < _data.length; i++) val += "," + _data[i].col_id;
//				    if (val != "") val = val.substring(1,val.length)  ;
				dialog("doc_set",langs.doc_set,"/cloud/include/doc_set1.html") ;
			}
			else
			{
				myAlert(result.msg);
			}
	   }
	});
}