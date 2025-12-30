<?php


/**
 * 数据库 ODBC 类 Access Excel

 * @date    20141021
 */


class DBODBC extends DBAbstract
{

 	public $driver_type = "" ;
	
	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{	
		$file_type = substr($dbPath,strrpos($dbPath,".")+1);
		switch($file_type)
		{
			case "xls":
				$this -> DB_DRIVE = "Driver={Microsoft Excel Driver (*.xls)};" ;
				break ;
			case "mdb":
				$this -> DB_DRIVE = "Driver={Microsoft Access Driver (*.mdb)};" ;
				break ;
			case "asp":
				$this -> DB_DRIVE = "Driver={Microsoft Access Driver (*.mdb)};" ;
				break ;
		}
		$this -> DB_NAME = $dbName ;
		$this -> DB_USER = $dbUser ;
		$this -> DB_PWD = $dbPwd ;
		$this -> driver_type = $file_type ;
		$this -> DB_PATH = $dbPath ;
	}
	
	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{
		error_reporting(0);

		$result = 0 ;
		$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
		//$odbc = "Driver={Microsoft Access Driver (*.mdb)};Dbq=".$this -> DB_PATH;  
  
//$conn = odbc_connect($odbc, '', 'seekinfo', SQL_CUR_USE_ODBC);  
//        echo ($this -> DB_DRIVE) . "Dbq=".realpath($this -> DB_PATH).";";
//		        echo ($this -> DB_USER);
//						        echo ($this -> DB_PWD);
//		exit();
		if(!$conn)
		{
			$result = 0 ;
		}
		else
		{
			$result = 1 ;
		}

		error_reporting(1);

		return $result ;
	}
	

	function execute($sqls,$params = array(),$returnType = 0,$cmdType = 0)
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		$result = 1 ;

  		$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
//$odbc = "Driver={Microsoft Access Driver (*.mdb)};Dbq=".$this -> DB_PATH;  
//  
//$conn = odbc_connect($odbc, '', 'seekinfo', SQL_CUR_USE_ODBC);  
        //echo $conn;
		//exit();
		foreach($sqls as $sql)
		{
			$sql = iconv_str($sql,"utf-8","gbk");
			//$sql = $this -> formatSQL($sql);
			//echo "|".$sql."|";
			$stid = odbc_exec($conn, trim($sql));
			if (! $stid)
				$result = 0 ;
		}
				 //exit();
//		foreach($sqls as $sql)
//    		$rs = odbc_exec($conn,$sql);
//  		$conn1 = "D:/RTCServer/Web/Data/BBQ.asp";
//$odbc1 = "Driver={Microsoft Access Driver (*.mdb)};Dbq=".$conn1;
//
//$conn2 = odbc_connect($odbc1, '', 'seekinfo', SQL_CUR_USE_ODBC);
//$sql ="select * from Users_ID where UserName = 'ZHOULIN'";
//$stid1 = odbc_exec($conn,$sql);
//				echo "->".odbc_result($stid1,"UppeID")."</br>";
//				exit();
		if ($returnType == 0)
		{

		}
		else
		{
			$result = array();
			//$i = 0 ;

			while($row = odbc_fetch_array($stid))
			{
				// gbk to utf-8

				//$row = array_change_key_case($row) ;
				$row = iconv_array(array_change_key_case($row));

				$result[] = $row;
								//echo "->".$result["UserPaws"]."</br>";
				//$i += 1 ;
			}
		}
		
		odbc_free_result($stid);
		odbc_close($conn);
		return $result ; 
	}
	
	function executeMsg($sqls,$params = array())
	{
		if (! is_array($sqls) )
			$sqls = array($sqls) ;
			
		$result = 1 ;

  		//$conn = odbc_connect(($this -> DB_DRIVE) . "Dbq=".($this -> DB_PATH).";",($this -> DB_USER),($this -> DB_PWD), SQL_CUR_USE_ODBC);
		
		$conn = @new COM("ADODB.Connection") or die ("ADO Connection faild.");
		$connstr = "PROVIDER=Microsoft.Jet.OLEDB.4.0;Data Source=".($this -> DB_PATH).";Persist Security Info=False;Jet OLEDB:Database Password=".($this -> DB_PWD);
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
		$row = $this -> getPageRow($pageIndex,$pageSize);

		//2014-11-24 jc  limit start length
		//$sql = $sql . " LIMIT " . $row["begin"] . "," . $pageSize ;  // limit start length

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
			case "int":
				return "" . $value . "" ;
			default:
				return "'" . $value . "'" ;
		}
	}

}
	
?>