<?php  require_once("../include/fun.php");?>
<?php
define("MENU","LIVECHAT_CHATER_THEME") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_chater_theme.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("chater_theme_title")?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="chater_theme_edit"><?=get_lang("chater_theme_add")?></button>
                          <button type="button" class="btn btn-default" action-type="chater_theme_delete"><?=get_lang("chater_theme_delete")?></button>
                     </div>
                     
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_chater_theme" data-fldid="typeid" data-fldname="typename"  data-fldsort="ord ,typeid" data-fldsortdesc="ord desc,typeid desc" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="typename"><?=get_lang("chater_theme_name")?></td>
                                <td data-sortfield="description"><?=get_lang("chater_theme_desc")?></td>
                                <td data-sortfield="createtime"><?=get_lang("chater_theme_dt")?></td>
                                <td data-sortfield="status" style="width: 80px"><?=get_lang("chater_theme_status")?></td>
                                <td data-sortfield="ord" style="width: 80px"><?=get_lang("chater_theme_order")?></td>
                                <!-- <td >标签</td> -->
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${typeid}" data-name="${typename}" data-id="${typeid}" data-ord="${ord}">
							<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
							<td><a href="javascript:void(0);" onclick="chater_theme_edit('${typeid}','${typename}')">${typename}</a></td>
							<td>${description}</td>
							<td>${createtime}</td>
							<td><a href="javascript:void(0);" class="icon-check${status}" data-value="${status}" action-data="${typeid},'status',this"  action-type="dataList.setSwitch"></a></td>
							<td>${ord}</td>
							<td class="col-op">
								<a href="javascript:void(0);" onclick="chater_theme_edit('${typeid}','${typename}')"><?=get_lang("btn_change")?></a>
								<a href="javascript:void(0);" onclick="chater_theme_delete('${typeid}')"><?=get_lang("btn_delete")?></a>
								<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapUp" title="<?=get_lang('chater_theme_up')?>"><?=get_lang('chater_theme_up')?></a>
							    <a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapDown" title="<?=get_lang('chater_theme_down')?>"><?=get_lang('chater_theme_down')?></a>
							</td>
						</tr>
					</script>
				<!--End List--->
				<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
    var dataList ;
    $(document).ready(function(){
        chater_theme_list_init();
    })
</script>

