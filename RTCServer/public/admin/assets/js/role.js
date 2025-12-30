var id = "" ;
var treeOrg ;
var isLoadedTreeOrg = 0 ;
function role_member(_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	user_picker(3,objId,1);
}


function role_list_init()
{
	dataList = $("#datalist").attr("data-where",get_where()).dataList(format_data,listCallBack);
	$("#key").keyup(function(){
		role_search();
	})
}

function format_data(data)
{
	return data;
}

function listCallBack()
{
	if (! _isadmin) {
		$("input[type=radio]").remove();
	}
	$("input[name='defaultrole'][data-value='1']").attr("checked", true);
	var id=$("input[name='defaultrole'][data-value='1']").attr("id").substring(12);
	$(".row-" + id).each(function(){
		$("input[type=checkbox]",this).remove();
		$(".btn_delete",this).remove();
		
		$(".btn_disabled,.btn_delete,.btn_member",this).each(function(){
			$(this).unbind("click");
			$(this).click(function(){
				myAlert(langs.role_delete_default);
			})
		})
		
	})
}

function role_search(){

	dataList.search(get_where()) ;
}

function get_where()
{
	var where = "" ;
	var key =  $("#key").val() ;
	if (! _isadmin)
		where = getWhereSql(where, "CreatorID='" + _curr_userid + "'") ;
	if (key != "")
		where = getWhereSql(where, "RoleName like '%" + key + "%'") ;
    return where ;
}

function role_edit(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = (id == ""?langs.role_create:langs.role_edit) ;
	var url = "../hs/role_edit.html" + (id == ""?"":"?roleid=" + id + "&rolename=" + escape(_name))  ;
	dialog("role",title ,url) ;
}

function role_copy(id,_name)
{
	$(".modal").remove() ; //以免与USERPICKER冲突
	if (id == undefined)
		id = "" ;
	if (_name == undefined)
		_name = "" ;

	var title = langs.role_copy ;
	var url = "../hs/role_edit.html" + (id == ""?"":"?roleid=" + id + "")  ;
	dialog("role",title ,url) ;
}


function role_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;
//	arrId = id.toString().split(",");
//	for(var i=0;i<arrId.length;i++)
//	{
//	   if(arrId[i] == $("input[name='defaultrole'][data-value='1']").attr("id").substring(12))
//	   {
//		   myAlert("默认角色不能删除");
//			return ;
//	   }
//	}

	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}

function role_detail_init()
{
	formatTabs("tabs","330px");

	$(".role-column,#container_treeuser").height(260);
	if(roleName=='') $("#form-role").attr("data-op","create");
	dataForm = $("#form-role").attr("data-id",roleId).dataForm({getcallback:role_getCallBack,savecallback:role_saveCallBack,submitcallback:role_submitCallBack});


	//init searchinput
	user_search_init() ;

	//init treeuser
	//loadTreeUser();

	//init org
	if ((roleId > 0) == false)
		loadTreeOrg();
	if (! _isadmin) {
//		$("input[name='departmentpermission'][value='0']").remove();
//		$("input[name='departmentpermission'][value='1']").remove();
		$("input[name='departmentpermission'][value='2']").attr("checked",true);
		$("#departmentpermission0").hide();
		$("#departmentpermission1").hide();
		//treeOrg.setCheck(treeOrg.getAllFatItems(),1);
	}

   // validate
   $("#form-role").validate({
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
			if (isLoadedTreeOrg)
			{
				var orgIds = treeOrg.getAllPartiallyChecked() + "," + treeOrg.getAllChecked() ;
				$("#department").val(formatOrgIds(orgIds));
			}
			$("#permissions").val(getPowers());
//			$("#memberIds").val(getMemberIds());
//			$("#chk_smscount,#chk_ptpsize").each(function(){
//				var checked = $(this).is(":checked");
//				var ipt = $("#" + $(this).attr("for"));
//				if (!checked)
//					$(ipt).val("-1");
//			})


			dataForm.save();
			return false;
		}
  });

//	$("#chk_attachsize,#chk_msends").click(function(){
//		var checked = $(this).is(":checked");
//		var ipt = $("#" + $(this).attr("for"));
//		if (checked)
//		{
//			if ($(this).attr("for") == "msends")
//   				$("#msends").val(default_sends);
//			else
//   				$("#attachsize").val(default_size);
//			//可输入
//			$(ipt).attr("disabled",false).focus();
//		}
//		else
//		{
//			//可输入
//			$(ipt).attr("disabled",true).val("-1");
//		}
//	})
}



function getPowers()
{
	var arr_values = getCheckValue("permission").split(",") ;
	var powers = "" ;
	for(var i=0;i<arr_values.length;i++)
	{
		if (arr_values[i] == "")
			continue ;
		powers +=","+arr_values[i];
	}
	return powers ;
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


function loadTreeOrg()
{
	var url = getAjaxUrl("org","get_tree","loadall=1&loaduser=0&isroot=0") ;
	treeOrg = new dhtmlXTreeObject("container_treeorg","100%","100%",0);
	treeOrg.setImagePath(TREE_IMAGE_PATH);
	treeOrg.enableCheckBoxes(1);
	treeOrg.setXMLAutoLoading(url);
	treeOrg.loadXML(url,function(){
		//设置选中的值
		//treeOrg.xopenAll("000002_4_000002_0_000000_");
		//document.write((treeOrg.getAllFatItems() + "," + treeOrg.getAllLeafs()));
		var arrIds = (treeOrg.getAllFatItems() + "," + treeOrg.getAllLeafs()).split(",") ;
		var arrDept = $("#department").val().split("-") ;
		
		if ((roleId > 0) == false&&! _isadmin){
			for(var i=0;i<arrIds.length;i++)
			{
				treeOrg.setCheck(arrIds[i],1);
				treeOrg.openItem(arrIds[i]);
	   	    }
		}else{

		for(var i=0;i<arrIds.length;i++)
		{

			var arr_tree = arrIds[i].split("_") ;
			for(var j=0;j<arrDept.length;j++)
			{
				var arr_db = arrDept[j] ;
				if ((arr_tree[2] ==arr_db))
				{
					treeOrg.setCheck(arrIds[i],1);
					treeOrg.openItem(arrIds[i]);
				}
			}
		}
		}
		isLoadedTreeOrg = 1 ; //表示加载完成
		treeOrg.enableThreeStateCheckboxes(1);	// 1 - on, 0 - off;
		$("#container_treeorg .loading").remove();
	});

}

function formatOrgIds(orgIds)
{
	var arr_org = orgIds.split(",");
	var orgId_new = "" ;
	for(var i=0;i<arr_org.length;i++)
	{
		if (arr_org[i] == "")
			continue ;
		var arr_item = arr_org[i].split("_");
		orgId_new += (orgId_new == ""?"":"-") + arr_item[2] ;
	}
	return orgId_new ;
}




function role_getCallBack(data)
{
	//$("#Department").val(data.role.department);

	//详情加载后加初始化树，因为要先取到详情的ORGIDS
	if ((roleId > 0))
		loadTreeOrg();

    //alert(JSON.stringify(data));
	// init member
//	for(var i=0;i<data.members.length;i++)
//		addMember(data.members[i].col_id,data.members[i].col_name,data.members[i].col_loginname);

	// init ace
	var Smsn=new Array();
	Smsn=data.permissions.split(",");
	for(var k=0;k<Smsn.length;k++){
       if(Smsn[k]!="") $("input[name='permission'][value='"+Smsn[k]+"']").attr("checked",true); 
	}

//    if(data.role.rolename.toLowerCase()=="everyone")
//    {
//    	$("#rolename").attr("disabled",true) ;
//    }
   $("input[name='departmentpermission'][value='"+data.departmentpermission+"']").attr("checked",true);
   if(roleName==''){
   $("#rolename").val('');
   $("#description").val('');
   }
//   $("#smscount").val(data.role.smscount);
//   $("#ptpsize").val(data.role.ptpsize);
//   $("#ptptype").val(data.role.ptptype);
//   $("#pubsize").val(data.role.pubsize);
//   $("#pubtype").val(data.role.pubtype);
//   $("#clotsize").val(data.role.clotsize);
//   $("#clottype").val(data.role.clottype);
//   $("#userssize").val(data.role.userssize);
//   $("#userstype").val(data.role.userstype);

	//data.col_ipaddr = replaceAll(data.col_ipaddr,",","\n");
}

function role_saveCallBack()
{
	dataList.reload();
	dialogClose("role");
}


function role_submitCallBack(data)
{
	//data.col_ipaddr = replaceAll(data.col_ipaddr,"\n",",");
	return data ;
}

function role_one_key()
{
    showLoading(langs.role_create_batch_doing);
    var url = getAjaxUrl("role","role_one_key") ;
    $.ajax({
        type:"POST",
        dataType:"json",
        url: url,
        success:function(result){
            dataList.reload();
            hideLoading();
            myAlert(langs.text_op_success);
        }
    });
}
