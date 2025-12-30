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
	
	public function DBMSSQL($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{
		//如果是默认端口，不要加，有的电脑上加上去就连不了
//		if (($dbPort != "") && ($dbPort != $this -> DEFAULT_DB_PORT))
//			$dbServer  = $dbServer . "," . $dbPort ;
		
		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;

		$this -> PARAM_SP = "@" ;
		$this -> SQL_SP = "GO" ;
		
		
	}
	
	/**
	 * 在createdatabase 时，要打开 master 数据库
	 * @param string $dbName
	 */
	function openConn($dbName = "")
	{
		//表示已经打开
		if ($this -> conn)
			return ;
		
		if ($dbName == "")
			$dbName = $this -> DB_NAME ;
		
		$connectionInfo = array( "Database"=> $dbName , "UID"=> $this -> DB_USER, "PWD"=> $this -> DB_PWD); 
		$this -> conn = sqlsrv_connect( $this -> DB_SERVER, $connectionInfo);
		return $this -> conn ;
	}
	
	function closeConn()
	{
		if ($this -> conn)
			sqlsrv_close($this -> conn);
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
		

		if(!($this -> conn))
		{
			
			//连接错误 或 数据库不存在
			//sqlsvr 中 conn 已经绑定数据库，所以我们这边先绑定  master 数据库来判断 数据库是否存在
			$this -> openConn("master");

			if ($this -> conn)
				return 2 ;
			else 
				return 0 ;

		}
		else
		{
			//连接成功
			$result = 1 ;
		}
		
		$this -> closeConn() ;
		
		error_reporting(1);
		return $result ;
	}
	

	
	public function createDataBase()
	{
		$currDB = $this -> DB_NAME ;
		
		$this -> closeConn();
		$this -> openConn("master") ;
		
		$sql = " create database " . $currDB ;
		
		$result = $this -> execute($sql);
		
		//创建完后要关闭数据库，否则还连的是 master
		$this -> closeConn();

		return $result ;
	}
	
	public function hasTable($table)
	{
		$conn = $this -> openConn();
		
		if ($conn == false)
			return 0 ;
		
		$sql = " select count(*) from " . $table ;
		
		error_reporting(0);
		$result = sqlsrv_query($sql,$conn);
		error_reporting(1);
		
		$this -> closeConn();
		
		return $result ;
	}
	
	
	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
	
		$result = 1 ;
		
		$this -> openConn();
		
		if($this -> conn == false)
		{
			recordLog("connect database error");
			return ;
		}

	
		//foreach($params as $param)
		//sqlsrv_bind($stid ,($this -> PARAM_SP) . $param["name"] ,$param["value"]);
	
		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");  //php 操作 ms sql server 中文问题
			//echo $sql ;
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
			
			while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))
			{
//				for($j=0;$j<count($row);$j++){   
//					if(is_object($row[$j])){ 
//					$dateoutput = (array)$row[$j];
//                    $row[$j]=$dateoutput['date'];
//					}
//				}
				
				foreach($row as $k=>$v){
					//echo $row[$k];
					if(is_object($row[$k])){ 
					$dateoutput = (array)$row[$k];
                    $row[$k]=substr($dateoutput['date'],0,strrpos($dateoutput['date'],'.'));
					}
				}
				
				$row = iconv_array(array_change_key_case($row));
				$result[] = $row;
			}
			
//			$result = sqlsrv_fetch_array( $stmt,SQLSRV_FETCH_NUMERIC) ;
//			for($j=0;$j<count($result);$j++){   
//				if(is_object($result[$j])) {
//				print_r($result[$j] -> date);//总结PHP中DateTime的常用方法http://www.jb51.net/article/90279.htm
//				}
//			}
			
		}
		sqlsrv_free_stmt( $stmt);

		//$this -> closeConn() ;
		//exit();
		return $result ;
	}
	


	function executeMsg($sqls,$params = array())
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		$result = 1 ;

  		//$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
		
		$this -> openConn();
		
		if($this -> conn == false)
		{
			recordLog("connect database error");
			return ;
		}
		
		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");  //php 操作 ms sql server 中文问题
			$stmt = sqlsrv_query($this -> conn,$sql);
		}

		$result = array();
		
		while( $row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))
		{
			foreach($row as $k=>$v){
				if(is_object($row[$k])){ 
				$dateoutput = (array)$row[$k];
				if($k=="To_Date") $row[$k]=date("Y/n/j",strtotime($dateoutput['date']));
				elseif($k=="To_Time") $row[$k]=date("G:i:s",strtotime(substr($dateoutput['date'],strrpos($dateoutput['date'],' '))));
				}
			}
			$row = iconv_array(array_change_key_case($row));
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