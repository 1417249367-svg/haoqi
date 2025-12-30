<?php  require_once("../include/fun.php");?>
<?php
$sql = " select (count(*)+1) as c from ant_Interface " ;
$db = new DB();
$ord = $db -> executeDataValue($sql);
?>
           <form id="form" method="post"  class="form-horizontal" data-table="ant_Interface" data-isidentity="0" data-fldid="col_id" data-fldname="col_name"  enctype="multipart/form-data">
              <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label class="control-label" for="col_id">ID</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field data-keyfield digits"  id="col_id"  name="col_id"  maxlength="50" value="<?=$ord?>" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="col_name">名称</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field data-keyfield"  id="col_name"  name="col_name"  maxlength="50" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="col_url">地址</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="col_url"  name="col_url"  maxlength="500" /> </div>
                        </div>
                        <div class="form-group form-group-left">
                            <label class="control-label" for="col_ispublic">公开</label>
                            <div class="control-value">
                                <select id="col_ispublic" name="col_ispublic" class="form-control  data-field form-control2" style="width:150px">
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-right">
                            <label  for="col_disabled" class="control-label"><span>状态</span></label>
                            <div class="control-value">
                                <select id="col_disabled" name="col_disabled" class="form-control  data-field form-control2" style="width:150px">
                                    <option value="0">正常</option>
                                    <option value="1">禁用</option>
                                </select>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div class="form-group form-group-left">
                            <label class="control-label" for="col_desc">描述</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field"  id="col_desc"  name="col_desc" value=""  maxlength="50"/> </div>
                        </div>
                        <div class="form-group form-group-right">
                            <label class="control-label" for="col_name">排序</label>
                            <div class="control-value"><input type="text" placeholder="" class="form-control data-field int"  id="col_index"  name="col_index" value="<?=$ord?>" required maxlength="50" style="width:150px;"/> </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="col_type">类型</label>
                            <div class="control-value">
                            	<select name="col_type" id="col_type" class="form-control data-field ">
									<option value="0">全部</option>
									<option value="1">PC端应用</option>
									<option value="2">Android应用</option>
									<option value="3">iOS应用</option>
                            	</select>
                            </div>
                        </div>

						<div class="clear"></div>

                    </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" id="btn_save">保存</button>
				<input type="hidden" name="col_img" id="col_img"class="form-control data-field"   maxlength="255"  />
              </div>
            </form>
<script type="text/javascript">


var dataForm ;
var id = "<?=g("id")?>" ;
$(document).ready(function(){

   dataForm = $("#form").attr("data-id",id).dataForm({getcallback:getCallBack,savecallback:saveCallBack});
    $("#btn_save").click(function(){
        saveForm();
        return false ;
    })
	$("#img_picture").attr("src", defaultImg) ;
});

function saveForm()
{
    if ($("#col_name").val() == "")
    {
        setElementError($("#col_name"),"请输入名称");
        return false ;
    }
    if ($("#col_url").val() == "")
    {
        setElementError($("#col_url"),"请输入地址");
        return false ;
    }
    dataForm.save();
}

function getCallBack(data)
{
	if (data.col_img == "")
		data.col_img = defaultImg ;
	$("#img_picture").attr("src", data.col_img) ;
}

function saveCallBack()
{
    dataList.reload();
    dialogClose("interface");
}

function uploadComplete(file)
{
	file.filepath = appPath + file.filepath;
	$("#img_picture").attr("src",file.filepath);
	$("#col_img").val(file.filepath);
}

</script>