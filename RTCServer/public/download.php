<?php
//define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
//require_once (__ROOT__ . "/config/config.inc.php");
//require_once (__ROOT__ . "/class/common/Site.inc.php");
require_once("class/fun.php");
//加载基础语言
addLangModel1("cloud");

ob_clean();
//function getAppValue($name = "",$defaultValue = "")
//{
//	global $arrSysConfig ;
//	
//	$name = strtolower($name);
//	$value = "" ;
//
//	if (isset($arrSysConfig[$name]))
//		$value = $arrSysConfig[$name] ;
//
//	if ($value == "")
//		$value = $defaultValue ;
//
//	return trim($value) ;
//
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=get_lang('download_title1')?></title>
<!-- 调用样式表 -->
<link rel="stylesheet" href="/templets/mobantianxia/images/style.css" type="text/css" media="all">
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type="text/javascript" src="/templets/mobantianxia/images/loopedcarousel.js"></script>
<script type="text/javascript">
$(function() {
// carousel
$('.loopedCarousel').loopedCarousel();
});
var browser={
versions:function(){
	var u = navigator.userAgent, app = navigator.appVersion;
	return {
		trident: u.indexOf('Trident') > -1, //IE内核
		presto: u.indexOf('Presto') > -1, //opera内核
		webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
		gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
		mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
		ios: !!u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/), //ios终端
		android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
		iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
		iPad: u.indexOf('iPad') > -1, //是否iPad
		webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
		};
	}(),
	language:(navigator.browserLanguage || navigator.language).toLowerCase()
	}
if(browser.versions.android==true||browser.versions.iPhone==true||browser.versions.iPad==true){
	window.location.href="/download_m.html"
}
var type=navigator.appName;
if (type=="Netscape"){
var lang = navigator.language;
}
else{
var lang = navigator.userLanguage;
}
//取得浏览器语言的前两个字母
var lang = lang.substr(0,2)
// 英语
//if (lang == "en"){
//window.location.href="/index1.html";
//}
//// 中文 - 不分繁体和简体
//else if (lang == "zh"){
////  window.location.href="http://www.xxx.cn/"
////  注释掉了上面跳转,不然会陷入无限循环
//}
//// 除上面所列的语言
//else{
////window.location.href="/index.html"
//}
function AdminLogin(){
	  var urlpath=window.location.protocol+'//' + window.location.host +'/admin/account/login.html';
	  window.open(urlpath);  
}

</script>

<script type="text/javascript" src="/templets/mobantianxia/images/tabs.js"></script>
<script language="javascript" type="text/javascript" src="/include/dedeajax2.js"></script>
<script type="text/javascript">
function CheckLogin(){
	  var taget_obj = document.getElementById('_userlogin');
	  myajax = new DedeAjax(taget_obj,false,false,'','','');
	  myajax.SendGet2("/member/ajax_loginsta.php");
	  DedeXHTTP = null;
}
</script>
<script language="javascript" type="text/javascript">
<!-- 
function ResumeError()  
{ 
    return true; 
} 
window.onerror = ResumeError; 
function check()
{
if(document.search.keyword.value.length==0){
     alert("请输入查询信息！");
     document.search.keyword.focus();
     return false;
    }

}
// --> 


// 导航下拉菜单

$(function(){
nav_curr();	   
   
//下拉菜单
$("#menu > li:has(.subMenu)").hover(function(){
//$("#menu > li > a").removeClass("hover");	
$(this).find("a").eq(0).addClass("hover");
$(this).find(".subMenu").stop(true,true).fadeIn(300);
},function(){
$(this).find("a").eq(0).removeClass("hover");
$(this).find(".subMenu").stop(true,true).fadeOut(300);
nav_curr();
});		

//导航当前项
function nav_curr(){
for(var i=0;i<5;i++){
navText=$("#menu > li > a").eq(i).attr("title");	
if(navText==navCurrent){
$("#menu > li > a").eq(i).addClass("hover");
}
}
}

});

var navCurrent="首页";
</script>

<style type="text/css">

#banner{height:250px;}
#info {margin:34px 20px 0px 0px;}
#top_nav {padding:8px 10px 6px;}
#right {background:none;}
</style>

</head>
<body>
<div id="body">
<div id="main">
<!-- 页头开始 -->
<div id="topmenu">
      <a href="#" style="width:80px;float:right;" onclick="AdminLogin();"><span class="blank30"><strong><?=get_lang('download_title2')?></strong></span></a>
      <a href="http://www.haoqiniao.cn/docs/" target="_blank" style="width:80px;float:right;"><?=get_lang('download_title3')?></a>
<div class="tel">
<h5><?=get_lang('download_title4')?>：&nbsp;&nbsp;400-8075-114&nbsp;&nbsp;&nbsp;&nbsp;<?=get_lang('download_title5')?>:&nbsp;&nbsp;<a href="http://www.haoqiniao.cn" target="_blank">www.haoqiniao.cn</a></h5>
</div>
</div>
<div id="logo"><a href="http://www.haoqiniao.cn" title="好奇鸟"><span><h1>好奇鸟</h1></span></a></div>

<div class="clearall"></div>

<div id="top_nav">
<div id="nav">
<ul id="menu">
<li><?=get_lang('download_title1')?></li>
</ul>
</div>
</div>
<body>
<SCRIPT src="/templets/mobantianxia/images/jquery.featureList-1.0.0.js" 
type=text/javascript></SCRIPT>

<SCRIPT src="/templets/mobantianxia/images/kxbdSuperMarquee.js" 
type=text/javascript></SCRIPT>

<SCRIPT type=text/javascript>

function tencent_wpa(uuu,gh,g_corp,useqq,newpop)
{
var g_noHeader = true;
var g_noFooter = true;
var g_vsWidth = "570px";
var g_vsHWidth = "644px";
}

$(document).ready(function() {

$.featureList(
$("#banner_current li a"),
$("#output li"), {
start_item	:	0
}
);			
$('#customer-list').kxbdSuperMarquee({
//isMarquee:true,
//duration:20,
 				isEqual:false,
distance:22,
time:1,
direction:'up'
});
$('#news-list').kxbdSuperMarquee({
isEqual:false,
distance:16,
time:2,
//btnGo:{up:'#goU',down:'#goD'},
direction:'up'
});


});	
</SCRIPT>

<div id="right" style="float:left;">

<div class="blank10"></div>

<div id="position">
<strong><?=get_lang('download_title6')?>：</strong><?=get_lang('download_title1')?></div>
<div id="text" class="text" style="width:930px;margin:15px;">

<div id="content" style="width:930px;" class="text">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top"><a href="#" onclick="javascript:get_filepath();"><img src="templets/mobantianxia/images/down_ico.jpg" width="9" height="12" /><strong><?=get_lang('download_title7')?></strong></a>
        <p isimg="false"><?=get_lang('download_title8')?></p></td>
      <td valign="top"><p><a href="templets/xiazai/rtc_android.apk"><img src="templets/mobantianxia/images/down_ico.jpg" width="9" height="12" /><strong>Android</strong></a></p>
        <p isimg="false"><?=get_lang('download_title9')?></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
      <td valign="top"><a href="https://itunes.apple.com/cn/app/id6747035211" target="_blank"><img src="templets/mobantianxia/images/down_ico.jpg" width="9" height="12" /><strong>App Store</strong></a>
        <p isimg="false"><?=get_lang('download_title10')?></p></td>
      <td><p id="img_id"></p>
        <p><?=get_lang('download_title11')?></p></td>
      </tr>
    <tr>
      <td><div isimg="false">
        <p><?=get_lang('download_title12')?></p>
      </div></td>
      <td colspan="3"><div isimg="false">
        <div isimg="false">
          <div isimg="false">
            <p><?=get_lang('download_title13')?></p>
          </div>
        </div>
      </div></td>
    </tr>
  </table>
</div>
</div>


</div>
<div id="right" style="float:left;">

<div class="blank10"></div>

<div id="position">
<strong><?=get_lang('download_title6')?>：</strong><?=get_lang('download_title14')?></div>
<div id="text" class="text" style="width:930px;margin:15px;">

<div id="content" style="width:930px;" class="text">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><a href="http://www.haoqiniao.cn/xiazai/<?=get_lang('download_title17')?>"><img src="templets/mobantianxia/images/down_ico.jpg" width="9" height="12" /><?=get_lang('download_title17')?></a></td>
      <td><img src="templets/mobantianxia/images/down_ico.jpg" width="9" height="12" /><a href="http://www.haoqiniao.cn/xiazai/<?=get_lang('download_title18')?>"><?=get_lang('download_title18')?></a></td>
      <td></td>
    </tr>
  </table>
</div>
<div class="blank30"></div>
</div>


</div>
<div id="right" style="float:left;">

<div class="blank10"></div>

<div id="position">
<strong><?=get_lang('download_title6')?>：</strong><?=get_lang('download_title15')?></div>
<div id="text" class="text" style="width:930px;margin:15px;">

<div id="content" style="width:930px;" class="text"><?=get_lang('download_title16')?></div>
<div class="blank30"></div>
</div>


</div>
<div class="clear"></div>
</div>

<script> 
function get_filepath(e)
{
	var url = getAjaxUrl("msg","get_file1","myid=public");
	//document.write(url);
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(result){
			if (result.status)
			{
				location.href = "/templets/xiazai/RTC.zip";
				
			}
			else
				alert(result.msg);
	   },
	   error: function(result){
		   location.href = "/templets/xiazai/RTC.zip";
		   alert("请登录进入后台-系统工具-后台设置--消息服务器IP地址,修改为服务器ip!");
	   }
	});
}
function getAjaxUrl(obj,op,param)
{
    var url = window.location.protocol+'//' + window.location.host+"/public/" + obj + ".html?op=" + op ;
    if (param != undefined)
        url += "&" + param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}
function resizeImg(obj)
{ 
var obj = document.getElementById(obj); 
var objContent = obj.innerHTML;
var imgs = obj.getElementsByTagName('img'); 
if(imgs==null) return; 
for(var i=0; i<imgs.length; i++) 
{ 
if(imgs[i].width>parseInt(obj.style.width)) 
{ 
imgs[i].width = parseInt(obj.style.width);
} 
} 
} 
window.onload = function() {resizeImg('content');
} 
var url = window.location.protocol+'//' + window.location.host+"/download_m.html" ;
var html =  "<img src='"+window.location.protocol+'//' + window.location.host+"/public/qrcode.html?myid=public&size=5&encode=1&text=" + escape(url) + "'>";
$("#img_id").html(html);
</script>
<div class="clear"></div>
<div id="footer">
<div class="main">
<div class="about">
</div>
</div>
<div class="copy">	
<div class="main">
<div class="foot_logo"></div>
</div>
</div>
</div>
<script>var _rtckf = _rtckf || [];(function() {var kf = document.createElement("script");kf.src = "<?=getRootPath() ?>/livechat/getjs/?loginname=admin";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(kf, s);})();</script>
</body>
</html>