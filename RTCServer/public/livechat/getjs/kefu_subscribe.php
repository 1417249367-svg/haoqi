<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/config/config.inc.php");
require_once (__ROOT__ . "/class/common/Site.inc.php");
require_once (__ROOT__ . "/class/common/lang.php"); //添加语言管理模块
error_reporting ( 0 );
$LangType=g("LangType",LANG_TYPE);
addLangModel2("livechat",$LangType);
function getAppValue($name = "",$defaultValue = "")
{
	global $arrSysConfig ;
	
	$name = strtolower($name);
	$value = "" ;

	if (isset($arrSysConfig[$name]))
		$value = $arrSysConfig[$name] ;

	if ($value == "")
		$value = $defaultValue ;

	return trim($value) ;

}
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?=get_lang('page_web_title')?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chorme=1">
<script type="text/javascript" src="/static/js/jquery.js"></script>
<meta name="viewport" content="width=device-width,target-densitydpi= 120,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"></head>
<body>
<wx-open-subscribe template="<?=getAppValue("weChat_subscribe_id2") ?>" id="subscribe-btn">
    <template slot="style">
    <style>
	  .subscribe-btn {
		  display: inline-block;
		  padding: 6px 12px;
		  margin-bottom: 0;
		  font-size: 14px;
		  font-weight: normal;
		  line-height: 1.428571429;
		  text-align: center;
		  white-space: nowrap;
		  vertical-align: middle;
		  cursor: pointer;
		  background-image: none;
		  border: 1px solid transparent;
		  border-radius: 4px;
		  -webkit-user-select: none;
			 -moz-user-select: none;
			  -ms-user-select: none;
			   -o-user-select: none;
				  user-select: none;
		  color: #fff;
		  background-color: #07c160;
		  width:10em;
		  height:3em;
	  }
     </style>
  </template>
     <template>
     <h1 align="center">公众平台</h1>
     <p align="center">该账号申请向你发送一条消息提醒，是否确认接收</p>
     <br>
     <br>
     <p align="center"><button class="subscribe-btn">确认接收</button></p>
  </template>
</wx-open-subscribe>    
</body></html>
<script src="https://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script type="text/javascript" src="<?=getRootPath() ?>/livechat/getjs/?ipaddress=<?=getAppValue("ipaddress")?>&op=3&typeid=<?=g("typeid") ?>&ischathistory=<?=g("ischathistory") ?>&userid=<?=g("userid") ?>&sourceurl=<?=g("sourceurl") ?>&callback_url=<?=g("callback_url") ?>&goods_image=<?=g("goods_image") ?>&goods_name=<?=g("goods_name") ?>&goods_price=<?=g("goods_price") ?>&fcname=<?=g("fcname") ?>&phone=<?=g("phone") ?>&email=<?=g("email") ?>&qq=<?=g("qq") ?>&wechat=<?=g("wechat") ?>&remarks=<?=g("remarks") ?>&othertitle=<?=g("othertitle") ?>&otherurl=<?=g("otherurl") ?>"></script>
<script>
//wx_init1();



//function wx_init1() {
//	var param = {userid:userid,redirect_uri:escape(window.location.href)};
//	var url = getAjaxUrl("livechat_kf","wxsignature") ; 
//	$.getJSON(url,param , function(result){
//			wx.config({
//			  debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//			  appId: result.appid, // 必填，公众号的唯一标识
//			  timestamp: result.timestamp, // 必填，生成签名的时间戳
//			  nonceStr: result.noncestr, // 必填，生成签名的随机串
//			  signature: result.signature,// 必填，签名
//			  jsApiList: [
//				'openLocation',
//				'getLocation'
//			  ], // 必填，需要使用的JS接口列表
//			  openTagList: ['wx-open-subscribe']
//			});
//			wx.ready(function(){
//			});
//			wx.error(function(res){
//				console.log(JSON.stringify(res));
//				// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
//			});
//	});
//}
</script>