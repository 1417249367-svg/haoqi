<?php
/*
参数说明
antserver		//服务器	默认CONFIG.INC.PHP
antport			//端口		默认CONFIG.INC.PHP
connecttype  	//1 直接推送并发客服提醒  2应答模式  默认2
top				//位置	默认-1
left			//位置	默认-1
right			//位置	默认-1
bottom			//位置	默认-1
containerwidth	//宽度  默认-1
container		//容器  默认body
*/

require_once('../../class/fun.php') ;
$LangType=g("LangType",LANG_TYPE);
$ischathistory=g("ischathistory");
addLangModel2("livechat",$LangType);
	$rootPath = getRootPath();
	$rootPath1 = IPADDRESS;
	$op = g("op",1);
	$top = g("top", -1);
	$left = g("left", -1);
	$right = g("right", -1);
	$bottom = g("bottom", -1);
	$containerwidth = g("containerwidth", -1);
	$container = g("container","body");
	$data  = "" ;
	
	if(!getValue("my_userid")) setValue("my_userid",str_replace('.', '', $_SERVER['REMOTE_ADDR']),-1); 

	if (($left == -1) && ($right == -1))
		$left = 0;

	if (($top == -1) && ($bottom == -1))
		$top = 150;
		
	$username = get_lang('index_service') ;
	$dp = new Model("lv_chater");
	$dp -> addParamWhere("loginname",g("loginName"));
    $row = $dp-> getDetail();
	if (count($row))
		$username =$row["username"] ;
		
	$dp = new Model("lv_chater_ro");
	$dp -> addParamWhere("TypeID",g("typeid"));
    $row = $dp-> getDetail();
	if (count($row))
		$username =$row["typename"] ;
		
	if(SWITCHDOMAINTYPE){
		$config = new SYSConfig();
		$params = array();
		$params[] = $config->create_param("Jump_Domain",0,"LivechatConfig");
		$config -> setConfig($params);
	}
?>
window.onload = function(){
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

    function getScript(url,callback) {
        var s = document.createElement('script');
        s.onload = s.onreadystatechange = function(o) {
          if(!this.readyState || this.readyState == "loaded" || this.readyState == "complete"){
            if (callback != undefined)
                callback();
          }
        }

        s.src = url + '?' + timestamp;
        s.charset = "utf-8";
        document.body.appendChild(s);
    }

    function getStyle(url,callback) {
        var s = document.createElement('link')
        s.rel = 'stylesheet'

        s.onload = s.onreadystatechange = function() {
          if(!this.readyState || this.readyState == "loaded" || this.readyState == "complete"){

            if (callback != undefined)
                callback();
          }
        }

        s.href = url + '?' + timestamp
        head.appendChild(s)
    }
    
    function getIframe(id) {
        var iframe = document.createElement('iframe');  
        iframe.id = id;
        iframe.name = id; 
        iframe.style = 'display:none;';
        document.body.appendChild(iframe);
        $("#"+id).hide();
    }
    
    function getAjaxUrl(obj,op,param)
    {
        var url = rootPath+"/public/" + obj + ".html?op=" + op ;
        if (param != undefined)
            url += "&" + param ;
        url += (url.indexOf("?")>-1)?"&":"?" ;
        url += "rnd=" + Math.random() ;
        return url ;
    }
    
    function is_weixin() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }
    
    //====================================================================================
    // 列表界面
    // JC 2014-06-20
    //====================================================================================
    var chaterList ;
    var listPos ;
    var win  ;
    var index_r_index;
    window.addEventListener("message",function(obj){
        var data = obj.data;
        switch (data.cmd) {
//        case 'flashTitle':
//          flashTitle(data.params);
//          break;
//        case 'stopFlash':
//          stopFlash();
//          break;
        case 'sendmessage':
          initInvite(data.params,loginname,typeid);
          break;
        case 'initInvite':
          initInvite(invite.welcomeText,data.params);
          break;
        case 'talk_r':
          talk_r(data.params,typeid,1);
          break;
        case 'talk_r1':
          talk_r(data.params,typeid,0);
          break;
        case 'restore':
          if(parseInt(cookieHCID4)!=1) return ;
          layer.restore(index_r_index);
          break;
        case 'scrolltop':
            setTimeout(function() {
                var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
                window.scrollTo(0, Math.max(scrollHeight - 1, 0));
            }, 100);
          break;
//        case 'endpc':
//          layer.close(parseInt(data.params));
//          var myIframe = document.getElementById("frmrtc_hidden1");
//          myIframe.contentWindow.postMessage({
//                    cmd: 'setCookie3',
//                    params: 0
//                  }, '*');
//          break;
        case 'end':
          layer.closeAll();
          //setCookie(cookieHCID3,0) ;
          var myIframe = document.getElementById("frmrtc_hidden1");
          myIframe.contentWindow.postMessage({
                    cmd: 'setCookie3',
                    params: 0
                  }, '*');
          if (op == 1){
          }else if (op == 2) window.history.back();
          break;
        }
    });
    /////////////////////////////////////////////////////////////////////////////////
    //画LIST
    /////////////////////////////////////////////////////////////////////////////////
    function initList(_listPos)
    {
        listPos = _listPos ;
    
        if ($("#livechat").html() != undefined)
            return ;
    
        if(ismobile){
        var str = '<button id="livechat" class="common-quick-nav common-online-service flutter"></button>';
        $("body").append(str) ;
        var html = "";
        html += '<image data-status="0" src="' + rootPath + '/static/img/online-service-icon.png" class="livechat-user dis-block"></image>' ;
        $("#livechat").html(html);
    
        $("#livechat").css("left",listPos.left).css("top",listPos.top) ;
        }else{
        var str = '<dl id="livechat" class="flutter flicker"><img class="ysf-online-invite-img" src="' + rootPath + "/livechat/assets/img/dialogue.png" + '"/></dl>';
        $("body").append(str) ;
    
        //drawList($("#livechat dd")) ;
    
        $("#livechat").css("right",listPos.right).css("top",listPos.top) ;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////
    //画Invite
    /////////////////////////////////////////////////////////////////////////////////
    function initInvite(usertext,loginName,typeid)
    {
        listPos = invitePos ;
    
        if ($(".ysf-online-invite-wrap").html() != undefined) $(".ysf-online-invite-wrap .ysf-online-invite .text").html(usertext) ;
        else{
        if(ismobile) var str = '<div class="ysf-online-invite-wrap" style="cursor:default;width:60% !important;height:10% !important;"><div class="ysf-online-invite" style="cursor:default;;margin-top:2.8em;"><div class="text">'+usertext+'</div><div class="close custom" title="关闭"></div><img class="ysf-online-invite-img" src="' + rootPath + "/livechat/assets/img/invitebg.png" + '"/></div></div>';
        else var str = '<div class="ysf-online-invite-wrap"><div class="ysf-online-invite" style="cursor:default;width:250px;height:90px;margin-top:45px"><div class="text">'+usertext+'</div><div class="close custom" title="关闭"></div><img class="ysf-online-invite-img" src="' + rootPath + "/livechat/assets/img/invitebg.png" + '"/></div></div>';
        $("body").append(str) ;
    
        $(".ysf-online-invite-wrap").css("left",listPos.left).css("top",listPos.top) ;
        
        $(".ysf-online-invite").click(function(){
            if(ismobile) talk(loginName,typeid) ;
            else talk_r("<?=g("loginname") ?>","<?=g("typeid") ?>",1) ;
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
        }); 
        }
    }
    
    /////////////////////////////////////////////////////////////////////////////////
    //画LIST
    /////////////////////////////////////////////////////////////////////////////////
//    function drawList(container)
//    {
//        var html = "";
//        html += "<ul class='livechat-list'>" ;
//        html += "<li class='livechat-user' data-status='0'><a href='#'>&nbsp;&nbsp;" + lv + "</a></li>" ;
//        html += "</ul>" ;
//        $(container).html(html);
//    }
    /////////////////////////////////////////////////////////////////////////////////
    //点亮
    /////////////////////////////////////////////////////////////////////////////////
//    function light()
//    {
//        $(".livechat-user").each(function(){
//            var loginName = $(this).attr("data-loginname") ;
//            
//            var status = getOnline(loginName);
//            $(this).addClass("status-" + status).attr("data-status",status) ;
//        })
//    }
    
//    function getOnline(_loginName)
//    {
//        
//        for(var i=0;i<UserList.length;i++)
//        {
//           if (UserList[i].LoginName.toLowerCase() == _loginName.toLowerCase())
//                return UserList[i].Online ;
//        }
//        return 0 ;
//    }
    
    /////////////////////////////////////////////////////////////////////////////////
    //得到所有的LOGINNAMES
    /////////////////////////////////////////////////////////////////////////////////
//    function getLoginNames(_list)
//    {
//        var loginnames = "," ;
//        $(".livechat-user").each(function(){
//            var loginName = $(this).attr("data-loginname").toLowerCase() ;
//            if (loginnames.indexOf("," + loginName + ",") == -1)
//                loginnames += loginName + "," ;
//        })
//    
//        //去掉头尾的,号
//        if (loginnames == ",")
//            loginnames = "" ;
//        if (loginnames != "")
//        {
//            loginnames = loginnames.substring(1,loginnames.length-1) ;
//        }
//        return loginnames ;
//    }
    
    var win  ;	
    function talk(loginName,typeid)
    {
        $(".ysf-online-invite-wrap").remove();
    
        var w = 800;
        var h = 550 ;
        var l = (screen.width-w) / 2 ;
        var t = (screen.height-h) / 2 ;
    
        var winName = lv ; 
        if(!loginName) loginName="";
        if(!typeid) typeid="";
        try
        {
            if(ismobile){
                var url = appPath + "mobile.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&LangType=<?=$LangType?>&ischathistory=<?=$ischathistory?>&my_userid=<?=getValue("my_userid")?>&rnd=" + Math.random();
                if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
                if(userid) url +="&userid=" + userid;
                if(fcname) url +="&username=" + fcname;
                if(phone) url +="&phone=" + phone;
                if(email) url +="&email=" + email;
                if(qq) url +="&qq=" + qq;
                if(wechat) url +="&wechat=" + wechat;
                if(remarks) url +="&remarks=" + remarks;
                if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
                newPage(url,winName);
            }else{
                var url = appPath + "win.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&LangType=<?=$LangType?>&ischathistory=<?=$ischathistory?>&my_userid=<?=getValue("my_userid")?>&rnd=" + Math.random();
                if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
                if(userid) url +="&userid=" + userid;
                if(fcname) url +="&username=" + fcname;
                if(phone) url +="&phone=" + phone;
                if(email) url +="&email=" + email;
                if(qq) url +="&qq=" + qq;
                if(wechat) url +="&wechat=" + wechat;
                if(remarks) url +="&remarks=" + remarks;
                if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
                setTimeout(function() {
                  location.href = url ;
                }, 500);
                //newWin(url,winName);
            }
            win.focus();
        }
        catch(err)
        {
     
        }
    }
    
//    function newWin(url, title) {
//        layui.use('layer', function(){
//          var layer = layui.layer;
//        
//            layer.open({
//              type: 2,
//              title: title,
//              maxmin: true,
//              area: ['800px', '550px'],
//              offset: '100px',
//              shade: 0,
//              content: url,
//              cancel: function(index, layero){ 
//                if(invite.rejectType){
//                var myIframe = document.getElementById(layero.find('iframe')[0]['id']);
//                myIframe.contentWindow.postMessage({
//                          cmd: 'postRate',
//                          params: index
//                        }, '*');
//                return false; 
//                }else{
//                }
//              },
//              end: function(){
//                  var myIframe = document.getElementById("frmrtc_hidden1");
//                  myIframe.contentWindow.postMessage({
//                            cmd: 'setCookie3',
//                            params: 0
//                          }, '*');
//              }
//            }); 
//        });  
//        var myIframe = document.getElementById("frmrtc_hidden1");
//        myIframe.contentWindow.postMessage({
//                  cmd: 'setCookie3',
//                  params: 1
//                }, '*');
//    } 
    
    function talk_r(loginName,typeid,isnotsend) {
        $(".ysf-online-invite-wrap").remove();
        if(ismobile) return false;
        var winName = lv ; 
        if(!loginName) loginName="";
        if(!typeid) typeid="";
        
        var param = {point:0,Chater:loginName,typeid:typeid};
        var url = getAjaxUrl("livechat_kf","chaterrodetail") ; 
        //console.log(url+JSON.stringify(param));
        $.getJSON(url,param , function(result){
            if(result.status){
                    //console.log(JSON.stringify(result));
                var url = appPath + "win_r.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + loginName + "&typeid=" + typeid + "&isnotsend=" + isnotsend + "&LangType=<?=$LangType?>&my_userid=<?=getValue("my_userid")?>&rnd=" + Math.random();
                if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
                if(userid) url +="&userid=" + userid;
                if(fcname) url +="&username=" + fcname;
                if(phone) url +="&phone=" + phone;
                if(email) url +="&email=" + email;
                if(qq) url +="&qq=" + qq;
                if(wechat) url +="&wechat=" + wechat;
                if(remarks) url +="&remarks=" + remarks;
                if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
                layui.use('layer', function(){
                  var layer = layui.layer;
                
                    index_r_index = layer.open({
                      //skin: 'layui-layer-molv',
                      type: 2,
                      title: winName,
                      maxmin: true,
                      full: function(layero, index) {
                          cookieHCID4 = 3;
                          var myIframe = document.getElementById("frmrtc_hidden1");
                          myIframe.contentWindow.postMessage({
                                    cmd: 'setCookie4',
                                    params: 3
                                  }, '*');
                      },
                      restore: function(layero, index) {
                          cookieHCID4 = 1;
                          var myIframe = document.getElementById("frmrtc_hidden1");
                          myIframe.contentWindow.postMessage({
                                    cmd: 'setCookie4',
                                    params: 1
                                  }, '*');
                      },
                      area: ['400px', '550px'],
                      offset: 'rb',
                      closeBtn:0,
                      shade: 0,
                      content: url,
                    }); 
                });
                $("#livechat").hide();
                cookieHCID4 = 1;
                var myIframe = document.getElementById("frmrtc_hidden1");
                myIframe.contentWindow.postMessage({
                          cmd: 'setCookie4',
                          params: 1
                        }, '*');
            }
        }); 
    } 
    
    function newPage(url, title) {  
        layer.open({
          type: 1
          ,content: '<iframe id="frame_main" name="frame_main" width="100%" src="'+url+'" allow = "microphone *;camera *" frameborder="0" ></iframe>'
          ,anim: 'up'
          ,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s; z-index:9999999;'
        });
        changeFrameHeight();
//        var ifm= document.getElementById("frame_main");
//        ifm.allow = "microphone *;camera *";
        var myIframe = document.getElementById("frmrtc_hidden1");
        myIframe.contentWindow.postMessage({
                  cmd: 'setCookie3',
                  params: 1
                }, '*');
    } 
    
    function newPage1(url, title) {  
        layer.open({
          type: 1
          ,content: '<iframe id="frame_main" name="frame_main" width="100%" src="'+url+'" frameborder="0" ></iframe>'
          ,anim: 'up'
          ,style: 'position:fixed; left:0; top:0; width:100%; height:90%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s; z-index:9999999;'
        });
        var ifm= document.getElementById("frame_main"); 
        ifm.height=document.documentElement.clientHeight-50;
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
    
//    var flashTitlePlayer = {
//        start: function (msg) {
//            this.title = document.title;
//            if (!this.action) {
//                try {
//                    this.element = document.getElementsByTagName('title')[0];
//                    this.element.innerHTML = this.title;
//                    this.action = function (ttl) {
//                        this.element.innerHTML = ttl;
//                    };
//                } catch (e) {
//                    this.action = function (ttl) {
//                        document.title = ttl;
//                    }
//                    delete this.element;
//                }
//                this.toggleTitle = function () {
//                    this.action('【' + this.messages[this.index = this.index == 0 ? 1 : 0] + '】');
//                };
//            }
//            this.messages = [msg];
//            var n = msg.length;
//            var s = '';
//            if (this.element) {
//                var num = msg.match(/\w/g);
//                if (num != null) {
//                    var n2 = num.length;
//                    n -= n2;
//                    while (n2 > 0) {
//                        s += " ";
//                        n2--;
//                    }
//                }
//            }
//            while (n > 0) {
//                s += '　';
//                n--;
//            };
//            this.messages.push(s);
//            this.index = 0;
//            this.timer = setInterval(function () {
//                flashTitlePlayer.toggleTitle();
//            }, 1000);
//        },
//        stop: function () {
//            if (this.timer) {
//                clearInterval(this.timer);
//                this.action(this.title);
//                delete this.timer;
//                delete this.messages;
//            }
//        }
//    };
//    function flashTitle(msg) {
//        flashTitlePlayer.start(msg);
//    }
//    function stopFlash() {
//        flashTitlePlayer.stop();
//    }
    
    function wx_init() {
        var param = {userid:userid,redirect_uri:escape(window.location.href)};
        var url = getAjaxUrl("livechat_kf","wxsignature") ; 
        $.getJSON(url,param , function(result){
            wx.config({
              debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
              appId: result.appid, // 必填，公众号的唯一标识
              timestamp: result.timestamp, // 必填，生成签名的时间戳
              nonceStr: result.noncestr, // 必填，生成签名的随机串
              signature: result.signature,// 必填，签名
              jsApiList: [
                'openLocation',
                'getLocation'
              ], // 必填，需要使用的JS接口列表
              openTagList: ['wx-open-subscribe']
            });
            wx.ready(function(){
            });
            wx.error(function(res){
                console.log(JSON.stringify(res));
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            });
        });
    }


	function init()
	{
        if(switchwechat&&is_wx){
            getScript("https://res2.wx.qq.com/open/js/jweixin-1.6.0.js",function(){
                  //ie下防止多次执行
                  if (time1 == 0)
                      wx_init();
                  time1 = time1 + 1 ;
              }) ;
        }
        if (op == 1){
            if(ischathistory){
                var url = appPath + "mobile.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&loginname=" + Request.username + "&typeid=" + Request.typeid + "&LangType=<?=$LangType?>&ischathistory=1&my_userid=<?=getValue("my_userid")?>&rnd=" + Math.random();
                if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
                if(userid) url +="&userid=" + userid;
                if(fcname) url +="&username=" + fcname;
                if(phone) url +="&phone=" + phone;
                if(email) url +="&email=" + email;
                if(qq) url +="&qq=" + qq;
                if(wechat) url +="&wechat=" + wechat;
                if(remarks) url +="&remarks=" + remarks;
                if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
                var winName = lv ; 
                //console.log(url);
                newPage(url,winName);
            }else{
                initList(listPos) ;
                getIframe("frmrtc_hidden1");
                var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + loginname + "&sourceurl=" + sourceurl + "&my_userid=<?=getValue("my_userid")?>&isweb=1&rnd=" + Math.random();
                if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
                if(userid) url +="&userid=" + userid;
                if(fcname) url +="&username=" + fcname;
                if(phone) url +="&phone=" + phone;
                if(email) url +="&email=" + email;
                if(qq) url +="&qq=" + qq;
                if(wechat) url +="&wechat=" + wechat;
                if(remarks) url +="&remarks=" + remarks;
                if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
                 //console.log(url);
                frmrtc_hidden1.location.href = url ;
            }
        }else if(op == 2){
            getIframe("frmrtc_hidden1");
            var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + Request.username + "&sourceurl=" + sourceurl + "&my_userid=<?=getValue("my_userid")?>&isweb=0&rnd=" + Math.random();
            if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
            if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
            if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
            frmrtc_hidden1.location.href = url ;
            talk(Request.username,Request.typeid);
        }else if(op == 3){
            getIframe("frmrtc_hidden1");
            var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + Request.username + "&sourceurl=" + sourceurl + "&my_userid=<?=getValue("my_userid")?>&isweb=0&rnd=" + Math.random();
            if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
            if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
            if(othertitle) url +="&othertitle=" + othertitle + "&otherurl=" + otherurl;
            frmrtc_hidden1.location.href = url ;
            
            var btn = document.getElementById('subscribe-btn');
            btn.addEventListener('success', function (e) {
              if(JSON.stringify(e.detail).indexOf("accept")!=-1) talk(Request.username,Request.typeid);
            });   
            btn.addEventListener('error',function (e) {             
              //alert(JSON.stringify(e.detail));
            });
        }
		//format
		$("#livechat").click(function(){
			if(ismobile) talk(loginname,typeid) ;
            else talk_r("<?=g("loginname") ?>","<?=g("typeid") ?>",1) ;
		});
	}
    var Request = new Object();
    Request = GetRequest();
    
    window.onerror=function(){return true;} 

    var timestamp = "rnd=" + Math.random() ;
    var head = document.getElementsByTagName('head')[0];
    var ismobile = parseInt("<?=ismobile() ?>") ;
    var switchwechat = parseInt("<?=SWITCHWECHAT ?>") ;
    var rootPath = "<?=$rootPath?>";
    var rootPath1 = "<?=$rootPath1?>";
//    var cookieHCID3 =  rootPath1 + "-layer" ;
    var cookieHCID4 = 0;
    var loginname = "<?=g("loginname") ?>";
    var typeid = "<?=g("typeid") ?>";
    var sourceurl = document.referrer;
    if(!sourceurl) sourceurl = "-";
	var appPath = rootPath + "/livechat/" ;
    var lv="<?=$username?>";
    var w = document.documentElement.clientWidth || document.body.clientWidth;
    var h = document.documentElement.clientHeight || document.body.clientHeight;
    var top = <?=$top?>;
    if(ismobile){
     //if(!window.layer) 
     var strScript="/static/js/layer_mobile/layer.js";
     var strCss="/static/js/layer_mobile/need/layer.css";
     var listPos = {top:150,left:w - 80} ;
     var invitePos = {top:h-350,left:w/2} ;
     var ratePos = {top:h-350,left:w/2} ;
    }else{
     if(!window.layui) var strScript="/static/js/layui/layui.js";
     var strCss="/livechat/assets/css/livechat.css";
     var listPos = {top:h - 50,left:w - 50,right:"1%"} ;
     var invitePos = {top:h/2-150,left:w/2} ;
     var ratePos = {top:h/2-250,left:w/2-170} ;
    }

    var invite ={switchType:<?=SWITCHTYPE?>,welcomeText:"<?=WELCOMETEXT?>",waitTime:<?=WAITTIME?>,rejectType:<?=REJECTTYPE?>,intervalTime:<?=INTERVALTIME?>};
    var op = parseInt("<?=$op?>");
    var connectType = "<?=g("connecttype",GUESTSESSION) ?>" ;


	var time = 0 ;
    var time1 = 0 ;
    var is_wx=is_weixin();
    var islocation = 0;
    var userid = "<?=g("userid") ?>";
    var callback_url = "<?=g("callback_url") ?>";
    var goods_image = "<?=g("goods_image") ?>";
    var goods_name = "<?=g("goods_name") ?>";
    var goods_price = "<?=g("goods_price") ?>";
    var fcname = "<?=g("fcname") ?>";
    var phone = "<?=g("phone") ?>";
    var email = "<?=g("email") ?>";
    var qq = "<?=g("qq") ?>";
    var wechat = "<?=g("wechat") ?>";
    var remarks = "<?=g("remarks") ?>";
    var othertitle = "<?=g("othertitle") ?>";
    var otherurl = "<?=g("otherurl") ?>";
    var ischathistory = "<?=$ischathistory ?>";

      getScript(rootPath + "/livechat/assets/js/protocolcheck.js",function(){
            getStyle(rootPath + "/livechat/assets/css/list.css",function(){
                  if(strScript){
                       getScript(rootPath + strScript,function(){
                          if(window.jQuery){
                          //ie下防止多次执行
                              if (time == 0)
                                  init();
                              time = time + 1 ;
                          }else{
                              getScript(rootPath + "/static/js/jquery.js",function(){
                              //ie下防止多次执行
                                  if (time == 0)
                                      init();
                                  time = time + 1 ;
                              }) ;
                          }
                        }) ;
                  }else{
                        if(window.jQuery){
                        //ie下防止多次执行
                            if (time == 0)
                                init();
                            time = time + 1 ;
                        }else{
                            getScript(rootPath + "/static/js/jquery.js",function(){
                            //ie下防止多次执行
                                if (time == 0)
                                    init();
                                time = time + 1 ;
                            }) ;
                        }
                  }
            }) ;
          }) ;
}



