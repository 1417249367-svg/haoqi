<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_LINK") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_link.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('link_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button class="btn btn-default" action-type="link_edit"><?=get_lang('link_list_btn_add')?></button>
                    </div> 
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('link_list_ph_search')?>" >
                    </div> 
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-obj="livechat_kf" data-table="lv_link" data-ispage="1" data-fldid="linkid" data-fldname="linkname"  data-fldlist="*" data-fldsort="linkid desc" data-fldsortdesc="linkid asc" >
                    <thead>
                        <tr>
                            <td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="linkname"><?=get_lang('link_list_table_name')?></td>
                            <td data-sortfield="linkurl"><?=get_lang('link_list_table_address')?></td>
                            <td style="width:80px" data-sortfield="chater"><?=get_lang('link_list_table_owner')?></td>
                            <td data-sortfield="createtime" style="width:150px"><?=get_lang('link_list_table_createdate')?></td>
                            <td style="width:80px"></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${linkid}">
                        <td><input type="checkbox" name="chk_Id" value="${linkid}"></td>
                        <td>
                            <a href="javascript:void(0);" action-data="${linkid}" action-type="link_edit">${linkname}</a>
                        </td>
                        <td> <a href="###" onclick="window.open('${linkurl}')">${linkurl}</a></td>
                        <td>${username}</td>
                        <td>${createtime}</td>
						<td>
							<a href="javascript:void(0);" action-data="${linkid}" action-type="link_edit"><?=get_lang('link_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${linkid}" action-type="link_delete" ><?=get_lang('link_list_delete')?></a>
						</td>
                    </tr>
                </script>
	<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
	var appPath = "<?=getRootPath() ?>"; 
	
    $(document).ready(function(){
        dataList = $("#datalist").dataList(formatData);
        $("#key").keyup(function(){
            search();
        })
    })

	function search(){
        var where = "" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"(linkname like '%" + key + "%')") ;
        dataList.search(where) ;
    }
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
			data[i].createtime = toDate(data[i].createtime,1) ;
        }
        return data ;
    }
</script>


