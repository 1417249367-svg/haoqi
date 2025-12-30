<?php
require_once ("include/fun.php");
define ( "MENU", "MANAGE" );


$meeting_server = $_SERVER['SERVER_NAME'] ;
	   
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/meeting.css" />
<script type="text/javascript" src="assets/js/meeting.js?ver=2014110601"></script>
</head>
<body class="body-frame">
	<div class="navbar navbar-inverse navbar-fixed-top navbar-inner"
		id="header">
			<div class="navbar-header">
				<h4>&nbsp;&nbsp;<?=PRODUCT_NAME?>视频会议</h4>
			</div>
	</div>
	<div id="content">
		<div class="container">
			<div id="sidebar">
				<?php  require_once("include/menu.php");?>
			</div>
			<div id="main" data-tmpid="tmpl_list" data-table="tab_meet"
				data-fldid="col_id" data-pagesize="2" data-fldsort="col_createdate desc"
				data-where="" data-fldlist="*">
				<tbody></tbody>
			</div>
		</div>
	</div>
	<script type="text/x-jquery-tmpl" id="tmpl_list">
				<div class="panel panel-default meetinglist " style="margin: 10px; margin-right:80px;" meeting_id="${col_id}" meeting_itemindex="${col_itemindex}" >
				   <div class="panel-body">
				      <h4 class="text-success">${col_name}</h4>
				      <p><span class="text-info">创建时间：</span>${col_createdate}</p>
				      <p><span class="text-info">创 建 者 ：</span>${col_createname}</p>
					  <p><span class="text-info">与会人员：</span><span class="attenders"></span></p>
				   </div>
				   <div class="panel-footer bg-info">
				   		<p class="pull-right">
						  <button id="meeting_btn${col_itemindex}" class="btn btn-danger" onclick="meeting_delete('${col_id}')" style="display:none;">删除会议</button>
						  <a href="upsoft://meeting/?from=meeting2&Name=<?=urlencode(utf8_unicode(CurUser::getUserName())) ?>&Role=1&UID=<?=CurUser::GetUserId() ?>&MID=${col_id}&Account=<?=urlencode(utf8_unicode(CurUser::getLoginName().RTC_DOMAIN)) ?>&MS=<?= $meeting_server?>:<?= MEETING_SERVER_PORT ?>&RS=<?=$meeting_server?>:<?= MEETING_TRANSFER_PORT ?>&PPT=showplay&FS=<?= $meeting_server?>:<?= MEETING_FILE_PORT ?>" type="button" class="btn btn-default btn-sm" target="createframe" >加入会议</a>
						</p>
						<div  class="clear"></div>
				   </div>
				</div>
	</script>
	<iframe frameborder="0" width="0" height="0" id="createframe" name="createframe"></iframe>
</body>
</html>

<script type="text/javascript">
var dataForm ;
var dataList ;
var loginName = "<?= CurUser::getLoginName()?>";

$(document).ready(function(){
	dataList = $("#main").attr("data-where",get_where()).dataList(format_data,listCallBack);
})

function get_where(){
	return "where col_id in (select col_meetid from Tab_Meet_Member where Col_UserID = <?=CurUser::GetUserId() ?>)";
}

function format_data(data) {
	 for (var i = 0; i < data.length; i++) {
         data[i].col_itemindex = i ;
     }
    return data ;
}

</script>

