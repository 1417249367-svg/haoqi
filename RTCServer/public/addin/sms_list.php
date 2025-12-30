<?php  

	require_once("include/fun.php");
	ob_clean();
	$db = new DB();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/sms.css" />
	<script type="text/javascript" src="assets/js/sms.js"></script>
</head>
<body>
	<ul id="tabs" class="nav nav-tabs">
		<li><a href="sms_send.html?<?=$_SERVER["QUERY_STRING"] ?>"><span class="icon_mail">发送短信</span></a></li>
		<li class="active"><a href="sms_list.html?<?=$_SERVER["QUERY_STRING"] ?>" ><span class="icon_mail_history">短信历史记录</span></a></li>
	</ul> 
	
	<div id="view_list" class="fluent">
	    <div class="padding">
				<!--List--->
				<table  id="datalist" class="table table-striped table-hover data-list"  data-tmpid="tmpl_list"  data-table="RTC_SMS" data-fldid="col_id" data-fldsort="col_id desc" data-fldsortdesc="col_id asc" data-where=""  data-fldlist="col_id,col_recv_name,col_content,col_status,col_send_time,col_creator_name">
				  <thead>
					<tr>
					  <td data-sortfield="col_id" style="width:60px">ID</td>
					  <td data-sortfield="col_recv_name" style="width:250px">接收者</td>
					  <td data-sortfield="col_content">内容</td>
					  <td data-sortfield="col_status" style="width:80px">状态</td>
					  <td data-sortfield="col_send_time" style="width:150px">发送时间</td>
					  <td data-sortfield="col_creator_name" style="width:80px">发送者</td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

				<script type="text/x-jquery-tmpl" id="tmpl_list">
					<tr class="row-${col_id}" id="user_${col_id}">
						<td>${col_id}</td>
						<td>${col_recv_name}</td>
						<td>${col_content}</td>
						<td><div class="status-${col_status}">${col_status_name}</div></td>
						<td>${col_send_time}</td>
						<td>${col_creator_name}</td>
					</tr>
				</script>
				<!--End List--->
		</div>
	</div>
	
	<div class="pagebar"></div>
 
</body>
</html>


<script type="text/javascript">

    var dataList ;
	var _lang = "<?=LANG_TYPE?>";
    
	var usercontainer = $("#container_users");
    $(document).ready(function(){
        dataList = $("#datalist").attr("data-where",get_where()).dataList(formatData);
		
		var abs_height = 58 + 40 ;
		$("#view_list").attr("abs_height",abs_height) ;

		
		resize();
		window.onresize = function(e){
			resize();
		}
		
    })
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            if (data[i].col_status == 0)
                data[i].col_status_name = "失败" ;
            else if (data[i].col_status == 1)
                data[i].col_status_name = "成功" ;
        }
        return data ;
    }
    
    function get_where()
    {
 	    var where = "" ;
	    where = getWhereSql(where, "col_creator_id=<?=CurUser::GetUserId() ?> " ) ;
        return where ;
    }
    
</script>
 