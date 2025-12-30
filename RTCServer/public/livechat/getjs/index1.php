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
	
	if(!getValue("my_userid")) setValue("my_userid",rand(10,100000),-1); 

	if (($left == -1) && ($right == -1))
		$left = 0;

	if (($top == -1) && ($bottom == -1))
		$top = 0;
?>
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
    
//    function getScript(url,callback){
//         var script=document.createElement('script');
//         script.type="text/javascript";
//         if(typeof(callback)!="undefined"){
//           if(script.readyState){
//             script.onreadystatechange=function(){
//                if(script.readyState == "loaded" || script.readyState == "complete"){
//                script.onreadystatechange=null;
//                callback();
//                }
//             }
//           }else{
//             script.onload=function(){
//                callback();
//             }
//           }
//         }
//         script.src=url + '?' + timestamp;
//         script.charset = "utf-8";
//         document.body.appendChild(script);
//     }



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
//        s.onload = s.onreadystatechange = function() {
//          if(!this.readyState || this.readyState == "loaded" || this.readyState == "complete"){
//
//            if (callback != undefined)
//                callback();
//          }
//        }
//        try{  
//           var iframe = document.createElement('<iframe id="frm_hidden" name="frm_hidden" style="display:none;"></iframe>');  
//          }catch(e){ 
//            var iframe = document.createElement('iframe');  
//            iframe.id = 'frm_hidden';
//            iframe.name = 'frm_hidden'; 
//            iframe.style = 'display:none;'; 
//         }
//       document.body.appendChild(iframe);
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
    
//    function setCookie(_name,value,expiredays)
//    {
//        if (expiredays == undefined)
//            expiredays = 9999 ;
//        var exdate=new Date()
//        exdate.setDate(exdate.getDate()+expiredays)
//        document.cookie=_name+ "=" +escape(value)+
//        ((expiredays==null) ? "" : "; expires="+exdate.toGMTString())+"; path=/; domain=.qiyeim.com"
//    }
    
    function is_weixin() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }
    
    function wx_init() {
        var param = {userid:userid,redirect_uri:escape(window.location.href)};
        var url = getAjaxUrl("livechat_kf","wxsignature") ; 
        //var url = "http://g.rtcim.com:98/public/livechat_kf.php?op=wxsignature&source=kefu";
        //console.log(url+JSON.stringify(param));
        $.getJSON(url,param , function(result){
                        //alert(JSON.stringify(result));
    //		if (result.status == undefined)
    //		{
    
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
                //alert(JSON.stringify(result));
                wx.ready(function(){
                });
                wx.error(function(res){
                    console.log(JSON.stringify(res));
                    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
                });
    //		}
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
			initList(listPos) ;
            getIframe("frmrtc_hidden1");
            var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + loginname + "&sourceurl=" + sourceurl + "&isweb=1&rnd=" + Math.random();
            if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
            if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
            //alert(url);
            frmrtc_hidden1.location.href = url ;
//            setTimeout(function() {
//                initInvite(invitePos);
//            }, 1000 * (invite.waitTime || 15));
        }else if(op == 2){
            getIframe("frmrtc_hidden1");
            var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + Request.username + "&sourceurl=" + sourceurl + "&isweb=0&rnd=" + Math.random();
            if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
            if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
            //alert(url);
            //document.write(url);
            //setTimeout(function() {
              frmrtc_hidden1.location.href = url ;
              talk(Request.username,Request.typeid);
            //}, 1000);
        }else if(op == 3){
            getIframe("frmrtc_hidden1");
            var url = appPath + "source.html?ipaddress=" + rootPath1 + "&connectType=" + connectType + "&typeid=" + typeid + "&loginname=" + Request.username + "&sourceurl=" + sourceurl + "&isweb=0&rnd=" + Math.random();
            if(goods_name) url +="&goods_info=" + escape(escape("{q@"+callback_url+"|"+goods_image+"|"+unescape(goods_name)+"|"+unescape(goods_price)+"}"));
            if(userid) url +="&userid=" + userid;
            if(fcname) url +="&username=" + fcname;
            if(phone) url +="&phone=" + phone;
            if(email) url +="&email=" + email;
            if(qq) url +="&qq=" + qq;
            if(wechat) url +="&wechat=" + wechat;
            if(remarks) url +="&remarks=" + remarks;
            frmrtc_hidden1.location.href = url ;
            //talk(Request.username);
        }
		//format
		$(".livechat-user").click(function(){
			talk(loginname,typeid) ;
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
//    var cookieHCID4 =  rootPath1 + "-layer1" ;
    var loginname = "<?=g("loginname") ?>";
    var typeid = "<?=g("typeid") ?>";
    var sourceurl = document.referrer;
    if(!sourceurl) sourceurl = "-";
	var appPath = rootPath + "/livechat/" ;
    var lv="<?=get_lang('index_service')?>";
    if(ismobile){
     if(!window.layer) var strScript="/static/js/layer_mobile/layer.js";
     var strCss="/static/js/layer_mobile/need/layer.css";
     var listPos = {top:150,left:window.screen.width - 80} ;
     var invitePos = {top:window.screen.height-350,left:(window.screen.width)/2} ;
     var ratePos = {top:window.screen.height-350,left:(window.screen.width)/2} ;
    }else{
     if(!window.layui) var strScript="/static/js/layui/layui.js";
     var strCss="/livechat/assets/css/livechat.css";
     var listPos = {top:150,left:window.screen.width - 200} ;
     var invitePos = {top:window.screen.height/2-150,left:(window.screen.width)/2} ;
     var ratePos = {top:window.screen.height/2-250,left:(window.screen.width)/2-170} ;
    }

    var invite ={switchType:<?=SWITCHTYPE?>,welcomeText:"<?=WELCOMETEXT?>",waitTime:<?=WAITTIME?>,rejectType:<?=REJECTTYPE?>,intervalTime:<?=INTERVALTIME?>};
    var op = parseInt("<?=$op?>");
    var connectType = "<?=g("connecttype",1) ?>" ;


	var time = 0 ;
    var time1 = 0 ;
    var is_wx=is_weixin();
    var islocation = 0;
    var userid;
    var callback_url;
    var goods_image;
    var goods_name;
    var goods_price;
    var fcname;
    var phone;
    var email;
    var qq;
    var wechat;
    var remarks;
    
//    var iframe = document.createElement('iframe');  
//    iframe.id = 'frmrtc_hidden';
//    iframe.name = 'frmrtc_hidden'; 
//    iframe.style = 'display:none;';
//    document.body.appendChild(iframe);
     

      getScript(rootPath + "/livechat/assets/js/protocolcheck.js",function(){
        //getScript(rootPath + "/livechat/langs/cn/lang.js?ver=20150504",function(){
            getScript(rootPath + "/livechat/assets/js/list.js?ver=2015022602",function(){
                //getStyle(rootPath + strCss,function(){
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
                  //}) ;
               }) ;
            //}) ;
          }) ;

//      getScript(rootPath + "/static/js/jquery.js",function(){
//        getScript(rootPath + strScript,function(){
//          getScript(rootPath + "/livechat/assets/js/protocolcheck.js",function(){
//              getScript(rootPath + "/livechat/assets/js/list.js?ver=2015022602",function(){
//                  getStyle(rootPath + "/livechat/assets/css/list.css",function(){
//                        //ie下防止多次执行
//                        if (time == 0)
//                            init();
//                        time = time + 1 ;
//                  }) ;
//                }) ;
//              }) ;
//            }) ;
//          }) ;



