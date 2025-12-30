<?php


/**
 * 数据库 MSSQL类
 * PHP 5.6后MSSQL数据库用此类
 * @author  jincun
 * @date    20141021
 */


class DBMSSQL extends DBAbstract
{
	private $DEFAULT_DB_PORT = "1433" ;
	private $conn ;
	
	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "",$dbPort = "")
	{
		//如果是默认端口，不要加，有的电脑上加上去就连不了
		if (($dbPort != "") && ($dbPort != $this -> DEFAULT_DB_PORT))
			$dbServer  = $dbServer . "," . $dbPort ;
		
		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;
		$this -> DBOS = strtoupper(substr(PHP_OS,0,3))==='WIN'?'windows':'linux' ;

		$this -> PARAM_SP = "@" ;
		$this -> SQL_SP = "GO" ;
		
		
	}
	
	/**
	 * 在createdatabase 时，要打开 master 数据库
	 * @param string $dbName
	 */
	function openConn($dbName = "")
	{
	
		if($dbName)
		    $connectionInfo = array( "Database"=> $dbName , "UID"=> $this -> DB_USER, "PWD"=> $this -> DB_PWD);	       
		else 
		    $connectionInfo = array( "UID"=> $this -> DB_USER, "PWD"=> $this -> DB_PWD);
		$this -> conn = sqlsrv_connect( $this -> DB_SERVER, $connectionInfo);
		return $this -> conn ;
	}
	
	function closeConn()
	{
		if ($this -> conn)
			sqlsrv_close($this -> conn);
		$this -> conn = "";
	}

	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{
		error_reporting(0);
		
		$result = 0 ;
		
		if (! function_exists('sqlsrv_connect'))
		{
			recordLog("sqlsrv_connect function not exists");
			return -1 ;
		}
		
		
		$this -> openConn();
		

		if($this -> conn)
		{
			
			//连接成功 ip 账号密码
			//sqlsvr 中 conn 连接数据库，
			$this -> openConn($this -> DB_NAME);

			if ($this -> conn)
				return 1 ;
			else 
				return 2 ;

		}
		else
		{
			//连接失败
			$result = 0 ;
		}
		
		$this -> closeConn() ;
		
		error_reporting(1);
		return $result ;
	}
	

	
	public function createDataBase()
	{
		$currDB = $this -> DB_NAME ;
		
		$connectionInfo = array("UID"=> $this -> DB_USER, "PWD"=> $this -> DB_PWD); 
		$this -> conn = sqlsrv_connect( $this -> DB_SERVER, $connectionInfo);
		
		$sqls = array(
			" create database " . $currDB,
			" ALTER DATABASE " . $currDB . " COLLATE Latin1_General_100_CI_AS_SC_UTF8",
			" ALTER DATABASE " . $currDB . " SET COMPATIBILITY_LEVEL = 100",
			" ALTER DATABASE " . $currDB . " SET RECOVERY SIMPLE "
		) ;
		
		foreach($sqls as $sql)
		{
			//$sql = iconv("utf-8","gbk", $sql);  //php 操作 ms sql server 中文问题
			$stmt = sqlsrv_query($this -> conn,$sql);
		}
		
		//关闭连接
		sqlsrv_free_stmt( $stmt);
		$this -> closeConn();
	}
	
	public function hasTable($table)
	{
		$conn = $this -> openConn($this -> DB_NAME);
		
		if ($conn == false)
			return 0 ;
		
		$sql = " select count(*) from " . $table ;

		error_reporting(0);
		$result = sqlsrv_query($conn,$sql);
		error_reporting(1);
		
		$this -> closeConn();
		
		return $result ;
	}
	
	
	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
	
		$result = 1 ;
		
		$this -> conn = $this -> openConn($this -> DB_NAME);
		
		if($this -> conn == false)
		{
			recordLog("connect database error");
			return ;
		}

	
		//foreach($params as $param)
		//sqlsrv_bind($stid ,($this -> PARAM_SP) . $param["name"] ,$param["value"]);
	
		foreach($sqls as $sql)
		{
			//if($this -> DBOS == "windows") $sql = iconv("utf-8","gbk", $sql);  //php 操作 ms sql server 中文问题
			$stmt = sqlsrv_query($this -> conn,$sql);
		}
	
		if ($returnType == 0)
		{
			//2015-11-12 execute return 1/0
			return $stmt?1:0 ;
		}
		else
		{
	
			$result = array();
			
			while( $row = sqlsrv_fetch_array($stmt))
			{ 
				foreach($row as $k=>$v){
					//echo $row[$k];
					if(is_object($row[$k])){ 
					$dateoutput = (array)$row[$k];
                    $row[$k]=substr($dateoutput['date'],0,strrpos($dateoutput['date'],'.'));
					}
				}
				//if($this -> DBOS == "windows") $row = iconv_array(array_change_key_case($row));
				//else 
				$row = array_change_key_case($row);
				$result[] = $row;
			}
		}
		sqlsrv_free_stmt( $stmt);

		$this -> closeConn() ;
		
		return $result ;
	}
	

	function executeMsg($sqls,$params = array())
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		$result = 1 ;

  		//$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
		
		$this -> conn = $this -> openConn($this -> DB_NAME);
		
		if($this -> conn == false)
		{
			recordLog("connect database error");
			return ;
		}
		
		foreach($sqls as $sql)
		{
			//if($this -> DBOS == "windows") $sql = iconv("utf-8","gbk", $sql);  //php 操作 ms sql server 中文问题
			$stmt = sqlsrv_query($this -> conn,$sql);
		}

		$result = array();
		
		while( $row = sqlsrv_fetch_array($stmt))
		{
			foreach($row as $k=>$v){
				if(is_object($row[$k])){ 
				$dateoutput = (array)$row[$k];
				if($k=="To_Date") $row[$k]=date("Y/n/j",strtotime($dateoutput['date']));
				elseif($k=="To_Time") $row[$k]=date("G:i:s",strtotime(substr($dateoutput['date'],strrpos($dateoutput['date'],' '))));
				}
			}
			//if($this -> DBOS == "windows") $row = iconv_array(array_change_key_case($row));
			//else 
			$row = array_change_key_case($row);
			$result[] = $row;
		}
		
		sqlsrv_free_stmt( $stmt);

		$this -> closeConn() ;
		
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