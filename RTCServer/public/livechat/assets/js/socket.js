////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Flash Event
//2014-05-22
////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//接收FLASH命令
////////////////////////////////////////////////////////////////////////////////////////////////////////////

function LiveChatCallBack(cmdName,param)
{
	//trace(cmdName + ":" + param);
    param = replaceAll(param,"%20", " ") ;
    
    try{
        param = eval("(" + param + ")") ;
        for(var i in param)
            param[i] = resCode(param[i]) ;
    }
    catch(err)
    {
    
    }
	
    switch (cmdName)
    {
        case "onBAConnect":
            onBAConnect(param) ;
            break; 
        case "onBADisconnect":
            onBADisconnect() ;
            break; 
        case "onBARecMsg":
            if (param.subject == "::RefuseFile")
                return ;
            if (param.subject == "::DownloadFile")
                return ;
            onBARecMsg(param);
            break; 
         case "onBARecAttach":
            onBARecAttach(param);
            break ;
         case "onBAChangeTalker":
            onBAChangeTalker(param);
            break ;
//         case "onBALoadEmpView":
//            onBALoadEmpView(param);
//            break ;
//         case "onBALoadEmpItem":
//            onBALoadEmpItem(param);
//            break ;
//         case "onBAUserStatus":
//            onBAUserStatus(param) ;
//            break ;
//		 case "onBALoadUserInfo":
//		 	onBALoadUserInfo(param);
//			break ;
		 case "onBAError":
		 	onBAError(param);
			break ;
         case "onBAOut":
            onBAOut();
            break ;
         case "onBAAlter":
        	 myAlert(param);
            break ;
         default:
            break ;
    } 
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//连接成功
//{result:1,userid:'70',loginname:'jc@aipu.com',username:'%u91D1%u5B58',note:''}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onBAConnect(data)
{
	onLogined(data) ;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//接收消息
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onBARecMsg(result)
{
	//window.prompt("",json2str(result));
    //过滤一个不支持的格式
    
    if (result.content == "::Shake")
        result.content = langs.chat_shake;

    if ((result.msgexttype == "AntAv") || (result.msgexttype == "AntRA"))
    {
        if (result.content.indexOf("End") > -1)
            return ;
            
        if (result.content.indexOf("AudioReq") > -1)    
            result.content = langs.chat_audio_fail;
            
        if (result.content.indexOf("VideoReq") > -1)    
            result.content = langs.chat_video_fail;
            
        if (result.content.indexOf("RAReq") > -1)    
            result.content = langs.chat_remote_fail;

    }
   

	recvMsg(result);

}



function onBARecAttach(result)
{
    var fileName = result.attach.substring(0,result.attach.indexOf("/")) ;
    var extendFileName = "" ;
    var dataPath = replaceAll(result.datapath,"@@@","/").toLowerCase() ;
    dataPath =  replaceAll(dataPath,"webroot/",antServer + ":" + antPort + "/") ; 
    var url = "http://" + dataPath + "/" + result.cmdid + "_" +  fileName ;
    var content = "" ;
    if (fileName.lastIndexOf(".")>-1)
        extendFileName = fileName.substring(fileName.lastIndexOf("."),fileName.length).toLowerCase() ;
    if (".jpg,.png,.gif,.bmp".indexOf(extendFileName) > -1)
        content = "<a href='" +　url　+　"' target='_blank'><img src='" + url + "' class='pic'></a>" ;
    else
        content = "<a href='" +　url　+　"' target='_blank'>" + fileName + "</a>" ;
    
    result.content = content ;
    recvMsg(result) ;

}


//用户上下线通知
function onBAUserStatus(data)
{
	setUserStatus(data);
}

//
function onBALoadEmpView(data)
{
	if (data.viewtype == 2)
		data.viewname = "我的联系人" ;
    addRootItem(data);
}


function onBALoadEmpItem(data)
{
	data.emptype = parseInt(data.emptype);
	data.empid = parseInt(data.empid);
	
	if (isNaN(data.emptype))
		data.emptype = 0 ;
	if (isNaN(data.empid))
		data.empid = 0 ;

    addNodeItem(data);
}

function onBALoadUserInfo(data)
{
	loadUserInfo(data) ;
}

function onBAOut()
{
	myAlert(langs.login_out);
    logout() ;
    
}

function onBADisconnect()
{
	myAlert(langs.login_disconnect);
    logout() ;
}

function onBAError(param)
{
	myAlert(param.errnum);
    logout() ;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//发送FLASH命令
////////////////////////////////////////////////////////////////////////////////////////////////////////////

function MonitorStatus(loginNames)
{
    if (loginNames == "")
        return ;

    document.getElementById("Talk").MonitorStatus(loginNames) ;
    trace("MonitorStatus:" + loginNames);
}

function GetMessage(cmdId,dataPath)
{
    document.getElementById("Talk").GetMessage(cmdId,dataPath) ;
}

//发送消息
//msgType: 0 消息  1群发   7 公告;
function SendMessage(recver,subject,content,msgType)
{
	if (msgType == undefined)
		msgType = 0 ;
    document.getElementById("Talk").SendMessage2(recver,subject,content,msgType) ;
}

//设置消息已读
function SendMessageReaded(cmdId,subject)
{
    document.getElementById("Talk").SendMessageReaded(cmdId,subject) ;
}


function GetEmpView()
{
    document.getElementById("Talk").GetEmpView() ;
}

function GetEmpItem(empType,empId)
{
    document.getElementById("Talk").GetEmpItem(empType,empId) ;
}

function GetUserInfo(loginName)
{
	document.getElementById("Talk").GetUserInfo(loginName) ;
}
function SetLogout()
{
    document.getElementById("Talk").Logout() ;
}


