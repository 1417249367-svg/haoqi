<?php  require_once("../include/fun.php");?>
<?php
define("MENU","APPLICATION") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
					<!--<div class="page-header"><h1>应用中心</h1></div>-->
                    <iframe src="http://addon.haoqiniao.cn/" id="mainFrame" name="mainFrame" width="100%" height="670px" frameborder="0" scrolling="yes" style="overflow: visible;display:"></iframe>
					

	<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">

var curr_type = "<?=$curr_type?>" ;
$(document).ready(function(){
	//getinfo();
})

function getinfo()
{
   var url = getAjaxUrl("update","getinfo","type=" + curr_type);
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(result){
			if (result.status)
			{
				$("#version").val(format_client_version(result.version.toString()));
				$("#exe").val(result.exe);
				$("#pnl_info").show();
			}
			else
			{
				$("#pnl_info").hide();
			}

	   }
   });
}

function delete_file()
{

   var url = getAjaxUrl("update","delete","type=" + curr_type);
   setLoadingBtn($("#btn_delete"));
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(result){
		   myAlert("删除成功");
			$("#pnl_info").hide();
			setSubmitBtn($("#btn_delete"));
	   }
   });

}


function import_file()
{
	if ($("#updatefile").val() == "")
	{
		myAlert("请选择更新包");
		return false ;
	}
	
	setLoadingBtn($("#btn_import"));
	
	var url = getAjaxUrl("update","import","type=" + curr_type);
	var _form = $("form");
	$(_form).attr("action",url).attr("target","frm_Upload").submit();
}


function import_callback(status,msg)
{
	if (status == 0)
	{
		myAlert(msg);
	}
	else
	{
		$("#pnl_success").show();
		getinfo();
	}
	setSubmitBtn($("#btn_import"));
}
</script>
