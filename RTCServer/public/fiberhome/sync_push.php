<?php
/**
 * 烽火同步推送系统

 * @date    20150519
 */
require_once("fun.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//推送通用函数
////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
method:推送接口
param:$method 方法
param:$param 参数
return:response
*/
function sync_push($method,$param)
{
	$url = FIBERHOME_API . "?method=" . $method. "&v=2.0&format=json"; 
	
	//jc 20150524 现在是POST方式，所以不在这里处理了
	/*
	foreach($param as $key=>$value)
		$url .= "&" . $key . "=" . $value ;
	*/
	$result = send_http_post($url,$param);
	
	
	//推送返回处理
	sync_push_callback($result);
}


/*
method:推送返回处理
param:$result {code:1,message:""}
*/
function sync_push_callback($result)
{
	if ($result == "")
		return ;
		
	$logId = g("logid",0);
	$obj = json_decode ( $result );
	
	//同步推送状态
    $syncStatus = 1 ;
	 
	//同步推送结果
	$syncResult = "" ;
	

    if($obj->code)
    {
        if($obj->code == "1")
            $syncStatus = 2;
        $syncResult = $obj->message;
    }


	$ant = new AntSync();
	$ant -> sync_push_callback($syncStatus,$syncResult);
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//部门推送
////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
method:部门修改
from:http://127.0.0.1:8041/public/sync.html?op=sync&datatype=DEPT&data=4_17&optype=EDIT&receiver=&newcount=0
param:$dept_id emptype_empid
*/
function dept_edit_push($dept_id)
{
	$arr_emp = explode("_",$dept_id) ;	
	
	//如果部门是群组重命令的话
	if ($arr_emp[0] == "4")
	{
		//判断是否是群组
		$sql = " select Col_Type as c from hs_view where col_id=" . $arr_emp[1] ;
		
		$db = new DB();
		$viewType = $db -> executeDataValue($sql);
		if ($viewType == "8")
			group_change_push($arr_emp[1],2);
	}
}


function group_change_push($group_id,$status)
{
	$group = new Group();
	
	$group_id = $group_id;
	//得到群组信息
	$row = $group -> getGroupMoreInfo($group_id) ;

	//群组不存在
	if (count($row) == 0)
		return ;
	
	//得到群公告
	//$noticeid = $row["col_cur_noticeid"] ;
	$group_name = $row["col_name"] ;
	$group_type = $row["col_dtype"] ;
	$group_owner = $row["col_loginname"];
	$group_intro = $row["col_description"] ;
	$group_member = "" ;


	//修改群组，需加设置成员
	if ($status == 2)
	{
		$member = $group -> getMemberInfo($group_id) ;
		$group_member = str_replace(";",",",$member["loginnames"]) ;
	}
	
	//成员添加创建者(如果成员中创建者)
	if (isIn($group_member,$group_owner) == false)
		$group_member .= ($group_member == ""?"":",") . $group_owner ;

	//生成参数
	$param = array(
		"im_groupid"=> $group_id,
		"name"=>$group_name,
		"type"=>$group_type,
		"owner"=> $group_owner .RTC_DOMAIN ,
		"declared"=>$group_intro,
		"permission"=>0,
		"status"=>$status,
		"loginname"=>$group_member
	);
	
	//推送内容
	$result = sync_push("mapps.rtc.group.change",$param);
}

/*

*/
function group_delete_push($group_id)
{
	//生成参数
	$param = array(
		"im_groupid"=> $group_id,
		"name"=> "imgroup",
		"status"=> 0,
		"owner"=> "imsync" . RTC_DOMAIN
	);
	
	//推送内容
	sync_push("mapps.rtc.group.change",$param);
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//消息推送
////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*

*/
function msg_offline_push($msgId,$receiver,$newCount = 1,$msgType = "MSG")
{
	
	$msg = new Msg();

	//得到消息数据
	if ($msgType == "MSG")
    	$msg_data = get_message_content_msg($msgId);
	else
		$msg_data = get_message_content_board($msgId);
	
	//消息无效
	if (count($msg_data) == 0)
	{
		recordLog("推送消息失败，没有找到消息" . $msgId);
		return ;
	}
	
    $msgType 	= $msg_data['msgtype'];		//消息类型
    $talkId 	= trim($msg_data['talkid']); 	//消息talkid
	$groupId	= $msg -> get_group_id($talkId);
	$sendName 	= $msg_data['sendername']; 	//发送者
	$sender 	= removeDomain($msg_data['sender']) ; //发送者
	$title		= formatTitle($msgType,$sendName,$talkId,$msg_data['msgtitle']) ; //消息标题
	
	//生成参数
	$param = array(
		"username"=> $receiver,
		"msgtype"=> $msgType,
		"im_groupid"=> $groupId,
		"sendname"=> $sender,
		"unreadcount"=> $newCount,
		"title"=> $title
	);
	
	//推送内容
	sync_push("mapps.rtc.offline.msgnotice",$param);

}

/*
method	得到消息内容
param	msgType MSG BOARD
return	{msgtype=>"",msgtitle=>"",sender=>"",sendername=>"",talkid=>""}
*/

function get_message_content_msg($msgId)
{
	$datapath = g("datapath");
	
	//得到消息数据
	//jc 20150611 antserver推送与写数据库是两个进程，可能有先后顺序，所以采用传 datapath的方式,所以数据到文件中取
	if ($datapath == "")
	{
		$sql = " select col_datapath as c from ant_msg where col_id='" . $msgId . "'" ;
		
		$db = new DB();
		$datapath =  $db -> executeDataValue($sql);
	}

	
	if($datapath == "")
		return array();
	
	//读取文件内容
	$reader = new MsgReader ();
	$reader->read($msgId,$datapath);
	
	//生成返回数据
	$data ['msgtype'] = $reader->msgType;
	$data ['sender'] = $reader -> get_attr("sender");
	$data ['sendername'] = $reader -> get_attr("sendername");
	$data ['talkid'] = $reader -> get_attr("talkid");
	
	// MOS中只传消息标题，但这个消息是消息内容的前段，所在 msgtitle 是消息内容 ，群组消息的标题是群组名称，所以只能在消息文件中取内容
	$data ['msgtitle'] =  $reader->html;  //$reader->msgTitle;  不能用标题,群组消息的标题是群组名称
	return $data;
}


/*
//这里 数据是到数据表中取
function get_message_content_msg($msgId)
{
	
	//得到消息数据
	$m = new Model("ant_msg");
	$m -> field  = "col_subject,col_datapath,col_sender,col_sendername,col_talkid " ;
	$m->addParamWhere("col_id", $msgId);
	$row = $m->getDetail();
	
	if(count($row)==0)
		return array();
	
	//读取文件内容
	$reader = new MsgReader ();
	$reader->msgTitle = $row['col_subject'];
	$reader->read($msgId,$row['col_datapath']);
	
	//生成返回数据
	$data ['msgtype'] = $reader->msgType;
	$data ['sender'] = $row['col_sender'];
	$data ['sendername'] = $row['col_sendername'];
	$data ['talkid'] = $row['col_talkid'];
	// MOS中只传消息标题，但这个消息是消息内容的前段，所在 msgtitle 是消息内容 ，群组消息的标题是群组名称，所以只能在消息文件中取内容
	$data ['msgtitle'] =  $reader->html;  //$reader->msgTitle;  不能用标题,群组消息的标题是群组名称
	return $data;
}
*/

/*
method	得到公告k内容
param	msgType MSG BOARD
return	{msgtype=>"",msgtitle=>"",sender=>"",sendername=>"",talkid=>""}
*/
function get_message_content_board($msgId)
{
	//得到消息数据
	$m = new Model("ant_board");
	$m->field = "col_subject,col_datapath,col_creator as col_sender,col_creator_name as col_sendername,'' as col_talkid " ;
	$m->addParamWhere("col_id", $msgId);
	$row = $m->getDetail();

	if(count($row)==0)
		return array();

	//生成返回数据
	$data ['msgtype'] = 10;
	$data ['sender'] = $row['col_sender'];
	$data ['sendername'] = $row['col_sendername'];
	$data ['talkid'] = $row['col_talkid'];
	$data ['msgtitle'] = $row['col_subject'];
	$data ['msgcontent'] = $row['col_subject'];
	
	return $data;
}

	

	
 
/*
method:转换成MOS的格式 Title规则
普通消息:
张三发来一张图片
张三发来一段语音
张三发来一个文件
张三：这是一段文本消息

群聊提示:
张三：文本消息
张三在群聊中发来一张图片
张三在群聊中发来一段语音
张三在群聊中发来一个文件
*/
function formatTitle($msgType,$sendName,$talkId,$title)
{
	$str = $sendName;

	//talkId不为空则为群消息
	if(trim($talkId) !="")
	{
		$str .= "在群聊中";
	}
	switch ($msgType)
	{
		case 0:
			$title = $str . "发来一张图片";
			break;
		case 1:
			$title = $str . "发来一个文件";
			break;
		case 2:
			$title = $str . "发来一段语音";
			break;
		default:
			$title = mb_substr($title, 0,20, 'utf-8'); //消息标题
			$title = $sendName . ":" . $title;
			break;
	}
	return $title;
}
 
?>
