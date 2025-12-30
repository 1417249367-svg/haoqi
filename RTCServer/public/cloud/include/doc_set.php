<?php  require_once("../include/fun.php");?>
           <form id="form-group" method="post"  class="form-horizontal"   data-obj="cloud"  data-table="OnlineFile" data-fldid="OnlineID" data-fldname="TypePath" enctype="multipart/form-data">
              <div class="modal-body" style="padding-top:0px !important;">
<!--                    <ul id="tabs" class="nav nav-tabs">
                        <li><a href="#base" data-toggle="tab">属性</a></li>
                        <li id="tab_member"><a href="#member" data-toggle="tab" id="tab_menu_member">成员</a></li>
                    </ul>-->
                    <div class="tab-content" style="display:block;" id="base">     
                        <div class="form-group">
                            <label class="control-label" for="authority3"><?=get_lang('set_authority3')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="radio" name="authority3" value="0" value-unchecked="0" /> <?=get_lang('set_authority30')?></label><label class="checkbox-inline"><input type="radio" name="authority3" value="1" value-unchecked="0" /> <?=get_lang('set_authority31')?></label>
							</div>
                        </div>            
                        <div class="form-group">
                            <label class="control-label" for="authority1"><?=get_lang('set_authority1')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="radio" name="authority1" value="0" value-unchecked="0" /> <?=get_lang('set_authority10')?></label><label class="checkbox-inline"><input type="radio" name="authority1" value="1" value-unchecked="0" /> <?=get_lang('set_authority11')?></label><label class="checkbox-inline"><input type="radio" name="authority1" value="2" value-unchecked="0" /> <?=get_lang('set_authority12')?></label>
							</div>
                        </div>
                        <div class="form-group" id="base2">
                            <label class="control-label" for="authority2"><?=get_lang('set_authority2')?></label>
                            <div class="control-value">
                                <label class="checkbox-inline"><input class="data-field" type="radio" name="authority2" value="0" value-unchecked="0" /> <?=get_lang('set_authority20')?></label><label class="checkbox-inline"><input type="radio" name="authority2" value="1" value-unchecked="0" /> <?=get_lang('set_authority21')?></label>
							</div>
                        </div>
                     <div class="tab-content" style="margin-top:10px;" id="member">
					    <div class="clearfix">
						    <div class="pull-left"><h5 id="title"><?=get_lang('set_title')?></h5></div>

						    <div class="pull-right" style="width:275px">
							    <div class="input-group">
							      <input type="text" class="form-control" id="userkey" placeholder="<?=get_lang('set_userkey')?>">
							      <span class="input-group-btn">
								    <button class="btn btn-default" type="button" onclick="addMemberByInput()"><?=get_lang('set_addMemberByInput')?></button>
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
									    <tr><td style="width:100px;"><div id="tbl_member_checkAll"><input type="checkbox" class="chk_power2" onclick="chk_set_All(this.checked)"><?=get_lang("set_edit")?></div></td><td style="width:100px;"><?=get_lang('set_name')?></td><td style="width:100px;"><?=get_lang('set_account')?></td><td></td><td></td></tr>
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
var authority=0;
var doc_id = "<?=g("doc_id") ?>" ;
var serverAddr = "<?=$_SERVER["SERVER_ADDR"] ?>";
var rtcPort = "<?=RTC_PORT?>";

$(document).ready(function(){
	$("#btn_save").click(function(){
        saveForm();
        return false ;
    })
	$("input[name='authority1']").click(function(){
        doc_html_init("authority1",$(this).val());
    })
	$("input[name='authority2']").click(function(){
        doc_html_init("authority2",$(this).val());
    })
	doc_detail_init();
})

function doc_html_init(flag,val)
{
	switch (flag) {
		case "authority1":
			authority=0;
			switch (parseInt(val)) {
				case 0:
				    authority=1;
					$("#tbl_member_checkAll").hide();
					$("#base2").show();
					$("#title").html("<?=get_lang('set_title')?>");
					if(parseInt($("input[name='authority2']:checked").val())==0){
						//$("#tab_member").show();
						$("#tbl_member tbody tr").remove();
						$("#member").show();
					}else{
						//$("#tab_member").hide();
						$("#member").hide();
					}
					break;
				case 1:
				    $("#tbl_member_checkAll").show();
					$("#base2").hide();
					$("#title").html("<?=get_lang('set_title1')?>");
					//$("#tab_member").show();
			        $("#tbl_member tbody tr").remove();
					$("#member").show();
					break;
				case 2:
					$("#base2").hide();
					$("#title").html("<?=get_lang('set_title1')?>");
					//$("#tab_member").hide();
					$("#member").hide();
					break;
			} 
			break;
		case "authority2":
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
	//document.write(url);
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
    $("input[name='authority1'][value='"+data.authority1+"']").attr("checked",true);
    $("input[name='authority2'][value='"+data.authority2+"']").attr("checked",true);
	$("input[name='authority3'][value='"+data.authority3+"']").attr("checked",true);
    doc_html_init("authority2",data.authority2);
    doc_html_init("authority1",data.authority1);

	// init member
	for(var i=0;i<data.members.length;i++)
		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname,data.members[i].authority);

}

function group_saveCallBack()
{
	//dataList.reload();
	dialogClose("set");
}
	
function saveForm()
{
	if($("#base2").is(":hidden")) $("input[name='authority2'][value='0']").attr("checked",true);;
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

function chk_set_All(ischeck)
{
   $(".chk_power").each(function(){
	this.checked = ischeck;
  });
}


function addMember(userId,userName,loginName,admin)
{
	if ($("#user_" + userId).html() != undefined)
	{
		myAlert(langs.user_exists.replace("{user}",userName));
		return ;
	}
	if (userId == curr_userid)
	{
		myAlert(langs.user_curr_userid.replace("{user}",userName));
		return ;
	}
	var txtchecked="";
//	var imgsrc="edit.png";
    if(admin==1){
		txtchecked=" checked";
//		imgsrc="edit.gif";
	}
	var row = $("<tr id='user_" + userId + "'><td><input type='checkbox' class='chk_power'" + txtchecked + " value='" + userId + "' title='" + userName + "'></td><td class='col_name'>" + userName + "</td><td class='col_loginname'>" + loginName + "</td><td><span style='cursor:pointer;' onclick='deleteMember(" + userId + ")'><img src='/static/img/DelGroupUserImg.png' width='16' height='16' /></span></td></tr>") ;
	$("#tbl_member tbody").append(row);

	$("#userkey").attr("data-value","").attr("real-value","").val("") ;
	if(parseInt($("input[name='authority1']:checked").val())==0) $(".chk_power").hide();
}

//function SetGroupAdmin(userId)
//{
//	if(authority) return ;
//    if($("#user_" + userId).attr("data")==userId + "-0"){
//	//$("#user_" + userId + " td a img").attr("src", "/static/img/edit.png"); 
//	//$("#user_" + userId).attr("class", ""); 
//	$("#user_" + userId).attr("data",userId + "-1");
//	}else{
//	//$("#user_" + userId + " td a img").attr("src", "/static/img/edit.gif"); 
//	//$("#user_" + userId).attr("class", "icon-member"); 
//	$("#user_" + userId).attr("data",userId + "-0");
//	};
//}

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
   $(".chk_power").each(function(){
		if (memberIds != "")
			memberIds += "," ;
		memberIds += $(this).val() + "-" +($(this).is(':checked')?1:0) + "-" +$(this).attr("title") ;
  });
//	$("#tbl_member tbody tr").each(function(){
//		if (memberIds != "")
//			memberIds += "," ;
//		memberIds += $(this).attr("data") + "-" +$(this).attr("title") ;
//	})
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
</script>