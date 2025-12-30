	var nodeId = "" ;
	var nodeText = "" ;
	function user_search(){
        dataList.search(get_where()) ;
    }

    function get_where()
    {
	    var where = "" ;
	    var key =  $("#key").val() ;

	    if (key != "")
		    where = getWhereSql(where, "(UserName like '" + key + "%') or (FcName like '" + key + "%') ") ;
        return where ;
    }

    function user_formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            if (data[i].userico == "0")
                data[i].userico = "" ;
            else if (data[i].userico == "1")
                data[i].userico = langs.sex_1 ;
            else
                data[i].userico = langs.sex_2 ;
//            if (data[i].userstate == "0")
//                data[i].userstate = "1" ;
//            else
//                data[i].userstate ="0" ;
            data[i].username = data[i].username.toLowerCase();
			if(parseInt(data[i].expiretime)) data[i].expiretime = ts2dt1(data[i].expiretime);
			else data[i].expiretime = langs.field_expiretime;
        }
        return data ;
    }

	function user_edit(_userId)
	{
		if (_userId == undefined)
		{
			// FROM TREE
			if (nodeId != "")
			{
				if (dept_select() == false)
					return ;
				if (nodeId =="0_0_0")
				{
					myAlert(getErrorText("102211"));
					return ;
				}
				//jc 20150716 生成路径，useredit会去path
				getTreePath(tree) ;
			}
		}
		if (_userId == undefined)
			dialog("user",langs.user_create,"../hs/user_edit.html?deptid=" + nodeId + "&deptname=" + escape(nodeText) ) ;
		else
			dialog("user",langs.user_edit,"../hs/user_edit.html?userid=" + _userId ) ;
	}

	function user_delete(_userId)
	{
	   userId = getSelectedId(_userId) ;
	   if (userId == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			user_delete_post(userId) ;
	}

	function user_delete_post(userId)
	{
       if(userId.indexOf("'")==-1) userId="'"+userId+"'";
	   var url = getAjaxUrl("user","delete","userid=" + userId) ;
	   //document.write(url);
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
				if (result.status)
					removeRows(replaceAll(userId,"'",""));
				else
					myAlert(getErrorText(result.errnum));
		   }
	   });
	}




	function user_detail_init()
	{

	   if (userId == "")
	   {
		   //new
		   $("#deptid").val(deptId);
		   $("#col_dept_name").val(deptName);
		   $("#col_dept_id").val(deptId.split("_")[2]);
	   }
	   else
	   {
		   //edit
		   //$("#password").val("******");
	   }

	   dataForm = $("#form-user").attr("data-id",userId).dataForm({getcallback:user_getCallBack,submitcallback:user_submitCallBack,savecallback:user_saveCallBack});

	   formatTabs("tabs");

	   $("#form-user").validate({
			invalidHandler: function(form, validator) {
				var errors = validator.errorList ;
				if (errors.length>0)
				{
					var el = $(errors[0].element) ;
					var tabId = $(el).parents(".tab-content").attr("id") ;
					$(".nav-tabs li a[href='#" + tabId + "']").click();
				}
			},
			ignore: "ui-tabs-hide",
			submitHandler: function(form) {
				dataForm.save();
				return false;
			}
	  });


	}

	function user_getCallBack(data)
	{
		if (data.col_birthday != "")
			data.col_birthday =  toDate(data.col_birthday);

		// init ip
		$("#ip").val(replaceAll(data.ip,",","\r\n")) ;

		// init mac
		$("#mac").val(replaceAll(data.mac,",","\r\n")) ;
	}

	function user_saveCallBack()
	{
		dataList.reload();
		dialogClose("user");
	}



	function user_role(_userId)
	{
	   userId = getSelectedId(_userId) ;
	   if (userId == "")
			return ;
		dialog("user_role",langs.user_attr,"../hs/user_role.html") ;
	}

	function user_attr(_userId)
	{
	   userId = getSelectedId(_userId) ;
	   if (userId == "")
			return ;
		dialog("user_attr",langs.user_attr,"../hs/user_attr.html") ;
	}

	function user_pos(_userId)
	{
	   userId = getSelectedId(_userId) ;
	   if (userId == "")
			return ;
		dialog("user_attr",langs.user_attr,"../hs/user_attr.html") ;
	}





	function user_attr_post()
	{
	   var url = getAjaxUrl("user","saveother","userid=" + userId) ;
	   //document.write(url+$('#form_attr').serialize());
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   data:$('#form_attr').serialize(),
		   url: url,
		   success: function(result){
				if (result.status)
				{
					dialogClose("user_attr");
					myAlert(langs.text_op_success);
					dataList.reload();
				}
				else
				{
					myAlert(getErrorText(result.errnum));
				}
		   }
	   });
	}
	
	function user_role_post(roleid)
	{
	   var url = getAjaxUrl("user","saverole","userid=" + userId) ;
	   //document.write(url+"roleid"+roleid);
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   data:{"roleid":roleid},
		   url: url,
		   success: function(result){
				if (result.status)
				{
					dialogClose("user_role");
					myAlert(langs.text_op_success);
					dataList.reload();
				}
				else
				{
					myAlert(getErrorText(result.errnum));
				}
		   }
	   });
	}

	function user_dept(_userId)
	{
	   userId = getSelectedId(_userId) ;
	   if (userId == "")
			return ;
		dialog("deptpicker",langs.dept_set,"../hs/dept_picker.html?action_type=user_dept_post") ;
	}

	// flag=0 添加部门  flag=1 重置部门
	function user_dept_post(targetId,targetName,flag,dept_path)
	{
	   if (flag == undefined)
	   		flag = 1 ;
       //if(userId.indexOf(",")==-1) userId="'"+userId+"'";
	   var url = getAjaxUrl("user","setdept","userid=" + userId) ;
	   //document.write(url+"flag"+flag+"targetid"+targetId+"targetname"+targetName+"dept_path"+dept_path);
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		  data:{"flag":flag,"targetid":targetId,"targetname":targetName,"dept_path":dept_path},
		   url: url,
		   success: function(result){
				if (result.status)
				{
					dataList.reload();
					dialogClose("deptpicker");
				}
				else
				{
					myAlert(getErrorText(result.errnum));
				}
		   }
	   });
	}

	function setpassword()
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
		   }
	   });

	}


