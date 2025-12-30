<?php  require_once("../include/fun.php");?>

           <form id="form-import" method="post" class="form-horizontal">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">域控服务器</label> 
                        <div class="control-value">
                            <input type="text" name="domain" id="domain" placeholder="域服务器域名" class="form-control"   maxlength="50" value="<?=getAppValue("domain")?>"  required /> 
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label">管理员帐号</label> 
                        <div class="control-value">
                            <input name="adminUser" id="adminUser" placeholder="管理员帐号" class="form-control specialCharValidate" value="" required/>
                        </div>
                    </div>
					<div class="form-group"> 
						<label class="control-label" for="adminPassword">密码</label> 
						<div class="control-value">
							<input type="password" placeholder="" class="form-control"  id="adminPassword"  name="adminPassword" value="" maxlength="50" required />
						</div>
					</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">确定</button>
              </div>
            </form>
<script type="text/javascript">
$(document).ready(function(){
	$("#btn_save").click(function(){
        import_ldap();
    })
})
</script>