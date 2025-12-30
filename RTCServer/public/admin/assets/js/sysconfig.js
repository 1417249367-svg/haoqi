var genre = "" ;

function load_config()
{
   var url = getAjaxUrl("sysconfig","load","genre=" + genre) ;
   //console.log(url);
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(result){
		   	//外部调用
			load_data(result) ;
       }
   });
}

var data = "" ;
function append_data(name,value)
{
//	if (value == "")
//		value = "1" ;
	if(value == -1)
		value = 0;
	data += (data == ""?"":",") + name + ":" + value;
}
function clear_data()
{
	data = "" ;
}


function isFilePath(value){
	/*	var re = /apples/gi;
	 str = "Apples are round, and apples are juicy.";
	 newstr=str.replace(re, "oranges");
	 alert(newstr);*/
	while (value.split("\\").length > 1) {
		value = value.replace("\\", "/");
	}
	
	if (value.split("//").length > 1) {
		//alert("不符合111");
		return null;
	}
	
	if(/.*[\u4e00-\u9fa5]+.*$/.test(value)) 
	{ 
		//alert("文件名不能含有汉字！"); 
		return false; 
	}
	
	return value;
	
//	var regex = /[a-zA-Z]{1}:{1}\/[^\/].+(\/$)?/;
//	
//	var array = regex.exec(value);
//	
//	if (array != null) {
//		//alert("符合");
//		return value;
//	}
//	else {
//		//alert("不符合222");
//		return null;
//	}
}

function save_config()
{
    //外部调用
   get_data();
   var url = getAjaxUrl("sysconfig","save","genre=" + genre) ;
   //document.write(url+"&data="+data);
   $.ajax({
       type: "POST",
	   data:{"data":data},
       dataType:"json",
       url: url,
       success: function(result){
    	   if(result.status)
		   {
    		   $("#pnl_success").show();
				var speed=200;//滑动的速度
                $('body,html').animate({ scrollTop: 0 }, speed);
		   }
    	   else
		   {
		   		myAlert(result.msg);
		   }
			
       }
   });
}

/*
method	自动获取保存数据
		data-type 为要保存的值
*/
function save_auto()
{
	var names = "" ;
	var values = "" ;
	var types = "" ;
	
	if(left($("#RTCServer_IP").val(), 7)=="http://"||left($("#RTCServer_IP").val(), 8)=="https://"){
	var TempString=$("#RTCServer_IP").val();
	}else{
	var TempString="http://"+$("#RTCServer_IP").val();
	}
	if(right(TempString, 1)=="/"){
	TempString=TempString.substring(0,TempString.length-1);
	}
	if(!$("#RTCServer_IP").val()) TempString='';
	$("#RTCServer_IP").val(TempString);
	
	if(left($("#RTC_VIDEO_IP").val(), 7)=="http://"||left($("#RTC_VIDEO_IP").val(), 8)=="https://"){
	var TempString=$("#RTC_VIDEO_IP").val();
	}else{
	var TempString="http://"+$("#RTC_VIDEO_IP").val();
	}
	if(right(TempString, 1)=="/"){
	TempString=TempString.substring(0,TempString.length-1);
	}
	if(!$("#RTC_VIDEO_IP").val()) TempString='';
	$("#RTC_VIDEO_IP").val(TempString);
	
    var rtc_console = isFilePath($("#RTC_CONSOLE").val());
    if (rtc_console)
    {
		$("#RTC_CONSOLE").val(rtc_console);
    }else{
        myAlert(langs.rtc_console);
        return ;	
	}
	
	var els = $("input[data-type],select[data-type]");
	$(els).each(function(){
		var name = $(this).attr("name");
		var value = $(this).val();
		var type = $(this).attr("data-type");
		value = replaceAll(value,",","@@@");
		
		//如果有的值中有，号，要用其它符号代替
		if (name != "")
		{
			names += "," ;
			values += "," ;
			types += "," ;
		}
		names += name ;
		values += value ;
		types += type ;
	})
	

	var url = getAjaxUrl("sysconfig","setconfig") ;
	//document.write(url+"&names="+names+"&values="+values+"&types="+types+"&old_rtc_console="+$("#old_rtc_console").val()+"&rtc_console="+$("#RTC_CONSOLE").val());
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{names:names,values:values,types:types,old_rtc_console:$("#old_rtc_console").val(),rtc_console:$("#RTC_CONSOLE").val()},
	   url: url,
	   success: function(result){
			if (result.status)
				$("#pnl_success").show();
			else
				myAlert(result.msg);
			setSubmitBtn($("#btn_save"));
	   }
	});
}


