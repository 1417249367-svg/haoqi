<?php
	require_once( "../../class/fun.php") ;

	$userId = CurUser::getUserId() ;
	$admin = CurUser::isAdmin();

	if ($userId == 0)
		header("Location:../account/login.html?op=relogin");
?>
<div id="header" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
	<div class="navbar-header">
	  <a href="../include/index.php" class="navbar-brand"><?=APP_NAME?></a>
	</div>

	<ul class="nav navbar-nav pull-right" id="nav_account">
		<li>
		  <a href="###"><?=get_lang('header_hello')?><?=CurUser::getUserName()?></a>
		</li>
		<li>
		  <a href="../include/index.php"><?=get_lang('header_home')?></a>
		</li>
		<li>
		  <a href="/download.html" target="_blank"><?=get_lang('header_download')?></a>
		</li>
		<li><a href="../account/setpassword.html"><?=get_lang('header_changepsw')?></a></li>
		<li><a href="../account/login.html?op=logout"><?=get_lang('header_exit')?></a></li>
        <!--<li><a href="#" onclick="OnlineData()">数据在线同步</a></li>-->
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('header_lang')?><b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="#" onclick="setlang('cn')"><?=get_lang('header_cn')?></a></li>
                <li><a href="#" onclick="setlang('hk')"><?=get_lang('header_hk')?></a></li>
                <li><a href="#" onclick="setlang('en')"><?=get_lang('header_en')?></a></li>
			  </ul>
		</li>
        <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=get_lang('header_help')?> <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li><a href="#" onclick="about()"><?=get_lang('header_dropdown_about')?></a></li>
			  </ul>
		</li>
	</ul>

  </div>
</div>

    <div id="content">
        <div class="container">
			<div id="sidebar">
			  <?php  require("../include/menu.php");?></div>
			<div id="main">

<?php


//默认页面要求超级用户权限
if (! isset($issuper))
	$issuper = 1 ;

if (($issuper == 1) && ($admin == 0))
{
	print('<div class="page-header"><h1><?=get_lang("header_nopermission")?></h1></div>');
	print('<p id="container_error" class="alert alert-warning"><?=get_lang("header_nopermission_operate")?><br><a href="#" onclick="history.back()"><?=get_lang("header_back")?></a></p>');
	die();
}

?>
