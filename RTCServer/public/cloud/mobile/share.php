<?php 
require_once("../include/fun2.php");

//将权限加载到SESSION中
$ace = new DocAce();
$ace -> load_all_ace() ;
$userId = CurUser::getUserId() ;
$admin = CurUser::isAdmin();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=get_lang('originalTitle')?></title>
<?php require_once("../include/meta1.php");?>

</head>
<body>
<div id="pnl_error" class="alert alert-danger" style="display:none;position:absolute;width:100%;">
  <b><?=get_lang('pnl_error')?></b>
</div>
<div id="page1" class="container">
    <div class="header">
        <div class="left-item"><img src="/cloud/assets/img/cloud.png" alt=""></div>
        <div class="right-menu">
            <ul class="nav navbar-nav pull-right" id="nav_account">
        <?php
            if ($userId == 0){
        ?>
                <li class="dropdown" id="login_btn">
                  <a href="javascript:void(0);" class="dropdown-toggle"><img src="../assets/img/avatar.png" class="photo"> <?=get_lang('header_login_btn')?></a>
                </li>
        <?php
            }else{
        ?>
               <li class="dropdown">
                  <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="../assets/img/face.png" class="photo"><?=CurUser::getUserName()?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li id="logout_btn"><a href="javascript:void(0);"><?=get_lang('header_logout')?></a></li>
                  </ul>
                </li>
        <?php
            }
        ?>
            </ul>
        </div>
    </div>
    <div class="nav-box">
         <a class="item" href="#">首页</a>><a href="#">文件</a>
    </div>

    <div class="main-content">
        <div class="list-box">
        </div>
    </div>
    
	<script type="text/x-jquery-tmpl" id="tmpl_list">
		<div class="list-item" id="${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}" data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}">
			<span class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></span>
			<span>${col_name}<br><em>${col_dt_create}</em>&nbsp;&nbsp;<em>${filesize_text}</em></span>
		</div>
    </script>
				
    <div align="center">
        <input type="button" class="btn btn-primary" onclick="doc_save()" value="<?=get_lang("btn_cloud_save")?>" />
    </div>
</div>

<div id="page2" class="container" style="display:none;">
    <div class="header" style="background-color:#437ef6;">
        <div id="chk_all" class="left-item" style="color:#FFF"><?=get_lang("col_chk_notall")?></div>
        <div id="path_info" data-count="0" class="left-item" style="color:#FFF"></div>
        <div id="cancel" class="right-menu" style="color:#FFF"><?=get_lang("btn_cancel")?></div>
    </div>
    <div class="nav-box">
         <span class="item">首页></span><span>文件</span>
    </div>

    <div class="main-content">
        <div class="list-box">
        </div>
    </div>
    
	<script type="text/x-jquery-tmpl" id="tmpl_list1">
		<div class="list-item" id="check_${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}"  data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}">
			<input type="checkbox" name="chk_id" value="${col_doctype}_${col_id}_${col_rootid}" checked>
			<span class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></span>
			<span>${col_name}<br><em>${col_dt_create}</em>&nbsp;&nbsp;<em>${filesize_text}</em></span>
		</div>
    </script>
				
    <div align="center">
        <div class="doc-save-box"><span class="item">保存位置:</span><span>个人文档</span></div><input type="hidden" id="target_id" name="target_id" value="0" /><input id="doc_save" type="button" class="btn btn-primary" onclick="doc_share_save()" value="<?=get_lang("btn_save")?>" />
    </div>
</div>
<div id="page3" class="container" style="display:none;">
    <div class="header">
        <div id="folder_nav_box" class="left-item"><?=get_lang("folder_nav_box")?></div>
        <div id="close" class="right-menu"><?=get_lang("btn_close")?></div>
    </div>
    <div class="nav-box1">
         <span><?=get_lang("btn_return")?></span>
    </div>

    <div class="main-content">
        <div class="list-box1">
        </div>
    </div>
    
	<script type="text/x-jquery-tmpl" id="tmpl_list2">
		<div class="list-item" id="folder_${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}" data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}">
			<span class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></span>
			<span>${col_name}<br><em>${col_dt_create}</em></span>
		</div>
    </script>
				
    <div align="center">
        <input id="doc_savefolder" type="button" class="btn btn-primary" onclick="doc_share_save()" value="<?=get_lang("btn_save")?>" />
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	hash_init();
	
	var browser={
	versions:function(){
		var u = navigator.userAgent, app = navigator.appVersion;
		return {
			trident: u.indexOf('Trident') > -1, //IE内核
			presto: u.indexOf('Presto') > -1, //opera内核
			webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
			gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
			mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
			ios: !!u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/), //ios终端
			android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
			iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
			iPad: u.indexOf('iPad') > -1, //是否iPad
			webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
			};
		}(),
		language:(navigator.browserLanguage || navigator.language).toLowerCase()
		}
	if(browser.versions.android==true||browser.versions.iPhone==true||browser.versions.iPad==true){
		
	}else{
		//hash = hash_get(location.hash) ;
		var url = decodeURI(hash.url);
		if (hash.param != "")
			url += "?" + hash.param ;
		url=site_address + "/cloud/include/share.html"+url;
		window.location.href=url;
	}

	
	$("#login_btn").click(function(){
		var url = decodeURI(hash.url);
		if (hash.param != "")
			url += "?" + hash.param ;
		url=site_address + "/cloud/mobile/share.html"+url;
		location.href = "../mobile/login.html?op=relogin&gourl="+escape(url) ;
	})
	
	$("#logout_btn").click(function(){
		logout();
	})
});

var UPLOAD_SIZE_LIMIT = "<?=UPLOAD_SIZE_LIMIT == 0?"0":UPLOAD_SIZE_LIMIT . "MB"?>";
var pagesize = parseInt("<?=DOC_PAGE_SIZE?>");
var site_address = "<?=getRootPath() ?>";
var _isadmin = "<?=$admin?>" == "1" ;
var curr_loginname = "<?=CurUser::getLoginName()?>";
var curr_password = "<?=CurUser::getPassword()?>";
var _curr_userid = "<?=CurUser::getUserId()?>" ;

//生成权限数据  ace_data [{"doc_type":105,"doc_id":1,"power":1},{"doc_type":102,"doc_id":1,"power":1}]
var aces = "<?=getValue("doc_aces")?>".split(",") ;
var my_root_id = parseInt("<?=getValue("doc_myroot")?>") ;
var ace_data = [] ;
for(var i=0;i<aces.length;i++)
{
	var ace_item = aces[i].split("_");
	ace_data.push({"doc_type":ace_item[0],"doc_id":ace_item[1],"power":ace_item[2]});  
}

 
var originalTitle = "<?=get_lang('originalTitle')?>";    
function changeTitle()
{
	document.title = originalTitle;
}

window.setTimeout(changeTitle,1000); 

</script>