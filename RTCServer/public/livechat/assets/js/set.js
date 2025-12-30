//====================================================================================
// LIVECHT 个人设置脚本 chater_edit.html
// JC 2014-06-20
//====================================================================================

function uploadPicture()
{
    var fileName = $("#file_picture").val();
    if (fileName == "")
    {
    	myAlert("请选择上传的图片");
        return ;
    }
    if (!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(fileName)) {   
    	myAlert("请上传图片文件");   
        return ;   
    }   
    
    var url = getAjaxUrl("livechat_kf","UploadPicture","folder=face&loginName=" + loginName) ;
    $("#form")
        .attr("action",url)
        .attr("target","frm_Upload")
        .submit();
}

function uploadComplete(file)
{
    $("#img_picture").attr("src",file.filepath);
}

function saveStatus(status)
{
    var url = getAjaxUrl("livechat_kf","SaveStatus","loginName=" + loginName + "&status=" + status) ;
    $.getJSON(url, function(result){
        location.href = location.href ;
    }); 
}

function saveUserInfo()
{
    $("#btn_save").attr("disabled",true);
    var data = {loginName:loginName,
                    deptname:$("#deptname").val(),jobtitle:$("#jobtitle").val(),
                    phone:$("#phone").val(),mobile:$("#mobile").val(),
                    email:$("#email").val(),welcome:$("#welcome").val()} ;
    
    var url = getAjaxUrl("livechat_kf","SaveUserInfo","") ;
    $.ajax({
      url: url,
      data:data,
      type: "post",
      dataType: "json",
      success: function(msg){
    	  myAlert("修改成功");
         $("#btn_save").attr("disabled",false);
       }
    }); 
}
    
