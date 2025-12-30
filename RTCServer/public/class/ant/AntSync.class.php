<?php
/**
 *   同步推送系统
   1 遍历推送列表
   2 找到对应推送URL
   3 生成推送日志
   4 提交推送数据
   5 返回结果写入日志

 * @date    20150520
 */
class AntSync
{
    private $m;
    function __construct(){
        $this->m = new Model("ant_accesssystem");
        $this->m->field = "col_id,col_name";
    }
	
	/*
	mothed:同步推送
	param:$dataType 数据类型 GROUP MSG
	param:$data 数据内容 groupid/msgid
	param:$opType  操作类型 CREATE/EDIT/DELETE
	*/
	static function sync_push($dataType,$data,$opType)
	{
		if(! SYNC_PUSH)
			return array("status"=>0,"msg"=>"没有开启推送");
			
		$result = array("status"=>1,"msg"=>"");
		
		$antSync = new AntSync();
		
		//得到推送系统的字段 col_groupurl col_msgurl
		$sync_field = $antSync->get_sync_field($dataType);
        if($sync_field == "")
			return array("status"=>0,"msg"=>"推送类型错误");

			
		//得到推送列表
		$arr_push_list = $antSync->sync_push_list($sync_field);

		
		//得到推送地址
		$arr_url = array();
        foreach($arr_push_list as $key => $row)
		{
            //写入推送日志
            $logId = $antSync -> sync_push_log($dataType,$data,$opType,$row['col_name'],$row['col_id']);
			
			//得到推送接口地址
            $url = $row[$sync_field] ;
			$url = $url . "?logid=" . $logId . "&datatype=" . $dataType . "&data=" . $data . "&optype=" . $opType;
			
			$param = array();
            if(($dataType == "MSG") || ($dataType == "BOARD"))
			{
				$param["receiver"] = f("receiver") ; //如果公告发送全部人员，有可能是上万条数据，这里不能用GET方式
				$param["newcount"] = f("newcount") ;
			}
            //执行POST方式
			send_http_post($url,$param);
        }
		

		return $result ;

	}
	


	/*
	mothed:得到推送列表
	return:array("","")
	*/
	function sync_push_list($field)
	{
        $this->m->clearParam();

        $this->m->field = "col_id,col_name," . $field;
        $this->m->order("col_id");

        //排除禁用的
        $this->m->addParamWhere("col_disabled", 0);
        $this->m->addParamWhere($field, "","<>","string");

        $result = $this->m->getList();

        $result = table_fliter_doublecolumn($result,1);

        return $result;
	}
	
	/*
	mothed:推送日志登记
	param:$dataType DEPT/USER/GROUP/MSG
	param:$data  DEPT_ID/USER_ID...
	param:$opType CREATE/DELETE...
	param:$sysName ant_accesssystem.col_name
	param:$sysId ant_accesssystem.col_id
	return:logId
	*/
	function sync_push_log($dataType,$data,$opType,$sysName,$sysId)
	{
        $log = new Model("ant_sync_log");

        $fields = array(
            "Col_DataType" => $dataType,
            "Col_Data" => $data,
            "Col_SystemName" => $sysName,
            "Col_SystemId" => $sysId,
            "Col_OpType" => $opType
        );

        $log->addParamFields($fields);
        $log->insert();
        $logId = $log->getMaxId();
        return $logId;
	}
	
	/*
	mothed:推送日志登记
	*/
	function sync_push_callback($status,$result,$ip = "" )
	{
        $log = new Model("ant_sync_log");
		$logId = g("logid") ;
        $fields = array(
            "col_ipaddr" => $ip,
            "col_status" => $status,
            "col_dt_feedback" =>getNowTime(),
            "col_result" => $result
        );

        $log->addParamFields($fields);
        $log->addParamWhere("col_id", $logId,"=","int");
        $log->update();
	}
	
	/*
	mothed:根据类型获取相关的推送接口字段
	*/
    function get_sync_field($dataType){
        switch ($dataType){
            case "DEPT":
                return "col_depturl";
            case "USER":
                return "col_userurl";
            case "GROUP":
                return "col_groupurl";
            case "MSG":
                return "col_msgurl";
            case "BOARD":
                return "col_msgurl";
            default:
                return "";
        }
    }

}