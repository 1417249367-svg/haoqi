trueDOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>uploadfile</title>
	<link rel="stylesheet" href="css/demo.css"/>
</head>
<body>
	<div class="up_load_file">
	</div>
	<script src="js/jquery-1.11.3.js"></script>
	<script src="js/uploadfile.js"></script>
	<script>
	var query = "parent_type=102&parent_id=1&root_id=1&curr_path=102_1_1";
		$('.up_load_file').uploadfile({
			url : getAjaxUrl("cloud","doc_upload",query + "&root_type=1&flag=html"),
			width : 500,
			height : 50,
			canDrag : true,
			canMultiple : true,
			success: function (fileName) {
				alert(fileName + '上传成功');
			},
			error: function (fileName) {
				alert(fileName + '上传失败');
			},
			complete : function () {
				alert('所有文件上传完毕');
			}
		});

function guid() {
    function S4() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    }
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

function getAjaxUrl(obj,op,param)
{
    var url = "/public/" + obj + ".html?op=" + op ;
    if (param != undefined)
        url += "&" + param ;
    url += (url.indexOf("?")>-1)?"&":"?" ;
    url += "rnd=" + Math.random() ;
    return url ;
}
	</script>
</body>
</html>