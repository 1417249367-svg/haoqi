<?php 
   include('./phpqrcode/phpqrcode.php'); 
   // 二维码数据 
   $data = 'http://www.haoqiniao.cn'; 
   // 生成的文件名 
   $filename = $errorCorrectionLevel.'|'.$matrixPointSize.'.png'; 
   // 纠错级别：L、M、Q、H 
   $errorCorrectionLevel = 'L';  
   // 点的大小：1到10 
   $matrixPointSize = 4;  
   QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);


  
# 创建一个二维码文件 
QRcode::png('code data text', 'filename.png'); 
// creates file 
  
# 生成图片到浏览器 
QRcode::png('some othertext 1234'); 
// creates code image and outputs it directly into browser
?>