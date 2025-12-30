<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal"   data-obj="livechat_kf"  data-table="OtherForm" data-fldid="ID" data-fldname="IPAddress" enctype="multipart/form-data">
              <div class="modal-body">
                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab"><?=get_lang('chater_list_attributes')?></a></li>
                        <li><a href="#member" data-toggle="tab" id="tab_menu_member"><?=get_lang('chater_list_member')?></a></li>
                         <li><a href="#board" data-toggle="tab"><?=get_lang('chater_list_generate')?></a></li> 
                         <li><a href="#mboard" data-toggle="tab"><?=get_lang('chater_list_generate1')?></a></li> 
                        <!-- <li><a href="#tag" data-toggle="tab">标签</a></li> -->
                    </ul>
                    <div class="tab-content" id="base">
<!--	                    <div>
	                        <div class="user-photo"  style="height: 60px;">
	                            <img id="img_picture" class="photo"  title="更改照片" alt="更改照片" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            	<input type="file" id="file_picture" name="file_picture"  class="file-picture pic" onchange="uploadFile(this)" style="outline: none;" accept=".png,.jpg,.jpeg,.gif"/>
	                        </div>
	                    </div>-->
                        <div class="form-group">
                            <label class="control-label" for="ipaddress"><?=get_lang('chater_list_server')?></label>
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('chater_list_alert_enteripaddress')?>" class="form-control data-field  specialCharValidate" required id="ipaddress"  name="ipaddress"/> </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label" for="col_diskspace">群空间大小</label>
	                        <div class="input-group" style="margin-left: 120px; width:150px;">
		                    	<input type="text" placeholder="" class="form-control data-field  specialCharValidate" required id="col_diskspace"  name="col_diskspace" value="1024" /><span class="input-group-addon">MB</span>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="col_itemindex">排序号</label>
                            <div class="control-value">
                                <input type="text" placeholder="" class="form-control data-field fl digits"  id="col_itemindex"  name="col_itemindex" required value="1000" style="width:120px;" /> <i class="fl" style="padding:5px;">从小到大进行排列</i>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label" for="welcome"><?=get_lang('chater_list_welcome')?></label>
                            <div class="control-value"><textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="welcome" name="welcome" maxlength="70" ></textarea> </div>
                        </div>
                    </div>

                    <div class="tab-content" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5><?=get_lang('user_picker_title')?></h5></div>

						    <div class="pull-right" style="width:275px">
							    <div class="input-group">
							      <input type="text" class="form-control" id="userkey" placeholder="<?=get_lang('user_picker_ph_userkey')?>">
							      <span class="input-group-btn">
								    <button class="btn btn-default" type="button" onclick="addMemberByInput()"><?=get_lang('user_picker_btn_add')?></button>
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
									    <tr><td style="width:100px;"><?=get_lang('user_picker_col_name')?></td><td style="width:100px;"><?=get_lang('user_picker_col_account')?></td><td></td></tr>
								    </thead>
								    <tbody>
								    </tbody>
							    </table>
						    </div>
						    <div style="clear:both;"></div>
					    </div>
                    </div>

                    
					<div class="tab-content" id="board">
                        <div class="form-group">
                            <label class="control-label" for="webcode"><a href="<?="http://".RTC_SERVER.":99" ?>" target="_blank"><?=get_lang('chater_list_preview')?></a><br><br><a href="#" onclick="copyUrl2()"><?=get_lang('chater_list_copy')?></a></label>
                            <div class="control-value"><textarea name="webcode" id="webcode" placeholder="" class="form-control" rows="14" maxlength="100"></textarea> </div>
                        </div>
                    </div>
                    <div class="tab-content" id="mboard">
                        <div class="form-group">
                            <label class="control-label" for="mwebcode"><a href="#" onclick="copyUrl3()"><?=get_lang('chater_list_copy')?></a></label>
                            <div class="control-value"><textarea name="mwebcode" id="mwebcode" placeholder="" class="form-control" rows="14" maxlength="100"></textarea> </div>
                        </div>
                    </div>
                    <div class="tab-content" id="tag" style="padding:5px;">
                            <div id="tag_container" class="tag_list"></div>
                    </div>
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
				<input type="hidden" class="data-field" id="user_id" name="user_id" />
              </div>
            </form>

<script type="text/javascript">

var dataForm ;
var treeUser ;
var treeOrg ;
var groupId = "1" ;
var groupName = "<?=g("groupname") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";

$(document).ready(function(){
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
   livechat_detail_init();
})
</script>