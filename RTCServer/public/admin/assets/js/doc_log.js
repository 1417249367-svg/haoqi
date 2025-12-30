var rootId = 0 ;
var path = "" ;
var nodeId = "" ;
var nodeText = "" ;
var op = "" ;

function loadTree(container_id)
{
    tree=new dhtmlXTreeObject(container_id,"100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
    var url = getAjaxUrl("cloud","get_root_log","root_id=0&root_type=1&isroot=1") ;
	//document.write(url);
    tree.setXMLAutoLoading(url);
    tree.loadXML(url ,function(){$(".standartTreeRow").eq(2).click(); });
}

function dir_select()
{
    nodeId = tree.getSelectedItemId() ;
	nodeText = tree.getSelectedItemText() ;
    if (nodeId == "")
    {
    	myAlert(langs.doc_dir_require);
        return false ;
    }
    return true ;
}

function dir_delete()
{
    if (dir_select() == false)
        return ;

    var arrNode = nodeId.split("_");

	var msg = langs.doc_dir_delete_confirm.replace("{dir}",nodeText) ;
	if (confirm(msg))
    {
        dir_delete_post(nodeId);
    }
}

function dir_delete_post()
{
   var url = getAjaxUrl("docdir","delete","id=" + nodeId) ;
   //document.write(url);
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(result){
            if (result.status)
                tree.deleteItem(nodeId,true);
            else
                myAlert(langs.doc_dir_delete_fail);
       }
   }); 
}

function dir_edit()
{
    if (dir_select() == false)
        return ;
	var arrNode = nodeId.split("_") ;
	
//	if (arrNode[2] == 0)
//		root_edit(arrNode[1]);
//	else
		folder_edit(nodeId);
}

function root_create()
{
	root_edit();
}
function root_edit(id)
{
	op = (id == undefined)?"create":"edit";
	if (op == "create")
		dialog("root",langs.doc_root_create,"root_edit.html?parentid=0") ;
	else
		dialog("root",langs.doc_root_edit,"root_edit.html?id=" + id ) ;
}


function root_savecallback(data)
{
	var name = $("#usname").val();
	if (op == "create")
	{
		//var id = "102_" + data.id + "_0_0_" + data.id ; 
		tree.insertNewItem("0",data.id,name,0,"folder.png","folder.png","folder.png");
	}
	else
	{
		tree.setItemText(nodeId,name);
	}
	dialogClose("root");
}


function folder_create()
{
	folder_edit();
}

function folder_edit(id)
{
	op = (id == undefined)?"create":"edit";
	//alert(objparentId);
	if (op == "create")
		dialog("folder",langs.doc_dir_create,"folder_edit.html?parentid=" + objId) ;
	else
		dialog("folder",langs.doc_dir_edit,"folder_edit.html?id=" + id ) ;
}


function folder_savecallback(data)
{
	var name = $("#usname").val();
	var arrParent = nodeId.split("_") ;
	//alert(name+"|"+JSON.stringify(data));

	if (op == "create"){
	    //tree.insertNewItem("0",data.id,name,0,"folder.png","folder.png","folder.png");
		tree.insertNewItem(nodeId,data.id,name,0,"folder.png","folder.png","folder.png");
		//tree.refreshItem(nodeId);
		treeClick();
	}else
		tree.setItemText(nodeId,name);
		
	dialogClose("folder");
}
	
///////////////////////////////////////////////////////////////////////////////////////////
//doc_download
///////////////////////////////////////////////////////////////////////////////////////////
function doc_download(item_id,e)
{
	if (e != undefined)
	{
		if($(e).attr("disabled"))
			return ;
	}

	var url = get_download_url(item_id) ;
	doc_download_go(url) ;
}


function get_download_url(id)
{
	var doc_item = $("#" + id);
	var url = "&name=" + escape($(doc_item).attr("data-target"))+ "&filename=" +  escape($(doc_item).attr("data-name")) + "&myid=public&label=msg"  ;
	//myAlert(url);
	url = "/public/cloud.html?op=getfile&" + url ;
	return url ;
	
}

function doc_download_go(url)
{
	frm_Upload.location.href = url ;
}
