<?php  require_once("../include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Grant.class.php");?>
<?php
	if (! g("userid"))
	{
		// create
		$grant = new Grant();
		$result = $grant -> allow_create_user();
		if ( ! $result["status"])
		{
			print("<div class='modal-body'><div class='alert alert-warning'>" . $result["msg"] . "</div></div>") ;
			die();
		}
	}

	$db = new DB();
//	$arr_pos = $db->executeDataTable("select * from hs_pos_info order by col_pos_idx asc");
//	$arr_pos = table_fliter_doublecolumn($arr_pos,1);

?>
           <form id="form-user" method="post"  class="form-horizontal" data-obj="user"  data-table="Users_ID" data-fldid="userid" data-fldname="fcname" >
              <div class="modal-body">

                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab" class="user-tab"><?=get_lang('user_edit_tab_base')?></a></li>
                        <li><a href="#work" data-toggle="tab" class="user-tab"><?=get_lang('user_edit_tab_work')?></a></li>
                        <li><a href="#self" data-toggle="tab" class="user-tab"><?=get_lang('user_edit_tab_self')?></a></li>
                        <li><a href="#other" data-toggle="tab" class="user-tab"><?=get_lang('user_edit_tab_login')?></a></li>
                        <li id="tab_power"><a href="#power" data-toggle="tab" class="user-tab"><?=get_lang('user_edit_tab_power')?></a></li>
                    </ul>
                    <div class="tab-content" id="base">
                        <div class="form-group">
                            <label class="control-label" for="username"><?=get_lang('user_edit_account')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field data-keyfield "  id="username"  name="username" required maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fcname"><?=get_lang('user_edit_username')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field specialCharValidate"  id="fcname"  name="fcname" required maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="userpaws"><?=get_lang('user_edit_psw')?></label>
                            <div class="control-value"><input type="password" placeholder="" class="form-control data-field"  id="userpaws"  name="userpaws" required  maxlength="50" /></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isdisplay"></label>
                            <div class="control-value">
                                <label class="checkbox-inline" ><input type="checkbox" id="isdisplay" name="isdisplay" value="1" value-unchecked="0" onclick="getuserpaws(this.checked);" /> <?=get_lang('user_edit_show_password')?></label>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sequence"><?=get_lang('user_edit_sequence')?></label>
                            <div class="control-value">
                                <input type="text" placeholder="" class="form-control data-field fl digits"  id="sequence"  name="sequence" maxlength="6" required value="1000" style="width:120px;" /> <i class="fl" style="padding:5px;"><?=get_lang('user_edit_order')?></i>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="expiretime"><?=get_lang('user_expiration_time')?></label>
                            <div class="control-value">
                               <!--  <input type="text" placeholder="" class="form-control data-field fl digits"  id="col_expire"  name="col_expire" value="0" style="width:120px;" /> --> 
                                <input type="text" placeholder="" class="form-control data-field dateISO datepicker fl" id="expiretime"  name="expiretime" data-mask='date' data-date-format="yyyy-mm-dd" data-type="date" maxlength="50"  style="width:120px;"/>
                                <button class="btn btn-defalult fl"style="margin-left:5px;" id="btn_expire_set"><?=get_lang('user_expiration_set')?></button>                                    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fld_pword"></label>
                            <div class="control-value">
                                <?php if (CurUser::isAdmin()) {?>
                                <label class="checkbox-inline" ><input class="data-field" type="checkbox" id="ismanager" name="ismanager" value="1" value-unchecked="0" /> <?=get_lang('user_edit_checkbox_admin')?></label>
                                <?php }?>
                                <label class="checkbox-inline"><input class="data-field" type="checkbox" id="userstate" name="userstate" value="0"  value-unchecked="1" /> <?=get_lang('user_edit_checkbox_disabled')?></label>
							</div>
                        </div>
                    </div>
                    <div class="tab-content" id="work">
                        <div class="form-group">
                            <label class="control-label" for="jod"><?=get_lang('user_edit_lb_jobtitle')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="jod"  name="jod"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="tel2"><?=get_lang('user_edit_lb_phone')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate"  id="tel2"  name="tel2"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="constellation"><?=get_lang('user_edit_lb_email')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="constellation"  name="constellation"  maxlength="200" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="tel1"><?=get_lang('user_edit_lb_mobile')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field specialCharValidate"  id="tel1"  name="tel1"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="effigy"><?=get_lang('field_other')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="effigy"  name="effigy"  maxlength="50" /> </div>
                        </div>

                    </div>
                    <div class="tab-content" id="self">
                    	<div style="width:50%;float:left">
                          <div class="form-group">
                              <label class="control-label" for="userico"><?=get_lang('user_edit_lb_gender')?></label>
                              <div class="control-value">
                                  <select name="userico" id="userico" class="form-control data-field" style="width:150px;">
                                      <option value="1"><?=get_lang('user_edit_lb_gender1')?></option>
                                      <option value="2"><?=get_lang('user_edit_lb_gender2')?></option>
                                  </select>
                              </div>
                          </div>
                        </div>
                    	<div style="width:50%;float:left">
                         <div class="form-group">
                              <label class="control-label" for="age" style="width:80px"><?=get_lang('user_edit_lb_age')?></label>
                              <div class="control-value" style="margin-left:90px;width:180px;"><input type="text" placeholder="" class="form-control data-field  specialCharValidate"  id="age"  name="age"  maxlength="10" /> </div>
                          </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form-group">
                            <label class="control-label" for="address"><?=get_lang('user_edit_lb_address')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate"  id="address"  name="address"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="school"><?=get_lang('user_edit_lb_school')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="school"  name="school"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="say"><?=get_lang('user_edit_lb_description')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate"  id="say"  name="say"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="remark"><?=get_lang('user_edit_lb_note')?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field specialCharValidate"  id="remark"  name="remark"  maxlength="50" /> </div>
                        </div>
                    </div>
  					<div class="tab-content" id="other">

                         <dl>
                            <dt><?=get_lang('user_edit_col_mac')?></dt>
                            <dd>
                                <textarea  class="form-control data-field" rows="3" name="maclist" id="maclist"></textarea>
                            </dd>
                        </dl>

                         <dl>
                            <dt><?=get_lang('user_edit_col_ip')?></dt>
                            <dd>
                                <textarea class="form-control data-field  " rows="3" name="localiplist" id="localiplist"></textarea>
                            </dd>
                        </dl>

					</div>

                    <div class="tab-content" id="power">
                        <dl>
                            <dt><?=get_lang('user_edit_power_roles')?></dt>
                            <dd>
                                <div style="height:80px;overflow:auto;" id="viewer_role">

                                </div>
                            </dd>
                        </dl>
<!--                        <dl>
                            <dt>允许访问的组织</dt>
                            <dd>
                                <div style="height:80px;overflow:auto;" id="viewer_org">

                                </div>
                            </dd>
                        </dl>-->

                        <!--
                        <div class="row clearfix">
                            <div class="col-xs-6"><input  type="checkbox"  name="baseace" value="1" disabled/> 允许发送公告</div>
                            <div class="col-xs-6"><input  type="checkbox"  name="baseace" value="16" disabled /> 允许新建会议</div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-6"><input  type="checkbox"  id="chk_attachsize" name="chk_attachsize" value="1" disabled/> 附件大小限制：<input type="text" id="attachsize" name="attachsize" disabled  style="width:80px;border:1px solid #ccc;padding:2px;height:20px;" /> KB</div>
                            <div class="col-xs-6"><input  type="checkbox"  id="chk_msends" name="chk_msends" value="1" disabled/> 群发个数限制：<input type="text" id="msends" name="msends" disabled style="width:80px;border:1px solid #ccc;padding:2px;height:20px;" /></div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-6"><input  type="checkbox"  name="baseace" value="256" disabled /> 禁止语音通话</div>
                            <div class="col-xs-6"><input  type="checkbox"  name="baseace" value="2408" disabled /> 禁止视频通话</div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-6"><input  type="checkbox"  name="baseace" value="1" disabled /> 禁止接收附件</div>
                        </div>
                         -->
                    </div>

              </div>
              <div class="modal-footer">
                <?php if (g("op") == "view") {?>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_close')?></button>
                <?php }else{?>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save" ><?=get_lang('btn_save')?></button>
                <?php }?>
                <input type="text"  id="deptid"  name="deptid" style="display:none;" />
                <!--<input type="text" id="usersrole" name="usersrole" style="display:none;" />-->
<!--                <input type="text"  id="col_deptinfo"  name="col_deptinfo" class="data-field" style="display:none;" />
                <input type="text"  id="col_alldeptinfo"  name="col_alldeptinfo" class="data-field" style="display:none;" />-->
                <input type="hidden" id="creatorid" name="creatorid" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="creatorname" name="creatorname" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>
<script type="text/javascript">

var deptId = "<?=g("deptid") ?>";
var userId = "<?=g("userid") ?>";
var ace = "";
var dataForm ;
var expirehmtime;

$(document).ready(function(){
   //init
   if (userId == "")
   {
        //$("#tab_power").remove();
        //$("#power").remove();
        $("#deptid").val(deptId);
   }
   else
   {
	    $("#username").attr("disabled",true);
        //$("#userpaws").val("******");
   }
   
  $("#btn_expire_set").click(function(){
	  $("#expiretime").val("");
	  return false;
  })

   //在 user.js中生成，用脚本传不会乱码
//   $("#col_deptinfo").val(nodeText);
//   $("#col_alldeptinfo").val(_path);
   dataForm = $("#form-user").attr("data-id",userId).dataForm({getcallback:getUserCallBack,submitcallback:submitUserCallBack,savecallback:saveUserCallBack});

   formatTabs("tabs");

   $("#form-user").validate({
        invalidHandler: function(form, validator) {
            var errors = validator.errorList ;
            if (errors.length>0)
            {
                var el = $(errors[0].element) ;
                var tabId = $(el).parents(".tab-content").attr("id") ;
                $(".nav-tabs li a[href='#" + tabId + "']").click();
            }
        },

        ignore: "ui-tabs-hide",

        submitHandler: function(form) {
			//$("#usersrole").val(getPowers());
			if(/.*[\u4e00-\u9fa5]+.*$/.test($("#username").val())) 
			{ 
				myAlert(getErrorText("102104")); 
				return ; 
			}
			if(getCheckValue("roleid")==""){
				myAlert(getErrorText("102302"));
				return ;
			}
            dataForm.save();
            return false;
        }

  });


//  $("input[name=baseace]").each(function(){
//        var v = $(this).val() ;
//        if ((ace & v ) == v)
//            $(this).attr("checked",true) ;
//  });

});

function getUserCallBack(data)
{
	expirehmtime=CurentTime();
	if (userId != ""){
		if (data.username.toLowerCase() == "admin")
		{
			$("#ismanager,#userstate").attr("disabled",true);
		}
		if(data.expiretime !=0){
			expirehmtime=ts2hm(data.expiretime);
			$("#expiretime").val(ts2dt(data.expiretime));
		}else{
			$("#expiretime").val("");
		}
	}
	
//    if (data.userstate == 0)
//        $("#userstate").attr("checked",true) ;

	var html = "";
	// init role
	html = "";		
	for(var i=0;i<data.orgs.length;i++){
	   var checkvalue="";
	   var display="";
	   if (userId == ""){
	       if(data.orgs[i].defaultrole=="1") checkvalue=" checked=\"checked\"";
	   }
	   else{
           for(var j=0;j<data.roles.length;j++){
			   if(data.roles[j].id==data.orgs[i].id){
				   checkvalue=" checked=\"checked\"";
				   break;
			   }
		   }
	   }
		if(data.orgs[i].creatorid!=_curr_userid&&! _isadmin) display=" style=\"display:none;\"";
		html += "<li"+display+"><label><input  type=\"checkbox\"  name=\"roleid\" value=\"" + data.orgs[i].id + "\""+checkvalue+"/> " + data.orgs[i].rolename + "</label></li>";
	}
	$("#viewer_role").html("<ul class='list-h'>" + html + "</ul>");
//alert(html);
	// init org
//	html = "";
//	for(var i=0;i<data.orgs.length;i++)
//		html += "<li>" + data.orgs[i].col_name + "</li>";
//	$("#viewer_org").html("<ul class='list-h'>" + html + "</ul>");

	// init ace
//	var baseace = data.ace.baseace ;
//    $("input[name=baseace]").each(function(){
//        var v = $(this).val() ;
//        if ((baseace & v ) == v)
//            $(this).attr("checked",true) ;
//    })
//
//    if (data.ace.attachsize > 0)
//    {
//        $("#chk_attachsize").attr("checked",true) ;
//        $("#attachsize").val(data.ace.attachsize);
//    }
//
//    if (data.ace.attachsends > 0)
//    {
//        $("#chk_msends").attr("checked",true) ;
//        $("#msends").val(data.ace.attachsends);
//    }
}

function saveUserCallBack()
{
    dataList.reload();
    dialogClose("user");
}

function submitUserCallBack(data)
{
    
	if (data.expiretime == "") data.expiretime = 0 ;
	else{
		//if(!expirehmtime) expirehmtime=CurentTime();
		 data.expiretime=chGMTDateTime4(data.expiretime+" "+expirehmtime);
	}
    return data ;
}

function getPowers()
{
	var arr_values = getCheckValue("roleid").split(",") ;
	var powers = "" ;
	for(var i=0;i<arr_values.length;i++)
	{
		if (arr_values[i] == "")
			continue ;
		powers +=","+arr_values[i];
	}
	return powers ;
}

function getuserpaws(ischeck)
{  
	if(ischeck) $("#userpaws").attr("type","text");
	else $("#userpaws").attr("type","password"); 
}
</script>