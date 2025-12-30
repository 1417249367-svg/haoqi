<?php
/**
 * 枚举值放这里
 * @author  jincun
 * @date    20150525
 */
 

//消息模式
//1 从ANT_MSG表获取
//2 从ANT_MSG_NEW 表中获取
define("WEBIM_MODE",2);

/*config.inc.php 定义 改为到数据库中获取*/
//define("PRODUCT_NAME",getAppValue("ProductName")) ; 
//define("APP_NAME",getAppValue("AppName")) ; 
//define("APP_COMPANY",getAppValue("AppCompany")) ; 
//define("APP_URL",getAppValue("AppUrl")) ; 
//define("COMPANY_NAME",getAppValue("CompanyName")) ;
define("BIGANT_SERVER_FACT",getFactAntServer()) ; 
define("RTC_SERVER_AGENT",getAgentRTCServer()) ; 
define("Jump_RTCServer_IP",getAppValue("jump_rtcserver_ip")) ; 
//define("BIGANT_PORT",getAppValue("AntServer_Port",6660)) ; 
//define("BIGANT_DOMAIN","@" . getAppValue("DomainName")) ; 
define("RTC_VIDEO_IP",getAppValue("rtc_video_ip")) ; 
define("RTC_DATADIR",getAppValue("rtc_datadir")) ; 
define("RTC_CONSOLE",getAppValue("rtc_console")) ; 

define("SMS_URL",getAppValue("sms_url")) ; 
define("SMS_PUSH",getAppValue("sms_push")) ; 

define("SMTPSERVER",getAppValue("smtpserver")) ; 
define("SMTPPORT",getAppValue("smtpport")) ; 
define("SMTPACCOUNT",getAppValue("smtpaccount")) ; 
define("SMTPPASSWORD",getAppValue("smtppassword")) ; 
define("EMAIL_PUSH",getAppValue("email_push")) ; 

define("EXPORT_USER_FIELD",getAppValue("export_user_field")) ; 
define("TRANSCODE",getAppValue("Transcode",0)) ; 
define("PUBLICDOCUMENTS",getAppValue("PublicDocuments",0)) ; 
define("PUBLICDOCUMENTS_VIEW",getAppValue("PublicDocuments_View",0)) ; 
define("LIVECHAT",getAppValue("LiveChat",0)) ; 
define("OPENPLATFORM",getAppValue("OpenPlatForm",0)) ; 
define("VERIFYUSERDEVICE",getAppValue("VerifyUserDevice",0)) ; 
define("INQUIRYBOX",getAppValue("InquiryBox",0)) ; 
//define("ANT_MEETING",getAppValue("AntMeeting",0)) ; 
//define("IOS_PUSH",getAppValue("IOSPush",0)) ;
define("LOGIN_ERROR_COUNT",getAppValue("login_error_count")) ;
define("BACKONLINEMINUTE",getAppValue("backonlineminute")) ;
//
//
//define("SYNCPUSH_TOKEN",getAppValue("AccessToken")) ;
//define("SYNC_PUSH",getAppValue("SyncPushTargetType",0)) ;
//
define("ACCESS_TOKEN",getAppValue("access_token"));
//
define("APIRETURNTYPE",getAppValue("apireturntype","XML"));
define("USERAPPLY",getAppValue("userapply","0"));
//
////开放的平台（应用管理）
//define("OPEN_PLATFORM",getAppValue("OpenPlatForm",0)) ;
//
////日志级别
define("LOG_LEVEL",getAppValue("log_level",3)) ;

define("IPADDRESS",getAppValue("ipaddress"));
define("OLDVISITORTIME",getAppValue("oldvisitortime"));
define("WAITTIME",getAppValue("waittime"));
define("FREETIME",getAppValue("freetime"));
define("INTERVALTIME",getAppValue("intervaltime"));
define("WELCOMETEXT",getAppValue("welcometext"));
define("CHATERMODE",getAppValue("chatermode"));
define("CHATERDISTRIBUTION",getAppValue("chaterdistribution"));
define("GUESTSESSION",getAppValue("guestsession"));
define("WELCOMETYPE",getAppValue("welcometype"));
define("OLDVISITORTYPE",getAppValue("oldvisitortype"));
define("SWITCHTYPE",getAppValue("switchtype"));
define("FREETYPE",getAppValue("freetype"));
define("WEBSITETYPE",getAppValue("websitetype"));
define("DIALOGTYPE",getAppValue("dialogtype"));
//define("CONNECTCHATTYPE",getAppValue("connectchatType"));
define("REJECTTYPE",getAppValue("rejecttype"));
define("WEIXINTYPE",getAppValue("weixintype"));
define("CDNTYPE",getAppValue("cdntype"));
define("CDNLINK",getAppValue("cdnlink"));
define("VOICEVIDEOTYPE",getAppValue("voiceVideoType"));
define("BEATTIME",getAppValue("beatTime"));
define("SHOWHISTORYTYPE",getAppValue("showhistorytype"));
define("SWITCHAD",getAppValue("switchad"));
define("ADLINK",getAppValue("adlink"));
define("CUSTOMERSERVICEMODE",getAppValue("customerservicemode"));

define("TRANSLATETYPE",getAppValue("translatetype")) ; 
define("TRANSLATEAPPID",getAppValue("translateappid")) ; 
define("TRANSLATEKEY",getAppValue("translatekey")) ; 

define("DEFAULTRECEPTION",getAppValue("defaultreception")) ; 
define("CHATGPTTYPE",getAppValue("chatgpttype")) ; 
define("CHATGPTAPPID",getAppValue("chatgptappid")) ; 
define("CHATGPTKEY",getAppValue("chatgptkey")) ; 
define("DEFAULTMODEL",getAppValue("defaultmodel")) ; 
define("DEFAULTMODELURL",getAppValue("defaultmodelurl")) ; 
define("CHATGPTTRANSFERTYPE",getAppValue("chatgpttransfertype")) ; 
define("CHATGPTAUTOTRANSFERTYPE",getAppValue("chatgptautotransfertype")) ; 
define("CHATGPTAUTOTRANSFERTIME",getAppValue("chatgptautotransfertime")) ; 

define("SWITCHWECHAT",getAppValue("switchwechat"));
define("SWITCHBACK",getAppValue("switchBack"));
define("SENDWELCOME",getAppValue("sendWelcome"));
define("SWITCHDOMAINTYPE",getAppValue("switchDomainType"));
define("WECHAT_DOMAIN",getAppValue("wechat_domain"));
define("WECHAT_APPID",getAppValue("wechat_appid"));
define("WECHAT_SERCET",getAppValue("wechat_sercet"));
define("WECHAT_TOKEN",getAppValue("wechat_token"));
define("WECHAT_MOBAN_ID",getAppValue("wechat_moban_id"));
define("WECHAT_DOMAIN1",getAppValue("wechat_domain1"));
define("WECHAT_APPID1",getAppValue("wechat_appid1"));
define("WECHAT_SERCET1",getAppValue("wechat_sercet1"));
define("WECHAT_MOBAN_ID1",getAppValue("wechat_moban_id1"));
define("WECHAT_SUBSCRIBE",getAppValue("wechat_subscribe"));
define("WECHAT_SUBSCRIBE_ID",getAppValue("wechat_subscribe_id"));
define("WECHAT_SUBSCRIBE_ID2",getAppValue("wechat_subscribe_id2"));
define("WECHAT_GROUPID",getAppValue("wechat_groupid"));
define("WECHAT_MODE",getAppValue("wechat_mode"));
define("WECHAT_CUSTOMER_SERVICE_LINK",getAppValue("wechat_customer_service_link"));
define("WECHAT_WECHAT_CUSTOMER_SERVICE_LINK",getAppValue("wechat_wechat_customer_service_link"));

define("ACCESSTOKEN",getAppValue("accesstoken")) ; 
define("TOKENEXPIREDTIME",getAppValue("tokenexpiredtime",0)) ; 

//上传文件大小限制
define("UPLOAD_SIZE_LIMIT",256); 

//BIGANT 中设置平台的类型 WEB
define("ANT_PLATFORM_WEB",3) ;

//令牌过期时间
define("TOKEN_EXPIRE_MINUTE",5) ;

define("EMP_USER",	1) ;  		//用户
define("EMP_DEPT",	2) ;		//部门
define("EMP_ROLE",	3) ;		//角色
define("EMP_VIEW",	4) ; 		//视图
define("EMP_GROUP",	4) ;		//群组
define("EMP_ADDIN",	10) ;		//插件
define("EMP_INTERFACE",	11) ;	//接口

define("VIEWTYPE_DEFAULT",	1) ;
define("VIEWTYPE_OWNER",	2) ;
define("VIEWTYPE_GROUP",	8) ;

define("LOG_LEVEL_CLOSE",	0) ;  		 
define("LOG_LEVEL_ERROR",	1) ;		 
define("LOG_LEVEL_INFO",	2) ;		 
define("LOG_LEVEL_DEBUG",	3) ;

define("DOC_FILE",	100) ;		//文档目录
define("DOC_ROOT",	102) ;		//文档根目录
define("DOC_VFOLDER",	105) ;	//文档目录


/*同步推送 内容类型*/
define("SP_TYPE_ORG","ORG") ;		
define("SP_TYPE_DEPT","DEPT") ;		
define("SP_TYPE_USER","USER") ;		
define("SP_TYPE_GROUP","GROUP") ;		
define("SP_TYPE_MSG","MSG") ;	

/*同步推送 操作类型*/
define("SP_OP_CREATE","CREATE") ;		
define("SP_OP_EDIT","EDIT") ;		
define("SP_OP_DELETE","DELETE") ;		
	

/*同步推送 状态类型*/
define("SP_STATUS_SUCCESS","1") ;		
define("SP_STATUS_ERROR","2") ;		



// 定义接口错误码
define("SYS_ERROR_TOKEN", 10000 ); // 10000 接口访问Token无效
define("SYS_ERROR_UNDEFINED", 10001 );

define("OP_SUCCESS", 100000 );
define("OP_FAIL", 100001 );
define("OP_REQUIRED", 100002 );
define("OP_IS_EXIST", 100003 );
define("OP_NOT_EXIST", 100004 );
define("OP_FIELDS_NULL", 100005 );

define("USER_OP_SUCCESS", 101000 );
define("USER_OP_FAILED", 101001 );
define("USER_IS_EXIST", 101002 );
define("USER_NOT_EXIST", 101003 );
define("USER_ERROR_PASSWORD", 101004 );
define("USER_DUPLICATE_NAME", 101005 );
define("USER_VALID_SUCCESS", 101006 );

define("DEPT_OP_SUCCESS", 102200 ); // 102200 部门操作成功
define("DEPT_OP_FAILED", 102201 ); // 102201 部门操作失败
define("DEPT_IS_EXIST", 102202 ); // 102202 部门已经存在
define("DEPT_NOT_EXIST", 102203 ); // 102203 部门不存在
define("DEPT_DUPLICATE_NAME", 102204 ); // 102204 部门重名
define("DEPT_IS_EMPTY", 102205 );

define("MSG_OP_SUCCESS", 103000 );
define("MSG_NET_ERROR", 103001 );
define("MSG_SEND_ERROR", 103002 );
define("MSG_NOT_EXIST", 103003);

define("GROUP_OP_SUCCESS", 104000 );
define("GROUP_OP_FAILED", 104001 );
define("GROUP_NOT_EXIST", 104003 );
define("GROUP_USER_EXIST", 104004 );
define("GROUP_USER_NOT_EXIST", 104005 );
define("CREATOR_NOT_EXIST", 104006 );

define("ROLE_OP_SUCCESS", 105000 );
define("ROLE_OP_FAILED", 105001 );
define("ROLE_IS_EXIST", 105002 );
define("ROLE_NOT_EXIST", 105003 );
define("ROLE_DUPLICATE_NAME", 105004 );

define("MAIL_OP_SUCCESS", 106000 );
define("MAIL_OP_FAILED", 106001 );
define("MAIL_PARAM_ERROR", 106002 );

//数据同步
define("SYNC_OP_SUCCESS", 107000);

//认证
define("OAUTH_APP_NOT_EXIST", 108001);
define("OAUTH_APP_IP_LIMIT", 108002);
define("OAUTH_TOKEN_NOT_EXIST", 108011);
define("OAUTH_TOKEN_EXPIRE", 108012);



/*
method	此功能主要
*/
function getErrMessage($errCode) {
	switch ($errCode) {
		// 系统错误
		case SYS_ERROR_TOKEN :
			return "ACCESS TOKEN无效";
		case USER_OP_SUCCESS :
			return "用户操作成功";
		case USER_OP_FAILED :
			return "用户操作失败";
		case USER_IS_EXIST :
			return "用户已经存在";
		case USER_NOT_EXIST :
			return "指定的用户不存在";
		case USER_ERROR_PASSWORD :
			return "密码错误";
		case USER_DUPLICATE_NAME :
			return "该用户帐号已经存在";
		case USER_VALID_SUCCESS :
			return "用户身份验证成功";

		// 部门接口错误
		case DEPT_OP_SUCCESS :
			return "部门操作成功";
		case DEPT_OP_FAILED :
			return "部门操作失败,可能有子部门";
		case DEPT_IS_EXIST :
			return "部门已经存在";
		case DEPT_NOT_EXIST :
			return "指定的部门不存在";
		case DEPT_DUPLICATE_NAME :
			return "部门重名";
		case DEPT_IS_EMPTY :
			return "部门名称不能为空";

		// 群组接口错误码
		case GROUP_OP_SUCCESS :
			return "群组操作成功";
		case GROUP_OP_FAILED :
			return "群组操作失败";
		case GROUP_NOT_EXIST :
			return "指定 的群组不存在";
		case GROUP_USER_EXIST :
			return "用户已经在该群中";
		case GROUP_USER_NOT_EXIST :
			return "用户不在该群中";
		case CREATOR_NOT_EXIST :
		    return "创建者帐号不存在";

		case ROLE_OP_SUCCESS :
			return "角色操作成功";
		case ROLE_OP_FAILED :
			return "角色操作失败";
		case ROLE_IS_EXIST :
			return "角色已经存在";
		case ROLE_NOT_EXIST :
			return "指定的角色不存在";
		case ROLE_DUPLICATE_NAME :
			return "角色重名";

		// 消息接口错误
		case MSG_OP_SUCCESS :
			return "消息操作成功";
		case MSG_NET_ERROR :
			return "网络连接错误";
		case MSG_SEND_ERROR :
			return "消息发送错误";
		case MSG_NOT_EXIST :
		    return "消息不存在";


		case SYS_ERROR_UNDEFINED :
			return "未定义的错误类型";



		case MAIL_OP_SUCCESS :
		    return "邮件操作成功";
	    case MAIL_OP_FAILED :
	        return "邮件操作失败";
        case MAIL_PARAM_ERROR :
            return "参数错误";


        case SYNC_OP_SUCCESS:
            return "同步操作成功";
	}
}




?>