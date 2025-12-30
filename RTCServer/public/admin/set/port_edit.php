<?php  require_once("../include/fun.php");?>
           <form id="form" method="post" class="form-horizontal" >      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label">端口</label> 
                        <div class="control-value">
                            <input type="text" id="txt_port" placeholder="端口" class="form-control number"   maxlength="50"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
              </div>
            </form>
<script type="text/javascript">
var service_name = "<?=g("service")?>" ;
var service_port = "<?=g("port")?>" ;


$(document).ready(function(){
   $("#txt_port").val(service_port);

   $("#form").validate({
        submitHandler: function(form) {
			var curr_port = $("#txt_port").val() ;
			if (service_port != curr_port)
			{
            	set_port(service_name,curr_port);
			}
			else
			{
				dialogClose("port");
			}
            return false;
        }
    })

});


</script>