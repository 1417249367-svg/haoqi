/*
 * doc list
 * jc 20141204
 *
 */

var sortby 		= 1; 	// 排序方式
var show_type 		= "list" ; 		//显示方式 
var recordcount 	= 0 ;
var pagesize 		= 20 ;
var pageindex 		= 1 ;
var show_img_sizelimit   = 2 * 1024 * 1024 ; // 图片显示大小限制 0 不限制，图片大小消耗内存  2M（2 * 1024 * 1024）
var parent_type 	= 0 ;			//parent_type 上级文件夹类型 folder 102,root 105
var parent_id 		= 0 ;			//parent_id root_id or folder_id
var root_type 		= 0 ;   		//root_type  1 公共文档 3个人文档
var root_id 		= 0 			//root_id
var file_type 		= 0 ; 			//file_type  1 office 2 pic 3 audio 4 vedio
var key				= "" ;
var label 			= "" ;
var pages =  {curid:1};
pages[1] = {ld:0};
var chkallIndex=1;
var nav_data = [] ;
// 文件列表显示 (列表显示  分页显示 新增后插入内容)
// _data  		data.rows
// _mode  		0 reset  1 append  2 prepend
// _recordcount	undefined 表示新增后插入内容
function doc_set_html(_data,_mode,_recordcount)
{
	recordcount = _recordcount ;

	if (_mode == undefined)
		_mode = 0 ;

	//得到HTML
	var container = $(".list-box") ;
	var html = "" ;
	var html1 = "" ;

	if (_data.length>0){
		if(label=="share"){
			if(!_data[0].col_name){
				$(".list-box").html("<div class='alert alert-warning' style='border-radius:0px;'>" + langs.doc_error_content1 + "</div>") ;
				return ;
			}
		}
		for (var i = 0; i < _data.length; i++) {
			_data[i].filetype = get_filetype1(_data[i].col_name);
			_data[i].filesize_text = get_filesize(_data[i].pcsize);
			//alert(_data[i].col_dt_create);
			_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
			
			//文件夹不显示大小
			if(_data[i].col_doctype == DOC_FILE)
			    _data[i].col_id = _data[i].msg_id;
			else
				_data[i].filetype = "folder";
			//文件夹不显示大小
			if(_data[i].filetype == "folder")
				_data[i].filesize_text = "----";
				//alert(_data[i].msg_id);
		}
		html = $("#tmpl_list").tmpl(_data) ;
		
		if(parseInt(_curr_userid)) html1 = $("#tmpl_list1").tmpl(_data) ;
	}
	else
	{
		if (pageindex == 1)
		{
			$(container).html("<div class='alert alert-warning' style='border-radius:0px;'>"+langs.doc_error_content+"</div>") ;
			return ;
		}
	}
		
	//删除分页按钮
	$(".page_btn").remove();
	//删除 没有内容的提示
	$(".alert",container).remove();

	if (_mode == 0)
		$(".list-box").eq(0).html(html) ;
	if (_mode == 1)
		$(".list-box").eq(0).append(html) ;
	if (_mode == 2)
		$(".list-box").eq(0).prepend(html) ;
		
	if(html1){
		if (_mode == 0)
			$(".list-box").eq(1).html(html1) ;
		if (_mode == 1)
			$(".list-box").eq(1).append(html1) ;
		if (_mode == 2)
			$(".list-box").eq(1).prepend(html1) ;
	}

	format_list();
	 
	//画分页
	if (_recordcount != undefined)
		draw_page();
}

function draw_page()
{
	var pagecount = parseInt(recordcount / pagesize) ;
	if (recordcount % pagesize > 0)
		pagecount += 1 ;

	var folder_count = $("#page2 .list-item[data-filetype=folder]").length ;
	$("#path_info").attr("data-count",(recordcount  + folder_count));
	ids = getCheckValue("chk_id") ;
	var arr_id = ids.split(",");
	$("#path_info").html(langs.col_chk1+arr_id.length+"/"+$("#path_info").attr("data-count")+langs.col_chk2);
	//alert((recordcount  + folder_count));
	//$("#path_info").html((recordcount  + folder_count)+langs.recordcount);
	
	if (pageindex < pagecount)
		$(".list-box").append('<a href="javascript:void(0)" onclick="page_next()" class="page_btn page_next">'+langs.page_next+'</a>') ;
	else if (pageindex>1)
		$(".list-box").append('<div class="page_btn page_finish">'+langs.page_finish+'</div>') ;
}

function page_next()
{
	pageindex = pageindex +1 ;
	doc_list();
}

function doc_list_init()
{
	$(".list-box").html("<div class='loading'>"+langs.text_loading+"<div>");
	pageindex = 1 ;
	recoredcount = 0 ;
}



function doc_list()
{
	//客户端判断是否有权限
//	if (path_data.length > 0)
//	{
//		if (! can(DOCACE_VIEW))
//		{
//			$("#doc_list").html("<div class='alert alert-warning' style='border-radius:0px;'>你没有权限查看内容</div>") ;
//			return ;
//		}
//	}
	
	//var shareids=urlrequest("ids");
	var url = getAjaxUrl("cloud","doc_list",query);
	//document.write(url);
	var data = {"root_type":root_type,"file_type":file_type,"label":label,"sortby":sortby,"show_type":show_type,"key":key,
				"pagesize":pagesize,"pageindex":pageindex} ;
	//document.write(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
		    if (result.status == undefined)
			{
				var mode = 0 ;
				if (pageindex>1)
					mode = 1 ; //append
				doc_set_html(result.rows,mode,result.recordcount);
				
				if (pageindex>1)
					document.getElementsByClassName('list-box').scrollTop = document.getElementsByClassName('list-box').scrollHeight;
				
			}
			else
			{
				$(".list-box").html("<div class='alert alert-warning' style='border-radius:0px;'>" + result.msg + "</div>") ;
			}
       }
    }); 
	
}

function doc_set_html1(_data,_mode,_recordcount)
{
	recordcount = _recordcount ;

	if (_mode == undefined)
		_mode = 0 ;

	//得到HTML
	var container = $(".list-box1") ;
	var html = "" ;

	if (_data.length>0){
		for (var i = 0; i < _data.length; i++) {
			_data[i].filetype = get_filetype1(_data[i].col_name);
			_data[i].filesize_text = get_filesize(_data[i].pcsize);
			//alert(_data[i].col_dt_create);
			_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
			
			//文件夹不显示大小
			if(_data[i].col_doctype == DOC_FILE)
			    _data[i].col_id = _data[i].msg_id;
			else
				_data[i].filetype = "folder";
			//文件夹不显示大小
			if(_data[i].filetype == "folder")
				_data[i].filesize_text = "----";
				
		}
		html = $("#tmpl_list2").tmpl(_data) ;

	}
	else
	{

		$(container).html("<div class='alert alert-warning' style='border-radius:0px;'>"+langs.doc_error_content+"</div>") ;
		return ;

	}

	//删除 没有内容的提示
	$(".alert",container).remove();

	$(container).html(html) ;

	format_list1();
}

function doc_list1()
{
	$(".list-box1").html("<div class='loading'>"+langs.text_loading+"<div>");
	var target_id=$("#target_id").val();
	var url = getAjaxUrl("cloud","doc_list",query);
	//document.write(url);
	var data = {"root_type":root_type,"file_type":file_type,"label":"folder","sortby":sortby,"show_type":show_type,"key":key,
				"parent_id":target_id} ;
	//document.write(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
		    if (result.status == undefined)
			{
				var mode = 0 ;
				doc_set_html1(result.rows,mode,result.recordcount);
				if(parseInt(target_id)) $(".nav-box1").show();
				else $(".nav-box1").hide();
				
			}
			else
			{
				$(".list-box1").html("<div class='alert alert-warning' style='border-radius:0px;'>" + result.msg + "</div>") ;
			}
       }
    }); 
	
}



function format_data(data)
{
	for (var i = 0; i < data.length; i++) {
		data[i].filetype = get_filetype1(data[i].col_name);
		data[i].filesize_text = get_filesize(_data[i].pcsize);
		
		//文件夹不显示大小
		if(data[i].filetype == "folder")
			data[i].filesize_text = "----";
	}
	return data;
}

function load_img()
{
	//得到图片预览
	$(".list-item[data-filetype=img]").each(function(){
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

function format_list()
{
	//得到图片预览
	$(".list-item[data-filetype=img]").each(function(){
		if($(this).attr("data-myid")=="Public") var roottype=1;
		else var roottype=3;
		var url = "root_type=" + roottype + "&root_id=" + $(this).attr("data-rootid") + "&parent_type=" + parent_type + "&parent_id=" + $(this).attr("data-rootid") + 
				  "&id=" + $(this).attr("data-id") + "&name=" +  escape($(this).attr("data-target")) + "&myid=" + urlrequest("myid") ;
		url = "/public/cloud.html?op=getimg&" + url ; 
		//window.prompt("getimg",url);
		$(".doc_icon",this).html("<a href='" + url + "' target='_blank'><img class='icon_img' src='/static/img/pix.png'/></a>") ;								
	})
	//异步加载图片
	load_img();
	
	setTimeout(function(){
			baguetteBox.run('.list-box');
			if (typeof oldIE === 'undefined' && Object.keys) {
				hljs.initHighlighting();
			}
			 }, 500);
	
	$("#page1 .list-item").each(function(){
		$(this)
		.unbind()
		.click(function(){
			if ($(this).attr("data-filetype") == "img")
				$(".doc_icon img",this).click();
				//$(".doc_icon a",this).trigger();
			else
				doc_open($(this).attr("id"));
		})
	})
	
	$("#page2 .list-item").each(function(){
		$(this)
		.unbind()
		.click(function(){
			selectItem($(this).attr("id"));
		})
	})
	

	 
	/*checkbox*/
	$("#chk_all")
	.unbind()
	.click(function(){
		if(chkallIndex==0){ 
			chkallIndex=1; 
			$("#chk_all").html(langs.col_chk_notall);
		}else{
			chkallIndex=0;
			$("#chk_all").html(langs.col_chk_all);
		}
		$("input[name=chk_id]").each(function(){
			this.checked = chkallIndex ;
		})
		check_item();
	})
	
	$("#cancel")
	.unbind()
	.click(function(){
		pageSwitch(1,event);
	})
	
	$(".doc-save-box")
	.unbind()
	.click(function(){
		if(!ids){ 
		     $("#pnl_error").html("<b>"+langs.get_ids_warning+"</b>").attr("class","alert alert-warning").show();
			  window.setTimeout(function(){
				$("#pnl_error").alert('close');
			},3000);
			 return ;
		}
		pageSwitch(3,event);
		if (nav_data.length == 0) nav_data.push({"doc_type":DOC_FOLDER,"doc_id":0,"doc_name":langs.path_person}); ;
		doc_list1();
	})
	
	$("input[name=chk_id]").click(function(e){
		check_item();
		e.stopPropagation();

	})
	
	//阻止事件冒泡
	$(".list-item a").click(function(e){
		e.stopPropagation();
	})

}


function format_list1()
{
	$("#page3 .list-item").each(function(){
		$(this)
		.unbind()
		.click(function(){
			$("#target_id").val($(this).attr("data-id")) ;
			nav_data.push({"doc_type":DOC_FOLDER,"doc_id":$(this).attr("data-id"),"doc_name":$(this).attr("data-name")});
			//alert(JSON.stringify(nav_data));
			$("#folder_nav_box").html(check_nav_name());
			doc_list1();
		})
	})
	
	$(".nav-box1")
	.unbind()
	.click(function(){
		nav_data.splice(nav_data.length-1, 1);
		$("#folder_nav_box").html(check_nav_name());
		$("#target_id").val(nav_data[nav_data.length-1].doc_id) ;
		doc_list1();
	})
	
	$("#close")
	.unbind()
	.click(function(){
		$(".doc-save-box").html($("#folder_nav_box").html());
		pageSwitch(2,event);
	})
}

function check_nav_name()
{
	var nav_name="";
	for(var i = 0; i < nav_data.length; i++)
		nav_name+=(nav_name == ""?"":"/") + nav_data[i].doc_name ;
	if(nav_name.length>10) nav_name=left(nav_name,10)+"...";
	return langs.folder_nav_box+nav_name;
}

function check_item()
{
	ids = getCheckValue("chk_id") ;
	var arr_id = ids.split(",");
	if(ids){ 
	     var len=arr_id.length;
		 $("#doc_save").attr("disabled",false);
	}else{
		 var len=0;
		 $("#doc_save").attr("disabled",true);
	}
	$("#path_info").html(langs.col_chk1+len+"/"+$("#path_info").attr("data-count")+langs.col_chk2);
}

function sort_time()
{
	sortby = 1 ;
	pageindex = 1 ;
	doc_list();
}

function sort_name()
{
	sortby = 2 ;
	pageindex = 1 ;
	doc_list();
}

function show_thumb()
{
	show_type = "thumb";
	$("#doc_list").removeClass("doc_list").addClass("doc_thumb");
	$("#btn_show_thumb").hide();
	$("#btn_show_list").show();
}

function show_list()
{
	show_type = "list";
	$("#doc_list").removeClass("doc_thumb").addClass("doc_list");
	$("#btn_show_list").hide();
	$("#btn_show_thumb").show();
}

 
function doc_refresh()
{
	pageindex = 1 ;
	doc_list();
}

function remove_list_items(ids)
{
	var arr_id = ids.split(",");
	for(var i=0;i<arr_id.length;i++)
		$("#" + arr_id[i]).fadeOut().remove();

	//可以显示没有数据或显示到下页数据
	if ($(".doc_item").length == 0)
		doc_refresh();
}

function pageSwitch(i,e){
	if(!pages[i]) pages[i] = {ld:0};
	if (pages.curid != i) {
		var p1 = 'page'+pages.curid;
		var p2 = 'page'+i;
		pages.curid = i;
		//alert(p1+"|"+p2);
		my_page_switch_j(p1, p2);
	}
		pages[i].ld = 1; 
}