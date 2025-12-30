///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//生成发送短信URL(不同运营商，格式不一样)
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_sms_url(send_name,send_time,send_content,names,mobiles)
{
    var send_users = "" ;
    var url = SEND_URL;

	var arr_name = names.split(",");
	var arr_mobile = mobiles.split(",");
	for(var i=0;i<arr_name.length;i++)
	{
		if($.trim(arr_mobile[i]))
		{
			send_users += (send_users == ""?"":",") + arr_mobile[i];
		}

	}

    url = url.replace("{content}",send_content + "[" + send_name + "]");
	url = url.replace("{account}",sendAccount);
	url = url.replace("{password}",sendPassword);
    url = url.replace("{users}",send_users);
	url = url.replace("{time}",send_time);
    return url ;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//返回短信结果(不同运营商，格式不一样)
//status(0失败 1成功)  msg(错误信息)
//{"MessageID":1816,"Msg":"信息发送成功！","ExecuteState":1}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_sms_result(response)
{
    var result = {"status":0,"msg":""};
    var res = parseInt(response);
    if( res == 100)
    {
    	result.status = 1;
    }
    result.msg = get_result_msg(res);
    return result;
}

//返回详细提示信息
function get_result_msg(response)
{
	switch(response)
	{
		case 100:
			return "短信发送成功";
		case 101:
			return "帐号验证失败";
		case 102:
			return "剩余短信不足";
		case 103:
			return "操作失败";
		case 104:
			return "内容含非法字符";
		case 105:
			return "短信内容过长";
		case 106:
			return "号码过多";
		case 107:
			return "短信发送频率过快";
		case 108:
			return "号码内容为空";
		case 109:
			return "短信发送帐号被冻结";
	}
}


