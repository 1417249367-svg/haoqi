/*
安装配置
*/

var system_db_type = "access" ;
var system_db_server = "127.0.0.1" ;
var system_db_name = "rtcdbms" ;
var system_db_user = "" ;
var system_db_password = "seekinfo" ;
var system_db_port = "1433" ;

function show_step(id)
{
	$(".step").hide();
	$("#" + id).show();
}

/**
 * 显示安装界面
 */
function step0_next()
{
	show_step("step1")
}

function step1_prev()
{
	show_step("step0")
}

/*
method	显示数据库配置页
*/
function step1_next()
{
//	if (trim($("#CompanyName").val()) == "")
//	{
//		myAlert(langs.text_input_companyname);
//		$("#CompanyName").focus();
//		return ;
//	}

	var dbType= get_dbtype();
	

	//变化数据类型
//	if ((dbType != curDBType)  || (curDBPort == ""))
//	{
		var dbPort = get_defaultport(dbType) ;
		$("#DBPort").val(dbPort);
//	}


		
	if (dbType == "dm"){
		$("#row_dbname").hide();
		$("#DBUser").val("SYSDBA");
	}else{
		$("#row_dbname").show();
		$("#DBUser").val($("#DBUser1").val());
	}
		

//	if (dbType == system_db_type)
//		install(1);
//	else{
		show_step("step2");
//		var data = "DBType=" + dbType ;
//		var url = getAspUrl("service",data) ;
//	   $.ajax({
//		   type: "POST",
//		   dataType:"jsonp",
//		   url: url,
//		   success: function(result){
//				if (result.msg=="yes"){
//					//myAlert("数据在线同步成功");
//	
//				}else
//					myAlert(getErrorText(result.errnum));
//		   }
//	   });
//	}
}

function step2_prev()
{
	show_step("step1");
}

function step2_next()
{
	install(2);
}

function get_dbtype()
{
	var dbType = getRadioValue("rad_dbtype") ;
	if (dbType == "-1")
		dbType = $('#drp_dbtype').val();
	return dbType ;
}

function get_defaultport(dbtype)
{
	switch(dbtype)
	{
		case "mysql":
			return 3306;
		case "oracle":
			return 1521;
		case "dm":
			return 5236;
		default: 
			return 1433; // mariadb/mysql
	}
}

function install(step_num)
{
	show_step("step_submiting");

	var dbtype = get_dbtype() ;
	

	//如果是内置数据库
	if (dbtype == system_db_type)
	{
		$("#DBServer").val(system_db_server);
		$("#DBName").val(system_db_name);
		$("#DBUser").val(system_db_user);
		$("#DBPassword").val(system_db_password);
		$("#DBPort").val(system_db_port);
	}

	//生成提交的数据
	var data = $("form").serialize()  ;
	data = data + "&DBType=" + dbtype ;

//	var companyName = trim($("#CompanyName").val());
//	if (companyName == "")
//	{
//		myAlert(langs.text_input_companyname);
//		show_step("step1");
//		return ;
//	}


    var url = "../public/install.html?op=install";
//console.log(url+data);
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url:url,
	   success: function(result){
	   		hideLoading();
		    if (result.status)
			{
				if (result.init == 1){
					$("#container_init").show();
					setTimeout('install_2();', 3000);
				}else
					$("#container_init").hide();

				show_step("step_success");
				
				//重启服务 restart
				restart();

			}
			else
			{
				$("#container_error").html(result.msg);
				show_step("step_fail");
			}
	   }
	});
}


function update()
{
	show_step("step_submiting");

	var data = $("form").serialize()  ;

    var url = "../public/install.html?op=update" ;

	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url:url,
	   success: function(result){
		    if (result.status)
				show_step("step_success");
			else
			{
				$("#container_error").html(result.msg);
				show_step("step_fail");
			}
	   }
	});
}

/*
method	重启服务
*/
function restart()
{
    var url = "../public/install.html?op=restart" ;
	$.ajax({
	   type: "POST",
	   url:url,
	   success: function(result){
	   }
	});
}

function install_2()
{
    var url = "../public/install.html?op=install_2&init=1" ;
	$.ajax({
	   type: "POST",
	   url:url,
	   success: function(result){
	   }
	});
}