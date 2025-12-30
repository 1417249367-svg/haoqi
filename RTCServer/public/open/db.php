<?php  require_once("fun.php");?>
<?php  require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");?>
<?php  require_once(__ROOT__ . "/class/common/CharsetConv.class.php");?>
<?php
	$op = g("op") ;
	$printer = new Printer();


	switch($op)
	{
		case "save":
			save();
			break ;
		case "saveini":
			saveini();
			break ;
		case "saveclient":
			saveclient();
			break ;
		case "saveclientini":
			saveclientini();
			break ;
		default:
			break;
	}

	function save()
	{
		
		Global $printer;
	    $content = new SimpleIniIterator(__ROOT__ . '/lang.ini');
		$data=$content->getIniContent();
		reset($data);
		$db = new DB();
		while (list($key, $val) = each($data))
		{
		   if( is_array($val) ){
				while (list($key2, $val2) = each($val))
				{
				   //if( is_array($val) ) foreach( $val as $value) echo $value.'<br>'; 
				   //echo $key.'=>'.$key2.'=>'.$val2.'<br>'; 
					$sql = "insert into lang(key,key2,val2) values('". $key ."','". $key2 ."','". $val2 ."')";
					echo $sql.'<br>'; 
					$db->execute($sql);
				   
				}  
		   }
		}
	}
	
	function saveini()
	{
		
		Global $printer;
	    $content = new SimpleIniIterator(__ROOT__ . '/lang.ini');
		$data=$content->getIniContent();
		reset($data);
		$db = new DB();
		$sql = "Select * from lang";
		$data = $db -> executeDataTable($sql);
		foreach($data as $row)
		{
			$content->setIniValue($row["key2"], $row["val3"], $row["key"]);
			echo $row["key"].'=>'.$row["key2"].'=>'.$row["val3"].'<br>'; 
		}
	}

	function saveclient()
	{
		
		Global $printer;
		
	    $content = new SimpleIniIterator(__ROOT__ . '/langclient.ini');
		$data=$content->getIniContent();
		reset($data);
		$db = new DB();
		while (list($key, $val) = each($data))
		{
		   if( is_array($val) ){
				while (list($key2, $val2) = each($val))
				{
				   //if( is_array($val) ) foreach( $val as $value) echo $value.'<br>'; 
				   //echo $key.'=>'.$key2.'=>'.$val2.'<br>'; 
					$sql = "insert into langclient(key,key2,val2) values('". $key ."','". $key2 ."','". $val2 ."')";
					echo $sql.'<br>'; 
					$db->execute($sql);
				   
				}  
		   }
		}
	}

	function saveclientini()
	{
		
		Global $printer;
	    $content = new SimpleIniIterator(__ROOT__ . '/langclient.ini');
		$data=$content->getIniContent();
		reset($data);
		$db = new DB();
		$sql = "Select * from langclient";
		$data = $db -> executeDataTable($sql);
		foreach($data as $row)
		{
			$content->setIniValue($row["key2"], $row["val3"], $row["key"]);
			echo $row["key"].'=>'.$row["key2"].'=>'.$row["val3"].'<br>'; 
		}
	}

?>