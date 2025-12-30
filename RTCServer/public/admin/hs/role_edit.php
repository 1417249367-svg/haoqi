<?php  require_once("../include/fun.php");?>
<style>
.ace_td {
	position: relative;
}

.ace_td label.error {
	bottom: 0px;
	left: auto;
	right: 15px;
}

.ace_td input[type=text] {
	border: 1px solid #ccc;
	width: 80px;
	height: 25px;
	line-height: 20px;
}
</style>
           <form id="form-role" method="post"  class="form-horizontal"   data-obj="role"  data-table="Role" data-fldid="ID" data-fldname="RoleName">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang("role_tab_base")?></a></li>
<!--                        <li><a href="#member" data-toggle="tab" id="tab_menu_member">成员</a></li>-->
                        <li><a href="#power" data-toggle="tab"><?=get_lang("role_tab_power")?></a></li>
                        <li><a href="#file" data-toggle="tab"><?=get_lang("role_tab_file")?></a></li>
                        <li><a href="#org" data-toggle="tab"><?=get_lang("role_tab_org")?></a></li>
						<li><a href="#ip" data-toggle="tab"><?=get_lang("role_tab_ip")?></a></li>
                    </ul>
                    <div class="tab-content" id="base">
                        <dl><dt><?=get_lang("role_power_warning")?></dt></dl>
                        <div class="form-group">
                            <label class="control-label" for="rolename"><?=get_lang("label_name")?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-keyfield  specialCharValidate data-field" required id="rolename"  name="rolename"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description"><?=get_lang("label_desc")?></label>
                            <div class="control-value"><textarea type="text"  rows="10" style="height:200px"  placeholder="" class="form-control data-field"  id="description" name="description" ></textarea> </div>
                        </div>
                    </div>

                    <!--<div class="tab-content" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5>选择成员</h5></div>

						    <div class="pull-right" style="width:280px">
							    <div class="input-group">
							      <input type="text" class="form-control" id="userkey" placeholder="输入帐号或姓名">
							      <span class="input-group-btn">
								    <button class="btn btn-default" type="button" onclick="addMemberByInput()">添加成员</button>
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
									    <tr><td style="width:100px;">姓名</td><td style="width:100px;">帐号</td><td></td></tr>
								    </thead>
								    <tbody>
								    </tbody>
							    </table>
						    </div>
						    <div style="clear:both;"></div>
					    </div>
                    </div>-->

                    <div class="tab-content" id="power" style="padding:5px;">
                         <div style="overflow:hidden;">
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="0" /> <?=get_lang("role_power_group_create")?></label>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="25" /> <?=get_lang("role_power_signout")?></label>
                            </div>
                            <!--<div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="1" /> 发布公告</label>
                            </div>-->
                            <div class="row clearfix">
                                <div class="col-xs-12 ace_td"><label class="pull-left"><input  type="checkbox" id="chk_smscount" name="permission" value="6" for="smscount"/> <?=get_lang("role_power_chk_smscount")?></label>  <input type="text" class="number pull-left data-field" id="smscount" name="smscount" required value="500" /> <?=get_lang("role_power_smscount")?></div>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="4" /> <?=get_lang("role_power_setattr")?></label>
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="15" /> <?=get_lang("role_power_setaway")?></label>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="5" /> <?=get_lang("role_power_set")?></label>
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="16" /> <?=get_lang("role_power_video")?></label>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="18" /> <?=get_lang("role_power_password")?></label>
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="17" /> <?=get_lang("role_power_remote")?></label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="file">
                         <div style="overflow:hidden;">
                         <dl><dt><?=get_lang("role_power_warning1")?></dt></dl>
                            <div class="row clearfix">
                                <div class="col-xs-12 ace_td"><label class="pull-left"><input  type="checkbox" id="chk_ptpsize" name="permission" value="2" for="ptpsize"/> <?=get_lang("role_power_chk_ptpsize")?></label></div>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="10" /> <?=get_lang("role_power_download_ptpsize")?></label>
                            </div>
<!--                            <div class="row clearfix">
                                <div class="col-xs-12 ace_td"><label class="pull-left"><input  type="checkbox" id="chk_pubsize" name="permission" value="21" for="pubsize"/> 上传公共文档</label>  <label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传最大限制<input type="text" class="numberdata-field data-field" id="pubsize" name="pubsize" required value="5120" />MB</label><label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;上传拓展名限制：<input type="text" class="data-field" id="pubtype" name="pubtype" required value="*" /></label></div>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-12">(上传公共文档权限包括重命名、删除、移动、新建文件夹权限)</label>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="22" /> 下载公共文档</label>
                            </div>-->
                            <div class="row clearfix">
                                <div class="col-xs-12 ace_td"><label class="pull-left"><input  type="checkbox" id="chk_clotsize" name="permission" value="3" for="clotsize"/> <?=get_lang("role_power_chk_clotsize")?></label>  <label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=get_lang("role_power_ptpsize")?><input type="text" class="number data-field" id="clotsize" name="clotsize" required value="5120" />MB</label><label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;<?=get_lang("role_power_ptptype")?><input type="text" class="data-field" id="clottype" name="clottype" required value="*" /></label></div>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="11" /> <?=get_lang("role_power_download_clotsize")?></label>
                            </div>
                            <div class="row clearfix">
                                <div class="col-xs-12 ace_td"><label class="pull-left"><input  type="checkbox" id="chk_userssize" name="permission" value="7" for="userssize"/> <?=get_lang("role_power_chk_userssize")?></label>  <label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=get_lang("role_power_userssize")?><input type="text" class="number data-field" id="userssize" name="userssize" required value="5120" />MB</label><label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;<?=get_lang("role_power_userstype")?><input type="text" class="data-field" id="userstype" name="userstype" required value="*" /></label></div>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="12" /> <?=get_lang("role_power_download_userssize")?></label>
                            </div>
                            <div class="row clearfix">
                                <label class="col-xs-6"><input  type="checkbox"  name="permission" value="13" /> <?=get_lang("role_power_download_networks")?></label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="org">
                        <div class="row clearfix">
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="24" /> <?=get_lang("role_power_sysview")?></label>
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="26" /> <?=get_lang("role_power_setjob")?></label>
                        </div>
                        <div class="row clearfix">
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="8" /> <?=get_lang("role_power_other_department")?></label>
                        </div>
                        <div class="row clearfix">
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="23" /> <?=get_lang("role_power_this_department")?></label>
                        </div>
                        <div class="row clearfix" id="departmentpermission0">
								<label class="col-xs-6"><input type="radio" id="departmentpermission_0" name="departmentpermission" value="0" class="data-field" checked="checked" ><?=get_lang("role_power_unauthorized_control")?></label>
                        </div>
                        <div class="row clearfix" id="departmentpermission1"> 
								<label class="col-xs-6"><input type="radio" id="departmentpermission_1" name="departmentpermission" value="1" ><?=get_lang("role_power_switch0_department")?></label>
                        </div>
                        <div class="row clearfix">
                                <label class="col-xs-6"><input type="radio" id="departmentpermission_2" name="departmentpermission" value="2" ><?=get_lang("role_power_switch1_department")?></label>

                        </div>
                        <div id="container_treeorg" style="height:180px;border:1px solid #ccc;" class="container-tree"><div class="loading"><?=get_lang("txt_loading")?></div></div>
                    </div>

                    <div class="tab-content" id="ip">
                        <div class="row clearfix">
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="9" /> <?=get_lang("role_power_remote_login")?></label>
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="14" /> <?=get_lang("role_power_phone_login")?></label>
                        </div>
                        <div class="row clearfix">
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="19" /> <?=get_lang("role_power_restrictip")?></label>
                            <label class="col-xs-6"><input  type="checkbox"  name="permission" value="20" /> <?=get_lang("role_power_restrictmac")?></label>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
                <input type="hidden" id="department" name="department" class="data-field"/>
<!--                <input type="hidden" id="memberIds" name="memberIds" />-->
                <input type="hidden" id="permissions" name="permissions" class="data-field" />
                <input type="hidden" id="creatorid" name="creatorid" class="data-field" value="<?=CurUser::getUserId() ?>" />
                <input type="hidden" id="creatorname" name="creatorname" class="data-field" value="<?=CurUser::getUserName() ?>"/>
              </div>
            </form>

<script type="text/javascript">

var dataForm ;
var treeUser ;
var treeOrg ;
var roleId = parseInt("<?=g("roleid",0) ?>") ;
var roleName = "<?=g("rolename") ?>" ;
var default_sends = 500 ;
var default_size = 5120 ;
var default_type = "*" ;

$(document).ready(function(){
//   if (roleName.toLowerCase() == "everyone")
//       $("#tab_menu_member").hide();

   $("#smscount").val(default_sends);
   $("#ptpsize").val(default_size);
   $("#ptptype").val(default_type);
   $("#pubsize").val(default_size);
   $("#pubtype").val(default_type);
   $("#clotsize").val(default_size);
   $("#clottype").val(default_type);
   $("#userssize").val(default_size);
   $("#userstype").val(default_type);
   role_detail_init();
})



</script>