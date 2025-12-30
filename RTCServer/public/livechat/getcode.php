<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/livechat/include/fun.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once (__ROOT__ . "/livechat/include/meta.php");?>
</head>
<body style="overflow:hidden;">
</body>
</html>

<script type="text/javascript">
  $(document).ready(function()
  {
	 var url = getAjaxUrl("livechat_kf","getcode") ;
	 var param = {"query":"<?=$_SERVER['QUERY_STRING']?>"} ;
	 //document.write(url+JSON.stringify(param));
    $.getJSON(url,param, function(result){
		alert(JSON.stringify(result));
        location.href = result.msg ;
    }); 
  })
</script>