<?php
require_once(__ROOT__ . "/class/common/Site.inc.php");

/*
 * AntServer配置
 * JC 2015-5-15
 */




class AntConfig
{
	public $ini_data = array();
	public $ini_filepath = "";
	public $ini_filename = "system.ini";
	
	public $arr_config_define = array("CompanyName","DomainName");
	
	function __construct()
	{
		//20151022 第一次安装时，BIGANT_CONSOLE为空，存放的路径不对
		$configPath = BIGANT_CONSOLE ;
		if ($configPath == "")
			$configPath = get_app_dir() . "/im_common" ;
		
		$this -> ini_filepath = $configPath . "/conf";  //在这边定义，先让 define.inc.php加载后
	}
	

	/**
	 * AntServer配置信息生成(从配置表生成表本地)
	 * @param $params:array(array(name=>"",value=>"",type=>"")) 
	 */
	function setConfig($params)
	{
		$params_new = array();
		foreach($params as $param)
		{
			$name = $param["name"] ;
			$value = $param["value"] ;
			
			if ($this -> is_define($name))
				$params_new[$name] = $value;
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
		return in_array($name,$this -> arr_config_define) ;
	}
	
	

	/**
	 * 设置数据库配置
	 * @param  $dbType
	 * @param  $dbServer
	 * @param  $dbPort
	 * @param  $dbName
	 * @param  $dbUser
	 * @param  $dbPassword
	 */
//	function setDBConfig($dbType,$dbServer,$dbPort,$dbName,$dbUser,$dbPassword)
//	{
//		$params = array("DBType"=> $dbType,
//						"DBServer"=>$dbServer,
//						"DBPort"=>$dbPort,
//						"DBName"=>$dbName,
//						"DBUser"=>$dbUser,
//						"DBPassword"=>$dbPassword);
//		$this -> write($params);
//		
//		//20151022 chenbang 
//		$oracle_config_command = get_app_dir() ."/im_webserver/oracle/odbc/oracle_config.sh" ;
//		exec($oracle_config_command, $output, $return);
//	}
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
	 * @return multitype:
	 */
	function load()
	{
		//得到配置文件
		$ini_file = $this -> ini_filepath . "/" . $this -> ini_filename ;
		
		//如果有缓存，则返回
		if (count($this -> ini_data) > 0)
			return $this -> ini_data ;
		
		//创建目录
		if(!file_exists($this -> ini_filepath))
		   mkdirs($this -> ini_filepath);
		
		//取内容
		$this -> ini_data = array();
		if(file_exists($ini_file))
			$this -> ini_data = parse_ini_file($ini_file,false);
	
		return $this -> ini_data ;
	}




	/**
	 * AntServer配置信息写入
	 * @param  $params array("CompanyName"=>"aa",DomainName=>"bb")
	 */
	function write($params)
	{
		//加载配置中的数据
		$this -> load();
		
		//合并数据
		foreach($params as $name => $value)
			$this -> ini_data[$name] = $value ;
			
		//生成内容
		$content = "";
		foreach($this -> ini_data as $name => $value)
			$content .= $name  . "=" . $value . "\r\n" ;
	
		//生成目录
		if (!file_exists($this -> ini_filepath)) 
			mkdirs($this -> ini_filepath, 0777); 
	
		//写文件(有权限问题，先写到站点下，再拷贝)
		$ini_file = $this -> ini_filepath . "/" . $this -> ini_filename ;
		$file = @fopen($ini_file,"w");
		@fwrite($file,$content);
		@fclose($file);
	}




}

?>
