<?php
define("MENU","HL_SET") ;

require_once ("../include/fun.php");
require_once (__ROOT__ . "/class/common/Regedit.class.php");
require_once (__ROOT__ . "/class/ant/SYSConfig.class.php");

$regedit = new Regedit ();


$sysconfig = new SYSConfig ();

//扩展功能
$serverFlagEx = $sysconfig->get("ServerFlagEx");
$useMulPlatForm = (($serverFlagEx & 2) == 2) ? 1:0;
$avTransfer = (($serverFlagEx & 4) == 4) ? 1:0;

//是否推送
$syncPush = $sysconfig->get("SyncPushTargetType") == "1";

//P2P阀值
$p2pThreshold = $sysconfig->get("P2PThreshold","","0");

//webserivice认证
$webAuthen = $sysconfig->get("Type","AntAuthenConfig");




?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/set.js"></script>
<style>
fieldset {
	padding: 0px;
	margin-bottom: 20px;
	float: left;
	width: 45%;
	margin-right: 2%;
}

fieldset legend {
	padding: 5px;
	margin: 0px;
}

fieldset div {
	padding: 2px 0px;
	margin: 0px;
}
</style>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1>系统设置</h1></div>
				<div id="pnl_success" class="alert alert-success" style="display:none;font-size:14px;" >设置成功。(<span style="color:#f00;font-size:14px;">您需要重新启动服务才能生效</span>，<a href="service.html" >立即重启</a>)</div>
                <form  id="form-client" method="post" class="form-horizontal">
					<fieldset>
<legend>基本设置</legend>
						<div>公司名称: <input type="text"  class="txt regval" id="WebName" name="WebName" value="<?=$webname?>" style="width:200px" /></div>
                        <div>快捷方式: <input type="text"  class="txt regval" id="WebNa" name="WebNa" value="" style="width:200px" />(客户端电脑桌面将显示软件名称的快捷方式)</div>
						<div><input type="checkbox" class="regval" name="WebRun" value="1" <?= $webrun==1 ? "checked" : "" ?>> 客户端启动时，弹出网站 <input type="text"  class="txt regval" id="WebUrl" name="WebUrl" value="<?=$weburl?>" style="width:200px" /> </div>
                       <div style="height: 60px;margin: auto;position: relative;">公司logo:
                            <img id="img_logo" class="photo"  title="更改logo" alt="更改logo" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_logo" name="file_logo"  class="logo-picture pic" onchange="uploadFile('logo')" style="outline: none;" accept=".ico"/>
                            <a href="#" style="margin-left:270px" onClick="clear_data('logo')">清除logo</a>
                        </div>
                        <div style="height: 80px;margin: auto;position: relative;">公司banner:
                            <img id="img_banner" class="banner"  title="更改banner" alt="更改banner" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_banner" name="file_banner"  class="banner-picture pic" onchange="uploadFile('banner')" style="outline: none;" accept=".jpg"/>
                            <a href="#" onClick="clear_data('banner')">清除banner</a>
                        </div>
                    </fieldset>
					<fieldset>
						 <legend>服务器连接</legend>
						<div>IP地址: <input type="text"  class="txt regval" id="ServerIp" name="ServerIp" value="" style="width:200px" />(IP地址OR域名OR计算机名称)</div>
						<div>连接方式：<label><input type="radio"  name="Option1" value="0"/>IP地址</label>
							 <label><input type="radio"  name="Option1" value="1"/>域名</label><label><input type="radio"  name="Option1" value="2"/>计算机名称</label></div>
						<div><input type="checkbox" class="regval" name="Server_CheckIM1" value="1"> 自动登录</div>
						<div><input type="checkbox" class="regval" name="Server_CheckIM2" value="1" > 记住密码</div>
					</fieldset>
					<div class="form-group" style="padding:0px 10px;">
						<input type="submit"  class="btn btn-primary"  value="保存设置"/>
					</div>
                </form>

	<?php  require_once("../include/footer.php");?>


</body>
</html>
<script type="text/javascript">
var AntServerFlag = parseInt("<?=$regedit -> get(REG_PATH_SERVER . "\\AntServerFlag")?>") ;
var AutoClear = "<?=$regedit -> get(REG_PATH_SERVER . "\\AutoClear")?>" ;
var MsgLife = "<?=$regedit -> get(REG_PATH_SERVER . "\\MsgLife")?>" ;
var AutoAway = "<?=$regedit -> get(REG_PATH_SERVER . "\\AutoAway")?>" ;
var AutoAwayTime = "<?=$regedit -> get(REG_PATH_SERVER . "\\AutoAwayTime")?>" ;

</script>