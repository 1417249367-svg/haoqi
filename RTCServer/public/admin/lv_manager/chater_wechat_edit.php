<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal" data-obj="livechat_kf" data-table="lv_chater_wechat" data-fldid="TypeID" data-fldname="TypeName" enctype="multipart/form-data">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang("chater_list_account")?></a></li>
                        <li><a href="#member" data-toggle="tab" id="tab_menu_member"><?=get_lang("chater_list_isminiprogram")?></a></li>
                    </ul>
                    <div class="tab-content" id="base">
                        <div class="form-group">
                            <label class="control-label" for="domain"><?=get_lang('chater_list_domain')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_domain_alert')?>" class="form-control data-field  specialCharValidate" required id="domain"  name="domain" style="width:300px" />
							</div>
                        </div>    
                        <div class="form-group">
                            <label class="control-label" for="description"><?=get_lang("chater_domain_desc")?></label>
                            <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="description" name="description" maxlength="70" ></textarea> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="appid"><?=get_lang('chater_list_appid')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_appid_alert')?>" class="form-control data-field  specialCharValidate" required id="appid"  name="appid"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sercet"><?=get_lang('chater_list_sercet')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_sercet_alert')?>" class="form-control data-field  specialCharValidate" required id="sercet"  name="sercet"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="token"><?=get_lang('chater_list_token')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_token_alert')?>" class="form-control data-field  specialCharValidate" required id="token"  name="token"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="moban_id"><?=get_lang('chater_list_moban_id')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_moban_id_alert')?>" class="form-control data-field  specialCharValidate" required id="moban_id"  name="moban_id"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="subscribe"><?=get_lang('chater_list_subscribe')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="radio" class="fl data-field" name="subscribe" value="0"/><input type="text" placeholder="<?=get_lang('chater_list_subscribe1_id_alert')?>" class="form-control data-field  specialCharValidate" required id="subscribe_id"  name="subscribe_id" style="width:300px" /> </label><?=get_lang('chater_list_subscribe1')?>
							</div>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="radio" class="fl data-field" name="subscribe" value="1"/><input type="text" placeholder="<?=get_lang('chater_list_subscribe2_id_alert')?>" class="form-control data-field  specialCharValidate" required id="subscribe_id2"  name="subscribe_id2" style="width:300px" /> </label><?=get_lang('chater_list_subscribe2')?>
							</div>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="radio" class="fl data-field" name="subscribe" value="2"/> </label><?=get_lang('chater_list_subscribe3')?>
							</div>
                        </div>   
                        
                        <div class="form-group" style="display:none;">
                            <label class="control-label" for="groupid"></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="checkbox" id="groupid" name="groupid" value="1" value-unchecked="0" /> <?=get_lang('chater_list_isminiprogram')?></label>
							</div>
                        </div>
                    </div>

                    <div class="tab-content" id="member">
                        <div class="form-group">
                            <label class="control-label" for="domain1"><?=get_lang('chater_list_domain')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_domain_alert')?>" class="form-control data-field  specialCharValidate" required id="domain1"  name="domain1" style="width:300px" />
							</div>
                        </div>    
                        <div class="form-group">
                            <label class="control-label" for="description1"><?=get_lang("chater_domain_desc")?></label>
                            <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="description1" name="description1" maxlength="70" ></textarea> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="appid1"><?=get_lang('chater_list_appid')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_appid_alert')?>" class="form-control data-field  specialCharValidate" required id="appid1"  name="appid1"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sercet1"><?=get_lang('chater_list_sercet')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_sercet_alert')?>" class="form-control data-field  specialCharValidate" required id="sercet1"  name="sercet1"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="moban_id1"><?=get_lang('chater_list_subscribe')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_subscribe4_id_alert')?>" class="form-control data-field  specialCharValidate" required id="moban_id1"  name="moban_id1"/> </div>
                        </div>
                    </div>
                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
<!--                <input type="hidden" id="subscribe" class="data-field"/>-->
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
   chater_wechat_detail_init();
})
</script>