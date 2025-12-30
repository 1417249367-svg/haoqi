<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DW") ;

require_once(__ROOT__ . "/class/common/Regedit.class.php");
$regedit = new Regedit();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/sysconfig.js"></script>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>个性化设置</h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" >修改成功。</div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:600px;"  enctype="multipart/form-data"> 
                        <div class="form-group"> 
                            <label class="control-label">统一头像</label> 
                            <div class="control-value">
								<div class="user-photo pull-left">
									<input type="file" id="file_pic" name="file_pic"  class="file-picture pic" onchange="uploadFile(this,$('#pic').val())"/>
									<img id="img_picture" class="img-picture" />
									<input type="text"  class="form-control"  id="CorDisplayPic" name="CorDisplayPic" />
								</div>
								<div class="clear gray small">推荐用95*95像素</div>
								<div><a href="#" onClick="clear_data()">清除头像</a></div>
							</div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"></label> 
                            <div class="control-value"><input type="submit"  id="btn_save" class="btn btn-primary"  value="保存设置"/> </div> 
                        </div>
                    </form>

	<?php  require_once("../include/footer.php");?>
    
 
</body>
</html>
<script type="text/javascript">
genre = "AntServerConfig" ;

var defaultPic = "/static/img/nophoto.png" ;
$(document).ready(function(){
	load_config();
	$("#img_picture").attr("src",defaultPic);
	$("#btn_save").click(function(){
		save_config();
	})
});

function load_data(result)
{
	if ((result.CorDisplayPic == undefined) || (result.CorDisplayPic == ""))
		return ;
		
	
	$("#CorDisplayPic").val(replaceAll(result.CorDisplayPic,"@@@","\\")) ;
	$("#img_picture").attr("src",result.CorDisplayPic);
}

function get_data()
{
	clear_data();
	append_data("CorDisplayPic",$("#CorDisplayPic").val());
}

function uploadComplete(file)
{
    $("#img_picture").attr("src",file.filepath);
    $("#CorDisplayPic").val(file.filepath);
}

function clear_data()
{
	$("#CorDisplayPic").val("-1") ; // delete
	$("#img_picture").attr("src",defaultPic);
}
</script>