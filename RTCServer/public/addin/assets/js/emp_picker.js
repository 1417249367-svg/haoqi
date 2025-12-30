/*自定义变量*/
var select_emp_mode = 2 ; //1支持部门发送    2支持部门自动钩选人员   3只支持选择人员
var field_data = "col_mobile"
var field_name = "手机号码" ;
	
	
var tree_org,tree_my,tree_group ;
var usersearch_field_search,usersearch_field_list ;


/**
 * 人员选择控件初始化  树初始化  搜索控件初始化
 */
function emp_picker_init()
{
	usersearch_field_list = "col_id,col_name," + field_data + " as col_data" ;
	usersearch_field_search = "col_name," + field_data  ;


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


/**
 * 树初始化
 */
function usertree_init(container_id)
{
	var tree = get_tree_obj(container_id);
	tree = new dhtmlXTreeObject(container_id + "_tree" ,"100%","100%",0);
	tree.setImagePath(TREE_IMAGE_PATH);
	tree.setOnClickHandler(function(){usertree_click(tree)});

	var url = getAjaxUrl("sms","get_orgtree","loaduser=1&field_data=" +  field_data + "&passport=0" ) ;

	if (container_id == "container_group")
		url += "&viewtype=" + viewtype_group;

	if (container_id == "container_my")
		url += "&viewtype=" + viewtype_owner + "&ownerid=" + owner_id;
//document.write(url);
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
					    usercontainer_add(currId,tree.getItemText(currId)) ;
				    else
				        $(".user[data-id=" + currId + "]").remove();
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

/**
 * 点击的情况
 * @param tree
 */
function usertree_click(tree)
{
	var nodeId = tree.getSelectedItemId() ;
	var nodeText = tree.getSelectedItemText() ;
	var arr_item = nodeId.split("_");

	if (arr_item[1] == "0")
		return ;

    //
	if (select_emp_mode > 1)
	{
	    if (arr_item[1] != "1")
		    return ;
    }
	usercontainer_add(nodeId,nodeText);
}

/**
 * 搜索控件初始化
 */
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
			return item["col_name"] + " (" + item["col_data"] + ")" ;
		},
		setValue:function(item){
			return {'data-value':item["col_name"] + " (" + trim(item["col_data"]) + ")",'real-value':"0_1_" + item["col_id"]};
		},
		select:function(dataVal,realVal){
	        usercontainer_add(realVal,dataVal);
		}
	})
}

