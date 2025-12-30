<?php  require_once("../include/fun.php");?>
<?php
define("MENU","ROLE") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/role.js?ver=2014103101"></script>
	<script type="text/javascript" src="../assets/js/userpicker.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>

				<div class="page-header"><h1><?=get_lang('role_list_title')?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="role_edit"><?=get_lang('role_list_btn_add')?></button>
                          <!--<button type="button" class="btn btn-default" action-type="role_member">设置人员</button>-->
                          <button type="button" class="btn btn-default" action-type="role_delete"><?=get_lang('role_list_btn_delete')?></button>
                          <!--<button type="button" class="btn btn-default" action-type="role_one_key">一键创建角色</button>-->
                     </div>
                     <div class="pull-right">
                         <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('role_list_ph_search')?>" >
                     </div>
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="role" data-tmpid="tmpl_list" data-table="Role" data-fldid="ID" data-fldname="RoleName"  data-fldsort="ID" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="rolename"><?=get_lang('role_list_col_name')?></td>
                                <td data-sortfield="description"><?=get_lang('role_list_col_description')?></td>
								<td data-sortfield="defaultrole" style="width:150px"><?=get_lang('role_picker_default_role')?></a></td>
                                <td style="width:150px"></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="row-${id}" data-name="${rolename}">
							<td><input type="checkbox" name="chk_Id" value="${id}"></td>
							<td><a href="javascript:void(0);" onclick="role_edit(${id},'${rolename}')">${rolename}</a></td>
							<td>${description}</td>
							<td><input type="radio" name="defaultrole" id="defaultrole_${id}" data-value="${defaultrole}" action-data="${id},'defaultrole',this"  action-type="dataList.setradioSwitch"/></td>
							<td class="col-op">
								<!--<a href="javascript:void(0);" action-data="${id}" action-type="role_member" class="btn_member">人员</a>-->
								<a href="javascript:void(0);" onclick="role_edit(${id},'${rolename}')"><?=get_lang('role_list_col_change')?></a>
								<a href="javascript:void(0);" onclick="role_copy(${id},'${rolename}')"><?=get_lang('role_list_col_clone')?></a>
								<a href="javascript:void(0);" action-data="${id}" action-type="role_delete" class="btn_delete" ><?=get_lang('role_list_col_detele')?></a>
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
		role_list_init();
    })
</script>
