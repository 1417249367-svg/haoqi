<?php  require_once("include/fun.php");?>
<?php
    $loginName = g("loginName","admin@rtcim.com");
	$dp = new Model("lv_chater");
	$dp -> addParamWhere("loginname",$loginName);
    $row = $dp-> getDetail();
	if (count($row) == 0)
		$row = array("loginname"=>$loginName,"username"=>$loginName,"deptname"=>"","jobtitle"=>"","phone"=>"","mobile"=>"","email"=>"","picture"=>"") ;
?>
<html>
<head>
    <title></title>
    <link   rel="stylesheet"  href="assets/css/aside.css" />
	<script type="text/javascript" src="/static/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/site.js"></script>
	<script type="text/javascript" src="assets/js/linkbox.js"></script>
</head>
<body>
<div style="width:100%;height:100%; overflow:auto ;margin:0px;">

    <div class="user-info">
        <div class="user-photo">
            <img class="photo" onerror="this.src='assets/img/default.png'"  style="width:90px;height:90px;"/><br>
        </div>
        <div class="user-intro">
            <ul>
                <li><b><?=$row["username"]?></b></li>
                <li><?=get_lang('aside_visitor_dept')?>：<?=$row["deptname"]?></li>
                <li><?=get_lang('aside_visitor_email')?>：<?=$row["email"]?></li>
                <li><?=get_lang('aside_visitor_phone')?>：<?=$row["phone"]?></li>
                <li><?=get_lang('aside_visitor_mobile')?>：<?=$row["mobile"]?></li>
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
        <a href="javascript:void(0);" onClick="loadData()" class="btn-aside" style="line-height:22px;"><?=get_lang('btn_refresh')?></a>
    </form>
</div>

</body>
</html>
<script type="text/javascript">
    var chatId = "<?=g("chatid","-1")?>" ;
	var loginName = "<?=$loginName?>" ;
    var flag = 0 ;
	var appPath = "<?=getRootPath() ?>";
	var defaultImg = appPath + "/livechat/assets/img/default.png" ;


    $(document).ready(function(){
        loadData();
    })

    function loadData()
    {
        listChaterPhoto("<?=$row["picture"]?>");
		listLink("") ;
        listLink(loginName) ;
    }
	
    function listChaterPhoto(picture)
    {
		if (picture == "")
            picture = defaultImg ;
		else picture = get_download_img_url(picture) ;
        $(".photo").attr("src", picture) ;

    }
	
	function get_download_img_url(tString)
	{
		var url = "myid=livechat&label=msg&name=" + tString  ;
		url = "/public/cloud.html?op=getfile&" + url ;
		return url ;
	}
</script>