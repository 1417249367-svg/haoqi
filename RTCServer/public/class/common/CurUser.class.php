<?php
/**
 * 人员管理类

 * @date    20140325
 */
 
class CurUser 
{

	
	static function setUserId($userId)
	{
		setValue("userid",$userId);
	}
	
	static function setLoginName($loginName)
	{
		setValue("loginname",$loginName);
	}
	
	static function setUserName($userName)
	{
		setValue("username",$userName);
	}
	static function setPassword($password)
	{
		setValue("password",$password);
	}
	
	static function setAdmin($admin)
	{
		setValue("admin",$admin);
	}
	
	static function getUserId()
	{
		$result = getValue("userid");
		return $result == ""?0:$result ;
	}

	static function getUserName()
	{
		$result = getValue("username");
		return $result ;
	}
	
	static function getLoginName()
	{
		$result = getValue("loginname");
		return $result ;
	}
	
	static function getPassword()
	{
		$result = getValue("password");
		return $result ;
	}
	static function isAdmin()
	{
		$result = getValue("admin");
		$result == 1?1:0 ;
		return $result ;
	}

	//获取短信附加号码
	static function getAddNum(){
		$userId=CurUser::getUserId();
		$user=new User();
		return $user->getAddNum($userId);
	}
}

?>