/*****************************************************
* 参数
* parentEmpType
* parentEmpId
* childEmpType
* mode 模式  hs_relation
* 得到用户数据getUserList,默认是hs_relaiton表
* 保存用户数据postUserList
* getMemberIds 得到用户的ids
*****************************************************/

var parentEmpType = "" ;
var parentEmpId = "" ;
var childEmpType = "" ;
var mode = "" ;
var treeUser ;
var userPikerThreeCheckbox = false ;
var _nodeId ;
function user_picker(parentEmpType,parentEmpId,childEmpType,mode)
{
	$(".modal").remove() ;
	if (mode == undefined)
		mode = "hs_relation" ;

	var param = "parentEmpType=" + parentEmpType +
			   "&parentEmpId=" + parentEmpId +
			   "&childEmpType=" + childEmpType +
			   "&mode=" + mode ;
	dialog("picker",langs.user_set,"../lv_manager/user_picker.html?" + param) ;
}



function userpicker_init()
{
	if (parentEmpId == "")
	{
		myAlert(langs.user_select_text);
		dialogClose("picker");
	}

	//批量设置不显示
	if (parentEmpType != "")
	{
		if (parentEmpId.indexOf(",") == -1)
			getUserList() ;
	}

	$(".role-column,#container_treeuser").height(260);

	//init treeuser
	loadTreeUser();


	$("#btn_picker_submit").click(function(){
		var users = "";
		var flag = $("#chk_reset").is(':checked')?1:0 ;
		postUserList1();
	})
}

function getUserList()
{
	var url = "" ;
	//if (mode == "hs_relation")
		url = getAjaxUrl("livechat_kf","getrelationuser2") ;

	if (url != "")
	{
		$.ajax({
		   type: "POST",
		   dataType:"json",
		   data:{parentEmpType:parentEmpType,parentEmpId:parentEmpId,mode:mode},
		   url: url,
		   success: function(result){
				var members = result.rows ;
				for(var i=0;i<members.length;i++)
					addMember(members[i].col_id,members[i].col_name,members[i].col_loginname);
		   }
		});
	}
}

function postUserList1()
{
   var my_ids = getMemberIds() ;
//   if(my_ids==''){
//	  myAlert(langs.doc_dir_warning);
//	  return ;
//   }
   setLoadingBtn($("#btn_picker_submit")) ;
   flag = $("#chk_reset").is(':checked')?1:0 ;
   data = {parentEmpType:parentEmpType,parentEmpId:parentEmpId,childEmpType:1,userid:my_ids,flag:flag,mode:mode} ;
   var url = getAjaxUrl("livechat_kf","setrelationuser6") ;
   //document.write(url+JSON.stringify(data));
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				myAlert(langs.text_op_success);
				dialogClose("picker");
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
   });
}

function loadTreeUser()
{
	treeUser=new dhtmlXTreeObject("container_treeuser","100%","100%",0);
	treeUser.setImagePath(TREE_IMAGE_PATH);
	var url = getAjaxUrl("livechat_kf","get_tree","isroot=0&loadall=0&loaduser=1") ;
	//document.write(url);
	treeUser.setXMLAutoLoading(url);
	treeUser.loadXML(url ,function(){$("#container_treeuser .standartTreeRow").eq(2).click(); });
	treeUser.enableCheckBoxes(1);
	treeUser.enableThreeStateCheckboxes(userPikerThreeCheckbox) ;
	treeUser.setOnCheckHandler(function(id,isCheck){
		_nodeId = id ;
        var arrId = id.split("_");
        if(parseInt(arrId[1]) == 0)
        {
            get_dept_user(id,isCheck);
        }
        else
        {
			if (isCheck)
                addMember(arrId[2],treeUser.getItemText(id),arrId[5]) ;
            else
                deleteMember(arrId[2]);
        }

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

function addMember(userId,userName,LoginName)
{
	if ($("#user_" + userId).html() != undefined)
	{
		myAlert(langs.user_exists.replace("{user}",userName));
		return ;
	}
	//alert(userId+"|"+userName+"|"+LoginName);
	var row = $("<tr id='user_" + userId + "' data='" + userId + "-" + LoginName + "-" + userName + "'><td class='col_name'>" + userName + "</td><td class='col_loginname'>" + LoginName + "</td><td><a href='#' onclick=\"deleteMember(\'" + userId + "\')\">"+langs.btn_delete+"</a></td></tr>") ;
	$("#tbl_member tbody").append(row);

	$("#userkey").attr("data-value","").attr("real-value","").val("") ;
}

function deleteMember(userId)
{
	//alert(userId);
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


//function set_member(empType,_objId)
//{
//	objId = getSelectedId(_objId) ;
//	if (objId == "")
//		return ;
//
//	user_picker(empType,objId,1);
//}

function get_dept_user(id,isCheck){

	var path = getTreePath(treeUser,id) ;
 
	var url = getAjaxUrl("org","get_dept") ;
	var data = {deptid:id,path:path};
	var loading = layer.load(langs.text_loading);
	   $.ajax({
		   type: "POST",
		   data:data,
		   dataType:"json",
		   url: url,
		   success: function(result){	
			   if (result.recordcount == 99999){
			   	alert(langs.user_select_user);
				treeUser.setCheck(_nodeId,0);				
				layer.close(loading);
				return;				
			   }
			
			   if (result.recordcount > 0)
				{
				    var data = result.rows;
					for(var i=0;i < data.length;i++){
						if(isCheck)
							addMember(data[i].col_id,data[i].col_name,data[i].col_loginname) ;
						else
							deleteMember(data[i].col_id);
					}
				}
			   layer.close(loading);
		   }
	   });
}