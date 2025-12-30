//====================================================================================
// 列表界面
// JC 2014-06-20
//====================================================================================
var chaterList ;
var listPos ;
var win  ;
var index_r_index;
//var lv = "";
window.addEventListener("message",function(obj){
    var data = obj.data;
	switch (data.cmd) {
	case 'flashTitle':
	  flashTitle(data.params);
	  break;
	case 'stopFlash':
	  stopFlash();
	  break;
	case 'sendmessage':
	  initInvite(data.params,loginname,typeid);
	  break;
	case 'initInvite':
	  initInvite(invite.welcomeText,data.params);
	  break;
	case 'talk_r':
	  talk_r(data.params,typeid);
	  break;
	case 'restore':
	  layer.restore(index_r_index);
	  break;
	case 'scrolltop':
        setTimeout(function() {
            var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
            window.scrollTo(0, Math.max(scrollHeight - 1, 0));
        }, 100);
	  break;
	case 'endpc':
	  layer.close(parseInt(data.params));
	  //setCookie(cookieHCID3,0) ;
	  var myIframe = document.getElementById("frmrtc_hidden1");
	  myIframe.contentWindow.postMessage({
				cmd: 'setCookie3',
				params: 0
			  }, '*');
//	  if (op == 1){
//		  getIframe("frmrtc_hidden");
//		  var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&isweb=1&isend=1&loginname=&rnd=" + Math.random();
//		  if(userid) url +="&userid=" + userid;
//		  if(fcname) url +="&username=" + fcname;
//		  if(phone) url +="&phone=" + phone;
//		  if(email) url +="&email=" + email;
//		  if(qq) url +="&qq=" + qq;
//		  if(wechat) url +="&wechat=" + wechat;
//		  if(remarks) url +="&remarks=" + remarks;
//		  frmrtc_hidden.location.href = url ;
//	  };
	  break;
	case 'end':
	  layer.closeAll();
	  //setCookie(cookieHCID3,0) ;
	  var myIframe = document.getElementById("frmrtc_hidden1");
	  myIframe.contentWindow.postMessage({
				cmd: 'setCookie3',
				params: 0
			  }, '*');
	  if (op == 1){
//		  getIframe("frmrtc_hidden");
//		  var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&isweb=1&isend=1&loginname=&rnd=" + Math.random();
//		  if(userid) url +="&userid=" + userid;
//		  if(fcname) url +="&username=" + fcname;
//		  if(phone) url +="&phone=" + phone;
//		  if(email) url +="&email=" + email;
//		  if(qq) url +="&qq=" + qq;
//		  if(wechat) url +="&wechat=" + wechat;
//		  if(remarks) url +="&remarks=" + remarks;
//		  frmrtc_hidden.location.href = url ;
	  }else if (op == 2) window.history.back();
	  break;
	}
});
/////////////////////////////////////////////////////////////////////////////////
//画LIST
/////////////////////////////////////////////////////////////////////////////////
function initList(_listPos)
{

    //chaterList = _list ;
    listPos = _listPos ;
//    if (chaterList.length == 0)
//        return ;

    if ($("#livechat").html() != undefined)
        return ;


	if(ismobile){
	var str = '<button id="livechat" class="common-quick-nav common-online-service flutter"></button>';
    $("body").append(str) ;
    var html = "";
    html += '<image data-status="0" src="' + rootPath + '/static/img/online-service-icon.png" class="livechat-user dis-block"></image>' ;
    $("#livechat").html(html);

    $("#livechat").css("left",listPos.left).css("top",listPos.top) ;
	//$("#livechat").attr("data-top", parseInt($("#livechat").offset().top)) ;
	}else{
	var str = '<dl id="livechat" class="flutter"><dt>'+lv+'</dt><dd></dd></dl>';
    $("body").append(str) ;

    drawList($("#livechat dd")) ;

    $("#livechat").css("left",listPos.left).css("top",listPos.top) ;
	//$("#livechat").attr("data-top", parseInt($("#livechat").offset().top)) ;
	}

//    $(window).scroll( function() {
//        $(".flutter").each(function(){
//            $(this).css("top",$(window).scrollTop() + parseInt($(this).attr("data-top"))) ;
//        })
//    });
}
/////////////////////////////////////////////////////////////////////////////////
//画Invite
/////////////////////////////////////////////////////////////////////////////////
function initInvite(usertext,loginName,typeid)
{
    //chaterList = _list ;
    listPos = invitePos ;
//    if (chaterList.length == 0)
//        return ;
    if ($(".ysf-online-invite-wrap").html() != undefined) $(".ysf-online-invite-wrap .ysf-online-invite .text").html(usertext) ;
	else{
	var str = '<div class="ysf-online-invite-wrap"><div class="ysf-online-invite" style="cursor:default;width:250px;height:90px;margin-top:45px"><div class="text">'+usertext+'</div><div class="close custom" title="关闭"></div><img class="ysf-online-invite-img" src="' + rootPath + "/livechat/assets/img/invitebg.png" + '"/></div></div>';
    $("body").append(str) ;

    $(".ysf-online-invite-wrap").css("left",listPos.left).css("top",listPos.top) ;
//	$(".ysf-online-invite-wrap").attr("data-top", parseInt($(".ysf-online-invite-wrap").offset().top)) ;
//	
//    $(window).scroll( function() {
//        $(".ysf-online-invite-wrap").each(function(){
//            $(this).css("top",$(window).scrollTop() + parseInt($(this).attr("data-top"))) ;
//        })
//    });
	
	$(".ysf-online-invite").click(function(){
		//$("#frmrtc_hidden").remove();
		talk(loginName,typeid) ;
	});

	$(".ysf-online-invite-wrap .custom")
	.mousedown(function(ev){
		if (ev.stopPropagation) { 
		// this code is for Mozilla and Opera 
		ev.stopPropagation(); 
		} 
		else { 
		// this code is for IE 
		window.event.cancelBubble = true; 
		}
	})
	
	$(".ysf-online-invite-wrap .custom")
	.mouseup(function () {
		$(".ysf-online-invite-wrap").remove();
//		if (0 != invite.rejectType){
//            setTimeout(function() {
//                initInvite(invitePos);
//            }, 1000 * invite.intervalTime);	
//		}
	}); 
	}
}

/////////////////////////////////////////////////////////////////////////////////
//画LIST
/////////////////////////////////////////////////////////////////////////////////
function drawList(container)
{
    var html = "";
    html += "<ul class='livechat-list'>" ;
//    for(var i=0;i<chaterList.length;i++)
//    {
    html += "<li class='livechat-user' data-status='0'><a href='#'>&nbsp;&nbsp;" + lv + "</a></li>" ;
//    }
    html += "</ul>" ;
    $(container).html(html);
}

//function initRate()
//{
//    listPos = ratePos ;
//	if(!$(".popu-rate").html()){
//		var str = '<div class="popu popu-rate popu-stop"  style="width:340px;padding:5px;">'
//									+'<div>'+langs.chart_rate_note+'</div>'
//									+'<div>'
//										+'<label><input type="radio" name="rate" checked value="5" />5'+langs.chart_rate_unit+'</label>'
//										+'<label><input type="radio" name="rate"  value="4" />4'+langs.chart_rate_unit+'</label>'
//										+'<label><input type="radio" name="rate"  value="3" />3'+langs.chart_rate_unit+'</label>'
//										+'<label><input type="radio" name="rate"  value="2" />2'+langs.chart_rate_unit+'</label>'
//										+'<label><input type="radio" name="rate"  value="1" />1'+langs.chart_rate_unit+'</label>'
//									+'</div>'
//									+'<div>'
//										+'<textarea class="form-control" id="ratenote" name="ratenote" style="height:100px;width:100%;"></textarea>'
//									+'</div>'
//									+'<div style="text-align:right;padding:5px 0px;">'
//										+'<input type="button" value="'+langs.login_cancel+'" onclick="hideRate();" style="padding:5px 10px;margin-right:10px;" />'
//										+'<input type="button" value="'+langs.chart_rate+'" onclick="sendRate()"  style="padding:5px 10px"/>'
//									+'</div>'
//								+'</div>';
//		$("body").append(str) ;
//		$(".popu-rate").css("left",listPos.left).css("top",listPos.top) ;
//	}
//	$('.popu-rate').show();
//}
//
//function sendRate()
//{
//    var rate = getRadioValue("rate") ;
//    var note = $("#ratenote").val() ;
//    var param = {chatId:chatId,rate:rate,note:escape(note)};
//    var url = getAjaxUrl("livechat_kf","PostRate") ;
//	//document.write(url+JSON.stringify(param));
//    $.getJSON(url,param, function(result){
//        myAlert(langs.lv_rate_success);
//        isPostRate = true ;
//        $(".popu-rate").hide();
//    }); 
//}
//
//function hideRate()
//{
//	$('.popu-rate').hide();
//}


/////////////////////////////////////////////////////////////////////////////////
//点亮
/////////////////////////////////////////////////////////////////////////////////
function light()
{
    $(".livechat-user").each(function(){
        var loginName = $(this).attr("data-loginname") ;
		
        var status = getOnline(loginName);
        $(this).addClass("status-" + status).attr("data-status",status) ;
    })
}

function getOnline(_loginName)
{
	
    for(var i=0;i<UserList.length;i++)
    {
       if (UserList[i].LoginName.toLowerCase() == _loginName.toLowerCase())
			return UserList[i].Online ;
    }
    return 0 ;
}

/////////////////////////////////////////////////////////////////////////////////
//得到所有的LOGINNAMES
/////////////////////////////////////////////////////////////////////////////////
function getLoginNames(_list)
{
    var loginnames = "," ;
    $(".livechat-user").each(function(){
        var loginName = $(this).attr("data-loginname").toLowerCase() ;
        if (loginnames.indexOf("," + loginName + ",") == -1)
            loginnames += loginName + "," ;
    })

    //去掉头尾的,号
    if (loginnames == ",")
        loginnames = "" ;
    if (loginnames != "")
    {
        loginnames = loginnames.substring(1,loginnames.length-1) ;
    }
    return loginnames ;
}

var win  ;	
function talk(loginName,typeid)
{
	$(".ysf-online-invite-wrap").remove();
//	if($("#frmrtc_hidden")) $("#frmrtc_hidden").remove();

	var w = 800;
	var h = 550 ;
	var l = (screen.width-w) / 2 ;
	var t = (screen.height-h) / 2 ;

	var winName = lv ; 
	if(!loginName) loginName="";
	if(!typeid) typeid="";
	//if(String(typeid)=="undefined") typeid="";
	try
	{
		if(ismobile){
//			var url = rootPath1 + "/client?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&rnd=" + Math.random();
//			if(callback_url) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+goods_name+"|"+goods_price+"}"));
//			if(userid) url +="&userid=" + userid;
//			//newWin(url,winName);
//			if(islocation) location.href=url;
//			else win = window.open(url);
			var url = appPath + "mobile.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&rnd=" + Math.random();
			if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
			if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
			newPage(url,winName);
		}else{
			var url = appPath + "do.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&rnd=" + Math.random();
			if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
			if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
			newWin(url,winName);
			//win = window.open(url,winName,"width=" + w + ",height=" + h + ",top=" + t + ",left=" + l + ",scroll=0,resize=auto");
		}
		win.focus();
	}
	catch(err)
	{
 
	}
}

$(".rtclink[href]").click(function (event) {
	var url=$(this).attr("href");
	window.protocolCheck(url,
		function () {
			talk(url.replace("rtc://sendmsg/?UserName=",""));
		});
	event.preventDefault ? event.preventDefault() : event.returnValue = false;
});

function newWin(url, title) {
	layui.use('layer', function(){
	  var layer = layui.layer;
	
		layer.open({
		  type: 2,
		  title: title,
		  maxmin: true,
		  area: ['800px', '550px'],
		  shade: 0,
		  content: url,
		  cancel: function(index, layero){ 
//			var myIframe1 = window[layero.find('iframe')[0]['id']];
//			myIframe.postRate(); //aaa()为子页面的方法
			if(invite.rejectType){
			var myIframe = document.getElementById(layero.find('iframe')[0]['id']);
			myIframe.contentWindow.postMessage({
					  cmd: 'postRate',
					  params: index
					}, '*');
			return false; 
			}else{
//			if (op == 1){
//				getIframe("frmrtc_hidden");
//				var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&isweb=1&isend=1&loginname=&rnd=" + Math.random();
//				if(userid) url +="&userid=" + userid;
//				if(fcname) url +="&username=" + fcname;
//				if(phone) url +="&phone=" + phone;
//				if(email) url +="&email=" + email;
//				if(qq) url +="&qq=" + qq;
//				if(wechat) url +="&wechat=" + wechat;
//				if(remarks) url +="&remarks=" + remarks;
//				frmrtc_hidden.location.href = url ;
//			};
			}
		  },
		  end: function(){
			  //setCookie(cookieHCID3,0) ;
			  var myIframe = document.getElementById("frmrtc_hidden1");
			  myIframe.contentWindow.postMessage({
						cmd: 'setCookie3',
						params: 0
					  }, '*');
//			  if (op == 1){
//				  getIframe("frmrtc_hidden");
//				  var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&isweb=1&isend=1&loginname=&rnd=" + Math.random();
//				  if(userid) url +="&userid=" + userid;
//				  if(fcname) url +="&username=" + fcname;
//				  if(phone) url +="&phone=" + phone;
//				  if(email) url +="&email=" + email;
//				  if(qq) url +="&qq=" + qq;
//				  if(wechat) url +="&wechat=" + wechat;
//				  if(remarks) url +="&remarks=" + remarks;
//				  frmrtc_hidden.location.href = url ;
//			  }
		  }
		}); 
	});  
	//setCookie(cookieHCID3,1) ;
	var myIframe = document.getElementById("frmrtc_hidden1");
	myIframe.contentWindow.postMessage({
			  cmd: 'setCookie3',
			  params: 1
			}, '*');
} 

function talk_r(loginName,typeid) {
	if(ismobile) return false;
	var winName = lv ; 
	if(!loginName) loginName="";
	if(!typeid) typeid="";
	
	var url = appPath + "index_r.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&rnd=" + Math.random();
	if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
	if(userid) url +="&userid=" + userid;
	if(fcname) url +="&username=" + fcname;
	if(phone) url +="&phone=" + phone;
	if(email) url +="&email=" + email;
	if(qq) url +="&qq=" + qq;
	if(wechat) url +="&wechat=" + wechat;
	if(remarks) url +="&remarks=" + remarks;
	layui.use('layer', function(){
	  var layer = layui.layer;
	
		index_r_index = layer.open({
		  type: 2,
		  title: winName,
		  maxmin: true,
//		  min: function(layero, index){
//			  setCookie(cookieHCID3,2) ;
//			  $('.layui-layer').css({
//				  'top': 'auto',
//				  'left': 'auto',
//				  'bottom': '27px',
//				  'right': '0'
//			  })
//		  },
		  full: function(layero, index) {
			  //setCookie(cookieHCID4,3) ;
			  var myIframe = document.getElementById("frmrtc_hidden1");
			  myIframe.contentWindow.postMessage({
						cmd: 'setCookie4',
						params: 3
					  }, '*');
		  },
		  restore: function(layero, index) {
			  //setCookie(cookieHCID4,1) ;
			  var myIframe = document.getElementById("frmrtc_hidden1");
			  myIframe.contentWindow.postMessage({
						cmd: 'setCookie4',
						params: 1
					  }, '*');
		  },
		  area: ['360px', '460px'],
		  offset: 'rb',
		  closeBtn:0,
		  shade: 0,
		  content: url,
		}); 
	});
	//setCookie(cookieHCID4,1) ; 
	var myIframe = document.getElementById("frmrtc_hidden1");
	myIframe.contentWindow.postMessage({
			  cmd: 'setCookie4',
			  params: 1
			}, '*');
} 

function newPage(url, title) {  
	layer.open({
	  type: 1
//	  ,title: [
//      title,
//      'background-color: #FF4351; color:#fff;'
//    ]
	  //,skin: 'footer'
//	  ,shade: true
//	  ,shadeClose: true
	  ,content: '<iframe id="frame_main" name="frame_main" width="100%" src="'+url+'" frameborder="0" ></iframe>'
	  ,anim: 'up'
	  ,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s; z-index:9999999;'
	});
	changeFrameHeight();
	//setCookie(cookieHCID3,1) ;
	var myIframe = document.getElementById("frmrtc_hidden1");
	myIframe.contentWindow.postMessage({
			  cmd: 'setCookie3',
			  params: 1
			}, '*');
//页面层
//  layer.open({
//    type: 1
//    ,content: '<iframe id="frame_main" name="frame_main" height="100%" width="100%" src="http://www.baidu.com" frameborder="0" ></iframe>'
//    ,anim: 'up'
//    ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;'
//  });

} 

function changeFrameHeight(){
    var ifm= document.getElementById("frame_main"); 
    ifm.height=document.documentElement.clientHeight;
}

window.onresize=function(){  
     changeFrameHeight();  
} 

function newWindow(url, id) { 
	var a = document.createElement('a'); 
	a.setAttribute('href', url); 
	a.setAttribute('target', '_blank');
	a.setAttribute('id', id); 
	if(!document.getElementById(id)) { 
	document.body.appendChild(a);
	} 
	a.click(); 
}

function closeWindow(){
	var userAgent = navigator.userAgent;
	if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") !=-1) {
			window.location.href="about:blank";
			window.close();
	} else {
			window.opener = null;
			window.open("", "_self");
			window.close();
	}
}

var flashTitlePlayer = {
    start: function (msg) {
        this.title = document.title;
        if (!this.action) {
            try {
                this.element = document.getElementsByTagName('title')[0];
                this.element.innerHTML = this.title;
                this.action = function (ttl) {
                    this.element.innerHTML = ttl;
                };
            } catch (e) {
                this.action = function (ttl) {
                    document.title = ttl;
                }
                delete this.element;
            }
            this.toggleTitle = function () {
                this.action('【' + this.messages[this.index = this.index == 0 ? 1 : 0] + '】');
            };
        }
        this.messages = [msg];
        var n = msg.length;
        var s = '';
        if (this.element) {
            var num = msg.match(/\w/g);
            if (num != null) {
                var n2 = num.length;
                n -= n2;
                while (n2 > 0) {
                    s += " ";
                    n2--;
                }
            }
        }
        while (n > 0) {
            s += '　';
            n--;
        };
        this.messages.push(s);
        this.index = 0;
        this.timer = setInterval(function () {
            flashTitlePlayer.toggleTitle();
        }, 1000);
    },
    stop: function () {
        if (this.timer) {
            clearInterval(this.timer);
            this.action(this.title);
            delete this.timer;
            delete this.messages;
        }
    }
};
function flashTitle(msg) {
    flashTitlePlayer.start(msg);
}
function stopFlash() {
    flashTitlePlayer.stop();
}