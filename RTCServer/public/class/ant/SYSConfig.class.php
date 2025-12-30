<?php
require_once (__ROOT__ . "/class/ant/webconfig.class.php");
/**
 * 系统配置

 * @date    20140826
 */

class SYSConfig
{




    function listByGenre($genre = "",$name = "")
    {
		$config = new Model("tab_config");
		if ($genre != "")
			$config->addParamWhere("col_genre", $genre);
		if ($name != "")
			$config->addParamWhere("col_name", $name);
		$config->field="col_name,col_data";
		return $config->getList();
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
		//生成antserver服务器配置(windows 一部门信息保存到注册表) ，不同的操作系统不同的处理
		$antconfig = new AntConfig();
		$antconfig -> setDBConfig($dbType,$dbServer,$dbPort,$dbName,$dbUser,$dbPassword);
		//生成webserver服务器配置(数据保存到config.inc.php)
		$webconfig = new WebConfig();
		$webconfig -> setDBConfig($dbType,$dbServer,$dbPort,$dbName,$dbUser,$dbPassword);
//				echo $dbType.'|'.$dbServer.'|'.$dbPort.'|'.$dbName.'|'.$dbUser.'|'.$dbPassword;
//		exit();

	}
	
	function setConfig($params)
	{
		//保存到数据库
		foreach($params as $param)
			$this -> set($param["type"],$param["name"],$param["value"]);

		//生成antserver服务器配置(从配置表生成表本地)
//		$antconfig = new AntConfig();
//		$antconfig -> setConfig($params);
		
		//生成webserver服务器配置(从配置表生成表本地)
		$webconfig = new WebConfig();
		$webconfig -> setConfig($params);
		
		//生成本地的配置数据
		bulidAppValue();
	}
	
	
	
    function set($genre,$name,$value)
    {
		if ($value == -1)
			$this -> delete($genre,$name);
		else
			$this -> add($genre,$name,$value) ;

	}

	function add($genre,$name,$value)
	{
		$db = new DB();
		$sql = " select count(*) as c from tab_config where col_name='" . $name . "'" ;
		$count = $db -> executeDataValue($sql) ;
		if ($count == 0)
			$sql = " insert into tab_config(col_genre,col_name,col_data) values('" . $genre . "','" . $name . "','" . $value . "')";
		else
			$sql = " update tab_config set col_data='" . $value . "' where col_name='" . $name . "'" ;
//echo $sql;
//exit();
		$db -> execute($sql) ;
	}

	function delete($genre,$name)
	{
		$db = new DB();
		$sql = " delete from tab_config where col_genre='" . $genre . "' and col_name='" . $name . "'" ;
		$db -> execute($sql) ;
	}
	
	/*
	method:查找参数
	param: $genre 分类
	param: $name 名称
	*/
    function load($genre = "",$name = "")
    {
		global $datas ;
		$config = new Model("tab_config");
		if ($genre != "")
			$config->addParamWhere("col_genre", $genre);
		if ($name != "")
			$config->addParamWhere("col_name", $name);
		$config->field="col_genre,col_name,col_data";
		$datas =  $config->getList();
		return $datas ;
	}
	
	
	/*
	method:得到配置
	param: $genre 分类
	param: $name 名称
	*/
	function get($name,$type = "",$defaultValue = "")
	{
		global $datas ;
		
		if (count($datas) == 0)
			$this -> load();
			
		foreach($datas as $row)
		{
			//如果有类型判断
			if ($type != "")
			{
				if ($type != $row["col_genre"])
					continue ;
			}
			if ($name == $row["col_name"])
				return $row["col_data"];
		}
		
		return $defaultValue ;
	}
	
	/**
	 * 生成参数项，辅助功能
	 * @param unknown $name col_name名称
	 * @param unknown $value col_data值
	 * @param string $type col_genre类型
	 * @return array()
	 */
	function create_param($name,$value,$type = "SysConfig")
	{
		return array("name"=>$name,"value"=>$value,"type"=>$type);
	}
}
?>



