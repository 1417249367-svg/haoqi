<?php  require_once("include/fun.php");?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/board.css" />
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
				<h4>系统公告</h4>
			</div>
		</div>

		<div class="content">
			<div class="fluent">
				<div id="container_list">
					<!--List--->
					<table id="datalist" class="table table-hover data-list"
						data-tmpid="tmpl_list" data-obj="board" data-table="ant_board"
						data-fldid="col_id" data-fldname="col_subject"
						data-fldsort="col_dt_create desc" data-where=""
						data-fldlist="col_id,col_creator_id,col_creator_name,col_subject,col_attachmentcount,col_clickcount,col_dt_create,col_ispublic,col_creator">
						<thead>
							<tr>
								<!--<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>-->
								<td style="width: 250px" data-sortfield="col_subject">标题</td>
								<td width="80" data-sortfield="col_creator_name">创建人</td>
								<td width="120" data-sortfield="col_dt_create">创建时间</td>
							</tr>
						</thead>
						<tbody class="data-body"></tbody>
					</table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${col_id}" id="${col_id}" col_subject="${col_subject}" col_creator_name="${col_creator_name}" col_dt_create="${col_dt_create}">
							<!--<td><input type="checkbox" name="chk_Id" value="${col_id}"></td>-->
							<td><a href="#"  onclick="show_detail('${col_id}')">${col_subject}</a></td>
							<td>${col_creator_name}</td>
							<td>${col_dt_create}</td>
						</tr>
					</script>

					<!--End List--->
				</div>
				<div id="container_detail" style="display: none; width: 100%;"></div>
			</div>
			<div class="clear"></div>
		</div>


	</div>

	<script type="text/x-jquery-tmpl" id="tmpl_detail">
                    <div class="article">
                      <div class="article-info">
                           <div class="col-left"><button onclick="show_list()" class="btn btn-return"><<返回</button></div>
                           <div class="col-middle"><h4>${col_subject}</h4></div>
                           <ul>
                                <li><b>创建人：</b>${col_creator_name}</li>
                                <li><b>创建时间：</b>${col_dt_create}</li>
                           </ul>

                           <div class="clear"></div>
                      </div>
                      <div class="article-body row-fluid">{col_content}</div>
                    </div>
					</script>
</body>
</html>

<script type="text/javascript">

var query = "loginname=<?=g("loginname") ?>&password=<?=g("password") ?>";
$(document).ready(function(){
	search();
    var abs_height = getInt($(".topbar").height()) + getInt($(".bottombar").height()) ;
    $(".fluent").attr("abs_height",abs_height) ;
	resize();
	window.onresize = function(e){
		resize();
	}
})

function search()
{
    show_list();

    dataList = $("#datalist")
        .attr("data-query", query)
        .dataList(formatData);
}

function show_detail(id)
{
    var html = '<div class="article"><div class="article-info" style="height:40px"><button onclick="show_list()" class="btn btn-return"><<返回</button></div><div class="article-body"><div class="loading">正在加载中</div></div></div>' ;
    $("#container_list").hide();
    $("#container_detail").html(html).show();

    var row = $("#"+ id);
    var data = {col_subject:$(row).attr("col_subject"),col_creator_name:$(row).attr("col_creator_name"),col_dt_create:$(row).attr("col_dt_create")};
    html = $("#tmpl_detail").tmpl(data).html() ;

    var url = getAjaxUrl("board","get_content","id=" + "{" + id + "}") ;

    $.get(url, function(responseText){
        html = html.replace("{col_content}",responseText) ;
        $("#container_detail").html(html)
    });

}

function show_list()
{
    $("#container_list").show();
    $("#container_detail").hide();
}


function formatData(data)
{
	for (var i = 0; i < data.length; i++) {
		data[i].col_id = data[i].col_id.replace("{","").replace("}","");
		data[i].col_dt_create = getLocalTime(data[i].col_dt_create);
	}
	return data ;
}
</script>