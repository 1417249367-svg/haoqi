<?php  require_once("include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgReader.class.php");?>
<?php
		$from = g("from");
        $sortBy = g("sortby");
        $sortDir = g("sortdir", 0);
        $pageIndex = g("page", -1);
        $pageSize = g("pagesize", 20);
        $dt1 = g("dt1",date("Y-m-d",strtotime("last month")));
		$dt2 = g("dt2",date("Y-m-d"));
        $key = g("key");
        $chater = urldecode(g("chater"));
        $chaterName = "";
		$loginname = urldecode(g("loginname"));
		$password = g("password");
        //Page_Load();
        if ($chater == "")
        {
            print(get_lang("msg_list_select_user"));
            die();
        }

		$db = new DB();
        $MyUserID=$db -> executeDataValue("select UserID as c from Users_ID where UserName='".$loginname."'");
        $YouUserID=$db -> executeDataValue("select UserID as c from Users_ID where UserName='".$chater."'");

		$msg = new Msg();
		$sql_where = $msg -> getWhereSql($MyUserID,$YouUserID,$dt1,$dt2,$key);
		$sql_count = "select  count(*) as c  from  Messeng_Text " . $sql_where ;
		$sql_list = "select * from Messeng_Text " . $sql_where . " order by TypeID " ;
//				echo $sql_list;
//		exit();

		$recordCount = $msg -> db -> executeDataValue($sql_count);

		if ($recordCount > 0)
		{
			//消息查看，从最后一页开始
			$pageIndex1=get_page_count($recordCount,$pageSize);
			if($pageIndex>$pageIndex1||$pageIndex == -1) $pageIndex = $pageIndex1;

			//$data = $msg -> db -> page($sql_list,$pageIndex,$pageSize,$recordCount);
			$Messeng = new Model ( "Messeng_Text" );
			$Messeng->order ( "TypeID" );
			$Messeng->orderdesc ( "TypeID desc" );
			$Messeng->field ( "*" );
			$Messeng->where ( $sql_where );
			$data = $Messeng-> getMsgPage ( $pageIndex, $pageSize, $recordCount );
		}
		else
		{
			$pageIndex = 0 ;
			$data = array() ;
		}

        $style=count($data)>0?"display:none":"";
		
		//测试读消息
		function getContent($usertext,$totype)
		{
			$reader = new MsgReader();
			return $reader -> PastImgEx($usertext,$totype,$YouUserID);
			//echo $reader -> html;
			//return $reader -> html ;
		}

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
		case "({msg:'-1'})":
		echo get_lang("msg_list_warning");
		exit();
		break;
		case "({msg:'0'})":
		echo get_lang("msg_list_warning2");
		exit();
		break;
		case "({msg:'1'})":

		break;
		case "({msg:'-2'})":
		echo get_lang("msg_list_warning1");
		exit();
		break;
		case "({msg:'-3'})":
		echo get_lang("msg_list_warning3");
		exit();
		break;
		}
		curl_close ($ch); 
		}
		//echo var_dump($data);

?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>    
    <link rel="stylesheet" href="assets/css/ui-base.css">
    <link rel="stylesheet" href="assets/css/ui-box.css">
    <link rel="stylesheet" href="assets/css/ui-btn.css">
    <link rel="stylesheet" href="assets/css/boilerplate.css">
    <link rel="stylesheet" href="assets/css/tbmu.css">
    <link rel="stylesheet" href="assets/css/kl.css">
    <link rel="stylesheet" href="assets/css/kjctn.css">
    <link rel="stylesheet" href="assets/css/kjbd.css">
    <link rel="stylesheet" href="assets/css/kf.css">
    <link rel="stylesheet" href="assets/css/kz.css">
    <link rel="stylesheet" href="assets/css/kc.css">
    <link rel="stylesheet" href="assets/css/kq.css">
    <link rel="stylesheet" href="assets/css/zs2tb.css">
    <link rel="stylesheet" href="assets/css/msg.css" />
    
</head>
<body>

<div>
    <div class="topbar">
        <div class="searchbar">

                <label class="pull-left mr" <?=$from == "webim"?"style='display:none;'":""?>><?=get_lang("label_date")?>：</label>
				<input type="text" class="form-control datepicker pull-left" data-date-format="yyyy-mm-dd" id="dt1" value="<?=$dt1?>" style="width:120px;">
				<label class="pull-left mr">&nbsp;<?=get_lang("label_to")?></label>
				<input type="text" class="form-control datepicker pull-left mr" data-date-format="yyyy-mm-dd" id="dt2" value="<?=$dt2 ?>" style="width:120px;">
				<label class="pull-left mr"><?=get_lang("label_title")?>：</label>
            	<input type="text" id="key" value="<?=js_unescape($key) ?>" class="form-control pull-left mr" style="width:120px;" />
            	<input type="button" id="btn_search" value="<?=get_lang("btn_search")?>" class="btn pull-left" onclick="search()" placeholder="<?=get_lang("label_search_title")?>"  />
				<div class="clear"></div>
        </div>
    </div>

    <div class="content fluent">
				  <div class="alert alert-warning" id="nodata" style="<?=$style ?>"><?=get_lang("label_nodata")?></div>
                  <div id="list" class="msg-list" style="<?=count($data)==0?"display:none":""?>">
						<?php
						    $reader = new MsgReader();
							foreach($data as $row)
							{
							$totype=$row["myid"] == $MyUserID?1:2;
							$result = $reader -> PastImgEx($row["usertext"],$totype,$YouUserID);
							//$result = getContent($row["usertext"],$totype);
						?>
                        <div class="msg-item <?=$totype == 1?"msg-send":"msg-recv" ?>" msg-id="<?=$row["typeid"] ?>">
                            <div class="msg-info">
                                <?=$row["fcname"] ?>  <?=$row["to_date"].' '.$row["to_time"] ?>
                                
                            </div>
		                    <div class="msg-content" data-totype="<?=$totype?>" data-type="<?=$result["data_type"] ?>" data-target="<?=$result["data_target"] ?>">
							     <p class="kl_text6"><?=$result["data"] ?></p>
                            </div>
                        </div>
						<?php
							}
						?>
                 </div>



    </div>

    <div class="bottombar pagebar" style="height:30px;">
    </div>

</div>
<div id="menu" class="selectmenu">
    <li id="openBtn"><?=get_lang("openBtn")?></li>
    <li id="openfolderBtn"><?=get_lang("openfolderBtn")?></li>
    <li id="downloadBtn"><?=get_lang("downloadBtn")?></li>
    <li id="receiveBtn"><?=get_lang("receiveBtn")?></li>
    <li id="saveasBtn"><?=get_lang("saveasBtn")?></li>
    <li id="forwardingBtn"><?=get_lang("forwardingBtn")?></li>
    <li id="saveptpfileBtn"><?=get_lang("saveptpfileBtn")?></li>
    <li id="copyBtn"><?=get_lang("copyBtn")?></li>
    <li id="allselectedBtn"><?=get_lang("allselectedBtn")?></li>
    <li id="diskviewBtn"><?=get_lang("diskviewBtn")?></li>
    <li id="assistantBtn"><?=get_lang("assistantBtn")?></li>
</div>
<div id="mask" style="display:none;"></div>
<a href="#" id="cmd" style="display:none;">cmd</a>
</body>
<script type="text/javascript" src="assets/js/function.js"></script>
<script type="text/javascript" src="assets/js/tools.js"></script>
<script type="text/javascript" src="assets/js/msg_reader.js"></script>
<script type="text/javascript" src="assets/js/base64.js"></script>
</html>

<script language="javascript" >
	var query = "loginname=<?=$loginname ?>&chater=<?=$chater ?>&Token=<?=urldecode(g("Token")) ?>" ;
    $(document).ready(function(){

        var abs_height = getInt($(".topbar").height()) + getInt($(".bottombar").height()) ;
        $(".fluent").attr("abs_height",abs_height) ;
		resize();
		window.onresize = function(e){
			resize();
		}
		
        UStext="";
		//formatMsgContent($(".msg-list"));
		Display=1;
		initBtn();

		drawPager($(".pagebar"),"<?=$pageIndex?>","<?=$pageSize?>","<?=$recordCount?>","page");


        $(".msg-item").click(function(){
            $(this).addClass("active");
            $(".msg-item").not(this).removeClass("active");
        })

		//选中最后一条
		var msgs = $(".msg-item");
		if (msgs.length>0)
		{
			msgs[msgs.length-1].click();
			$('.content').scrollTop($(".msg-list").height());
		}


    })


    function search()
    {
    	if(!compare_date($("#dt1").val(),$("#dt2").val()))
		{
    		myAlert("<?=get_lang("text_date_range")?>");
			return;
		}
        var url = "msg_list.html?" + query + "&dt1=" + $("#dt1").val() + "&dt2=" +  $("#dt2").val() + "&key=" + escape($("#key").val()) ;
        location.href = url ;
        return false ;
    }
</script>