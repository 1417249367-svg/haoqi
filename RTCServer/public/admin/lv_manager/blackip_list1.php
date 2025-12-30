<?php  require_once("../include/fun1.php");?>
<?php  
define("MENU","LIVECHAT_BLACKIP") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_blackip.js"></script>
</head>
<body>
				<div class="page-header"><h1><?=get_lang('blackip_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div>
                    <div class="pull-right">
				      <select  id="field" class="form-control pull-left ws mr" style="width:150px">
				        <option value="youid"><?=get_lang('blackip_list_option_userid')?></option>
				      </select>
                      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('blackip_list_ph_key')?>" />
                      <input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
                      <span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang('txt_to')?></span>
                      <input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
					</div>
					<div class="clear"></div>
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-ispage="1" data-table="Clot_Silence" data-fldid="TypeID" data-fldname="TypeID"  data-fldlist="*" data-fldsort="TypeID desc" data-fldsortdesc="TypeID asc">
                    <thead>
                        <tr>
                        	<td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="youid"><?=get_lang('blackip_list_option_userid')?></td>
                            <td data-sortfield="myid"><?=get_lang('blackip_list_table_operator')?></td>
                            <td data-sortfield="uname"><?=get_lang('user_list_table_name')?></td>
                            <td data-sortfield="phone"><?=get_lang('user_list_table_phone')?></td>
                            <td data-sortfield="statusname"><?=get_lang('addin_list_table_type')?></td>
                            <td data-sortfield="to_ip"><?=get_lang('server_list_ip')?></td>
                            <td data-sortfield="ncontent"><?=get_lang('blackip_list_table_des')?></td>
                            <td data-sortfield="username"><?=get_lang('blackip_list_table_date')?></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${userid}" class="">
						<td><input type="checkbox" name="chk_Id" value="${typeid}"></td>
                        <td><a href="javascript:void(0);" action-data="${typeid}" action-type="blackip_edit">${youid}</a></td>
                        <td>${username}</td>
						<td>${uname}</td>
						<td>${phone}</td>
						<td>${statusname}</td>
                        <td>${to_ip}</td>
                        <td>${ncontent}</td>
                        <td><small>${to_date}</small></td>
						<td>
							<a href="javascript:void(0);" action-data="${typeid}" action-type="blackip_edit"><?=get_lang('question_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${typeid}" action-type="blackip_delete" ><?=get_lang('question_list_delete')?></a>
						</td>
                    </tr>
                </script>				
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
    var fliter = " where (To_Type=3 or To_Type=6)" ;
    var where = "" ;
    var field = "<?=g("field") ?>" ;
    var key = "<?=g("key") ?>" ;
    
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
			data[i].to_date = toDate(data[i].to_date,1) ;
			if(parseInt(data[i].to_type)==3) data[i].statusname = langs.livechat_blackip_to_type3 ;
			else data[i].statusname = langs.livechat_blackip_to_type6 ;
        }
        return data ;
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
		where = getWhereSql(where,"MyID='<?=CurUser::getUserId() ?>'") ;
        where = get_date_sql("TO_Date",$("#dt1").val(),$("#dt2").val(),where) ;
		
		return where ;
    }
    
	function search(){
        dataList.search(getSearchSql()) ;
    }
	
    function blackip_getCallBack(data)
    {
		$(".form-group").eq(1).hide();

    }
	
//	function data_edit(id,_name)
//	{
//		$(".modal").remove() ; //以免与USERPICKER冲突
//		if (id == undefined)
//			id = "" ;
//		if (_name == undefined)
//			_name = "" ;
//	
//		var title = (id == ""?langs.livechat_blackip_create:langs.livechat_blackip_edit) ;
//		var url = "../lv_manager/blackip_edit.html?" + (id == ""?"":"groupid=" + id ) + "&groupname=" + escape(_name) ;
//		dialog("blackip",title ,url,{width:0,height:350,isClear:true}) ;
//	}
</script>