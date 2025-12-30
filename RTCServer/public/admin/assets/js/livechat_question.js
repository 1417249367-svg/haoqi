    var loginName = "" ;
    var fliter = "where flag=0 and chatid=''" ;
    
    
    function formatData(data)
    {
 
        return data ;
    }

    
	function question_edit(id)
	{

		if (id == undefined)
			dialog("question",langs.question_create,"question_edit.html") ;
		else
			dialog("question",langs.question_edit,"question_edit.html?id=" + id ) ;
	}
	
	function question_edit1(id)
	{
		if (id == undefined)
			dialog("question",langs.question_create,"question_edit1.html") ;
		else
			dialog("question",langs.question_edit,"question_edit1.html?id=" + id ) ;
	}
	
	var id = "" ;
	function question_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			dataList.del(id) ;
	}
	
	function question_saveCallBack()
	{
		dataList.reload();
		dialogClose("question");
	}
	
	function question_search(){
        var where = fliter ;
        var key =  $("#key").val() ;

        if (key != "")
            where = getWhereSql(where," (subject like '%" + key + "%' )") ;

        dataList.search(where) ;
    }
    

    function question_getCallBack(data)
    {
		CKEDITOR.replace('usertext');
		CKEDITOR.instances.usertext.setData(PastImgEx1(data.usertext));
    }

    function save()
    {
        
        if ($("#subject").val() == "")
        {
            setElementError($("#subject"),langs.question_subject_require);
            return false ;
        }
//        if ($("#usertext").val() == "")
//        {
//            setElementError($("#usertext"),langs.question_usertext_require);
//            return false ;
//        }
		
		var ord = $("#ord").val();
	
		if (isNaN(ord))
			ord = 0 ;
	
		if(ord <= 0 )
		{
			setElementError($("#ord"),langs.question_ord_require);
			return;
		}
        $("#subject").val(replaceAll($("#subject").val(),"'",""));
		
		for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
		var usertext=$("#usertext").val();
		usertext=replaceAll(replaceAll(usertext,"'",""),"\n","");
		var Request = new Object(); 
		var newContent= usertext.replace(/<img [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
		//capture,返回每个匹配的字符串
			Request = GetURLRequest(capture);
			var newStr="{e@"+Request['name']+"|0|0|}";
			return newStr;
		});
		newContent= newContent.replace(/<video [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
		//capture,返回每个匹配的字符串
			Request = GetURLRequest(capture);
			var newStr="{i@"+Request['name']+"|0|0|FileRecv/MessageVideoPlay.png}";
			return newStr;
		});
		 $("#usertext").val(newContent);
		
//		var usertext=replaceAll(replaceAll($("#usertext").val(),"'",""),"\n","<br>");
//		$("#usertext").val(usertext);
        dataForm.save();
    }