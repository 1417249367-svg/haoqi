<?php 
require_once("../include/fun2.php");

//将权限加载到SESSION中
$ace = new DocAce();
$ace -> load_all_ace() ;
$admin = CurUser::isAdmin();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=get_lang('originalTitle')?></title>
    <?php require_once("../include/meta.php");?>
</head>

<body class="body-frame1">
    <?php require_once("../include/header1.php");?>
			<div id="main1">
				<div id="toolbar" class="clearfix">
					<div class="toolbar_btn">
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_download" action-type="doc_download"><span class="icon icon_download"></span><?=get_lang('icon_download')?></a>
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_download" action-type="doc_save"><?=get_lang('btn_save')?></a>
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_download" action-type="folder_qrcode"><?=get_lang('icon_qrcode')?></a>
					</div>
					<!--<div class="toolbar_more">

					
					  <div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">排序 <span class="caret"></span></button>
						<ul class="dropdown-menu pull-right">
						  <li><a href="javascript:void(0);" action-type="sort_time"><span class="icon icon_time"></span>按时间排序</a></li>
						  <li><a href="javascript:void(0);" action-type="sort_name"><span class="icon icon_az"></span>按名称排序</a></li>
						  <li id="btn_show_thumb"><a href="javascript:void(0);" action-type="show_thumb"><span class="icon icon_thumb"></span>显示缩略图</a></li>
						  <li id="btn_show_list"><a href="javascript:void(0);" action-type="show_list"><span class="icon icon_list"></span>显示列表</a></li>
						</ul>
					  </div>
					</div>-->
					<div class="clear"></div>
				</div>
				
				<div id="path">
					<div class="path_check"><input type="checkbox" name="chk_all" id="chk_all"></div>
					<ul class="path_node">
						<li class="active"><a href="javascript:void(0);" onclick="path_go(this)"><?=get_lang('path_node')?></a></li>
					</ul>
					<div class="path_info"></div>
					<div class="clear"></div>
				</div>
				<div class="fluent doc_thumb" style="padding-right:160px" id="doc_list">

				</div>
			</div>
			<div class="clear"></div>
			

 
<script type="text/x-jquery-tmpl" id="tmpl_list">
	<div class="doc_item" id="${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}" data-file-id="${col_id}" data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}">
		<div class="doc_check"><input type="checkbox" name="chk_id" value="${col_doctype}_${col_id}_${col_rootid}"></div>
		<div class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></div>
		<div class="doc_name">${col_name}</div>
		<div class="doc_size">${filesize_text}</div>
		<div class="doc_time">${col_dt_create}</div>
	</div>
</script>

<div id="contextmenu_doc" class="contextmenu dropdown-menu" style="left:100px;top:300px;">
	<ul>
		<li id="item_download" class="btn_doc_download"><a href="javascript:void(0);"><span class="icon icon_download"></span><?=get_lang('icon_download')?></a></li>
<!--		<li id="item_attr" class="btn_doc_view"><a href="javascript:void(0);"><span class="icon icon_attr"></span>详情</a></li>
		<li class="divider"></li>
		<li id="item_move" class="btn_cmd btn_doc_move"><a href="javascript:void(0);"><span class="icon icon_move"></span>移动到</a></li>
		<li id="item_edit" class="btn_cmd btn_doc_edit"><a href="javascript:void(0);"><span class="icon icon_edit"></span>重命名</a></li>-->
		<li id="item_delete" class="btn_cmd btn_doc_delete"><a href="javascript:void(0);"><span class="icon icon_delete"></span><?=get_lang('icon_save')?></a></li>
		<!--<li class="divider btn_file"></li>
		<li id="item_qrcode" class="btn_doc_qrcode btn_file"><a href="javascript:void(0);"><span class="icon icon_qrcode"></span>二维码下载</a></li>-->
	</ul>
</div>

	<?php require_once("../include/footer.php");?>
	
	<script type="text/javascript" src="/static/js/jquery.contextmenu.js"></script>


</body>
</html>


<script type="text/javascript">

$(document).ready(function(){
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
		hash = hash_get(location.hash) ;
		var url = decodeURI(hash.url);
		if (hash.param != "")
			url += "?" + hash.param ;
		url=site_address + "/cloud/mobile/share.html"+url;
		window.location.href=url;
	}

    $(".fluent").attr("abs_height",142).attr("abs_width",160) ;
	resize();
	window.onresize = function(e){
		resize();
	}

	formatContainer();
	
	initSideBar();
	//锚点
  	hash_init();
	//alert(location.hash);
	$("#login_btn").click(function(){
		var url = decodeURI(hash.url);
		if (hash.param != "")
			url += "?" + hash.param ;
		url=site_address + "/cloud/include/share.html"+url;
		//alert(url);
		location.href = "../account/login.html?op=relogin&gourl="+escape(url) ;
	})
	
	$("#logout_btn").click(function(){
		logout();
	})
	//searchbox
//	$("#search_key")
//		.focus(function(){
//			$(this).parent().addClass("search_box_foucs");
//		})
//		.blur(function(){
//			$(this).parent().removeClass("search_box_foucs");
//		})
//		.keyup(function(){
//			doc_search();
//		})
//	$("#search_btn").click(function(){
//		doc_search();
//	})
})

var UPLOAD_SIZE_LIMIT = "<?=UPLOAD_SIZE_LIMIT == 0?"0":UPLOAD_SIZE_LIMIT . "MB"?>";
var pagesize = parseInt("<?=DOC_PAGE_SIZE?>");
var site_address = "<?=getRootPath() ?>";
var _isadmin = "<?=$admin?>" == "1" ;
var curr_loginname = "<?=CurUser::getLoginName()?>";
var curr_password = "<?=CurUser::getPassword()?>";
var _curr_userid = "<?=CurUser::getUserId()?>" ;
var _curr_myfcname = "<?=CurUser::getUserName();?>";

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


