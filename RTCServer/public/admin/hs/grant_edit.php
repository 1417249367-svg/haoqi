<?php  require_once("../include/fun.php");?>


           <form id="form1" method="post" class="form-horizontal" data-table="AdminGrant" data-fldid="ID" data-fldname="FcName">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("grant_lb_user")?></label> 
                        <div class="control-value">
                            <input type="text" class="form-control pull-left" id="user_key" placeholder="<?=get_lang("grant_ph_user")?>" style="width:325px;">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("grant_lb_tree")?></label> 
                        <div class="control-value">
                           <?php  require_once(__ROOT__ . "/admin/hs/dept_dropdown.php");?>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("grant_lb_usercount")?></label> 
                        <div class="control-value">
                            <input type="text" id="countuser" name="countuser" class="data-field form-control fl digits" required value="0" style="width:120px;"><i class="fl" style="padding:5px;"><?=get_lang("grant_notice")?></i>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="<?=get_lang("btn_cancel")?>" />
                <input type="submit" class="btn btn-primary" id="btn_save" value="<?=get_lang("btn_save")?>" />
                <input type="hidden" id="userid" name="userid" class="data-field" />
                <input type="hidden" id="fcname" name="fcname" class="data-field" />
<!--                <input type="hidden" id="col_emp_type" name="col_emp_type" class="data-field" />-->
                <input type="hidden" id="uppeid" name="uppeid" class="data-field" />
                <input type="hidden" id="deptname" name="deptname" class="data-field" />
                <input type="hidden" id="creatorid" name="creatorid" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="creatorname" name="creatorname" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>

<script language="javascript" >
var id = "<?=g("id") ?>";
$(document).ready(function(){
   if (id != "")
   {
        $("#user_key").attr("disabled",true);
   }
    grant_detail_init() ;
    
})



</script>