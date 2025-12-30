<?php  require_once(__ROOT__ . "/class/hs/User.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgSender.class.php");?>
<?php
/**
 * 群组管理

 * @date    20140410
 * 20150513加入 加人，删人，删群组，重命名群组的通知
 	群组消息命令
	msgflag:530
	msgtype:14
	receive-users:loginname;zs@aipu.com;jc@aipu.com
	subject:groupname

	加人
	ADD:jincun@fiberhome;jincun@fiberhome

	删人
	DEL:loginname:username

	退群
	QUI:groupid;loginname;username:
	
	删群
	DEG:Group

	重命名群
	REG:groupname
 */
class Group extends Model {

	function __construct() {
		$this->tableName = "Clot_Ro";
		$this->db = new DB ();
	}
	
	function getGroupId() {
		$sql = " select max(TypeID) as c from Clot_Ro";
		$types =$this -> db -> executeDataValue($sql);
		if(empty($types)) $types="Clot000000";
		$newid=substr($types,-6);
		$newid=$newid+1;
		$newid=$newid+1000000;
		return "Clot".substr($newid,-6);
	}
	
	// 群组添加
	function addAnGroup($groupName,$sender,$itemIndex, $description,$create_userid) 
	{
		$groupId = $this ->getGroupId();
		$fields = array (
				'TypeID' => $groupId,
				'TypeName' => $groupName,
				'ItemIndex' => $itemIndex,
				'Remark' => $description,
		        'Sender' =>$sender,
		        'OwnerID'=>$create_userid,
				'CreatorID' =>$create_userid
		);
		$this -> save ( $fields );
		$sql = "INSERT INTO Clot_Pic(ClotID) values('". $groupId ."')";
		$this -> db -> execute($sql);
		$doc_file = new Model ( "Users_ID" );
		$doc_file -> addParamWhere("UserID", $create_userid);
		$row = $doc_file->getDetail ();
		$this -> addMember($groupId,$create_userid,1,$row ["fcname"],$row ["username"]);
		return $groupId ;
	}

	function deleteAnGroup($groupId) {
	
		//发送通知,先发通知，再删除（否则成员找不到，消息发送无效）
		//$this -> sendNotify($groupId,"DEG:Group");
	
		$sqls = array (
				"Delete from Clot_Ro where TypeID='" .$groupId. "'",
				"Delete from Clot_Form where UpperID='" .$groupId. "'",
				"Delete from Clot_Pic where ClotID='" .$groupId. "'",
				"Delete from ClotFile where ClotID='" .$groupId. "'",
				"Delete from MessengClot_Text where ClotID='" .$groupId. "'"
				//"Delete from MessengClot_Type where ClotID='" .$groupId. "'"
		);
		$result = $this->db->execute ( $sqls );
		return $result;
	}
	
	function updateAnGroup($groupId,$groupNewName,$itemIndex, $description) 
	{
		//发送通知
//		$groupName = $this -> getGroupName($groupId);
		
		//如果群组更名，发送更名通知
//		if ($groupName != $groupNewName){
//			//$this -> sendNotify($groupId,"REG:" . $groupNewName);
//			$msg = new Msg ();
//			$msg ->sendRTCMessge("admin",$groupId,"", "REG:" . $groupNewName,"",1);
//		}

	
		$this -> clearParam ();
		$fields = array (
				'TypeName' => $groupNewName ,
				'ItemIndex' => $itemIndex,
				'Remark' => $description
		);

		$this-> save ( $fields, $groupId );
		return true;
	}

	/*
	method:设置成员
	param:$groupId 
	param:$userIds
	param:$flag 0 append  1 reset
	return:
	*/
	function setMember($groupId, $userIds, $flag) {
	
		$relation = new EmpRelation ();
		$result = $relation -> setRelation ( 0, EMP_GROUP, $groupId, "", EMP_USER, $userIds, $flag );
		
//		$user = new User();
//		$groupName = $this -> getGroupName($groupId);
//		
//		//发送添加人的通知
//		$users_add =  $user -> listUserWithUserIdArray($result["add"])  ;
//		if (count($users_add)>0)
//		{
//			$loginNames = table_column_tostring($users_add,"col_loginname",",") ;
//			$userNames = table_column_tostring($users_add,"col_name",",") ;
//			$this -> sendNotify_AddMember($groupId,$loginNames,$userNames);
//		}
//
//		//发送删除人的通知(删除人员应通知所有成员)
//		$users_delete =  $user -> listUserWithUserIdArray($result["delete"])  ;
//		if (count($users_delete)>0)
//		{
//			$loginNames = table_column_tostring($users_delete,"col_loginname",",") ;
//			$userNames = table_column_tostring($users_delete,"col_name",",") ;
//			$this -> sendNotify_RemoveMember($groupId,$loginNames,$userNames);
//		}
	
	}
	
	/*
	method:添加人员(单人)
	param:$groupId 
	param:$userId
	param:$loginName 不带域名
	param:$userName
	return:操作成功的 loginNames
	*/
	function addMember($groupId,$userIds,$IsAdmins,$remarks,$loginNames)
	{

		$empRelation = new EmpRelation ();
		
		$arr_userId = explode(",",$userIds);
		$arr_IsAdmin = explode(",",$IsAdmins);
		$arr_remark = explode(",",$remarks);
		$arr_loginName = explode(",",$loginNames);
		$arr_sql = array();
		
		//设置发送消息的人员
		$loginNames = "" ;
		$userNames = "" ;
		
		$TypeID=$empRelation -> TopTypeID($groupId);
		for($i=0;$i<count($arr_userId);$i++)
		{
			$userId = $arr_userId[$i] ;

			//判断关系是否存在
			$isExist = $empRelation->isRelation(EMP_GROUP, $groupId, EMP_USER, $userId) ;
			
			if ($isExist)
				continue ;

				
			//添加关系
			$arr_sql[] = "insert into Clot_Form(UpperID,UserID,IsAdmin,remark,last_ack_typeid1,last_ack_typeid2,last_ack_typeid3,last_ack_typeid4) values('". $groupId ."','". $arr_userId[$i] ."',". $arr_IsAdmin[$i] .",'". $arr_remark[$i] ."',". $TypeID .",". $TypeID .",". $TypeID .",". $TypeID .")";
//			$empRelation->setRelation ( $groupId, EMP_GROUP, $groupId, "", EMP_USER, $userId, 0 );
//			
			$loginNames .= ($loginNames == ""?"":",") . $arr_loginName[$i] ;
			$userNames .= ($userNames == ""?"":",") . $arr_remark[$i] ;
		}
//		echo var_dump($arr_sql);
//		exit();
		$this -> db -> execute($arr_sql);
//        $sql = "delete from Clot_Form where UpperID='". $groupId ."' and id not in(select min(id) from Clot_Form where UpperID='". $groupId ."' group by UserID)";
//		$this -> db -> execute($sql) ;
		
		//发送通知
		//$this -> sendNotify_AddMember($groupId,$loginNames,$userNames);

		
		return $loginNames ;
		
	}
	
	/*
	method:移除人员(单人)
	param:$groupId 
	param:$userId
	param:$loginName 不带域名
	param:$userName
	return:操作成功的 loginNames
	*/
	function removeMember($groupId,$userIds,$loginNames,$userNames)
	{
		$empRelation = new EmpRelation ();
		
		$arr_userId = explode(",",$userIds);
		$arr_loginName = explode(",",$loginNames);
		$arr_userName = explode(",",$userNames);
		
		//设置发送消息的人员
		$loginNames = "" ;
		$userNames = "" ;
		
		for($i=0;$i<count($arr_userId);$i++)
		{
			$userId = $arr_userId[$i] ;
			
			$isExist = $empRelation->isRelation(EMP_GROUP, $groupId, EMP_USER, $userId) ;
			$result = false ;
			
			//如果不存在
			if (! $isExist)
				continue ;
				
			//删除关系
			$empRelation->delete($groupId,EMP_GROUP,$groupId,EMP_USER, $userId);
			
			$loginNames .= ($loginNames == ""?"":",") . $arr_loginName[$i] ;
			$userNames .= ($userNames == ""?"":",") . $arr_userName[$i] ;
		}

		//发送通知
		//$this -> sendNotify_RemoveMember($groupId,$loginNames,$userNames);

		return $loginNames ;
		
	}

	function listMember($groupId) {
		$relation = new EmpRelation ();
		return $relation->getRelationData ( EMP_GROUP, $groupId, EMP_USER );
	}

	function save($fields, $groupId = "") {
		$this->addParamFields ( $fields );

		// 用户存在则更新
		if ($groupId != "") {
			$this->addParamWhere ( "TypeID", $groupId );
			return $this->update ();
		}
		$this->insert ();
		return $this->getMaxId ();
	}

	function isExist($groupId){
		$this->addParamWhere("TypeID", $groupId);
		if($this->getCount()>0)
			return true;
		else
			return false;
	}
	
	/*
	method:得到成员的帐号,并带域名
	return:array("loginnames"=>"jc;zwz","usernames"=>"jc;zwz")
	*/
	function getMemberInfo($groupId)
	{
		$sql = " select col_loginname,col_name from hs_user where  col_id in " .
			   "(select col_dhsitemid from hs_relation where col_dhsitemtype=1 and col_hsitemtype=4 and col_hsitemid=" . $groupId. ")" ;
		$data = $this -> db -> executeDataTable($sql);
		$loginnames = table_column_tostring($data,"col_loginname",";") ;
		$usenrames = table_column_tostring($data,"col_name",";") ;
		return array("loginnames"=>$loginnames,"usernames"=>$usenrames) ;
	}
	
	//获取群组名称
	function getGroupName($groupId)
	{
		$sql = " select TypeName as c from Clot_Ro where TypeID='" . $groupId . "'" ;
		$name = $this -> db -> executeDataValue($sql);
		return $name ;
	}
	
	//得到群组详情信息（包括创建者帐号）
	function getGroupMoreInfo($groupId)
	{
		$sql = " select hs_view.*,hs_user.col_loginname,hs_user.col_name  as col_username " . 
			   " from hs_view left join hs_user on hs_view.col_ownerid=hs_user.col_id " .
			   " where hs_view.col_id=" . $groupId . " and hs_view.Col_Type=8";
		$row = $this -> db -> executeDataRow($sql);
		return $row ;
	}
	
	/*
	method:添加成员发送通知  
	param:$loginNames
	param:$userName
	*/
	function sendNotify_AddMember($groupId,$loginNames,$userNames)
	{
		if ($loginNames == "")
			return ;
		$content = $this -> getNotifyContentWithMember("ADD",$loginNames,$userNames);
		$this -> sendNotify($groupId,$content);
	}
	
	/*
	method:删除成员发送通知 
	param:$loginNames
	param:$userNames
	*/
	function sendNotify_RemoveMember($groupId,$loginNames,$userNames)
	{
		if ($loginNames == "")
			return ;
		$content = $this -> getNotifyContentWithMember("DEL",$loginNames,$userNames);
		
		
		//删除的人不在群组中，要以追加的形式通知
		$this -> sendNotify($groupId,$content,$loginNames,$userNames);
	}
	
	//ADD/DEL:loginname;loginname:username;username
	function getNotifyContentWithMember($op,$loginNames,$userNames)
	{
		$loginNames = str_replace(",",";",$loginNames);
		$userNames = str_replace(",",";",$userNames);
		$content = $op . ":" . userAppendDomain($loginNames,";") . ":" . $userNames ;
		return $content ;
	}

	/*
	method:发送通知(所有操作都是对群组所有成员)
	param:@groupId
	param:@content
	param:@appendRecvLoginNames 用 ;号分隔  只是帐号，不带域名
	param:@appendRecvUserNames  用 ;号分隔
	return:loginnames 
	*/
	function sendNotify($groupId,$content,$appendRecvLoginNames = "",$appendRecvUserNames = "")
	{
		$msg = new MsgSender();
		
		//得到群组名称、群组创建人
		$dr = $this -> getGroupMoreInfo($groupId) ;
		if (count($dr) == 0)
		{
			print("群组不存在");
			return ;
		}
		
		
		$groupName = $dr["col_name"] ;
		$senderName = $dr["col_username"] ;
		
		//得到群组成员
		$member = $this -> getMemberInfo($groupId) ;
		$recvLoginNames = $member["loginnames"] ;
		$recvUserNames = $member["usernames"] ;
		
		if ($appendRecvLoginNames != "")
		{
			$recvLoginNames .= ($recvLoginNames == "")?"":";" . str_replace(",",";",$appendRecvLoginNames);
			$recvUserNames .= ($recvUserNames == "")?"":";" . str_replace(",",";",$appendRecvUserNames);
		}
		
		//设置发送信息
		$msgFlag = 530;
		$msgType = 14 ;
		$subject = $groupName ;
		$talkId = $msg -> getTalkId($groupId);
		
		//发送信息
		$result = $msg -> sendAntNotify($msgFlag,$msgType,$talkId,$recvLoginNames,$recvUserNames,$subject,$content,$senderName);

		return $result ;
	}
	
	/*
	method	判断是否是群组Id
	*/
	function isGroupId($groupId)
	{
		$sql = "Select TypeID as c from Clot_Ro where TypeName='" .$groupId. "' or TypeID='" .$groupId. "'";
		$value = $this -> db -> executeDataValue($sql) ;
		return $value ;
	}
	
	/*
	method	判断是否是群组成员
	*/
	function isGroupMemberByLoginName($groupId,$userId)
	{
		$sql = "Select id as c from Clot_Form where UpperID='" .$groupId. "' and UserID='" .$userId. "'";
		$value = $this -> db -> executeDataValue($sql) ;
		return $value ;
	}
	
}

?>