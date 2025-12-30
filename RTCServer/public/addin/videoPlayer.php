<?php  
require_once("include/fun.php");
$db = new DB();
$FormFileType = g("FormFileType");
switch ($FormFileType) {
	case 1 :
		$sql = " select * from PtpFile where Msg_ID='" . g("col_id") . "'";
		break;
	case 2 :
		$sql = " select * from LeaveFile where Msg_ID='" . g("col_id") . "'";
		break;
	case 4 :
		$sql = " select * from ClotFile where Msg_ID='" . g("col_id") . "'";
		break;	
}
$row = $db -> executeDataRow($sql);
if (count($row)){
   $onlineid = $row["onlineid"];
   $filpath = $row["filpath"];
}
$row = $db -> executeDataRow("select * from MD5VideoFile where ID = ".$onlineid);
if (count($row)){
	 $filpath = $row["filpath"];
}
if(!$filpath) $filpath = g("name");
if(__ROOT__.'/Data'==RTC_CONSOLE) $url = getRootPath().'/Data/'.$filpath;
else $url = RTC_VIDEO_IP.'/'.$filpath;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>
<video controlsList="nodownload" src="<?=$url ?>" width="100%" height="100%" controls autoplay>your browser does not support the video tag</video>
</body>
</html>
<script type="text/javascript">
document.oncontextmenu = function(){
    event.returnValue = false;
}// 或者直接返回整个事件
document.oncontextmenu = function(){
    return false;
}
</script>
