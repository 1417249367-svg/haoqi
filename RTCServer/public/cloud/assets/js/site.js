

$(document).ready(function(){

})
// <param name="paras">参数名称</param>
///
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
function flashChecker()
{
    var hasFlash=0;         //是否安装了flash
    var flashVersion=0; //flash版本
    var isIE=/*@cc_on!@*/0;      //是否IE浏览器

    if(isIE)
    {
        try
        {
            var swf = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
        }
        catch(err)
        {
            swf = false ;
        }
        if(swf) {
            hasFlash=1;
            VSwf=swf.GetVariable("$version");
            flashVersion=parseInt(VSwf.split(" ")[1].split(",")[0]);
        }
    }else{
    if (navigator.plugins && navigator.plugins.length > 0)
    {
    var swf=navigator.plugins["Shockwave Flash"];
        if (swf)
         {
    hasFlash=1;
            var words = swf.description.split(" ");
            for (var i = 0; i < words.length; ++i)
    {
                if (isNaN(parseInt(words[i]))) continue;
                flashVersion = parseInt(words[i]);
    }
        }
    }
    }
    return {f:hasFlash,v:flashVersion};
}



function formatContainer(container)
{
    if (container == undefined)
        container = $("body") ;

    $("[action-type]",container).click(function () {
        var cmd = $(this).attr("action-type") + "(" + $(this).attr("action-data") + ")" ;
        eval(cmd);
    });



}

function initSideBar()
{
    var container = $("#sidebar") ;

	$("a",container).click(function(){
		var currmenu = $(this).siblings() ;
		if (currmenu.length>0)
		{
			$(".submenu",container).hide();
			$(currmenu).show();
		}
		$("a",container).removeClass("active");
		$(this).addClass("active");
	})
}

function initSideBar1()
{
    var container = $("#sidebar") ;

	$("a",container).click(function(){
		var currmenu = $(this).siblings() ;
		if (currmenu.length>0)
		{
			$(".submenu",container).hide();
			$(currmenu).show();
		}
		$("a",container).removeClass("active");
		$(this).addClass("active");
		file_type=$(this).attr("data-id");
		doc_list_init();
		doc_list();
	})
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

function get_filetype1(filename)
{
	var pos = filename.toString().lastIndexOf(".") ;
	if (pos == -1)
		return "folder" ;
	var extend_name = filename.substring(pos).toLowerCase();
	if (".psd".indexOf(extend_name)>-1)
		return "psd" ;
		
	if (".txt.ini".indexOf(extend_name)>-1)
		return "txt" ;
		
	if (".htm.asp.php.jsp.js.cs".indexOf(extend_name)>-1)
		return "html" ;
		
	if (".doc.docx.wps.rtf".indexOf(extend_name)>-1)
		return "doc" ;
		
	if (".ppt.pptx.dps".indexOf(extend_name)>-1)
		return "ppt" ;
		
	if (".xls.xlsx.et".indexOf(extend_name)>-1)
		return "xls" ;
		
	if (".pdf".indexOf(extend_name)>-1)
		return "pdf" ;
		
	if (".zip.rar".indexOf(extend_name)>-1)
		return "zip" ;
		
	if (".gif.png.jpg.jpeg.bmp".indexOf(extend_name)>-1)
		return "img" ;
		
	if (".mp3.wav.asf.aac.vqf.wma".indexOf(extend_name)>-1)
		return "mp3" ;
		
	if (".rm.rmvb.wmv.avi.mp4.3gp.mkv.mov.mpeg.webm".indexOf(extend_name)>-1)
		return "mpeg" ;
		
	return "unknow" ;
}

function GetFileExt(filepath) {
	if (filepath != "") {
		var pos = "." + filepath.replace(/.+\./, "");
		return pos;
	}
}

function is_oos(filename)
{
	var pos = filename.toString().lastIndexOf(".") ;
	var extend_name = filename.substring(pos).toLowerCase();
	if (".ods.xls.xlsb.xlsm.xlsx.doc.docm.docx.dot.dotm.dotx.odt.pot.potm.potx.pps.ppsm.ppsx.ppt.pptm.pptx.odp".indexOf(extend_name)>-1)
		return true ;

	return false;
}

function getFullFileName(str){ 
	 str=str.replace(/\\/g,"/");
	 var p=str.lastIndexOf('/'); 
     return str.substr(++p,str.length-p); 
}


// sigln or batch
function get_ids(id)
{
	if ((id == undefined) || (id == "") || (id == "0"))
	{
		id = getCheckValue("chk_id");
		if (id == "")
		{
			myAlert(langs.get_ids_warning);
			return "" ;
		}
	}
	return id ;
}

function setInnerText(id,str){
	if(id==''){return;}
	//if(str==""){return;}
	$$(id).innerHTML=str;
}

function my_page_switch(p1,p2,cb){
	if(p1 != p2){
		var a = $$(p1);
		var b = $$(p2);
		
		if(a && b){
	        a.style.display="none";
	        b.style.display="block";
		}
		
		if(cb) cb(p2);
	}
}

function my_page_switch_i(p1,p2,cb){
	if(p1 != p2){
		var a = $$(p1);
		var b = $$(p2);
		
		if(a && b){
	        a.style.cssText="display:none !important;";
	        b.style.cssText="display:block !important;";
		}
		
		if(cb) cb(p2);
	}
}

function my_page_switch_j(p1,p2,cb){
	if(p1 != p2){
		var a = $("#"+p1);
		var b = $("#"+p2);
		
		if(a && b){
			a.hide();
	        b.show();
		}
		
		if(cb) cb(p2);
	}
}