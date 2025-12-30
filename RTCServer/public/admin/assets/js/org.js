var viewId = 0 ;
var nodeId = "" ;
var nodeText = "" ;
var userId = "0" ;


function loadTree(container_id)
{
    tree=new dhtmlXTreeObject(container_id,"100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("org","get_tree") ;
    tree.setXMLAutoLoading(url);
    tree.loadXML(url ,function(){$(".standartTreeRow").eq(2).click(); });
}

function dept_select()
{
    nodeId = tree.getSelectedItemId() ;
	nodeText = tree.getSelectedItemText() ;
    if (nodeId == "")
    {
    	myAlert(langs.dept_select_text);
        return false ;
    }
    return true ;
}



function dept_create()
{
    if (dept_select() == false)
        return ;
	var path = getTreePath(tree) ;
	//document.write("../hs/dept_edit.html?parentid=" + nodeId + "&path=" + escape(path));
    dialog("dept",langs.dept_create,"../hs/dept_edit.html?parentid=" + nodeId + "&path=" + escape(path)) ;
}

function dept_edit()
{
    if (dept_select() == false)
        return ;
    if (nodeId =="0_0_0")
    {
        myAlert(getErrorText("102213"));
        return ;
    }
	var path = getTreePath(tree,tree.getParentId(tree.getSelectedItemId())) ;
	//document.write("../hs/dept_edit.html?id=" + nodeId  + "&path=" + escape(path));
    dialog("dept",langs.dept_edit,"../hs/dept_edit.html?id=" + nodeId  + "&path=" + escape(path)) ;
}


function dept_delete()
{
    if (tree.getParentId(nodeId) == "0")
    {
    	myAlert(langs.dept_root_delete_error);
        return ;
    }

    if (dept_select() == false)
        return ;

    if (nodeId =="0_0_0")
    {
        myAlert(getErrorText("102213"));
        return ;
    }
    if (confirm(langs.dept_delete_confirm))
    {
        dept_delete_post(nodeId);
    }
}

function dept_create_post()
{
   setLoadingBtn($("#btn_save"));
   var url = getAjaxUrl("org","create","parentid=" + nodeId) ;
   //document.write(url+$('#form-dept').serialize());
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:$('#form-dept').serialize(),
       success: function(result){
		   //alert(JSON.stringify(result));
            if (result.status)
            {
                //tree.insertNewItem(nodeId,result.id,result.name,0,"folder.png","folder.png","folder.png");
                tree.refreshItem(nodeId);
				treeClick();
                dialogClose("dept");
            }
            else
            {
                myAlert(getErrorText(result.errnum));
				setSubmitBtn($("#btn_save"));
            }
       }
   });

}

function dept_edit_post(nodeId)
{
   setLoadingBtn($("#btn_save"));
   var url = getAjaxUrl("org","edit","id=" + nodeId + "&parentid=" + tree.getParentId(nodeId)) ;
   //document.write(url+$('#form-dept').serialize());
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:$('#form-dept').serialize(),
       success: function(result){
            if (result.status)
            {
                tree.setItemText(nodeId,result.name);
                dialogClose("dept");
            }
            else
            {
                myAlert(getErrorText(result.errnum));
				setSubmitBtn($("#btn_save"));
            }
       }
   });
}


function dept_delete_post()
{
   var url = getAjaxUrl("org","delete","id=" + nodeId) ;
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(result){
            if (result.status)
                tree.deleteItem(nodeId,true);
            else
                myAlert(getErrorText(result.errnum));
       }
   });
}

function dept_move()
{
	var empItem = getNodeInfo(nodeId);
    if (empItem.empType == 0)
    {
    	myAlert(langs.dept_move_error);
        return ;
    }

    dialog("deptpicker",langs.dept_move,"../hs/dept_picker.html?deptid=" + nodeId + "&action_type=dept_move_post") ;
}

function dept_move_post(targetId)
{
	var empItem = getNodeInfo(targetId);
	var currParent = tree.getParentId(nodeId);

//    if (empItem.empType == 0)
//    {
//    	myAlert("不能选择根结点");
//        return ;
//    }
	if (nodeId == targetId)
	{
		myAlert(langs.dept_move_target_self);
	   return ;
	}

	var url = getAjaxUrl("org","dept_move") ;
	//document.write(url+"deptid=" + nodeId + "&targetid=" + targetId);
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:"deptid=" + nodeId + "&targetid=" + targetId,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				//tree.moveItem(nodeId,"item_child",targetId,tree);
				
				//采用刷新节点的方式避免显示重复
				tree.refreshItem(currParent);
				tree.refreshItem(targetId);
				dialogClose("deptpicker");
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
	});
}



///////////////////////////////////////////////////////////////////////////////////////////
//Member
///////////////////////////////////////////////////////////////////////////////////////////
function member_add()
{
	var dept_path = getTreePath();
	
    if (dept_select() == false)
        return ;
    if (nodeId =="0_0_0")
    {
        myAlert(getErrorText("102212"));
        return ;
    }

    var value = $("#key").val() ;
    var data_value = $("#key").attr("data-value") ;
    var real_value = $("#key").attr("real-value") ;
    if ((real_value == "") || (real_value == undefined))
    {
        myAlert(langs.user_select_text);
        return ;
    }

   var url = getAjaxUrl("org","member_add","deptid=" + nodeId) ;
   //document.write(url+"userid"+real_value+"dept_path"+dept_path);
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:{"userid":real_value,"dept_path":dept_path} ,
       success: function(result){
            if (result.status)
            {
                dataList.reload();
				$("#key").attr("data-value","").attr("real-value","").val("") ;
            }
            else
            {
                myAlert(getErrorText(result.errnum));
            }
       }
   });
}


function member_remove(userId)
{
	var dept_path = getTreePath(tree);
	
	userId = getSelectedId(userId) ;
	if (userId == "")
		return ;
	var url = getAjaxUrl("org","member_remove","userid=" + userId) ;
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{"deptid":nodeId,"dept_path":dept_path},
	   url: url,
	   success: function(result){
			if (result.status)
			{
				removeRows(userId);
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
	});
}

function member_move(_userId)
{
   userId = getSelectedId(_userId) ;
   if (userId == "")
   		return ;
    dialog("deptpicker",langs.member_move,"../hs/dept_picker.html?deptid=" + nodeId + "&action_type=member_move_post") ;
}

function member_copy(_userId)
{
   userId = getSelectedId(_userId) ;
   if (userId == "")
   		return ;
    dialog("deptpicker",langs.member_copy,"../hs/dept_picker.html?deptid=" + nodeId + "&action_type=member_copy_post") ;
}

function member_move_post(targetId,targetName,targetPath)
{
   var url = getAjaxUrl("org","member_move","userid=" + userId) ;
   $.ajax({
       type: "POST",
       dataType:"json",
       data:{"deptid":nodeId,"targetid":targetId,"targetname":targetName,"dept_path":targetPath},
       url: url,
       success: function(result){
            if (result.status)
            {
				removeRows(userId);
                dialogClose("deptpicker");
            }
            else
            {
            	myAlert(getErrorText(result.errnum));
            }
       }
   });
}

function member_copy_post(targetId,targetName,targetPath)
{
   var url = getAjaxUrl("org","member_copy","userid=" + userId) ;
   $.ajax({
       type: "POST",
       dataType:"json",
       data:{"deptid":nodeId,"targetid":targetId,"targetname":targetName,"dept_path":targetPath},
       url: url,
       success: function(result){
            if (result.status)
            {
                myAlert(langs.text_op_success);
                dialogClose("deptpicker");
            }
            else
            {
            	myAlert(getErrorText(result.errnum));
            }
       }
   });
}






///////////////////////////////////////////////////////////////////////////////////////////
//Org Tree
///////////////////////////////////////////////////////////////////////////////////////////
function getNodeInfo(nodeId)
{
    var arrItem = nodeId.split("_") ;
    var empItem = {viewId:0,empType:0,empId:0} ;
    if (arrItem.length > 3)
    {
        empItem.viewId = parseInt(arrItem[0]) ;
        empItem.empType = parseInt(arrItem[1]) ;
        empItem.empId = parseInt(arrItem[2]) ;
    }
    return empItem ;
}


