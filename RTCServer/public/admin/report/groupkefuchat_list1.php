<?php  require_once("../include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/Msg.class.php");?>
<?php  require_once(__ROOT__ . "/class/im/MsgReader.class.php");?>

<?php
        $sortBy = g("sortby");
        $sortDir = g("sortdir", 0);
        $pageIndex = g("page", -1);
        $pageSize = g("pagesize", 20);
		$recordCount = 0 ;
        $dt1 = g("dt1");
		$dt2 = g("dt2");
        $pid = g("pid");
		$typeid = g("typeid");
		$key = g("key");
		

        if (($typeid != ""))
        {
		

			$db = new DB();
			$msg = new Msg();
			$sql_where = $msg -> getWhereSql1($typeid,$dt1,$dt2,$key);
			$sql_count = "select  count(*) as c  from  MessengKefuClot_Text " . $sql_where ;
			$sql_list = "select * from MessengKefuClot_Text " . $sql_where . " order by TypeID " ;
			
//			echo $sql_list;
//			exit();
	
			$recordCount = $msg -> db -> executeDataValue($sql_count);
	
			if ($recordCount > 0)
			{
				//消息查看，从最后一页开始
				$pageIndex1=get_page_count($recordCount,$pageSize);
				if($pageIndex>$pageIndex1||$pageIndex == -1) $pageIndex = $pageIndex1;
	
				$Messeng = new Model ( "MessengKefuClot_Text" );
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
		}


?>

<?php
define("MENU","GROUPKEFUCHATLIST") ;
$db = new Model("lv_chater_ro");
$db->where ("where To_Type=1");
$data_user = $db -> getList();
$html = '<option value="">'.get_lang('msg_list_pid').'</option>';
foreach($data_user as $k=>$v){
	if($data_user[$k]['typeid']==$pid) $res=' selected="selected"';
	else $res='';
	$html .='<option value="'.$data_user[$k]['typeid'].'"'.$res.'>'.$data_user[$k]['typename'].'</option>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <link rel="stylesheet" type="text/css" href="/static/js/lightbox/lightbox.css" media="screen">
	<script type="text/javascript" src="/static/js/lightbox/lightbox.js"></script>
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
    <script src="/static/js/BenzAMRRecorder.min.js"></script>
    <link rel="stylesheet" href="/addin/assets/css/ui-base.css">
    <link rel="stylesheet" href="/addin/assets/css/ui-box.css">
    <link rel="stylesheet" href="/addin/assets/css/ui-btn.css">
    <link rel="stylesheet" href="/addin/assets/css/tbmu.css">
    <link rel="stylesheet" href="/addin/assets/css/kl.css">
    <link rel="stylesheet" href="/addin/assets/css/kjctn.css">
    <link rel="stylesheet" href="/addin/assets/css/kjbd.css">
    <link rel="stylesheet" href="/addin/assets/css/kf.css">
    <link rel="stylesheet" href="/addin/assets/css/kz.css">
    <link rel="stylesheet" href="/addin/assets/css/kc.css">
    <link rel="stylesheet" href="/addin/assets/css/kq.css">
    <link rel="stylesheet" href="/addin/assets/css/zs2tb.css">
    <link rel="stylesheet" href="/addin/assets/css/msg.css" />
</head>
<body>
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
							$totype=$row["to_type"];
							$usertext=$row["usertext"];
							$result = $reader -> PastImgEx1($usertext,$totype,$YouUserID);
							if($totype<3){
						?>
                        <div class="msg-item <?=$totype == 2?"msg-send":"msg-recv" ?>" msg-id="<?=$row["typeid"] ?>">
                            <div class="msg-info">
                                <?=js_unescape($row["fcname"]) ?>  <?=$row["to_date"].' '.$row["to_time"] ?>
                                
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
		
		selectkefuclot();


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
		if ($("#typeid").val() == "")
		{
			myAlert("<?=get_lang('msg_list_groupid')?>");
			$("#typeid").focus();
			return ;
		}
		var query = "dt1=" + $("#dt1").val() + "&dt2=" +  $("#dt2").val() + "&pid=" +  $("#pid").val() + "&typeid=" + $("#typeid").val() ;
		var url = "groupkefuchat_list.html?" + query  ;
		location.href = url ;
        return false ;
    }

	function selectkefuclot()
	{
		if(!$("#pid").val()) return ;
		var url = getAjaxUrl("livechat_kf","listclot_ro") ;
		//document.write(url+"pid=" + $("#pid").val());
		$.ajax({
		   type: "POST",
		   dataType:"json",
		   data:"pid=" + $("#pid").val(),
		   url: url,
		   success: function(result){
				if (result.status == undefined)
				{
					$('#typeid').html('');
					var html = '<option value=""><?=get_lang('msg_list_groupid')?></option>'; 
					if(result.rows.length>0){
						for(var i=0;i<result.rows.length;i++){
							if(result.rows[i].typeid=='<?=$typeid?>') var res=' selected="selected"';
							else var res='';
							 html +='<option value="'+result.rows[i].typeid+'"'+res+'>'+result.rows[i].typename+'</option>';
						}
					}
					$('#typeid').html(html);
				}
				else
				{
					myAlert(getErrorText(result.errnum));
				}
		   }
		});
	}
</script>