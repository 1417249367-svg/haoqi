<?php
/**
 * 组件装配
 * @author  jincun
 * @date    20140725
 */
define ( "__ROOT__", $_SERVER ['DOCUMENT_ROOT'] );
require_once(__ROOT__ . "/class/fun.php");

//加载基础语言
addLangModel("addin");

loginByAddin();

ob_clean();
?>