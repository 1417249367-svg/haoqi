
	var dataList ;

    $(document).ready(function(){
     
		address_list() ;

    })
	
	function address_list()
	{
		dataList = $("#datalist").attr("data-where",get_where()).dataList();
	}
	
	function get_where()
	{
 	    var where = "" ;
	    where = getWhereSql(where, "col_owner='" + sendAccount + "'" ) ;
        return where ;
	}
	
	function address_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm("你确定要删除吗？"))
			dataList.del(id) ;
	}
	
	function address_add()
	{	

	   var name = $("#address_name").val();
	   var mobile = $("#address_mobile").val();
	   var owner = sendAccount ;
	   var url = getAjaxUrl("sms_address","add") ;
	   if (name == "")
	   {
		   alert("请输入联系人姓名");
		   $("#address_name").focus();
		   return ;
	   }
	   
	   var reg_mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	   if (!reg_mobile.test(mobile))
	   {
		   alert("请输入有效的手机号码");
		   $("#address_mobile").focus();
		   return ;
	   }
	  
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   data:{"name":name,"mobile":mobile,"owner":owner},
		   success: function(result){
				if (result.status)
				{
					$("#address_name,#address_mobile").val("");
					dataList.reload();
				}
				else
				{
					alert("die");
					myAlert(result.msg);
				}
		   }
	   });
	}
    

	function address_select(name,mobile)
	{
		usercontainer_add("-1_" + name + "_" + mobile , name + "(" + mobile + ")") ;
	}
	
	function address_add_show()
	{
		$("#form_address_switch").hide();
		$("#form_address").show();
	}

	function address_add_hide()
	{
		$("#form_address_switch").show();
		$("#form_address").hide();
	}

