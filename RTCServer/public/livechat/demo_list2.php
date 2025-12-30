<?php  
require_once("../class/fun.php");
$rootPath1 = g("ipaddress",getRootPath1());
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<style>
        #container_online .livechat-list{margin:0px;padding:0px;}
        #container_online .livechat-user{list-style-type:none;margin:0px;padding:20px 0px;float:left;width:20%; text-align:center;}
        #container_online ul li a{ display:block ;margin:0px 10px;padding:10px;padding-top:130px; background-position:center 10px ; background-repeat:no-repeat ; text-decoration:none;background-image:url(../images/user_b_0.png);}
        #container_online ul li a:hover{ background-color:#f7f7f7;}
        #container_online ul li.status-3 a{background-image:url(../images/user_b_1.png) ; }
	</style>
</head>
<script type="text/javascript">
	var lang = "<?=LANG_TYPE?>";
</script>
<body>
	

			
			<div id="container_online">
                <ul class='livechat-list'>
					<?php
						$db = new Model("lv_chater");
						$data = $db -> getList();
						foreach($data as $row)
						{
					?>
                   <li class='livechat-user' data-status='0' data-loginname='<?=$row["loginname"]?>'><a href='#'><?=$row["username"]?></a></li>
					<?php
						}
					?>
                </ul>
            </div>


	
</body>
</html>
<script type="text/javascript" src="getjs/?ipaddress=<?=$rootPath1 ?>&rnd=<?=getAutoId() ?>&op=3"></script>