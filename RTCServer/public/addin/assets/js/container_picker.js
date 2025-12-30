
var usercontainer ;
var select_userid = "" ;
var select_deptid = "" ;
var send_data = "" ;
function usercontainer_init()
{
	//初始化人员选择容器
    usercontainer = $("#container_users") ;
    
	//设置初始的人员
	if (select_userid != "")
		select_user(select_userid);
	
	//设置初始的部门
	if (select_deptid != "")
	{
		select_dept(select_deptid);
		select_emp_mode = 1 ; //1支持部门发送
	}
}

//容器清空
function usercontainer_clear()
{
    $(usercontainer).html("") ;
}

//容器添加
function usercontainer_add(user_id,user_name)
{
    if (user_id == "")
        return ;
		
	var arrItem = user_id.split("_");
	var uid=arrItem[2];
	if ($("[data-uid='" + uid + "']",usercontainer).html() != undefined)
	{
		//alert("人员【" + user_name + "】已经存在");
		return ;
	}
		
    var html = "" ;
    html +='<li data-uid="' + uid + '" data-id="' + user_id + '" data-name="' + user_name + '">' ;
    html += '<span>' + user_name + '</span>' ;
    html += '<i onclick="usercontainer_delete(this)"></i>' ;
    html +='</li>' ;
    

    $(usercontainer).append(html) ;
}

function usercontainer_delete(e)
{
    $(e).parent().remove();
    event.stopPropagation();
}

//容器得到的数据
//{ids:,names:}
function usercontainer_get()
{
    var id = "" ;
    var name = "" ;
    $("li",usercontainer).each(function(){
       
        id += (id ==""?"":",") + $(this).attr("data-id") ;
        name += (name ==""?"":",") + $(this).attr("data-name");

    })
    return {id:id,name:name} ;
}

/**
 * 得到容器里的人员，如果选择部门，会异步取人员，再返回
 * @param callback
 */


function get_container_user(callback)
{
	//全局变量
	send_data = usercontainer_get();

    if (select_emp_mode == 1)
    {
        //方法一(支持部门，异步取人员)
		//return  {"rows":[{"name":"赵昂然","mobile":"18368028281"}]}
        $("#col_recv_name").val(send_data.name);
        var url = getAjaxUrl("org","get_users","parents=" + send_data.id + "&fields=" + usersearch_field_list) ;
        $.ajax({
           type: "POST",
           dataType:"json",
           url:url,
           success: function(result){
                var recvs ={"names":"","datas":""} ;
                for(var i=0;i<result.rows.length;i++)
                {
                    var item = result.rows[i] ;
                    if ((item.name != "") && (item.datas != ""))
                    {
                        recvs.names += (recvs.names == ""?"":",")  + item.col_name ;
                        recvs.datas += (recvs.datas == ""?"":",")  + item.col_data ;
                    }
                }
                callback(recvs) ;
           }
        });
    }
    else
    {
        //方法二(只能选人员)
        var recvs = get_users(send_data);
        callback(recvs) ;
    }
}


/**
 * 得到用户信息 20151127 不知道为什么要这个函数 data 已经是返回的函数了
 * @param data 
 * @return {"names":"zs,ls","datas":"132xxxxxxxx,132xxxxxxxx"}
 */
function get_users(data)
{
    var arr_item = data.name.split(",") ;
    var recvs ={"names":"","datas":""} ;
    for(var i=0;i<arr_item.length;i++)
    {
        var item = get_item(arr_item[i]) ;
        if (item.name != "")
        {
            recvs.names += (recvs.names == ""?"":",")  + item.name ;
            recvs.datas += (recvs.datas == ""?"":",")  + item.data ;
        }
    }
    return recvs;
}


/**
 * 得到姓名或辅助信息(手机/邮箱)
 * @param user_exp zs(132xxxxxxxx)
 * @return {name:zs,mobile:13282826192}
 */
function get_item(user_exp)
{
    var pos = user_exp.lastIndexOf("(");
    var result = {"name":user_exp,"data":""};
    if (pos > -1)
    {
        result.name = user_exp.substring(0,pos);
        result.data = user_exp.substring(pos + 1,user_exp.length-1);
    }

    return result ;
}



/**
 * 传客户端选中的人员
 */
function select_user(select_userid)
{

	var url = getAjaxUrl("user","list_byid","id=" + select_userid );
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   data:{field_list:usersearch_field_list},
	   success: function(result){
		    data = result.rows;
		   
		    var error_user = "" ;
			for(i=0;i<data.length;i++)
			{
				data[i].col_data = trim(data[i].col_data) ;
				if (data[i].col_data == "")
					error_user += (error_user == ""?"":",") + data[i].col_name ;
				else
					usercontainer_add(data[i].col_id,data[i].col_name + "(" + data[i].col_data + ")");
			}

			if (error_user != "")
				alert(error_user + field_name + "为空，不能选择");
	   }
   });
}

function select_dept(select_deptid)
{
	// Ant_Group:1@asd;Ant_Group:2@asd  部门
	// Ant_Cluster 群组
	var dept_id = get_addin_deptid(select_deptid);

	var url = getAjaxUrl("org","get_emp","id=" + dept_id );
    $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   data:{field_list:"col_id,col_name"},
	   success: function(result){
		    data = result.rows;

			for(i=0;i<data.length;i++)
				usercontainer_add("1_" + data[i].emptype + "_" + data[i].col_id,data[i].col_name);

	   }
    });

}

/*
method 得到插件中的部门ID
param  select_deptid  Ant_Group:1@asd;Ant_Group:2@asd;Ant_Cluster:1
return 2_1,2_2,4_1
*/
function get_addin_deptid(select_deptid)
{
	// Ant_Group:1@asd;Ant_Group:2@asd  部门
	// Ant_Cluster 群组
	
	select_deptid = replaceAll(select_deptid,"@",":") ;
	
	var arr_dept = select_deptid.split(";");
	var ids = "" ;
	for(var i=0;i<arr_dept.length;i++)
	{
		var id = "" ;
		var arr_item = arr_dept[i].split(":");
		if (arr_item[0] == "Ant_Group")
			id = "2_" + arr_item[1] ;
		if (arr_item[0] == "Ant_Cluster")
			id = "4_" + arr_item[1] ;
		ids += (ids == ""?"":",") + id ;
	}
	return ids ;
}