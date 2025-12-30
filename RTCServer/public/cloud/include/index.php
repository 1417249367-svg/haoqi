<?php 
require_once("../include/fun.php");

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

<body class="body-frame">
    <?php require_once("../include/header.php");?>
			<div id="sidebar">
				<ul>
					<!--<li><a href="#all"><span class="icon icon_dir"></span>全部文件</a></li>-->
					<li>
						<a href="#public" class="dropdown-toggle"><span class="icon icon_folder_public"></span><?=get_lang('icon_folder_public')?></a>
						<ul class="submenu">
							<li><a href="#public/1"><span class="icon icon_office"></span><?=get_lang('icon_office')?></a></li>
							<li><a href="#public/2"><span class="icon icon_pic"></span><?=get_lang('icon_pic')?></a></li>
							<li><a href="#public/3"><span class="icon icon_music"></span><?=get_lang('icon_music')?></a></li>
							<li><a href="#public/4"><span class="icon icon_video"></span><?=get_lang('icon_video')?></a></li>
					   </ul>
					</li>
					<li>
						<a href="#person" class="dropdown-toggle"><span class="icon icon_folder_person"></span><?=get_lang('icon_folder_person')?></a>
						<ul class="submenu">
							<li><a href="#person/1"><span class="icon icon_office"></span><?=get_lang('icon_office')?></a></li>
							<li><a href="#person/2"><span class="icon icon_pic"></span><?=get_lang('icon_pic')?></a></li>
							<li><a href="#person/3"><span class="icon icon_music"></span><?=get_lang('icon_music')?></a></li>
							<li><a href="#person/4"><span class="icon icon_video"></span><?=get_lang('icon_video')?></a></li>
					   </ul>
					</li>
					<li><a href="#recent"><span class="icon icon_recent"></span><?=get_lang('icon_recent')?></a></li>
					<!--<li><a href="#favitor"><span class="icon icon_favitor"></span>我的订阅</a></li>-->
			   </ul>
			</div>
			<div id="main">
				<div id="toolbar" class="clearfix">
					<div id="upload_disabled" class="toolbar_upload">
						<a href="javascript:void(0);" class="btn btn-primary" id="btn_doc_upload" disabled="disabled"><span class="icon icon_upload"></span><?=get_lang('icon_upload')?></a>
					</div>
					<!-----SWF UPLOAD-------->
					<div id="upload_swf" class="toolbar_upload">
						<input id="file_upload" name="file_upload" type="file" multiple>
					</div>
					<!-----END SWF UPLOAD-------->
					
					
					<!-----HTML UPLOAD-------->
					<div id="upload_form" class="toolbar_upload">
						<form enctype="multipart/form-data" id="form_upload" name="form_upload" method="post" target="frm_hidden" style="margin:0px;padding:0px;">
							<input type="file" id="inputfile" name="inputfile" class="inputfile" onchange="file_upload_html()" />
						</form>
						<a href="javascript:void(0);" class="btn btn-primary" id="btn_doc_upload"><span class="icon icon_upload"></span><?=get_lang('icon_upload')?></a>

					</div>
					<!-----END HTML UPLOAD-------->

					<div class="toolbar_btn">
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_download" action-type="doc_download"><span class="icon icon_download"></span><?=get_lang('icon_download')?></a>
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_delete" action-type="doc_delete"><span class="icon icon_delete"></span><?=get_lang('icon_delete')?></a>
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_folder_create" action-type="folder_create"><span class="icon icon_folder_create"></span><?=get_lang('icon_folder_create')?></a>
						<a href="javascript:void(0);" class="btn btn-default btn_cmd btn_doc_move" action-type="doc_move"><span class="icon icon_move"></span><?=get_lang('icon_move')?></a>
						<a href="javascript:void(0);" class="btn btn-default" id="btn_refresh" action-type="doc_refresh"><span class="icon icon_refresh"></span></a>
					</div>
					<div class="toolbar_more">

					
					  <div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?=get_lang('dropdown-toggle')?> <span class="caret"></span></button>
						<ul class="dropdown-menu pull-right">
						  <li><a href="javascript:void(0);" action-type="sort_time"><span class="icon icon_time"></span><?=get_lang('icon_time')?></a></li>
						  <li><a href="javascript:void(0);" action-type="sort_name"><span class="icon icon_az"></span><?=get_lang('icon_az')?></a></li>
						  <li id="btn_show_thumb"><a href="javascript:void(0);" action-type="show_thumb"><span class="icon icon_thumb"></span><?=get_lang('icon_thumb')?></a></li>
						  <li id="btn_show_list"><a href="javascript:void(0);" action-type="show_list"><span class="icon icon_list"></span><?=get_lang('icon_list')?></a></li>
						</ul>
					  </div>
					</div>
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
				<div class="fluent doc_thumb" id="doc_list">

				</div>
			</div>
			<div class="clear"></div>
			

 
<script type="text/x-jquery-tmpl" id="tmpl_list">
	<div class="doc_item" id="${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}" data-file-id="${col_id}" data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}" data-creatorid="${creatorid}">
		<div class="doc_check"><input type="checkbox" name="chk_id" value="${col_doctype}_${col_id}_${col_rootid}"></div>
		<div class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></div>
		<div class="doc_name">${col_name}</div>
		<div class="doc_size">${filesize_text}</div>
		<div class="doc_time">${col_dt_create}</div>
		<div class="doc_cmd">
			<a href="javascript:void(0);" class="icon_download btn_doc_download" onclick="doc_download('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_attr btn_doc_view"  onclick="doc_attr('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			
			<a href="javascript:void(0);" class="icon_move btn_cmd btn_doc_move"  onclick="doc_move('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_edit btn_cmd btn_doc_edit"  onclick="doc_rename('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_delete btn_cmd btn_doc_delete"  onclick="doc_delete('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			
			<a href="javascript:void(0);" class="icon_qrcode btn_doc_subscribe btn_file" onclick="doc_qrcode('${col_doctype}_${col_id}_${col_rootid}',this)" ></a>
			
		</div>
	</div>
</script>

<div id="contextmenu_doc" class="contextmenu dropdown-menu" style="left:100px;top:300px;">
	<ul>
		<li id="item_download" class="btn_doc_download"><a href="javascript:void(0);"><span class="icon icon_download"></span><?=get_lang('icon_download')?></a></li>
		<li id="item_attr" class="btn_doc_view"><a href="javascript:void(0);"><span class="icon icon_attr"></span><?=get_lang('icon_attr')?></a></li>
		<li class="divider"></li>
		<li id="item_move" class="btn_cmd btn_doc_move"><a href="javascript:void(0);"><span class="icon icon_move"></span><?=get_lang('icon_move')?></a></li>
		<li id="item_edit" class="btn_cmd btn_doc_edit"><a href="javascript:void(0);"><span class="icon icon_edit"></span><?=get_lang('icon_edit')?></a></li>
		<li id="item_delete" class="btn_cmd btn_doc_delete"><a href="javascript:void(0);"><span class="icon icon_delete"></span><?=get_lang('icon_delete')?></a></li>
		<li class="divider btn_file"></li>
		<li id="item_qrcode" class="btn_doc_qrcode btn_file"><a href="javascript:void(0);"><span class="icon icon_qrcode"></span><?=get_lang('icon_qrcode')?></a></li>
	</ul>
</div>

<!---Upload List---------------------------->
<div id="upload_container"  style="display:none">
	<div class="upload_top clearfix">
		<div class="upload_title"><span class="upload_count">67</span><?=get_lang('upload_title')?></div>
		<!--
		<div class="upload_winbtn">
			<span class="icon icon_win_plus btn_switch hand"></span>
			<span class="icon icon_win_close btn_close hand"></span>
		</div>
		-->
	</div>
	<div class="upload_content" style="display:block">
		<div id="upload_queue" class="upload_body">
		</div>
	</div>
</div>
<!---End Upload List------------------------>
 

	<?php require_once("../include/footer.php");?>
	
	<script type="text/javascript" src="/static/js/jquery.contextmenu.js"></script>


</body>
</html>


<script type="text/javascript">

$(document).ready(function(){

    $(".fluent").attr("abs_height",142).attr("abs_width",160) ;
	resize();
	window.onresize = function(e){
		resize();
	}

	formatContainer();
	
	initSideBar();
	
	//锚点
  	hash_init();
	
	//searchbox
	$("#search_key")
		.focus(function(){
			$(this).parent().addClass("search_box_foucs");
		})
		.blur(function(){
			$(this).parent().removeClass("search_box_foucs");
		})
		.keyup(function(){
			doc_search();
		})
	$("#search_btn").click(function(){
		doc_search();
	})
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
//alert(JSON.stringify(ace_data));
 
var originalTitle = "<?=get_lang('originalTitle')?>";    
function changeTitle()
{
	document.title = originalTitle;
}

window.setTimeout(changeTitle,1000); 
</script>


