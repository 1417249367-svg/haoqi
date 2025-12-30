<?php
/**
 * 网站的常用操作

 * @date    20140325
 * jc 2014-12-05  create_guid,  fliterTreeText(dhtmlxtree)
 */


define("EMP_USER",	1) ;  		//用户
define("EMP_DEPT",	2) ;		//部门
define("EMP_ROLE",	3) ;		//角色
define("EMP_VIEW",	4) ; 		//视图
define("EMP_GROUP",	4) ;		//群组
define("EMP_ADDIN",	10) ;		//插件
define("EMP_INTERFACE",	11) ;	//接口

define("VIEWTYPE_DEFAULT",	1) ;
define("VIEWTYPE_OWNER",	2) ;
define("VIEWTYPE_GROUP",	8) ;

define("DOC_FILE",	100) ;		//文档目录
define("DOC_DownLoad",	103) ;
define("DOC_LeaveFile",	104) ;
define("DOC_ROOT",	102) ;		//文档根目录
define("DOC_VFOLDER",	105) ;	//文档目录
define("DOC_OnlineFILE",	106) ;		//文档目录

//20150522 日志存放到网站上级目录
$runtime_dir = dirname(__ROOT__) . "/runtime" ;
mkdirs($runtime_dir . "/sessions");
@session_save_path ( $runtime_dir . "/sessions" );
@session_start ();

$sysconfig_file = __ROOT__ . "/config/sysconfig.inc.php" ;
$arrSysConfig = include ($sysconfig_file);

function js_unescape($str) {
	$ret = '';
	$len = strlen ( $str );
	for($i = 0; $i < $len; $i ++) {
		if ($str [$i] == '%' && $str [$i + 1] == 'u') {
			$val = hexdec ( substr ( $str, $i + 2, 4 ) );
			if ($val < 0x7f)
				$ret .= chr ( $val );
			else if ($val < 0x800)
				$ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
			else
				$ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
			$i += 5;
		} else if ($str [$i] == '%') {
			$ret .= urldecode ( substr ( $str, $i, 3 ) );
			$i += 2;
		} else
			$ret .= $str [$i];
	}
	return $ret;
}

function js_unescape1($str) {
    $str = rawurldecode($str);
    preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U", $str, $r);
    $ar = $r[0];
    foreach ($ar as $k => $v) {
        if (substr($v, 0, 2) == "%u") {
            $restr = substr($v, -4);
            if (!eregi("WIN", PHP_OS)) {
                $restr = substr($restr, 2, 2) . substr($restr, 0, 2);
            }
            $ar[$k] = iconv("UCS-2", "UTF-8", pack("H4", $restr));
        } elseif (substr($v, 0, 2) == "&#") {
            $ar[$k] = iconv("UCS-2", "UTF-8", pack("n", substr($v, 2, -1)));
        }
    }
    return join("", $ar);
}

function g($name, $defaultValue = "") {
	// php这里区分大小写，将两者都变为小写
	$_GET = array_change_key_case ( $_GET, CASE_LOWER );
	$name = strtolower ( $name );

	$v = isset ( $_GET [$name] ) ? $_GET [$name] : "";
	if ($v == "") {
		$_POST = array_change_key_case ( $_POST, CASE_LOWER );
		$v = isset ( $_POST [$name] ) ?$_POST [$name] : "";
	}

		if ($v == "")
			return $defaultValue;
		else
		{
			// 20141011 jc :  js_unescape($v)会引起 where ( col_subject like '%123%' ) 会变成 where ( col_subject like '%3%' )
			//$v =  js_unescape($v) ;
			$v = trim($v);
			return $v;
		}

	}



	function f($name,$defaultValue = "")
	{
		return g($name,$defaultValue) ;
	}
	
	function gi($name,$defaultValue = "")
	{
		return iconv_str(g($name,$defaultValue),"gbk","utf-8") ;
	}

	//生成ID，如果没有表名的话，安时间生成
 	function getAutoId($tableName = "",$fieldId = "")
	{
		if (($tableName != "") && ($fieldId != ""))
		{
			$sql = " select max(" . $fieldId . ") as c from " . $tableName ;
			$db = new DB();
			$id = $db -> executeDataValue($sql) ;
			return (empty($id)?0:$id) + 1 ;
		}
		else
		{
			//毕免短时间同样
			sleep(1);
			$d = getdate() ;
			$id = $d[0] ;
			return $id ;
		}

	}

	/*
	method:是否存在
	param:$values jc,zwz,wwy
	param:$value jc
	return: true/false
	*/
	function isIn($values,$value,$sp = ",")
	{
		$values = $sp . $sp . $values . $sp ; //两个sp ,防止 pos=0 return false ;
		$value = $sp . $value . $sp ;
		return strpos($values,$value) ;
	}

	//写文件
//	function writeFileContent($file_path,$content,$append = 1)
//	{
//		//得到文件的路径
//		$dir = substr($file_path,0,strrpos($file_path,"\\"));
//
//		if(!file_exists($dir))
//		   mkdirs($dir);
//
//		$file = fopen($file_path,($append?"a":"w"));
//		fwrite($file,$content);
//		fclose($file);
//	}
	
	function writeFileContent($file_path,$content,$append = 1)
	{
		//格式化路径
		$file_path = str_replace("\\","/",$file_path);
		
		//得到目录
		$file_dir = dirname($file_path) ;

		//创建目录
		if(!file_exists($file_dir))
		   mkdirs($file_dir);

		//写入文件
		$file = fopen($file_path,($append?"a":"w"));
		fwrite($file,$content);
		fclose($file);
	}

	//读取文件内容
	function readFileContent($file_path)
	{
		if(!file_exists($file_path))
		   return "" ;

    	$content = file_get_contents($file_path);

		//BOM的问题
		if (strlen($content)>3)
		{
			if(ord(substr($content,0,1)) == 239 && ord(substr($content,1,1)) == 187 && ord(substr($content,2,1)) == 191)
				$content = substr($content,3) ;
		}

		return $content ;
	}
	
	/*
	method	读取INI 文件
	return	array(name=>value)
	*/
	function readInitFile($file_path)
	{
    	if (! file_exists($file_path))
        	return array();
    	$content = readFileContent($file_path);
    	return str2array($content, "\r\n", "=");
	}

	

	function removeBOM($str)
	{
	}

	//读取XML文件到数组
	// 返回 array
	function readXMLFile($file_path)
	{
		//读取文件内容
		$content = readFileContent($file_path);

		//转换成XML
		return readXMLContent($content);
	}

	//根据标签得到XML的内容 <name>jc</name>     $tag=name  return jc
	function getXMLValue($data,$tag)
	{
		$tag = strtoupper($tag);
		foreach($data as $item)
		{
			if ($item["tag"] == $tag)
				return $item["value"] ;
		}
		return "" ;
	}

	function readXMLContent($xml_content)
	{
		error_reporting(0);
		//转换成XML
		$values = array();
		$doc = xml_parser_create();
		xml_parse_into_struct($doc, $xml_content, $values);
		xml_parser_free($doc);

		return $values;
	}

	//将字符串转换成数组   id|1,name|jc
	//{"id"=>"1","name"=>"jc"}
	function str2array($str,$sp_item = "," ,$sp_cell = "|",$isKeyLower = 0 )
	{
		$result = array();
		$items = explode($sp_item,$str);
		foreach($items as $item)
		{
			$pos = strpos($item,$sp_cell);
			if ($pos)
			{
				$key = substr($item,0,$pos);
				if ($isKeyLower)
					$key = strtolower($key);
				$value = substr($item,$pos+1);
				$result[$key] = $value ;
			}
		}
		return $result ;
	}

	//将一维数组转化为字符串
	function array2str($arr , $sp_item = "," )
	{
		$str ="";
		foreach($arr as $key=>$value)
		{
			if($str == "")
				$str =$value;
			else
				$str .= $sp_item . $value;
		}
		return $str;
	}
	
	/*
	method	得到列表中的某个对象
	param	$list:array(array,...)
	param	$key:string path
	return	array(aa,bb)
	*/
	function list2array($list,$key)
	{
		if (! $list)
			return array();

		$arr = array();
		foreach($list as $item)
		{
			
			$arr[] = $item[$key] ;
		}
		
		return $arr ;	
	}
	
	
	/*
	method	根据$key，返回$list
	param	$list:array(array,...)
	param	$key:string path
	return	array(aa,bb)
	*/
	function array2list($arr,$list,$key)
	{
		if (! $list)
			return array();
			
		$new_list = array();
		foreach($list as $item)
		{
			foreach($arr as $value)
			{
				if ($item[$key] == $value)
					$new_list[] = $item ;
			}
		}
		return $new_list ;
	}


	//记录到日志，支持string,array
	function recordLog($log)
	{
		global $runtime_dir;
		
		if (! DEBUG)
			return ;


		//格式化内容
		$content = $log ;
		if(is_array($log))
		{
			foreach ($log as $key => $value)
			{
				$content = $key . " => " . $value . ",";
			}
		}

        $content = "[" . getNowTime() . "]:" . $content;

		//生成文件
		$dt = getdate();
		$file_name = $dt["year"] . "-" . $dt["mon"] . "-" . $dt["mday"] . ".txt" ;
		$file_name = $runtime_dir . "/log/" . $file_name ;
		$dir_name=dirname($file_name);

		if(!file_exists($dir_name))
		   mkdirs($dir_name);
		   
		//写入文件
		$file = @fopen($file_name,"a");
		@fwrite($file,$content . "\r\n");
		@fclose($file);
	}


	//================================================================
	//删除目录(包括子文件夹与文件)
	//================================================================
	function deldir($dir) {
	   if (! is_dir($dir))
			return false ;
	   //先删除目录下的文件：
	   $dh=opendir($dir);
	   while ($file=readdir($dh)) {
		 if($file!="." && $file!="..") {
		   $fullpath=$dir."/".$file;
		   if(!is_dir($fullpath)) {
			   unlink($fullpath);
		   } else {
			   deldir($fullpath);
		   }
		 }
	   }

	   closedir($dh);
	   //删除当前文件夹：
	   if(rmdir($dir)) {
		 return true;
	   } else {
		 return false;
	   }
	 }

	///////////////////////////////////////////////////////////////////////////////
	//自动递归创建目录
	///////////////////////////////////////////////////////////////////////////////
	function mkdirs($dir)
	{

		//$dir = iconv_str($dir,'utf-8', 'gbk');  递归多次 iconv_str 中文会有问题 jc 2014-12-9
		if(!is_dir(iconv_str($dir,'utf-8', 'gbk')))
		{
			if(!mkdirs(dirname($dir)))
				return false;

		 	$dir = iconv_str($dir,'utf-8', 'gbk');

		 	if(!mkdir($dir,0777))
				return false;
			else
				@chmod($dir,0777);
		}
		return true;
	}


	//得到根目录
	function getRootName()
	{
		return "/" ;
	}
	//得到根目录
	function getRootPath()
	{
//		$url =  'http://'.$_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];
//		return $url ;
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		return $http_type . $_SERVER['HTTP_HOST']; 

	}
	
	function getRootPath1()
	{
		$url =  'http://'.$_SERVER['SERVER_NAME'] . ":97";
		return $url ;
	}

	function setValue($name,$value,$expireTime = 0)
	{
		if ($expireTime == 0)
			$expireTime = time()+3600 ;
		if ($expireTime == -2)
			$expireTime = 0 ;
		if ($expireTime == -1)
			$expireTime = time()+315360000 ;

		$name = "BA-" . $name ;
		$_SESSION[$name] = $value ;
		setcookie($name, $value, $expireTime,getRootName());
	}

	function getValue($name)
	{
		$name = "BA-" . $name ;
		if(isset($_SESSION[$name]))
			return $_SESSION[$name] ;

		if(isset($_COOKIE[$name]))
			return $_COOKIE[$name] ;
		else
			return "" ;
	}
	

	function phpEscape1($str) {
		return str_replace('\\', '%', substr(json_encode($str), 1, -1));
	}


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
	
	function phpescape($str){//这个是加密用的
		preg_match_all("/[\xc2-\xdf][\x80-\xbf]+|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}|[\x01-\x7f]+/",$str,$newstr);
		$ar = $newstr[0];
		foreach($ar as $k=>$v){
			if(ord($ar[$k])>=127){
				$tmpString=bin2hex(iconv("utf-8","ucs-2",$v));
				if (!preg_match('/WIN/i',PHP_OS)){
					$tmpString = substr($tmpString,2,2).substr($tmpString,0,2);
				}
				$reString.="%u".$tmpString;
			} else {
				$reString.= rawurlencode($v);
			}
		}
		return $reString;
	}
	
//	function phpescape3($str){
//		$sublen=strlen($str);
//		$reString="";
//		for ($i=0;$i<$sublen;$i++){
//			if(ord($str[$i])>=127){
//				$tmpString=bin2hex(iconv("GBK","ucs-2",substr($str,$i,2)));    //此处GBK为目标代码的编码格式，请实际情况修改
//	
//				if (!eregi("WIN",PHP_OS)){
//					$tmpString=substr($tmpString,2,2).substr($tmpString,0,2);
//				}
//				$reString.="%u".$tmpString;
//				$i++;
//			} else {
//				$reString.="%".dechex(ord($str[$i]));
//			}
//		}
//		return $reString;
//	}

	function unescape($str){
		$ret = '';
		$len = strlen($str);
		for ($i = 0; $i < $len; $i++){
		if ($str[$i] == '%' && $str[$i+1] == 'u'){
		$val = hexdec(substr($str, $i+2, 4));
		if ($val < 0x7f) $ret .= chr($val);
		else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
		else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
		$i += 5;
		}
		else if ($str[$i] == '%'){
		$ret .= urldecode(substr($str, $i, 3));
		$i += 2;
		}
		else $ret .= $str[$i];
		}
		return $ret;
	}

	//取余，自带会出现负数
	function kmod($bn, $sn)
	{
		return intval(fmod(floatval($bn), $sn));
	}

	//将IP转为数字
	function ip2num($ip)
	{
		$arr_ip = explode(".",$ip);
		if (count($arr_ip) != 4)
			return 0 ;
		$ip0 = $arr_ip[0] * (256*256*256) ;
		$ip1 = $arr_ip[1] * (256*256) ;
		$ip2 = $arr_ip[2] * (256) ;
		$ip3 = $arr_ip[3] ;
		return $ip0 + $ip1 + $ip2 + $ip3 ;
	}

	//将数字转为IP
	function num2ip($ip)
	{
		$ip0 = intval($ip / (256*256*256)) ;
		$ip = kmod($ip,(256*256*256)) ;

		$ip1 = intval($ip / (256*256)) ;
		$ip = kmod($ip,(256*256)) ;

		$ip2 = intval($ip / 256) ;
		$ip = kmod($ip,256) ;

		return $ip0 . "." . $ip1  . "." . $ip2 . "." . $ip ;
	}

 	function getNowTime()
	{
		return date("Y-m-d H:i:s") ;
	}

	//$utcTime string
	//return string
	function getLocalTime($utcTime,$timeZone = 8)
	{
		$time = strtotime($utcTime);
		$time = $time +  ($timeZone * 60 * 60);
		return date("Y-m-d H:i:s",$time) ;
	}

	function dateAdd($time,$hour)
	{
		$time = strtotime($time);
		$time = $time +  ($hour * 60 * 60);
		return date("Y-m-d",$time) ;
	}


    /**
     * 将EMPID解析成数组
	 * $id  viewid_emptype_empid_parenttype_parentid_empname
	 * return array("viewid"=>"0","emptype"=>"0","empid"=>"0","parent_emptype"=>"0","parent_empid"=>"0","empname"=>"") ;
     */
    function getEmpInfo($id)
    {
		$result = array("viewid"=>"0","emptype"=>"0","empid"=>"000000","parent_emptype"=>"0","parent_empid"=>"0","empname"=>"");

		if (($id == "") || empty($id))
			return $result ;

		$arr = explode("_",$id) ;	// to array


        if (count($arr) >= 3)
        {
			$result["viewid"] = $arr[0] ;
			$result["emptype"] = $arr[1] ;
			$result["empid"]=$arr[2]+1000000;
			$result["empid"]=substr($result["empid"],-6);
			if (isset($arr[3]))
				$result["parenttype"] = $arr[3] ;
			if (isset($arr[4])){
				$result["parentid"]=$arr[4]+1000000;
			    $result["parentid"]=substr($result["parentid"],-6);
			}
			if (isset($arr[5]))
				$result["empname"] = $arr[5] ;
		}
		return $result ;
    }

    /**
     * 生成EMPID
	 * return viewid_emptype_empid_parenttype_parentid_empname
     */
	function getEmpId($viewId,$empType,$empId,$parentEmpType = 0,$parentEmpId = 0 ,$loginName = "")
	{
		$loginName = trim($loginName);
		return  $viewId . "_" . $empType . "_" . $empId . "_" . $parentEmpType . "_" . $parentEmpId  . "_" . $loginName ;
	}


    /**
     * 生成ARRAY
     */
	function getArray($values,$keys)
	{
		$arr = array();
		if (($values == "") && ($keys == ""))
			return $arr ;
		$arr_value = explode(",",$values) ;
		$arr_key = explode(",",$keys) ;
		$i = 0 ;
		while($i<count($arr_value))
		{
			if (isset($arr_key[$i]))
				$arr[$arr_key[$i]] = $arr_value[$i] ;
			else
				$arr[$i] = $arr_value[$i] ;
			$i++ ;
		}
		return $arr ;
	}

	function array_value_index($value,$arr)
	{
		for($i=0;$i<count($arr);$i++)
		{
			if ($arr[$i] == $value)
			{
				return $i ;
			}
		}
		return -1 ;
	}

	//将表格的列合并，并用,号分隔
	function table_column_tostring($data,$column_name,$sp = ",")
	{
		$values = "" ;
		foreach($data as $row)
		{
			$values .= ($values?$sp:"") . $row[$column_name] ;
		}
		return $values ;
	}

	// executeDataTable表格的列是重复的，index fieldname
	// mode 0 保留列  index  mode  1  保留  fieldname
	function table_fliter_doublecolumn($table, $mode = 0) {
		$table_new = array ();
		foreach ( $table as $key=>$row ) {
			$table_new[$key] = row_fliter_doublecolumn($row, $mode);
		}
		return $table_new;
	}

	// executeDataRow表格的列是重复的，index fieldname
	// mode
	function row_fliter_doublecolumn($row, $mode = 0) {

	    $table_new = array ();
		$i = 0;
		foreach ( $row as $key => $val ) {
			if ($mode == 0 && $i % 2 == 0)
				$table_new [$key] = $val;
			else if ($mode == 1 && $i % 2 == 1) {
				$table_new [$key] = $val;
			}
			$i ++;
		}

		return $table_new;
	}


	function getSizeExp($size)
	{
    	$mod = 1024;
    	$units = explode(' ','KB KB MB GB TB PB');
    	for ($i = 0; $size > $mod; $i++) {
        	$size /= $mod;
    	}
    	return round($size, 2) . ' ' . $units[$i];
	}


	function getWhereSQL($sql,$where)
	{
		if ($where == "")
			return $sql;
		if ($sql == "")
			$sql = " where " . $where ;
		else
			$sql = $sql . " and " . $where ;
		return $sql ;
	}

	function println($str = "")
	{
		print $str . "<br>";
	}

	//数组编码转换
	function iconv_array($arr,$in_charset = 'GBK',$out_charset = 'UTF-8')
	{
		foreach($arr as $key => $value)
		{
			$value = iconv($in_charset,$out_charset. "//IGNORE",$value) ;
			$arr[$key] = $value ;
		}
		return $arr ;
	}

	function iconv_str($str,$in_charset = 'GBK',$out_charset = 'UTF-8')
	{
		if(strtoupper(substr(PHP_OS,0,3)) == "WIN") return $str ;
		else return iconv($in_charset,$out_charset. "//IGNORE",$str) ;
		
	}


	//用来存放数组与查询
	$hash = array();
	function hash_clear()
	{
		global $hash ;
		$hash = array();
	}

	function hash_add($key,$value)
	{
		global $hash ;
		$hash[$key] = $value ;
	}

	function hash_get($key)
	{
		global $hash ;
		foreach($hash as $curr_key=>$curr_value)
		{
			if ($curr_key == $key)
				return $curr_value ;
		}

		return "null" ;
	}


	define("KEY_REG",	"2B9i7g1A14n20t") ; //注册表密码的KEY
	define("KEY_HL","!@3*(DPOdccd&*") ; 	//中心互联密码的KEY
	function DBPwdEncrypt($password,$key = "2B9i7g1A14n20t")
	{
		$ascom =  new COM("ASCom.AntServerCtrl") ;
		$password = $ascom -> DBPwdEncrypt($password,$key);
		return $password ;
	}

	function DBPwdDecrypt($password,$key = "2B9i7g1A14n20t")
	{
		$ascom =  new COM("ASCom.AntServerCtrl") ;
		$password = $ascom -> DBPwdDecrypt($password,$key);
		return $password ;
	}

	//
	function MyMD5($password)
	{
		$ascom =  new COM("ASCom.AntServerCtrl") ;
		return $ascom -> MyMD5($password);
	}

	function rtf2html($rtf)
	{
		$ascom =  new COM("ASCom.AntServerCtrl") ;
		$html = $ascom -> RTF2HTML($rtf);
		$html = iconv_str($html) ;
		return $html;
	}

	//将关系表转为路径格式
	//$data:	array(array("id"=>"1","name"=>"a","parent_id"=>"0"),array("id"=>"2","name"=>"b","parent_id"=>"1"))
	//return:	添加一列 path  a/b
	function relation2path($data)
	{
		foreach($data as $key=>$row)
		{
			$path = get_path($data,$row["id"]) ;
			$data[$key]["path"] = $path;
		}
		return $data ;
	}

	//将关系表转为路径格式  从子向根查找
	//$data:	array(array("id"=>"1","name"=>"a","parent_id"=>"0"),array("id"=>"2","name"=>"b","parent_id"=>"1"))
	//$id:		2
	//$return:	a_b
	function get_path($data,$id,$path = "" )
	{
		foreach($data as $row)
		{
			if ($row["id"] == $id)
			{
				$path =  $row["name"] . ($path?"/":"") . $path ;
				return get_path($data,$row["parent_id"],$path) ;
			}
		}
		return $path;
	}
	
	
	$temp = array();
	/*
	method	得到关系数据中的子孙(递归)
	param	$data array(array("id"=>"1","name"=>"a","parent_id"=>"0"),...)
	return	array(array("id"=>"1","name"=>"a","parent_id"=>"0"),...)
	*/
	function relation_child($data,$parent_id)
	{
		global $temp ;
		$temp = array();
		get_child($data,$parent_id);
		return $temp ;
	}
	
	/*
	method	得到关系数据中的子孙(递归)
	*/
	function get_child($data,$parent_id)
	{
		global $temp ;
		foreach($data as $row)
		{
			println($row["parent_id"] . ":" . $parent_id);
			if ($row["parent_id"] == $parent_id)
			{
				$temp[] = $row ;
				get_child($data,$row["id"]) ;
			}
		}
	}

	function valid_column_length($table,$len)
	{
		foreach($table as $row)
		{
			if (count($row)<$len)
				return 0 ;
		}
		return 1 ;
	}


	function print_table($data)
	{
		foreach($data as $row)
		{
			print_r($row);
			print("<br>");
		}

	}

	function get_page_count($record_count,$page_size)
	{
		$page_count = intval($record_count / $page_size) ;
		if (($record_count % $page_size)>0)
			$page_count = $page_count + 1 ;
		return $page_count ;
	}

	//生成guid  type  0  不带花括号   其他
	function create_guid($type=0) {
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$hyphen = chr(45);             // "-"
		$guid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
		if($type==1)
			return chr(123) . $guid . chr(125) ;
		return $guid;
	}

	//过滤树特殊字符
	function fliterTreeText($str)
	{
		$chars = explode(",","#,',\",&,?,+,:") ;
		foreach($chars as $char)
			$str = str_replace($char,"",$str) ;
		return $str ;
	}

	//文件系统的编码是GBK，所以这在边封装一下
	function file_copy($source_file,$target_file)
	{
		$source_file = format_path($source_file);
		$target_file = format_path($target_file);

		if (file_exist($source_file))
		{
			//判断文件夹是否存在，不存在创建
			$dir = substr($target_file,0,strrpos($target_file,"/")) ;
			mkdirs($dir);
			copy(iconv_str($source_file,"utf-8","gbk"),iconv_str($target_file,"utf-8","gbk")) ;
			return 1 ;
		}
		else
		{
			return 0 ;
		}
	}

	//文件系统的编码是GBK，所以这在边封装一下
	function file_delete($file_path)
	{
		$file_path = format_path($file_path);

		if (file_exist($file_path))
		{
			unlink(iconv_str($file_path,"utf-8","gbk")) ;
			return 1 ;
		}
		else
		{
			return 0 ;
		}
	}

	function file_exist($file_path)
	{
		$file_path = iconv_str($file_path,"utf-8","gbk");
		return file_exists($file_path);
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	//读取数据流
	//$content_type   application/octet-stream image/jpg
	//jc 2014-12-19
	////////////////////////////////////////////////////////////////////////////////////////////////
	function file_read_stream($file_path,$content_type = "application/octet-stream",$file_name = "")
	{
		$file = fopen($file_path.$file_name,"r"); // 打开文件
		ob_clean();
		Header("Content-type:" . $content_type);
		if ($content_type == "application/octet-stream")
		{
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($file_path.$file_name));
			Header("Content-Disposition: attachment; filename=" . $file_name);
		}
		while(!feof($file)) {
			echo fgets($file, 4096);
		}
		//echo fread($file,filesize($file_path.$file_name));
		fclose($file);
		exit();
	}
	
	function file_read_stream1($file_path,$content_type = "application/octet-stream",$file_name = "",$typepath)
	{
		$file = fopen($file_path.$file_name,"r"); // 打开文件
		ob_clean();
		Header("Content-type:" . $content_type);
		if ($content_type == "application/octet-stream")
		{
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($file_path.$file_name));
			Header("Content-Disposition: attachment; filename=" . $typepath);
		}
		while(!feof($file)) {
			echo fgets($file, 4096);
		}
		//		echo fread($file,filesize($file_path.$file_name));
		fclose($file);
		exit();
	}
	
	function file_read_stream2($file_path,$content_type = "application/octet-stream",$file_name = "",$typepath)
	{
		$file = fopen($file_path.$file_name,"r"); // 打开文件
		ob_clean();
		Header("Content-type:" . $content_type);
		if ($content_type == "application/octet-stream")
		{
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($file_path.$file_name));
			Header("Content-Disposition: attachment; filename=" . rawurlencode($typepath));
		}
		while(!feof($file)) {
			echo fgets($file, 4096);
		}
		//		echo fread($file,filesize($file_path.$file_name));
		fclose($file);
		exit();
	}

	function format_path($file_path)
	{
		$file_path = str_replace("\\","/",$file_path);
		//$file_path = iconv_str($file_path,"utf-8","gbk");
		return $file_path;
	}

	function getDBType()
	{
		switch (strtolower(DB_TYPE))
		{
			case "mssql":
				return 1;
			case "mysql":
				return 6;
			case "oracle":
				return 3;
			case "mariadb":
				return 7;
			default:
				return 1;
		}
	}

	//去除单位ID
	function removeDomain($loginname)
	{
	    $pos = strpos($loginname,"@");
	    if ($pos > 0)
	        return substr($loginname,0,$pos);
	    return $loginname ;
	}
	
	/*
	method:发送http post数据
	param:$post_data 发送数据 array('var1'=>'abc','var2'=>'how are you , my friend??');
	*/
	function send_http_post($url,$post_data = array(), $timeout = 5)
	{
		$log = $url ;
		foreach($post_data as $key=>$value)
			$log .= "&" . $key . "=" . $value ;
		recordLog("HTTP_POST:" . $log);

	
        $ch = curl_init(); 
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		// https请求 不验证证书和hosts
 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_POST, 1); 
        if($post_data != ''){ 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
        } 
		
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
        curl_setopt($ch, CURLOPT_HEADER, false); 
		
        $file_contents = curl_exec($ch); 
        curl_close($ch); 
		
        return $file_contents; 

	}

	//发送http请求,支持https
	function send_http_request($url,$timeout="",$reTry=0)
    {
		recordLog("HTTP_SEND:" . $url);
		
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        if($timeout != "") {
            curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
        }

	    $result = curl_exec ( $ch );
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        //失败后重试
        if($reTry >0 && $httpCode != 200)
        {
		
        }
        curl_close($ch);
	    return $result;
	}

	//语言函数
	function get_lang($key,$param1="",$param2="",$param3="",$param4="",$param5=""){
	    Global $arrLang;
	    $str = isset($arrLang[$key]) ? $arrLang[$key] : "";
	    if($param1 != "")
	    {
	        $str = str_replace("%1", $param1, $str);
	        $str = str_replace("%2", $param2, $str);
	        $str = str_replace("%3", $param3, $str);
	        $str = str_replace("%4", $param4, $str);
	        $str = str_replace("%5", $param5, $str);
	    }
	    return $str;
	}
    function utf8_unicode($name){
        $name = iconv('UTF-8', 'UCS-2', $name);
        $len  = strlen($name);
        $str  = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2){
            $c  = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0){   //两个字节的文字
                $str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
            } else {
                $str .= '\u'.str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
            }
        }
        //$str = strtoupper($str);//转换为大写
        return $str;
    }
	
	
	//得到数组中的值，如果不存在，返回""
	function get_array_value($arr,$name,$defaultValue = "")
	{
		if (array_key_exists($name,$arr))
			return $arr[$name] ;
		else
			return $defaultValue;
	}
	
	
	/*
	 mothed:将帐号加上域名
	 param:$loginNames admin,jc
	 return: admin@aipu.com,jc@aipu.com
	 */
	function userAppendDomain($loginNames,$sp = ",") {
		if ($loginNames == "")
			return "" ;
			
		//已经带域名，则不加
		if (! strpos($loginNames,"@"))
			$loginNames = str_replace($sp,RTC_DOMAIN . $sp,$loginNames) . RTC_DOMAIN ;
			
		return $loginNames;
	}
	
	/**
	 * 是否是本机
	 * @param string $ip
	 * @return boolean
	 */
	function isLocal($ip = "")
	{
		//因为 linux有的没能图形界，在没有安装的情况下，可以在其它电脑上访问
		if (ISINSTALL == 0)
			return  true ;
			
		if ($ip == "")
			$ip =  strtolower($_SERVER["SERVER_ADDR"]);
			
		if (($ip == "127.0.0.1") || ($ip == "localhost") || ($ip == "::1"))
			return true ;
		else
			return false ;
	}
	
	/*
	 mothed:只能是本机上访问
	 */
	function checkLocalLimit()
	{
		if(getOS()=='windows'){
			$ip = strtolower($_SERVER ["SERVER_ADDR"]);
			if (($ip != "127.0.0.1") &&  ($ip != "localhost"))
			{
				ob_clean ();
				header("Content-type: text/html; charset=utf-8");
				die(get_lang("class_site_warning")."<a href=\"http://127.0.0.1:98\" target=\"_blank\">http://127.0.0.1:98</a>.".get_lang("class_site_warning1"));
			}
		}else{
			if (! isLocal())
			{
				ob_clean ();
				header("Content-type: text/html; charset=utf-8");
				die(get_lang("class_site_warning")."<a href=\"http://127.0.0.1:98\" target=\"_blank\">http://127.0.0.1:98</a>.".get_lang("class_site_warning1"));
			}
		}
	}
	
	/*
	 mothed:得到子文件夹
	 */
	function getChildFolder($dir)
	{
		$files=scandir($dir);
		$arr = array();
		foreach($files as $file)
		{
			if($file != '.' && $file != '..')
			{
				if(is_dir($dir . "/" . $file))
					$arr[] = $file ;
			}
		}
		return $arr ;
	}
	
   function clientIP(){   
	$cIP = getenv('REMOTE_ADDR');   
	$cIP1 = getenv('HTTP_X_FORWARDED_FOR');   
	$cIP2 = getenv('HTTP_CLIENT_IP');   
	$cIP1 ? $cIP = $cIP1 : null;   
	$cIP2 ? $cIP = $cIP2 : null;   
	return $cIP;   
   } 
     
   function serverIP(){   
	return gethostbyname($_SERVER["SERVER_NAME"]);   
   }   
//检测域名格式  
	function CheckUrl($C_url){  
    $str="/^(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";  
    if (!preg_match($str,$C_url)){  
        return false;  
    }else{  
    return true;  
    }  }
	
	function is_private_ip($ip) { 
		return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE); 
	} 
	
	function is_domain($ip) { 
		return !filter_var($ip, FILTER_VALIDATE_IP); 
	} 

//	function ismobile() {
//		$is_mobile = '0';
//	
//		if(preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
//			$is_mobile=1;
//		}
//	
//		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
//			$is_mobile=1;
//		}
//	
//		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
//		$mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
//	
//		if(in_array($mobile_ua,$mobile_agents)) {
//			$is_mobile=1;
//		}
//	
//		if (isset($_SERVER['ALL_HTTP'])) {
//			if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
//				$is_mobile=1;
//			}
//		}
//	
//		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
//			$is_mobile=0;
//		}
//	
//		return $is_mobile;
//	}
    
    /**
     * 得到AntServer的ip
     * @return Ambigous <unknown, string>
     */
    function getFactAntServer()
    {
    	$ip = $_SERVER['SERVER_NAME'] ;
    	
    	return $ip ;
    }
    
    /**
     * 得到AntServer的ip
     * @return Ambigous <unknown, string>
     */
    function getAgentRTCServer()
    {
    	$ip = getAppValue("RTCServer_IP","http://127.0.0.1:98") ;
    	 
    	//如果设置本机，那么动态取地址
    	if ($ip == "http://127.0.0.1:98")
    	{
    		$url_server = getRootPath() ;
    		if ($url_server != "http://localhost:98")
    			$ip = $url_server ;
    	}
    	return $ip ;
    }
  ////获得访客浏览器语言
    function Get_Browser_Lang(){
        if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                $lang = substr($lang,0,5);
            if(preg_match("/zh-cn/i",$lang)){
                 $lang = "cn";
            }
            elseif(preg_match("/zh/i",$lang)){
                 $lang = "hk";
            }
            else{
                    $lang = "en";
            }
            return $lang;
           }
           else{
               return "en";
           }
  }
  
    /**
     * 生成Applcation数据,数据内容config/sysconfig.inc.php
     */
    function bulidAppValue()
    {
    
    	if (ISINSTALL == 0)
    		return ; 
    		
    	global $sysconfig_file ;
    	
    	$sql = "select col_name,col_data from tab_config" ;
    
    	$db = new DB();
    	$data = $db -> executeDataTable($sql) ;
    		
    	//写sysconfig.inc.php
    	$content = "" ;
    	foreach($data as $row)
    	{
    		$name = strtolower($row["col_name"]) ;
    		$value = $row["col_data"] ;
    		$value = str_replace("\\","/",$value);
    		$content .= "'" . $name . "' => '" . $value . "',\r\n" ;
    	}
    
    	

    	
    	$content = "<?php\r\n" .
    					"return array(\r\n" .  
    						$content . 
    					");\r\n" .
    				"?>\r\n" ;
    	
    	//recordLog("配置:" . $sysconfig_file) ;
    	writeFileContent($sysconfig_file,$content,0);
    
    }
	
    function manager_username()
    {
		$db = new DB();
		$sql = "Select UserName from Users_ID where IsManager=1 and UserState=1" ;
		$data = $db -> executeDataTable($sql) ;
		foreach($data as $row){
			$ptpform .= ($ptpform?",":"") . $row["username"];
		}

		return $ptpform;
    }
	////////////////////////////////////////////////////////////////////////////////////////////////
	//得到文件类型 0 unknow 1 office 2 pic 3 music 4 vedio
	////////////////////////////////////////////////////////////////////////////////////////////////
	function get_file_style($filename)
	{
		$pos = strrpos($filename,".");
		if ($pos == -1)
			return 0 ;

		$exentd_name = strtolower(substr($filename,$pos));
		if (strpos(".doc,.ppt,.xls,.docx,.pptx,.xlsx,.pdf,.txt,.chm",$exentd_name)>-1)
			return 1 ;
		if (strpos(".gif,.png,.jpg,.jpeg,.ico,.bmp",$exentd_name)>-1)
			return 2 ;
		if (strpos(".mp3,.wma,.rm,.wav,.midi,.mkv",$exentd_name)>-1)
			return 3 ;
		if (strpos(".mp4,.mpg,.mpeg,.avi,.rm,.rmvb,.mov,.wmv,.asf,.dat,.asx,.wvx,.mpe,.mpa,.3gp",$exentd_name)>-1)
			return 4 ;
		return 0 ;
	}
	
	function get_extension($file)
	{
	return substr(strrchr($file, '.'), 1);
	}
	
	function get_basename($filename){    
		 return preg_replace('/^.+[\\\\\\/]/', '', $filename);    
	}
	
	function create_guid1() {
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$guid = substr($charid, 0, 8)
		.substr($charid, 8, 4)
		.substr($charid,12, 4)
		.substr($charid,16, 4)
		.substr($charid,20,12);
		return $guid;
	}
	/**
	 * 将秒转换为 分:秒
	 * s int 秒数
	*/
	function s_to_hs($s=0){
		//计算分钟
		//算法：将秒数除以60，然后下舍入，既得到分钟数
		$s    =    floor($s/1000);
		$h    =    floor($s/60);
		//计算秒
		//算法：取得秒%60的余数，既得到秒数
		$s    =    $s%60;
		//如果只有一位数，前面增加一个0
		$h    =    (strlen($h)==1)?'0'.$h:$h;
		$s    =    (strlen($s)==1)?'0'.$s:$s;
		return $h.':'.$s;
	}
	
	function isInner($ip,$network_start,$network_end){ 
		$ip = (double) (sprintf("%u", ip2long($ip)));
		$network_start = (double) (sprintf("%u", ip2long($network_start)));
		$network_end = (double) (sprintf("%u", ip2long($network_end)));
		if ($ip >= $network_start && $ip <= $network_end)
		{
			return true;
		}
		return false;    
	}
	
	function isPublicNet(){ 
	    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if($http_type=='https://'&&g ( "source" )=='kefu'){
			header("Access-Control-Allow-Origin: *");
			header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
			return ;
		}
		//if(OPENPLATFORM){
			ob_clean ();
			//if(g ( "source" )=='kefu'){
			header("Access-Control-Allow-Origin: *");
			header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
			//}
		//}   
	}
	
	function get_device_type()
	{
	 //全部变成小写字母
	 $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	 $type = 'other';
	 //分别进行判断
	 if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
	{
	 $type = 'ios';
	 } 
	 
	 if(strpos($agent, 'android'))
	{
	 $type = 'android';
	 }
	 return $type;
	}

	/*移动端判断*/
	function ismobile()
	{ 
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		} 
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{ 
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		} 
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
				); 
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			} 
		} 
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{ 
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			} 
		} 
		return false;
	}
	
	function isWeixin() { 
	  if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
		return true; 
	  } else {
		return false; 
	  }
	}
	
	function isMiniProgram() { 
	  if (strpos($_SERVER['HTTP_USER_AGENT'], 'miniProgram') !== false) {
		  return true;
	  } else {
		  return false;
	  }
	}
	
	function get_download_url($tString)
	{
		$url = "/public/cloud.html?op=getfile&myid=livechat&label=msg&name=" . $tString ;
		return $url ;
	}
	
	function getNextElm($elm,$array){
	  if(!in_array($elm,$array)) return FALSE;
	  $count = count($array);
	  for ($i = 0; $i < $count; $i++){
		if ($elm == $array[$i]){
		  if ($i == $count-1){
			return $array[0];
		  }else{
			return $array[$i+1];
		  }
		}
	  }
	}
	
   function a_array_unique($array){
	$out = array();
	
	foreach ($array as $key=>$value) {
	 if (!in_array($value, $out)){
	  $out[$key] = $value;
	 }
	}
	
	$out = array_values($out);
	return $out;
   }
   
  function file_md5_100($path){
	$size=filesize($path);//取得文件大小
	if($size>1024*1024*100){//如果文件大于16kb
	  $str='';
	  $str.=file_get_contents($path,null,null,0,4096);#文件头部4kb
	  $str.=file_get_contents($path,null,null,(($size/2)-2048),4096);#文件中部4kb
	  $str.=file_get_contents($path,null,null,($size-4096),4096);#文件尾部4kb
	  return md5($str);
	}else{ //文件不太，不抽样，直接计算整个文件的hash
	  return md5_file($path);
	}
  }
  
  function curl_yibu($url)
  {
	$ch = curl_init();
	$timeout = 1;
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_exec($ch);
	curl_close($ch);
  }
  
function find_empty_dirs($dir) {
    $empty_dirs = [];
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        if (empty($files)) {
            $empty_dirs[] = $dir;
        } else {
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $empty_dirs = array_merge($empty_dirs, find_empty_dirs($file));
                }
            }
        }
    }
    return $empty_dirs;
}

  
//  function checkrobot($useragent=''){
//	  static $kw_spiders = array('bot', 'crawl', 'spider' ,'slurp', 'sohu-search', 'lycos', 'robozilla');
//	  static $kw_browsers = array('msie', 'netscape', 'opera', 'konqueror', 'mozilla');
//   
//	  $useragent = strtolower(empty($useragent) ? $_SERVER['HTTP_USER_AGENT'] : $useragent);
//	  if(strpos($useragent, 'http://') === false && dstrpos($useragent, $kw_browsers)) return false;
//	  if(dstrpos($useragent, $kw_spiders)) return true;
//	  return false;
//  }
//  function dstrpos($string, $arr, $returnvalue = false) {
//	  if(empty($string)) return false;
//	  foreach((array)$arr as $v) {
//		  if(strpos($string, $v) !== false) {
//			  $return = $returnvalue ? $v : true;
//			  return $return;
//		  }
//	  }
//	  return false;
//  }
?>