<?php
require_once(__ROOT__ . "/class/common/Site.inc.php");

/**
 * 本站点配置
 * JC 2015-5-15
 */

class WebConfig
{
	public $config_file = ""  ;
	public $content = "" ;
	public $content_rows = array();
	
	public $arr_config_define = array();

	function __construct()
	{
		$this -> config_file = __ROOT__ . "/config/config.inc.php" ;
	}
	

	/**
	 * WebServer配置信息生成(从配置表生成表本地)
	 * @param unknown $params:array(array({name=>"flag",value="1","type":"webserver"}))
	 */
	function setConfig($params)
	{
//	echo var_dump($params);
//	exit();
		//$this -> write($params);
	}
	 

	

	/**
	 * 是否在本获取的列表中
	 * @param unknown $name
	 * @return boolean
	 */
	function is_define($name)
	{
		return in_array($name,$this -> arr_config_define) ;
	}
	
	
	

	/**
	 * 设置数据库配置
	 * @param unknown $dbType
	 * @param unknown $dbServer
	 * @param unknown $dbPort
	 * @param unknown $dbName
	 * @param unknown $dbUser
	 * @param unknown $dbPassword
	 */
	function setDBConfig($dbType,$dbServer,$dbPort,$dbName,$dbUser,$dbPassword)
	{
		$params = array("DB_TYPE"=> $dbType,
						"DB_SERVER"=>$dbServer,
						"DB_PORT"=>$dbPort,
						"DB_NAME"=>$dbName,
						"DB_USER"=>$dbUser,
						"DB_PWD"=>$dbPassword,
						"ISINSTALL"=>"1");
		$this -> write($params);
	}


	/**
	 * 配置载入
	 * @return array(name=>value,name=>value)
	 */
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



 

	/**
	 * 配置写入  1 获取原来的数据 2 替换成新的数据  3 写入
	 * @param unknown $params array("dbname"=>"antdb","dbuser"=>"sa")
	 */
	function write($params)
	{
		$this -> load();
		$text = $this -> content ;

		foreach($params as $name=>$value)
		{

			if (trim($name) == "")
				continue ;
			
			$oldvalue = $this -> get($name);

			//判断内容是否存在
			if ($oldvalue == "null")
			{
				//不存在追加
				$text .=  "define(\"" . $name . "\",\"" . $value . "\");" . "\r\n" ;
			}
			else
			{
				//存在替换
				$str_old = "\"" . $name . "\",\"" . $oldvalue . "\"" ;
				$str_new = "\"" . $name . "\",\"" . $value . "\"" ;

				//变量转义
				$str_new = $this -> to_var($str_new);
				$text = str_replace($str_old,$str_new,$text);
			}

		}

		$text = "<?php\r\n" . $text . "\r\n?>" ;
		//$this -> config_file = __ROOT__ . "/config/config1.inc.php" ;

		writeFileContent($this -> config_file ,$text,0);
		
	}



	/**
	 * 获取值
	 * @param unknown $key
	 * @return string|mixed
	 */
	function get($key)
	{
		error_reporting(0);
		$s = "" ;
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


	/**
	 * 变量转义
	 * @param unknown $s
	 * @return mixed
	 */
	function to_var($s)
	{
		$s = str_replace("\\","\\\\",$s);
		return $s ;
	}

}

?>
