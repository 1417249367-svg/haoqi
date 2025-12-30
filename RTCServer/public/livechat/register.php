<?php  require_once("include/fun.php");?>

<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<script  type="text/javascript" src="/static/js/jquery.validate.js"></script>
	<script  type="text/javascript" src="/static/js/messages_zh.js"></script>
</head>
<div id="win">
	<?php  require_once("include/header.php");?>
	<div class="content">
		<div class="fluent">

            <form id="form" method="post" class="bor">
			<div class="note" style="margin-bottom:10px"><?=get_lang('reg_note') ?></div>
            <div class="form-group">
                <label class="control-label" for="username"><?=get_lang('reg_lb_username') ?></label>
                <div class="control-value">
                    <input type="text" name="username" id="username" placeholder="<?=get_lang('reg_ph_username') ?>" class="form-control data-field"   maxlength="20"   value="<?=getValue("BIGANTLIVE_USERNAME")?>" required data-msg-required="<?=get_lang('reg_required_username') ?>" />
                </div>
                <div class="clear"></div>
           </div>
           <div class="form-group">
                <label class="control-label" for="phone"><?=get_lang('reg_lb_phone') ?></label>
                <div class="control-value">
                    <input type="text" name="phone" id="phone" placeholder="<?=get_lang('reg_ph_phone') ?>" class="form-control data-field"   maxlength="20"   value="<?=getValue("BIGANTLIVE_PHONE")?>" required data-msg-required="<?=get_lang('reg_required_phone') ?>"/>
                </div>
                <div class="clear"></div>
            </div>
           <div class="form-group">
                <label class="control-label" for="email"><?=get_lang('reg_lb_email') ?></label>
                <div class="control-value">
                    <input type="text" name="email" id="email" placeholder="<?=get_lang('reg_ph_email') ?>" class="form-control data-field email"   maxlength="50"   value="<?=getValue("BIGANTLIVE_EMAIL")?>" required data-msg-required="<?=get_lang('reg_required_email') ?>" />
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <div class="control-value">
                    <input type="submit"  class="btn btn-primary" id="btn_save" value="<?=get_lang('reg_btn_save')?>" />
                </div>
                <div class="clear"></div>
            </div>
            </form>
		</div>
	</div>
</div>

</body>
</html>

 <script type="text/javascript">
   $("#form").validate({
        submitHandler: function(form) {
            save();
            return false ;
        }
    });

    function save()
    {
       var url = getAjaxUrl("livechat_kf","Register") ;
       $.ajax({
           type: "POST",
           dataType:"json",
           url: url,
           data:$('#form').serialize(),
           success: function(result){
                location.href = "index.html" + location.search ;
           }
       });
    }
 </script>