<?php  require_once("../include/fun.php");?>
<?php
define("MENU","PROFILE") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/user.js"></script>
	<style>

	</style>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("pwd_title")?></h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" ><?=get_lang("pwd_notice")?></div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:600px;">
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("pwd_lb_old")?></label>
                            <div class="control-value"><input type="password"  class="form-control" id="old_password" name="old_password" maxlength="20" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("pwd_lb_new")?></label>
                            <div class="control-value"><input type="password"  class="form-control" required id="new_password" name="new_password" maxlength="20" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?=get_lang("pwd_lb_repeat")?></label>
                            <div class="control-value"><input type="password"  class="form-control" required id="confirm_password" name="confirm_password" equalTo="#new_password" maxlength="20" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <div class="control-value"><input  type="submit" id="btn_save" class="btn btn-primary" value="<?=get_lang("btn_change")?>"></input></div>
                        </div>
                    </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

   $("#form1").validate({
        submitHandler: function(form) {
            setpassword();
            return false;
        }
    });
});

</script>