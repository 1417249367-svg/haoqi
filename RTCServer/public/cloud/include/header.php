<?php

	$userId = CurUser::getUserId() ;
	$admin = CurUser::isAdmin();
	
	if ($userId == 0)
		header("Location:../account/login.html?op=relogin");
?>
<div id="header" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
	<div class="navbar-header">
	  <a href="../include/index.html#public"></a>
	</div>

	<ul class="nav navbar-nav pull-right" id="nav_account">
		<li class="dropdown">
		  <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="../assets/img/face.png" class="photo"><?=CurUser::getUserName()?> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="../account/login.html?op=logout"><?=get_lang('header_logout')?></a></li>
		  </ul>
		</li>
	</ul>
	<div class="search_box">
		<input type="text" id="search_key" style="border-width:0px;">
		<a href="javascript:void(0);" action-type="doc_search" id="btn_search"><span class="icon icon_search"></span></a>
	</div>
  </div>
</div>



    <div id="content">
        <div class="container">


