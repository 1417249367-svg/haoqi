/////////////////////////////////////////////////////////////////////////////////
//导入导出
/////////////////////////////////////////////////////////////////////////////////
var flag = "" ;

function import_upload(_flag)
{
	flag = _flag ;
	uploadFile($("#file_import"));
}

function uploadComplete(result)
{
	if(/.*[\u4e00-\u9fa5]+.*$/.test(result.filepath)) 
	{ 
	alert("文件名不能含有汉字！"); 
	return false; 
	}
	import_post(result.filepath);
}
function import_user()
{
	dialog("picker",langs.import_user,"../hs/import_user.html") ;
}

function import_dept()
{
	dialog("picker",langs.import_dept,"../hs/import_dept.html") ;
}

function import_ldap_user()
{
	dialog("ldap",langs.import_ad,"../hs/import_ldap_user.html") ;	
}

function import_rtx_user()
{
	dialog("picker",langs.import_rtx,"../hs/import_rtx_user.html") ;
}

function import_addin()
{
	dialog("picker",langs.import_plugins,"../hs/import_addin.html") ;
}

function import_ldap(){
	dialogClose("ldap");
	showLoading(langs.import_doing);
	var url = getAjaxUrl("import_export","import_ldap_user") ;
	//document.write(url+"&domain="+$("#domain").val()+"&adminuser="+$("#adminUser").val()+"&adminpassword="+$("#adminPassword").val());
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{domain:$("#domain").val(),adminuser:$("#adminUser").val(),adminpassword:$("#adminPassword").val()},
	   url: url,
	   success: function(result){
		   hideLoading();
			if (result.status)
				myAlert(langs.import_success);
			else
				myAlert(result.msg);
	   }
	});		
}


function import_post(filepath)
{
	dialogClose("picker");
	showLoading(langs.import_doing);
	var isQuick = 0;
	$("[name=quick]").each(function(){
		if ($(this).is(":checked"))
			isQuick = 1;
	})
	
	var url = getAjaxUrl("import_export","import_user","quick=" + isQuick) ;
	if (flag == "dept")
		url = getAjaxUrl("import_export","import_dept") ;
	if (flag == "rtx")
		url = getAjaxUrl("import_export","import_rtx") ;
	if (flag == "addin")
		url = getAjaxUrl("addin","import") ;
	//document.write(url+"file"+filepath);
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{file:filepath},
	   url: url,
	   success: function(result){
		    hideLoading();
			if (result.status)
				myAlert(langs.import_success);
			else
				myAlert(result.msg);
	   }
	});
}

function export_user()
{
	dialog("picker",langs.export_user,"../hs/export_user.html") ;
}

function export_user_all()
{
	dialogClose("picker");
	showLoading(langs.export_doing);
	var url = getAjaxUrl("import_export","export_user") ;
	//document.write(url);
	var where = "";
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where},
	   url: url,
	   success: function(result){
		   	hideLoading();
			if (result.status)
				to_down(result.msg) ;
			else
				myAlert(langs.export_fail);
	   }
	});
}

var status = 0 ;
function export_user_selected()
{
	dialogClose("picker");
	var ids = getCheckValue("chk_Id");
	var path = getTreePath(tree);

	if (ids == "")
	{
		myAlert(langs.export_user_require);
		return ;
	}

	showLoading(langs.export_doing);
	var url = getAjaxUrl("import_export","export_user_bywhere") ;
	var where = " where UserID in (" + ids + ")";
	//document.write(url+where+path);
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where,path:path},
	   url: url,
	   success: function(result){
		   	hideLoading();

			if (result.status)
				to_down(result.msg) ;
			else
				myAlert(result.msg);
	   }
	});

	return ;
}

function export_dept()
{
	showLoading(langs.export_doing);
	var url = getAjaxUrl("import_export","export_dept") ;
	//document.write(url+where);
	var where = "";
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where},
	   url: url,
	   success: function(result){
		   	hideLoading();
			if (result.status)
				to_down(result.msg) ;
			else
				myAlert(langs.export_fail);
	   }
	});
}



function to_down(file)
{
	location.href = "/public/download.html?file=" + file ;
}


function set_pinyin()
{
	showLoading(langs.emp_pinyin_seting);
	var url = getAjaxUrl("user","setpinyin") ;
	var where = "";
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where},
	   url: url,
	   success: function(result){
		   	hideLoading();
			myAlert(langs.text_set_success);
	   }
	});
}


function set_path()
{
	showLoading(langs.emp_deptpath_seting);
	var url = getAjaxUrl("user","setpath") ;
	var where = "";
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where},
	   url: url,
	   success: function(result){
		   	hideLoading();
			myAlert(langs.text_set_success);
	   }
	});
}



function set_index()
{
	showLoading(langs.emp_order_seting);
	var url = getAjaxUrl("user","setindex") ;
	var where = "";
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{where:where},
	   url: url,
	   success: function(result){
		   	hideLoading();
			myAlert(langs.text_set_success);
	   }
	});
}

