<?php  
	require_once("include/fun.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>
<video id="video" src="<?=getRootPath() ?>/Data/<?=g("name") ?>" width="100%" height="100%" controls autoplay></video>
</body>
</html>
<script type="text/javascript">
var videoJudje = false;//用于判断无法解析
var currentTime = 0;//用于判断无法播放
var videoDom = document.getElementById("video");
//open_ie();
//getWrongVideo(videoDom);
function getWrongVideo(videoDom){
    var videoWrong;//定时器   
    videoDom.addEventListener("timeupdate",videoShow,"false");
    function videoShow(){
        videoJudje = true;
        currentTime = videoDom.currentTime;
        if(currentTime > 1){
           videoDom.removeEventListener("timeupdate",videoShow,"false");
            clearTimeout(videoWrong); 
        }
    };
    videoWrong = setTimeout(function(){
       if(videoJudje == false||currentTime == 0){
            //此处添加发现错误视频之后的处理函数    
			doc_clipboard();
			videoDom.removeEventListener("timeupdate",videoShow,"false");
        } 
    },5000);
}

function doc_clipboard()
{
	var texturl = location.href.replace("addin/videoPlayer.php","addin/videoPlayer2.php") ;
	var html =  '<textarea  class="form-control data-field" rows="3" name="texturl" id="texturl">'+texturl+'</textarea>' +
				'<div>' + langs.doc_clipboardData + '</div>' +
				'<div style="padding:5px;"><input type="button" class="btn btn_primary" value="'+langs.doc_clipboard+'" onClick="doc_ie()" /></div>' ;
	showLoading(html,500,300);
}

function doc_ie()
{	
	$("#texturl").select(); // 选择对象 
	document.execCommand("Copy"); // 执行浏览器复制命令
}
</script>
