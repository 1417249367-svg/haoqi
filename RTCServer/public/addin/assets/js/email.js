/**
 * 邮件发送
 */


var select_emp_mode = 2 ;
var field_data = "col_email"

/*
method	邮件发送前的验证，扩展功能，供定制
return 	true/false
*/
function email_send_valid_ext()
{
	return true ;
}

/*
method	初始化发送界面
		人员查询控件，人员树选择控件，人员选择容器，邮件内容输入，定时发送控件，界面布局
*/
function email_send_init()
{

	//初始化人员选择控件
    emp_picker_init();  

    //初始化人员容器控件
    usercontainer_init();


	//初始化表单
	dataForm = $("#form").dataForm({savecallback:saveCallBack});
    $("#btn_save").click(function(){
        send_email();
    })
 

	//初始化界面布局
    var abs_height = 58 + 40 ;
    $(".tree").attr("abs_height",abs_height + 100) ;
    $("#view_users").attr("abs_height",abs_height + 272) ;
    resize();
    window.onresize = function(e){
	    resize();
    }
	
}







/*
method	0 发送邮件
*/
function send_email()
{
    var send_name = $("#col_send_name").val();
    var send_time = $("#col_send_time").val();
    var send_content = $("#col_content").val() ;
    var send_data = usercontainer_get();
 

	//扩展的验证
	if  (email_send_valid_ext() == false)
		return ;
		
    //valid data
    if (send_data.id == "")
    {
    	alert("请选择接收者");
        return ;
    }
	
	
    if (send_content == "")
    {
        alert("请输入邮件的内容");
        return ;
    }
	
 
	//jc 20150818 
	var regStr = "[`~@%#$^&*()|{}''\\[\\]<>/ \\；：]" ;
	if (specialCharValidate(send_content,regStr))
	{
		alert(langs.email_content_specialchar + regStr);
		return ;
	}
	
    if ($("#chk_fix").is(":checked"))
    {
        if ($("#col_send_time").val() == "")
        {
            alert(langs.email_require_sendtime);
            return ;
        }
    }
    else
    {
        $("#col_send_time").val("");
    }


    setLoadingBtn($("#btn_save")) ;

    get_container_user(get_container_user_callback) ;

}

function get_container_user_callback(recvs)
{
	alert("dddd");
    var recvs = get_users(send_data);

}


/*
method	1 得到接收者(获取部门下的人员)
*/
function send_email_recv(send_name,send_time,send_content,recvs)
{
    var count = recvs.datas.split(",").length;
    if ((email_recver_limit> 0) && (email_recver_limit < count ) )
    {
        alert(langs.email_recver_count_overt.replace("{Count}",email_recver_limit)) ;
        setSubmitBtn($("#btn_save"));
        return ;
    }
    
	//发送邮件
	send_email_url(recvs.datas,send_content,recvs.names,send_name,send_time) ;

}


/*
method	2 发送邮件
*/
function send_email_url(mobile,content,recvname,sendname,sendtime)
{
	var url = getAjaxUrl("sms","send_email");
	
    var data = {"mobile":mobile,"content":content,"recvname":recvname,"sendname":sendname,"sendtime":sendtime};
	
	$.ajax({
	   type: "POST",
	   data:data,
	   dataType:"json",
	   url:url,
	   success: function(result)
	   {
		   	//发送无效
			if (result.status == -1)
			{
				alert(result.msg) ;
				setSubmitBtn($("#btn_save")) ;
				return ;
			}
			else
			{
				if (result.status < 1)
				   alert(langs.email_send_fail.replace("{Error}",result.msg));
				else
				   alert(langs.email_send_success);
				
				$("#col_status").val(result.status);
				$("#col_return").val(result.msg);
				$("#col_send_url").val("");
				$("#col_send_time").val(get_send_time());
				send_email_save();
			}

	   }
	});	
}


/*
method	3 保存邮件发送结果
*/
function send_email_save()
{
   
}

/*
method	4 保存后回调
*/
function saveCallBack()
{

}




