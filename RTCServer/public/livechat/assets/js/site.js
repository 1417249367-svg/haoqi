function getAjaxUrl(obj,op,param)
{
    var url = "../public/" + obj + ".html?op=" + op ;
    if (param != undefined)
        url += "&" + param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    // window.prompt("",url);
    return url ;
}

function filterChar(str)
{
    str = replaceAll(str,".","");
    str = replaceAll(str,"(","");
    str = replaceAll(str,")","");
    str = replaceAll(str,"@","");
    return str ;
}

function loadScripts(array,callback){
    var loader = function(src,handler){
        var script = document.createElement("script");
        script.src = src;
        script.onload = script.onreadystatechange = function(){
        script.onreadystatechange = script.onload = null;
        	handler();
        }
        var head = document.getElementsByTagName("head")[0];
        (head || document.body).appendChild( script );
    };
    (function(){
        if(array.length!=0){
        	loader(array.shift(),arguments.callee);
        }else{
        	callback && callback();
        }
    })();
}

function flashChecker()
{
	var hasFlash=0;   //是否安装了flash
	var flashVersion=0;   //flash版本
	
	if(document.all)
	{
	var swf = new ActiveXObject('ShockwaveFlash.ShockwaveFlash'); 
	if(swf) {
	hasFlash=1;
	VSwf=swf.GetVariable("$version");
	flashVersion=parseInt(VSwf.split(" ")[1].split(",")[0]); 
	}
	}else{
	if (navigator.plugins && navigator.plugins.length > 0)
	{
	var swf=navigator.plugins["Shockwave Flash"];
	if (swf)
		{
	hasFlash=1;
		   var words = swf.description.split(" ");
		   for (var i = 0; i < words.length; ++i)
	{
			 if (isNaN(parseInt(words[i]))) continue;
			 flashVersion = parseInt(words[i]);
	}
	}
	}
	}
	return {f:hasFlash,v:flashVersion};
}

function getDateTime()
{
	var d = new Date() ;
	return d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds() ;
}

function trace(msg)
{
    $("#trace").html($("#trace").html() +  "<br>" + msg ) ;
}
