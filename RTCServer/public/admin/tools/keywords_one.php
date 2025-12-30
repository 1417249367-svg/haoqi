<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","EXTEND") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/acepicker.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1><?=get_lang('ext_list_title')?></h1></div>
			        <div class="searchbar">
			            <div class="pull-left">
			                <input type="button" class="btn btn-default" action-type="ext_edit_cus" value="<?=get_lang('ext_list_btn_add_custom')?>" />
			                 <input type="button" class="btn btn-default" action-type="ext_edit_sys" value="<?=get_lang('ext_list_btn_add_sys')?>" />
                            <input type="button" class="btn btn-default" action-type="ext_bulid" value="<?=get_lang('ext_list_btn_bulid')?>" />
			            </div> 
                        <div class="pull-right">
                            <input type="text" class="form-control pull-left mr" id="key" style="width:200px;" placeholder="<?=get_lang('ext_list_ph_search')?>">
                        </div> 
			        </div>
                    
					<div id="pnl_success" class="alert alert-success" style="display:none;font-size:14px;" ><?=get_lang('set_alert_success')?></div>
                    
                    <table id="datalist" class="table table-hover data-list" data-ispage="0"  data-tmpid="tmpl_list" data-table="tab_config" data-fldid="col_id"  data-fldord="col_id" data-fldname="col_name"  data-fldlist="*" data-fldsort="col_genre,col_id" data-where="" >
                        <thead>
                            <tr>
                                <td data-sortfield="col_name" style="width:200px"><?=get_lang('ext_list_table_name')?></td>
                                <td data-sortfield="col_data"><?=get_lang('ext_list_table_data')?></td>
                                <td data-sortfield="col_type" style="width:150px"><?=get_lang('ext_edit_lb_type')?></td>
                                <td class="col-op" style="width:170px"></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${col_id}"  data-id="${col_id}">
                            <td>${col_name}</td>
                            <td>${col_data}</td>
						    <td>${col_genre}</td>
                            <td class="col-op">
                                <a href="javascript:void(0);" onclick="ext_edit_cus(${col_id})"><?=get_lang('ext_list_table_edit')?></a>
                                <a href="javascript:void(0);" onclick="ext_delete(${col_id})"><?=get_lang('ext_list_table_del')?></a>
                            </td>
                        </tr>
                    </script>
				<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">


    var dataList ;
    $(document).ready(function(){
        dataList = $("#datalist").attr("data-where",getSearchSql()).dataList();
        
        $("#key").keyup(function(){
            search();
        })
    })
    

    
	function getSearchSql()
	{
        var where = " where ( col_genre='CUSTOM' ) or (col_genre='BigAntClientExt')" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"( col_name like '%" + key + "%' )") ;
		return where ;
	}
    function search(){

        dataList.search(getSearchSql()) ;
    }

    
    function ext_edit_cus(id)
    {    

        if (id == undefined)
            id = "" ;
        var title = (id == ""?"<?=get_lang('ext_list_add')?>":"<?=get_lang('ext_list_change')?>") ;
        var url = "ext_edit.html" + (id == ""?"":"?id=" + id )
        dialog("ext",title ,url) ;
    }
    function ext_edit_sys(id)
    {    

        if (id == undefined)
            id = "" ;
        var title = (id == ""?"<?=get_lang('ext_list_add')?>":"<?=get_lang('ext_list_change')?>") ;
        var url = "ext_edit_sys.html" + (id == ""?"":"?id=" + id )
        dialog("ext",title ,url) ;
    }
   
    function ext_delete(_id)
    {
	    id = getSelectedId(_id) ;
	    if (id == "")
		    return ;

	    if (confirm("<?=get_lang('alert_delconfirm')?>"))
		    dataList.del(id) ;
    }
	
	function ext_bulid()
	{
		 var url = getAjaxUrl("sysconfig","init") ;
		 $.ajax({
			 type: "POST",
			 dataType:"json",
			 url: url,
			 success: function(result){
				 if(result.status)
					 $("#pnl_success").show();
				 else
					  myAlert(result.msg);
			 }
		 });
	}
    

</script>