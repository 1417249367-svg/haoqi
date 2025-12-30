<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_QUICKTALK") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_quicktalk.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
				<div class="page-header"><h1><?=get_lang('quicktalk_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button class="btn btn-default" action-type="quicktalk_edit"><?=get_lang('quicktalk_list_btn_add')?></button>
                    </div> 
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('quicktalk_list_ph_search')?>" >
                    </div> 
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-obj="livechat_kf" data-table="lv_quicktalk" data-ispage="1" data-fldid="TalkId" data-fldname="subject"  data-fldlist="*" data-fldsort="ord ,talkid" data-fldsortdesc="ord desc,talkid desc" >
                    <thead>
                        <tr>
                            <td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="usertext"><?=get_lang('quicktalk_list_table_address')?></td>
                            <td style="width:40px" data-sortfield="status"><?=get_lang('chater_list_status')?></td>
                            <td style="width:40px" data-sortfield="ord"><?=get_lang('chater_list_order')?></td>
                            <td style="width:80px" data-sortfield="chater"><?=get_lang('link_list_table_owner')?></td>
                            <td data-sortfield="createtime" style="width:150px"><?=get_lang('quicktalk_list_table_createdate')?></td>
                            <td style="width:160px"></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${talkid}" data-id="${talkid}" data-ord="${ord}">
                        <td><input type="checkbox" name="chk_Id" value="${talkid}"></td>
                        <td>
                            <a href="javascript:void(0);" action-data="${talkid}" action-type="quicktalk_edit">${usertext}</a>
                        </td>
                        <td><a href="javascript:void(0);" class="icon-check${status}" data-value="${status}" action-data="${talkid},'status',this"  action-type="dataList.setSwitch"></a></td>
                        <td>${ord}</td>
						<td>${username}</td>
                        <td>${createtime}</td>
						<td>
							<a href="javascript:void(0);" action-data="${talkid}" action-type="quicktalk_edit"><?=get_lang('quicktalk_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${talkid}" action-type="quicktalk_delete" ><?=get_lang('quicktalk_list_delete')?></a>
							<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapUp" title="<?=get_lang('chater_list_up')?>"><?=get_lang('chater_list_up')?></a>
							<a href="javascript:void(0);" action-data="'ord','data-ord',this" action-type="dataList.swapDown" title="<?=get_lang('chater_list_down')?>"><?=get_lang('chater_list_down')?></a>
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
            where = getWhereSql(where,"(usertext like '%" + key + "%')") ;
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


