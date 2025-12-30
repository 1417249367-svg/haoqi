<?php
require_once("../include/fun.php");
require_once(__ROOT__ . "/config/livechat.inc.php");
?>
<?php
define("MENU","LIVECHAT_CHATER_RO") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_ro.js"></script>
	<script type="text/javascript" src="../assets/js/userpicker2.js"></script>
    <script src="/static/js/msg_reader.js"></script>
    <script src="/static/js/ckeditor/ckeditor.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("chater_ro_title")?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="chater_ro_edit"><?=get_lang("chater_ro_add")?></button>
                          <button type="button" class="btn btn-default" action-type="chater_ro_delete"><?=get_lang("chater_ro_delete")?></button>
                     </div>
                     
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_chater_ro" data-fldid="typeid" data-fldname="typename"  data-fldsort="ord ,typeid" data-fldsortdesc="ord desc,typeid desc" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="typename"><?=get_lang("chater_ro_name")?></td>
                                <td data-sortfield="description"><?=get_lang("chater_ro_desc")?></td>
                                <td data-sortfield="createtime"><?=get_lang("chater_ro_dt")?></td>
                                <td data-sortfield="welcome" style="width:150px"><?=get_lang('chater_list_welcome')?></td>
                                <td data-sortfield="status" style="width: 80px"><?=get_lang("chater_ro_status")?></td>
                                <td data-sortfield="to_type" style="width: 80px"><?=get_lang("chater_ro_to_type")?></td>
                                <td data-sortfield="ord" style="width: 80px"><?=get_lang("chater_ro_order")?></td>
                                <!-- <td >标签</td> -->
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${typeid}" data-name="${typename}" data-id="${typeid}" data-ord="${ord}">
							<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
							<td><a href="javascript:void(0);" onclick="chater_ro_edit('${typeid}','${typename}')">${typename}</a></td>
							<td>${description}</td>
							<td>${createtime}</td>
							<td>${welcome}</td>
							<td><a href="javascript:void(0);" class="icon-check${status}" data-value="${status}" action-data="${typeid},'status',this"  action-type="dataList.setSwitch"></a></td>
							<td><a href="javascript:void(0);" class="icon-check${to_type}" data-value="${to_type}" action-data="${typeid},'to_type',this"  action-type="dataList.setSwitch"></a></td>
							<td>${ord}</td>
							<td class="col-op">
							<?php if (CHATER_RO){?>
								<a href="javascript:void(0);" onclick="doc_share('${typeid}',this)"><?=get_lang('chater_list_link')?></a>
								<a href="javascript:void(0);" onclick="doc_js('${typeid}',this)"><?=get_lang('chater_list_js')?></a>
								<a href="javascript:void(0);" onclick="doc_qrcode('${typeid}','${typename}','',this)" ><?=get_lang('chater_list_qrcode')?></a>
							<?php }?>
								<a href="javascript:void(0);" action-data="'${typeid}'" action-type="chater_ro_member"><?=get_lang("btn_setmember")?></a>
								<a href="javascript:void(0);" onclick="chater_ro_edit('${typeid}','${typename}')"><?=get_lang("btn_change")?></a>
								<a href="javascript:void(0);" onclick="chater_ro_delete('${typeid}')"><?=get_lang("btn_delete")?></a>
								<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapUp" title="<?=get_lang('chater_ro_up')?>"><?=get_lang('chater_ro_up')?></a>
							    <a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapDown" title="<?=get_lang('chater_ro_down')?>"><?=get_lang('chater_ro_down')?></a>
							</td>
						</tr>
					</script>
				<!--End List--->
                <input type="text" id="texturl" style="width:10px;display:none"/>
				<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
    var dataList ;
    var ipaddress = "<?=IPADDRESS ?>";
	var site_address = "<?=getRootPath() ?>";
    $(document).ready(function(){
        chater_ro_list_init();
    })
</script>

