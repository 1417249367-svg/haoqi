<?php
	require_once("fun.php");
	$op = g("op") ;
	$printer = new Printer();
	switch($op)
	{
		case "create":
			save();
			break ;
		case "edit":
			save();
			break ;
		case "detail":
			detail();
			break ;
		default:
			break ;
	}

	
	function save()
	{
		Global $printer;
		Global $op;
		$filefactpath = g("filefactpath","");
		$pos = new Model("hs_pos_info","col_pos_idx");
		
		
		$result = $pos->autoSave();
		
		
		if (! $result["status"])
			$printer -> fail("errnum:10008,msg:" . $result["msg"] ) ;

	
		//拷贝图标到系统目录下
		if($filefactpath != "")
		{
			$filesaveas = g("filesaveas");
			mkdirs(RTC_DATADIR . "\\WebRoot\\Posidx");
			
			recordLog($filefactpath);
			recordLog(RTC_DATADIR . "\\WebRoot\\Posidx\\" . $filesaveas);
			copy($filefactpath, RTC_DATADIR . "\\WebRoot\\Posidx\\" . $filesaveas);
		}
	
		if (! $result["status"])
			$printer -> fail("errnum:10008,msg:" . $result["msg"] ) ;
		else
			$printer -> success() ;
	
	}

	function detail()
	{
		Global $printer;
		$pos = new Model("hs_pos_info","col_pos_idx");
		$posIdx = g("id",0) ;
		$pos -> field("*") ;
		$pos -> addWhere("col_pos_idx=" . $posIdx) ;
		$row_pos = $pos-> getDetail() ;
		$printer -> out_detail($row_pos);
	}

?>