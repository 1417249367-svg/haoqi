<?php
require_once("../class/fun.php");
//加载基础语言
//addLangModel("livechat");
$LangType=g("LangType",LANG_TYPE);
addLangModel2("livechat",$LangType);

ob_clean();
header("Content-type: text/html; charset=utf-8");
?>