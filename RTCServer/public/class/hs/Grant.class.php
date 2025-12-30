<?php
/**
 * 授权管理类

 * @date    20141118
 */
class Grant extends Model {
	function __construct() {
		$this->tableName = "hs_grant";
		$this->db = new DB ();
	}
	

	/*
	method	创建用户
	return	array("status"=>1,"msg"=>"") ;   1允许  0禁止
	*/
    function allow_create_user()
    {
        if (CurUser::isAdmin())
            return array("status"=>1,"msg"=>"") ;


        $my_id = CurUser::getUserId();
        $sql = " select CountUser as c from AdminGrant where UserID='" . $my_id . "'";
        $count_user = $this -> db -> executeDataValue($sql);
		
		//不限制
        if ($count_user == "0")
           return array("status"=>1,"msg"=>"") ;
		   
		//没有权限
        if (($count_user == "") || ($count_user == "-1"))
            return array("status"=>0,"msg"=>get_lang("class_grant_warning")) ;

        $sql = " select count(*) as c from Users_ID where CreatorID='" . $my_id . "'";
        $total_user = $this -> db -> executeDataValue($sql);

		if ($total_user > 0)
		{
        	if ($total_user >= $count_user)
				return array("status"=>0,"msg"=>get_lang("class_grant_warning1") . $count_user . get_lang("class_grant_warning2")) ;
		}

        return array("status"=>1,"msg"=>"") ;
    }
	
	


}

?>