<?php  require_once("../include/fun.php");?>

           <form id="form" method="post" class="form-horizontal" enctype="multipart/form-data">      
              <div class="modal-body">
                    <div class="form-group"> 
                        
                        <div style="margin-left:25%;">
                        	<button type="button" class="btn btn-primary"  onclick="export_user_all()" style="margin-right:40px"><?=get_lang("btn_exp_alluser")?></button>
                       		<button type="button" class="btn btn-primary" onclick="export_user_selected()"><?=get_lang("btn_exp_seluser")?></button> 
                        </div>
                    </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
                
              </div>
            </form>
