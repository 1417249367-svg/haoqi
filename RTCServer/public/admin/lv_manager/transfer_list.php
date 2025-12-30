<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_TRANSFER") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script type="text/javascript" src="../assets/js/livechat.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('transfer_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div>
                    <div class="pull-right">
				      <select  id="drp_status" class="form-control pull-left ws mr" style="width:auto;display:none;">
				        <option value=""><?=get_lang('lvchat_list_drop_status')?></option>
				        <option value="0"><?=get_lang('lvchat_list_drop_status0')?></option>
				        <option value="1"><?=get_lang('lvchat_list_drop_status1')?></option>
				        <option value="2"><?=get_lang('lvchat_list_drop_status2')?></option>
				      </select>
				      <select  id="field" class="form-control pull-left ws mr" style="width:auto;">
				        <option value="myid"><?=get_lang('transfer_list_original')?></option>
				        <option value="chater"><?=get_lang('transfer_list_now')?></option>
                        <option value="youid"><?=get_lang('lvchat_list_userid')?></option>
				      </select>
                      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('lvchat_list_txt_keywords')?>" />
                      <input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
                      <span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang('txt_to')?></span>
                      <input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
                    </div>

                    <div class="clear"></div> 
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_transfer" data-fldid="id" data-fldname="id"  data-fldlist="*" data-fldsort="id desc" data-fldsortdesc="id asc">
                    <thead>
                        <tr>
                        	<td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="chatid"><?=get_lang('lvchat_list_chatid')?></td>
                            <td data-sortfield="youid"><?=get_lang('lvchat_list_userid')?></td>
                            <td data-sortfield="myid"><?=get_lang('transfer_list_original')?></td>
                            <td data-sortfield="chater"><?=get_lang('transfer_list_now')?></td>
                            <td data-sortfield="to_type"><?=get_lang('transfer_list_type')?></td>
                            <td data-sortfield="todate"><?=get_lang('transfer_list_date')?></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${id}">
						<td><input type="checkbox" name="chk_Id" value="${id}"></td>
                        <td>${chatid}</td>
                        <td>${youid}</td>
                        <td>${myid}</td>
                        <td>${chater}</td>
                        <td>${to_type}</td>
						<td>${todate}</td>
                    </tr>
                </script>
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
    var fliter = "" ;
    var where = "" ;
    
    $(document).ready(function(){
        dataList = $("#datalist").attr("data-where",getSearchSql()).dataList(formatData);
    })
    
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            data[i].to_type = get_status_name(data[i].to_type) ;
			data[i].todate = toDate(data[i].todate,1) ;
        }
        return data ;
    }
    
    function get_status_name(status)
    {
        switch(parseInt(status))
        {
            case 1:
                return "<?=get_lang('transfer_list_type1')?>" ;
            case 2:
                return "<?=get_lang('transfer_list_type2')?>" ;
            case 3:
                return "<?=get_lang('transfer_list_type3')?>" ;
            default:
                return "" ;
        }
    }
    
    function getSearchSql()
    {
        var where = fliter ;
        var key =  $("#key").val() ;

        if(!compare_date($("#dt1").val(),$("#dt2").val()))
		{
        	myAlert("<?=get_lang('alert_date')?>");
			return;
		}

		if (key != "") where = getWhereSql(where,$("#field").val() + " like '%" + $("#key").val() + "%'") ;
        where = get_date_sql("todate",$("#dt1").val(),$("#dt2").val(),where) ;
		
		return where ;
    }
    
	function search(){
        dataList.search(getSearchSql()) ;
    }
</script>
