<?php
	$fileName = $_FILES['file']['name'];
	$type = $_FILES['file']['type'];
	$size = $_FILES['file']['size'];
	$fileAlias = $_FILES["file"]["tmp_name"];

	$fileTypes = array('asp','php'); // File extensions
	$fileParts = pathinfo($fileName);
	if (in_array($fileParts['extension'],$fileTypes)) return false;
	if($fileAlias){
		move_uploaded_file($fileAlias, "uploadfile/" . $fileName);
	}
	echo 'fileName: ' . $fileName . ', fileType: ' . $type . ', fileSize: ' . ($size / 1024) . 'KB';
?>