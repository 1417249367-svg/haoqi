<?php

	$userId = CurUser::getUserId() ;
	$admin = CurUser::isAdmin();
	
//	if ($userId == 0)
//		header("Location:../account/login.html?op=relogin");
?>
<div id="header" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
	<div class="navbar-header">
	  <a style="background:url(../assets/img/onlinefile.png) 10px top no-repeat !important;"></a>
	</div>

	<ul class="nav navbar-nav pull-right" id="nav_account">
		<li>
		  <a href="/download.html" target="_blank" style="color:#FFF;"><?=get_lang('header_download')?></a>
		</li>
		<li class="dropdown">
		  <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="../assets/img/face.png" class="photo"><?=CurUser::getUserName()?> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="../account/login.html?op=logout&gourl=../include/onlinefile.html"><?=get_lang('header_logout')?></a></li>
		  </ul>
		</li>
	</ul>
  </div>
</div>



    <div id="content">
        <div class="container">


