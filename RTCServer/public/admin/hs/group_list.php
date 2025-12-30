<?php  require_once("../include/fun.php");?>
<?php
define("MENU","GROUP") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/group.js"></script>
	<script type="text/javascript" src="../assets/js/userpicker.js"></script>
	<script type="text/javascript" src="../assets/js/tagpicker.js"></script>
    <script type="text/javascript" src="../assets/js/rspublic.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("group_title")?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="group_edit"><?=get_lang("btn_addgroup")?></button>
						  <!--不能用通知的人员设置功能，因为group设置人员要特殊处理(发送通知)--->
						  <!--
                          <button type="button" class="btn btn-default" action-type="group_member">设置人员</button>
						  -->
                          <!-- <button type="button" class="btn btn-default" action-type="group_tag">设置标签</button>-->
                          <button type="button" class="btn btn-default" action-type="group_delete"><?=get_lang("btn_delgroup")?></button>
                     </div>
                     <div class="pull-right">
                         <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang("group_ph_search")?>" />

                     </div>
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="group" data-tmpid="tmpl_list" data-table="clot_ro" data-fldid="typeid" data-fldname="typename"  data-fldsort="typeid" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="typename"><?=get_lang("field_name")?></td>
                                <td data-sortfield="remark"><?=get_lang("field_desc")?></td>
                                <td data-sortfield="to_date"><?=get_lang("field_dt")?></td>
                                <td data-sortfield="sender" style="width: 80px"><?=get_lang("group_ph_Banned")?></td>
                                <!-- <td >标签</td> -->
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${typeid}" data-name="${typename}" data-id="${typeid}">
							<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
							<td><a href="javascript:void(0);" onclick="group_edit('${typeid}','${typename}')">${typename}</a></td>
							<td>${remark}</td>
							<td>${to_date}</td>
							<td><a href="#" class="icon-check${sender} btn_disabled" data-value="${sender}" action-data="'${typeid}','sender',this"  action-type="dataList.setSwitch"></a></td>
							<!--<td class="tags"></td>-->
							<td class="col-op">
								<a href="javascript:void(0);" action-data="'${typeid}'" action-type="group_member"><?=get_lang("btn_setmember")?></a>
								<!--<a href="javascript:void(0);" action-data="${col_id}" action-type="group_tag">标签</a>-->
								<a href="javascript:void(0);" onclick="group_edit('${typeid}','${typename}')"><?=get_lang("btn_change")?></a>
								<a href="javascript:void(0);" onclick="group_delete('${typeid}')"><?=get_lang("btn_delete")?></a>
							</td>
						</tr>
					</script>
				<!--End List--->
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
        group_list_init();
    })
</script>

