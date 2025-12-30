<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_MESSAGE") ;
$db = new Model("lv_chater_ro");
$data = $db -> getList();
$html = '<option value="">'.get_lang('message_list_groupid').'</option>';
$html .= '<option value="0">'.get_lang('message_list_not').'</option>';
foreach($data as $k=>$v){
	$html .='<option value="'.$data[$k]['typeid'].'">'.$data[$k]['typename'].'</option>';
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
				<div class="page-header"><h1><?=get_lang('message_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div>
                    <div class="pull-right">
				      <select  id="groupid" class="form-control pull-left ws mr" style="width:auto;">
                      <?=$html?>
				      </select>
				      <select  id="field" class="form-control pull-left ws mr" style="width:200px">
                        <option value="chater"><?=get_lang('lvchat_list_field_account')?></option>
				        <option value="username"><?=get_lang('message_list_option_username')?></option>
				        <option value="phone"><?=get_lang('message_list_option_phone')?></option>
				        <option value="email"><?=get_lang('message_list_option_email')?></option>
				        <option value="usertext"><?=get_lang('message_list_option_content')?></option>
				        <option value="userid"><?=get_lang('message_list_option_userid')?></option>
				      </select>
                      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('message_list_ph_key')?>" />
                      <input type="text" class="form-control pull-left dateISO datepicker mr" data-date-format="yyyy-mm-dd"  id="dt" placeholder="<?=get_lang('message_list_ph_date')?>">
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
					</div>
					<div class="clear"></div>
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-obj="livechat_kf" data-table="lv_message" data-fldid="id" data-fldname="id"  data-fldlist="*" data-fldsort="id desc" data-fldsortdesc="id asc" >
                    <thead>
                        <tr>
                        	<td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td style="width:80px;"><?=get_lang('message_list_table_source')?></td>
                            <td data-sortfield="username" style="width:80px;"><?=get_lang('message_list_table_username')?></td>
                            <td data-sortfield="phone" style="width:80px;"><?=get_lang('message_list_table_phone')?></td>
                            <td data-sortfield="email" style="width:150px;"><?=get_lang('message_list_table_email')?></td>
                            <td data-sortfield="createtime" style="width:150px;"><?=get_lang('message_list_table_createtime')?></td>
                            <td data-sortfield="usertext"><?=get_lang('message_list_table_note')?></td>
                            
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${id}">
						<td><input type="checkbox" name="chk_Id" value="${id}"></td>
						<td>${typename}</td>
                        <td>${username}</td>
                        <td>${phone}</td>
                        <td>${email}</td>
                        <td><small>${createtime}</small></td>
                        <td>${usertext}</td>
                        
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
            data[i].usertext = replaceAll( data[i].usertext,"<br>","") ;
			data[i].createtime = toDate(data[i].createtime,1) ;
        }
        return data ;
    }
    
    function getSearchSql()
    {
        var where = fliter ;

        if ($("#groupid").val() != ""){
			 where = getWhereSql(where,"groupid = " + $("#groupid").val()) ;
			 if ($("#groupid").val() == "0") where = getWhereSql(where,"Chater = ''") ;
		}
		if ($("#key").val() != "")
            where = getWhereSql(where,$("#field").val() + " like '%" + $("#key").val() + "%'") ;

        where = get_date_sql("createtime",$("#dt").val(),$("#dt").val(),where) ;   

        return where ;
    }
    
	function search(){
        dataList.search(getSearchSql()) ;
    }


</script>

