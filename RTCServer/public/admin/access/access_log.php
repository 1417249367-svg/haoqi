<?php  require_once("../include/fun.php");?>
<?php
define("MENU","ACCESS_LOG") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1>同步日志</h1></div>
			        <div class="searchbar">
                        <div class="pull-left">
							<input type="text" class="form-control datepicker pull-left" data-mask="date"  id="dt1" value="" data-date-format="yyyy-mm-dd"  style="width:150px;">
							<span class="pull-left" style="line-height:34px;padding:0px 5px;">至</span>
							<input type="text" class="form-control datepicker pull-left mr"  data-mask="date" id="dt2" value="" data-date-format="yyyy-mm-dd" style="width:150px;">

                            <select id="search_field" class="form-control pull-left  mr" style="width:120px;">
                                <option value="col_data">数据</option>
                                <option value="col_systemname">系统名称</option>
                            </select>
                            <input type="text" class="form-control pull-left mr" id="key" style="width:200px;" placeholder="查找">
							<input type="button" class="pull-left btn btn-default" value="查询"  onclick="search()"/>
                        </div>
			        </div>
                    <table id="datalist" class="table table-hover data-list" data-tmpid="tmpl_list" data-table="ant_sync_log" data-fldid="col_id" data-fldname="data"  data-fldlist="*" data-fldsort="col_dt_create desc" data-where="" >
                        <thead>
                            <tr>
                                <td data-sortfield="col_id" style="width:50px;">ID</td>
                                <td data-sortfield="col_datatype" style="width:100px;">数据类型</td>
                                <td data-sortfield="col_data" style="">数据</td>
                                <td data-sortfield="col_optype" style="width:100px;">操作类型</td>
                                <td data-sortfield="col_systemname" style="width:100px;">接入系统</td>
                                <td data-sortfield="col_ipaddr" style="width:50px;">IP</td>
                                <td data-sortfield="col_dt_create" style="width:150px;">同步时间</td>
                                <td data-sortfield="col_status" style="width:100px;">状态</td>
                                <td data-sortfield="col_result" style="width:100px;">同步结果</td>
                                <td data-sortfield="col_dt_feedback" style="width:150px;">反馈时间</td>
                            </tr>
                        </thead>
                        <tbody class="data-body"></tbody>
                    </table>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
                        <tr class="row-${col_id}">
                            <td>${col_id}</td>
                            <td>${col_datatype}</td>
                            <td>${col_data}</td>
                            <td>${col_optype}</td>
                            <td>${col_systemname}</td>
                            <td>${col_ipaddr}</td>
                            <td>${col_dt_create}</td>
                            <td><span class="${css}">${col_status}</span></td>
                            <td>${col_result}</td>
                            <td>${col_dt_feedback}</td>
                        </tr>
                    </script>

	<?php  require_once("../include/footer.php");?>


</body>
</html>

<script type="text/javascript">
    var dataList ;
    $(document).ready(function(){
        dataList = $("#datalist").dataList(formatData);

        $("#key").keyup(function(){
            search();
        })
    })

	function formatData(data)
	{
        for (var i = 0; i < data.length; i++) {

        	data[i].col_dt_feedback = (parseInt(data[i].col_status) == 0) ? "" : data[i].col_dt_feedback ;
			data[i].col_datatype = getDataTypeName(data[i].col_datatype) ;
			data[i].col_optype = getOpTypeName(data[i].col_optype) ;

			if (data[i].col_status == 1)
			{
				data[i].col_status = "失败";
				data[i].css = "icon-error" ;
			}
			else if(data[i].col_status == 2)
			{
				data[i].col_status = "成功";
				data[i].css = "icon-success" ;
			}
			else
			{
				data[i].col_status = "未反馈";
				data[i].css = "icon-warning" ;
			}
        }
        return data ;
	}

	function getOpTypeName(type)
	{
		switch(type)
		{
			case "CREATE":
				return "新增" ;
			case "EDIT":
				return "更新" ;
			case "DELETE":
				return "删除" ;
			case "TEXT":
				return "消息" ;
			case "FILE":
				return "附件" ;
			default:
				return "---" ;
		}
	}

	function getDataTypeName(type)
	{
		switch(type)
		{
			case "DEPT":
				return "部门" ;
			case "USER":
				return "用户" ;
			case "GROUP":
				return "群组" ;
			case "MSG":
				return "消息" ;
			default:
				return "---" ;
		}
	}

    function search(){
        var where = "" ;
        var key =  $("#key").val() ;

        if(!compare_date($("#dt1").val(),$("#dt2").val()))
		{
    		myAlert("开始日期必须小于结束日期");
			return;
		}

        if (key != "")
            where = getWhereSql(where,"(" + $("#search_field").val() + " like '%" + key + "%' )") ;

        where = get_date_sql("col_dt_create",$("#dt1").val(),$("#dt2").val(),where,"<?=DB_TYPE?>") ;
        dataList.search(where) ;
    }


</script>
