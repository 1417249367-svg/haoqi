$(document).ready(function(){
	formatContainer();
})




function formatContainer(container)
{
    if (container == undefined)
        container = $("body") ; 
        
    $("[lang]",container).each(function () {
        var str =  langs[$(this).attr("lang")] ;
        if (str) 
        { 
            if ($(this).is("input") || $(this).is("textarea")) 
                $(this).val(str); 
            else 
                $(this).text(str); 
        } 
    }); 
    
    $("[action-type]",container).click(function () {
        var cmd = $(this).attr("action-type") + "(" + $(this).attr("action-data") + ")" ;
        eval(cmd);
    }); 
 
   
    $("input[name=chk_Id]").click(function(){
        check(this,this.checked) ;
    })
    

    $("input.datepicker")
    	.attr("readOnly","readOnly")
    	.datetimepicker({minView:'month',autoclose:true,pickerPosition:'bottom-left',
            language:'zh-CN'})
        .click(function() {
        	$(this).datetimepicker('show');
        })
        .blur(function() {
            var val = $(this).val() ;
            if (val != "")
            {
                if(!/\d{4}-\d{1,2}-\d{1,2}/.test(val))
                    $(this).val("")
            }
        })
}
