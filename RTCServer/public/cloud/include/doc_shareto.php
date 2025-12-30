<?php 
require_once("../include/fun.php");
?>
<style>
#sharepath a{
	word-wrap:break-word;
	text-decoration:underline;
	color:#6699cc;
}
</style>
              <div class="modal-body" style="padding:20px 40px">
			  	<div class="form-group">
				  <label class="control-label"><?=get_lang('share_url')?></label>
				  <div class="control-value"><div id="sharepath" name="path" class="data-field"></div></div>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_close')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('copy_share_url')?></button>
              </div>
			 
<script type="text/javascript">
var myid = "<?=g("myid")?>" ;
var sids = "<?=g("sids")?>" ;
$(document).ready(function(){
	var texturl = site_address+"/cloud/include/share.html#share?myid="+myid+"&sids=" + sids ;
	$("#sharepath").html('<a href="'+texturl+'" target="_blank">'+texturl+'</a>');
//	$(".data-field")
//	.click(function(e){
//		e.stopPropagation();
//	})
	$("#btn_save")
	.unbind()
	.click(function(e){
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_clipboardData); 
		$("#texturl").hide(); 
	})
})
</script>

