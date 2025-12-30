    var loginName = "" ;
    var fliter = "where flag=0 and chatid=''" ;
    
    
    function formatData(data)
    {
 
        return data ;
    }

    
	function blackip_edit(id)
	{

		if (id == undefined)
			dialog("blackip",langs.livechat_blackip_create,"blackip_edit.html") ;
		else
			dialog("blackip",langs.livechat_blackip_edit,"blackip_edit.html?id=" + id ) ;
	}
	
	var id = "" ;
	function blackip_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			dataList.del(id) ;
	}
	
	function blackip_saveCallBack()
	{
		dataList.reload();
		dialogClose("blackip");
	}

    function blackip_getCallBack(data)
    {


    }

    function save()
    {
        
        if ($("#youid").val() == "")
        {
            setElementError($("#youid"),langs.livechat_blackip_youid_require);
            return false ;
        }
        if ($("#to_ip").val() == "")
        {
            setElementError($("#to_ip"),langs.livechat_blackip_to_ip_require);
            return false ;
        }
        dataForm.save();
    }