<?php  require_once("../include/fun1.php");?>
<?php  
define("MENU","LIVECHAT_QUESTION") ;
$db = new Model("lv_chater");
$db -> addParamWhere("LoginName", CurUser::getLoginName());
$row = $db -> getDetail();
$userid=$row["userid"];
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/livechat_question.js?ver=20240123"></script>
    <script src="/static/js/msg_reader.js"></script>
    <script src="/static/js/ckeditor/ckeditor.js"></script>
</head>
<body>
				<!--SearchBar-->
				<div class="searchbar" style="margin-top:10px;">
                    <div class="pull-left">
                        <button class="btn btn-default" action-type="question_edit1"><?=get_lang('question_list_btn_add')?></button>
                    </div> 
                    <div class="pull-right">
                        <input type="text" class="form-control pull-left search" id="key" style="width:200px;" placeholder="<?=get_lang('question_list_ph_search')?>" >
                    </div> 
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-obj="livechat_kf" data-table="lv_question" data-ispage="1" data-fldid="questionid" data-fldname="subject"  data-fldlist="*" data-fldsort="ord ,questionid" data-fldsortdesc="ord desc,questionid desc" data-where="">
                    <thead>
                        <tr>
                            <td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="subject"><?=get_lang('question_list_table_name')?></td>
                            <td data-sortfield="usertext"><?=get_lang('question_list_table_address')?></td>
                            <td style="width:80px" data-sortfield="col_top"><?=get_lang('chater_list_top')?></td>
                            <td style="width:40px" data-sortfield="to_type"><?=get_lang('chater_list_status')?></td>
                            <td style="width:40px" data-sortfield="ord"><?=get_lang('chater_list_order')?></td>
                            <td style="width:80px" data-sortfield="chater"><?=get_lang('link_list_table_owner')?></td>
                            <td data-sortfield="createtime" style="width:150px"><?=get_lang('question_list_table_createdate')?></td>
                            <td style="width:160px"></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr class="row-${questionid}" data-id="${questionid}" data-ord="${ord}">
                        <td><input type="checkbox" name="chk_Id" value="${questionid}"></td>
                        <td>
                            <a href="javascript:void(0);" action-data="${questionid}" action-type="question_edit">${subject}</a>
                        </td>
                        <td>${usertext}</td>
                        <td><a href="javascript:void(0);" class="icon-check${col_top}" data-value="${col_top}" action-data="${questionid},'col_top',this"  action-type="dataList.setSwitch"></a></td>
                        <td><a href="javascript:void(0);" class="icon-check${to_type}" data-value="${to_type}" action-data="${questionid},'to_type',this"  action-type="dataList.setSwitch"></a></td>
                        <td>${ord}</td>
						<td>${username}</td>
                        <td>${createtime}</td>
						<td>
							<a href="javascript:void(0);" action-data="${questionid}" action-type="question_edit1"><?=get_lang('question_list_edit')?></a>
							<a href="javascript:void(0);" action-data="${questionid}" action-type="question_delete" ><?=get_lang('question_list_delete')?></a>
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
        dataList = $("#datalist").attr("data-where",get_where()).dataList(formatData);
        $("#key").keyup(function(){
            search();
        })
    })
	
	function get_where()
	{
        var where = "" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"(subject like '%" + key + "%')") ;
		where = getWhereSql(where,"Chater='<?=$userid ?>'") ;
		//alert(where);
		return where ;
	}

	function search(){
        var where = get_where() ;
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


