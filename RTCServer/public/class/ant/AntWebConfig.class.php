<?php
require_once(__ROOT__ . "/class/common/Site.inc.php");
require_once(__ROOT__ . "/class/common/Regedit.class.php");

/*--------------------------------------------
定义全局变量，php中没有APPLICATION,故写到config/config.inc.php中
---------------------------------------------*/
class AntWebConfig
{
	public $config_file = "../config/config.inc.php" ;
	public $content = "" ;
	public $content_rows = array();

	function __construct()
	{

	}

	/*
	#define ATDB_DBTYPE_ACCESS		(0)
	#define ATDB_DBTYPE_SQLSERVER	(1)
	#define ATDB_DBTYPE_ACCESS2		(2)
	#define ATDB_DBTYPE_ORACLE		(3)
	//#define ATDB_DBTYPE_SOADB		(4)	// 使用 SOAClient 访问 SOA 数据库
	#define ATDB_DBTYPE_UDLFILE		(5)
	#define ATDB_DBTYPE_MYSQL		(6)
	*/
	function getDBTypeName($dbType)
	{
		switch($dbType)
		{
			case 0:
				return "access" ;
			case 1:
				return "mssql" ;
			case 2:
				return "access" ;
			case 3:
				return "oracle" ;
			case 6:
				return "mysql" ;
			case 7:
				return "mariadb" ;
			default:
				return "mssql" ;
		}
	}

	//初始化
	function init()
	{
		$regedit = new Regedit();

		//得到注册表地址 判断是64位还是32位
		$reg_path = "HKEY_LOCAL_MACHINE\\SOFTWARE\\RTCSoft\\" ;
		$reg_path_server = $reg_path . "AntServer\\" ;

		$arr = array();
		$arr["RTC_PORT"] = $regedit -> get($reg_path_server . "\\Port");
		$arr["COMPANY_NAME"] = $regedit -> get($reg_path_server . "\\CompanyName");
		$arr["DB_TYPE"] = $this -> getDBTypeName($regedit -> get($reg_path_server . "\\DBType"));
		$arr["DB_SERVER"] = $regedit -> get($reg_path_server . "\\DBServer");
		$arr["DB_PORT"] = $regedit -> get($reg_path_server . "\\DBPort");
		$arr["DB_NAME"] = $regedit -> get($reg_path_server . "\\DBName");
		$arr["DB_USER"] = $regedit -> get($reg_path_server . "\\DBUser");
		$arr["DB_PWD"] = DBPwdDecrypt($regedit -> get($reg_path_server . "\\DBPassword"),KEY_REG);
		$arr["DB_NAME"] = $regedit -> get($reg_path_server . "\\DBName");

		$arr["RTC_SERVER"] = $_SERVER['SERVER_ADDR'] ;
		$arr["RTC_PORT"] = $regedit -> get($reg_path_server . "\\Port");
		$arr["RTC_DATADIR"] = $regedit -> get($reg_path_server . "\\DataDir");
		$arr["RTC_CONSOLE"] = $regedit -> get($reg_path_server . "\\WorkDir");

        //烽火专用  2015.04.10  zwz
        $arr["ENCRYPTION_KEY"] = $regedit -> get($reg_path_server . "\\ENCRYPTION_KEY");
        $arr["FIBERHOME_API"] = $regedit -> get($reg_path_server . "\\FIBERHOME_API");

		$domain = $regedit -> get($reg_path_server . "\\DomainName");
		if ($domain != "")
			$arr["RTC_DOMAIN"] = "@" . $domain ;

		$arr["REG_PATH_APP"] = $reg_path;
		$arr["REG_PATH_SERVER"] = $reg_path_server;
		$arr["ISINSTALL"] = 1;

		$this -> load();
		$this -> setValue($arr);
	}

	//读取内容，并生成数组
	function load()
	{
		$text = file_get_contents($this -> config_file);
		$this -> content_rows = array();
		$this -> content = "" ;

		$rows = explode("\r\n",$text);
		foreach($rows as $row)
		{
			$sp = strpos($row,",");

			if ($sp>-1)
			{
				//define("DB_TYPE","mssql") ;
				$key = substr($row,0,$sp) ; //取前段  例 define("DB_TYPE"
				$key = str_replace("define(\"","",$key);
				$key = str_replace("\"","",$key);

				$value = substr($row,$sp+1); //取后段 例 ,"mssql") ;
				$value = substr($value,0,strrpos($value,")"));
				$value = str_replace("\"","",$value);

				$this -> content_rows[$key] = $value;
				$this -> content .= $row . "\r\n" ;
			}
		}

		return $this -> content_rows ;
	}


	function getValue($key)
	{
		error_reporting(0);
		eval("\$s = " . $key . ";");
		if ($s == $key)
			return "null";
		else
		{
			//变量转义
			$s = $this -> to_var($s);
			return $s ;
		}
	}


	function setValue($arr_new)
	{
		$this -> load();
		$text = $this -> content ;

		foreach($arr_new as $key=>$value)
		{
			//判断内容是否存在
			$oldvalue = $this -> getValue($key);

			if ($oldvalue == "null")
			{
				//不存在追加
				$text .=  "define(\"" . $key . "\",\"" . $value . "\");" . "\r\n" ;
			}
			else
			{
				//存在替换
				$str_old = "\"" . $key . "\",\"" . $oldvalue . "\"" ;
				$str_new = "\"" . $key . "\",\"" . $value . "\"" ;

				//变量转义
				$str_new = $this -> to_var($str_new);
				$text = str_replace($str_old,$str_new,$text);
			}

			//println($str_old . "---------" . $str_new);
		}

		$text = "<?php\r\n" . $text . "\r\n?>" ;

        file_put_contents($this -> config_file ,$text);
	}

	//变量转义
	function to_var($s)
	{
		$s = str_replace("\\","\\\\",$s);
		return $s ;
	}

}

?>