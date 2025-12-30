<?php  require_once("../include/fun.php");?>
<?php
define("MENU","SMS_ACCOUNT") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>

				<div class="page-header"><h1>短信帐号</h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                    <button type="button" class="btn btn-default" action-type="account_edit">分配</button>
				</div>
				<!--End SearchBar-->

				<!--List--->
                <table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="rtc_sms_account" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="*">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>帐号</td>
                            <td>密码</td>
                            <td>部门</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="list"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${col_id}" data-name="${col_account}">
                        <td>${col_id}</td>
                        <td>${col_account}</td>
                        <td>${col_password}</td>
                        <td>${col_emp_name}</td>
                        <td>
                            <a href="javascript:void(0);" action-data="${col_id}" action-type="account_edit" >修改</a>
                            <a href="javascript:void(0);" action-data="${col_id}" action-type="account_delete" >删除</a>
                        </td>
                    </tr>
                </script>
				<!--End List--->

				<?php  require_once("../include/footer.php");?>


</body>
</html>

<script language="javascript" >

var dataList ;

$(document).ready(function(){

	 account_list_init();

})
function account_list_init()
{
	dataList = $("#datalist").dataList();
}

function account_edit(_id)
{
	if (_id == undefined)
		dialog("sms_account","分配帐号","sms_account_edit.html" ) ;
	else
		dialog("sms_account","修改帐号","sms_account_edit.html?id=" + _id ) ;
}


var id = "" ;
function account_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}



</script>