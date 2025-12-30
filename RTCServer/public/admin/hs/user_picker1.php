<?php  require_once("../include/fun.php");?>
              <div class="modal-body">
					<div class="clearfix">
						<div class="pull-left"><h5><?=get_lang('user_picker_title')?></h5></div>
						
						<div class="pull-right" style="width:280px">
							<div class="input-group">
							  <input type="text" class="form-control" id="userkey" placeholder="<?=get_lang('user_picker_ph_userkey')?>">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button" onclick="addMemberByInput()"><?=get_lang('user_picker_btn_add')?></button>
							  </span>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			  
					<div class="clearfix">
						<div class="col2 bor role-column" style="float:left;">
							<div id="container_treeuser" class="container-tree"></div>
						</div>
						<div class="col2 bor role-column" style="float:right;overflow:scroll;">
							<table id="tbl_member" class="table" style="margin:0px;padding:0px;">
								<thead>
									<tr><td style="width:100px;"><?=get_lang('user_picker_col_title')?></td><td style="width:100px;"><?=get_lang('user_picker_col_type')?></td><td></td></tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div style="clear:both;"></div>
					</div>
              </div>
              <div class="modal-footer clearfix">
			  		<div class="pull-left" id="options" style="display:none">
						<label><input type="checkbox" id="chk_reset" /> <?=get_lang('user_picker_checkbox_reset')?></label>
					</div>
			  		<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
						<button type="submit" class="btn btn-primary" id="btn_picker_submit"><?=get_lang('btn_ok')?></button>
					</div>
              </div>

 <script type="text/javascript">
    var parentEmpType = "<?=g("parentEmpType") ?>" ;
    var parentEmpId = "<?=g("parentEmpId") ?>" ;
    var childEmpType = "<?=g("childEmpType") ?>" ;
	var mode = "<?=g("mode") ?>" ;
	
	$(document).ready(function(){
		userpicker_init();
		if (parentEmpId.indexOf(",")== -1)
			$("#chk_reset").attr("checked",true) ;
		else
			$("#options").show() ;
	})

 </script>


