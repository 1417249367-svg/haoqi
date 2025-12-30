<?php  require_once("../include/fun.php");?>
<?php
define("MENU","POSIDX") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/pos.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1>铭牌管理</h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="pos_edit">新增铭牌</button>
                          <button type="button" class="btn btn-default" action-type="pos_delete">删除铭牌</button>
                     </div>
                     <div class="pull-right">
                         <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="查找铭牌" />
                     </div>
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="hs_pos_info" data-fldid="col_pos_idx" data-fldname="col_pos_name"  data-fldsort="col_pos_idx" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
								<td style="width:10%;" data-sortfield="col_pos_idx">序号</td>
                                <td style="width:30%;" data-sortfield="col_pos_name">名称</td>
                                <td style="width:30%;">描述</td>
                                <td style="width:10%;">图标</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${col_pos_idx}" data-name="${col_pos_name}" data-id="${col_pos_idx}">
							<td><input type="checkbox" name="chk_Id" value="${col_pos_idx}"></td>
							<td>${col_pos_idx}</td>
							<td><a href="javascript:void(0);" action-data="${col_pos_idx}" action-type="pos_edit">${col_pos_name}</a></td>
							<td>${col_pos_disp}</td>
							<td><img src="${col_img_url}" title="${col_pos_name}" width="16" height="16" /></td>
							<td class="col-op">
								<a href="javascript:void(0);" action-data="${col_pos_idx}" action-type="pos_edit">编辑</a>
								<a href="javascript:void(0);" action-data="${col_pos_idx}" action-type="pos_delete" class="btn_delete">删除</a>
							</td>
						</tr>
					</script>
				<!--End List--->
				<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
    var dataList ;
    var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
    var rtcPort = "<?=RTC_PORT?>";

    var _key = "<?=g("key")?>" ;
    $(document).ready(function(){
        if (_key != "")
            $("#key").val(_key);
        pos_list_init();
    })
</script>

