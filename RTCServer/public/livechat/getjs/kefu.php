<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/class/fun.php");
require_once (__ROOT__ . "/class/lv/LiveChat.class.php") ;
require_once (__ROOT__ . "/class/common/visitorInfo.class.php");
//error_reporting ( 0 );
$LangType=g("LangType",LANG_TYPE);
addLangModel2("livechat",$LangType);
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

if(g("typeid")){
	$livechat = new LiveChat ();
	$data = $livechat->GetChaterRoDetail (g ("typeid"));
	if (count($data)) $ishow=1;
	else $ishow=0;
}else{
	if(g ("username")){
		$livechat = new LiveChat ();
		$data = $livechat->GetChaterDetail (g ("username"));
		if (count($data)) $ishow=1;
		else $ishow=0;
	}else $ishow=1;
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
</body></html>
<?php if ($ishow){?>
<script type="text/javascript" src="<?=getRootPath() ?>/livechat/getjs/?ipaddress=<?=getAppValue("ipaddress")?>&op=2&typeid=<?=g("typeid") ?>&LangType=<?=$LangType?>&ischathistory=<?=g("ischathistory") ?>&userid=<?=g("userid") ?>&sourceurl=<?=g("sourceurl") ?>&callback_url=<?=g("callback_url") ?>&goods_image=<?=g("goods_image") ?>&goods_name=<?=g("goods_name") ?>&goods_price=<?=g("goods_price") ?>&fcname=<?=g("fcname") ?>&phone=<?=g("phone") ?>&email=<?=g("email") ?>&qq=<?=g("qq") ?>&wechat=<?=g("wechat") ?>&remarks=<?=g("remarks") ?>&othertitle=<?=g("othertitle") ?>&otherurl=<?=g("otherurl") ?>"></script>
<?php }else{
if(SWITCHDOMAINTYPE){
	$config = new SYSConfig();
	$params = array();
	$params[] = $config->create_param("Jump_Domain",0,"LivechatConfig");
	$config -> setConfig($params);
}
//$str ='您使用的触点客服已到期，请打开<a href="http://kk.qiyeim.com" target="_blank">kk.qiyeim.com</a>，联系客服人员续费';
//echo $str;
//	$visitor = new visitorInfo();
//	if($visitor->getBrowser()=='qq'){
//		 $currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//		 $currentPageUrl = phpescape(str_replace("livechat/getjs/","",$currentPageUrl)) ;
//		 header("Location:https://c.pc.qq.com/middlem.html?pfurl=".$currentPageUrl."&pfuin=1417249367&pfto=qq.msg&type=0&gjlevel=15&gjsublevel=2804&iscontinue=0");
//	}else header("Location:TestPage184.htm");
}?>