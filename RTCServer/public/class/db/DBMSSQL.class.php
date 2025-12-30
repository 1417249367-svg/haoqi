<?php


/**
 * 数据库 MSSQL类

 * @date    20141021
 */


class DBMSSQL extends DBAbstract
{
	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{

		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;

		$this -> PARAM_SP = "@" ;
		$this -> SQL_SP = "GO" ;
		
		
	}
	
//	/**
//	 * 在createdatabase 时，要打开 master 数据库
//	 * @param string $dbName
//	 */
//	function openConn($dbName = "")
//	{
//		//表示已经打开
//		if ($this -> conn)
//			return ;
//		
//		if ($dbName == "")
//			$dbName = $this -> DB_NAME ;
//		
//		$connectionInfo = array( "Database"=> $dbName , "UID"=> $this -> DB_USER, "PWD"=> $this -> DB_PWD); 
//		$this -> conn = sqlsrv_connect( $this -> DB_SERVER, $connectionInfo);
//		return $this -> conn ;
//	}
//	
//	function closeConn()
//	{
//		if ($this -> conn)
//			sqlsrv_close($this -> conn);
//	}
//	// 0 连接错误 1 success 2 连接成功(数据库不存在)
//	// 0 连接错误 1 success 2 连接成功(数据库不存在)
//	public function testConn()
//	{
//		error_reporting(0);
//		
//		$result = 0 ;
//		
//		if (! function_exists('sqlsrv_connect'))
//		{
//			recordLog("sqlsrv_connect function not exists");
//			return -1 ;
//		}
//		
//		
//		$this -> openConn();
//		
//
//		if(!($this -> conn))
//		{
//			
//			//连接错误 或 数据库不存在
//			//sqlsvr 中 conn 已经绑定数据库，所以我们这边先绑定  master 数据库来判断 数据库是否存在
//			$this -> openConn("master");
//
//			if ($this -> conn)
//				return 2 ;
//			else 
//				return 0 ;
//
//		}
//		else
//		{
//			//连接成功
//			$result = 1 ;
//		}
//		
//		$this -> closeConn() ;
//		
//		error_reporting(1);
//		return $result ;
//	}

	public function testConn()
	{
		error_reporting(0);
		
		$result = 0 ;
		
		if (! function_exists('mssql_connect'))
		{
			recordLog("mssql_connect function not exists");
			return -1 ;
		}

		$conn = mssql_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		if(!$conn)
			$result = 0 ;
		else
		{
			$result = mssql_select_db($this -> DB_NAME);
			if(!$result)
				$result = 2 ;
			else
				$result = 1 ;
		}
//		echo $this -> DB_SERVER."|".$this -> DB_USER."|".$this -> DB_PWD."|".$result;
//		exit();
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
		$conn = mssql_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		mssql_select_db($this -> DB_NAME);
		$result = mssql_query($sql,$conn);
		mssql_close($conn);
		error_reporting(1);
		return $result ;
	}


	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;

		$result = 1 ;
//		echo $this -> DB_SERVER.'<br>';
//		echo $this -> DB_USER.'<br>';
//		echo $this -> DB_PWD.'<br>';
//		exit();
		$conn = mssql_connect($this -> DB_SERVER,$this -> DB_USER,$this -> DB_PWD);
		if(!$conn)
		{
			recordLog("connect database error");
			return ;
		}
		mssql_select_db($this -> DB_NAME);

		//foreach($params as $param)
			//mssql_bind($stid ,($this -> PARAM_SP) . $param["name"] ,$param["value"]);

		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");  //php 操作 ms sql server 中文问题
			$rs = mssql_query($sql,$conn);
		}

		if ($returnType == 0)
		{

		}
		else
		{

			$result = array();
			while($row = mssql_fetch_array($rs,MYSQL_ASSOC))
			{
				$row = iconv_array(array_change_key_case($row));
				$result[] = $row;
			}
		}

		mssql_close($conn);
		return $result ;
	}
	
	function executeMsg($sqls,$params = array())
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		$result = 1 ;

  		//$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
		
		$conn = @new COM("ADODB.Connection") or die ("ADO Connection faild.");
		$connstr = "provider=sqloledb;datasource=".($this -> DB_PATH).";uid=".($this -> DB_USER).";pwd=".($this -> DB_PWD).";database=".$this -> DB_NAME.";";
		$conn->Open($connstr);
		
		$rs = @new COM("ADODB.RecordSet");
		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");
			//$sql = $this -> formatSQL($sql);
			//echo "|".$sql."|";

            $rs->Open(trim($sql),$conn);
			if (! $rs)
				$result = 0 ;
		}

		$result = array();
		
		$count = $rs->RecordCount; 
		$i=0;
		while(!$rs->eof){
		
		$result[$i]['typeid'] = iconv_str($rs->Fields('TypeID')->Value);
		$result[$i]['myid'] = iconv_str($rs->Fields('MyID')->Value); 
		$result[$i]['youid'] = iconv_str($rs->Fields('YouID')->Value);
		$result[$i]['fcname'] = iconv_str($rs->Fields('FcName')->Value);
		$result[$i]['to_type'] = iconv_str($rs->Fields('To_Type')->Value); 
		$result[$i]['isreceipt'] = iconv_str($rs->Fields('IsReceipt')->Value);
		$result[$i]['to_date'] = iconv_str($rs->Fields('To_Date')->Value); 
		$result[$i]['to_time'] = iconv_str($rs->Fields('To_Time')->Value);
		$result[$i]['usertext'] = iconv_str($rs->Fields('UserText')->Value); 
		$result[$i]['fontinfo'] = iconv_str($rs->Fields('FontInfo')->Value);
		$i++;
		$rs->Movenext(); //将记录集指针下移
		} 
		
		$rs->close();
		return $result ; 
	}


	public function page($sql,$pageIndex,$pageSize)
	{
		$data = $this -> execute($sql,array(),1,0);
		$data_new = array();

		$row = $this -> getPageRow($pageIndex,$pageSize,count($data));

		for($index = $row["begin"];$index <$row["end"];$index++)
			$data_new[] = $data[$index] ;

		return $data_new ;
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