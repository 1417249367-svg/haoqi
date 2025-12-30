<?php
$db = new DB();
$data =$db -> executeDataRow("select * from Plug where Plug_Name = 'OfficeOnlineServer' and Plug_Site = '2' order by Plug_Index desc");
if (count($data)) $Plug_Param = explode(',', $data["plug_param"]);
//else{
//echo get_lang('addin_alert');
//exit();
//}
	
if(is_private_ip($_SERVER['SERVER_NAME'])&&(!CheckUrl($_SERVER['SERVER_NAME']))){
$onlyoffice_url=$Plug_Param[0];
//$onlyoffice_url="http://".RTC_SERVER.":96";
}else{
$onlyoffice_url=$Plug_Param[2];
}
	
$GLOBALS['FILE_SIZE_MAX'] = 5242880;
$GLOBALS['STORAGE_PATH'] = "";
$GLOBALS['ALONE'] = FALSE;

$GLOBALS['MODE'] = "";

$GLOBALS['DOC_SERV_VIEWD'] = array(".ppt",".pps",".odp",".pdf",".djvu",".epub",".xps");
$GLOBALS['DOC_SERV_EDITED'] = array(".docx",".doc",".odt",".xlsx",".xls",".ods",".csv",".pptx",".ppsx",".rtf",".txt",".mht",".html",".htm");
$GLOBALS['DOC_SERV_CONVERT'] = array(".doc",".odt",".xls",".ods",".ppt",".pps",".odp",".rtf",".mht",".html",".htm",".epub");

$GLOBALS['DOC_SERV_TIMEOUT'] = "120000";

$GLOBALS['DOC_SERV_STORAGE_URL'] = $onlyoffice_url."/FileUploader.ashx";
$GLOBALS['DOC_SERV_CONVERTER_URL'] = $onlyoffice_url."/ConvertService.ashx";
$GLOBALS['DOC_SERV_API_URL'] = $onlyoffice_url."/web-apps/apps/api/documents/api.js";

$GLOBALS['DOC_SERV_PRELOADER_URL'] = $onlyoffice_url."/web-apps/apps/api/documents/cache-scripts.html";

$GLOBALS['EXAMPLE_URL'] = $Plug_Param[1];

$GLOBALS['MOBILE_REGEX'] = "android|avantgo|playbook|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\\/|plucker|pocket|psp|symbian|treo|up\\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino";


$GLOBALS['ExtsSpreadsheet'] = array(".xls", ".xlsx",
                                    ".ods", ".csv");

$GLOBALS['ExtsPresentation'] = array(".pps", ".ppsx",
                                    ".ppt", ".pptx",
                                    ".odp");

$GLOBALS['ExtsDocument'] = array(".docx", ".doc", ".odt", ".rtf", ".txt",
                                ".html", ".htm", ".mht", ".pdf", ".djvu",
                                ".fb2", ".epub", ".xps");

if ( !defined('ServiceConverterMaxTry') )
    define( 'ServiceConverterMaxTry', 3);


?>