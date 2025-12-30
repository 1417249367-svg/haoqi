<?php
//define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
//require_once (__ROOT__ . "/config/config.inc.php");
//require_once (__ROOT__ . "/class/common/Site.inc.php");
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
require_once("class/fun.php");
//加载基础语言
addLangModel1("cloud");

ob_clean();
?>
<!DOCTYPE html>
<!-- saved from url=(0040)http://www.workchat.com/downloadApps.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?=get_lang('download_title1')?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chorme=1">
<script type="text/javascript" src="templets/mobantianxia/images/jquery-2.1.1.min.js"></script>
<style>
body{
    width:100%;
    margin:auto;
    font-family: "Microsoft YaHei","Helvetica Neue",Helvetica,Arial;
    font-size:15px;
    color:#000;
    max-width:400px;
}
.headerBg{
    width:100%;
}
.headerBg img{
    width:100%;
}
.downButton{
    width:100%;
    height:60px;
    position:relative;
    overflow:hidden;
}
a.down{
    background-size: 26px 30px;
    width: 40.5%;
    display: inline-block;
    border-radius: 5px;
    position: absolute;
    top: 14.55%;
    background-repeat: no-repeat;
    background-position: 5.88% center;
    cursor:pointer;
}
a.down span.text{
    font-size:10px;
    display: inline-block;
    width: 100%;
    color: #fff;
    height:10%;
    text-align:center;
    margin-top:3.5px;
}
a.down img{
    width:27px;height:27px;display:inline-block;
}
a.down span.text span{
    position:relative;
    top:-8px;
}
a.down_iphone{
    background-color: #2EA1FC;
    right: 52.5%;
}
a.down_android{
    background-color: #755BF0;
    left: 52.5%;
}
.foot{
    width:100%;
    overflow:hidden;
    margin-bottom:20px;
}
.foot p.footH{
    width:100%;text-align:center;font-size:18px;margin:0px auto 10px auto;
}
.foot ul{
    width:240px;
    margin:0 auto;
}
.foot ul li{
    list-style-type:none;
    line-height:20px;
}
.foot ul li em{
    display: inline-block;
    width: 6px;
    height: 6px;
    background-color: #2EA1FC;
    border-radius: 3px;
    margin-right: 2.5%;
    margin-bottom:2px;
}
#tipBg {
    background: #000;
    opacity: 0.8;
    left: 0px;
    top: 0px;
    position: fixed;
    height: 100%;
    width: 100%;
    overflow: hidden;
    z-index: 10000;
    filter: progid:DXImageTransform.Microsoft.Alpha(opacity=30);
}
#tipBox{
    z-index:10001;
    width:100%;
    height:100%;
    position:absolute;
    top:0;
    left:0;
}
#tipBox img{
    width:20%;
    float:right;
    position:absolute;
    top:2.5%;
    right:5%;
    clear:both;
}
#tipBox .notice{
    position:relative;
    top:25%;
    color:#fff;
    text-align:center;
    font-size:20px;
}
#tipBox .notice p span{
    color:#2EA1FC;
}
</style>
<script>
function checkVersion() {
    var u = navigator.userAgent.toLowerCase();
    var version = {
        "ios" : u.indexOf("iphone") > -1,
        "android" : u.indexOf("android") > -1 || u.indexOf("linux") > -1,
        "safari" : u.indexOf("iphone") > -1,
        "weixin" : u.indexOf("nettype") >-1
    };
    return version;
}


function judgeBrand(sUserAgent) {
   var isIphone = sUserAgent.match(/iphone/i) == "iphone";
   var isHuawei = sUserAgent.match(/huawei/i) == "huawei";
   var isHonor = sUserAgent.match(/honor/i) == "honor";
   var isOppo = sUserAgent.match(/oppo/i) == "oppo";
   var isOppoR15 = sUserAgent.match(/pacm00/i) == "pacm00";
   var isVivo = sUserAgent.match(/vivo/i) == "vivo";
   var isXiaomi1 = sUserAgent.match(/xiaomi/i) == "xiaomi";
   var isXiaomi = sUserAgent.match(/mi\s/i) == "mi ";
   var isXiaomi2s = sUserAgent.match(/mix\s/i) == "mix ";
   var isRedmi = sUserAgent.match(/redmi/i) == "redmi";
   var isSamsung = sUserAgent.match(/sm-/i) == "sm-";

   if (isIphone) {
	   return 'iphone';
   } else if (isHuawei) {
	   return 'huawei';
   } else if (isHonor) {
	   return 'honor';
   } else if (isOppo || isOppoR15) {
	   return 'oppo';
   } else if (isVivo) {
	   return 'vivo';
   } else if (isXiaomi1 || isXiaomi || isRedmi || isXiaomi2s) {
	   return 'xiaomi';
   } else if (isSamsung) {
	   return 'samsung';
   } else {
	   return 'default';
   }
}


function GetRequest() {
   var url = location.search; //获取url中"?"符后的字串
   var theRequest = new Object();
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}
var Request = new Object();
Request = GetRequest();

function getApp(ver) {
    var version = checkVersion();
    if (version.weixin) {
        if (version.ios) {
            var phone = "iphone";
        } else if (version.android){
            var phone = "android";
        } else {
            var phone = ver;
        }   
        $("#tipBg").show();
        $("#tipBox").find(".notice_" + phone).show();
        $("#tipBox").show();
    } else {
	    if (ver=="iphone"){
		window.open("https://itunes.apple.com/cn/app/id6747035211");
		}else{
			var brand = judgeBrand(navigator.userAgent.toLowerCase());
			if(brand=="huawei"||brand=="xiaomi") window.open("templets/xiazai/rtc_android.apk");
			else window.open("templets/xiazai/rtc_android1.apk");
		}
        
    }
}

function copyToClipboard_js(element) {
  var temp = document.createElement("input"); //声明创建一个input元素
  var txt = document.getElementById(element).innerHTML; //获得要复制的文字
  document.body.appendChild(temp); //在body中追加input元素
  temp.value = txt; //把要复制的文字赋予input元素
  temp.select(); //选择要复制的文字
  document.execCommand("copy"); //把文字复制到剪贴板
  document.body.removeChild(temp); //移除body追加的input元素
}

$(document).ready(function(){
	$("#p1").html(document.domain);
    var ua = navigator.userAgent.toLowerCase(),
        mobile = {		
            android : ua.indexOf('android') > -1,
            ios : ua.indexOf('iphone') > -1
        };
    //根椐手机系统改变页面缩放,自动执行
    (function(){
        var meta = document.createElement('meta'),
            head = document.getElementsByTagName('head')[0],
            uiWidth = 1080,      //WebApp布局宽度
            devicePixelRatio = window.devicePixelRatio,
            deviceWidth	= window.screen.width,		
            deviceHeight = window.screen.height;
            getTargetDensitydpi = uiWidth / deviceWidth * devicePixelRatio * 160;
            meta.setAttribute('name','viewport');
        if (mobile.ios){	
            meta.setAttribute('content','width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no');	
        } else {
            meta.setAttribute('content','width=device-width,target-densitydpi= '+ getTargetDensitydpi +',initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no');		
        }
        head.appendChild(meta);
    })();
    //$("body").append(navigator.userAgent.toLowerCase() + " _ " + JSON.stringify(checkVersion()));
    $("body").on("touchend click", "#tipBox", function() {
        $("#tipBg").hide();
        $("#tipBox").hide();
        $("#tipBox").find(".notice").hide();
    });
});
</script>
<meta name="viewport" content="width=device-width,target-densitydpi= 120,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"></head>
<!-- 2EA1FC 755BF0 -->
<body onselectstart="return false;">   
<div class="headerBg">
    <img src="templets/mobantianxia/images/app_bg4.png">
</div>
<div class="downButton">
    <a class="down down_iphone" href="javascript:void(0);" onclick="getApp(&#39;iphone&#39;);return false;">
    <span class="text"><img src="templets/mobantianxia/images/app_iphone.png"><span>iPhone</span></span></a>
    <a class="down down_android" href="javascript:void(0);" onclick="getApp(&#39;android&#39;);return false;">
    <span class="text"><img src="templets/mobantianxia/images/app_android.png"><span>Android</span></span></a>
</div> 
<div class="foot">
    <ul> <li><?=get_lang('download_title19')?></li></ul>
    <span style="color: red;"><b><p class="footH" id="p1"></p></b></span>
    <p class="footH"><button onclick="copyToClipboard_js('p1')"><?=get_lang('download_title20')?></button></p>
</div>
<div id="tipBg" style="display:none;"></div>
<div id="tipBox" style="display:none;">
    <img src="templets/mobantianxia/images/app_arrow.png">
    <div class="notice notice_iphone" style="display:none;">
      <p>请点击右上角按钮</p>
        <p>使用 <span>Safari</span> 打开并下载</p>
    </div>
    <div class="notice notice_android" style="display:none;">
        <p>请点击右上角按钮</p>
        <p>使用 <span>浏览器</span> 打开并下载</p>
    </div>
</div>		
<script>var _rtckf = _rtckf || [];(function() {var kf = document.createElement("script");kf.src = "<?=getRootPath() ?>/livechat/getjs/?loginname=admin";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(kf, s);})();</script>
</body></html>