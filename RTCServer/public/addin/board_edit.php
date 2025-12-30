<?php  require_once("include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal"   data-obj="board"  data-table="Board" data-fldid="id" data-fldname="col_Subject" enctype="multipart/form-data">
              <div class="modal-body" style="padding-top:0px !important;">
<!--                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab">属性</a></li>
                        <li id="tab_member"><a href="#member" data-toggle="tab" id="tab_menu_member">成员</a></li>
                    </ul>-->
                    <div class="tab-content" style="display:block;" id="base">
                        <div class="form-group"> 
                            <label class="control-label" for="col_subject"><?=get_lang('board_subject')?></label> 
                            <div class="control-value">
                                <input type="text" id="col_subject" name="col_subject"  class="form-control specialCharValidate data-field" required  />
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="col_content"><?=get_lang('board_content')?></label> 
                            <div class="control-value">
                                <textarea rows="5" style="height:50px"  placeholder="" class="form-control data-field  specialCharValidate"  id="col_content" name="col_content" maxlength="700" required></textarea>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label class="control-label" for="filename"><?=get_lang('board_datapath')?></label> 
                            <div class="control-value">
                                <input type="text" id="filename" name="filename"  class="form-control" disabled="disabled"/>
                                <a href="javascript:void(0);" onclick="$('#container_link').toggle()"><?=get_lang('board_attach')?></a>
                                <div id="container_link" style="display:none;">
                                    <input type="file" id="file" name="file"  class="form-control pull-left mr" style="width:350px;" />
                                    <button type="button" class="btn btn-default pull-left" id="btn_upload" onclick="uploadFile()" ><?=get_lang('board_upload')?></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="base2">
                            <label class="control-label" for="col_ispublic"><?=get_lang('board_type')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="radio" name="col_ispublic" value="1" value-unchecked="0" /> <?=get_lang('board_all')?></label><label class="checkbox-inline"><input type="radio" name="col_ispublic" value="0" value-unchecked="0" /> <?=get_lang('board_designation')?></label>
							</div>
                        </div>    
                        
                                     
                     <div class="tab-content" style="margin-top:10px;" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5 id="title"><?=get_lang('board_user')?></h5></div>

						    <div class="pull-right" style="width:275px">
							    <div class="input-group">
							      <input type="text" class="form-control" id="userkey" placeholder="<?=get_lang('board_userkey')?>">
							      <span class="input-group-btn">
								    <button class="btn btn-default" type="button" onclick="addMemberByInput()"><?=get_lang('board_addMemberByInput')?></button>
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
									    <tr><td style="width:100px;"><?=get_lang('board_name')?></td><td style="width:122px;"><?=get_lang('board_account')?></td><td></td><td></td></tr>
								    </thead>
								    <tbody>
								    </tbody>
							    </table>
						    </div>
						    <div style="clear:both;"></div>
					    </div>
                    </div>
                    
                    
                        </div>

                    
					 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
<!--                <input type="hidden" id="tagIds" name="tagIds" />-->
				<input type="hidden" id="memberIds" name="memberIds" />
<!--				<input type="hidden" id="col_type" name="col_type" class="data-field" value="8"/>
				<input type="hidden" id="col_dtype" name="col_dtype" class="data-field" value="1"/>
				<input type="hidden" id="col_ispublic" name="col_ispublic" class="data-field" value="0"/>-->
                <input type="hidden" id="board_attach" name="board_attach"/>
				<input type="hidden" id="col_id" name="col_id" class="data-field" value="<?=create_guid1() ?>"/>
				<input type="hidden" id="col_creator_id" name="col_creator_id" class="data-field" value="<?=CurUser::getUserId() ?>" />
				<input type="hidden" id="col_creator_name" name="col_creator_name" class="data-field" value="<?=CurUser::getUserName() ?>" />
                <input type="hidden" id="col_creator" name="col_creator" class="data-field" value="<?=CurUser::getLoginName() ?>" />
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
var authority=0;
var doc_id = "<?=g("doc_id") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";

$(document).ready(function(){
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
	$("input[name='col_ispublic']").click(function(){
        doc_html_init("col_ispublic",$(this).val());
    })
	doc_detail_init();
})

function doc_html_init(flag,val)
{
	switch (flag) {
		case "col_ispublic":
			switch (parseInt(val)) {
				case 0:
					//$("#tab_member").show();
					$("#member").show();
					break;
				case 1:
					//$("#tab_member").hide();
					$("#member").hide();
					break;
			} 
			break;
	} 
}

function doc_detail_init()
{
	$(".group-column,#container_treeuser").height(260);
	$("input[name='col_ispublic'][value='1']").attr("checked",true);
	dataForm = $("#form-group").attr("data-id",doc_id).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});


	//init searchinput
	user_search_init() ;

	//init treeuser
	loadTreeUser();

	//init org
	//loadTag(EMP_GROUP,groupId);

}

function user_search_init()
{

	$('#userkey').autocomplete({
		source:function(query,process){
			var matchCount = this.options.items;
			var url = getAjaxUrl("user","search") ;
			//alert(url+"key"+query+"top"+matchCount);
			$.getJSON(url,{"key":query,"top":matchCount},function(respData){
				return process(respData.rows);
			});

		},
		formatItem:function(item){
			return item["name"] + " (" + item["loginname"] + ")" ;
		},
		setValue:function(item){
			return {'data-value':item["name"],'real-value':item["id"] + "@@@" + item["name"] + "@@@" + item["loginname"]};
		}
	});
}

function loadTreeUser()
{

	treeUser=new dhtmlXTreeObject("container_treeuser","100%","100%",0);
	treeUser.setImagePath(TREE_IMAGE_PATH);
	var url = getAjaxUrl("org","get_tree1","loadall=0&loaduser=1") ;
	treeUser.setXMLAutoLoading(url);
	treeUser.loadXML(url ,function(){$("#container_treeuser .standartTreeRow").eq(2).click(); });
	treeUser.enableCheckBoxes(1);
	treeUser.enableThreeStateCheckboxes(true) ;
	treeUser.setOnCheckHandler(function(id,isCheck){
		var arrId = id.split("_");
		if(parseInt(arrId[1]) == 1)
		{
			if (isCheck)
				addMember(arrId[2],treeUser.getItemText(id),arrId[5],authority) ;
			else
				deleteMember(arrId[2]);
		}
		else
		{
			get_dept_user(id,isCheck);
		}


		/*
		//selected childs node
		var ids = treeUser.getAllSubItems(id) ;
		if (ids != "")
			ids += "," ;
		ids += id ;
		var arrId = ids.split(",");

		for(var i=0;i<arrId.length;i++)
		{
			var currId = arrId[i] ;
			var arrItem = currId.split("_");
			if (arrItem[1] == "1")
			{
				if (isCheck)
					addMember(arrItem[2],treeUser.getItemText(currId),arrItem[5]) ;
				else
					deleteMember(arrItem[2]);
			}
		}
		*/


	});
	treeUser.setOnOpenEndHandler(function(id){
		var ids=this.getAllSubItems(id);
		var arrId = ids.split(",");
		for(var i=0;i<arrId.length;i++){
			var currId = arrId[i] ;
			var arrItem = currId.split("_");
			if(parseInt(arrItem[1]) == 1)
			{
				var loginName = arrItem[arrItem.length-1];
				$("td.col_loginname").each(function () {
					if(loginName == $(this).text()){
						treeUser.setCheck(currId,true);
					}
				});
			}
		}
	})
}

function group_getCallBack(data)
{
    $("input[name='col_ispublic'][value='"+data.col_ispublic+"']").attr("checked",true);
    doc_html_init("col_ispublic",data.col_ispublic);

	// init member
	for(var i=0;i<data.members.length;i++)
		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname,data.members[i].authority);

}

function group_saveCallBack()
{
	dataList.reload();
	dialogClose("board");
}
	
function saveForm()
{
	if($("#base2").is(":hidden")) $("input[name='col_ispublic'][value='0']").attr("checked",true);;
	if($("#member").is(":hidden")) $("#memberIds").val("");
	else $("#memberIds").val(getMemberIds());
    dataForm.save();
}

function addMemberByInput()
{
	var real_value = $("#userkey").attr("real-value") ;
	if ((real_value == "") || (real_value == undefined))
	{
		myAlert(langs.user_select_text);
		return ;
	}

	var arrItem = real_value.split("@@@");
	addMember(arrItem[0],arrItem[1],arrItem[2],authority);
}

function addMember(userId,userName,loginName,admin)
{
	if ($("#user_" + userId).html() != undefined)
	{
		myAlert(langs.user_exists.replace("{user}",userName));
		return ;
	}
	if (userId == _curr_userid)
	{
		myAlert(langs.user_curr_userid.replace("{user}",userName));
		return ;
	}
	var row = $("<tr id='user_" + userId + "' data='" + userId + "-" + loginName + "' title='" + userName + "'><td class='col_name'>" + userName + "</td><td class='col_loginname'>" + loginName + "</td><td><span style='cursor:pointer;' onclick='deleteMember(" + userId + ")'><img src='/static/img/DelGroupUserImg.png' width='16' height='16' /></span></td></tr>") ;
	$("#tbl_member tbody").append(row);

	$("#userkey").attr("data-value","").attr("real-value","").val("") ;
}

function deleteMember(userId)
{
//	var my_ids;
//	var Smsn=new Array();
//	my_ids = getMemberIds() ;
//	Smsn=my_ids.split(",");
//	if(Smsn.length<3){
//		myAlert("群组成员必须2个人以上");
//		return ;
//	}
	$("#user_" + userId).remove();
}

function getMemberIds()
{
	var memberIds = "" ;
	$("#tbl_member tbody tr").each(function(){
		if (memberIds != "")
			memberIds += "," ;
		memberIds += $(this).attr("data") + "-" +$(this).attr("title") ;
	})
	return memberIds ;
}

function get_dept_user(id,isCheck){

	var url = getAjaxUrl("org","get_dept_user","deptid=" + id) ;
	//document.write(url);
	var loading = layer.load(langs.text_loading);
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
			   if (result.recordcount > 0)
				{
				    var data = result.rows;
					for(var i=0;i < data.length;i++){
						if(isCheck)
							addMember(data[i].col_id,data[i].col_name,data[i].col_loginname,authority) ;
						else
							deleteMember(data[i].col_id);
					}
				}
			   layer.close(loading);
		   }
	   });
}

function uploadFile()
{
	var fileName = $("#file").val();
	var url = getAjaxUrl("upload","bioace") ;
	$("#form-group").attr("action",url).attr("target","frm_Upload").submit();
}


function uploadComplete(file)
{
	//document.write(JSON.stringify(file));
	$("#filename").val($("#filename").val()+file.filename+",");
	$("#board_attach").val($("#board_attach").val()+file.filesize+"|"+ file.filepath+"|"+file.filename+",");
	$("#container_link").fadeOut();
}
</script>