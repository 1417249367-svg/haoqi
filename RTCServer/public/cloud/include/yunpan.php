<?php 
require_once("../include/fun.php");
require_once (__ROOT__ . "/class/common/visitorInfo.class.php");
//将权限加载到SESSION中
//$ace = new DocAce();
//$ace -> load_all_ace() ;
$visitor = new visitorInfo();
if($visitor->getBrowser()=='ie'){
	$currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$currentPageUrl = str_replace("cloud/include/yunpan.html","cloud/include/yunpan2.html",$currentPageUrl) ;
	 header("Location:".$currentPageUrl);
}
$userId = CurUser::getUserId() ;
$admin = CurUser::isAdmin();

if ($userId == 0)
	header("Location:../account/login.html?op=relogin&gourl=../include/yunpan.html");
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?=get_lang('originalTitle')?></title>
    <?php require_once("../include/meta2.php");?>
	<style>
	  #progress{
		width: 100%;
		height: 5px;
		background-color:#f7f7f7;
		box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);
		border-radius:4px;
		background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);
	  }
   
	  #finish{
		background-color: #149bdf;
		background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);
		background-size:40px 40px;
		height: 100%;
	  }
	  .upload_intro{float:left;width:100px;text-align:center;font-size:9pt;color:#999;}
	  .path_to a { color: #00e; }
	  .path_to a:visited { color: #551a8b; }
	  .path_to a:hover { color: #06e; }
	  .path_to a:focus { outline: thin dotted; }
    </style>
</head>
<body class="body-frame">
    <!-- 微云 -->
    <div class="weiyun">
        <!-- 头部 -->
        <header class="header">
            <!-- logo -->
            <a href="#" class="logo"></a>
            <!-- 用户信息 -->
            <div class="user">
                <ul class="nav navbar-nav" id="nav_account">
                    <li class="dropdown">
                      <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="../assets/img/face.png" class="photo"><?=CurUser::getUserName()?> <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="../account/login.html?op=logout&gourl=../include/yunpan.html#public"><?=get_lang('header_logout')?></a></li>
                      </ul>
                    </li>
                </ul>
            </div>
            <!-- 搜索框 -->
            <div class="header-search">
                <div class="beautiful-input">
                    <i class="ico"></i>
                    <input type="text" name="search_key" id="search_key" placeholder="<?=get_lang('icon_warning3')?>" autocomplete="off" maxlength="40" tabindex="0">
                </div>
            </div>
            <!-- 会员中心和下载 -->
                <div class="ad diff-adright">
<!--                    <a href="javascript:void(0)" class="renew-btn">
                        <i class="icon"></i>会员中心
                    </a>-->
                    <a href="/download.html" class="download-btn" target="_blank">
                        <?=get_lang('header_download')?>
                    </a>
                </div>
        </header>
        <!-- 主要内容区 -->
        <div class="weiyun-content">
            <!-- 左侧菜单区 -->
            <div class="lay-aside">

                
                <div class="aside-box">
                    <div class="aside-wrap">
                        <ul class="nav-box">
                            <li class="nav-list">
                                <a href="#public" class="link all" title="<?=get_lang('icon_folder_public')?>"><i></i><?=get_lang('icon_folder_public')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#public/1" class="link doc" title="<?=get_lang('icon_office')?>"><i></i><?=get_lang('icon_office')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#public/2" class="link pic" title="<?=get_lang('icon_pic')?>"><i></i><?=get_lang('icon_pic')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#public/3" class="link music" title="<?=get_lang('icon_music')?>"><i></i><?=get_lang('icon_music')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#public/4" class="link video" title="<?=get_lang('icon_video')?>"><i></i><?=get_lang('icon_video')?></a>
                            </li>
                            <li class="nav-gap">
                                <span class="gap"></span>
                            </li>
                            <li class="nav-list">
                                <a href="#person" class="link all" title="<?=get_lang('icon_folder_person')?>"><i></i><?=get_lang('icon_folder_person')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#person/1" class="link doc" title="<?=get_lang('icon_office')?>"><i></i><?=get_lang('icon_office')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#person/2" class="link pic" title="<?=get_lang('icon_pic')?>"><i></i><?=get_lang('icon_pic')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#person/3" class="link music" title="<?=get_lang('icon_music')?>"><i></i><?=get_lang('icon_music')?></a>
                            </li>
                            <li class="nav-list">
                                <a href="#person/4" class="link video" title="<?=get_lang('icon_video')?>"><i></i><?=get_lang('icon_video')?></a>
                            </li>
                            <li class="nav-gap">
                                <span class="gap"></span>
                            </li>
                            <li class="nav-list">
                                <a href="#recent" class="link recent" title="<?=get_lang('icon_recent')?>"><i></i><?=get_lang('icon_recent')?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- 右侧内容区域 -->
            <div class="main">
                <!-- 工具菜单导航 -->
                <div class="nav">
                    <nav class="nav-collects clearfix">
                        <div id="upload_disabled" class="toolbar_upload">
                            <a href="javascript:void(0);" class="btn btn-primary" disabled="disabled"><span class="icon icon_upload"></span><?=get_lang('icon_upload')?></a>
                        </div>
                        <!-----SWF UPLOAD-------->
                        <div id="upload_swf" class="toolbar_upload">
                            <input id="file_upload" name="file_upload" type="file" multiple>
                        </div>
                        <!-----END SWF UPLOAD-------->
                        
                        
                        <!-----HTML UPLOAD-------->
                        <div id="upload_form" class="toolbar_upload">
                            <form enctype="multipart/form-data" id="form_upload" name="form_upload" method="post" target="frm_hidden" style="margin:0px;padding:0px;">
                                    <input type="file" id="inputfile" name="inputfile" class="inputfile" multiple />
                                </form>
                                <a href="javascript:void(0);" class="btn btn-primary" id="btn_doc_upload"><span class="icon icon_upload"></span><?=get_lang('icon_upload1')?></a>
        
                        </div>
                        <!-----END HTML UPLOAD-------->
                        <a href="javascript:void(0);" class="nav-a down btn_cmd btn_doc_download" action-type="doc_download">
                            <span><i></i><span><?=get_lang('icon_download')?></span></span>
                        </a>
                        <a href="javascript:void(0);" class="nav-a share btn_cmd btn_doc_shareto" action-type="doc_shareto">
                            <span><i></i><span><?=get_lang('icon_share')?></span></span>
                        </a>
                        <a href="javascript:void(0);" class="nav-a move btn_cmd btn_doc_move" action-type="doc_move">
                            <span><i></i><span><?=get_lang('icon_move')?></span></span>
                        </a>
                        <a href="javascript:void(0);" class="nav-a delect btn_cmd btn_doc_delete" action-type="doc_delete">
                            <span><i></i><span><?=get_lang('icon_delete')?></span></span>
                        </a>
                        <a href="javascript:void(0);" class="nav-a create btn_cmd btn_folder_create" action-type="folder_create">
                            <span><i></i><span><?=get_lang('icon_folder_create')?></span></span>
                        </a>
                        <a href="javascript:void(0);" class="nav-a reload" action-type="doc_refresh">
                            <span><i></i><span><?=get_lang('icon_reload')?></span></span>
                        </a>
<!--                        <a href="#" class="nav-a arraybtn btn-inner1 g-btn-gray1" style="margin: 13px 20px 0 0px;">
                            <span><i></i><span></span></span>
                        </a>-->
<!--                        <a href="#" class="nav-a navbtn btn-inner1">
                            <span><i></i><span></span></span>
                        </a>-->
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
                    </nav>
                </div>
                <!-- 主要内容展示区 -->
                <div class="content clearfix">
                    <!-- 树形导航 -->
<!--                    <div class="tree-menu">

                    </div>-->
                    <!-- 文件展示区 -->
                    <div class="file-show">
                        <!-- 文件路径导航 -->
                        <div class="path-nav-box clearfix">
                            <lable class="cheched-all"></lable>
                            <div class="path-nav clearfix">
                                <!-- <a href="javascript:void(0)" style="z-index: 3;">微云</a>
                                <a href="javascript:void(0)" style="z-index: 2;">我的音乐</a>
                                <span class="current-path" style="z-index: 1;">周杰伦</span> -->
                            </div>
                            <div class="path_info"></div>
                        </div>
                        <!-- 空白文件展示区 -->
                        <div id="file_empty" class="g-empty sort-folder-empty">
                            <div class="empty-box">
                                <div class="ico"></div>
                                <p class="title"><?=get_lang('icon_warning1')?></p>
                                <p class="content"><?=get_lang('icon_warning2')?></p>
                            </div>
                        </div>
                        <!-- 文件展示区 -->
                        <div class="file-list file_thumb clearfix" id="doc_list">
                            <!-- <div class="file-item file-checked">
                                <div class="item">
                                    <lable class="checkbox checked"></lable>
                                    <div class="file-img">
                                        <i></i>
                                    </div>
                                    <div class="file-title-box">
                                        <span class="file-tilte">我的文档</span>
                                        <span class="file-edtor">
                                            <input type="text" value="我的文档" class="edtor">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item">
                                <div class="item">
                                    <lable class="checkbox"></lable>
                                    <div class="file-img">
                                        <i></i>
                                    </div>
                                    <div class="file-title-box">
                                        <span class="file-tilte">我的视频</span>
                                        <span class="file-edtor">
                                            <input type="text" value="我的视频">
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/x-jquery-tmpl" id="tmpl_list">
	<div class="file-item">
	 <div class="doc_item" id="${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}" data-file-id="${col_id}" data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-path="${pathdata}" data-myid="${myid}" data-creatorid="${creatorid}">
		  <lable class="checkbox"></lable>
		  <div class="doc_icon">
			  <img src="/cloud/assets/img/ico/${filetype}.png"/>
		  </div>
		  <div class="file-title-box">
			  <span class="doc_name" title="${col_name}">${col_name}</span>
		  </div>
		  <div class="dtime">
			  <span class="file-dtime"><span>${col_dt_create}</span><span class="doc_size">${filesize_text}</span></span>
			  <span class="file-edtors"><a href="javascript:void(0);" class="ico ico-edit btn_doc_online_edit btn_file" title="<?=get_lang('icon_doc_edit')?>" onclick="doc_onlinefile('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-down btn_doc_download" title="<?=get_lang('icon_download')?>" onclick="doc_download('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-view btn_doc_view" title="<?=get_lang('icon_attr')?>" onclick="doc_attr('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-share btn_doc_shareto" title="<?=get_lang('icon_share')?>" onclick="doc_shareto('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-move btn_cmd btn_doc_move" title="<?=get_lang('icon_move')?>" onclick="doc_move('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-rename btn_cmd btn_doc_edit" title="<?=get_lang('icon_edit')?>" onclick="doc_rename('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-del btn_cmd btn_doc_delete" title="<?=get_lang('icon_delete')?>" onclick="doc_delete('${col_doctype}_${col_id}_${col_rootid}',this)"></a><a href="javascript:void(0);" class="ico ico-qrcode btn_doc_qrcode btn_file" onclick="doc_qrcode('${col_doctype}_${col_id}_${col_rootid}',this)"></a></span>
		  </div>
	 </div>
	 </div>
</script>
    <!-- 提示信息 -->
    <div class="full-tip-box">
        <span class="full-tip">
            <span class="inner">
                <i class="ico"></i>
                <span class="text" data-id="label"><?=get_lang('icon_warning')?></span>
            </span>
        </span>
    </div>
    
    <!---Upload List---------------------------->
    <div id="upload_container" style="display:none">
<!--        <div class="upload_top">
            <div class="upload_title"><span class="upload_count">67</span><font set-lan="html:A-file-transfer">个文件传输中</font></div>
            
            <div class="upload_winbtn">
                <span class="icon icon_win_plus btn_switch hand"></span>
                <span class="icon icon_win_close btn_close hand"></span>
            </div>
            
        </div>-->
        <div class="upload_content" style="display:block">
            <div id="upload_queue" class="upload_body">
            </div>
        </div>
    </div>
    
    <div id="upload_container1" style="display:none">
        <div class="upload_top" style="color:#999;">
            <div class="upload_title"><span class="icon icon_success"></span><span id="ok_upload_count" class="upload_count">0</span><font>个文件</font></div>
            <div class="upload_title"><span class="icon icon_fail"></span><span id="err_upload_count" class="upload_count">0</span><font>个文件</font></div>
            
            <div class="upload_winbtn">
                <!--<span class="icon icon_win_plus btn_switch hand"></span>-->
                <span class="icon icon_win_close btn_close hand"></span>
            </div>
            
        </div>
<!--       <div class="upload_content" style="display:block">
            <div id="upload_queue1" class="upload_body">
            </div>
        </div>-->
    </div>
    
    <div id="contextmenu_doc" class="contextmenu dropdown-menu" style="left:100px;top:300px;">
        <ul>
            <li id="item_doc_edit" class="btn_doc_online_edit btn_file"><a href="javascript:void(0);"><span class="icon icon_online_edit"></span><?=get_lang('icon_doc_edit')?></a></li>
            <li id="item_download" class="btn_doc_download"><a href="javascript:void(0);"><span class="icon icon_download"></span><?=get_lang('icon_download')?></a></li>
            <li id="item_attr" class="btn_doc_view"><a href="javascript:void(0);"><span class="icon icon_attr"></span><?=get_lang('icon_attr')?></a></li>
<!--            <li class="divider"></li>-->
            <li id="item_move" class="btn_cmd btn_doc_move"><a href="javascript:void(0);"><span class="icon icon_move"></span><?=get_lang('icon_move')?></a></li>
            <li id="item_edit" class="btn_cmd btn_doc_edit"><a href="javascript:void(0);"><span class="icon icon_edit"></span><?=get_lang('icon_edit')?></a></li>
            <li id="item_delete" class="btn_cmd btn_doc_delete"><a href="javascript:void(0);"><span class="icon icon_delete"></span><?=get_lang('icon_delete')?></a></li>
<!--            <li class="divider"></li>-->
            <li id="item_share" class="btn_cmd btn_doc_shareto"><a href="javascript:void(0);"><span class="icon icon_share"></span><?=get_lang('icon_share')?></a></li>
            <li id="item_set" class="btn_cmd btn_doc_set"><a href="javascript:void(0);"><span class="icon icon_list"></span><?=get_lang('icon_set')?></a></li>
<!--            <li class="divider btn_file"></li>-->
            <li id="item_qrcode" class="btn_doc_qrcode btn_file"><a href="javascript:void(0);"><span class="icon icon_qrcode"></span><?=get_lang('icon_qrcode')?></a></li>
        </ul>
    </div>
    <!---End Upload List------------------------>
<!--	<div id="mask"></div>-->
<!--	<div id="menu" class="selectmenu">
		<li id="editBtn" set-lan="html:edit">编辑</li>
		<li id="downloadBtn" set-lan="html:download">下载</li>
    	<li id="delectBtn" set-lan="html:delect">删除</li>
    	<li id="moveBtn" set-lan="html:move">移动到</li>
    	<li id="renameBtn" set-lan="html:rename">重命名</li>
    	<li id="shareBtn" set-lan="html:share">分享到</li>
        <li id="permissionBtn" set-lan="html:permission">设置权限</li>

    </div>-->
    <!-- 拖拽 -->
    <div class="drag-helper ui-draggable-dragging" >
        <div class="icons">
            <i class="icon icon0 filetype icon-folder"></i>
            <i class="icon icon0 filetype icon-folder"></i>
            <i class="icon icon1 filetype icon-folder"></i>
            <i class="icon icon2 filetype icon-folder"></i>
            <i class="icon icon3 filetype icon-folder"></i>
        </div>
        <span class="sum">1</span>
    </div>
<input type="text" id="texturl" style="width:10px;display:none"/>
<iframe id="frm_hidden"  name="frm_hidden" style="display:none;"></iframe>
  <script src="/cloud/assets/js/data.js"></script>
  <script src="/cloud/assets/js/handledata.js"></script>
  <script src="/cloud/assets/js/tools.js"></script>
  <script src="/cloud/assets/js/doc1.js?ver=20250525"></script>
  <script src="/cloud/assets/js/htmlTemplate.js"></script>
  <script src="/cloud/assets/js/index.js"></script>
  <script type="text/javascript" src="/cloud/assets/js/doc_list1.js?ver=20250620"></script>
</body>

</html>
<script type="text/javascript">
var _isadmin = "<?=$admin?>" == "1" ; 
var _curr_loginname = "<?=CurUser::getLoginName()?>" ;
var _curr_userid = "<?=CurUser::getUserId()?>" ;
var _curr_myfcname = "<?=CurUser::getUserName();?>";
var _dbtype = "<?=DB_TYPE?>" ;
$(document).ready(function(){
	formatContainer();
	
	//锚点
  	hash_init();
	//searchbox
	$("#search_key")
//		.focus(function(){
//			$(this).parent().addClass("search_box_foucs");
//		})
//		.blur(function(){
//			$(this).parent().removeClass("search_box_foucs");
//		})
		.keyup(function(){
			doc_search();
		})

	$(".btn_close").click(function(){
		$("#upload_container1").hide();
	})

	$("#inputfile").on('change', function (e) {
	  var
		i = 0,
		files = e.target.files,
		len = files.length,
		notSupport = false;

		for (; i <= len; i++) {
			createContext(files[i]);
		}
	})
})

var UPLOAD_SIZE_LIMIT = "<?=UPLOAD_SIZE_LIMIT == 0?"0":UPLOAD_SIZE_LIMIT . "MB"?>";
var pagesize = parseInt("<?=DOC_PAGE_SIZE?>");
var site_address = "<?=getRootPath() ?>";
var curr_loginname = "<?=CurUser::getLoginName()?>";
var curr_password = "<?=CurUser::getPassword()?>";
axios.defaults.baseURL = "<?=getRootPath() ?>";

//生成权限数据  ace_data [{"doc_type":105,"doc_id":1,"power":1},{"doc_type":102,"doc_id":1,"power":1}]
var aces = [] ;
var my_root_id = parseInt("<?=getValue("doc_myroot")?>") ;
var ace_data = [] ;
//for(var i=0;i<aces.length;i++)
//{
//	var ace_item = aces[i].split("_");
//	ace_data.push({"doc_type":ace_item[0],"doc_id":ace_item[1],"power":ace_item[2]});  
//}
//alert(JSON.stringify(ace_data));
 
var originalTitle = "<?=get_lang('originalTitle')?>";    
function changeTitle()
{
	document.title = originalTitle;
}

window.setTimeout(changeTitle,1000);

    /*拖拽的目标对象------ document 监听drop 并防止浏览器打开客户端的图片*/
//    document.ondragover = function (e) {
//        e.preventDefault();  //只有在ondragover中阻止默认行为才能触发 ondrop 而不是 ondragleave
//    };
//    document.ondrop = function (e) {
//        e.preventDefault();  //阻止 document.ondrop的默认行为  *** 在新窗口中打开拖进的图片
//    };
//    /*拖拽的源对象----- 客户端的一张图片 */
//    /*拖拽目标对象-----div#container  若图片释放在此元素上方，则需要在其中显示*/
//    container.ondragover = function (e) {
//        e.preventDefault();
//    };
//    container.ondrop = function (e) {
//        console.log(e.dataTransfer);
////        chrome 此处的显示有误
//        var list = e.dataTransfer.files;
//        for (var i = 0; i < list.length; i++) {
//            var f = list[i];
////            console.log(f);
//            reader(f);
////            读取指定文件的内容 作为“数据URL”
////            reader.readAsDataURL(f);
////            当客户端文件读取完成 触发onload事件
//        }
//    };
//    function reader(f) {
//        var reader = new FileReader();
//        reader.readAsDataURL(f);
//        reader.onload = function () {
////            console.log(reader.result);
//            var img = new Image();
//            img.src = reader.result;
//            container.appendChild(img);
// 
//        }
//    }
//function doc_move1(item_id)
//{
//	dialog("move",'gfg',"doc_move.html?root_id=1") ;
//}
</script>
