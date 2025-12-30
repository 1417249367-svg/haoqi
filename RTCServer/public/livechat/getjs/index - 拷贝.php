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
	$rootPath1 = getRootPath1();
	$op = g("op",1);
	$top = g("top", -1);
	$left = g("left", -1);
	$right = g("right", -1);
	$bottom = g("bottom", -1);
	$containerwidth = g("containerwidth", -1);
	$container = g("container","body");
	$data  = "" ;

	if (($left == -1) && ($right == -1))
		$left = 0;

	if (($top == -1) && ($bottom == -1))
		$top = 0;

	if ($op < 3)
	{
		$db = new DB();
		$sql = " select * from lv_chater where status=1 order by ord,id ";
		$data = $db -> executeDataTable($sql);

		$printer = new Printer();
		$data = $printer -> parseList($data,0);

	}
    
?>

    function getScript(url,callback) {
        //alert(url);
        var s = document.createElement('script');
        s.onload = s.onreadystatechange = function(o) {
          if(!this.readyState || this.readyState == "loaded" || this.readyState == "complete"){
            if (callback != undefined)
                callback();
          }
        }

        s.src = url + '?' + timestamp;
        s.charset = "utf-8";
        head.appendChild(s)
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

	function init()
	{
		if (op == 1)
			initList(data,listPos) ;
	}

    var timestamp = "rnd=" + Math.random() ;
    var head = document.getElementsByTagName('head')[0]
    var rootPath = "<?=$rootPath?>";
    var rootPath1 = "<?=$rootPath1?>";
	var appPath = rootPath + "/livechat/" ;
    var data = eval('[<?=$data?>]');
    var listPos = {top:150,left:window.screen.width -(window.screen.width- 960) /2 + 40} ;
    var op = parseInt("<?=$op?>");
	var time = 0 ;

    getScript(rootPath + "/livechat/assets/layui/layui.js",function(){
      getScript(rootPath + "/livechat/assets/js/fingerprint.js",function(){
        getScript(rootPath1 + "/socket.io/socket.io.js",function(){
          getScript(rootPath + "/livechat/assets/js/common.js",function(){
             getScript(rootPath + "/livechat/assets/js/client/client.js",function(){
               getStyle(rootPath + "/livechat/assets/layui/css/layui.css",function(){
  
                    //ie下防止多次执行
                    if (time == 0)
                        init();
                    time = time + 1 ;
  
                }) ;
              }) ;
           }) ;
        }) ;
      }) ;
    }) ;


