<?php  require_once("../include/fun.php");?>
           <form id="form_root" method="post" class="form-horizontal" data-obj="docdir">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">目录名称</label> 
                        <div class="control-value">
                            <input type="text" name="usname" id="usname" placeholder="目录名称" class="form-control data-field specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
				<input type="hidden" name="myid" class="data-field" value="Public"> 
				<input type="hidden" name="parentid" value="<?=g("parentid") ?>"> 
              </div>
            </form>
<script type="text/javascript">
var id = "<?=g("id") ?>";
var root_dataForm ;

$(document).ready(function(){
   root_dataForm = $("#form_root").attr("data-id",id).dataForm({savecallback:root_savecallback});
   $("#form_root").validate({
        submitHandler: function(form) {
            root_dataForm.save();
            return false;
        }
    })

});

//先创建文件夹，再保存信息
function root_path_create()
{
	var url = getAjaxUrl("docdir","path_create") ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   //data:{path:$("#col_datapath").val()},
	   success: function(result){
		   if (result.status)
				root_dataForm.save();
		   else
			   myAlert(result.msg);
	   }
	});
}



function root_getcallback(data)
{
	data.col_datapath = replaceAll(data.col_datapath,"@@@","\\");
	return data ;
}
</script>