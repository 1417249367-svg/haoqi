//====================================================================================
// LIVECHT 文件柜或链接管理
// JC 2014-06-20
//====================================================================================


function listLink(chater)
{
    var url = getAjaxUrl("livechat_kf","ListLink") ;
	//document.write(url+"&chater="+chater);
    var containter_file ;
    if (chater == "")
        containter_file = $("#container_public");
    else
        containter_file = $("#container_tmp") ;
    $.getJSON(url,{chater:chater}, function(result){
        var html = "" ;
        var data = result.rows ;
        for(var i=0;i<data.length;i++)
        {
            var item = data[i] ;
            html += '<li><a href="' + item.linkurl + '" target="_blank">' + item.linkname + '</a></li>' ;
        }
        
        if (result.length == 0)
            html = "没有内容" ;
            
        $(containter_file).html(html) ;
    }); 
}

function listFile(chatId,flag)
{
    if (chatId == undefined)
        chatId = "" ;
    if (flag == undefined)
        flag = 0 ;
        
    var url = getAjaxUrl("livechat_kf","ListFile","chatId="  + chatId + "&flag=" + flag) ;
	//document.write(url);

    var containter_file ;
    if (chatId == "")
        containter_file = $("#container_public");
    else
        containter_file = $("#container_tmp") ;
    
    $(containter_file).html("正在加载中...") ;

    $.getJSON(url,function(result){

        var html = "" ;
        var data = result.rows ;
        
        for(var i=0;i<data.length;i++)
        {
            var item = data[i] ;
            html += '<li><a href="' + item.filepath + '" target="_blank">' + item.filename + '</a><small class="text-muted">(' + getFileSizeExp(item.filesize) + ')</small></li>' ;
        }
        
        if (data.length == 0)
            html = "<li class='no-style'>没有内容</li>" ;

        $(containter_file).html(html) ;
            
    }); 
    
}

function uploadFile()
{ 
    if ($("#file1").val() == "")
    {
    	myAlert("请选择上传的文件");
        return ;
    }
    
    chatId = $("#drp_ChatId").val();
 
    var url = getAjaxUrl("livechat_kf","UploadAttach","chatId=" + chatId + "&flag=" + flag) ;

    $("#frmUpload").attr("action",url).submit();
}

function uploadComplete(result)
{
    
    listFile(chatId);
    
    $("#file1").val("");
}





function getFileSizeExp(filesize)
{
    
    filesize = parseInt(filesize) ;
    if (filesize < 1024*1024)
        return round1(filesize / 1024) + "K" ;
    if (filesize < 1024*1024*1024)
        return round1(filesize / (1024*1024)) + "M";
    return round1(filesize / (1024*1024*1024)) + "G";
}

function round1(num)
{
    return Math.round(num*100)/100 ;
}


