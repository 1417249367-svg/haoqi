<?php  require_once("../include/fun.php");?>
<?php
define("MENU","LIVECHAT_CHATER") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat.js"></script>
    <script src="/static/js/msg_reader.js"></script>
    <script src="/static/js/ckeditor/ckeditor.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('chater_list_title')?></h1></div>

				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="chater_edit"><?=get_lang('chater_list_add')?></button>
                        <button type="button" class="btn btn-default" action-type="chater_delete"><?=get_lang('chater_list_deleteoperate')?></button>
                        <button type="button" class="btn btn-default" onClick="doc_share1()"><?=get_lang('chater_list_link')?></button>
                        <button type="button" class="btn btn-default" onClick="doc_js1()"><?=get_lang('chater_list_js')?></button>
                        <button type="button" class="btn btn-default" onClick="doc_qrcode1()"><?=get_lang('chater_list_qrcode')?></button>
                    </div>
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('chater_list_search')?>" >
                    </div>
				</div>
				<!--End SearchBar-->

				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="lv_chater" data-fldid="id"  data-fldname="loginname"  data-fldlist="*" data-fldsort="ord ,id" data-fldsortdesc="ord desc,id desc" >
                    <thead>
                        <tr>
                            <td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="loginname"><?=get_lang('chater_list_account')?></td>
                            <td data-sortfield="username"><?=get_lang('chater_list_name')?></td>
                            <td data-sortfield="deptname"><?=get_lang('chater_list_dept')?></td>
                            <td data-sortfield="jobtitle"><?=get_lang('chater_list_job')?></td>
                            <td data-sortfield="phone"><?=get_lang('chater_list_tel')?></td>
                            <td data-sortfield="mobile"><?=get_lang('chater_list_mobile')?></td>
                            <td data-sortfield="email"><?=get_lang('chater_list_email')?></td>
                            <td data-sortfield="welcome" style="width:150px"><?=get_lang('chater_list_welcome')?></td>
                            <td data-sortfield="status"><?=get_lang('chater_list_status')?></td>
                            <td data-sortfield="ord"><?=get_lang('chater_list_order')?></td>
                            <td style="width:80px"></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${id}" data-id="${id}" data-ord="${ord}">
                        <td><input type="checkbox" name="chk_Id" value="${id}"></td>
                        <td>
                            <img src="${picture}" style="width:20px;height:20px;" class="photo">
                            <a href="javascript:void(0);" action-data="${id}" action-type="chater_edit">${loginname}</a>
                        </td>
                        <td>${username}</td>
                        <td>${deptname}</td>
                        <td>${jobtitle}</td>
                        <td>${phone}</td>
                        <td>${mobile}</td>
                        <td>${email}</td>
                        <td>${welcome}</td>
                        <td><a href="javascript:void(0);" class="icon-check${status}" data-value="${status}" action-data="${id},'status',this"  action-type="dataList.setSwitch"></a></td>
                        <td>${ord}</td>
						<td style="width:250px">
						    <a href="javascript:void(0);" onclick="doc_share('${loginname}',this)"><?=get_lang('chater_list_link')?></a>
							<a href="javascript:void(0);" onclick="doc_js('${loginname}',this)"><?=get_lang('chater_list_js')?></a>
							<a href="javascript:void(0);" onclick="doc_qrcode('${loginname}','${username}','${picture}',this)" ><?=get_lang('chater_list_qrcode')?></a>
						    <a href="rate_list.html?field=chater&key=${loginname}"><?=get_lang('chater_list_rate')?></a>
							<a href="javascript:void(0);" action-data="${id}" action-type="chater_edit"><?=get_lang('chater_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${id}" action-type="chater_delete" ><?=get_lang('chater_list_delete')?></a>
							<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapUp" title="<?=get_lang('chater_list_up')?>"><?=get_lang('chater_list_up')?></a>
							<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapDown" title="<?=get_lang('chater_list_down')?>"><?=get_lang('chater_list_down')?></a>
						</td>
                    </tr>
                </script>
<input type="text" id="texturl" style="width:10px;display:none"/>
	<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
    var ipaddress = "<?=IPADDRESS ?>";
	var site_address = "<?=getRootPath() ?>";
    var webPort = "<?=$_SERVER['SERVER_PORT']?>";
    var appPath = "<?=getRootPath() ?>";
	var defaultImg = appPath + "/livechat/assets/img/default.png" ;
    $(document).ready(function(){
        dataList = $("#datalist").dataList(formatData,listCallBack);
        $("#key").keyup(function(){
            search();
        })
    })

	function formatData(data)
	{
		return data ;
	}

	function listCallBack()
	{
		$(".photo").bind("error",function(){
			this.src= defaultImg;
		});
	}

	function search(){
        var where = "" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"(username like '%" + key + "%' or loginname like '%" + key + "%')") ;
        dataList.search(where) ;
    }

</script>

