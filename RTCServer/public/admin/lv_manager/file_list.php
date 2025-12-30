<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_ATTACH") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_file.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('file_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
		
                    <div class="pull-left">
                        <button class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div> 

                    <div class="pull-right">
				      <select  id="drp_flag" class="form-control pull-left ws mr" style="width:150px">
				        <option value="-1"><?=get_lang('file_list_dropdown_type-1')?></option>
				        <option value="2"><?=get_lang('file_list_dropdown_type1')?></option>
				        <option value="1"><?=get_lang('file_list_dropdown_type0')?></option>
				      </select>
				      <select  id="field" class="form-control pull-left ws mr" style="width:200px">
				        <option value="chater"><?=get_lang('file_list_filed_account')?></option>
				        <option value="username"><?=get_lang('file_list_filed_username')?></option>
				        <option value="chatid"><?=get_lang('file_list_filed_chatid')?></option>
				        <option value="filename"><?=get_lang('file_list_filed_filename')?></option>
				      </select>
				      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('file_list_ph_key')?>" />
                      <input type="text" class="form-control pull-left dateISO datepicker mr" data-date-format="yyyy-mm-dd"  id="dt" placeholder="<?=get_lang('file_list_ph_date')?>">
                      <button type="submit" class="btn btn-default pull-left" action-type="file_search" ><?=get_lang('btn_search')?></button>
                    </div> 
                    <div class="clear"></div>
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="lv_file" data-fldid="fileid" data-fldname="fileid"  data-fldlist="*" data-fldsort="fileid desc" data-fldsortdesc="fileid asc" >
                    <thead>
                        <tr>
                            <td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="chatid"><?=get_lang('file_list_table_chatid')?></td>
                            <td data-sortfield="filename"><?=get_lang('file_list_table_filename')?></td>
                            <td data-sortfield="username"><?=get_lang('file_list_table_username')?></td>
                            <td data-sortfield="chater"><?=get_lang('file_list_table_chater')?></td>
                            <td data-sortfield="createtime" style="width:150px"><?=get_lang('file_list_table_createdate')?></td>
                            <td style="width:80px"></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${fileid}">
                        <td><input type="checkbox" name="chk_Id" value="${fileid}"></td>
                        <td>${chatid}</td>
                        <td><a href="###" onclick="getFile(${flag},'${filepath}')">${filename}</a></td>
                        <td>${username}</td>
                        <td>${chater}</td>
                        <td><small>${createtime}</small></td>
						<td>
							<a href="javascript:void(0);" action-data="${fileid}" action-type="file_edit"><?=get_lang('file_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${fileid}" action-type="file_delete" ><?=get_lang('file_list_delete')?></a>
						</td>
                    </tr>
                </script>
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>


<script type="text/javascript">
    var dataList ;
    var fliter = "" ;
    var where = "" ;
    var field = "<?=g("field") ?>" ;
    var key = "<?=g("key") ?>" ;
    var appPath = "<?=getRootPath() ?>"; 
	
    $(document).ready(function(){
    
        if (field != "")
        {
            $("#field").val(field);
            $("#key").val(key);
        }
 
        dataList = $("#datalist").attr("data-where",getSearchSql()).dataList(formatData);
    })
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
			data[i].createtime = toDate(data[i].createtime,1) ;
        }
        return data ;
    }
	
	function getFile(flag,fileUrl)
	{
		//if (flag == 2)
			window.open(fileUrl) ;
//		else
//			downloadFile(fileUrl) ;
	}
	
	function downloadFile(fileUrl)
	{
		$.ajax({
		   type: "POST",
		   dataType:"json",
		   url: fileUrl,
		   success: function(result){
				if (result.status)
					location.href = getAjaxUrl("download","down","file=" + result.msg) ;
				else
					myAlert(result.msg);
		   },
		   error: function(result){
			   myAlert("<?=get_lang('file_list_alert')?>");   
		   }
		});
	}
</script>
