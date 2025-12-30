<?php	
require_once("../../class/fun.php") ; 
addLangModel1("cloud");
$rootPath1 = g("ipaddress",getRootPath1());
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script language="javascript" src="../assets/js/passport.js"></script>

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
                    <b><?=get_lang('pnl_error')?></b>
                 </div>

				 <div class="panel panel-default">
				 	<div class="panel-heading"><h4><?=get_lang('btn_login')?></h4></div>
					<div class="panel-body">
                       <form id="form-login" class="form-horizontal" role="form" action="../index.html" method="post">
                       <input type="hidden" id="gourl" name="gourl" value="<?php echo g("gourl");?>">
                       <input type="hidden" id="isclient" name="isclient" value="1">
                        <div class="form-group">
                          <label class="control-label" for="UserName"  style="font-size:15px;"><?=get_lang('txt_loginname')?></label>
                          <div class="control-value">
                            <input   id="UserName" name="UserName" placeholder="<?=get_lang('txt_loginname_desc')?>" type="text" class="form-control" required data-msg-required="<?=get_lang('txt_loginname_desc')?>" maxlength="50">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="UserPaws" style="font-size:15px;"><?=get_lang('txt_password')?></label>
                          <div class="control-value">
                            <input  id="UserPaws" name="UserPaws"  placeholder="<?=get_lang('txt_password_desc')?>" type="password" class="form-control" data-msg-required="<?=get_lang('txt_password_desc')?>" maxlength="50">
                          </div>
                        </div>
                        <div class="form-group">
                           <div class="control-value">
                            <button class="btn btn-primary" type="submit" id="btn_login"><?=get_lang('btn_login')?></button>
                            <input type="hidden" id="token" name="token" class="data-field" value="23456" />
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
var ipaddress = "<?=$rootPath1 ?>" ;
$(document).ready(function(){

   if ("<?=g("op")?>" == "relogin")
       $("#pnl_error").html("<b><?=get_lang('pnl_error1')?></b>").attr("class","alert alert-warning").show();

   $("#form-login").validate({
        submitHandler: function(form) {
            login1();
            return false;
        }
    });
});

</script>