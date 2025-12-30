<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DOC_SET") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/sysconfig.js"></script>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>文档管理 / 配置信息</h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" >修改成功。</div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:800px;"> 
                        <div class="form-group"> 
                            <label class="control-label">存储路径</label> 
                            <div class="control-value"><input type="text"  class="form-control"  id="AntDocDefaultDataPath" name="AntDocDefaultDataPath"/> </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"></label> 
                            <div class="control-value"><input type="checkbox" id="AntDocLabelRoot" name="AntDocLabelRoot" value="1"> 允许保存个人文档</div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"></label> 
                            <div class="control-value"><input type="button"  class="btn btn-primary"  id="btn_save"  value="保存" /> </div> 
                        </div>

                    </form>

	<?php  require_once("../include/footer.php");?>
    
 
</body>
</html>
<script type="text/javascript">
genre = "AntDocConfig" ;
$(document).ready(function(){
	load_config();
	$("#btn_save").click(function(){
		save_config();
	})
});

function load_data(result)
{
	$("#AntDocDefaultDataPath").val(replaceAll(result.AntDocDefaultDataPath,"@@@","\\")) ;
	if (result.AntDocLabelRoot)
		$("#AntDocLabelRoot").attr("checked",true);
		
}

function get_data()
{
	clear_data();
	append_data("AntDocDefaultDataPath",$("#AntDocDefaultDataPath").val());
	append_data("AntDocLabelRoot",$("#AntDocLabelRoot").is(":checked")?1:-1);
}
</script>