<?php
/**
 * Api.inc.php
 * @author  zwz
 * @date    2014.09.25 下午2:49:44
 */
// 定义接口错误码
define ( "SYS_ERROR_TOKEN", 10000 ); // 10000 接口访问Token无效
define ( "SYS_ERROR_UNDEFINED", 10001 );

define ( "USER_OP_SUCCESS", 101000 );
define ( "USER_OP_FAILED", 101001 );
define ( "USER_IS_EXIST", 101002 );
define ( "USER_NOT_EXIST", 101003 );
define ( "USER_ERROR_PASSWORD", 101004 );
define ( "USER_DUPLICATE_NAME", 101005 );
define ( "USER_VALID_SUCCESS", 101006 );

define ( "DEPT_OP_SUCCESS", 102200 ); // 102200 部门操作成功
define ( "DEPT_OP_FAILED", 102201 ); // 102201 部门操作失败
define ( "DEPT_IS_EXIST", 102202 ); // 102202 部门已经存在
define ( "DEPT_NOT_EXIST", 102203 ); // 102203 部门不存在
define ( "DEPT_DUPLICATE_NAME", 102204 ); // 102204 部门重名

define ( "MSG_OP_SUCCESS", 103000 );
define ( "MSG_NET_ERROR", 103001 );
define ( "MSG_ACCOUNT_ERROR", 103002 );
define ( "MSG_NOT_EXIST", 103003);

define ( "GROUP_OP_SUCCESS", 104000 );
define ( "GROUP_OP_FAILED", 104001 );
define ( "GROUP_NOT_EXIST", 104003 );
define ( "GROUP_USER_EXIST", 104004 );
define ( "GROUP_USER_NOT_EXIST", 104005 );
define ( "CREATOR_NOT_EXIST", 104006 );

define ( "ROLE_OP_SUCCESS", 105000 );
define ( "ROLE_OP_FAILED", 105001 );
define ( "ROLE_IS_EXIST", 105002 );
define ( "ROLE_NOT_EXIST", 105003 );
define ( "ROLE_DUPLICATE_NAME", 105004 );

define ( "MAIL_OP_SUCCESS", 106000 );
define ( "MAIL_OP_FAILED", 106001 );
define ( "MAIL_PARAM_ERROR", 106002 );

//数据同步
define ( "SYNC_OP_SUCCESS", 107000);


//function getErrMessage($errCode) {
//	switch ($errCode) {
//		// 系统错误
//		case SYS_ERROR_TOKEN :
//			return "ACCESS TOKEN无效";
//
//		case USER_OP_SUCCESS :
//			return "用户操作成功";
//		case USER_OP_FAILED :
//			return "用户操作失败";
//		case USER_IS_EXIST :
//			return "用户已经存在";
//		case USER_NOT_EXIST :
//			return "指定的用户不存在";
//		case USER_ERROR_PASSWORD :
//			return "密码错误";
//		case USER_DUPLICATE_NAME :
//			return "该用户帐号已经存在";
//		case USER_VALID_SUCCESS :
//			return "用户身份验证成功";
//
//		// 部门接口错误
//		case DEPT_OP_SUCCESS :
//			return "部门操作成功";
//		case DEPT_OP_FAILED :
//			return "部门操作失败";
//		case DEPT_IS_EXIST :
//			return "部门已经存在";
//		case DEPT_NOT_EXIST :
//			return "指定的部门不存在";
//		case DEPT_DUPLICATE_NAME :
//			return "部门重名";
//
//		// 群组接口错误码
//		case GROUP_OP_SUCCESS :
//			return "群组操作成功";
//		case GROUP_OP_FAILED :
//			return "群组操作失败";
//		case GROUP_NOT_EXIST :
//			return "指定 的群组不存在";
//		case GROUP_USER_EXIST :
//			return "用户已经在该群中";
//		case GROUP_USER_NOT_EXIST :
//			return "用户不在该群中";
//		case CREATOR_NOT_EXIST :
//		    return "创建者帐号不存在";
//
//		case ROLE_OP_SUCCESS :
//			return "角色操作成功";
//		case ROLE_OP_FAILED :
//			return "角色操作失败";
//		case ROLE_IS_EXIST :
//			return "角色已经存在";
//		case ROLE_NOT_EXIST :
//			return "指定的角色不存在";
//		case ROLE_DUPLICATE_NAME :
//			return "角色重名";
//
//		// 消息接口错误
//		case MSG_OP_SUCCESS :
//			return "消息操作成功";
//		case MSG_NET_ERROR :
//			return "网络连接错误";
//		case MSG_ACCOUNT_ERROR :
//			return "帐号或密码错误";
//		case MSG_NOT_EXIST :
//		    return "消息不存在";
//
//
//		case SYS_ERROR_UNDEFINED :
//			return "未定义的错误类型";
//
//
//
//		case MAIL_OP_SUCCESS :
//		    return "邮件操作成功";
//	    case MAIL_OP_FAILED :
//	        return "邮件操作失败";
//        case MAIL_PARAM_ERROR :
//            return "参数错误";
//
//
//        case SYNC_OP_SUCCESS:
//            return "同步操作成功";
//	}
//}

/*
 * 验证Token @param string $token @return bool
 */
function authenticate($token) {
	if ($token === ACCESS_TOKEN)
		return true;
	return false;
}


