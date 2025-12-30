/*
 2014-11-20
$("$lbl_companyname").editBox()
*/

(function($) {
 

$.fn.editBox = function(opts)
{
    var _ = this ;
 	var value = "" ;
	var container ;
	var container_view ;
	var container_edit ;
    opts = jQuery.extend({
        url:"",
		query:"name={name}&value={value}",
		triobj:null  //触发编辑的对象
	},opts);

    _.init = function(){
		
		if (opts.triobj)
			$(opts.triobj).click(function(){_.edit();})
		
		_.value = $(this).html();
	    _.container = $(this).parent() ;
	    _.container_view = $(_.container).children();


    }
    
     _.edit = function(){
		 
		_.container_edit = $('<input type="text" class="txt_value form-control pull-left mr" style="height:23px; line-height:23px;padding:0px 5px;width:300px;" value="' + _.value + '"/>' +  
						 '<input type="button" class="btn btn-xs btn-primary pull-left mr btn_save" value="保存" /> ' +  
						 '<input type="button" class="btn btn-xs pull-left btn_cancel" value="取消" />') ;
		
		$(_.container_view).hide();
		$(_.container).append(_.container_edit); 
		$(".btn_save",_.container).click(function(){
			_.save();
		})
		
		$(".btn_cancel",_.container).click(function(){
			_.cancel();
		})

		$(".txt_value",_.container).focus();
    }   
     _.cancel = function(){
		$(_.container_edit,_.container).remove();
		$(_.container_view).show();
		
    }   
    
    _.save = function(){
		
		var btn_save = $(".btn_save",_.container) ;
		var txt_value = $(".txt_value",_.container) ;

		var value = $(txt_value).val() ;
		var name = $(_).attr("name");

		var url = opts.url ;
		var data = opts.query ;
		data = data.replace("{name}",name).replace("{value}",value);
		setLoadingBtn(btn_save);
		$.ajax({
		   type: "POST",
		   dataType:"json",
		   data:data,
		   url: url,
		   success: function(result){
				if (result.status)
				{
					//success
					_.cancel();
					$(_).html(value);
				}
				else
				{
					myAlert(result.msg);
					
				}
				setSubmitBtn(btn_save);
		   }
		}); 
    }

    


      
    _.init();
    return _ ;
}
    
})(jQuery);


