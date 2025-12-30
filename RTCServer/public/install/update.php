<?php
require_once("fun.php");
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
$content = new SimpleIniIterator(__ROOT__ . '/Data/Config.ini');
$date2=(int)$content->getIniValue('updated_date', 'date2');
//只能是本机上访问
//checkLocalLimit();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<script type="text/javascript" src="assets/js/install.js"></script>
</head>
<body>

				<form  id="form1" method="post" action="db.html" class="form-horizontal">
				
				<div class="step" id="step1">
					<div class="step-top"><?=get_lang("upgrade_db")?></div>
					<div class="step-body">
						<div style="padding:20px 40px">
							<h4><?=get_lang("upgrade_type")?></h4>
							<p>
									<select class="form-control" name="type" id="type" >
										<?php
										$folders = getChildFolder(__ROOT__ . "/install/dbupdate");
										foreach($folders as $folder)
										{
											if($date2<(int)str_replace("dbupdate_","",$folder)){
										?>
										<option value="<?=$folder?>"><?=$folder?></option>
										<?php
										break;
											}
										}
										?>
									</select>
							</p>
						</div>
					</div>
					<div class="step-bottom">
						<input type="button" class="btn btn-primary"  value="<?=get_lang("upgrade_db_button")?>" onclick="update()" />
					</div>
				</div>
				
				<div class="step" id="step_submiting">
					<div class="step-top"><?=get_lang("upgrade_db")?></div>
					<div class="step-body">
						<div class="text-center">
							<p style="padding:30px"><img src="/static/img/loading_b.gif"></p>
							<h4><?=get_lang("upgrade_doing")?></h4>
						</div>
					</div>
				</div>
				
				
				<div class="step" id="step_success">
					<div class="step-top"><?=get_lang("upgrade_db")?></div>
					<div class="step-body">
					
						<div class="text-center">
							<p class="icon_success"></p>
						</div>
						<div class="text-center">
							<h4><?=get_lang("upgrade_success")?></h4>
						</div>
					</div>
					<div class="step-bottom">
						<a href='javascript:window.location.reload();' class='btn btn-primary'><?=get_lang("upgrade_db_reload")?></a>
					</div>
				</div>
				
				<div class="step" id="step_fail">
					<div class="step-top"><?=get_lang("upgrade_db")?></div>
					<div class="step-body">
						<div class="text-center">
							<p class="icon_fail"></p>
						</div>
						<div class="alert alert-danger" >
							<h4><?=get_lang("upgrade_fail")?></h4>
							<p id="container_error"><?=get_lang("upgrade_error_db")?></p>
						</div>
						
					</div>
					<div class="step-bottom"><input type="button" class="btn btn-primary"  value="<?=get_lang("btn_return")?>"  onclick="show_step1()" /></div>
				</div>

         </form>


</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	show_step("step1");
});
</script>