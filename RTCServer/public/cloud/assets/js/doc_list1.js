/*
 * doc list
 * jc 20141204
 *
 */

var sortby 		= 1; 	// 排序方式
var show_type 		= "thumb" ; 		//显示方式 
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
	var container = $("#doc_list") ;
	var html = "" ;
	if (_data.length>0){
		for (var i = 0; i < _data.length; i++) {
			//_data[i].col_name = unescape(_data[i].col_name);
			_data[i].filetype = get_filetype1(_data[i].col_name);
			_data[i].filesize_text = get_filesize(_data[i].pcsize);
			//alert(_data[i].col_dt_create);
			_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
		
			if(_data[i].col_doctype == DOC_FILE)
			    _data[i].col_id = _data[i].msg_id;
			else
				_data[i].filetype = "folder";
			//文件夹不显示大小
			if(_data[i].filetype == "folder")
				_data[i].filesize_text = "----";
//				if (_mode == 1)
//					var item_id=_data[i].col_doctype+'_'+_data[i].col_id+'_'+_data[i].col_rootid;
				//alert(_data[i].msg_id);
			//var item_id=_data[i].col_doctype+'_'+_data[i].col_id+'_'+_data[i].col_rootid;
		}
		//if($("#" + item_id).length > 0) return ;
		html = $("#tmpl_list").tmpl(_data) ;
	}
	else
	{
		if (pageindex == 1)
		{
			$(container).html("<div class='alert alert-warning' style='border-radius:0px;'>"+langs.doc_error_content2+"</div>") ;
			draw_page();
			return ;
		}
	}
	//删除分页按钮
	$(".page_btn").remove();
	
	//删除 没有内容的提示
	$(".alert",container).remove();
	if (_mode == 0)
		$(container).html(html) ;
	if (_mode == 1)
		$(container).append(html) ;
	if (_mode == 2)
		$(container).prepend(html) ;

	format_list();
	 
	//画分页
	if (_recordcount != undefined)
		draw_page();
}

function doc_set_html1(_data,_data3,_index)
{
	pageindex = _index ;

	var permissions="";
//	if(root_type==1){
		ace_data = [] ;
		if (_data.length>0){
			for (var i = 0; i < _data.length; i++) {
				ace_data.push({"doc_type":DOC_FOLDER,"doc_id":_data[i].ptpfolderid,"power":_data[i].docace});
			}
		}
//	}else{
		aces = [] ;
		if (_data3.length>0){
			for (var i = 0; i < _data3.length; i++) {
				permissions+=_data3[i].permissions; 
			}
		}
		aces=permissions.split(",") ;
		aces=aces.notempty() ;
//	}
	//alert(JSON.stringify(ace_data));
	//列出内容
	
	//重新按钮
	init_cmd_btn();
}

function doc_set_html2(_data,_mode,_recordcount)
{
	recordcount = _recordcount ;

	if (_mode == undefined)
		_mode = 0 ;

	//得到HTML
	var container = $("#doc_list") ;
	var html = "" ;
	if (_data.length>0){
		for (var i = 0; i < _data.length; i++) {
			_data[i].filetype = get_filetype1(_data[i].col_name);
			_data[i].filesize_text = get_filesize(_data[i].pcsize);
			//alert(_data[i].col_dt_create);
			_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
				
			if(_data[i].col_doctype == DOC_FILE)
			    _data[i].col_id = _data[i].msg_id;
			else
				_data[i].filetype = "folder";
			//文件夹不显示大小
			if(_data[i].filetype == "folder")
				_data[i].filesize_text = "----";
				//alert(_data[i].msg_id);
			var item_id=_data[i].col_doctype+'_'+_data[i].col_id+'_'+_data[i].col_rootid;
		}
		if($("#" + item_id).length > 0) return ;
		html = $("#tmpl_list").tmpl(_data) ;
	}
	else
	{
		if (pageindex == 1)
		{
			$(container).html("<div class='alert alert-warning' style='border-radius:0px;'>"+langs.doc_error_content2+"</div>") ;
			draw_page();
			return ;
		}
	}
	//删除分页按钮
	$(".page_btn").remove();
	
	//删除 没有内容的提示
	$(".alert",container).remove();
	if (_mode == 0)
		$(container).html(html) ;
	if (_mode == 1)
		$(container).append(html) ;
	if (_mode == 2)
		$(container).prepend(html) ;

	format_list();
	 
	//画分页
	if (_recordcount != undefined)
		draw_page();
}

function doc_set_html3(_data,existname,_recordcount)
{
	recordcount = _recordcount ;

	//得到HTML
	var container = $("#doc_list") ;
	var html = "" ;
	if (_data.length>0){
		for (var i = 0; i < _data.length; i++) {
			_data[i].filetype = get_filetype1(_data[i].col_name);
			_data[i].filesize_text = get_filesize(_data[i].pcsize);
			//alert(_data[i].col_dt_create);
			_data[i].col_dt_create = toDate(_data[i].col_dt_create,1);
			
			if(_data[i].col_doctype == DOC_FILE)
			    _data[i].col_id = _data[i].msg_id;
			else
				_data[i].filetype = "folder";
			//文件夹不显示大小
			if(_data[i].filetype == "folder")
				_data[i].filesize_text = "----";
				//alert(_data[i].msg_id);
			var item_id=_data[i].col_doctype+'_'+existname+'_'+_data[i].col_rootid;
			var item_newid=_data[i].col_doctype+'_'+_data[i].col_id+'_'+_data[i].col_rootid;
			$("#" + item_id).attr("data-id",_data[i].col_id);
			$("#" + item_id).attr("data-file-id",_data[i].col_id);
			$("#" + item_id).attr("data-target",_data[i].filpath);
			$("#" + item_id).attr("data-filesize",_data[i].pcsize);
            var html = '<span class="file-dtime"><span>'+_data[i].col_dt_create+'</span><span class="doc_size">'+_data[i].filesize_text+'</span></span>'
                            +'<span class="file-edtors"><a href="javascript:void(0);" class="ico ico-edit btn_doc_online_edit btn_file" title="'+langs.icon_doc_edit+'" onclick="doc_onlinefile(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-down btn_doc_download" title="'+langs.icon_download+'" onclick="doc_download(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-view btn_doc_view" title="'+langs.icon_attr+'" onclick="doc_attr(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-share btn_doc_shareto" title="'+langs.icon_share+'" onclick="doc_shareto(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-move btn_cmd btn_doc_move" title="'+langs.icon_move+'" onclick="doc_move(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-rename btn_cmd btn_doc_edit" title="'+langs.icon_edit+'" onclick="doc_rename(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-del btn_cmd btn_doc_delete" title="'+langs.icon_delete+'" onclick="doc_delete(\''+item_newid+'\',this)"></a><a href="javascript:void(0);" class="ico ico-qrcode btn_doc_qrcode btn_file" onclick="doc_qrcode(\''+item_newid+'\',this)"></a></span>';
//			console.log('html:'+html);
//			console.log('item_id:'+$("#" + item_id).attr("data-id"));
			$(".dtime","#" + item_id).html(html);
			$("#" + item_id).attr("id",item_newid);
		}
	}
	format_list();
}


function draw_page()
{
	var pagecount = parseInt(recordcount / pagesize) ;
	if (recordcount % pagesize > 0)
		pagecount += 1 ;

	var folder_count = $(".doc_item[data-filetype=folder]").length ;
	$(".path_info").html($(".doc_item").length+langs.recordcount);
	
	if (pageindex < pagecount)
		$("#doc_list").append('<a href="javascript:void(0)" onclick="page_next()" class="page_btn page_next">'+langs.page_next+'</a>') ;
	else if (pageindex>1)
		$("#doc_list").append('<div class="page_btn page_finish">'+langs.page_finish+'</div>') ;
}

function page_next()
{
	pageindex = pageindex +1 ;
	doc_list();
}

function doc_list_init()
{
//	$("#doc_list").html("<div class='loading'>"+langs.text_loading+"<div>");
//	$("#chk_all").attr("checked",false);
//	$("#doc_list .alert").remove(); //删除 nodata等提示信息
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
	var url = getAjaxUrl("cloud","doc_list1",query);
	//document.write(url);
	var data = {"root_type":root_type,"file_type":file_type,"label":label,"sortby":sortby,"show_type":show_type,"key":key,
				"pagesize":pagesize,"pageindex":pageindex} ;
	//console.log(url+JSON.stringify(data));
    $.ajax({
       type: "POST",
       dataType:"json",
       data:data,
       url: url,
       success: function(result){
		    if (result.status == undefined)
			{
				//console.log(JSON.stringify(result.rows));
				var mode = 0 ;
				if (pageindex>1)
					mode = 1 ; //append
				doc_set_html1(result.rows2,result.rows3,result.index);
				doc_set_html(result.rows,mode,result.recordcount);
				
				if (pageindex>1)
					document.getElementById('doc_list').scrollTop = document.getElementById('doc_list').scrollHeight;
				
			}
			else
			{
				$("#doc_list").html("<div class='alert alert-warning' style='border-radius:0px;'>" + result.msg + "</div>") ;
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

function format_list()
{
    var fileItem = tools.$('.file-item', fileList); // 文件展示区所有文件
	tools.each(fileItem, function (item, index) {
         fileHandle(item);
    });
	//得到图片预览
	$(".doc_item[data-filetype=img]").each(function(){
		var roottype = root_type;
		if (label == "recent"||label == "search"||label == "share"){
		if($(this).attr("data-myid")=="Public") var roottype=1;
		else var roottype=3;
		}
		var url = "root_type=" + roottype + "&root_id=" + $(this).attr("data-rootid") + "&parent_type=" + parent_type + "&parent_id=" + $(this).attr("data-rootid") + 
				  "&id=" + $(this).attr("data-id") + "&name=" +  escape($(this).attr("data-target")) + "&myid=" + urlrequest("myid") ;
		url = "/public/cloud.html?op=getimg&" + url ;
		//window.prompt("getimg",url);
		$(".doc_icon",this).html("<a href='" + url + "' rel='lightbox-group' target='_blank'><img class='icon_img' src='/static/img/pix.png'/></a>") ;								
	})
	
	//异步加载图片
	load_img();
	
	//lightbox
	formatViewer();
	
	//format btn
	init_cmd_btn_container($("#doc_list"));
	
	$(".doc_item").each(function(){
		var doc_type = $(this).attr("data-type");
		
		//subscribe 
		if (doc_type == DOC_FILE)
		{

			}
		else
		{
			$(".btn_file",this).remove();
		}
		
	
		$(this)
		.unbind()
		.click(function(){
			if ($(this).attr("data-filetype") == "img")
				$(".doc_icon a",this).click();
			else doc_open($(this).attr("id"));
		})
		
		.contextMenu('contextmenu_doc', {
					 onShowMenu:function(e,t){
						init_cmd_btn_container1(t.id);
						var docitem = $("#" + t.id);
						
						if ($(docitem).attr("data-type") == DOC_FILE){
							//$(".btn_file",$("#jqContextMenu")).show();
							$(".btn_doc_set",$("#jqContextMenu")).hide();
						}else
							$(".btn_file",$("#jqContextMenu")).hide();
						
					 },
					 bindings:{
						 'item_doc_edit': function(t,menu) {doc_onlinefile(t.id);},
						 'item_download': function(t,menu) {doc_download(t.id);},
						 'item_attr': function(t) {doc_attr(t.id);},
						 'item_move': function(t) {doc_move(t.id);},
						 'item_edit': function(t) {doc_rename(t.id);},
						 'item_delete': function(t) {doc_delete(t.id);},
						 'item_share': function(t) {doc_shareto(t.id);},
						 'item_set': function(t) {doc_set(t.id);},
						 'item_qrcode': function(t) {doc_qrcode(t.id);}
					 }
		})
		
	})
	

	 
	/*checkbox*/
//	$("#chk_all").click(function(){
//		var checked = $(this).is(":checked") ;
//		$("input[name=chk_id]").each(function(){
//			check_item(this,checked);
//			this.checked = checked ;
//		})
//	})
//	$("input[name=chk_id]").click(function(e){
//		check_item(this,$(this).is(":checked"));
//		e.stopPropagation();
//
//	})
	
	//阻止事件冒泡
	$(".doc_item a").click(function(e){
		e.stopPropagation();
	})

}

function check_item(chk_id,checked)
{
	var doc_item = $(chk_id).parent().parent();
	if (checked)
		$(doc_item).addClass("doc_select");
	else
		$(doc_item).removeClass("doc_select");
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
	$("#doc_list").removeClass("file_list").addClass("file_thumb");
//	$(".arraybtn").addClass("g-btn-gray1");
	$("#btn_show_thumb").hide();
	$("#btn_show_list").show();
//	arrayBtn.onOff = true;
//	tools.addClass(arrayBtn,"g-btn-gray1");
//	var pathNavLast = tools.$("span",pathNav)[0];   //导航中最后一个元素span
//	var pid = pathNavLast.getAttribute('data-file-id');           //当前创建的元素的pid就是导航区域的最后一个sp
//	renderFilesPathTree(pid);  
//	menu.style.display = 'none';
}

function show_list()
{
	show_type = "list";
	$("#doc_list").removeClass("file_thumb").addClass("file_list");
//	$(".arraybtn").removeClass("g-btn-gray1");
	$("#btn_show_list").hide();
	$("#btn_show_thumb").show();
//	arrayBtn.onOff = false;
//	tools.removeClass(arrayBtn,"g-btn-gray1");
//	var pathNavLast = tools.$("span",pathNav)[0];   //导航中最后一个元素span
//	var pid = pathNavLast.getAttribute('data-file-id');           //当前创建的元素的pid就是导航区域的最后一个sp
//	renderFilesPathTree(pid);  
//	menu.style.display = 'none';
}

 
function doc_refresh()
{
	pageindex = 1 ;
	doc_list();
}

function remove_list_items(ids)
{
	//console.log(ids);
	var arr_id = ids.split(",");
	for(var i=0;i<arr_id.length;i++)
		$("#" + arr_id[i]).parent().fadeOut().remove();

	//可以显示没有数据或显示到下页数据
	if ($(".doc_item").length == 0)
		doc_refresh();
}