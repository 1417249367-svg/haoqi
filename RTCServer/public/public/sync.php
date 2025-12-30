<?php
/*
同步到接入系统
*/
    $_GET = array_change_key_case($_GET, CASE_LOWER);
    date_default_timezone_set('PRC');

    define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
    require_once (__ROOT__ . "/config/config.inc.php");
    require_once (__ROOT__ . "/class/common/Site.inc.php");
    require_once (__ROOT__ . "/class/common/Printer.class.php");
    require_once (__ROOT__ . "/class/db/DB.class.php");
    require_once (__ROOT__ . "/class/db/Model.class.php");
    require_once (__ROOT__ . "/class/ant/AntSync.class.php");


    $op = g ( "op" );

	$printer = new Printer ();
	switch ($op) {
		case "sync" :
			sync();
			break;
		default :
			break;
	}



    function sync(){

        Global $printer;
		
		//jc 20150518 
		recordLog("开始同步");
		$dataType = strtoupper(g("datatype"));
		$data = g("data");
		$opType = strtoupper(g("optype"));
		$result = AntSync::sync_push($dataType,$data,$opType) ;
		recordLog("结束同步");
		if ($result["status"] == 1)
			$printer -> out_str('{"status":1,"msg":"' . $dataType . "&&" . $data . '"}') ;
		else
			$printer -> fail($result["msg"]);
 
		/*
        $arr_url = array();

        $dataType = strtoupper(g("datatype","DEPT"));   //同步的视图类型  有  DEPT、USER、GROUP、MSG
        $opType = strtoupper(g("optype"));              //操作类型 DEPT、USER、GROUP有 CREATE,EDIT,DELETE  MSG有 TEXT,FILE等
        $data = g("data");
        $newCount = g("newcount",1);

        //消息文件不存在则不写同步日志也不调用烽火的同步接口
        if($dataType == "MSG")
        {
            $m = new Model("ant_msg");
            $m->addParamWhere("col_id", $data);
            $dataPath = $m->getField("col_DataPath");
            $dataPath = RTC_DATADIR . "\\" . $dataPath . $data . ".msg";
            if(file_exists( $dataPath ))
                $printer -> fail("消息文件不存在");
        }

        $antSync = new AntSync();
        $field = $antSync->get_field($dataType);

        if($field == "")
            $printer -> fail("参数错误");
        $arr_accessSystem = $antSync->get_access_system($field);

        foreach($arr_accessSystem as $key => $row){
            $log = new Model("ant_sync_log");
            $log->field = "";
            $log->getTop(1);
            //写入同步日志
            $logId = $antSync -> log($dataType,$data,$opType,$row['col_name'],$row['col_id']);
            $url = $row[$field] . "?logid=" . $logId . "&datatype=" . $dataType . "&data=" . $data . "&optype=" . $opType;
            if($dataType == "MSG")
                $url .= "&receiver=" . g("receiver","") . "&newcount=" . $newCount;
            $arr_url[] = $url;
        }

        ob_clean();
        print ('{"status":1,"msg":"' . $dataType . "&&" . $data . '"}');
        //$printer -> success($dataType . "&&" . $data);
        //调用接入系统配置的接口
        $antSync->send_post($arr_url);
		*/
    }
?>