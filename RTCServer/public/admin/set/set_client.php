<?php  require_once("../include/fun.php");?>
<?php
define("MENU","SET_CLIENT") ;
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
	$db = new DB();
	$sql = "Select * from OtherForm where ID=1";
	$data = $db->executeDataRow($sql);
	//echo var_dump($data);
	$webname=$data['webname'];
	$weburl=$data['weburl'];
	$webrun=$data['webrun'];
	$logo=file_exist(__ROOT__."/templets/xiazai/logo.ico")?1:0;
	$banner=file_exist(__ROOT__."/templets/xiazai/ClientLogo.jpg")?1:0;
	$pan=file_exist(__ROOT__."/templets/xiazai/logo.png")?1:0;
	$content = new SimpleIniIterator(__ROOT__ . '/templets/xiazai/DataBase.ini');
	//$content->setIniValue('NewKey', 'NewValue','NewNode');
	//$content->setIniValue('lock_screen', '1', 'server_connection');
	//$content->setIniValue('U-swappable_disk_alarm', '0', 'U-authorization');
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/skin.js"></script>
<style type="text/css">
.current {
	background: url(/static/img/icon-success.png) no-repeat;
	position: absolute;
	width: 16px;
	height: 16px;
	right: 10px;
	top: -5px;
}
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
				<div class="page-header">
		<h1><?=get_lang('set_client_configuration')?></h1>
	</div>
	<!--List--->
    <div id="pnl_success" class="alert alert-success" style="display:none;font-size:14px;" ><?=get_lang('set_client_warning')?>(<a href="/templets/xiazai/RTC.zip" ><?=get_lang('set_client_download')?></a>)</div>
<form id="form-client" method="post" class="form-horizontal" enctype="multipart/form-data">
					<fieldset>
						<legend><?=get_lang('set_client_basic_settings')?></legend>
						<div><?=get_lang('set_client_WebName')?>: <input type="text"  class="txt regval" id="WebName" name="WebName" value="<?=$webname?>" style="width:200px" /></div>
                        <div><?=get_lang('set_client_WebNa')?>: <input type="text"  class="txt regval" id="WebNa" name="WebNa" placeholder="<?=get_lang('set_client_WebNa_desc')?>" value="<?=iconv_str($content->getIniValue('Web', 'WebNa'))?>" style="width:200px" /></div>
						<div><input type="checkbox" class="regval" name="WebRun" value="1" <?= $webrun==1 ? "checked" : "" ?>> <?=get_lang('set_client_WebRun')?> <input type="text"  class="txt regval" id="WebUrl" name="WebUrl" value="<?=$weburl?>" style="width:200px" /> </div>
                       <div style="height: 60px;margin: auto;position: relative;"><?=get_lang('set_client_logo')?>:
                            <img id="img_logo" class="photo"  title="<?=get_lang('set_client_edit_logo')?>" alt="<?=get_lang('set_client_edit_logo')?>" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_logo" name="file_logo"  class="logo-picture pic" onchange="uploadFile('logo')" style="outline: none;" accept=".ico"/>
                            <a href="#" style="margin-left:270px" onClick="clear_data('logo')"><?=get_lang('set_client_delete_logo')?></a>
                        </div>
                        <div style="height: 80px;margin: auto;position: relative;"><?=get_lang('set_client_banner')?>:
                            <img id="img_banner" class="banner"  title="<?=get_lang('set_client_edit_banner')?>" alt="<?=get_lang('set_client_edit_banner')?>" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_banner" name="file_banner"  class="banner-picture pic" onchange="uploadFile('banner')" style="outline: none;" accept=".jpg"/>
                            <a href="#" onClick="clear_data('banner')"><?=get_lang('set_client_delete_banner')?></a>
                        </div>
                        <div style="height: 80px;margin: auto;position: relative;"><?=get_lang('set_client_pan')?>:
                            <img id="img_pan" class="pan"  title="<?=get_lang('set_client_edit_logo')?>" alt="<?=get_lang('set_client_edit_logo')?>" data-toggle="tooltip" data-placement="left" title="Tooltip on left"/>
                            <input type="file" id="file_pan" name="file_pan"  class="pan-picture pic" onchange="uploadFile('pan')" style="outline: none;" accept=".png"/>
                            <a href="#" style="margin-left:270px" onClick="clear_data('pan')"><?=get_lang('set_client_delete_logo')?></a>
                        </div>
                        </fieldset>
                        <fieldset>
                        <legend><?=get_lang('set_client_server_connection')?></legend>
						<div><?=get_lang('set_client_ServerIp')?>: <input type="text"  class="txt regval" id="ServerIp" name="ServerIp" placeholder="<?=get_lang('set_client_ServerIp_desc')?>" value="<?=$content->getIniValue('server_connection', 'ServerIp')?>" style="width:200px" /></div>
						<div><?=get_lang('set_client_Option1')?>：<input type="radio"  name="Option1" value="0"/><?=get_lang('set_client_Option10')?><input type="radio"  name="Option1" value="1"/><?=get_lang('set_client_Option11')?><input type="radio"  name="Option1" value="2"/><?=get_lang('set_client_Option12')?></div>
						<div><input type="checkbox" class="regval" name="Server_CheckIM1" value="1" <?= $content->getIniValue('server_connection', 'CheckIM1')==1 ? "checked" : "" ?>> <?=get_lang('set_client_Server_CheckIM1')?></div>
						<div><input type="checkbox" class="regval" name="Server_CheckIM2" value="1" <?= $content->getIniValue('server_connection', 'CheckIM2')==1 ? "checked" : "" ?>> <?=get_lang('set_client_Server_CheckIM2')?></div>
                        </fieldset>
                        <div class="form-group" style="padding:0px 10px;">
                        <legend><?=get_lang('set_client_software_settings')?></legend>
                        <fieldset>
						<div><input type="checkbox" class="regval" name="CheckIM0" value="1" <?= $content->getIniValue('software_settings', 'CheckIM0')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM0')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM1" value="1" <?= $content->getIniValue('software_settings', 'CheckIM1')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM1')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM2" value="1" <?= $content->getIniValue('software_settings', 'CheckIM2')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM2')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM3" value="1" <?= $content->getIniValue('software_settings', 'CheckIM3')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM3')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM4" value="1" <?= $content->getIniValue('software_settings', 'CheckIM4')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM4')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM5" value="1" <?= $content->getIniValue('software_settings', 'CheckIM5')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM5')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM6" value="1" <?= $content->getIniValue('software_settings', 'CheckIM6')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM6')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM7" value="1" <?= $content->getIniValue('software_settings', 'CheckIM7')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM7')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM8" value="1" <?= $content->getIniValue('software_settings', 'CheckIM8')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM8')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM9" value="1" <?= $content->getIniValue('software_settings', 'CheckIM9')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM9')?></div>
						<div><input type="checkbox" class="regval" name="CheckIM11" value="1" <?= $content->getIniValue('software_settings', 'CheckIM11')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM11')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM13" value="True" <?= $content->getIniValue('software_settings', 'CheckIM13')=="True" ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM13')?></div>
                        <div><input type="checkbox" class="regval" name="CheckIM14" value="1" <?= $content->getIniValue('software_settings', 'CheckIM14')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckIM14')?></div>
                    </fieldset>
					<fieldset>
                        <div><input type="checkbox" class="regval" name="CheckTab5" value="1" <?= $content->getIniValue('software_settings', 'CheckTab5')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab5')?></div>
                        <div><input type="checkbox" class="regval" name="CheckTab9" value="1" <?= $content->getIniValue('software_settings', 'CheckTab9')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab9')?></div>
						<div><input type="checkbox" class="regval" name="CheckTab10" value="1" <?= $content->getIniValue('software_settings', 'CheckTab10')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab10')?></div>
                        <div><input type="checkbox" class="regval" name="CheckTab11" value="1" <?= $content->getIniValue('software_settings', 'CheckTab11')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab11')?></div>
						<div><input type="checkbox" class="regval" name="CheckTab12" value="1" <?= $content->getIniValue('software_settings', 'CheckTab12')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab12')?></div>
                        <div><input type="checkbox" class="regval" name="CheckTab13" value="1" <?= $content->getIniValue('software_settings', 'CheckTab13')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab13')?></div>
						<div><input type="checkbox" class="regval" name="CheckTab14" value="1" <?= $content->getIniValue('software_settings', 'CheckTab14')==1 ? "checked" : "" ?>> <?=get_lang('set_client_CheckTab14')?></div>
						<div><?=get_lang('set_client_HotKey0')?>: <input type="text"  class="txt regval" id="HotKey0" name="HotKey0" value="<?=$content->getIniValue('software_settings', 'HotKey0')?>" style="width:200px" /></div>
                        <div><?=get_lang('set_client_HotKey1')?>: <input type="text"  class="txt regval" id="HotKey1" name="HotKey1" value="<?=$content->getIniValue('software_settings', 'HotKey1')?>" style="width:200px" /></div>
                    </fieldset>
</div>
<!--                        <legend>默认皮肤</legend>
                        	<div class="container" id="datalist" data-tmpid="tmpl_list"
		data-obj="skin" data-ispage="0"
		<tbody>
		</tbody>
	</div>>-->
                    
					<div class="form-group" style="padding:0px 10px;">
						<input type="submit" id="btn_save" class="btn btn-primary"  value="<?=get_lang('base_btn_save')?>"/>
                        <input type="hidden" id="Skins" name="Skins" value="<?=$content->getIniValue('software_settings', 'Skins')?>"/>
                        <input type="hidden" id="logo" name="logo" value="<?=$logo?>"/>
                        <input type="hidden" id="banner" name="banner" value="<?=$banner?>"/>
                        <input type="hidden" id="pan" name="pan" value="<?=$pan?>"/>
					</div>
                </form>

	<!--End List--->
<!--	<script type="text/x-jquery-tmpl" id="tmpl_list">
					<div class="col-md-2"  style="width:160px;position:relative;">
						<b title="${skin_name}" class="${curr_class}"></b>
				        <div class="thumbnail" id="skin_${skin_id}">
				          <img style="width: 100%; display: block;" alt="${skin_name}" src="${skin_picture}" data-holder-rendered="true" onclick="show_img(${skin_id});" title="点击查看大图">
				          <div class="caption" style="text-align:center;" >
				            <h5>${skin_name}</h5>
				            <p>
					            <a class="btn btn-xs ${btn_class}" role="button" href="javascript:void(0);" action-data="'${skin_name}'" action-type="${action_type}">${btn_text}</a>
								<a class="btn btn-xs btn-default" role="button" href="javascript:void(0);" onclick="show_img(${skin_id});">预览</a>
							</p>
				          </div>
				        </div>
				      </div>
					<div id="picture_${skin_id}" style="display:none;"><img src="${skin_picture}" /></div>
				</script>-->
                <?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
var dataList;
var Option1 = parseInt("<?=$content->getIniValue('server_connection', 'Option1')?>") ;
$(document).ready(function(){
	init();
//	dataList = $("#datalist").dataList(skin_formatData,init);
//	$("#form1").validate({
//		submitHandler: function(form) {
//			save();
//			return false;
//		}
//	});
	$("#btn_save").click(function(){
        save();
        return false ;
    })
})
</script>

