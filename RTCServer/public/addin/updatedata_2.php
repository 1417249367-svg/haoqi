<?php  require_once("include/fun.php");?>
<?php
		$callback = g("callback");

		$myHost = "127.0.0.1";  //目标数据库地址(请修改)
		$myDB = "zlchat";     //使用的目标数据库名，当为access时，这里填写目标数据库文件路径，例如:"F:\RTC\Data\oa.mdb"(请修改)
		$myUID = "root";        //连接目标数据库使用的帐号(请修改)
		$myPWD = "zlchat888";  //连接目标数据使用帐号的密码(请修改)
		$myTYPE = "mysql";             //mssql,mysql,oracle,access,odbc(请修改)
		$myPort = "3307";             //数据库端口(请修改)

		$db = new DB();
		$sql = "Select * from UpDateForm where ID=1";
        $data = $db->executeDataRow($sql);
		$vesr=$data['users_rovesr']+$data['users_idvesr']+$data['clot_rovesr']+$data['clot_formvesr'];
        //users_rovesr-部门，users_idvesr-人员，clot_rovesr-群，clot_formvesr-群成员，根据第三方系统需要，clot_formvesr，clot_formvesr是否保留
        $plug_vesr=$db -> executeDataValue("Select Plug_Vesr as c from PlugVesr where Plug_Bie=2");//Plug_Bie-导入插件xml时,Bie值，表示第三方系统编号
		if($plug_vesr==$vesr){
		    echo $callback."({msg:'ok'})";
		    exit();
		}else{
			$user = new Model("PlugVesr","Plug_Bie");
			$field_update = array ();
			$field_update ["Plug_Vesr"] = $vesr;
			if (count ( $field_update ) > 0) {
				$user->clearParam ();
				$user->addParamFields ( $field_update );
				$user->addWhere ( "Plug_Bie=2");
				$user->update ();
			}
		}

		$my_db = new DB($myTYPE,$myHost,$myDB,$myUID,$myPWD,"",$myPort);
		$is_delete=1;  // 是否先清空目标数据库部门表和人员表(请修改)
		if($is_delete==1){
		$sqls = array (
				"delete from department",
				"delete from account"
		);
		$my_db->execute ( $sqls );
		}
		
        $arr = $db->executeDataTable("Select * from Users_Ro");
		$i = 0;
		foreach ($arr as $row)
		{
			$sql1[$i] = "insert into department(TypeID,TypeName,ParentID) values('".$row['typeid']."','".$row['typename']."','".$row['parentid']."')";
			$i++;
		}
		$my_db->execute($sql1);
	
        $arr = $db->executeDataTable("Select * from Users_ID");
		$i = 0;
		foreach ($arr as $row)
		{
			$sql2[$i] = "insert into account(id,login_name,passwd,real_name,enabled,roles,email,created_date,UppeID) values(".$row['userid'].",'".$row['username']."','".md5(trim($row['userpaws']))."','".$row['fcname']."',".$row['userstate'].",'ROLE_AUDIENCE','','".date("Y-m-d")."','".$row['uppeid']."')";
			$i++;
		}
		$my_db->execute($sql2);
		
        $arr = $db->executeDataTable("Select * from Clot_Ro");
		$i = 0;
		foreach ($arr as $row)
		{
			$sql31[$i] = "delete from meeting where meet_no='".$row['typeid']."'";
			$i++;
			$sql31[$i] = "delete from rel_meeting_user where meet_no='".$row['typeid']."'";
			$i++;
		}
		$my_db->execute($sql31);
		$i = 0;
		foreach ($arr as $row)
		{
			$sql32[$i] = "insert into meeting(meet_no,meet_name,subject,start_time,end_time) values('".$row['typeid']."','".$row['typename']."','".$row['remark']."','".$row['to_date']."','0000-00-00 00:00:00')";
			$i++;
		}
		$my_db->execute($sql32);
		
        $arr = $db->executeDataTable("Select * from Clot_Form");
		$i = 0;
		foreach ($arr as $row)
		{
			if($row['Admin']==1) $role=2;
			else $role=3;
			$sql4[$i] = "insert into rel_meeting_user(meet_no,user_id,role) values('".$row['upperid']."',".$row['userid'].",".$role.")";
			$i++;
		}
		$my_db->execute($sql4);
?>