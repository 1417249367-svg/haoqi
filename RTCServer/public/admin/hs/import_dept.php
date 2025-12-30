<?php  require_once("../include/fun.php");?>

           <form id="form" method="post" class="form-horizontal" enctype="multipart/form-data">      
              <div class="modal-body">
			  		<div class="alert alert-warning"><?=get_lang("imp_dept_warning")?></div>
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("imp_lb_filepath")?></label> 
                        <div class="control-value">
                            <input type="file" name="file_import" id="file_import"  class="form-control" accept=".xls"  required> 
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label"></label> 
                        <div class="control-value">
                            <a href="/public/download.html?file=../static/file/dept_path.xls"><?=get_lang("imp_dept_link_path")?></a>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_import"  onclick="import_upload('dept')"><?=get_lang("btn_impdept")?></button>
              </div>
            </form>
