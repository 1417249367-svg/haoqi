<?php  require_once("../include/fun.php");?>

              <div class="modal-body">
                    <div id="tag_container"></div>
              </div>
              <div class="modal-footer clearfix">
			  		<div class="pull-left" id="options">
						<label><input type="checkbox" id="chk_reset" /> 重置标签</label>
					</div>
			  		<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="submit" class="btn btn-primary" id="btn_picker_submit">确定</button>
					</div>
              </div>
 

 <script type="text/javascript">
    var empType = "<?=g("EmpType") ?>" ;
    var empId = "<?=g("EmpId") ?>" ;

	$(document).ready(function(){
		loadTag(empType,empId);
	    if (empId == "")
	    {
	    	myAlert("请选择要设置的对象");
		    dialogClose("tagpicker");
	    }

	    $("#btn_picker_submit").click(function(){
		    var tags = "";
		    var flag = $("#chk_reset").is(':checked')?1:0 ;
		    tag_post();
	    })
	})

 </script>