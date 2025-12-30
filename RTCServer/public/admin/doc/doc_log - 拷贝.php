<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","DOC_LOG") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1><?=get_lang("doc_log_title")?></h1></div>
			        <div class="searchbar">
                        <div class="pull-left">
							<input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
							<span class="pull-left" style="line-height:34px;padding:0px 5px;"><?=get_lang("txt_to")?></span>
							<input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">

                            <select id="search_field" class="form-control pull-left  mr" style="width:120px;">
                                <option value="Users_ID.FcName"><?=get_lang("field_user")?></option>
                                <option value="ServerLog.Txt"><?=get_lang("field_content")?></option>
                            </select>
                            <input type="text" class="form-control pull-left" id="key" style="width:200px;" placeholder="<?=get_lang("txt_search")?>">
                        </div> 
			        </div>
                    <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="ServerLog,Users_ID" data-fldid="ID" data-fldname="UserID"  data-fldlist="username,fcname,todate,txt,ip,ico,mac,id" data-fldsort="ID desc" data-fldSortdesc="ID" data-where="" >
                        <thead>
                            <tr>
                                <!--<td data-sortfield="col_id" style="width:300px;">ID</td>-->
                                <td data-sortfield="todate" style="width:150px;"><?=get_lang("field_time")?></td>
                                <td data-sortfield="fcname" style="width:150px;"><?=get_lang("field_user")?></td>
                                <td data-sortfield="ico" style="width:150px;"><?=get_lang("field_operate")?></td>
                                <td data-sortfield="txt"><?=get_lang("field_content")?></td>
                                <td data-sortfield="ip"><?=get_lang("log_list_table_ip")?></td>
                                <td data-sortfield="mac"><?=get_lang("log_list_table_mac")?></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${id}">
                            <!--<td>${col_id}</td>-->
                            <td>${col_dt_create}</td>
                            <td>${fcname}</td>
                            <td>${col_type_name}</td>
                            <td>${txt}</td>
							<td>${ip}</td>
							<td>${mac}</td>
                        </tr>
                    </script>				
					
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
    $(document).ready(function(){
		
        $("#dt1").val("<?=date("Y-m-d",time()-60*60*24*7) ?>");
        $("#dt2").val("<?=date("Y-m-d",time()) ?>");
		
        dataList = $("#datalist").attr("data-where",getDataWhere()).dataList(formatData);
        
        $("#key").keyup(function(){
            search();
        })
    })
    
	function formatData(data)
	{
        for (var i = 0; i < data.length; i++) {
            data[i].col_dt_create = data[i].todate ;
			data[i].col_type_name = getTypeName(data[i].ico) ;
        }
        return data ;
	}
	
	function getTypeName(type)
	{
		switch(type)
		{
			case "21":
				return "<?=get_lang("type_newfile")?>" ;
			case "22":
				return "<?=get_lang("type_downloadfile")?>" ;
			case "23":
				return "<?=get_lang("type_deletefile")?>" ;
			case "24":
				return "<?=get_lang("type_sharefile")?>" ;
			case "25":
				return "<?=get_lang("type_login")?>" ;
		}
	}

    function search(){
        var where = getDataWhere();
        dataList.search(where) ;
    }
    
    function getDataWhere()
    {

        var where = "" ;
        var key =  $("#key").val() ;

        if(!compare_date($("#dt1").val(),$("#dt2").val()))
		{
        	myAlert("<?=get_lang("alert_date")?>");
			return;
		}

        if (key != "")
            where = getWhereSql(where,"(" + $("#search_field").val() + " like '%" + key + "%' )") ;
            
        where = get_date_sql("ServerLog.todate",$("#dt1").val(),$("#dt2").val(),where,"<?=DB_TYPE?>") ;   
		where = getWhereSql(where,"ServerLog.UserID=Users_ID.UserID and ServerLog.To_Type=2" ) ;
        return where ;
    }

</script>
