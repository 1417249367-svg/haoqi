// textboxlist
// bootstrap.autocomplete.js

(function($) {
 
$.fn.textboxlist = function(_options)
{
 
    var _ = this ;
    
    //{url:,maxcount:-1}
    var default_options = {url:"",maxcount:-1} ;
    var options ;
    var container_data ;
    
    
    _.init = function(){

        options = jQuery.extend(options, default_options,_options); 
        options.url = $(_).attr("url") ;

        if ($(_).attr("maxcount") != undefined)
            options.maxcount = parseInt($(_).attr("maxcount")) ;

        
        //init html
        $(_).wrap("<div class='textboxlist'><ul class='textboxlist-data'></ul></div>"); 
        $(_).addClass("textboxlist_ipt");
        container_data = $(".textboxlist-data",$(_).parent().parent());
       
       if ($(_).attr("height") != undefined)
            $(container_data).parent().height($(_).attr("height"));
        
        //init action
        $(_).unbind("keydown") ;
        
        $(_).keydown(function(event){
            if (event.keyCode == 13)
            {          
                var id = $(this).attr("real-value") ;
                if ((id == undefined)||(id == ""))
                    return ;
               _.addValue(id,$(this).val());
               
               $(this).val("").attr("real-value","") ;
            }
        })
        
        $(_).autocomplete({
            source:function(query,process){
	            var matchCount = this.options.items;
	            $.getJSON(options.url,{"key":query,"top":matchCount},function(respData){
		            return process(respData.rows);
	            });
                
            },
            formatItem:function(item){
	            return item["name"];
            },
            setValue:function(item){
                //_.addValue(item["id"],item["name"]);
	            return {'data-value':item["name"],'real-value':item["id"]};
            }
        });	
        
    }
    
    //return ids
    _.getValue = function()
    {
        var values = "" ;
        $("li",container_data).each(function(){
            var v = $(this).attr("data-id") ;
            if (v != undefined)
                values += (values == ""?"":",") + v ;
        })
        return values ;
    }
    
    //return texts
    _.getText = function()
    {
        var values = "" ;
        $("li",container_data).each(function(){
            var v = $(this).attr("data-name") ;
            if (v != undefined)
                values += (values == ""?"":",") + v ;
        })
        return values ;
    }
    
    _.setValue = function(ids,texts)
    {
        var arr_Id = ids.split(",");
        var arr_Text = texts.split(",");
        
       
        for(var i=0;i<arr_Id.length;i++)
            _.addValue(arr_Id[i],arr_Text[i]) ; 
            
    }
    
    _.addValue = function(id,text)
    {
        //判断是否存在
        var el = $("li[data-id=" + id + "]",container_data) ;
        if ($(el).html() != undefined)
        {
            alert("已经添加此项") ;
            return ;
        }
        
        if (options.maxcount == 1)
        {
            //每次输入为替换
            $("li[data-id]",container_data).remove();
        }
        if (options.maxcount>0)
        {
            var count = $("li[data-id]",container_data).length ;
            if (count >= options.maxcount)
            {
                alert("添加的数量不能超过" + options.maxcount + "个") ;
                return ;
            }
        }
        
        $(_).before('<li data-id="' + id + '" data-name="' +text + '"><span>' + text + '</span><i onclick="$(this).parent().remove()"></i></li>');  
        
    }
 
    _.init() ;
    
    return _ ;  
      
}
    
})(jQuery);

