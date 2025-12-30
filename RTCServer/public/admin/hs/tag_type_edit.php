<?php  require_once("../include/fun.php");?>
           <form id="form_type" method="post" class="form-horizontal" data-table="hs_tag_type" data-fldid="col_id">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">类型名称</label> 
                        <div class="control-value">
                            <input type="text" name="col_name" id="col_name" placeholder="类型名称" class="form-control data-field specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
              </div>
            </form>
<script type="text/javascript">
var id = "<?=g("id") ?>";
var type_dataForm ;

$(document).ready(function(){
   type_dataForm = $("#form_type").attr("data-id",id).dataForm({savecallback:savecallback});
   $("#form_type").validate({
        submitHandler: function(form) {
            type_dataForm.save();
            return false;
        }
    })

});

function savecallback()
{
    dialogClose("type");
	load_all();
	
}
</script>