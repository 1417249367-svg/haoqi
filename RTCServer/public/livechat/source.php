<?php
	require_once("include/fun.php");

    $loginName = g("loginName","admin");
    $userid = "" ;
    $rootPath1 = g("ipaddress",getRootPath1());
	
	$launchurl = $_SERVER['HTTP_REFERER'];
	$arr_item = parse_url($launchurl);
	
	$parentDomain = $arr_item["scheme"]."://".$arr_item["host"].":".$arr_item["port"];

	ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link  rel="stylesheet" href="assets/css/livechat.css?ver=20251216"   />
	<link  rel="stylesheet" href="assets/css/kjctn.css"   />
    <link rel="stylesheet" type="text/css" href="/static/js/lightbox/lightbox.css" media="screen">
	<script type="text/javascript" src="/static/js/lightbox/lightbox.js?ver=20251216"></script>
	<script type="text/javascript" src="assets/js/socket.js?ver=150927"></script>
	<script type="text/javascript" src="assets/js/livechat1.js?ver=20251216"></script>
	<script type="text/javascript" src="assets/js/chat.js?ver=20251216"></script>
	<script type="text/javascript" src="<?=$rootPath1 ?>/static/js/msg_reader.js?ver=20251216"></script>
    <script src="<?=$rootPath1 ?>/js/fingerprint.js"></script>
    <script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/common.js' charset='utf-8'></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/client/client.js' charset='utf-8'></script>
</head>
<body style="overflow:hidden;">





<iframe id="frm_Upload"  name="frm_Upload" style="display:none;"></iframe>
<div id="trace" style="position:absolute ; z-index:10000"></div>
</body>
</html>
<script type="text/javascript">

//====================================================================================
// LIVECHT 配置文件
// JC 2014-06-20
//====================================================================================
var ismobile = parseInt("<?=ismobile() ?>") ;
var parentDomain = "<?=$parentDomain ?>" ;
var _loginname = "<?=$loginName ?>" ;
var ipaddress = "<?=$rootPath1 ?>" ;
var SitePath = "<?=getRootPath() ?>";
//cookieHCID1 =  ipaddress + "-Talk" ;
cookieHCID2 =  ipaddress + "-loginname" ;
cookieHCID3 =  0 ;
cookieHCID4 =  0 ;
var connectType = "<?=g("connecttype",1) ?>" ;
var goods_info = "<?=g("goods_info") ?>" ;
var welcome_db = "<?=g("welcome") ?>" ; 
var sourceurl = "<?=g("sourceurl") ?>" ; 
var launchurl = "<?=$launchurl ?>" ; 
if(sourceurl==launchurl) sourceurl = "-" ; 
var isweb = "<?=g("isweb") ?>" ; 
var isend = "<?=g("isend") ?>" ; 
var currWin ;
var lang_type = "<?=$LangType?>";
chater.typeid = "<?=g("typeid") ?>";
chater.loginname = "<?=g("loginname") ?>";
my.userid = "<?=g("userid") ?>" ;
chater.username = "";
chater_loginname = chater.loginname;
var username = "<?=g("username") ?>" ;
var phone = "<?=g("phone") ?>" ;
var email = "<?=g("email") ?>" ;
var qq = "<?=g("qq") ?>" ;
var wechat = "<?=g("wechat") ?>" ;
var remarks = "<?=g("remarks") ?>" ;
var othertitle = "<?=g("othertitle") ?>" ;
var otherurl = "<?=g("otherurl") ?>" ;
//if(getCookie(cookieHCID2)!=""&&getCookie(cookieHCID2)!="undefined"&&chater.loginname == "") setCookie(cookieHCID1,"") ;
//setCookie(cookieHCID2,chater_loginname) ;
//setCookie(cookieHCID3,0) ;
//setCookie(cookieHCID4,0) ;
if (welcome_db != "")
	welcome = welcome_db;
if(lang_type == 'en'){
    msgTip = "Open the chat" ;
}
$(document).ready(function()
{   
	if(!my.userid){
		var fp1 = new Fingerprint();
		my.userid = fp1.get()+"<?=g("my_userid") ?>";
	}
	connectChat();
})


</script>


