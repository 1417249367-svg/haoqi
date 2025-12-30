<?php  require_once("../include/fun.php");?>


           <form id="form1" method="post" class="form-horizontal" data-table="rtc_sms_account" data-fldid="col_id" data-fldname="col_account">
              <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">发送帐号</label>
                        <div class="control-value">
                            <input type="text" id="col_account" name="col_account" class="data-field form-control fl " required value="" style="width:325px;" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">发送密码</label>
                        <div class="control-value">
                            <input type="text" id="col_password" name="col_password" class="data-field form-control fl " required value="" style="width:325px;" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">选择部门</label>
                        <div class="control-value">
                            <?php  require_once(__ROOT__ . "/admin/hs/dept_dropdown.php");?>
                        </div>
                    </div>

              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="取消" />
                <input type="submit" class="btn btn-primary" id="btn_save" value="保存" />

                <input type="hidden" id="col_emp_type" name="col_emp_type" class="data-field" />
                <input type="hidden" id="col_emp_id" name="col_emp_id" class="data-field" />
                <input type="hidden" id="col_emp_name" name="col_emp_name" class="data-field " />
                <input type="hidden" id="col_creator_id" name="col_creator_id" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="col_creator_name" name="col_creator_name" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>

<script language="javascript" >
var id = "<?=g("id") ?>";
$(document).ready(function(){
    account_detail_init() ;
})

function account_detail_init()
{

   dataForm = $("#form1").attr("data-id",id).dataForm({getcallback:account_getCallBack,savecallback:account_saveCallBack});
   $("#form1").validate({
        submitHandler: function(form) {

            if (valid_data() == false)
                return false ;

            dataForm.save();
            return false;
        }
    });

    $("#container_dept").click(function(e){
        e.stopPropagation();
    })

}


function account_getCallBack(data)
{
    var dept_id = "1_" + data.col_emp_type + "_" + data.col_emp_id ;

	setDeptDropDown(dept_id,data.col_emp_name) ;
}

function account_saveCallBack()
{
	dataList.reload();
	dialogClose("sms_account");
}


function valid_data()
{
    var dept_info = getDeptDropDownData();
	var dept_id = dept_info.dept_id ;

    if ((dept_id == "") || (dept_id == undefined) || (dept_id =="0_0_0" ))
    {
        myAlert(getErrorText("102212"));
        return false ;
    }


    var emp_item = dept_id.split("_") ;
    $("#col_emp_type").val(dept_info.emp_type);
    $("#col_emp_id").val(dept_info.emp_id);
    $("#col_emp_name").val(dept_info.dept_path);
    return true ;
}


</script>