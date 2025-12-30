<?php
	require_once("include/fun.php");
	require_once('../class/lv/LiveChat.class.php') ;
	require_once('../class/common/visitorInfo.class.php') ;
    $loginName = g("loginName","admin");
    $userid = "" ;
    $rootPath1 = g("ipaddress",getRootPath1());
	
	$livechat = new LiveChat ();
	
	$user ["userid"] = g ( "userid");
	$user ["username"] = g ( "username");
	$user ["phone"] = g ( "phone" );
	$user ["email"] = g ( "email" );
	$user ["qq"] = g ( "qq" );
	$user ["wechat"] = g ( "wechat" );
	$user ["remarks"] = g ( "remarks" );
	$user ["othertitle"] = g ( "othertitle" );
	$user ["otherurl"] = g ( "otherurl" );
	$user = $livechat->GetUser ( $user );
	$mine_username=get_lang("chat_my");
	$mine_avatar="assets/img/face.png";
	if($user ["isweixin"]==1){
		$mine_username=$user ["username"];
		$mine_avatar=$user ["headimgurl"];
	}
	
	$dp = new Model("lv_chater");
	$dp -> addParamWhere("loginname",g("loginName"));
    $row = $dp-> getDetail();
	if (count($row))
		$username =$row["username"] ;
	
	$dp = new Model("Plug");
	$dp -> addParamWhere("Plug_Enabled",1);
	$dp -> addParamWhere("Plug_Name","Meeting");
    $row = $dp-> getDetail();
	if (count($row))
		$meetingurl =$row["plug_param"] ;
		
	ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta2.php");?>
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
	.layui-layim-stars span{position: relative; margin: 0 14px; display: inline-block; *display:inline; *zoom:1; vertical-align:top; font-size: 28px; cursor: pointer;}
    .musk {
    position: fixed;
    top: 0;
    left: 0;
	display: none;
    z-index: 99999999;
    background-color: #000;
    opacity: 0.8;
    width: 100%;
    height: 100%;
	}
	.map_box {
		position: fixed;
		display: none;
		z-index: 999999999;
		width: 80%;
		height: 70%;
		background-color: #fff;
		left: 10%;
		top: 10%;
		border-radius: 10px;
		text-align: center;
	}
</style>
<body id="win">
		<!--定位弹窗-->
		<div class="musk"></div>
		<div class="map_box" style="">
			<div style="display:flex">
				<input id="search" name="search" type="text" class="layui-input" style="width: 60%;border: 1px solid #ccc;line-height: 32px;height:32px;margin-left: 5%;margin-top:1.5rem" placeholder="请输入地址">
				<input type="button" value="搜索位置" class="layui-btn layui-btn-normal send-btn" style="line-height:32px;height:32px;margin-left:5%;margin-top:1.5rem;background-color: #1E9FFF;font-size: 14px; width: 90px;" onclick='searchNearby(event);'/>
			</div>
			<div id="allmap" style="width:90%;height:70%;margin-left:5%;margin-top:1rem"></div>
			<input type="button" value="确认发送" class="layui-btn layui-btn-normal send-btn" style="line-height:32px;height:32px;margin-top:1rem;background-color: #1E9FFF;font-size: 14px; width: 90px;" onclick='sendPosition(event);'/>
			<input type="button" value="取消发送" onClick="$('.musk').hide();$('.map_box').hide()" class="layui-btn layui-btn-normal layui-btn-danger" style="line-height:32px;height:32px;margin-top:1rem" />
		</div>
<!--		<input type="hidden" id="lat" value="" />
		<input type="hidden" id="lng" value="" />-->
		
     <!--定位弹窗-->




<iframe id="frm_Upload"  name="frm_Upload" style="display:none;"></iframe>
</body>
</html>
<script type="text/javascript">

//====================================================================================
// LIVECHT 配置文件
// JC 2014-06-20
//====================================================================================

var invite ={switchType:<?=SWITCHTYPE?>,welcomeText:"<?=WELCOMETEXT?>",waitTime:<?=WAITTIME?>,rejectType:<?=REJECTTYPE?>,intervalTime:<?=INTERVALTIME?>,chaterMode:<?=CHATERMODE?>};
var _loginname = "<?=$loginName ?>" ;
var ipaddress = "<?=$rootPath1 ?>" ;
var SitePath = "<?=getRootPath() ?>";
var rejectType = parseInt("<?=REJECTTYPE?>");
var ischatlog = 0;
//cookieHCID1 =  ipaddress + "-Talk" ;
cookieHCID2 =  ipaddress + "-loginname" ;
cookieHCID3 =  ipaddress + "-layer" ;
cookieHCID4 =  ipaddress + "-layer1" ;
meetingurl.voiceVideoType = parseInt("<?=VOICEVIDEOTYPE ?>") ;
meetingurl.url="<?=$meetingurl ?>" ;
var beatTime = parseInt("<?=BEATTIME ?>") ;
if(!beatTime) beatTime=1;
var ChatGPTType = parseInt("<?=CHATGPTTYPE ?>") ;
var ChatGPTAppid = "<?=CHATGPTAPPID ?>" ;
var ChatGPTTransferType = parseInt("<?=CHATGPTTRANSFERTYPE ?>") ;
var connectType = "<?=g("connecttype",1) ?>" ;
var goods_info = "<?=g("goods_info") ?>" ;
var welcome_db = "<?=g("welcome") ?>" ; 
var currWin ;
var lang_type = "<?=$LangType?>";
var typeid = "<?=g("typeid") ?>" ;
var ischathistory = "<?=g("ischathistory") ?>" ;
chater.loginname = "<?=g("loginname") ?>";
my.userid = "<?=g("userid") ?>" ;
chater.username = "<?=$username?>";
chater_loginname = chater.loginname;
var username = "<?=g("username") ?>" ;
var phone = "<?=g("phone") ?>" ;
var email = "<?=g("email") ?>" ;
var qq = "<?=g("qq") ?>" ;
var wechat = "<?=g("wechat") ?>" ;
var remarks = "<?=g("remarks") ?>" ;
var othertitle = "<?=g("othertitle") ?>" ;
var otherurl = "<?=g("otherurl") ?>" ;
var mobileback = true ;
var switchDomainType = "<?=SWITCHDOMAINTYPE ?>" ;
var isChatlog = 0 ;
var switchwechat = parseInt("<?=SWITCHWECHAT ?>") ;
//if(getCookie(cookieHCID2)!=""&&getCookie(cookieHCID2)!="undefined"&&chater.loginname == "") setCookie(cookieHCID1,"") ;
//setCookie(cookieHCID2,chater_loginname) ;
if (welcome_db != "")
	welcome = welcome_db;
if(lang_type == 'en'){
    msgTip = "Open the chat" ;
}
appPath = getAppPath();

//var time = 0 ;
isweixin=is_weixin();
//定位开始
var lat;
var lng;
var map;
var pt;
var mk;

	//定位结束
//function logout(closeRole)
//{
//	if (closeRole == 0) return ;
//	window.parent.postMessage({
//			  cmd: 'end',
//			  params: ''
//			}, '*');
//}

//
//function wx_init() {
//var vConsole = new VConsole();
//  console.log('Hello world');
//    var param = {userid:my.userid};
//	var url = getAjaxUrl("livechat_kf","wxsignature") ; 
//	//var url = "http://g.rtcim.com:98/public/livechat_kf.php?op=wxsignature&source=kefu";
//	//console.log(url);
//    $.getJSON(url,param , function(result){
//					//document.write(JSON.stringify(result));
////		if (result.status == undefined)
////		{
//
//			wx.config({
//			  debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//			  appId: result.appid, // 必填，公众号的唯一标识
//			  timestamp: result.timestamp, // 必填，生成签名的时间戳
//			  nonceStr: result.noncestr, // 必填，生成签名的随机串
//			  signature: result.signature,// 必填，签名
//			  jsApiList: [
//				'openLocation',
//				'getLocation'
//			  ]
//			});
//			//alert(JSON.stringify(result));
//			wx.ready(function(){
//				alert('fdg');
//				// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
//				wx.getLocation({
//					type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
//					success: function (res) {
//						alert(JSON.stringify(res));
//						var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
//						var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
//						var speed = res.speed; // 速度，以米/每秒计
//						var accuracy = res.accuracy; // 位置精度
//					}
//				});
//			});
//			wx.error(function(res){
//				alert(JSON.stringify(res));
//				// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
//			});
////		}
//    });
//}
$(document).ready(function()
{ 


})

layui.config({
  version: true
}).use(['mobile','form','layer'], function(){
  var mobile = layui.mobile
  ,layim = mobile.layim
  ,layer = mobile.layer
  ,form = layui.form
  ,layerpic = layui.layer;
  
  if(!my.userid){
	  var fp1 = new Fingerprint();
	  my.userid = fp1.get()+"<?=g("my_userid") ?>";
  }

    if(ischathistory){
		initChat() ;
	}else{
		if(typeid) ConnectChat1(typeid,0);
		else connectChat(0);
	}

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
			"username": "<?=$mine_username ?>" //我的昵称
			,"id": my.userid //我的ID
			,"status": "online"
			,"avatar": "<?=$mine_avatar ?>" //我的头像
			,"sign": ""
		  }
		}  
		,isgroup: false //是否开启“群聊”
	  });
	  
	  //监听查看更多记录
	  layim.on('chatlog', function(data, ul){
		//console.log(data);
		ischatlog=1;
		if(chater.lv_chater_ro_to_type) var url="/admin/report/groupkefuchat_list1.html?typeid=" + chater.loginname;
		else var url="/admin/report/livechat_list3.html?user1="+chater.loginname+"&user2="+my.userid+"&loginname=" + chater.loginname;
		//console.log(url);
		layim.panel({
		  title: '与'+ data.name +' 的聊天记录' //标题
		  ,tpl: '<iframe id="frame_main1" name="frame_main1" width="100%" height="100%" src="{{d.data.test}}" frameborder="0" ></iframe>' //模版
		  ,data: { //数据
			test: url
		  }
		});
	  });
	  
	  //监听聊天窗口的切换
	  layim.on('chatChange', function(res){
		var type = res.data.type;
		//console.log('chatChange:'+JSON.stringify(res.data));
		
		chater.loginname = res.data.id;
		if(res.data.username) chater.username = res.data.username;
		chater.lv_chater_ro_to_type = res.data.lv_chater_ro_to_type;
		chater.pic = res.data.avatar;

		if(parseInt(res.data.lv_chater_ro_to_type)==1) ConnectChat1(res.data.pid,1);
		else{
			 //chater.loginname = res.data.id;
			 connectChat(1);
		}
			
		if(type === 'friend'){

		}
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
	 //setTimeout(function(){
//		var chatobj = {
//		id: 'zhoulin'
//		,name: 'unknown1'
//		,type: 'kefu' //friend、group等字符，如果是group，则创建的是群聊
//		,avatar: "assets/img/face.png"
//		}
//		layim_chat(chatobj);
//	 }, 1000);
  //创建一个会话
  window.layim_chat=function(obj) {
	  //alert(JSON.stringify(obj));
//	  if(ischathistory){
//		  setTimeout(function(){
//			  layim.getchatHistory(obj);
//		  }, 1000);
//	  }else 
	  layim.chat(obj);
  }
  
  window.layim_sendMessage1=function(msg) {
	  layim.sendMessage1(msg);
  }
  //模拟收到一条好友消息
  window.layim_getMessage=function(obj) {
	  //alert(JSON.stringify(obj));
	  layim.getMessage(obj);
  }
  
  window.layim_sysMessage=function(obj) {
	  layim.sysMessage(obj);
  }
  
  window.layim_disabled=function() {
    var thatChat = thisChat();
    var textarea = thatChat.textarea;
	textarea.next().addClass('layui-disabled');
  }
  
  window.layim_getchatRo=function(obj) {
	  layim.getchatRo(obj);
  }
  
  window.getRate=function(obj) {
    layim.getRate(obj);
  }
  
  window.layim_Retractmessage=function(obj) {
    layim.Retractmessage(obj);
  }
  
  window.layim_replacemessage=function(obj) {
    layim.replacemessage(obj);
  }
  
  window.layim_Retractallmessage=function(obj) {
    layim.Retractallmessage(obj);
  }
  
  window.layim_panel=function(obj) {
	layim.panel({
	  title: obj.title //标题
	  ,tpl: '<iframe id="frame_main1" name="frame_main1" width="100%" height="100%" src="{{d.data.test}}" frameborder="0" ></iframe>' //模版
	  ,data: { //数据
		test: obj.url
	  }
	});
  }
  
  window.layim_photos=function(obj) {
	  
	var src = obj.src;
	//layer.close(popchat.photosIndex);
	layerpic.photos({
	  photos: {
		data: [{
		  "alt": "大图模式",
		  "src": src
		}]
	  }
	  ,shade: 0.01
	  ,closeBtn: 2
	  ,anim: 0
	  ,resize: false
	  ,success: function(layero, index){
		 //popchat.photosIndex = index;
	  }
	});
	
//	layerpic.photos({
//	  //类选择器  选择图片的父容器	  
//	  photos: '.layim-chat-main ul'
//	  ,full:true
//	  ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
//	}); 
  }
});


</script>


