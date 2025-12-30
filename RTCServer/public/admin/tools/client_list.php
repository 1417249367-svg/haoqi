<?php  require_once("../include/fun.php");?>
<?php
define("MENU","CLIENT") ;
$issuper = 0 ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/client.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1>客户端程序发布</h1></div>

                <div class="searchbar clearfix">
                    <div class="pull-left">
                      <button type="button" class="btn btn-default" action-type="client_edit">新增客户端</button>
                      <button type="button" class="btn btn-default" action-type="client_delete">删除客户端</button>
                    </div>
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="查找客户端名称或版本" >
                    </div>
                </div>

				<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="ant_client" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="*">
				  <thead>
					<tr>
					  <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
					  <td data-sortfield="col_name" style="width:150px">客户端名称</td>
					  <td data-sortfield="col_version" style="width:150px">版本</td>
					  <td data-sortfield="col_size" style="width:80px">大小</td>
					  <td style="width:120px"></td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${col_id}" id="user_${col_id}">
						<td><input type="checkbox" name="chk_Id" value="${col_id}"></td>
						<td><a href="javascript:void(0);" action-data="${col_id}" action-type="client_edit">${col_name}</a></td>
						<td>${col_version}</td>
						<td>${col_size}</td>
						<td>
							<a href="javascript:void(0);" action-data="${col_id}" action-type="client_edit">编辑</a>&nbsp;
                            <a href="javascript:void(0);" onclick="client_link('${col_url}');">下载链接</a>&nbsp;
							<a href="javascript:void(0);" action-data="${col_id}" action-type="client_delete" class="btn_delete" >删除</a>
						</td>
					</tr>
				</script>
				<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
	var _key = "<?=g("key")?>" ;
	var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
	var serverPort = "<?=$_SERVER["SERVER_PORT"]?>";
    $(document).ready(function(){
        if (_key != "")
            $("#key").val(_key);
        dataList = $("#datalist").attr("data-where",get_where()).dataList(client_formatData);
		$("#key").keyup(function(){
			client_search();
		})
    })
</script>