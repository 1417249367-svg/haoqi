<?php  require_once("../include/fun.php");?>
<?php
define("MENU","HOME") ;
require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");
$issuper = 0 ;
$content = new SimpleIniIterator(__ROOT__ . '/Data/Config.ini');
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script type="text/javascript" src="../assets/js/livechat.js"></script>
    <script type="text/javascript" src="../assets/js/lcuserpicker.js"></script>
	<link type="text/css" rel="stylesheet" href="../assets/css/home.css" />
</head>

<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="section" style="margin-top:20px">
				</div>
				<div class="section">
					<h4><?=get_lang('index_commonuse')?></h4>
					<div class="wizard-box">
						<ul>
							<li class="box-org">
								<a href="../hs/org_list.html">
									<span></span>
									<h5><?=get_lang('index_user')?></h5>
									<p><?=get_lang('index_user_des')?></p>
								</a>
							</li>
							<li class="box-client">
                                <a href="../lv_manager/chater_list.html">
									<span></span>
									<h5><?=get_lang('index_service')?></h5>
									<p><?=get_lang('index_service_des')?></p>
								</a>
							</li>
							<li class="box-service">
								<a href="../set/application.html">
									<span></span>
									<h5><?=get_lang('index_application')?></h5>
									<p><?=get_lang('index_application_des')?></p>
								</a>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="section" style="border-bottom-width:0px">
					<h4><?=get_lang('index_map')?></h4>
					<div class="wizard">
						<?php  require("../include/menu.php");?>
					</div>
					<div class="clear"></div>
				</div>
	<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript" src="/static/js/editBox.js"></script>
<script type="text/javascript">
var updated_date;
	$(document).ready(function(){
		var url = getAjaxUrl("system","set_companyname");
		var editbox = $("#lbl_companyname").editBox({url:url,triobj:$("#btn_set_companyname")});
		updated_date = "<?=$content->getIniValue('updated_date', 'date')?>" ;
		checkupdate();
	})
	
function checkupdate()
{
	var url="http://www.haoqiniao.cn/download/1/log.php?";
	url+="callback=?"; 
	jQuery.getJSON(url, function(data){
	   if(data.datetime>updated_date) dialog("update",langs.software_upgrade,"../help/update.html");
	});
}
</script>