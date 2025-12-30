



///////////////////////////////////////////////////////////////////////////////////
// User Tree
///////////////////////////////////////////////////////////////////////////////////
function usertree_init(container_id)
{
	tree=new dhtmlXTreeObject(container_id,"100%","100%",0);
	tree.setImagePath(TREE_IMAGE_PATH);
	tree.setOnClickHandler(usertree_click);
	var url = getAjaxUrl("org","get_tree","loaduser=1&isadmin=0") ;
	tree.setXMLAutoLoading(url);
	tree.loadXML(url ,function(){$(".standartTreeRow").eq(2).click(); });
}

function usertree_click()
{
	var nodeId = tree.getSelectedItemId() ;
	var nodeText = tree.getSelectedItemText() ;
	var arr_item = nodeId.split("_");
	if (arr_item[1] != "1")
		return ;
	usercontainer_add(nodeId,nodeText);
}

///////////////////////////////////////////////////////////////////////////////////
// User Search
///////////////////////////////////////////////////////////////////////////////////

//查询
function usersearch_init()
{
	$('#userkey').autocomplete({
		source:function(query,process){
			var matchCount = this.options.items;
			var url = getAjaxUrl("org","search") ;
			$.getJSON(url,{"key":query,"top":matchCount},function(respData){
				return process(respData.rows);
			});
			
		},
		formatItem:function(item){
			return item["name"] + " (" + item["loginname"] + ")" ;
		},
		setValue:function(item){
			return {'data-value':item["name"],'real-value':item["id"] + "@@@" + item["name"] };
		}
	});
}

//添加查询数据
function usersearch_add()
{
	var real_value = $("#userkey").attr("real-value") ;
	if ((real_value == "") || (real_value == undefined))
	{
		myAlert(langs.user_select_text);
		return ;
	}
	
	var arrItem = real_value.split("@@@");
	usercontainer_add(arrItem[0],arrItem[1]);
}



///////////////////////////////////////////////////////////////////////////////////
// User Container
///////////////////////////////////////////////////////////////////////////////////
var usercontainer ;

//容器清空
function usercontainer_clear()
{
    $(usercontainer).html("") ;
}

//容器添加
function usercontainer_add(user_id,user_name)
{
    if (user_id == "")
        return ;
		
	
	if ($("[data-id='" + user_id + "']",usercontainer).html() != undefined)
	{
		//myAlert("人员【" + user_name + "】已经存在");
		return ;
	}
		
    var html = "" ;
    html +='<li data-id="' + user_id + '" data-name="' + user_name + '">' ;
    html += '<span>' + user_name + '</span>' ;
    html += '<i onclick="usercontainer_delete(this)"></i>' ;
    html +='</li>' ;
    

    $(usercontainer).append(html) ;
}

function usercontainer_delete(e)
{
    $(e).parent().remove();
    event.stopPropagation();
}

//容器得到的数据
//{ids:,names:}
function usercontainer_get()
{
    var id = "" ;
    var name = "" ;
    $("li",usercontainer).each(function(){
       
        id += (id ==""?"":",") + $(this).attr("data-id") ;
        name += (name ==""?"":",") + $(this).attr("data-name");

    })
    return {id:id,name:name} ;
}


