

(function($) {
$.fn.dataForm = function(opts)
{
    opts = jQuery.extend({
        getcallback:function(){},
		detailcallback:function(){},
		submitcallback:function(data){return data},  //提交前处理
		savecallbak:function(){}

	},opts);
	
    var _ = this ;
    var param ;
	
 

    _.init = function(){
        param = _.getParam() ;
        if ((param.id != "") && (param.id != "-1") && (param.id != "0")) _.detail() ;
        else if(param.id == ""&&$(_).attr("data-obj")=="user") _.creator_detail() ;

    }
	
     _.creator_detail = function(){
	   $("#btn_save").attr("disabled",true);
       var url = _.getUrl("detail") ;
	   //console.log(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           data:param,
           url: url,
           success: function(response){
			   //alert(JSON.stringify(response));
				var result = eval("(" +response + ")");
			   	$("#btn_save").attr("disabled",false);
                if (result.error == undefined)
                {
                    if (opts.getcallback != undefined)
                        opts.getcallback(result) ;
                    if (opts.detailcallback != undefined)
                        opts.detailcallback(result) ;
                }
                else
                {
                    var label = $("label[for=" + result.field + "]").html() ; 
                    myAlert(getErrorText(result.errnum).replace("{name}",label));
                }
           },
		   error:function(){
			   myAlert("detail error");   
		   }
       }); 

    }   
	
     _.detail = function(){
	   $("#btn_save").attr("disabled",true);
       var url = _.getUrl("detail") ;
	   //console.log(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           data:param,
           url: url,
           success: function(response){
			   //alert(JSON.stringify(response));
				var result = eval("(" +response + ")");
			   	$("#btn_save").attr("disabled",false);
                if (result.error == undefined)
                {
                    $(".data-field",_).each(function(){
                        var val = result[$(this).attr("name")] ;
                        setElementValue(this,val) ;
                    })
                    if (opts.getcallback != undefined)
                        opts.getcallback(result) ;
                    if (opts.detailcallback != undefined)
                        opts.detailcallback(result) ;
                }
                else
                {
                    var label = $("label[for=" + result.field + "]").html() ; 
                    myAlert(getErrorText(result.errnum).replace("{name}",label));
                }
           },
		   error:function(){
			   myAlert("detail error");   
		   }
       }); 

    }   
    
    _.save = function(){
 	   setLoadingBtn($("#btn_save"));
	   
       var data = _.getData();
	   
            
      var op = $(_).attr("data-op") ;
	  if ((op == undefined) || (op == "") )
	  	op = param.id == ""?"create":"edit" ;
            
       var url = _.getUrl(op) ;
       if (opts.submitcallback != undefined)
          data = opts.submitcallback(data) ;
		  //console.log(url+JSON.stringify(data));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:data,
           url: url,
           success: function(result){
                if (result.status)
                {
                    if (opts.savecallback != undefined)
                        opts.savecallback(result);
                    
                }
                else
                {
					var els = result.msg.split(";");
					
					clearElementError();
					
					if (result.errnum == undefined)
						alert(result.msg);
					else
					{
						for(var i=0;i<els.length;i++)
						{
							if (els[i] != "")
							{
								var el = $("#" + els[i]) ;
								var name = getElementName(el) ;
								setElementError(el,getErrorText(result.errnum).replace("{name}",name));
							}
						}
					}

					setSubmitBtn($("#btn_save"));
                }
           }
       }); 
    }

    
    _.getParam = function(){
        param = {table:$(_).attr("data-table"),fldid:$(_).attr("data-fldid"),fldname:$(_).attr("data-fldname"),
        id:$(_).attr("data-id"),op:$(_).attr("data-op"),label:$(_).attr("data-label"),isidentity:$(_).attr("data-isidentity")}

        if ((param.id == undefined) || (param.id == "-1") || (param.id == "0"))
            param.id = "" ;

        if (param.isidentity == undefined)
            param.isidentity = 0 ;
            
        var fields = "" ;
        var fieldtypes = "" ;
        $(".data-field",_).each(function(){
            if (fields != "")
            {
                fields += "," ;
                fieldtypes += "," ;
            }
            fields += $(this).attr("name") ;
            fieldtypes += ($(this).attr("data-type") == undefined)?"string":$(this).attr("data-type") ;
        })
        
        
        param.fields = fields ;
        param.fieldtypes = fieldtypes ;
        
       
        
        var keyfields = "" ;
        $(".data-keyfield",_).each(function(){
            if (keyfields != "")
                keyfields += "," ;
            keyfields += $(this).attr("name") ;
        })
        param.keyfields = keyfields ;
        
        param.flitersql = $(_).attr("data-flitersql") ;
        if (param.flitersql == undefined)
            param.flitersql = "" ;
            
        return param ;
    }
    
    _.getData = function(){
        //var data = $("form").serializeJson();
        //jQuery.extend(param, data); 
        var els = $("*[name]",this) ;
        var names = new Array()
        for(var i=0;i<els.length;i++)
            names[i] = $(els[i]).attr("name") ;
        names = $.unique(names);  // radio name repeat

        for(var i=0;i<names.length;i++)
        {
            var key = names[i] ;
            param[key] = getElementValue(key) ;
            
        }
		
        return param ;
    }
    
    _.getUrl = function(op)
    {
        var obj = $(_).attr("data-obj") ;
        if (obj == undefined)
            obj = "db" ;
        var query = $(_).attr("data-query") ;    
        if (query == undefined)
            query = "" ;
         
        return getAjaxUrl(obj,op,query) ;
    }
    _.init();
    return _ ;
}
    
})(jQuery);


function setElementValue(el,value)
{
	if(value == undefined)
		value = "";
	value = value.toString() ;
    var type = $(el).attr("type") ; 
	value = trim(value) ;
    switch(type)
    {
        case "checkbox":
               value = "," + value + "," ;
               $("input[name=" + $(el).attr("name") + "]").each(function(){
                   var curr_value = "," + $(this).val() + "," ;
                   if (value.indexOf(curr_value) > -1)
                   {
                        $(this).attr("checked",true) ;
                   }
              });

            break ;
        case "radio":
            $("input[name=" + $(el).attr("name") + "]").each(function(){
                if($(this).val() == value)
					$(this).attr("checked",true);
					
            }) 
            break ;
        default:
            $(el).val(value);
            break ;
    }
}
function getElementName(el)
{
    var name = $(el).attr("placeholder") ;
    
    if ((name == undefined) || (name == ""))
        name = $("label[for='" + $(el).attr("id") + "']").html() ;

    return name ;
}

function getElementValue(name)
{
    var els = $("*[name=" + name + "]") ;
    var type = $(els[0]).attr("type") ; 
    var val = "" ;
    switch(type)
    {
        case "checkbox":
            $(els).each(function(){
                if (this.checked)
                {
                    if (val != "")
                        val += "," ;
                    val += $(this).val();
                }
                else
                {
                    if ($(this).attr("value-unchecked"))
                        val += $(this).attr("value-unchecked");
                }
            })
            break ;
        case "radio":
            $(els).each(function(){
                if (this.checked)
                    val = $(this).val();
            })
            break ;
        default:
            val = $(els[0]).val();
            break ;
    }

    return val ;
}
 

(function($){
		$.fn.serializeJson=function(){
			var serializeObj={};
			$(this.serializeArray()).each(function(){
				serializeObj[this.name]=this.value;
			});
			
			return serializeObj;
		};
})(jQuery);

