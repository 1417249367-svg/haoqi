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
var my = {userid:"",loginname:"",jobtitle:"",deptinfo:"",phone:"",mobile:"",email:"",pic:clientFace,username:langs.chat_my} ;
var chater = {loginname:"",username:"",deptname:"",jobtitle:"",email:"",phone:"",mobile:"",pic:defaultFace,lv_chater_ro_to_type:0,issilence:0,connectType:1,isConnected:0};
var meetingurl = {voiceVideoType:0,url:"",point:1,x:"",y:""} ;
var chatId = "" ;
var isConnected = false ;
var isPostRate = false ;
var isPostClose = false ;
var isPostHide = false ;
var isgetMenu = false ;
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

//var delDtDom='';
//var preOPen='';
//var showFlag=true;
//var timer;
//var timer1;
//var Messengid;
//var tmid = '';
////设置触摸时长
//var touchduration=1000;

function formatContainer(_container)
{
	$(document).click(function(e){
		$(".popu").hide();
	})
	
	if (_container == undefined)
		_container = $("body");
		

		
	//格式化下拉菜单
	$(".btn-toggle",_container).click(function(e){
		$(this).siblings().toggle();
		e.stopPropagation();
	})
	$(".popu-stop",_container).click(function(e){
		e.stopPropagation();
	})
	

    $("[action-type]",_container).click(function () {
        var cmd = $(this).attr("action-type") + "(" + $(this).attr("action-data") + ")" ;
        eval(cmd);
    }); 
	
    $(".messagebox",_container).keydown(function(event){
        if (event.keyCode == 13)
        {
            sendMsg(); 
            return false ;
        }
		event.stopPropagation();
    })
	
//    $("#history a",_container).click(function () {
//        history(2);
//		//update20();
//    }); 
	
//	$(".chat-record",_container).scroll(function(){
//       var $this =$(this);
//	   var scrollTop = $(this).scrollTop();;
//	   if(scrollTop==0){
//		  history(2);
//	   }
//	});
}
 


//====================================================================================
//UI
//====================================================================================
function initPage()
{
	appPath = getAppPath();
}


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





function postRate()
{
    //连接过，再断开也可以评价
	isPostClose = true;
    if (chatId == "")
    {
        return false ;
    }

        
    if (isPostRate||isPostHide)
    {
		window.parent.postMessage({
				  cmd: 'end',
				  params: ''
				}, '*');
        return false ;
    }

	var obj = {
		type: '2'
	}
    getRate(obj);
}

function postRate1()
{
    //连接过，再断开也可以评价
	isPostHide = true;
    if (chatId == "")
    {
        return false ;
    }

        
    if (isPostRate)
    {
        return false ;
    }
	var obj = {
		type: '1'
	}
    getRate(obj);
}

function sendRate(rate,index)
{
	var param = {chatId:chatId,rate:rate};
	var url = getAjaxUrl("livechat_kf","PostRate") ;
	//document.write(url+JSON.stringify(param));
	$.getJSON(url,param, function(result){
//				if (isConnected){
//					sendMsg(langs.lv_rate_msg.replace("{Rate}",param.rate)  ,false) ;
//				}
		myAlert(langs.lv_rate_success);
		isPostRate = true ;
		hideRate(index);
	}); 
	
}

function hideRate(index)
{
	layer.close(layer.index);
	if(isPostClose){
		var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
		parent.layer.close(index);
	}
}
  

//====================================================================================
//History  
//cookie["userid"] 存放所有chatid
//cookie["chatid"] 存放当前chat的内容
//====================================================================================
function saveChatId()
{
	if (chatId == "")
        return ;

    var chats = getCookie(cookieHCID) ;
    if (chats == "")
        chats = chatId ;
    else 
        chats = chats + "," + chatId ;
    setCookie(cookieHCID,chats) ;
	setCookie(cookieHCID1,chatId) ;
}



function saveHistory()
{
    if (chatId == "")
        return ;
    
    var content = $("#" + chatId).html() ;
    if (isSaveCookie)
        setCookie(chatId,content ,9999) ;

   
    var param = {chatId:chatId,content:  escape(content)};
    var url = getAjaxUrl("livechat_kf","SaveHistory") ;
    $.post(url,param , function(result){
    }); 
}



function getHistory()
{
    var html = "" ;
    var chats = getCookie(cookieHCID) ;
    if (chats == "")
        return ;
    var arr = chats.split(",");
    for(var i=0;i<arr.length;i++)
    {
        var s = arr[i]; 
        if ((s == chatId) || (s == ""))
            continue ;
        var c = getCookie(s) ;

        if (c != "")
        {
            html += "<div id='" + s + "' class='chat chat-history'>" + c + "</div>"
        }
    }

    return html ;
}

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
			}
		}
    }); 
}

function getClotAcks()
{
	var param = {point:0,label:"messengkefuclot_acks",myid:my.userid,"Msg_IDs4":ArrMsg[10],ispage:1};
    var url = getAjaxUrl("msg","list") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			ArrMsg[10] = "";
		}
    }); 
}

function history(type)
{
	if(chater.lv_chater_ro_to_type){
		clothistory(type);
		return ;
	}
	var param = {point:0,label:"messengkefu_history",myid:my.userid,youid:chater.loginname,lastTypeID:lastTypeID,isclient:1,ispage:1,pagesize:pagesize};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			for(var i=msg.length-1;i>=0;i--){
				lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:2,myid:chater.loginname,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
			}
			if(msg.length<pagesize) $("#history").hide();
			if(type==1) update10();
			else update20();
		}
    }); 
}

function clothistory(type)
{
	//if(showhistorytype) return ;
	var param = {point:0,label:"messengkefuclot_history",myid:my.userid,youid:chater.loginname,lastTypeID:lastTypeID,isclient:1,ispage:1,pagesize:pagesize};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			for(var i=0;i<msg.length;i++){
				lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,2,chater.loginname,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:2,myid:chater.loginname,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:1,pid:msg[i].pid,typename:msg[i].typename};
				printMsg(obj);
			}
			if(msg.length<pagesize) $("#history").hide();
			if(type==1) update10();
			else update20();
		}
    }); 
}
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
			for(var i=0;i<msg.length;i++){
				if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].myid,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].myid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
			}
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
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].myid,msg[i].to_date);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].myid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
				printMsg(obj);
			}
			//printMsg(0,langs.lv_chat_system,3,langs.lv_chat_history,0,2,chater.loginname,chater.username);
			if(parseInt(switchDomainType)&&isChatlog==0) history(1);
			acks_timer = window.setInterval(getAcks,1000 * acksTime * beatTime) ;
			getLeaveMesseng_timer = window.setInterval(getLeaveMesseng2,5000 * beatTime) ;
			if(ischathistory) getLeaveClotMesseng();
			//update10();
		}
    }); 
 
}

function getLeaveClotMesseng2()
{
	if(ischathistory) var chater1="";
	else var chater1=chater.loginname;
	var param = {point:0,label:"messengkefuclot",myid:my.userid,chater:chater1,"Msg_IDs4":ArrMsg[10],ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//console.log(url+JSON.stringify(param));
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
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].clotid,msg[i].to_date,0,1,msg[i].pid,msg[i].groupname);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].clotid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:1,pid:msg[i].pid,typename:msg[i].typename};
				printMsg(obj);
			}
		}
    }); 
 
}

function getLeaveClotMesseng()
{
	if(__uuids.indexOf(chater.loginname) == -1) var ispush=1;
	else var ispush=0;
	if(ischathistory) var chater1="";
	else var chater1=chater.loginname;
	var param = {point:0,label:"messengkefuclot",myid:my.userid,chater:chater1,ispush:ispush,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			//console.log(JSON.stringify(result));
			ArrMsg[10] = "";
			var msg = result.rows2 ;
			for(var i=0;i<msg.length;i++){
				if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				ArrMsg[10]+=To_Type+"_"+msg[i].msg_id+",";
				//printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].clotid,msg[i].to_date,0,1,msg[i].pid,msg[i].groupname);
				var obj = {msg_id:msg[i].msg_id,fcname:msg[i].fcname,to_type:To_Type,usertext:msg[i].usertext,isreceipt:msg[i].isreceipt1,isAppend:1,myid:msg[i].clotid,picture:msg[i].picture,time:msg[i].to_date,objtype:0,lv_chater_ro_to_type:1,pid:msg[i].pid,typename:msg[i].typename};
				printMsg(obj);
			}
			//printMsg(0,langs.lv_chat_system,3,langs.lv_chat_history,0,2,chater.loginname,chater.username);
			if(parseInt(switchDomainType)&&isChatlog==0) history(1);
			acks_timer = window.setInterval(getClotAcks,1000 * acksTime * beatTime) ;
			getLeaveMesseng_timer = window.setInterval(getLeaveClotMesseng2,5000 * beatTime) ;
		}
    }); 
 
}

//====================================================================================
//EVENT
//====================================================================================
function connectChat(ischatChange)
{
	var param = {LangType:lang_type,connectType:connectType,chater:chater.loginname,userid:my.userid,goods_info:goods_info,username:username,phone:phone,email:email,qq:qq,wechat:wechat,remarks:remarks,othertitle:othertitle,otherurl:otherurl,isnotsend:ischatChange};
    var url = getAjaxUrl("livechat_kf","ConnectChat") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//console.log(JSON.stringify(result));
		switch (parseInt(result.error))
		{
			case 0:
				//更改用户信息
			   chater.loginname = result.talker;
			   chater.username = result.talkername;
			   chater.connectType = result.connecttype;
			   welcome = result.welcome;
			   if(result.mobileback) mobileback = false ;
			   chater.lv_chater_ro_to_type = 0;
			   chater.issilence = 0;
			   chater.isConnected = 1;
			   
			   //if (result.picture != "") 
			   chater.pic = result.picture ;
			   //chat.js 的sendMessage取这个信息
			   //$(".logo").html(chater.username);
			   $(currWin).attr("loginname",chater.loginname);
				chatId = result.chatid ;
				my.userid = result.userid ;
				if (result.username != "")
					my.username = result.username ;
					
				cookieHCID5 = parseInt(result.cookiehcid5) ;
				//meetingurl.url=result.meetingplug[0].plug_param;
				var obj = {
				id: chater.loginname
				,name: chater.username
				,type: 'kefu' //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: 0
				,pid: 0
				}
				//console.log('ischatChange:'+ischatChange);
				if(ischatChange){
					if (chater.connectType == CONNECT_TYPE_REQUEST){
						chater.isConnected = 0;
						requestChat() ; 
					}
				}else{
					layim_chat(obj);
					initChat() ;
					if(result.questions){
						var res=langs.lv_chat_question;
						for(var i=0;i<result.questions.length;i++) res+='<a href="javascript:QuestionDetail('+result.questions[i].questionid+',\''+result.questions[i].subject+'\');"><span>'+result.questions[i].subject+'</span></a><br>';
						//printMsg(0,langs.lv_chat_system,2,res,0,1,chater.loginname);
						var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
						if(result.questions.length>0) printMsg(obj);
						//update10();
					}
				}
				//setBtn();
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
				,type: 'kefu' //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: 0
				,pid: 0
				}
				
				if(ischatChange){
//					if (chater.connectType == CONNECT_TYPE_REQUEST){
//						chater.isConnected = 0;
//						requestChat() ; 
//					}
				}else{
					layim_chat(obj);
					var res=langs.lv_chat_content;
					for(var i=0;i<result.members.length;i++) res+='<a href="javascript:onBAChangechatRo('+result.members[i].typeid+');"><span>'+result.members[i].typename+'</span></a><br>';
					var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:1,lv_chater_ro_to_type:0,pid:0,typename:""};
					printMsg(obj);
				}
//				$('span','.layim-chat-footer').hide();
//				$('.layim-send','.layim-chat-footer').hide();
				//$('.layim-chat-footer').hide();
//			    chater.loginname = result.talker;
//				chater.lv_chater_ro_to_type = 0;
//				chater.issilence = 0;
//				chater.isConnected = 1;
//				var obj = {
//					url: getAjaxUrl("livechat_kf","GetChaterRo","myid=public&id="+my.userid) //接口地址（返回的数据格式见下文）
//					,type: 'get' //默认get，一般可不填
//					,data: {} //额外参数
//					,objtype: 0
//				}
				//layim_getchatRo(obj);
				//setTimeout("layim_getchatRo();", 1000);
				break; 
			case 2:
			    chater.issilence = 1;
				//location.href=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&chater="+chater.loginname;
				var url=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&chater="+chater.loginname;
				//console.log(url);
				var obj = {
					url: url
					,title: '给我留言'
				}
				layim_panel(obj);
//				layim.panel({
//				  title: '给我留言' //标题
//				  ,tpl: '<iframe id="frame_main1" name="frame_main1" width="100%" height="100%" src="{{d.data.test}}" frameborder="0" ></iframe>' //模版
//				  ,data: { //数据
//					test: url
//				  }
//				});
				break; 
			 default:
				myAlert(result.msg) ;
				break ;
		} 
    }); 
 
}

function ConnectChat1(typeid,ischatChange)
{
	var param = {LangType:lang_type,connectType:connectType,chater:chater.loginname,userid:my.userid,typeid:typeid,goods_info:goods_info,username:username,phone:phone,email:email,qq:qq,wechat:wechat,remarks:remarks,othertitle:othertitle,otherurl:otherurl,isnotsend:ischatChange};
    var url = getAjaxUrl("livechat_kf","connectchat1") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//console.log(JSON.stringify(result));
		switch (parseInt(result.error))
		{
			case 0:
				//更改用户信息
			   chater.loginname = result.talker;
			   chater.username = result.talkername;
			   chater.connectType = result.connecttype;
			   welcome = result.welcome;
			   if(result.mobileback) mobileback = false ;
			   chater.lv_chater_ro_to_type = result.to_type;
			   if(chater.lv_chater_ro_to_type) chater.connectType = 1;
			   chater.issilence = 0;
			   chater.isConnected = 1;
			   //if (result.picture != "") 
			   chater.pic = result.picture ; 
			   
			   //chat.js 的sendMessage取这个信息
			   //$(".logo").html(chater.username);
			   $(currWin).attr("loginname",chater.loginname);
				if(result.chatid) chatId = result.chatid ;
				my.userid = result.userid ;
				if (result.username != "")
					my.username = result.username ;
				
				cookieHCID5 = parseInt(result.cookiehcid5) ;
				//meetingurl.url=result.meetingplug[0].plug_param;
//				if(chater.lv_chater_ro_to_type) var objid = typeid;
//				else var objid = chater.loginname;
				var obj = {
				id: chater.loginname
				,name: chater.username
				,type: 'kefu' //friend、group等字符，如果是group，则创建的是群聊
				,avatar: chater.pic
				,lv_chater_ro_to_type: chater.lv_chater_ro_to_type
				,pid: typeid
				}

				//printTip(langs.login_doing,0) ;
				if(ischatChange){
					if (chater.connectType == CONNECT_TYPE_REQUEST){
						chater.isConnected = 0;
						requestChat() ; 
					}
				}else{
					layim_chat(obj);
					initChat() ;
					if(result.questions){
						var res=langs.lv_chat_question;
						for(var i=0;i<result.questions.length;i++) res+='<a href="javascript:QuestionDetail('+result.questions[i].questionid+',\''+result.questions[i].subject+'\');"><span>'+result.questions[i].subject+'</span></a><br>';
						//printMsg(0,langs.lv_chat_system,2,res,0,1,chater.loginname);
						var obj = {msg_id:0,fcname:chater.username,to_type:2,usertext:res,isreceipt:0,isAppend:2,myid:chater.loginname,picture:result.picture,time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
						if(result.questions.length>0) printMsg(obj);
						//update10();
					}
				}
				//setBtn();
				break; 
			case 2:
			    chater.lv_chater_ro_to_type = 0;
				chater.issilence = 1;
				//location.href=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				var url=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				var obj = {
					url: url
					,title: '给我留言'
				}
				layim_panel(obj);
				break; 
			case 3:
			    chater.lv_chater_ro_to_type = 1;
				chater.issilence = 1;
				//location.href=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				var url=location.href.replace("mobile.html","message1.html")+"&userid="+my.userid+"&groupid="+typeid;
				var obj = {
					url: url
					,title: '给我留言'
				}
				layim_panel(obj);
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

    //printTip(langs.login_doing,0);
//console.log(chater.loginname);
	connectio(my.userid,chater.loginname,my.username,'client',3);

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
	logout(closeRole);
	if(invite.rejectType) postRate1();

    window.clearInterval(free_timer) ;
    window.clearInterval(wait_timer) ;
	window.clearInterval(acks_timer) ;
	window.clearInterval(getLeaveMesseng_timer) ;
    
    if (closeRole == 2)
    {
		//printMsg(0,langs.lv_chat_system,3,langs.lv_chat_close,0,2,chater.loginname);
		var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:langs.lv_chat_close,isreceipt:0,isAppend:2,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
		printMsg(obj);

    }
	//layim_disabled();
	socket.disconnect();
    isConnected  = false ;
    
    return true ;
}

function setConnected(result)
{
//	$(".chat-write,.chat-toolbar").show();
//	$(".chat-toolbar").css("visibility","visible");
//
//	$(".msg-0").remove();
//console.log(ischathistory+'|'+connectType+'|'+CONNECT_TYPE_REQUEST+'|'+chater.lv_chater_ro_to_type);
	if ((!ischathistory)&&connectType == CONNECT_TYPE_REQUEST&&parseInt(chater.lv_chater_ro_to_type)==0){
		//console.log('isConnected:'+chater.isConnected);
		chater.isConnected = 0;
		requestChat() ; 
	}else online();
	$(".msg-0").remove();
	isConnected = true ;
    isPostRate = false ;
	isPostHide = false ;


//	if (isShowHistory)
//        $("#record").prepend(getHistory()) ;
//        
//    $("#message").focus() ;
//	
//	var messagebox = $(".messagebox",currWin) ;
//	messagebox.attr("contentEditable",true);
	
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
	 closeChat(0);
	 connectType = 1;
	 chater.loginname = result.name;
	 changekefu(chater.loginname,my.username,3);
	 connectChat();
 }

 function onBAChangechatRo(typeid)
 {
	 //window.layim_closeThisChat1();
	 //更改用户信息
	  //setTimeout(function(){
		ConnectChat1(typeid,0);
	  //}, 500); 
 }


function logout(logout)
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
	var obj = {
	  system: true
	  ,id: chater.loginname
	  ,type: 'kefu'
	  ,content: msg
	}
	layim_sysMessage(obj);
}

//msgtype 0 system  1 my  2 chater
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
	var mine = obj.to_type == 1?true:false ;
	var objtype = obj.objtype == 1?true:false ;

	if (obj.to_type < 3)
	{
        var obj = {
		  msg_id: obj.msg_id
          ,username: username
          ,avatar: obj.picture
          ,id: obj.myid
          ,type: 'kefu'
		  ,objtype: objtype
          ,content: usertext
		  ,isreceipt: obj.isreceipt
		  ,isAppend: obj.isAppend
		  ,lv_chater_ro_to_type: obj.lv_chater_ro_to_type
		  ,pid: obj.pid
		  ,groupname: obj.typename
		  ,mine: mine
		  ,timestamp: parseInt(chGMTDateTime3(obj.time))
        }
	}else{
        var obj = {
		  system: true
          ,id: obj.myid
          ,type: 'kefu'
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
	layim_Retractmessage(msg);
}

function Retractallmessage(msg)
{
	layim_Retractallmessage(msg);
}

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
			//data.content = getHTMLContent(data) ;
			//alert(result.usertext);
			if(result.myid==my.userid) var To_Type = parseInt(result.to_type);
			else{
				 var To_Type = parseInt(result.to_type)+1;
				 if((!ischathistory)&&result.myid!=chater.loginname) return ;
			}
			//printMsg(result.msg_id,result.fcname,To_Type,result.usertext,result.isreceipt1,1,result.myid,result.to_date);
			var obj = {msg_id:result.msg_id,fcname:result.fcname,to_type:To_Type,usertext:result.usertext,isreceipt:result.isreceipt1,isAppend:1,myid:result.myid,picture:result.picture,time:result.to_date,objtype:0,lv_chater_ro_to_type:0,pid:0,typename:""};
			printMsg(obj);
			//update10();
		}
    }); 
	

	
	//设置已经读取消息
	//SendMessageReaded(data.cmdid,data.subject) ;

}

function recvClotMsg(msg)
{
	if(ischathistory) var chater1="";
	else var chater1=chater.loginname;
	var param = {point:0,msg_id:msg.content,myid:my.userid,clotid:chater1};
	var url = getAjaxUrl("msg","GetKefuClotMessage") ; 
	//alert(url+JSON.stringify(param));
	$.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			if(result.myid==my.userid) var To_Type = parseInt(result.to_type);
			else{
				 var To_Type = parseInt(result.to_type)+1;
				 //if((!result.fcname)&&(result.myid!=chater.loginname)) return ;
			}
			ArrMsg[10]+=To_Type+"_"+result.msg_id+",";
			//printMsg(result.msg_id,result.fcname,To_Type,result.usertext,2,1,result.clotid,result.to_date,0,1,result.pid,result.groupname);
			var obj = {msg_id:result.msg_id,fcname:result.fcname,to_type:To_Type,usertext:result.usertext,isreceipt:2,isAppend:1,myid:result.clotid,picture:result.picture,time:result.to_date,objtype:0,lv_chater_ro_to_type:1,pid:result.pid,typename:result.typename};
			printMsg(obj);
		}
	}); 
}

function QuestionDetail(questionid,subject)
{
	//printMsg(0,langs.lv_chat_system,1,subject,0,1,chater.loginname,"",1);
	var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:1,usertext:subject,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:1,lv_chater_ro_to_type:0,pid:0,typename:""};
	printMsg(obj);
	
	var param = {point:1,questionid:questionid,youid:chater.loginname,myid:my.userid,chatid:chatId,to_type:3,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5};
    var url = getAjaxUrl("livechat_kf","QuestionDetail") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			//printMsg(guid32(),langs.lv_chat_system,2,result.usertext,0,1,chater.loginname,"",1);
			var obj = {msg_id:guid32(),fcname:chater.username,to_type:2,usertext:result.usertext,isreceipt:0,isAppend:1,myid:chater.loginname,picture:chater.pic,time:"",objtype:1,lv_chater_ro_to_type:0,pid:0,typename:""};
			printMsg(obj);
			
			send_message(chater.loginname,result.msg_id);
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

function sendChatGPT1(point,msg_id,msg)
{
	axios.post('https://api.openai.com/v1/completions', {
		prompt: msg, max_tokens: 2048, model: "text-davinci-003"
	}, {
		headers: { 'content-type': 'application/json', 'Authorization': 'Bearer ' + ChatGPTAppid }
	}).then(res => {
		console.log(res);
		let text = inputUText(HTML2BA(res.data.choices[0].text.trim().replace("openai:", "").replace("openai：", "").replace(/^\n|\n$/g, "")));
		if(point){
			var obj = {
			  msg_id: msg_id
			  ,username: chater.username
			  ,avatar: chater.pic
			  ,id: chater.loginname
			  ,type: 'kefu'
			  ,content: text
			  ,isreceipt: 0
			  ,mine: false
			  ,timestamp: parseInt(chGMTDateTime3(getDateTime()))
			}
			//alert(JSON.stringify(obj));
			layim_replacemessage(obj);
		}
		update10();
	}).catch(error =>{
		console.log('error',error);
		if(point){
			var obj = {
			  msg_id: msg_id
			  ,username: chater.username
			  ,avatar: chater.pic
			  ,id: chater.loginname
			  ,type: 'kefu'
			  ,content: langs.msg_recv_chatgpt3
			  ,isreceipt: 0
			  ,mine: false
			  ,timestamp: parseInt(chGMTDateTime3(getDateTime()))
			}
			//alert(JSON.stringify(obj));
			layim_replacemessage(obj);
		}
		update10();
	})
}