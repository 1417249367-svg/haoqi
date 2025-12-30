 

function danwei_init(){
 
    var html_showfields = "" ;
    var html_searchfields = "" ;
    
    $("#datalist thead [data-col]").each(function(){
        var isshow  = ! $(this).is(":hidden") ;
        var fieldCode = $(this).attr("data-col") ;
        var fieldName = $(this).html() ;
        
        html_showfields += "<li class='" + (isshow?"checked":"")+ "' data-col='" + fieldCode + "'><label><input type='checkbox' " + (isshow?"checked":"")+ " > " + fieldName + "</label></li>" ;
        
        if ((fieldCode != "fullname") && (fieldCode != "shortname"))
            html_searchfields += "<option value='" + fieldCode + "'>" + fieldName + "</option>" ;

    })
    
    
    //init table header dropdown-menu
    $("#menu_showfields").html(html_showfields);
    $("#menu_showfield input[type=checkbox]").click(function(){
        var isshow = $(this).hasClass("checked") ;
        var col = $(this).attr("data-col") ;
        if (isshow)
        {
            $("td[data-col=" + col + "]").hide()
            $(this).removeClass("checked");
            
        }
        else
        {
            $("td[data-col=" + col + "]").show()
            $(this).addClass("checked");
        }
    })
    
    
    //init search field
    $("#search_field").html(html_searchfields);
    $("#search_field").prepend("<option value='fullname,shortname'>全称/简称</option>");
    
    
    $("#key").keyup(function(){
        search();
    })
    
   
    tree=new dhtmlXTreeObject("container_tree","100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("danwei","get_areatree","root=1") ;
    tree.setXMLAutoLoading(url);
    tree.loadXML(url ,function(){$(".standartTreeRow").eq(2).click(); });
    
}

function treeClick()
{
    var areaId =  tree.getSelectedItemId();
    
    path = getTreePath(tree) ;
    path = path.replace("全部地区/","");
    
    var where = "" ;
    if (parseInt(areaId) > 0)
    {
        //where = getWhereSql(where,"areaId=" + areaId  ) ;
        where = getWhereSql(where,"area like '" + path + "%'" ) ;
    }

    $("#datalist").attr("data-where",where);
    
    if (dataList == undefined)
        dataList = $("#datalist").dataList();
    else
        dataList.search(where);
}


function search(){
    var where = "" ;
    var key =  $("#key").val() ;

    if (key != "")
        where = getWhereSql(where,getLikeSQL($("#search_field").val(),key)) ;

    var areaId =  tree.getSelectedItemId();
    if (parseInt(areaId) > 0)
        where = getWhereSql(where,"areaId=" + areaId ) ;
        
    dataList.search(where) ;
}


function danwei_edit(id)
{
    var query = "" ;
    if (id == undefined)
    {
        var nodeId = tree.getSelectedItemId() ;
        var nodeText = getTreePath(tree) ;
        var rootName = "全部地区" ;
        if (nodeText.indexOf(rootName) > -1)
        {
            nodeText = nodeText.replace(rootName,"") ; //remove root name
            if (nodeText != "")
                nodeText = nodeText.substring(1,nodeText.length);
        }
        if (nodeText != "")
            query = "areaId=" + nodeId + "&areaName=" + escape(nodeText) ;
    }
    else
    {
        query = "id=" + id ;
    }   
    var title = (id == ""?"新增单位":"修改单位") ;
    var url = "../exls/danwei_edit.html?" + query ;

    dialog("danwei",title ,url,{width:800}) ; 
}

function danwei_delete(id)
{
    if (confirm("你确定要删除吗?"))
        dataList.del(id) ;
}

function set_area()
{
    var ids = getCheckValue("chk_Id") ;
    if (ids == "")
    {
        myAlert("请选择单位") ;
        return ;
     }
    dialog("set","设置地区","set_area.html?ids=" + ids) ;
}
function set_public()
{
    var ids = getCheckValue("chk_Id") ;
    if (ids == "")
    {
        myAlert("请选择单位") ;
        return ;
     }
    dialog("set","设置公有属性","set_field.html?ids=" + ids) ;
}
function set_private()
{
    var ids = getCheckValue("chk_Id") ;
    if (ids == "")
    {
        myAlert("请选择单位") ;
        return ;
     }
    dialog("set","设置自定义属性","set_field.html?type=2&ids=" + ids) ;
}


function area_loadtree()
{
    tree=new dhtmlXTreeObject("tree","100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("danwei","get_areatree","") ;
    tree.loadXML(url ,function(){ });
}

function area_edit(id)
{
    var nodeId = tree.getSelectedItemId() ;
    
    if ((id != undefined ) && ( parseInt(id)<1))
    {
    	myAlert("请选择地区") ;
        return ;
    }
    if (nodeId == "")
    {
    	myAlert("请选择上级地区");
        return ;
    }
    area_edit_dialog(nodeId,id) ;
}

function area_edit_dialog(parentNodeId,id)
{
    if (id == undefined)
        id = "" ;
    var title = (id == ""?"新增地区":"修改地区") ;
    var path = getTreePath(tree).replace("全部地区/","") ;
    
    if (parentNodeId == undefined)
        nodeId = 0 ; 
    else
        nodeId = parentNodeId;
    var url = "../exls/area_edit.html?parentareaid=" + nodeId  + (id == ""?"":"&areaId=" + id ) +"&path=" + path  ;
    url += "&ord=" + ($("#datalist tbody tr").length) ;
    
   
    dialog("area",title ,url) ;
}

function area_edit_post(areaId,areaName,op)
{
    if (op == "create")
       tree.insertNewItem(nodeId,areaId,areaName,0,"folder.png","folder.png","folder.png","");
    else
       tree.setItemText(nodeId,areaName);
    dialogClose("area");
}

function area_delete(id)
{
    if (id == undefined)
    {
    	myAlert("请选择要删除的地区");
        return ;
    }

    if (confirm("你确定要删除吗?") == false)
        return ;
        
   var url = getAjaxUrl("danwei","area_delete","") ;
 
   $.ajax({
       type: "POST",
       dataType:"json",
       data:{areaId:id,area:path},
       url: url,
       success: function(result){
            if (result.status)
            {
                tree.deleteItem(id,true);
            }
            else
            {
                myAlert(result.error);
            }
       }
   });         
}


function grant_add()
{
    
    var userId = $("#key").attr("real-value") ;
    var areaId = $("#btn_area_select").attr("real-value") ;
    var areaName = $("#btn_area_select").html();

    if (isNaN(parseInt(userId)))
    {
        myAlert(langs.user_select_text);
        return ;
    }
    
    areaId = parseInt(areaId) ;
    if ((isNaN(areaId)) || (areaId<=0))
    {
        myAlert("请选择授权的地区");
        return ;
    }


   var url = getAjaxUrl("areapower","add") ;
   $.ajax({
       type: "POST",
       dataType:"json",
       data:{userId:userId,areaId:areaId,areaName:areaName},
       url: url,
       success: function(result){
            if (result.status)
            {
                dataList.reload();
            }
            else
            {
            	myAlert(getErrorText(result.error));
            }
       }
   }); 
    
}

function grant_delete(id)
{
   var url = getAjaxUrl("areapower","delete","id=" + id) ;
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(result){
            if (result.status)
            {
                $("#" + id).fadeOut();
            }
            else
            {
            	myAlert(getErrorText(result.error));
            }
       }
   }); 
    
}