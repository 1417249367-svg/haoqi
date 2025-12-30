<!DOCTYPE html>
<html>
<head>
    <title>demo</title>
    <style type="text/css">
        label{font-size:12px;}
        h3{float:right;margin:4px 30px;line-height:40px;}
        #logInfo{background-color:#eee;border:1px solid #999;height:30px;line-height:30px;font-size:12px;padding:2px 20px;}
        #snapImg{border:1px solid #666;margin-top:10px;height:650px;overflow:auto; text-align:center;}
        .btn{border:1px solid #3079ED;background-color:#498AF4;color:#ffffff;line-height:40px;font-weight:bold; text-decoration:none; text-align:center;padding:5px 20px;}
        .btn:hover{background-color:#3B80EE}
    </style>
</head>
<body>
    <form name="form1" method="post"  id="form1">

    <div id="ctlDiv">
        <a id="A1" href="javascript:test()" class="btn">test</a>  
        <a id="btnCapture" href="javascript:f_capture()" class="btn">屏幕截图</a>     
        <a id="btnReload" href="javascript:f_loadPlugin()" class="btn" style="display:none">正在进行插件安装，安装成功后请点击这里...</a>         
        <input type="checkbox" id="autoMin" value="1" /><label for="autoMin">自动最小化当前窗口</label>
        <input type="checkbox" id="captureScreen" value="1" /><label for="captureScreen">直接捕捉当前屏幕</label>
        
        <script type="text/javascript" src="/static/screenhot/UdCapture.js"></script>
        <div id="logInfo">请点击上面的按钮开始进行屏幕截图</div>
    </div>
    <div id="snapImg"></div>
    </form>
</body>
</html>

<script type="text/javascript">
	//var recver = $(currWin).attr("loginname");
	var url = "http://192.168.2.101:98/public/upload.html?op=screenhot&recver=wer" ;

    //截屏控件URL不支持@
    //url = replaceAll(url,"@","---") ;
UDCAPTURE_SAVEFILE = url ;
function f_onBeforeUpload(file, size) {
    f_log("正在上传截图...");
}

function f_onUploadCompleted(responseText) {
	alert(responseText);
     var result = eval("(" + responseText + ")");
    f_log("图片上传完成.");
    document.getElementById("snapImg").innerHTML = "<img src=\"" + result.filePath + "?" + Math.random() + "\" style='border:1px solid #ccc'>"
}
function f_onUploadFailed(errorCode) {
	myAlert("图片上传失败" + errorCode);
}
</script>