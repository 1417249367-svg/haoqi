<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","HL_ORG") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>单位互联 / 组织管理</h1></div>
                <div class="searchbar clearfix">
                    <div class="pull-left">
						<button type="button" class="btn btn-default" action-type="create_dir">创建目录</button>
                      	<button type="button" class="btn btn-default" action-type="delete_dir">删除目录</button>
                    </div>
                </div>

				<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="hs_user" data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="col_id,col_loginname,col_name,col_sex,col_email,col_mobile,col_deptinfo,col_disabled,col_issuper">
				  <thead>
					<tr>
					  <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
					  <td data-sortfield="col_loginname" style="width:200px">名称</td>
					  <td data-sortfield="col_name">描述</td>
					  <td data-sortfield="col_sex" style="width:150px">端口地址</td>
					  <td data-sortfield="col_email" style="width:150px">端口类型</td>
					  <td data-sortfield="col_mobile" style="width:150px">状态</td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

	<?php  require_once("../include/footer.php");?>
    
 
</body>
</html>
