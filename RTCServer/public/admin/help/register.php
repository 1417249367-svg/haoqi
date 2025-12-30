<?php  require_once("../include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/ant/Register.class.php");?>
<?php


$db = new db();
$sql = " select count(*) as c from hs_user" ;
$count = $db -> executeDataValue($sql);

$reg = new Register();
$mac_addr = $reg -> get_mac();

?>
<div id="pnl_register">
              <div class="modal-body">
                        <h4><?=APP_NAME?></h4>
                        <ul class="list-unstyled">
							<li>机器码：<span id="lbl_machinecode"><?=$mac_addr?></span></li>
                            <li>许可数：<span id="lbl_users"></span></li>
                            <li>总用户数：<span><?=$count?></span></li>
                            <li>到期时间：<span id="lbl_expiredate"></span></li>
                        </ul>
                        <br>

              </div>
              <div class="modal-footer">
			  	<input type="button" class="btn btn-primary" onclick="activation_dialog()" value="注册" />
                <input type="button" class="btn btn-default" data-dismiss="modal" value="关闭" />
              </div>

</div>

<div id="pnl_activation" style="display:none">
              <div class="modal-body">
                        <b>请输入激活码</b>
                        <textarea class="form-control" id="txt_code" rows="8"></textarea>
                        <br>

              </div>
              <div class="modal-footer">
			  	<input type="button" class="btn btn-primary" onclick="activation()" value="激活" />
                <input type="button" class="btn btn-default" data-dismiss="modal" value="关闭" />
              </div>

</div>


<script type="text/javascript">
	$(document).ready(function(){
		loadinfo();
	})


	function activation_dialog()
	{
		$("#pnl_register").hide();
		$("#pnl_activation").show();
	}

	function register_dialog()
	{
		$("#pnl_register").show();
		$("#pnl_activation").hide();
	}

	function loadinfo()
	{
		var url = getAjaxUrl("license","get_info");
		$.getJSON(url, function(data){
		  	$("#lbl_users").html(data.users);
			$("#lbl_expiredate").html(data.expiredate);
		});
	}

	function activation()
	{
		var url = getAjaxUrl("license","activation");
		var code = $("#txt_code").val();
		$.ajax({
		  type: "post",
		  url: url,
		  data:{code:code},
		  dataType: "json",
		  success: function(result){
			 if (result.status == "1")
			 {
			 	loadinfo();
				alert("激活成功");
				register_dialog();
			 }
			 else
			 {
			 	alert(result.msg);
			 }
		  }
		});
	}

</script>