function load_list()
{
	//得到所有的服务名称
	var services = get_services();

	//得到状态
	var url = getAjaxUrl("service","get_status") ;
	//document.write(url+services);
    $.ajax({
       type: "POST",
	   dataType:"json",
	   data:{services:services},
       url: url,
       success: function(result){
		   //console.log(JSON.stringify(result));
			//得到状态
    	    //result = eval("(" + result + ")");
			for(var i=0;i<service_data.length;i++)
			{
				service_data[i].status = result.rows[i].doc_status;
				service_data[i].status_name = get_status_name(service_data[i].status);

				service_data[i].css = "icon-error" ;
				if (service_data[i].status == "4")
					service_data[i].css = "icon-success" ;
				if (service_data[i].status == "7")
					service_data[i].css = "icon-warning" ;
				if(service_data[i].name =="AntMeetingServer" || service_data[i].name =="AntMeetTransferServer" || service_data[i].name =="AntGuard" ){
					service_data[i].service_style = "display:none;";
				}
			}

			//绑定数据
			var html = $("#tmpl_list").tmpl(service_data) ;
			$("#datalist tbody").html(html);
       }
   });

}

function service_start()
{
	set_status("start","");
}

function service_restart()
{
	set_status("restart","");
}

function service_stop()
{
	set_status("stop","");
}

function set_status(service_op,services)
{
	if (services == "")
		services = getCheckValue("chk_Id");
	if (services == "")
	{
		myAlert(langs.service_select_tip);
		return ;
	}
	showLoading();
	//得到状态
	var url = getAjaxUrl("service","set_status","services=" + services + "&service_op=" + service_op) ;
    $.ajax({
       type: "POST",
       url: url,
       success: function(result){
			load_list();
			hideLoading();
			$("input:checked").prop("checked", false);
       }
   });

}

function get_services()
{
	var services = "" ;
	for(var i=0;i<service_data.length;i++)
		services += (services == ""?"":",") + service_data[i].name ;
	return services ;
}

function port_edit(service_name,service_port)
{
	dialog("port",langs.service_port_set,"port_edit.html?service=" + service_name + "&port=" + service_port) ;
}


function set_port(service_name,service_port)
{
	var url = getAjaxUrl("service","set_port","service=" + service_name + "&port=" + service_port) ;
    $.ajax({
       type: "POST",
       url: url,
       success: function(result){
			dialogClose("port");
			myAlert(langs.text_op_success);
			location.href = location.href ;
       }
   });

}


function get_status_name(status)
{
	switch(parseInt(status))
	{
		case 4:
			return serviceState.running;
		case 7:
			return serviceState.pause;
		case 1:
			return serviceState.stop;
//		case 3:
//			return serviceState.error;
//		case -1:
//			return serviceState.unknown;
		default:
			return "---";
	}
}