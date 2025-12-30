<?php  require_once("../include/fun.php");?>
<?php
define("MENU","ONLINE") ;

$db = new DB();
//$sql = " select count(*) from hs_user where col_issystem=0 " ;     //不包含系统帐号
$sql = " select count(UserID) as c from Users_ID";
$count = $db -> executeDataValue($sql);
$sql = " select count(UserID) as c from Users_ID where UserIcoLine<>0";
$count_online = $db -> executeDataValue($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body>
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1><?=get_lang('online_list_title')?></h1></div>
			        <div class="searchbar">
                        <div class="pull-left">
                            <button type="button" class="btn btn-default" action-type="export_user_online"><?=get_lang("btn_expuser")?></button>
                        </div>
			        </div>
				<table id="datalist" class="table table-striped table-hover data-list" data-tmpid="tmpl_list" data-table="Users_ID" data-fldid="userid" data-fldsort="" data-where=""  data-fldlist="" data-ispage="0" data-obj="user">
				  <thead>
					<tr>
                        <!--<td data-sortfield="col_id" style="width:300px;">ID</td>-->
                        <td data-sortfield="username" style="width:100px;"><?=get_lang('online_list_table_account')?></td>
                        <td data-sortfield="fcname" style="width:50px;"><?=get_lang('online_list_table_user')?></td>
                        <td data-sortfield="path" style="width:300px;"><?=get_lang('field_dept')?></td>
                        <td data-sortfield="userico" style="width:50px;"><?=get_lang('user_list_col_sex')?></td>
                        <td data-sortfield="usericoline" style="width:100px;"><?=get_lang('online_list_table_version')?></td>
                        <td data-sortfield="logintime" style="width:150px;"><?=get_lang('online_list_table_logintime')?></td>
                        <td data-sortfield="manufacturer" style="width:150px;"><?=get_lang('online_list_table_manufacturer')?></td>
                        <td data-sortfield="mac" style="width:200px;"><?=get_lang('online_list_table_mac')?></td>
                        <td data-sortfield="localip" style="width:150px;"><?=get_lang('online_list_table_ip')?></td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${userid}" id="user_${userid}" loginname="${username}">
						<td><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit">${username}</a></td>
						<td>${fcname}</td>
						<td>${path}</td>
						<td>${userico}</td>
						<td>${usericoline}</td>
						<td>${logintime}</td>
						<td>${manufacturer}</td>
						<td>${mac}</td>
						<td>${localip}</td>
					</tr>
				</script>           

	<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
    $(document).ready(function(){
        dataList = $("#datalist").attr("data-query", "label=online_list").attr("data-where",get_where()).dataList(user_formatData,listCallBack);

    })
	
	function get_where()
	{
		var where = "";
		where = getWhereSql(where, "UserIcoLine<>0") ;
		return where ;
	}
	
    function user_formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            if (data[i].userico == "1")
                data[i].userico = langs.sex_1 ;
            else if (data[i].userico == "2")
                data[i].userico = langs.sex_2 ;
			else
			    data[i].userico = "" ;
            if (data[i].usericoline == "1")
                data[i].usericoline = langs.status_online ;
            else if (data[i].usericoline == "2")
                data[i].usericoline = langs.status_go_away ;
            else if (data[i].usericoline == "3")
                data[i].usericoline = langs.status_mobile_online ;
            data[i].username = data[i].username.toLowerCase();
        }
        return data ;
    }
	
	function listCallBack()
	{

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

	function export_user_online()
	{
		showLoading(langs.export_doing);
		var url = getAjaxUrl("import_export","export_user_online") ;
		var where = "";
		where = getWhereSql(where, "UserIcoLine<>0") ;
		//document.write(url+where);
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
</script>