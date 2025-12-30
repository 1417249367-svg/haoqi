<?php  require_once("fun.php");?>
<?php
/*
 * 生成二维码
 * 2014-12-22
 */

include __ROOT__ . "/vendor/phpqrcode/qrlib.php";

$errorCorrectionLevel = g ( "ecc", "H" ); // ECC L/M/Q/H
$matrixPointSize = g ( "size", "5" ); // Size 1~10
$text = g ( "text", "test" ); // 二维码的内容
if(g ( "logo" )) $logo = RTC_CONSOLE . "/" . g ( "logo" );
$filename = g ( "filename", microtime().'.png' ); // 存放的地址

if (g ( "encode" ) == 1)
	$text = js_unescape ( $text );

$folder = RTC_CONSOLE . "/" . date("Ymd",getAutoId()) . "/qrcode/";
$filename = $folder . $filename;

mkdirs ( $folder );

recordLog ( "qrcode:" . $text );
QRcode::png ( $text, $filename, $errorCorrectionLevel, $matrixPointSize, 2 );


$QR = $filename;      //已经生成的原始二维码图
if (file_exists($logo)) {
  $QR = imagecreatefromstring(file_get_contents($QR));    //目标图象连接资源。
  $logo = imagecreatefromstring(file_get_contents($logo));  //源图象连接资源。
  $QR_width = imagesx($QR);      //二维码图片宽度
  $QR_height = imagesy($QR);     //二维码图片高度
  $logo_width = imagesx($logo);    //logo图片宽度
  $logo_height = imagesy($logo);   //logo图片高度
  $logo_qr_width = $QR_width / 4;   //组合之后logo的宽度(占二维码的1/5)
  $scale = $logo_width/$logo_qr_width;  //logo的宽度缩放比(本身宽度/组合后的宽度)
  $logo_qr_height = $logo_height/$scale; //组合之后logo的高度
  $from_width = ($QR_width - $logo_qr_width) / 2;  //组合之后logo左上角所在坐标点
  //重新组合图片并调整大小
  /*
   * imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
   */
  imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
  imagepng($QR, $filename);
  imagedestroy($QR);
  imagedestroy($logo);
}


  
$printer = new Printer ();
$printer->out_img ( $filename );

?>    