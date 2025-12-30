<?php  require_once("include/fun.php");?>
<?php
		$callback = g("callback");
		define("MYHOST","127.0.0.1"); //目标数据库地址(请修改)
		define("MYDB","TD_OA");     //使用的目标数据库名，当为access时，这里填写目标数据库文件路径，例如:"F:\RTC\Data\oa.mdb"(请修改)
		define("MYUID","root");        //连接目标数据库使用的帐号(请修改)
		define("MYPWD","myoa888");  //连接目标数据使用帐号的密码(请修改)
		define("MYTYPE","mysql");             //mssql,mysql,oracle,access,odbc(请修改)
		define("MYPORT","3336");             //数据库端口(请修改)

		$db = new DB();
		$sql = "Select * from UpDateForm where ID=1";
        $data = $db->executeDataRow($sql);
		$vesr=$data['users_rovesr']+$data['users_idvesr'];
        //users_rovesr-部门，users_idvesr-人员，clot_rovesr-群，clot_formvesr-群成员，根据第三方系统需要，clot_formvesr，clot_formvesr是否保留
        $plug_vesr=$db -> executeDataValue("Select Plug_Vesr as c from PlugVesr where Plug_Bie=1");//Plug_Bie-导入插件xml时,Bie值，表示第三方系统编号
		if($plug_vesr==$vesr){
		    exit();
		}else{
			$user = new Model("PlugVesr","Plug_Bie");
			$field_update = array ();
			$field_update ["Plug_Vesr"] = $vesr;
			if (count ( $field_update ) > 0) {
				$user->clearParam ();
				$user->addParamFields ( $field_update );
				$user->addWhere ( "Plug_Bie=1");
				$user->update ();
			}
		}

		$my_db = new DB(MYTYPE,MYHOST,MYDB,MYUID,MYPWD,"",MYPORT);
		$dept_parent=0; //目标数据库最顶层父部门ID(请修改)
		$is_delete=1;  // 是否先清空目标数据库部门表和人员表(请修改)
		if($is_delete==1){
		$sqls = array (
				"delete from department",
				"delete from user where USER_ID<>'admin'"
		);
		$my_db->execute ( $sqls );
		}
		readsubid("000000",$dept_parent);

		function readsubid($parentid,$deptparent){
		$db = new DB();
        $arr = $db->executeDataTable("Select * from Users_Ro where ParentID='".$parentid."'");
		foreach ($arr as $row)
		{
		$TypeID=$row['typeid'];    //源数据库部门ID
		$RoName=$row['typename'];  //源数据库部门名称
		$dept_id=read_subid($deptparent,$RoName);//根据源数据库的部门名称获取目标数据库对应的部门ID，当目标数据库不存在该部门，则添加部门
		readusers($TypeID,$dept_id);  //目标数据库添加人员
		readsubid($TypeID,$dept_id);
		}
		}
		
		function read_subid($parentid,$dept_name){//(请修改)
		 $my_db = new DB(MYTYPE,MYHOST,MYDB,MYUID,MYPWD,"",MYPORT);
		 $arr = $my_db->executeDataTable("Select * from department where DEPT_NAME='".$dept_name."' and DEPT_PARENT=".$parentid);
		 if(count ( $arr ) > 0) $read_sub = $arr[0]["DEPT_ID"] ;
         else{
		 $arr1 = $my_db->executeDataTable("select MAX(DEPT_ID) as c from department");
		 if(count ( $arr1 ) > 0) $dept_id=$arr1[0][0] ;
         if(empty($dept_id)) $dept_id=0;
		 $dept_id=$dept_id+1001;
		 $dept_ids=substr($dept_id,-3);
		 
		 $arr2 = $my_db->executeDataTable("select * from department where DEPT_ID=".$parentid);
		 if(count ( $arr2 ) > 0) $dept_no = $arr2[0]["DEPT_NO"].$dept_ids ;
         else $dept_no=$dept_ids;
         $my_db->execute("insert into department(DEPT_NAME,DEPT_NO,DEPT_PARENT) values('".$dept_name."','".$dept_no."',".$parentid.")");
		 //echo "insert into department(DEPT_NAME,DEPT_NO,DEPT_PARENT) values('".$dept_name."','".$dept_no."',".$parentid.")";
		 //echo "添加部门".$dept_name."成功"."<br>";
		 $arr3 = $my_db->executeDataTable("Select * from department order by DEPT_ID desc limit 0,1");
		 if(count ( $arr3 ) > 0) $read_sub = $arr3[0]["DEPT_ID"] ;
		 }
		 return $read_sub;
		}
		
		function readusers($parentid,$deptparent){//(请修改)
		$db = new DB();
		$my_db = new DB(MYTYPE,MYHOST,MYDB,MYUID,MYPWD,"",MYPORT);
        $arr = $db->executeDataTable("Select * from Users_ID where UppeId like '%".$parentid."%'");
		$i = 0;
		foreach ($arr as $row)
		{
		if($row['username']) $USER_ID=$row['username']."";
		if($USER_ID<>"admin"){
			$sql1[$i] = "delete from user where USER_ID='".$USER_ID."'";
			$i++;
		}
		}
		$my_db->execute($sql1);
		$i = 0;
		foreach ($arr as $row)
		{
			if($row['username']) $USER_ID=$row['username']."";
			if($row['userpaws']) $PASSWORD=md5(trim($row['userpaws']))."";
			if($row['fcname']) $USER_NAME=$row['fcname']."";
			if($row['jod']) $USER_PRIV_NAME=$row['jod']."";
			if($row['tel1']) $MOBIL_NO=$row['tel1']."";
			if($row['tel2']) $TEL_NO_DEPT=$row['tel2']."";
			if($row['address']) $ADD_HOME=$row['address']."";
			$SEX=$row['userico']-1;
			if($row['constellation']) $OICQ_NO=$row['constellation'].""; //QQ号码
			if($row['remark']) $REMARK=$row['remark']."";
			$sql2[$i] = "insert into user(DEPT_ID,USER_ID,PASSWORD,USER_NAME,USER_PRIV,USER_PRIV_NO,USER_PRIV_NAME,MOBIL_NO,TEL_NO_DEPT,ADD_HOME,SEX,OICQ_NO,REMARK) values(".$deptparent.",'".$USER_ID."','".$PASSWORD."','".$USER_NAME."',5,10,'".$USER_PRIV_NAME."','".$MOBIL_NO."','".$TEL_NO_DEPT."','".$ADD_HOME."','".$SEX."','".$OICQ_NO."','".$REMARK."')";
			$i++;
			//echo "添加人员.$USER_NAME."成功"."<br>";
		}
		$my_db->execute($sql2);
		}
?>