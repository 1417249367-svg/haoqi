<?php  require_once("../include/fun.php");?>
<?php
define("MENU","LIVECHAT_WECHAT") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script language="javascript" src="../assets/js/sysconfig.js"></script>
	<script type="text/javascript" src="../assets/js/livechat_chater_wechat.js?ver=2025022601"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("chater_wechat_title")?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="chater_wechat_edit"><?=get_lang("chater_wechat_add")?></button>
                          <button type="button" class="btn btn-default" action-type="chater_wechat_delete"><?=get_lang("chater_wechat_delete")?></button>
                          <button type="button" class="btn btn-default" action-type="import_txt"><?=get_lang("chater_wechat_upload")?></button>
                     </div>
                     
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_chater_wechat" data-fldid="typeid" data-fldname="typename"  data-fldsort="ord ,typeid" data-fldsortdesc="ord desc,typeid desc" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="domain"><?=get_lang("chater_list_domain")?></td>
                                <td data-sortfield="description"><?=get_lang("chater_domain_desc")?></td>
                                <td data-sortfield="createtime"><?=get_lang("chater_wechat_dt")?></td>
                                <td data-sortfield="status" style="width: 80px"><?=get_lang("chater_wechat_status")?></td>
                                <!-- <td >标签</td> -->
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${typeid}" data-domain="${domain}" data-id="${typeid}" data-appid="${appid}" data-sercet="${sercet}" data-token="${token}" data-moban_id="${moban_id}" data-subscribe="${subscribe}" data-subscribe_id="${subscribe_id}" data-subscribe_id2="${subscribe_id2}" data-groupid="${groupid}" data-domain1="${domain1}" data-appid1="${appid1}" data-sercet1="${sercet1}" data-moban_id1="${moban_id1}">
							<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
							<td><a href="javascript:void(0);" onclick="chater_wechat_edit('${typeid}','${domain}')">${domain}</a></td>
							<td>${description}</td>
							<td>${createtime}</td>
							<td><input type="radio" name="defaultrole" id="defaultrole_${typeid}" data-value="${status}" action-data="${typeid},'status',this"  action-type="dataList.setradioSwitch1"/></td>
							<td class="col-op">
								<a href="javascript:void(0);" onclick="chater_wechat_edit('${typeid}','${typename}')"><?=get_lang("btn_change")?></a>
								<a href="javascript:void(0);" onclick="chater_wechat_delete('${typeid}')" class="btn_delete"><?=get_lang("btn_delete")?></a>
							</td>
						</tr>
					</script>
				<!--End List--->
				<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
genre = "LivechatConfig" ;
var dataList ;
$(document).ready(function(){
	chater_wechat_list_init();
})
function Switch_saveCallBack()
{
   var url = getAjaxUrl("sysconfig","save","genre=" + genre) ;
   //document.write(url+"&data="+data);
   $.ajax({
       type: "POST",
	   data:{"data":data},
       dataType:"json",
       url: url,
       success: function(result){
    	   if(result.status)
		   {

		   }
    	   else
		   {
		   		myAlert(result.msg);
		   }
			
       }
   });
}
</script>

