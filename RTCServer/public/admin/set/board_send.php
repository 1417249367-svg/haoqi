<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","BOARD_SEND") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>发送公告</h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" >发送成功。</div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:600px;"> 
                        <div class="form-group"> 
                            <label class="control-label">发送密码</label> 
                            <div class="control-value"><input type="password"  class="form-control"  id="password" name="password" required /> </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label">发送类型</label> 
                            <div class="control-value">
								<label><input type="radio"  name="recv" value="ant_Online" checked />在线用户</label>
								<label><input type="radio"  name="recv" value="ant_AllUser"/>全部用户</label>
							</div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label">发送内容</label> 
                            <div class="control-value"><textarea name="content" class="form-control"  rows="10" required></textarea></div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"></label> 
                            <div class="control-value"><input type="submit" class="btn btn-primary" value="发送公告" /></div> 
                        </div>

                    </form>

	<?php  require_once("../include/footer.php");?>
    
 
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){

   $("#form1").validate({
        submitHandler: function(form) {
			send();
            return false;
        }
    });
});

function send()
{
   setLoadingBtn($("#btn_save"));

   var url = getAjaxUrl("ant","board_send") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:$('#form1').serialize(),
	   url: url,
	   success: function(result){
			if (result.status)
				$("#pnl_success").show();
			else
				myAlert(result.msg);
			setSubmitBtn($("#btn_save"));
	   }
   }); 
}

</script>
