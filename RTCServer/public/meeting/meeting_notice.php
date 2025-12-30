<?php
require_once("../class/fun.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/meeting.css" media="screen" />
<script type="text/javascript" src="assets/js/meeting.js"></script>
</head>
<body style="padding-bottom: 70px;">
	<div class="container">
		<div class="panel panel-default" style="margin-top: 70px;">
			<div class="panel-heading">
				<h3><?=PRODUCT_NAME?>会议通知</h3>
			</div>
			<div class="panel-body">
				   <div class="panel-body">
				      <h4 class="text-success meetingname"></h4>
				      <p><span class="text-info">创建时间：</span><span class="meetingtime"></span></p>
				      <p><span class="text-info">创 建 者 ：</span><span class="meetingcreator"></span></p>
					  <p><span class="text-info">与会人员：</span><span class="attenders"></span></p>
				   </div>
			</div>
			<div class="panel-footer bg-info">
				<p class="pull-right">
					<a
						href="" type="button" class="btn btn-success"
					    target="joinframe">加入会议</a>
				</p>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<iframe frameborder="0" width="0" height="0" id="joinframe" name="joinframe"></iframe>
</body>
</html>
<script>
var meetingId = "<?=g("meetingid") ?>";
var userId = "<?=g("userid") ?>";


$(document).ready(function(){
	getMeetingInfo();
})


function getMeetingInfo(){
		   var url = getAjaxUrl("meeting","get_meeting_info","meetingid=" + meetingId + "&userid=" + userId + "&passport=0") ;
		   $.ajax({
			   type: "POST",
			   dataType:"json",
			   url: url,
			   success: function(result){
					$(".meetingname").html(result.meetingname);
					$(".meetingtime").html(result.meetingtime);
					$(".meetingcreator").html(result.meetingcreator);
					$(".attenders").html(result.attenders);
					$(".btn-success").attr("href",result.joinurl);
			   }
		   });
}

</script>