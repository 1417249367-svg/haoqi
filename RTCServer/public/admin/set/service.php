<?php  require_once("../include/fun.php");?>
<?php
define("MENU","SERVER") ;

require_once(__ROOT__ . "/class/common/Regedit.class.php");
$regedit = new Regedit();
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script language="javascript" src="../assets/js/service.js"></script>
</head>
<body class="body-frame">
	<?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('service_title')?></h1></div>
                <div class="searchbar clearfix">
                    <div class="pull-left">
						<button type="button" class="btn btn-default" action-type="service_start"><?=get_lang('service_btn_launch')?></button>
                      	<button type="button" class="btn btn-default" action-type="service_restart"><?=get_lang('service_btn_restart')?></button>
					  	<button type="button" class="btn btn-default" action-type="service_stop"><?=get_lang('service_btn_stop')?></button>
                    </div>

                </div>

				<table  id="datalist" class="table table-striped table-hover data-list">
				  <thead>
					<tr>
					  <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
					  <td style="width:200px"><?=get_lang('service_table_name')?></td>
					  <td><?=get_lang('service_table_des')?></td>
					  <td style="width:150px"><?=get_lang('service_table_portaddress')?></td>
					  <td style="width:150px"><?=get_lang('service_table_porttype')?></td>
					  <td style="width:150px"><?=get_lang('service_table_status')?></td>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>

                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${col_id}"  data-id="${col_id}" data-ord="${col_index}">
                            <td><input type="checkbox" name="chk_Id" value="${name}"></td>
                            <td>${name}</td>
                            <td>${desc}</td>
                            <td>${port}</td>
							<td>${type}</td>
							<td><span class="${css}">${status_name}</span></td>
                        </tr>
                    </script>

	<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
<?php
if(ANT_MEETING)
{
?>
var service_data = [
//	{name:"RTC_DB_Service",port:"3399",type:"TCP",desc:"数据库服务器",status:-1},
	{name:"RTC_Main_Service",port:"6004",type:"TCP",desc:"<?=get_lang('service_data_main')?>",status:-1},
//	{name:"RTC_NetRelay_Service",port:"3283",type:"TCP",desc:"<?=get_lang('service_data_netrelay')?>",status:-1},
//	{name:"RTC_Site_Service",port:"98",type:"TCP",desc:"<?=get_lang('service_data_site')?>",status:-1},
	{name:"RTC_Upload_Service",port:"6005",type:"TCP",desc:"<?=get_lang('service_data_upload')?>",status:-1},
	{name:"RTC_Download_Service",port:"5995",type:"TCP",desc:"<?=get_lang('service_data_download')?>",status:-1},
	{name:"RTC_SetverPic_Service",port:"6006",type:"TCP",desc:"<?=get_lang('service_data_setverpic')?>",status:-1},
	{name:"RTC_Telnet_Service",port:"5994",type:"TCP",desc:"<?=get_lang('service_data_telnet')?>",status:-1},
//	{name:"RTC_Web_Service",port:"99",type:"TCP",desc:"asp web服务",status:-1},
	{name:"zlchat-server",port:"1935",type:"TCP",desc:"<?=get_lang('service_data_zlchat')?>",status:-1},
	{name:"RTC_Chat_Apache",port:"5080",type:"TCP",desc:"<?=get_lang('service_data_apache')?>",status:-1},
	{name:"RTC_Chat_MySQL",port:"3307",type:"TCP",desc:"<?=get_lang('service_data_mysql')?>",status:-1}

]
<?php
}
else
{
?>
var service_data = [
//	{name:"RTC_DB_Service",port:"3399",type:"TCP",desc:"数据库服务器",status:-1},
	{name:"RTC_Main_Service",port:"6004",type:"TCP",desc:"<?=get_lang('service_data_main')?>",status:-1},
//	{name:"RTC_NetRelay_Service",port:"3283",type:"TCP",desc:"<?=get_lang('service_data_netrelay')?>",status:-1},
//	{name:"RTC_Site_Service",port:"98",type:"TCP",desc:"<?=get_lang('service_data_site')?>",status:-1},
	{name:"RTC_Upload_Service",port:"6005",type:"TCP",desc:"<?=get_lang('service_data_upload')?>",status:-1},
	{name:"RTC_Download_Service",port:"5995",type:"TCP",desc:"<?=get_lang('service_data_download')?>",status:-1},
	{name:"RTC_SetverPic_Service",port:"6006",type:"TCP",desc:"<?=get_lang('service_data_setverpic')?>",status:-1},
	{name:"RTC_Telnet_Service",port:"5994",type:"TCP",desc:"<?=get_lang('service_data_telnet')?>",status:-1},
                ]
<?php
}
?>

$(document).ready(function(){
	load_list();
})
</script>