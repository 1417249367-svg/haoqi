<?php  
//http://127.0.0.1:8000/addin/board_list.html?loginname=ZS@aa&password=e10adc3949ba59abbe56e057f20f883e
	require_once("include/fun.php");
	$db = new DB();
	
	$dt1 = g("dt1");
	$dt2 = g("dt2");
	$key = g("dt1");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/board.css" />
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
</head>
<body>

    <!--[if lte IE 6]>
    <style>
        .table td{padding:5px;}
        .data-pager{margin:auto;}
    </style>
    <![endif]-->
<div>
    
    <div class="topbar">
        <div class="searchbar" id="searchbar">
                <div class="pull-left">
                    <button type="button" class="btn btn-default" action-type="board_edit"><?=get_lang('btn_release')?></button>
                </div>
                <div class="pull-right">
                <label class="pull-left mr"><?=get_lang("label_search_range")?>：</label>
				<input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="<?=$dt1?>" data-date-format="yyyy-mm-dd"  style="width:150px;">
				<span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang("label_to")?></span>
				<input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="<?=$dt2 ?>" data-date-format="yyyy-mm-dd" style="width:150px;">
            	<input type="text" id="key" value="<?=$key ?>" class="form-control pull-left mr" style="width:150px;" />
<input type="button" id="btn_search" value="<?=get_lang("btn_search")?>" class="btn pull-left" onclick="search()"  />
				</div>
                <div class="clear"></div>
        </div>
    </div>

	<div class="content">
        <div class="ctree  fluent">
            <div id="container_tree" class="fluent" ></div>
        </div>
        <div class="clist">
			<div class="fluent">
                <div id="container_list">
				<!--List--->
                    <table  id="datalist"  class="table table-hover data-list" drawpage="0" data-obj="board" data-tmpid="tmpl_list"  data-table="ant_board" data-fldid="col_id" data-fldname="col_subject"  data-fldsort="col_dt_create desc" data-where=""  data-fldlist="col_id,col_creator_id,col_creator_name,col_subject,col_attachmentcount,col_clickcount,<?=$db -> getSelectDateField("col_dt_create")?>,col_ispublic,col_creator">
                        <thead>
                            <tr>
								<!--<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>-->
                                <td style="width:250px" data-sortfield="col_subject"><?=get_lang("label_title")?></td>
                                <td width="80" data-sortfield="col_creator_name"><?=get_lang("label_create_user")?></td>
                                <td width="120" data-sortfield="col_dt_create"><?=get_lang("label_create_time")?></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${col_id} readed-${col_readed}" id="${col_id}" col_subject="${col_subject}" col_creator_name="${col_creator_name}" col_dt_create="${col_dt_create}">
							<!--<td><input type="checkbox" name="chk_Id" value="${col_id}"></td>-->
							<td><a href="javascript:void(0);"  onclick="show_detail('${col_id}')">${col_subject}</a></td>
							<td>${col_creator_name}</td>
							<td>${col_dt_create}</td>
						</tr>
					</script>

				<!--End List--->
				</div>
				<div id="container_detail" style="display:none;width:100%;">
                </div> 
			</div>
			<div class="bottombar pagebar" style="height:30px">
			</div>
				
        </div> 
        <div class="clear"></div>
    </div> 
    

</div>

					<script type="text/x-jquery-tmpl" id="tmpl_detail">
                    <div class="article">
                      <div class="article-info">
                           <div class="col-left"><button onclick="show_list()" class="btn btn-return"><<<?=get_lang("btn_return")?></button></div>
                           <div class="col-middle"><h4>${col_subject}</h4></div>
                           <ul>
                                <li><b><?=get_lang("label_create_user")?>：</b>${col_creator_name}</li>
                                <li><b><?=get_lang("label_create_time")?>：</b>${col_dt_create}</li>
                           </ul>
                           
                           <div class="clear"></div>
                      </div>
                      <div class="article-body">{col_content}</div>
                    </div>
					</script>
					
<?php  require_once("include/footer.php");?>
</body>
</html>

<script type="text/javascript">

var query = "loginname=<?=g("loginname") ?>&password=<?=g("password") ?>" ;
var lang_type = "<?=LANG_TYPE?>"
var dataList ;
var boardId = "<?=g("boardId") ?>"; 

var appPath = "<?=getRootPath() ?>"; 
$(document).ready(function(){

    loadTree() ;
	
    var abs_height = getInt($(".topbar").height())  ;
    $(".fluent").attr("abs_height",abs_height) ;
	resize();
	window.onresize = function(e){
		resize();
	}
})



function loadTree()
{
    tree=new dhtmlXTreeObject("container_tree","100%","100%",0);
    tree.setImagePath(TREE_IMAGE_PATH);
    tree.setOnClickHandler(treeClick);
	
	//var url = getAjaxUrl("org","get_tree_all","passport=0") ;
	
	//20150806 改为按权限查看
    var url = getAjaxUrl("org","get_tree1","passport=0&aceflag=2") ;

    tree.setXMLAutoLoading(url);
    tree.loadXML(url ,function(){$(".standartTreeRow").eq(2).click(); });
}


function treeClick()
{
    
    var nodeId = tree.getSelectedItemId() ;
	var nodeText = tree.getSelectedItemText() ;
	
    search(nodeId)
}

function get_where()
{
    var where = "" ;

   where = get_date_sql("col_dt_create",$("#dt1").val(),$("#dt2").val(),where) ;  
        
    var key = $("#key").val();
    if (key != "")
        where = getWhereSql(where, " col_subject like '%" + key + "%'");
          
    return where ;
}

function search(nodeId)
{
    if (nodeId == undefined)
        nodeId = "" ;
        
    show_list();
    
    var where = get_where();

    dataList = $("#datalist")
        .attr("data-query","nodeid=" + nodeId + "&" + query)
        .attr("data-where",where)
        .dataList(formatData,listCallBack);
}

function formatData(data)
{
	for (var i = 0; i < data.length; i++) {
		data[i].col_dt_create = data[i].col_dt_create;
		data[i].col_id = data[i].col_id.replace("{","").replace("}","");
	}
	return data ;
}

function listCallBack(rows,recordcount)
{
	var param = dataList.param();
	drawPager($(".pagebar"),param.pageindex,param.pagesize,recordcount,"page");
	//if(boardId) show_detail(boardId);
}

function page(pageIndex,pageSize)
{
    if (pageIndex == undefined)
        pageIndex = parseInt($("#txt_PageIndex").val()) ;
    if (pageSize == undefined)
        pageSize = parseInt($("#txt_PageSize").val()) ;
		
	if (isNaN(pageIndex) || isNaN(pageSize))
	{
		myAlert("<?=get_lang("text_pagenum_error")?>");
		return ;
	}
	
	dataList.param().pagesize = pageSize ;
	dataList.page(pageIndex);
}
	
function show_detail(id)
{
    var html = '<div class="article"><div class="article-info" style="height:40px"><button onclick="show_list()" class="btn btn-return"><<<?=get_lang("btn_return")?></button></div><div class="article-body"><div class="loading">正在加载中</div></div></div>' ;
    $("#container_list").hide();
    $("#container_detail").html(html).show();
    var row = $("#"+ id);
    var data = {col_subject:$(row).attr("col_subject"),col_creator_name:$(row).attr("col_creator_name"),col_dt_create:$(row).attr("col_dt_create")};
    html = $("#tmpl_detail").tmpl(data).html() ;
    
    var url = getAjaxUrl("board","get_content","id=" + id ) ;
	//document.write(url);
    $.get(url, function(responseText){
        html = html.replace("{col_content}",responseText) ; 
        $("#container_detail").html(html) ;
		formatMsgContent($("#container_detail"));
    }); 

}

function show_list()
{
    $("#container_list").show();
    $("#container_detail").hide();
}

function board_edit(id)
{

	if (id == undefined)
		dialog("board",langs.board_create,"board_edit.html") ;
	else
		dialog("board",langs.board_edit,"board_edit.html?id=" + id ) ;
}
 
	
//function copyUrl() 
//{ 
//	$("#texturl").select(); // 选择对象 
//	document.execCommand("Copy"); // 执行浏览器复制命令 
//	alert(langs.board_list_code_bulid_tip); 
//}
</script>