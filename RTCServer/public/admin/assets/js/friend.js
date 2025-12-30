    
    function friend_add()
    {
       
       var friendId = $("#key").attr("real-value") ;
       if (friendId == undefined)
       {
            myAlert(langs.user_select_text);
            return ;
       }

       var url = getAjaxUrl("friend","add") ;
       $.ajax({
           type: "POST",
           dataType:"json",
           url: url,
           data:{userId:userId,friendId:friendId},
           success: function(result){
                if (result.status)
                {
                    myAlert("添加成功");
                    dataList.reload();
                }
                else
                {
                    myAlert(getErrorText(result.error));
                }
                
           }
       }); 
        
    }
    
    function friend_delete(friendId)
    {
       var url = getAjaxUrl("friend","delete") ;
       $.ajax({
           type: "POST",
           dataType:"json",
           url: url,
           data:{userId:userId,friendId:friendId},
           success: function(result){
                if (result.status)
                {
                    $(".row-"+ friendId).remove(); 
                }
                else
                {
                    myAlert(getErrorText(result.error));
                }
                
           }
       }); 
    }
    