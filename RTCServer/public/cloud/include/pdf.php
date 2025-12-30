<?php 
require_once("../include/fun.php");
require_once (__ROOT__ . "/class/common/visitorInfo.class.php");

$userId = CurUser::getUserId() ;
$admin = CurUser::isAdmin();

function getpathname()
{
	$arrfile = explode(chr(47),base64_decode(js_unescape(g("name"))));
	$file_name = iconv_str($arrfile[count($arrfile)-1],"UTF-8","GBK") ;
	return js_unescape($file_name) ;
}

$file_name = getpathname() ;

//if(__ROOT__.'/Data'==RTC_CONSOLE) $url = getRootPath().'/Data/'.js_unescape(base64_decode(js_unescape(g("name"))));
//else $url = RTC_VIDEO_IP.'/'.js_unescape(base64_decode(js_unescape(g("name"))));
//header("Location:/vendor/pdfjs/web/viewer.html?formfiletype=".g("FormFileType")."&col_id=0&filename=".$file_name."&file=".$url."&loginname=".phpescape(CurUser::getLoginName())."&password=".CurUser::getPassword());
//if ($userId == 0)
//	header("Location:../account/login.html?op=relogin&gourl=../include/yunpan.html");
?>

<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title></title>
<?php require_once("../include/meta2.php");?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chorme=1">

<meta name="viewport" content="width=device-width,target-densitydpi= 120,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"></head>
<!-- 2EA1FC 755BF0 -->
<body>
<a id="pdfbutton" href="" target="_blank">跳转</a>
</body></html>
<script>
var site_address = "<?=getRootPath() ?>";
var curr_loginname = "<?=CurUser::getLoginName()?>";
var curr_password = "<?=CurUser::getPassword()?>";
$(document).ready(function(){
	var url = "name=<?=js_unescape(base64_decode(js_unescape(g("name"))))?>&loginname="+curr_loginname+"&password="+curr_password;
	url = site_address + "/public/cloud.html?op=getpdffile1&" + url ;
	doc_pdffile1(<?=g("FormFileType")?>,0,"<?=$file_name?>",url);


})

function doc_pdffile1(formfiletype,col_id,filename,url)
{
	$.ajax({
			url : url,
			type: 'post',
			dataType: 'blob',
			mimeType: 'text/plain; charset=x-user-defined',
			complete: (response) => {
				// 将文件流转换成blob形式
				let rawLength = response['responseText'].length;
				let array = new Uint8Array(new ArrayBuffer(rawLength));
				for (let i = 0; i < rawLength; i++) {
					array[i] = response['responseText'].charCodeAt(i) & 0xff;
				}
				const blob = new Blob([array], {type: 'application/pdf;charset=utf-8'});
				let url = window.URL || window.webkitURL;
				// 将blob对象创建新的url
				const blobUrl = url.createObjectURL(blob);
				// 将url传送到PDF.js
				//let pdfLink = '/vendor/pdfjs/web/viewer.html?formfiletype='+formfiletype+'&col_id='+col_id+'&filename='+filename+'&file=' + blobUrl;
				var pdfLink = "formfiletype=" + formfiletype + "&col_id=" + col_id + "&filename=" + filename + "&file=" + blobUrl + '&loginname='+curr_loginname+'&password='+curr_password;
				pdfLink = site_address + "/vendor/pdfjs/web/viewer.html?" + pdfLink;
				// iframe画面更新
				$("#pdfbutton").attr("href",pdfLink);
			}
		});
}
</script>