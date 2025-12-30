<?php  require_once("include/fun.php");?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>
           <form id="form_folder" method="post" class="form-horizontal" data-obj="cloud" data-table="PtpFolder" data-fldid="PtpFolderID" data-fldname="UsName" data-label="ptpform" enctype="multipart/form-data"> 
              <div class="modal-body" style="padding-top:0px !important;">
                    <div class="tab-content" style="display:block;" id="base">
                        <div class="form-group"> 
                            <label class="control-label" for="col_name"><?=get_lang('phpform_subject')?></label> 
                            <div class="control-value">
                                <input type="text" id="col_name" name="col_name"  class="form-control specialCharValidate data-field" required  />
                            </div>
                        </div>
                                     
                     <div class="tab-content" style="margin-top:10px;display:block;" id="member">
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
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
                <input type="hidden" name="parent_type" class="data-field" value="105"> 
				<input type="hidden" name="parent_id" class="data-field" value="0"> 
                <input type="hidden" name="root_type" class="data-field" value="2">
                <input type="hidden" name="root_id" class="data-field" value="0">
                <input type="hidden" id="memberIds" class="data-field" name="memberIds" />
              </div>
            </form>
<?php  require_once("include/footer.php");?>
</body>
</html>
<script type="text/javascript">
var doc_id = "<?=g("doc_id") ?>" ;
var authority=0;
var folder_dataForm ;
$(document).ready(function(){
//	$("#btn_save").click(function(){
//        folder_create_save();
//        return false ;
//    })
   $("#form_folder").validate({
        submitHandler: function(form) {
            saveForm();
            return false;
        }
    })
	doc_detail_init();
});

function doc_detail_init()
{
	$(".group-column,#container_treeuser").height(260);
	if(doc_id) $("#col_name").attr("disabled",true);
	folder_dataForm = $("#form_folder").attr("data-id",doc_id).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});
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
	// init member
	for(var i=0;i<data.members.length;i++)
		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname,data.members[i].authority);
}

function group_saveCallBack()
{
    location.href='include/success.html';
//	dataList.reload();
//	dialogClose("board");
}

function saveForm()
{
    if ($("#col_name").val() == "")
    {
        myAlert(langs.user_phpform_name_text);
        return false ;
    }
	$("#memberIds").val(getMemberIds());
	if (($("#memberIds").val() == "") || ($("#memberIds").val() == undefined))
	{
		myAlert(langs.user_phpform_text);
		return ;
	}
    folder_dataForm.save();
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
	//alert(userId+'|'+userName+'|'+loginName+'|'+admin);
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
	var row = $("<tr id='user_" + userId + "' data='" + userId + "' title='" + userName + "'><td class='col_name'>" + userName + "</td><td class='col_loginname'>" + loginName + "</td><td><span style='cursor:pointer;' onclick='deleteMember(" + userId + ")'><img src='/static/img/DelGroupUserImg.png' width='16' height='16' /></span></td></tr>") ;
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
		memberIds += $(this).attr("data") ;
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


//function folder_create_save()
//{
//	setLoadingBtn($("#btn_save"));
//	
//	var url = getAjaxUrl("cloud","folder_create");
//	var data = {"parent_type":105,"parent_id":0,"root_type":2,"root_id":0,"name":$("#col_name").val(),"ptpform":getMemberIds()} ;
//	//document.write(url+JSON.stringify(data));
//    $.ajax({
//       type: "POST",
//       dataType:"json",
//       data:data,
//       url: url,
//       success: function(result){
//	   		if (result.status == undefined)
//			{
//				//success
////				doc_set_html(result.rows,2);
////				dialogClose("folder");
//			}
//			else
//			{
//				setSubmitBtn($("#btn_save"));
//				myAlert(result.msg);
//			}
//       }
//    }); 
//}

</script>