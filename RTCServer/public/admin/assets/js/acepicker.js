




//加载数据
function ace_load(itemType,itemId)
{
   if (itemId.indexOf(",")>-1)
   {
      return ;
   }

   var url = getAjaxUrl("ace","get_data") ;
   //document.write(url);
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   data:{itemType:itemType,itemId:itemId},
	   success: function(data){
            
            var empIds = $("input[name=empid]");

            for(var i=0;i<data.rows.length;i++)
            {
                for(var j=0;j<empIds.length;j++)
                {
                    if((data.rows[i].col_dhsitemtype == empType) && (data.rows[i].col_dhsitemid == $(empIds[j]).attr("value")))
						$(empIds[j]).attr("checked","true"); 
                }
            }
	   }
   }); 
}



 
//保存
function ace_post()
{
  
   setLoadingBtn($("#btn_picker_submit")) ;
   //flag = $("#chk_reset").is(':checked')?1:0 ;
   data = {itemType:itemType,itemId:itemId,empType:empType,funName:funName,funGenre:funGenre} ;

	var fields = "" ;
	var fieldtypes = "" ;
	var key = "" ;
	$(".data-field").each(function(){
		if (fields != "")
		{
			fields += "," ;
			fieldtypes += "," ;
		}
		fields += $(this).attr("name") ;
		fieldtypes += ($(this).attr("data-type") == undefined)?"string":$(this).attr("data-type") ;
		key = $(this).attr("name") ;
		data[key] = $(this).val() ;

	})
	

	data.fields = fields ;
	data.fieldtypes = fieldtypes ;

   var url = getAjaxUrl("ace","set_data") ;
   //document.write(url+JSON.stringify(data));
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				myAlert(langs.text_op_success);
				dataList.reload();
				dialogClose("acepicker");
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
   }); 
}

//批量或单个设置
function set_ace(itemType,_objId,funName,funGenre,empType)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	ace_picker(itemType,_objId,funName,funGenre,empType);
}



//打开窗体
function ace_picker(itemType,_objId,funName,funGenre,empType)
{

	$(".modal").remove() ; 
	
	if (empType == undefined)
	    empType = 3 ;
	    
	var param = "itemType=" + itemType + "&itemId=" + _objId + "&funName=" + funName + "&funGenre=" + funGenre + "&empType=" + empType + "&rnd=" + Math.random()  ;

	dialog("acepicker",langs.ace_set,"../hs/ace_picker.html?" + param) ;
}