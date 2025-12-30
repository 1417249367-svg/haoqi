var showad = true;//是否显示广告
var Toppx = 88;//上端位置
var AdDivW = 155;//宽度
var AdDivH = 179;//高度
var PageWidth = 960;//页面多少宽度象素下正好不出现左右滚动条
var MinScreenW = 1024;//显示广告的最小屏幕宽度象素

var AdContentHtml = '<div align="center"><a target="_blank" title="立刻申请优惠套餐" href="http://www.cmseasy.cn/cuxiao/"><img src="/cuxiao/style/cuxiao.gif" /></a></div>'

var ClosebuttonHtml = '<div align="right" style="position: absolute;top:0px;right:0px;margin-top:189px;padding:2px;z-index:2000;"><a href="javascript:;" onclick="hidead()" style="color:red;text-decoration:none;font-size:12px;">关闭</a></div>';
document.write ('<div id="Javascript.RightDiv" style="position: absolute;z-index:1000;width:'+AdDivW+'px;height:'+AdDivH+'px;top:-1000px;word-break:break-all;display:none;">'+ClosebuttonHtml+'<div>'+AdContentHtml+'</div></div>');



var AdContentHtml = '<div align="center"><a target="_blank" title="立刻申请优惠套餐" href="http://www.cmseasy.cn/cuxiao/"><img src="/cuxiao/style/cuxiao.gif" /></a></div>'

var ClosebuttonHtml = '<div align="left" style="position: absolute;top:0px;right:0px;margin-top:189px;padding:2px;z-index:2000;"><a href="javascript:;" onclick="hidead()" style="color:red;text-decoration:none;font-size:12px;">关闭</a></div>';
document.write ('<div id="Javascript.LeftDiv" style="position: absolute;z-index:1000;width:'+AdDivW+'px;height:'+AdDivH+'px;top:-1000px;word-break:break-all;display:none;">'+ClosebuttonHtml+'<div>'+AdContentHtml+'</div></div>');


function scall(){
if(!showad){return;}
if (window.screen.width<MinScreenW){
//alert("临时提示：nn显示器分辨率宽度小于"+MinScreenW+",不显示广告");
showad = false;
document.getElementById("Javascript.LeftDiv").style.display="none";
document.getElementById("Javascript.RightDiv").style.display="none";
return;
}
var Borderpx = ((window.screen.width-PageWidth)/2-AdDivW)/2;
document.getElementById("Javascript.LeftDiv").style.display="";
document.getElementById("Javascript.LeftDiv").style.top=(document.documentElement.scrollTop+Toppx)+"px";
document.getElementById("Javascript.LeftDiv").style.left=(document.documentElement.scrollLeft+Borderpx)+"px";
document.getElementById("Javascript.RightDiv").style.display="";
document.getElementById("Javascript.RightDiv").style.top=(document.documentElement.scrollTop+Toppx)+"px";
document.getElementById("Javascript.RightDiv").style.left=(document.documentElement.scrollLeft+document.documentElement.clientWidth-document.getElementById("Javascript.RightDiv").offsetWidth-Borderpx)+"px";
}
function hidead()
{
showad = false;
document.getElementById("Javascript.LeftDiv").style.display="none";
document.getElementById("Javascript.RightDiv").style.display="none";
}
window.onscroll=scall;
window.onresize=scall;
window.onload=scall;
