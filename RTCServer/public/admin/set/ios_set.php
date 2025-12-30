<?php  require_once("../include/fun.php");?>

           <form id="form-ios" method="post" class="form-horizontal" data-obj="org">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">AppKey</label> 
                        <div class="control-value">
                            <input type="text" name="AppKey" id="AppKey" placeholder="AppKey" class="form-control specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label">Api主密码</label> 
                        <div class="control-value">
                        	<input type="text" name="MasterKey" id="MasterKey" placeholder="iOS API主密码" class="form-control specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
              </div>
            </form>
<script type="text/javascript">
$(document).ready(function(){
	$("#btn_save").click(function(){
		set_ios_post();
        return false ;
    });
    get_ios_set();
});
</script>