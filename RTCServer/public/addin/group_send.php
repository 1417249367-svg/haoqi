<?php  
//http://127.0.0.1:8000/addin/board_list.html?loginname=ZS@aa&password=e10adc3949ba59abbe56e057f20f883e
require_once("include/fun.php");
$db = new DB();
	
$sql = "select * from lv_user_ro where Status=1 order by Ord ,TypeID";
$data_ro = $db -> executeDataTable($sql) ;
foreach($data_ro as $k=>$v){
	$html .='<label class="checkbox-inline" ><input class="data-field" type="checkbox" name="col_label" value="'.$data_ro[$k]['typeid'].'" />'.$data_ro[$k]['typename'].'</label>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
	<link type="text/css" rel="stylesheet" href="assets/css/board.css" />
	<script type="text/javascript" src="/static/js/msg_reader.js"></script>
<style>
.data-list .doc_icon{float:left;width:32px;height:32px;padding:0px; position:relative;}
.data-list .doc_icon img{width:32px;height:32px; position:absolute;left:0px;top:3px;}
.new-span {
	color:#F00;
}
.nonew-span {
	display:none;
}
</style>
</head>
<body>
 <form id="form-group" method="post"  class="form-horizontal"   data-obj="board"  data-table="Board" data-fldid="id" data-fldname="col_Subject" enctype="multipart/form-data">
    <div class="modal-body" style="padding-top:0px !important;">
<!--                    <ul id="tabs" class="nav nav-tabs">
              <li><a href="#base" data-toggle="tab">属性</a></li>
              <li id="tab_member"><a href="#member" data-toggle="tab" id="tab_menu_member">成员</a></li>
          </ul>-->
          <div class="tab-content" style="display:block;" id="base">
              <div class="form-group"> 
                  <label class="control-label" for="col_content"><?=get_lang('board_content')?></label> 
                  <div class="control-value">
                      <textarea rows="10" style="height:100px"  placeholder="" class="form-control data-field  specialCharValidate"  id="col_content" name="col_content" maxlength="1400" required></textarea>
                  </div>
              </div>
              <div class="form-group"> 
                  <label class="control-label" for="filename"><?=get_lang('board_datapath')?></label> 
                  <div class="control-value">
                      <input type="text" id="filename" name="filename"  class="form-control" disabled="disabled"/>
                      <a href="javascript:void(0);" onclick="$('#container_link').toggle()"><?=get_lang('board_attach')?></a>
                      <div id="container_link" style="display:none;">
                          <input type="file" id="file" name="file"  class="form-control pull-left mr" style="width:350px;" />
                          <button type="button" class="btn btn-default pull-left" id="btn_upload" onclick="uploadFile()" ><?=get_lang('board_upload')?></button>
                      </div>
                  </div>
              </div>
              
              <div class="form-group" id="base2">
                  <label class="control-label" for="col_ispublic"><?=get_lang('board_type')?></label>
                  <div class="control-value">
                      <label class="checkbox-inline"><input class="data-field" type="radio" name="col_ispublic" value="1" value-unchecked="0" /> <?=get_lang('board_all')?></label><label class="checkbox-inline"><input type="radio" name="col_ispublic" value="0" value-unchecked="0" /> <?=get_lang('board_designation')?></label>
                  </div>
              </div>    

                           
          <div class="tab-content" style="margin-top:10px;" id="member">
              <div class="form-group">
                  <label class="control-label" for="col_label"><?=get_lang('board_label')?></label>
                  <div class="control-value">
                       <?=$html?>
                  </div>
              </div>    
              <div class="clearfix">
                  <div class="bor group-column" style="overflow:scroll;">
                  <table id="datalist" class="table table-striped table-hover data-list" data-tmpid="tmpl_list" data-fldid="UserId" data-fldsort="" data-where=""  data-fldlist="" data-ispage="1" data-obj="livechat_kf">
                    <thead>
                      <tr>
                        <td style="width:40px"><input type="checkbox"  name="chk_All" onclick="checkAll('chk_Id',this.checked)"></td>
                        <td data-sortfield="username" style="width:150px"><?=get_lang('group_username')?></td>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
				  <script type="text/x-jquery-tmpl" id="tmpl_list">
                      <tr class="row-${userid}" id="user_${userid}" loginname="${username}">
                          <td><input type="checkbox" name="chk_Id" value="${userid}"></td>
                          <td>
						  	<span class="doc_icon">
								<img src="${img}"/>
							</span><span>${username}</span>&nbsp;&nbsp;<span class="${css}">新</span></td>
                      </tr>
                  </script>
                  </div>
                  <div style="clear:both;"></div>
              </div>
          </div>
          
          
              </div>

          
           
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn_save"><?=get_lang('btn_send')?></button>
<!--                <input type="hidden" id="tagIds" name="tagIds" />-->
      <input type="hidden" id="memberIds" name="memberIds" />
<!--				<input type="hidden" id="col_type" name="col_type" class="data-field" value="8"/>
      <input type="hidden" id="col_dtype" name="col_dtype" class="data-field" value="1"/>
      <input type="hidden" id="col_ispublic" name="col_ispublic" class="data-field" value="0"/>-->
      <input type="hidden" id="board_attach" name="board_attach"/>
      <input type="hidden" id="col_id" name="col_id" class="data-field" value="<?=create_guid1() ?>"/>
      <input type="hidden" id="col_creator_id" name="col_creator_id" class="data-field" value="<?=CurUser::getUserId() ?>" />
      <input type="hidden" id="col_creator_name" name="col_creator_name" class="data-field" value="<?=CurUser::getUserName() ?>" />
      <input type="hidden" id="col_creator" name="col_creator" class="data-field" value="<?=CurUser::getLoginName() ?>" />
<!--				<input type="hidden" id="filefactpath" name="filefactpath" />
      <input type="hidden" id="filesaveas" name="filesaveas" />
      <input type="hidden" id="col_photo" name="col_photo" class="data-field" />
      <input type="hidden" id="ispublic" name="ispublic" class="data-field" />-->
    </div>
  </form>
  
<?php  require_once("include/footer.php");?>
</body>
</html>

<script type="text/javascript">
var dataList ;
$(document).ready(function(){
	$("#btn_save").click(function(){
		msg_send();
	})
	$("input[name='col_ispublic']").click(function(){
        doc_html_init("col_ispublic",$(this).val());
    })
	$("input[name='col_label']").click(function(){
		doc_detail_init();
	})
	doc_detail_init();
})

//控制backspace
$(document).keydown( function(e)
		{
	//获取键盘的按键CODE
	var k=e.keyCode;
	if(k == 8){
		//获取操作的标签对象
		var act = document.activeElement.tagName.toLowerCase();
		//如果按键为“backspace”并且标签对象为body或html时，返回false
		if(act.indexOf("body") != -1 || act.indexOf("html") != -1 || act == 'a')
		{
		   return false;
		}
		return true;
	}
	return true;
});

function doc_html_init(flag,val)
{
	switch (flag) {
		case "col_ispublic":
			switch (parseInt(val)) {
				case 0:
					//$("#tab_member").show();
					$("#member").show();
					break;
				case 1:
					//$("#tab_member").hide();
					$("#member").hide();
					break;
			} 
			break;
	} 
}

function doc_detail_init()
{
	var col_label = [];
	$("input[name='col_label']:checked").each(function() {
		col_label.push($(this).val());
	});
	$(".group-column").height(320);
	$("input[name='col_ispublic'][value='1']").attr("checked",true);
	dataList = $("#datalist").attr("data-query", "label=listvisitor&TypeID="+col_label.join(",")).dataList(user_formatData,listCallBack);
}

function user_formatData(data)
{
	for (var i = 0; i < data.length; i++) {
		var res3 = '/static/img/mine_pc.png';
		switch (parseInt(data[i].usericoline)) {
		case 0:
			var res3 = '/static/img/mine_pc.png';
		break;
		case 1:
			var res3 = '/static/img/mine_pc_blue.png';
		break;
		case 2:
			var res3 = '/static/img/mine_mobile.png';
		break;
		case 3:
			var res3 = '/static/img/mine_mobile_blue.png';
		break;
		}
		if(data[i].headimgurl) var res3 = data[i].headimgurl;
		data[i].img = res3;
		if(parseInt(data[i].visitcount)==1) var res4='new-span';
		else var res4='nonew-span';
		data[i].css = res4;
	}
	return data ;
}

function listCallBack()
{
}

function uploadFile()
{
	var fileName = $("#file").val();
	var url = getAjaxUrl("upload","bioace") ;
	$("#form-group").attr("action",url).attr("target","frm_Upload").submit();
}


function uploadComplete(data)
{
	//document.write(JSON.stringify(file));
	switch (get_filetype(data.filepath)) {
	case "mp3":
	var msg = escape("{d@" + data.filepath + "|"+data.filesize+"|0|}") ;
	break;
	case "img":
	var msg = escape("{e@" + data.filepath + "|"+data.filesize+"|0|}") ;
	break;
	case "mpeg":
	var msg = escape("{i@" + data.filepath + "|"+data.filesize+"|0|FileRecv/MessageVideoPlay.png}") ;
	break;
	default:
	var msg = escape("{a@" + data.filepath + "}") ;
	break;
	}
	
	$("#filename").val($("#filename").val()+data.filename+",");
	$("#board_attach").val($("#board_attach").val()+","+msg);
	$("#container_link").fadeOut();
}

function msg_send()
{
   var id = getCheckValue("chk_Id") ;
//   if (id == "")
//		return ;
			
	var param = {youid:id,myid:_curr_loginname,col_ispublic:$("input[name='col_ispublic']:checked").val(),ispush:1,usertext:escape($("#col_content").val())+$("#board_attach").val(),to_type:1,point:0};
    var url = getAjaxUrl("msg_kf","SendKefuMessage1") ; 
	//document.write(url+JSON.stringify(param));
    $.getJSON(url,param , function(result){
		if (result.status)
		{
			window.parent.postMessage({
					  cmd: 'endgroupsend',
					  params: ''
					}, '*');
		}
    }); 
}
	
function saveAttach(fileName,fileSize,filePath,flag)
{
	var createUser = flag == 1?my.username:chater.username
    var param = {chatId:chatId,chater:chater.loginname,username:my.username,fileName:fileName,fileSize:fileSize,filePath:filePath,flag:flag,createUser:createUser};
    var url = getAjaxUrl("livechat_kf","SaveAttach") ;
    $.post(url,param , function(result){
    }); 
}
</script>