$(document).ready(function(){

})

//自动调节高度
function resize()
{
    var height = document.body.clientHeight ;
    
	$(".fluent").each(function(){
	    var abs_height = getInt($(this).attr("abs_height")) ;
	    if (abs_height>0)
	    {
		    $(this).height(height - abs_height);
		}
	})
}

 

function formatContainer(container)
{
}


