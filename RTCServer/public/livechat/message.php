<?php  require_once("include/fun.php");?>
<?php
    $loginName = g("loginName","admin@rtcim.com");
	$dp = new Model("lv_chater");
	$dp -> addParamWhere("loginname",$loginName);
    $row = $dp-> getDetail();
	if (count($row) == 0)
		$row = array("userid"=>"","loginname"=>$loginName,"username"=>get_lang('aside_usercard'),"welcome"=>"") ;
	
	$userid =$row["userid"] ;

	ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
   <?php  require_once("include/meta.php");?>
	<script  type="text/javascript" src="/static/js/jquery.validate.js"></script>
	<script  type="text/javascript" src="/static/js/messages_zh.js"></script>
	<style>
		.main{width:70%;}
		.aside{width:30%;}
	</style>
</head>
<body style="overflow:hidden;">
<div id="win">
	<?php  require_once("include/header.php");?>
	<div class="content">
		<div class="main fluent">
            <div id="container_success" class="bor" style="display:none">
				<div class="alert alert-success">
					<?=get_lang('msg_warning')?>
				</div>
			</div>
			<div id="container_form" class="bor">
            <form id="form" method="post" >
			<div class="note" style="margin-bottom:10px"><?=get_lang('msg_note',$row["username"])?></div>

            <div class="form-group">
                <label class="control-label" for="username"><?=get_lang('msg_lb_username')?></label>
                <div class="control-value">
                    <input type="text" name="username" id="username" placeholder="<?=get_lang('msg_ph_username')?>" class="form-control data-field"   maxlength="20"   value="<?=getValue("BIGANTLIVE_USERNAME")?>" required data-msg-required="<?=get_lang('msg_required_username')?>" />
                </div>
                <div class="clear"></div>
           </div>
           <div class="form-group">
                <label class="control-label" for="phone"><?=get_lang('msg_lb_phone')?></label>
                <div class="control-value">
                    <input type="text" name="phone" id="phone" placeholder="<?=get_lang('msg_ph_phone')?>" class="form-control data-field"   maxlength="20"   value="<?=getValue("BIGANTLIVE_PHONE")?>" required data-msg-required="<?=get_lang('msg_required_phone')?>"/>
                </div>
                <div class="clear"></div>
            </div>
           <div class="form-group">
                <label class="control-label" for="email"><?=get_lang('msg_lb_email')?></label>
                <div class="control-value">
                    <input type="text" name="email" id="email" placeholder="<?=get_lang('msg_ph_email')?>" class="form-control email data-field"   maxlength="50"   value="<?=getValue("BIGANTLIVE_EMAIL")?>" data-msg-required="<?=get_lang('msg_required_email')?>" />
                </div>
                <div class="clear"></div>
            </div>
           <div class="form-group">
                <label class="control-label" for="usertext"><?=get_lang('msg_lb_content')?></label>
                <div class="control-value">
                    <textarea type="text" name="usertext" id="usertext" rows="3"    placeholder="<?=get_lang('msg_ph_content')?>" maxlength="500" class="form-control data-field" required data-msg-required="<?=get_lang('msg_required_content')?>" /></textarea>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <div class="control-value">
                    <input type="submit"  class="btn btn-primary" id="btn_save" value="<?=get_lang('msg_leave')?>" />
                    <input type="hidden" name="groupid" id="groupid"class="form-control data-field" value="<?=g("groupid") ?>" />
                    <input type="hidden" name="chater" id="chater"class="form-control data-field" value="<?=g("chater") ?>" />
                </div>
                <div class="clear"></div>
            </div>
            </form>
			</div>
		</div>
		<div class="aside fluent">
			<?php  require_once("aside.php");?>
		</div>
		<div class="clear"></div>
	</div>
</div>



</body>
</html>

 <script type="text/javascript">
	window.addEventListener("message",function(obj){
		var data = obj.data;
		switch (data.cmd) {
		case 'postRate':
		  postRate(data.params);
		  break;
		}
	});
	
	$(document).ready(function()
	{
		//size
		var abs_height = getInt($(".topbar").height()) + 3 ;
		$(".fluent").attr("abs_height",abs_height) ;
		resize();
		window.onresize = function(e){
			resize();
		}

	    $("#form").validate({
			submitHandler: function(form) {
				save();
				return false ;
			}
		});
	})
	
	function postRate(index)
	{
		window.parent.postMessage({
				  cmd: 'endpc',
				  params: index
				}, '*');
	}

    function save()
    {
//		var username = $("#username").val() ;
		var phone = $("#phone").val() ;
//		var email = $("#email").val() ;
//		var note = $("#note").val() ;
//		var param = {username:escape(username),phone:phone,email:email,note:escape(note)};
	   var reg_mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
	   if (!reg_mobile.test(phone))
	   {
		   alert("请输入有效的手机号码");
		   $("#phone").focus();
		   return ;
	   }
	   var url = getAjaxUrl("livechat_kf","postmessage") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           url: url,
           data:$('#form').serialize(),
           success: function(result){
		   		$("#container_form").hide();
                $("#container_success").show();
           }
       });
    }
 </script>