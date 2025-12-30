<?php  require_once("../include/fun.php");?>
<?php
define("MENU","INTERFACE") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/acepicker.js"></script>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1>接口管理</h1></div>
			        <div class="searchbar">
			            <div class="pull-left">
			                <button type="button" class="btn btn-default" action-type="interface_edit">新增接口</button>
						    <div class="btn-group">
							    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">批量操作 <span class="caret"></span></button>
							    <ul class="dropdown-menu">
							      <li><a href="#" action-type="interface_ace">设置权限</a></li>
							      <li><a href="#" action-type="interface_delete">删除</a></li>
							    </ul>
						    </div>
			            </div>
                        <div class="pull-right">
                            <input type="text" class="form-control pull-left mr" id="key" style="width:200px;" placeholder="接口查找">
                        </div>
			        </div>
                    <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="ant_Interface" data-fldid="col_id" data-fldord="col_index" data-fldname="col_name"  data-fldlist="*" data-fldsort="col_index,col_id" data-where="" >
                        <thead>
                            <tr>
                                <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                                <td data-sortfield="col_name" style="width:80px;">ID</td>
                                <td data-sortfield="col_name" style="width:200px;">名称</td>
                                <td data-sortfield="col_url">地址</td>
                                <td data-sortfield="col_type" style="width:100px;">类型</td>
                                <td data-sortfield="col_disabled" style="width:100px;">禁用</td>
                                <td data-sortfield="col_index" style="width:100px;">排序</td>
                                <td class="col-op"  style="width:170px"></td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${col_id}"  data-id="${col_id}" data-ord="${col_index}">
                            <td><input type="checkbox" name="chk_Id" value="${col_id}"></td>
                            <td>${col_id}</td>
                            <td><a href="javascript:void(0);" onclick="interface_edit(${col_id})">${col_name}</a></td>
                            <td>${col_url}</td>
							<td>${col_typename}</td>
							<td><a href="#" class="icon-check${col_disabled}" data-value="${col_disabled}" action-data="${col_id},'col_disabled',this"  action-type="dataList.setSwitch"></a></td>
                            <td>${col_index}</td>
                            <td class="col-op">
                                <a href="javascript:void(0);" onclick="interface_edit(${col_id})">修改</a>
                                <a href="javascript:void(0);" onclick="interface_ace(${col_id})">权限</a>
                                <a href="javascript:void(0);" onclick="interface_delete(${col_id})">删除</a>
								<a href="javascript:void(0);" action-data="'col_index','data-ord',this" action-type="dataList.swapUp" title="上移">上移</a>
								<a href="javascript:void(0);" action-data="'col_index','data-ord',this" action-type="dataList.swapDown" title="下移">下移</a>
                            </td>
                        </tr>
                    </script>
					<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
	var objEmpType = "<?=EMP_INTERFACE?>";
	var appPath = "<?=getRootPath() ?>";
	var defaultImg = appPath + "/static/img/pix.png" ;
    $(document).ready(function(){
        dataList = $("#datalist").dataList(formatData,listCallBack);

        $("#key").keyup(function(){
            search();
        })
    })

   function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {

            if (data[i].col_disabled == "1")
                data[i].col_disabled = 1 ;
            else
                data[i].col_disabled = 0 ;

			if (data[i].col_url.length>60)
				data[i].col_url = data[i].col_url.substring(0,60) + "..." ;

			if(data[i].col_type =="0")
				data[i].col_typename = "全部";
			else if(data[i].col_type =="1")
				data[i].col_typename = "PC端应用";
			else if(data[i].col_type =="2")
				data[i].col_typename = "Android端应用";
			else if(data[i].col_type =="3")
				data[i].col_typename = "iOS端应用";

        }
        return data ;
    }

	function listCallBack()
	{
		$(".photo").bind("error",function(){
			this.src= defaultImg;
		});
	}

    function search(){
        var where = "" ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where,"( col_name like '%" + key + "%' )") ;


        dataList.search(where) ;
    }

    function interface_edit(id)
    {
        if (id == undefined)
            id = "" ;
        var title = (id == ""?"新增接口":"修改接口") ;
        var url = "interface_edit.html" + (id == ""?"":"?id=" + id )
        dialog("interface",title ,url) ;
    }
    function interface_delete(_id)
    {
	    id = getSelectedId(_id) ;
	    if (id == "")
		    return ;

	    if (confirm("你确定要删除吗？"))
		    dataList.del(id) ;
    }

    function interface_ace(_objId)
    {
	    objId = getSelectedId(_objId) ;
	    if (objId == "")
		    return ;

	    ace_picker(objEmpType,objId,'InterfaceAce','RTCAce');
    }


</script>

