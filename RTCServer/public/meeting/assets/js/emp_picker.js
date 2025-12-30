var tree_org,tree_my,tree_group ;
var select_emp_mode = 2 ;
var usersearch_field_search = "col_name,col_loginname,col_mobile" ;
var usersearch_field_list = "col_id,col_name,col_loginname,col_mobile" ;
var usertree_field_user = "col_name";
function emp_picker_init()
{
	$("#tabs_viewport li").click(function(){
		$("#tabs_viewport li").removeClass("active");
		$(this).addClass("active");

		$("#tabs_viewport li").each(function(){
			$("#" + $(this).attr("for")).hide();
		})


		var container_id = $(this).attr("for") ;
		if ($("#" + container_id + " .tree").html() == "")
			usertree_init(container_id);
		$("#" + container_id).show();

	})

	usersearch_init();
	$("#tabs_viewport a:eq(0)").click();
}


///////////////////////////////////////////////////////////////////////////////////
// User Tree
///////////////////////////////////////////////////////////////////////////////////
function usertree_init(container_id)
{
	var tree = get_tree_obj(container_id);
	tree = new dhtmlXTreeObject(container_id + "_tree" ,"100%","100%",0);
	tree.setImagePath(TREE_IMAGE_PATH);
	tree.setOnClickHandler(function(){usertree_click(tree)});
	usertree_field_user = replaceAll(usertree_field_user,"+","%2B");
	var url = getAjaxUrl("meeting","get_orgtree","loaduser=1&field_user=" +  usertree_field_user ) ;

	if (container_id == "container_group")
		url += "&viewtype=" + viewtype_group;

	if (container_id == "container_my")
		url += "&viewtype=" + viewtype_owner + "&ownerid=" + owner_id;

	tree.setXMLAutoLoading(url);
	if (select_emp_mode == 2)
	{
	    tree.enableCheckBoxes(1);
	    tree.enableThreeStateCheckboxes(true) ;
    }
	tree.loadXML(url);

	if (select_emp_mode == 2)
	{
	    tree.setOnCheckHandler(function(id,isCheck){
		    var ids = tree.getAllSubItems(id) ;
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
					    usercontainer_add(arrItem[2],arrItem[5],tree.getItemText(currId)) ;
				    else
				        $(".user[data-id=" + arrItem[2] + "]").remove();
			    }
		    }

	    })
    }
}

function get_tree_obj(container_id)
{
	switch(container_id)
	{
		case "container_org":
			return tree_org ;
		case "container_my":
			return tree_my ;
		case "container_group":
			return tree_group ;
		default:
			return tree_org ;
	}
}


function usertree_click(tree)
{
	var nodeId = tree.getSelectedItemId() ;
	var nodeText = tree.getSelectedItemText() ;
	var arr_item = nodeId.split("_");

	if (arr_item[1] == "0")
		return ;

	if (select_emp_mode > 1)
	{
	    if (arr_item[1] != "1")
		    return ;
    }
	usercontainer_add(arr_item[2],arr_item[5],nodeText);
}

///////////////////////////////////////////////////////////////////////////////////
// User Search
///////////////////////////////////////////////////////////////////////////////////

//��ѯ
function usersearch_init()
{

	$('#userkey').autocomplete({
		source:function(query,process){
			var matchCount = this.options.items;
			var url = getAjaxUrl("user","search","field_search=" + usersearch_field_search + "&field_list=" + usersearch_field_list) ;
			$.getJSON(url,{"key":query,"top":matchCount},function(respData){
				return process(respData.rows);
			});


		},
		formatItem:function(item){
			return item["col_name"];
		},
		setValue:function(item){
			return {'data-value':item["col_name"],'real-value':item["col_id"] + "_" + item["col_loginname"]};
		},
		select:function(dataVal,realVal){
			var arr_Item=realVal.split("_");
	        usercontainer_add(arr_Item[0],arr_Item[1],dataVal);
		}
	})
}

