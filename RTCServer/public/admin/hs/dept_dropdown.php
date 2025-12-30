    <div class="btn-group">
      <div class="btn btn-default dropdown-toggle" data-toggle="dropdown"><div id="btn_dept_select" class="dropdown-btn" style="width:300px; display:block ; text-align:left;float:left;"><?=get_lang("btn_sel_dept")?></div></div>
      <div class="dropdown-menu" id="container_dept">
            <div id="container_droptree" class="container-tree" style="height:300px;width:325px;"></div>
       
      </div>
    </div>
    
<script type="text/javascript">

$(document).ready(function(){
	
	loadDeptDropDownTree();
	
    $("#container_dept").click(function(e){
        e.stopPropagation();
    })
})

/*
method set value
return {"dept_id":"4_4_1_0_0","dept_path":"/a/a-1","emp_type":4,"emp_id":1}
*/
function getDeptDropDownData()
{
	var dept_id = $("#btn_dept_select").attr("real-value") ;
	var dept_path = $("#btn_dept_select").html() ;
	if (dept_id == undefined)
		dept_id = "" ;
	if (dept_id == "")
		dept_path = "" ;
	
	var emp_type = 0 ;
	var emp_id = 0 ;
	var emp_item = dept_id.split("_") ;	
	if (emp_item.length>3)
	{
		emp_type = emp_item[1] ;
		emp_id = emp_item[2] ;
	}
	
	return {"dept_id":dept_id,"dept_path":dept_path,"emp_type":emp_type,"emp_id":emp_id} ;
}

/*
method set value
*/
function setDeptDropDown(dept_id,dept_path)
{
	$("#btn_dept_select").attr("real-value",dept_id).html(dept_path) ;	
}

/*
method load tree
*/
function loadDeptDropDownTree()
{
    treeDropDown = new dhtmlXTreeObject("container_droptree","100%","100%",0);
    treeDropDown.setImagePath("/static/js/dhtmlxtree/img/");
    treeDropDown.setOnClickHandler(treeDropDownClick);
    var url = getAjaxUrl("org","get_tree","") ;
    treeDropDown.setXMLAutoLoading(url);
    treeDropDown.loadXML(url ,function(){ });

}

/*
method tree click
*/
function treeDropDownClick()
{
    var dept_id = treeDropDown.getSelectedItemId() ;
    var dept_path = getTreePath(treeDropDown,dept_id) ;


    if (dept_id == "0_0_0")
    {
        dept_path = langs.dept_select ;
        dept_id = "" ;
    }
    $("#btn_dept_select").html(dept_path).attr("real-value",dept_id);
    $("#btn_dept_select").dropdown("toggle");
}



</script>