<?php  
	require_once("include/fun.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
</head>
<body>
    <!-- windows media player 仅ie支持（ie7/i7+） 这个classid很关键，ie靠这个识别对象的实现应用 -->
    <object id="video" class="video" border="0" classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95">
        <param name="ShowDisplay" value="0">
        <param name="ShowControls" value="1">
        <param name="AutoStart" value="1">
        <param name="AutoRewind" value="0">
        <param name="PlayCount" value="0">
        <param name="Appearance" value="0">
        <param name="BorderStyle" value="0">
        <param name="MovieWindowHeight" value="240">
        <param name="MovieWindowWidth" value="320">
        <param name="FileName" value="<?=getRootPath() ?>/Data/<?=g("name") ?>">
    </object>
</body>
</html>