<?php


/**
 * 数据库抽象类

 * @date    20141021
 */


class DBAbstract
{

	public $PARAM_SP = ":" ;
	public $SQL_SP = "GO" ;

	public $DB_SERVER = "" ;
	public $DB_NAME = "";
	public $DB_USER = "";
	public $DB_PWD = "";
	public $DB_PATH = "";
	public $DB_DRIVE = "" ;

	public function __construct($dbServer = "",$dbName = "",$dbUser = "",$dbPwd = "",$dbPath = "")
	{

	}



	public function execute($sqls,$params = array(),$returnType = 0 ,$cmdType = 0)
	{

	}



	public function page($sql,$pageIndex,$pageSize)
	{
	}


	public function testConn()
	{

	}

	public function createDataBase()
	{

	}

	public function hasTable($table)
	{
	}

	public function formatValue($value,$type = "string")
	{
	}

	//得到分页第几行开始，第几行结束
	public function getPageRow($pageIndex,$pageSize,$count = -1)
	{
		$row1 = ($pageIndex - 1) * $pageSize ;
		$row2 = $row1 + $pageSize ;

		if ($count > -1)
		{
			if ($row1 >= $count)
				$row1 = 0 ;
			if ($row1 < 0)
				$row1 = 0 ;
			if ($row2 > $count)
				$row2 = $count ;
		}
		return array("begin"=>$row1,"end"=>$row2);
	}
}

?>