<?php  require_once("../include/fun.php");?>
           <form id="form" method="post" class="form-horizontal"  data-table="hs_tag" data-fldid="col_id">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">标签名称</label> 
                        <div class="control-value">
                            <input type="text" name="col_name" id="col_name" placeholder="标签名称" class="form-control data-field specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
                <input type="hidden" id="col_type_id" name="col_type_id" class="data-field" />
              </div>
            </form>
<script type="text/javascript">

var id = "<?=g("id") ?>";
var type_id = "<?=g("type_id") ?>";
var dataForm ;
$(document).ready(function(){
   $("#col_type_id").val(type_id);
   dataForm = $("#form").attr("data-id",id).dataForm({savecallback:savecallback});
   $("#form").validate({
        submitHandler: function(form) {
            dataForm.save();
            return false;
        }
    })

});

function savecallback()
{
	dialogClose("tag");
	$(".tag_name_" + id).html($("#col_name").val());
}
</script>