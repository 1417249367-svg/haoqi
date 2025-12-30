function load_all()
{
   var url = getAjaxUrl("tag","load_all") ;
   $.ajax({
	   type: "POST",
	   dataType:"json",
	   url: url,
	   success: function(data){
	       var container = $("#tag_container") ;
           var html = "" ; 
           html = $("#tmpl_type").tmpl(data) ;
           $(container).html(html);
           for(var i=0;i<data.length;i++)
           {
                html = $("#tmpl_tag").tmpl(data[i].tags) ;
                $("#type_" + data[i].col_id + " .tags").html(html);
           }

           formatContainer(container);
	   }
   }); 
}
 

function type_delete(id)
{
    if (confirm("你确定要删除吗？") == false)
        return ;
    var url = getAjaxUrl("tag","delete_type","id=" + id) ;
    $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(data){
            $("#type_" + id).remove();
       }
    });
}

function tag_delete(id)
{
    if (confirm("你确定要删除吗？") == false)
        return ;
    var url = getAjaxUrl("tag","delete_tag","id=" + id) ;
    $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       success: function(data){
            $("#tag_" + id).remove();
       }
    });
}



function type_edit(id)
{
	if (id == undefined)
		id = "" ;

	var title = (id == ""?"新增类型":"修改类型") ;
	var url = "tag_type_edit.html?" + (id == ""?"":"&id=" + id ) ;
	dialog("type",title ,url) ;
}

function tag_edit(id,type_id)
{
	if (id == undefined)
		id = "" ;

	var title = (id == ""?"新增标签":"修改标签") ;
	var url = "tag_edit.html?type_id=" + type_id + (id == ""?"":"&id=" + id ) ;
	dialog("tag",title ,url) ;
}

function tag_add_post(type_id)
{
    var container_type = $("#type_" + type_id) ;
    var ipt = $(".tag-name",container_type) ;
    var name = $(ipt).val();
    var id = 0 ;
    
    if (name == "")
    {
    	myAlert("请输入标签");
        $(ipt).focus();
        return ;
    }
    var url = getAjaxUrl("tag","add_tag") ;
    $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:{type_id:type_id,name:name},
       success: function(data){
            var container_tag = $("#tmpl_tag").tmpl({"col_id":data.id ,"col_name":name,"col_type_id":type_id}) ;
            $(".tags",container_type).append(container_tag);
            formatContainer(container_tag);
            $(ipt).val("");
       }
    });
    

}


function tag_user(name)
{
    location.href = "user_list.html?key=" + name ;
}

function tag_group(name)
{
    location.href = "group_list.html?key=" + name ;
}