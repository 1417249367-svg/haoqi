<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal" data-obj="livechat_kf" data-table="lv_chater_ro" data-fldid="TypeID" data-fldname="TypeName" enctype="multipart/form-data">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang("chater_ro_attributes")?></a></li>
                        <li><a href="#member" data-toggle="tab" id="tab_menu_member"><?=get_lang("chater_ro_member")?></a></li>
                    </ul>
                    <div class="tab-content" id="base">
                        <div class="form-group">
                            <label class="control-label" for="typename"><?=get_lang("chater_ro_name")?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="typename" name="typename" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description"><?=get_lang("chater_ro_desc")?></label>
                            <div class="control-value"><textarea rows="10" style="height:50px"  placeholder="" class="form-control data-field  specialCharValidate"  id="description" name="description" maxlength="70" ></textarea> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="welcome"><?=get_lang('chater_edit_lb_welcome')?></label>
                            <div class="control-value">
                                <textarea name="welcome" id="welcome" placeholder="<?=get_lang('chater_edit_ph_welcome')?>" class="form-control specialCharValidate data-field"  rows="3" > </textarea>
                            </div>
                        </div>
                        <div class="form-group form-group-left">
                            <label class="control-label" for="defaultreception"><?=get_lang('chater_list_chatgpt_reception')?></label>
                            <div class="control-value">
                                <select name="defaultreception" id="defaultreception" class="form-control data-field form-control"  >
                                    <option value="0"><?=get_lang('chater_list_chatgpt_reception3')?></option>
                                    <option value="1"><?=get_lang('chater_list_chatgpt_reception1')?></option>
                                    <option value="2"><?=get_lang('chater_list_chatgpt_reception2')?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-right">
                            <label class="control-label" for="ord"><?=get_lang("chater_ro_order")?></label>
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang("txt_order")?>" class="form-control data-field fl digits"  id="ord"  name="ord" required value="1000" style="width:150px;" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="status"></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="checkbox" id="status" name="status" value="1" value-unchecked="0"/> <?=get_lang("chater_ro_status")?></label>
                                <label class="checkbox-inline"><input class="data-field" type="checkbox" id="to_type" name="to_type" value="1" value-unchecked="0"/> <?=get_lang("chater_ro_to_type")?></label>
							</div>
                        </div>                    </div>

                    <div class="tab-content" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5><?=get_lang("chater_ro_tree_title")?></h5></div>
						    <div style="clear:both;"></div>
					    </div>

					    <div class="clearfix">
						    <div class="col2 bor group-column" style="float:left;">
							    <div id="container_treeuser" class="container-tree"></div>
						    </div>
						    <div class="col2 bor group-column" style="float:right;overflow:scroll;">
							    <table id="tbl_member" class="table" style="margin:0px;padding:0px;">
								    <thead>
									    <tr><td style="width:100px;"><?=get_lang("field_username")?></td><td style="width:100px;"><?=get_lang("field_account")?></td><td></td></tr>
								    </thead>
								    <tbody>
								    </tbody>
							    </table>
						    </div>
						    <div style="clear:both;"></div>
					    </div>
                    </div>
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
<!--                <input type="hidden" id="tagIds" name="tagIds" />-->
				<input type="hidden" id="memberIds" name="memberIds" />
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
	if (!groupId) CKEDITOR.replace('welcome');
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
   chater_ro_detail_init();
   if(!groupId) $("#status").attr("checked",true);
})
</script>