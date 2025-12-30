function meeting_delete(meetingId)
{
	if (confirm("你确定要删除吗？")){
		   var url = getAjaxUrl("meeting","delete","meetingid=" + meetingId) ;
		   $.ajax({
			   type: "POST",
			   dataType:"json",
			   url: url,
			   success: function(result){
				   	if(result.status == 1)
				   	{
				   		myAlert("会议删除成功");
				   		dataList.reload();
				   	}
			   }
		   });
	}
}

function create_init()
{
    dataForm = $("#form-meeting").dataForm({savecallback:saveCallBack});

    usercontainer = $("#container_users") ;
    $("#btn_save").click(function(){
    	create_meeting();
    })
}


function create_meeting()
{
	var meeting_name = $("#col_name").val();
    var user_data = usercontainer_get();
    
    //valid data
    if(meeting_name == "")
    {
    	myAlert("请输入会议主题");
        return ;
    }
    
    if(specialCharValidate(meeting_name))
    {
    	myAlert("会议主题不能包含非法字符");
    	return;
    }
    
    if (user_data.id == "")
    {
    	
    	myAlert("请选择与会人员");
        return ;
    }
    
    $("#userids").val(user_data.id);
    $("#loginnames").val(user_data.loginname);
    $("#usernames").val(user_data.name);
    
	dataForm.save();
}

function saveCallBack()
{
	myAlert("会议创建成功");
	window.location.reload();
}

///////////////////////////////////////////////////////////////////////////////////
// User Container
///////////////////////////////////////////////////////////////////////////////////
var usercontainer ;

//容器清空
function usercontainer_clear()
{
    $(usercontainer).html("") ;
}

//容器添加
function usercontainer_add(user_id,user_loginname,user_name)
{
    if (user_id == "")
        return ;

	var item = user_id.split("_") ;

	if ($("[data-id='" + user_id + "']",usercontainer).html() != undefined)
	{
		myAlert("人员【" + user_name + "】已经存在");
		return ;
	}
	
	if(user_loginname ==loginName)
	{
		return ;
	}

    var html = "" ;
    html +='<li data-id="' + user_id + '" data-name="' + user_name + '" data-loginname="' + user_loginname + '" class="user">' ;
    html += '<span>' + user_name + '</span>' ;
    html += '<i onclick="usercontainer_delete(this)"></i>' ;
    html +='</li>' ;


    $(usercontainer).append(html) ;
}

function usercontainer_delete(e)
{
    $(e).parent().remove();
}

//容器得到的数据
//{id:,name:,loginname:}
function usercontainer_get()
{
    var id = "" ;
    var name = "" ;
    var loginname="";
    $("li",usercontainer).each(function(){
        id += (id ==""?"":",") + $(this).attr("data-id") ;
        name += (name ==""?"":",") + $(this).attr("data-name");
        loginname +=(loginname==""?"":",") + $(this).attr("data-loginname");
    })
    return {id:id,name:name,loginname:loginname} ;
}


function listCallBack()
{
	$(".meetinglist").each(function(){
		var container = this ;
		var meetingId = $(this).attr("meeting_id");
		var meetingItemIndex = $(this).attr("meeting_itemindex");
		var url = getAjaxUrl("meeting","get_attenders","meetingid=" + meetingId) ;
		   $.ajax({
			   type: "POST",
			   dataType:"json",
			   url: url,
			   success: function(result){
					$(".attenders",container).html(result.attenders);
					
					if(parseInt(result.isadmin) == 1)
					{
						$("#meeting_btn" + meetingItemIndex).show();
					}
						
			   }
		   });
	})
}