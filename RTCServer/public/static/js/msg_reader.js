var max_thumbpic_width = 150 ;
var max_thumbpic_height = 150 ;
var emots = [
             "/:wx" ,
             "/:dx" ,
             "/:ka" ,
             "/:tp" ,
             "/:cy" ,
             "/:hx" ,
             "/:pz" ,
             "/:bx" ,
             "/:sq" ,
             "/:fn" ,
             "/:wq" ,
             "/:ng" ,
             "/:lb" ,
             "/:tk" ,
             "/:jiong" ,
             "/:sm" ,
             "/:tu" ,
             "/:heix" ,
             "/:han" ,
             "/:kh" ,
             "/:wl" ,
             "/:yx" ,
             "/:kb" ,
             "/:ot" ,
             "/:bk" ,
             "/:zj" ,
             "/:xu" ,
             "/:lh" ,
             "/:yw" ,
             "/:sj" ,
             "/:se" ,
             "/:tq" ,
             "/:aw" ,
             "/:sb" ,
             "/:bz" ,
             "/:xies" ,
             "/:tx" ,
             "/:xd" ,
             "/:xs" ,
             "/:hua" ,
             "/:dg" ,
             "/:lw" ,
             "/:ch" ,
             "/:yl" ,
             "/:ty" ,
             "/:kf" ,
             "/:ws" ,
             "/:qiang" ,
             "/:ruo" ,
             "/:sl" ,
             "/:rmb" ,
             "/:yy"
             ] ;
//格式化消息内容
function format21MsgContent(container)
{
	//表情转换
//	$(".msg-content",container).each(function(){
//		$(this).html(BA21HTML($(this).html(),1));
//	})
	//生成缩略图 <div class='thumbview' url='imgurl'><a href="imgurl"  target='_blank'><img class='thumbpic' src='imgurl'></a></div>

    $(".thumbview",container).each(function(){
		var img_container = this ;
		var img = $(".thumbpic",this);
		var img_test = new Image();
		img_test.src = $(img).attr("src") ;
		img_test.onload = function(){
			var size = get_scale_size(img_test.width,img_test.height) ;
			$(img).width(size.width + "px").height(size.height + "px").attr("data-width",img.width).attr("data-height",img.height);
			$(img_container).show();
		}
    })
	
	setTimeout("formatViewer();", 500);
}

//格式化消息内容
function formatMsgContent(container)
{
	//表情转换
	$(".msg-content",container).each(function(){
		$(this).html(BA2HTML($(this).html(),1));
	})
	//生成缩略图 <div class='thumbview' url='imgurl'><a href="imgurl"  target='_blank'><img class='thumbpic' src='imgurl'></a></div>

    $(".thumbview",container).each(function(){
		var img_container = this ;
		var img = $(".thumbpic",this);
		var img_test = new Image();
		img_test.src = $(img).attr("src") ;
		img_test.onload = function(){
			var size = get_scale_size(img_test.width,img_test.height) ;
			$(img).width(size.width + "px").height(size.height + "px").attr("data-width",img.width).attr("data-height",img.height);
			$(img_container).show();
		}
    })
}

//得到缩略图
function get_thumbview(fileUrl)
{
	var html = "<div class='thumbview' url='" + fileUrl + "'><a href='" + fileUrl + "' target='_blank'><img class='thumbpic' src='" + fileUrl + "'></a></div>" ;
	return html ;
}

function get_thumbview1(fileUrl)
{
	var html = "<img alt='' src='" + fileUrl + "'>" ;
	return html ;
}

function get_thumbview2(fileUrl)
{
	var html = "<video src='" + fileUrl + "' width='100%' controls='controls'></video>" ;
	return html ;
}


//得到附件
//<div class='file-item file-type-0' msg-id='111' msg-datapath='' file-name='' file-size=''> 1.txt <span class='file-size'>大小:11KB <a href='#' onclick='get_package(this)'>下载</a></div>
function get_package(e)
{
	var file_item = $(e).parents('.file-item') ;

	var package_size = $(file_item).attr("file-size") ;
	var msgid = $(file_item).attr("msg-id") ;
	var datapath = $(file_item).attr("msg-datapath");

	$(e).hide();
	$(e).after("<span class='loading'>正在准备下载，请稍等</span>");


	if ((package_size > (1024*1024*1024*100))>0)
	{
		myAlert("文件太大，不支持下载") ;
		return false ;
	}

	var url = getAjaxUrl("msg","get_package") ;
	$.ajax({
	   type: "POST",
	   data:{msgid:msgid,datapath:datapath},
	   dataType:"json",
	   url: url,
	   success: function(result){
		   //document.write(getAjaxUrl("download","down","file=" + result.msg));
			if (result.status)
				location.href = getAjaxUrl("download","down","file=" + result.msg) ;
			else
				myAlert(result.msg);
			$(".loading",$(e).parent()).remove();
			$(e).show();
	   },
	   error: function(result){
		   myAlert("下载错误");
	   }
	});

}


function get_file(e,fileguid)
{
	//$("#texturl").show();
	var url = getAjaxUrl("msg","get_file") ;
	//document.write(url+"fileguid="+fileguid);
	$.ajax({
	   type: "POST",
	   data:{fileguid:fileguid},
	   dataType:"json",
	   url: url,
	   success: function(result){
			if (result.status)
			{
				//location.href = getAjaxUrl("download","down","file=" + escape(result.msg)) ;
//				var texturl = appPath+getAjaxUrl("download","down","file=" + escape(result.msg)) ;
//		        $("#texturl").val(texturl);
//				$("#texturl").select(); // 选择对象 
//				document.execCommand("Copy"); // 执行浏览器复制命令 
//				myAlert(langs.board_list_code_bulid_tip); 
				//document.write(getAjaxUrl("download","down","file=" + escape(result.msg)));
				//frm_Upload.location.href = getAjaxUrl("download","down","file=" + escape(result.msg));
				window.open(getAjaxUrl("download","down","file=" + escape(result.msg)));
				
			}
			else
				myAlert(result.msg);
			$(".loading",$(e).parent()).remove();
			$(e).show();
	   },
	   error: function(result){
		   myAlert("下载错误");
	   }
	});
}

function get_filepath(e,filepath)
{
	location.href = getAjaxUrl("download","down","file=" + escape(filepath)) ;
}

function get_urlpath(e,x,y)
{
	//var urlpath="http://api.map.baidu.com/marker?location="+x+","+y+"&output=html&src=yourComponyName|yourAppName";
	var urlpath="http://map.baidu.com/?latlng="+y+","+x+"&title=我的位置&autoOpen=true";
	//alert(urlpath);
	window.open(urlpath);   
	//top.location.href = "http://api.map.baidu.com/marker?location="+x+","+y+"&output=html&src=yourComponyName|yourAppName" ;
}

function get_scale_size(true_width,true_height)
{
	if ((true_width<max_thumbpic_width) && (true_height<max_thumbpic_height))
		return {width:true_width,height:true_height};

    var max_rate = max_thumbpic_width/max_thumbpic_height;
    var true_rate = true_width/true_height ;

    var size = {width:0,height:0} ;
    if(max_rate<true_rate)
    {
        size.width =max_thumbpic_width;
        size.height = max_thumbpic_width / true_rate ;
    }
    else
    {
        size.width = max_thumbpic_height * true_rate ;
        size.height = max_thumbpic_height ;
    }
    return size ;
}

//插入内容
function insertContent(msg)
{
	var messagebox = $(".messagebox",currWin);
    var content = $(messagebox).html() ;
    if (content.toLowerCase() == "<br>")
        content = "" ;
    content += msg ;
    $(messagebox).html(content) ;
}

//插入表情
function insertEmote(i)
{
  insertContent(getEmotImg(i));
}

function getEmotImg(i)
{
  return '<img src="/static/img/emoticons/smiley_' + i + '.png">' ;
}

function BA21HTML(msg)
{
    var re = /\n/g ;
    var html = msg.replace(re,"<br>");

    html = replaceAll(html,"<br>","@@@") ;
    html = replaceAll(html,"@@@","<br>") ;

    //添加链接
    var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g;
    html = html.replace(reg, "<a href='$1$2' target='_blank'>$1$2</a>"); //这里的reg就是上面的正则表达式


    //转换表情
	for(var i=0;i<emots.length;i++)
	{
		html = html.replace(emots[i],getEmotImg(i)) ;
	}


	return html ;

}
//BA CODE to HTML
function BA2HTML(msg,To_Type)
{
    var re = /\n/g ;
    var html = msg.replace(re,"<br>");

    html = replaceAll(html,"<br>","@@@") ;
    html = replaceAll(html,"@@@","<br>") ;

    //添加链接
    var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g;
    html = html.replace(reg, "<a href='$1$2' target='_blank'>$1$2</a>"); //这里的reg就是上面的正则表达式

	var messeng_data = PastImgEx(html,To_Type);
	var filpath=messeng_data.data;
    //转换表情
	for(var i=0;i<emots.length;i++)
	{
		html = html.replace(emots[i],getEmotImg(i)) ;
	}


	return html ;

}

function HTML2BA(s)
{
    s = s.replace(/&lt;/g, "<");
    s = s.replace(/&gt;/g, ">");
    s = s.replace(/&amp;/g, "&");
    s = s.replace(/&nbsp;/g, " ");
    s = s.replace(/&#39;/g, "\'");
    s = s.replace(/&quot;/g, "\"");
    s = s.replace(/<br>/g, "\n");
	for(var i=0;i<emots.length;i++)
	{
	    var regS = new RegExp(getEmotImg(i),"gi");
		//console.log(s);
		//console.log(getEmotImg(i));
		//console.log(emots[i]);
	    s = s.replace(getEmotImg(i),emots[i]) ;
	}
	return s ;
}

function PlaySound(Stext,src){

	var e = $("#"+Stext);
	var imgsrc;
	//logs('imgLoadSucSrc()-->id='+id+', e='+e+',src='+src);
	if(e){
		//imgsrc="record_other_normal.gif";
		
		imgsrc="record_other_normal.gif";
		
		$("#"+Stext).attr("src",'/static/img/'+imgsrc);
		//e.src = '/static/img/'+imgsrc;
		
		var amr = new BenzAMRRecorder();
		amr.initWithUrl(src).then(function() {
		  amr.play();
		});
		amr.onEnded(function() {
		  StopSound(Stext)
		})
	}
}
function StopSound(Stext){
	//alert('d@'+tString);
	var e = $("#"+Stext);
	var imgsrc;
	//logs('imgLoadSucSrc()-->id='+id+', e='+e+',src='+src);
	if(e){
		imgsrc="record_other_normal.png";
		//e.src = '/static/img/'+imgsrc;
		
//		imgsrc="record_other_normal.png";
		$("#"+Stext).attr("src","/static/img/"+imgsrc);
	}
}

function PastImgEx(RTB,To_Type){
	var TempString;
	var tType;
	var tString;
	var aa=-1;
	var usname='';
	appPath=window.location.protocol+'//' + window.location.host;
	//RTB=unescape(RTB);
	var count=(RTB.split('[')).length-1;
	for(var i=0;i<count;i++){
		var m=RTB.indexOf("[")+1;
		var n=RTB.indexOf("]")- m;
		TempString=mid(RTB, m, n);
		tType = left(TempString, 2);
        tString = mid(TempString, 2);
		var imgsrc;
		var imgid;
		var res='';
		var res1='';
		switch (tType) {
		case "a@":
		RTB=RTB.replace('['+TempString+']','<a href="' + appPath+tString.split("|")[1] + '" target="_blank">' + tString.split("|")[0] + '</a>');
		break;
		case "d@":
		if(To_Type==1) imgsrc="record_me_normal.png";
		else imgsrc="record_other_normal.png";
		RTB=RTB.replace('['+TempString+']','<a href="' + appPath+tString + '" target="_blank"><img src="/static/img/'+imgsrc+'"/></a>');
		break;
		case "e@":case "f@":
		RTB=RTB.replace('['+TempString+']',get_thumbview(appPath+tString));
		break;
		case "i@":
		RTB=RTB.replace('['+TempString+']','<a href="' + appPath+tString + '" target="_blank"><img src="/static/img/MessageVideoPlay@2x.png"/></a>');
		break;
		}	
	}
	return(RTB);
}

function PastImgEx1(RTB){
	var TempString;
	var sTempString;
	var tType;
	var tString;
	var aa=-1;
	var count=(RTB.split('{')).length-1;
	for(var i=0;i<count;i++){
		var m=RTB.indexOf("{")+1;
		var n=RTB.indexOf("}")- m;
		TempString=mid(RTB, m, n);
		tType = left(TempString, 2);
        tString = mid(TempString, 2);
		sTempString=escape(TempString);
		//var src = get_download_url(tString);
		var imgsrc;
		var imgid;
		var res='';
		switch (tType) {
		case "e@":
		var target_file=tString.split("|")[0];
		var fileSize=tString.split("|")[1];
		var duration=s_to_hs(tString.split("|")[2]);
		var filePic=tString.split("|")[3];
		var src = get_download_url(target_file);
		RTB=RTB.replace('{'+TempString+'}',get_thumbview1(src));
		break;
		case "i@":
		var target_file=tString.split("|")[0];
		var fileSize=tString.split("|")[1];
		var duration=s_to_hs(tString.split("|")[2]);
		var filePic=tString.split("|")[3];
		var src = get_download_url(target_file);
		RTB=RTB.replace('{'+TempString+'}',get_thumbview2(src));
		break;
		}	
	}
	return(RTB);
}

function s_to_hs(s){
    //计算分钟
    //算法：将秒数除以60，然后下舍入，既得到分钟数
    var h;
    h  =   Math.floor(s/60);
    //计算秒
    //算法：取得秒%60的余数，既得到秒数
    s  =   s%60;
    //将变量转换为字符串
    h    +=    '';
    s    +=    '';
    //如果只有一位数，前面增加一个0
    h  =   (h.length==1)?'0'+h:h;
    s  =   (s.length==1)?'0'+s:s;
    return h+'\''+s+'\'\'';
}

function get_download_url(tString)
{
	var url = "myid=livechat&label=msg&name=" + tString  ;
	url = window.location.protocol+'//' + window.location.host+"/public/cloud.html?op=getfile&" + url ;
	return url ;
}

function isArray(obj) {return Object.prototype.toString.call(obj) === '[object Array]';}

function go2new12(Plug_Target,e){
	if(e!=null&&typeof(e)!='undefined'){
		e.stopPropagation();
	    e.preventDefault();
	}
	window.open(Plug_Target);  
}

function cmd(action){
	switch (action[0]) {
	case "go2new6":
		switch (parseInt(action[1])) {
		case 14:
		var url = get_download_url(action[2]);
		window.open(url); 
		break;
		case "d@":
		if(To_Type==1) imgsrc="record_me_normal.png";
		else imgsrc="record_other_normal.png";
		RTB=RTB.replace('['+TempString+']','<a href="' + appPath+tString + '" target="_blank"><img src="/static/img/'+imgsrc+'"/></a>');
		break;
		case "e@":case "f@":
		RTB=RTB.replace('['+TempString+']',get_thumbview(appPath+tString));
		break;
		case "i@":
		RTB=RTB.replace('['+TempString+']','<a href="' + appPath+tString + '" target="_blank"><img src="/static/img/MessageVideoPlay@2x.png"/></a>');
		break;
		}	

	break;
	}	
}