<?php

/**
 * 语言管理类
 * 可以加载不同模块的语言,通过  addLangModel
 * @author  jincun
 * @date    20150528
 */
 
$arrLang = array();



/**
 * 添加语言模块  语言包的路径要统一  moduel/langs/cn(en)/lang.php
 * @param unknown $module 模块名称 admin/livechat/im/install/meeting
 */
function addLangModel($module)
{
	global $arrLang ;
//	echo __ROOT__ . "/" . $module . "/langs/" . LANG_TYPE . "/lang.php";
//	exit();
	$arrLang = array_merge($arrLang,include(__ROOT__ . "/" . $module . "/langs/" . LANG_TYPE . "/lang.php"));
}

function addLangModel1($module)
{
	global $arrLang ;
	global $browserLang ;
	$browserLang=Get_Browser_Lang();
	$arrLang = array_merge($arrLang,include(__ROOT__ . "/" . $module . "/langs/" . $browserLang . "/lang.php"));
}

function addLangModel2($module,$Lang)
{
	global $arrLang ;
	global $browserLang ;
	$arrLang = array_merge($arrLang,include(__ROOT__ . "/" . $module . "/langs/" . $Lang . "/lang.php"));
}

//加载基础语言
addLangModel2("class",g("LangType",LANG_TYPE));
?>