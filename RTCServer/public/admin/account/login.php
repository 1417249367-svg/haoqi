<?php	require_once("../include/fun.php") ; ?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script language="javascript" src="../assets/js/account.js"></script>
</head>
<?php

	if (g("op") == "logout")
	{
        if(CurUser::getUserId() > 0)
        {
//            $antLog = new AntLog();
//            $antLog->log(CurUser::getUserName()."退出登录",CurUser::getUserId(),$_SERVER['REMOTE_ADDR'],22);
        }
		CurUser::setUserId(0);
		CurUser::setUserName("");
		CurUser::setLoginName("");
		CurUser::setPassword("");
		CurUser::setAdmin("");
	}

//    $antLog = new AntLog();
//    $errorCount = $antLog->get_admin_error_count();

?>
<body class="body-wallpaper">
    <?php  require_once("../include/header0.php");?>

	<!--[if  IE 8]>
	<div style="position:absolute;top:50px;left:0px; background:#ffd990;color:#6b4b0e;width:100%;padding:10px;"><span style="padding:20px">建议使用IE9或FireFox、Chrome浏览器，获得更好的体验....</span></div>
	<![endif]-->

	<!--[if lte IE 7]>
	<div style="position:absolute;top:50px;left:0px; background:#ffd990;color:#6b4b0e;width:100%;padding:10px;"><span style="padding:20px">你的IE版本过低，请升级IE版本，或用Chrome/FireFox浏览器</span></div>
	<script type="text/javascript">
	    $(document).ready(function(){
	        $("#view_login").hide();
	    })
	</script>
	<![endif]-->



    <div id="content">
        <div class="container" style="text-align:center">
            <div id="view_login" style="margin:auto;margin-top:100px;width:500px;text-align:left;">

                 <div id="pnl_error" class="alert alert-danger"  style="display:none;">
                    <b><?=get_lang("login_error")?></b>
                 </div>
                <div id="pnl_error" class="alert alert-danger"  style="display:<?=(($errorCount>=LOGIN_ERROR_COUNT && LOGIN_ERROR_COUNT !=0 ) ? "block" : "none")?>;padding: 50px 20px;text-align: center;">
                    <b><?=get_lang("login_error1",$login_error_count)?></b>
                </div>
                 <?php
                 if($errorCount<LOGIN_ERROR_COUNT || LOGIN_ERROR_COUNT == 0)
                 {
                 ?>
				 <div class="panel panel-default">
				 	<div class="panel-heading">
				 		<h4><?=get_lang("login_title")?></h4>
				 		<p class="pull-right warnning" style="font-size: 11px;color:#666;display:none;"><?=get_lang("login_notice")?></p>
				 		<div class="clear"></div>
				 	</div>
					<div class="panel-body">
                       <form id="form-login" class="form-horizontal" role="form" action="../index.html" method="post">
                        <div class="form-group">
                          <label class="control-label" for="txt_loginname"  style="font-size:15px;"><?=get_lang("login_lb_account")?></label>
                          <div class="control-value">
                            <input   id="txt_loginname" name="txt_loginname" placeholder="<?=get_lang("login_ph_account")?>" type="text" class="form-control" required data-msg-required="<?=get_lang("login_required_account")?>" maxlength="20">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="txt_password" style="font-size:15px;"><?=get_lang("login_lb_password")?></label>
                          <div class="control-value">
                            <input  id="txt_password" name="txt_password"  placeholder="<?=get_lang("login_ph_password")?>" type="password" class="form-control" data-msg-required="<?=get_lang("login_required_password")?>" maxlength="20">
                          </div>
                        </div>
                        <div class="form-group">
                           <div class="control-value">
                            <button class="btn btn-primary" type="submit" id="btn_login"><?=get_lang("btn_login")?></button>
                          </div>
                        </div>
                      </form>
					</div>
				 </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>



</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

   check_admin_password();
   if ("<?=g("op")?>" == "relogin")
       $("#pnl_error").html("<b><?=get_lang("time_out_warning")?></b>").attr("class","alert alert-warning").show();

   $("#form-login").validate({
        submitHandler: function(form) {
            login();
            return false;
        }
    });


});

</script>