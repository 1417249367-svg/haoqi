<?php  require_once("../include/fun.php");?>
 
           <form id="form_role" method="post"  class="form-horizontal" data-obj="user"  data-table="hs_user" data-fldid="col_id" data-fldname="col_name">  
		   

              <div class="modal-body">

                    <div id="power">
                        <dl>
                            <dt><?=get_lang("role_list_btn_batches")?></dt>
                            <dd>
                                <div style="height:80px;overflow:auto;" id="viewer_role">

                                </div>
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
	 dataForm = $("#form_role").attr("data-id","").dataForm({getcallback:getUserCallBack,submitcallback:submitUserCallBack,savecallback:saveUserCallBack});
    $("#btn_save").click(function(){
        user_role_post(getCheckValue("roleid"));
		return false ;
    })
});

function getUserCallBack(data)
{
	//alert(JSON.stringify(data));;
	var html = "";
	// init role
	html = "";		
	for(var i=0;i<data.orgs.length;i++){
	    var checkvalue="";
		var display="";
	    if(data.orgs[i].defaultrole=="1") checkvalue=" checked=\"checked\"";
		if(data.orgs[i].creatorid!=_curr_userid&&! _isadmin) display=" style=\"display:none;\"";
		html += "<li"+display+"><label><input  type=\"checkbox\"  name=\"roleid\" value=\"" + data.orgs[i].id + "\""+checkvalue+"/> " + data.orgs[i].rolename + "</label></li>";
	}
	$("#viewer_role").html("<ul class='list-h'>" + html + "</ul>");
}

function saveUserCallBack()
{
    //dataList.reload();
    //dialogClose("user");
}

function submitUserCallBack(data)
{
//    if (data.col_birthday == "")
//        data.col_birthday = "1900-1-1" ;
    //document.write(JSON.stringify(data));
    return data ;
}

</script>