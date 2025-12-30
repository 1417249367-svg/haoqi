<?php  require_once("../include/fun.php");?>
<?php
    $deptId = g("id");
    $arrDept = explode("_",$deptId);
    $parentId = g("parentid");
?>

           <form id="form-dept" method="post" class="form-horizontal" data-obj="org">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("dept_lb_path")?></label> 
                        <div class="control-value">
							<input type="text"  value=" <?="/" . js_unescape(g("path"))?>" disabled class="form-control"> 
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("dept_lb_name")?></label> 
                        <div class="control-value">
                            <input type="text" name="typename" id="typename" placeholder="<?=get_lang("dept_ph_name")?>" class="form-control data-field specialCharValidate"   maxlength="50"  required> 
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("dept_lb_desc")?></label> 
                        <div class="control-value">
                            <textarea name="description" id="description" placeholder="<?=get_lang("dept_ph_desc")?>" class="form-control data-field specialCharValidate" rows="5" maxlength="50"></textarea>
                        </div>
                    </div>
					<div class="form-group form-group-left">
						<label class="control-label" for="col_ord"><?=get_lang("dept_lb_index")?></label> 
						<div class="control-value">
							<input type="text" placeholder="" class="form-control data-field fl digits"  id="itemindex"  name="itemindex" maxlength="6" required value="1000" style="width:150px;" /> <i class="fl" style="padding:5px;"><?=get_lang('user_edit_order')?></i>
						</div>
					</div>
                  <?php
                  if($parentId == "0_0_0" || (count($arrDept)>1 && $arrDept[1] == 4))
                  {
                  ?>
<!--                    <div class="form-group form-group-right">
                      <label class="control-label" for="col_itemindex">人员显示</label>
                      <div class="control-value">
                        <select class="form-control data-field" id="col_style" name="col_style" style="width: 150px;">
                            <option value="0">状态优先</option>
                            <option value="1">忽略状态</option>
                        </select>
                      </div>
                    </div>-->

                  <?php
                  }
                  ?>
                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
                <input type="hidden" id="col_creator_id" name="col_creator_id" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="col_creator_name" name="col_creator_name" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>
<script type="text/javascript">
var parentid = "<?=$parentId ?>";
var id = "<?=$deptId ?>";
$(document).ready(function(){
   dataForm = $("#form-dept").attr("data-id",id).dataForm();
   $("#form-dept").validate({
        submitHandler: function(form) {

            if (id == "")
                dept_create_post(parentid) ;
            else
                dept_edit_post(id);
            return false;
        }
    });

});
</script>