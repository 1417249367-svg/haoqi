<?php
	require_once("include/fun.php");

    $loginName = g("loginName","admin");
    $userid = "" ;
    $rootPath1 = g("ipaddress",getRootPath1());
//	$dp = new Model("lv_chater");
//	$dp -> addParamWhere("loginname",$loginName);
//    $row = $dp-> getDetail();
//	if (count($row) == 0)
//		$row = array("userid"=>"","loginname"=>$loginName,"username"=>$loginName,"welcome"=>"") ;
//	
//	$userid =$row["userid"] ;

	ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
    <link rel="stylesheet" href="/static/js/layui/css/layui.mobile.css">
    <link rel="stylesheet" href="assets/css/kjctn.css"   />
<!--	<link rel="stylesheet" type="text/css" href="/static/js/baguetteBox/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="/static/js/baguetteBox/css/htmleaf-demo.css">
	<link rel="stylesheet" href="/static/js/baguetteBox/dist/baguetteBox.css">-->
    <script src="/static/js/layui/layui.js"></script>
<!--	<script src="/static/js/baguetteBox/dist/baguetteBox.js" async></script>-->
    <script src="/static/js/baguetteBox/js/highlight.min.js" async></script>
    <script type="text/javascript" src="assets/js/md5.js"></script>
	<script type="text/javascript" src="assets/js/socket.js?ver=150927"></script>
	<script type="text/javascript" src="assets/js/livechat_m.js"></script>
	<script type="text/javascript" src="assets/js/chat.js?ver=150927"></script>
	<script type="text/javascript" src="<?=$rootPath1 ?>/static/js/msg_reader.js?ver=150927"></script>
    <script src="<?=$rootPath1 ?>/js/fingerprint.js"></script>
    <script src="<?=$rootPath1 ?>/js/BenzAMRRecorder.min.js"></script>
    <script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/common.js' charset='utf-8'></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/client/client.js' charset='utf-8'></script>
</head>
<style type="text/css">
	.layui-layim-stars{
		white-space: nowrap;
		text-align: center;
		margin-top: 20px;
		margin-bottom: 20px;
	}

	.layui-layim-stars li{
		display: inline-block;
		color: #ADADAD;
		font-size: 40px;
	}
</style>
<body id="win">





<iframe id="frm_Upload"  name="frm_Upload" style="display:none;"></iframe>
</body>
</html>
<script type="text/javascript">

//====================================================================================
// LIVECHT 配置文件
// JC 2014-06-20
//====================================================================================


var _loginname = "<?=$loginName ?>" ;
var ipaddress = "<?=$rootPath1 ?>" ;
var SitePath = "<?=getRootPath() ?>";
var rejectType = parseInt("<?=REJECTTYPE?>");
cookieHCID1 =  ipaddress + "-Talk" ;
cookieHCID2 =  ipaddress + "-loginname" ;
var connectType = "<?=g("connecttype",1) ?>" ;
var goods_info = "<?=g("goods_info") ?>" ;
var welcome_db = "<?=g("welcome") ?>" ; 
var currWin ;
var lang_type = "<?=LANG_TYPE?>";
var typeid = "<?=g("typeid") ?>" ;
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
if(getCookie(cookieHCID2)!=""&&chater.loginname == "") setCookie(cookieHCID1,"") ;
setCookie(cookieHCID2,chater_loginname) ;
if (welcome_db != "")
	welcome = welcome_db;
if(lang_type == 'en'){
    msgTip = "Open the chat" ;
}
appPath = getAppPath();

var time = 0 ;
var is_wx=is_weixin();
if(is_wx){
	getScript("http://res.wx.qq.com/open/js/jweixin-1.4.0.js",function(){
		  //ie下防止多次执行
		  if (time == 0)
			  wx_init();
			  //setTimeout('wx_init();', 2000);
		  time = time + 1 ;
	  }) ;
}

function wx_init() {
    var param = {userid:my.userid};
	var url = getAjaxUrl("livechat_kf","wxsignature") ; 
	//var url = "http://g.rtcim.com:98/public/livechat_kf.php?op=wxsignature&source=kefu";
	//console.log(url);
    $.getJSON(url,param , function(result){
					//document.write(JSON.stringify(result));
//		if (result.status == undefined)
//		{

			wx.config({
			  debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			  appId: result.appid, // 必填，公众号的唯一标识
			  timestamp: result.timestamp, // 必填，生成签名的时间戳
			  nonceStr: result.noncestr, // 必填，生成签名的随机串
			  signature: result.signature,// 必填，签名
			  jsApiList: ['getLocation','openLocation'] // 必填，需要使用的JS接口列表
			});
			alert(JSON.stringify(result));
			wx.ready(function(){
				alert('fdg');
				// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
				wx.getLocation({
					type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
					success: function (res) {
						alert(JSON.stringify(res));
						var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
						var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
						var speed = res.speed; // 速度，以米/每秒计
						var accuracy = res.accuracy; // 位置精度
					}
				});
			});
			wx.error(function(res){
				console.log(res);
				// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
			});
//		}
    });
}

$(document).ready(function()
{ 


})



layui.config({
  version: true
}).use('mobile', function(){
  var mobile = layui.mobile
  ,layim = mobile.layim
  ,layer = mobile.layer;
  
  if(!my.userid){
	  var fp1 = new Fingerprint();
	  my.userid = fp1.get()+"<?=getValue("my_userid") ?>";
  }
	if(typeid) ConnectChat1(typeid);
	else connectChat();
//alert(getAjaxUrl("livechat_kf","GetChaterRo","id="+my.userid));
  //window.layim_config=function() {
	  layim.config({
		//上传图片接口
		uploadImage: {
		  url: uploadUrl + "?op=kefufile" //（返回的数据格式见下文）
		}
		//上传文件接口
		,uploadFile: {
		  url: uploadUrl + "?op=kefufile" //（返回的数据格式见下文）
		}
//		,tool: [{
//		  alias: 'rate'
//		  ,title: '评价'
//		  ,iconUnicode: '&#xe67b;'
//		}]
		//,brief: true
	
		//获取主面板列表信息
		,init: {
		  mine: {
			"username": "我" //我的昵称
			,"id": my.userid //我的ID
			,"status": "online"
			,"avatar": "assets/img/face.png" //我的头像
			,"sign": ""
		  }
		}  
		,isgroup: false //是否开启“群聊”
	  });
	  
	  //监听返回
//	  layim.on('back', function(){
//		postRate(); 
//		//如果你只是弹出一个会话界面（不显示主面板），那么可通过监听返回，跳转到上一页面，如：history.back();
//	  });
	  
//	  layim.on('tool(rate)', function(insert, send, obj){ //事件中的tool为固定字符，而code则为过滤器，对应的是工具别名（alias）
//
//	  }); 
  //}
  
  //创建一个会话
  window.layim_chat=function(obj) {
	  //alert(JSON.stringify(obj));
	  layim.chat(obj);
  }

  //模拟收到一条好友消息
  window.layim_getMessage=function(obj) {
	  //alert(JSON.stringify(obj));
	  layim.getMessage(obj);
  }
  
  window.layim_disabled=function() {
    var thatChat = thisChat();
    var textarea = thatChat.textarea;
	textarea.next().addClass('layui-disabled');
  }
  
  window.layim_getchatRo=function() {
	  var obj = {
		  url: getAjaxUrl("livechat_kf","GetChaterRo","myid=public&id="+my.userid) //接口地址（返回的数据格式见下文）
		  ,type: 'get' //默认get，一般可不填
		  ,data: {} //额外参数
	  }
	  layim.getchatRo(obj);
  }
  
  window.getRate=function(obj) {
    layim.getRate(obj);
  }
});


</script>


