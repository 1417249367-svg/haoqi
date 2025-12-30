<?php  require_once("../include/fun.php");?>
<?php  
define("MENU","FILTER") ;
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("../include/meta.php");?>
	<script type="text/javascript" src="../assets/js/acepicker.js"></script>
	<style type="text/css">
	   #btn_save{
	       margin-top:20px;
	   }
	</style>
</head>
<body class="body-frame">
    <?php require_once("../include/header.php");?>
			        <div class="page-header"><h1><?=get_lang('menu_sub_filter')?></h1></div>
			        <div style="width:600px;">
                        <ul id="tabs" class="nav nav-tabs ">
                            <li  data-type="0" style="width:50%;text-align:center;"  class="active"><a  href="#" ><?=get_lang('keywords_type_one')?></a></li>
                            <li  data-type="1" style="width:50%;text-align:center;"  ><a  href="#"><?=get_lang('keywords_type_two')?></a></li>
                        </ul>           
			        </div>
                    <div class="keywords_tip">多个关键字以英文逗号分隔,&nbsp;&nbsp;如&nbsp;&nbsp;反动,游行</div>
				    
				    
				    <div id="keywords_list" class="keywords-list" data-fldsort="col_id desc" >
                        <textarea class="form-control" rows="15" style="width:750px;" maxlength="1024"></textarea>
                    </div>
                    <script type="text/x-jquery-tmpl" id="tmpl_list">
						<textarea class="form-control" rows="15" style="width:750px;" maxlength="1024" class="row-${col_id}">${col_keyword}</textarea>
				    </script>				  				   
                    <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
				<?php  require_once("../include/footer.php");?>
    

</body>
</html>

<script type="text/javascript">


    var keyword_type = 0 ;
    $(document).ready(function(){

    	keyword_list();    
        $("#tabs li").click(function(){	
        	$("#tabs li").removeClass("active");	
        	$(this).addClass("active");
        	keyword_type = $(this).attr("data-type");
        	keyword_list(keyword_type);
        	      
        })
    })
    

   function keyword_list(_type){
    	if(_type == undefined)
    		_type = 0;
    	var url = getAjaxUrl("keyword","list") ;
    	var param = {"col_type":_type};
            $.ajax({
               type: "POST",
               url: url,
               data: param,
               dataType:"json",
               success: function(data){      
                    var html = $("#tmpl_list").tmpl(data.rows) ;
                    if(!html.length)
                    	html = '<textarea class="form-control" rows="15" style="width:750px;" maxlength="1024" ></textarea>';
					var container_rows = $("#keywords_list ") ;    					
                    $(container_rows).html(html);
                    formatContainer(container_rows);  				    				
               },
    		   error:function(){
    			   myAlert("load error");
    		   }
            });
  } 

    $("#btn_save").click(function(){
    
    	var url = getAjaxUrl("keyword","save") ;
    	var content = $("#keywords_list textarea").val();
    	setLoadingBtn($("#btn_save"));         	
        $.ajax({
           type: 'POST',
           url: url ,
           data: {"col_type":keyword_type,"col_keyword":content} ,
           dataType:'json',
           success:function(data){
        	   if(data.status)
            	alert('保存成功,需重启RTC_Main_Service服务');
        	   setSubmitBtn($("#btn_save"));
            },

          });
        return false;
    })
    
</script>