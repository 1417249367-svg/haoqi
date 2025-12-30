////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CHAT 对话框 20140522 
////////////////////////////////////////////////////////////////////////////////////////////////////////////

//发送文件
function sendFile()
{
   
	var recver = $(currWin).attr("loginname");
	var inputFile = $(".inputfile",currWin);
	var fileName = $(inputFile).val() ;
	
	if (recver == undefined)
	{
		myAlert("currWin error");
	    return ;
	}
	
    if (fileName == "")
    {
    	myAlert(langs.chat_file_select);
        return false ;
    }
	fileName = fileName.substring(fileName.lastIndexOf("\\") + 1 ,fileName.length) ; 
	
    var fileId = guid32();

	//发送文件
	var url = appPath + uploadUrl + "?fileid=" + fileId + "&recver=" + recver ;
	//document.write(url);
    $("form",currWin).attr("action",url).submit();
    $(".popu-file",currWin).hide();
	
	sendFileBefore(recver,fileId,fileName);
    
}
//上传之前在对话框中加提示,发送文件与截图都用于
// fileId 用于上传完成后修改内容,sendFileComplete中要用到
function sendFileBefore(recver,fileId,fileName)
{
	var content = "" ;
	content = langs.chat_file_sending.replace("{FileName}",fileName) ;
	content = "<div id='file" + fileId + "'>" + content + "</div>" ;
	printMsg(fileId,"",1,content,0,1);
	update10();
}

//发送文件完成
//上传之前在对话框中加提示,发送文件与截图都用于
// {status:1,recver:,fileid:filepath,filename,filesize,}
function uploadComplete(data)
{
	//alert(JSON.stringify(data));
	if (data.status == 0)
        return  ;
		
	data.filename=unescape(data.filename);
	var src = get_download_url(data.filepath);
	
	switch (get_filetype(data.filepath)) {
	case "mp3":
	var msg = escape("{d@" + data.filepath + "|"+data.filesize+"|0|}") ;
	break;
	case "img":
	var msg = escape("{e@" + data.filepath + "|"+data.filesize+"|0|}") ;
	break;
	case "mpeg":
	var msg = escape("{i@" + data.filepath + "|"+data.filesize+"|0|FileRecv/MessageVideoPlay.png}") ;
	break;
	default:
	var msg = escape("{a@" + data.filepath + "}") ;
	break;
	}	
	var content = PastImgEx(msg,1) ;

	var file_container = $("#file" + data.fileid) ;
	$(file_container).html(content);
	lastWriteTime = new Date() ;
	formatMsgContent(file_container);
	update10();
	//data.filepath = appPath + data.filepath ;
    //var msg = langs.chat_file_msg.replace("{FileName}",data.filename).replace("{FilePath}",data.filepath) ;
	
	//记录附件
	saveAttach(data.filename,data.filesize,src,ATTACH_VISITER_SEND) ;

    //SendMessage(data.recver,data.filename,msg);
	
	var param = {msg_id:data.fileid,youid:data.recver,myid:my.userid,chatid:chatId,ispush:1,usertext:msg,to_type:1,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,point:0};
    var url = getAjaxUrl("msg_kf","SendKefuMessage") ; 
    $.getJSON(url,param , function(result){
		if (result.status)
		{
			send_message(data.recver,result.msg);
		}
    }); 
}

//启动截屏

function startScreenShot()
{
	var recver = $(currWin).attr("loginname");
	var url = appPath + uploadUrl + "?op=screenhot&recver=" + recver ;

    //截屏控件URL不支持@
    url = replaceAll(url,"@","---") ;
	//set upload url by recver
	UDCAPTURE_SAVEFILE = url ;
//	if (udCapCtl != null)
//		udCapCtl.PostUrl = url ;
//	
//	f_capture();

}

var screenshot_fileid = "" ;
function screenshotUploadBefore()
{
	//$("[type='checkbox']").prop("checked",false); // 方法1
	screenshot_fileid = guid32();
    var content = "<div id='" + screenshot_fileid + "'>" + langs.chat_screenshot_sending + "</div>" ;
	var recver = $(currWin).attr("loginname");
	printMsg(screenshot_fileid,"",1,content,0,1);
	update10();
}

function screenshotComplete(data)
{
    var src = get_download_url(data.filepath);
	printMsgByImage(screenshot_fileid,src) ;
	update10();
    lastWriteTime = new Date() ;
    
	var msg = escape("{e@" + data.filepath + "|"+data.filesize+"|0|}") ;
	//data.filepath = appPath + data.filepath ;
    //SendMessage(data.recver,data.filename,msg);
	
	//记录附件
	 saveAttach(data.filename,data.filesize,src,ATTACH_VISITER_SEND) ;
	
	var param = {msg_id:screenshot_fileid,youid:data.recver,myid:my.userid,chatid:chatId,ispush:1,usertext:msg,to_type:1,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,point:0};
	//alert(url+JSON.stringify(param));
    var url = getAjaxUrl("msg_kf","SendKefuMessage") ; 
    $.getJSON(url,param , function(result){
		if (result.status)
		{
			send_message(data.recver,result.msg);
		}
    }); 
}

function paste_img(e) {
    if (e.clipboardData && e.clipboardData.items) {
        var imageContent = e.clipboardData.getData('image/png');
        var ele = e.clipboardData.items;
        for (var i = 0; i < ele.length; ++i) {
        	//粘贴图片
            if (ele[i].kind == 'file' && ele[i].type.indexOf('image/') !== -1) {
                var blob = ele[i].getAsFile();
                window.URL = window.URL || window.webkitURL;
                var blobUrl = window.URL.createObjectURL(blob);
                uploadImg(blob,"imgpaste.png");
				return false; 
            } 
            else{
            	//alert('没有图片');
            }
        }
    }
    else {
        //alert('不支持的浏览器');
    }
}
//前端上传方法
function uploadImg(obj,name) {
    //发送的数据
    var recver = $(currWin).attr("loginname");
	var fileId = guid32();
	//发送文件
	var url = appPath + uploadUrl + "?op=kefufile&fileid=" + fileId + "&recver=" + recver ;
	sendFileBefore(recver,fileId,name);
	var fd = new FormData();
    fd.append("file", obj, name);
    $.ajax({
        type: 'post',
        url: url,
        data: fd,
        contentType: false,// 当有文件要上传时，此项是必须的，否则后台无法识别文件流的起始位置(详见：#1)
        processData: false,// 是否序列化data属性，默认true(注意：false时type必须是post，详见：#2)
        success: function(data) {
//			var messagebox = $(".messagebox",currWin) ;
//			$(messagebox).html("").focus() ;
			uploadComplete(JSON.parse(data));
        },error:function(e){
        	alert(e);
        }
    })
}

function tip(content)
{
	var recver = $(currWin).attr("loginname");
	printMsg(chater,0,content,true)
}

function printMsgByImage(fileId,fileUrl)
{
	var file_container = $("#" + fileId) ;
	$(file_container).html(get_thumbview(fileUrl));
	formatMsgContent(file_container);
}

function reconnectChat() 
{
//    var Request = new Object();
//    Request = GetRequest();
//	chater.loginname = Request.loginname;
//	setCookie(cookieHCID1,"") ;
    connectChat();
	
}

function reconnectChat1() 
{
    connectChat(0);
}

//保存谈话内容
function saveRecord() 
{

	var content = $(".chat-record",currWin).html();
    var windowSave = window.open();
    var time=new Date();
	var filename=time.toLocaleDateString();
	filename="Record-" + filename + ".htm";
	
    var path = location.href ;
    path = path.substring(0,path.lastIndexOf("/")) ;
    var savestyle='<link rel="stylesheet" href="' + path + '/assets/css/common.css" />';
    windowSave.document.open("text/html", "utf-8");		
	windowSave.document.write("<html><body><head>"+savestyle+"</head>");	
    windowSave.document.write(content);	
	windowSave.document.write("</body></html>");
	
    var ua = navigator.userAgent.toLowerCase();
    if (window.ActiveXObject)
    {
        windowSave.document.execCommand("SaveAs", true, filename);
        windowSave.close();
    }
	
}

//发送消息
function sendMsg(msg,isPrint,win)
{
    if (win == undefined)
        win = currWin ;
		
    if (isPrint == undefined)
        isPrint = true ;
        
	//发送框中的数据
	var messagebox = $(".messagebox",currWin) ;
	
    if (msg == undefined)
    {
        msg = $(messagebox).html();
        $(messagebox).html("").focus() ;
    }

    if (msg == "")
    {
    	myAlert(langs.chat_content_require) ;
        $(messagebox).focus() ;
        return ;
    }

    msg = inputUText(HTML2BA(msg));
    var content = escape(msg) ;
	
	var subject = content ;
	if (subject.length>50)
		subject = subject.substr(0,50) ;
    subject = replaceAll(subject,"\n","");

	var recver = $(currWin).attr("loginname");

	//SendMessage(recver,subject,content)
	if(__uuids.indexOf(recver) == -1) var ispush=1;
	else var ispush=0;
	var msg_id=guid32();
	if (isPrint){
		printMsg(msg_id,"",1,msg,0,1);
		update10();
	}
	var param = {msg_id:msg_id,youid:recver,myid:my.userid,chatid:chatId,ispush:ispush,usertext:content,to_type:1,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5,point:0};
    var url = getAjaxUrl("msg_kf","SendKefuMessage") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//alert(JSON.stringify(result));
		if (result.status)
		{
			switch (parseInt(result.col_receive)) {
			case 0:
			printMsg(result.mychater_msg_id,langs.lv_chat_system,2,result.usertext,0,1);
			update10();
			break;
			case 1:
			send_message(recver,msg_id);
			send_message(recver,result.mychater_msg_id);
			printMsg(result.mychater_msg_id,langs.lv_chat_system,2,result.usertext,0,1);
			update10();
			break;
			case 2:
//			if(!cookieHCID5) return ;
//			if(!ChatGPTAppid){
//				printMsg(0,langs.lv_chat_system,3,langs.msg_recv_chatgpt2,0,1);
//				return ;
//			}
//			if(!ChatGPTType){
//				printMsg(0,langs.lv_chat_system,3,langs.msg_recv_chatgpt1,0,1);
//				return ;
//			}
//			var msg_id=guid32();
			if(!result.usertext) return ;
			printMsg(result.mychater_msg_id,langs.lv_chat_system,result.to_type,result.usertext,0,1);
			update10();
//			sendChatGPT(0,msg_id,msg);
			break;
			case 3:
			send_message(recver,msg_id);
			var container  = $(".chat-content",currWin);
			if($(".msg-0",container).length>0){
				 var msgTip=$(".msg-0",container).eq(0);
				 printMsg(0,langs.lv_chat_system,3,$(".msg-content",msgTip).html(),0,1);
			}
			break;
			case 4:
			cookieHCID5 = 0;
			var transfer_image="robot.png";
			var transfer_title=langs.chart_robot;
			var usertext=langs.msg_recv_chatgpt6;
			printMsg(0,langs.lv_chat_system,3,usertext,0,1);
			$('#transfer').attr("title",transfer_title);
			$('#transfer span').css('background-image','url(assets/img/'+transfer_image+')');
			$('#robotlogo').hide();
			break;
			}
		}
    }); 
	

		
	$(messagebox).focus() ;
}

//发送消息
function m_sendMsg(obj)
{
	//console.log(chater.connectType +'|'+ CONNECT_TYPE_REQUEST +'|'+chater.lv_chater_ro_to_type +'|'+chater.isConnected);
	if(chater.connectType == CONNECT_TYPE_REQUEST&&chater.lv_chater_ro_to_type==0&&chater.isConnected==0) waitQueue(obj);
	if(parseInt(chater.issilence)){
	  switch (parseInt(chater.issilence)) {
	  case 1:
	  var usertext=langs.lv_chat_issilence;
	  break;
	  case 2:
	  var usertext=langs.lv_chat_issilence2;
	  break;
	  }
	   var obj = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:usertext,isreceipt:0,isAppend:1,myid:chater.loginname,picture:"",time:"",objtype:0,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,pid:0,typename:""};
	   printMsg(obj);
	}
	if(__uuids.indexOf(obj.id) == -1) var ispush=1;
	else var ispush=0;
	//var msg_id=guid32();

	var param1 = {fcname:chater.username,myid:chater.loginname,picture:chater.pic,lv_chater_ro_to_type:chater.lv_chater_ro_to_type};
	var param = {msg_id:obj.msg_id,youid:obj.id,myid:my.userid,chatid:chatId,ispush:ispush,usertext:escape(obj.content),to_type:1,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5,point:0};
    var url = getAjaxUrl("msg_kf","SendKefuMessage") ; 
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		//console.log(JSON.stringify(result));
		if (result.status)
		{
			var usertext=inputUText(HTML2BA(result.usertext));
			switch (parseInt(result.col_receive)) {
			case 0:
			//printMsg(result.mychater_msg_id,langs.lv_chat_system,2,usertext,0,1);
			var obj1 = {msg_id:result.mychater_msg_id,fcname:param1.fcname,to_type:2,usertext:usertext,isreceipt:0,isAppend:2,myid:param1.myid,picture:param1.picture,time:"",objtype:0,lv_chater_ro_to_type:param1.lv_chater_ro_to_type,pid:0,typename:""};
			printMsg(obj1);
			//update10();
			break;
			case 1:
			send_message(obj.id,obj.msg_id);
			send_message(obj.id,result.mychater_msg_id);
			//printMsg(result.mychater_msg_id,langs.lv_chat_system,2,usertext,0,1);
			var obj1 = {msg_id:result.mychater_msg_id,fcname:param1.fcname,to_type:2,usertext:usertext,isreceipt:0,isAppend:2,myid:param1.myid,picture:param1.picture,time:"",objtype:0,lv_chater_ro_to_type:param1.lv_chater_ro_to_type,pid:0,typename:""};
			printMsg(obj1);
			//update10();
			break;
			case 2:
			//printMsg(result.mychater_msg_id,langs.lv_chat_system,result.to_type,result.usertext,0,1);
			if(!result.usertext) return ;
			var obj1 = {msg_id:result.mychater_msg_id,fcname:param1.fcname,to_type:result.to_type,usertext:result.usertext,isreceipt:0,isAppend:2,myid:param1.myid,picture:param1.picture,time:"",objtype:0,lv_chater_ro_to_type:param1.lv_chater_ro_to_type,pid:0,typename:""};
			printMsg(obj1);
			//update10();
			break;
			case 3:
			send_message(obj.id,obj.msg_id);
			var container  = $('.layim-chat-main ul','.layim-chat');
			if($(".msg-0",container).length>0){
				var msgTip=$(".msg-0",container).eq(0);
				var kefuobj = {
				  system: true
				  ,id: param1.myid
				  ,type: 'kefu'
				  ,content: $("span",msgTip).html()
				}
				layim_getMessage(kefuobj);	
			}
			break;
			case 4:
			cookieHCID5 = 0;
			var transfer_image='<svg t="1676443980835" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="10514" width="24" height="24"><path d="M923.8 767.1h-42.7V665.4c-8.7 8-17.5 16-26.2 23.5-29.5 25.7-54.3 44.2-73.1 53.2-12.2 5.9-24.7 11.8-41.4 19.7-65.5 31.1-95.4 45.7-130.8 64.6l-249.2 133c-19.7 10.5-41.7 15.9-64.1 15.9-20.4 0-40.6-4.5-59-13.3-35.6-16.9-62-49.7-72.5-89.8l-5.2-19.8c-5.5-21-16.7-55.6-33.7-103.4-34.7-76.6-63.5-132.6-86.2-167.5l-8.1-12.4c-6-9.2-4-21.6 4.7-28.4l36.2-28.5c27.3-21.5 43.2-53.3 44.2-87.9v-3.7c1.7-144 103.1-284.4 241.4-334.5C420.6 63.5 504.7 51 610.9 48.5 813.5 48.5 983.4 206.3 990 401c2.7 79.1-20.8 156.4-66.3 220.9v145.2z m23.6-364.5C941.5 231.3 790.9 91.4 611.6 91.3c-101.8 2.5-181.6 14.3-239 35.1-115 41.6-201.9 155.4-212.2 274.3 1.6 0 3.4 0.1 5.2 0.1 18 0.4 51.2 1.3 81.1 1.3 28.1 0.6 27.9 42.7-0.6 42.7-36-0.6-63-0.9-80.9-0.9h-7.4c-5.7 40.1-26.5 76.4-58.9 101.9L78 562.3c22.5 35.3 49.6 87.8 81.6 157.7 33.1 0.1 60.2-3.8 81.2-11.5 23-8.4 43.6-23.2 61.8-44.6 18.1-21.2 50.2 5 33 27-21.4 27.3-48.4 46.7-80.5 57.8-23.2 8-49.6 12.5-79.3 13.7 12 34.9 20.4 61.2 25.1 79.2l5.2 19.8c7.4 28.1 25.5 50.7 49.5 62.1 12.7 6.1 26.7 9.2 40.7 9.2 15.4 0 30.6-3.7 44-10.9l249.2-133c36.3-19.3 66.6-34.1 132.6-65.5 16.7-7.9 29.1-13.8 41.2-19.6 26.6-12.8 78.3-57.7 122.8-102.4 42-57.8 63.7-127.4 61.3-198.7z m-108 485.9L608.1 989.7c-10.8 4.7-23.4-0.2-28.1-11-4.7-10.8 0.2-23.4 11-28.1l230.1-100.7c-1-5.2-1.5-10.7-1.5-16.2 0-47.1 38.2-85.3 85.3-85.3s85.3 38.2 85.3 85.3c0 47.1-38.2 85.3-85.3 85.3-26.3 0.1-49.8-11.8-65.5-30.5z m65.5-12.1c23.6 0 42.7-19.1 42.7-42.7S928.5 791 904.9 791s-42.7 19.1-42.7 42.7 19.1 42.7 42.7 42.7zM599.4 598.9c-105.2 0-190.5-85.3-190.5-190.5s85.3-190.5 190.5-190.5 190.5 85.3 190.5 190.5-85.3 190.5-190.5 190.5z m0-42.7c81.7 0 147.9-66.2 147.9-147.9S681 260.5 599.4 260.5s-147.9 66.2-147.9 147.9 66.2 147.8 147.9 147.8z m0-105.4c-23.5 0-42.5-19-42.5-42.5s19-42.5 42.5-42.5 42.5 19 42.5 42.5c-0.1 23.5-19.1 42.5-42.5 42.5z m0-42.7c-0.1 0-0.2 0.1-0.2 0.2s0.1 0.2 0.2 0.2 0.2-0.1 0.2-0.2c-0.1-0.1-0.1-0.2-0.2-0.2z" fill="" p-id="10515"></path></svg>';
			var transfer_title=langs.chart_robot;
			var usertext=langs.msg_recv_chatgpt6;
			//printMsg(0,langs.lv_chat_system,3,usertext,0,1);
			var obj1 = {msg_id:0,fcname:langs.lv_chat_system,to_type:3,usertext:usertext,isreceipt:0,isAppend:2,myid:param1.myid,picture:"",time:"",objtype:0,lv_chater_ro_to_type:param1.lv_chater_ro_to_type,pid:0,typename:""};
			printMsg(obj1);
			
			$('.layim-tool-transfer','.layim-chat-footer').attr("title",transfer_title);
			$('.layim-tool-transfer','.layim-chat-footer').html(transfer_image);
			$('#robotlogo').hide();
			break;
			}

		}
    }); 
}

function sendChatGPT(point,msg_id,msg)
{
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "https://api.openai.com/v1/completions", true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.setRequestHeader("Authorization", "Bearer " + ChatGPTAppid);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200){
			console.log('suss',xhr.responseText);
			var response = JSON.parse(xhr.responseText);
			var text = inputUText(HTML2BA(response.choices[0].text.trim().replace("openai:", "").replace("openai：", "").replace(/^\n|\n$/g, "")));
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
			}else{
				var file_container = $(".msg-content",$("#message" + msg_id));
				$(".kl_text6",file_container).html(text);
			}
			
			update10();
			return ;
		}
	}
	var data = JSON.stringify({
		prompt: msg,
		max_tokens: 2048,
		model: "text-davinci-003"
	});
	xhr.send(data);
}

//清屏
function clearRecord(chater)
{
	$(".chat-content",currWin).html("");
}

function transfer()
{
	var param = {point:0,myid:my.userid,youid:chater.loginname,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5};
    var url = getAjaxUrl("livechat_kf","transfer1") ;
	//console.log(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status)
		{
			//console.log(result.msg);
			cookieHCID5 = parseInt(result.msg);
			if(cookieHCID5){
				 var transfer_image="kefu.png";
				 var transfer_title=langs.chart_artificial;
				 var usertext=langs.msg_recv_chatgpt4;
				 $('#robotlogo').show();
			}else{
				var transfer_image="robot.png";
				var transfer_title=langs.chart_robot;
				var usertext=langs.msg_recv_chatgpt5;
				$('#robotlogo').hide();
			}
			printMsg(0,langs.lv_chat_system,3,usertext,0,1);
			$('#transfer').attr("title",transfer_title);
			$('#transfer span').css('background-image','url(assets/img/'+transfer_image+')');
		}
    });
}
//漫游消息
function msgRoam(chater)
{
	chater = $(currWin).attr("loginname");
	var url = getAjaxUrl("passport","password_encrypt","password=" + bigantPassword) ;
	$.ajax({
	   url: url,
	   success: function(response){
		 	url = appPath + "/addin/msg_list.html?loginname=" + my.loginname + "&password=" + response + "&chater=" + chater + "&from=webim" ;
			msgRoam_show(url);
	   }
	}); 
}

function msgRoam_show(url)
{
	var chat_history_width = 470 ;
	var container = $(".chat_history",currWin) ;
	var iframe = $("iframe",container) ;
	if ($(iframe).attr("src"))
	{
		if ($(container).is(":hidden"))
		{
			$(currWin).width($(currWin).width() + chat_history_width);
		}
		else
		{
			$(currWin).width($(currWin).width() - chat_history_width);
		}
		$(container).toggle();
	}
	else
	{
		var height = $(".window_inner",currWin).height() - 30 ;
		$(".chat_history",currWin).css("width",chat_history_width) ;
		$(currWin).width($(currWin).width()+ chat_history_width);
		$(container).html("<iframe class='chat-history' src='" + url + "' style='height:" + height + "px;width:" + chat_history_width + "px;'  ></iframe>").show();
	}
}

function getHTMLContent(data)
{
	if (data.contenttype.toLowerCase() == "text/btf")
	{
		var id = data.cmdid.replace("{","").replace("}","") ;
		var url = getAjaxUrl("msg","read") ;
		$.ajax({
		   type: "POST",
		   url: url,
		   data: {msgid:data.cmdid,datapath:data.datapath},
		   success: function(response){
			 $("#" + id).html(response);
			 formatMsgContent($("#" + id));
			 
			//记录附件
			$("#" + id + " .file-item").each(function(){
				saveAttach($(this).attr("file-name"),$(this).attr("file-size"),$(this).attr("url"),ATTACH_VISITER_RECV) ;  
			})
	 		
		   }
		}); 
		return "<span id='" + id + "'>" + langs.text_loading + "</span>" ; 
	}
	else
	{
		return data.content ;
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

function setBtn(){
	//console.log('fgg'+meetingurl.voiceVideoType);
  if(meetingurl.voiceVideoType){
	  $('.layim-tool-audio').hide();
	  $('.layim-tool-video').hide();
  }
  if(!ChatGPTTransferType){
	  $('.layim-tool-transfer').hide();
  }
  if(cookieHCID5){
	   var transfer_image='<svg t="1676443186165" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2945" width="24" height="24"><path d="M233.984 531.456c6.656 0 11.776-5.12 11.776-11.776L245.76 302.592c0-3.072-1.536-6.144-3.584-8.704 51.712-97.792 155.648-160.256 268.8-160.256s217.088 62.464 268.8 160.768c-2.048 2.048-3.584 5.12-3.584 8.192l0 217.088c0 6.656 5.12 11.776 11.776 11.776 67.584 0 122.368-53.76 122.368-120.32 0-41.984-22.528-81.408-59.392-102.912-51.2-140.288-187.904-234.496-340.48-234.496S221.696 167.936 169.472 308.224C133.12 330.24 110.592 369.152 110.592 411.136 111.104 477.696 166.4 531.456 233.984 531.456z" p-id="2946"></path><path d="M755.712 633.856c-4.608-2.048-9.728-1.536-13.312 2.048-62.976 57.856-144.896 89.6-231.424 89.6-86.016 0-168.448-31.744-231.424-89.088-3.584-3.072-8.704-4.096-13.312-2.048-123.904 62.464-192.512 170.496-192.512 304.128 0 6.656 5.12 11.776 11.776 11.776l853.504 0c6.656 0 11.776-5.12 11.776-11.776C950.272 804.352 881.152 696.32 755.712 633.856zM885.248 892.416 141.824 892.416c13.824-90.624 76.288-156.672 129.536-187.904 71.68 51.712 147.456 74.752 244.224 74.752 84.48 0 178.176-31.744 240.64-81.408C825.856 738.304 878.592 819.2 885.248 892.416z" p-id="2947"></path><path d="M510.976 182.784c-138.752 0-251.904 110.592-251.904 246.784s113.152 247.296 251.904 247.296 251.392-111.104 251.392-247.296C762.368 293.376 649.728 182.784 510.976 182.784zM699.392 429.056c0 101.888-84.48 184.32-188.416 184.32s-188.416-82.944-188.416-184.32c0-99.84 86.528-184.32 188.416-184.32C614.4 244.736 699.392 327.168 699.392 429.056z" p-id="2948"></path></svg>';
	   var transfer_title=langs.chart_artificial;
	   $('#robotlogo').show();
  }else{
	  var transfer_image='<svg t="1676443980835" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="10514" width="24" height="24"><path d="M923.8 767.1h-42.7V665.4c-8.7 8-17.5 16-26.2 23.5-29.5 25.7-54.3 44.2-73.1 53.2-12.2 5.9-24.7 11.8-41.4 19.7-65.5 31.1-95.4 45.7-130.8 64.6l-249.2 133c-19.7 10.5-41.7 15.9-64.1 15.9-20.4 0-40.6-4.5-59-13.3-35.6-16.9-62-49.7-72.5-89.8l-5.2-19.8c-5.5-21-16.7-55.6-33.7-103.4-34.7-76.6-63.5-132.6-86.2-167.5l-8.1-12.4c-6-9.2-4-21.6 4.7-28.4l36.2-28.5c27.3-21.5 43.2-53.3 44.2-87.9v-3.7c1.7-144 103.1-284.4 241.4-334.5C420.6 63.5 504.7 51 610.9 48.5 813.5 48.5 983.4 206.3 990 401c2.7 79.1-20.8 156.4-66.3 220.9v145.2z m23.6-364.5C941.5 231.3 790.9 91.4 611.6 91.3c-101.8 2.5-181.6 14.3-239 35.1-115 41.6-201.9 155.4-212.2 274.3 1.6 0 3.4 0.1 5.2 0.1 18 0.4 51.2 1.3 81.1 1.3 28.1 0.6 27.9 42.7-0.6 42.7-36-0.6-63-0.9-80.9-0.9h-7.4c-5.7 40.1-26.5 76.4-58.9 101.9L78 562.3c22.5 35.3 49.6 87.8 81.6 157.7 33.1 0.1 60.2-3.8 81.2-11.5 23-8.4 43.6-23.2 61.8-44.6 18.1-21.2 50.2 5 33 27-21.4 27.3-48.4 46.7-80.5 57.8-23.2 8-49.6 12.5-79.3 13.7 12 34.9 20.4 61.2 25.1 79.2l5.2 19.8c7.4 28.1 25.5 50.7 49.5 62.1 12.7 6.1 26.7 9.2 40.7 9.2 15.4 0 30.6-3.7 44-10.9l249.2-133c36.3-19.3 66.6-34.1 132.6-65.5 16.7-7.9 29.1-13.8 41.2-19.6 26.6-12.8 78.3-57.7 122.8-102.4 42-57.8 63.7-127.4 61.3-198.7z m-108 485.9L608.1 989.7c-10.8 4.7-23.4-0.2-28.1-11-4.7-10.8 0.2-23.4 11-28.1l230.1-100.7c-1-5.2-1.5-10.7-1.5-16.2 0-47.1 38.2-85.3 85.3-85.3s85.3 38.2 85.3 85.3c0 47.1-38.2 85.3-85.3 85.3-26.3 0.1-49.8-11.8-65.5-30.5z m65.5-12.1c23.6 0 42.7-19.1 42.7-42.7S928.5 791 904.9 791s-42.7 19.1-42.7 42.7 19.1 42.7 42.7 42.7zM599.4 598.9c-105.2 0-190.5-85.3-190.5-190.5s85.3-190.5 190.5-190.5 190.5 85.3 190.5 190.5-85.3 190.5-190.5 190.5z m0-42.7c81.7 0 147.9-66.2 147.9-147.9S681 260.5 599.4 260.5s-147.9 66.2-147.9 147.9 66.2 147.8 147.9 147.8z m0-105.4c-23.5 0-42.5-19-42.5-42.5s19-42.5 42.5-42.5 42.5 19 42.5 42.5c-0.1 23.5-19.1 42.5-42.5 42.5z m0-42.7c-0.1 0-0.2 0.1-0.2 0.2s0.1 0.2 0.2 0.2 0.2-0.1 0.2-0.2c-0.1-0.1-0.1-0.2-0.2-0.2z" fill="" p-id="10515"></path></svg>';
	  var transfer_title=langs.chart_robot;
	  $('#robotlogo').hide();
  }
  $('.layim-tool-transfer').attr("title",transfer_title);
  $('.layim-tool-transfer').html(transfer_image);
};


function get_location() {
   // e.preventDefault();
	// navigator.geolocation.getCurrentPosition(showPosition,showError);
	$('.musk').show();
	$('.map_box').show();

	map = new BMapGL.Map("allmap");
	var point = new BMapGL.Point(116.331398,39.897445);
	map.enableScrollWheelZoom();
	map.centerAndZoom(point,17);
	var myIcon = new BMapGL.Icon("/livechat/assets/img/icons-map.png", new BMapGL.Size(36, 36));
	 map.addEventListener("click", function (e) {    //给地图添加点击事件
			if(mk) map.removeOverlay(mk);
			//map.clearOverlays();
			lng = e.latlng.lng;
			lat = e.latlng.lat;
			//创建标注位置
			pt = e.latlng;
			mk = new BMapGL.Marker(pt, {icon: myIcon});  // 创建标注
			map.addOverlay(mk);  // 将标注添加到地图中
		});
	var geolocation = new BMapGL.Geolocation();
	geolocation.getCurrentPosition(function(e){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			lng = e.point.lng;
			lat = e.point.lat;
			pt = e.point;
			mk = new BMapGL.Marker(pt, {icon: myIcon});
			map.addOverlay(mk);
			map.panTo(pt);
			
		}else{
			showError('failed'+this.getStatus());
		}
	},{enableHighAccuracy: true})
}

function searchNearby(e){
	if(e!=null&&typeof(e)!='undefined'){
		e.stopPropagation();
	    e.preventDefault();
	}
	map.clearOverlays();
    var searchText=($('#search').val()).trim();
	var local =  new BMapGL.LocalSearch(map, {renderOptions: {map: map, autoViewport: false}});  
    local.searchNearby(searchText,pt,1000);
}

function sendPosition(e){
	if(e!=null&&typeof(e)!='undefined'){
		e.stopPropagation();
	    e.preventDefault();
	}
	$('.musk').hide();
	$('.map_box').hide();
	layer.msg('定位中..');
	var myGeo = new BMapGL.Geocoder();
	var myAddress="";
	// 根据坐标得到地址描述
	myGeo.getLocation(pt, function(result){
		if (result){
			myAddress= result.address;
			var msg = "{c@x="+lng+":y="+lat+"}<p>"+myAddress+"</p>" ;
			layim_sendMessage1(msg);
		}else{
			showError("获取定位地址失败");
		}
	});

}

function showError(error){
	layer.msg("定位失败");
}