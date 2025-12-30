<?php  require_once("../include/fun.php");?>
<?php
define ( "MENU", "ORG" );
$issuper = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/user.js?v=20150716"></script>
<script type="text/javascript" src="../assets/js/org.js?v=20150716"></script>
<script type="text/javascript" src="../assets/js/import.js"></script>
<script type="text/javascript" src="../assets/js/rspublic.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
    <div class="page-header">
		<h1><?=get_lang("org_title")?></h1>
	</div>

	<!--SearchBar-->
	<div class="searchbar">
		<div class="pull-left">
			<button type="button" class="btn btn-default"
				action-type="dept_create"><?=get_lang("btn_adddept")?></button>
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle"
					data-toggle="dropdown">
					<?=get_lang("btn_opdept")?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#" action-type="dept_edit"><?=get_lang("btn_editdept")?></a></li>
					<li><a href="#" action-type="dept_delete"><?=get_lang("btn_deldept")?></a></li>
					<li><a href="#" action-type="dept_move"><?=get_lang("btn_movedept")?></a></li>
				</ul>
			</div>
			<button type="button" class="btn btn-default" action-type="user_edit"><?=get_lang("btn_adduser")?></button>
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?=get_lang("btn_opuser")?> <span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="#" action-type="user_role"><?=get_lang("role_list_btn_role")?></a></li>
					<li><a href="#" action-type="user_attr"><?=get_lang("btn_setattr")?></a></li>
					<li><a href="#" action-type="user_dept"><?=get_lang("btn_setdept")?></a></li>
<!--					<li><a href="#" action-type="member_remove">从部门移出</a></li>-->
					<li><a href="#" action-type="user_delete"><?=get_lang("btn_deluser")?></a></li>
				</ul>
			</div>
					<?php
					if (CurUser::isAdmin ()) {
						?>
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown"><?=get_lang("btn_batchop")?><span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="#" action-type="import_user"><?=get_lang("btn_impuser")?></a></li>
					<li><a href="#" action-type="import_dept"><?=get_lang("btn_impdept")?></a></li>
                    <li><a href="javascript:void(0);" action-type="import_ldap_user"><?=get_lang("btn_impldap")?></a></li>
                    <li><a href="#" action-type="import_rtx_user"><?=get_lang("btn_imprtx")?></a></li>
					<li><a href="#" action-type="export_user"><?=get_lang("btn_expuser")?></a></li>
					<li><a href="#" action-type="export_dept"><?=get_lang("btn_expdept")?></a></li>
<!--					<li class="divider"></li>
					<li><a href="#" action-type="set_pinyin">重置拼音</a></li>
					<li><a href="#" action-type="set_path">重置部门路径</a></li>-->
					<!-- 一键设置按姓名排序 -->
					<!-- <li><a href="#" action-type="set_index">重置排序</a></li> -->
				</ul>
			</div>
					<?php
					}
					?>
                    </div>
		<div class="pull-right" style="width: 300px;">
			<div class="input-group">
				<input type="text" class="form-control" id="key" placeholder="<?=get_lang("org_ph_search")?>"> 
				<span class="input-group-btn"><button class="btn btn-default" type="button" action-type="member_add"><?=get_lang("btn_addmember")?></button></span>
			</div>
		</div>
	</div>
	<!--End SearchBar-->

	<!--List--->
	<div class="clearfix">
		<div class="ctree">
			<div class="widget widget-default">
				<div class="widget-heading"><?=get_lang("org_tree_title")?></div>
				<div class="widget-body" style="overflow: hidden">
					<div id="container_tree" class="container-tree"></div>
				</div>
			</div>
		</div>
		<div class="clist">
			<div class="widget widget-default">
				<div class="widget-heading">
					<?=get_lang("org_user_title")?><span id="usercount" class="pull-right"></span>
				</div>
				<div class="widget-body">
					<table id="datalist"
						class="table table-striped table-hover data-list"
						data-tmpid="tmpl_list" data-ispage="1" data-obj="user"
						data-fldid="userid" data-fldsort=""
						data-where=""
						data-fldlist="*">
						<thead>
							<tr>
								<td style="width: 10px"><input type="checkbox" name="chk_All"
									onclick="checkAll('chk_Id',this.checked)"></td>
								<td style="width: 10px"></td>
								<td data-sortfield="username" style="width: 100px"><?=get_lang("field_account")?></td>
								<td data-sortfield="fcname" style="width: 150px"><?=get_lang("field_name")?></td>
								<td data-sortfield="userico" style="width: 80px"><?=get_lang("field_sex")?></td>
								<td data-sortfield="tel1" style="width: 80px"><?=get_lang("field_mobile")?></td>
								<td data-sortfield="jod" style="width: 80px"><?=get_lang("field_job")?></td>
								<td data-sortfield="effigy" style="width: 100px"><?=get_lang("field_other")?></td>
                                <td data-sortfield="expiretime" style="width:150px"><?=get_lang('user_list_col_expiretime')?></td>
								<td data-sortfield="userstate" style="width: 80px"><?=get_lang("field_disabled")?></td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

					<script type="text/x-jquery-tmpl" id="tmpl_list">
										<tr class="row-${userid}" id="user_${userid}" loginname="${username}">
											<td><input type="checkbox" name="chk_Id" value="'${userid}'"></td>
											<td>
												<div class="btn-group">
												  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span>
												  </button>
												  <ul class="dropdown-menu" role="menu">
													<li><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit"><?=get_lang("btn_edituser")?></a></li>
													<li><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_dept" ><?=get_lang("btn_setdept")?></a></li>
<!--													<li><a href="javascript:void(0);" action-data="${userid}" action-type="member_remove" >从部门移出</a></li>-->
													<li><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_delete" class="btn_delete" ><?=get_lang("btn_deluser")?></a></li>
												  </ul>
												</div>
											</td>
											<td><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit">${username}</a></td>
											<td>${fcname}</td>
											<td>${userico}</td>
											<td>${tel1}</td>
											<td>${jod}</td>
											<td>${effigy}</td>
											<td>${expiretime}</td>
											<td><a href="#" class="icon_check${userstate} btn_disabled" data-value="${userstate}" action-data="${userid},'userstate',this"  action-type="dataList.setSwitch"></a></td>
										</tr>
									</script>
				</div>
			</div>
		</div>
	</div>
	<!--End List--->
				<?php  require_once("../include/footer.php");?>


</body>
</html>
<script language="javascript">

var dataList ;
$(document).ready(function(){
	window.onbeforeunload = function(event) {
		OnlineData();
	};
    loadTree("container_tree");

	user_search_init($("#key"));

    $(".widget-body,#container_tree").height($(document).height()-235);

})






function treeClick()
{
    nodeId = tree.getSelectedItemId() ;
    nodeText = tree.getSelectedItemText() ;


    var arrItem = nodeId.split("_") ;
    var empType = parseInt(arrItem[1]);
    viewId = parseInt(arrItem[0]);
    $("#datalist").attr("data-query","deptid=" + nodeId).attr("data-pageindex","1") ;
    if (dataList == undefined)
        dataList = $("#datalist").dataList(user_formatData,user_listBack);
    else
        dataList.reload();
}

function user_listBack(rows,count)
{
   nodeId = tree.getSelectedItemId() ;
   nodeText = tree.getSelectedItemText() ;
   $("tr[loginname=admin]").each(function(){
	  $("input[type=checkbox]",this).remove();
	  
	  $(".btn_disabled,.btn_delete",this).each(function(){
		  $(this).unbind("click");
		  $(this).click(function(){
			  myAlert(langs.role_delete_system);
		  })
	  })
	  
   })
   var url = getAjaxUrl("org","get_user_count","deptid=" + nodeId) ;
   //document.write(url);
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(result){
            if (result.status)
            {
            	$("#usercount").html(get_lang(langs.text_user_count,result.usercount));
            }
            else
            {
            	$("#usercount").html(get_lang(langs.text_user_count,"0"));
            }
       }
   });
}

</script>
