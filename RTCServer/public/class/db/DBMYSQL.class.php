<?php


/**
 * 数据库 MySQL类

 * @date    20141021
 */


class DBMYSQL extends DBAbstract
{


	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{
		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;

		$this -> PARAM_SP = ":" ;
		$this -> SQL_SP = "delimiter $$" ;
	}

	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{
		error_reporting(0);

		$result = 0 ;
		$conn = mysql_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		if(!$conn)
		{
			$result = 0 ;
		}
		else
		{
			$result = mysql_select_db($this -> DB_NAME);
			if(!$result)
				$result = 2 ;
			else
				$result = 1 ;
		}

		error_reporting(1);

		return $result ;
	}

	public function createDataBase()
	{
		$sql = " create database " . $this -> DB_NAME ;
		$this -> execute(array($sql));
	}

	public function hasTable($table)
	{
		$sql = " select count(*) from " . $table ;
		error_reporting(0);
		$conn = mysql_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		mysql_select_db($this -> DB_NAME);
		$result = mysql_query($sql,$conn);
		mysql_close($conn);
		error_reporting(1);
		return $result ;
	}

	//$sqls
	//$param
	//$returnType 		0 execute  1 datatable
	//$cmdType  		0 sql  1 proc
	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;

		$result = 1 ;
		$conn = mysql_connect($this -> DB_SERVER,$this -> DB_USER,$this ->DB_PWD);
		mysql_select_db($this -> DB_NAME,$conn);
		//mysql_query("SET NAMES 'utf8'");

		//启动事务
		mysql_query("START TRANSACTION");
		mysql_query("set names 'gb2312' ");
		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");
			$sql = $this -> formatSQL($sql);
			//echo "|".$sql."|";
			$stid = mysql_query($sql,$conn);
			if (! $stid)
				$result = 0 ;
		}
		//提交事务
		mysql_query("COMMIT");


		if ($returnType == 0)
		{

		}
		else
		{
			$result = array();
			while($row = mysql_fetch_array($stid))
			{
				//$row = array_change_key_case($row) ;
				// gbk to utf-8
				$row = iconv_array($row);
				$result[] = $row;

			}
		}

		
		
		mysql_close($conn);
		return $result ;
	}

	public function page($sql,$pageIndex,$pageSize)
	{
		$row = $this -> getPageRow($pageIndex,$pageSize);

		//2014-11-24 jc  limit start length
		$sql = $sql . " LIMIT " . $row["begin"] . "," . $pageSize ;  // limit start length

		return $this -> execute($sql,array(),1,0);
	}

	function formatSQL($sql)
	{
		//反斜杠(\)为何离奇消失
		$sql = str_replace("\\","\\\\",$sql);
		return $sql ;
	}

	function formatValue($value,$type = "string")
	{
		switch($type)
		{
			default:
				return "'" . $value . "'" ;
		}
	}
}
?>