var TREE_IMAGE_PATH = "/static/js/dhtmlxtree/img/" ;

$(document).ready(function(){
	jQuery.validator.addMethod("specialCharValidate",
	    function(value, element) {
	    var pattern = new RegExp("[`~!@%#$^&*=|()（）{}':;',\\[\\]<>/?\\.；：%……+￥【】‘”“'。，、？]");
	        return this.optional(element)||!pattern.test(value) ;
	    },
	    jQuery.format(jQuery.validator.messages["specialCharValidate"])
	);

	jQuery.extend(jQuery.validator.messages, {
	    specialCharValidate : "请不要输入特殊字符"
	});
})


function specialCharValidate(str)
{
	var pattern = new RegExp("[`~!@%#$^&*=|{}':;',\\[\\]<>/?\\.；：%……+￥【】‘”“'。，、？]");
	 return pattern.test(str) ;
}

function getCookie(_name,defaultValue)
{
	if (document.cookie.length>0)
	{
		c_start=document.cookie.indexOf(_name + "=")
		if (c_start!=-1)
		{
			c_start=c_start + _name.length+1
			c_end=document.cookie.indexOf(";",c_start)
			if (c_end==-1) c_end=document.cookie.length
				return unescape(document.cookie.substring(c_start,c_end))
		}
	}
	if (defaultValue == undefined)
		defaultValue = "" ;
	return defaultValue ;
}

function setCookie(_name,value,expiredays)
{
	if (expiredays == undefined)
		expiredays = 9999 ;
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=_name+ "=" +escape(value)+
	((expiredays==null) ? "" : "; expires="+exdate.toGMTString())
}

function checkAll(name,ischeck)
{
   $("input[name='" + name + "']").each(function(){
    this.checked = ischeck;
    check(this,ischeck) ;
  });
}

function check(chk,ischeck)
{
   var row = $(chk).parent().parent();
   if (ischeck)
        row.addClass("active");
   else
        row.removeClass("active");

}

function getCheckValue(name)
{
   var val = "" ;
   $("input[name='" + name + "']").each(function(){ if (this.checked){val += "," + $(this).val()}});
   if (val != "")
        val = val.substring(1,val.length)  ;
   return val ;
}

function getCheckValueString(name)
{
   var val = "" ;
   $("input[name='" + name + "']").each(function(){ if (this.checked){val += ",'" + $(this).val() + "'"}});
   if (val != "")
        val = val.substring(1,val.length)  ;
   return val ;
}

function getCheckValueData(name)
{
   var val = "" ;
   $("input[name='" + name + "']").each(function(){ if (this.checked&&is_oos($(this).attr("data-name"))){val += "," + $(this).val()}});
   if (val != "")
        val = val.substring(1,val.length)  ;
   return val ;
}

function getRadioValue(name)
{
   return $("input[name=" + name + "]:checked").val();
}


// sigln or batch
function getSelectedId(id)
{
	if ((id == undefined) || (id == "") || (id == "0"))
	{
		id = getCheckValue("chk_Id");
		if (id == "")
		{
			myAlert(langs.text_select_data);
			return "" ;
		}
	}
	return id ;
}

function getSelectedIdString(id)
{
	if ((id == undefined) || (id == "") || (id == "0"))
	{
		id = getCheckValueString("chk_Id");
		//alert(id);
		if (id == "")
		{
			myAlert(langs.text_select_data);
			return "" ;
		}
	}
	return id ;
}

function getSelectedIdData(id)
{
	if ((id == undefined) || (id == "") || (id == "0"))
	{
		id = getCheckValueData("chk_Id");
		if (id == "")
		{
			myAlert(langs.text_select_data);
			return "" ;
		}
	}
	return id ;
}

function setParam(url,key,value){
    url = replaceAll(url,"#","");
    key = escape(key);
    value = escape(value);
    var s = url;
    var kvp = key+"="+value;

    var r = new RegExp("(&|\\?)"+key+"=[^\&]*");
    s = s.replace(r,"$1"+kvp);
    if(!RegExp.$1) {
        s += (s.indexOf("?")>-1 ? '&' : '?') + kvp;
    };

    if (s.indexOf(key + "=")==-1)
    {
        if (s.indexOf("?")==-1)
            s += "?" + key + "=" + value ;
        else
            s += "&" + key + "=" + value ;
    }
    return s ;
}


function formatDate(_dt,fmt)
{
	if (fmt == undefined)
		fmt = "yyyy-MM-dd hh:mm:ss" ;
	var mydate = new Date(_dt);
    var o = {
        "M+": mydate.getMonth() + 1, //??
        "d+": mydate.getDate(), //?
        "h+": mydate.getHours(), //??
        "m+": mydate.getMinutes(), //?
        "s+": mydate.getSeconds(), //?
        "q+": Math.floor((mydate.getMonth() + 3) / 3), //??
        "S": mydate.getMilliseconds() //??
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (mydate.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

var timeZone = (new Date()).getTimezoneOffset();
//转为本地时间 UTC时间+时区
function getLocalTime(_utcDate)
{
	_utcDate = replaceAll(_utcDate,"-","/");
	//alert(_utcDate);
	var myDate = new Date(_utcDate);
	if (timeZone > 0)
		myDate.setMinutes(myDate.getMinutes() + timeZone) ;
	else
		myDate.setMinutes(myDate.getMinutes() - timeZone) ;
	return formatDate(myDate) ;
}

function getArchor(url)
{
	url = url.substring(url.indexOf("#"),url.length);
	return url ;
}

function formatTabs(tabsId,height)
{
    $("#" + tabsId + " a").click(function () {
		var container = $(this).parent().parent() ;
		$("a",container).each(function(){
			$(getArchor($(this).attr("href"))).hide();
			$(this).parent().removeClass("active");
		})
		$(getArchor($(this).attr("href"))).show();
		$(this).parent().addClass("active");
    })

    $("#" + tabsId + " li:eq(0) a").click();

    if (height != undefined)
    {
        $("#" + tabsId + " a").each(function(){
            $(getArchor($(this).attr("href"))).css("height",height);

        })
    }

}

function getErrorText(err)
{
    return eval("errors.err_" + err);
}

function getCmdText(err)
{
    return eval("cmds.cmd_" + err);
}

function getLang(varName)
{
    return eval("langs." + varName);
}

////////////////////////////////////////////////////
//dialog
////////////////////////////////////////////////////
function dialog(winName,title,url,opts)
{
	opts = jQuery.extend({width:0,height:0,isClear:true},opts);
	if (opts.isClear)
		$(".modal").remove();
		
    var html = "" ;
    html += '<div class="modal fade" id="modal_' + winName + '" >' ;
    html += '  <div class="modal-dialog" >' ;
    html += '    <div class="modal-content">' ;
    html += '      <div class="modal-header">' ;
    html += '        <a href="###" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>' ;
    html += '         <h4 class="modal-title">' + title + '</h4>' ;
    html += '       </div>' ;
    html += '       <div class="modal-entity">' ;
    html += "<p class='loading'>" + langs.text_loading + "</p>" ;
    html += '       </div>' ;
    html += '     </div>' ;
    html += '   </div>' ;
    html += ' </div>' ;
    $("body").append(html);

    var modal = $('#modal_' + winName) ;

    modal.modal({backdrop: 'static',keyboard: true}) ;  //  backdrop: 'static',keyboard: true 点击非对话框位置不关闭对话框

    url += ((url.indexOf("?")==-1)?"?":"&") + "rnd=" +  Math.random()

    $.get(url, function(data){
         $(".modal-entity",modal).html(data) ;
        if (opts.width > 0)
            $(".modal-body",modal).width(opts.width) ;
        if (opts.height > 0)
            $(".modal-body",modal).height(opts.height) ;
        formatContainer(modal);
    });
}

function dialogByContent(winName,title,content,width,height)
{
    //20131025 以免重复
    $("#modal_" + winName).remove();
    var html = "" ;
    html += '<div class="modal fade" id="modal_' + winName + '" >' ;
    html += '  <div class="modal-dialog" >' ;
    html += '    <div class="modal-content">' ;
    html += '      <div class="modal-header">' ;
    html += '        <a href="###" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>' ;
    html += '         <h4 class="modal-title">' + title + '</h4>' ;
    html += '       </div>' ;
    html += '       <div class="modal-entity" >' ;
    html += content ;
    html += '       </div>' ;
    html += '     </div>' ;
    html += '   </div>' ;
    html += ' </div>' ;
    $("body").append(html);

    var modal = $('#modal_' + winName) ;
    modal.modal({backdrop: 'static',keyboard: true}) ;
}

function dialogClose(winName)
{
    //$('#modal_' + winName).modal('hide');
	$('#modal_' + winName + " .close").click();
}

function showLoading(text,width,height)
{

	$("#modal_load").remove();
	if (! text)
		text = "正在加载中" ;

	var attr = "" ;
	if (width != undefined)
		attr += "width:" + width + "px;";
	if (height != undefined)
		attr += "height:" + height + "px;";
	attr = "style=\"" + attr + "\"" ;

    var html = "" ;
    html += '<div class="modal fade" id="modal_load" style="margin-top:10%;">' ;
    html += '  <div class="modal-dialog" ' + attr + ' >' ;
    html += '    <div class="modal-content">' ;
    html += '       <div class="modal-entity" >' ;
	html += "<div style='padding:20px'><div>" +  text + "</div></div>" ;
    html += '       </div>' ;
    html += '     </div>' ;
    html += '   </div>' ;
    html += ' </div>' ;

    $("body").append(html);

    var modal = $('#modal_load') ;
    modal.modal({backdrop: 'static',keyboard: true}) ;
}

function hideLoading()
{
	$('#modal_load').modal('hide') ;
}



function myAlert(msg)
{
    alert(msg);

	//layer.alert(msg,-1);
}


function getWhereSql(sql,whereSql)
{

    if (sql != "")
        sql += " and " ;
    else
        sql += " where " ;
    return sql + whereSql ;
}

function clearElementError()
{
	$(".error-tip").remove();;
}

function setElementError(el,msg)
{
	//移除上一次的,重复提交时会有多次  2015.01.23
	$(".error-tip").remove();
    var c = $(el).parent() ;
    $(el).addClass("error");
    $(el).after("<label for='" + $(el).attr("id") + "' class='error error-tip'>" + msg + "</label>");

    //设置获得焦点时移除错误提醒  2015.01.23
    $(el).focus(function(){
    	$(".error-tip").remove();
    });

}

var _path = "" ;

function getTreePath(_tree,_nodeId)
{
	if (_tree == undefined)
    	_tree = tree ;
	if (_nodeId == undefined)
    	_nodeId = _tree.getSelectedItemId() ;
    _path = "";
    getTreePath2(_tree,_nodeId) ;

    if (_path != "")
        _path = _path.substring(1,_path.length) ;

    return _path ;
}
function getTreePath2(_tree,_nodeId)
{

    if ((_nodeId == undefined) || (_nodeId == "") || (_nodeId == 0)|| (_nodeId == "0_0_0"))
        return  ;

    _path = "/" + _tree.getItemText(_nodeId) + _path ;
    getTreePath2(_tree,_tree.getParentId(_nodeId)) ;
}

function getTreeId(_tree,_nodeId)
{
	if (_tree == undefined)
    	_tree = tree ;
	if (_nodeId == undefined)
    	_nodeId = _tree.getSelectedItemId() ;
    _path = "";
    getTreeId2(_tree,_nodeId) ;

    if (_path != "")
        _path = _path.substring(1,_path.length) ;

    return _path ;
}
function getTreeId2(_tree,_nodeId)
{

    if ((_nodeId == undefined) || (_nodeId == "") || (_nodeId == 0)|| (_nodeId == "0_0_0"))
        return  ;

    _path = "/" + _nodeId + _path ;
	//console.log('_path:'+_path);
    getTreeId2(_tree,_tree.getParentId(_nodeId)) ;
}

function trim(str)
{
	if (str == undefined)
		return "";
	return str.replace(/^(\s|\xA0)+|(\s|\xA0)+$/g, '');
}


function replaceAll(str,replaceStr,newStr)
{
    if (str == "")
        return str ;
    var reg = new RegExp("\\" + replaceStr,"g");
    return str.replace(reg,newStr);

}

// s 1900-1-1	1900-1-1 00:00:00   1900/1/1 00:00:00  07 30 2014 1:45PM
function toDate(date,islongdate)
{
	if (date == "")
		return "" ;

	if (islongdate == undefined)
		islongdate = 0 ;
	var arr,year,month,day;

	//format date  to 1900-1-1 00:00:00
	var mydate = date;
	var mytime = "" ;
	var pos = date.lastIndexOf(" ") ;
	if (pos > -1)
	{
		mydate = date.substring(0,pos) ;
		mytime = date.substring(pos,date.length) ;
	}


    mydate =  replaceAll(mydate,"/","-") ;
	mydate =  replaceAll(mydate," ","-") ;
	var arr = mydate.split("-");

	if (arr[0].length == 4)
	{
		//yyyy-MM-dd
		year = arr[0];
		month = arr[1];
		day = arr[2];
	}
	else
	{
		// MM-dd-yyyy
		month = arr[0];
		day = arr[1];
		year = arr[2];
	}

	year = fillL(year,4,"0") ;
    month = fillL(month,2,"0") ;
    day = fillL(day,2,"0") ;

	mydate = year + "-" + month + "-" + day ;

	if (islongdate)
	{
		mytime = replaceAll(mytime,"PM","下午");
		mytime = replaceAll(mytime,"AM","上午");
		mydate += " " + mytime ;
	}
    return mydate  ;
}

function fillL(str,len,fillChar)
{
	if (str == undefined)
		return "" ;
	var count = len - str.length ;
	for(var i=0;i<count;i++)
		str = fillChar + str ;
	return str ;
}


var currBtn ;
function setLoadingBtn(btn,tip)
{
    if (tip == undefined)
        tip = "正在提交中..." ;

	currBtn = btn;
	if ($(btn).is("button"))
        $(btn).attr("data-name",$(btn).html()).attr("disabled",true).html(tip);
    else
        $(btn).attr("data-name",$(btn).val()).attr("disabled",true).val(tip);
}

function cancelLoadingBtn(btn)
{
	setSubmitBtn(btn);
}

function setSubmitBtn(btn,text)
{
	if (btn == undefined)
		btn = currBtn ;
	if (text == undefined)
		text = $(btn).attr("data-name") ;

	if ($(btn).is("button"))
	    $(btn).attr("disabled",false).html(text);
	else
	    $(btn).attr("disabled",false).val(text);
}

function getIds(preName,ids)
{
	ids = ids.toString();
	return "#" + preName + "_" + replaceAll(ids,",",",#" + preName + "_") ;
}



// 得到行的ids
function getRowIds()
{
    var ids = "" ;

    $(".data-row").each(function(){
        ids += (ids == ""?"":",") + $(this).attr("data-id") ;
    })

    return ids ;
}

function getInt(val)
{
    if (val == null)
        return 0 ;
    if (val == undefined)
        return 0 ;
    return parseInt(val) ;
}




//上传文件
function uploadFile(ipt,saveFileName)
{
	var fileId = $(ipt).attr("id");
    var fileName = $(ipt).val() ;
    if (fileName == "")
    {
    	myAlert("请选择上传的文件");
        return ;
    }

    if ($(ipt).hasClass("pic"))
    {
        if (!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(fileName)) {
        	myAlert("请选择图片文件") ;
            return false;
        }
    }

    if (saveFileName == undefined)
        saveFileName = "" ;

//    var url = "../../public/upload.html?fileid=" + fileId ;
//
//    //表示覆盖
//    if (saveFileName != "")
//        url += "&filename=" + saveFileName ;
		
	var url = getAjaxUrl("upload","upload","autoFileName=1&fileid=" + fileId) ;
    var _form = $("form");
    var action = $(_form).attr("action") ;
    var target = $(_form).attr("target") ;
    if (action == undefined)
        action = "" ;
    if (target == undefined)
        target = "" ;

    $(_form)
        .attr("action",url)
        .attr("target","frm_Upload")
        .submit();
     $(_form)
        .attr("action",action)
        .attr("target",target) ;
}


function json2str(data)
{
	var s = JSON.stringify( data );
	return s ;
}

function getAjaxUrl(obj,op,param)
{
    var url = "/public/" + obj + ".html?op=" + op ;
    if (param != undefined)
        url += "&" + param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}

function getAspUrl(obj,param)
{
    var url = "http://"+window.location.hostname+":99/services/" + obj + ".asp?";
    if (param != undefined)
        url += param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}

function getApiUrl(obj,param)
{
    var url = window.location.protocol+'//' + window.location.host+"/api/" + obj + ".html?";
    if (param != undefined)
        url += param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}

var _dbtype = "mssql" ;

function get_date_sql(field_date,dt1,dt2,where,dbtype)
{

	if (dt1 != "")
		where = getWhereSql(where,field_date + ">=" + format_search_date(dt1,dbtype) ) ;
	if (dt2 != "")
		where = getWhereSql(where,field_date + "<=" + format_search_date(dt2 + " 23:59:59",dbtype) ) ;
	return where ;
}

function format_search_date(dt,dbtype)
{
	if (dbtype == undefined)
		dbtype = _dbtype ;
	if (dbtype == "oracle")
		return "to_date('" + dt + "','YYYY-MM-DD HH24:MI:SS')" ;
	else if (dbtype == "access")
	    return "#" + dt + "#" ;
	else
		return "'" + dt + "'" ;

}

function drawPager(container,pageIndex,pageSize,recordCount,evPage)
{
	pageIndex = parseInt(pageIndex);
	pageSize = parseInt(pageSize);
	recordCount = parseInt(recordCount);

	var pageCount = Math.floor(recordCount / pageSize) ;
	if ((recordCount % pageSize)>0)
		pageCount = pageCount + 1 ;

	var html = "";
	html += "<div class='fl'>";
	html += "<span class='spanfl'>第</span> <input type=text class='txt' id='txt_PageIndex'  value='" + pageIndex + "'  usage='int'  minvalue='1' maxlength='4' style='width:40px' /> <span class='spanfl'>页 / 共</span> <span class='pageCount spanfl'>" + pageCount + "</span> <span class='spanfl'>页 ，";
	html += "每页</span> <input type=text class='txt' id='txt_PageSize'  value='" + pageSize + "' usage='int' minvalue='1' maxlength='4' style='width:40px' /> <span class='spanfl'>条</span> ";
	html += "</div>";
	html += "<div class='fl'><a href='#' onclick='" + evPage + "();' class='fl'><span class='icon20 icon-refresh'></span></a></div>";
	html += "<div class='fr'><table><tr>";
	if (pageIndex <= 1)
	{
		html += "<td><a href='#'><span class='icon20 icon-first-disabled'></span></a></td>";
		html += "<td><a href='#'><span class='icon20 icon-prev-disabled'></span></a></td>";
	}
	else
	{
		html += "<td><a href='#' onclick=\"" + evPage + "(1)\"><span class='icon20 icon-first'></span></a></td>";
		html += "<td><a href='#' onclick=\"" + evPage + "(" + (pageIndex - 1 < 1 ? 1 : pageIndex - 1) + ")\"><span class='icon20 icon-prev'></a></td>";
	}
	if ((pageIndex >= pageCount) || (pageCount <= 1))
	{
		html += "<td><a href='#'><span class='icon20 icon-next-disabled'></span></a></td>";
		html += "<td><a href='#'><span class='icon20 icon-last-disabled'></span></a></td>";
	}
	else
	{
		html += "<td><a href='#' onclick=\"" + evPage + "(" + (pageIndex + 1 > pageCount ? pageCount : pageIndex + 1) + ")\"><span class='icon20 icon-next'></span></a></td>";
		html += "<td><a href='#' onclick=\"" + evPage + "(" + pageCount + ")\"><span class='icon20 icon-last'></span></a></td>";
	}


	html += "</tr></table></div>";
	html += "<div class='clear'></div>";

	html += "<script language='javascript'>$('#txt_PageSize').keydown(function(e){if (e.keyCode == 13){" + evPage + "(1);return false;}})</script>";
	html += "<script language='javascript'>$('#txt_PageIndex').keydown(function(e){if (e.keyCode == 13){" + evPage + "();return false;}})</script>";
	$(container).html(html);
}

function page(pageIndex,pageSize)
{
    if (pageIndex == undefined)
        pageIndex = parseInt($("#txt_PageIndex").val()) ;
    if (pageSize == undefined)
        pageSize = parseInt($("#txt_PageSize").val()) ;

	if (isNaN(pageIndex) || isNaN(pageSize))
	{
		myAlert("输入内容不正确");
		return ;
	}
    var url = location.href ;
    url = setParam(url,"page", pageIndex) ;
    url = setParam(url,"pagesize",pageSize) ;
    $("#txt_PageIndex").val(pageIndex);
    $("#txt_PageSize").val(pageSize);
    location.href = url ;
}


//自动调节高度
function resize()
{
    var height = document.body.clientHeight ;
    var width = document.body.clientWidth ;
	$(".fluent").each(function(){
	    var abs_height = getInt($(this).attr("abs_height")) ;

	    if (abs_height>0)
	    {
		    $(this).css("height",height - abs_height);
		}
		var abs_width = getInt($(this).attr("abs_width")) ;
	    if (abs_width>0)
	    {
		    $(this).css("width",width - abs_width);
		}
	})
}

function getAppPath()
{
    var _url = location.href ;
    if (location.search)
        _url = _url.replace(location.search,"") ;
    _url = _url.substring(0,_url.lastIndexOf("/")) ;
    _url = _url.substring(0,_url.lastIndexOf("/")) ;
    return _url ;
}

function getOuterHTML(node)
{
	var container = $("<div></div>");
	var o = $(node).clone();
	$(container).append(o);
	return $(container).html();
}

function get_filesize(filesize)
{
	if (filesize == 0)
		return "0 B" ;
    var mod = 1024;
	var units = 'B,KB,MB,GB,TB,PB'.split(",");
	for (var i = 0; filesize > mod; i++) {
		filesize = filesize / mod;
	}
	return Math.round(filesize*100)/100 + ' ' + units[i];
}


function get_filetype(filename)
{
	var pos = filename.toString().lastIndexOf(".") ;
	if (pos == -1)
		return "folder" ;
	var extend_name = filename.substring(pos).toLowerCase();
	
	if (".doc.docx".indexOf(extend_name)>-1)
		return "doc" ;
		
	if (".ppt.pptx".indexOf(extend_name)>-1)
		return "ppt" ;
		
	if (".xls.xlsx".indexOf(extend_name)>-1)
		return "xls" ;
		
	if (".pdf".indexOf(extend_name)>-1)
		return "pdf" ;
		
	if (".zip.rar".indexOf(extend_name)>-1)
		return "zip" ;
		
	if (".gif.png.jpg.jpeg.bmp".indexOf(extend_name)>-1)
		return "img" ;
		
	if (".mp3.mp4..waw".indexOf(extend_name)>-1)
		return "mp3" ;
		
	return "unknow" ;
}

//格式化客户端版本
function format_client_version(version)
{
	var result;
	result = version.substr(0,1) + "." + version.substr(1,1) + "." + version.substr(2,2) + get_client_type(version.substr(4,1)) ;
	return result;
}

function get_client_type(type)
{
	switch(type)
	{
		case "0":
			return " Alpha";
		case "1":
			return " Beta";
		case "2":
			return " Rel";
		default:
			return " Rel";
	}
}

/*
 * 限制文件上传类型
*/
function limitAttach(fieldId) {
	var file = $("#" + fieldId).val();
	var fileTypes = $("#" + fieldId).attr("accept");
	var ext = get_fileType(file);
	if ( fileTypes.indexOf(ext) <0 ) {
		myAlert("文件类型必须是[" + fileTypes + "]中的一种");
		return false;
	}
	return true;
}

function get_fileType(file_name){
	var result =/\.[^\.]+$/.exec(file_name);
	return result;
}

function get_lang(str,param1,param2,param3,param4,param5){

    if(param1 != null)
        str = str.replace("%1",param1);
    if(param2 != null)
        str = str.replace("%2",param2);
    if(param3 != null)
        str = str.replace("%3",param3);
    if(param4 != null)
        str = str.replace("%4",param4);
    if(param5 != null)
        str = str.replace("%5",param5);
    return str;
}

/*
method	格式化 input:cehck 控件对象显示
		input:check 要求属性 class="switch" for="div1"
*/
function formatCheckSwitch()
{
	$("input.switch").each(function(){
		var chk = $(this);
		var e = $("#" + $(chk).attr("for")) ;
		switchDisplayElement(e,$(chk).is(':checked')) ;
		
		$(chk).click(function(){
			switchDisplayElement(e,$(this).is(':checked'));
		})
	})	
	
	$("input[name=Type]").each(function(){
		var chk = $(this);
		var e = $("#div_authen_url") ;
		switchDisplayElement(e,$("input[name='Type'][value='2']").is(':checked')) ;
		
		$(chk).click(function(){
			switchDisplayElement(e,$("input[name='Type'][value='2']").is(':checked'));
		})
	})
}
/**
 * 扩展Array方法, 去除数组中空白数据
 */
Array.prototype.notempty = function() {
    var arr = [];
    this.map(function(val, index) {
        //过滤规则为，不为空串、不为null、不为undefined，也可自行修改
        if (val !== "" && val != undefined) {
            arr.push(val);
        }
    });
    return arr;
}
/*
method	开显示关对象
param	e 对象
param	isShow 开/关(显示)
*/
function switchDisplayElement(e,isShow)
{
	if (isShow == undefined)
		isShow = true ;

	if (isShow)
		$(e).show();
	else
		$(e).hide();
}

function compare_date(checkStartDate, checkEndDate) {
	var arys1 = new Array();
	var arys2 = new Array();
	if (checkStartDate != null && checkEndDate != null) {
		arys1 = checkStartDate.split('-');
		var sdate = new Date(arys1[0], parseInt(arys1[1] - 1), arys1[2]);
		arys2 = checkEndDate.split('-');
		var edate = new Date(arys2[0], parseInt(arys2[1] - 1), arys2[2]);
		if (sdate > edate) {
			return false;
		} else {
			return true;
		}
	}
}

//格林威治时间的转换
Date.prototype.format = function(format)
{
	var o = {
            "M+" : this.getMonth()+1, //month
            "d+" : this.getDate(), //day
            "h+" : this.getHours(), //hour
            "m+" : this.getMinutes(), //minute
            "s+" : this.getSeconds(), //second
            "q+" : Math.floor((this.getMonth()+3)/3), //quarter
            "S" : this.getMilliseconds() //millisecond
        }
    if(/(y+)/.test(format))
    format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
    if(new RegExp("("+ k +")").test(format))
    format = format.replace(RegExp.$1,RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}

function CurentDate(){ 
	var now = new Date();
	var year = now.getFullYear();       //年
	var month = now.getMonth() + 1;     //月
	var day = now.getDate();            //日
	var clock = year + "-";
	if(month < 10)
	   clock += "0";
	   clock += month + "-";
	if(day < 10)
	   clock += "0"; 
	   clock += day + " ";
	return(clock); 
} 

function CurentTime(){ 
	var now = new Date();
	var hh = now.getHours();            //时
	var mm = now.getMinutes();          //分
	var ss = now.getSeconds();
	var clock = "";
	if(hh < 10)
	   clock = "0";
	   clock += hh + ":";
	if (mm < 10) clock += '0'; 
	   clock += mm + ":";
	if (ss < 10) clock += '0'; 
	   clock += ss; 
	return(clock); 
} 

function chGMTDate(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("yyyy-MM-dd");
}

function chGMTTime(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("hh:mm:ss");
}

function chGMTDateTime1(gmtDate){
	if(gmtDate.indexOf("-")>-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate=new Date(Date.parse(gmtDate.replace(/-/g,"/"))); 
	return mydate.format("yyyy/MM/dd hh:mm:ss");
	
//return new Date(gmtDate.replace(/\s/g, '/')).format('yyyy-MM-dd')
}

function chGMTDateTime(gmtDate) {
   if(gmtDate.indexOf(":")!=-1) return gmtDate;
   else return new Date(parseInt(gmtDate) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
} 

function chGMTDateTime4(gmtDate){
	if(gmtDate.indexOf("-")==-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate = new Date(Date.parse(gmtDate.replace(/-/g,"/")));
	return parseInt(mydate.getTime()/1000);;
}

function formatSeconds(value) {

    var theTime = parseInt(value);// 秒
    var middle= 0;// 分
    var hour= 0;// 小时

    if(theTime > 60) {
        middle= parseInt(theTime/60);
        theTime = parseInt(theTime%60);
        if(middle> 60) {
            hour= parseInt(middle/60);
            middle= parseInt(middle%60);
        }
    }
    var result = ""+parseInt(theTime)+"秒";
    if(middle > 0) {
        result = ""+parseInt(middle)+"分"+result;
    }
    if(hour> 0) {
        result = ""+parseInt(hour)+"小时"+result;
    }
    return result;
}    

function guid32() {
    function S4() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1).toUpperCase();
    }
    return (S4()+S4()+S4()+S4()+S4()+S4()+S4()+S4());
}

function guid() {
    function S4() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    }
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

function get_download_img_url(tString)
{
	var url = "myid=livechat&label=msg&name=" + tString  ;
	url = "/public/cloud.html?op=getfile&" + url ;
	return url ;
}


function decode2UserText(UserText)
{
	UserText=unescape(UserText);
	//UserText=UserText.replace(/\\/g,"/");
	UserText=UserText.replace(/"/g, "");
	UserText=UserText.replace(/<\/?.+?>/g,""); 
	UserText=UserText.replace(/[\r\n]/g, "<br>"); 
	UserText=UserText.replace(/<br><br>/g, "<br>"); 
	
	if(UserText.indexOf("{h@")!=-1) UserText=langs.lv_chat_file;
	else if(UserText.indexOf("{b@")!=-1) UserText=langs.lv_chat_file;
	else if(UserText.indexOf("{c@")!=-1) UserText=langs.lv_chat_location;
	else if(UserText.indexOf("{d@")!=-1) UserText=langs.lv_chat_voice;
	else if(UserText.indexOf("{e@")!=-1) UserText=langs.lv_chat_pic;
	else if(UserText.indexOf("{f@")!=-1) UserText=langs.lv_chat_expression;
	else if(UserText.indexOf("{i@")!=-1) UserText=langs.lv_chat_video;
	else if(UserText.indexOf("{k@")!=-1) UserText=langs.lv_chat_card;
	else if(UserText.indexOf("{o@")!=-1) UserText=langs.lv_chat_link;
	else if(UserText.indexOf("{q@")!=-1) UserText=langs.lv_chat_link;
	else if(UserText.indexOf("{x@")!=-1) UserText=langs.lv_voice_call;
	else if(UserText.indexOf("{y@")!=-1) UserText=langs.lv_video_call;
	return UserText ;
}

function getScript(url,callback) {
	var timestamp = "rnd=" + Math.random() ;
	var s = document.createElement('script');
	s.onload = s.onreadystatechange = function(o) {
	  if(!this.readyState || this.readyState == "loaded" || this.readyState == "complete"){
		if (callback != undefined)
			callback();
	  }
	}

	s.src = url + '?' + timestamp;
	s.charset = "utf-8";
	document.body.appendChild(s);
}

function GetURLRequest(url) {
   var theRequest = new Object();
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&amp;");
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}

function ts2dt1(ts){
	var datetime = new Date(parseInt(ts) * 1000),y=datetime.getFullYear(),m=datetime.getMonth()+1,d=datetime.getDate(),h=datetime.getHours(),mm=datetime.getMinutes();
	if(m<10){m="0"+m;}
	if(d<10){d="0"+d;}
	if(h<10){h="0"+h;}
	if(mm<10){mm="0"+mm;}
	
    var dt = y+"-"+m+"-"+d+" "+h+":"+mm;
	return dt;
}

function ts2dt(ts){
	var datetime = new Date(parseInt(ts) * 1000),y=datetime.getFullYear(),m=datetime.getMonth()+1,d=datetime.getDate();
	if(m<10){m="0"+m;}
	if(d<10){d="0"+d;}	
    var dt = y+"-"+m+"-"+d;
	return dt;
}

function ts2hm(ts){
	var datetime = new Date(parseInt(ts) * 1000),h=datetime.getHours(),mm=datetime.getMinutes();
	if(h<10){h="0"+h;}
	if(mm<10){mm="0"+mm;}
	
    var dt = h+":"+mm;
	return dt;
}