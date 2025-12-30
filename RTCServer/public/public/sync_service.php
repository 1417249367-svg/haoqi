<?php
$_GET = array_change_key_case($_GET, CASE_LOWER);
date_default_timezone_set('PRC');

define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once (__ROOT__ . "/config/config.inc.php");
require_once (__ROOT__ . "/class/common/Site.inc.php");
require_once (__ROOT__ . "/class/ant/AntWebConfig.class.php");
require_once (__ROOT__ . "/class/common/Printer.class.php");
require_once (__ROOT__ . "/class/db/DB.class.php");
require_once (__ROOT__ . "/class/db/Model.class.php");
require_once (__ROOT__ . "/class/ant/AntSync.class.php");
$arr_url = array();
$log = new Model("ant_sync_log");
$antSync = new AntSync();
$log->addParamWhere("col_dt_create",SYNC_TIME,">=","date");
$arrLog = $log->getList();

foreach ($arrLog as $logRow){

    $field = $antSync->get_field($logRow['col_datatype']);

    $arr_accessSystem = $antSync->get_access_system($field);

    foreach($arr_accessSystem as $key => $row){
        $arr_url[] = $row[$field] . "?logid=" . $logRow['col_id'] . "&datatype=" . $logRow['col_datatype'] . "&data=" . $logRow['col_data'] . "&optype=" . $logRow['col_optype'];
    }

}

$antSync->send_post($arr_url);