<?php


 
/*
 * ant server配置
 * JC 2015-5-15
 */

require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");

class AntConfig
{
	public $regedit;
	public $reg_path_app = REG_PATH_APP;
	public $reg_path_server = REG_PATH_SERVER ;
	public $arr_config_define = array(
			"AntDocServerFlag"=>"REG_DWORD",
			"AntServerFlag"=>"REG_DWORD",
			"AutoAway"=>"REG_DWORD",
			"AutoAwayTime"=>"REG_DWORD",
			"AutoClear"=>"REG_DWORD",
			"CompanyName"=>"REG_SZ",
			"ConsoleDir"=>"REG_SZ",
			"DataDir"=>"REG_SZ",
			"DBFile"=>"REG_SZ",
			"DBLoginMode"=>"REG_DWORD",
			"DBName"=>"REG_SZ",
			"DBPassword"=>"REG_SZ",
			"DBPort"=>"REG_DWORD",
			"DBServer"=>"REG_SZ",
			"DBType"=>"REG_DWORD",
			"DBUser"=>"REG_SZ",
			"DBVer"=>"REG_DWORD",
			"DomainName"=>"REG_SZ",
			"MsgLife"=>"REG_DWORD",
			"ServerName"=>"REG_SZ",
			"WorkDir"=>"REG_SZ",
			"AntServer_Port"=>"REG_DWORD",
			"AntAV_Port"=>"REG_DWORD",
			"AntDS_Port"=>"REG_DWORD",
			"AntFileServer_Port"=>"REG_DWORD"
			);
 

	function __construct()
	{
		$this -> regedit = new Regedit();
	}


	/**
	 * AntServer配置信息生成
	 * @param unknown $params array(array({name=>"flag",value="1","type":"webserver"}))
	 */
	function setConfig($params)
	{
		
		$params_new = array();
	
		//得到需要加到antserver的配置内容
		foreach($params as $param)
		{
			$name = $param["name"] ;
			$value = $param["value"] ;
			
			if (strtolower($name) == "antavserver_port")
				$name = "AntAV_Port" ;

			if ($this -> is_define($name))
			{
				$reg_type = $this -> arr_config_define[$name] ; //得到注册表的类型
				$params_new[] = $this -> create_param($name,$value,$reg_type) ;
			}
		}
		

		$this -> write($params_new);
		
	}
	

	/**
	 * 是否在本获取的列表中
	 * @param unknown $name
	 * @return boolean
	 */
	function is_define($name)
	{
		return array_key_exists($name,$this -> arr_config_define) ;
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
	function setDBConfig($DB_TYPE,$DB_SERVER,$DB_PORT,$DB_NAME,$DB_USER,$DB_PWD)
	{
//	    $config_content = file_get_contents(__ROOT__ . '/config/config.inc.php');
//		$config_content = preg_replace('/(DB_TYPE",[\'"])(.*?)([\'"])/','${1}'.$DB_TYPE.'${3}',$config_content);  
//		if($DB_TYPE=="access"){
//		$config_content = preg_replace('/(DB_USER",[\'"])(.*?)([\'"])/','${1}${3}',$config_content);
//		$config_content = preg_replace('/(DB_PWD",[\'"])(.*?)([\'"])/','${1}seekinfo${3}',$config_content);
//		}else{
//		$config_content = preg_replace('/(DB_SERVER",[\'"])(.*?)([\'"])/','${1}'.$DB_SERVER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PORT",[\'"])(.*?)([\'"])/','${1}'.$DB_PORT.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_USER",[\'"])(.*?)([\'"])/','${1}'.$DB_USER.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_PWD",[\'"])(.*?)([\'"])/','${1}'.$DB_PWD.'${3}',$config_content); 
//		$config_content = preg_replace('/(DB_NAME",[\'"])(.*?)([\'"])/','${1}'.$DB_NAME.'${3}',$config_content); 
//	    }
//		file_put_contents(__ROOT__ . '/config/config.inc.php',$config_content);
		
	    $config_content = file_get_contents(__ROOT__ . '/inc/config.ini');
		$config_content = preg_replace('/(DB_TYPE=[\'"])(.*?)([\'"])/','${1}'.$DB_TYPE.'${3}',$config_content);  
		if($DB_TYPE=="access"){
		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}${3}',$config_content);
		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}seekinfo${3}',$config_content);
		}else{
		$config_content = preg_replace('/(DB_SERVER=[\'"])(.*?)([\'"])/','${1}'.$DB_SERVER.'${3}',$config_content); 
		$config_content = preg_replace('/(DB_PORT=[\'"])(.*?)([\'"])/','${1}'.$DB_PORT.'${3}',$config_content); 
		$config_content = preg_replace('/(DB_USER=[\'"])(.*?)([\'"])/','${1}'.$DB_USER.'${3}',$config_content); 
		$config_content = preg_replace('/(DB_PWD=[\'"])(.*?)([\'"])/','${1}'.$DB_PWD.'${3}',$config_content); 
		$config_content = preg_replace('/(DB_NAME=[\'"])(.*?)([\'"])/','${1}'.$DB_NAME.'${3}',$config_content); 
	    }
		file_put_contents(__ROOT__ . '/inc/config.ini',$config_content);
		
	    $content = new SimpleIniIterator(__ROOT__ . '/Data/DataBase.ini');
		$content->setIniValue('DB_TYPE', $DB_TYPE, 'server_connection');
		$content->setIniValue('DB_SERVER', $DB_SERVER, 'server_connection');
		$content->setIniValue('DB_PORT', $DB_PORT, 'server_connection');
		$content->setIniValue('DB_USER', $DB_USER, 'server_connection');
		$content->setIniValue('DB_PWD', $DB_PWD, 'server_connection');
		$content->setIniValue('DB_NAME', $DB_NAME, 'server_connection');
	}


	/**
	 * AntServer配置信息加载
	 * @return $arr_antconfig
	 */
	function load()
	{
		$arr_antconfig = array();
	
		//得到需要加到antserver的配置内容
		foreach($this -> arr_config_define as $key=>$type)
		{
			//得到注册表路径 AntAV_Port 注册表应是 AntAV/Port
			$regPath = $this -> get_regpath($key) ;
	
			//得到注册表值
			$value = $this -> regedit -> get($regPath) ;
			
			$arr_antconfig[] = array("name"=>$key,"value"=>$value,"type"=>$type);
		}
		
		return $arr_antconfig ;
		
		
	}
	

	
	

	/**
	 * AntServer配置信息写入
	 * @param  $params array(array(name=>"DBName",value=>"antdb",type=>"REG_SZ"))
	 */
	function write($params)
	{
		foreach($params as $param)
		{
			//得到注册表路径 AntAV_Port 注册表应是 AntAV/Port
			$regPath = $this -> get_regpath($param["name"]) ;

			//保存注册表
			$this -> regedit -> set($regPath,$param["value"],$param["type"]) ;

		}
	}
	
	/**
	 * 创建参数
	 * @param unknown $name
	 * @param unknown $value
	 * @param unknown $type
	 * @return multitype:unknown
	 */
	function create_param($name,$value,$type)
	{
		return array("name"=>$name,"value"=>$value,"type"=>$type);
	}
	

	/**
	 * 得到配置内容
	 * @param unknown $key
	 * @param string $defaultValue
	 * @return Ambigous <string, string>
	 */
	function get_regvalue($key,$defaultValue = "")
	{
		$regPath = $this -> get_regpath($key) ;

		//得到注册表值
		$value = $this -> regedit -> get($regPath) ;
		
		if ($value == "")
			$value = $defaultValue ;
		return $value ;
		
	}
	
	

	/**
	 * 得到注册表的位置
	 * @param unknown $name
	 * @return string
	 */
	function get_regpath($name)
	{
		$arr_name = explode("_",$name);

		if (count($arr_name)>1)
		{
			$reg_path = $this -> reg_path_app . $arr_name[0] . "\\" ;
			$name = $arr_name[1] ;
		}
		else
		{
			$reg_path = $this -> reg_path_server ;
		}
		
		$reg_path = $reg_path . $name ;
		
		return $reg_path ;
	}

	


}


?>