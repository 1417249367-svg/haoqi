/*
程序名称：触点通RTC
作    者： 周舟
QQ:1417249367
网站地址：    http://www.haoqiniao.cn
日    期：    2014.03.19
说明：复制请保留源作者信息，转载请说明，欢迎大家提出意见和建议
*/
function $$(id)
{
	return document.getElementById(id);
}
function getID(id){ 
    var s=document.getElementById(id);
    if(s) return getID(id+"d");
    else return id;
}

function getFullFileName(str){ 
	 str=str.replace(/\\/g,"/");
	 var p=str.lastIndexOf('/'); 
     return str.substr(++p,str.length-p); 
}

//字符串逆转
function strturn(str) {
	if (str != "") {
	var str1 = "";
	for (var i = str.length - 1; i >= 0; i--) {
		str1 += str.charAt(i);
	}
	return (str1);
	}
}
		
function GetFileExt(filepath) {
	if (filepath != "") {
		var pos = "." + filepath.replace(/.+\./, "");
		return pos;
	}
}


//取文件名不带后缀
function GetFileNameNoExt(filepath) {
	var pos = strturn(GetFileExt(filepath));
	var file = strturn(filepath);
	var pos1 =strturn( file.replace(pos, ""));
	var pos2 = getFullFileName(pos1);
	return pos2;
}
		
function left(mainStr,lngLen) { 
if (lngLen>0) {return mainStr.substring(0,lngLen)} 
else{return null} 
}
function right(mainStr,lngLen) { 
if (mainStr.length-lngLen>=0 && mainStr.length>=0 && mainStr.length-lngLen<=mainStr.length) { 
return mainStr.substring(mainStr.length-lngLen,mainStr.length)} 
else{return null} 
} 
function mid(mainStr,starnum,endnum){ 
if (mainStr.length>=0){ 
return mainStr.substr(starnum,endnum) 
}else{return null} 
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
	if(hh < 10)
	   clock = "0";
	   clock = hh + ":";
	if (mm < 10) clock += '0'; 
	   clock += mm + ":";
	if (ss < 10) clock += '0'; 
	   clock += ss; 
	return(clock); 
} 
function CurentDate1(){ 
	var now = new Date();
	var year = now.getFullYear();       //年
	var month = now.getMonth() + 1;     //月
	var day = now.getDate();            //日
	var clock = year + "/";
    clock += month + "/";
    clock += day + " ";
	return(clock); 
} 

function CurentTime1(){ 
	var now = new Date();
	var hh = now.getHours();            //时
	var mm = now.getMinutes();          //分
	var ss = now.getSeconds();
	 clock = hh + ":";
	 clock += mm + ":";
	 clock += ss; 
	return(clock); 
} 
var getOffDays = function(startDate, endDate) { 
var mmSec = (endDate.getTime() - startDate.getTime()); //得到时间戳相减 得到以毫秒为单位的差    
  return (mmSec); 
}; 

var isJson = function(obj){
    var isjson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
    return isjson;
}

function GetRandomNum(Min, Max) {
var Range = Max - Min;
var Rand = Math.random();
return (Min + Math.round(Rand * Range));
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

function chGMTDateTime(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("yyyy-MM-dd hh:mm:ss");
}
function chGMTDateTime1(gmtDate){
	if(gmtDate.indexOf("-")==-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate=new Date(Date.parse(gmtDate.replace(/-/g,"/"))); 
	return mydate.format("yyyy/MM/dd hh:mm:ss");
}
function chGMTDate(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("yyyy-MM-dd");
}
function chGMTDate1(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("MM-dd");
}
function chGMTDate2(gmtDate){
	if(gmtDate.indexOf("-")==-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate=new Date(Date.parse(gmtDate.replace(/-/g,"/"))); 
	return mydate.format("yyyy-MM-dd");
}
function chGMTDate3(gmtDate){
	if(gmtDate.indexOf("-")==-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate=new Date(Date.parse(gmtDate.replace(/-/g,"/"))); 
	return mydate.format("yyyy/MM/dd");
}
function chGMTTime(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("hh:mm:ss");
}
function chGMTTime1(gmtDate){
	var mydate = new Date(gmtDate);
	return mydate.format("hh:mm");
}
function chGMTTime2(gmtDate){
	if(gmtDate.indexOf("-")==-1) gmtDate=gmtDate.replace(/ /g,"/");
	var mydate=new Date(Date.parse(gmtDate.replace(/-/g,"/"))); 
	return mydate.format("hh:mm:ss");
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

	mydate = year + "/" + month + "/" + day ;

	if (islongdate)
	{
		mytime = replaceAll(mytime,"PM","下午");
		mytime = replaceAll(mytime,"AM","上午");
		mydate += " " + mytime ;
	}
    return mydate  ;
}

function toTime(date)
{
	if (date == "")
		return "" ;
	var mytime = "" ;
	var pos = date.lastIndexOf(" ") ;
	if (pos > -1)
	{
		mytime = date.substring(pos,date.length) ;
		mytime = replaceAll(mytime,"PM","下午");
		mytime = replaceAll(mytime,"AM","上午");
	}

    return mytime  ;
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


function encodeUTF8(str){
  var temp = "",rs = "";
  for( var i=0 , len = str.length; i < len; i++ ){
	  temp = str.charCodeAt(i).toString(16);
	  rs  += "\\u"+ new Array(5-temp.length).join("0") + temp;
  }
  return rs;
}
function decodeUTF8(str){
  return str.replace(/(\\u)(\w{4}|\w{2})/gi, function($0,$1,$2){
	  return String.fromCharCode(parseInt($2,16));
  }); 
} 

function s_to_hs(s){
var h;
h = Math.floor(s/60);
s = s%60;
h += '';
s += '';
h = (h.length==1)?'0'+h:h;
s = (s.length==1)?'0'+s:s;
return h+'\''+s+'\'\'';
}

function get_filetype(filename)
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
		
	if (".mp3.wav.asf.aac.vqf.wma.amr".indexOf(extend_name)>-1)
		return "mp3" ;
		
	if (".rm.rmvb.wmv.avi.mp4.3gp.mkv.mov.mpeg".indexOf(extend_name)>-1)
		return "mpeg" ;
		
	return "unknow" ;
}

function is_oos(filename)
{
	var pos = filename.toString().lastIndexOf(".") ;
	var extend_name = filename.substring(pos).toLowerCase();
	if (".ods.xls.xlsb.xlsm.xlsx.doc.docm.docx.dot.dotm.dotx.odt.odp.pot.potm.potx.pps.ppsm.ppsx.ppt.pptm.pptx".indexOf(extend_name)>-1)
		return true ;

	return false;
}


// sigln or batch
function get_ids(id)
{
	if ((id == undefined) || (id == "") || (id == "0"))
	{
		id = getCheckValue("chk_id");
		if (id == "")
		{
			myAlert(get_lan('Please-select-the-file'));
			return "" ;
		}
	}
	return id ;
}

function getCheckValue(name)
{
   var select = whoSelect();
   var val = "" ;
   for(var i = 0; i < select.length; i++ ) val += "," + select[i].getAttribute('id');
   if (val != "")
        val = val.substring(1,val.length)  ;
   return val ;
}

//function get_ids1(id)
//{
//	if ((id == undefined) || (id == "") || (id == "0"))
//	{
//		id = getCheckValue1("chk_id");
//		if (id == "")
//		{
//			myAlert("请选择文件");
//			return "" ;
//		}
//	}
//	return id ;
//}
//
//function getCheckValue1(name)
//{
//   var select = whoSelect();
//   var val = "" ;
//   for(var i = 0; i < select.length; i++ ) val += "," + select[i].getAttribute('data-file-id');
//   if (val != "")
//        val = val.substring(1,val.length)  ;
//   return val ;
//}

function getElementsByClassName(className, root, tagName) {    //root：父节点，tagName：该节点的标签名。 这两个参数均可有可无
    if (root) {
        root = typeof root == "string" ? document.getElementById(root) : root;
    } else {
        root = document.body;
    }
    tagName = tagName || "*";
    if (document.getElementsByClassName) {                    //如果浏览器支持getElementsByClassName，就直接的用
        return root.getElementsByClassName(className);
    } else {
        var tag = root.getElementsByTagName(tagName);    //获取指定元素
        var tagAll = [];                                    //用于存储符合条件的元素
        for (var i = 0; i < tag.length; i++) {                //遍历获得的元素
            for (var j = 0, n = tag[i].className.split(' ') ; j < n.length; j++) {    //遍历此元素中所有class的值，如果包含指定的类名，就赋值给tagnameAll
                if (n[j] == className) {
                    tagAll.push(tag[i]);
                    break;
                }
            }
        }
        return tagAll;
    }
}
/**
* 返回第一个元素firstElementChild的浏览器兼容
* @param parent
* @returns {*}
*/
function getFirstElement(parent) {
  if(!parent) return;
  if(parent.firstElementChild) {
    return parent.firstElementChild;
  }else {
    var el = parent.firstChild;
    while(el && el.nodeType !== 1) {
      el = el.nextSibling;
      }
    return el;
  }
}

//兼容浏览器   获取下一个兄弟元素
function getNextElement(node){
        var NextElementNode = node.nextSibling;
        while(NextElementNode.nodeValue != null){
            NextElementNode = NextElementNode.nextSibling
        }
        return NextElementNode;
    }

function children(curEle,tagName){

	   var nodeList = curEle.childNodes;
	   var ary = [];
	   if(/MSIE(6|7|8)/.test(navigator.userAgent)){
		   for(var i=0;i<nodeList.length;i++){
			   var curNode = nodeList[i];
			   if(curNode.nodeType ===1){
				  ary[ary.length] = curNode;
			   }
		   }
	   }else{
		   ary = Array.prototype.slice.call(curEle.children);
	   }
	   
	   // 获取指定子元素
	   if(typeof tagName === "string"){
		   for(var k=0;k<ary.length;k++){
			 curTag = ary[k];
			 if(curTag.nodeName.toLowerCase() !== tagName.toLowerCase()){
			  ary.splice(k,1);
			  k--;
			 }
		   }
	   }

	   return ary;
}

function stopEvent(event){ //阻止冒泡事件
     //取消事件冒泡
     var e=arguments.callee.caller.arguments[0]||event; //若省略此句，下面的e改为event，IE运行可以，但是其他浏览器就不兼容
     if (e && e.stopPropagation) {
     // this code is for Mozilla and Opera
     e.stopPropagation();
     } else if (window.event) {
     // this code is for IE
      window.event.cancelBubble = true;
     }
}

function getStyle (obj,attr) {
return obj.currentStyle ? obj.currentStyle[attr]:getComputedStyle(obj)[attr];

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

function replaceAll(str,replaceStr,newStr)
{
if (str == "")
return str ;
var reg = new RegExp("\\" + replaceStr,"g");
return str.replace(reg,newStr);

}


//////////////////////////////////////////////////////可视区宽高//////////////////////////////////////////////////////
function views(){
	return {
		W:document.documentElement.clientWidth,
		H:document.documentElement.clientHeight
	}
}

if(!String.prototype.trim) {
	 String.prototype.trim = function () {
		 return this.replace(/^\s+|\s+$/g,'');
	};
}

String.prototype.colorRgb = function(){  
    var sColor = this;
	var ByN=256;
    var ByN2=65536;
	var SmsnList=new Array();
	SmsnList[0]=sColor%ByN;
	SmsnList[1]=sColor%ByN2/ByN;
	SmsnList[2]=sColor%ByN2;
    return "RGB(" + SmsnList.join(",") + ")";  

};  
/*获取选中的文字*/
var _getSelectedText = function() {
 if (window.getSelection) {
  return window.getSelection().toString();
 } else if (document.getSelection) {
  return document.getSelection();
 } else if (document.selection) {
  return document.selection.createRange().htmlText;
 }else{
  return "";
 }
}

function SelectText(obj) {
	//var text = document.getElementById(element);
	var range = document.body.createTextRange();
	range.moveToElementText(obj);
	range.select();
}
function getInt(val)
{
    if (val == null)
        return 0 ;
    if (val == undefined)
        return 0 ;
    return parseInt(val) ;
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


function getAjaxUrl(obj,op,param)
{
    var url = "http://"+ServerIp+":98/public/" + obj + ".html?op=" + op ;
    if (param != undefined)
        url += "&" + param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}

function guid() {
    function S4() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    }
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}
