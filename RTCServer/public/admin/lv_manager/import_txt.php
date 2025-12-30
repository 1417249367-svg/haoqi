<?php  require_once("../include/fun.php");?>

           <form id="form" method="post" class="form-horizontal" enctype="multipart/form-data">
              <div class="modal-body">
			  		<div class="alert alert-warning"><?=get_lang("imp_txt_warning")?></font></div>
                    <div class="form-group">
                        <label class="control-label"><?=get_lang("imp_lb_filepath")?></label>
                        <div class="control-value">
                            <input type="file" name="file_import" id="file_import"  class="form-control" required>
                        </div>
                    </div>
                    <!--<div class="form-group form-group-left">
                        <div class="control-value">
                        <label class="control-label">
                        	<input type="checkbox" value="1" value-unchecked="0" name="quick" id="quick"/>
                            快速导入
                        </label>
                        </div>
                    </div>-->
                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_import"  onclick="import_upload('user')"><?=get_lang("btn_imptxt")?></button>
              </div>
            </form>
