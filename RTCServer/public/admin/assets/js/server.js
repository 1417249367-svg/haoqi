var timer ;
var cmdid ;
//提交命令 ,返回cmdid
function cmd_post(cmdtype,cmdmemo,prior,iswaiting)
{
   showLoading();
   var url = getAjaxUrl("server","cmd_create") ;
   var data = {type:cmdtype,memo:cmdmemo,prior:prior};
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:data,
       success: function(result){
			cmdid = result.cmdid ;
			
			if (iswaiting)
				timer = setInterval(cmd_get, 5000); // create timer  
			else
				hideLoading();
				
       }
   });
}

//获取命令是否完成
function cmd_get()
{
   var url = getAjaxUrl("server","cmd_status") ;
   var data = {cmdid:cmdid};
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:data,
       success: function(result){
			if (result.status)
			{
				clearInterval(timer);
				hideLoading();
				dataList.reload();
			}
       }
   });
}

//取消命令
function cmd_cancel()
{
   cmdid = getSelectedId();
   if (cmdid == "")
   		return ;
   var url = getAjaxUrl("server","cmd_cancel") ;
   var data = {cmdid:cmdid};
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:data,
       success: function(result){
			if (result.status)
				$(getIds("cmd",cmdid)).fadeOut();
       }
   });
}