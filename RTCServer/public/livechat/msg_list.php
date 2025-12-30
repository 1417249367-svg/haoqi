<?php  require_once("include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/im/msg.class.php");?>

<?php
		/*
		$dp = new Model("lv_user");
		$dp -> addParamWhere("userid",g("userid"));
		$row = $dp-> getDetail();
		if (count($row) == 0)
		{
			print("用户不存在");
			die();
		}
		*/

        $sortBy = g("sortby");
        $sortDir = g("sortdir", 0);
        $pageIndex = g("page", -1);
        $pageSize = g("pagesize", 20);
        $dt1 = g("dt1");
		$dt2 = g("dt2");
        $key = g("key");
        $chater = g("chater","wwj@aipu.com");
        $chaterName = "";
		$loginname = g("loginname","jc@aipu.com");
		$password = g("password");
		
        if ($chater == "")
        {
            print("请输入对话人帐号");
            die();
        }
		
		$db = new DB();
		
		$msg = new Msg();
		$sql_where = $msg -> getWhereSql($loginname,$chater,$dt1,$dt2,$key);
		$sql_count = "select  count(*) as c  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where ;
		$sql_list = "select  A.col_id,col_subject,col_sender,col_sendername," . ($db -> getSelectDateField("A.col_senddate")) . ",col_datapath  from  Ant_Msg A,Ant_Msg_Rece B " . $sql_where . " order by A.col_senddate " ;

		$recordCount = $msg -> db -> executeDataValue($sql_count);
		
		if ($recordCount > 0)
		{
			//消息查看，从最后一页开始
			if ($pageIndex == -1)
				$pageIndex = get_page_count($recordCount,$pageSize);

			$data = $msg -> db -> page($sql_list,$pageIndex,$pageSize);
		}
		else
		{
			$pageIndex = 0 ;
			$data = array() ;
		}
		

		
		//测试读消息
		function getContent($msgid,$datapath)
		{
			$reader = new MsgReader();
			$reader -> read($msgid,$datapath);
			return $reader -> html ;
		}

		
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../addin/include/meta.php");?>
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
    <link type="text/css" rel="stylesheet" href="../addin/assets/css/msg.css" />
</head>
<body>

<div>
    <div class="topbar">
        <div class="searchbar">
				
                <label class="pull-left mr"><?=get_lang("text_search_rang")?>：</label>
				<input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="<?=$dt1?>" data-date-format="yyyy-mm-dd"  style="width:120px;">
				<span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang("text_to")?></span>
				<input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="<?=$dt2 ?>" data-date-format="yyyy-mm-dd" style="width:120px;">

            	<input type="text" id="key" value="<?=$key ?>" class="form-control pull-left mr" style="width:120px;" />
            	<input type="button" id="btn_search" value="<?=get_lang("btn_search")?>" class="btn pull-left" onclick="search()"  />
				<div class="clear"></div>
        </div>
    </div>

    <div class="content fluent"> 
				  <div class="alert alert-warning" id="nodata" style="<?=count($data)>0?"display:none":""?>"><?=get_lang("text_norecord")?></div>
                  <div class="msg-list"  style="<?=count($data)==0?"display:none":""?>"> 
						<?php 
							foreach($data as $row)
							{
						?>
                        <div class="msg-item <?=$row["col_sender"] == $loginname?"msg-send":"msg-recv" ?>" msg-id="<?=$row["col_id"] ?>" msg-datapath="<?=$row["col_datapath"] ?>">
                            <div class="msg-info">
                                <?=$row["col_sendername"] ?>  <?=getLocalTime($row["col_senddate"]) ?>
                            </div> 
		                    <div class="msg-content">
                                 <?=getContent($row["col_id"],$row["col_datapath"]) ?>
		                    </div> 
                        </div>
						<?php 
							}
						?>
                 </div>

        
        
    </div> 
    
    <div class="bottombar pagebar" style="height:30px">
    </div>
    
</div>

</body>
</html>

<script language="javascript" >
	var query = "loginname=<?=$loginname ?>&password=<?=$password ?>&chater=<?=$chater ?>" ;
    $(document).ready(function(){

        var abs_height = getInt($(".topbar").height()) + getInt($(".bottombar").height()) ;
        $(".fluent").attr("abs_height",abs_height) ;
		resize();
		window.onresize = function(e){
			resize();
		}
		
		formatMsgContent($(".msg-content"));
		
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
        var url = "msg_list.html?" + query + "&dt1=" + $("#dt1").val() + "&dt2=" +  $("#dt2").val() + "&key=" + $("#key").val() ;
        location.href = url ;
        return false ;
    }
</script>