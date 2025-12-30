/**
 * author:zwz
 * date:2015.03.02
 */

	function access_search(){
        dataList.search(get_where()) ;
    }

	function get_where()
    {
	    var where = "" ;
	    var key =  $("#key").val() ;

	    if (key != "")
		    where = getWhereSql(where, " col_name like '%" + key + "%' ") ;
        return where ;
    }

	function access_formatData(data)
    {
        return data ;
    }

	function access_delete(_id)
	{
		id = getSelectedId(_id) ;
		if (id == "")
			return ;


		if (confirm("你确定要删除吗？"))
			dataList.del(id) ;
	}

	function access_edit(_id)
	{
		if (_id == undefined)
			id = "" ;
		else
			id = getSelectedId(_id) ;

		var title = (id == ""?langs.access_create:langs.access_edit) ;
		var url = "../access/access_edit.html?" + (id == ""?"":"id=" + id );
		dialog("access",title ,url) ;
	}

	function access_detail_init()
	{
		dataForm = $("#form-access").attr("data-id",id).dataForm({savecallback:access_saveCallBack});
	}

	function access_saveCallBack()
	{
		dataList.reload();
		dialogClose("access");
	}

