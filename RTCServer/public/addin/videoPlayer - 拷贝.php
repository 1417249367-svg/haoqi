<?php  
	require_once("include/fun.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>
<video src="<?=getRootPath() ?>/public/cloud.html?op=getfile&loginname=<?=g("loginname") ?>&password=<?=g("password") ?>&label=msg&name=<?=g("name") ?>" width="100%" height="100%" controls autoplay>your browser does not support the video tag</video>
</body>
</html>