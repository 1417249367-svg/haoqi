<?php  require_once("../include/fun.php");?>
           <form id="form-access" method="post" class="form-horizontal" data-obj="access">
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">系统名称</label>
                        <div class="control-value">
                            <input type="text" name="col_name" id="col_name" placeholder="系统名称" class="form-control data-field specialCharValidate"   maxlength="50"  required>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label">部门同步URL</label>
                        <div class="control-value">
                            <input type="text" name="col_depturl" id="col_depturl" placeholder="部门同步URL" class="form-control data-field url"   maxlength="200">
                        </div>
                    </div>
					 <!--
                    <div class="form-group">
                        <label class="control-label">用户同步URL</label>
                        <div class="control-value">
                            <input type="text" name="col_userurl" id="col_userurl" placeholder="用户同步URL" class="form-control data-field url"   maxlength="200">
                        </div>
                    </div>
                     -->
                    <div class="form-group">
                        <label class="control-label">群组同步URL</label>
                        <div class="control-value">
                            <input type="text" name="col_groupurl" id="col_groupurl" placeholder="群组同步URL" class="form-control data-field url"   maxlength="200">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">消息同步URL</label>
                        <div class="control-value">
                            <input type="text" name="col_msgurl" id="col_msgurl" placeholder="消息同步URL" class="form-control data-field url"   maxlength="200">
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
                <input type="hidden" id="col_creator_id" name="col_creator_id" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="col_creator_name" name="col_creator_name" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>
<script type="text/javascript">
var id = "<?=g("id") ?>";
var dataForm;
$(document).ready(function(){
	   dataForm = $("#form-access").attr("data-id",id).dataForm();
	   $("#form-access").validate({
	        submitHandler: function(form) {
	            dataForm.save();
	            return false;
	        }
	    })
	    access_detail_init();
	});
</script>