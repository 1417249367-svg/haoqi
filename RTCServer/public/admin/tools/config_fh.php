<?php
define("MENU","CONFIG_FH") ;

require_once("../include/fun.php");
require_once(__ROOT__ . "/class/ant/AntWebConfig.class.php");
require_once(__ROOT__ . "/class/common/Regedit.class.php");

$encryption_key = g("encryption_key","");
$fiberhome_api = g("fiberhome_api","");
if($encryption_key != "" || $fiberhome_api != "")
{
    $regedit = new Regedit();
    $regedit -> set_batch(REG_PATH_SERVER,array("ENCRYPTION_KEY","FIBERHOME_API"),array($encryption_key,$fiberhome_api),array("REG_SZ","REG_SZ"));

    $config = new AntWebConfig();
    $config -> config_file = "../../config/config.inc.php";
    $config -> setValue(array("ENCRYPTION_KEY"=>$encryption_key,"FIBERHOME_API"=>$fiberhome_api));
    header ( "Location:config_fh.html" );
}


?>

<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<style>
fieldset {
	border: 1px solid #ccc;
	padding-bottom: 10px;
}

legend {
	background-color: transparent;
	width: auto;
	margin: 0px 10px;
	padding: 0px;
}

.box_must {
	background: #eef6fb;
}

.box_option {
	background: #f7f7f7;
}

.warnning {
	color: #f00;
	margin-right: 5px;
}
</style>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>集成配置</h1></div>
					<div id="pnl_success" class="alert alert-success" style="display:none" >修改成功。</div>
                    <form  id="form1" method="post" class="form-horizontal" style="width:600px;">
					<fieldset class="box_option">
						<legend>配置信息</legend>
                        <div class="form-group">
                            <label class="control-label">办公套件接口</label>
                            <div class="control-value"><input type="text" id="fiberhome_api" name="fiberhome_api" value="<?=FIBERHOME_API?>" class="form-control"  maxlength="200" /></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">加密密钥</label>
                            <div class="control-value"><input type="password"  class="form-control" id="encryption_key" name="encryption_key" value="<?=ENCRYPTION_KEY?>" maxlength="16" required /> </div>
                        </div>
					</fieldset>
                        <div style="padding:0px;">
                            <input type="submit"  class="btn btn-primary"  id="btn_save"  value="保存配置信息" /> </div>
                        </div>
                    </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
