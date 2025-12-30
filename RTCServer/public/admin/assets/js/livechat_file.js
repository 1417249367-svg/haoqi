    var loginName = "" ;

    function formatData(data)
    {
 
        return data ;
    }

    
	function file_edit(id)
	{

		if (id == undefined)
			dialog("file",langs.file_create,"file_edit.html") ;
		else
			dialog("file",langs.file_edit,"file_edit.html?id=" + id ) ;
	}
	
	var id = "" ;
	function file_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_config))
			dataList.del(id) ;
	}
	
	function file_saveCallBack()
	{
		dataList.reload();
		dialogClose("file");
	}
	
	function file_search(){
        var where = getSearchSql();
        dataList.search(where) ;
    }
    
    var fliter = "" ;
    function getSearchSql()
    {
        var where = fliter ;

        if ($("#dt").val() != "")
			where = get_date_sql("createtime",$("#dt").val(),$("#dt").val(),where) ;  
 
        if ($("#key").val() != "")
            where = getWhereSql(where,$("#field").val() + " like '%" + $("#key").val() + "%'") ;
        
        if ($("#drp_flag").val() != "-1")
            where = getWhereSql(where,"flag=" + $("#drp_flag").val()) ;

        return where ;
    }

    function file_getCallBack(data)
    {


    }

    function save()
    {
        if ($("#filename").val() == "")
        {
            setElementError($("#filename"),langs.file_name_require);
            return false ;
        }
        if ($("#filepath").val() == "")
        {
            setElementError($("#filepath"),langs.file_path_require);
            return false ;
        }
        dataForm.save();
    }

    function uploadFile()
    {
        var fileName = $("#file").val();
        var url = getAjaxUrl("upload","livechat") ;
        $("#form_file").attr("action",url).attr("target","frm_Upload").submit();
    }


    function uploadComplete(file)
    {
        $("#filename").val(file.filename);
        $("#filepath").val(get_download_img_url(file.filepath));
        $("#filesize").val(file.filesize);
		$("#container_link").fadeOut();
    }