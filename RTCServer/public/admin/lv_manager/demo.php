<?php  
require_once("../include/fun.php");
require_once(__ROOT__ . "/config/config.inc.php");
$rootPath1 = g("ipaddress",getRootPath1());
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
<script type="text/javascript">
	var lang = "<?=LANG_TYPE?>";
</script>
</head>
<body>
<script>
var _rtckf = _rtckf || [];
(function() {
  var kf = document.createElement("script");
  kf.src = "<?=getRootPath() ?>/livechat/getjs/?ipaddress=<?=getAppValue("ipaddress")?>";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(kf, s);
  })();
</script>
</body>


</html>

