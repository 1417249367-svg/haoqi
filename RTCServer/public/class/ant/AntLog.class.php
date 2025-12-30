<?php
/**
 * Created by PhpStorm.
 * User: zwz
 * Date: 15-4-15
 * Time: 上午9:34
 */
//require_once(__ROOT__ . "/class/doc/Doc.class.php");
class AntLog{
    private $m;
    function __construct(){
        $this->m = new Model("ServerLog");
        $this->m->field = "ID,UserID";
    }

    //写日志
    //status : 0成功 1失败
    function log($SubIt1,$SubIt2,$ip,$Ico){
		if(DOC_Logs==1){
//        $this->m->clearParam();
//
//        $fields = array(
//            //"ToDate" => getNowTime(),
//            "Txt" => $SubIt1,
//            "UserID" => $SubIt2,
//            "Ip" => $ip,
//            "Ico" => $Ico,
//			"To_Type" => 2
//        );
//
//        $this->m->addParamFields($fields);
//        $this->m->insert();
//		switch ((int)$Ico) {
//			case 21 :
//				$getTypeName=get_lang("type_newfile");
//				break;
//			case 22 :
//				$getTypeName=get_lang("type_downloadfile");
//				break;
//			case 23 :
//				$getTypeName=get_lang("type_deletefile");
//				break;
//			case 24 :
//				$getTypeName=get_lang("type_sharefile");
//				break;
//			case 25 :
//				$getTypeName=get_lang("type_login");
//				break;	
//		}
//		$doc = new Doc();
//		$root_dir = $doc -> get_root_dir(8,iconv_str(format_path("log/" . date("Ymd")),"utf-8","gbk")) ;
		
		$default_dir=RTC_CONSOLE . "/log/" . date("Ym");
		mkdirs($default_dir);
		
		//echo $root_dir["default_dir"]."/".date("Ymd").".log";
		//exit();
		file_put_contents($default_dir."/".date("Ymd").".log", "[" .$ip . "] [". date('Y-m-d H:i:s') . "] [UserID:" . $SubIt2 . "] [type:" . $Ico . "]: "  . $SubIt1 ."\r\n", FILE_APPEND);
		}
    }

    function clear_log_by_ip(){
        $this->m->clearParam();
        $this->m->addParamWhere("col_ip",$_SERVER['REMOTE_ADDR'],"=","string");
        $this->m->addParamWhere("col_status",1,"=","int");
        $this->m->addParamWhere("col_action",3,"=","int");
        $this->m->delete();
    }

    function get_admin_error_count()
    {
        $this->m->clearParam();
        $this->m->addParamWhere("col_ip",$_SERVER['REMOTE_ADDR'],"=","string");
        $this->m->addParamWhere("col_dt_create",date("Y-m-d",time()),"<","date");
        $this->m->addParamWhere("col_dt_create",date("Y-m-d",time()),">=","date");
        $this->m->addParamWhere("col_status",1,"=","int");
        $this->m->addParamWhere("col_action",3,"=","int");   //表明是管理员登录
        return $this->m->getCount();
    }

}