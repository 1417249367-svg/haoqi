<?php
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
require_once(__ROOT__ . "/class/common/Site.inc.php");
$config_file = "/config.inc.php" ;
$text = "<?php\r\n\r\n?>" ;
writeFileContent($config_file ,$text,0);
//setDBConfig("dm","127.0.0.2","5236","","SYSDBA","Qiyeim.com");
	function setDBConfig($DB_TYPE,$DB_SERVER,$DB_PORT,$DB_NAME,$DB_USER,$DB_PWD)
	{	
//	    $config_content = file_get_contents(__ROOT__ . '/inc/config.ini');
//		$config_content = preg_replace('/(DB_TYPE=[\'"])(.*?)([\'"])/','${1}'.$DB_TYPE.'${3}',$config_content);  
//		if($DB_TYPE=="access"){
//		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}${3}',$config_content);
//		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}seekinfo${3}',$config_content);
//		}else{
//		$config_content = preg_replace('/(DB_SERVER=[\'"])(.*?)([\'"])/','${1}'.$DB_SERVER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PORT=[\'"])(.*?)([\'"])/','${1}'.$DB_PORT.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}'.$DB_USER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}'.$DB_PWD.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_NAME=[\'"])(.*?)([\'"])/','${1}'.$DB_NAME.'${3}',$config_content); 
//	    }
//		file_put_contents(__ROOT__ . '/inc/config.ini',$config_content);
		
	    $content = new SimpleIniIterator(__ROOT__ . '/DataBase.ini');
		$content->setIniValue('DB_TYPE', $DB_TYPE, 'server_connection');
		$content->setIniValue('DB_SERVER', $DB_SERVER, 'server_connection');
		$content->setIniValue('DB_PORT', $DB_PORT, 'server_connection');
		$content->setIniValue('DB_USER', $DB_USER, 'server_connection');
		$content->setIniValue('DB_PWD', $DB_PWD, 'server_connection');
		$content->setIniValue('DB_NAME', $DB_NAME, 'server_connection');
	}
//$item='192.168.2.102';
//$ip = ip2long($item);   
//$arr_ip = explode("-",$item);
//echo $_SERVER['REMOTE_ADDR'];
phpinfo();
//echo __ROOT__;
//获取当前文件所在目录，如果 A.php include B.php 则无论写在哪个文件里，都是表示 A.php 文件所在的目录
echo realpath('.'),'<br>';
echo getcwd(),'<br>';

// 获取当前文件的上级目录，如果 A.php include B.php 则无论写在哪个文件里，都是表示 A.php 文件所在目录的上级目录
echo realpath('..'),'<br>';

// 获取网站根目录，所有文件里面获取的都是当前项目所在的目录
echo $_SERVER['DOCUMENT_ROOT'],'<br>';

// 获取目录信息
$path_parts = pathinfo(__FILE__);
echo 'dirname: ',$path_parts['dirname'],'<br>';//表示代码所在文件的目录，如果 A.php include B.php 并且此代码段写在 B.php ，那么获取的是 B.php 文件所在的目录

echo 'basename: ',$path_parts['basename'],'<br>';//同上，获取的是代码所在的文件的文件名称，比如：inc.php

echo $path_parts['extension'],'<br>';//同上，获取的是代码所在的文件的后缀名，比如：php

echo dirname(__FILE__),'<br>';//效果同 $path_parts['dirname']
echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
exit();
//require_once(__ROOT__ . "/class/common/ThumbHandler.class.php");
////使用实例
////参数说明:
////$arrOri为图片原文件!为了同时处理多张图片设为数组,
////$original_path为源文件的地址,
////$waterd_path为生成水印后的图片地址.
//function markPics($arrOri,$original_path,$watered_path,$duration)
//{
//$Setting['cfg_watermark_wsize'] = '60';
//$Setting['cfg_watermark_words'] = $duration;
//$Setting['cfg_watermark_scale'] = '100';
//$Setting['cfg_watermark_pic'] = 'static/img/video_slide_play.png';
//if(is_array($arrOri))
//{
////数组；
//for($i=0;$i<count($arrOri);$i++)
//{
//$t = new ThumbHandler();
//$t->setSrcImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\4a07fb5b7110fd5189a4ef55bb9ea0f5.png'); //ori file；
//$t->setDstImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\small\4a07fb5b7110fd5189a4ef55bb9ea0f5.png');//masked file
//$t->setMaskFont(__ROOT__.'/static/fonts/simfang.ttf'); //字体
//$t->setMaskFontSize(15);//文字大小
//$t->setMaskWord($duration);//文字；
//$t->setMaskTxtPct(0); //合并度；
//$t->setImgDisplayQuality(9);
//$t->setCutType ( 1 );
//$t->createImg(25); //处理并保存文件；
//
//$t->setSrcImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\small\4a07fb5b7110fd5189a4ef55bb9ea0f5.png'); //ori file；
//$t->setDstImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\small\4a07fb5b7110fd5189a4ef55bb9ea0f5.png');//masked file
//$t->setMaskImg(__ROOT__.'/static/img/video_slide_play.png');
//$t->setMaskImgPct(75); //合并度
//$t->setMaskOffsetX(10);
//$t->setMaskOffsetY(20);
//$t->setMaskPosition(5); //水印位置；
//$t->setImgDisplayQuality(9);
//$t->createImg(100); //处理并保存文件；
//
////$t->setSrcImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\small\4a07fb5b7110fd5189a4ef55bb9ea0f5.png'); //ori file；
////$t->setDstImg('F:\rtc\dbcreate\Data\FileRecv\2\20190728\small\4a07fb5b7110fd5189a4ef55bb9ea0f5.png');//masked file
////$t->setCutType ( 1 );
////$t->createImg ( 25);
//}
//} 
//return true;
//}
//$arrOri = array('4a07fb5b7110fd5189a4ef55bb9ea0f5.png');
//$original_path = "F:\rtc\dbcreate\Data\FileRecv\2\20190728"."\\";
//$watered_path = "F:\rtc\dbcreate\Data\FileRecv\2\20190728\small"."\\";
//$duration = "0:03";
//$result = markPics($arrOri,$original_path,$watered_path,$duration);
//if($result == true)
//{
//echo "success";
//}else{
//echo "faild";
//}
//require_once(__ROOT__ . "/class/common/FileUtil.class.php");
//$fu = new FileUtil();
//$fu->copyDir('D:/RTCServer/Web/Data', 'F:/rtc/pojie/Data');
//		$params = array();
//		$params[] = array("name"=> "access_token","value"=> "12","type"=> "PushConfig");
//		array_push($params,array("name"=> "tokenexpiredtime","value"=> time(),"type"=> "PushConfig"));
//		echo var_dump($params);
//		exit();
//$ch = curl_init();
//$user_name='44454';
//$shop_name='公司梵蒂冈分';
//$url = "http://192.168.2.100:99/services/ChaterUpdate.asp?UName=".urlencode(urlencode($user_name))."&UserName=".urlencode(urlencode($shop_name));
//curl_setopt($ch, CURLOPT_URL, $url); 
//curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//curl_exec($ch); 
//curl_close ($ch);
//echo strpos("You love php, I love php too!","You");
/*如手册上的举例*/
// 			$d = getdate() ;
//			$id = $d[0] ;
//			//echo $id;
// $email = 'user@example.com';
// $domain = !strstr($email, 'gafgh');
// //echo $domain;
//  //echo getValue("departmentpermission").'<br>';
// //echo getValue("department");
// // prints @example.com
//
//$url = $_SERVER['SERVER_NAME']; //填写你要检测的域
//echo $url.'<br>';
//echo is_private_ip($url).'d<br>';
//echo !CheckUrl($url).'d<br>';
//function is_private_ip($ip) { 
//    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE); 
//} 
//
//
////echo !CheckUrl($url).'d'; 
////if(CheckUrl($url)){  
////    echo "域名格式不正确";  }else{  
////    echo "域名格式正确";  }
//	
////检测域名格式  
//function CheckUrl($C_url){  
//    $str="/^(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";  
//    if (!preg_match($str,$C_url)){  
//        return false;  
//    }else{  
//    return true;  
//    }  }
//本地测试的服务名
//$serverName="webrtc.qiyeim.com";
////使用sql server身份验证，参数使用数组的形式，一次是用户名，密码，数据库名
////如果你使用的是windows身份验证，那么可以去掉用户名和密码
//$connectionInfo = array( "UID"=>"sa",
//    "PWD"=>"Zhou8767317",
//    "Database"=>"master");
// 
//$conn = sqlsrv_connect( $serverName, $connectionInfo);
// 
//if( $conn )
//{
//echo "Connection established.\n";
//}
//else
//{
//echo "Connection could not be established.\n";
//die( print_r( sqlsrv_errors(), true));
//}
//$a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow2","df"=>"yellow1");
//$a2=array("e"=>"red","f"=>"green","g"=>"blue");
//
//$result=array_diff($a1,$a2);
//if($result) print_r(current($result));
//$data1 = array();
//
//$k=0;
//for ($k=0; $k<=10; $k++) {
//$data1[$k]['ac'] = $k;
//}
//echo var_dump($data1);
//	function iconv_str($str,$in_charset = 'GBK',$out_charset = 'UTF-8')
//	{
//		return iconv($in_charset,$out_charset. "//IGNORE",$str) ;
//	}
//
//$default_dir = "F:/rtc/data/DownLoad/Public/手机杀菌消毒设备项目采购合同范本最终版.doc";
//
//
////$default_dir = str_replace("\\","/",$default_dir) ;
//$default_dir = iconv_str($default_dir,"utf-8","gbk");
//$md5file = md5_file($default_dir);
//echo $md5file;
//echo PastEtaEx("@周琳d:飞飞飞","周琳");
//$file_name="d\d\f\jk";
//		$arrfile = explode(chr(92),$file_name);
//		echo phpescape("fadfgd");
// 输出个别的 cookie
//if(!getValue("doceditorhelp1")){
//setValue("doceditorhelp1",1,-1);
//echo getValue("doceditorhelp1");
//}
//echo $_COOKIE["TestCookie"];
//echo "<br />";
////echo $HTTP_COOKIE_VARS["TestCookie"];
//echo "<br />";
//
//// 输出所有 cookie
////print_r($_COOKIE);
//$value = "my cookie value";
//
//// 发送一个 24 小时候过期的 cookie
//setcookie("TestCookie",$value, time()+3600*24);
?>
<?php
	//得到根目录
//	function getRootName()
//	{
//		return "/" ;
//	}
//	function setValue($name,$value,$expireTime = 0)
//	{
//		if ($expireTime == 0)
//			$expireTime = time()+3600 ;
//		if ($expireTime == -1)
//			$expireTime = time()+315360000 ;
//
//		$name = "BA-" . $name ;
//		$_SESSION[$name] = $value ;
//		setcookie($name, $value, $expireTime,getRootName());
//	}
//
//	function getValue($name)
//	{
//		$name = "BA-" . $name ;
//		if(isset($_SESSION[$name]))
//			return $_SESSION[$name] ;
//
//		if(isset($_COOKIE[$name]))
//			return $_COOKIE[$name] ;
//		else
//			return "" ;
//	}
//	
//function PastEtaEx($RTB,$fcname)
//{
//  $arrEx = explode ( "@", $RTB );
//  $arrcount=count($arrEx);
//  for ($i=0; $i<$arrcount-1; $i++) {
//	$m=strpos($RTB,"@")+1;
//	$n=strpos($RTB,":")-$m;
//	$TempString=substr($RTB, $m, $n);
//	if(($TempString=="everyone")||($TempString==$fcname)) return 1 ;
//  } 
//  return 0 ;
//}
//
//	function phpescape($str)
//	{         
//	$sublen=strlen($str);
//		  $retrunString="";         
//	for ($i=0;$i<$sublen;$i++)         
//	{                  
//	if(ord($str[$i])>=127)                  
//	{                           
//	$tmpString=bin2hex(iconv("gb2312","ucs-2",substr($str,$i,2)));                           
//	//$tmpString=substr($tmpString,2,2).substr($tmpString,0,2);window下可能要打开此项                           
//	$retrunString.="%u".$tmpString;                           
//	$i++;                  
//	} else 
//	{                           
//	$retrunString.="%".dechex(ord($str[$i]));                  
//	}         
//	}         
//	return $retrunString;
//	}
/**
* 获取服务器端IP地址
 * @return string
*/
//define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
////require_once(__ROOT__ . '/class/PHPExcel/PHPExcel/Reader/Excel2007.php');  
////$objReader = new PHPExcel_Reader_Excel2007;  
////$objPHPExcel = $objReader->load(__ROOT__ ."/static/file/user.xlsx");  
////$sheet = $objPHPExcel->getSheet(0); // 读取第一??工作表
////$highestRow = $sheet->getHighestRow(); // 取得总行数
////$highestColumm = $sheet->getHighestColumn(); // 取得总列数
////  
/////** 循环读取每个单元格的数据 */
////for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
////  for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
////    $dataset[] = $sheet->getCell($column.$row)->getValue();
////    echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
////  }
////} 
//
//require_once __ROOT__ . '/class/PHPExcel/PHPExcel.php';
//require_once __ROOT__ . '/class/PHPExcel/PHPExcel/IOFactory.php';
////$excelHelper = new PHPExcel ();
////$data = $excelHelper->excelToArray(__ROOT__ ."/static/file/user.xls");
//
//
//require_once __ROOT__ . '/class/PHPExcel/PHPExcel/Reader/Excel2007.php';
//require_once __ROOT__ . '/class/PHPExcel/PHPExcel/Reader/Excel5.php';
////include __ROOT__ . '/class/PHPExcel/PHPExcel/IOFactory.php';
//
//$arr = array('1'=>array('name'=>'张三','year'=>'20','sex'=>'男'),  
//              '2'=>array('name'=>'李四','year'=>'25','sex'=>'男'),  
//              '3'=>array('name'=>'王五','year'=>'19','sex'=>'女')   
//             );  
//arrayToExcel($arr);
//function arrayToExcel($data){
//$objPHPExcel = new PHPExcel();
//$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->setTitle('firstsheet');
//$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
//$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
////add data
//$i = 2;
//foreach ($data as $line){
//$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $line['name']);
//$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setDataType('n');
//$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $line['year']);
//$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setDataType('n');
//$i++;
//}
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$file = 'excel.xls';
//$objWriter->save($file);
//}

//echo var_dump($data);
//function excelToArray($file){
//	$objReader = PHPExcel_IOFactory::createReader('Excel5');
//	$objReader->setReadDataOnly(true);
//	$objPHPExcel = $objReader->load($file);
//	$objWorksheet = $objPHPExcel->getActiveSheet();
//	$highestRow = $objWorksheet->getHighestRow();
//	$highestColumn = $objWorksheet->getHighestColumn();
//	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
//	$excelData = array();
//	for ($row = 2; $row <= $highestRow; ++$row) {
//		for ($col = 0; $col <= $highestColumnIndex; ++$col) { $excelData[$row][] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
//		}
//	}
//	return $excelData;
//}
//phpinfo();
//$power=-1;
//$op=2;
//$can = (($power & $op) == $op) ? 1:0;
//echo ($power & $op) == $op;
//$server = '(local)';
//$user = 'sa';
//$pass='seekinfo';
//$dbname='rtcdbms';
////if(sqlsrv_connect($server, array('UID' => $user ,'PWD'=> $pass, 'Database' => $dbname)))
////{ 
////    echo "成功"; 
////} 
////else 
////{ 
////    echo "失败"; 
////} 
//		$conn = mssql_connect($server,$user,$pass);
//		if(!$conn)
//		{
//			recordLog("connect database error");
//			return ;
//		}
?>