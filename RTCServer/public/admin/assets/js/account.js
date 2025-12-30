function login(loginname,password)
{
    setLoadingBtn($("#btn_login"));
    valid_password();
}

function valid_password()
{
    var url = getAjaxUrl("passport","login","ismanager=1") ;
		//console.log(url+$('#form-login').serialize());
    $.ajax({
        type: "POST",
        dataType:"json",
        data:$('#form-login').serialize(),
        url: url,
        success: function(result){
            if (result.status){
				if($(".warnning").is(":visible")==true) location.href = "setpassword.html" ;
                else location.href = "../include/index.html" ;
			}else
            {
                $("#pnl_error").html("<b>" + getErrorText(result.errnum) + "</b>").attr("class","alert alert-danger").show();
                setSubmitBtn($("#btn_login"));
            }
        },
        error: function(result){
            myAlert(" system error");
        }
    });
}

function valid_code(){
    var url = getAjaxUrl("validate_code","valid_code","verifycode=" + $("#verifycode").val()) ;
    $.ajax({
        type: "POST",
        dataType:"json",
        url: url,
        success: function(result){
            if (result.status)
            {
                valid_password() ;
            }
            else
            {
                $("#pnl_error").html("<b>" + getErrorText(result.errnum) + "</b>").attr("class","alert alert-danger").show();
                setSubmitBtn($("#btn_login"));
            }
        },
        error: function(result){
            myAlert(" system error");
        }
    });

}

function check_admin_password()
{
	var url = getAjaxUrl("passport","check_admin_password") ;
	$.ajax({
		type:"POST",
		dataType:"json",
	    url: url,
	    success:function(result){
	    	if(result.status=="1")
	    		$(".warnning").show();
	    }
	});
}

