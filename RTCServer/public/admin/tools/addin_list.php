<?php  require_once("../include/fun.php");?>
<?php
define("MENU","ADDIN") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/acepicker.js"></script>
	<script type="text/javascript" src="../assets/js/addin.js"></script>
    <script type="text/javascript" src="../assets/js/import.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1><?=get_lang('addin_list_title')?></h1></div>
			        <div class="searchbar">
			            <div class="pull-left">
                            <button type="button" class="btn btn-default" action-type="import_addin"><?=get_lang('addin_list_btn_import')?></button>
			                <button type="button" class="btn btn-default" action-type="addin_edit"><?=get_lang('addin_list_btn_add')?></button>
			                <button type="button" class="btn btn-default" action-type="addin_ace"><?=get_lang('addin_list_btn_permission')?></button>
			                <button type="button" class="btn btn-default" action-type="addin_delete"><?=get_lang('addin_list_btn_delete')?></button>
			            </div>
                        <div class="pull-right">
                            <!--<select id="search_type" class="form-control pull-left mr" style="width:120px;" onchange="search()">
                                <option value="">选择类型</option>
                                <option value="1">命令插件</option>
                                <option value="2">视图插件</option>
                            </select>-->
                            <input type="text" class="form-control pull-left mr" id="key" style="width:200px;" placeholder="<?=get_lang('addin_list_btn_search')?>">
                        </div>
			        </div>
                    <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-obj="addin" data-table="Plug" data-fldid="Plug_ID"  data-fldord="Plug_Index" data-fldname="Plug_Name"  data-fldlist="Plug_ID,Plug_Site,Plug_Bie,Plug_Name,Plug_Enabled,Plug_Desc,Plug_Index" data-fldsort="Plug_Index,Plug_ID" data-fldsortdesc="Plug_Index desc,Plug_ID desc" data-where="" >
                        <thead>
                            <tr>
                                <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="plug_site" style="width:150px"><?=get_lang('addin_list_table_type')?></td>
                                <td data-sortfield="plug_name" style="width:200px"><?=get_lang('addin_list_table_name')?></td>
                                <td data-sortfield="plug_enabled" style="width:80px"><?=get_lang('addin_list_table_disable')?></td>
                                <td data-sortfield="plug_desc"><?=get_lang('addin_list_table_desc')?></td>
                                <td data-sortfield="plug_index"  style="width:80px"><?=get_lang('addin_list_table_sequence')?></td>
                                <td class="col-op" style="width:170px"></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${plug_id}"  data-id="${plug_id}" data-ord="${plug_index}" data-bie="${plug_bie}">
                            <td><input type="checkbox" name="chk_Id" value="${plug_id}"></td>
                            <td>${plug_site}</td>
                            <td><a href="javascript:void(0);" onclick="addin_edit(${plug_id})">${plug_name}</a></td>
							<td><a href="#" class="icon_check${plug_enabled} btn_disabled" data-value="${plug_enabled}" action-data="${plug_id},'plug_enabled',this"  action-type="dataList.setSwitch"></a></td>
                            <td>${plug_desc}</td>
                            <td>${plug_index}</td>
                            <td class="col-op">
                                <a href="javascript:void(0);" onclick="addin_edit(${plug_id})"><?=get_lang('addin_list_table_edit')?></a>
                                <a href="javascript:void(0);" onclick="addin_ace(${plug_id})"><?=get_lang('addin_list_table_permission')?></a>
                                <a href="javascript:void(0);" onclick="addin_delete(${plug_id})" class="btn_delete"><?=get_lang('addin_list_table_del')?></a>
								<a href="javascript:void(0);" action-data="'plug_index','data-ord',this" action-type="dataList.swapUp" title="<?=get_lang('addin_list_table_up')?>"><?=get_lang('addin_list_table_up')?></a>
								<a href="javascript:void(0);" action-data="'plug_index','data-ord',this" action-type="dataList.swapDown" title="<?=get_lang('addin_list_table_down')?>"><?=get_lang('addin_list_table_down')?></a>
                            </td>
                        </tr>
                    </script>
				<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">


    var dataList ;
	var objEmpType = "<?=EMP_ADDIN?>";
    $(document).ready(function(){
        dataList = $("#datalist").dataList(formatData,listCallBack);

        $("#key").keyup(function(){
            search();
        })
    })

   function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
			switch (data[i].plug_site) {
			case "0":
			data[i].plug_site = "<?=get_lang('addin_plug_site0')?>" ;
			break;
			case "1":
			data[i].plug_site = "<?=get_lang('addin_plug_site1')?>" ;
			break;
			case "2":
			data[i].plug_site = "<?=get_lang('addin_plug_site2')?>" ;
			break;
			case "3":
			data[i].plug_site = "<?=get_lang('addin_plug_site3')?>" ;
			break;
			case "4":
			data[i].plug_site = "<?=get_lang('addin_plug_site4')?>" ;
			break;
			case "5":
			data[i].plug_site = "<?=get_lang('addin_plug_site5')?>" ;
			break;
			case "6":
			data[i].plug_site = "<?=get_lang('addin_plug_site6')?>" ;
			break;
			case "7":
			data[i].plug_site = "<?=get_lang('addin_plug_site7')?>" ;
			break;
			case "8":
			data[i].plug_site = "<?=get_lang('addin_plug_site8')?>" ;
			break;
			case "9":
			data[i].plug_site = "<?=get_lang('addin_plug_site9')?>" ;
			break;
			case "10":
			data[i].plug_site = "<?=get_lang('addin_plug_site10')?>" ;
			break;
			case "11":
			data[i].plug_site = "<?=get_lang('addin_plug_site11')?>" ;
			break;
			case "12":
			data[i].plug_site = "<?=get_lang('addin_plug_site12')?>" ;
			break;
			case "13":
			data[i].plug_site = "<?=get_lang('addin_plug_site13')?>" ;
			break;
			case "14":
			data[i].plug_site = "<?=get_lang('addin_plug_site14')?>" ;
			break;
			}
        }
        return data ;
    }

	function listCallBack()
	{
		$("tr[data-bie=0]").each(function(){
			$("input[type=checkbox]",this).remove();
			$(".btn_delete",this).remove();
			$(".btn_delete",this).each(function(){
				$(this).unbind("click");
				$(this).click(function(){
					myAlert("<?=get_lang('addin_plug_warning1')?>");
				})
			})
			
		})
	}
	
    function search(){
        var where = "" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"( Plug_Name like '%" + key + "%' or Plug_DisplayName like '%" + key + "%' )") ;

        var type = $("#search_type").val() ;
//        if (type != "")
//            where = getWhereSql(where,"col_addintype=" + type ) ;
        dataList.search(where) ;
    }

    function addin_edit(id)
    {
        if (id == undefined)
            id = "" ;
        var title = (id == ""?"<?=get_lang('addin_list_add')?>":"<?=get_lang('addin_list_edit')?>") ;
        var url = "addin_edit.html" + (id == ""?"":"?id=" + id )
        dialog("addin",title ,url) ;
    }

    function addin_delete(_id)
    {
	    id = getSelectedId(_id) ;

	    if (id == "")
		    return ;

	    if (confirm("<?=get_lang('alert_delconfirm')?>"))
		    dataList.del(id) ;
    }

    function addin_ace(_objId)
    {
	    objId = getSelectedId(_objId) ;
	    if (objId == "")
		    return ;

	    ace_picker(objEmpType,objId,'AddinAce','RTCAce');
    }

    function addin_import(_file)
	{
	   showLoading();
	   var url = getAjaxUrl("addin","import","file=/install/addin/" + _file) ;
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
				if (result.status)
					dataList.reload();
				else
					myAlert(result.msg);
				hideLoading();
		   }
	   });
	}

</script>