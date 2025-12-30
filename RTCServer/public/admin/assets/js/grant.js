function grant_list_init()
{
	dataList = $("#datalist").attr("data-where",get_where()).dataList();
	$("#key").keyup(function(){
		grant_search();
	})
}

function grant_search(){

	dataList.search(get_where()) ;
}

function get_where()
{
	var where = "" ;
    if (_isadmin == 0)
        where = getWhereSql(where, "creatorid='" + _curr_userid + "'" ) ;
    return where ;
}



function grant_edit(_id)
{
	if (_id == undefined)
		dialog("grant",langs.grant_create,"../hs/grant_edit.html" ) ;
	else
		dialog("grant",langs.grant_edit,"../hs/grant_edit.html?id=" + _id ) ;
}



var id = "" ;
function grant_delete(_id)
{
	id = getSelectedId(_id) ;
	if (id == "")
		return ;


	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}




function grant_detail_init()
{

   dataForm = $("#form1").attr("data-id",id).dataForm({getcallback:grant_getCallBack,savecallback:grant_saveCallBack});
   $("#form1").validate({
        submitHandler: function(form) {

            if (valid_data() == false)
                return false ;
                
            dataForm.save();
            return false;
        }
    });
 
    user_search_init($("#user_key"));
}

function valid_data()
{
    var user_id = $("#user_key").attr("real-value") ;
	var dept_info = getDeptDropDownData();
    var dept_id = dept_info.dept_id ;
    
    if ((user_id == "") || (user_id == undefined))
    {
        myAlert(langs.user_select_text);
        return false;
    }
    if ((dept_id == "") || (dept_id == undefined) || (dept_id =="0_0_0" ))
    {
        myAlert(getErrorText("102212"));
        return false ;
    }
 
    $("#userid").val(user_id);
    $("#fcname").val($("#user_key").val());
    //$("#col_emp_type").val(dept_info.emp_type);
    $("#uppeid").val(dept_info.emp_id);
    $("#deptname").val(dept_info.dept_path);
    return true ;
}

function grant_getCallBack(data)
{
	//alert(JSON.stringify(data));
    $("#user_key").attr("real-value",data.userid).val(data.fcname) ;
	
	var dept_id = "1_2_" + data.uppeid ;
	setDeptDropDown(dept_id,data.deptname);
    $("#countuser").val(data.countuser) ;
}

function grant_saveCallBack()
{
	dataList.reload();
	dialogClose("grant");
}


function loadTree()
{
    tree=new dhtmlXTreeObject("container_droptree","100%","100%",0);
    tree.setImagePath("/static/js/dhtmlxtree/img/");
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("org","get_tree","") ;
    
    tree.setXMLAutoLoading(url);
    tree.loadXML(url ,function(){ });

}
 
function loadList()
{
    var container_rows = $("#list") ;
    var cols = $("thead td",container_rows.parent().parent()).length ;
    $(container_rows).html("<tr><td colspan='" + cols + "' class='loading'>" + langs.text_loading + "</td></tr>");
    
    var url = getAjaxUrl("grant","list") ;
    $.getJSON(url, function(data){
        if (data.recordcount==0)
        {
            $(container_rows).html("<tr><td colspan='" + cols + "'>" + langs.text_norecord + "</td></tr>");
        }
        else
        {
            var html = $("#tmpl_list").tmpl(data.rows) ;
            $(container_rows).html(html);
            formatContainer(container_rows);
        }
    });
}

function treeClick()
{
    var dept_id = tree.getSelectedItemId() ;
    
    path = "" ;
    getPath(dept_id) ;

    if (dept_id == "0_0_0")
    {
        path = langs.dept_select ;
        dept_id = "" ;
    }
    $("#btn_dept_select").html(path).attr("real-value",dept_id);
    $("#btn_dept_select").dropdown("toggle");
   

}


var path = "" ;
function getPath(nodeId)
{
    if ((nodeId == undefined) || (nodeId == "") || (nodeId == 0)|| (nodeId == "0_0_0"))
        return  ;

    path = "/" + tree.getItemText(nodeId) + path ;
    path = path.replace("//","/");
    
    getPath(tree.getParentId(nodeId)) ;
}
