var EMP_USER = 1 ;
var EMP_DEPT = 2 ;
var EMP_ROLE = 2 ;
var EMP_VIEW = 4 ;
var EMP_GROUP = 4 ;


$(document).ready(function(){
	formatContainer();

	initSideBar();
})

function initSideBar()
{
    var container = $("#sidebar") ;
	var submenu = $("li.active",container).parent() ;

	$(submenu).show();
	$(submenu).siblings().addClass("active");


	$("a.dropdown-toggle",container).click(function(){

		var currMenu = $(this).siblings() ;
		$(".submenu",container).not(currMenu).hide();
		$(currMenu).toggle();

		$("a.dropdown-toggle",container).removeClass("active");

		if($(currMenu).is(":hidden"))
		    $(currMenu).siblings().removeClass("active");
		else
		    $(currMenu).siblings().addClass("active");


	})
}



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



///////////////////////////////////////////////////////////////////////////////////////////
//Member
///////////////////////////////////////////////////////////////////////////////////////////
function user_search_init(ipt)
{
    $(ipt).autocomplete({
        source:function(query,process){
	        var matchCount = this.options.items;
	        var url = getAjaxUrl("user","search") ;
			//document.write(url+"key"+query+"top"+matchCount);
	        $.getJSON(url,{"key":query,"top":matchCount},function(respData){
		        return process(respData.rows);
	        });

        },
        formatItem:function(item){
	        return item["name"] + " (" + item["loginname"] + ")" ;
        },
        setValue:function(item){
	        return {'data-value':item["name"],'real-value':item["id"]};
        }
    });
}

function setlang(lang)
{
	var url = getAjaxUrl("system","set_language") ;
    $.ajax({
        type:"POST",
        dataType:"json",
		data:{"lang":lang} ,
        url: url,
        success:function(result){
			window.location.reload();
        }
    });
}

function about()
{
    dialog("about",langs.text_about,"/admin/help/about.html");
}

function register()
{
    dialog("register",langs.text_register,"/admin/help/register.html");
}

function OnlineData()
{
   var CmdStr="CmdStr=";
   if(getCookie("BA-Users_RoVesr")) CmdStr+="Users_Ro-";
   if(getCookie("BA-Users_IDVesr")) CmdStr+="Users_ID-";
   if(getCookie("BA-Clot_RoVesr")) CmdStr+="Clot_Ro-";
   if(getCookie("BA-Clot_FormVesr")) CmdStr+="Clot_Form-";
   var url = getApiUrl("OnlineData",CmdStr) ;
      //document.write(url);
	delCookie("BA-Users_RoVesr");
	delCookie("BA-Users_IDVesr");
	delCookie("BA-Clot_RoVesr");
	delCookie("BA-Clot_FormVesr");
   $.ajax({
	   type: "POST",
	   dataType:"jsonp",
	   url: url,
	   success: function(result){
			if (result.msg=="yes"){
				//myAlert("数据在线同步成功");

			}else
				myAlert(getErrorText(result.errnum));
	   }
   });
}

//function delCookie2(cookiename){
//	alert(cookiename);
//	setCookies(cookiename,"",-1);
//}

function bulid_app_value(btn)
{
	setLoadingBtn(btn,"正在生成配置数据...") ;
	var url = getAjaxUrl("system","bulid_app_value") ;
    $.ajax({
        type:"POST",
        dataType:"json",
        url: url,
        success:function(result){
            cancelLoadingBtn(btn);
			myAlert("配置数据完成");
        }
    });
}

function left(mainStr,lngLen) { 
if (lngLen>0) {return mainStr.substring(0,lngLen)} 
else{return null} 
}
function right(mainStr,lngLen) { 
if (mainStr.length-lngLen>=0 && mainStr.length>=0 && mainStr.length-lngLen<=mainStr.length) { 
return mainStr.substring(mainStr.length-lngLen,mainStr.length)} 
else{return null} 
} 
function mid(mainStr,starnum,endnum){ 
if (mainStr.length>=0){ 
return mainStr.substr(starnum,endnum) 
}else{return null} 
} 

function is_oos(filename)
{
	var pos = filename.toString().lastIndexOf(".") ;
	var extend_name = filename.substring(pos).toLowerCase();
	if (".ods.xls.xlsb.xlsm.xlsx.doc.docm.docx.dot.dotm.dotx.odt.pot.potm.potx.pps.ppsm.ppsx.ppt.pptm.pptx.odp".indexOf(extend_name)>-1)
		return true ;

	return false;
}