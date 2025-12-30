    var loginName = "" ;
    var fliter = "where flag=0 and chatid=''" ;
    
    
    function formatData(data)
    {
 
        return data ;
    }

    
	function link_edit(id)
	{

		if (id == undefined)
			dialog("link",langs.link_create,"link_edit.html") ;
		else
			dialog("link",langs.link_edit,"link_edit.html?id=" + id ) ;
	}
	
	var id = "" ;
	function link_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			dataList.del(id) ;
	}
	
	function link_saveCallBack()
	{
		dataList.reload();
		dialogClose("link");
	}
	
	function link_search(){
        var where = fliter ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where," (linkname like '%" + key + "%' )") ;

        dataList.search(where) ;
    }
    

    function link_getCallBack(data)
    {


    }

    function save()
    {
        
        if ($("#linkname").val() == "")
        {
            setElementError($("#linkname"),langs.link_name_require);
            return false ;
        }
        if ($("#linkurl").val() == "")
        {
            setElementError($("#linkurl"),langs.link_url_require);
            return false ;
        }
        
        dataForm.save();
    }

    function uploadFile()
    {
		var fileName = $("#file").val();
        var url = getAjaxUrl("upload","livechat") ;
        $("#form_link").attr("action",url).attr("target","frm_Upload").submit();
    }


    function uploadComplete(file)
    {
		$("#linkname").val(file.filename);
        $("#linkurl").val(get_download_img_url(file.filepath));
		$("#container_link").fadeOut();
    }