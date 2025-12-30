<?php  require_once("../include/fun.php");?>
<script language="javascript" src="../assets/js/passport.js"></script>
<form  id="form1" method="post" class="form-horizontal"> 
              <div class="modal-body">
			  		<div id="pnl_success" class="alert alert-success" style="display:none" ><?=get_lang('pnl_success')?></div>
					
                        <div class="form-group"> 
                            <label class="control-label"><?=get_lang('old_password')?></label> 
                            <div class="control-value"><input type="password"  class="form-control" required id="old_password" name="old_password"/> </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"><?=get_lang('new_password')?></label> 
                            <div class="control-value"><input type="password"  class="form-control" required id="new_password" name="new_password"/> </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="control-label"><?=get_lang('confirm_password')?></label> 
                            <div class="control-value"><input type="password"  class="form-control" required id="confirm_password" name="confirm_password" equalTo="#new_password" /> </div> 
                        </div>
					
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <input  type="submit" id="btn_save" class="btn btn-primary" value="<?=get_lang('header_password_dialog')?>" />
              </div>
</form>

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