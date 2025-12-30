var objId ;


function group_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;
	
	//设置附加字段值
	append_fields = "col_USER_ID" ;
	append_values = "" ;
	arrObjId = objId.toString().split(",");
	
	for(var i=0;i<arrObjId.length;i++)
	{
		
	   var row = $("#group_" + arrObjId[i]) ;
	   append_values += (append_values == ""?"":",") + $(row).attr("user_id") ;
	}

	user_picker(objId,"HS_FRIEND","col_FRIEND_GROUP_ID","col_FRIEND_ID",1,"col_id",append_fields,append_values);
}

function group_detail_init()
{
	$("#col_user").autocomplete({
		source:function(query,process){
			var matchCount = this.options.items;
			var url = getAjaxUrl("user","search") ;
			$.getJSON(url,{"key":query,"top":matchCount},function(respData){
				return process(respData.rows);
			});
			
		},
		formatItem:function(item){
			return item["name"] + " (" + item["loginname"] + ")" ;
		},
		setValue:function(item){
			return {'data-value':item["name"],'real-value':item["id"]};
		}
	});	
	
   dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});

   $("#form-group").validate({
		submitHandler: function(form) {
			
			var userId = $("#col_user").attr("real-value") ;
			if ((userId == "") || (userId == undefined))
			{
				myAlert(langs.user_select_text);
				return ;
			}
			$("#col_user_id").val(userId) ;
			dataForm.save();
			return false;
		}
  });
	

}

function group_getCallBack(data)
{
	$("#col_user").attr("real-value",data.col_user_id).val(data.col_user_name);
}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("group");
}


function group_search(){
	var where = "" ;
	var key =  $("#key").val() ;

	if (key != "")
		where = getWhereSql(where," col_user_id in(select col_id from hs_user where(col_loginname like '%" + key + "%' or col_name like '%" + key + "%') )") ;

	dataList.search(where) ;
}



function group_edit(_groupId)
{
	if (_groupId == undefined)
	{

	}

	if (_groupId == undefined)
		dialog("group","新增好友组","../hs/friendgroup_edit.html" ) ;
	else
		dialog("group","修改好友组","../hs/friendgroup_edit.html?groupid=" + _groupId ) ;
}

function group_delete(_groupId)
{
   	groupId = getSelectedId(_groupId) ;
   	if (groupId == "")
		return ;
	if (confirm("你确定要删除吗？"))
		group_delete_post(groupId) ;
}

function group_delete_post(groupId)
{
   var url = getAjaxUrl("friendgroup","delete","groupid=" + groupId) ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(result){
			if (result.status)
			{
				$(getIds("group",groupId)).fadeOut();
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
   }); 
}


