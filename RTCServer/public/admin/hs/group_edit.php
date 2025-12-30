<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal"   data-obj="group"  data-table="Clot_Ro" data-fldid="TypeID" data-fldname="TypeName" enctype="multipart/form-data">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang("group_tab_base")?></a></li>
                        <li><a href="#member" data-toggle="tab" id="tab_menu_member"><?=get_lang("group_tab_member")?></a></li>
                         <li id="tab_pic"><a href="#pic" data-toggle="tab"><?=get_lang("group_ph_portrait")?></a></li> 
                        <!-- <li><a href="#tag" data-toggle="tab">标签</a></li> -->
                    </ul>
                    <div class="tab-content" id="base">
                        <div class="form-group">
                            <label class="control-label" for="typename"><?=get_lang("group_lb_name")?></label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="typename" name="typename" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="disk_space"><?=get_lang("group_lb_diskspace")?></label>
	                        <div class="input-group" style="margin-left: 120px; width:150px;">
		                    	<input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="disk_space"  name="disk_space" value="1024" /><span class="input-group-addon">MB</span>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="itemindex"><?=get_lang("group_lb_index")?></label>
                            <div class="control-value">
                                <input type="text" placeholder="" class="form-control data-field fl digits"  id="itemindex"  name="itemindex" maxlength="6" required value="1000" style="width:120px;" /> <i class="fl" style="padding:5px;"><?=get_lang("txt_order")?></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="remark"><?=get_lang("group_lb_desc")?></label>
                            <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="remark" name="remark" maxlength="70" ></textarea> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sender"></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="checkbox" id="sender" name="sender" value="1" value-unchecked="0" /> <?=get_lang("group_ph_Banned")?></label>
							</div>
                        </div>                    </div>

                    <div class="tab-content" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5><?=get_lang("group_tree_title")?></h5></div>

						    <div class="pull-right" style="width:275px">
							    <div class="input-group">
							      <input type="text" class="form-control" id="userkey" placeholder="<?=get_lang("txt_usersearch")?>">
							      <span class="input-group-btn">
								    <button class="btn btn-default" type="button" onclick="addMemberByInput()"><?=get_lang("btn_addmember")?></button>
							      </span>
							    </div>
						    </div>
						    <div style="clear:both;"></div>
					    </div>

					    <div class="clearfix">
						    <div class="col2 bor group-column" style="float:left;">
							    <div id="container_treeuser" class="container-tree"></div>
						    </div>
						    <div class="col2 bor group-column" style="float:right;overflow:scroll;">
							    <table id="tbl_member" class="table" style="margin:0px;padding:0px;">
								    <thead>
									    <tr><td style="width:22px;"></td><td style="width:100px;"><?=get_lang("field_username")?></td><td style="width:100px;"><?=get_lang("field_account")?></td><td></td><td></td></tr>
								    </thead>
								    <tbody>
								    </tbody>
							    </table>
						    </div>
						    <div style="clear:both;"></div>
					    </div>
                    </div>

                    
					<div class="tab-content" id="pic">
	                    <div>
	                        <div class="user-photo"  style="height: 60px;">
	                            <img id="img_picture" class="photo"  title="<?=get_lang("txt_img_tip")?>" alt="<?=get_lang("txt_img_tip")?>" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            	<input type="file" id="file_picture" name="file_picture"  class="file-picture pic" onchange="uploadFile(this)" style="outline: none;" accept=".jpg,.gif"/>
	                        </div>
	                    </div>
                    </div>
<!--                    <div class="tab-content" id="tag" style="padding:5px;">
                            <div id="tag_container" class="tag_list"></div>
                    </div>-->
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang("btn_save")?></button>
<!--                <input type="hidden" id="tagIds" name="tagIds" />-->
				<input type="hidden" id="memberIds" name="memberIds" />
<!--				<input type="hidden" id="col_type" name="col_type" class="data-field" value="8"/>
				<input type="hidden" id="col_dtype" name="col_dtype" class="data-field" value="1"/>
				<input type="hidden" id="col_ispublic" name="col_ispublic" class="data-field" value="0"/>-->
				<input type="hidden" id="ownerid" name="ownerid" class="data-field" value="<?=CurUser::getUserId() ?>" />
				<input type="hidden" id="creatorid" name="creatorid" class="data-field" value="<?=CurUser::getUserId() ?>" />
				<input type="hidden" id="creatorname" name="creatorname" class="data-field" value="<?=CurUser::getUserName() ?>" />
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
var RTCCONSOLE = "<?=RTC_CONSOLE?>";

$(document).ready(function(){
   if (groupId == "")
   {
        $("#tab_pic").remove();
        $("#pic").remove();
   }
	$("#img_picture").attr("src","../assets/img/icon_group.png");
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
   group_detail_init();
})
</script>