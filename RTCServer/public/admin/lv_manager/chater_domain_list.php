<?php  require_once("../include/fun.php");?>
<?php
define("MENU","LIVECHAT_DOMAIN") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script language="javascript" src="../assets/js/sysconfig.js"></script>
	<script type="text/javascript" src="../assets/js/livechat_chater_domain.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang("chater_domain_title")?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                     <div class="pull-left">
                          <button type="button" class="btn btn-default" action-type="chater_domain_edit"><?=get_lang("chater_domain_add")?></button>
                          <button type="button" class="btn btn-default" action-type="chater_domain_delete"><?=get_lang("chater_domain_delete")?></button>
                     </div>
                     
				</div>
				<!--End SearchBar-->

				<!--List--->
                    <table  id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_chater_domain" data-fldid="typeid" data-fldname="typename"  data-fldsort="ord ,typeid" data-fldsortdesc="ord desc,typeid desc" data-where=""  data-fldlist="*">
                        <thead>
                            <tr>
								<td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="typename"><?=get_lang("chater_domain_name")?></td>
                                <td data-sortfield="description"><?=get_lang("chater_domain_desc")?></td>
                                <td data-sortfield="createtime"><?=get_lang("chater_domain_dt")?></td>
                                <td data-sortfield="status" style="width: 80px"><?=get_lang("chater_domain_status")?></td>
                                <!-- <td >标签</td> -->
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
					<script type="text/x-jquery-tmpl" id="tmpl_list">
						<tr class="data-row row-${typeid}" data-name="${typename}" data-id="${typeid}" data-ord="${ord}">
							<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
							<td><a href="javascript:void(0);" onclick="chater_domain_edit('${typeid}','${typename}')">${typename}</a></td>
							<td>${description}</td>
							<td>${createtime}</td>
							<td><input type="radio" name="defaultrole" id="defaultrole_${typeid}" data-value="${status}" action-data="${typeid},'status',this"  action-type="dataList.setradioSwitch1"/></td>
							<td class="col-op">
								<a href="javascript:void(0);" onclick="chater_domain_edit('${typeid}','${typename}')"><?=get_lang("btn_change")?></a>
								<a href="javascript:void(0);" onclick="chater_domain_delete('${typeid}')" class="btn_delete"><?=get_lang("btn_delete")?></a>
							</td>
						</tr>
					</script>
				<!--End List--->
				<?php  require_once("../include/footer.php");?>
</body>
</html>

<script type="text/javascript">
genre = "SysConfig" ;
var dataList ;
$(document).ready(function(){
	chater_domain_list_init();
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

