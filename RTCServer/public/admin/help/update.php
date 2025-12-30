<?php  require_once("../include/fun.php");?>
<?php


?>
              <div class="modal-body">
                        <h4><?=get_lang("update_software_upgrade")?></h4>
                        <ul class="list-unstyled">
                            <li><?=get_lang("update_product_website")?>：<a href="<?=APP_URL?>" target="_blank"><?=APP_URL?></a></li>
                        </ul>
                        <br>
                        <p><?=get_lang("update_warning")?><br></p>
              </div>
              <div class="modal-footer">
                <input type="button" class="btn btn-primary" onclick="update_dialog()" value="<?=get_lang("update_download")?>" />
                <input type="button" class="btn btn-default" data-dismiss="modal" value="<?=get_lang("btn_close")?>" />
              </div>


<script type="text/javascript">
function update_dialog()
{
	var url="http://www.haoqiniao.cn/download/1/UpDateFile1.exe";
	frm_Upload.location.href = url;
}
</script>