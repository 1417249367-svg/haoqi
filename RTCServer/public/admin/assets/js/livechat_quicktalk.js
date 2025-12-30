    var loginName = "" ;
    var fliter = "where flag=0 and chatid=''" ;
    
    
    function formatData(data)
    {
 
        return data ;
    }

    
	function quicktalk_edit(id)
	{

		if (id == undefined)
			dialog("quicktalk",langs.quicktalk_create,"quicktalk_edit.html") ;
		else
			dialog("quicktalk",langs.quicktalk_edit,"quicktalk_edit.html?id=" + id ) ;
	}
	
	var id = "" ;
	function quicktalk_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			dataList.del(id) ;
	}
	
	function quicktalk_saveCallBack()
	{
		dataList.reload();
		dialogClose("quicktalk");
	}
	
	function quicktalk_search(){
        var where = fliter ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where," (usertext like '%" + key + "%' )") ;

        dataList.search(where) ;
    }
    

    function quicktalk_getCallBack(data)
    {


    }

    function save()
    {
        
//        if ($("#subject").val() == "")
//        {
//            setElementError($("#subject"),langs.quicktalk_subject_require);
//            return false ;
//        }
        if ($("#usertext").val() == "")
        {
            setElementError($("#usertext"),langs.quicktalk_usertext_require);
            return false ;
        }
		
		var ord = $("#ord").val();
	
		if (isNaN(ord))
			ord = 0 ;
	
		if(ord <= 0 )
		{
			setElementError($("#ord"),langs.quicktalk_ord_require);
			return;
		}
        
        dataForm.save();
    }