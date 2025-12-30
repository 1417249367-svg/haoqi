<?php  
require_once("../class/fun.php");
$rootPath1 = g("ipaddress",getRootPath1());
?>

<!DOCTYPE html>
<html>
<head>
</head>
<script type="text/javascript">
	var lang = "<?=LANG_TYPE?>";
</script>
<body>
    <form id="form1">
    <div>

    </div>
    </form>
</body>
</html>
<script type="text/javascript" src="getjs/?ipaddress=<?=$rootPath1 ?>&rnd=<?=getAutoId() ?>&op=1" charset="utf-8"></script>