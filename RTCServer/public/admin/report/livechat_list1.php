<?php  require_once("../include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgReader.class.php");?>

<?php
		loginByAddin();
		$userId = CurUser::getUserId() ;
		$admin = CurUser::isAdmin();
	
		if ($userId == 0)
			header("Location:../account/login.html?op=relogin");
        $sortBy = g("sortby");
        $sortDir = g("sortdir", 0);
        $pageIndex = g("page", -1);
        $pageSize = g("pagesize", 20);
		$recordCount = 0 ;
        $dt1 = g("dt1");
		$dt2 = g("dt2");
        $user1 = g("user1");
		$user2 = g("user2");
		$key = g("key");
		

        if (($user1 != "") && ($user2 != ""))
        {
			$db = new Model("lv_chater");
			$db -> clearParam();
			$db -> addParamWhere("LoginName",$user1);
			$detail =  $db -> getDetail() ;
			$MyUserName=$detail ["username"];
			
			$db = new Model("lv_user");
			$db -> clearParam();
			$db -> addParamWhere("userid",$user2);
			$detail =  $db -> getDetail() ;
			if(empty($detail ["username"])) $YouUserName=$detail ["area"];
			else $YouUserName=$detail ["username"];
			if(empty($YouUserName)) $YouUserName=get_lang("livechat_message9");

	
			$msg = new Msg();
			if(CHATERMODE) $sql_where = $msg -> getWhereSql($user1,$user2,$dt1,$dt2,$key);
			else $sql_where = $msg -> getWhereSql("",$user2,$dt1,$dt2,$key);
			$sql_count = "select  count(*) as c  from  MessengKefu_Text " . $sql_where ;
			$sql_list = "select * from MessengKefu_Text " . $sql_where . " order by TypeID " ;
	//				echo $sql_list;
	//		exit();
	
			$recordCount = $msg -> db -> executeDataValue($sql_count);
	
			if ($recordCount > 0)
			{
				//消息查看，从最后一页开始
				$pageIndex1=get_page_count($recordCount,$pageSize);
				if($pageIndex>$pageIndex1||$pageIndex == -1) $pageIndex = $pageIndex1;
	
				//$data = $msg -> db -> page($sql_list,$pageIndex,$pageSize,$recordCount);
				$Messeng = new Model ( "MessengKefu_Text" );
				$Messeng->order ( "TypeID" );
				$Messeng->orderdesc ( "TypeID desc" );
				$Messeng->field ( "*" );
				$Messeng->where ( $sql_where );
				$data = $Messeng-> getMsgPage ( $pageIndex, $pageSize, $recordCount );
	//			echo var_dump($data);
	//			exit();
			}
			else
			{
				$pageIndex = 0 ;
				$data = array() ;
			}
        }
		else
		{
			$data = null ;
		}

        $style=count($data)>0?"display:none":"";

		//测试读消息
		function getContent($usertext,$totype)
		{
			$reader = new MsgReader();
			return $reader -> PastImgEx1($usertext,$totype,$YouUserID);
			//echo $reader -> html;
			//return $reader -> html ;
		}


?>

<?php
define("MENU","LIVECHATLIST") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <link rel="stylesheet" type="text/css" href="/static/js/lightbox/lightbox.css" media="screen">
	<script type="text/javascript" src="/static/js/lightbox/lightbox.js"></script>
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
    <script src="/static/js/BenzAMRRecorder.min.js"></script>
    <link rel="stylesheet" href="/addin/assets/css/msg.css" />
    <link rel="stylesheet" href="/addin/assets/css/ui-base.css">
    <link rel="stylesheet" href="/addin/assets/css/ui-box.css">
    <link rel="stylesheet" href="/addin/assets/css/ui-btn.css">
    <link rel="stylesheet" href="/addin/assets/css/boilerplate.css">
    <link rel="stylesheet" href="/addin/assets/css/tbmu.css">
    <link rel="stylesheet" href="/addin/assets/css/kl.css">
    <link rel="stylesheet" href="/addin/assets/css/kjctn.css">
    <link rel="stylesheet" href="/addin/assets/css/kjbd.css">
    <link rel="stylesheet" href="/addin/assets/css/kf.css">
    <link rel="stylesheet" href="/addin/assets/css/kz.css">
    <link rel="stylesheet" href="/addin/assets/css/kc.css">
    <link rel="stylesheet" href="/addin/assets/css/kq.css">
    <link rel="stylesheet" href="/addin/assets/css/zs2tb.css">
</head>
<body>
<script>
	//控制backspace
	$(document).keydown( function(e)
			{
		//获取键盘的按键CODE
		var k=e.keyCode;
		if(k == 8){
			//获取操作的标签对象
			var act = document.activeElement.tagName.toLowerCase();
			//如果按键为“backspace”并且标签对象为body或html时，返回false
			if(act.indexOf("body") != -1 || act.indexOf("html") != -1 || act == 'a')
			{
			   return false;
			}
			return true;
		}
		return true;
	});
</script>
<?php


//默认页面要求超级用户权限
if (! isset($issuper))
	$issuper = 1 ;

?>

				<?php
				if (! is_null($data))
				{
				?>
				  <div class="alert alert-warning" id="nodata" style="<?=count($data)>0?"display:none":""?>"><?=get_lang('chat_list_alert_none')?></div>
                  <div class="msg-list"  style="<?=count($data)==0?"display:none":""?>">
						<?php
						    $reader = new MsgReader();
							foreach($data as $row)
							{
							$totype=$row["myid"] == $user1?$row["to_type"]:((int)$row["to_type"]+1);
							$fcname=$row["myid"] == $user1?$MyUserName:$YouUserName;
							switch($totype)
							{
								case 1:
									$totype=1 ;
									$usertext=$row["usertext"];
									break ;
								case 2:
									$totype=2 ;
									$usertext=$row["usertext"];
									break ;
								case 3:case 4:
									$totype=3 ;
									$usertext=$row["usertext"];
									break ;
							}
							
							$result = $reader -> PastImgEx1($usertext,$totype,$YouUserID);
							if($totype<3){
						?>
                        <div class="msg-item <?=$totype == 1?"msg-send":"msg-recv" ?>" msg-id="<?=$row["typeid"] ?>">
                            <div class="msg-info">
                                <?=$fcname ?>  <?=$row["to_date"].' '.$row["to_time"] ?>
                                
                            </div>
		                    <div class="msg-content" data-totype="<?=$totype?>" data-type="<?=$result["data_type"] ?>" data-target="<?=$result["data_target"] ?>">
							     <p class="kl_text6"><?=$result["data"] ?></p>
                            </div>
                        </div>
						<?php
							}else{
						?>
                        <div class="msg-item msg-system" msg-id="<?=$row["typeid"] ?>">
		                    <div class="msg-content" data-totype="<?=$totype?>" data-type="<?=$result["data_type"] ?>" data-target="<?=$result["data_target"] ?>">
							     <p class="kl_text6"><?=$result["data"] ?></p>
                            </div>
                        </div>
						<?php
							}
							}
						?>
                 </div>
   			 	<div class="bottombar pagebar" style="height:30px">
    			</div>

			<?php
			}
			?>




</body>
</html>

<script language="javascript" >
    $(document).ready(function(){
        var abs_height = getInt($(".topbar").height()) + getInt($(".bottombar").height()) ;
        $(".fluent").attr("abs_height",abs_height) ;
		resize();
		window.onresize = function(e){
			resize();
		}

		format21MsgContent($(".msg-list"));
	    $(".time").each(function(){
	        $(this).html(getLocalTime($(this).html()));
		});
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
    		myAlert("<?=get_lang('alert_date')?>");
			return;
		}
		if ($("#user1").val() == "")
		{
			myAlert("<?=get_lang('chat_list_alert_enteraccount')?>");
			$("#user1").focus();
			return ;
		}
		if ($("#user2").val() == "")
		{
			myAlert("<?=get_lang('chat_list_alert_enteraccount')?>");
			$("#user2").focus();
			return ;
		}
		var query = "dt1=" + $("#dt1").val() + "&dt2=" +  $("#dt2").val() + "&user1=" + $("#user1").val() + "&user2=" + $("#user2").val() ;
		var url = "livechat_list.html?" + query  ;
		location.href = url ;
        return false ;
    }


</script>