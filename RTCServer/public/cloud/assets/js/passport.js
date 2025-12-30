
function login(loginname,password)
{
    setLoadingBtn($("#btn_login"));
    var url = getAjaxUrl("passport","login") ;
	//document.write(url+$('#form-login').serialize());
    $.ajax({
       type: "POST",
       data:$('#form-login').serialize(),
       url: url,
       success: function(response){
		   	var result = eval("(" + response + ")") ;
            if (result.status)
			    if($('#gourl').val()){
					if($('#gourl').val()=="livechat") location.href = ipaddress+"/?loginname="+$('#txt_loginname').val()+"&password="+result.md5password+"&flag=isweb";
					else location.href = unescape($('#gourl').val());
				}else{
					 if(parseInt(result.ismanager)) location.href = "../include/index.html#public" ;
					 else $("#pnl_error").html("<b>" + getErrorText('102004') + "</b>").attr("class","alert alert-danger").show();
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

function login1(loginname,password)
{
    setLoadingBtn($("#btn_login"));
    var url = "http://192.168.0.102:98/api/user/login.html" ;
	//document.write(url+$('#form-login').serialize());
    $.ajax({
       type: "POST",
       data:$('#form-login').serialize(),
       url: url,
       success: function(response){
		   alert(JSON.stringify(response));
		   	var result = eval("(" + response + ")") ;
            if (result.status)
			    if($('#gourl').val()){
					if($('#gourl').val()=="livechat") location.href = ipaddress+"/?loginname="+$('#txt_loginname').val()+"&password="+result.md5password+"&flag=isweb";
					else location.href = unescape($('#gourl').val());
				}else location.href = "../include/index.html#public" ;
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

function login2(loginname,password)
{
    setLoadingBtn($("#btn_login"));
    var url = getAjaxUrl("passport","login") ;
	//document.write(url+$('#form-login').serialize());
    $.ajax({
       type: "POST",
       data:$('#form-login').serialize(),
       url: url,
       success: function(response){
		   	var result = eval("(" + response + ")") ;
            if (result.status)
			    if($('#gourl').val()){
					if($('#gourl').val()=="livechat") location.href = ipaddress+"/?loginname="+$('#txt_loginname').val()+"&password="+result.md5password+"&flag=isweb";
					else location.href = unescape($('#gourl').val());
				}else{
					 if(parseInt(result.ismanager)) location.href = "../include/index.html#public" ;
					 else $("#pnl_error").html("<b>" + getErrorText('102004') + "</b>").attr("class","alert alert-danger").show();
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

function logout(){
    var url = getAjaxUrl("passport","logout") ;
	//document.write(url);
    $.ajax({
        type: "POST",
        dataType:"json",
        url: url,
        success: function(result){
			//alert(JSON.stringify(result));
            if (result.status)
                window.location.reload();
        }
    });

}

function logout1(gourl){
    var url = getAjaxUrl("passport","logout") ;
    $.ajax({
        type: "POST",
        dataType:"json",
        url: url,
        success: function(result){
            if (result.status)
                location.href = unescape(gourl) ;
        }
    });

}

///////////////////////////////////////////////////////////////////////////////////////////
//password_dialog
///////////////////////////////////////////////////////////////////////////////////////////
function password_dialog()
{
	dialog("password",langs.password_dialog,"../account/setpassword.html") ;
}

function savepassword()
{
   setLoadingBtn($("#btn_save"));
   var url = getAjaxUrl("user","setpassword") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:$('#form1').serialize(),
	   url: url,
	   success: function(result){
			if (result.status)
				$("#pnl_success").show();
			else
				myAlert(getErrorText(result.errnum));
			setSubmitBtn($("#btn_save"));
			dialog_close("password");
	   }
   }); 
	
}


