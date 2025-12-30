<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_RATE") ;
$db = new Model("lv_chater_ro");
$data = $db -> getList();
$html = '<option value="">'.get_lang('lvchat_list_groupid').'</option>';
$html .= '<option value="0">'.get_lang('lvchat_list_not').'</option>';
foreach($data as $k=>$v){
	$html .='<option value="'.$data[$k]['typeid'].'">'.$data[$k]['typename'].'</option>';
}
$db = new Model("lv_chater_theme");
$data = $db -> getList();
$html1 = '<option value="">'.get_lang('lvchat_list_themeid').'</option>';
$html1 .= '<option value="0">'.get_lang('lvchat_list_chatlevel0').'</option>';
foreach($data as $k=>$v){
	$html1 .='<option value="'.$data[$k]['typeid'].'">'.$data[$k]['typename'].'</option>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/group.js"></script>
	<script type="text/javascript" src="../assets/js/userpicker.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('rate_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div>
                    <div class="pull-right">
				      <select  id="groupid" class="form-control pull-left ws mr" style="width:auto;">
                      <?=$html?>
				      </select>
				      <select  id="themeid" class="form-control pull-left ws mr" style="width:auto;">
                      <?=$html1?>
				      </select>
				      <select  id="chatlevel" class="form-control pull-left ws mr" style="width:auto;">
                        <option value=""><?=get_lang('lvchat_list_chatlevel')?></option>
                        <option value="0"><?=get_lang('lvchat_list_chatlevel0')?></option>
                        <option value="1"><?=get_lang('lvchat_list_chatlevel1')?></option>
                        <option value="2"><?=get_lang('lvchat_list_chatlevel2')?></option>
				      </select>
				      <select  id="field" class="form-control pull-left ws mr" style="width:150px">
				        <option value="chater"><?=get_lang('rate_list_option_account')?></option>
				        <option value="username"><?=get_lang('rate_list_option_username')?></option>
				        <option value="userid"><?=get_lang('rate_list_option_userid')?></option>
				      </select>
                      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('rate_list_ph_key')?>" />
                      
                      <input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
                      <span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang('txt_to')?></span>
                      <input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">
                      
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
					</div>
					<div class="clear"></div>
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-ispage="1" data-table="lv_chat" data-fldid="chatid" data-fldname="chatid"  data-fldlist="*" data-fldsort="chatid desc" data-fldsortdesc="chatid asc">
                    <thead>
                        <tr>
                        	<td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="chatid"><?=get_lang('rate_list_table_chatid')?></td>
                            <td data-sortfield="groupid"><?=get_lang('lvchat_list_groupname')?></td>
                            <td data-sortfield="chater"><?=get_lang('rate_list_table_operator')?></td>
                            <td data-sortfield="userid"><?=get_lang('rate_list_table_userid')?></td>
                            <td data-sortfield="username"><?=get_lang('rate_list_table_name')?></td>
                            <td data-sortfield="themeid"><?=get_lang('lvchat_list_themename')?></td>
                            <td data-sortfield="chatlevel"><?=get_lang('lvchat_list_chatlevelname')?></td>
                            <td data-sortfield="rate"><?=get_lang('rate_list_table_score')?></td>
                            <td data-sortfield="ratenote"><?=get_lang('rate_list_table_des')?></td>
                            <td data-sortfield="intime"><?=get_lang('rate_list_table_date')?></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${chatid}" class="">
						<td><input type="checkbox" name="chk_Id" value="${chatid}"></td>
                        <td>${chatid}</td>
						<td>${grouptypename}</td>
                        <td>${chater}</td>
                        <td>${userid}</td>
                        <td>${username}</td>
						<td>${themetypename}</td>
						<td>${chatlevel_name}</td>
                        <td>${rate}</td>
                        <td>${ratenote}</td>
                        <td><small>${intime}</small></td>
                    </tr>
                </script>				
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
    var fliter = " where rate>0 " ;
    var where = "" ;
    var field = "<?=g("field") ?>" ;
    var key = "<?=g("key") ?>" ;
    var groupid = "<?=g("groupid") ?>" ;
    var chater = "<?=g("chater") ?>" ;
    var themeid = "<?=g("themeid") ?>" ;
    var chatlevel = "<?=g("chatlevel") ?>" ;
	var isenable = "<?=g("isenable") ?>" ;
	var dt1 = "<?=g("dt1") ?>" ;
	var dt2 = "<?=g("dt2") ?>" ;
    
    $(document).ready(function(){
    
        if (field != "")
        {
            $("#field").val(field);
            $("#key").val(key);
        }
		if (groupid != "") $("#groupid").val(groupid);
		if (themeid != "") $("#themeid").val(themeid);
		if (chatlevel != "") $("#chatlevel").val(chatlevel);
		if (dt1 != "") $("#dt1").val(dt1);
		if (dt2 != "") $("#dt2").val(dt2);
		
		if (chater != ""){
			 $("#field").val("chater");
			 $("#key").val(chater);
		}
        
        dataList = $("#datalist").attr("data-where",getSearchSql()).dataList(formatData);
    })
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            data[i].ratenote = unescape(data[i].ratenote);
			data[i].intime = toDate(data[i].intime,1) ;
			data[i].chatlevel_name = get_chatlevel_name(data[i].chatlevel) ;
			data[i].rate = get_rate(data[i].rate) ;
        }
        return data ;
    }
	
    function get_chatlevel_name(status)
    {
        switch(status)
        {
            case "0":
                return "<?=get_lang('lvchat_list_chatlevel0')?>" ;
            case "1":
                return "<?=get_lang('lvchat_list_chatlevel1')?>" ;
            case "2":
                return "<?=get_lang('lvchat_list_chatlevel2')?>" ;
            default:
                return "" ;
        }
    }
	
    function get_rate(status)
    {
        switch(parseInt(status))
        {
            case 1:
                return "<?=get_lang('chart_rate_unit1')?>" ;
            case 2:
                return "<?=get_lang('chart_rate_unit2')?>" ;
            case 3:
                return "<?=get_lang('chart_rate_unit3')?>" ;
            case 4:
                return "<?=get_lang('chart_rate_unit4')?>" ;
            case 5:
                return "<?=get_lang('chart_rate_unit5')?>" ;
            default:
                return "<?=get_lang('chart_rate_unit0')?>" ;
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

        if ($("#groupid").val() != "") where = getWhereSql(where,"groupid = " + $("#groupid").val()) ;
		if ($("#themeid").val() != "") where = getWhereSql(where,"themeid = " + $("#themeid").val()) ;
		if ($("#chatlevel").val() != "") where = getWhereSql(where,"chatlevel = " + $("#chatlevel").val()) ;
		if (key != "") where = getWhereSql(where,$("#field").val() + " like '%" + $("#key").val() + "%'") ;
        where = get_date_sql("intime",$("#dt1").val(),$("#dt2").val(),where) ;
		
		return where ;
    }
    
    
	function search(){
        dataList.search(getSearchSql()) ;
    }
</script>