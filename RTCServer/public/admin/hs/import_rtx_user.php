<?php  require_once("../include/fun.php");?>

           <form id="form" method="post" class="form-horizontal" enctype="multipart/form-data">      
              <div class="modal-body">
                    <div class="form-group"> 
                        <label class="control-label"><?=get_lang("imp_lb_filepath")?></label> 
                        <div class="control-value">
                            <input type="file" name="file_import" id="file_import"  class="form-control" accept=".xml"  required> 
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                <button type="button" class="btn btn-primary" id="btn_import"  onclick="import_upload('rtx')"><?=get_lang("btn_imprtx")?></button>
              </div>
            </form>
