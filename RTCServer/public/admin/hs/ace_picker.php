<?php  require_once("../include/fun.php");?>

              <div class="modal-body">
                    <ul class="list-h">
						<?php
						$role = new Model("Role") ;
						$plug_name = $role -> db -> executeDataTable("select Plug_Name from Plug where Plug_ID in (" . g("itemId") . ")");
						
						$data = $role -> getList();
						foreach($data as $row)
						{
						if(strpos(g("itemId"),",")) $checkvalue=' checked="checked"';
						else{
							$checkvalue='';
							//echo $row["plug"].","."|"."Plug_".$plug_name[0]["plug_name"].",";
							if(!strpos($row["plug"].",",$plug_name[0]["plug_name"].",")) $checkvalue=' checked="checked"';
						}
						?>
						<li style="width:48%;"><input  type="checkbox"  name="<?=$row["rolename"] ?>" value="<?=$row["plug"] ?>"<?=$checkvalue ?> class="data-field"/> <?=$row["rolename"] ?></li>
                    	<?php
						}
						?>
					</ul>
                    <div class="clear"></div>
              </div>
              <div class="modal-footer clearfix">
<!--			  		<div class="pull-left" id="options">
						<label><input type="checkbox" id="chk_reset" /> 重置标签</label>
					</div>-->
			  		<div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=get_lang("btn_cancel")?></button>
						<button type="submit" class="btn btn-primary" id="btn_picker_submit"><?=get_lang("btn_ok")?></button>
					</div>
              </div>
 

 <script type="text/javascript">
    var itemType = "<?=g("itemType") ?>" ;
    var itemId = "<?=g("itemId") ?>" ;
    var empType = "<?=g("empType") ?>" ;
    var funName = "<?=g("funName") ?>" ;
    var funGenre = "<?=g("funGenre") ?>" ;
	var Smsn = <?=json_encode($plug_name) ?> ;
    //document.write(JSON.stringify(Smsn));
	
	$(document).ready(function(){
		//ace_load(itemType,itemId);
		
//		if (itemId.indexOf(",")== -1)
//		{
//		    $("#options").hide() ;
//			$("#chk_reset").attr("checked",true) ;
//	    }
//		else
//		{
//			$("#options").show() ;
//		}
		
	    if (itemId == "")
	    {
	    	myAlert(getErrorText(102601));
		    dialogClose("acepicker");
	    }
		$("input[type=checkbox][class=data-field]").each(function(){
			$(this).click(function(){
				var checked = $(this).is(":checked");
				if (checked){
				   //myAlert($(this).val());
				   for(var k=0;k<Smsn.length;k++){
					   if(Smsn[k].plug_name!="") $(this).val(replaceAll($(this).val(),","+Smsn[k].plug_name,""));
				   }
					//myAlert($(this).val());
				}
				else{
					 //myAlert($(this).val());
				   for(var k=0;k<Smsn.length;k++){
					   if(Smsn[k].plug_name!=""&&$(this).val().indexOf(Smsn[k].plug_name)==-1) $(this).val($(this).val()+","+Smsn[k].plug_name);
				   }
				    //myAlert($(this).val());
				}
			})
		})
	    $("#btn_picker_submit").click(function(){
		    var tags = "";
		    //var flag = $("#chk_reset").is(':checked')?1:0 ;
		    ace_post();
	    })
	})

 </script>