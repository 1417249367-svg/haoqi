function init()
{
    $("input[name='Option1'][value='"+Option1+"']").attr("checked",true);
	//alert($("#datalist").find("b[title='Red Business']").attr("class"));
	//alert($("#skin_1").attr("class"));
	$("b[title='"+$("[name=Skins]").val()+"']").attr("class","current");
//	$("#user_" + userId).attr("class", "icon-member"); 
//	var a = $("#div2").find("a[id=b1]").size();
//	$("[title="+$("[name=Skins]").val()+"]").setAttribute("class", "current");

    if($("[name=logo]").val()==1) $("#img_logo").attr("src","/templets/xiazai/logo.ico");
	else $("#img_logo").attr("src","../assets/img/icon_logo.png");
    if($("[name=banner]").val()==1) $("#img_banner").attr("src","/templets/xiazai/ClientLogo.jpg");
	else $("#img_banner").attr("src","../assets/img/icon_banner.png");
    if($("[name=pan]").val()==1) $("#img_pan").attr("src","/templets/xiazai/logo.png");
	else $("#img_pan").attr("src","../assets/img/icon_pan.png");
}

function save()
{
	$("#pnl_success").hide();
	setLoadingBtn($("#btn_save"));
	var WebRun = $("[name=WebRun]").is(":checked")?1:0 ;
	var Server_CheckIM1 = $("[name=Server_CheckIM1]").is(":checked")?1:0 ;
	var Server_CheckIM2 = $("[name=Server_CheckIM2]").is(":checked")?1:0 ;
	var CheckIM0 = $("[name=CheckIM0]").is(":checked")?1:0 ;
	var CheckIM1 = $("[name=CheckIM1]").is(":checked")?1:0 ;
	var CheckIM2 = $("[name=CheckIM2]").is(":checked")?1:0 ;
	var CheckIM3 = $("[name=CheckIM3]").is(":checked")?1:0 ;
	var CheckIM4 = $("[name=CheckIM4]").is(":checked")?1:0 ;
	var CheckIM5 = $("[name=CheckIM5]").is(":checked")?1:0 ;
	var CheckIM6 = $("[name=CheckIM6]").is(":checked")?1:0 ;
	var CheckIM7 = $("[name=CheckIM7]").is(":checked")?1:0 ;
	var CheckIM8 = $("[name=CheckIM8]").is(":checked")?1:0 ;
	var CheckIM9 = $("[name=CheckIM9]").is(":checked")?1:0 ;
//	var CheckIM10 = $("[name=CheckIM10]").is(":checked")?1:0 ;
	var CheckIM11 = $("[name=CheckIM11]").is(":checked")?1:0 ;
	var CheckIM13 = $("[name=CheckIM13]").is(":checked")?"True":"False" ;
	var CheckIM14 = $("[name=CheckIM14]").is(":checked")?1:0 ;
//	var CheckTab0 = $("[name=CheckTab0]").is(":checked")?1:0 ;
//	var CheckTab1 = $("[name=CheckTab1]").is(":checked")?1:0 ;
//	var CheckTab2 = $("[name=CheckTab2]").is(":checked")?1:0 ;
//	var CheckTab3 = $("[name=CheckTab3]").is(":checked")?1:0 ;
//	var CheckTab4 = $("[name=CheckTab4]").is(":checked")?1:0 ;
	var CheckTab5 = $("[name=CheckTab5]").is(":checked")?1:0 ;
//	var CheckTab6 = $("[name=CheckTab6]").is(":checked")?1:0 ;
//	var CheckTab7 = $("[name=CheckTab7]").is(":checked")?1:0 ;
//	var CheckTab8 = $("[name=CheckTab8]").is(":checked")?1:0 ;
	var CheckTab9 = $("[name=CheckTab9]").is(":checked")?1:0 ;
	var CheckTab10 = $("[name=CheckTab10]").is(":checked")?1:0 ;
	var CheckTab11 = $("[name=CheckTab11]").is(":checked")?1:0 ;
	var CheckTab12 = $("[name=CheckTab12]").is(":checked")?1:0 ;
	var CheckTab13 = $("[name=CheckTab13]").is(":checked")?1:0 ;
	var CheckTab14 = $("[name=CheckTab14]").is(":checked")?1:0 ;
	
	var data = {
				"WebName":$("#WebName").val(),
				"WebUrl":$("#WebUrl").val(),
		        "WebRun":WebRun,
				"WebNa":$("#WebNa").val(),
				"ServerIp":$("#ServerIp").val(),
				"Server_CheckIM1":Server_CheckIM1,
				"Server_CheckIM2":Server_CheckIM2,
				"Option1":$("input[name='Option1']:checked").val(),
				"CheckIM0":CheckIM0,
				"CheckIM1":CheckIM1,
				"CheckIM2":CheckIM2,
				"CheckIM3":CheckIM3,
				"CheckIM4":CheckIM4,
				"CheckIM5":CheckIM5,
				"CheckIM6":CheckIM6,
				"CheckIM7":CheckIM7,
				"CheckIM8":CheckIM8,
				"CheckIM9":CheckIM9,
//				"CheckIM10":CheckIM10,
				"CheckIM11":CheckIM11,
				"CheckIM13":CheckIM13,
				"CheckIM14":CheckIM14,
//				"CheckTab0":CheckTab0,
//				"CheckTab1":CheckTab1,
//				"CheckTab2":CheckTab2,
//				"CheckTab3":CheckTab3,
//				"CheckTab4":CheckTab4,
				"CheckTab5":CheckTab5,
//				"CheckTab6":CheckTab6,
//				"CheckTab7":CheckTab7,
//				"CheckTab8":CheckTab8,
				"CheckTab9":CheckTab9,
				"CheckTab10":CheckTab10,
				"CheckTab11":CheckTab11,
				"CheckTab12":CheckTab12,
				"CheckTab13":CheckTab13,
				"CheckTab14":CheckTab14,
				"HotKey0":$("#HotKey0").val(),
				"HotKey1":$("#HotKey1").val()};
//				"Skins":$("#Skins").val()
	
	var url = getAjaxUrl("regedit","saveclient") ;
	//alert(url+JSON.stringify(data));
	$.ajax({
	   type: "POST",
	   dataType:"json",
	   data:data,
	   url: url,
	   success: function(result){
			if (result.status){
				$("#pnl_success").show();
				var speed=200;//滑动的速度
                $('body,html').animate({ scrollTop: 0 }, speed);
			}
			else
				myAlert(result.msg);
			setSubmitBtn($("#btn_save"));
	   }
	});
}

function skin_formatData(data){
	 for (var i = 0; i < data.length; i++) {
		data[i].curr_class = (data[i].skin_iscurrent == "1") ? "current" : "";
		data[i].btn_class = (data[i].skin_iscurrent == "1") ? "btn-danger" : "btn-info";
		data[i].btn_text = (data[i].skin_iscurrent == "1") ? "取消应用" : "应用"; 
		data[i].action_type = (data[i].skin_iscurrent == "1") ? "disuse_skin" : "use_skin"; 
	}
	return data;
}

function show_img(id){
	var i = $.layer({
	    type : 1,
	    title : false,
	    fix : false,
	    offset:['50px' , ''],
	    area : ['auto','auto'],
	    page : {dom : '#picture_' + id}
	});
}

function disuse_skin(_id){
	var skinId = getSelectedId(_id) ;
	   if (skinId == "")
			return ;
		showLoading("正在取消皮肤应用");
		var url = getAjaxUrl("skin","disuse_skin","skinid=" + skinId) ;

	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
			   hideLoading();
			   if (result.status)
				{
					dataList.reload();
				}
				else
				{
					myAlert(result.msg);
				}
		   }
	   });	
}

function clear_data(filetype){
		var file_name;
		switch (filetype) {
		case "logo":
		file_name="logo.ico";
		break;
		case "banner":
		file_name="ClientLogo.jpg";
		break;
		case "pan":
		file_name="logo.png";
		break;
		case "ad":
		file_name="ad.png";
		break;
		}
	   var url = getAjaxUrl("upload","delete","file_path=/templets/xiazai/&file_name=" + file_name) ;
	   //document.write(url);
	   $.ajax({
		   type: "POST",
		   dataType:"json",
		   url: url,
		   success: function(result){
			   if (result.status)
				{
					$("[name="+filetype+"]").val("0");
	                $("#img_"+filetype).attr("src","../assets/img/icon_"+filetype+".png");
					var uploadfile = $("#file_"+filetype) ;
					uploadfile.after(uploadfile.clone().val(""));      
					uploadfile.remove(); 
				}
				else
				{
					myAlert(result.msg);
				}
		   }
	   });	
}

function use_skin(skin_name){
	   if (skin_name == "")
			return ;
       $(".current").attr("class","");
	   $("b[title='"+skin_name+"']").attr("class","current");
	   $("[name=Skins]").val(skin_name);
}

function uploadFile(filetype)
{
	if(limitAttach("file_"+filetype))
	{
		var file_name;
		switch (filetype) {
		case "logo":
		file_name="logo.ico";
		break;
		case "banner":
		file_name="ClientLogo.jpg";
		break;
		case "pan":
		file_name="logo.png";
		break;
		case "ad":
		file_name="ad.png";
		break;
		}
		
		loading = layer.load(langs.text_uploading);
	    var url = getAjaxUrl("upload",filetype,"autoFileName=0&file_path=/templets/xiazai/&file_name=" + file_name) ;
		//document.write(url);
	    $("#form-client").attr("action",url).attr("target","frm_Upload").submit();
	}
}

function uploadComplete(file,filetype)
{
	//alert(JSON.stringify(file));
	if(file.status>0)
	{
//	    $("#filename").val(file.filename);
//	    $("#filefactpath").val(file.factpath);
//alert(replaceAll(file.filepath,"//","/"));
	    $("#img_"+filetype).attr("src",replaceAll(file.filepath,"//","/"));
		$("[name="+filetype+"]").val("1");
		var uploadfile = $("#file_"+filetype) ;
		uploadfile.after(uploadfile.clone().val(""));      
		uploadfile.remove(); 
//	    $("#col_photo").val("AntWeb://Faces/" + file.filesaveas);
//	    $("#filesaveas").val(file.filesaveas);
	}
	layer.close(loading);
}
