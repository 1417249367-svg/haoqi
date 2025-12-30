<?php  require_once("../include/fun.php");?>
<?php
define("MENU","USER") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/user.js"></script>
	<script type="text/javascript" src="../assets/js/tagpicker.js"></script>
    <script type="text/javascript" src="../assets/js/rspublic.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('user_list_page_title')?></h1></div>


                <div class="searchbar clearfix">
                    <div class="pull-left">
                      <!--<button type="button" class="btn btn-default" action-type="user_edit">新增人员</button>-->
					  <div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?=get_lang('user_list_btn_batch')?> <span class="caret"></span></button>
						<ul class="dropdown-menu">
                          <li><a href="#" action-type="user_role"><?=get_lang('user_list_dropdown_role')?></a></li>
						  <li><a href="#" action-type="user_attr"><?=get_lang('user_list_dropdown_properties')?></a></li>
						  <li><a href="#" action-type="user_dept"><?=get_lang('user_list_dropdown_dept')?></a></li>

						  <!-- <li><a href="#" action-type="set_tag" action-data="1,0">设置标签</a></li> -->
						  <li><a href="#" action-type="user_delete"><?=get_lang('user_list_dropdown_delete')?></a></li>
						</ul>
					  </div>
                    </div>
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('user_list_ph_search')?>" >
                    </div>
                </div>

				<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="Users_ID" data-fldid="userid" data-fldsort="" data-where=""  data-fldlist="*" data-ispage="1" data-obj="user">
				  <thead>
					<tr>
					  <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
					  <td data-sortfield="username" style="width:150px"><?=get_lang('user_list_col_loginname')?></td>
					  <td data-sortfield="fcname" style="width:150px"><?=get_lang('user_list_col_name')?></td>
                      <td data-sortfield="path" style="width:300px;"><?=get_lang('field_dept')?></td>
					  <td data-sortfield="userico" style="width:80px"><?=get_lang('user_list_col_sex')?></td>
					  <td data-sortfield="tel1" style="width:150px"><?=get_lang('user_list_col_mobile')?></td>
                      <td data-sortfield="jod" style="width: 80px"><?=get_lang('user_edit_lb_jobtitle')?></td>
					  <td data-sortfield="effigy" style="width:150px"><?=get_lang('user_list_col_other')?></td>
                      <td data-sortfield="expiretime" style="width:150px"><?=get_lang('user_list_col_expiretime')?></td>
					  <td data-sortfield="ismanager" style="width:80px"><?=get_lang('user_list_col_issuper')?></td>
					  <td data-sortfield="userstate" style="width:80px"><?=get_lang('user_list_col_disabled')?></td>
					  <td style="width:120px"></td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${userid}" id="user_${userid}" loginname="${username}">
						<td><input type="checkbox" name="chk_Id" value="'${userid}'"></td>
						<td><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit">${username}</a></td>
						<td>${fcname}</td>
						<td>${path}</td>
						<td>${userico}</td>
						<td>${tel1}</td>
						<td>${jod}</td>
						<td>${effigy}</td>
						<td>${expiretime}</td>
						<td><a href="#" class="icon-check${ismanager} btn_super" data-value="${ismanager}" action-data="${userid},'ismanager',this"  action-type="dataList.setSwitch"></a></td>
						<td><a href="#" class="icon_check${userstate} btn_disabled" data-value="${userstate}" action-data="${userid},'userstate',this"  action-type="dataList.setSwitch"></a></td>
						<td>
							<a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit"><?=get_lang('btn_edit')?></a>
							<!--<a href="javascript:void(0);" action-data="1,${col_id}" action-type="set_tag">标签</a>-->
							<a href="javascript:void(0);" action-data="'${userid}'" action-type="user_delete" class="btn_delete" ><?=get_lang('btn_delete')?></a>
						</td>
					</tr>
				</script>
				<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
	var _key = "<?=g("key")?>" ;
    $(document).ready(function(){
		window.onbeforeunload = function(event) {
			OnlineData();
		};
        if (_key != "")
            $("#key").val(_key);

        dataList = $("#datalist").attr("data-query", "label=online_list").attr("data-where",get_where()).dataList(user_formatData,listCallBack);

        $("#key").keyup(function(){
            user_search();
        })
    })

	function listCallBack()
	{
		$("tr[loginname=admin]").each(function(){
			$("input[type=checkbox]",this).remove();
			
			$(".btn_super,.btn_disabled,.btn_delete",this).each(function(){
				$(this).unbind("click");
				$(this).click(function(){
					myAlert("<?=get_lang('user_list_alert')?>");
				})
			})
			
		})
	}
</script>

