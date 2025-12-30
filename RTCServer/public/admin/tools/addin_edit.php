<?php  require_once("../include/fun.php");?>
           <form id="form" method="post"  class="form-horizontal" data-obj="addin"  data-table="Plug" data-fldid="Plug_ID" data-fldname="Plug_Name">      
              <div class="modal-body">

                    <div>
                        <div class="form-group form-group-left"> 
                            <label class="control-label" for="plug_name"><?=get_lang('addin_plug_name')?></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_name')?>" class="form-control data-field specialCharValidate" style="width:150px"  id="plug_name"  name="plug_name" required maxlength="50"/>
                            </div>
                        </div> 
                        <div class="form-group form-group-right">
                            <label  for="plug_displayname" class="control-label"><span><?=get_lang('addin_plug_displayname')?></span></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_displayname')?>" class="form-control data-field specialCharValidate" style="width:150px"  id="plug_displayname"  name="plug_displayname" maxlength="50"/>
                            </div> 
                        </div> 
                        
                        <div class="form-group"> 
                            <label class="control-label" for="plug_target"><?=get_lang('addin_plug_target')?></label> 
                            <div class="control-value">
                                <textarea type="text" placeholder="" rows="4" class="form-control data-field"  id="plug_target"  name="plug_target" maxlength="4000" /></textarea>
                            </div>
                        </div> 

                        <div class="form-group"> 
                            <label class="control-label" for="plug_desc"><?=get_lang('addin_plug_desc')?></label> 
                            <div class="control-value"><input type="text" placeholder="<?=get_lang('addin_plug_desc')?>" class="form-control data-field"  id="plug_desc"  name="plug_desc" /> </div> 
                        </div>

                        <div class="form-group form-group-left"> 
                            <label class="control-label" for="plug_width"><?=get_lang('addin_plug_width')?></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_width_desc')?>" class="form-control data-field  int form-control2" style="width:150px"  id="plug_width"  name="plug_width" maxlength="50" value="800"/>
                            </div>
                        </div> 
                        <div class="form-group form-group-right">
                            <label  for="plug_height" class="control-label"><span><?=get_lang('addin_plug_height')?></span></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_height_desc')?>" class="form-control data-field  int form-control2" style="width:150px"  id="plug_height"  name="plug_height" maxlength="50" value="600"/>
                            </div> 
                        </div> 
                        
                        <div class="form-group form-group-left"> 
                            <label class="control-label" for="plug_param"><?=get_lang('addin_plug_param')?></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_param')?>" class="form-control data-field" style="width:150px"  id="plug_param"  name="plug_param"/>
                            </div>
                        </div> 
                        <div class="form-group form-group-right">
                            <label  for="plug_image" class="control-label"><span><?=get_lang('addin_plug_image')?></span></label> 
                            <div class="control-value">
                                <input type="text" placeholder="<?=get_lang('addin_plug_image')?>" class="form-control data-field" style="width:150px"  id="plug_image"  name="plug_image"/>
                            </div> 
                        </div> 
                        
                        <div class="form-group form-group-left"> 
                            <label class="control-label" for="plug_site"><?=get_lang('addin_plug_site')?></label> 
                            <div class="control-value">
								<select id="plug_site" name="plug_site" class="form-control data-field">
									<option value="0"><?=get_lang('addin_plug_site0')?></option>
									<option value="1"><?=get_lang('addin_plug_site1')?></option>
									<option value="2"><?=get_lang('addin_plug_site2')?></option>
									<option value="3"><?=get_lang('addin_plug_site3')?></option>
									<option value="4"><?=get_lang('addin_plug_site4')?></option>
									<option value="5"><?=get_lang('addin_plug_site5')?></option>
									<option value="6"><?=get_lang('addin_plug_site6')?></option>
									<option value="7"><?=get_lang('addin_plug_site7')?></option>
									<option value="8"><?=get_lang('addin_plug_site8')?></option>
                                    <option value="9"><?=get_lang('addin_plug_site9')?></option>
                                    <option value="10"><?=get_lang('addin_plug_site10')?></option>
                                    <option value="11"><?=get_lang('addin_plug_site11')?></option>
                                    <option value="12"><?=get_lang('addin_plug_site12')?></option>
                                    <option value="13"><?=get_lang('addin_plug_site13')?></option>
                                    <option value="14"><?=get_lang('addin_plug_site14')?></option>
								</select>
                            </div> 
                        </div>
                        <div class="form-group form-group-right"> 
                            <label class="control-label" for="plug_targettype"><?=get_lang('addin_plug_targettype')?></label> 
                            <div class="control-value">
                                <select id="plug_targettype" name="plug_targettype" class="form-control data-field form-control2" style="width:150px">
                                    <option value="1"><?=get_lang('addin_plug_targettype1')?></option>
                                    <option value="2"><?=get_lang('addin_plug_targettype2')?></option>
                                    <option value="3"><?=get_lang('addin_plug_targettype3')?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-left">         
                            <label  for="plug_bie" class="control-label"><span><?=get_lang('addin_plug_bie')?></span></label>
                            <div class="control-value">  
                                <input type="text" placeholder="<?=get_lang('addin_plug_bie')?>" class="form-control data-field  int form-control2" style="width:150px"  id="plug_bie"  name="plug_bie" required maxlength="50"/>
                            </div>  
                        </div>
                        <div class="form-group form-group-right"> 
                            <label class="control-label" for="plug_enabled"><?=get_lang('addin_plug_enabled')?></label> 
                            <div class="control-value">
                                <select id="plug_enabled" name="plug_enabled" class="form-control data-field form-control2" style="width:150px">
                                    <option value="1"><?=get_lang('addin_plug_enabled1')?></option>
                                    <option value="0"><?=get_lang('addin_plug_enabled0')?></option>
                                </select>
                            </div>
                        </div>
                         
                        <div class="clear"></div>    
                    </div> 


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang('btn_cancel')?></button>
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
              </div>
            </form>
<script type="text/javascript">
   

var dataForm ;
var id = "<?=g("id")?>" ;
$(document).ready(function(){
   //init
   if (id != ""){
	    $("#plug_name").attr("disabled",true);
		$("#plug_bie").attr("disabled",true);
   }

   dataForm = $("#form").attr("data-id",id).dataForm({getcallback:getCallBack,savecallback:saveCallBack});
   $("#form").validate({
		invalidHandler: function(form, validator) {
			var errors = validator.errorList ;
			if (errors.length>0)
			{
				var el = $(errors[0].element) ;
				var tabId = $(el).parents(".tab-content").attr("id") ;
				$(".nav-tabs li a[href='#" + tabId + "']").click();
			}
		},
		ignore: "ui-tabs-hide",
        submitHandler: function(form) {
			if(/.*[\u4e00-\u9fa5]+.*$/.test($("#plug_displayname").val())&&parseInt($("#plug_targettype").val())==1) 
			{ 
			alert("<?=get_lang('addin_plug_warning3')?>"); 
			return false; 
			}
			var plug_bie = $("#plug_bie").val();
		
			if (isNaN(plug_bie))
				plug_bie = 0 ;
		
			if(plug_bie <= 0&&id == "")
			{
				setElementError($("#plug_bie"),"<?=get_lang('addin_plug_warning')?>");
				return;
			}
            dataForm.save();
            return false;
        }
  });

});

function getCallBack(data)
{
	//data.col_data =  replaceAll(data.col_data,"\\n","");
	return data ;
}


function saveCallBack()
{
    dataList.reload();
    dialogClose("addin");
}
</script>