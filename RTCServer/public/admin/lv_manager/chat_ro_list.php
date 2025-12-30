<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_CHAT_RO") ;
$db = new Model("lv_chater_ro");
$data = $db -> getList();
$html = '<option value="0">'.get_lang('lvchat_list_not').'</option>';
foreach($data as $k=>$v){
	$html .='<option value="'.$data[$k]['typeid'].'">'.$data[$k]['typename'].'</option>';
}
$db = new Model("lv_chater_theme");
$data = $db -> getList();
$html1 = '<option value="0">'.get_lang('lvchat_list_chatlevel0').'</option>';
foreach($data as $k=>$v){
	$html1 .='<option value="'.$data[$k]['typeid'].'">'.$data[$k]['typename'].'</option>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
    <script type="text/javascript" src="../assets/js/livechat.js"></script>
    <style>
		
        .status-0 td,.status-0{background-color:#fff;}
        .status-1 td,.status-1{background-color:#fff;}
        .status-2 td,.status-2{background-color:#fff;}
        
        .note-list li{float:left;list-style-type:none;margin-right:10px;}
        .note-list span{border:1px solid #ccc;border-radius:4px;padding:0px 8px;font-size:10px;margin:0px 5px;  }
    </style>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('menu_sub_dialog_analysis')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-right">
				      <select  id="drp_status" class="form-control pull-left ws mr" style="width:auto;display:none;">
				        <option value=""><?=get_lang('lvchat_list_drop_status')?></option>
				        <option value="0"><?=get_lang('lvchat_list_drop_status0')?></option>
				        <option value="1"><?=get_lang('lvchat_list_drop_status1')?></option>
				        <option value="2"><?=get_lang('lvchat_list_drop_status2')?></option>
				      </select>
				      <select  id="groupid" multiple class="form-control pull-left ws mr" style="width:auto;">
                      <?=$html?>
				      </select>
				      <select  id="drp_type" class="form-control pull-left ws mr" style="width:auto;">
                        <option value="0"><?=get_lang('lvchat_list_drp_type0')?></option>
                        <option value="1"><?=get_lang('lvchat_list_drp_type1')?></option>
                        <option value="2"><?=get_lang('lvchat_list_drp_type2')?></option>
				      </select>
				      <select  id="themeid" multiple class="form-control pull-left ws mr" style="width:auto;display:none;">
                      <?=$html1?>
				      </select>
				      <select  id="chatlevel" multiple class="form-control pull-left ws mr" style="width:auto;display:none;">
                        <option value="0"><?=get_lang('lvchat_list_chatlevel0')?></option>
                        <option value="1"><?=get_lang('lvchat_list_chatlevel1')?></option>
                        <option value="2"><?=get_lang('lvchat_list_chatlevel2')?></option>
				      </select>
				      <select  id="isenable" class="form-control pull-left ws mr" style="width:auto;">
                        <option value=""><?=get_lang('lvchat_list_no')?></option>
                        <option value="0"><?=get_lang('lvchat_list_isenable1')?></option>
                        <option value="1"><?=get_lang('lvchat_list_isenable2')?></option>
				      </select>
                      <input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
                      <span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang('txt_to')?></span>
                      <input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
                    </div>

                    <div class="clear"></div> 
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-obj="livechat_kf" data-tmpid="tmpl_list" data-table="lv_chat" data-fldid="chatid" data-fldname="chatid"  data-fldlist="*" data-fldsort="chatid desc" data-fldsortdesc="chatid asc">
                    <thead>
                        <tr>
                            <td><?=get_lang('lvchat_list_groupname')?></td>
                            <td><?=get_lang('lvchat_list_uname')?></td>
                            <td><?=get_lang('lvchat_list_rates')?></td>
                            <td><?=get_lang('lvchat_list_groupcount')?></td>
                            <td><?=get_lang('lvchat_list_percent')?></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr>
                        <td>${typename}</td>
						<td>${username}</td>
						<td><a href="javascript:void(0);" onclick="toRateList('${groupid}','${uid}')">${rate}</a></td>
                        <td>${groupcount}</td>
                        <td>${percent}</td>
                        <td style="width:80px">
                            <a href="javascript:void(0);" onclick="toChatList('${groupid}','${uid}')"><?=get_lang('lvchat_list_detail')?></a>
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
    
    $(document).ready(function(){ 
        dataList = $("#datalist").attr("data-where",getSearchSql()).attr("data-query","op=listchatro&drp_type=" + $("#drp_type").val()).dataList(formatData);
		$("#drp_type").change(function(){
			switch(parseInt($("#drp_type").val()))
			{
				case 0:
					$("#isenable").show();
					$("#themeid").hide();
					$("#chatlevel").hide();
					break;
				case 1:
					$("#isenable").hide();
					$("#themeid").show();
					$("#chatlevel").hide();
					break;
				case 2:
					$("#isenable").hide();
					$("#themeid").hide();
					$("#chatlevel").show();
					break;
			}
		})
    })
	
    function toChatList(groupid,uid)
    {
		var url="chat_list.html?groupid="+groupid+"&dt1="+$("#dt1").val()+"&dt2="+$("#dt2").val();
		switch(parseInt($("#drp_type").val()))
		{
			case 0:
				if ($("#isenable").val()) url+="&isenable=" + $("#isenable").val() ;
				url +="&chater=" + uid; 
				break;
			case 1:
				url +="&themeid=" + uid; 
				break;
			case 2:
				url +="&chatlevel=" + uid; 
				break;
		}
		//alert(url);
		location.href = url ;
    }
	
	
    function toRateList(groupid,uid)
    {
		var url="rate_list.html?groupid="+groupid+"&dt1="+$("#dt1").val()+"&dt2="+$("#dt2").val();
		switch(parseInt($("#drp_type").val()))
		{
			case 0:
				url +="&chater=" + uid; 
				break;
			case 1:
				url +="&themeid=" + uid; 
				break;
			case 2:
				url +="&chatlevel=" + uid; 
				break;
		}
		location.href = url ;
    }
    
    function formatData(data)
    {
		for (var i = 0; i < data.length; i++) {
            data[i].percent = Percentage(data[i].groupcount, data[i].totalcount) ;
			data[i].rate = get_rate(Math.round(data[i].rate)) ;
//			data[i].first_inouttime = formatSeconds(data[i].first_inouttime) ;
//			data[i].inouttime = formatSeconds(data[i].inouttime) ;
//			data[i].chat_time = formatSeconds(data[i].chat_time) ;
        }
        return data ;
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
	
	function Percentage(num, total) { 
		if (num == 0 || total == 0){
			return 0;
		}
		return (Math.round(num / total * 10000) / 100.00);// 小数点后两位百分比
	}
    
    function getSearchSql()
    {
        var where = fliter ;

        if(!compare_date($("#dt1").val(),$("#dt2").val()))
		{
        	myAlert("<?=get_lang('alert_date')?>");
			return;
		}

        if ($("#groupid").val()) where = getWhereSql(where,"groupid in (" + $("#groupid").val() + ")") ;
        where = get_date_sql("intime",$("#dt1").val(),$("#dt2").val(),where) ;
		switch(parseInt($("#drp_type").val()))
		{
			case 0:
				if ($("#isenable").val()) where = getWhereSql(where,"isenable = " + $("#isenable").val()) ;
				where +=" group by groupid,Chater"; 
				break;
			case 1:
				if ($("#themeid").val()) where = getWhereSql(where,"themeid in (" + $("#themeid").val() + ")") ;
				where +=" group by groupid,themeid"; 
				break;
			case 2:
				if ($("#chatlevel").val()) where = getWhereSql(where,"chatlevel in (" + $("#chatlevel").val() + ")") ;
				where +=" group by groupid,chatlevel"; 
				break;
		}
		return where ;
    }
    
	function search(){
		dataList.query("op=listchatro&drp_type=" + $("#drp_type").val()) ;
        dataList.search(getSearchSql()) ;
    }


</script>
