//验证互联密码
function valid_password()
{
 	setLoadingBtn($("#btn_save"),"正在连接中...") ;
	var url = getAjaxUrl("hl","valid_password") ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   data:{server:$("#centerserver_ip").val(),domain:$("#domain").val(),password:$("#password").val()},
	   success: function(result){
		   if (result.status)
		   {
			    setLoadingBtn($("#btn_save"),"正在保存中...") ;
				set_server();
		   }
		   else
		   {
			   myAlert(result.msg);
				$("#password").focus();
				setSubmitBtn($("#btn_save"),"保存配置信息");
		   }
	   }
	});
}

function set_server()
{
	var data = "";
	$(".data-value").each(function(){
		data+= (data == ""?"":"&") + $(this).attr("id")  + "=" + $(this).val() ;
	})

	var url = getAjaxUrl("hl","set_server") ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   data:data,
	   success: function(result){
		   $("#pnl_success").show();
		   setSubmitBtn($("#btn_save"),"保存配置信息");
	   }
	});
}

function get_server()
{
   var url = getAjaxUrl("hl","get_server") ;
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(data){
			$(".data-value").each(function(){
				$(this).val( eval("data." + $(this).attr("id")) );
			})
       }
   });
}
