 

$(document).ready(function(){

    jQuery.validator.addMethod("specialCharValidate", 
        function(value, element) { 
	    var pattern = new RegExp("[`~!@%#$^&*()=|{}':;',　\\[\\]<>/? \\.；：%……+￥（）【】‘”“'。，、？]");
            return this.optional(element)||!pattern.test(value) ; 
        }, 
        jQuery.format(jQuery.validator.messages["specialCharValidate"])
    ); 
    
    jQuery.extend(jQuery.validator.messages, { 
	    specialCharValidate : "请不要输入特殊字符" 
    }); 
 
})

 
 
