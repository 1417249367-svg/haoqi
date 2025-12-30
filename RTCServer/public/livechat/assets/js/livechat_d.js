var lang = "cn" ;
var UDCAPTURE_SAVEFILE = "/public/livechat_kf.html?op=uploadscreenhot"; //后台保存图片的文件路径,aspx可以换成php或jsp
var uploadUrl = "/public/upload.html";
var defaultFace = "assets/img/default.png" ;
var clientFace = "assets/img/face.png" ;
var appPath = "" ;
var welcome = langs.lv_welcome ;
var chater_loginname = "";
var pagesize = 10 ;
var lastTypeID = 0;
var connectType = 1 ;  // 1 直接推送  2 应答推送
var freeTime = 0 ;    //几秒没有响应则自动关闭   0 not timer
var waitTime = 10 ;   
var acksTime = 15 ;  
var isShowHistory = true ;  
var isSaveCookie = false ; 
var asideUrl = "aside_vister.html" ;
var msgTip = "打开交谈对话框" ;

var ArrMsg=new Array();
var my = {userid:"",loginname:"",jobtitle:"",deptinfo:"",phone:"",mobile:"",email:"",pic:clientFace,username:""} ;
var chater = {loginname:"",username:"",deptname:"",jobtitle:"",email:"",phone:"",mobile:"",pic:defaultFace,lv_chater_ro_to_type:0,issilence:0,connectType:1,isConnected:0};
var meetingurl = {voiceVideoType:0,url:"",point:0,x:"",y:""} ;
var chatId = "" ;
var isConnected = false ;
var isPostRate = false ;
var isPostClose = false ;
var isPostHide = false ;
var cookieHCID ;
var cookieHCID1;
var cookieHCID2;
var cookieHCID3;
var cookieHCID4;
var cookieHCID5=0;
var free_timer,wait_timer,acks_timer,getLeaveMesseng_timer ;
var lastWriteTime ;
var appPath = "" ;

var ATTACH_VISITER_RECV = 1 ;
var ATTACH_VISITER_SEND = 2 ;
var CONNECT_TYPE_ALLOW = 1 ;
var CONNECT_TYPE_REQUEST = 2 ;

window.addEventListener("message",function(obj){
    var data = obj.data;
	switch (data.cmd) {
	case 'postRate':
	  postRate();
	  break;
	}
});

//function formatContainer(_container)
//{
//	$(document).click(function(e){
//		$(".popu").hide();
//	})
//	
//	if (_container == undefined)
//		_container = $("body");
//		
//
//		
//	//格式化下拉菜单
//	$(".btn-toggle",_container).click(function(e){
//		$(this).siblings().toggle();
//		e.stopPropagation();
//	})
//	$(".popu-stop",_container).click(function(e){
//		e.stopPropagation();
//	})
//	
//	$(".inputfile1",_container).on('change', function (e) {
//	  var
//		i = 0,
//		files = e.target.files,
//		len = files.length,
//		notSupport = false;
//	
//		// 循环多张图片，需要for循环和notSupport变量支持（检测）
//		for (; i < len; i++) {
//			if (files[i].type.indexOf("image") == 0&&files[i].size > 200 * 1024) {
//				if (!notSupport) {
//				  (function(i) {
//					new html5ImgCompress(files[i], {
//					  before: function(file) {
//						console.log('多张: ' + i + ' 压缩前...');
//					  },
//					  done: function (file, base64) { // 这里是异步回调，done中i的顺序不能保证
//						console.log('多张: ' + i + ' 压缩成功...');
//						var bl = convertBase64UrlToBlob(base64);
//						uploadImg(bl,files[i].name);
//					  },
//					  fail: function(file) {
//						console.log('多张: ' + i + ' 压缩失败...');
//					  },
//					  complete: function(file) {
//						console.log('多张: ' + i + ' 压缩完成...');
//					  },
//					  notSupport: function(file) {
//						notSupport = true;
//						console.log('浏览器不支持！');
//					  }
//					});
//				  })(i);
//				}
//			}else{
//				uploadImg(files[i],files[i].name);
//			}
//		}
//	})
//
//    $("[action-type]",_container).click(function () {
//        var cmd = $(this).attr("action-type") + "(" + $(this).attr("action-data") + ")" ;
//        eval(cmd);
//    }); 
//	
//    $(".messagebox",_container).keydown(function(event){
//        if (event.keyCode == 13)
//        {
//            sendMsg(); 
//            return false ;
//        }
//		event.stopPropagation();
//    })
//	
//	document.getElementById('messagebox').onpaste = function () {
//		if (event.clipboardData && event.clipboardData.items) {
//			var imageContent = event.clipboardData.getData('image/png');
//			var ele = event.clipboardData.items;
//			for (var i = 0; i < ele.length; ++i) {
//				//粘贴图片
//				if (ele[i].kind == 'file' && ele[i].type.indexOf('image/') !== -1) {
//					var blob = ele[i].getAsFile();
//					window.URL = window.URL || window.webkitURL;
//					var blobUrl = window.URL.createObjectURL(blob);
//					uploadImg(blob,"imgpaste.png");
//					return false; 
//				} 
//				else{
//					//alert('没有图片');
//				}
//			}
//		}
//		else {
//			//alert('不支持的浏览器');
//		}
//		//paste_img(event); 
//		//return false; 
//	};
//	
//    $("#history a",_container).click(function () {
//        history(2);
//		//update20();
//    }); 
//	
//	$(".chat-record",_container).scroll(function(){
//       var $this =$(this);
//	   var scrollTop = $(this).scrollTop();;
//	   //alert(scrollTop);
//	   if(scrollTop==0){
//		  history(2);
//		  //update20();
//	   }
//	});
//}
// 
//
//
////====================================================================================
////UI
////====================================================================================
//function initPage()
//{
//	appPath = getAppPath();
//
//	//size
//    var abs_height = getInt($(".topbar").height()) + 3 ;
//	$(".chat-record").attr("abs_height",abs_height + 90) ;
//    $(".aside").attr("abs_height",abs_height) ;
//	resize();
//	window.onresize = function(e){
//		resize();
//	}
//	
////	//环境检测
////    var fls=flashChecker();
////    var s="";
////    if(fls.f == false)
////    {
////    	myAlert(langs.valid_flash_install) ;
////        return ;
////    }
//	
//	//$("#win").attr("loginname",chater.loginname);
//	currWin= $("#win");
//	
//	
//	
//	//emots
//    var html = "" ;
//    for(var i=0;i<135;i++)
//        html += '<a href="###" onclick="insertEmote(' + i + ')"><img class="icon22" src="/Data/Expression/default/' + i + '.gif"></a>';
//	html += "<div class='clear'></div>" ;
//    $(".popu-emote").html(html) ;
// 
//    formatContainer();
//}


function startFreeTimer()
{
	if (freeTime == 0)
		return ;
		
    var d = new Date() ;
    var s = (d - lastWriteTime) / 1000 ;
    if (s > freeTime)
    {
        if (isConnected)
            printTip(langs.lv_connect_timeout,1) ;
        window.clearInterval(free_timer) ;
        closeChat(0) ;
    }
	//document.title = s + ":" + freeTime ;
}





//function postRate()
//{
//    //连接过，再断开也可以评价
//	isPostClose = true;
//    if (chatId == "")
//    {
//    	hideRate();
//        return false ;
//    }
//
//        
//    if (isPostRate||isPostHide)
//    {
//    	hideRate();
//        return false ;
//    }
//
//    $(".popu").not($(".popu-rate")).hide();
//    $(".popu-rate").toggle();
//}
//
//function postRate1()
//{
//    //连接过，再断开也可以评价
//	isPostHide = true;
//    if (chatId == "")
//    {
//        return false ;
//    }
//
//        
//    if (isPostRate)
//    {
//        return false ;
//    }
//    $(".popu").not($(".popu-rate")).hide();
//    $(".popu-rate").toggle();
//}
//
//
//
//
//function sendRate()
//{
//    if (isPostRate)
//    {
//    	myAlert(langs.lv_rate_error);
//		hideRate();
//        return false ;
//    }
//	var rate = getRadioValue("rate") ;
//    var note = $("#ratenote").val() ;
//    var param = {chatId:chatId,rate:rate,note:escape(note)};
//    var url = getAjaxUrl("livechat_kf","PostRate") ;
//	//document.write(url+JSON.stringify(param));
//    $.getJSON(url,param, function(result){
//        if (isConnected)
//            sendMsg(langs.lv_rate_msg.replace("{Rate}",get_rate(param.rate)).replace("{Note}",note)  ,false) ;
//        myAlert(langs.lv_rate_success);
//        isPostRate = true ;
//        hideRate();
//    }); 
//}

//function hideRate()
//{
//	$('.popu-rate').hide();
//	if(isPostClose){
////		var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
////		parent.layer.close(index);
//		window.parent.postMessage({
//				  cmd: 'endpc',
//				  params: ''
//				}, '*');
//	}
//	if(isPostHide) $(".chat-toolbar").css("visibility","hidden");
//}
//  
//function get_rate(status)
//{
//	switch(parseInt(status))
//	{
//		case 1:
//			return langs.chart_rate_unit1 ;
//		case 2:
//			return langs.chart_rate_unit2 ;
//		case 3:
//			return langs.chart_rate_unit3 ;
//		case 4:
//			return langs.chart_rate_unit4 ;
//		case 5:
//			return langs.chart_rate_unit5 ;
//		default:
//			return langs.chart_rate_unit0 ;
//	}
//}
//====================================================================================
//History  
//cookie["userid"] 存放所有chatid
//cookie["chatid"] 存放当前chat的内容
//====================================================================================
//function saveChatId()
//{
//	if (chatId == "")
//        return ;
//
//    var chats = getCookie(cookieHCID) ;
//    if (chats == "")
//        chats = chatId ;
//    else 
//        chats = chats + "," + chatId ;
//    setCookie(cookieHCID,chats) ;
//	setCookie(cookieHCID1,chatId) ;
//}
//
//
//
//function saveHistory()
//{
//    if (chatId == "")
//        return ;
//    
//    var content = $("#" + chatId).html() ;
//    if (isSaveCookie)
//        setCookie(chatId,content ,9999) ;
//
//   
//    var param = {chatId:chatId,content:  escape(content)};
//    var url = getAjaxUrl("livechat_kf","SaveHistory") ;
//    $.post(url,param , function(result){
//    }); 
//}
//
//
//
//function getHistory()
//{
//    var html = "" ;
//    var chats = getCookie(cookieHCID) ;
//    if (chats == "")
//        return ;
//    var arr = chats.split(",");
//    for(var i=0;i<arr.length;i++)
//    {
//        var s = arr[i]; 
//        if ((s == chatId) || (s == ""))
//            continue ;
//        var c = getCookie(s) ;
//
//        if (c != "")
//        {
//            html += "<div id='" + s + "' class='chat chat-history'>" + c + "</div>"
//        }
//    }
//
//    return html ;
//}

function getAcks()
{
	var param = {point:0,label:"messengkefu_acks",myid:my.userid,ispage:1};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			for(var i=0;i<msg.length;i++){
				$("#IsReceipt"+msg[i].msg_id).show();
//				$("#IsReceipt"+msg[i].msg_id).removeClass("kl_text5a");
//				$("#IsReceipt"+msg[i].msg_id).addClass("kl_text5b");
//				$("#IsReceipt"+msg[i].msg_id).html(langs.lv_chat_isread) ;
			}
		}
    }); 
}

function getClotAcks()
{
	var param = {point:0,label:"messengkefuclot_acks",myid:my.userid,"Msg_IDs4":ArrMsg[10],ispage:1};
    var url = getAjaxUrl("msg","list") ; 
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			ArrMsg[10] = "";
		}
    }); 
}

//function history(type)
//{
//	if(showhistorytype) return ;
//	if(chater.lv_chater_ro_to_type){
//		clothistory(type);
//		return ;
//	}
//	var param = {point:0,label:"messengkefu_history",myid:my.userid,youid:chater.loginname,lastTypeID:lastTypeID,isclient:1,ispage:1,pagesize:pagesize};
//    var url = getAjaxUrl("msg","list") ; 
//	//document.write(url+JSON.stringify(param));
//    $.getJSON(url,param , function(result){
//		if (result.status == undefined)
//		{
//			var msg = result.rows ;
//			for(var i=0;i<msg.length;i++){
//				lastTypeID=parseInt(msg[i].typeid);
//				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
//				else var To_Type = parseInt(msg[i].to_type)+1;
//				printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,2,msg[i].to_date);
//			}
//			if(msg.length<pagesize) $("#history").hide();
//			if(type==1) update10();
//			else update20();
//		}
//    }); 
//}
//
//function clothistory(type)
//{
//	if(showhistorytype) return ;
//	var param = {point:0,label:"messengkefuclot_history",myid:my.userid,youid:chater.loginname,lastTypeID:lastTypeID,isclient:1,ispage:1,pagesize:pagesize};
//    var url = getAjaxUrl("msg","list") ; 
//	//document.write(url+JSON.stringify(param));
//    $.getJSON(url,param , function(result){
//		if (result.status == undefined)
//		{
//			var msg = result.rows ;
//			for(var i=0;i<msg.length;i++){
//				lastTypeID=parseInt(msg[i].typeid);
//				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
//				else var To_Type = parseInt(msg[i].to_type)+1;
//				printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,2,msg[i].to_date);
//			}
//			if(msg.length<pagesize) $("#history").hide();
//			if(type==1) update10();
//			else update20();
//		}
//    }); 
//}
//====================================================================================
//EVENT
//====================================================================================
function getLeaveMesseng2()
{
	var param = {point:0,label:"messengkefu",myid:my.userid,chater:chater.loginname,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			if(msg.length>0){
				//msg_notification('您有新的消息');
					window.parent.postMessage({
							  cmd: 'restore',
							  params: ''
							}, '*');
			}
			for(var i=0;i<msg.length;i++){
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].myid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
			}
			//if(msg.length>0) update10();
		}
    }); 
 
}
//====================================================================================
//EVENT
//====================================================================================
function getLeaveMesseng()
{
	if(__uuids.indexOf(chater.loginname) == -1) var ispush=1;
	else var ispush=0;
	var param = {point:0,label:"messengkefu",myid:my.userid,chater:chater.loginname,ispush:ispush,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			for(var i=0;i<msg.length;i++){
				if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].myid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
			}
//			printMsg(0,langs.lv_chat_system,3,langs.lv_chat_history,0,2);
//			history(1);
			acks_timer = window.setInterval(getAcks,1000 * acksTime * beatTime) ;
			getLeaveMesseng_timer = window.setInterval(getLeaveMesseng2,5000 * beatTime) ;
		}
    }); 
 
}

function getLeaveClotMesseng2()
{
	var param = {point:0,label:"messengkefuclot",myid:my.userid,chater:chater.loginname,"Msg_IDs4":ArrMsg[10],ispage:0};
    var url = getAjaxUrl("msg","list") ; 
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows2 ;
//			if(msg.length>0){
//				msg_notification('您有新的消息');
//			}
			for(var i=0;i<msg.length;i++){
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				ArrMsg[10]+=To_Type+"_"+msg[i].msg_id+",";
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].clotid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:1,pid:msg[i].pid,typename:msg[i].typename};
				printMsg(obj);
			}
			//if(msg.length>0) update10();
		}
    }); 
 
}

function getLeaveClotMesseng()
{
	if(__uuids.indexOf(chater.loginname) == -1) var ispush=1;
	else var ispush=0;
	var param = {point:0,label:"messengkefuclot",myid:my.userid,chater:chater.loginname,ispush:ispush,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			ArrMsg[10] = "";
			var msg = result.rows2 ;
			for(var i=0;i<msg.length;i++){
				if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				ArrMsg[10]+=To_Type+"_"+msg[i].msg_id+",";
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].clotid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:1,pid:msg[i].pid,typename:msg[i].typename};
				printMsg(obj);
			}
//			printMsg(0,langs.lv_chat_system,3,langs.lv_chat_history,0,2);
//			history(1);
			acks_timer = window.setInterval(getClotAcks,1000 * acksTime * beatTime) ;
			getLeaveMesseng_timer = window.setInterval(getLeaveClotMesseng2,5000 * beatTime) ;
		}
    }); 
 
}

//function msg_notification(usertext) {
//	var messeng_data = PastImgEx(usertext,1);
//	var tType=messeng_data.data_type;
//	
//	switch (messeng_data.data_type) {
//	case "a@":
//		var res1="[文件]";
//		 break;
//	case "e@":
//		var res1="[图片]";
//		 break; 
//	case "f@":
//		var res1="[表情]";
//		 break; 
//	default:
//		var res1=messeng_data.data;
//		break;
//	}
//	
//	var audio = document.createElement("audio");
//	audio.src = '/static/js/layui/css/modules/layim/voice/default.mp3';
//	audio.play();
//	window.parent.postMessage({
//			  cmd: 'flashTitle',
//			  params: langs.lv_chat_newmsg
//			}, '*');
//	
//	//$(".chat-user #"+uid+" .msg-tips").show();
//	if(window.Notification && Notification.permission !== "denied") {
//		Notification.requestPermission(function(status) {
//			var n = new Notification('您有新的消息', { body: res1 });
//		});
//	}
//}

//function bodyMove(e){
//	if(e!=null&&typeof(e)!='undefined'){
//		e.stopPropagation();
//	}
//	window.parent.postMessage({
//			  cmd: 'stopFlash',
//			  params: ''
//			}, '*');
//}
//====================================================================================
//EVENT
//====================================================================================
function connectChat()
{
	var param = {LangType:lang_type,connectType:connectType,chater:chater.loginname,userid:my.userid,isnotsend:isnotsend,goods_info:goods_info,username:username,phone:phone,email:email,qq:qq,wechat:wechat,remarks:remarks,othertitle:othertitle,otherurl:otherurl};
    var url = getAjaxUrl("livechat_kf","ConnectChat") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//console.log(JSON.stringify(result));
		switch (parseInt(result.error))
		{
			case 0:
				//更改用户信息
				//alert(JSON.stringify(result));
			   chater.loginname = result.talker;
			   chater.username = result.talkername;
			   chater.connectType = result.connecttype;
			   welcome = result.welcome;
			   
			   chater.lv_chater_ro_to_type = 0;
			   chater.issilence = 0;
			   chater.isConnected = 1;
			   
			   chater.pic = result.picture ;
			   //chat.js 的sendMessage取这个信息
//			   $(".logo").html(chater.username);
//			   $(currWin).attr("loginname",chater.loginname);
				chatId = result.chatid ;
				my.userid = result.userid ;
				if (result.username != "")
					my.username = result.username ;
					
				cookieHCID5 = parseInt(result.cookiehcid5) ;
				//meetingurl.url=result.meetingplug[0].plug_param;
				var obj = {
				id: chater.loginname
				,name: chater.username
				,type: 'friend' //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: 0
				,pid: 0
				}
				layim_chat(obj);
				initChat() ; 
				if(result.questions){
					var res=langs.lv_chat_question;
					for(var i=0;i<result.questions.length;i++) res+='<a href="javascript:QuestionDetail('+result.questions[i].questionid+',\''+result.questions[i].subject+'\');"><span>'+result.questions[i].subject+'</span></a><br>';
//					printMsg(0,langs.lv_chat_system,2,res,0,1);
//					update10();
					var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
					if(result.questions.length>0) printMsg(obj);
				}
				setBtn();
				break; 
			case 1:
			    chater.loginname = result.talker;
				chater.username = result.talker;
				chater.lv_chater_ro_to_type = 0;
				chater.issilence = 2;
				chater.isConnected = 1;
				chater.pic = "" ;
				
				var obj = {
				id: chater.loginname
				,name: chater.username
				,type: 'friend' //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: 0
				,pid: 0
				}
				layim_chat(obj);
				
				var res=langs.lv_chat_content;
				for(var i=0;i<result.members.length;i++) res+='<a href="javascript:onBAChangechatRo('+result.members[i].typeid+');"><span>'+result.members[i].typename+'</span></a><br>';
				var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:1,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
				if(result.questions){
					res=langs.lv_chat_question;
					for(var i=0;i<result.questions.length;i++) res+='<a href="javascript:QuestionDetail('+result.questions[i].questionid+',\''+result.questions[i].subject+'\');"><span>'+result.questions[i].subject+'</span></a><br>';
					//printMsg(0,langs.lv_chat_system,2,res,0,1);
					var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
					//printMsg(obj);
				}
				$('span','.layim-chat-footer').hide();
				//$('.layim-chat-footer').hide();
				//meetingurl.url=result.meetingplug[0].plug_param;
				//update10();  
				break; 
			case 2:
			    chater.issilence = 1;
				location.href=location.href.replace("win_r.html","message1.html")+"&userid="+my.userid+"&chater="+chater.loginname;
				break; 
			 default:
				myAlert(result.msg) ;
				break ;
		} 
    }); 
 
}

function ConnectChat1(typeid)
{
    var param = {LangType:lang_type,connectType:connectType,chater:chater.loginname,userid:my.userid,typeid:typeid,isnotsend:isnotsend,goods_info:goods_info,username:username,phone:phone,email:email,qq:qq,wechat:wechat,remarks:remarks,othertitle:othertitle,otherurl:otherurl};
    var url = getAjaxUrl("livechat_kf","connectchat1") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		
		switch (parseInt(result.error))
		{
			case 0:
				//更改用户信息
			   chater.loginname = result.talker;
			   chater.username = result.talkername;
			   chater.connectType = result.connecttype;
			   welcome = result.welcome;
			   chater.lv_chater_ro_to_type = result.to_type;
			   if(chater.lv_chater_ro_to_type) chater.connectType = 1;

			   chater.issilence = 0;
			   chater.isConnected = 1;
			   var type1 = chater.lv_chater_ro_to_type == 1?'group':'friend' ;
			   
			   chater.pic = result.picture ; 
			   
			   //chat.js 的sendMessage取这个信息
//			   $(".logo").html(chater.username);
//			   $(currWin).attr("loginname",chater.loginname);
				if(result.chatid) chatId = result.chatid ;
				my.userid = result.userid ;
				if (result.username != "")
					my.username = result.username ;
				
				cookieHCID5 = parseInt(result.cookiehcid5) ;
				//printTip(langs.login_doing,0) ;
				//meetingurl.url=result.meetingplug[0].plug_param;
				var obj = {
				id: chater.loginname
				,name: chater.username
				,type: type1 //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: chater.lv_chater_ro_to_type
				,pid: typeid
				}
				layim_chat(obj);
				initChat() ; 
				if(result.questions){
					var res=langs.lv_chat_question;
					for(var i=0;i<result.questions.length;i++) res+='<a href="javascript:QuestionDetail('+result.questions[i].questionid+',\''+result.questions[i].subject+'\');"><span>'+result.questions[i].subject+'</span></a><br>';
//					printMsg(0,langs.lv_chat_system,2,res,0,1);
//					update10();
					var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
					if(result.questions.length>0) printMsg(obj);
				}
				setBtn();
				break; 
			case 2:
			    chater.lv_chater_ro_to_type = 0;
				chater.issilence = 1;
				location.href=location.href.replace("win_r.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				break; 
			case 3:
			    chater.lv_chater_ro_to_type = 1;
				chater.issilence = 1;
				location.href=location.href.replace("win_r.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				break; 
			 default:
				myAlert(result.msg) ;
				break ;
		} 
    }); 
 
}

function initChat(_chater)
{
    
    if (_chater != undefined)
        chater = _chater ;
    cookieHCID =  ipaddress + "-" + chater.loginname + "-Talk" ;
    //保存到chatid 中
    //saveChatId() ;
	
	//var url=meetingurl+"/?roomID="+chatId+"&LoginType=3&ChatType=Users_ID&isaudio=1&isvideo=0&fcname="+escape(my.username)+"&ServerIp="+document.domain;
//	$(".toolbar a").eq(0).attr("href",get_meeting_url(0,meetingurl.point)) ;
//	//var url=meetingurl+"/?roomID="+chatId+"&LoginType=3&ChatType=Users_ID&isaudio=1&isvideo=1&fcname="+escape(my.username)+"&ServerIp="+document.domain;
//	$(".toolbar a").eq(1).attr("href",get_meeting_url(1,meetingurl.point)) ;
//	if(meetingurl.voiceVideoType){
//		$(".toolbar a").eq(0).hide();
//		$(".toolbar a").eq(1).hide();
//	}
//	if(!ChatGPTTransferType){
//		$("#transfer").hide();
//	}
//	if(cookieHCID5){
//		 var transfer_image="kefu.png";
//		 var transfer_title=langs.chart_artificial;
//		 $('#robotlogo').show();
//	}else{
//		var transfer_image="robot.png";
//		var transfer_title=langs.chart_robot;
//		$('#robotlogo').hide();
//	}
//	//console.log('assets/img/'+transfer_image);
//	$('#transfer').attr("title",transfer_title);
//	$('#transfer span').css('background-image','url(assets/img/'+transfer_image+')');
////    if(switchad) asideUrl = "aside_vister_ad.html" ;
////	//加载右边页面
////    if ((location.search != null) && (location.search != ""))
////        asideUrl += location.search + "&chatId=" + chatId + "&loginName=" + chater.loginname;
////    else
////        asideUrl += "?chatId=" + chatId + "&loginName=" + chater.loginname;
////    var asideHeight = $(".aside").height();
////    $(".aside").html('<iframe id="frame_aside" name="frame_aside" height="' + asideHeight+ 'px" width="100%" src="' + asideUrl + '" frameborder="0" ></iframe>');
//
//    printTip(langs.login_doing,0);
//	
//	$(".chat-write,.chat-toolbar").show();
//	$(".chat-toolbar").css("visibility","visible");
//	
////	if (isShowHistory)
////        $("#record").prepend(getHistory()) ;
//        
//    $("#message").focus() ;
//	
//	var messagebox = $(".messagebox",currWin) ;
//	messagebox.attr("contentEditable",true);

	connectio(my.userid,chater.loginname,my.username,'client',1);

//    $("body").append("<div id='talkflash'  style='position:absolute;'></div>") ;
//	var so = new SWFObject("/static/swf/bigantim.swf?ver=20160101", "Talk", "0", "0", "9", "#E5F0F4");
//	var param = "LoginName=Ant_Guest_Web&Password=&Server=" + antServer + "&Port=" + antPort + "&Chater=" + chater.loginname + "&LoginFlag=258&ConnectType=" + connectType  ;
//    
//    if (my.loginname != "")
//        param += "&LoginName=" + my.loginname + "&Password=" + my.password ;
//	if (my.userid != "")
//	    param += "&UserId=" + my.userid ;
//	if (my.userid != "")
//	    param += "&HostName=" + my.userid ; //生成帐号
//	if (my.username != "")
//	    param += "&UserName=" + my.username ;
//		
//	param += "&MsgTip=" + msgTip ;	
//
//	//prompt("",param) ;
//	so.addParam("FlashVars",param );
//	so.write("talkflash");

	
//	$(window).bind('beforeunload',function(){
//		if (true) {
//			 return langs.lv_chat_close_confirm ;
//		} else {
//		}
//	})
	


}


function requestChat()
{
    
//    var subject = langs.lv_chat_request ;
//    var query = "chatId=" + chatId + "&loginname=[LoginName]&password=[pw5]&pwd=[Password]&uid=[UserID]" ; //[LoginName][pw5][Password][UserID]
//    var recvUrl = appPath + "/api/livechat_kf.html?op=RecvChat&" + query;
//    var userInfoUrl =  appPath + "/livechat/aside_chater.html?" + query ;

    //document.getElementById("Talk").SendLiveChatRequest(subject,recvUrl,userInfoUrl) ;
    send_queue(chater.loginname);
	waitQueue();
    //wait_timer = window.setInterval(waitQueue,1000 * waitTime) ;
    
}

function recvChat(msg)
{
	var param = {LangType:lang_type,chater:msg.uid,userid:my.userid,chatId:chatId,visiter_loginname:msg.uid};
    var url = getAjaxUrl("livechat_kf","RecvChat") ;
    $.getJSON(url, param,function(result){
		if(msg.uid==chater.loginname) chater.isConnected = 1;
//        setConnected();
//		
//		if (connectType == CONNECT_TYPE_REQUEST)
//        	window.clearInterval(wait_timer) ;
    });
    
}

function waitQueue(obj)
{
    var param = {chatId:chatId};
    var url = getAjaxUrl("livechat_kf","WaitQueue") ;
	//document.write(url+JSON.stringify(param));
    $.getJSON(url, param,function(result){
		//console.log(JSON.stringify(result));
        switch(result.status)
        {
            case -1:
            	//printTip(langs.lv_chat_queue2,2);
				 var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_queue2,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
				 printMsg(obj);
                break ;
            case 0:
                if (result.queue == 0){
                    //printTip(langs.lv_chat_queue,2);
				   var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_queue,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
				   printMsg(obj);
				}else{
                    //printTip(langs.lv_chat_queue1.replace("{queue}",result.queue),2);
				   var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_queue1.replace("{queue}",result.queue),isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
				   printMsg(obj);
				}
                break ;
            case 1:
                //setConnected(result);
				chater.isConnected = 1;
				if(obj) m_sendMsg(obj);
                break ;
            case 2:
                closeChat(2);
                break ; 
            case 3:
                //printTip(langs.lv_chat_queue3,2);
				 var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_queue3,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
				 printMsg(obj);
                break ;
            case 4:
                //printTip(langs.lv_chat_queue4,2);
				 var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_queue4,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
				 printMsg(obj);
                break ; 
        }
        
        if (result.status != 0)
            window.clearInterval(wait_timer) ;

    }); 

}


 

function closeChatByMy()
{
	if (window.confirm(langs.lv_chat_close_confirm) == false)
        return false ;
    closeChat(1) ;
}

function closeChat(closeRole)
{
    return ;
	logout();
	if(invite.rejectType) postRate1();

    window.clearInterval(free_timer) ;
    window.clearInterval(wait_timer) ;
	window.clearInterval(acks_timer) ;
	window.clearInterval(getLeaveMesseng_timer) ;
    $("#record .msg-5").remove();
    
    if (closeRole == 2)
    {
        printTip(langs.lv_chat_close ,1) ;
    }
	var messagebox = $(".messagebox",currWin) ;
	messagebox.attr("contentEditable",false);
	//$(".chat-toolbar").css("visibility","hidden");
	socket.disconnect();
    isConnected  = false ;
    
    return true ;
}

function setConnected(result)
{
	if (connectType == CONNECT_TYPE_REQUEST&&parseInt(chater.lv_chater_ro_to_type)==0){
		//console.log('isConnected:'+chater.isConnected);
		chater.isConnected = 0;
		requestChat() ; 
	}else online();
	$(".msg-0").remove();

    isConnected = true ;
    isPostRate = false ;
	isPostHide = false ;

    //printMsg(chater.username,2,welcome,0,1) ;	
	if(chater.lv_chater_ro_to_type) getLeaveClotMesseng();
	else getLeaveMesseng(); 
    // freeTime
	if (freeTime > 0)
	{
    	lastWriteTime = new Date() ;
    	free_timer = window.setInterval(startFreeTimer,1000) ;
	}
}

function checkConnect()
{
    if (isConnected == false)
    {
    	myAlert(langs.lv_connect_fail) ;
        return false ;
    }
    else 
        return true ;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//返回错误
//{errnum:1,method:'User'}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function OnError(data)
//{
//	switch(data.errnum)
//	{
//		case 205:
//			printTip(langs.login_accountError,0) ;
//			break;
//		case 208:
//			printTip(langs.login_password_error,0) ;
//			break;
//		case 208:
//			printTip(langs.login_license,0) ;
//			break;
//		case 208:
//			printTip(langs.login_disconnect,0) ;
//			break;
//	}
//}


function onLogined(data)
{
	data.userid = my.userid ; //还是用自己的id
    if (data.result)
		my = jQuery.extend(my,data);
    data.result = parseInt(data.result) ;
//	if (connectType == CONNECT_TYPE_REQUEST)
//		requestChat() ; 
//	else
//	{
		setConnected(data);
//	}
}




 //{talker:'jc',talkername:'jc'}
 function onBAChangeTalker(result)
 {
	 //提示转接用户
	 //printMsg(0,langs.lv_chat_system,3,langs.lv_change_talker.replace("{UserName}",result.username),0,1);
//	 console.log(JSON.stringify(result));
//	 var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_transfer,isreceipt:0,isAppend:1,myid:result.from_uid,picture:"",time:"",objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
//	 printMsg(obj);
	 window.layim_closeThisChat1();
	 connectType = 1;
	 //更改用户信息
	 chater.loginname = result.name;
	 //chater.username = result.username;
	 changekefu(chater.loginname,my.username,1);
	 //connectChat();
	  setTimeout(function(){
		connectChat();
	  }, 500); 
	 
	 //chat.js 的sendMessage取这个信息
//	 $(".logo").html(chater.username);
//	 $(currWin).attr("loginname",chater.loginname);
	 
    //加载右边页面
//    if ((location.search != null) && (location.search != ""))
//        asideUrl += location.search + "&chatId=" + chatId + "&loginName=" + chater.loginname;
//    else
//        asideUrl += "?chatId=" + chatId + "&loginName=" + chater.loginname;
//    var asideHeight = $(".aside").height();
//    $(".aside").html('<iframe id="frame_aside" name="frame_aside" height="' + asideHeight+ 'px" width="100%" src="' + asideUrl + '" frameborder="0" ></iframe>');
	

//	var param = {point:0,label:"messengkefu",myid:my.userid,chater:chater.loginname,ispush:0,ispage:0};
//    var url = getAjaxUrl("msg","list") ; 
//    $.getJSON(url,param , function(result){
//		if (result.status == undefined)
//		{
//			var msg = result.rows ;
//			for(var i=0;i<msg.length;i++){
//				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
//				else var To_Type = parseInt(msg[i].to_type)+1;
//				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].myid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
//				printMsg(obj);
//			}
//		}
//    }); 
 }
 
 function onBAChangechatRo(typeid)
 {
	 window.layim_closeThisChat1();
	  setTimeout(function(){
		ConnectChat1(typeid);
	  }, 500); 
 }


function logout()
{
}

function getWindown()
{
	return $("#win");
}



function printTip(msg,append)
{
	if (append ==undefined)
		append = 0 ;
	var html = "" ;
	html += '<div class="msg msg-0">' ;
	html += '<div class="msg-content">' + msg + '</div> ' ;
	html += '</div>' ;
	html += '</div> ' ;
	
	var container  = $(".chat-content",currWin);
	if (append==1)
 		$(container).html($(container).html() + html);
    else if (append==2){
		if($(".msg-0",container).length==0) $(container).html(html);
		else{
			var msgTip=$(".msg-0",container).eq(0);
			$(".msg-content",msgTip).html(msg);
		}
	}else 
        $(container).html(html);
    $(".chat-record").scrollTop($(container).height()) ;
}

//msgtype 0 system  1 my  2 chater
//function printMsg(msg_id,fcname,to_type,usertext,isreceipt,isAppend,time)
//{
//	//alert(usertext);
//    if(!msg_id) msg_id=guid32();
//	usertext = PastImgEx(usertext,to_type) ;
//    var html = "" ;
//	var res1 = "";
//	if(!time) time = getDateTime() ;
//	var user = to_type == 1?my:chater ;
//	var username = to_type == 1?langs.chat_my:chater.username ;
//	if(chater.lv_chater_ro_to_type) username = to_type == 1?langs.chat_my:unescape(fcname) ;
//	var Fontstyle = to_type == 1?' style="font-size: 1em; font-family: 微软雅黑,Verdana, Arial, Helvetica, sans-serif;color:rgb(255,255,255);font-weight:normal;font-style:normal;text-decoration:none"':' style="font-size: 1em; font-family: 微软雅黑,Verdana, Arial, Helvetica, sans-serif;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration:none"';
//	var res2 = to_type == 1?'<div class="kl_box27 clearfix">'
//						  +'<img class="kl_image3 image" src="assets/img/poit19.png"/>'
//					  +'</div>':'<div class="kl_box22 clearfix">'
//						  +'<img class="kl_image1 image" src="assets/img/poit18.png"/>'
//					  +'</div>';
//
//	if (to_type < 3)
//	{
//	   if(to_type==1){
//		 if(isreceipt==1) res1='<div class="kl_text5b clearfix" id="IsReceipt'+msg_id+'">'+langs.lv_chat_isread+'</div>';
//		 else res1='<div class="kl_text5a clearfix" id="IsReceipt'+msg_id+'">'+langs.lv_chat_unread+'</div>';
//		 if(chater.lv_chater_ro_to_type) res1='';
//	   }
//		html += '<div id="message'+msg_id+'" class="msg msg-' + to_type + '">' ;
//			html += '<div class="msg-user"><img src="' + user.pic + '" align="middle" class="photo" /> </div>' ;
//			html += '<div class="msg-intro">' ;
//			//alert(to_type+"|"+fcname);
//		//if(to_type == 2) html += '<span class="msg-name">' + fcname + '</span>' ;
//				html += '<span class="msg-time">' + username + ' ' + time + '</span>' ;
//				html += '<div class="msg-content"><p class="kl_text6"'+Fontstyle+'>'+usertext+'</p>'+res2+'</div> ' + res1 ;
//			html += '</div>' ;
//		html += '</div> ' ;
//	}else{
//		html += '<div class="msg msg-3">' ;
//		html += '<div class="msg-content">' + usertext + '</div> ' ;
//		html += '</div>' ;
//	//	html += '</div> ' ;
//	}
////alert(html);
//    var container  = $(".chat-content");
//	if($('#message'+msg_id,container).length > 0) return ;
//    if (isAppend==1) 
//        $(container).html($(container).html() + html);
//    else if (isAppend==2) 
//        $(container).html(html+$(container).html());
//    else $(container).html(html);
//	formatMsgContent(container);
//    //$(".chat-record",currWin).scrollTop($(container).height()) ;
//    window.focus() ;
//
//}

function printMsg(obj)
{
    if(!obj.msg_id) obj.msg_id=guid32();
	usertext = obj.usertext ;
    var html = "" ;
	var res1 = "";
	if(!obj.objtype) obj.objtype = 0;
	if(!obj.time) obj.time = getDateTime() ;
	var user = obj.to_type == 1?my:chater ;
	var username = obj.to_type == 1?langs.chat_my:unescape(obj.fcname) ;
	if(!obj.isreceipt){
		 //username = to_type == 1?langs.chat_my:unescape(fcname) ;
		 obj.isreceipt=0;
	}
	//if(!obj.picture) obj.picture="MyPic/default.png";
	//if(obj.lv_chater_ro_to_type)
	var type1 = obj.lv_chater_ro_to_type == 1?'group':'friend' ;
	var mine = obj.to_type == 1?true:false ;
	var objtype = obj.objtype == 1?true:false ;

	if (obj.to_type < 3)
	{
        var obj = {
		  msg_id: obj.msg_id
          ,username: username
          ,avatar: obj.picture
          ,id: obj.myid
          ,type: type1
		  ,objtype: objtype
          ,content: usertext
		  ,isreceipt: obj.isreceipt
		  ,isAppend: obj.isAppend
		  ,lv_chater_ro_to_type: obj.lv_chater_ro_to_type
		  ,pid: obj.pid
		  ,groupname: obj.typename
		  ,mine: mine
		  ,fromid: obj.myid
		  ,timestamp: parseInt(chGMTDateTime3(obj.time))
        }
	}else{
        var obj = {
		  system: true
          ,id: obj.myid
          ,type: type1
		  ,objtype: objtype
          ,content: usertext
		  ,isAppend: obj.isAppend
		  ,lv_chater_ro_to_type: obj.lv_chater_ro_to_type
		  ,pid: obj.pid
		  ,groupname: obj.typename
        }
	}
	//console.log(JSON.stringify(obj));
	layim_getMessage(obj);
    window.focus() ;

}

function Retractmessage(msg)
{
	//console.log(JSON.stringify(msg));
	layim_Retractmessage(msg);
}

function Retractallmessage(msg)
{
	layim_Retractallmessage(msg);
}

//function Retractmessage(msg)
//{
//	var file_container = $("#message" + msg.content) ;
//	$(file_container).removeClass("msg-2").addClass("msg-3");
//	$(file_container).html('<div class="msg-content">' + langs.Retract_success3 + '</div>');
//}
//
//function Retractallmessage(msg)
//{
//	$(".chat-content",currWin).html('<div class="msg msg-3"><div class="msg-content">' + langs.Retract_success5 + '</div></div>');
//}


function update10(){
	var container  = $(".chat-content");
	var speed=100;//滑动的速度
    //$(".chat-record",currWin).animate({ scrollTop: $(container).height() }, speed);
}


function update20(){
	var container  = $(".chat-content");
	var speed=100;//滑动的速度
    //$(".chat-record",currWin).animate({ scrollTop: 0 }, speed);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//发送消息
//msgType: 0 消息  1群发   7 公告;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SendMessage(recver,subject,content,msgType)
{
	if (msgType == undefined)
		msgType = 0 ;
	if (content == undefined)
		content = subject ;
		
	document.getElementById("Talk").SendMessage2(recver,subject,content,msgType) ;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//接收消息
//{sender:,sendername:,extdata:,senderdate:,subject:,msgexttype,cmdid:,contenttype:,content:,attachcount:,attach:,datapath:,}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function recvMsg(msg)
{
	var param = {point:0,msg_id:msg.content,myid:my.userid};
    var url = getAjaxUrl("msg","GetKefuMessage") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			if(result.myid==my.userid) var To_Type = parseInt(result.to_type);
			else{
				 var To_Type = parseInt(result.to_type)+1;
				 if(result.myid!=chater.loginname) return ;
				 //msg_notification(result.usertext);
			}
//			printMsg(result.msg_id,result.fcname,To_Type,result.usertext,result.isreceipt1,1,result.to_date);
//			update10();
			var obj = {msg_id:result.msg_id,fcname:result.fcname,to_type:To_Type,usertext:result.usertext,isreceipt:result.isreceipt1,isAppend:1,myid:result.myid,picture:result.picture,time:result.to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
			printMsg(obj);
				window.parent.postMessage({
						  cmd: 'restore',
						  params: ''
						}, '*');
//			}
		}
    }); 
	

	
	//设置已经读取消息
	//SendMessageReaded(data.cmdid,data.subject) ;

}

function recvClotMsg(msg)
{
	var param = {point:0,msg_id:msg.content,myid:my.userid,clotid:chater.loginname};
	var url = getAjaxUrl("msg","GetKefuClotMessage") ; 
	//console.log(url+JSON.stringify(param));
	$.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			if(result.myid==my.userid) var To_Type = parseInt(result.to_type);
			else{
				 var To_Type = parseInt(result.to_type)+1;
				 if(result.clotid!=chater.loginname) return ;
				 //msg_notification(result.usertext);
			}
			ArrMsg[10]+=To_Type+"_"+result.msg_id+",";
//			printMsg(result.msg_id,result.fcname,To_Type,result.usertext,2,1,result.to_date);
//			update10();
			var obj = {msg_id:result.msg_id,fcname:result.fcname,to_type:To_Type,usertext:result.usertext,isreceipt:2,isAppend:1,myid:result.clotid,picture:result.picture,time:result.to_date,objtype:0,lv_chater_ro_to_type:1,pid:result.pid,typename:result.typename};
			printMsg(obj);
		}
	}); 
}

function QuestionDetail(questionid,subject)
{
	//printMsg(0,langs.lv_chat_system,1,subject,1,1);
	var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:1,usertext:subject,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:1,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
	printMsg(obj);
	var recver = chater.loginname;
	var param1 = {fcname:chater.username,myid:chater.loginname,picture:chater.pic,lv_chater_ro_to_type:chater.lv_chater_ro_to_type};

	var param = {point:0,questionid:questionid,youid:recver,myid:my.userid,chatid:chatId,to_type:3,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5};
    var url = getAjaxUrl("livechat_kf","QuestionDetail") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			//printMsg(0,langs.lv_chat_system,2,result.usertext,0,1);
			var obj = {msg_id:guid32(),fcname:param1.fcname,to_type:2,usertext:result.usertext,isreceipt:0,isAppend:1,myid:param1.myid,picture:param1.picture,time:"",objtype:1,lv_chater_ro_to_type:param1.lv_chater_ro_to_type,pid:0,typename:""};
			printMsg(obj);
			send_message(recver,result.msg_id);
			//update10();
		}
    }); 

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//消息漫游
//jc 20150116
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function msgRoam()
//{
//	var url = appPath + "/livechat/msg_list.html?loginname=" + my.loginname + "&chater=" + chater.loginname + "&from=livechat" ; //chatId
//	window.open(url);
//}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//登记到文件发送表
//flag  1 visiter send   2 visiter recv
//jc 20150116
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function saveAttach(fileName,fileSize,filePath,flag)
{
	var createUser = flag == 1?my.username:chater.username
    var param = {chatId:chatId,chater:chater.loginname,username:my.username,fileName:fileName,fileSize:fileSize,filePath:filePath,flag:flag,createUser:createUser};
    var url = getAjaxUrl("livechat_kf","SaveAttach") ;
    $.post(url,param , function(result){
    }); 
}

//function warning()
//{
//    alert(langs.lv_chat_warning);
//}