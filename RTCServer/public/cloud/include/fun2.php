<?php 

require_once("../../class/fun.php");
require_once(__ROOT__ . "/config/cloud.inc.php");
require_once(__ROOT__ . "/class/doc/DocXML.class.php");
require_once(__ROOT__ . "/class/doc/DocDir.class.php");
require_once(__ROOT__ . "/class/doc/DocFile.class.php");
require_once(__ROOT__ . "/class/doc/DocRelation.class.php");
require_once(__ROOT__ . "/class/doc/Doc.class.php");
require_once(__ROOT__ . "/class/doc/DocAce.class.php");
require_once(__ROOT__ . "/class/doc/DocSubscribe.class.php");

//加载基础语言
addLangModel1("cloud");

ob_clean();
?>