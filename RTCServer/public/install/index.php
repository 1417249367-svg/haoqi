<?php
require_once("fun.php");
require_once(__ROOT__ . "/class/ant/SYSConfig.class.php");

 

//只能是本机上访问
//checkLocalLimit();

//from web config
$DBType 		= DB_TYPE ;
$DBServer 		= DB_SERVER ;
$DBPort        	= DB_PORT ;
$DBName 		= DB_NAME ;
$DBUser 		= DB_USER ;
$DBPassword 	= DB_PWD ;
$DBFILE			= "";
 
if ($DBType == "")
	$DBType = "mssql" ;

function check_func($function_name)
{
	$result = function_exists($function_name) ;
	return check_return($result) ;
}

function check_return($result)
{
	if ($result)
		return ('<span class="icon-success"></span>');
	else
		return ('<span class="icon-error"></span>');
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<script type="text/javascript" src="/static/js/pinyin.js"></script>
	<script type="text/javascript" src="assets/js/install.js"></script>
<style>
label {
	font-size: 16px;
	padding: 5px 0px;
}

#step0 ul{margin:10px;}
#step0 li{ list-style-type:none;padding:5px;}
#step0 li span{padding-right:10px;}
</style>
</head>
<body>

				<form  id="form1" method="post" action="db.html" class="form-horizontal">
				
				<div class="step" id="step0">
					<div class="step-top"><?=get_lang("lv_welcome")?></div>
					<div class="step-body">
						<fieldset>
							<legend><?= get_lang("environment_check")?></legend>
							<ul>
								<?php if ($os == "windows") {?>
								<li><?=check_func(version_compare("5.4", PHP_VERSION, ">")?'mssql_connect':'sqlsrv_connect');?><?=get_lang("environment_check_mssql")?></li>
								<?php }?>
								<?php if ($os == "linux") {?>
                                <li><?=check_func(version_compare("5.4", PHP_VERSION, ">")?'mssql_connect':'sqlsrv_connect');?><?=get_lang("environment_check_mssql")?></li>
								<li><?=check_func('dm_connect');?><?=get_lang("environment_check_dm")?></li>
								<?php }?>
							</ul>

						</fieldset>

					</div>
					<div class="step-bottom">
						<input type="button" class="btn btn-primary"  value="<?= get_lang("btn_next")?>" onclick="step0_next()" />
					</div>
				</div>
				
				<div class="step" id="step1">
					<div class="step-top"><?=get_lang("lv_welcome")?></div>
					<div class="step-body">
						<fieldset>
							<legend><?= get_lang("db_config")?></legend>
							<div class="form-group">
								<div class="control-value">
									<div>
										<label class="pull-left"><input type="radio" name="rad_dbtype" id="rad_dbtype_1" value="-1" <?=$DBType != "access"?"checked":""?> /> <?= get_lang("db_type_other")?> </label>
										<select class="form-control pull-left" name="drp_dbtype" id="drp_dbtype" style="width:305px;margin-left:10px;<?=$DBType == "access"?"display:none":""?>" >
										  <?php if ($os == "windows") {?>
										  <option value="mssql" <?=$DBType == "mssql"?"selected='selected'":""?>><?= get_lang("db_dbtype_mssql")?></option>
										  <?php }?>
                                          <?php if ($os == "linux") {?>
                                         <option value="mssql" <?=$DBType == "mssql"?"selected='selected'":""?>><?= get_lang("db_dbtype_mssql")?></option>
                                          <option value="dm" <?=$DBType == "dm"?"selected='selected'":""?>><?= get_lang("db_dbtype_dm")?></option>
                                          <?php }?>
										</select>

									</div>

								</div>
							</div>
						</fieldset>
					</div>
					<div class="step-bottom">
						<input type="button" class="btn btn-default"  value="<?= get_lang("btn_prev")?>" onclick="step1_prev()" />
						<input type="button" class="btn btn-primary"  value="<?= get_lang("btn_next")?>" onclick="step1_next()" />
					</div>
				</div>


				<div class="step" id="step2">
					<div class="step-top"><?=get_lang("lv_welcome")?></div>
					<div class="step-body">
						<fieldset>
							<legend><?= get_lang("db_config")?></legend>
							<div class="form-group" id="row_dbserver">
								<label class="control-label"><?= get_lang("db_server")?></label>
								<div class="control-value">
									<input type="text"  class="form-control fl"   id="DBServer" name="DBServer" value="<?=$DBServer?>" maxlength="50" style="width:200px" />
									
									<span class="fl" style="width:110px;text-align:right;margin-right:5px;line-height:30px;"><?= get_lang("db_port")?></span>
									<input type="text"  class="form-control fl"   id="DBPort" name="DBPort" value="<?=$DBPort?>" maxlength="50" style="width:100px" />
								</div>
							</div>
							<div class="form-group" id="row_dbname">
								<label class="control-label"><?= get_lang("db_name")?></label>
								<div class="control-value"><input type="text"  class="form-control"   id="DBName" name="DBName" value="<?=$DBName?>" maxlength="50"  /> </div>
							</div>
							<div class="form-group">
								<label class="control-label"><?= get_lang("db_user")?></label>
								<div class="control-value"><input type="text"  class="form-control"   id="DBUser" name="DBUser" value="<?=$DBUser?>" maxlength="50"  /></div>
							</div>
							<div class="form-group">
								<label class="control-label"><?= get_lang("db_password")?></label>
								<div class="control-value"><input type="password"  class="form-control"   id="DBPassword" name="DBPassword" value="<?=$DBPassword?>"  maxlength="50" /> </div>
							</div>
						</fieldset>
					</div>
					<div class="step-bottom">
                        <input type="hidden" id="DBUser1" name="DBUser1" value="<?=$DBUser?>" />
						<input type="hidden"  class="form-control"  data-type="REG_DWORD" id="DBLoginMode" name="DBLoginMode" value="0" />
						<input type="button" class="btn btn-default"  value="<?= get_lang("btn_prev")?>" onclick="step2_prev()" />
						<input type="button" class="btn btn-primary"  value="<?= get_lang("btn_next")?>"  onclick="step2_next()" />
					</div>
				</div>


				<div class="step" id="step_submiting">
					<div class="step-top"><?= get_lang("lv_welcome")?></div>
					<div class="step-body">
						<div class="text-center">
							<p style="padding:30px"><img src="/static/img/loading_b.gif"></p>
							<h4><?= get_lang("text_configing")?></h4>
						</div>
					</div>
				</div>


				<div class="step" id="step_success">
					<div class="step-top"><?= get_lang("lv_welcome")?></div>
					<div class="step-body">

						<div class="text-center">
							<p class="icon_success"></p>
						</div>
						<div>
							<h4><?= get_lang("text_config_success")?></h4>
							<p id="container_init"><?= get_lang("label_default_account")?>：<b style="color:red">admin</b>  <?= get_lang("label_default_password")?>：<b style="color:red"><?= get_lang("label_default_empty")?></b></p>
							<p><?= get_lang("text_use_tip")?></p>
						</div>
					</div>
					<div class="step-bottom"><a href='../admin/account/login.html' target='_blank' class='btn btn-primary'><?= get_lang("btn_login")?></a></div>
				</div>

				<div class="step" id="step_fail">
					<div class="step-top"><?= get_lang("lv_welcome")?></div>
					<div class="step-body">
						<div class="text-center">
							<p class="icon_fail"></p>
						</div>
						<div class="alert alert-danger" >
							<h4><?= get_lang("text_config_fail")?></h4>
							<p id="container_error"><?= get_lang("text_config_error_db")?></p>
                            <p><?=get_lang("environment_download_mssql")?></p>
						</div>

					</div>
					<div class="step-bottom"><input type="button" class="btn btn-primary"  value="<?= get_lang("btn_return")?>"  onclick="step1_next()" /></div>
				</div>
         </form>


</body>
</html>

<script type="text/javascript">
var curDBPort = "<?=$DBPort ?>";
var curDBServer = "<?=$DBServer?>";
var curDBType = "<?=$DBType?>";
$(document).ready(function(){
	show_step("step0");
	$("input[name=rad_dbtype]").click(function(){
		switch($("input[name=rad_dbtype]:checked").attr("id")){
		  case "rad_dbtype_0":
			  $("#drp_dbtype").hide();
			  break;
		  case "rad_dbtype_1":
			  $("#drp_dbtype").show();
			  break;
		  default:
			  break;
		}
	});
});

</script>