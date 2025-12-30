/*
method	短信发送功能
		0  send_sms() 验证表单，获取接收者
		1  send_sms_recv(send_name,send_time,send_content,recvs) 根据接收者，内容得到发送的URL
		2  send_sms_url 发送到短信接口 ,返回发送 
		3  send_sms_save 保存发送的信息
*/
var count_input;
var count_tip;
var count_max;
var select_emp_mode = 2 ;
var field_data = "col_mobile" ;

/*
method	短信发送前的验证，扩展功能，供定制
return 	true/false
*/
function sms_send_valid_ext()
{
	return true ;
}

/*
method	初始化发送界面
		人员查询控件，人员树选择控件，人员选择容器，短信内容输入，定时发送控件，界面布局
*/
function sms_send_init()
{

	//初始化人员选择控件
    emp_picker_init();  

    //初始化人员容器控件
    usercontainer_init();


	//初始化短信内容输入
    count_input = $("#col_content");
    count_tip = $("#col_content_tip");
    count_max = $(count_input).attr("maxlength");
	count_char();
    $("#col_content").keyup(function(){
        count_char();
        return false;
    })
	
	//初始化定时发送
    $("#chk_fix").click(function(){
        $(".container_time").toggle();
    })
    $(".datetimepicker").datetimepicker({format: "yyyy-mm-dd hh:ii",autoclose: true,pickerPosition:'top-left'});

	//初始化表单
	dataForm = $("#form").dataForm({savecallback:saveCallBack});
    $("#btn_save").click(function(){
        send_sms();
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
method	0 发送短信
*/
function send_sms()
{
    var send_name = $("#col_send_name").val();
    var send_time = $("#col_send_time").val();
    var send_content = $("#col_content").val() ;
    send_data = usercontainer_get();
    

	//扩展的验证
	if  (sms_send_valid_ext() == false)
		return ;
		
    //valid data
    if (send_data.id == "")
    {
        alert(langs.sms_require_recver);
        return ;
    }
	
	
    if (send_content == "")
    {
        alert(langs.sms_require_content);
        return ;
    }
	
 
	//jc 20150818 
	var regStr = "[`~@%#$^&*()|{}''\\[\\]<>/ \\；：]" ;
	if (specialCharValidate(send_content,regStr))
	{
		alert(langs.sms_content_specialchar + regStr);
		return ;
	}
	
    if ($("#chk_fix").is(":checked"))
    {
        if ($("#col_send_time").val() == "")
        {
            alert(langs.sms_require_sendtime);
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
	//20151127 不知道为什么要用这个函数 recvs 已经是此格式了 {names:"jc",datas:"132"}
    //var recvs = get_users(send_data);
    
    $("#col_recv_name").val(recvs.names);
    $("#col_recv_mobile").val(recvs.datas);
    

    var send_name = $("#col_send_name").val();
    var send_time = $("#col_send_time").val();
    var send_content = $("#col_content").val() ;
    send_sms_recv(send_name,send_time,send_content,recvs) ;
}


/*
method	1 得到接收者(获取部门下的人员)
*/
function send_sms_recv(send_name,send_time,send_content,recvs)
{
    var count = recvs.datas.split(",").length;
    if ((sms_recver_limit> 0) && (sms_recver_limit < count ) )
    {
        alert(langs.sms_recver_count_overt.replace("{Count}",sms_recver_limit)) ;
        setSubmitBtn($("#btn_save"));
        return ;
    }
    
	//发送短信
	send_sms_url(recvs.datas,send_content,recvs.names,send_name,send_time) ;

}


/*
method	2 发送短信
*/
function send_sms_url(mobile,content,recvname,sendname,sendtime)
{
	var url = getAjaxUrl("sms","send_sms");
	
    var data = {"mobile":mobile,"content":content,"recvname":recvname,"sendname":sendname,"sendtime":sendtime};
	//document.write(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   data:data,
	   url:url,
	   success: function(result)
	   {	
		   //这里不要用dataType JSON

		   if (result == "")
			   result = {"status":0,"msg":""} ;
		   else
			   result = eval('(' + result + ')');  //to json

		   //短信接口返回值修改
		   result.status=result.replyCode;
		   result.msg=result.replyMsg;
		   //
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
				   alert(langs.sms_send_fail.replace("{Error}",result.msg));
				else
				   alert(langs.sms_send_success);
				
				$("#col_status").val(result.status);
				$("#col_return").val(result.msg);
				$("#col_send_url").val("");
				$("#col_send_time").val(get_send_time());
				send_sms_save();
			}

	   }
	});	
}


/*
method	3 保存短信发送结果
*/
function send_sms_save()
{
    dataForm.save();
}

/*
method	4 保存后回调
*/
function saveCallBack()
{
	setSubmitBtn($("#btn_save")) ;
    location.href = "sms_list.html?" + query ;
    //usercontainer_clear();
}




/*
method	短信内容计数器
*/
function count_char()
{
    var count_current = $(count_input).val().length ;
    var count_last = count_max - count_current ;

    if (count_last <= 0)
    {
        $(count_input).val($(count_input).val().substring(0,count_max));
        count_last = 0 ;
    }

    if (count_current == 0 )
        $(count_tip).html(langs.sms_content_over.replace("{Max}",count_max));
    else
        $(count_tip).html(langs.sms_content_length.replace("{Max}",count_max).replace("{Last}",count_last));


}


///////////////////////////////////////////////////////////////////////////////////
// 得到发送的时候
///////////////////////////////////////////////////////////////////////////////////
function get_send_time()
{
    var send_time =$("#col_send_time").val();
    if (send_time == "")
        send_time = curr_time ;
    else
        send_time += ":00" ;
    return send_time ;
}


