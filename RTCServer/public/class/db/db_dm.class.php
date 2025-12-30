<?php



/**
 * 数据库达梦类
 * @author jc
 * 20150803
 */
class DBDM extends DBAbstract
{
	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "",$dbPort = "")
	{

		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;

		$this -> PARAM_SP = "@" ;
		$this -> SQL_SP = ";" ;
		
		
	}

	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{


		error_reporting(0);
		
		$result = 0 ;
		
		if (! function_exists('dm_connect'))
		{
			recordLog("dm_connect function not exists");
			return -1 ;
		}

		$conn = dm_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		if(!$conn)
			$result = 0 ;
		else
			$result = 1 ;

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
		$conn = dm_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		$result = dm_query($sql,$conn);
		dm_close($conn);
		error_reporting(1);
		return $result ;
	}


	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;

		$result = 1 ;
		$conn = dm_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		if(!$conn)
		{
			recordLog("connect database error");
			return ;
		}

		foreach($sqls as $sql)
		{
			$sql = str_replace("+","||",$sql) ;
			$sql = iconv_str($sql,"utf-8","gbk");  //php 操作 ms sql server 中文问题
			$rs = dm_query($sql,$conn);
		}

		if ($returnType == 0)
		{
			//2015-11-12 execute return 1/0
			return $rs?1:0;
		}
		else
		{

			$result = array();
			while ($row = dm_fetch_array($rs, DM_BOTH))
			{
				$row = array_change_key_case($row,CASE_LOWER);
				$row = iconv_array($row,"gbk","utf-8") ;
				$result[] = $row;
			}
		}
		dm_free_result($result);
		dm_close($conn);
		return $result ;
	}

	public function page($sql,$pageIndex,$pageSize)
	{
		$row = $this -> getPageRow($pageIndex,$pageSize);

		//2014-11-24 jc  limit start length
		$sql = $sql . " LIMIT " . $row["begin"] . "," . $pageSize ;  // limit start length

		return $this -> execute($sql,array(),1,0);
	}

	function formatValue($value,$type = "string")
	{
		switch($type)
		{
			default:
				return "'" . $value . "'" ;
		}
	}
	
	public function formatField($field,$type = "string",$fieldAlias = "")
	{
		return $field ;
	}
	
}

?>