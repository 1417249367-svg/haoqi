<?php  require_once("include/fun.php");?>
<?php  require_once(__ROOT__ . "/class/hs/Col.class.php");?>
<?php
$sortby = g("sortby","TypeID");  
$colro_myid = g ( "colro_myid" );
if($colro_myid) $myid='Public';
else $myid=CurUser::getUserId();
$col = new Col();
$data_col = array();
$result_ro = $col -> list_ro($parent_type,$parent_id,$root_type,$root_id,$sortby,$myid);
$data_ro = $result_ro["data"] ;
foreach($data_ro as $k=>$v){
	$html .='<option value="'.$data_ro[$k]['typeid'].'">'.$data_ro[$k]['typename'].'</option>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php  require_once("include/meta.php");?>
    <script src="/admin/assets/js/site.js?ver=20141023"></script>
    <script src="/static/js/msg_reader.js"></script>
    <script src="/static/js/ckeditor/ckeditor.js"></script>
</head>
<body>

           <form id="form" method="post" class="form-horizontal" data-obj="col" data-table="Col_Form" data-fldid="id" data-fldname="ncontent" enctype="multipart/form-data" >
              <div class="modal-body" style="padding-top:0px;">
                    <div class="form-group form-group-left">
                        <label class="control-label" for="upperid"><?=get_lang('col_upperid')?></label>
                        <div class="control-value">
                            <select name="upperid" id="upperid" class="form-control data-field form-control"  >
                                <?=$html?>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="form-group">
                        <label class="control-label" for="ncontent"><?=get_lang('col_ncontent')?></label>
                        <div class="control-value">
                            <textarea name="ncontent" id="ncontent" placeholder="<?=get_lang('col_ncontent_des')?>" class="form-control specialCharValidate data-field"  rows="3" > </textarea>
                       <!-- <div id="welcome"></div>-->
                        </div>
                    </div>

                    <div class="clear"></div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn_save"><?=get_lang('btn_save')?></button>
              </div>
            </form>
            <iframe id="frm_Upload" name="frm_Upload" style="display: none;"></iframe>
</body>
</html>

<script type="text/javascript">
var dataForm ;
var upperid = "<?=g("upperid") ?>";
var doc_id = "<?=g("col_id") ?>";
var appPath = "<?=getRootPath() ?>";
var defaultImg = appPath + "/livechat/assets/img/default.png" ;

$(document).ready(function(){
   if (upperid != "")
   {
		$("#upperid").val(upperid);
   }
   if (!doc_id) CKEDITOR.replace('ncontent');
   dataForm = $("#form").attr("data-id",doc_id).dataForm({getcallback:col_getCallBack,savecallback:col_saveCallBack1});
    $("#btn_save").click(function(){
        saveCol();
        return false ;
    })
})

function col_getCallBack(data)
{
	CKEDITOR.replace('ncontent');
	CKEDITOR.instances.ncontent.setData(PastImgEx1(unescape(data.ncontent)));
}
	
function col_saveCallBack1()
{
//	window.parent.postMessage({
//			  cmd: 'endcol_edit',
//			  params: ''
//			}, '*');
}

function saveCol()
{
	var title="";
	var listtype="";
	for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
	var welcome=$("#ncontent").val();
	welcome=replaceAll(welcome,"\n","");
	var Request = new Object(); 
	var newContent= welcome.replace(/<img [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{e@"+Request['name']+"|0|0|}";
		title=langs.pic;
		listtype="e@";
		return newStr;
	});
	newContent= newContent.replace(/<video [^>]*src=['"]([^'"]+)[^>]*>/gi,function(match,capture){
	//capture,返回每个匹配的字符串
		Request = GetURLRequest(capture);
		var newStr="{i@"+Request['name']+"|0|0|FileRecv/MessageVideoPlay.png}";
		title=langs.video;
		listtype="i@";
		return newStr;
	});
	 $("#ncontent").val(newContent);
	 if(!title) title=left($("#ncontent").val().replace(/<[^>]+>/g,""),13);
	var url = getAjaxUrl("col","createcol");
	var param = {"doc_id":doc_id,"colro_myid":"<?=$colro_myid ?>","doc_type":105,"parent_id":$("#upperid").val(),"title":title,"content":escape($("#ncontent").val()),"types":listtype,"iskefu":1} ;
	//document.write(url+JSON.stringify(param));
	$.getJSON(url,param , function(result){
		if (result.status)
		{
			window.parent.postMessage({
					  cmd: 'endcol_edit',
					  params: ''
					}, '*');
		}
		else
		{
			myAlert(result.msg);
		}

	});
}
</script>