<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal" data-obj="livechat_kf" data-table="lv_chater_domain" data-fldid="TypeID" data-fldname="TypeName" enctype="multipart/form-data">
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="typename"><?=get_lang("chater_domain_name")?></label>
                        <div class="control-value"><input type="text" placeholder="<?=get_lang("chater_domain_name_desc")?>" class="form-control data-field" required id="typename" name="typename" /> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description"><?=get_lang("chater_domain_desc")?></label>
                        <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="description" name="description" maxlength="70" ></textarea> </div>
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
   chater_domain_detail_init();
})
</script>