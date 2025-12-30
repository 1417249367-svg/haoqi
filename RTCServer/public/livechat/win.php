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
<?php  require_once("include/meta.php");?>
<link  rel="stylesheet" href="assets/css/livechat.css?ver=20251216"   />
<link  rel="stylesheet" href="assets/css/kjctn.css"   />
<link rel="stylesheet" type="text/css" href="/static/js/lightbox/lightbox.css" media="screen">
<link rel="stylesheet" href="/static/js/layui/css/layui.css">
<script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=xjALWQ1fAHE5xWKueQu0w8iP"></script>
<script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak=xjALWQ1fAHE5xWKueQu0w8iP"></script>
<script type="text/javascript" src="/static/js/lightbox/lightbox.js?ver=20251216"></script>
<script type="text/javascript" src="assets/js/md5.js"></script>
<script type="text/javascript" src="assets/js/socket.js?ver=150927"></script>
<script type="text/javascript" src="assets/js/livechat.js?ver=20251216"></script>
<script type="text/javascript" src="assets/js/chat.js?ver=20251216"></script>
<script type="text/javascript" src="/static/js/layui/layui.js"></script>
<script type="text/javascript" src="<?=$rootPath1 ?>/static/js/msg_reader.js?ver=20251216"></script>
<script src="<?=$rootPath1 ?>/js/fingerprint.js"></script>
<script src="<?=$rootPath1 ?>/js/html5ImgCompress.min.js"></script>
<script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
<script type='text/javascript' src='<?=$rootPath1 ?>/js/common.js' charset='utf-8'></script>
<script type='text/javascript' src='<?=$rootPath1 ?>/js/client/client.js' charset='utf-8'></script>
<style>
html{background-color: #333;}
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
</head>
<body>
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
<!--定位弹窗-->
<script>

//====================================================================================
// LIVECHT 配置文件
// JC 2014-06-20
//====================================================================================

var invite ={switchType:<?=SWITCHTYPE?>,welcomeText:"<?=WELCOMETEXT?>",waitTime:<?=WAITTIME?>,rejectType:<?=REJECTTYPE?>,intervalTime:<?=INTERVALTIME?>};
var _loginname = "<?=$loginName ?>" ;
var ipaddress = "<?=$rootPath1 ?>" ;
var SitePath = "<?=getRootPath() ?>";
var RTC_SERVER_AGENT = "<?=RTC_SERVER_AGENT ?>";
//cookieHCID1 =  ipaddress + "-Talk" ;
cookieHCID2 =  ipaddress + "-loginname" ;
cookieHCID3 =  ipaddress + "-layer" ;
cookieHCID4 =  ipaddress + "-layer1" ;
var switchad = parseInt("<?=SWITCHAD?>") ;
meetingurl.voiceVideoType = parseInt("<?=VOICEVIDEOTYPE ?>") ;
meetingurl.url="<?=$meetingurl ?>" ;
var beatTime = parseInt("<?=BEATTIME ?>") ;
if(!beatTime) beatTime=1;
var showhistorytype = parseInt("<?=SHOWHISTORYTYPE ?>") ;
var ChatGPTType = parseInt("<?=CHATGPTTYPE ?>") ;
var ChatGPTAppid = "<?=CHATGPTAPPID ?>" ;
var ChatGPTTransferType = parseInt("<?=CHATGPTTRANSFERTYPE ?>") ;
var connectType = "<?=g("connecttype",1) ?>" ;
var goods_info = "<?=g("goods_info") ?>" ;
var welcome_db = "<?=g("welcome") ?>" ; 
var currWin ;
var lang_type = "<?=$LangType?>";
var typeid = "<?=g("typeid") ?>" ;
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
//if(getCookie(cookieHCID2)!=""&&getCookie(cookieHCID2)!="undefined"&&chater.loginname == "") setCookie(cookieHCID1,"") ;
//setCookie(cookieHCID2,chater_loginname) ;
if (welcome_db != "")
	welcome = welcome_db;
if(lang_type == 'en'){
    msgTip = "Open the chat" ;
}
var lat;
var lng;
var map;
var pt;
var mk;

$(document).ready(function()
{   

})

layui.use('layim', function(layim){
  
//  //演示自动回复
//  var autoReplay = [
//    '您好，我现在有事不在，一会再和您联系。', 
//    '你没发错吧？face[微笑] ',
//    '洗澡中，请勿打扰，偷窥请购票，个体四十，团体八折，订票电话：一般人我不告诉他！face[哈哈] ',
//    '你好，我是主人的美女秘书，有什么事就跟我说吧，等他回来我会转告他的。face[心] face[心] face[心] ',
//    'face[威武] face[威武] face[威武] face[威武] ',
//    '<（@￣︶￣@）>',
//    '你要和我说话？你真的要和我说话？你确定自己想说吗？你一定非说不可吗？那你说吧，这是自动回复。',
//    'face[黑线]  你慢慢说，别急……',
//    '(*^__^*) face[嘻嘻] ，是贤心吗？'
//  ];
  if(!my.userid){
	  var fp1 = new Fingerprint();
	  my.userid = fp1.get()+"<?=g("my_userid") ?>";
  }
  //initPage();

  if(typeid) ConnectChat1(typeid,0);
  else connectChat(0);

  //基础配置
  layim.config({

    //初始化接口
//    init: {
//      url: 'json/getList.json'
//      ,data: {}
//    }
    
    //或采用以下方式初始化接口
    
    init: {
//      mine: {
//        "username": "LayIM体验者" //我的昵称
//        ,"id": "100000123" //我的ID
//        ,"status": "online" //在线状态 online：在线、hide：隐身
//        ,"remark": "在深邃的编码世界，做一枚轻盈的纸飞机" //我的签名
//        ,"avatar": "a.jpg" //我的头像
//      }
	  mine: {
		"username": "<?=$mine_username ?>" //我的昵称
		,"id": my.userid //我的ID
		,"status": "online"
		,"avatar": "<?=$mine_avatar ?>" //我的头像
		,"remark": ""
	  }
      ,friend: []
      ,group: []
    }
    
    

    //查看群员接口
    ,members: {
      url: 'json/getMembers.json'
      ,data: {}
    }
    
    //上传图片接口
    ,uploadImage: {
      url: uploadUrl + "?op=kefufile" //（返回的数据格式见下文）
      ,type: '' //默认post
    } 
    
    //上传文件接口
    ,uploadFile: {
      url: uploadUrl + "?op=kefufile" //（返回的数据格式见下文）
      ,type: '' //默认post
    }
    
    ,isAudio: true //开启聊天工具栏音频
    ,isVideo: true //开启聊天工具栏视频
    
    //扩展工具栏
//    ,tool: [{
//      alias: 'code'
//      ,title: '代码'
//      ,icon: '&#xe64e;'
//    }]
    
    //,brief: true //是否简约模式（若开启则不显示主面板）
    
    ,title: '好奇鸟客服' //自定义主面板最小化时的标题
    //,right: '100px' //主面板相对浏览器右侧距离
    //,minRight: '90px' //聊天面板最小化时相对浏览器右侧距离
    ,initSkin: '2.jpg' //1-5 设置初始背景
    //,skin: ['aaa.jpg'] //新增皮肤
    ,isfriend: false //是否开启好友
    ,isgroup: false //是否开启群组
    //,min: true //是否始终最小化主面板，默认false
    ,notice: true //是否开启桌面消息提醒，默认false
    //,voice: false //声音提醒，默认开启，声音文件为：default.mp3
    ,copyright: true 
    //,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
    //,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
    ,chatLog: layui.cache.dir + 'css/modules/layim/html/chatlog.html' //聊天记录页面地址，若不开启，剔除该项即可
    
  });

  window.layim_chat=function(obj) {
	  layim.chat(obj);
  }
  
  window.layim_sendMessage1=function(msg) {
	  layim.sendMessage1(msg);
  }
  
  window.layim_getMessage=function(obj) {
	  //alert(JSON.stringify(obj));
	  layim.getMessage(obj);
  }
  
  window.layim_Retractmessage=function(obj) {
    layim.Retractmessage(obj);
  }
  
  window.layim_Retractallmessage=function(obj) {
    layim.Retractallmessage(obj);
  }
  
  window.layim_closeThisChat1=function() {
    layim.closeThisChat1();
  }
//  layim.chat({
//    name: '在线客服-小苍'
//    ,type: 'kefu'
//    ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.180.180.180/7f5f6861jw1e8qgp5bmzyj2050050aa8.jpg'
//    ,id: -1
//  });
//  layim.chat({
//    name: '在线客服-心心'
//    ,type: 'kefu'
//    ,avatar: 'http://tva1.sinaimg.cn/crop.219.144.555.555.180/0068iARejw8esk724mra6j30rs0rstap.jpg'
//    ,id: -2
//  });
  //layim.setChatMin();

  //监听在线状态的切换事件
  layim.on('online', function(data){
    //console.log(data);
  });
  
  //监听签名修改
  layim.on('sign', function(value){
    //console.log(value);
  });

  //监听自定义工具栏点击，以添加代码为例
  layim.on('tool(code)', function(insert){
    layer.prompt({
      title: '插入代码'
      ,formType: 2
      ,shade: 0
    }, function(text, index){
      layer.close(index);
      insert('[pre class=layui-code]' + text + '[/pre]'); //将内容插入到编辑器
    });
  });
  
  //监听layim建立就绪
  layim.on('ready', function(res){

    //console.log(res.mine);
    
//    layim.msgbox(5); //模拟消息盒子有新消息，实际使用时，一般是动态获得
//  
//    //添加好友（如果检测到该socket）
//    layim.addList({
//      type: 'group'
//      ,avatar: "http://tva3.sinaimg.cn/crop.64.106.361.361.50/7181dbb3jw8evfbtem8edj20ci0dpq3a.jpg"
//      ,groupname: 'Angular开发'
//      ,id: "12333333"
//      ,members: 0
//    });
//    layim.addList({
//      type: 'friend'
//      ,avatar: "http://tp2.sinaimg.cn/2386568184/180/40050524279/0"
//      ,username: '冲田杏梨'
//      ,groupid: 2
//      ,id: "1233333312121212"
//      ,remark: "本人冲田杏梨将结束AV女优的工作"
//    });
  //模拟收到一条好友消息
    
//    setTimeout(function(){
//      //接受消息（如果检测到该socket）
//      layim.getMessage({
//        username: "Hi"
//        ,avatar: "http://qzapp.qlogo.cn/qzapp/100280987/56ADC83E78CEC046F8DF2C5D0DD63CDE/100"
//        ,id: "10000111"
//        ,type: "friend"
//        ,content: "临时："+ new Date().getTime()
//      });
//      
//      /*layim.getMessage({
//        username: "贤心"
//        ,avatar: "http://tp1.sinaimg.cn/1571889140/180/40030060651/1"
//        ,id: "100001"
//        ,type: "friend"
//        ,content: "嗨，你好！欢迎体验LayIM。演示标记："+ new Date().getTime()
//      });*/
//      
//    }, 3000);
  });

  //监听发送消息
  layim.on('sendMessage', function(data){
    var To = data.to;
    //console.log(data);
    
//    if(To.type === 'friend'){
//      layim.setChatStatus('<span style="color:#FF5722;">对方正在输入。。。</span>');
//    }
	var message = {
	  msg_id: data.mine.msg_id
      ,username: data.mine.username
      ,avatar: data.mine.avatar
      ,id: data.to.id
      ,type: data.to.type
      ,content: data.mine.content
      //,timestamp: time
      ,mine: true
    };
	m_sendMsg(message);
    
//    //演示自动回复
//    setTimeout(function(){
//      var obj = {};
//      if(To.type === 'group'){
//        obj = {
//          username: '模拟群员'+(Math.random()*100|0)
//          ,avatar: layui.cache.dir + 'images/face/'+ (Math.random()*72|0) + '.gif'
//          ,id: To.id
//          ,type: To.type
//          ,content: autoReplay[Math.random()*9|0]
//        }
//      } else {
//        obj = {
//          username: To.name
//          ,avatar: To.avatar
//          ,id: To.id
//          ,type: To.type
//          ,content: autoReplay[Math.random()*9|0]
//        }
//        layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
//      }
//      layim.getMessage(obj);
//    }, 1000);
  });

//  //监听查看群员
//  layim.on('members', function(data){
//    //console.log(data);
//  });
  
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
      //模拟标注好友状态
      //layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
    }
//	else if(type === 'group'){
//      //模拟系统消息
//      layim.getMessage({
//        system: true
//        ,id: res.data.id
//        ,type: "group"
//        ,content: '模拟群员'+(Math.random()*100|0) + '加入群聊'
//      });
//    }
  });
  
  

});
</script>
</body>
</html>
