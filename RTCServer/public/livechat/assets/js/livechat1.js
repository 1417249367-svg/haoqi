var lang = "cn" ;
var UDCAPTURE_SAVEFILE = "/public/livechat_kf.html?op=uploadscreenhot"; //后台保存图片的文件路径,aspx可以换成php或jsp
var uploadUrl = "/public/upload.html";
var defaultFace = "assets/img/face.png" ;
var clientFace = "assets/img/client.png" ;
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
var my = {userid:"",loginname:"",jobtitle:"",deptinfo:"",phone:"",mobile:"",email:"",pic:clientFace,username:"",usericoline:""} ;
var chater = {typeid:"",loginname:"",username:"",deptname:"",jobtitle:"",email:"",phone:"",mobile:"",pic:defaultFace,lv_chater_ro_to_type:0};
var chatId = "" ;
var isConnected = false ;
var isPostRate = false ;
var connectchattype = 0;
var cookieHCID ;
var cookieHCID1;
var cookieHCID2;
var cookieHCID3;
var cookieHCID4;
var cookieHCID5;
var free_timer,wait_timer,acks_timer ;
var lastWriteTime ;
var appPath = "" ;

var ATTACH_VISITER_RECV = 1 ;
var ATTACH_VISITER_SEND = 2 ;
var CONNECT_TYPE_ALLOW = 1 ;
var CONNECT_TYPE_REQUEST = 2 ;

window.addEventListener("message",function(obj){
    var data = obj.data;
	switch (data.cmd) {
	case 'setCookie3':
	  cookieHCID3=data.params ;
	  break;
	case 'setCookie4':
	  cookieHCID4=data.params ;
	  break;
	}
});

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

    if (chatId == "")
    {
    	myAlert(langs.lv_connect_fail) ;
        return false ;
    }

        
    if (isPostRate)
    {
    	myAlert(langs.lv_rate_error);
        return false ;
    }
    $(".popu").not($(".popu-rate")).hide();
    $(".popu-rate").toggle();
}







function sendRate()
{
    var rate = getRadioValue("rate") ;
    var note = $("#ratenote").val() ;
    var param = {chatId:chatId,rate:rate,note:escape(note)};
    var url = getAjaxUrl("livechat_kf","PostRate") ;
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param, function(result){
        if (isConnected)
            sendMsg(langs.lv_rate_msg.replace("{Rate}",get_rate(param.rate)).replace("{Note}",note)  ,false) ;
        myAlert(langs.lv_rate_success);
        isPostRate = true ;
        $(".popu-rate").hide();
    }); 
}
  
  
function get_rate(status)
{
	switch(parseInt(status))
	{
		case 1:
			return langs.chart_rate_unit1 ;
		case 2:
			return langs.chart_rate_unit2 ;
		case 3:
			return langs.chart_rate_unit3 ;
		case 4:
			return langs.chart_rate_unit4 ;
		case 5:
			return langs.chart_rate_unit5 ;
		default:
			return langs.chart_rate_unit0 ;
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
				$("#IsReceipt"+msg[i].msg_id).removeClass("kl_text5a");
				$("#IsReceipt"+msg[i].msg_id).addClass("kl_text5b");
				$("#IsReceipt"+msg[i].msg_id).html(langs.lv_chat_isread) ;
			}
		}
    }); 
}

//====================================================================================
//EVENT
//====================================================================================
function getLeaveMesseng()
{
	//alert(getCookie(cookieHCID3));
	if(__uuids.indexOf(chater.loginname) == -1) var ispush=1;
	else var ispush=0;
	var param = {point:0,label:"messengkefu_one",myid:my.userid,youid:chater.loginname,typeid:chater.typeid,chater:chater.loginname,ispush:ispush,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//alert(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//alert(JSON.stringify(result));
		if (result.status == undefined)
		{
			var msg = result.rows ;
			if(msg.length){
				for(var i=0;i<msg.length;i++){
					if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
					if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
					else var To_Type = parseInt(msg[i].to_type)+1;
					printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				}
			}else{
				if(result.recordcount&&(!ismobile)){
					window.parent.postMessage({
							  cmd: 'talk_r',
							  params: chater.loginname
							}, '*');
				}
			}
		}
    }); 
 
}

function getLeaveClotMesseng()
{
	if(__uuids.indexOf(chater.loginname) == -1) var ispush=1;
	else var ispush=0;
	var param = {point:0,label:"messengkefuclot_one",myid:my.userid,youid:chater.loginname,typeid:chater.typeid,chater:chater.loginname,ispush:ispush,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//alert(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			if(msg.length){
				for(var i=0;i<msg.length;i++){
					if(lastTypeID==0) lastTypeID=parseInt(msg[i].typeid);
					if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
					else var To_Type = parseInt(msg[i].to_type)+1;
					printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
				}
			}else{
				if(result.recordcount&&(!ismobile)){
					window.parent.postMessage({
							  cmd: 'talk_r',
							  params: chater.loginname
							}, '*');
				}
			}
		}
    }); 
 
}

function connectChat()
{
	var param = {connectType:connectType,chater:chater.loginname,userid:my.userid,typeid:chater.typeid,sourceurl:sourceurl,launchurl:launchurl,isweb:isweb,isend:isend,username:username,phone:phone,email:email,qq:qq,wechat:wechat,remarks:remarks,othertitle:othertitle,otherurl:otherurl};
    var url = getAjaxUrl("livechat_kf","ConnectSource") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		switch (parseInt(result.error))
		{
			case 0:
			
			   break; 
			case 1:
				//更改用户信息
//			   chater.loginname = result.talker;
//			   chater.username = result.talkername;
//			   //chat.js 的sendMessage取这个信息
//				chatId = result.chatid ;
//				my.userid = result.userid ;
                my.usericoline = result.usericoline;
                chater.lv_chater_ro_to_type = result.to_type;
				if (result.username != "")
					my.username = result.username ;
//				cookieHCID =  ipaddress + "-" + chater.loginname + "-Talk" ;
//				//保存到chatid 中
//				saveChatId() ;
				connectchattype =  result.connectchattype ;
				if(chater.lv_chater_ro_to_type) connectio(my.userid,chater.typeid,username,'web',result.usericoline);
				else connectio(my.userid,chater.loginname,username,'web',result.usericoline);
				break; 
		} 
    }); 
 
}

function requestChat()
{
    
    var subject = langs.lv_chat_request ;
    var query = "chatId=" + chatId + "&loginname=[LoginName]&password=[pw5]&pwd=[Password]&uid=[UserID]" ; //[LoginName][pw5][Password][UserID]
    var recvUrl = appPath + "/api/livechat_kf.html?op=RecvChat&" + query;
    var userInfoUrl =  appPath + "/livechat/aside_chater.html?" + query ;

    //document.getElementById("Talk").SendLiveChatRequest(subject,recvUrl,userInfoUrl) ;
    waitQueue();
    wait_timer = window.setInterval(waitQueue,1000 * waitTime) ;
    
}

function recvChat()
{
    var param = {chatId:chatId,visiter_loginname:my.loginname};
    var url = getAjaxUrl("livechat_kf","RecvChat") ;
    $.getJSON(url, param,function(result){
        setConnected();
		
		if (connectType == CONNECT_TYPE_REQUEST)
        	window.clearInterval(wait_timer) ;
    });
    
}

function waitQueue()
{
    var param = {chatId:chatId};
    var url = getAjaxUrl("livechat_kf","WaitQueue") ;
	//document.write(url+JSON.stringify(param));
    $.getJSON(url, param,function(result){
        switch(result.status)
        {
            case -1:
            	//myAlert("参数错误");
                break ;
            case 0:
                if (result.queue == 0)
                    printTip("目前在线客服繁忙，请等待...",0);
                else
                    printTip("目前在线客服繁忙，您前面有" + result.queue + "位客户等待...",0);
                break ;
            case 1:
                setConnected(result);
                break ;
            case 2:
                closeChat(2);
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
    logout();
	socket.disconnect();
    window.clearInterval(free_timer) ;
    window.clearInterval(wait_timer) ;
	window.clearInterval(acks_timer) ;
    
    if (closeRole == 2)
    {
        //printTip(langs.lv_chat_close ,1) ;
    }

    isConnected  = false ;
    
    return true ;
}

function setConnected(result)
{
	online();
	isConnected = true ;
    isPostRate = false ;

	if(parseInt(connectchattype)){
		//connectchatkefu(loginname);
		//printMsg(0,langs.lv_chat_system,3,langs.lv_chat_connectchat1,0,2);
		window.parent.postMessage({
				  cmd: 'talk_r1',
				  params: chater.loginname
				}, '*');
	}else{
		if(chater.lv_chater_ro_to_type) getLeaveClotMesseng();
		else getLeaveMesseng();
	}
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
function OnError(data)
{
	switch(data.errnum)
	{
		case 205:
			printTip(langs.login_accountError,0) ;
			break;
		case 208:
			printTip(langs.login_password_error,0) ;
			break;
		case 208:
			printTip(langs.login_license,0) ;
			break;
		case 208:
			printTip(langs.login_disconnect,0) ;
			break;
	}
}


function onLogined(data)
{
	data.userid = my.userid ; //还是用自己的id
    if (data.result)
		my = jQuery.extend(my,data);
    data.result = parseInt(data.result) ;
	if (connectType == CONNECT_TYPE_REQUEST)
		requestChat() ; 
	else
	{
		setConnected(data);
	}
}




 //{talker:'jc',talkername:'jc'}
 function onBAChangeTalker(result)
 {
	 //更改用户信息
	 chater.loginname = result.name;
	 chater.username = result.name;
	 
	

	var param = {point:0,label:"messengkefu",myid:my.userid,ispush:0,ispage:0};
    var url = getAjaxUrl("msg","list") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status == undefined)
		{
			var msg = result.rows ;
			for(var i=0;i<msg.length;i++){
				if(msg[i].myid==my.userid) var To_Type = msg[i].to_type;
				else var To_Type = parseInt(msg[i].to_type)+1;
				printMsg(msg[i].msg_id,msg[i].fcname,To_Type,msg[i].usertext,msg[i].isreceipt1,1,msg[i].to_date);
			}
		}
    }); 
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
	if (append)
 		$(container).html($(container).html() + html);
    else 
        $(container).html(html);
    $(".chat-record").scrollTop($(container).height()) ;
}

//msgtype 0 system  1 my  2 chater
function printMsg(msg_id,fcname,to_type,usertext,isreceipt,isAppend,time)
{
	//alert(getCookie(cookieHCID3)+'|'+getCookie(cookieHCID4));
	if(parseInt(cookieHCID3)) return false;
	if(parseInt(cookieHCID4)) return false;
	//alert('gfshh');
	if(ismobile){
		usertext = decodeUserText(usertext);
		//alert(usertext);
		if(usertext.length>30) usertext=left(usertext,30)+"...";
		//window.parent.postMessage(usertext,parentDomain);
		window.parent.postMessage({
				  cmd: 'sendmessage',
				  params: usertext
				}, '*');
	}else{
		window.parent.postMessage({
				  cmd: 'talk_r',
				  params: chater.loginname
				}, '*');
	}
}

function initInvite(lname)
{
	window.parent.postMessage({
			  cmd: 'initInvite',
			  params: lname
			}, '*');
}

function update10(){
	var container  = $(".chat-content");
	var speed=100;//滑动的速度
    $(".chat-record",currWin).animate({ scrollTop: $(container).height() }, speed);
}


function update20(){
	var container  = $(".chat-content");
	var speed=100;//滑动的速度
    $(".chat-record",currWin).animate({ scrollTop: 0 }, speed);
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
			//alert(result.myid+'|'+my.userid);
			if(result.myid!=my.userid) printMsg(result.msg_id,result.fcname,parseInt(result.to_type)+1,result.usertext,result.isreceipt1,1,result.to_date);
		}
    }); 
	

	
	//设置已经读取消息
	//SendMessageReaded(data.cmdid,data.subject) ;

}

function recvClotMsg(msg)
{
	var param = {point:0,msg_id:msg.content,myid:my.userid,pid:chater.loginname};
	var url = getAjaxUrl("msg","GetKefuClotMessage") ; 
	//console.log(url+JSON.stringify(param));
	$.getJSON(url,param , function(result){
		//alert(JSON.stringify(result));
		if (result.status == undefined)
		{
			if(result.myid!=my.userid) printMsg(result.msg_id,result.fcname,parseInt(result.to_type)+1,result.usertext,result.isreceipt1,1,result.to_date);
		}
	}); 
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//消息漫游
//jc 20150116
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function msgRoam()
{
	var url = appPath + "/livechat/msg_list.html?loginname=" + my.loginname + "&chater=" + chater.loginname + "&from=livechat" ; //chatId
	window.open(url);
}


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

function warning()
{
    alert(langs.lv_chat_warning);
}