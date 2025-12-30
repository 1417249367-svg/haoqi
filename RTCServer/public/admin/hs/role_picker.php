<?php  require_once("../include/fun.php");?>

              <div class="modal-body" style="height:400px; overflow:auto">
			  
					<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list" data-ispage="0"  data-fldid="col_id" data-fldsort="col_id" data-where=""  data-fldlist="col_id,col_loginname,col_name,col_sex,col_email,col_mobile,col_deptinfo,col_disabled,col_issuper">
					  <thead>
						<tr>
						  <td style="width:40px"><input type="checkbox" name="chk_All" onclick="checkAll('empid',this.checked)"></td>
						  <td data-sortfield="col_name" style="width:150px">名称</td>
						  <td data-sortfield="col_description">描述</td>
						</tr>
					  </thead>
					  <tbody>
						<?php
						$role = new Model("hs_role") ;
						$role -> order("col_name");
						$data = $role -> getList();
						foreach($data as $row)
						{
						?>
						<tr>
						  <td><input  type="checkbox"  name="empid" value="<?=$row["col_id"] ?>" data-name="<?=$row["col_name"] ?>" /></td>
						  <td><?=$row["col_name"] ?></td>
						  <td><?=$row["col_description"] ?></td>
						</tr>
                    	<?php
						}
						?>
					  </tbody>
					</table>

              </div>
              <div class="modal-footer clearfix">
			  		<div class="pull-left" id="options">
						
					</div>
			  		<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="submit" class="btn btn-primary" id="btn_picker_submit" onclick="postRoleList()">确定</button>
					</div>
              </div>
 
 

