<?php
	require_once("include/fun.php");

//    $loginName = g("loginName","admin");
//    $userid = "" ;
//    $rootPath1 = g("ipaddress",getRootPath1());
//	$dp = new Model("lv_chater");
//	$dp -> addParamWhere("loginname",$loginName);
//    $row = $dp-> getDetail();
//	if (count($row) == 0)
//		$row = array("userid"=>"","loginname"=>$loginName,"username"=>$loginName,"welcome"=>"") ;
//	
//	$userid =$row["userid"] ;
//
//	ob_clean();
?>
<div class="aside-tab">
	<ul id="tabs" class="aside-tab-nav">
		<li class="active"><a href="###" for="container_usercard"><?=get_lang('aside_usercard')?></a></li>
		<li><a href="###" for="container_link"><?=get_lang('aside_link')?></a></li>
	</ul>
	<div class="clear"></div>
	<div id="container_usercard" class="tab-content">
		<ul id="usercard" style="padding:0px;margin:0px auto;">
			<li class="pic"><img class="photo" src="<?=$row["picture"]?>" onerror="this.src='assets/img/default.png'"  style="width:90px;height:90px;"/></li>
			<li class="username"><?=$row["username"]?></li>
			<li class="sp"></li>
			<li class="dept field"><?=$row["deptname"]?></li>
			<li class="jobtitle field"><?=$row["jobtitle"]?></li>
			<li class="phone field"><?=$row["phone"]?></li>
			<li class="mobile field"><?=$row["mobile"]?></li>
			<li class="email field"><?=$row["email"]?></li>
		</ul>
		<div class="clear"></div>
	</div>
	<div id="container_link" class="tab-content">
		<ul class="link-list" style="padding:0px 10px;margin:0px auto;">
			<?php
			$sql = " select * from lv_link where Chater='' or Chater='" . $userid . "' order by chater,ord,linkid desc" ;

			$db = new DB();
			$data = $db -> executeDataTable($sql);
			foreach($data as $row_link)
			{
			?>
			<li><a href="<?=$row_link["linkurl"]?>" target="_blank"><?=$row_link["linkname"]?></a></li>
			<?php
			}
			?>
		</ul>
		<div class="clear"></div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	var tabsId = "tabs" ;
    $("#" + tabsId + " a").click(function () {
		var container = $(this).parent().parent() ;
		$("a",container).each(function(){
			$("#" + $(this).attr("for")).hide();
			$(this).parent().removeClass("active");
		})
		$("#" +$(this).attr("for")).show();
		$(this).parent().addClass("active");
    })

    $("#" + tabsId + " li:eq(0) a").click();

})


</script>
</script>