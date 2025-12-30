<?php
	require_once( dirname(__FILE__) . '/fun1.php');
    require_once( dirname(__FILE__) . '/config.php' );
    require_once( dirname(__FILE__) . '/common.php' );
    require_once( dirname(__FILE__) . '/functions.php' );

    $filename;
	
	$userId = CurUser::getUserId() ;
	$onlineid = g("OnlineID");
	
	//$doceditorhelp=getValue("doceditorhelp");
	$html='';
	if(!getValue("doceditorhelp")){
	setValue("doceditorhelp",1,-1);
	$html='<div id="myModal" class="myModal">';
	$html=$html.'<span class="close">&times;</span>';
	$html=$html.'<img class="myModal-content" id="img01">';
	$html=$html.'<div id="caption"></div>';
	$html=$html.'</div>';
	}
	
	$db = new DB();
	if (isset($_REQUEST['filpath'])){
		 //$filpath = str_replace("\\\\","\\",js_unescape(g("filpath")));
		$row = $db -> executeDataRow("select top 1 * from OnlineFile where MyID='".$userId."' and FilPath='".str_replace("\\\\","\\",js_unescape(g("filpath")))."' order by OnlineID desc");
		if (count($row)) $onlineid = $row["onlineid"];
		 
	}

	$data =$db -> executeDataRow("select * from OnlineFile where OnlineID = ".$onlineid);
	if (count($data)) {
		$myid = $data["myid"];
		$usname = $data["usname"];
		$filename = $data["typepath"];
		$todate = date("Y-m-d",strtotime($data["todate"]))." ".date("G:i:s",$data["totime"]);
		$filpath = $data["filpath"];
		
		if ($myid==$userId) $ac = "edit";
		else{
			switch ((int)$data["authority1"]) {
				case 0 :
				switch ((int)$data["authority2"]) {
					case 0 :
					$row = $db -> executeDataRow("select * from OnlineForm where OnlineID = ".$onlineid." and UserID = '".$userId."'");
					if (count($row)) $ac = "edit";
					else $ac = "view";
					break;
					case 1 :
					if ($userId == 0) $ac = "view";
					else $ac = "edit";
					break;
				}
				break;
				case 1 :
				$row = $db -> executeDataRow("select * from OnlineForm where OnlineID = ".$onlineid." and UserID = '".$userId."'");
				if (count($row)){
					if ((int)$row["authority"]) $ac = "edit";
					else $ac = "view";	
				}
				else $ac = "no";
				break;
				case 2 :
				$ac = "no";
				break;
			}
		}
		if($userId != 0&&$ac != "no"){
			$sql = "delete from OnlineHeat where MyID='". $userId ."' and OnlineID=".$onlineid ;
			$db->execute($sql);
			$sql = "insert into OnlineHeat(MyID,OnlineID) values('". $userId ."',". $onlineid .")";
			$db->execute($sql);
		}
		$row = $db -> executeDataRow("select top 1 * from OnlineRevisedFile where OnlineID = ".$onlineid." order by ID desc");
		if (count($row)){
			 $todate = date("Y-m-d",strtotime($row["todate"]))." ".date("G:i:s",$row["totime"]);
			 $filpath = $row["filpath"];
		}
		//$key = getDocEditorKey($filename,$filpath);
	}
	else{
	$ac = "not";
	}


//    $createExt = $_GET["fileExt"];
//
//    if (!empty($createExt))
//    {
//        $filename = tryGetDefaultByType($createExt);
//
//        $new_url = "doceditor.php?fileID=" . $filename . "&user=" . $_GET["user"];
//        header('Location: ' . $new_url, true);
//        exit;
//    }
	
//    $fileuri = $GLOBALS['EXAMPLE_URL']."/Data/".str_replace("\\","/",$filpath);
//    $fileuriUser = FileUri($filename,false);

	
    function tryGetDefaultByType($createExt) {
        $demoName = ($_GET["sample"] ? "demo." : "new.") . $createExt;
        $demoFilename = GetCorrectName($demoName);

        if(!@copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . "app_data" . DIRECTORY_SEPARATOR . $demoName, getStoragePath($demoFilename)))
        {
            //sendlog("Copy file error to ". getStoragePath($demoFilename), "logs/common.log");
            //Copy error!!!
        }

        return $demoFilename;
    }

    function getCallbackUrl($fileName,$onlineid) {
        return serverPath(TRUE) . '/cloud/include/'
                    . "webeditor-ajax.php"
                    . "?type=track"
                    . "&fileName=" . urlencode($fileName)
					. "&doc_id=" . $onlineid
					. "&loginname=" . CurUser::getLoginName()
					. "&password=" . CurUser::getPassword();
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<title><?=get_lang('doceditor_title')?></title>
<?php require_once( dirname(__FILE__) . '/meta.php');?>
<link type="text/css" rel="stylesheet" href="/cloud/assets/css/editor.css" />
<link type="text/css" rel="stylesheet" href="/cloud/assets/css/empty.css" />
<script type="text/javascript" src="<?php echo $GLOBALS["DOC_SERV_API_URL"] ?>"></script>
</head>
<body>
<?php
//echo $_COOKIE["BA-doceditorhelp"];
//setcookie("BA-doceditorhelp", "help",time()+3600*24);
//echo getStoragePath($filpath);
//exit();
//echo '<div id="docEditor">';
echo '<div class="topbar '.getDocumentType($filename).'">';
echo '<div class="left">';
echo '<span class="logo item"></span>';
echo '<span class="title item">'.$filename.(($ac=="view") ? get_lang('doceditor_read') : '').'</span>';
echo '<span class="time item">'.$todate.'</span>';
echo '</div>';
echo '<div class="right">';
echo '<ul class="nav navbar-nav pull-right" id="nav_account">';
echo '<li><a href="javascript:doc_share('.$onlineid.');">'.get_lang('doceditor_doc_share').'</a></li>';
if ($userId == 0){
echo '<li><a>'.get_lang('doceditor_warning').'</a></li>';
echo '<li class="dropdown" id="login_btn">';
echo '<a href="javascript:void(0);" class="dropdown-toggle"><img src="../assets/img/avatar.png" class="photo"> '.get_lang('doceditor_login_btn').'</a>';
echo '</li>';
}else{
if($myid==$userId) echo '<li><a href="javascript:void(0);" onclick="doc_set(\''.DOC_FILE.'_'.$onlineid.'_0\',this);">'.get_lang('doceditor_doc_set').'</a></li>';
echo '<li><a href="javascript:doc_col(\''.DOC_FILE.'_'.$onlineid.'_0\',this);">'.get_lang('doceditor_doc_col').'</a></li>';
//if($ac=="edit") echo '<li><a href="javascript:void(0);" onclick="doc_revised(1);">查看修订记录</a></li>';
echo '<li class="dropdown">';
echo '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="../assets/img/face.png" class="photo">'.CurUser::getUserName().' <b class="caret"></b></a>';
echo '<ul class="dropdown-menu">';
echo '<li id="logout_btn"><a href="javascript:void(0);">'.get_lang('doceditor_logout_btn').'</a></li>';
echo '</ul>';
echo '</li>';
}
echo '</ul>';
echo '</div>';
echo '</div>';
echo '<div class="content">';
echo '<div id="iframeEditor"></div>';
echo $html;
//if(!$doceditorhelp){
//echo '<div id="myModal" class="modal">';
//echo '<span class="close">&times;</span>';
//echo '<img class="modal-content" id="img01">';
//echo '<div id="caption"></div>';
//echo '</div>';
//}

echo '<div id="file_empty" class="g_empty sort_folder_empty">';
echo '<div class="empty_box">';
echo '<div class="ico"></div>';
echo '<p class="title"></p>';
echo '</div>';
echo '</div>';
echo '</div>';
//setValue("doceditorhelp","help",-1);
//setValue("doceditor_help",1,-1);
//echo '</div>';

//echo '<div id="revisedFile" class="body-frame container" style="display:none">';
//echo '<div id="sidebar">';
//echo '<ul>';
//echo '<li class="navigate">修订记录</li>';
//echo '<li>';
//echo '<ul class="submenu" style="display:block !important;">';
$sql = "Select * from OnlineRevisedFile where OnlineID=" . $onlineid . " order by ID asc";
$reviseddata = $db -> executeDataTable($sql) ;
//$recordcount = count($reviseddata)+1;
$i = 1;
$history='';
$historydata='';
foreach($reviseddata as $row){
//	$default_dir = RTC_CONSOLE . "/" . $row["filpath"] ;
//	$default_dir = str_replace("/","\\",$default_dir) ;	
    $callback = json_decode($row["callbackjson"], TRUE);
//	echo '<li id="100_'.$i.'_0" data-sid="'.$i.'" data-id="'.$onlineid.'" data-name="'.$filename.'(第'.$i.'版)" data-target="'.$row["filpath"].'" data-changesUrl="'.$callback["changesurl"].'" data-key="'.$callback["key"].'" data-url="'.$callback["url"].'" onclick="сonnectEditor1('.$i.');"><span class="dtime">'.date("Y-m-d",strtotime($row["todate"]))." ".date("G:i",$row["totime"]).'(第'.$i.'版)</span><br><span class="description">'.$row["description"].'</span></li>';
	//$changes = $callback["history"]["changes"][0];
	$history .= '{"changes":'.json_encode($callback["history"]["changes"]).',"created":"'.$callback["history"]["changes"][0]["created"].'","key":"'.$callback["key"].'","serverVersion":"'.$callback["history"]["serverVersion"].'","user":'.json_encode($callback["history"]["changes"][0]["user"]).',"version":'.$i.'},';
	$historydata .= '{"key":"'.$callback["key"].'","url":"'.$callback["url"].'","version":'.$i.'},';
	$i += 1;
}
    $history = substr($history, 0, -1);
	$historydata = substr($historydata, 0, -1);
//	echo '<li id="100_'.$i.'_0" data-sid="'.$i.'" data-id="'.$onlineid.'" data-name="'.$filename.'(第'.$i.'版)" data-target="'.$data["filpath"].'" data-key="'.getDocEditorKey($myid,$filename,$data["filpath"]).'" onclick="сonnectEditor1('.$i.');"><span class="dtime">'.date("Y-m-d",strtotime($data["todate"]))." ".date("G:i",$data["totime"]).'(第'.$i.'版)</span><br><span class="description">'.$usname.'创建了文档</span></li>';
//echo '</ul>';
//echo '</li>';
//echo '</ul>';
//echo '</div>';
//echo '<div id="main">';
//echo '<div id="toolbar" style="position:absolute;width:100%;z-index:100;" class="clearfix">';
//echo '<div class="toolbar_btn">';
//echo '<a href="javascript:void(0);" class="btn btn-default btn_cmd" onclick="doc_revised(2);">返回</a>';
//echo '</div>';
//echo '<div class="toolbar_title">';
//echo '<span id="toolbartitle"></span><a href="javascript:doc_restore();" class="btn btn-primary">恢复</a>';
//echo '</div>';
//echo '<div class="clear"></div>';
//echo '</div>';
//echo '<div class="fluent doc_thumb" style="top:10px !important;left:0px !important;right:0px !important;bottom:0px !important;z-index:80;" id="doc_list">';
//echo '<div id="iframeEditor1"></div>';
//echo '<div id="file_empty1" class="g_empty sort_folder_empty">';
//echo '<div class="empty_box">';
//echo '<div class="ico"></div>';
//echo '<p class="title"></p>';
//echo '</div>';
//echo '</div>';
//echo '</div>';
//echo '</div>';
//echo '</div>';

$printer = new Printer();
$j = 0;
$EditorId = 0;
$response = '{id:"'.$j.'","name":"'.CurUser::getUserName().'"},' ;
$sql = "Select bb.UserID,aa.FcName from Users_ID as aa , OnlineForm as bb where aa.UserID=bb.UserID and bb.OnlineID=" . $onlineid . " and aa.UserState=1 order by bb.ID asc";
$data = $db -> executeDataTable($sql);
foreach($data as $row){
$j += 1;
$response .= '{id:"'.$j.'","name":"'.$row["fcname"].'"},';
if($userId==$row["userid"]) $EditorId=$j;
}
$response = substr($response, 0, -1);
?>
<input type="text" id="texturl" style="width:10px;display:none"/>
</body>
</html>
<script>
// 获取弹窗
var modal = document.getElementById('myModal');
 
// 获取图片插入到弹窗 - 使用 "alt" 属性作为文本部分的内容
//var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

modal.style.display = "block";
modalImg.src = "/cloud/assets/img/help.png";
captionText.innerHTML = "下载文件、版本历史等功能";
// 获取 <span> 元素，设置关闭按钮
var span = document.getElementsByClassName("close")[0];
// 当点击 (x), 关闭弹窗
span.onclick = function() { 
  modal.style.display = "none";
}
// 当点击 (x), 关闭弹窗
modal.onclick = function() { 
  modal.style.display = "none";
}
</script>
<script type="text/javascript">
	var docEditor;
	var revisedFile;
	var pageindex = 0 ;
	var curr_userid = "<?=$userId?>";
	var site_address = "<?=getRootPath() ?>";
	var fileName = "<?php echo $filename ?>";
	var fileType = "<?php echo strtolower(pathinfo($filename, PATHINFO_EXTENSION)) ?>";
	var user = [<?php echo $response ?>]["<?php echo $EditorId ?>"||0];


	var innerAlert = function (message) {
		if (console && console.log)
			console.log(message);
	};
	
	var initPage = function(){
		if(window.parent == window){//新页面；非iframe中
		    $(".fluent").attr("abs_height",10).attr("abs_width",160) ;
			resize();
			window.onresize = function(e){
				resize();
			}
			var url = site_address + "/cloud/include/doceditor.php?OnlineID="+<?php echo $onlineid ?> ;
			$("#login_btn").click(function(){
				location.href = "../account/login.html?op=relogin&gourl="+escape(url) ;
			})
			
			$("#logout_btn").click(function(){
				logout1(escape(url));
			})
		}
	}
	$(document).ready(function(){
		initPage();
	});
	
	var onReady = function () {
//		    $('.logo').bind('click',function(){
//    		    var $panel = window.frameEditor.$("#file-menu-panel");
//    		    if($panel.is(":hidden")){
//    		        $panel.show();
//    		    }else{
//    		        $panel.hide();
//    		    }
//		    });
		innerAlert("Document editor ready");
	};

	var onDocumentStateChange = function (event) {
		var title = document.title.replace(/\*$/g, "");
		document.title = title + (event.data ? "*" : "");
	};

	var onRequestEditRights = function () {
		location.href = location.href.replace(RegExp("action=view\&?", "i"), "");
	};

	var onError = function (event) {
		if (event)
			innerAlert(event.data);
	};

	var onOutdatedVersion = function (event) {
		location.reload(true);
	};
	
	var onRequestHistory = function() {
		docEditor.refreshHistory({
			"currentVersion": <?php echo count($reviseddata) ?>,
			"history": [<?php echo $history ?>],
		});
	};
	
	var onRequestHistoryData = function(event) {
		var historydatas = [<?php echo $historydata ?>];
		var historydata;
		var version = event.data;
		if (historydatas.length>0){
			for (var i = 0; i < historydatas.length; i++) {
				if(historydatas[i].version == version) historydata=historydatas.slice(i,i+1);
			}
		}
		docEditor.setHistoryData(historydata);
	};

	var onRequestHistoryClose = function() {
		location.reload(true);
	};

	var сonnectEditor = function () {

		<?php
		//echo getStoragePath($filpath);
			if ((!file_exists(getStoragePath($filpath)))||$ac == "not") {
				echo '$("#iframeEditor").hide();';
				echo '$("#file_empty").show();';
				echo '$("#file_empty .title").html("'.get_lang('doceditor_file_empty').'");';
				echo 'return;';
			}
			if ($ac == "no") {
				echo '$("#iframeEditor").hide();';
				echo '$("#file_empty").show();';
				echo '$("#file_empty .title").html("'.get_lang('doceditor_file_empty1').'");';
				echo 'return;';
			}
		?>
		var type = "<?php echo ($_GET["type"] == "mobile" ? "mobile" : ($_GET["type"] == "embedded" ? "embedded" : ($_GET["type"] == "desktop" ? "desktop" : ""))) ?>";
		if (type == "") {
		    type = new RegExp("<?php echo $GLOBALS['MOBILE_REGEX'] ?>", "i").test(window.navigator.userAgent) ? "mobile" : "desktop";
		}
		if(type=="mobile") $(".topbar").hide();
		docEditor = new DocsAPI.DocEditor("iframeEditor",
			{
				width: "100%",
				height: "100%",
				type: type,
				documentType: "<?php echo getDocumentType($filename) ?>",
				document: {
					title: fileName,
					url: "<?php echo serverPath(TRUE)."/public/cloud.html?op=getfile&label=onlinefile&myid=1&id=".$onlineid."&name=".str_replace("\\","/",$filpath) ?>",
					fileType: fileType,
					key: "<?php echo getDocEditorKey($myid,$filename,$filpath) ?>",
					info: {
						author: "<?php echo $usname ?>",
						created: "<?php echo date('Y-m-d') ?>",
					},
					permissions: {
						comment: false,
						download: false,
						print: false,
						edit: true,
						review: true
					}
				},
				editorConfig: {
					mode: '<?php echo $ac?>',
					lang: "zh",
					callbackUrl: "<?php echo getCallbackUrl($filename,$onlineid) ?>",
					user: user,
					customization: {
						//autosave: true,
						//forcesave: true,
						about: false,
						feedback: false,
						goback: {
							url: "http://www.haoqiniao.cn",
						},
						chat: false,
						comments: false,
					},
				},
				events: {
					'onReady': onReady,
					'onDocumentStateChange': onDocumentStateChange,
					'onRequestEditRights': onRequestEditRights,
					'onError': onError,
					'onOutdatedVersion': onOutdatedVersion,
				    <?php
					if($ac=="edit") {
						echo "'onRequestHistory': onRequestHistory,";
						echo "'onRequestHistoryData': onRequestHistoryData,";
						echo "'onRequestHistoryClose': onRequestHistoryClose";
					}
				    ?>
				}
			});
			
			
	};

	if (window.addEventListener) {
		window.addEventListener("load", сonnectEditor);
	} else if (window.attachEvent) {
		window.attachEvent("load", сonnectEditor);
	}

	function getXmlHttp() {
		var xmlhttp;
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (ex) {
				xmlhttp = false;
			}
		}
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}
	
//	function doc_revised(operation) {
//		 switch (operation) {
//		 case 1:
//		 $("#docEditor").hide();
//		 $("#revisedFile").show();
//		 сonnectEditor1($("#sidebar .submenu li").length);
//
//		 break;
//		 case 2:
//		 $("#docEditor").show();
//		 $("#revisedFile").hide();
//		 break;
//		 }
//	}
</script>