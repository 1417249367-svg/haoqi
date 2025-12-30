    var loginName = "" ;
    var appPath = getAppPath();

    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            if (data[i].status == 0)
                data[i].statusname = langs.livechat_status_close ;
            else if (data[i].status == 1)
                data[i].statusname = langs.livechat_status_open ;
            if (data[i].picture == "")
                data[i].picture = defaultImg ;
            data[i].loginname_en = escape(data[i].loginname);
        }
        return data ;
    }

	function msgRoam(visiter_loginname,chater_loginname,chatId)
	{
		var url = "/livechat/msg_list.html?loginname=" + visiter_loginname + "&chater=" + chater_loginname + "&from=livechat" ;
		if (chatId != "")
			url += "&chatid=" + chatId ;
		window.open(url);
	}

    function viewContent(chatId,userId)
    {
        dialog("livechat",langs.livechat_history_view ,"chat_view.html?chatid=" + chatId + "&userid=" + userId ,{width:700,height:500})
    }

	function chater_edit(id)
	{
		if (id == undefined)
			dialog("chater",langs.livechat_chater_create,"chater_edit.html") ;
		else
			dialog("chater",langs.livechat_chater_edit,"chater_edit.html?id=" + id ) ;
	}

	var id = "" ;
	function chater_delete(_id)
	{
	   id = getSelectedId(_id) ;
	   if (id == "")
			return ;
		if (confirm(langs.text_delete_confirm))
			dataList.del(id) ;
	}

	function chater_saveCallBack()
	{
		dataList.reload();
		dialogClose("chater");
	}




    function chater_getCallBack(data)
    {
		if (data.picture == "")
            data.picture = defaultImg ;
		else data.picture = get_download_img_url(data.picture) ;
        $("#img_picture").attr("src", data.picture) ;
        loginName = data.loginname ;
		CKEDITOR.replace('welcome',{height:'130px'});
		CKEDITOR.instances.welcome.setData(PastImgEx1(data.welcome));
    }

    function chater_getCallBack1(data)
    {
		if (data.userautotranslate == 1)
			$("#userautotranslate").attr("checked",true);
		if (data.chaterautotranslate == 1)
			$("#chaterautotranslate").attr("checked",true);
    }

    function uploadComplete(file)
    {
		var filepath = get_download_img_url(file.filepath);
        $("#img_picture").attr("src",filepath);
        $("#picture").val(file.filepath);
    }

    function get_code()
    {
    	var html;
    	html =  '<div class="modal-body">';
    	html += '	<div class="container">';
    	html += '		<div class="alert alert-success" style="font-size:14px;margin:10px;" >' + langs.livechat_code_bulid_tip +  '</div>';
    	html += '		<div>';
    	html += '			<textarea name="col_code" id="col_code" placeholder="" class="form-control" rows="5" maxlength="100" disabled>';
    	html += '<script type="text/javascript" src="' + site_address + '/livechat/getjs/"></script>';
    	html += '			</textarea>';
    	html += '		</div>';
    	html += '	</div>';
    	html += '</div>';

    	html += '<div class="modal-footer">';
    	html += '	<button type="button" class="btn btn-default" data-dismiss="modal">' + langs.btn_close + '</button>';
    	html += '</div>';
    	dialogByContent("chater",langs.livechat_code_bulid,html);
    }
	
	function livechat_edit()
	{
		$(".modal").remove() ; //以免与USERPICKER冲突
		var title = langs.livechat_edit ;
		var url = "../lv_manager/livechat_edit.html" ;
		dialog("livechat",title ,url) ;
	}
	
	function group_getCallBack(data)
	{
		var html = '<script type="text/javascript" src="' + site_address + '/livechat/getjs/"></script>';
		$("#webcode").val(html);
		$("#mwebcode").val(html);
	}
	
	function group_saveCallBack()
	{
		//dataList.reload();
		dialogClose("livechat");
	}
	
	function group_saveCallBack()
	{
		//dataList.reload();
		dialogClose("livechat");
	}
	
    function chater_view(site)
    {
        window.open("demo.html?ipaddress="+$("#ipaddress").val()) ;
    }
	
	function copyUrl2() 
	{ 
		$("#webcode").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令 
		alert(langs.livechat_code_bulid_tip); 
	}
	
	function copyUrl3() 
	{ 
		$("#mwebcode").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令 
		alert(langs.livechat_code_bulid_tip); 
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//doc_share
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_share(loginname)
	{
		//var doc_item = $("#" + item_id);
		var texturl = site_address + "/kefu.html?username="+loginname ;
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_clipboardData); 
		$("#texturl").hide();
	}
	
	function doc_js(loginname)
	{
		//var doc_item = $("#" + item_id);
		var texturl = '<script>'
					+'var _rtckf = _rtckf || [];'
					+'(function() {'
						+'var kf = document.createElement("script");'
						+'kf.src = "' + site_address + '/livechat/getjs/?loginname=' + loginname + '";'
						+'var s = document.getElementsByTagName("script")[0];'
						+'s.parentNode.insertBefore(kf, s);'
					+'})();'
					+'<\/script>';
		
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_jsclipboardData); 
		$("#texturl").hide();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//二维码下载
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_qrcode(loginname,username,picture)
	{
		var url = site_address + "/kefu.html?username="+loginname+"&sourceurl=qrcode" ;
	
		if(!picture) picture="MyPic/default.png";
		//document.write("/public/qrcode.html?myid=public&size=3&logo=" + picture + "&encode=1&text=" + escape(url));
		var html =  "<div><img src='/public/qrcode.html?myid=public&size=6&logo=" + picture + "&encode=1&text=" + escape(url) + "'></div>" +
					"<div>" + username + "</div>" +
					"<div style='padding:5px;'><input type='button' class='btn btn_primary' value='"+langs.btn_close+"' data-dismiss='modal' aria-hidden='true' /></div>" ;
		showLoading(html,340,200);
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//doc_share
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_share1()
	{
		//var doc_item = $("#" + item_id);
		var texturl = site_address + "/kefu.html" ;
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_clipboardData); 
		$("#texturl").hide();
	}
	
	function doc_js1()
	{
		//var doc_item = $("#" + item_id);
		var texturl = '<script>'
					+'var _rtckf = _rtckf || [];'
					+'(function() {'
						+'var kf = document.createElement("script");'
						+'kf.src = "' + site_address + '/livechat/getjs/";'
						+'var s = document.getElementsByTagName("script")[0];'
						+'s.parentNode.insertBefore(kf, s);'
					+'})();'
					+'<\/script>';
		$("#texturl").show();
		$("#texturl").val(texturl);
		$("#texturl").select(); // 选择对象 
		document.execCommand("Copy"); // 执行浏览器复制命令
	//	window.clipboardData.setData("Text",url);
		myAlert(langs.doc_jsclipboardData); 
		$("#texturl").hide();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//二维码下载
	///////////////////////////////////////////////////////////////////////////////////////////
	function doc_qrcode1()
	{
		var url = site_address + "/kefu.html?sourceurl=qrcode" ;
	
		var picture="MyPic/default.png";
		//document.write("/public/qrcode.html?myid=public&size=3&logo=" + picture + "&encode=1&text=" + escape(url));
		var html =  "<div><img src='/public/qrcode.html?myid=public&size=6&logo=" + picture + "&encode=1&text=" + escape(url) + "'></div>" +
					"<div>" + langs.livechat_edit + "</div>" +
					"<div style='padding:5px;'><input type='button' class='btn btn_primary' value='"+langs.btn_close+"' data-dismiss='modal' aria-hidden='true' /></div>" ;
		showLoading(html,340,200);
	}

	
	function livechat_detail_init()
	{
		formatTabs("tabs");
		dataForm = $("#form-group").attr("data-id",groupId).dataForm({getcallback:group_getCallBack,savecallback:group_saveCallBack});
	}
	
	function saveForm()
	{
		if ($("#ipaddress").val() == "")
		{
			setElementError($("#ipaddress"),langs.livechat_serverip);
			return false ;
		}
		dataForm.save();
	}

    function formatData(data)
    {
        for (var i = 0; i < data.length; i++) {
            if (data[i].status == 0)
                data[i].statusname = langs.livechat_status_close ;
            else if (data[i].status == 1)
                data[i].statusname = langs.livechat_status_open ;
            if (data[i].picture == "")
                data[i].picture = defaultImg ;
            data[i].loginname_en = escape(data[i].loginname);
        }
        return data ;
    }
