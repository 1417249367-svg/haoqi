function sms_formatData(data){
    for (var i = 0; i < data.length; i++) {
        if (data[i].col_status == 0)
            data[i].col_status_name = "失败";
        else
            if (data[i].col_status == 1)
                data[i].col_status_name = "成功";
    }
    return data;
}


function sms_delete(_smsId){
    smsId = getSelectedId(_smsId);
    if (smsId == "")
        return;
    if (confirm("你确定要删除吗？"))
        sms_delete_post(smsId);
}


function sms_delete_post(smsId)
	{
	   var url = getAjaxUrl("sms","delete","smsid=" + smsId) ;
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
				if (result.status)
					removeRows(smsId);
				else
					myAlert(getErrorText(result.errnum));
		   }
	   });
	}