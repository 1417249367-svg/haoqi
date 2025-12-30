


var empType = "" ;
var empId = "" ;

//加载数据
function loadTag(empType,empId)
{
   var url = getAjaxUrl("tag","load_all") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(data){
            draw_loadall(data);
            tag_getdata(empType,empId);
	   }
   }); 
}

function draw_loadall(data)
{
    
    var html = "" ;
    
    
    for(var i=0;i<data.length;i++)
    {
        var type = data[i] ;
        html += '<dl id="type_' + type.col_id + '" >' ;
                html += '<dt>' + type.col_name + '</dt>' ;
                html += '<dd>' ;
                    html += '<ul class="list-h">' ;

                    for(var j=0;j<type.tags.length;j++)
                    {
                        var tag = type.tags[j] ;
                        html += '<li>' ;
                            html += '<label><input type="checkbox" name="chk_Tag" value="' + tag.col_id + '" class="tag_' + tag.col_id + '">' + tag.col_name + '</label>' ;
                        html += '</li>' ;
                     }   
                        
                    html += '</ul><div class="clear"></div>' ;
                html += '</dd>' ;
        html += '</dl>' ;
    }
    var container = $("#tag_container");
    $(container).html(html) ;
}

function getTagIds()
{
    var ids = getCheckValue("chk_Tag") ;
    return ids ;
}

//加载关联
function tag_getdata(empType,empId)
{
   if ((empId == "") || (empId.indexOf(",")>-1))
      return ;
   var url = getAjaxUrl("tag","get_data") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{empType:empType,empId:empId},
	   url: url,
	   success: function(data){
            for(var i=0;i<data.rows.length;i++)
            {
                var item = data.rows[i] ;
                $(".tag_" + item.col_id).attr("checked",true);
            }
	   }
   }); 
}


//打开窗体
function tag_picker(empType,empId)
{

	$(".modal").remove() ; 
	
	var param = "empType=" + empType + 
			   "&empId=" + empId ;

	dialog("tagpicker","设置标签","../hs/tag_picker.html?" + param) ;
}




 
 
//保存
function tag_post()
{
  
   setLoadingBtn($("#btn_picker_submit")) ;

   my_ids = getTagIds();

   flag = $("#chk_reset").is(':checked')?1:0 ;
   data = {empType:empType,empId:empId,tagIds:my_ids,flag:flag} ;
   var url = getAjaxUrl("tag","set_data") ;

   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status)
			{
				myAlert("操作成功");
				dataList.reload();
				dialogClose("tagpicker");
			}
			else
			{
				myAlert(getErrorText(result.errnum));
			}
	   }
   }); 
}

//批量或单个设置
function set_tag(empType,_objId)
{
	objId = getSelectedId(_objId) ;
	if (objId == "")
		return ;

	tag_picker(empType,objId,1);
}

//显示如群表的标签值
function formatTagRow(empType)
{
   var empId = getRowIds() ;
   if (empId == "")
   		return ;
   var url = getAjaxUrl("tag","get_relation") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   data:{empType:empType,empId:empId},
	   url: url,
	   success: function(data){
            for(var i=0;i<data.rows.length;i++)
            {
                var item = data.rows[i] ;
                var c = $(".row-" + item.col_emp_id + " .tags") ;
                $(c).append( item.col_name + ",");
            }
	   }
   }); 
}
