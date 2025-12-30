window.onload = function () {
	//其中"btnCapture"为截图按钮的ID
	var udCapture = new UdCapture("btnCapture", {
		OnClick: function () {
			//udCapture.Init();
			startScreenShot();
			udCapture.AutoMinimize = document.getElementById("autoMin").checked;
			if (document.getElementById("captureScreen").checked)
				udCapture.CaptureScreen();
			else if (udCapture.AutoMinimize)
				udCapture.Capture();
			else
				udCapture.StartCapture();
		},
		OnStartSetup: function (setupFile) {
			f_log("正在进行安装，安装完成后请<a href=''>刷新当前页面</a>！");
		},
		OnBeforeCapture: function () {
			f_log("开始截图");
		},
		OnCaptureCanceled: function () {
			f_log("已取消截图");
		},
		OnCaptureCompleted: function () {
			f_log("<img src=\"/static/img/Loading_UdCapture.gif\" style=\"vertical-align:text-bottom\" />&nbsp;正在上传截图...");
			screenshotUploadBefore();
			//调用控件的上传方法完成上传,请求的文件可以根据需要换为其它语言
			udCapture.Upload(UDCAPTURE_SAVEFILE);
		},
		OnUploadFailed: function () {
			f_log("图片上传失败");
		},
		OnUploadCompleted: function (responseText) {
			f_log("图片上传完成.");
			var data = eval("(" + responseText + ")");
			screenshotComplete(data);
			//document.getElementById("snapImg").innerHTML = "<img src=\"" + json.filepath + "?" + Math.random() + "\">"
		}

	});
}

//显示事件消息
function f_log(str) {
	if (typeof (console) != "undefined")
		console.log(str);
	//document.getElementById("logInfo").innerHTML = str;
}
