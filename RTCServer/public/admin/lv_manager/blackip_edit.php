<?php  require_once("../include/fun.php");?>
<?php
$sql = "select aa.UserName,cc.UserID,aa.LoginName from lv_chater as aa,Users_ID as cc where aa.LoginName=cc.UserName";
$db = new DB();
$data = $db -> executeDataTable($sql) ;
?>
           <form id="form_blackip" method="post" class="form-horizontal" data-table="clot_silence" data-fldid="typeid" data-fldname="youid"  enctype="multipart/form-data" >
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="youid"><?=get_lang("blackip_list_option_userid")?></label>
                        <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="youid" name="youid" /> </div>
                    </div>
                   <div class="form-group"> 
                        <label class="control-label" for="myid"><?=get_lang('link_edit_lb_owner')?></label> 
                        <div class="control-value">
                            <select id="myid" name="myid" class="form-control data-field">
                                <option value=""><?=get_lang('link_edit_option')?></option>
								<?php
								foreach($data as $row)
								{
								?>
                                <option value="<?=$row["userid"]?>"><?=$row["username"]?>(<?=$row["loginname"]?>)</option>
								<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="to_ip"><?=get_lang("server_list_ip")?></label>
                        <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="to_ip" name="to_ip" /> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ncontent"><?=get_lang("blackip_list_table_des")?></label>
                        <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="ncontent" name="ncontent" maxlength="70" ></textarea> </div>
                    </div>
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
                <input type="hidden" id="to_type" name="to_type" class="data-field" value="3"/>
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
var TypeID = "<?=g("id") ?>"; 
$(document).ready(function(){
   dataForm = $("#form_blackip").attr("data-id",TypeID).dataForm({getcallback:blackip_getCallBack,savecallback:blackip_saveCallBack});
    $("#btn_save").click(function(){
        save();
        return false ;
    })
    
    
})
</script>