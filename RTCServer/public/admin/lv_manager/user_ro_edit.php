<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal" data-obj="livechat_kf" data-table="lv_user_ro" data-fldid="TypeID" data-fldname="TypeName" enctype="multipart/form-data">
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="typename"><?=get_lang("user_ro_name")?></label>
                        <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="typename" name="typename" /> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description"><?=get_lang("user_ro_desc")?></label>
                        <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="description" name="description" maxlength="70" ></textarea> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ord"><?=get_lang("user_ro_order")?></label>
                        <div class="control-value">
                            <input type="text" placeholder="" class="form-control data-field fl digits"  id="ord"  name="ord" required value="1000" style="width:120px;" /> <i class="fl" style="padding:5px;"><?=get_lang("txt_order")?></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="status"></label>
                        <div class="control-value">
                            <label class="checkbox-inline"><input class="data-field" type="checkbox" id="status" name="status" value="1" value-unchecked="0"/> <?=get_lang("user_ro_status")?></label>
                        </div>
                    </div>
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
<!--                <input type="hidden" id="tagIds" name="tagIds" />-->
<!--				<input type="hidden" id="memberIds" name="memberIds" />-->
<!--				<input type="hidden" id="col_type" name="col_type" class="data-field" value="8"/>
				<input type="hidden" id="col_dtype" name="col_dtype" class="data-field" value="1"/>
				<input type="hidden" id="col_ispublic" name="col_ispublic" class="data-field" value="0"/>-->
<!--				<input type="hidden" id="filefactpath" name="filefactpath" />
				<input type="hidden" id="filesaveas" name="filesaveas" />
				<input type="hidden" id="col_photo" name="col_photo" class="data-field" />
				<input type="hidden" id="ispublic" name="ispublic" class="data-field" />-->
              </div>
            </form>

<script type="text/javascript">

var dataForm ;
var treeUser ;
var treeOrg ;
var groupId = "<?=g("groupid") ?>" ;
var groupName = "<?=g("groupname") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";

$(document).ready(function(){
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
   user_ro_detail_init();
   if(!groupId) $("#status").attr("checked",true);
})
</script>