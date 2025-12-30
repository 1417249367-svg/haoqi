<?php


/**
 * 数据库 Oracle 类

 * @date    20141021
 */


class DBOracle extends DBAbstract
{

    private $DB_DSN = "";
	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{
		$this -> DB_SERVER = $dbServer ;
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> DB_PATH = $dbPath ;
		
		$this -> PARAM_SP = ":" ;
		$this -> SQL_SP = ";\r\n" ;

        //支持在不使用Oracle客户端的情况下连接远程数据库  2015.04.22 zwz
        //$this->DB_DSN = $dbServer;
	}

	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{
		error_reporting(0);

		$result = 0 ;
		$conn = oci_connect($this -> DB_USER,$this -> DB_PWD,$this->DB_NAME, 'UTF8');
		if(!$conn)
			$result = 0 ;
		else
			$result = 1 ;

		error_reporting(1);

		return $result ;
	}

	public function hasTable($table)
	{
		$sql = " select count(*) from " . $table ;
		error_reporting(0);
		$conn = oci_connect($this -> DB_USER,$this -> DB_PWD,$this -> DB_NAME, 'UTF8');
		$stid = oci_parse($conn, $sql);
		$result = oci_execute($stid , OCI_DEFAULT) ;
		oci_commit($conn);
		error_reporting(1);
		return $result ;
	}

	function formatValue($value,$type = "string")
	{

		switch($type)
		{
			case "datetime":
					return "TO_DATE('" . $value . "','yyyy-MM-dd')";
			default:
				return "'" . $value . "'" ;
		}
	}

	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		//$result ;
		//$stid ;
		//连接数据库
		$conn = oci_connect($this -> DB_USER,$this -> DB_PWD,$this->DB_NAME, 'UTF8');
		if (! $conn)
			return false ;

		//设置执行语句
		foreach($sqls as $sql)
		{
			$sql = str_replace("\r\n"," ",$sql);
			$stid = oci_parse($conn, $sql);
			//设置参数
			if (count($params)>0)
			{
				/*
				foreach($params as $param)
				{
					oci_bind_by_name($stid ,($this -> PARAM_SP) . $param["name"] ,$param["value"]);
				}
				*/
			}

			//执行语句，设置执行模式为自动提交
			$result = oci_execute($stid , OCI_DEFAULT);
			if (! $result)
				recordLog($sql);
		}

		oci_commit($conn);

		//记录错误日志
		$e = oci_error($stid);
		if ($e)
			recordLog($e['message']) ;


		//设置返回值
		if ($returnType == 0)
		{
			//$result = oci_num_rows($stid) ;
			$result = 1 ;
		}
		else
		{
			$result = array();
			$i = 0 ;

			while($row = oci_fetch_array($stid))
			{

				$result[$i] = array_change_key_case($row);
				$i += 1 ;
			}
		}
		oci_free_statement($stid);
		oci_close($conn);

		return $result ;
	}

	public function page($sql,$pageIndex,$pageSize)
	{
		$row = $this -> getPageRow($pageIndex,$pageSize);
		$sql = " select * from ( " . $sql . ")  where rownum>" . $row["begin"] . " and rownum<=" . $row["end"];
		return $this -> execute($sql,array(),1,0);
	}

}

?>