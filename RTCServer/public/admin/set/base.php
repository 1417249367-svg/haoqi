<?php
define("MENU","BASE") ;

require_once("../include/fun.php");
require_once(__ROOT__ . "/class/common/Regedit.class.php");

$regedit = new Regedit();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>基本设置</h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" >修改成功。</div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:600px;">
                        <div class="form-group">
                            <label class="control-label">单位名</label>
                            <div class="control-value"><input type="text"  class="form-control regval" data-type="REG_SZ"  id="CompanyName" value="<?=$regedit -> get(REG_PATH_SERVER . "\\CompanyName")?>" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">单位ID</label>
                            <div class="control-value"><input type="text"  class="form-control regval" data-type="REG_SZ"  id="DomainName" value="<?=$regedit -> get(REG_PATH_SERVER . "\\DomainName")?>" maxlength="15" /> </div>
                        </div>
                        <!-- 功能重复 -->
                        <!--
                        <div class="form-group">
                            <label class="control-label">端口号</label>
                            <div class="control-value"><input type="text"  class="form-control regval digits" data-type="REG_DWORD" min="1000" max="65535"  id="Port" value="<?=$regedit -> get(REG_PATH_SERVER . "\\Port")?>" /></div>
                        </div>
                         -->
                        <div class="form-group">
                            <label class="control-label">数据目录</label>
                            <div class="control-value"><input type="text"  class="form-control regval" data-type="REG_SZ"  id="DataDir"  value="<?=$regedit -> get(REG_PATH_SERVER . "\\DataDir")?>" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <div class="control-value"><input type="submit"  class="btn btn-primary"  value="保存设置" /> </div>
                        </div>
                    </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

   $("#form1").validate({
        submitHandler: function(form) {
			save();
            return false;
        }
    });
});

function save()
{
   setLoadingBtn($("#btn_save"));

   var keys = "" ;
   var values = "";
   var types = "" ;
   $(".regval").each(function(){
   		keys += (keys == ""?"":",") + $(this).attr("id");
		values += (values == ""?"":",") + $(this).val();
		types += (types == ""?"":",") + $(this).attr("data-type");
   })


   var url = getAjaxUrl("regedit","save") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{keys:keys,values:values,types:types},
	   url: url,
	   success: function(result){
			if (result.status)
				$("#pnl_success").show();
			else
				myAlert(getErrorText(result.errnum));
			setSubmitBtn($("#btn_save"));
	   }
   });
}

</script>