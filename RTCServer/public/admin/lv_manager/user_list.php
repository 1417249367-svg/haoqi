<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","LIVECHAT_USER") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
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
				<div class="page-header"><h1><?=get_lang('user_list_title')?></h1></div>
				
				<!--SearchBar-->
				<div class="searchbar">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default" action-type="data_delete"><?=get_lang('btn_delete')?></button>
                    </div>
                    <div class="pull-right">
				      <select  id="field" class="form-control pull-left ws mr" style="width:150px">
                        <option value="userid">ID</option>
				        <option value="username"><?=get_lang('user_list_option_name')?></option>
				        <option value="phone"><?=get_lang('user_list_option_phone')?></option>
				        <option value="email"><?=get_lang('user_list_option_email')?></option>
				      </select>
                      <input type="text" class="form-control pull-left ws mr"  id="key" placeholder="<?=get_lang('user_list_ph_key')?>" />
                      <button type="submit" class="btn btn-default pull-left" action-type="search" ><?=get_lang('btn_search')?></button>
					</div>
					<div class="clear"></div>
				</div>
				<!--End SearchBar-->
				
				<!--List--->
                <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="lv_user" data-fldid="userid" data-fldname="userId"  data-fldlist="*" data-fldsort="regtime desc" data-fldsortdesc="regtime asc" >
                    <thead>
                        <tr>
                        	<td style="width:40px"><input type="checkbox"  name="chk_All" onClick="checkAll('chk_Id',this.checked)"></td>
                            <td data-sortfield="userid">ID</td>
                            <td data-sortfield="username"><?=get_lang('user_list_table_name')?></td>
                            <td data-sortfield="phone"><?=get_lang('user_list_table_phone')?></td>
                            <td data-sortfield="chater"><?=get_lang('user_list_table_chater')?></td>
                            <td data-sortfield="remarks"><?=get_lang('user_list_table_remarks')?></td>
                            <td data-sortfield="ip">IP</td>
                            <td data-sortfield="regtime"><?=get_lang('user_list_table_regtime')?></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody class="data-body"></tbody>
                </table>
                <script type="text/x-jquery-tmpl" id="tmpl_list">
                    <tr id="${userid}" class="status-${status}">
						<td><input type="checkbox" name="chk_Id" value="${userid}"></td>
                        <td><a href="javascript:void(0);" action-data="'${userid}'" action-type="user_edit">${userid}</a></td>
                        <td>${username}</td>
                        <td>${phone}</td>
                        <td>${chater}</td>
						<td>${remarks}</td>
                        <td>${ip}</td>
                        <td><small>${regtime}</small></td>
                        <td style="width:100px">
                            <a href="chat_list.html?field=userid&key=${userid}"><?=get_lang('user_list_table_chat')?></a>
                            <a href="message_list.html?field=userid&key=${userid}"><?=get_lang('user_list_table_message')?></a>
                            <a href="file_list.html?field=username&key=${username}"><?=get_lang('user_list_table_attach')?></a>
                        </td>
                    </tr>
                </script>
				<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">
    var dataList ;
    var fliter = "" ;
    $(document).ready(function(){
        dataList = $("#datalist").attr("data-where",fliter).dataList(formatData);
    })
	
	function user_edit(id)
	{
		dialog("user",langs.livechat_user_edit,"user_edit.html?id=" + id ) ;
	}
    
    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
			data[i].regtime = toDate(data[i].regtime,1) ;
        }
        return data ;
    }
    
	
	
	function search(){
        var where = fliter ;


        if ($("#key").val() != "")
            where = getWhereSql(where,$("#field").val() + " like '%" + $("#key").val() + "%'") ;

        dataList.search(where) ;
    }
</script>

