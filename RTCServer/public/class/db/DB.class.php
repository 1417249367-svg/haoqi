<?php
require_once(__ROOT__ . '/class/db/DBAbstract.class.php') ;
//if (version_compare("5.4", PHP_VERSION, ">")) 
//{
//    require_once(__ROOT__ . '/class/db/DBMSSQL.class.php') ;
//}
//else 
//{
//	require_once(__ROOT__ . '/class/db/DBSqlSrv.class.php') ;
//}
require_once (__ROOT__ . "/class/db/db_sqlsrv.class.php");
require_once(__ROOT__ . '/class/db/DBMYSQL.class.php') ;
require_once(__ROOT__ . '/class/db/DBOracle.class.php') ;
require_once(__ROOT__ . '/class/db/DBODBC.class.php') ;
if (version_compare("7.0", PHP_VERSION, ">")) 
{
    require_once(__ROOT__ . '/class/db/db_dm.class.php') ;
}
else 
{
	require_once(__ROOT__ . '/class/db/db_dm7_class.php') ;
}
/**
 * 数据库工厂类

 * @date    20141021
 */
class DB
{

	public $PARAM_SP = "" ;
	public $SQL_SP = "" ;
	public $dbEntity   ;
	public $dbType = "" ;
	public $dbName = "" ;
	public $isLog = 1 ;
	public function __construct($dbType = "",$dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "",$dbPort = "")
	{
		
		//FROM CONFIG.INC.PHP
		if ($dbType == "")
		{
			$dbType 	= DB_TYPE ;
			$dbServer 	= DB_SERVER ;
			$dbName 	= DB_NAME ;
			$dbUser 	= DB_USER ;
			$dbPwd 		= DB_PWD ;
			$dbPath 	= DB_PATH ;
			$dbPort 	= DB_PORT ;
		}
		

		if ($dbType == "mariadb")
			$dbType = "mysql"  ;

		$this -> dbType = $dbType ;
		$this -> dbName = $dbName ;
 		$this -> dbEntity = $this -> getDB($dbType,$dbServer,$dbName,$dbUser,$dbPwd,$dbPath,$dbPort);
		$this -> PARAM_SP = $this -> dbEntity -> PARAM_SP ;
		$this -> SQL_SP = $this -> dbEntity -> SQL_SP ;

	}

	// 0 连接错误 1 success 2 连接成功(数据库不存在)
	public function testConn()
	{
		return $this -> dbEntity -> testConn();
	}

	// 创建数据库
	public function createDataBase()
	{
		return $this -> dbEntity -> createDataBase();
	}

	public function hasTable($table)
	{
		return $this -> dbEntity -> hasTable($table);
	}



	 function getDB($dbType,$dbServer,$dbName,$dbUser,$dbPwd,$dbPath,$dbPort = "")
	 {
        switch($dbType)
        {
			case "mssql":
				return $this -> dbEntity = new DBMSSQL($dbServer,$dbName,$dbUser,$dbPwd,$dbPath,$dbPort);
				break ;
			case "mysql":
				if ($dbPort != "")
					$dbServer  = $dbServer . ":" . $dbPort ;
				return $this -> dbEntity = new DBMYSQL($dbServer,$dbName,$dbUser,$dbPwd,$dbPath);
				break ;
			case "oracle":
				return $this -> dbEntity = new DBOracle($dbServer,$dbName,$dbUser,$dbPwd,$dbPath);
				break ;
			case "dm":
				return $this -> dbEntity = new DBDM($dbServer,$dbName,$dbUser,$dbPwd,$dbPath,$dbPort);
				break ;
			case "access":
				return $this -> dbEntity = new DBODBC($dbServer,$dbName,$dbUser,$dbPwd,$dbPath);
				break ;
			case "odbc":
				return $this -> dbEntity = new DBODBC($dbServer,$dbName,$dbUser,$dbPwd,$dbPath);
				break ;
		}
		
	 }


	public function execute($sqls,$params = array(),$returnType = 0 ,$cmdType = 0)
	{
		//将它转为数组
		if (! is_array($sqls) )
		{
			if ($sqls == "")
				return 1 ;
			$sqls = array($sqls) ;
		}
		else
		{
			//空的ARRAY
			if (count($sqls) == 0)
				return 1 ;
		}

		 
		//if ($this -> isLog)
		//{
			foreach($sqls as $sql){
				recordLog($sql . ";");
//				echo $sql;
//				exit();
			}
		//}

		return $this -> dbEntity -> execute($sqls,$params,$returnType,$cmdType);
	}



	public function page($sql,$pageIndex,$pageSize)
	{
		return $this -> dbEntity -> page($sql,$pageIndex,$pageSize);
	}



    /**
     * 执行返回表格
     */
	public function executeDataTable($sqls,$params = array(),$type = 0)
	{
//		echo $sqls;
//		exit();
		$data = $this -> execute($sqls,$params,1,$type);

		return $data ;
	}

    /**
     * 执行返回行 ,array
     */
	public function executeDataRow($sqls,$params = array(),$type = 0)
	{
		$data = $this -> execute($sqls,$params,1,$type);
		if (count($data) == 0)
			return array() ;
		else
			return $data[0] ;
	}


    /**
     * 执行返回值
     */
	public function executeDataValue($sqls,$params = array(),$type = 0)
	{
		$data = $this -> execute($sqls,$params,1,$type);
		if (count($data) == 0)
			return "" ;
		else
			return $data[0]['c'] ;
	}


    /**
     * 得到INSERT语句
     */
	public function getInsertSQL($tableName,$fieldParams)
	{
		$sql = "" ;
		$fields = "" ;
		$values = "" ;
		foreach($fieldParams as $param)
		{
			if ($fields != "")
			{
				$fields .= "," ;
				$values .= "," ;
			}
			$fields .= $param["name"] ;
			$values .= $this -> dbEntity-> formatValue($param["value"],$param["type"]) ;  // by sql
			//$values .= $this -> getParamValueExp($param["type"],$param["name"])  ;  // by param
		}

		$sql = " insert into " . $tableName . "(" . $fields. ") values(" . $values . ")" ;
//        switch ($this -> dbType)
//        {
//            case "dm":
//                $sql = $sql . ";commit;";
//                break;
//        }
		return $sql ;
	}
	
    /**
     * 得到INSERT语句
     */
	public function getInsertSQL_key($tableName,$fieldParams)
	{
		$sql = "" ;
		$fields = "" ;
		$values = "" ;
		foreach($fieldParams as $key => $value)
		{
			if ($fields != "")
			{
				$fields .= "," ;
				$values .= "," ;
			}
			$fields .= $key ;
			$values .= $this -> formatValue($value,"string") ;  // by sql
		}

		$sql = " insert into " . $tableName . "(" . $fields. ") values(" . $values . ")" ;

		return $sql ;
	}


    /**
     * 得到更新语句
     */
	public function getUpdateSQL($tableName,$fieldParams,$where = "")
	{
		$sql = "" ;

		foreach($fieldParams as $param)
		{
			if ($sql != "")
				$sql .= "," ;
			$value = $this -> dbEntity-> formatValue($param["value"],$param["type"]) ;
			$sql .= $param["name"] . "=" . $value ;  // by sql
			//$sql .= $param["name"] . "=" . ($this -> getParamValueExp($param["type"],$param["name"])) ;  // by param
		}

		$sql = " update " . $tableName . " set " . $sql . ($this -> parseWhere($where)) ;

		return $sql ;
	}
	

    /**
     * 得到INSERT语句
     */
	public function getUpdateSQL_key($tableName,$fieldParams)
	{
		$sql = "" ;
		foreach($fieldParams as $key => $value)
		{
			if ($sql != "")
				$sql .= "," ;
			$value = $this -> dbEntity-> formatValue($value,"string") ;
			$sql .= $key . "=" . $value ;  // by sql
		}

		$sql = " update " . $tableName . " set " . $sql . ($this -> parseWhere($where)) ;

		return $sql ;
	}

	public function getParamValueExp($type,$name)
	{
		if (($this -> dbType == "oracle") && ($type == "datetime"))
			return "TO_DATE(" . $this -> PARAM_SP . $name . ",'YYYY-MM-DD')" ;

		return $this -> PARAM_SP . $name ;
	}

    /**
     * 得到删除语句
     */
	public function getDeleteSQL($tableName,$where = "")
	{
		$sql = " delete from " . $tableName . ($this -> parseWhere($where)) ;
		return $sql ;
	}

	public function getWhereSQL($whereParams)
	{
		$sql = "" ;
		$PARAM_SP = $this -> PARAM_SP ;
		foreach($whereParams as $param)
		{
			if ($sql != "")
				$sql .= " and " ;
			$sql .= $param["name"] . "=" . $PARAM_SP . $param["name"] ;
		}
		return $sql ;
	}

    /**
     * 得到查询语句
     */
	public function getSelectSQL($tableName,$fields = "*",$where = "",$order = "")
	{
		$where =  $this -> parseWhere($where) ;
		$order = $this -> parseOrder($order) ;
		return $sql = " select  " . $fields . " from  " . $tableName . $where . $order;
	}

    /**
     * 执行TOP语句
     */
	public function getTopSQL($tableName,$fields = "*",$where = "",$order = "",$top)
	{
		$where =  $this -> parseWhere($where) ;
		$order = $this -> parseOrder($order) ;

		if ($fields == "*")
			$fields = $tableName . "." . $fields ;


        switch ($this -> dbType)
        {
            case "oracle":
				$where = $this -> addWhere($where," ROWNUM<" . $top) ;
                $sql = " select  " . $fields . " from  " . $tableName . $where . $order;
                break;
			case "mysql":
				$sql = " select  " . $fields . " from " . $tableName .  $where . $order . " LIMIT 0," . $top;
				break;
            default:
                $sql = " select top " . $top . " " . $fields  . " from " . $tableName . $where . $order;
//				echo $sql;
//				exit();
                break;
        }
		return $sql ;
	}

    /**
     * 得到分页语句
     */
	public function getPageSQL($tableName,$field_id = "col_id",$fields = "*",$where = "",$order = "",$orderdesc = "",$pageIndex,$pageSize,$count)
	{
		$row1 = ($pageIndex - 1) * $pageSize ;
		$row2 = $row1 + $pageSize ;
		if($row2>$count) $pageSize=$count-$row1;
		$where =  $this -> parseWhere($where) ;
		$order = $this -> parseOrder($order) ;
		$orderdesc = $this -> parseOrder($orderdesc) ;

//		if ($fields == "*")
//			$fields = $tableName . "." . $fields ;

        switch ($this -> dbType)
        {
            case "oracle":
                $sql = " select rownum as rn, " . $fields . " from  " . $tableName . $where . $order;
				$sql = " select * from ( " . $sql . ")  where rn>" . $row1 . " and rn<=" . $row2;
                break;
			case "mysql":
				$sql = " select  " . $fields . " from " . $tableName .  $where . $order . " LIMIT " . $row1 . "," . $pageSize ;
				break ;
			case "access":
				$sql = "SELECT * from (SELECT TOP " . $pageSize . " " . $fields . " FROM (SELECT TOP " . $row2 . " " . $fields . " FROM " . $tableName .  $where . $order . ") A " . $orderdesc . ") B" . $order ;
//				echo $sql;
//				exit();
				break ;
            default:
				$sql = "SELECT * from (SELECT TOP " . $pageSize . " " . $fields . " FROM (SELECT TOP " . $row2 . " " . $fields . " FROM " . $tableName .  $where . $order . ") A " . $orderdesc . ") B" . $order ;
//                echo $sql;
//				exit();
				break;
        }
		return $sql ;
	}



    /**
     * 将数据转为带格式的参数
     * @param mixed $data 字段参数
     * @return [{"name":"col_id","value","1","type":"int"},{"name":"col_id","value","1","type":"int"}]
     */
	public function parseDataParam($data = array())
	{
		$params = array();
		$i = 0 ;
		foreach($data as $key=>$value)
		{
			$type = "string" ;
			$params[$i] = array("name"=>$key,"value"=>$value,"type"=>$type) ;
			$i += 1 ;
		}

		return $params ;
	}

	public static function getDataParam($name,$value,$type)
	{
		return array("name"=>$name,"value"=>$value,"type"=>$type) ;
	}

    /**
     * 合并参数
     * @param mixed $data 字段参数
     * @param mixed $whereParam 条件参数
     * @return array
     */
	public function unionParam($data = array(),$whereParam = array())
	{
		$param = array();
		foreach($data as $key=>$value)
		{
			if ($key != "")
				$param[$key] = $value ;
		}
		foreach($whereParam as $key=>$value)
		{
			if ($key != "")
				$param[$key] = $value ;
		}
		return $param ;
	}



    /**
     * 添加一个WHERE条件
     * @param mixed $where  原WHERE
	 * @param mixed $apendWhere  添加的WHERE
     * @return string
     */
	public function addWhere($where,$apendWhere)
	{
		if (trim($apendWhere) == "")
			return $where ;
		return $where . ($where == ""?" where ":" and ") . $apendWhere ;
	}

    /**
     * 得到SQL 的 WHERE语句
     * @param mixed $where
     * @return string
     */
	public function parseWhere($where)
	{
		if ($where != "")
			$where = "  " . $where ;
		return $where ;
	}

    /**
     * 得到SQL 的 ORDER语句
     * @param mixed $order
     * @return string
     */
	private function parseOrder($order)
	{
		if (empty($order))
			$order = "" ;
		if ($order != "")
			$order = " order by " . $order ;
		return $order ;
	}




    /**
     * 指定查询数量
     * @access public
     * @param mixed $data 执行结果
     * @return object
     */
    function parseDataValue($data,$defaultValue = "")
    {
		$rows = parseDataTable($data) ;
        if (count($rows) == 0)
			return $defaultValue ;
		else
			return $rows[0][0] ;
    }

	function getColumnValues($data,$field)
	{
		$field = strtolower($field);
		$result = "" ;
		foreach($data as $row )
		{
			if ($result != "")
				$result .= "," ;
			$result .= $row[$field] ;
		}
		return $result ;
	}



	function getMaxId($tableName,$pk)
	{
		switch (DB_TYPE)
		{
			case "access":
				$sql = " select max(clng(" . $pk . ")) as c from " . $tableName ;
				break ;
			default:
				$sql = " select max(CONVERT(int," . $pk . ")) as c from " . $tableName ;
				break;
		}
//		echo $sql;
//		exit();
		return $this -> executeDataValue($sql) ;
	}

	function getSelectDateField($field_date)
	{

		//解决oracle上报  '未找到要求的 FROM 关键字'的问题   2015.01.22
		$arrTemp = explode(".", $field_date);
		$new_field = count($arrTemp)>1 ?  $arrTemp[1] : $field_date;
		switch($this -> dbType)
		{
			case "oracle":
				return  "to_char(" . $field_date . ",'YYYY-MM-DD HH24:MI:SS') as " . $new_field ;
			default:
				return $field_date ;
		}
	}

 
	/*
	method 	得到字段内容相加 jc 20150709
	param	可变参数
	*/ 
	function getSelectFieldAdd()
	{
		$exp = "" ;
		$arg_array  = func_get_args();
		foreach($arg_array as $arg)
		{
			switch($this -> dbType)
			{
				case "mysql":
					$exp .= ($exp?",":"") . $arg;
					break;
				default:
					$exp .= ($exp?"+":"") . $arg;
					break;
			}
			
		}
		
		if ($this -> dbType == "mysql")
			$exp = "CONCAT(" . $exp . ")";
		return $exp ;
	}
		
	/*
	method 	得到查询表达式 jc 20150709
	param	$name 	字段名
	param	$value 	值
	param	$op 	操作		 
	param	$type 	值格式	 string/date
	*/ 
	function getSearchExp($name,$value,$op = "=",$type = "string")
	{
		if (($type == "date") && ($value == ""))
			return "" ;

		if ($type == "string")
			$value = "'" . $value . "'" ;

		if($type == "date")
		{
//			if ($op == "<" || $op=="<=")
//			{
//				// 加一天
//				$time = strtotime($value);
//				$time = $time +  (24 * 60 * 60);
//				$value = date("Y-m-d",$time) ;
//			}
			
			switch ($this -> dbType)
			{
				case "oracle":
					$value = "to_date('" . $value . "','yyyy-mm-dd')" ;
					break;
				case "access":
					$value = "#" . $value . "#" ;
					break ;
				default:
					$value = "'" . $value . "'" ;
					break;
			}
		}

		if ($op == "in")
			$value = "(" . $value . ")" ;
		
		$exp = $name . " " . $op . " ". $value ;
		return $exp ;
	}
	
	
	function createParam($name,$value,$type = "string")
	{
		return array("name"=>$name,"value"=>$value,"type"=>$type) ;
	}


    /**
     * 将读取SQL语句文件
     */
	function readSQLFile($filepath)
	{
		
		$content = readFileContent($filepath);
		//$content = iconv_str($content) ;

		//删除 oracle 结尾符
		if ($this -> dbType == "oracle")
		{
			$content = str_replace("\r\n/\r\n",";",$content) ;
			$content = str_replace("\r\n/",";",$content) ;
		}

		//删除 mysql 结尾符
		if ($this -> dbType == "mysql")
		{
			$content = str_replace("delimiter $$","delimiter @@",$content) ;
			$content = str_replace("$$\r\n","",$content) ;
			$content = str_replace("delimiter @@","delimiter $$",$content) ;
		}
	
		//用GO分隔
		$sqls = explode($this->SQL_SP,$content);

		return $sqls ;
	}


}

?>