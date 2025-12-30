<?php  require_once("../include/fun.php");?>
<?php
define("MENU","ACCESS_LIST") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/access.js"></script>
	<script type="text/javascript" src="../assets/js/tagpicker.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1>系统接入</h1></div>
                <div class="searchbar clearfix">
                    <div class="pull-left">
                      <button type="button" class="btn btn-default" action-type="access_edit">新增系统</button>
                      <button type="button" class="btn btn-default" action-type="access_delete">删除系统</button>
                    </div>
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="查找系统名称" >
                    </div>
                </div>

				<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="ant_accesssystem" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="*" data-ispage="1">
				  <thead>
					<tr>
					  <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
					  <td data-sortfield="col_id" style="width:150px">ID</td>
					  <td data-sortfield="col_name" style="width:150px">接入系统名称</td>
					  <td data-sortfield="col_disabled" style="width:80px">禁用</td>
					  <td data-sortfield="col_creator_name" style="width:80px">创建者</td>
					  <td style="width:120px"></td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${col_id}" id="access_${col_id}" >
						<td><input type="checkbox" name="chk_Id" value="${col_id}"></td>
						<td>${col_id}</td>
						<td><a href="javascript:void(0);" action-data="${col_id}" action-type="access_edit">${col_name}</a></td>
                        <td><a href="#" class="icon-check${col_disabled} btn_disabled" data-value="${col_disabled}" action-data="${col_id},'col_disabled',this"  action-type="dataList.setSwitch"></a></td>
						<td>${col_creator_name}</td>
						<td>
							<a href="javascript:void(0);" action-data="${col_id}" action-type="access_edit">编辑</a>
							<a href="javascript:void(0);" action-data="${col_id}" action-type="access_delete" class="btn_delete" >删除</a>
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
        if (_key != "")
            $("#key").val(_key);

        dataList = $("#datalist").attr("data-where",get_where()).dataList(access_formatData);

        $("#key").keyup(function(){
            access_search();
        })
    })
</script>

