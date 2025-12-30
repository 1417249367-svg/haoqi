<?php
	require_once("include/fun.php");

    $loginName = g("loginName","admin");
    $userid = "" ;
    $rootPath1 = g("ipaddress",getRootPath1());

	$dp = new Model("Plug");
	$dp -> addParamWhere("Plug_Enabled",1);
	$dp -> addParamWhere("Plug_Name","Meeting");
    $row = $dp-> getDetail();
	if (count($row))
		$meetingurl =$row["plug_param"] ;

	ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link  rel="stylesheet" href="assets/css/livechat.css?ver=14052001"   />
	<link  rel="stylesheet" href="assets/css/kjctn.css"   />
    <link rel="stylesheet" type="text/css" href="/static/js/lightbox/lightbox.css" media="screen">
	<script type="text/javascript" src="/static/js/lightbox/lightbox.js?ver=20231124"></script>
    <script type="text/javascript" src="assets/js/md5.js"></script>
	<script type="text/javascript" src="assets/js/socket.js?ver=150927"></script>
	<script type="text/javascript" src="assets/js/livechat_d.js?ver=20240922"></script>
	<script type="text/javascript" src="assets/js/chat.js?ver=150927"></script>
	<script type="text/javascript" src="<?=$rootPath1 ?>/static/js/msg_reader.js?ver=150927"></script>
    <script src="<?=$rootPath1 ?>/js/fingerprint.js"></script>
    <script src="<?=$rootPath1 ?>/js/html5ImgCompress.min.js"></script>
    <script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/common.js' charset='utf-8'></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/client/client.js' charset='utf-8'></script>
	<style>
		.main{width:100%;}
	</style>
</head>
<body style="overflow:hidden;" onclick="bodyMove(event);">



<div id="win">
	<div class="content">
		<div class="main">
			<div class="chat-record fluent">
                <div id="history" class="msg msg-3 clearfix">
                     <p class="msg-content"><img src="<?=$rootPath1 ?>/images/server/sjpic.png" onerror="warning();" /><a href="###"><?=get_lang('see_more_news')?></a></p>
                </div>
				<div class="chat-content">

				</div>
			</div><!----end record-->

			<div class="chat-toolbar" style="display:none;">
				<ul class="toolbar clearfix">
					<li><a href="###" target="_blank" onclick="StartLiveChatMeetChat(0,0)" title="<?=get_lang('chart_audio')?>"><span class="icon20" style="background:url(assets/img/qav_audio_icon_normal.png)"></span></a>
					</li>
					<li><a href="###" target="_blank" onclick="StartLiveChatMeetChat(1,0)" title="<?=get_lang('chart_video')?>"><span class="icon20" style="background:url(assets/img/qav_video_icon_normal.png)"></span></a>
					</li>
					<li>
						<div class="btn-downdrop">
							<a class="btn-toggle" href="###" title="<?=get_lang('chart_emotion')?>"><span class="icon-emote icon20"></span></a>
							<div class="popu popu-emote clearfix" style="width:550px;left:0px;top:-260px;">
							</div>
						</div>
					</li>
					<li>
						<div class="btn-downdrop">
							<a class="btn-toggle" href="###" title="<?=get_lang('chart_sendfile')?>"><span class="icon-file icon20"><input type="file"  name="file" multiple class="inputfile1 form-control" /></span></a>
<!--							<div class="popu popu-file popu-stop" style="width:280px;left:-30px;top:-50px;">
								<form enctype="multipart/form-data" name="form_upload" method="post" target="frm_Upload" style="margin:0px;padding:0px;">
									<input type="file"  name="file" class="inputfile form-control"  style="width:220px;"/>
									<input type="submit" class="btn" value=""  onclick="return(sendFile())" style="padding:6px" />
									<div class="clear"></div>
								</form>
							</div>-->
						</div>
					</li>
                    <li>
                        <a id="btnCapture" href="javascript:;" title="<?=get_lang('chart_shot')?>"><span class="icon-screenshot icon20"></span></a>
                    </li>
                    <li>
                        <div class="btn-downdrop">
                            <a class="btn-toggle" title="<?=get_lang('chart_shot_set')?>"><span class="caret"></span></a> 
                            <div class="popu popu-capture popu-stop" style="width:280px;left:-90px;top:-40px;">            
                                <input type="checkbox" id="autoMin" value="1" /><label for="autoMin"><?=get_lang('chart_shot_autoMin')?></label>
                                <input type="checkbox" id="captureScreen" value="1" /><label for="captureScreen"><?=get_lang('chart_shot_captureScreen')?></label>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>
					<li>
						<div class="btn-downdrop">
							<a class="btn-toggle" href="###" title="<?=get_lang('chart_rate')?>"><span class="icon-rate icon20"></span></a>
							<div class="popu popu-rate popu-stop"  style="width:280px;left:-120px;top:-240px;padding:5px;">
								<div><?=get_lang('chart_rate_note')?></div>
								<div>
									<label><input type="radio" name="rate" checked value="5" /><?=get_lang('chart_rate_unit5')?></label>
									<label><input type="radio" name="rate"  value="4" /><?=get_lang('chart_rate_unit4')?></label>
									<label><input type="radio" name="rate"  value="3" /><?=get_lang('chart_rate_unit3')?></label>
									<label><input type="radio" name="rate"  value="2" /><?=get_lang('chart_rate_unit2')?></label>
									<label><input type="radio" name="rate"  value="1" /><?=get_lang('chart_rate_unit1')?></label>
								</div>
								<div>
									<textarea class="form-control" id="ratenote" name="ratenote" style="height:100px;width:100%;"></textarea>
								</div>
								<div style="text-align:right;padding:5px 0px;">
									<input type="button" class="btn btn-primary btn-sm" value="<?=get_lang('chart_rate')?>" onclick="sendRate()"  style="padding:3px 10px"/>
								</div>
							</div>
						</div>
					</li>
					<li><a href="###"  onclick="clearRecord()" title="<?=get_lang('chart_clear')?>"><span class="icon-clear icon20"></span></a></li>
					<li><a id="transfer" href="###" onclick="transfer()" title=""><span class="icon20" style="background:url(assets/img/kefu.png)"></span></a>
					</li>
				</ul>
			</div><!----end toolbar-->

			<div class="chat-write"  style="display:none;">
				<table style="width:100%; border-width:0px;padding:0px;" cellpadding="0" cellspacing="0">
					<tr>
						<td><div class="messagebox-content"><div id="messagebox" class="messagebox"  contentEditable="true" ></div></div></td>
						<td style="width:40px"><button  class="btn" onclick="sendMsg()"><?=get_lang('btn_send')?></button></td>
					</tr>
				</table>
			</div><!----end write-->
		</div>
	</div>
</div>

<iframe id="frm_Upload"  name="frm_Upload" style="display:none;"></iframe>
<script type="text/javascript" src="/static/screenhot/UdCapture.js"></script>
<script type="text/javascript" src="/static/screenhot/screenshot.js"></script>
<div id="trace" style="position:absolute ; z-index:10000"></div>
</body>
</html>
<script type="text/javascript">

//====================================================================================
// LIVECHT 配置文件
// JC 2014-06-20
//====================================================================================

var invite ={switchType:<?=SWITCHTYPE?>,welcomeText:"<?=WELCOMETEXT?>",waitTime:<?=WAITTIME?>,rejectType:<?=REJECTTYPE?>,intervalTime:<?=INTERVALTIME?>};
var _loginname = "<?=$loginName ?>" ;
var ipaddress = "<?=$rootPath1 ?>" ;
var SitePath = "<?=getRootPath() ?>";
var RTC_SERVER_AGENT = "<?=RTC_SERVER_AGENT ?>";
//cookieHCID1 =  ipaddress + "-Talk" ;
cookieHCID2 =  ipaddress + "-loginname" ;
cookieHCID3 =  ipaddress + "-layer" ;
cookieHCID4 =  ipaddress + "-layer1" ;
var switchad = parseInt("<?=SWITCHAD?>") ;
meetingurl.voiceVideoType = parseInt("<?=VOICEVIDEOTYPE ?>") ;
meetingurl.url="<?=$meetingurl ?>" ;
var beatTime = parseInt("<?=BEATTIME ?>") ;
if(!beatTime) beatTime=1;
var showhistorytype = parseInt("<?=SHOWHISTORYTYPE ?>") ;
var ChatGPTType = parseInt("<?=CHATGPTTYPE ?>") ;
var ChatGPTAppid = "<?=CHATGPTAPPID ?>" ;
var ChatGPTTransferType = parseInt("<?=CHATGPTTRANSFERTYPE ?>") ;
var connectType = "<?=g("connecttype",1) ?>" ;
var goods_info = "<?=g("goods_info") ?>" ;
var welcome_db = "<?=g("welcome") ?>" ; 
var currWin ;
var lang_type = "<?=$LangType?>";
var typeid = "<?=g("typeid") ?>" ;
var isnotsend = "<?=g("isnotsend") ?>" ;
chater.loginname = "<?=g("loginname") ?>";
my.userid = "<?=g("userid") ?>" ;
chater.username = "";
chater_loginname = chater.loginname;
var username = "<?=g("username") ?>" ;
var phone = "<?=g("phone") ?>" ;
var email = "<?=g("email") ?>" ;
var qq = "<?=g("qq") ?>" ;
var wechat = "<?=g("wechat") ?>" ;
var remarks = "<?=g("remarks") ?>" ;
var othertitle = "<?=g("othertitle") ?>" ;
var otherurl = "<?=g("otherurl") ?>" ;
//if(getCookie(cookieHCID2)!=""&&getCookie(cookieHCID2)!="undefined"&&chater.loginname == "") setCookie(cookieHCID1,"") ;
//setCookie(cookieHCID2,chater_loginname) ;
if (welcome_db != "")
	welcome = welcome_db;
if(lang_type == 'en'){
    msgTip = "Open the chat" ;
}
$(document).ready(function()
{   
	if(!my.userid){
		var fp1 = new Fingerprint();
		my.userid = fp1.get()+"<?=g("my_userid") ?>";
	}
	initPage();
	if(typeid) ConnectChat1(typeid);
	else connectChat();
})
</script>


