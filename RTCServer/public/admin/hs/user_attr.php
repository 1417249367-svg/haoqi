<?php  require_once("../include/fun.php");?>
 
           <form id="form_attr" method="post"  class="form-horizontal" data-obj="user"  data-table="hs_user" data-fldid="col_id" data-fldname="col_name">  
		   

              <div class="modal-body">

  					<div  id="other">
                         <dl>
                            <dt><?=get_lang('label_pwd')?></dt>
                            <dd>
                                <input type="password" placeholder="" class="form-control"  id="col_userpaws"  name="col_userpaws" required  maxlength="50" />
                            </dd>
                        </dl>
                         <dl>
                            <dt><?=get_lang('user_attr_allowedcard')?></dt>
                            <dd>
                                <textarea  class="form-control data-field" rows="3" name="col_farserver" id="col_farserver"></textarea>
                            </dd>
                        </dl>
  					
                         <dl>
                           <dt><?=get_lang('user_attr_allowedip')?></dt>
                            <dd>
                                <textarea class="form-control data-field  " rows="3" name="col_ipaddr" id="col_ipaddr"></textarea>
                            </dd>
                        </dl>
					</div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save" ><?=get_lang('btn_save')?></button>
              </div>
			  
            </form>
<script type="text/javascript">
   


var dataForm ;

$(document).ready(function(){
	$("#col_userpaws").val("******");
    $("#btn_save").click(function(){
        user_attr_post();
		return false ;
    })
});



</script>