<?php  require_once(__ROOT__ . "/class/common/Site.inc.php");?>
<!--SearchBar-->
<div class="searchbar">
	<div class="pull-left">
		<button type="button" class="btn btn-default" action-type="ace_create">新增权限</button>
		<button type="button" class="btn btn-default" action-type="ace_delete">删除权限</button>
		<button type="button" class="btn btn-default" action-type="ace_edit">修改权限</button>
	</div>

</div>
<!--End SearchBar-->
<!--List--->
<table id="datalist" class="table table-hover data-list" data-ispage="0"
	data-tmpid="tmpl_list" data-table="tab_bioace" data-fldid="col_id"
	data-fldname="col_id" data-fldlist="*" data-fldsort="col_id">
	<thead>
		<tr>
			<td>名称</td>
			<td>类型</td>
			<td>权限</td>
			<td></td>
		</tr>
	</thead>
	<tbody id="list"></tbody>
</table>
<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr id="${col_id}">
							<td>${col_hsitemname}</td>
							<td>${col_hsitemtype}</td>
							<td>${col_power}</td>
							<td>
								<a href="javascript:void(0);" action-data="${id}" action-type="grant_delete" >删除</a>
							</td>
						</tr>
					</script>
<!--End List--->

<script language="javascript">
var funName = "<?=g("funName","DocAce")?>" ;
var funGenre = "<?=g("funGenre")?>" ;
var classId = "<?=g("classId",102)?>" ;
var objId = "<?=g("objId")?>" ;
var dataList ;
$(document).ready(function(){
	ace_load(objId);
})
</script>
