
;(function () {
    var UDCAPTURE_NEWVERSION = "3.0.0"; //当前最新的控件版本号
    var _token = "";

    function f_trim(s) {
        return s.replace(/^\s+|\s+$/gm, '');
    };

    //检查是否有新版本
    function f_checkNewVersion(instVer) {
        var newVer = UDCAPTURE_NEWVERSION.split(".");
        var curVer = instVer.split(".");
        if (parseInt(newVer[0]) > parseInt(curVer[0]))
            return true;
        if (parseInt(newVer[0]) == parseInt(curVer[0]) && parseInt(newVer[1]) > parseInt(curVer[1]))
            return true;
        if (parseInt(newVer[0]) == parseInt(curVer[0]) && parseInt(newVer[1]) == parseInt(curVer[1])
            && parseInt(newVer[2]) > parseInt(curVer[2]))
            return true;
        return false;
    };

    //向本地服务器发起get请求
    function f_udget(pathQuery, callback,errback) {
        var xmlhttp;
        if (window.XDomainRequest) {
            xmlhttp = new XDomainRequest();
        }
        else if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onload = function () {
            var ct = xmlhttp.contentType;
            if (ct == undefined)
                ct = xmlhttp.getResponseHeader("Content-Type");
            var data = xmlhttp.responseText;
            if (ct.toLowerCase().indexOf("application/json") > -1)
                data = JSON.parse(data);
            if (typeof (callback) == 'function')
                callback(data);
        }
        xmlhttp.onerror = function (err) {
            if (typeof (errback) == "function") {
                errback(err);
            } else {
                if (typeof (console) != "undefined")
                    console.log(err);
                alert("截图服务请求出错！")
            }
        };
        var port = 60523;
        var ishttps = 'https:' == document.location.protocol ? true : false;
        if (ishttps)
            port = 60524;
        xmlhttp.open('get', '//127.0.0.1:' + port + '/' + pathQuery);
        xmlhttp.send();
    };

    function UdCapture(el, options) {
		var that = this;
        that.el = typeof el == 'object' ? el : document.getElementById(el);
        that.options = options || {};   

        //设置默认属性    
        that.IsReady = false;
        if(that.options.AutoMinimize) 
            that.AutoMinimize = that.options.AutoMinimize;
        else
            that.AutoMinimize = false;
            
        if(that.options.License)
            that.License = that.options.License;
        else
            that.License = UDCAPTURE_LICENSE;            
            
        if (that.options.FileField) that.FileField = that.options.FileField;
        if (that.options.FileName) that.FileName = that.options.FileName; 
        if (that.options.TipInfo) that.TipInfo = that.options.TipInfo;
        if (that.options.UILanguage) that.UILanguage = this.options.UILanguage;
                
        if(!that.options.OnClick){
            that.options.OnClick = function(){
                that.StartCapture();
            };
        }
        if(that.el.attachEvent)
            that.el.attachEvent('onclick', that.options.OnClick);
        else
            that.el.addEventListener("click", that.options.OnClick, false);   

        //that.Init();
    }

 

    UdCapture.prototype = {
        IsReady:false,
        Init: function (callback) {
            var that = this;
            if (that.IsReady) {
                if (typeof (callback) == 'function')
                    callback();
                return;
            }
            f_udget("regist?product=UdCapture&license=" + that.License, function (data) {
                if (data.result == 0) {
                    that._version = data.version;
                    _token = data.token;
                    if (f_checkNewVersion(that._version)) {
                        if (confirm("屏幕截图客户端组件有新版本v" + UDCAPTURE_NEWVERSION + "，需要升级后才能使用。\r\n是否现在进行升级？")) {
                            that.StartSetup();
                            return;
                        }
                    }
                    that.IsReady = true;
                    if (typeof (callback) == 'function')
                        callback(true);
                } else {
                    alert("截图组件初始化错误：" + data.message);
                }
            }, function (err) {
                if (typeof (console) != "undefined")
                    console.log(err);
                if (confirm("您尚未安装屏幕截图客户端组件，是否现在进行安装？")) {
                    that.StartSetup();
                }
            });
        },
        _udcapPing: function () {
            var that = this;
            f_udget("ping?token=" + _token, function (data) {
                if (data.result == 0) {
                    switch (data.captureStatus) {
                        case 0://正在截图
                            setTimeout(function () { that._udcapPing() }, 300);
                            break;
                        case 1://截图成功
                            if (that.options.OnCaptureCompleted) that.options.OnCaptureCompleted.call(that);
                            break;
                        case -1://退出截图
                            if (that.options.OnCaptureCanceled) that.options.OnCaptureCanceled.call(that);
                            break;
                    }
                }
            });
        },
        _udcap: function (cmd, async) {
            var that = this;
            that.Init(function () {
                var pathQuery = "capture?token=" + _token + "&cmd=" + cmd;
                if (that.AutoMinimize) pathQuery += "&minimize=1";
                if (that.FileName) pathQuery += "&file=" + encodeURIComponent(that.FileName);
                if (that.TipInfo) pathQuery += "&tip=" + encodeURIComponent(that.TipInfo);
                if (that.UILanguage) pathQuery += "&language=" + that.UILanguage;
                f_udget(pathQuery, function (data) {
                    if (data.result == 0) {
                        if (that.options.OnBeforeCapture) that.options.OnBeforeCapture.call(that);
                        setTimeout(function () { that._udcapPing() }, 300);
                    }
                    else {
                        alert("启动截图失败：" + data.message);
                    }
                });
            });
        },
        StartCapture:function(){    
            this._udcap("");
        },
        Capture:function(){   
            this._udcap("cd");
        },
        CaptureScreen: function () {
            this._udcap("cs");
        },
        CaptureWindow: function () {
            this._udcap("cw");
        },
        CaptureRect:function(left,top,width,height){     
            this._udcap("cr:" + left+","+ top+","+ width+","+ height);
        },
        _uploadPing: function () {
            var that = this;
            f_udget("ping?token=" + _token, function (data) {
                if (data.result == 0) {
                    switch (data.uploadStatus) {
                        case 0://正在上传
                            setTimeout(function () {
                                that._uploadPing();
                            }, 300);
                            break;
                        case 1://上传成功
                            f_udget("query?token=" + _token + "&object=response", function (data) {
                                if (that.options.OnUploadCompleted) that.options.OnUploadCompleted.call(that, data);
                            });
                            break;
                        case -1://上传失败
                            if (that.options.OnCaptureCanceled) that.options.OnUploadFailed.call(that);
                            break;
                    }
                }
            });
        },
        Upload: function (postUrl, postParams) {
            var that = this;
            if (postUrl == undefined || postUrl == "") {
                return;
            }
            var lowUrl = f_trim(postUrl).toLowerCase();
            if (postUrl.length < 8 || (lowUrl.substring(0, 7) != "http://"
                && lowUrl.substring(0, 8) != "https://"
                && lowUrl.substring(0, 6) != "ftp://")){
                var url = location.href.split('?')[0];
                postUrl = url.substring(0, url.lastIndexOf("/") + 1) + postUrl;
            }
            var pathQuery = "upload?token=" + _token;
            if (that.FileField) pathQuery += "&FileField=" + encodeURIComponent(that.FileField);
            if (postUrl) pathQuery += "&PostUrl=" + encodeURIComponent(postUrl);
            if (postParams != undefined) pathQuery += "&PostParams=" + encodeURIComponent(postParams);

            f_udget(pathQuery, function (data) {
                if (data.result == 0) {
                    if (that.options.OnBeforeUpload) that.options.OnBeforeUpload.call(that);
                    setTimeout(function () {
                        that._uploadPing();
                    }, 500);
                }
                else {
                    alert("上传截图失败：" + data.message);
                }
            });
        },
        GetVersion:function(){
            return this._version;
        },
        GetBase64: function (callback) {
            f_udget("query?token=" + _token + "&object=base64", function (data) {
                if (typeof (callback) == 'function')
                    callback(data);
            });
        },
        GetImageUrl: function () {
            return '//localhost:' + UDSERVICE_PORT + '/query?token=' + _token + '&object=image'
        },  
        //下载安装文件进行安装
        StartSetup: function () {
            var canceled = false;
            if (this.options.OnStartSetup)
                canceled = this.options.OnStartSetup.call(this, UDCAPTURE_SETUP_URL);
            if (!canceled) {
                var iframe = document.getElementById("udCaptureSetupFrame");
                if (iframe == null) {
                    iframe = document.createElement("iframe");
                    iframe.id = "udCaptureSetupFrame";
                    iframe.style.display = "none";
                    document.body.appendChild(iframe);
                }
                iframe.setAttribute("src", UDCAPTURE_SETUP_URL);
            }
        },
        Destory: function () {
            if (this.IsReady) {
                f_udget("quit?token=" + _token)
                this.IsReady = false;
            }
        }
    }
    
    
    
    /**
    * Factory method for creating a UdCapture object
    *
    * @param {Element} The el to listen on
    * @param {Object} [options={}] The options to override the defaults
    */
    UdCapture.Attach = function (el, options) {
        return new UdCapture(el, options);
    };


    if (typeof define === 'function' && typeof define.amd === 'object' && define.amd) {
        // AMD. Register as an anonymous module.
        define(function () {
            return UdCapture;
        });
    } else if (typeof module !== 'undefined' && module.exports) {
        module.exports = UdCapture.Attach;
        module.exports.UdCapture = UdCapture;
    } else {
        window.UdCapture = UdCapture;
    }
}());

//客户端安装文件路径
var UDCAPTURE_SETUP_URL = "/static/screenhot/UdSvcSetup.msi";
//注册授权许可号
var UDCAPTURE_LICENSE = "";         