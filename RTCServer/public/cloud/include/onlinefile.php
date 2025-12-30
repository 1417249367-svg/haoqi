<?php 
require_once("../include/fun.php");

//$loginname = urldecode(g("loginname"));
////Page_Load();
//$db = new DB();
//$data =$db -> executeDataRow("select * from Users_ID where UserID='".CurUser::getUserId."'");
//if (count($data)){
//	 $userid = $data["userid"];
//	 $password = md5(trim($data["userpaws"]));
//	 $fcname = $data["fcname"];
//}else{
//	echo get_lang('onlinefile_warning');
//	exit();
//}

$loginname = CurUser::getLoginName();
$userid = CurUser::getUserId();
$password = CurUser::getPassword();
$fcname = CurUser::getUserName();

function Page_Load()
{            
$ch = curl_init();
$url = "http://".RTC_SERVER.":99/services/CheckToken.asp?UserName=".urlencode(urlencode(urldecode(g("loginname"))))."&Token=".urldecode(g("Token"));
//				echo $url;
//		exit();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
$output = curl_exec($ch); 
switch($output)
{
case "({msg:'-2'})":
echo get_lang('onlinefile_warning1');
exit();
break;
case "({msg:'-1'})":
echo get_lang('onlinefile_warning');
exit();
break;
case "({msg:'0'})":
echo get_lang('onlinefile_warning2');
exit();
break;
case "({msg:'1'})":

break;
default: 
echo get_lang('onlinefile_warning3');
exit();
}
curl_close ($ch); 
}
//将权限加载到SESSION中
$ace = new DocAce();
$ace -> load_all_ace() ;
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=get_lang('doceditor_title')?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <?php require_once("../include/meta.php");?>
</head>

<body class="body-frame">
     <?php require_once("../include/header2.php");?>
             <div id="sidebar">
				<ul>
					<li>
						<ul class="submenu" style="display:block !important;">
							<li><a href="javascript:void(0);" data-id="1" class="active"><span class="icon icon_recent"></span><?=get_lang('onlinefile_icon_recent')?></a></li>
							<li><a href="javascript:void(0);" data-id="2"><span class="icon icon_folder_person"></span><?=get_lang('onlinefile_icon_folder_person')?></a></li>
							<li><a href="javascript:void(0);" data-id="3"><span class="icon icon_folder_public"></span><?=get_lang('onlinefile_icon_folder_public')?></a></li>
					   </ul>
					</li>
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
							<input type="file" id="inputfile" name="inputfile" class="inputfile" onchange="file_upload_html1()" />
						</form>
						<a href="javascript:void(0);" class="btn btn-primary" id="btn_doc_upload"><span class="icon icon_upload"></span><?=get_lang('icon_upload2')?></a>

					</div>
					<!-----END HTML UPLOAD-------->
					<div class="toolbar_btn">
						<a href="javascript:doc_create(1);" class="btn btn-default btn_cmd"><?=get_lang('onlinefile_doc_create1')?></a>
						<a href="javascript:doc_create(2);" class="btn btn-default btn_cmd"><?=get_lang('onlinefile_doc_create2')?></a>
                        <a href="javascript:void(0);" class="btn btn-default" id="btn_refresh" action-type="doc_refresh"><span class="icon icon_refresh"></span></a>
                                                    <!--<a href="rtc://sendmsg/?UserName=admin" target="_blank">点击这里发消息</a>-->
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
				
				<!--<div id="path">
					<div class="path_check"><input type="checkbox" name="chk_all" id="chk_all"></div>
					<ul class="path_node">
						<li class="active"><a href="javascript:void(0);" onclick="path_go(this)">目录</a></li>
					</ul>
					<div class="path_info"></div>
					<div class="clear"></div>
				</div>-->
				<div class="fluent doc_thumb" style="top:50px !important;" id="doc_list">

				</div>
			</div>
			<div class="clear"></div>
			

 
<script type="text/x-jquery-tmpl" id="tmpl_list">
	<div class="doc_item" id="${col_doctype}_${col_id}_${col_rootid}" data-rootid="${col_rootid}"  data-type="${col_doctype}" data-id="${col_id}"  data-filetype="${filetype}" data-name="${col_name}" data-target="${filpath}" data-filesize="${pcsize}" data-myid="${myid}">
		<!--<div class="doc_check"><input type="checkbox" name="chk_id" value="${col_doctype}_${col_id}_${col_rootid}"></div>-->
		<div class="doc_icon"><img class='icon_${filetype}' src='/static/img/pix.png'></div>
		<div class="doc_name" style="width:200px !important;text-overflow:ellipsis;" title="${col_name}"><a href="<?=getRootPath()?>/cloud/include/doceditor.php?OnlineID=${col_id}&loginname=<?=$loginname?>&password=<?=$password?>" target="_blank">${col_name}</a></div>
		<div class="doc_size">${usname}</div>
		<div class="doc_time" style="left:390px !important;">${col_dt_create}</div>
		<div class="doc_cmd" style="left:390px !important;">
			<a href="<?=getRootPath()?>/cloud/include/doceditor.php?OnlineID=${col_id}&loginname=<?=$loginname?>&password=<?=$password?>" target="_blank" class="icon_attr btn_doc_view"></a>
			<a href="javascript:void(0);" class="icon_download btn_doc_download" onclick="doc_download('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_share btn_doc_share" onclick="doc_share('${col_id}',this)"></a>
			<a href="javascript:void(0);" class="icon_az btn_cmd btn_doc_az"  onclick="doc_az('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_delete btn_cmd btn_doc_delete"  onclick="doc_delete1('${col_doctype}_${col_id}_${col_rootid}',this)"></a>
			<a href="javascript:void(0);" class="icon_edit btn_cmd btn_doc_edit"  onclick="doc_rename1('${col_doctype}_${col_id}_${col_rootid}',this)"></a>	
			<a href="javascript:void(0);" class="icon_list btn_doc_set" onclick="doc_set('${col_doctype}_${col_id}_${col_rootid}',this)" ></a>
			
		</div>
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
<input type="text" id="texturl" style="width:10px;display:none"/>
	<?php require_once("../include/footer.php");?>
	
	<script type="text/javascript" src="/static/js/jquery.contextmenu.js"></script>


</body>
</html>


<script type="text/javascript">

$(document).ready(function(){

    $(".fluent").attr("abs_height",50).attr("abs_width",160) ;
	resize();
	window.onresize = function(e){
		resize();
	}

	formatContainer();
	
	initSideBar1();
	//锚点
	if (show_type == 2)
		show_thumb();
	else
		show_list();
		
	curr_loginname = "<?=$loginname?>";
    curr_password = "<?=$password?>";
	curr_userid = "<?=$userid?>";
	curr_myfcname = "<?=$fcname?>";
	query="loginname=" + curr_loginname + "&password=" + curr_password;
	file_type=1;
	label="onlinefile";
	//列出内容
	doc_list_init();
	doc_list();
	//重新按钮
	init_cmd_btn1();
//	alert(location.hash);
//	$("#login_btn").click(function(){
//		var url = hash.url;
//		if (hash.param != "")
//			url += "?" + hash.param ;
//		url="http://" + site_address + "/cloud/include/share.html"+url;
//		//alert(url);
//		location.href = "../account/login.html?op=relogin&gourl="+escape(url) ;
//	})
//	
//	$("#logout_btn").click(function(){
//		logout();
//	})
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
var pagesize = 10;
var site_address = "<?=getRootPath() ?>";
var curr_loginname;
var curr_password;
var curr_myfcname;
var curr_userid;
//生成权限数据  ace_data [{"doc_type":105,"doc_id":1,"power":1},{"doc_type":102,"doc_id":1,"power":1}]
var aces = "<?=getValue("doc_aces")?>".split(",") ;
var my_root_id = parseInt("<?=getValue("doc_myroot")?>") ;
var ace_data = [] ;
for(var i=0;i<aces.length;i++)
{
	var ace_item = aces[i].split("_");
	ace_data.push({"doc_type":ace_item[0],"doc_id":ace_item[1],"power":ace_item[2]});  
}

 
var originalTitle = "<?=get_lang('doceditor_title')?>";    
function changeTitle()
{
	document.title = originalTitle;
}

window.setTimeout(changeTitle,1000); 
</script>


