<?php  require_once("include/fun.php");?>
<?php
    $chatid = g("chatid");
	$dp = new Model("lv_chat");
	$dp -> addParamWhere("chatid",$chatid);
    $row = $dp-> getDetail();
?>
<html>
<head>
    <title><?=get_lang('page_title')?></title>
    <link   rel="stylesheet"  href="assets/css/aside.css" />
	<script type="text/javascript" src="/static/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/site.js"></script>
	<script type="text/javascript" src="assets/js/linkbox.js"></script>
</head>
<body>
<div style="width:100%;height:100%; overflow:auto ;margin:0px;">
	<div class="user-info">
		<div class="user-photo">
			<img src="assets/img/default.png" />
		</div>
		<div class="user-intro">
			<ul>
				<li><b><?=$row["username"]?></b> </li>
				<li>IP：<?=$row["ip"]?></li>
				<li><?=get_lang('aside_intime')?>：<?=$row["intime"]?></li>
			</ul>
		</div>
	</div>
    <form enctype="multipart/form-data" id="frmUpload" method="post" target="frm_Upload" style="margin:0px;padding:0px;">
        <fieldset>
            <legend><?=get_lang('aside_public')?></legend>
            <ul class="link-list" id="container_public">
            </ul>
        </fieldset>
        <fieldset>
            <legend><?=get_lang('aside_tmp')?></legend>
            <ul class="link-list" id="container_tmp">
            </ul>


        </fieldset>

        <div class="clear">
            <select id="drp_ChatId" name="drp_ChatId" class="txt fl mr" ></select>
            <input type="file" id="file1" name="file1" class="txt fl" style="width:140px;">
            <input type="button"  value="<?=get_lang('btn_send')?>" onclick="uploadFile()" class="btn-aside fr"/>
            <div class="clear"></div>
        </div>
    </form>
</div>
<iframe id="frm_Upload"  name="frm_Upload" style="display:none;"></iframe>
</body>
</html>
<script type="text/javascript">
    var chatId = "<?=$chatid?>" ;
    var flag = 0 ;

    $("#drp_ChatId").html("<option value='" + chatId + "'><?=get_lang('aside_tmp')?></option><option value=''><?=get_lang('aside_public')?></option>");
    $(document).ready(function(){
        listFile("") ;
        listFile(chatId) ;
    })


</script>