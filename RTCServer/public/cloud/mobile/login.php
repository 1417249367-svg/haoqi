<?php	
require_once("../../class/fun.php") ; 
addLangModel1("cloud");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <?php  require_once("../include/meta.php");?>
    <script language="javascript" src="../assets/js/passport.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php

	if (g("op") == "logout")
	{
		CurUser::setUserId(0);
		CurUser::setUserName("");
		CurUser::setLoginName("");
		CurUser::setPassword("");
		CurUser::setAdmin("");
	}

?>
<body>
<div class="container">
    <div class="header">
        <div class="left-item"><img src="/cloud/assets/img/cloud.png" alt=""></div>
        <div class="right-menu"></div>
    </div>
    <div class="main-content" style="margin-top:5em;">
        <div class="list-box">
           <div id="pnl_error" class="alert alert-danger"  style="display:none;">
              <b><?=get_lang('pnl_error')?></b>
           </div>
           <div class="panel panel-default">
				 	<div class="panel-heading"><h4><?=get_lang('btn_login')?></h4></div>
					<div class="panel-body">
                       <form id="form-login" class="form-horizontal" role="form" action="../index.html" method="post">
                       <input type="hidden" id="gourl" name="gourl" value="<?php echo g("gourl");?>">
                        <div class="form-group">
                          <label class="control-label" for="txt_loginname"  style="font-size:15px;"><?=get_lang('txt_loginname')?></label>
                          <div class="control-value">
                            <input   id="txt_loginname" name="txt_loginname" placeholder="<?=get_lang('txt_loginname_desc')?>" type="text" class="form-control" required data-msg-required="<?=get_lang('txt_loginname_desc')?>" maxlength="50">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="txt_password" style="font-size:15px;"><?=get_lang('txt_password')?></label>
                          <div class="control-value">
                            <input  id="txt_password" name="txt_password"  placeholder="<?=get_lang('txt_password_desc')?>" type="password" class="form-control" data-msg-required="<?=get_lang('txt_password_desc')?>" maxlength="50">
                          </div>
                        </div>
                        <div class="form-group">
                           <div class="control-value">
                            <button class="btn btn-primary" type="submit" id="btn_login"><?=get_lang('btn_login')?></button>
                          </div>
                        </div>
                      </form>
					</div>
				 </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

   if ("<?=g("op")?>" == "relogin")
       $("#pnl_error").html("<b><?=get_lang('pnl_error1')?></b>").attr("class","alert alert-warning").show();

   $("#form-login").validate({
        submitHandler: function(form) {
            login();
            return false;
        }
    });
});

</script>