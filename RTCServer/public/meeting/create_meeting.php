<?php
require_once ("include/fun.php");
define ( "MENU", "CREATE" );
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/meeting.css"
	media="screen" />
<script type="text/javascript" src="assets/js/meeting.js"></script>
</head>
<body class="body-frame">
	<div class="navbar navbar-inverse navbar-fixed-top navbar-inner"
		id="header">
			<div class="navbar-header">
				<h4>&nbsp;&nbsp;<?=PRODUCT_NAME?>视频会议</h4>
			</div>
	</div>
	<div id="content">
		<div id="sidebar">
			<?php  require_once("include/menu.php");?>
		</div>
		<div id="user_tree">
			<?php  require_once("include/emp_picker.php");?>
		</div>
		<div id="create_form">
			<form id="form-meeting" method="post" data-obj="meeting"
				data-table="tab_meet" data-fldid="col_id" data-fldname="col_name">
				<div class="form-group">
					<div>
						<label for="col_name" class="pull-left"><h5>会议主题</h5></label>
						<div class="clear"></div>
					</div>
					<div>
						<input id="col_name" name="col_name" placeholder="会议主题"
							type="text" class="form-control data-field" required
							data-msg-required="请输入会议主题" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label for="users"><h5>与会人员</h5></label>
					<div>
						<div id="view_users"
							style="height: 200px; overflow: auto; padding: 4px;"
							class="form-control fluent">
							<ul id="container_users" class="dotlist"></ul>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="padding">
					<div class="pull-right">
						<input type="button" value="创建会议" id="btn_save" class="btn btn-primary" style="padding: 2px 20px; height: auto;" />
						<input type="hidden" id="col_id" name="col_id" class="form-control data-field" value="<?=create_guid(1) ?>" /> 
					    <input type="hidden" id="col_createid" name="col_createid" class="form-control data-field" value="<?=CurUser::GetUserId() ?>" /> 
					    <input type="hidden" id="col_createname" name="col_createname" class="form-control data-field input-sm" value="<?=CurUser::GetUserName() ?>" /> 
					    <input type="hidden" id="col_createlogin" name="col_createlogin" class="form-control data-field input-sm" value="<?=CurUser::getLoginName().RTC_DOMAIN ?>" /> 
					    <input type="hidden" id="col_state" name="col_state" class="form-control data-field input-sm" value="1" />
					    <input type="hidden" id="userids" name="userids" class="form-control input-sm" value="" />
					    <input type="hidden" id="loginnames" name="loginnames" class="form-control input-sm" value="" />
					    <input type="hidden" id="usernames" name="usernames" class="form-control input-sm" value="" />
					</div>
					<div class="clear"></div>
				</div>
			</form>

		</div>
	</div>
</body>
</html>
<script type="text/javascript">
var dataForm ;
var dataList ;
var query = "<?=$_SERVER["QUERY_STRING"] ?>";
var SELECT_MODE = parseInt("<?=g("mode",1) ?>") ; // 1支持部门    2支持部门自动钩选人员   3只支持选择人员
var groupId = parseInt("<?=g("groupid",0) ?>") ;
var loginName = "<?= CurUser::getLoginName()?>";


$(document).ready(function(){

 	select_emp_mode = SELECT_MODE ;

	create_init();
    emp_picker_init();  //初始化人员选择控件
    resize();
    window.onresize = function(e){
	    resize();
    }
    if(groupId>0){
        select_group();
    }
})


function select_group(){

	var url = getAjaxUrl("meeting","select_group","groupid=" + groupId );

	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
			   data = result.rows;
				for(i=0;i<data.length;i++)
				{
					usercontainer_add(data[i].col_id,data[i].col_loginname,data[i].col_name);
				}
		   }
	   });
}
</script>

